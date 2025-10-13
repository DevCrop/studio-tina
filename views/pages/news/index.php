<?php section('main_class', 'sub-news') ?>

<?php section('content') ?>


<?= include_view('sections.subVisual', [
        'title' => 'NEWS',
    ]) ?>


<form id="frm" name="frm" method="get" autocomplete='off'>
    <input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>">
    <input type="hidden" id="category_no" name="category_no" value="<?= htmlspecialchars($category_no) ?>">
    <input type="hidden" id="mode" name="mode" value="">

    <section class="no-sub-news no-section-md">
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
                    <li>
                        <a href="/news/show/<?= $v['no'] ?>">
                            <figure>
                                <?php if ($imgSrc): ?><img src="<?= htmlspecialchars($imgSrc) ?>" alt=""><?php endif; ?>
                            </figure>
                            <div>
                                <h3 class="f-heading-4 --bold"><?= htmlspecialchars($title) ?></h3>
                                <span
                                    class="f-body-2 --regular"><?= htmlspecialchars(strip_tags($v['contents']))?></span>
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