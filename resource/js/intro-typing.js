/**
 * Main Intro Typing Animation
 * GSAP을 사용한 타이핑 효과
 * 페이지 로드 시 항상 실행되며 Skip 버튼으로 건너뛸 수 있음
 */

class IntroTyping {
  constructor(options = {}) {
    // 옵션 설정
    this.texts = options.texts || ["This is Not AI", "STUDIO TINA"];

    // DOM 요소
    this.introSection = document.getElementById("mainIntro");
    this.typingText = document.getElementById("typingText");
    this.skipButton = document.getElementById("skipIntro");

    // Promise resolve 함수 저장
    this.resolveIntro = null;

    if (!this.introSection || !this.typingText) {
      return Promise.resolve();
    }
  }

  init() {
    return new Promise((resolve) => {
      this.resolveIntro = resolve;

      // Lenis 스크롤 중지 (여러 방법으로 시도)
      const stopLenis = () => {
        if (window.lenis) {
          window.lenis.stop();
          console.log("Intro 시작 - Lenis 스크롤 중지");
        } else {
          // Lenis가 아직 로드되지 않았다면 잠시 후 다시 시도
          setTimeout(stopLenis, 100);
        }
      };

      // 즉시 시도
      stopLenis();

      // 스킵 버튼 이벤트
      if (this.skipButton) {
        this.skipButton.addEventListener("click", () => {
          this.skipIntro();
        });
      }

      // 애니메이션 시작
      this.startAnimation();
    });
  }

  startAnimation() {
    const tl = gsap.timeline({
      onComplete: () => {
        this.skipIntro();
      },
    });

    // 배경 이미지 요소 찾기
    const bgImage = this.introSection.querySelector(".no-main-intro-bg img");

    // 1. "This is Not AI" 타이핑
    this.typeText(tl, this.texts[0], 0.1);

    // 2. 잠시 대기
    tl.to({}, { duration: 1 });

    // 3. 지우기 (텍스트 길이를 전달)
    this.eraseText(tl, this.texts[0].length, 0.05);

    // 4. "Studio Tina" 타이핑 시작과 동시에 배경 fade in
    tl.call(() => {
      if (bgImage) {
        gsap.fromTo(
          bgImage,
          { opacity: 0 },
          { opacity: 0.3, duration: 1, ease: "power2.out" }
        );
      }
    });

    this.typeText(tl, this.texts[1], 0.12);

    // 5. 잠시 대기
    tl.to({}, { duration: 1.5 });

    // 6. 커서(after) 제거
    tl.call(() => {
      this.typingText.classList.add("no-cursor");
    });

    // 7. Fade out
    tl.to(this.introSection, {
      opacity: 0,
      duration: 1,
      ease: "power2.inOut",
      onComplete: () => {
        this.introSection.style.display = "none";

        // Lenis 스크롤 재시작 (약간의 지연 후)
        setTimeout(() => {
          if (window.lenis) {
            window.lenis.start();
            console.log("Intro 애니메이션 완료 - Lenis 스크롤 재시작");
          }
        }, 100);
      },
    });
  }

  typeText(timeline, text, speed) {
    const chars = text.split("");

    chars.forEach((char, index) => {
      timeline.call(
        () => {
          this.typingText.textContent += char;
        },
        null,
        `+=${speed}`
      );
    });

    return timeline;
  }

  eraseText(timeline, length, speed) {
    // 지정된 길이만큼 한 글자씩 지우기
    for (let i = 0; i < length; i++) {
      timeline.call(
        () => {
          this.typingText.textContent = this.typingText.textContent.slice(
            0,
            -1
          );
        },
        null,
        `+=${speed}`
      );
    }

    return timeline;
  }

  skipIntro() {
    // 즉시 숨기기
    gsap.to(this.introSection, {
      opacity: 0,
      duration: 0.5,
      onComplete: () => {
        this.introSection.style.display = "none";

        // Lenis 스크롤 재시작 (약간의 지연 후)
        setTimeout(() => {
          if (window.lenis) {
            window.lenis.start();
            console.log("Intro 완료 - Lenis 스크롤 재시작");
          }
        }, 100);

        // Promise resolve 호출
        if (this.resolveIntro) {
          this.resolveIntro();
        }
      },
    });
  }
}

// 전역 함수로 인트로 시작
window.startIntro = async function () {
  const intro = new IntroTyping({
    texts: ["This is Not AI", "STUDIO TINA"],
  });

  await intro.init();

  // 인트로 완료 후 Swiper 초기화
  if (typeof window.initMainSwiper === "function") {
    window.initMainSwiper();
  }
};

// DOM 로드 후 자동 시작
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", () => {
    window.startIntro();
  });
} else {
  window.startIntro();
}
