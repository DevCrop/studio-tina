<?php section('main_class', 'sub-blog') ?>

<?php section('content') ?>
<form id="frm" name="frm" method="get" autocomplete='off'>    
<input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>">
<input type="hidden" id="category_no" name="category_no" value="<?= htmlspecialchars($category_no) ?>">
<input type="hidden" id="mode" name="mode" value="">

    <section class="sub-blog">
        <div class="container-xl">
            <hgroup>
                <h2 class="poppins">Palette Blog</h2>
                <p <?= AOS_SLOW_DELAY ?>>
                    <?= (app()->getLocale() === 'en')
                        ? 'Stay updated on the latest in video through the Palette blog.'
                        : '팔레트 블로그를 통해 영상과 관련된 최신 정보를 파악하세요.' ?>
                </p>
            </hgroup>

            <article class="no-article">
                <ul class="blog-list" <?= AOS_SLOW_DELAY ?>>
                    <?php
                    foreach ($arrResultSet as $v):
                        $title    = iconv_substr($v['title'], 0, 2000, "utf-8");
                        $contents = iconv_substr(strip_tags($v['contents']), 0, 500, "utf-8");

                        $slug       = \Database\DB::makeSlug($title);   
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
                        <a href="<?= e($link) ?>" target="<?= $target ?>">
                            <figure class="video-wrap" style="background-image:url(<?= e($imgSrc) ?>);"></figure>
                            <div class="txt">
                                <span><?= date("Y.m.d", strtotime($v['regdate'])) ?></span>
                                <h3><?= e($title) ?></h3>
                            </div>
                            <div class="keyword">
                                <p><?= e($v['extra1'] ?? '') ?></p>
                                <p><?= e($v['extra2'] ?? '') ?></p>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <?php include_once $_SERVER['DOCUMENT_ROOT']."/pages/board/components/pagination.php"; ?>
            </article>
        </div>
    </section>
</form>
<?php end_section() ?>

<?php section('script') ?>
<script src="/resource/js/sub-blog.js?v=<?= date('YmdHis') ?>" defer></script>
<script src="/resource/js/board.js?v=<?= date('YmdHis') ?>" defer></script>
<?php end_section() ?>
