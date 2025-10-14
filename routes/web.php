<?php

use Database\DB;
use Http\Request;
use Http\Response;

/**
 * @var \Routing\Router $router
 */
$router = app()->router();

// 홈/기본
$router->get('/', function() {
    $db = \DB::getInstance();
    
    // 메인 배너 조회
    $stmt = $db->prepare("
        SELECT banner_image, link_url, description, banner_type, is_active
        FROM nb_banners 
        WHERE is_active = 1 
        ORDER BY sort_no ASC
    ");
    $stmt->execute();
    $banners = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
    // 메인 뉴스 조회 (최신 5개)
    $newsStmt = $db->prepare("
        SELECT no, title, contents, regdate, thumb_image
        FROM nb_board
        WHERE board_no = 25
        ORDER BY no DESC
        LIMIT 5
    ");
    $newsStmt->execute();
    $newsList = $newsStmt->fetchAll(\PDO::FETCH_ASSOC);
    
    // 뉴스 이미지 URL 처리
    foreach ($newsList as &$news) {
        $imageUrl = '';
        if (!empty($news['thumb_image'])) {
            $imageUrl = '/uploads/board/' . $news['thumb_image'];
        }
        $news['image_url'] = $imageUrl;
        
        // contents 전처리
        if (!empty($news['contents'])) {
            $contents = html_entity_decode($news['contents'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $contents = strip_tags($contents);
            $news['contents'] = trim($contents);
        }
    }
    unset($news);
    
    return render('pages.index', [
        'banners' => $banners,
        'newsList' => $newsList
    ]);
});

$router->group(['prefix' => '/'], function ($r)  {

    // 기본 페이지
    $r->get('/', function() {
        $db = \DB::getInstance();
        
        // 메인 배너 조회
        $stmt = $db->prepare("
            SELECT banner_image, link_url, description, banner_type, is_active
            FROM nb_banners 
            WHERE is_active = 1 
            ORDER BY sort_no ASC
        ");
        $stmt->execute();
        $banners = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // 메인 뉴스 조회 (최신 5개)
        $newsStmt = $db->prepare("
            SELECT no, title, contents, regdate, thumb_image
            FROM nb_board
            WHERE board_no = 25
            ORDER BY no DESC
            LIMIT 5
        ");
        $newsStmt->execute();
        $newsList = $newsStmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // 뉴스 이미지 URL 처리
        foreach ($newsList as &$news) {
            $imageUrl = '';
            if (!empty($news['thumb_image'])) {
                $imageUrl = '/uploads/board/' . $news['thumb_image'];
            }
            $news['image_url'] = $imageUrl;
            
            // contents 전처리
            if (!empty($news['contents'])) {
                $contents = html_entity_decode($news['contents'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $contents = strip_tags($contents);
                $news['contents'] = trim($contents);
            }
        }
        unset($news);
        
        return render('pages.index', [
            'banners' => $banners,
            'newsList' => $newsList
        ]);
    })->name('home');
    $r->get('/contact', fn() => render('pages.contact.index'))->name('contact');
    $r->get('/privacy', fn() => render('pages.privacy.index'))->name('privacy');

    // Company - About
    $r->get('/about', function() {
        $boardNo = 27;
        $db = \DB::getInstance();

        // 카테고리 중 'Directors'의 category_no 조회
        $directorsCategoryNo = null;
        $categories = getBoardCategory($boardNo) ?: [];
        foreach ($categories as $cat) {
            if (isset($cat['name']) && strtolower($cat['name']) === 'directors') {
                $directorsCategoryNo = (int)($cat['category_no'] ?? 0) ?: null;
                break;
            }
        }

        // 게시글 목록 조회 (Directors 카테고리 한정, 없으면 전체)
        $data = \Database\DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> $directorsCategoryNo,
            'page'       => 1,
            'perpage'    => 100,
            'search'     => [
                'keyword' => '',
                'column'  => '',
                'sdate'   => '',
                'edate'   => '',
            ],
        ]);

        $creators = $data['arrResultSet'] ?? [];

        return render('pages.about.company', [
            'creators' => $creators,
            'directorsCategoryNo' => $directorsCategoryNo,
        ]);
    })->name('about');

    $r->get('/about/company', function() {
        $boardNo = 27;
        $directorsCategoryNo = null;
        $categories = getBoardCategory($boardNo) ?: [];
        foreach ($categories as $cat) {
            if (isset($cat['name']) && strtolower($cat['name']) === 'directors') {
                $directorsCategoryNo = (int)($cat['category_no'] ?? 0) ?: null;
                break;
            }
        }
        $data = \Database\DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> $directorsCategoryNo,
            'page'       => 1,
            'perpage'    => 100,
            'search'     => [
                'keyword' => '',
                'column'  => '',
                'sdate'   => '',
                'edate'   => '',
            ],
        ]);
        $creators = $data['arrResultSet'] ?? [];
        return render('pages.about.company', [
            'creators' => $creators,
            'directorsCategoryNo' => $directorsCategoryNo,
        ]);
    })->name('about.company');
    $r->get('/about/history', fn() => render('pages.about.history'))->name('about.history');
    $r->get('/about/partners', fn() => render('pages.about.partners'))->name('about.partners');

    // ========== News ==========
    $r->get('/news', function()  {
        $boardNo = 25;
        $req = app()->request();

        $data = DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> (int)$req->query('category_no', 0) ?: null,
            'page'       => (int)$req->query('page', 1),
            'perpage'    => (int)$req->query('perpage', 0) ?: null,
            'search'     => [
                'keyword' => (string)$req->query('searchKeyword', ''),
                'column'  => (string)$req->query('searchColumn', ''),
                'sdate'   => (string)$req->query('sdate', ''),
                'edate'   => (string)$req->query('edate', ''),
            ],
        ]);
        return render('pages.news.index', $data);
    })->name('company.news');
    
    // NEWS 상세
    $r->get('/news/show/{no}', function(Request $req, Response $res, string $no) {
        $boardNo = 25;

        // no 값 검증
        if (!is_numeric($no)) {
            return $res->redirect('/news', 302);
        }

        // 뉴스 전용 상세 페이지
        return render('pages.news.show', [
            'no'        => (int)$no,
            'board_no'  => $boardNo,
            'page'      => (int)$req->query('page', 1),
            'searchKeyword' => (string)$req->query('searchKeyword', ''),
            'searchColumn'  => (string)$req->query('searchColumn', ''),
        ]);
    })->name('company.news.show');

    
    // ========== Portfolio: Videos ==========
    $r->get('/works', function(Request $req, Response $res)  {
        // board_no: 26
        $boardNo = 26;

        $data = DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> (int)$req->query('category_no', 0) ?: null,
            'page'       => (int)$req->query('page', 1),
            'perpage'    => (int)$req->query('perpage', 0) ?: null,
            'search'     => [
                'keyword' => (string)$req->query('searchKeyword', ''),
                'column'  => (string)$req->query('searchColumn', ''),
                'sdate'   => (string)$req->query('sdate', ''),
                'edate'   => (string)$req->query('edate', ''),
            ],
        ]);
        
        // 카테고리 목록 가져오기
        $categories = getBoardCategory($boardNo) ?: [];
        $data['categories'] = $categories;
        
        return render('pages.works.portfolio', $data);
    })->name('works.portfolio');

    // ========== Portfolio: Show ==========
    $r->get('/works/{no}', function(Request $req, Response $res, string $no)  {
        // board_no: 26
        $boardNo = 26;

        // no 값 검증
        if (!is_numeric($no)) {
            return $res->redirect('/works', 302);
        }

        // DB에서 게시글 상세 정보 가져오기
        $connect = \DB::getInstance();
        $stmt = $connect->prepare("
            SELECT a.*, b.title AS board_name, c.name AS category_name
            FROM nb_board a
            LEFT JOIN nb_board_manage b ON a.board_no = b.no
            LEFT JOIN nb_board_category c ON a.category_no = c.no
            WHERE a.no = :no AND a.board_no = :board_no
        ");
        $stmt->execute([
            ':no' => (int)$no,
            ':board_no' => $boardNo
        ]);
        $work = $stmt->fetch(\PDO::FETCH_ASSOC);

        // 게시글이 없으면 목록으로 리다이렉트
        if (!$work) {
            return $res->redirect('/works', 302);
        }

        // 이미지 경로 처리
        $imageUrl = '';
        if (!empty($work['thumb_image'])) {
            $imageUrl = '/uploads/board/' . $work['thumb_image'];
        }
        $work['image_url'] = $imageUrl;

        // 이전글 가져오기 (현재 글보다 no가 작은 것 중 가장 큰 것)
        $stmtPrev = $connect->prepare("
            SELECT no, title
            FROM nb_board
            WHERE board_no = :board_no AND no < :current_no
            ORDER BY no DESC
            LIMIT 1
        ");
        $stmtPrev->execute([
            ':board_no' => $boardNo,
            ':current_no' => (int)$no
        ]);
        $prevWork = $stmtPrev->fetch(\PDO::FETCH_ASSOC);

        // 다음글 가져오기 (현재 글보다 no가 큰 것 중 가장 작은 것)
        $stmtNext = $connect->prepare("
            SELECT no, title
            FROM nb_board
            WHERE board_no = :board_no AND no > :current_no
            ORDER BY no ASC
            LIMIT 1
        ");
        $stmtNext->execute([
            ':board_no' => $boardNo,
            ':current_no' => (int)$no
        ]);
        $nextWork = $stmtNext->fetch(\PDO::FETCH_ASSOC);

        // 상세 페이지 렌더링
        return render('pages.works.show', [
            'work'      => $work,
            'prevWork'  => $prevWork,
            'nextWork'  => $nextWork,
            'no'        => (int)$no,
            'board_no'  => $boardNo,
        ]);
    })->name('works.show');

});