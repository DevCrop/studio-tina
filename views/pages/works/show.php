<?php section('main_class', 'sub-works') ?>
<?php section('seo_title', $work['title'] ?? 'Works') ?>
<?php section('content') ?>

<?php
// 이전/다음글 안전 처리
$hasPrev    = is_array($prevWork) && !empty($prevWork['no']);
$hasNext    = is_array($nextWork) && !empty($nextWork['no']);
$prevTitle  = $hasPrev ? $prevWork['title'] : (($HTML_LANG ?? '') === 'en' ? 'No previous post.' : '이전글이 없습니다.');
$nextTitle  = $hasNext ? $nextWork['title'] : (($HTML_LANG ?? '') === 'en' ? 'No next post.'     : '다음글이 없습니다.');
$prevLink   = $hasPrev ? '/works/' . $prevWork['no'] : 'javascript:void(0)';
$nextLink   = $hasNext ? '/works/' . $nextWork['no'] : 'javascript:void(0)';
$prevBack   = $hasPrev ? '' : 'onClick="redirectToList();"';
$nextBack   = $hasNext ? '' : 'onClick="redirectToList();"';
$listUrl    = '/works';
$labelList  = ($HTML_LANG ?? '') === 'en' ? 'Go to List' : '목록으로';
?>

<section class="no-sub-works-view-visual">
    <img src="<?= e('/uploads/board/' . $work['file_attach_1']) ?>" alt="<?= e($work['title'] ?? '') ?>">
</section>
<section class="no-sub-works-show no-section-md">
    <div class="no-container-2xl">


        <!-- 작품 상세 정보 -->
        <article class="no-sub-works-show-article">
            <a href="<?= e($listUrl) ?>" class="no-prev-button">
                <i class="fa-regular fa-arrow-left-long"></i>
            </a>
            <!-- 유튜브 영상 임베딩 direct_url 이거 plyr 써서 처리 예정-->
            <?php if (!empty($work['direct_url'])): ?>
            <div class="no-sub-works-show-youtube">
                <iframe src="<?= e($work['direct_url']) ?>" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <?php endif; ?>

            <div class="no-sub-works-show-contents">
                <!-- 썸네일 이미지 -->
                <?php if (!empty($work['image_url'])): ?>
                <figure class="no-sub-works-show-thumbnail">
                    <img src="<?= e($work['image_url']) ?>" alt="<?= e($work['title'] ?? '') ?>">
                </figure>
                <?php endif; ?>
                <!-- 제목 & 카테고리 -->
                <div class="no-sub-works-show-txt">
                    <div>
                        <?php if (!empty($work['category_name'])): ?>
                        <span class="f-body-4 --semibold category"><?= e($work['category_name']) ?></span>
                        <?php endif; ?>

                        <div class="no-sub-works-show-txt__title">
                            <h2 class="f-heading-2 --bold"><?= e($work['title'] ?? '') ?></h2>
                            <?php 
                        $contents = $work['contents'] ?? '';
                        // HTML 엔티티 디코딩 -> 태그 제거 -> 이스케이프 -> 줄바꿈 처리
                        $contents = html_entity_decode($contents, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        $contents = strip_tags($contents);
                        $contents = trim($contents);
                    ?>
                            <span class="f-heading-4 --regular"><?= nl2br(e($contents)) ?></span>
                        </div>
                    </div>
                    <div class="no-sub-works-show-txt__info">
                        <ul>
                            <?php if (!empty($work['extra1'])): ?>
                            <li>
                                <span class="label f-body-3 --medium">형식</span>
                                <p class="value f-body-3 --regular"><?= e($work['extra1']) ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($work['extra2'])): ?>
                            <li>
                                <span class="label f-body-3 --medium">채널</span>
                                <p class="value f-body-3 --regular"><?= e($work['extra2']) ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($work['extra3'])): ?>
                            <li>
                                <span class="label f-body-3 --medium">제작</span>
                                <p class="value f-body-3 --regular"><?= e($work['extra3']) ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($work['extra4'])): ?>
                            <li>
                                <span class="label f-body-3 --medium">원작</span>
                                <p class="value f-body-3 --regular"><?= e($work['extra4']) ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($work['extra5'])): ?>
                            <li>
                                <span class="label f-body-3 --medium">출연</span>
                                <p class="value f-body-3 --regular"><?= e($work['extra5']) ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($work['extra6'])): ?>
                            <li>
                                <span class="label f-body-3 --medium">감독</span>
                                <p class="value f-body-3 --regular"><?= e($work['extra6']) ?></p>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($work['extra7'])): ?>
                            <li>
                                <span class="label f-body-3 --medium">Model</span>
                                <p class="value f-body-3 --regular"><?= e($work['extra7']) ?></p>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </article>

        <div class="no-sub-view-nav">
            <!-- 이전글 -->
            <a href="<?= $prevLink ?>" <?= $prevBack ?>
                class="no-sub-view-nav__item --prev <?= !$hasPrev ? '--disabled' : '' ?>">
                <div class="--icon">
                    <i class="fa-regular fa-arrow-left-long"></i>
                </div>
                <div class="--content">
                    <span class="--title f-heading-5"><?= e($prevTitle) ?></span>
                </div>
            </a>

            <!-- 목록 버튼 -->
            <a href="<?= e($listUrl) ?>" class="no-sub-view-nav__list">
                <span class="f-body-1 --semibold"><?= $labelList ?></span>
            </a>

            <!-- 다음글 -->
            <a href="<?= $nextLink ?>" <?= $nextBack ?>
                class="no-sub-view-nav__item --next <?= !$hasNext ? '--disabled' : '' ?>">
                <div class="--content">
                    <span class="--title f-heading-5"><?= e($nextTitle) ?></span>
                </div>
                <div class="--icon">
                    <i class="fa-regular fa-arrow-right-long"></i>
                </div>
            </a>
        </div>

    </div>
</section>

<?php end_section() ?>

<?php section('script') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 스냅샷 애니메이션 초기화
    if (typeof subSnapAnimation === 'function') {
        subSnapAnimation();
    }
});

function redirectToList() {
    alert('정보를 찾을 수 없습니다.');
    location.href = <?= json_encode($listUrl ?? '/works', JSON_UNESCAPED_SLASHES) ?>;
}
</script>
<?php end_section() ?>