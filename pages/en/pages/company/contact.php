<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<script src="<?= $ROOT ?>/resource/js/sub-contact.js" <?= date('YmdHis') ?> defer></script>
<script src="<?= $ROOT ?>/resource/js/inquiry.js" <?= date('YmdHis') ?> defer></script>

<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<!-- contents -->

<main>
    <section class="sub-contact">
        <div class="container-xl">
            <h2 class="sub-h2 poppins">Contact</h2>

            <article class="no-article">
                <div class="flex-wrap">
                    <div class="left" <?= $aos_slow_delay ?>>
                        <div class="txt">
                            <h3 class="sub-h2">Have a question for Palette?</h3>
                            <p>If you have any inquiries, please leave us a message.<br>We will respond promptly.</p>
                        </div>

                        <ul class="contactinfo">
                            <li>
                                <h4 class="poppins">Address</h4>
                                <p><a href="#" target="_blank">4F, Hoban Park II, 18,<br> Yangjaedaero 2-gil, Seocho-gu,<br> Seoul, Republic of Korea</a></p>
                            </li>

                            <li>
                                <h4 class="poppins">Email</h4>
                                <p><a href="mailto:hello@pltt.xyz" target="_blank"><?=$SITEINFO_FOOTER_EMAIL?></a></p>
                            </li>

                            <li>
                                <h4 class="poppins">Phone</h4>
                                <p><a href="tel:<?=$SITEINFO_FOOTER_PHONE?>" target="_blank"><?=$SITEINFO_FOOTER_PHONE?></a></p>
                            </li>
                        </ul>
                    </div>

                    <div class="right" <?= $aos_slow_delay ?>>
                        <form id="frm" name="frm" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <ul>
                                    <li>
                                        <ul class="dept2">
                                            <li>
                                                <h3>Name<span></span></h3>
                                                <input type="text" name="name" id="name" required placeholder="Enter your name.">
                                            </li>

                                            <li>
                                                <h3>Company Name<span></span></h3>
                                                <input type="text" name="company" id="company" required placeholder="Enter your company name.">
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <ul class="dept2">
                                            <li>
                                                <h3>Email<span></span></h3>
                                                <input type="text" name="email" id="email" required placeholder="Enter your email address.">
                                            </li>

                                            <li>
                                                <h3>Phone<span></span></h3>
                                                <input type="text" name="phone" id="phone" required placeholder="Enter your phone number.">
                                            </li>
                                        </ul>
                                    </li>

									<li>
                                        <ul class="dept2 all">
                                            <li>
                                                <h3>Budget<span></span></h3>
                                                <select name="budget" id="budget">
													<option value="" disabled="" selected="">Please select your budget</option>
													<option value="1천만원 이하">Below 10 million KRW</option>
													<option value="1~3천만원">10–30 million KRW</option>
													<option value="3~7천만원">30–70 million KRW</option>
													<option value="7천만원 이상">Over 70 million KRW</option>
													<option value="Undecided">Undecided</option>
												</select>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <ul class="text">
                                            <h3>Details<span></span></h3>
                                            <textarea placeholder="Enter your message." name="contents" id="contents"></textarea>
                                        </ul>
                                    </li>

                                    <li>
                                        <ul class="dept2">
                                            <li class="file">
                                                <h3>Attachment</h3>
                                                <div class="file-wrap">
                                                    <input type="text" placeholder="Please upload an attachment." class="upload-name" readonly>
                                                    <label for="file1" class="file_btn">Upload File <i class="fa-light fa-arrow-up-from-bracket" style="color: rgba(255, 255, 255, .75);"></i></label>
                                                    <input type="file" id="file1" name="file1">
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <div class="no-captcha">
                                            <div class="no-captcha__box">
                                                <div class="no-captcha__img">
                                                    <img src="/inc/lib/captcha.n.php" alt="captcha">
                                                </div>
                                                <input type="text" name="r_captcha" id="r_captcha" maxlength="5" placeholder="Enter the 5 characters to verify." autocomplete="off">
                                            </div>
                                        </div>
                                    </li>

                                    <div class="check-wrap en">
                                        <figure>
                                            <input type="checkbox" name="check" id="check" class="check">
                                            <label for="check"></label>
                                            <label for="check">I agree to the collection and use of personal information (Required)</label>

                                            <a href="#" class="policy" onclick="return false">[View]</a>
                                        </figure>
                                    </div>
                                </ul>

                                <button type="button" onclick="doRequest();" class="submit">
                                    <a href="#" onclick="return false">
                                        <p class="poppins">SUBMIT</p>
                                    </a>
                                </button>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </article>
        </div>
    </section>
</main>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    if (window.location.pathname === "/pages/company/contact.php") { 
        if (window.wcs) {
            var _conv = {};
            _conv.type = 'custom001'; // 사용자 정의 전환 001번
            wcs.trans(_conv);
        }
    }
});
</script>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>