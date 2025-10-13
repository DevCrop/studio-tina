<section class="no-sub-visual">
    <div class="no-sub-visual-txt">
        <?php if (!empty($category)): ?>
        <p class="f-heading-3"><?= $category ?></p>
        <?php endif; ?>
        <?php if (!empty($title)): ?>
        <h2 class="f-display-3"><?= $title ?></h2>
        <?php endif; ?>
    </div>
    <figure>
        <video src="/resource/video/sub-visual.mp4" autoplay loop muted playsinline></video>
    </figure>
    <div class="no-sub-visual-bg"></div>
    <?= include_view('components.scrollLine') ?>
</section>