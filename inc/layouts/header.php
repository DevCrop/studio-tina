<?php 

$MENU_ITEMS = app()->get('menu')->toArray();

dd($MENU_ITEMS);
?>
ASDASDASDASD
<header>
    <div class="no-header">
        <div class="no-header__bg"></div>

        <div class="no-header__inner">
            <div class="no-header__logo">
                <a href="<?= ($HTML_LANG == 'en') ? '/en' : '/' ?>">
                    <img src="<?= $UPLOAD_SITEINFO_WDIR_LOGO ?>/<?= $SITEINFO_LOGO_TOP ?>" alt="<?= $SITEINFO_TITLE ?>"
                        class="white" />
                </a>
            </div>

            <!-- HeaderNav -->

            <?php if (count($MENU_ITEMS) > 0) : ?>
            <nav class="no-header__nav">
                <div class="no-header__menu">
                    <ul class="no-header__menu--gnb">
                        <?php foreach ($MENU_ITEMS as $di => $depth) :
								$depth_active = $depth['isActive'] ? 'active' : '';
							?>
                        <li>
                            <a href="<?= $depth['path'] ?>" class="<?= $depth_active ?>"
                                data-content="<?= htmlspecialchars($depth['title']) ?>">
                                <span class="poppins"><?= $depth['title'] ?></span>
                            </a>

                            <?php if (!empty($depth['pages'])) : ?>
                            <ul class="no-header__menu--lnb">
                                <?php foreach ($depth['pages'] as $pi => $PAGE) :
												$page_active = $PAGE['isActive'] ? 'active' : '';
											?>
                                <li class="<?= $page_active ?>">
                                    <a href="<?= $PAGE['path'] ?>" class="poppins"><?= $PAGE['title'] ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <?php endif; ?>

            <div class="opt-group">

                <div class="lang-box">
                    <a href="/" class="<?= ($HTML_LANG == 'ko') ? 'active' : '' ?>">
                        KR
                    </a>

                    <a href="/en" class="<?= ($HTML_LANG == 'en') ? 'active' : '' ?>">
                        EN
                    </a>
                </div>

                <div class="line"></div>

                <div class="sns-group">
                    <a href="https://www.youtube.com/@pltt_official" target="_blank"><img
                            src="/resource/images/icon/youtube.svg"></a>
                    <a href="<?=$SITEINFO_HP?>" target="_blank"><img src="/resource/images/icon/naver.svg"></a>
                    <a href="<?=$SITEINFO_PHONE?>" target="_blank"><img src="/resource/images/icon/insta.svg"></a>
                    <a href="<?=$SITEINFO_CUSTOMER_CENTER_ABLE_TIME?>" target="_blank"><img
                            src="/resource/images/icon/linked.svg"></a>
                </div>

                <div class="line"></div>

                <a class="no-header__btn">
                    <span class="no-header__btn-line-top"></span>
                    <span class="no-header__btn-line-bottom"></span>
                </a>
            </div>
        </div>

        <!--Mobile menu start-->

        <div class="no-header__m">
            <nav class="no-header__m-nav">
                <div class="no-header__m-menu">
                    <?php if (count($MENU_ITEMS) > 0) : ?>
                    <!-- depth1 start -->
                    <ul class="no-header__m--gnb">
                        <?php foreach ($MENU_ITEMS as $di => $depth) :
                                $depth_active = $depth['isActive'] ? 'active' : '';
                            ?>
                        <li>
                            <a href="<?= $depth['path'] ?>" class="no-header__m--gnb-title"
                                data-content="<?= htmlspecialchars($depth['title']) ?>">
                                <p class="poppins">
                                    <span class="poppins"><?= str_pad($di + 1, 2, '0', STR_PAD_LEFT) ?></span>
                                    <?= $depth['title'] ?>
                                </p>
                            </a>

                            <!--depth2 start-->
                            <?php if (array_key_exists('pages', $depth) && count($depth['pages']) > 0) : ?>
                            <ul class="no-header__m--lnb">
                                <?php foreach ($depth['pages'] as $pi => $PAGE) :
                                                $page_active = $PAGE['isActive'] ? 'active' : '';
                                            ?>
                                <li>
                                    <a href="<?= $PAGE['path'] ?>" class="poppins"><?= $PAGE['title'] ?> <div
                                            class="line"></div></a>

                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            <!--depth2 end-->
                        </li>
                        <?php endforeach; ?>
                        <!-- depth1 end -->
                    </ul>
                    <?php endif; ?>

                    <h4 class="sub-footer poppins">
                        <p>
                            <?= ($HTML_LANG == 'en') 
								? '4F, Hoban Park II, 18, Yangjaedaero 2-gil, Seocho-gu, Seoul, Republic of Korea' 
								: '서울시 서초구 양재대로 2길 18 호반파크 2관 4층' ?>
                        </p>
                        <p>010-3490-9181</p>
                        <p>hello@pltt.xyz</p>
                        <p>&copy; Palette Corp. All rights reserved.</p>
                    </h4>
                </div>
            </nav>
        </div>
</header>

<ul class="side-btn">
    <li class="contact-btn">
        <img src="/resource/images/icon/rotate-txt.svg" class="rotate-txt">
        <a href="<?= ($HTML_LANG == 'en') ? '/en/pages/company/contact.php' : '/pages/company/contact.php' ?>">
            <img src="/resource/images/icon/contact.svg">
        </a>
    </li>

    <li class="top_btn">
        <a href="#" onclick="return false">
            <img src="/resource/images/icon/top-arrow.svg">
        </a>
    </li>
</ul>

<div class="cursor"></div>