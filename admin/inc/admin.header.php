<?php
include_once $_SERVER['DOCUMENT_ROOT'] . $NO_IS_SUBDIR . '/admin/lib/admin.check.php';
?>

<header class="no-header">
    <div class="no-header__inner">
        <div class="no-drawer-btn">
            <button aria-label="Open navigation drawer">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div class="no-header-menu">
            <span class="no-header-menu-btn">
                <i class="bx bxs-user-pin"></i>
            </span>
            <ul class="no-nav-list">
                <!-- <li class="no-nav-item">
                <a href="#" class="no-nav-link">
                <span class="no-menu-icon sm">
                    <i class="bx bx-book"></i>
                </span>
                <span class="no-menu-title">메뉴얼 안내</span>
                </a>
            </li>
            <li class="no-nav-item">
                <a href="#" class="no-nav-link">
                <span class="no-menu-icon sm">
                    <i class="bx bx-pie-chart-alt-2"></i>
                </span>
                <span class="no-menu-title">최적화 안내</span>
                </a>
            </li> -->
                <li class="no-nav-item">
                    <a href="<?= $NO_IS_SUBDIR ?>/index.php" target="_blank" class="no-nav-link">
                        <span class="no-menu-icon sm">
                            <i class="bx bx-home"></i>
                        </span>
                        <span class="no-menu-title">내홈페이지</span>
                    </a>
                </li>
                <? if ($_SESSION['no_adm_login_uid']) { ?>
                    <li class="no-nav-item">
                        <a href="<?= $NO_IS_SUBDIR ?>/admin/lib/login/logout.php" class="no-nav-link">
                            <span class="no-menu-icon sm">
                                <i class="bx bx-log-out"></i>
                            </span>
                            <span class="no-menu-title">로그아웃</span>
                        </a>
                    </li>
                <? } ?>
                <li class="no-nav-item">
                    <div class="no-nav-text">
                        <span class="no-bullet--status blink"></span>
                        <span class="no-menu-icon sm">
                            <i class="bx bx-user"></i>
                        </span>
                        <span class="no-menu-title"> 로그인중</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>