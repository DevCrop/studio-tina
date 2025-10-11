<?php section('main_class', 'sub-news') ?>

<?php section('content') ?>
<form id="frm" name="frm" method="get" autocomplete='off'>    
<input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>">
<input type="hidden" id="category_no" name="category_no" value="<?= htmlspecialchars($category_no) ?>">
<input type="hidden" id="mode" name="mode" value="">

    <section class="sub-news">
        <div class="container-xl">
            <h2 class="sub-h2 poppins">News</h2>

            <article class="no-article">
                <ul class="news-list" <?= AOS_SLOW_DELAY ?>>
                    <?php foreach ($arrResultSet as $v):
                        $title    = iconv_substr($v['title'], 0, 2000, "utf-8");
                        $contents = iconv_substr(strip_tags($v['contents']), 0, 500, "utf-8");

                        $slug       = \Database\DB::makeSlug($title);   

                        // 라우트 헬퍼로 path 생성 후, 로케일 프리픽스만 붙여서 최종 링크 완성
                        $linkPath = \Database\DB::buildPostRoute('company.news.show', (string)$v['title']); // ← 원본으로!
                        $link = '/' . app()->getLocale() . $linkPath . '?page=' . (int)$listCurPage;
                        $imgSrc = '';
                        
                        if (!empty($v['thumb_image'])) {
                            $imgSrc = $GLOBALS['UPLOAD_WDIR_BOARD'] . "/" . $v['thumb_image'];
                        }

                        $target = !empty($v['direct_url']) ? '_blank' : '_self';
                        $link   = !empty($v['direct_url']) ? $v['direct_url'] : $link;
                    ?>
                    <li>
                        <a href="<?= htmlspecialchars($link) ?>" target="<?= $target ?>">
                            <h3><?= htmlspecialchars($title) ?></h3>
                            <span><?= date("Y.m.d", strtotime($v['regdate'])) ?></span>
                            <?php if ($imgSrc): ?><img src="<?= htmlspecialchars($imgSrc) ?>" alt=""><?php endif; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <?php include_once $_SERVER['DOCUMENT_ROOT']."/pages/board/components/pagination.php"; ?>
            </article>
        </div>
    </section>
</main>
<?php end_section() ?>
</form>
<?php section('script') ?>
<script src="/resource/js/sub-news.js?v=<?= date('YmdHis') ?>" defer></script>
<script src="/resource/js/board.js?v=<?= date('YmdHis') ?>" defer></script>
<?php end_section() ?>
