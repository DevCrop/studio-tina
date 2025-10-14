<?php
	include_once "../../../inc/lib/base.class.php";

    $pageName = "사이트맵 배경 관리";

    $depthnum = 9; 
    $pagenum = 0;

	include_once "../../inc/admin.title.php";
	include_once "../../inc/admin.css.php";
	include_once "../../inc/admin.js.php";
    include_once "../../Model/SitemapBgModel.php";

    // 사이트맵 배경 이미지 조회
    $sitemapBackgrounds = SitemapBgModel::getAllSitemapBackgrounds();
    
    // title별로 매핑
    $bgMap = [];
    foreach ($sitemapBackgrounds as $item) {
        $bgMap[$item['title']] = $item['bg_image'];
    }
    
    $SITEINFO_SITEMAP_BG_DEFAULT = $bgMap['default'] ?? '';
    $SITEINFO_SITEMAP_BG_ABOUT = $bgMap['about'] ?? '';
    $SITEINFO_SITEMAP_BG_WORKS = $bgMap['works'] ?? '';
    $SITEINFO_SITEMAP_BG_NEWS = $bgMap['news'] ?? '';
    $SITEINFO_SITEMAP_BG_CONTACT = $bgMap['contact'] ?? '';
?>
</head>

<body data-page="sitemap_bg">
    <div class="no-wrap">
        <!-- Header -->
        <?php 
        include_once "../../inc/admin.header.php";
        ?>

        <!-- Main -->
        <main class="no-app no-container">
            <!-- Drawer -->
            <?php
                include_once "../../inc/admin.drawer.php";
            ?>

            <!-- Contents -->
            <form id="frm" name="frm" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="mode" name="mode" value="">
                <section class="no-content">
                    <!-- Page Title -->
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title">사이트맵 배경 관리</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item">
                                            <span>사이트맵</span>
                                        </li>
                                        <li class="no-breadcrumb-item">
                                            <span>사이트맵 배경 관리</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- page indicator -->
                        </div>
                    </div>

                    <!-- card-title -->
                    <div class="no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header no-card-header--detail">
                                <h2 class="no-card-title">사이트맵 배경 이미지 설정</h2>
                            </div>
                            <div class="no-card-body no-admin-column no-admin-column--detail">
                                <!-- 기본 이미지 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">
                                        <label for="sitemap_bg_default">기본 배경 이미지</label>
                                    </h3>
                                    <div class="no-admin-content">
                                        <? if($SITEINFO_SITEMAP_BG_DEFAULT){?>
                                        <input type="hidden" id="sitemap_bg_default_filename"
                                            value="<?=$SITEINFO_SITEMAP_BG_DEFAULT?>">
                                        <div class="no-banner-image">
                                            <img src="/uploads/logo/<?=$SITEINFO_SITEMAP_BG_DEFAULT?>" alt="기본 배경"
                                                style="width: 400px" />
                                        </div>
                                        <? } ?>

                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fake_sitemap_bg_default"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="sitemap_bg_default" id="sitemap_bg_default"
                                                    accept="image/*"
                                                    onchange="document.getElementById('fake_sitemap_bg_default').value = this.value" />
                                                <button type="button" class="no-btn no-btn--main">
                                                    파일찾기
                                                </button>
                                            </div>
                                        </div>
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i>
                                            권장 이미지 사이즈: 1920 x 1080 픽셀 | 파일 크기: 1MB 이하
                                        </span>
                                    </div>
                                </div>
                                <!-- admin-block -->

                                <!-- About 이미지 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">
                                        <label for="sitemap_bg_about">About 배경 이미지</label>
                                    </h3>
                                    <div class="no-admin-content">
                                        <? if($SITEINFO_SITEMAP_BG_ABOUT){?>
                                        <input type="hidden" id="sitemap_bg_about_filename"
                                            value="<?=$SITEINFO_SITEMAP_BG_ABOUT?>">
                                        <div class="no-banner-image">
                                            <img src="/uploads/logo/<?=$SITEINFO_SITEMAP_BG_ABOUT?>" alt="About 배경"
                                                style="width: 400px" />
                                        </div>
                                        <? } ?>

                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fake_sitemap_bg_about"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="sitemap_bg_about" id="sitemap_bg_about"
                                                    accept="image/*"
                                                    onchange="document.getElementById('fake_sitemap_bg_about').value = this.value" />
                                                <button type="button" class="no-btn no-btn--main">
                                                    파일찾기
                                                </button>
                                            </div>
                                        </div>
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i>
                                            권장 이미지 사이즈: 1920 x 1080 픽셀 | 파일 크기: 1MB 이하
                                        </span>
                                    </div>
                                </div>
                                <!-- admin-block -->

                                <!-- Works 이미지 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">
                                        <label for="sitemap_bg_works">Works 배경 이미지</label>
                                    </h3>
                                    <div class="no-admin-content">
                                        <? if($SITEINFO_SITEMAP_BG_WORKS){?>
                                        <input type="hidden" id="sitemap_bg_works_filename"
                                            value="<?=$SITEINFO_SITEMAP_BG_WORKS?>">
                                        <div class="no-banner-image">
                                            <img src="/uploads/logo/<?=$SITEINFO_SITEMAP_BG_WORKS?>" alt="Works 배경"
                                                style="width: 400px" />
                                        </div>
                                        <? } ?>

                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fake_sitemap_bg_works"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="sitemap_bg_works" id="sitemap_bg_works"
                                                    accept="image/*"
                                                    onchange="document.getElementById('fake_sitemap_bg_works').value = this.value" />
                                                <button type="button" class="no-btn no-btn--main">
                                                    파일찾기
                                                </button>
                                            </div>
                                        </div>
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i>
                                            권장 이미지 사이즈: 1920 x 1080 픽셀 | 파일 크기: 1MB 이하
                                        </span>
                                    </div>
                                </div>
                                <!-- admin-block -->

                                <!-- News 이미지 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">
                                        <label for="sitemap_bg_news">News 배경 이미지</label>
                                    </h3>
                                    <div class="no-admin-content">
                                        <? if($SITEINFO_SITEMAP_BG_NEWS){?>
                                        <input type="hidden" id="sitemap_bg_news_filename"
                                            value="<?=$SITEINFO_SITEMAP_BG_NEWS?>">
                                        <div class="no-banner-image">
                                            <img src="/uploads/logo/<?=$SITEINFO_SITEMAP_BG_NEWS?>" alt="News 배경"
                                                style="width: 400px" />
                                        </div>
                                        <? } ?>

                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fake_sitemap_bg_news"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="sitemap_bg_news" id="sitemap_bg_news"
                                                    accept="image/*"
                                                    onchange="document.getElementById('fake_sitemap_bg_news').value = this.value" />
                                                <button type="button" class="no-btn no-btn--main">
                                                    파일찾기
                                                </button>
                                            </div>
                                        </div>
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i>
                                            권장 이미지 사이즈: 1920 x 1080 픽셀 | 파일 크기: 1MB 이하
                                        </span>
                                    </div>
                                </div>
                                <!-- admin-block -->

                                <!-- Contact 이미지 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">
                                        <label for="sitemap_bg_contact">Contact 배경 이미지</label>
                                    </h3>
                                    <div class="no-admin-content">
                                        <? if($SITEINFO_SITEMAP_BG_CONTACT){?>
                                        <input type="hidden" id="sitemap_bg_contact_filename"
                                            value="<?=$SITEINFO_SITEMAP_BG_CONTACT?>">
                                        <div class="no-banner-image">
                                            <img src="/uploads/logo/<?=$SITEINFO_SITEMAP_BG_CONTACT?>" alt="Contact 배경"
                                                style="width: 400px" />
                                        </div>
                                        <? } ?>

                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fake_sitemap_bg_contact"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="sitemap_bg_contact" id="sitemap_bg_contact"
                                                    accept="image/*"
                                                    onchange="document.getElementById('fake_sitemap_bg_contact').value = this.value" />
                                                <button type="button" class="no-btn no-btn--main">
                                                    파일찾기
                                                </button>
                                            </div>
                                        </div>
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i>
                                            권장 이미지 사이즈: 1920 x 1080 픽셀 | 파일 크기: 1MB 이하
                                        </span>
                                    </div>
                                </div>
                                <!-- admin-block -->

                                <div class="no-items-center center">
                                    <button type="button" id="submitBtn" class="no-btn no-btn--big no-btn--main">
                                        저장
                                    </button>
                                </div>
                                <!-- admin-block -->
                            </div>
                            <!-- card-body -->
                        </div>
                        <!-- card -->
                    </div>
                </section>
            </form>
        </main>

        <!-- Footer -->
        <?php
            include_once "../../inc/admin.footer.php";
        ?>

    </div>
</body>

</html>