// Works Portfolio Fetch
class WorksPortfolio {
  constructor() {
    this.apiUrl = "/api/fetch.php";
    this.currentCategory = null;
    this.currentPage = 1;
    this.container = document.querySelector(".no-sub-works-portfolio-list");
    this.paginationContainer = document.querySelector(".no-pagination");
    this.init();
  }

  init() {
    this.setupCategoryButtons();
    this.loadWorks(null, 1); // 초기 로드 (전체)
  }

  setupCategoryButtons() {
    const categoryButtons = document.querySelectorAll(
      ".no-category button[data-category]"
    );

    categoryButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        const categoryNo = button.dataset.categoryNo
          ? parseInt(button.dataset.categoryNo)
          : null;

        this.currentCategory = categoryNo;
        this.currentPage = 1;

        // 디바운스 적용: 0.5초 후에 마지막 요청만 실행
        this.debouncedLoadWorks(categoryNo, 1);
      });
    });
  }

  // ES6 디바운스 함수
  debounce = (func, delay) => {
    let timeoutId;
    return (...args) => {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
  };

  // 디바운스된 로드 함수
  debouncedLoadWorks = this.debounce((categoryNo, page) => {
    this.loadWorks(categoryNo, page);
  }, 1000);

  async loadWorks(categoryNo = null, page = 1) {
    try {
      // 로딩 표시
      this.showLoading();

      // API 호출
      const params = new URLSearchParams();
      if (categoryNo !== null && categoryNo !== 0) {
        params.append("category_no", categoryNo);
      }
      params.append("page", page);
      params.append("perpage", 12);

      const response = await fetch(`${this.apiUrl}?${params.toString()}`);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const result = await response.json();

      if (result.success) {
        this.renderWorks(result.data.list);
        this.renderPagination(result.data.pagination);
      } else {
        throw new Error(result.error || "데이터를 불러오는데 실패했습니다.");
      }
    } catch (error) {
      this.showError(error.message);
      if (this.paginationContainer) {
        this.paginationContainer.style.display = "none";
      }
    }
  }

  renderWorks(works) {
    if (!this.container) return;

    // 데이터가 없는 경우
    if (!works || works.length === 0) {
      this.container.innerHTML = `
        <li class="no-data">
          <p class="f-heading-4">게시글이 존재하지 않습니다.</p>
        </li>
      `;
      return;
    }

    // 데이터 렌더링
    this.container.innerHTML = works
      .map(
        (work) => `
      <li class="no-sub-works-portfolio-item fade-up">
        <a href="/works/${work.no || ""}">
          <figure>
            <img src="${work.image_url || ""}" alt="${this.escapeHtml(
          work.title || ""
        )}">
          </figure>
          <div class="no-sub-works-portfolio-item-txt">
            <h3 class="f-heading-4 --fm-ko --bold">${this.escapeHtml(
              work.title || ""
            )}</h3>
            <p>${this.escapeHtml(
              this.truncateText(work.contents || "", 100)
            )}</p>
          </div>
        </a>
      </li>
    `
      )
      .join("");

    // 동적으로 생성된 요소들에 fade-up 애니메이션 적용
    this.applyFadeUpAnimation();
  }

  truncateText(text, maxLength) {
    if (!text) return "";

    // API에서 이미 전처리된 텍스트이므로 길이만 조절
    const trimmed = text.trim();
    if (trimmed.length <= maxLength) return trimmed;
    return trimmed.substring(0, maxLength) + "...";
  }

  escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
  }

  applyFadeUpAnimation() {
    // GSAP이 로드되었는지 확인
    if (typeof gsap === "undefined") {
      console.warn("GSAP not loaded");
      return;
    }

    // 현재 컨테이너 내의 fade-up 요소들만 선택
    const fadeUpElements = this.container.querySelectorAll(".fade-up");

    if (!fadeUpElements.length) return;

    fadeUpElements.forEach((element, index) => {
      // 초기 상태 설정
      gsap.set(element, {
        y: 50,
        opacity: 0,
      });

      // Intersection Observer 설정
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              // 요소가 보이면 애니메이션 실행
              gsap.to(element, {
                y: 0,
                opacity: 1,
                duration: 0.8,
                delay: index * 0.1, // 각 요소마다 0.1초씩 차이
                ease: "power2.out",
                onComplete: () => {
                  // 애니메이션 완료 후 observer 해제
                  observer.unobserve(element);
                },
              });
            }
          });
        },
        {
          threshold: 0.1, // 10% 보이면 트리거
          rootMargin: "0px 0px -50px 0px", // 하단에서 50px 여유
        }
      );

      // 요소 관찰 시작
      observer.observe(element);
    });
  }

  showLoading() {
    if (!this.container) return;
    this.container.innerHTML = `
      <li class="loading">
        <p class="f-heading-4">로딩 중...</p>
      </li>
    `;
  }

  showError(message) {
    if (!this.container) return;
    this.container.innerHTML = `
      <li class="error">
        <p class="f-heading-4">오류: ${this.escapeHtml(message)}</p>
      </li>
    `;
  }

  renderPagination(pagination) {
    if (!this.paginationContainer) return;

    const totalPages = pagination?.total_pages || 0;
    const curPage = pagination?.current_page || 1;
    const side = 2; // 좌우 표시할 개수

    // 페이지가 0개면 숨기기 (게시글이 아예 없을 때만)
    if (totalPages <= 0) {
      this.paginationContainer.style.display = "none";
      return;
    }

    this.paginationContainer.style.display = "flex";

    const start = Math.max(1, curPage - side);
    const end = Math.min(totalPages, curPage + side);

    let html = `
      <!-- 맨 처음 -->
      <a href="javascript:void(0);" class="--arrow --first" data-page="1" ${
        curPage === 1 ? "disabled" : ""
      }>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="11 17 6 12 11 7"></polyline>
          <polyline points="18 17 13 12 18 7"></polyline>
        </svg>
      </a>

      <!-- 이전 -->
      <a href="javascript:void(0);" class="--arrow --prev" data-page="${Math.max(
        1,
        curPage - 1
      )}" ${curPage === 1 ? "disabled" : ""}>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </a>

      <div class="--numbers">
    `;

    // 시작 부분 처리
    if (start > 1) {
      html += '<a href="javascript:void(0);" data-page="1">1</a>';
      if (start > 2) {
        html += '<span class="--dots">...</span>';
      }
    }

    // 중앙 페이지 출력
    for (let i = start; i <= end; i++) {
      const active = i === curPage ? "active" : "";
      html += `<a href="javascript:void(0);" class="${active}" data-page="${i}">${i}</a>`;
    }

    // 끝 부분 처리
    if (end < totalPages) {
      if (end < totalPages - 1) {
        html += '<span class="--dots">...</span>';
      }
      html += `<a href="javascript:void(0);" data-page="${totalPages}">${totalPages}</a>`;
    }

    html += `
      </div>

      <!-- 다음 -->
      <a href="javascript:void(0);" class="--arrow --next" data-page="${Math.min(
        totalPages,
        curPage + 1
      )}" ${curPage === totalPages ? "disabled" : ""}>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </a>

      <!-- 맨 끝 -->
      <a href="javascript:void(0);" class="--arrow --last" data-page="${totalPages}" ${
      curPage === totalPages ? "disabled" : ""
    }>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="13 17 18 12 13 7"></polyline>
          <polyline points="6 17 11 12 6 7"></polyline>
        </svg>
      </a>
    `;

    this.paginationContainer.innerHTML = html;
    this.setupPaginationEvents();
  }

  setupPaginationEvents() {
    if (!this.paginationContainer) return;

    const pageLinks = this.paginationContainer.querySelectorAll("a[data-page]");

    pageLinks.forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();

        if (link.hasAttribute("disabled")) return;

        const page = parseInt(link.dataset.page);

        if (page && page !== this.currentPage) {
          this.currentPage = page;

          // 디바운스 적용: 0.5초 후에 마지막 요청만 실행
          this.debouncedLoadWorks(this.currentCategory, page);

          // 페이지 최상단으로 스크롤
          window.scrollTo({
            top: 0,
            behavior: "smooth",
          });
        }
      });
    });
  }
}

// DOM 로드 완료 시 초기화
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", () => {
    new WorksPortfolio();
  });
} else {
  new WorksPortfolio();
}
