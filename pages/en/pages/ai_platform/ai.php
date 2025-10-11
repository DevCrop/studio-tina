<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<script src="<?= $ROOT ?>/resource/js/sub-hub.js" <?= date('YmdHis') ?> defer></script>
<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<!-- contents -->

<main class="sub-hub">
<h1 style="position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">
Video-centric workflow management, optimized team collaboration, enhanced client connection, real-time streaming feedback, customized workflows, easy file sharing, partner invitations
</h1>
<h2 style="position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">
Efficiently manage every step from planning to post-production
</h2>

    <section class="hub-headline hub-headline-new ">
        <figure class="back-bg" style="background-image: url('/resource/images/new-ai-bg.jpg');">
        </figure>
        <div class="container-xl">
            <hgroup class="reveal">
                <span class="letter">
                    <h2>How We Color Tech<br class="m-br"> with AI</h2>
                    <p>Easy and simple bring your stories to life with AI-powered video creation
                    </p>
                </span>
            </hgroup>
            <img src="/resource/images/new-ai-center.png" class="visual-img" <?= $aos_slow_delay ?>>
        </div>
    </section>

    <section class="hub-effect">
        <div class="container-xl">
            <h2 class="sub-h2" <?= $aos_slow ?>>Key Benefits</h2>

            <article class="no-article">
                <ul class="effect-list">
                    <li>
                        <div class="txt">
                            <h3>End-to-end automation</h3>
                            <p>Just enter a topic AI takes care of everything from storyboard to final video.</p>
                        </div>
                        <img src="/resource/images/ai-effect1.svg">
                    </li>

                    <li>
                        <div class="txt">
                            <h3>Cost-efficient production</h3>
                            <p>Cut down on time and budget with smart templates and AI-driven workflows.</p>
                        </div>
                        <img src="/resource/images/ai-effect2.svg">
                    </li>

                    <li>
                        <div class="txt">
                            <h3>Global-ready content</h3>
                            <p>Easily produce localized videos with multi-style and multi-language support.</p>
                        </div>
                        <img src="/resource/images/ai-effect3.svg">
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <section class="hub-function">
        <div class="container-bl">
            <h2 class="sub-h2" <?= $aos_slow ?>>Features</h2>

            <article class="no-article">
                <ul class="function-list function-list-new">
                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_1.png">
                        </figure>
                        <div class="txt">
							<div>
								<h3>One-Click Video Creation</h3>
							</div>
                            <p>Create a video from scratch, input a simple topic or image, and AI will create a storyboard and produce the video all at once.
                            </p>
                        </div>

                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_2.png">
                        </figure>

                        <div class="txt">
							<div>
								<h3>News Article Video Production</h3>
							</div>
                            <p>Just attach a link to a news article and the AI ​​will summarize the article and automatically create a short, impactful video.
                            </p>
                        </div>
                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_3.png">
                        </figure>

                        <div class="txt">
							<div>
								<h3>Template-based production<br>
								Magic Create
								</h3>
							</div>
                            <p>Anyone can easily create the video they want using the provided templates. Save time with templates optimized for various industries and purposes such as real estate, marketing, and event promotion.</p>
                        </div>
                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_4.png">
                        </figure>

                        <div class="txt">
							<div>
								<h3>Detailed customization</h3>
							</div>
                            <p>You can freely edit everything from adding scenes to modifying subtitles, video style, and background music to complete the video in the way you want.
                            </p>
                        </div>
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <?php include_once $STATIC_ROOT . '/inc/layouts/gocontact.php'; ?>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>