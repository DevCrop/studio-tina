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
        <div class="popup-content">
          <button class="close-btn">&times;</button>
          <div class="plyr-video-container">
            <div class="plyr" data-plyr-provider="youtube" data-plyr-embed-id=""></div>
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

  handleClick(videoId) {
    if (this.isOpen) {
      this.close();
    } else {
      this.open(videoId);
    }
  }

  open(videoId) {
    if (this.isOpen) return;

    // SpiralGallery에 팝업 열림 알림 (천천히 멈추도록)
    if (window.spiralGallery) {
      window.spiralGallery.onPopupOpen();
    }

    // PLYR 플레이어 초기화
    const plyrContainer = this.popupElement.querySelector(".plyr");
    plyrContainer.setAttribute("data-plyr-embed-id", videoId);

    // 팝업 표시
    this.popupElement.classList.add("active");
    document.body.style.overflow = "hidden";

    // PLYR 플레이어 초기화 (약간의 지연 후)
    setTimeout(() => {
      if (window.Plyr) {
        // 기존 플레이어가 있다면 제거
        if (this.currentPlayer) {
          this.currentPlayer.destroy();
        }

        this.currentPlayer = new Plyr(plyrContainer, {
          controls: [
            "play-large",
            "play",
            "progress",
            "current-time",
            "mute",
            "volume",
            "settings",
            "fullscreen",
          ],
          settings: ["quality", "speed"],
          quality: {
            default: 720,
            options: [1080, 720, 480, 360],
          },
        });

        // 플레이어 이벤트 리스너
        this.currentPlayer.on("ready", () => {
          console.log("PLYR 플레이어 준비 완료");
        });

        this.currentPlayer.on("play", () => {
          console.log("비디오 재생 시작");
        });
      }
    }, 100);

    this.isOpen = true;
  }

  close() {
    if (!this.isOpen) return;

    // SpiralGallery에 팝업 닫힘 알림 (다시 회전 시작)
    if (window.spiralGallery) {
      window.spiralGallery.onPopupClose();
    }

    // 플레이어 정지 및 제거
    if (this.currentPlayer) {
      this.currentPlayer.stop();
      this.currentPlayer.destroy();
      this.currentPlayer = null;
    }

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
