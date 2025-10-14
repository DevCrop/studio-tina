<?php 
    $MENU_ITEMS = app()->get('menu')->toArray();
    $siteinfo = app()->get('siteinfo');
    
    // 사이트맵 배경 이미지 조회
    $db = DB::getInstance();
    $stmt = $db->prepare("SELECT title, bg_image FROM nb_etcs ORDER BY id ASC");
    $stmt->execute();
    $sitemapBgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // title별로 매핑
    $bgImages = [
        'default' => '/resource/images/util/sitemap_bg_default.jpg',
        'about' => '/resource/images/util/sitemap_bg_1.jpg',
        'works' => '/resource/images/util/sitemap_bg_2.jpg',
        'news' => '/resource/images/util/sitemap_bg_3.jpg',
        'contact' => '/resource/images/util/sitemap_bg_4.jpg',
    ];
    
    foreach ($sitemapBgs as $bg) {
        if (!empty($bg['bg_image'])) {
            $bgImages[$bg['title']] = '/uploads/logo/' . $bg['bg_image'];
        }
    }
?>

<header id="header">
    <div class="no-header-container ">
        <div class="no-header">
            <div class="no-header__inner">
                <div class="no-header-logo">
                    <a href="/">
                        <img src="/resource/images/logo/LOGO_WHITE.svg" alt="LOGO_WHITE" class="white" />
                    </a>
                </div>

                <!-- HeaderNav -->
                <?php if (count($MENU_ITEMS) > 0) :?>
                <nav class="no-header__nav">
                    <div class="no-header__menu">
                        <ul class="no-header__menu--gnb">
                            <?php foreach ($MENU_ITEMS as $di => $depth) :
								// $depth_active = $depth['isActive'] ? 'active' : '';
							?>
                            <li>
                                <a href="<?= $depth['url'] ?>" data-content="<?= htmlspecialchars($depth['label']) ?>">
                                    <span class="poppins"><?= $depth['label'] ?></span>
                                </a>

                                <?php if (!empty($depth['children']) && count($depth['children']) > 1) : ?>
                                <ul class="no-header__menu--lnb">
                                    <?php foreach ($depth['children'] as $pi => $PAGE) :
												// $page_active = $PAGE['isActive'] ? 'active' : '';
											?>
                                    <li>
                                        <a href="<?= $PAGE['url'] ?>" class="poppins"><?= $PAGE['label'] ?></a>
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
            </div>
        </div>
        <button type="button" class="no-header-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    <aside id="sitemap" class="no-sitemap">
        <div class="no-container-2xl">
            <div class="no-sitemap__inner">
                <!-- HeaderNav -->
                <?php if (count($MENU_ITEMS) > 0) :?>
                <nav class="no-sitemap__nav">
                    <div class="no-sitemap__menu">
                        <ul class="no-sitemap__menu--gnb">
                            <?php foreach ($MENU_ITEMS as $di => $depth) :
								// $depth_active = $depth['isActive'] ? 'active' : '';
							?>
                            <li>
                                <a href="<?= $depth['url'] ?>" data-content="<?= htmlspecialchars($depth['label']) ?>">
                                    <span class="f-display-1"><?= $depth['label'] ?></span>
                                </a>
                                <?php if (!empty($depth['children']) && count($depth['children']) > 1) : ?>
                                <ul class="no-sitemap__menu--lnb">
                                    <?php foreach ($depth['children'] as $pi => $PAGE) :
												// $page_active = $PAGE['isActive'] ? 'active' : '';
											?>
                                    <li>
                                        <a href="<?= $PAGE['url'] ?>"
                                            class="f-heading-3 --regular"><?= $PAGE['label'] ?></a>
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
            </div>
        </div>
        <div class="no-sitemap__bg">
            <img src="<?= $bgImages['default'] ?>" alt="default">
            <img src="<?= $bgImages['about'] ?>" alt="about">
            <img src="<?= $bgImages['works'] ?>" alt="works">
            <img src="<?= $bgImages['news'] ?>" alt="news">
            <img src="<?= $bgImages['contact'] ?>" alt="contact">
        </div>

    </aside>
</header>