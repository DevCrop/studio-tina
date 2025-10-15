<div class="videomodal" class="modal">
    <div class="modal-content">
        <i class="fa-sharp fa-light fa-xmark videoclose" style="color: #ffffff;"></i>
        <div class="videocontainer"></div>
    </div>
</div>

<footer class="no-footer">
    <div class="container-xl">
        <ul class="no-footer__menu">
            <li class="f-wrap">
                <h2 class="no-footer__logo">
                    <a href="<?= ($HTML_LANG == 'en') ? '/en' : '/' ?>">
                        <img src="<?= $UPLOAD_SITEINFO_WDIR_LOGO ?>/<?= $SITEINFO_LOGO_FOOTER ?>"
                            alt="<?= $SITEINFO_TITLE ?>" />
                    </a>
                </h2>

                <?php 
					$arrBanner = getBanner("site_main",1,"data"); 
				?>
                <?php foreach($arrBanner as $k => $v) : 
					$link = "javascript:void(0);";
					  $target = "";
					  if($v['b_link']){
					   $link = $v['b_link'];
					   if($v['b_target'] == "_self")
						$target = "_self";
					   else if($v['b_target'] == "_blank")
						$target = "_blank";
					 }

					 $b_image = $UPLOAD_WDIR_BANNER."/".$v['b_img'];
				?>
                <a href="<?= $b_image ?>" class="f_down_wrap--item down_kr"
                    download="<?= ($HTML_LANG == 'en') ? 'Pltt_Company Introduction' : 'Pltt_Company Introduction' ?>"><i
                        class="fa-regular fa-file"
                        aria-hidden="true"></i><?= ($HTML_LANG == 'en') ? 'Company Profile' : '회사소개서' ?></a>
                <?php endforeach; ?>
            </li>
            <li>
                <?php if (count($MENU_ITEMS) > 0) : ?>
                <ul class="no-footer__menu--wrap">
                    <?php foreach ($MENU_ITEMS as $di => $depth) :
                            $depth_active = $depth['isActive'] ? 'active' : '';
                        ?>
                    <li>
                        <a href="<?= $depth['path'] ?>" class="<?= $depth_active ?> poppins"><?= $depth['title'] ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li>
        </ul>
        <div class="no-footer__center">
            <ul class="no-footer__info">
                <div class="flex-wrap">
                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Company Name' : '상호명' ?></b>
                        <p><?= $siteinfo['company_name'] ?? 'Studio Tina' ?></p>
                    </li>

                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Email' : '이메일' ?></b>
                        <p><?= $siteinfo['contact_email'] ?? 'tina@studiotina.co.kr' ?></p>
                    </li>
                </div>

                <div class="flex-wrap">
                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Phone' : '전화번호' ?></b>
                        <p><?= $siteinfo['contact_phone'] ?? '+82 2 517 8080' ?></p>
                    </li>

                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Ceo' : '대표자' ?></b>
                        <p><?= $siteinfo['ceo_name'] ?? 'Tina' ?></p>
                    </li>

                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'SSN' : '사업자등록번호' ?></b>
                        <p><?= $siteinfo['business_number'] ?? '' ?></p>
                    </li>
                </div>
            </ul>
            <div class="sns-group">
                <img src="<?=IMG_PATH?>/award-logo.svg" alt="" class="award">

                <div class="inner-group">
                    <a href="https://www.youtube.com/@pltt_official" target="_blank"><img
                            src="/resource/images/icon/youtube.svg"></a>
                    <a href="<?=$SITEINFO_HP?>" target="_blank"><img src="/resource/images/icon/naver.svg"></a>
                    <a href="<?=$SITEINFO_PHONE?>" target="_blank"><img src="/resource/images/icon/insta.svg"></a>
                    <a href="<?=$SITEINFO_CUSTOMER_CENTER_ABLE_TIME?>" target="_blank"><img
                            src="/resource/images/icon/linked.svg"></a>
                </div>
            </div>
        </div>
        <ul class="no-footer__address">
            <li>
                <b><?= ($HTML_LANG == 'en') ? 'Head Office' : '본사' ?></b>
                <p><?= $siteinfo['address'] ?? '서울시 강남구 강남대로 636 두원빌딩 6층' ?></p>
            </li>

            <li>
                <b><?= ($HTML_LANG == 'en') ? 'Fax' : '팩스' ?></b>
                <p><?= $siteinfo['contact_fax'] ?? '+82 2 517 8080' ?></p>
            </li>
        </ul>
        <ul class="no-footer__bottom">
            <div class="flex-wrap">
                <a
                    href="<?= ($HTML_LANG == 'en') ? '/en/pages/policy/policy.php' : '/pages/policy/policy.php' ?>"><?= ($HTML_LANG == 'en') ? 'Privacy Policy' : '개인정보처리방침' ?></a>
            </div>

            <address>&copy; <?= $siteinfo['company_name'] ?? 'Studio Tina' ?> All rights reserved.</address>
        </ul>
    </div>
</footer>

</body>

</html>