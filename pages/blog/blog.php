<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<script src="<?= $ROOT ?>/resource/js/sub-blog.js" <?= date('YmdHis') ?> defer></script>
<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<!-- contents -->

<main>
    <section class="sub-blog">
        <div class="container-xl">
            <hgroup>
                <h2>Palette Blog</h2>
                <p <?= $aos_slow_delay ?>>팔레트 블로그를 통해 영상과 관련된 최신 정보를 파악하세요.
                </p>
            </hgroup>

            <article class="no-article">
                <ul class="blog-list" <?= $aos_slow_delay ?>>
                    <li>
                        <a href="#">
                            <figure class="video-wrap" style="background-image: url(/resource/images/blog1.jpg);">
                            </figure>
                            <div class="txt">
                                <span>2024.12.01</span>
                                <h3>브랜드 로컬라이제이션의 모순 탐색하기 일관되고 적응력 있는 글로벌 입지 구축하기브랜드 로컬라이제이션의 모순 탐색하기 일관되고 적응력 있는 글로벌 입지 구축하기</h3>
                            </div>

                            <div class="keyword">
                                <p>AI 디자인</p>
                                <p>기획&디자인</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <figure class="video-wrap" style="background-image: url(/resource/images/blog2.jpg);">
                            </figure>
                            <div class="txt">
                                <span>2024.12.01</span>
                                <h3>현장 마케팅 관리자를 위한 2025 콘텐츠 계획 가이드</h3>
                            </div>

                            <div class="keyword">
                                <p>콘텐츠 기획</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <figure class="video-wrap" style="background-image: url(/resource/images/blog3.jpg);">
                            </figure>
                            <div class="txt">
                                <span>2024.12.01</span>
                                <h3>빠듯한 예산으로 고품질 비디오 제작 유지</h3>
                            </div>

                            <div class="keyword">
                                <p>지속적인 창작</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <figure class="video-wrap" style="background-image: url(/resource/images/blog4.jpg);">
                            </figure>
                            <div class="txt">
                                <span>2024.12.01</span>
                                <h3>기능 출시 새로운 매칭 앱을 만나보세요</h3>
                            </div>

                            <div class="keyword">
                                <p>AI 디자인</p>
                                <p>기획&디자인</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <figure class="video-wrap" style="background-image: url(/resource/images/blog5.jpg);">
                            </figure>
                            <div class="txt">
                                <span>2024.12.01</span>
                                <h3>2025년 계획 마케팅 관리자가 온디맨드 콘텐츠 제작을 위해 90 Seconds 을 활용하는 방법</h3>
                            </div>

                            <div class="keyword">
                                <p>AI 디자인</p>
                                <p>기획&디자인</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </article>
        </div>
    </section>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>