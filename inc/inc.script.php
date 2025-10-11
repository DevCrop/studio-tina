<!--JQUERY-->
<script src="<?= $ROOT ?>/resource/vendor/jquery/jquery.min.js"></script>
<!-- SWIPER -->
<script src="/resource/vendor/swiper/swiper-bundle.js"></script>
<!-- Marquee -->
<script src="/resource/vendor/marquee/jquery.marquee.min.js"></script>
<!-- AOS -->
<script src="/resource/vendor/aos/aos.js"></script>
<!-- lordIcon -->
<script src="<?= $ROOT ?>/resource/vendor/lordIcon/lordIcon.min.js"></script>
<!-- FONTAWSOME -->
<script src="<?= $ROOT ?>/resource/vendor/fontAwesome/fontAwesome.min.js" crossorigin="anonymous"></script>
<!-- lenis -->
<script src="<?= $ROOT ?>/resource/vendor/lenis/lenis.js"></script>
<!-- GSAP -->
<script src="<?= $ROOT ?>/resource/vendor/gsap/gsap.min.js"></script>
<script src="<?= $ROOT ?>/resource/vendor/gsap/scrollTrigger.min.js"></script>
<!-- easing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Plyr -->
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<!-- light box -->
<script src="<?= $ROOT ?>/resource/js/fslightbox.js"></script>

<!-- Google Tag Manager -->
<script>
(function(w, d, s, l, i) {
	w[l] = w[l] || [];
	w[l].push({
		'gtm.start': new Date().getTime(),
		event: 'gtm.js'
	});
	var f = d.getElementsByTagName(s)[0],
		j = d.createElement(s),
		dl = l !== 'dataLayer' ? '&l=' + l : '';
	j.async = true;
	j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
	f.parentNode.insertBefore(j, f);
})(window, document, 'script', 'dataLayer', 'GTM-KRP6HPZX');
</script>
<!-- End Google Tag Manager -->

<!-- Meta Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1738602140085473');
  fbq('track', 'PageView');
</script>
<!-- End Meta Pixel Code -->

<!-- NAVER 공통 SCRIPT -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if (!wcs_add) var wcs_add = {};
wcs_add["wa"] = "s_2cb985b496b1";
if (window.wcs) {
    wcs.inflow("pltt.xyz");
}
wcs_do();
</script>

<!-- RESOURCE -->
<script src="<?= $ROOT ?>/resource/js/app.js?v=<?= date('YmdHis') ?>" defer></script>
