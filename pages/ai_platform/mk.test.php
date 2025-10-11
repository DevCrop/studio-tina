<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<script src="<?= $ROOT ?>/resource/js/sub-mk.js" <?= date('YmdHis') ?> defer></script>
<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<!-- contents -->

<main class="sub-mk">
<h1 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">콘텐츠 마케팅, 퍼포먼스 마케팅, 고객사
</h1>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">콘텐츠 기획, 영상제작, SNS 운영, 광고기획
</h2>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">SA, 검색광고, DA, 디스플레이 광고, 테이터 분석, CPC, CTR, CVR, ROAS
</h2>
    <section class="mk-headline">
        <figure class="back-bg" style="background-image: url('/resource/images/mk-bg.jpg');">
        </figure>
        <div class="container-xl">
            <h2 class="reveal"><span class="letter">전략적 콘텐츠와<br> 퍼포먼스 디지털 마케팅의 완성</span>
            </h2>

            <ul class="circle-group">
                <li <?= $aos_slow_delay ?>>
                    <h3>Creative</h3>
                    <figure>
                        <div class="txt">
                            <p>콘텐츠기획</p>
                            <p>영상</p>
                            <p>SNS운영대행</p>
                            <p>광고기획</p>
                        </div>
                        <svg class="circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="100%" height="100%">
                            <circle cx="60" cy="60" r="55" fill="none" stroke="#fff" stroke-width=".5" />
                        </svg>
                    </figure>
                </li>
                <li <?= $aos_slow_delay ?>>
                    <h3>Performance</h3>
                    <figure>
                        <div class="txt">
                            <p>SA · 검색광고</p>
                            <p>DA · 디스플레이 광고</p>
                            <p>데이터 분석</p>
                        </div>
                        <svg class="circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="100%" height="100%">
                            <circle cx="60" cy="60" r="55" fill="none" stroke="#fff" stroke-width=".5" />
                        </svg>
                    </figure>
                </li>
            </ul>
        </div>
    </section>

    <section class="mk-graph">
        <div class="container-xl">
            <h2 class="sub-h2" <?= $aos_slow ?>>팔레트 마케팅이<br>
                만들면 성장합니다
            </h2>

            <article class="no-article">
                <ul class="graph-list">
                    <li <?= $aos_slow ?>>
                        <img src="/resource/images/mk-graph1.png">
                        <h3>경기도 광명시</h3>
                    </li>

                    <li <?= $aos_slow ?>>
                        <img src="/resource/images/mk-graph2.png">
                        <h3>한국벤처투자</h3>
                    </li>

                    <li <?= $aos_slow ?>>
                        <img src="/resource/images/mk-graph3.png">
                        <h3>농림축산식품부</h3>
                    </li>

                    <li <?= $aos_slow ?>>
                        <img src="/resource/images/mk-graph4.png">
                        <h3>코이카</h3>
                    </li>
                </ul>
            </article>
    </section>

    <section class="mk-case">
        <div class="container-bl">
            <h2 class="sub-h2" <?= $aos_slow ?>>성과를 시각화하여<br>
                당신의 성공을 보여드립니다
            </h2>

            <article class="no-article" <?= $aos_slow ?>>
                <div class="mkcase-slider">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide">
                            <div class="wrap">
                                <h3>한국벤처투자</h3>
                                <p>스타트업 X는 디지털 마케팅 전략을 통해 단기간에 눈에 띄는 성과를 이뤄냈습니다. 맞춤형 타겟팅과 콘텐츠 마케팅, 그리고 데이터 기반 최적화가 핵심이었으며, 이를 통해 브랜드 인지도를 획기적으로 향상시키고, 매출을 크게 증대시킬 수 있었습니다.</p>
                                <div class="percent">
                                    <span>
                                        <p>유튜브</p> <b>70</b> % 증가
                                    </span>
                                    <span>
                                        <p>인스타그램</p> <b>70</b> % 증가
                                    </span>
                                </div>
                            </div>
                            <img src="/resource/images/case1.jpg">
                        </li>
                        <li class="swiper-slide">
                            <div class="wrap">
                                <h3>한국벤처투자</h3>
                                <p>스타트업 X는 디지털 마케팅 전략을 통해 단기간에 눈에 띄는 성과를 이뤄냈습니다. 맞춤형 타겟팅과 콘텐츠 마케팅, 그리고 데이터 기반 최적화가 핵심이었으며, 이를 통해 브랜드 인지도를 획기적으로 향상시키고, 매출을 크게 증대시킬 수 있었습니다.</p>
                                <div class="percent">
                                    <span>
                                        <p>유튜브</p> <b>70</b> % 증가
                                    </span>
                                    <span>
                                        <p>인스타그램</p> <b>70</b> % 증가
                                    </span>
                                </div>
                            </div>
                            <img src="/resource/images/case1.jpg">
                        </li>
                        <li class="swiper-slide">
                            <div class="wrap">
                                <h3>한국벤처투자</h3>
                                <p>스타트업 X는 디지털 마케팅 전략을 통해 단기간에 눈에 띄는 성과를 이뤄냈습니다. 맞춤형 타겟팅과 콘텐츠 마케팅, 그리고 데이터 기반 최적화가 핵심이었으며, 이를 통해 브랜드 인지도를 획기적으로 향상시키고, 매출을 크게 증대시킬 수 있었습니다.</p>
                                <div class="percent">
                                    <span>
                                        <p>유튜브</p> <b>70</b> % 증가
                                    </span>
                                    <span>
                                        <p>인스타그램</p> <b>70</b> % 증가
                                    </span>
                                </div>
                            </div>
                            <img src="/resource/images/case1.jpg">
                        </li>
                    </ul>
                </div>

                <div class="swiper-controller">
                    <div class="swiper-button-prev arrow"><i class="fa-regular fa-angle-up fa-rotate-270" style="color: #ffffff;"></i></div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next arrow"><i class="fa-regular fa-angle-up fa-rotate-90" style="color: #ffffff;"></i></div>
                </div>
            </article>
        </div>
    </section>

    <section class="sub-client">
        <div class="container-xl">
            <h2 class="sub-h2" <?= $aos_slow ?>>고객의 성공이 곧 우리의<br> 성공입니다
            </h2>

            <article class="no-article">
                <ul class="client-list" <?= $aos_slow ?>>

					<li>
                        <img src="/resource/images/client0.png">
                    </li>

                    <li>
                        <img src="/resource/images/client00.png">
                    </li>

                    <li>
                        <img src="/resource/images/client000.png">
                    </li>

                    <li>
                        <img src="/resource/images/client1.png">
                    </li>

                    <li>
                        <img src="/resource/images/client2.png">
                    </li>

                    <li>
                        <img src="/resource/images/client3.png">
                    </li>

                    <li>
                        <img src="/resource/images/client4.png">
                    </li>

                    <li>
                        <img src="/resource/images/client5.png">
                    </li>


                    <li>
                        <img src="/resource/images/client6.png">
                    </li>

                    <li>
                        <img src="/resource/images/client7.png">
                    </li>

                    <li>
                        <img src="/resource/images/client8.png">
                    </li>

                    <li>
                        <img src="/resource/images/client9.png">
                    </li>

                    <li>
                        <img src="/resource/images/client10.png">
                    </li>



                    <li>
                        <img src="/resource/images/client11.png">
                    </li>

                    <li>
                        <img src="/resource/images/client12.png">
                    </li>

                    <li>
                        <img src="/resource/images/client13.png">
                    </li>

                    <li>
                        <img src="/resource/images/client14.png">
                    </li>

                    <li>
                        <img src="/resource/images/client15.png">
                    </li>


                    <li>
                        <img src="/resource/images/client16.png">
                    </li>

                    <li>
                        <img src="/resource/images/client17.png">
                    </li>

                    <li>
                        <img src="/resource/images/client18.png">
                    </li>

                    <li>
                        <img src="/resource/images/client19.png">
                    </li>

                    <li>
                        <img src="/resource/images/client20.png">
                    </li>



                    <li>
                        <img src="/resource/images/client21.png">
                    </li>

                    <li>
                        <img src="/resource/images/client22.png">
                    </li>

                    <li>
                        <img src="/resource/images/client23.png">
                    </li>

                    <li>
                        <img src="/resource/images/client24.png">
                    </li>

                    <li>
                        <img src="/resource/images/client25.png">
                    </li>


                    <li>
                        <img src="/resource/images/client26.png">
                    </li>

                    <li>
                        <img src="/resource/images/client27.png">
                    </li>

                    <li>
                        <img src="/resource/images/client28.png">
                    </li>

                    <li>
                        <img src="/resource/images/client29.png">
                    </li>

                    <li>
                        <img src="/resource/images/client30.png">
                    </li>

                    <li>
                        <img src="/resource/images/client31.png">
                    </li>

                    <li>
                        <img src="/resource/images/client32.png">
                    </li>

                    <li>
                        <img src="/resource/images/client33.png">
                    </li>

                    <li>
                        <img src="/resource/images/client34.png">
                    </li>

                    <li>
                        <img src="/resource/images/client35.png">
                    </li>



                    <li>
                        <img src="/resource/images/client36.png">
                    </li>

                    <li>
                        <img src="/resource/images/client37.png">
                    </li>

                    <li>
                        <img src="/resource/images/client38.png">
                    </li>

                    <li>
                        <img src="/resource/images/client39.png">
                    </li>

                    <li>
                        <img src="/resource/images/client40.png">
                    </li>


                    <li>
                        <img src="/resource/images/client41.png">
                    </li>

                    <li>
                        <img src="/resource/images/client42.png">
                    </li>

                    <li>
                        <img src="/resource/images/client43.png">
                    </li>

                    <li>
                        <img src="/resource/images/client44.png">
                    </li>

                    <li>
                        <img src="/resource/images/client45.png">
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <?php include_once $STATIC_ROOT . '/inc/layouts/gocontact.php'; ?>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>