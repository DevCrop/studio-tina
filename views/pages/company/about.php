<!-- contents -->
<?php section('seo_title', __('about.seo_title')) ?>
<?php section('seo_desc', __('about.seo_desc')) ?>
<?php section('seo_keywords', __('about.seo_keywords')) ?>
<?php section('main_class', 'sub-about') ?> 

<?php section('content') ?>

    <h1 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
        <?= __('about.seo.h1') ?>
    </h1>
    <h2 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
        <?= __('about.seo.h2_1') ?>
    </h2>
    <h2 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
        <?= __('about.seo.h2_2') ?>
    </h2>
    <h2 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
        <?= __('about.seo.h2_3') ?>
    </h2>

    <section class="about-intro">
        <figure class="back-bg" style="background-image: url('/resource/images/about-bg.jpg');"></figure>
        <div class="container-xl">
            <div class="content">
                <h2 class="reveal">
                    <span class="letter"><?= __('about.intro.headline') ?></span>
                </h2>
            </div>
        </div>
    </section>

    <section class="vision">
        <div class="container-xl">
            <h2 class="sub-h2 poppins" <?= AOS_RIGHT_SLOW ?>><?= __('about.vision.title') ?></h2>
            <div class="flex-wrap">
                <div class="title scroll-color" <?= AOS_SLOW ?>>
                    <h3><?= __('about.vision.slogan') ?></h3>
                    <p><?= __('about.vision.subtitle') ?></p>
                </div>
                <div class="txt" <?= AOS_SLOW ?>>
                    <p class="scroll-color"><?= __('about.vision.p1') ?></p>
                    <br>
                    <p class="scroll-color"><?= __('about.vision.p2') ?></p>
                </div>
                <div class="txt m-vesion" <?= AOS_SLOW ?>>
                    <p class="scroll-color"><?= __('about.vision.mobile_p') ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="cibi">
        <div class="container-xl">
            <div class="cibi-wrap" <?= AOS_SLOW ?>>
                <div class="flex-wrap">
                    <h2 class="sub-h2"><?= __('about.cibi.identity_title') ?></h2>
                    <div class="right">
                        <div class="wordmark-list">
                            <img src="/resource/images/wordmark-light.jpg" alt="wordmark light">
                            <img src="/resource/images/wordmark-dark.jpg" alt="wordmark dark">
                        </div>
                        <p><?= __('about.cibi.identity_desc') ?></p>
                    </div>
                </div>
            </div>

            <div class="cibi-wrap" <?= AOS_SLOW ?>>
                <div class="flex-wrap">
                    <h2 class="sub-h2"><?= __('about.cibi.color_title') ?></h2>
                </div>

                <ul class="color-list">
                    <li>
                        <div class="color-box red">
                            <span><?= __('about.cibi.colors.0.name') ?></span>
                        </div>
                        <ul class="color-info">
                            <li><p>PANTONE</p><span>1785 C</span></li>
                            <li><p>CMYK</p><span>0/80/60/0</span></li>
                            <li><p>RGB</p><span>255/80/80</span></li>
                            <li><p>HEX</p><span>#FF5050</span></li>
                        </ul>
                    </li>

                    <li>
                        <div class="color-box navy">
                            <span><?= __('about.cibi.colors.1.name') ?></span>
                        </div>
                        <ul class="color-info">
                            <li><p>PANTONE</p><span>Blue 072 C</span></li>
                            <li><p>CMYK</p><span>100/95/30/0</span></li>
                            <li><p>RGB</p><span>10/40/135</span></li>
                            <li><p>HEX</p><span>#0A2887</span></li>
                        </ul>
                    </li>

                    <li>
                        <div class="color-box beige">
                            <span><?= __('about.cibi.colors.2.name') ?></span>
                        </div>
                        <ul class="color-info">
                            <li><p>PANTONE</p><span>7401 C</span></li>
                            <li><p>CMYK</p><span>0/15/30/0</span></li>
                            <li><p>RGB</p><span>255/230/185</span></li>
                            <li><p>HEX</p><span>#FFE6B9</span></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="office office-new">
        <div class="container-xl">
            <h2 class="sub-h2 poppins" <?= AOS_SLOW ?>><?= __('about.offices.title') ?></h2>

            <article class="no-article">
                <div class="history">
                    <ul>
                        <li>
                            <div>
                                <div class="year"><h4>2022</h4></div>
                                <div class="info">
                                    <div class="month">10</div>
                                    <div class="text"><?= __('about.offices.timeline.0.text') ?></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <div class="year"><h4>2024</h4></div>
                                <div class="info">
                                    <div class="month">07</div>
                                    <div class="text"><?= __('about.offices.timeline.1.text') ?></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <div class="year"><h4>2025</h4></div>
                                <div class="info">
                                    <div class="text"><?= __('about.offices.timeline.2.text') ?></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <figure>
                    <div class="img">
						<img src="/resource/images/new/map.svg" alt="">
						<div class="ripple-list">
							<div class="kr">
								<div class="ripple-item">
									<div class="dot"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
								</div>
							</div>
							<div class="id">
								<div class="ripple-item">
									<div class="dot"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
								</div>
							</div>
							<div class="sp">
								<div class="ripple-item">
									<div class="dot"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
								</div>
							</div>
							<div class="usa">
								<div class="ripple-item">
									<div class="dot"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
									<div class="ripple"></div>
								</div>
							</div>
						</div>
					</div>
                </figure>
            </article>
    </section>

    <section class="award award-new">
        <div class="container-xl">
            <h2 class="sub-h2" style="color:#fff;text-align:center;" <?= AOS_SLOW ?>>
                <?= __('about.awards.title') ?>
            </h2>
            <article class="no-article award-article">
                <ul>
                    <li <?= AOS_SLOW ?>>
                        <div class="img"><img src="<?= IMG_PATH ?>/new/about_new_img_1.png" alt=""></div>
                        <div class="text"><div class="year"><ul><li>2022</li></ul></div>
                            <div class="txt"><?= __('about.awards.items.0.text') ?></div></div>
                    </li>
                    <li <?= AOS_SLOW ?>>
                        <div class="img"><img src="<?= IMG_PATH ?>/new/about_new_img_2.png" alt=""></div>
                        <div class="text"><div class="year"><ul><li>2022</li></ul></div>
                            <div class="txt"><?= __('about.awards.items.1.text') ?></div></div>
                    </li>
                    <li <?= AOS_SLOW ?>>
                        <div class="img"><img src="<?= IMG_PATH ?>/new/about_new_img_3.png" alt=""></div>
                        <div class="text"><div class="year"><ul><li>2023</li></ul></div>
                            <div class="txt"><?= __('about.awards.items.2.text') ?></div></div>
                    </li>
                    <li <?= AOS_SLOW ?>>
                        <div class="img"><img src="<?= IMG_PATH ?>/new/about_new_img_4.png" alt=""></div>
                        <div class="text"><div class="year"><ul><li>2023</li><li>2022</li></ul></div>
                            <div class="txt"><?= __('about.awards.items.3.text') ?></div></div>
                    </li>
                    <li <?= AOS_SLOW ?>>
                        <div class="img"><img src="<?= IMG_PATH ?>/new/about_new_img_5.png" alt=""></div>
                        <div class="text"><div class="year"><ul><li>2024</li></ul></div>
                            <div class="txt"><?= __('about.awards.items.4.text') ?></div></div>
                    </li>
                    <li <?= AOS_SLOW ?>>
                        <div class="img"><img src="<?= IMG_PATH ?>/new/about_new_img_6.png" alt=""></div>
                        <div class="text"><div class="year"><ul><li>2024</li></ul></div>
                            <div class="txt"><?= __('about.awards.items.5.text') ?></div></div>
                    </li>
                    <li <?= AOS_SLOW ?>>
                        <div class="img"><img src="<?= IMG_PATH ?>/new/about_new_img_7.png" alt=""></div>
                        <div class="text"><div class="year"><ul><li>2024</li></ul></div>
                            <div class="txt"><?= __('about.awards.items.6.text') ?></div></div>
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <?= include_view('sections.contact', [
        'sub_title' => __('main.contact_desc'),
        'rolling' => true,    
    ]) ?>

<?php end_section() ?>

<?php section('script') ?>

<script src="/resource/js/sub-about.js?v=<?= date('YmdHis') ?>" defer></script>

<?php end_section() ?>