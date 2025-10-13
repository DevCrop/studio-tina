<?php
if ($board_no == 11) {
?>

    <main>
        <section class="no-cetner-visual">
            <div class="no-container-pc">
                <div class="visual-wrap">
                    <?php include_once $STATIC_ROOT . '/inc/shared/pc-info.php'; ?>

                    <div class="mobile-visual-wrap">
                        <?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
                        <?php include_once $STATIC_ROOT . '/inc/shared/sub.nav-board.php'; ?>

                        <div class="no-cancer no-neuro no-rehab no-review">
                            <section class="no-review-top no-pd-48--y">
                                <div class="no-container-sm">
                                    <hgroup class="--tac no-mg-24--b">
                                        <h2 class="no-heading-sm">나와 비슷한 이야기,<br>
                                            회복의 여정을 확인하세요.</h2>
                                    </hgroup>
                                    <!-- 검색결과 O -->
                                    <div class="search-success">
                                        <p class="no-body-xl fw700 --tac"><b class="blue">‘00’</b>에 대한 검색 결과 입니다.</p>
                                    </div>

                                    <!-- 검색결과 X -->
                                    <div class=" no-search-result">
                                        <p class="no-body-xl fw300 --tac">‘000’에 대한 검색 결과가 없습니다.</p>

                                        <div class="search-guide bg no-mg-32--t">
                                            <p class="bullet no-body-lg fw300">단어의 철자가 정확한지 확인해 주세요.</p>
                                            <p class="bullet no-body-lg fw300">검색어의 수를 줄여서 검색해 보세요.</p>
                                            <p class="bullet no-body-lg fw300">일반적인 검색어로 다시 검색해 보세요.</p>
                                        </div>
                                    </div>

                                    <div class="header-search-box no-mg-32--y">
                                        <input type="search" name="searchKeyword" placeholder="검색어를 입력해주세요"
                                            class="no-body-md">
                                        <button type="button">
                                            <i class="fa-regular fa-magnifying-glass" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                    <ul class="cartegory-wrap">
                                        <li>
                                            <a href="javascript:void(0);" onClick="doCategoryClick(0);"
                                                class="<?= empty($category_no) ? 'active' : '' ?> no-body-lg fw300">
                                                전체
                                            </a>
                                        </li>

                                        <?php if (count($boardCategory) > 0) : ?>
                                            <?php
                                            foreach ($boardCategory as $k => $v) :
                                                $categoryActive = ($category_no == $v['no']) ? "active" : '';
                                            ?>
                                                <li>
                                                    <a href="javascript:void(0);" onClick="doCategoryClick(<?= $v['no'] ?>);"
                                                        class="no-body-lg fw300 <?= $categoryActive ?>">
                                                        <?= $v['name'] ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </section>

                            <section class="no-review-wrap no-pd-48--y">
                                <div class="no-container-sm">
                                    <ul class="review-list">
                                        <?php foreach ($arrResultSet as $v): ?>
                                            <?php
                                            $title = isset($v['title']) && !is_array($v['title']) ? iconv_substr($v['title'], 0, 2000, "utf-8") : '';

                                            $contents = '';
                                            if (isset($v['contents']) && !is_array($v['contents'])) {
                                                $decoded = html_entity_decode($v['contents'], ENT_QUOTES, 'UTF-8');
                                                $stripped = strip_tags($decoded);
                                                $contents = iconv_substr($stripped, 0, 500, "utf-8");
                                            }

                                            $keywordParam = isset($searchKeyword) && !is_array($searchKeyword) ? base64_encode($searchKeyword) : '';
                                            $columnParam  = isset($searchColumn) && !is_array($searchColumn) ? base64_encode($searchColumn) : '';
                                            $link = "./board.view.php?board_no=$board_no&no={$v['no']}" . "&searchKeyword={$keywordParam}"
                                                . "&searchColumn={$columnParam}";

                                            // 이미지 경로 처리
                                            $imgSrc = !empty($v['thumb_image']) ? $UPLOAD_WDIR_BOARD . '/' . $v['thumb_image'] : '/assets/img/no-image.png';

                                            // 타겟 설정
                                            $target = '_self';

                                            // 카테고리 이름
                                            $categoryName = $v['category_name'] ?? '';
                                            ?>

                                            <li class="fade-up">
                                                <a href="<?= $link ?>" target="<?= $target ?>">
                                                    <figure>
                                                        <span
                                                            class="no-body-xs fw600"><?= htmlspecialchars($categoryName) ?></span>
                                                        <img src="<?= htmlspecialchars($imgSrc) ?>"
                                                            alt="<?= htmlspecialchars($title) ?>">
                                                    </figure>

                                                    <div class="f-wrap no-gap-8 no-pd-8--x no-mg-16--t">
                                                        <h3 class="no-body-xxl fw600"><?= htmlspecialchars($title) ?></h3>
                                                        <i class="fa-regular fa-arrow-right i-30"></i>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <?php include_once $STATIC_ROOT . '/inc/layouts/pagination.php'; ?>

                                </div>
                            </section>

                            <?php include_once $STATIC_ROOT . '/inc/layouts/integrate-link.php'; ?>
                        </div>

                        <?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>

                        <?php include_once $STATIC_ROOT . '/inc/layouts/floating-bottom.php'; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
}
?>

<?php
if ($board_no == 12) {
?>

    <?php
    $order_by = $_GET['order_by'] ?? 'latest';
    $order_sql = ($order_by === 'views') ? 'read_cnt DESC' : 'regdate DESC';

    $baseParams = $_GET;
    $baseParams['order_by'] = 'latest';
    $latestUrl = './board.list.php?' . http_build_query($baseParams);

    $baseParams['order_by'] = 'views';
    $viewsUrl = './board.list.php?' . http_build_query($baseParams);
    ?>

    <main>
        <?php
        $banners = getBannersByBranch('gangseo', 6);
        $sql = "SELECT banner_rolling_times FROM nb_etcs LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // 6000 (6초)
        $rollingTime = isset($result['banner_rolling_times']) ? (int)$result['banner_rolling_times'] * 1000 : 5000; // ms로 변환

        // swiper div에 data-rolling=<?=$rollingTime.. 이거넣고 js에서 상수 등록 후 autoplay delay에 해당 값을 넣으세요.
        ?>
        <section class="no-cetner-visual">
            <div class="no-container-pc">
                <div class="visual-wrap">
                    <?php include_once $STATIC_ROOT . '/inc/shared/pc-info.php'; ?>

                    <div class="mobile-visual-wrap">
                        <?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
                        <?php include_once $STATIC_ROOT . '/inc/shared/sub.nav-board.php'; ?>

                        <div class="no-cancer no-neuro no-rehab no-media">
                            <section class="no-cancer-visual visual-slider" data-rolling="<?= $rollingTime ?>">
                                <div class="swiper-wrapper">
                                    <?php if (!empty($banners)): ?>
                                        <?php foreach ($banners as $banner): ?>
                                            <div class="swiper-slide">
                                                <?php
                                                $imgSrc = '/uploads/banners/' . $banner['banner_image'];
                                                $alt = htmlspecialchars($banner['title']);
                                                $imgTag = "<img src=\"{$imgSrc}\" alt=\"{$alt}\">";

                                                if ($banner['has_link'] == 1 && !empty($banner['link_url'])) {
                                                    $href = htmlspecialchars($banner['link_url']);
                                                    $target = ((int)$banner['is_target'] === 1) ? '_blank' : '_self';
                                                    echo "<a href=\"{$href}\" target=\"{$target}\">{$imgTag}</a>";
                                                } else {
                                                    echo $imgTag;
                                                }
                                                ?>
                                                <h2 class="no-heading-sm --tac"><?= $banner['description'] ?></h2>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="swiper-pagination-bar">
                                    <div class="progress-bar">
                                        <div class="progress-fill"></div>
                                    </div>
                                    <button class="swiper-control play" title="Play"></button>
                                    <button class="swiper-control pause" title="Pause"></button>
                                </div>
                            </section>

                            <section class="no-review-wrap no-pd-48--y">
                                <div class="no-container-sm">

                                    <ul class="array-option no-mg-16--b f-wrap no-gap-8">
                                        <li>
                                            <a href="<?= $latestUrl ?>"
                                                class="no-body-lg fw300 gray <?= ($order_by === 'latest' ? 'active' : '') ?>">최신순</a>
                                        </li>
                                        <li>
                                            <a href="<?= $viewsUrl ?>"
                                                class="no-body-lg fw300 gray <?= ($order_by === 'views' ? 'active' : '') ?>">조회순</a>
                                        </li>
                                    </ul>

                                    <ul class="review-list">
                                        <?php foreach ($arrResultSet as $v): ?>
                                            <?php
                                            // 제목 처리
                                            $title = isset($v['title']) && !is_array($v['title'])
                                                ? iconv_substr($v['title'], 0, 2000, "utf-8")
                                                : '';

                                            // 본문 요약
                                            $contents = '';
                                            if (isset($v['contents']) && !is_array($v['contents'])) {
                                                $decoded = html_entity_decode($v['contents'], ENT_QUOTES, 'UTF-8');
                                                $stripped = strip_tags($decoded);
                                                $contents = iconv_substr($stripped, 0, 500, "utf-8");
                                            }

                                            // URL 파라미터 방어
                                            $keywordParam   = isset($searchKeyword) && !is_array($searchKeyword) ? base64_encode($searchKeyword) : '';
                                            $columnParam    = isset($searchColumn)  && !is_array($searchColumn)  ? base64_encode($searchColumn)  : '';
                                            $pageParam      = is_array($page)        ? 1 : (int)$page;
                                            $categoryParam  = is_array($category_no) ? '' : $category_no;

                                            // 링크
                                            $link = "./board.view.php?board_no=$board_no"
                                                . "&no={$v['no']}"
                                                . "&searchKeyword={$keywordParam}"
                                                . "&searchColumn={$columnParam}"
                                                . "&page={$pageParam}"
                                                . "&category_no={$categoryParam}";

                                            // 이미지
                                            $imgSrc = !empty($v['thumb_image'])
                                                ? $UPLOAD_WDIR_BOARD . "/" . $v['thumb_image']
                                                : '/assets/img/no-image.png';

                                            // 타겟 및 날짜
                                            $target = '_self';
                                            $regDate = isset($v['regdate']) ? date("Y.m.d", strtotime($v['regdate'])) : '';
                                            ?>

                                            <li class="fade-up">
                                                <a href="<?= htmlspecialchars($link) ?>" target="<?= $target ?>">
                                                    <figure>
                                                        <img src="<?= htmlspecialchars($imgSrc) ?>"
                                                            alt="<?= htmlspecialchars($title) ?>">
                                                    </figure>

                                                    <div class="f-wrap no-gap-8 no-pd-8--x no-mg-16--t">
                                                        <h3 class="no-body-xxl fw600"><?= htmlspecialchars($title) ?></h3>
                                                        <i class="fa-regular fa-arrow-right i-30"></i>
                                                    </div>
                                                    <p class="no-body-lg fw300 gray no-pd-8--x no-mg-8--t">
                                                        <?= $regDate ?>
                                                    </p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>

                                    </ul>

                                    <?php include_once $STATIC_ROOT . '/inc/layouts/pagination.php'; ?>

                                </div>
                            </section>

                            <?php include_once $STATIC_ROOT . '/inc/layouts/integrate-link.php'; ?>
                        </div>

                        <?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>

                        <?php include_once $STATIC_ROOT . '/inc/layouts/floating-bottom.php'; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
}
?>

<?php
if ($board_no == 13) {
?>

    <main>
        <section class="no-cetner-visual">
            <div class="no-container-pc">
                <div class="visual-wrap">
                    <?php include_once $STATIC_ROOT . '/inc/shared/pc-info.php'; ?>

                    <div class="mobile-visual-wrap">
                        <?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
                        <?php include_once $STATIC_ROOT . '/inc/shared/sub.nav-board.php'; ?>

                        <div class="no-cancer no-neuro no-rehab">
                            <section class="no-review-top no-pd-48--t no-pd-16--b">
                                <div class="no-container-sm">
                                    <hgroup class="--tac no-mg-48--b">
                                        <h2 class="no-heading-sm">함께 나누는 따뜻한 소식,<br>
                                            지금 전해드립니다.</h2>
                                    </hgroup>

                                    <ul class="cartegory-wrap v2 v3">
                                        <li>
                                            <a href="javascript:void(0);" onClick="doCategoryClick(0);"
                                                class="<?= empty($category_no) ? 'active' : '' ?> no-body-lg fw300">
                                                전체
                                            </a>
                                        </li>

                                        <?php if (count($boardCategory) > 0) : ?>
                                            <?php
                                            foreach ($boardCategory as $k => $v) :
                                                $categoryActive = ($category_no == $v['no']) ? "active" : '';
                                            ?>
                                                <li>
                                                    <a href="javascript:void(0);" onClick="doCategoryClick(<?= $v['no'] ?>);"
                                                        class="no-body-lg fw300 <?= $categoryActive ?>">
                                                        <?= $v['name'] ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </section>

                            <section class="no-review-wrap no-pd-48--b">
                                <div class="no-container-sm">
                                    <ul class="review-list">
                                        <?php foreach ($arrResultSet as $v): ?>
                                            <?php
                                            // title 방어 처리
                                            $title = isset($v['title']) && !is_array($v['title'])
                                                ? iconv_substr($v['title'], 0, 2000, "utf-8")
                                                : '';

                                            // contents 요약 (사용 안 하지만 유지)
                                            $contents = '';
                                            if (isset($v['contents']) && !is_array($v['contents'])) {
                                                $decoded = html_entity_decode($v['contents'], ENT_QUOTES, 'UTF-8');
                                                $stripped = strip_tags($decoded);
                                                $contents = iconv_substr($stripped, 0, 500, "utf-8");
                                            }

                                            // URL 파라미터 방어 처리
                                            $keywordParam  = isset($searchKeyword) && !is_array($searchKeyword) ? base64_encode($searchKeyword) : '';
                                            $columnParam   = isset($searchColumn)  && !is_array($searchColumn)  ? base64_encode($searchColumn) : '';
                                            $pageParam     = is_array($page) ? 1 : (int)$page;
                                            $categoryParam = is_array($category_no) ? '' : $category_no;

                                            // 링크 생성
                                            $link = "./board.view.php?board_no=$board_no"
                                                . "&no={$v['no']}"
                                                . "&searchKeyword={$keywordParam}"
                                                . "&searchColumn={$columnParam}"
                                                . "&page={$pageParam}"
                                                . "&category_no={$categoryParam}";

                                            // 이미지 처리
                                            $imgSrc = !empty($v['thumb_image'])
                                                ? $UPLOAD_WDIR_BOARD . "/" . $v['thumb_image']
                                                : '/assets/img/no-image.png';

                                            // 타겟 및 날짜
                                            $target = '_self';
                                            $regDate = isset($v['regdate']) ? date("Y.m.d", strtotime($v['regdate'])) : '';
                                            ?>

                                            <li class="fade-up">
                                                <a href="<?= htmlspecialchars($link) ?>" target="<?= $target ?>">
                                                    <figure>
                                                        <img src="<?= htmlspecialchars($imgSrc) ?>"
                                                            alt="<?= htmlspecialchars($title) ?>">
                                                    </figure>

                                                    <div class="f-wrap no-gap-8 no-pd-8--x no-mg-16--t">
                                                        <h3 class="no-body-xxl fw600"><?= htmlspecialchars($title) ?></h3>
                                                        <i class="fa-regular fa-arrow-right i-30"></i>
                                                    </div>

                                                    <p class="no-body-lg fw300 gray no-pd-8--x no-mg-8--t">
                                                        <?= $regDate ?>
                                                    </p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>

                                    </ul>

                                    <?php include_once $STATIC_ROOT . '/inc/layouts/pagination.php'; ?>

                                </div>
                            </section>

                            <?php include_once $STATIC_ROOT . '/inc/layouts/integrate-link.php'; ?>
                        </div>

                        <?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>

                        <?php include_once $STATIC_ROOT . '/inc/layouts/floating-bottom.php'; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
}
?>