<?php 
    $MENU_ITEMS = app()->get('menu')->toArray();
    $HTML_LANG = app()->getLocale();
    
    $siteinfo = app()->get('siteinfo');
?>


<footer class="no-footer">
    <button type="button" class="no-footer-top-btn" id="scrollToTop" aria-label="Scroll to top">
        <i class="fa-regular fa-arrow-up"></i>
    </button>
    <div class="no-container-2xl">
        <div class="no-footer-top">
            <div class="no-footer-top__left">
                <h2 class="no-footer-logo">
                    <a href="/">
                        <img src="/resource/images/logo/LOGO_WHITE.svg" alt="Studio Tina" />
                    </a>
                </h2>
                <div class="no-footer-info">
                    <ul>
                        <li>
                            <span>회사명</span>
                            <p>스튜디오 티나</p>
                        </li>
                        <li>
                            <span>대표자</span>
                            <p>김태현</p>
                        </li>
                        <li>
                            <span>이메일</span>
                            <p>tina@studiotina.co.kr</p>
                        </li>
                        <li>
                            <span>전화번호</span>
                            <p>02-517-8080</p>
                        </li>
                        <li>
                            <span>주소</span>
                            <p>서울시 강남구 강남대로 636 두원빌딩 6층</p>
                        </li>
                        <li>
                            <span>팩스</span>
                            <p>02-543-8080</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="no-footer-top__right">
                <div class="no-footer-menu">
                    <ul>
                        <?php if (count($MENU_ITEMS) > 0) : ?>

                        <?php foreach ($MENU_ITEMS as $di => $depth) :
                        ?>
                        <li>
                            <a href="<?= $depth['url'] ?>" class=" poppins"><?= $depth['label'] ?></a>

                            <?php if (!empty($depth['children']) && count($depth['children']) > 1) : ?>
                            <ul class="no-footer-menu--lnb">
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
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="no-footer-social">
                    <ul>
                        <li>
                            <a href="https://youtube.com">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://facebook.com">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="no-footer-bottom">
            <address>
                &copy; 2025 Studio Tina. All rights reserved.
            </address>
            <a href="/privacy" class="no-footer-privacy-link">개인정보처리방침</a>
        </div>
    </div>
</footer>

</body>

</html>