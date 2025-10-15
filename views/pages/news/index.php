<?php section('main_class', 'sub-news') ?>
<?php section('seo_title', __('news.index.seo_title')) ?>
<?php section('seo_desc', __('news.index.seo_desc')) ?>
<?php section('seo_keywords', __('news.index.seo_keywords')) ?>

<?php section('content') ?>


<form id="frm" name="frm" method="get" autocomplete='off'>
    <input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>">
    <input type="hidden" id="category_no" name="category_no" value="<?= htmlspecialchars($category_no) ?>">
    <input type="hidden" id="mode" name="mode" value="">

    <section class="no-sub-news no-section-md">
        <div class="no-section-sub-title">
            <h2 class="f-display-2 fade-up --tac">News</h2>
        </div>
        <div class="no-container-2xl">
            <div class="--cnt">
                <ul>
                    <?php foreach ($arrResultSet as $v):
                        $title    = iconv_substr($v['title'], 0, 2000, "utf-8");
                        $contents = iconv_substr(strip_tags($v['contents']), 0, 500, "utf-8");

                        // 이미지 경로
                        $imgSrc = '';
                        if (!empty($v['thumb_image'])) {
                            $imgSrc = $GLOBALS['UPLOAD_WDIR_BOARD'] . "/" . $v['thumb_image'];
                        }
                    ?>
                    <li class="fade-up">
                        <a href="/news/show/<?= $v['no'] ?>">
                            <figure>
                                <?php if ($imgSrc): ?><img src="<?= htmlspecialchars($imgSrc) ?>" alt=""><?php endif; ?>
                            </figure>
                            <div>
                                <h3 class="f-heading-4 --bold"><?= htmlspecialchars($title) ?></h3>
                                <span
                                    class="f-body-2 --regular"><?= htmlspecialchars(mb_strimwidth(preg_replace('/&[a-zA-Z0-9#]+;/', '', strip_tags(html_entity_decode($v['contents'], ENT_QUOTES | ENT_HTML5, 'UTF-8'))), 0, 150, '...', 'UTF-8')) ?></span>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?= include_view('components.pagination') ?>

        </div>
    </section>
    <?= include_view('sections.contact') ?>

    </main>
    <?php end_section() ?>
</form>
<?php section('script') ?>
<script src="/resource/js/board.js?v=<?= date('YmdHis') ?>" defer></script>
<?php end_section() ?>