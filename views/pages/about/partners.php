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

<?= include_view('sections.subVisual', [
        'category' => 'ABOUT US',
        'title' => 'PARTNERS',
    ]) ?>

<section class="no-sub-about-partners no-section-md">
    <div class="no-container-2xl">
        <div class="no-sub-section-title --tac">
            <div class="no-main-section-title">
                <div class="text-reveal-container">
                    <h2 class="f-display-2 text-reveal-item">Our Partners</h2>
                </div>
            </div>
        </div>
        <div class="--cnt">
            <ul>
                <?php for ($i = 1; $i < 24; $i++): ?>
                <li class="fade-up">
                    <figure>
                        <img src="/resource/images/logo/partners_logo_<?= $i ?>.png" alt="Partner <?= $i ?>">
                    </figure>
                </li>
                <?php endfor; ?>
            </ul>
        </div>
        <div class="no-sub-about-partners-inner">
            <div class="no-sub-about-partners-content">
            </div>
        </div>
    </div>

</section>

<?= include_view('sections.contact') ?>

<?php end_section() ?>

<?php section('script') ?>



<?php end_section() ?>