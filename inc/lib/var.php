<?php


// 배너 위치 설정
$arr_banner_loc = [
    'site_main' => '메인 상단이미지',
];

$banner_types = [
    1 => '메인 상단이미지',
];


$popup_types = [
    1 => '메인 페이지',
    2 => '문의하기 페이지',
    3 => '제품 페이지',
];

$admin_roles = [
    1 => ['code' => 'superadmin', 'name' => '최고 관리자'],
    2 => ['code' => 'manager',    'name' => '중간 관리자'],
    3 => ['code' => 'external',   'name' => '외부인'],
];

$link_targets = [
    0 => ['label' => '현재창', 'target' => '_self'],
    1 => ['label' => '새창', 'target' => '_blank'],
];

$has_link = [
    1 => '링크',
    2 => '비링크',
];

$is_unlimited = [
    1 => '무기한 노출',
    2 => '노출 기간 설정'
];

$is_confirmed = [
    0 => "미확인",
    1 => "확인"
];

// 사이트 데이터 타겟 설정
$siteDataTarget = [
    'subtitle' => '임시제목',
];

// 창 열기 방식 설정
$_targetArr = [
    '_blank' => '새창',
    '_self' => '같은창',
];

$board_type = [
    'bbs' => '게시판',
    'gal' => '갤러리',
    'pro' => '제품',

    // 홍보센터
    'new' => '뉴스',
    'not' => '공지사항',
];


// FAQ 카테고리
$faq_categories = [
    1 => '구매',
    2 => 'A/S',
    3 => '환불',
    4 => '기타',
];


// ACTIVE 공통
$is_active = [
    1 => "활성화",
    0 => "비활성화"
];



$product_categories = [
  1 => "eversys",
  2 => "scotsman",
  3 => "lacimbali",
  4 => "fetco",
  5 => "cooktek",
  6 => "grindmaster",
];

$product_secondary_categories = [
  1 => "eversys",
  2 => "scotsman",
  3 => [
    1 => "TS",
    2 => "MILK",
    3 => "3GR",
    4 => "2GR",
  ],
  4 => "fetco",
  5 => "cooktek",
  6 => "grindmaster",
];




// 허용된 파일 확장자
$board_file_allow = ['jpg', 'jpeg', 'png', 'gif', 'zip', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'hwp', 'mp4', 'mov', 'avi', 'txt', 'webp'];
$employment_file_allow = ['zip', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'hwp'];
$admission_file_allow = ['jpg', 'jpeg', 'png', 'gif'];

?>