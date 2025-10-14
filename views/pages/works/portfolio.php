<!-- contents -->
<?php section('seo_title', __('about.seo_title')) ?>
<?php section('seo_desc', __('about.seo_desc')) ?>
<?php section('seo_keywords', __('about.seo_keywords')) ?>
<?php section('main_class', 'sub-works') ?>

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
        'category' => 'WORKS',
        'title' => 'PORTFOLIO',
    ]) ?>

<section class="no-sub-works-portfolio no-section-md">
    <div class="no-container-2xl">
        <!-- 토글링 카테고리 -->
        <div class="no-category">
            <ul>
                <div class="no-category-active-bg"></div>
                <li>
                    <button type="button" class="--active" data-category="all" data-category-no="0">All</button>
                </li>
                <li>
                    <button type="button" data-category="movie" data-category-no="27">Drama</button>
                </li>
                <li>
                    <button type="button" data-category="drama" data-category-no="28">Film</button>
                </li>
                <li>
                    <button type="button" data-category="variety" data-category-no="29">Broadcast</button>
                </li>
                <li>
                    <button type="button" data-category="ad" data-category-no="30">AI CF</button>
                </li>
            </ul>
        </div>
        <!-- 콘텐츠 fetch.js로 렌더링 -->
        <div id="works">
            <ul class="no-sub-works-portfolio-list">
                <!-- JavaScript로 동적 렌더링됨 -->
                <li class="loading">
                    <p class="f-heading-4">로딩 중...</p>
                </li>
            </ul>

            <!-- 페이지네이션 (JavaScript로 동적 렌더링) -->
            <div class="no-pagination">
                <!-- fetch.js에서 동적으로 생성됨 -->
            </div>
        </div>
    </div>
</section>



<?php end_section() ?>

<?php section('script') ?>

<!-- Fetch.js 로드 -->
<script src="/resource/js/fetch.js"></script>

<?php end_section() ?>