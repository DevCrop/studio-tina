<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<script src="<?= $ROOT ?>/resource/js/sub-works.js" <?= date('YmdHis') ?> defer></script>
<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<main>
    <section class="sub-works" <?= $aos_slow ?>>
        <div class="works-slider">
            <ul class="swiper-wrapper">
                <li class="swiper-slide">
                    <a href="/pages/company/about.php">
                        <figure class="cursor-video">
                            <span class="category poppins">Production</span>


                        </figure>

                        <div class="txt">
                            <p class="poppins">Seoul National University</p>
                            <h3 class="poppins">Educational Content Production with AI</h3>
                        </div>
                    </a>
                </li>

                <li class="swiper-slide">
                    <a href="/pages/company/about.php">
                        <figure class="cursor-video">
                            <span class="category poppins">Production</span>


                        </figure>

                        <div class="txt">
                            <p class="poppins">Seoul National University</p>
                            <h3 class="poppins">Educational Content Production with AI</h3>
                        </div>
                    </a>
                </li>

                <li class="swiper-slide">
                    <a href="/pages/company/about.php">
                        <figure class="cursor-video">
                            <span class="category poppins">Production</span>


                        </figure>

                        <div class="txt">
                            <p class="poppins">Seoul National University</p>
                            <h3 class="poppins">Educational Content Production with AI</h3>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="swiper-button-prev arrow"><i class="fa-light fa-arrow-right fa-rotate-180" style="color: #ffffff;"></i></div>
            <div class="swiper-button-next arrow"><i class="fa-light fa-arrow-right" style="color: #ffffff;"></i></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section class="works-wrap" <?= $aos_slow ?>>

        <div class="container-bl">
            <div class="category-wrap">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide active">
                        <a href="#" data-content="All"><span>All</span></a>
                    </li>

                    <li class="swiper-slide">
                        <a href="#" data-content="AI Video"><span>AI Video</span></a>
                    </li>

                    <li class="swiper-slide">
                        <a href="#" data-content="Startup IR"><span>Startup IR</span></a>
                    </li>

                    <li class="swiper-slide">
                        <a href="#" data-content="Shorts"><span>Shorts</span></a>
                    </li>

                    <li class="swiper-slide">
                        <a href="#" data-content="Product"><span>Product</span></a>
                    </li>

                    <li class="swiper-slide">
                        <a href="#" data-content="Brand"><span>Brand</span></a>
                    </li>

                    <li class="swiper-slide">
                        <a href="#" data-content="Corp News"><span>Corp News</span></a>
                    </li>
                </ul>
            </div>

            <article class="no-article">
                <ul class="work-list">
                    <li>
                        <a href="/pages/company/about.php">
                            <figure class="cursor-video">


                                <span class="category poppins">AI Video</span>
                            </figure>

                            <div class="txt">
                                <p class="poppins">ABC Studios</p>
                                <h3 class="poppins">Beyond the Frame: A Journey</h3>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/pages/company/about.php">
                            <figure class="cursor-video">

                                <span class="category poppins">AI Video</span>
                            </figure>

                            <div class="txt">
                                <p class="poppins">ABC Studios</p>
                                <h3 class="poppins">Beyond the Frame: A Journey</h3>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/pages/company/about.php">
                            <figure class="cursor-video">


                                <span class="category poppins">AI Video</span>
                            </figure>

                            <div class="txt">
                                <p class="poppins">ABC Studios</p>
                                <h3 class="poppins">Beyond the Frame: A Journey</h3>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/pages/company/about.php">
                            <figure class="cursor-video">


                                <span class="category poppins">AI Video</span>
                            </figure>

                            <div class="txt">
                                <p class="poppins">ABC Studios</p>
                                <h3 class="poppins">Beyond the Frame: A Journey</h3>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/pages/company/about.php">
                            <figure class="cursor-video">


                                <span class="category poppins">AI Video</span>
                            </figure>

                            <div class="txt">
                                <p class="poppins">ABC Studios</p>
                                <h3 class="poppins">Beyond the Frame: A Journey</h3>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/pages/company/about.php">
                            <figure class="cursor-video">


                                <span class="category poppins">AI Video</span>
                            </figure>

                            <div class="txt">
                                <p class="poppins">ABC Studios</p>
                                <h3 class="poppins">Beyond the Frame: A Journey</h3>
                            </div>
                        </a>
                    </li>
                </ul>
            </article>

            <?php include_once $STATIC_ROOT . '/inc/layouts/pagination.php'; ?>
        </div>
    </section>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>