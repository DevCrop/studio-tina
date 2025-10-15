<?php section('seo_title', __('home.seo_title')) ?>
<?php section('seo_desc', __('home.seo_desc')) ?>
<?php section('seo_keywords', __('home.seo_keywords')) ?>

<?php section('content') ?>

<h1 style=" position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0); color: #fff;">
    <?= __('main.title') ?>
</h1>
<h2 style=" position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0);">
    <?= __('main.sub_title') ?>
</h2>

<section class="no-main-intro" id="mainIntro">
    <div class="no-main-intro-wrap">
        <h2 class="no-main-intro-text f-display-1" id="typingText"></h2>
        <button type="button" class="no-main-intro-skip f-body-2" id="skipIntro">
            Skip
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>
    <div class="no-main-intro-bg">
        <img src="/resource/images/bg/intro_gradient_bg.png" alt="">
    </div>
</section>

<section class="no-main-visual">
    <div class="no-main-visual-swiper">
        <ul class="swiper-wrapper">

            <?php if (!empty($banners)): ?>
            <?php foreach ($banners as $banner): 
                $file_ext = strtolower(pathinfo($banner['banner_image'], PATHINFO_EXTENSION));
                $is_video = in_array($file_ext, ['mp4', 'webm', 'ogg']);
            ?>
            <li class="swiper-slide">
                <article>
                    <?php if ($is_video): ?>
                    <video autoplay loop muted preload="auto" playsinline>
                        <source src="/uploads/banners/<?= htmlspecialchars($banner['banner_image']) ?>"
                            type="video/<?= $file_ext ?>">
                    </video>
                    <?php else: ?>
                    <img src="/uploads/banners/<?= htmlspecialchars($banner['banner_image']) ?>"
                        alt="<?= htmlspecialchars($banner['description'] ?? 'Studio Tina') ?>">
                    <?php endif; ?>
                </article>
                <div class="no-main-visual-txt">
                    <h2 class="f-display-1">STUDIO TINA</h2>
                </div>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <div class="no-main-visual-controls">
            <div>

                <div class="swiper-pagination-wrap">
                    <div class="swiper-pagination"></div>
                    <div class="no-main-visual-btn-wrap">
                        <button type="button" class="no-main-visual-btn-prev" aria-label="Previous slide">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button type="button" class="no-main-visual-btn-next" aria-label="Next slide">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="no-main-visual-pagination">
                    <div class="no-main-visual-progress">
                        <div class="no-main-visual-progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= include_view('components.scrollLine') ?>
</section>

<section class="no-main-spiral-gallery no-section-md">
    <div class="no-container-2xl">
        <article>
            <div class="no-main-section-title">
                <div class="text-reveal-container">
                    <span class="clr-primary-def f-heading-3 text-reveal-item">PORTFOLIO</span>
                </div>
                <div class="text-reveal-container">
                    <h2 class="f-display-2">
                        <span class="text-reveal-item">Our</span>
                        <span class="text-reveal-item">Crafted</span>
                        <span class="text-reveal-item">Scenes</span>
                    </h2>
                </div>
            </div>
            <div class="--cnt">
                <div id="spiral-gallery-container" class="container">
                </div>
            </div>
            <div class="no-main-spiral-gallery-btn">
                <a href="/works" class="no-btn-cta">
                    <p>View More</p>
                    <div>
                        <i class="fa-regular fa-arrow-right-long" aria-hidden="true"></i>
                    </div>
                </a>
            </div>
        </article>
    </div>
    <div class="no-main-spiral-gallery-bg">
        <img src="/resource/images/bg/gallery_bg.png" alt="">
    </div>
</section>


<section class="no-main-about">
    <div class="no-main-about__inner">
        <div class="no-main-about-txt">
            <div class="txt-reveal-item">
                <h3 class="f-display-4 txt-base">스튜디오 티나는 AI 기반 영상·콘텐츠 제작사로,<br>기술을 인간 중심 창작에 접목해<br>효율성과 예술성을 동시에
                    실현합니다.</h3>
                <h3 class="f-display-4 txt-overlay">스튜디오 티나는 AI 기반 영상·콘텐츠 제작사로,<br>기술을 인간 중심 창작에 접목해<br>효율성과 예술성을 동시에
                    실현합니다.</h3>
            </div>
            <div class="txt-reveal-item">
                <h3 class="f-display-4 txt-base">우리는 This Is Not AI라는 철학 아래,<br>AI를 도구로 활용하여</h3>
                <h3 class="f-display-4 txt-overlay">우리는 This Is Not AI라는 철학 아래,<br>AI를 도구로 활용하여</h3>
            </div>
            <div class="txt-reveal-item">
                <h3 class="f-display-4 txt-base">진짜 감정과 서사를 담은<br>차별화된 콘텐츠를 만들어냅니다.</h3>
                <h3 class="f-display-4 txt-overlay">진짜 감정과 서사를 담은<br>차별화된 콘텐츠를 만들어냅니다.</h3>
            </div>
        </div>
        <div class="no-main-about-img">
            <?php for ($i = 1; $i <= 7; $i++): ?>
            <img class="image" src="/resource/images/main/main_about_img_<?=$i?>.jpg" alt="">
            <?php endfor; ?>
        </div>
        <div class="no-main-about-bg">
            <img src="/resource/images/main/main_about_bg.jpg" alt="">
        </div>
    </div>

</section>



<section class="no-main-news no-section-md">
    <div class="no-container-2xl">
        <article>
            <div class="no-main-section-title">
                <div class="text-reveal-container">
                    <h2 class="f-display-2 text-reveal-item">News</h2>
                </div>
                <a href="/news" class="no-btn-cta">
                    <p>View More</p>
                    <div>
                        <i class="fa-regular fa-arrow-right-long"></i>
                    </div>
                </a>
            </div>

            <div class="--cnt">
                <ul>
                    <?php if (!empty($newsList)): ?>
                    <?php foreach ($newsList as $news): ?>
                    <li class="fade-up">
                        <a href="/news/show/<?= $news['no'] ?>">

                            <h3 class="f-heading-3 --semibold"><?= htmlspecialchars($news['title']) ?></h3>
                            <time datetime="<?= date('Y-m-d', strtotime($news['regdate'])) ?>" class="">
                                <?= date('Y.m.d', strtotime($news['regdate'])) ?>
                            </time>
                            <?php if (!empty($news['thumb_image'])): ?>
                            <figure>
                                <img src="/uploads/board/<?= $news['thumb_image'] ?>"
                                    alt="<?= htmlspecialchars($news['title']) ?>">
                            </figure>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <li class="no-data">
                        <p>등록된 뉴스가 없습니다.</p>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </article>
    </div>
</section>

<section class="no-main-partners no-section-md">
    <div class="no-container-2xl">
        <article>
            <div class="no-main-section-title">
                <div class="text-reveal-container">
                    <span class="clr-primary-def f-heading-3 text-reveal-item">PARTNERS</span>
                </div>
                <div class="text-reveal-container">
                    <h2 class="f-display-2">
                        <span class="text-reveal-item">Creative</span>
                        <span class="text-reveal-item">Partners</span>
                    </h2>
                </div>
            </div>
        </article>
    </div>
    <div class="--cnt">
        <div class="no-marquee" wb-data="marquee-logo" duration="120" direction="left">
            <div class="no-marquee__content">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                <div class="no-marquee__item">
                    <figure>
                        <img src="/resource/images/logo/partners_logo_<?=$i?>.png" alt="Partner Logo <?=$i?>">
                    </figure>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="no-marquee" wb-data="marquee-logo" duration="120" direction="right">
            <div class="no-marquee__content">
                <?php for ($i = 13; $i <= 23; $i++): ?>
                <div class="no-marquee__item">
                    <figure>
                        <img src="/resource/images/logo/partners_logo_<?=$i?>.png" alt="Partner Logo <?=$i?>">
                    </figure>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<?= include_view('sections.contact') ?>

<?php end_section() ?>


<?php section('portal') ?>
<?php include_view('components.popup'); ?>
<?php end_section() ?>

<?php section('script') ?>
<script src="/resource/js/intro-typing.js?v=<?= date('YmdHis') ?>"></script>
<script src="/resource/js/spiral-gallery.js?v=<?= date('YmdHis') ?>"></script>
<?php end_section() ?>