$(document).ready(function () {
  document.cookie = "cookie_name=cookie_value; SameSite=None; Secure";
  AOS.init();
  initHeader();
  initLenis();
  initScrollToTop();
  customCursor();

  gsap.registerPlugin(ScrollTrigger);
  // mainVisualSwiper는 인트로 완료 후 자동 실행됨
  mainAboutAnimation();
  marqueeLogos();
  subSnapAnimation();
  subRotateAnimation();
  subHistoryAnimation();
  categoryAnimation();
});

function categoryAnimation() {
  const categoryButtons = document.querySelectorAll(".no-category button");
  const activeBg = document.querySelector(".no-category-active-bg");

  if (!categoryButtons.length || !activeBg) return;

  // 배경 위치 업데이트 함수
  function updateActiveBg(button) {
    const buttonRect = button.getBoundingClientRect();
    const containerRect = button.closest("ul").getBoundingClientRect();

    // 스크롤 오프셋 고려
    const scrollLeft = button.closest("ul").scrollLeft || 0;
    const left = buttonRect.left - containerRect.left + scrollLeft;
    const top = buttonRect.top - containerRect.top;
    const width = buttonRect.width;
    const height = buttonRect.height;

    activeBg.style.transform = `translate(${left}px, ${top}px)`;
    activeBg.style.width = `${width}px`;
    activeBg.style.height = `${height}px`;
  }

  // 초기 활성 버튼 위치 설정
  const activeButton = document.querySelector(".no-category button.--active");
  if (activeButton) {
    updateActiveBg(activeButton);
  }

  // 버튼 클릭 이벤트
  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // 모든 버튼에서 active 클래스 제거
      categoryButtons.forEach((btn) => btn.classList.remove("--active"));

      // 현재 버튼에 active 클래스 추가
      this.classList.add("--active");

      // 배경 위치 업데이트
      updateActiveBg(this);

      // 여기에 필터링 로직 추가 가능
      const category = this.dataset.category;
      console.log("Selected category:", category);
    });
  });

  // 스크롤 이벤트 추가 (가로 스크롤 시 배경 위치 업데이트)
  const categoryContainer = document.querySelector(".no-category ul");
  if (categoryContainer) {
    categoryContainer.addEventListener("scroll", function () {
      const currentActive = document.querySelector(
        ".no-category button.--active"
      );
      if (currentActive) {
        updateActiveBg(currentActive);
      }
    });
  }

  // 윈도우 리사이즈 시 배경 위치 재계산
  let resizeTimer;
  window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      const currentActive = document.querySelector(
        ".no-category button.--active"
      );
      if (currentActive) {
        updateActiveBg(currentActive);
      }
    }, 100);
  });
}

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

  let lastScrollY = window.scrollY;

  function handleScroll() {
    const currentScrollY = window.scrollY;

    // 스크롤 위치에 따른 is-scrolled 클래스
    if (currentScrollY > 80) {
      root.classList.add("is-scrolled");
    } else {
      root.classList.remove("is-scrolled");
    }

    // 스크롤 방향 감지 (최소 5px 이상 이동 시에만 방향 변경)
    if (Math.abs(currentScrollY - lastScrollY) > 5) {
      if (currentScrollY > lastScrollY) {
        // 아래로 스크롤
        root.classList.remove("direction-up");
        root.classList.add("direction-down");
      } else {
        // 위로 스크롤
        root.classList.remove("direction-down");
        root.classList.add("direction-up");
      }
      lastScrollY = currentScrollY;
    }
  }

  window.addEventListener("scroll", handleScroll);
  handleScroll();
}
function subRotateAnimation() {
  const section = document.querySelector(".no-sub-about-rotate");
  if (!section) return;

  const circleContainer = section.querySelector(".ripple-circle");
  const items = section.querySelectorAll(".ripple-circle-item");
  const textItems = section.querySelectorAll(".no-sub-about-rotate-text-item");
  const numElement = section.querySelector("#current-num .f-heading-3"); // 첫 번째 span (숫자)

  if (!circleContainer || !items.length) return;

  // 각 단계별 컨테이너 회전값 (CSS item 위치: 90, 180, 270, 360)
  const stages = [
    { num: 1, rotation: 0 }, // item1 (90deg)을 12시(0deg)로
    { num: 2, rotation: -90 }, // item2 (180deg)를 12시로
    { num: 3, rotation: -180 }, // item3 (270deg)를 12시로
    { num: 4, rotation: -270 }, // item4 (360deg=0deg)는 이미 12시
  ];

  // 이전 단계 추적
  let previousStage = 0;

  // 단계 업데이트 함수
  const updateStage = (currentStage) => {
    if (currentStage === previousStage) return;

    // ripple-circle-item current 클래스 업데이트
    items.forEach((item, index) => {
      if (index === currentStage) {
        item.classList.add("current");
      } else {
        item.classList.remove("current");
      }
    });

    // rotate-text-item current 클래스 업데이트
    textItems.forEach((item, index) => {
      if (index === currentStage) {
        item.classList.add("current");
      } else {
        item.classList.remove("current");
      }
    });

    // 컨테이너 회전 애니메이션 (90도씩 snap)
    gsap.to(circleContainer, {
      rotation: stages[currentStage].rotation,
      duration: 0.8,
      ease: "power3.inOut",
    });

    // 숫자 업데이트 (첫 번째 span만 변경)
    if (numElement) {
      numElement.textContent = stages[currentStage].num;
    }

    // 이전 단계 업데이트
    previousStage = currentStage;
  };

  // ScrollTrigger로 섹션 고정 및 snap
  ScrollTrigger.create({
    trigger: section,
    start: "top top",
    end: "+=300%", // 3배 길이로 스크롤
    pin: true,
    snap: {
      snapTo: [0, 0.33, 0.66, 1], // 4단계로 snap
      duration: { min: 0.3, max: 0.6 }, // snap 속도
      ease: "power2.inOut",
    },
    onUpdate: (self) => {
      // 현재 진행도에 따라 단계 결정
      const progress = self.progress;
      let currentStage = 0;

      if (progress < 0.16) currentStage = 0;
      else if (progress < 0.5) currentStage = 1;
      else if (progress < 0.83) currentStage = 2;
      else currentStage = 3;

      // 단계 업데이트
      updateStage(currentStage);
    },
  });

  // 클릭 이벤트로 해당 단계로 이동
  items.forEach((item, index) => {
    item.addEventListener("click", () => {
      const triggers = ScrollTrigger.getAll();
      const trigger = triggers.find((t) => t.trigger === section);

      if (trigger) {
        const targetProgress = index / (stages.length - 1);
        const targetScroll =
          trigger.start + (trigger.end - trigger.start) * targetProgress;

        // Lenis를 사용한 부드러운 스크롤
        if (window.lenis) {
          window.lenis.scrollTo(targetScroll, {
            duration: 1,
            easing: (t) =>
              t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1, // easeInOutCubic
          });
        } else {
          // Lenis가 없을 경우 일반 스크롤
          window.scrollTo({
            top: targetScroll,
            behavior: "smooth",
          });
        }
      }
    });
  });
}

function subSnapAnimation() {
  const snapItems = document.querySelectorAll(".no-sub-about-snap-item");
  if (!snapItems.length) return;

  // 각 아이템의 초기 설정 및 복제
  const itemsData = Array.from(snapItems).map((item, liIndex) => {
    // 원본 내용을 2번 복제하여 무한 루프 구현
    const innerContent = item.innerHTML;
    item.innerHTML = innerContent + innerContent + innerContent;

    // 전체 너비 계산 (복제된 콘텐츠 포함)
    const itemWidth = item.scrollWidth / 3; // 3번 복제했으므로 1/3이 원본 너비

    // li 인덱스 기준으로 rotation 결정
    // 1번째(0), 3번째(2) li: -2deg / 2번째(1) li: 2deg
    const rotation = liIndex % 2 === 0 ? -2 : 2;

    // 아이템 자체만 살짝 기울임 (wrap에는 회전 적용하지 않음)
    gsap.set(item, {
      rotation: rotation,
      force3D: true,
    });

    return {
      element: item,
      direction: item.dataset.direction === "right" ? 1 : -1,
      baseSpeed: 0.3, // 기본 자동 이동 속도
      scrollSpeed: 0.8, // 스크롤 시 추가 속도
      currentX: 0,
      targetX: 0,
      itemWidth: itemWidth, // 리셋 기준점
    };
  });

  let lastScrollY = window.scrollY;
  let scrollVelocity = 0;

  // Lenis 스크롤 이벤트 활용
  if (window.lenis) {
    window.lenis.on("scroll", ({ scroll, velocity }) => {
      scrollVelocity = velocity;
    });
  }

  // 애니메이션 루프
  function animate() {
    itemsData.forEach((item) => {
      // 기본 자동 이동 (조금씩)
      const autoMove = item.baseSpeed * item.direction;

      // 스크롤 양에 따른 추가 이동
      const scrollMove = scrollVelocity * item.scrollSpeed * item.direction;

      // 목표 위치 업데이트
      item.targetX += autoMove + scrollMove;

      // 부드러운 이징 적용 (lerp)
      item.currentX += (item.targetX - item.currentX) * 0.08;

      // 무한 루프: 한 세트가 지나가면 위치 리셋
      if (item.direction === 1) {
        // 오른쪽으로 이동 (양수)
        if (item.currentX >= item.itemWidth) {
          item.currentX -= item.itemWidth;
          item.targetX -= item.itemWidth;
        }
      } else {
        // 왼쪽으로 이동 (음수)
        if (item.currentX <= -item.itemWidth) {
          item.currentX += item.itemWidth;
          item.targetX += item.itemWidth;
        }
      }

      // GSAP으로 실제 DOM 업데이트 (최적화된 transform)
      gsap.set(item.element, {
        x: item.currentX,
        force3D: true, // GPU 가속
      });
    });

    // 스크롤 속도 감소 (Lenis가 없을 경우 대비)
    if (!window.lenis) {
      scrollVelocity *= 0.95;
    }

    requestAnimationFrame(animate);
  }

  // 애니메이션 시작
  animate();

  // Lenis가 없을 경우 일반 스크롤 이벤트로 대체
  if (!window.lenis) {
    let ticking = false;

    window.addEventListener("scroll", () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          const currentScrollY = window.scrollY;
          scrollVelocity = (currentScrollY - lastScrollY) * 0.5;
          lastScrollY = currentScrollY;
          ticking = false;
        });
        ticking = true;
      }
    });
  }
}

function subHistoryAnimation() {
  const section = document.querySelector(".no-sub-about-history");
  if (!section) return;

  const fixedYear = document.getElementById("fixed-year");
  const fixedMonth = document.getElementById("fixed-month");
  const historyItems = section.querySelectorAll(".no-sub-about-history-item");

  if (!fixedYear || !fixedMonth || !historyItems.length) return;

  // 숫자 카운팅 애니메이션 함수
  const animateNumber = (element, targetValue) => {
    const currentValue = parseInt(element.textContent);
    if (currentValue === targetValue) return;

    gsap.to(
      { value: currentValue },
      {
        value: targetValue,
        duration: 0.6,
        ease: "power2.inOut",
        onUpdate: function () {
          element.textContent = Math.round(this.targets()[0].value);
        },
      }
    );
  };

  // 각 history-item에 ScrollTrigger 설정
  historyItems.forEach((item) => {
    const year = parseInt(item.dataset.year);
    const month = parseInt(item.dataset.month);

    ScrollTrigger.create({
      trigger: item,
      start: "top center",
      end: "bottom center",
      onEnter: () => {
        animateNumber(fixedYear, year);
        animateNumber(fixedMonth, month);
      },
      onEnterBack: () => {
        animateNumber(fixedYear, year);
        animateNumber(fixedMonth, month);
      },
    });
  });
}

// 전역 함수로 선언하여 intro에서 호출 가능하도록
window.initMainSwiper = function () {
  const swiperContainer = document.querySelector(".no-main-visual-swiper");
  if (!swiperContainer) return;

  const progressBar = swiperContainer.querySelector(
    ".no-main-visual-progress-bar"
  );

  // 실제 슬라이드 개수 계산 (클론 제외)
  const realSlides = swiperContainer.querySelectorAll(
    ".swiper-wrapper > .swiper-slide"
  );
  const slideCount = realSlides.length;
  const enableLoop = slideCount > 1;
  const enableAutoplay = slideCount > 1;

  const swiper = new Swiper(".no-main-visual-swiper", {
    loop: enableLoop,
    speed: 1200,
    effect: "fade",
    fadeEffect: {
      crossFade: true,
    },
    autoplay: enableAutoplay
      ? {
          delay: 4000,
          disableOnInteraction: false,
        }
      : false,
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
        // 슬라이드가 1개면 컨트롤 숨김 및 진행바 초기화
        if (slideCount <= 1 && controls) {
          controls.style.display = "none";
          if (progressBar) progressBar.style.width = "0%";
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
};

function initLenis() {
  const lenis = new Lenis();
  window.lenis = lenis; // 전역 접근 가능하도록

  lenis.on("scroll", ScrollTrigger.update);

  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });

  gsap.ticker.lagSmoothing(0);
}

function initScrollToTop() {
  const scrollToTopBtn = document.getElementById("scrollToTop");
  if (!scrollToTopBtn) return;

  const iconEl = scrollToTopBtn.querySelector("i");

  scrollToTopBtn.addEventListener("click", () => {
    if (window.lenis) {
      window.lenis.scrollTo(0, {
        duration: 1.5,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      });
    } else {
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  });

  // 통합 스크롤 핸들러
  const handleScroll = () => {
    const scrollY = window.scrollY || window.pageYOffset;
    const doc = document.documentElement;
    const maxScroll = doc.scrollHeight - window.innerHeight;

    // 버튼 표시/숨김
    scrollToTopBtn.classList.toggle("show", scrollY > 300);
  };

  // Lenis 사용 시
  if (window.lenis) {
    window.lenis.on("scroll", handleScroll);
  } else {
    // 기본 스크롤
    let ticking = false;
    window.addEventListener("scroll", () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          handleScroll();
          ticking = false;
        });
        ticking = true;
      }
    });
  }

  // 초기 상태
  handleScroll();
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

function customCursor() {
  const cursor = new MouseFollower({
    speed: 0.25,
    stateDetection: {
      "-pointer": "a, button",
      "-hidden": "input, textarea, select",
    },
  });
}
