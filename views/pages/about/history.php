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
    <div class="no-container-2xl">
        <div class="no-sub-about-history-inner">
            <!-- Fixed 연도/월 표시 -->
            <div class="no-sub-about-history-fixed">
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
                    'month' => '10',
                    'image' => '/resource/images/snap/sub_snap_img_1.png',
                    'partners' => [
                        '/resource/images/logo/partner_1.png',
                        '/resource/images/logo/partner_2.png',
                        '/resource/images/logo/partner_3.png',
                    ],
                    'items' => [
                        '주식회사 스튜디오티나 사명 변경',
                        '단편영화 <사랑의 아포칼립스> 제작 (영화 \'극한직업\'의 문충일 작가 연출, 각본참여)',
                        '서울예술대학교 2025년 미디어컨텐츠산업 아트프로젝트 선정작',
                    ]
                ],
                [
                    'month' => '07',
                    'image' => '/resource/images/snap/sub_snap_img_2.png',
                    'partners' => null,
                    'items' => [
                        '단편영화 <아들니스> 제작 (영화 \'택시운전사\', \'고지전\', \'의형제\'의 장훈 감독 연출)',
                        '한국콘텐츠진흥원 2025 \'AI 영상 콘텐츠 제작지원\' 단편 부문 선정작',
                        'AI 비주얼 이펙트 기술 특허 출원',
                    ]
                ],
                [
                    'month' => '03',
                    'image' => '/resource/images/snap/sub_snap_img_3.png',
                    'partners' => [
                        '/resource/images/logo/partner_4.png',
                        '/resource/images/logo/partner_5.png',
                    ],
                    'items' => [
                        '숏폼드라마 <자매전쟁> 제작 (기술총괄)',
                        'Netflix 오리지널 시리즈 VFX 파트너십 체결',
                        '글로벌 AI 영상 제작 컨퍼런스 참가',
                    ]
                ],
            ],
            2024 => [
                [
                    'month' => '12',
                    'image' => '/resource/images/snap/sub_snap_img_4.png',
                    'partners' => [
                        '/resource/images/logo/partner_6.png',
                    ],
                    'items' => [
                        '영화 <더 문> AI 기반 VFX 제작 참여',
                        '제59회 백상예술대상 기술상 수상',
                        'AI 영상 제작 툴킷 v2.0 정식 출시',
                    ]
                ],
                [
                    'month' => '08',
                    'image' => '/resource/images/snap/sub_snap_img_5.png',
                    'partners' => null,
                    'items' => [
                        '스튜디오 티나 강남 사옥 이전',
                        '최신 AI 렌더링 장비 도입',
                        '프로덕션 스튜디오 확장 (500평 규모)',
                    ]
                ],
                [
                    'month' => '05',
                    'image' => '/resource/images/snap/sub_snap_img_6.png',
                    'partners' => [
                        '/resource/images/logo/partner_7.png',
                        '/resource/images/logo/partner_8.png',
                        '/resource/images/logo/partner_9.png',
                    ],
                    'items' => [
                        'tvN 드라마 <시간의 저편> AI 배경 제작',
                        '부산국제영화제 VR 콘텐츠 제작',
                        '문화체육관광부 우수 콘텐츠 기업 선정',
                    ]
                ],
                [
                    'month' => '02',
                    'image' => '/resource/images/snap/sub_snap_img_7.png',
                    'partners' => null,
                    'items' => [
                        '영상 AI 전문 인력 30명 추가 채용',
                        'AI 모션 캡처 시스템 구축',
                        '서울대학교 AI 연구소와 산학협력 MOU 체결',
                    ]
                ],
            ],
            2023 => [
                [
                    'month' => '11',
                    'image' => '/resource/images/snap/sub_snap_img_8.png',
                    'partners' => [
                        '/resource/images/logo/partner_10.png',
                    ],
                    'items' => [
                        '유튜브 오리지널 시리즈 <메타버스 크로니클> 제작',
                        '누적 제작 콘텐츠 100편 돌파',
                        '직원 복지 프로그램 대폭 확대',
                    ]
                ],
                [
                    'month' => '09',
                    'image' => '/resource/images/snap/sub_snap_img_9.png',
                    'partners' => null,
                    'items' => [
                        '중소벤처기업부 기술혁신대상 수상',
                        'AI 영상 편집 자동화 시스템 개발 완료',
                        '일본 도쿄 지사 설립',
                    ]
                ],
                [
                    'month' => '06',
                    'image' => '/resource/images/snap/sub_snap_img_10.png',
                    'partners' => [
                        '/resource/images/logo/partner_11.png',
                        '/resource/images/logo/partner_12.png',
                    ],
                    'items' => [
                        'CJ ENM과 AI 콘텐츠 제작 전략적 파트너십',
                        '숏폼 콘텐츠 플랫폼 \'티나TV\' 런칭',
                        'AI 배우 생성 기술 개발 착수',
                    ]
                ],
                [
                    'month' => '03',
                    'image' => '/resource/images/snap/sub_snap_img_11.png',
                    'partners' => null,
                    'items' => [
                        '시리즈 B 투자 유치 (100억원)',
                        'KAIST AI 대학원과 공동 연구 프로젝트 시작',
                        'AI 영상 콘텐츠 제작 교육 프로그램 개설',
                    ]
                ],
            ],
            2022 => [
                [
                    'month' => '10',
                    'image' => '/resource/images/snap/sub_snap_img_12.png',
                    'partners' => [
                        '/resource/images/logo/partner_13.png',
                        '/resource/images/logo/partner_14.png',
                    ],
                    'items' => [
                        '주식회사 스튜디오 티나 설립',
                        '고려대학교 기술지주 투자 유치',
                        'AI 영상 제작 기술 개발 착수',
                    ]
                ],
                [
                    'month' => '08',
                    'image' => '/resource/images/snap/sub_snap_img_13.png',
                    'partners' => null,
                    'items' => [
                        '첫 번째 사무실 오픈 (테헤란로)',
                        '창립 멤버 10명 구성 완료',
                        'AI 영상 제작 R&D 센터 설립',
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
                    <div class="no-sub-about-history-content">
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