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
        'title' => 'COMPANY',
    ]) ?>




<section class="no-sub-about-company no-section-md">
    <div class="no-container-2xl">
        <div class="no-sub-section-title --tac">
            <h2 class="f-display-2">Who We Are</h2>
            <p class="f-heading-4 --medium">
                스튜디오 티나는 AI 기술을 활용해<br>
                드라마·영화·숏폼 등 영상 콘텐츠를 기획·제작하는<br>
                AI 크리에이티브 스튜디오입니다.
            </p>
            <span class="f-body-1 --regular">
                국내외 방송사 및 OTT 플랫폼과의 협업 경험, 전문 창작자 네트워크, 실제 상용화 사례를 기반으로 <br>
                AI영상 산업의 새로운 기준을 제시하며, 글로벌 콘텐츠 시장을 선도해 나가고 있습니다.
            </span>
        </div>
    </div>
</section>




<section class="no-sub-about-snap no-section-md">
    <ul class="no-sub-about-snap-list">
        <!-- 스냅샷 리스트 -->
        <li class="no-sub-about-snap-item" data-direction="left">
            <div class="no-sub-about-snap-item-wrap">
                <?php for ($i = 1; $i <= 15; $i++) : ?>
                <div class="no-sub-about-snap-item-inner">
                    <figure>
                        <img src="/resource/images/snap/sub_snap_img_<?= $i ?>.png" alt="">
                    </figure>
                </div>
                <?php endfor; ?>
            </div>
        </li>
        <!-- 스냅샷 리스트 -->
        <li class="no-sub-about-snap-item" data-direction="right">
            <div class="no-sub-about-snap-item-wrap">
                <?php for ($i = 1; $i <= 15; $i++) : ?>
                <div class="no-sub-about-snap-item-inner">
                    <figure>
                        <img src="/resource/images/snap/sub_snap_img_<?= $i ?>.png" alt="">
                    </figure>
                </div>
                <?php endfor; ?>
            </div>
        </li>
        <!-- 스냅샷 리스트 -->
        <li class="no-sub-about-snap-item" data-direction="left">
            <div class="no-sub-about-snap-item-wrap">
                <?php for ($i = 1; $i <= 15; $i++) : ?>
                <div class="no-sub-about-snap-item-inner">
                    <figure>
                        <img src="/resource/images/snap/sub_snap_img_<?= $i ?>.png" alt="">
                    </figure>
                </div>
                <?php endfor; ?>
            </div>
        </li>
    </ul>
</section>

<section class="no-sub-about-doing no-section-md">
    <div class="no-container-2xl">
        <div class="no-sub-section-title --tac">
            <h2 class="f-display-2">What We Do</h2>
            <p class="f-heading-4 --medium">
                Better Efficiency Higher Quality
            </p>
            <span class="f-body-1 --regular">
                AI 기반 버추얼 스튜디오와 실사 촬영을 아우르는 End-to-End AI Production Pipeline으로, <br>
                더 효율적이고, 더 완성도 높은 콘텐츠를 만듭니다.
            </span>
        </div>
    </div>
</section>
<section class="no-sub-about-rotate ">
    <div class="no-container-2xl">
        <div class="no-sub-about-rotate-inner">
            <!-- 원 컨테이너 -->
            <div class="no-sub-about-rotate-circle ">

                <!-- 보더 원 -->
                <div class="border-circle">
                    <!-- 컬러 원 -->
                    <div class="bg-circle">
                        <div class="list">
                            <p class="f-heading-2">
                                End-to-End <br>
                                AI Production
                            </p>
                            <div class="no-sub-about-rotate-num">
                                <div id="current-num">
                                    <span class="f-heading-3">1</span>
                                    <span class="f-body-1">/</span>
                                    <span class="f-body-1">4</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ripple circle  -->
                    <div class="ripple-circle">
                        <div class="ripple-circle-item current">
                            <span></span>
                        </div>
                        <div class="ripple-circle-item">
                            <span></span>
                        </div>
                        <div class="ripple-circle-item">
                            <span></span>
                        </div>
                        <div class="ripple-circle-item">
                            <span></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="no-sub-about-rotate-text">
                <div class="no-sub-about-rotate-text-item current">
                    <h3 class="f-heading-2 --bold">AI Creative Production</h3>
                    <p class="f-body-2">AI 기반 풀파이프라인으로 효율적이고 완성도 높은 영상 제작</p>
                </div>
                <div class="no-sub-about-rotate-text-item">
                    <h3 class="f-heading-2 --bold">VFX & AI Solutions</h3>
                    <p class="f-body-2">AI·VFX 기술로 비용과 시간을 줄이고 글로벌 수준의 비주얼 구현</p>
                </div>
                <div class="no-sub-about-rotate-text-item">
                    <h3 class="f-heading-2 --bold">Content Planning & Storytelling</h3>
                    <p class="f-body-2">IP 기반 기획력과 스토리텔링으로 차별화된 콘텐츠 제작</p>
                </div>
                <div class="no-sub-about-rotate-text-item">
                    <h3 class="f-heading-2 --bold">Original Content & Film Production</h3>
                    <p class="f-body-2">영화·드라마·예능·숏폼 등 다양한 오리지널 콘텐츠 제작</p>
                </div>
            </div>
        </div>

    </div>
    <!-- BG -->
    <div class="no-gradient-bg no-sub-about-rotate-bg">
        <img src="/resource/images/bg/gradient_bg.png" alt="">
    </div>
</section>


<section class="no-sub-about-creators no-section-md">
    <div class="no-container-2xl">
        <div class="no-sub-section-title --tac">
            <h2 class="f-display-2">Our Creators</h2>
        </div>
        <div class="--cnt">
            <div class="no-sub-about-creators-inner">
                <div class="no-sub-about-creators-wrap">
                    <!-- 타이틀 FIXED -->
                    <div class="no-sub-about-creators-title">
                        <h3 class="f-heading-1 --bold">Directors</h3>
                    </div>
                    <!-- 컨텐츠 일반 스크롤링 -->
                    <div class="no-sub-about-creators-contents">
                        <ul>
                            <?php if (!empty($creators)): ?>
                            <?php foreach ($creators as $creator): ?>
                            <li>
                                <div class="no-sub-about-creators-contents-title">
                                    <h3 class="f-heading-3 --bold"><?= htmlspecialchars($creator['title'] ?? '') ?></h3>
                                    <?php if (!empty($creator['extra1'])): ?>
                                    <span class="f-body-1 --medium"><?= htmlspecialchars($creator['extra1']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php 
                                    $rawHtml = html_entity_decode((string)($creator['contents'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                ?>
                                <div class="no-sub-about-creators-contents-html">
                                    <?= $rawHtml ?>
                                </div>
                            </li>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <li>
                                <p class="no-data">등록된 크리에이터가 없습니다.</p>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<?= include_view('sections.contact') ?>

<?php end_section() ?>

<?php section('script') ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 스냅샷 애니메이션 초기화
    if (typeof subSnapAnimation === 'function') {
        subSnapAnimation();
    }
});
</script>

<?php end_section() ?>