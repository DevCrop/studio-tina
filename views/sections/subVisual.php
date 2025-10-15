<section class="no-sub-visual">
    <div class="no-sub-visual-txt">
        <div class="no-main-section-title">
            <?php if (!empty($category)): ?>
            <div class="text-reveal-container">
                <p class="f-heading-3 text-reveal-item"><?= $category ?></p>
            </div>
            <?php endif; ?>
            <?php if (!empty($title)): ?>
            <div class="text-reveal-container">
                <h2 class="f-display-3 text-reveal-item"><?= $title ?></h2>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <figure>
        <?php 
        $currentPath = $_SERVER['REQUEST_URI'];
        $isWorksPage = strpos($currentPath, '/works') !== false;
        ?>
        <?php if ($isWorksPage): ?>
        <video src="/resource/video/clarity-stream.mp4" autoplay loop muted playsinline></video>
        <?php else: ?>
        <video src="/resource/video/test_sub.mp4" autoplay loop muted playsinline></video>
        <?php endif; ?>
    </figure>
    <div class="no-sub-visual-bg">
        <img src="/resource/images/bg/gradient_bg.png" alt="">
    </div>
    <?= include_view('components.scrollLine') ?>
</section>