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
        'title' => 'HISTORY',
    ]) ?>

<section class="no-sub-about-history no-section-md">
    <div>

    </div>
    <div class="no-container-xl">
        <div class="no-sub-about-history-inner">
            <!-- Fixed 연도/월 표시 -->
            <div class="no-sub-about-history-fixed fade-up">
                <div class="no-sub-about-history-year">
                    <h2 class="f-heading-1 --bold --fm-ko" id="fixed-year">2025</h2>
                </div>
                <div class="no-sub-about-history-month">
                    <h3 class="f-heading-1 --bold --fm-ko" id="fixed-month">10</h3>
                </div>
            </div>

            <?php
        // DB에서 가져올 데이터 (예시 구조)
        // TODO: 실제 DB 쿼리로 대체 필요
        $historyData = [
            2025 => [
                [
                    'month' => '08',
                    'image' => '/resource/images/sub/history_banner_img_1.jpg',
                    'partners' => [
                        '/resource/images/logo/history_logo_1.png',
                        '/resource/images/logo/history_logo_3.png',
                    ],
                    'items' => [
                        '주식회사 스튜디오티나 사명 변경',
                        '단편영화 <사랑의 아포칼립스> 제작 (영화 \'극한직업\'의 문충일 작가 연출, 각본참여)',
                        '서울예술대학교 2025년 미디어컨텐츠산업 아트프로젝트 선정작',
                        '숏폼드라마 <자매전장> 제작 (기술총괄)'
                    ]
                ],
                [
                    'month' => '07',
                    'image' => '/resource/images/sub/history_banner_img_2.jpg',
                    'partners' => [
                        '/resource/images/logo/history_logo_3.png',
                    ],
                    'items' => [
                        '한국콘텐츠진흥원 2025 \'AI 영상 콘텐츠 제작지원\' 장편 부문 선정',
                    ]
                ],
                [
                    'month' => '05',
                    'image' => '/resource/images/sub/history_banner_img_3.jpg',
                    'partners' => [
                        '/resource/images/logo/history_logo_2.png',
                    ],
                    'items' => [
                        '숏폼드라마 <스퍼맨> LG유플러스와 공동제작',
                    ]
                ],
                [
                    'month' => '04',
                    'image' => '/resource/images/sub/history_banner_img_4.jpg',
                    'partners' => [
                        '/resource/images/logo/history_logo_5.png',
                        '/resource/images/logo/history_logo_4.png',
                    ],
                    'items' => [
                        'MBC every1 예능 [히든아이] AI VCR 재연 영상 제작',
                        'TV조선 교양 [중증건강센터] AI 재연/자료 영상 제작'
                    ]
                ],
                [
                    'month' => '03',
                    'items' => [
                        '주식회사 스튜디오애닉 설립',
                        'AI 기반 영상 제작 솔루션 사업 개시 (VFX·CG → 드라마·영화·예능 전 과정 적용)'
                    ]
                ],
            ],
        ];
        ?>
            <div class="no-sub-about-history-items">
                <?php foreach ($historyData as $year => $yearItems): ?>
                <?php foreach ($yearItems as $index => $item): ?>
                <div class="no-sub-about-history-item" data-year="<?= $year ?>" data-month="<?= $item['month'] ?>">

                    <!-- CONTENT -->
                    <div class="no-sub-about-history-content    fade-up">
                        <?php if (!empty($item['image'])): ?>
                        <figure class="no-sub-about-history-content-image">
                            <img src="<?= $item['image'] ?>" alt="<?= $year ?>년 <?= $item['month'] ?>월">
                        </figure>
                        <?php endif; ?>

                        <ul class="no-sub-about-history-content-text">
                            <?php foreach ($item['items'] as $text): ?>
                            <li class="f-body-1 --regular"><?= $text ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <?php if (!empty($item['partners'])): ?>
                        <div class="no-sub-about-history-content-partners">
                            <?php foreach ($item['partners'] as $partnerLogo): ?>
                            <div class="no-sub-about-history-content-partner-item">
                                <img src="<?= $partnerLogo ?>" alt="Partner">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
</section>

<?= include_view('sections.contact') ?>

<?php end_section() ?>

<?php section('script') ?>



<?php end_section() ?>