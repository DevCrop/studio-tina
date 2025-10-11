<?php section('seo_title', __('ai_platform.ai.seo.title')) ?>
<?php section('seo_desc', __('ai_platform.ai.seo.desc')) ?>
<?php section('seo_keywords', __('ai_platform.ai.seo.keywords')) ?>
<?php section('main_class','sub-hub') ?>

<?php section('content') ?>
    <h1 class="sr-only"><?= __('ai_platform.ai.seo.h1') ?></h1>
    <h2 class="sr-only"><?= __('ai_platform.ai.seo.h2') ?></h2>

    <section class="hub-headline hub-headline-new">
        <figure class="back-bg" style="background-image: url('/resource/images/new-ai-bg.jpg');"></figure>
        <div class="container-xl">
            <hgroup class="reveal">
                <span class="letter">
                    <h2><?= __('ai_platform.ai.hero.title') ?></h2>
                    <p><?= __('ai_platform.ai.hero.subtitle') ?></p>
                </span>
            </hgroup>
            <img src="/resource/images/new-ai-center.png" class="visual-img" <?= AOS_SLOW_DELAY ?>>
        </div>
    </section>

    <section class="hub-effect">
        <div class="container-xl">
            <h2 class="sub-h2" <?= AOS_SLOW ?>><?= __('ai_platform.ai.benefit.title') ?></h2>

            <article class="no-article">
                <ul class="effect-list">
                    <li>
                        <div class="txt">
                            <h3><?= __('ai_platform.ai.benefit.items.0.title') ?></h3>
                            <p><?= __('ai_platform.ai.benefit.items.0.desc') ?></p>
                        </div>
                        <img src="/resource/images/ai-effect1.svg" alt="">
                    </li>

                    <li>
                        <div class="txt">
                            <h3><?= __('ai_platform.ai.benefit.items.1.title') ?></h3>
                            <p><?= __('ai_platform.ai.benefit.items.1.desc') ?></p>
                        </div>
                        <img src="/resource/images/ai-effect2.svg" alt="">
                    </li>

                    <li>
                        <div class="txt">
                            <h3><?= __('ai_platform.ai.benefit.items.2.title') ?></h3>
                            <p><?= __('ai_platform.ai.benefit.items.2.desc') ?></p>
                        </div>
                        <img src="/resource/images/ai-effect3.svg" alt="">
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <section class="hub-function">
        <div class="container-bl">
            <h2 class="sub-h2" <?= AOS_SLOW ?>><?= __('ai_platform.ai.feature.title') ?></h2>

            <article class="no-article">
                <ul class="function-list function-list-new">
                    <li <?= AOS_SLOW ?>>
                        <figure><img src="/resource/images/new/ai_new_img_1.png" alt=""></figure>
                        <div class="txt">
                            <div>
                                <span class="fjalla"><?= __('ai_platform.ai.feature.items.0.eyebrow') ?></span>
                                <h3><?= __('ai_platform.ai.feature.items.0.title') ?></h3>
                            </div>
                            <p><?= __('ai_platform.ai.feature.items.0.desc') ?></p>
                        </div>
                    </li>

                    <li <?= AOS_SLOW ?>>
                        <figure><img src="/resource/images/new/ai_new_img_2.png" alt=""></figure>
                        <div class="txt">
                            <div>
                                <span class="fjalla"><?= __('ai_platform.ai.feature.items.1.eyebrow') ?></span>
                                <h3><?= __('ai_platform.ai.feature.items.1.title') ?></h3>
                            </div>
                            <p><?= __('ai_platform.ai.feature.items.1.desc') ?></p>
                        </div>
                    </li>

                    <li <?= AOS_SLOW ?>>
                        <figure><img src="/resource/images/new/ai_new_img_3.png" alt=""></figure>
                        <div class="txt">
                            <div>
                                <span class="fjalla"><?= __('ai_platform.ai.feature.items.2.eyebrow') ?></span>
                                <h3><?= __('ai_platform.ai.feature.items.2.title') ?></h3>
                            </div>
                            <p><?= __('ai_platform.ai.feature.items.2.desc') ?></p>
                        </div>
                    </li>

                    <li <?= AOS_SLOW ?>>
                        <figure><img src="/resource/images/new/ai_new_img_4.png" alt=""></figure>
                        <div class="txt">
                            <div>
                                <span class="fjalla"><?= __('ai_platform.ai.feature.items.3.eyebrow') ?></span>
                                <h3><?= __('ai_platform.ai.feature.items.3.title') ?></h3>
                            </div>
                            <p><?= __('ai_platform.ai.feature.items.3.desc') ?></p>
                        </div>
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <?= include_view('sections.contact', [
        'sub_title' => __('main.contact_desc'),
        'rolling'   => false,
    ]) ?>
<?php end_section() ?>
