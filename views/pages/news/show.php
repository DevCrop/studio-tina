<?php section('main_class', 'no-sub-view no-section-md') ?>
<?php
// SEO 메타: 제목/설명/키워드 설정
$__seoTitle = isset($post['title']) ? (string)$post['title'] : __('news.index.seo_title');
$__rawDesc  = isset($post['contents']) ? html_entity_decode((string)$post['contents'], ENT_QUOTES | ENT_HTML5, 'UTF-8') : '';
$__textDesc = trim(strip_tags($__rawDesc));
if ($__textDesc === '') {
    $__textDesc = __('news.index.seo_desc');
}
// 설명 길이 제한
$__textDesc = mb_substr($__textDesc, 0, 160, 'UTF-8');
?>
<?php section('seo_title', $__seoTitle) ?>
<?php section('seo_desc', $__textDesc) ?>
<?php section('seo_keywords', __('news.index.seo_keywords')) ?>

<?php section('content') ?>


<?php
// ====== DB에서 현재 글/이전/다음 글 조회 및 뷰용 값 매핑 ======
$pdo = \DB::getInstance();

$no      = (int)($no        ?? ($_REQUEST['no']       ?? 0));
$boardNo = (int)($board_no  ?? ($_REQUEST['board_no'] ?? 0));

// 현재 글
$params = [':no' => $no, ':board_no' => $boardNo];
$sql    = "SELECT a.*, c.name AS category_name
           FROM nb_board a
           LEFT JOIN nb_board_category c ON a.category_no = c.no
           WHERE a.no = :no AND a.board_no = :board_no";
$post   = $post ?? ($data ?? null);


if (!$post) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$post) {
        error('정보를 찾을 수 없습니다.');
        exit;
    }
}


// 이전글 / 다음글
$prev = $prev ?? null;
$next = $next ?? null;

if ($prev === null) {
    $stmt = $pdo->prepare("
        SELECT no, title, regdate
        FROM nb_board
        WHERE board_no = :board_no AND is_notice != 'Y' AND no < :no
        ORDER BY no DESC
        LIMIT 1
    ");
    $stmt->execute([':board_no' => $boardNo, ':no' => $post['no']]);
    $prev = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
if ($next === null) {
    $stmt = $pdo->prepare("
        SELECT no, title, regdate
        FROM nb_board
        WHERE board_no = :board_no AND is_notice != 'Y' AND no > :no
        ORDER BY no ASC
        LIMIT 1
    ");
    $stmt->execute([':board_no' => $boardNo, ':no' => $post['no']]);
    $next = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

// 목록 URL (라우팅 사용 시 자동 추론, 없으면 구 방식으로 폴백)
$listUrl = $listUrl ?? (function() use ($boardNo) {
    $loc = app()->getLocale();
    switch ($boardNo) {
        case 8: case 12:  return "/{$loc}/blog";
        case 9: case 13:  return "/{$loc}/news";
        case 10: case 14: return "/{$loc}/portfolio/videos";
        case 15: case 16: return "/{$loc}/portfolio/images";
        default:          return "./board.list.php?board_no=" . urlencode((string)$boardNo);
    }
})();

// 상세 라우트 이름 추론 (넘겨오지 않으면 뉴스/블로그만 자동)
$showRouteName = $showRouteName ?? (function() use ($boardNo) {
    if (in_array($boardNo, [9, 13], true))  return 'company.news.show';
    if (in_array($boardNo, [8, 12], true))  return 'blog.show';
    // 포트폴리오 상세 라우트가 있으면 아래 주석 해제
    // if (in_array($boardNo, [10, 14], true)) return 'portfolio.videos.show';
    // if (in_array($boardNo, [15, 16], true)) return 'portfolio.images.show';
    return null;
})();

// 슬러그 생성은 DB와 동일 규칙 사용
$makeSlug = fn(string $title): string => \Database\DB::makeSlug($title);

// 상세 링크 생성기 (prev/next 공용)
$makeShowUrl = function(array $row) use ($boardNo) {
    // 뉴스는 /news/show/{no} 형식
    if ($boardNo === 25) {
        return "/news/show/{$row['no']}";
    }
    // 다른 게시판은 기존 방식
    return "/pages/board/board.view.php?no={$row['no']}&board_no={$boardNo}";
};

// 다국어 라벨
$labelPrev = (app()->getLocale() === 'en') ? 'Previous' : '이전글';
$labelNext = (app()->getLocale() === 'en') ? 'Next'     : '다음글';
$labelList = (app()->getLocale() === 'en') ? 'List'     : 'Go to List';
?>


<h1 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
    영상트렌드, AI영상 트렌드, 마케팅 트렌드, 스타트업 마케팅
</h1>

<form id="frm" name="frm" method="post">
    <input type="hidden" id="mode" name="mode" value="">
    <input type="hidden" id="comment_no" name="comment_no" value="">
    <input type="hidden" id="no" name="no" value="<?= (int)$no ?>">
    <input type="hidden" id="board_no" name="board_no" value="<?= (int)$boardNo ?>">
    <input type="hidden" id="returnUrl" value="">

    <div class="no-container-lg">
        <div class="no-sub-view-top">
            <a href="<?= e($listUrl) ?>" class="no-prev-button">
                <i class="fa-regular fa-arrow-left-long"></i>
            </a>
            <!-- 이미지 넣기 -->
            <?php if (!empty($post['thumb_image'])): ?>
            <div class="no-sub-view-top__img">
                <figure>
                    <img src="<?= $GLOBALS['UPLOAD_WDIR_BOARD'] . '/' . $post['thumb_image'] ?>"
                        alt="<?= e($post['title'] ?? '') ?>">
                </figure>
            </div>
            <?php endif; ?>
            <div class="no-sub-view-top__txt">
                <span class="no-view-top__date f-body-2">
                    <?= !empty($post['regdate']) ? date('Y.m.d', strtotime($post['regdate'])) : '' ?>
                </span>
                <div>
                    <span class="no-view-top__title f-heading-3 --fm-ko"><?= e($post['title'] ?? '') ?></span>
                    <?php
                    $directUrl = $post['direct_url'];
                    // URL에 프로토콜이 없으면 https:// 추가
                    if (!empty($directUrl) && !preg_match('/^https?:\/\//', $directUrl)) {
                        $directUrl = 'https://' . $directUrl;
                    }
                    ?>
                    <a href="<?= htmlspecialchars($directUrl) ?>" class="no-btn-cta" target="_blank"
                        rel="noopener noreferrer">
                        <p>뉴스 원본 보기</p>
                        <div>
                            <i class="fa-regular fa-arrow-right-long" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="no-sub-view-bot">
            <div class="no-view-bot__contents">
                <?= isset($post['contents']) ? htmlspecialchars_decode($post['contents']) : '' ?>
            </div>
        </div>
        <?php
        // 이전/다음글 안전 처리
        $hasPrev    = is_array($prev) && !empty($prev['no']);
        $hasNext    = is_array($next) && !empty($next['no']);
        $prevTitle  = $hasPrev ? $prev['title'] : (($HTML_LANG ?? '') === 'en' ? 'No previous post.' : '이전글이 없습니다.');
        $nextTitle  = $hasNext ? $next['title'] : (($HTML_LANG ?? '') === 'en' ? 'No next post.'     : '다음글이 없습니다.');
        $prevLink   = $hasPrev ? $makeShowUrl($prev) : 'javascript:void(0)';
        $nextLink   = $hasNext ? $makeShowUrl($next) : 'javascript:void(0)';
        $prevDate   = $hasPrev && !empty($prev['regdate']) ? date('Y-m-d', strtotime($prev['regdate'])) : '';
        $nextDate   = $hasNext && !empty($next['regdate']) ? date('Y-m-d', strtotime($next['regdate'])) : '';
        $prevBack   = $hasPrev ? '' : 'onClick="redirectToList();"';
        $nextBack   = $hasNext ? '' : 'onClick="redirectToList();"';
        ?>

        <div class="no-sub-view-nav">
            <!-- 이전글 -->
            <a href="<?= $prevLink ?>" <?= $prevBack ?>
                class="no-sub-view-nav__item --prev <?= !$hasPrev ? '--disabled' : '' ?>">
                <div class="--icon">
                    <i class="fa-regular fa-arrow-left-long"></i>
                </div>
                <div class="--content">
                    <span class="--title f-heading-5"><?= e($prevTitle) ?></span>
                </div>
            </a>

            <!-- 목록 버튼 -->
            <a href="<?= e($listUrl) ?>" class="no-sub-view-nav__list">
                <span class="f-body-1 --semibold"><?= $labelList ?></span>
            </a>

            <!-- 다음글 -->
            <a href="<?= $nextLink ?>" <?= $nextBack ?>
                class="no-sub-view-nav__item --next <?= !$hasNext ? '--disabled' : '' ?>">
                <div class="--content">
                    <span class="--title f-heading-5"><?= e($nextTitle) ?></span>
                </div>
                <div class="--icon">
                    <i class="fa-regular fa-arrow-right-long"></i>
                </div>
            </a>
        </div>
    </div>



    <script>
    function redirectToList() {
        alert('정보를 찾을 수 없습니다.');
        location.href = <?= json_encode($listUrl, JSON_UNESCAPED_SLASHES) ?>;
    }
    </script>
</form>

<?php end_section() ?>