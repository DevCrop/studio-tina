class Popover {
  constructor() {
    this.isOpen = false;
    this.currentPlayer = null;
    this.popupElement = null;
    this.init();
  }

  init() {
    this.createPopupHTML();
    this.setupEventListeners();
  }

  createPopupHTML() {
    // 팝업 HTML 구조 생성
    const popupHTML = `
      <div class="video-popup" id="video-popup">
      <button class="close-btn">&times;</button>
        <div class="popup-content">
          <div class="video-container">
            <iframe id="video-iframe" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    `;

    // body에 팝업 추가
    document.body.insertAdjacentHTML("beforeend", popupHTML);
    this.popupElement = document.getElementById("video-popup");
  }

  setupEventListeners() {
    // 닫기 버튼 이벤트
    const closeBtn = this.popupElement.querySelector(".close-btn");
    closeBtn.addEventListener("click", () => {
      this.close();
    });

    // 배경 클릭으로 닫기
    this.popupElement.addEventListener("click", (e) => {
      if (e.target === this.popupElement) {
        this.close();
      }
    });

    // ESC 키로 닫기
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && this.isOpen) {
        this.close();
      }
    });
  }

  handleClick(directUrl) {
    if (this.isOpen) {
      this.close();
    } else {
      this.open(directUrl);
    }
  }

  open(directUrl) {
    if (this.isOpen) return;

    // direct_url이 없으면 알림 표시 후 리턴
    if (!directUrl || directUrl.trim() === "") {
      alert("영상이 없습니다");
      return;
    }

    // Lenis 스크롤 중지
    if (window.lenis) {
      window.lenis.stop();
      console.log("모달 열림 - Lenis 스크롤 중지");
    }

    // SpiralGallery에 팝업 열림 알림 (천천히 멈추도록)
    if (window.spiralGallery) {
      window.spiralGallery.onPopupOpen();
    }

    // YouTube URL을 embed URL로 변환
    let embedUrl = directUrl;
    if (directUrl.includes("youtube.com/watch?v=")) {
      const videoId = directUrl.split("v=")[1].split("&")[0];
      embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
    } else if (directUrl.includes("youtu.be/")) {
      const videoId = directUrl.split("youtu.be/")[1].split("?")[0];
      embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
    } else if (!directUrl.includes("embed")) {
      // 직접 YouTube ID인 경우
      embedUrl = `https://www.youtube.com/embed/${directUrl}?autoplay=1&rel=0`;
    }

    // iframe에 URL 설정
    const iframe = this.popupElement.querySelector("#video-iframe");
    iframe.src = embedUrl;

    // 팝업 표시
    this.popupElement.classList.add("active");
    document.body.style.overflow = "hidden";

    this.isOpen = true;
  }

  close() {
    if (!this.isOpen) return;

    // Lenis 스크롤 재시작
    if (window.lenis) {
      window.lenis.start();
      console.log("모달 닫힘 - Lenis 스크롤 재시작");
    }

    // SpiralGallery에 팝업 닫힘 알림 (다시 회전 시작)
    if (window.spiralGallery) {
      window.spiralGallery.onPopupClose();
    }

    // iframe 정지 (src 제거)
    const iframe = this.popupElement.querySelector("#video-iframe");
    iframe.src = "";

    // 팝업 숨기기
    this.popupElement.classList.remove("active");
    document.body.style.overflow = "";

    this.isOpen = false;
  }

  destroy() {
    this.close();
    if (this.popupElement) {
      this.popupElement.remove();
    }
  }
}

// 전역 팝오버 인스턴스 생성
window.popover = new Popover();
