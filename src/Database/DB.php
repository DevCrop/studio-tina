<?php

namespace Database;

class DB
{
    /** 내부에서 쓸 PDO */
    private static function pdo(): \PDO {
        // 기존 전역 \DB 래퍼 그대로 사용
        return \DB::getInstance();
    }


    // 리스트/상세 슬러그 규칙 통일
    public static function makeSlug(string $title): string {
        $s = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (class_exists('\Normalizer')) $s = \Normalizer::normalize($s, \Normalizer::FORM_KC);
        $s = preg_replace('/[\"\'\x{2018}\x{2019}\x{201C}\x{201D}`´]/u', '', $s);
        $s = preg_replace('/[\x{00A0}\s]+/u', ' ', $s);
        $s = preg_replace('/[^가-힣a-zA-Z0-9\.\- ]/u', '', $s);
        $s = preg_replace('/\s+/u', '-', trim($s));
        $s = preg_replace('/-+/', '-', $s);
        $s = trim($s, '-');
        return mb_strtolower($s, 'UTF-8');
    }

    // 상세에서 슬러그로 게시물 찾기 (ID 우선, 규칙 일치 비교)
    public static function findPostBySlug(int $boardNo, string $slug): ?int {
        $pdo = self::pdo();

        // URL 디코드 → 우리 규칙으로 다시 슬러그화 (리스트에서 만든 것과 100% 동일 규칙)
        $needle = self::makeSlug(rawurldecode($slug));

        $stmt = $pdo->prepare("SELECT no, title FROM nb_board WHERE board_no = :board_no");
        $stmt->execute([':board_no' => $boardNo]);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $hay = self::makeSlug((string)$row['title']);
            if ($hay === $needle) {
                return (int)$row['no'];
            }
        }
        return null;
    }

    /** (선택) 라우트 링크 생성 헬퍼 */
    public static function buildPostRoute(string $routeName, string $title): string {
        $slug = self::makeSlug($title);
        return route($routeName, ['title' => $slug]);
    }


    /**
     * 공통: 게시판 목록 조회 유틸 (클로저 내부에서만 사용)
     * - $opts: [
     *     'board_no'   => int (필수),
     *     'category_no'=> int|null,
     *     'page'       => int (기본 1),
     *     'perpage'    => int|null  // 없으면 게시판 설정 list_size 또는 10
     *     'search'     => [
     *        'keyword' => string,
     *        'column'  => string,   // 현재는 제목/내용 통합 LIKE, 필요시 확장
     *        'sdate'   => 'YYYY-MM-DD',
     *        'edate'   => 'YYYY-MM-DD'
     *     ]
     *   ]
     * return: compact(...) 배열
     */
    public static function fetchBoardList(array $opts) {
        global $NO_SITE_UNIQUE_KEY;

        $connect = \DB::getInstance();

        $board_no    = (int)($opts['board_no'] ?? 0);
        $category_no = $opts['category_no'] ?? null;
        $page        = max(1, (int)($opts['page'] ?? 1));
        $search      = $opts['search'] ?? [];

        $searchKeyword = trim((string)($search['keyword'] ?? ''));
        $searchColumn  = trim((string)($search['column']  ?? ''));
        $sdate         = trim((string)($search['sdate']   ?? ''));
        $edate         = trim((string)($search['edate']   ?? ''));

        // 게시판 설정/권한
        $board_info      = getBoardInfoByNo($board_no) ?? [];
        $role_info       = getBoardRole($board_no, $GLOBALS['NO_USR_LEV'] ?? null) ?? [];
        $boardManageInfo = getBoardManageInfoByNo($board_no) ?? [];
        $boardCategory   = getBoardCategory($board_no) ?? [];

        if (($board_info[0]['isOpen'] ?? 'Y') === 'N') {
            if (!$role_info || ($role_info[0]['role_list'] ?? 'N') === 'N') {
                error("열람 권한이 없습니다.", "/pages/member/login.php");
                exit;
            }
        }

        $perpage = (int)($opts['perpage'] ?? ($board_info[0]['list_size'] ?? 10));
        $listRowCnt  = $perpage;
        $listCurPage = $page;
        $offset      = ($listCurPage - 1) * $listRowCnt;

        // WHERE
        $where  = [];
        $params = [];

        $where[]            = "a.sitekey = :sitekey";
        $params[':sitekey'] = $NO_SITE_UNIQUE_KEY;

        $where[]             = "a.board_no = :board_no";
        $params[':board_no'] = $board_no;

        if (!empty($category_no)) {
            $where[]                 = "a.category_no = :category_no";
            $params[':category_no']  = $category_no;
        }
        if ($searchKeyword !== '') {
            // 제목/내용 공백 제거 후 LIKE
            $where[] = "(REPLACE(a.title,' ','') LIKE :kw OR REPLACE(a.contents,' ','') LIKE :kw)";
            $params[':kw'] = '%' . $searchKeyword . '%';
        }
        if ($sdate !== '' && $edate !== '') {
            $where[] = "(DATE_FORMAT(a.regdate, '%Y-%m-%d') BETWEEN :sdate AND :edate)";
            $params[':sdate'] = $sdate;
            $params[':edate'] = $edate;
        }

        $mainWhere = ' WHERE ' . implode(' AND ', $where);

        // 총 개수
        $sqlCnt = "SELECT COUNT(*) AS cnt FROM nb_board a {$mainWhere}";
        $stmt   = $connect->prepare($sqlCnt);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->execute();
        $totalCnt = (int)$stmt->fetchColumn();
        $Page     = (int)ceil($totalCnt / $listRowCnt);

        // 목록
        $sql = "
            SELECT a.*, b.title AS board_name, c.name AS category_name
            FROM nb_board a
            LEFT JOIN nb_board_manage  b ON a.board_no   = b.no
            LEFT JOIN nb_board_category c ON a.category_no = c.no
            {$mainWhere}
            ORDER BY a.is_notice='Y' DESC, a.regdate DESC
            LIMIT {$offset}, {$listRowCnt}
        ";
        $stmt = $connect->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->execute();
        $arrResultSet = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $rnumber     = $totalCnt - $offset;
        $board_title = $board_info[0]['title'] ?? '';
        $skin        = $board_info[0]['skin']  ?? 'default';

        return compact(
            'arrResultSet','totalCnt','Page','listCurPage','listRowCnt','rnumber',
            'board_no','category_no','searchKeyword','searchColumn','sdate','edate','board_title','skin'
        );
    }
}