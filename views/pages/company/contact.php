<?php 
    $siteinfo = app()->get('siteinfo');
?>

<?php section('content') ?>
<section class="sub-contact">
    <div class="container-xl">
        <h2 class="sub-h2 poppins">Contact</h2>

        <article class="no-article">
            <div class="flex-wrap">
                <div class="left" <?= $aos_slow_delay ?>>
                    <div class="txt">
                        <h3 class="sub-h2"><?= __('contact.title') ?></h3>
                        <p><?= __('contact.desc') ?></p>
                    </div>

                    <ul class="contactinfo">
                        <li>
                            <h4 class="poppins">Address</h4>
                            <p><a href="#" target="_blank"><?=__('footer.head_office')?></a></p>
                        </li>

                        <li>
                            <h4 class="poppins">Email</h4>
                            <p><a href="mailto:hello@pltt.xyz" target="_blank"><?=__('footer.email')?></a></p>
                        </li>

                        <li>
                            <h4 class="poppins">Phone</h4>
                            <p><a href="tel:<?=__('footer.tel')?>" target="_blank"><?=__('footer.tel')?></a></p>
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
                                            <h3><?= __('contact.fields.name.label') ?><span></span></h3>
                                            <input type="text" name="name" id="name" required
                                                placeholder="<?= __('contact.fields.name.placeholder') ?>">
                                        </li>

                                        <li>
                                            <h3><?= __('contact.fields.company.label') ?><span></span></h3>
                                            <input type="text" name="company" id="company" required
                                                placeholder="<?= __('contact.fields.company.placeholder') ?>">
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <ul class="dept2">
                                        <li>
                                            <h3><?= __('contact.fields.email.label') ?><span></span></h3>
                                            <input type="text" name="email" id="email" required
                                                placeholder="<?= __('contact.fields.email.placeholder') ?>">
                                        </li>

                                        <li>
                                            <h3><?= __('contact.fields.phone.label') ?><span></span></h3>
                                            <input type="text" name="phone" id="phone" required
                                                placeholder="<?= __('contact.fields.phone.placeholder') ?>">
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <ul class="dept2 all">
                                        <li>
                                            <h3><?= __('contact.fields.budget.label') ?><span></span></h3>
                                            <select name="budget" id="budget" required>
                                                <option value="" disabled selected>
                                                    <?= __('contact.fields.budget.placeholder') ?>
                                                </option>
                                                <option value="under_10m"><?= __('contact.fields.budget.options.under_10m') ?></option>
                                                <option value="1_3"><?= __('contact.fields.budget.options.1_3') ?></option>
                                                <option value="3_7"><?= __('contact.fields.budget.options.3_7') ?></option>
                                                <option value="over_7"><?= __('contact.fields.budget.options.over_7') ?></option>
                                                <option value="tbd"><?= __('contact.fields.budget.options.tbd') ?></option>
                                            </select>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <ul class="text">
                                        <h3><?= __('contact.fields.details.label') ?><span></span></h3>
                                        <textarea name="contents" id="contents"
                                                placeholder="<?= __('contact.fields.details.placeholder') ?>"></textarea>
                                    </ul>
                                </li>

                                <li>
                                    <ul class="dept2">
                                        <li class="file">
                                            <h3><?= __('contact.fields.attachment.label') ?></h3>
                                            <div class="file-wrap">
                                                <input type="text" class="upload-name" readonly
                                                    placeholder="<?= __('contact.fields.attachment.placeholder') ?>">
                                                <label for="file1" class="file_btn">
                                                    <?= __('contact.fields.attachment.button') ?>
                                                    <i class="fa-light fa-arrow-up-from-bracket" style="color: rgba(255, 255, 255, .75);"></i>
                                                </label>
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
                                            <input type="text" name="r_captcha" id="r_captcha" maxlength="5" autocomplete="off"
                                                placeholder="<?= __('contact.fields.captcha.placeholder') ?>">
                                        </div>
                                    </div>
                                </li>

                                <div class="check-wrap">
                                    <figure>
                                        <input type="checkbox" name="check" id="check" class="check" required>
                                        <label for="check"></label>
                                        <label for="check"><?= __('contact.fields.consent.label') ?></label>
                                        <a href="#" class="policy" onclick="return false">[<?= __('contact.fields.consent.view') ?>]</a>
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
<?php end_section() ?>

<?php section('script') ?>

<script src="/resource/js/sub-contact.js" <?= date('YmdHis') ?> defer></script>
<script src="/resource/js/inquiry.js" <?= date('YmdHis') ?> defer></script>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    if (window.wcs) {
        var _conv = {};
        _conv.type = 'custom001';
        wcs.trans(_conv);
    }
});
</script>
<?php end_section() ?>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>