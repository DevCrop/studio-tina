<?php
    // --- 기본 객체/값

    $conn = DB::getInstance(); 
    $sql = "SELECT * FROM nb_siteinfo"; 
    $result = $conn->query($sql);
    $siteinfo = $result->fetch(PDO::FETCH_ASSOC);
    app()->share('siteinfo', $siteinfo); 

    // --- 환경 기반 보조값
    $ROOT   = $ROOT   ?? ($NO_IS_SUBDIR ?? '');
    $LOCALE = $LOCALE ?? 'ko';

    // HTTPS 판별(프록시 고려)
    $isHttps = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') ||
        (($_SERVER['SERVER_PORT'] ?? '') == 443)
    );
    $scheme = $isHttps ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');
    $uri    = $_SERVER['REQUEST_URI'] ?? '/';
    $baseUrl= $scheme . '://' . $host;

    // --- 파일 버전 헬퍼(존재하면 mtime, 없으면 timestamp)
    $assetVersion = function (string $publicPath) use ($ROOT) {
        $full = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . $ROOT . $publicPath;
        return is_file($full) ? filemtime($full) : time();
    };

    // --- siteinfo 매핑(안전한 기본값)
    $siteName        = $siteinfo['title']         ?? '';
    $metaTitleBase   = $siteinfo['meta_title']        ?? '';
    $metaDescBase    = $siteinfo['meta_description']  ?? '';
    $metaKeywords    = $siteinfo['meta_keywords']     ?? '';

    // 페이지별 SEO가 있으면 우선
    $pageTitle       = $CUR_PAGE['seo_title']   ?? $metaTitleBase;
    $pageDesc        = $CUR_PAGE['seo_desc']    ?? $metaDescBase;
    $pageKeywords    = $CUR_PAGE['seo_keyword'] ?? $metaKeywords;

    // Canonical/URL들
    $canonicalUrl    = $baseUrl . $uri;

    // OG / Twitter
    $ogTitle         = $siteinfo['og_title']       ?? $pageTitle;
    $ogDescription   = $siteinfo['og_description'] ?? $pageDesc;
    $ogImage         = $siteinfo['og_image']       ?? ($ROOT . '/resource/images/ogimg.jpg');
    $ogImageAbs      = (strpos($ogImage, 'http') === 0) ? $ogImage : ($baseUrl . $ogImage);
    $ogLocale        = $siteinfo['og_locale']      ?? ($LOCALE === 'ko' ? 'ko_KR' : 'en_US');
    $ogType          = $siteinfo['og_type']        ?? 'website';

    $twitterCard     = $siteinfo['twitter_card']   ?? 'summary';
    $twitterImage    = $siteinfo['twitter_image']  ?? $ogImageAbs;
    $twitterTitle    = $siteinfo['twitter_title']  ?? $pageTitle;
    $twitterDesc     = $siteinfo['twitter_desc']   ?? $pageDesc;

    // 파비콘/썸네일
    $favicon         = $siteinfo['favicon']        ?? ($ROOT . '/resource/images/favicon.png');
    $faviconAbs      = (strpos($favicon, 'http') === 0) ? $favicon : ($baseUrl . $favicon);

    // 검증 태그들
    $naverVerify     = $siteinfo['naver_site_verification'] ?? null;
    $googleVerify    = $siteinfo['google_site_verification'] ?? []; // 문자열/배열 모두 허용
    if (!is_array($googleVerify)) $googleVerify = array_filter([$googleVerify]);

    // 마케팅 스크립트 ID (있을 때만 로드)
    $gtmId           = $siteinfo['gtm_id']       ?? 'GTM-KRP6HPZX'; // 예시 기본값 유지
    $fbPixelId       = $siteinfo['fb_pixel_id']  ?? '1738602140085473';

    // 기타 메타
    $metaImageAbs    = $siteinfo['meta_image'] ?? $ogImageAbs;

    // 스타일 버전
    $styleVer        = $assetVersion('/resource/css/style.css');

?>

<!DOCTYPE html>
<html lang="<?= e($LOCALE) ?>" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php 
        $seo_title = yield_section('seo_title') ?? __('site.seo_title'); 
        $seo_desc = yield_section('seo_desc') ?? __('site.seo_desc'); 
        $seo_keywords = yield_section('seo_keywords') ?? __('site.seo_keywords'); 
    ?>

    <title><?= e($seo_title) ?></title>
    <meta name="description" content="<?= e($seo_desc) ?>">
    <meta name="keywords" content="<?= e($seo_keywords) ?>">


    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <meta name="robots" content="index, follow" />
    <meta name="image" content="<?= e($metaImageAbs) ?>">
    <?php if ($naverVerify): ?>
    <meta name="naver-site-verification" content="<?= e($naverVerify) ?>" />
    <?php endif; ?>
    <?php foreach ($googleVerify as $gv): ?>
    <meta name="google-site-verification" content="<?= e($gv) ?>" />
    <?php endforeach; ?>

    <!-- Open Graph -->
    <meta property="og:locale" content="<?= e($ogLocale) ?>" />
    <meta property="og:url" content="<?= e($baseUrl) ?>">
    <meta property="og:type" content="<?= e($ogType) ?>">
    <meta property="og:site_name" content="<?= e($siteName) ?>">
    <meta property="og:title" content="<?= e($ogTitle) ?>">
    <?php if ($ogDescription): ?>
    <meta property="og:description" content="<?= e($ogDescription) ?>">
    <?php endif; ?>
    <meta property="og:image" content="<?= e($ogImageAbs) ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="<?= e($twitterCard) ?>">
    <meta name="twitter:title" content="<?= e($twitterTitle) ?>">
    <?php if ($twitterDesc): ?>
    <meta name="twitter:description" content="<?= e($twitterDesc) ?>">
    <?php endif; ?>
    <meta name="twitter:image" content="<?= e($twitterImage) ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= e($faviconAbs) ?>">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <link href="/resource/vendor/aos/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://kit.fontawesome.com/feea649d0a.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <!-- App CSS -->
    <link rel="stylesheet" href="<?= $ROOT ?>/resource/css/style.css?v=<?= $styleVer ?>" />

    <?= yield_section('style', '') ?>

    <!-- Vendor JS (head 필요분) -->
    <script src="<?= $ROOT ?>/resource/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="/resource/vendor/aos/aos.js"></script>
    <script src="<?= $ROOT ?>/resource/vendor/lordIcon/lordIcon.min.js"></script>
    <script src="<?= $ROOT ?>/resource/vendor/fontAwesome/fontAwesome.min.js" crossorigin="anonymous"></script>
    <script src="<?= $ROOT ?>/resource/vendor/lenis/lenis.js"></script>
    <script src="<?= $ROOT ?>/resource/vendor/gsap/gsap.min.js"></script>
    <script src="<?= $ROOT ?>/resource/vendor/gsap/scrollTrigger.min.js"></script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script src="<?= $ROOT ?>/resource/js/fslightbox.js"></script>
    <script src="<?= $ROOT ?>/resource/vendor/mouseFollower/mouseFollower.js"></script>
    <script src="/resource/js/popup.js?v=<?=time()?>" defer></script>
    <!-- App JS -->
    <script src="<?= $ROOT ?>/resource/js/app.js?v=<?= date('YmdHis') ?>" defer></script>

</head>

<body>

    <div class="__root">
        <?= include_view('components.header') ?>
        <main class="<?= yield_section('main_class') ?>">
            <?= yield_section('content') ?>
        </main>
        <?= include_view('components.footer') ?>
    </div>

    <!-- (선택) 페이지 전용 포탈/스크립트 섹션 -->
    <?= yield_section('portal', '') ?>
    <?= yield_section('script', '') ?>

</body>

</html>