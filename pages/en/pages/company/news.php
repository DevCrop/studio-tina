<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<script src="<?= $ROOT ?>/resource/js/sub-news.js" <?= date('YmdHis') ?> defer></script>
<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<!-- contents -->

<main>
    <section class="sub-news">
        <div class="container-xl">
            <h2 class="sub-h2">News</h2>

            <article class="no-article">
                <ul class="news-list" <?= $aos_slow_delay ?>>
                    <li>
                        <a href="#">
                            <h3>팔레트 주식회사 사명변경
                            </h3>
                            <span>2024.12.01</span>

                            <img src="/resource/images/news1.jpg">
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <h3>팔레트 주식회사 ai 영상 플랫폼 런칭

                            </h3>
                            <span>2024.12.21</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <h3>팔레트 주식회사 영상 협업플랫폼 런칭
                            </h3>
                            <span>2024.12.01</span>
                        </a>
                    </li>
                </ul>

                <?php include_once $STATIC_ROOT . '/inc/layouts/pagination.php'; ?>
            </article>
        </div>
    </section>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>