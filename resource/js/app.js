$(document).ready(function () {
  document.cookie = "cookie_name=cookie_value; SameSite=None; Secure";
  AOS.init();
  initHeader();
  initLenis();

  gsap.registerPlugin(ScrollTrigger);
  mainVisualSwiper();
  mainAboutAnimation();
  marqueeLogos();
});

function initHeader() {
  const root = document.getElementById("header");

  if (!root) return;

  const menu = root.querySelector(".no-header__menu, .no-header-menu");
  const nav = root.querySelector(".no-header__nav, .no-header-nav");
  const btn = root.querySelector(".no-header-btn");
  const backdrop = document.getElementById("no-backdrop");
  const sitemap = document.getElementById("sitemap");

  const mql = window.matchMedia("(min-width: 769px)");
  if (menu) {
    menu.addEventListener("mouseenter", () => {
      if (!mql.matches) return;
      root.classList.add("active");
      if (backdrop) backdrop.classList.add("active");
    });

    root.addEventListener("mouseleave", () => {
      if (!mql.matches) return;
      root.classList.remove("active");
      if (backdrop) backdrop.classList.remove("active");
    });
  }

  // 버튼 컨트롤
  if (btn) {
    btn.addEventListener("click", () => {
      root.classList.toggle("mb-visible");
      btn.classList.toggle("active");
      sitemap.classList.toggle("active");
      nav.classList.toggle("active");
    });
  }
  // sitemap 컨트롤
  if (sitemap) {
    const sitemapItems = sitemap.querySelectorAll(
      ".no-sitemap__menu--gnb > li"
    );
    const sitemapBgImages = sitemap.querySelectorAll(".no-sitemap__bg img");

    if (sitemapBgImages.length > 0) {
      sitemapBgImages[0].classList.add("active");
    }

    sitemapItems.forEach((item, index) => {
      item.addEventListener("mouseenter", () => {
        sitemapBgImages.forEach((img) => img.classList.remove("active"));

        if (sitemapBgImages[index + 1]) {
          sitemapBgImages[index + 1].classList.add("active");
        }
      });

      item.addEventListener("mouseleave", () => {
        sitemapBgImages.forEach((img) => img.classList.remove("active"));
        if (sitemapBgImages[0]) {
          sitemapBgImages[0].classList.add("active");
        }
      });
    });
  }

  function handleScroll() {
    if (window.scrollY > 80) {
      root.classList.add("is-scrolled");
    } else {
      root.classList.remove("is-scrolled");
    }
  }

  window.addEventListener("scroll", handleScroll);
  handleScroll();
}

function mainVisualSwiper() {
  const swiperContainer = document.querySelector(".no-main-visual-swiper");
  if (!swiperContainer) return;

  const progressBar = swiperContainer.querySelector(
    ".no-main-visual-progress-bar"
  );

  const swiper = new Swiper(".no-main-visual-swiper", {
    loop: true,
    speed: 800,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    watchOverflow: true,
    pagination: {
      el: ".swiper-pagination",
      type: "custom",
      renderCustom: function (swiper, current, total) {
        const currentStr = String(current).padStart(2, "0");
        const totalStr = String(total).padStart(2, "0");
        return `<span class="current">${currentStr}</span><span class="divider">/</span><span class="total">${totalStr}</span>`;
      },
    },
    navigation: {
      nextEl: ".no-main-visual-btn-next",
      prevEl: ".no-main-visual-btn-prev",
      hideOnClick: false,
    },
    on: {
      init: function () {
        const controls = swiperContainer.querySelector(
          ".no-main-visual-controls"
        );
        // 슬라이드가 1개면 controls 숨기기
        if (this.slides.length <= 1 && controls) {
          controls.style.display = "none";
        }
      },
      autoplayTimeLeft(s, time, progress) {
        if (progressBar) {
          progressBar.style.width = (1 - progress) * 100 + "%";
        }
      },
      autoplayStop: function () {
        if (progressBar) {
          progressBar.style.width = "0%";
        }
      },
    },
  });

  swiperContainer.addEventListener("mouseenter", () => {
    swiper.autoplay.stop();
  });

  swiperContainer.addEventListener("mouseleave", () => {
    swiper.autoplay.start();
  });
}

function initLenis() {
  const lenis = new Lenis();

  lenis.on("scroll", ScrollTrigger.update);

  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });

  gsap.ticker.lagSmoothing(0);
}

function mainAboutAnimation() {
  const about = document.querySelector(".no-main-about");
  const inner = document.querySelector(".no-main-about__inner");
  if (!about || !inner) return;

  const config = {
    scrollEnd: "+=600%",
    textDuration: 2.5,
    textFadeDuration: 0.8,
    imageDuration: 3,
    imageStartDelay: 0.3,
    bgScaleType: "shrink",
    bgScaleFrom: 1,
    bgScaleTo: 1.3,
  };

  const textSequences = [
    { start: 0, imageIndices: [0, 1] },
    { start: 3, imageIndices: [2, 3] },
    { start: 6, imageIndices: [4] },
  ];

  const textItems = gsap.utils.toArray(".txt-reveal-item");
  const images = gsap.utils.toArray(".no-main-about-img .image");
  const bgImage = document.querySelector(".no-main-about-bg img");

  const timeline = gsap.timeline({
    scrollTrigger: {
      trigger: about,
      start: "top top",
      end: config.scrollEnd,
      scrub: true,
      pin: about,
      // markers: true,
    },
  });

  if (bgImage) {
    const scaleFrom =
      config.bgScaleType === "grow" ? config.bgScaleFrom : config.bgScaleTo;
    const scaleTo =
      config.bgScaleType === "grow" ? config.bgScaleTo : config.bgScaleFrom;

    gsap.set(bgImage, { scale: scaleFrom });

    timeline.to(
      bgImage,
      {
        scale: scaleTo,
        duration: 8,
        ease: "none",
      },
      0
    );
  }

  const animateImages = (imageIndices, startTime) => {
    imageIndices.forEach((imgIndex, i) => {
      const img = images[imgIndex];
      const delay = startTime + config.imageStartDelay * (i + 1);

      timeline.to(
        img,
        {
          y: "-150vh",
          opacity: 1,
          filter: "blur(0px)",
          duration: config.imageDuration,
          ease: "power2.inOut",
        },
        delay
      );
    });
  };

  const animateTextSequence = (index, sequence) => {
    const currentItem = textItems[index];
    const prevItem = index > 0 ? textItems[index - 1] : null;
    const { start, imageIndices } = sequence;

    // 텍스트 fade in
    timeline.to(
      currentItem,
      {
        opacity: 1,
        duration: config.textFadeDuration,
        ease: "power2.inOut",
      },
      start
    );

    // 이전 텍스트 fade out
    if (prevItem) {
      timeline.to(
        prevItem,
        {
          opacity: 0,
          duration: config.textFadeDuration,
          ease: "power2.inOut",
        },
        start
      );
    }

    // 텍스트 채워지기
    timeline.to(
      currentItem.querySelector(".txt-overlay"),
      {
        clipPath: "polygon(0 0, 100% 0, 100% 100%, 0 100%)",
        duration: config.textDuration,
        ease: "power2.inOut",
      },
      start
    );

    // 이미지 애니메이션
    animateImages(imageIndices, start);
  };

  // 모든 시퀀스 실행
  textSequences.forEach((sequence, index) => {
    animateTextSequence(index, sequence);
  });
}

// 로고 마키 애니메이션
function marqueeLogos() {
  const marquees = document.querySelectorAll('[wb-data="marquee-logo"]');

  if (!marquees.length) return;

  marquees.forEach((marquee) => {
    const duration = parseInt(marquee.getAttribute("duration"), 10) || 60;
    const direction = marquee.getAttribute("direction") || "left";
    const marqueeContent = marquee.querySelector(".no-marquee__content");

    if (!marqueeContent) return;

    const marqueeContentClone = marqueeContent.cloneNode(true);
    marquee.appendChild(marqueeContentClone);

    let tween;

    const playMarquee = () => {
      let progress = tween ? tween.progress() : 0;
      tween && tween.progress(0).kill();

      const width = marqueeContent.scrollWidth;
      const gap =
        parseInt(getComputedStyle(marqueeContent).getPropertyValue("gap")) || 0;

      const distanceToTranslate = -1 * (width + gap);

      // 방향에 따라 애니메이션 설정
      if (direction === "right") {
        // 오른쪽에서 왼쪽 (역방향)
        // 초기 위치를 0에서 시작하도록 설정
        gsap.set(marqueeContent, { x: 0 });
        gsap.set(marqueeContentClone, { x: -distanceToTranslate });

        tween = gsap.fromTo(
          [marqueeContent, marqueeContentClone],
          { x: -2000 },
          {
            x: -distanceToTranslate,
            duration,
            ease: "none",
            repeat: -1,
            onRepeat: function () {
              gsap.set(marqueeContent, { x: 0 });
              gsap.set(marqueeContentClone, { x: -distanceToTranslate });
            },
          }
        );
      } else {
        // 왼쪽에서 오른쪽 (기본)
        gsap.set(marqueeContent, { x: 0 });
        gsap.set(marqueeContentClone, { x: -distanceToTranslate });

        tween = gsap.fromTo(
          [marqueeContent, marqueeContentClone],
          { x: 0 },
          {
            x: distanceToTranslate,
            duration,
            ease: "none",
            repeat: -1,
          }
        );
      }

      tween.progress(progress);
    };

    playMarquee();

    function debounce(func) {
      let timer;
      return function () {
        clearTimeout(timer);
        timer = setTimeout(func, 500);
      };
    }

    window.addEventListener("resize", debounce(playMarquee));
  });
}
