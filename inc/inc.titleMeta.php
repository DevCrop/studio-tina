<?php
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') !== false ? 'https://' : 'http://';

    // HTTP 호스트와 요청 URI를 미리 변수로 저장
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $uri = $_SERVER['REQUEST_URI'] ?? '';

    // Canonical URL 생성
    $canonical_url = $protocol . $host . $uri;

    // 사이트 정보 변수들
    $NO_STATIC_TITLE = $SITEINFO_TITLE;
    $NO_META_KEYWORDS = $SITEINFO_META_KEYWORDS;
    $NO_META_DESCRIPTION = $SITEINFO_META_DESCRIPTION;
    $NO_META_URL = $protocol . $host . $uri;
    $NO_META_TWITTER_CARD = "Summary";
    $NO_META_TWITTER_URL = $protocol . $host . $uri;
    $NO_META_TWITTER_TITLE = $NO_STATIC_TITLE;
    $NO_META_TWITTER_DESCRIPTION = $NO_META_DESCRIPTION;
    $NO_META_TWITTER_IMAGE = $NO_IS_SUBDIR . "/uploads/meta/" . $SITEINFO_META_THUMB;
    $NO_META_OG_URL = $protocol . $host;
    $NO_META_OG_TYPE = "website";
    $NO_META_OG_IMAGE = "/resource/images/ogimg.jpg";
    $NO_META_OG_SITE_NAME = $NO_STATIC_TITLE;
    $NO_META_OG_LOCALE = "ko";
    $NO_META_OG_TITLE = "Artful Craft, Colorful Tech | Palette";
    $NO_META_OG_DESCRIPTION = "예술에 기술을 더하여 새로움을 완성하는 곳, 팔레트";
    $NO_META_OG_COUNTRY_NAME = "";
    $NO_META_ITEMPROP_NAME = $NO_STATIC_TITLE;
    $NO_META_ITEMPROP_IMAGE = "";
    $NO_META_ITEMPROP_URL = $protocol . $host . $uri;
    $NO_META_ITEMPROP_DESCRIPTION = $NO_META_DESCRIPTION;
    $NO_META_ITEMPROP_KEYWORD = $NO_META_KEYWORDS;
    $NO_META_SHORTCUT_ICON = $NO_IS_SUBDIR . "/resource/images/favicon.png?v";
    $NO_META_APPLE_THOUCH_ICON = "";
?>
<?php if(isset($CUR_PAGE['seo_title'])) : ?>
<title><?=$CUR_PAGE['seo_title']?></title>
<meta name="description" content="<?=$CUR_PAGE['seo_desc']?>">
<meta name="keywords" content="<?=$CUR_PAGE['seo_keyword']?>">
<?php else: ?>
<title><?=$PAGE_TITLE?></title>
<meta name="description" content="<?=$NO_META_DESCRIPTION?>">
<meta name="keywords" content="<?=$NO_META_KEYWORDS?>">
<?php endif; ?>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:image" content="<?= $ROOT ?>/resource/images/ogimg.jpg">

<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebPage",
      "name": "AI 영상 제작 서비스",
      "description": "AI 기술로 혁신적인 영상 제작 솔루션 제공. 자동 편집, 음성 합성, 얼굴 합성 등 최신 기술로 고품질 콘텐츠 제작.",
      "keywords": "AI 영상 제작, 자동화 기술, 음성 합성, 유튜브 최적화, 대량 콘텐츠 제작",
      "image": "http://palette.nineonelabs.co.kr/resource/images/ai-mockup.png",
	  "url": "http://palette.nineonelabs.co.kr/pages/service/ai.php"
    }
</script>
<!-- 영상 제작 협업 서비스 Schema -->
<script type="application/ld+json">
	{
	"@context": "https://schema.org",
	"@type": "WebPage",
	"name": "영상 제작 협업 서비스",
	"description": "효율적이고 체계적인 영상 제작 협업 플랫폼. 클라이언트와 전문가가 함께 작업하며, 실시간 피드백과 클라우드 기반 관리로 최고의 결과를 제공합니다.",
	"keywords": "영상 제작 협업, 협업 플랫폼, 클라우드 기반 협업, 팀워크, 실시간 피드백, 글로벌 협업",
	"image": "http://palette.nineonelabs.co.kr/resource/images/hub-mockup.png",
	"url": "http://palette.nineonelabs.co.kr/pages/service/hub.php"
	}
</script>
<!-- 디지털 마케팅 전문가 Schema -->
<script type="application/ld+json">
	{
	  "@context": "https://schema.org",
	  "@type": "WebPage",
	  "name": "디지털 마케팅 전문가",
	  "description": "콘텐츠 마케팅과 퍼포먼스 마케팅을 결합한 디지털 마케팅 솔루션 제공. 데이터 기반 전략과 ROI 최적화를 통해 비즈니스 성장 지원.",
	  "keywords": "디지털 마케팅, 콘텐츠 마케팅, 퍼포먼스 마케팅, SEO, ROI 최적화, 캠페인 최적화, 데이터 기반 마케팅",
	  "image": "http://palette.nineonelabs.co.kr/resource/images/mk-graph1.png",
	  "url": "http://palette.nineonelabs.co.kr/pages/service/mk.php"
	}
</script>
<link rel="canonical" href="<?=$canonical_url?>">
<meta name="autocomplete" content="off" />
<meta name="image" content="<?=$NO_META_OG_IMAGE?>">
<meta name="robots" content="index, follow" />
<meta property="og:locale" content="ko_KR" />
<meta property="og:url" content="<?=$NO_META_OG_URL?>">
<meta property="og:image" content="<?=$NO_META_OG_IMAGE?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?=$NO_META_OG_SITE_NAME?>">
<meta property="og:title" content="<?=$NO_META_OG_TITLE?><?=$NO_STATIC_SUBTITLE?>">
<meta property="og:description" content="<?=$NO_META_OG_DESCRIPTION?>">
<link rel="shortcut icon" href="<?=$NO_META_SHORTCUT_ICON?>">
<meta name="naver-site-verification" content="fb8d5917621dedb6109d382bb1e6efb45c78b9cd" />
<meta name="google-site-verification" content="IXvq6STfnrMjc8aUR-hkbJqrhKkQXt7o0LHdp-ajgR4" />
<meta name="google-site-verification" content="google8fb87cb7130e2a93.html" />
<meta name="google-site-verification" content="H7_dWqom3eKXsT8D5zq9Ab0nNJJoViUzmGADudvz5X0" />

