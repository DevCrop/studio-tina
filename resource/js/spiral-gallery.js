class SpiralGallery {
  constructor(containerId) {
    this.RADIUS = 640;
    this.SLICE_COUNT = 12;
    this.ITEM_SHIFT = 48;

    this.container = document.getElementById(containerId);
    this.gallery = null;
    this.imageDisplay = null;
    this.animId = 0;

    this.angleUnit = 0;
    this.sliceIndex = 0;
    this.currentAngle = 0;
    this.currentY = 0;
    this.mouseX = 0;
    this.mouseY = 0;

    // 자동 회전 관련 변수
    this.rotationSpeed = 0.1; // 회전 속도 (조절 가능)

    // 드래그 관련 변수
    this.isDragging = false;
    this.lastMouseX = 0;
    this.dragSensitivity = 0.5; // 드래그 민감도

    // 관성 관련 변수
    this.velocity = 0; // 회전 속도
    this.friction = 0.97; // 마찰력 (0.97 = 3% 감속) - 더 오래 회전
    this.minVelocity = 0.005; // 최소 속도 (이보다 작으면 정지) - 더 민감하게

    // 팝업 상태 관리
    this.isPopupOpen = false;
    this.stopFriction = 0.85; // 팝업 열릴 때 감속력 (더 빠르게 멈춤)

    this.imageData = [
      {
        image: "resource/images/works/works_img_1.jpg",
        video: "dQw4w9WgXcQ",
        category: "Category 1",
        title: "Title 1",
      },
      {
        image: "resource/images/works/works_img_2.jpg",
        video: "jNQXAC9IVRw",
        category: "Category 2",
        title: "Title 2",
      },
      {
        image: "resource/images/works/works_img_3.jpg",
        video: "kJQP7kiw5Fk",
        category: "Category 3",
        title: "Title 3",
      },
      {
        image: "resource/images/works/works_img_4.jpg",
        video: "fJ9rUzIMcZQ",
        category: "Category 4",
        title: "Title 4",
      },
      {
        image: "resource/images/works/works_img_1.jpg",
        video: "dQw4w9WgXcQ",
        category: "Category 1",
        title: "Title 1",
      },
      {
        image: "resource/images/works/works_img_2.jpg",
        video: "jNQXAC9IVRw",
        category: "Category 2",
        title: "Title 2",
      },
      {
        image: "resource/images/works/works_img_3.jpg",
        video: "kJQP7kiw5Fk",
        category: "Category 3",
        title: "Title 3",
      },
      {
        image: "resource/images/works/works_img_4.jpg",
        video: "fJ9rUzIMcZQ",
        category: "Category 4",
        title: "Title 4",
      },
      {
        image: "resource/images/works/works_img_1.jpg",
        video: "dQw4w9WgXcQ",
        category: "Category 1",
        title: "Title 1",
      },
      {
        image: "resource/images/works/works_img_2.jpg",
        video: "jNQXAC9IVRw",
        category: "Category 2",
        title: "Title 2",
      },
      {
        image: "resource/images/works/works_img_3.jpg",
        video: "kJQP7kiw5Fk",
        category: "Category 3",
        title: "Title 3",
      },
      {
        image: "resource/images/works/works_img_4.jpg",
        video: "fJ9rUzIMcZQ",
        category: "Category 4",
        title: "Title 4",
      },
      {
        image: "resource/images/works/works_img_1.jpg",
        video: "dQw4w9WgXcQ",
        category: "Category 1",
        title: "Title 1",
      },
      {
        image: "resource/images/works/works_img_2.jpg",
        video: "jNQXAC9IVRw",
        category: "Category 2",
        title: "Title 2",
      },
      {
        image: "resource/images/works/works_img_3.jpg",
        video: "kJQP7kiw5Fk",
        category: "Category 3",
        title: "Title 3",
      },
      {
        image: "resource/images/works/works_img_4.jpg",
        video: "fJ9rUzIMcZQ",
        category: "Category 4",
        title: "Title 4",
      },
    ];

    this.init();
  }

  init() {
    this.createGallery();
    this.setupDragEvents();
    this.startAutoRotation();
  }

  createGallery() {
    // 갤러리 아이템들을 템플릿 리터럴로 생성
    const galleryItems = this.imageData
      .map(
        (itemData, index) =>
          `
          <div class="spiral-gallery-item" data-image-url="${itemData.image}" data-video-id="${itemData.video}">
            <a href="#" class="gallery-link">
              <figure>
                <img src="${itemData.image}" alt="${itemData.image}">
              </figure>
              <div class="spiral-gallery-item-txt">
                <span>${itemData.category}</span>
                <h3>${itemData.title}</h3>
              </div>
            </a>
          </div>
          `
      )
      .join("");

    // 전체 갤러리 HTML 구조
    const galleryHTML = `
      <div class="spiral-gallery">
        ${galleryItems}
      </div>
    `;

    // 컨테이너에 HTML 삽입
    this.container.innerHTML = galleryHTML;

    // 요소 참조 설정
    this.gallery = this.container.querySelector(".spiral-gallery");

    // 이벤트 리스너 설정
    this.setupEventListeners();

    // Initialize positions
    this.resetParameters();
    this.positionItems();

    // 컨테이너 높이 동적 조정
    this.adjustContainerHeight();
  }

  setupEventListeners() {
    // 갤러리 아이템 클릭 이벤트 (Popover와 협력)
    this.gallery.querySelectorAll(".spiral-gallery-item").forEach((item) => {
      item.addEventListener("click", (e) => {
        e.preventDefault();
        // 드래그 중이 아닐 때만 팝오버 열기
        if (!this.isDragging) {
          const videoId = item.getAttribute("data-video-id");
          // Popover 객체의 handleClick 메서드 호출
          if (window.popover) {
            window.popover.handleClick(videoId);
          }
        }
      });
    });
  }

  resetParameters() {
    this.angleUnit = 360 / this.SLICE_COUNT;
    this.sliceIndex = 0;
    this.mouseX = 0;
    this.mouseY = 0;
    this.currentAngle = 0;
    this.currentY = 0;
  }

  positionItems() {
    const items = this.gallery.children;

    for (let i = 0; i < items.length; i++) {
      const item = items[i];
      const itemAngle = this.angleUnit * this.sliceIndex;
      const itemAngleRad = (itemAngle * Math.PI) / 180;
      const xpos = Math.sin(itemAngleRad) * this.RADIUS;
      const zpos = Math.cos(itemAngleRad) * this.RADIUS;

      // spiral 각도에 따른 skew 효과 추가 (첫 번째 아이템부터 적용)
      const skewValue = (itemAngle + 30) * 0.03; // +30도 오프셋으로 첫 번째부터 기울기 적용

      item.style.transform = `translateX(${xpos}px) translateZ(${zpos}px) translateY(${
        i * this.ITEM_SHIFT
      }px) rotateY(${itemAngle}deg) skewY(${skewValue}deg)`;

      if (++this.sliceIndex === this.SLICE_COUNT) {
        this.sliceIndex = 0;
      }
    }
  }

  adjustContainerHeight() {
    // 모든 아이템의 위치를 계산하여 필요한 최대 높이 구하기
    const items = this.gallery.children;
    let maxY = 0;
    let minY = 0;

    for (let i = 0; i < items.length; i++) {
      const itemAngle = this.angleUnit * (i % this.SLICE_COUNT);
      const itemAngleRad = (itemAngle * Math.PI) / 180;
      const xpos = Math.sin(itemAngleRad) * this.RADIUS;
      const zpos = Math.cos(itemAngleRad) * this.RADIUS;
      const ypos = i * this.ITEM_SHIFT;

      // skew 효과로 인한 높이 변화 고려 (첫 번째 아이템부터 적용)
      const skewValue = (itemAngle + 30) * 0.03; // +30도 오프셋으로 첫 번째부터 기울기 적용

      // CSS에서 height가 제거되었으므로 동적으로 계산
      // 이미지의 자연스러운 비율을 고려한 높이 (width 대비 비율)
      const itemWidth = 180; // CSS에서 설정된 width값 (fluid(180, 326)의 기본값)
      const aspectRatio = 1.4; // 일반적인 이미지 비율 (width:height = 1:1.4)
      const itemHeight = itemWidth * aspectRatio;

      // skew 효과로 인한 높이 변화 계산
      const skewHeightAdjustment =
        Math.abs(Math.tan((skewValue * Math.PI) / 180)) * itemHeight;

      // 아이템의 상단과 하단 위치 계산 (skew 효과 고려)
      const itemTop = ypos - (itemHeight + skewHeightAdjustment) / 2;
      const itemBottom = ypos + (itemHeight + skewHeightAdjustment) / 2;

      minY = Math.min(minY, itemTop);
      maxY = Math.max(maxY, itemBottom);
    }

    // 여백 추가 (상하 100px씩)
    const padding = 100;
    const requiredHeight = maxY - minY + padding * 2;

    // 컨테이너 높이 설정
    this.container.style.height = `${Math.max(requiredHeight, 640)}px`; // 최소 640px 보장
  }

  setupDragEvents() {
    // 이벤트 핸들러를 메서드로 정의하여 제거 가능하게 함
    this.handleMouseDown = (e) => {
      e.preventDefault(); // 기본 드래그 동작 방지
      this.isDragging = true;
      this.lastMouseX = e.clientX;
      this.container.style.cursor = "grabbing";
    };

    this.handleMouseMove = (e) => {
      if (this.isDragging) {
        e.preventDefault(); // 기본 드래그 동작 방지
        const deltaX = e.clientX - this.lastMouseX;
        const deltaAngle = deltaX * this.dragSensitivity;

        // 관성 속도 계산 (드래그 속도에 비례) - 더 민감하게
        this.velocity = deltaAngle * 0.3; // 드래그 속도를 관성으로 변환 (0.1 → 0.3)

        this.currentAngle += deltaAngle;
        this.lastMouseX = e.clientX;
      }
    };

    this.handleMouseUp = () => {
      this.isDragging = false;
      this.container.style.cursor = "grab";
    };

    this.handleTouchStart = (e) => {
      e.preventDefault(); // 기본 터치 동작 방지
      this.isDragging = true;
      this.lastMouseX = e.touches[0].clientX;
    };

    this.handleTouchMove = (e) => {
      if (this.isDragging) {
        e.preventDefault();
        const deltaX = e.touches[0].clientX - this.lastMouseX;
        const deltaAngle = deltaX * this.dragSensitivity;

        // 관성 속도 계산 (드래그 속도에 비례) - 더 민감하게
        this.velocity = deltaAngle * 0.3; // 드래그 속도를 관성으로 변환 (0.1 → 0.3)

        this.currentAngle += deltaAngle;
        this.lastMouseX = e.touches[0].clientX;
      }
    };

    this.handleTouchEnd = () => {
      this.isDragging = false;
    };

    // 컨테이너와 갤러리 아이템 모두에 이벤트 리스너 등록
    this.container.addEventListener("mousedown", this.handleMouseDown);
    document.addEventListener("mousemove", this.handleMouseMove);
    document.addEventListener("mouseup", this.handleMouseUp);
    this.container.addEventListener("touchstart", this.handleTouchStart);
    document.addEventListener("touchmove", this.handleTouchMove);
    document.addEventListener("touchend", this.handleTouchEnd);

    // 갤러리 아이템들에도 동일한 이벤트 추가
    this.gallery.querySelectorAll(".spiral-gallery-item").forEach((item) => {
      item.addEventListener("mousedown", this.handleMouseDown);
      item.addEventListener("touchstart", this.handleTouchStart);
    });

    // 커서 스타일 설정
    this.container.style.cursor = "grab";
  }

  startAutoRotation() {
    const updateFrame = () => {
      // 드래그 중이 아닐 때만 관성 적용
      if (!this.isDragging) {
        // 팝업이 열려있으면 더 빠르게 멈춤
        const currentFriction = this.isPopupOpen
          ? this.stopFriction
          : this.friction;

        // 관성이 있을 때는 관성으로 회전
        if (Math.abs(this.velocity) > this.minVelocity) {
          this.currentAngle += this.velocity;
          this.velocity *= currentFriction; // 팝업 상태에 따른 마찰 적용
        } else {
          // 관성이 없을 때는 팝업이 닫혀있을 때만 자동 회전
          if (!this.isPopupOpen) {
            this.currentAngle += this.rotationSpeed;
          }
        }
      }

      // 중심점을 유지하면서 회전만 적용
      this.gallery.style.transform = `translateZ(-200px) translateY(0px) rotateY(${this.currentAngle}deg)`;

      this.animId = requestAnimationFrame(updateFrame);
    };

    updateFrame();
  }

  // 회전 속도 조절 메서드
  setRotationSpeed(speed) {
    this.rotationSpeed = speed;
  }

  // 회전 일시정지/재개 메서드
  pause() {
    this.rotationSpeed = 0;
  }

  resume(speed = 0.1) {
    this.rotationSpeed = speed;
  }

  // 관성 설정 메서드
  setFriction(friction) {
    this.friction = friction; // 0.9 ~ 0.99 권장 (낮을수록 빨리 멈춤)
  }

  setMinVelocity(minVel) {
    this.minVelocity = minVel; // 관성이 이 값보다 작으면 정지
  }

  // 관성 즉시 정지
  stopInertia() {
    this.velocity = 0;
  }

  // 팝업 상태 관리 메서드들
  onPopupOpen() {
    this.isPopupOpen = true;
    console.log("팝업 열림 - 갤러리 천천히 멈춤");
  }

  onPopupClose() {
    this.isPopupOpen = false;
    console.log("팝업 닫힘 - 갤러리 회전 재개");
  }

  // 팝업 상태에 따른 감속력 조절
  setStopFriction(friction) {
    this.stopFriction = friction; // 0.8 ~ 0.9 권장 (낮을수록 빨리 멈춤)
  }

  destroy() {
    if (this.animId) {
      cancelAnimationFrame(this.animId);
    }

    // 드래그 이벤트 리스너 제거
    this.container.removeEventListener("mousedown", this.handleMouseDown);
    document.removeEventListener("mousemove", this.handleMouseMove);
    document.removeEventListener("mouseup", this.handleMouseUp);
    this.container.removeEventListener("touchstart", this.handleTouchStart);
    document.removeEventListener("touchmove", this.handleTouchMove);
    document.removeEventListener("touchend", this.handleTouchEnd);

    // 갤러리 아이템 이벤트 리스너 제거
    this.gallery.querySelectorAll(".spiral-gallery-item").forEach((item) => {
      item.removeEventListener("mousedown", this.handleMouseDown);
      item.removeEventListener("touchstart", this.handleTouchStart);
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  let container = document.getElementById("spiral-gallery-container");
  if (!container) return;

  container = document.createElement("div");
  container.id = "spiral-gallery-container";
  container.className = "container my-4";

  const mainContent =
    document.querySelector("main") ||
    document.querySelector(".main") ||
    document.body;
  mainContent.appendChild(container);

  const spiralGallery = new SpiralGallery("spiral-gallery-container");

  // Make it globally accessible if needed
  window.spiralGallery = spiralGallery;

  // 회전 속도 조절
  window.spiralGallery.setRotationSpeed(0.12);

  // 관성 민감도 조절
  window.spiralGallery.setFriction(0.98); // 매우 오래 회전 (2% 감속)
  window.spiralGallery.setMinVelocity(0.003); // 매우 민감하게 반응

  // 팝업 열릴 때 감속력 조절 (더 빠르게 멈춤)
  window.spiralGallery.setStopFriction(0.85); // 15% 감속으로 빠르게 멈춤
});
