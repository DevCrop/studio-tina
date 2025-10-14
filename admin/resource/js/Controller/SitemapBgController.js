import { fetcher } from "../core/fetcher.js";
import { API } from "../core/apiRoutes.js";

export class SitemapBgController {
  constructor({
    formSelector = "#frm",
    updateBtnSelector = "#submitBtn",
  } = {}) {
    this.form = document.querySelector(formSelector);
    this.updateBtn = document.querySelector(updateBtnSelector);
  }

  init() {
    console.log("[SitemapBgController] Initialized");
    this.bindFormEvents();
  }

  bindFormEvents() {
    if (this.form && this.updateBtn) {
      this.updateBtn.addEventListener("click", this.update.bind(this));
    }
  }

  async update(e) {
    e.preventDefault();

    // 5개의 이미지 필드
    const imageFields = [
      "sitemap_bg_default",
      "sitemap_bg_about",
      "sitemap_bg_works",
      "sitemap_bg_news",
      "sitemap_bg_contact",
    ];

    // 파일 크기 체크 (1MB = 1048576 bytes)
    for (const field of imageFields) {
      const fileInput = document.getElementById(field);
      if (fileInput && fileInput.files.length > 0) {
        const fileSize = fileInput.files[0].size;
        if (fileSize > 1048576) {
          alert(
            `${field}: 파일 크기가 1MB를 초과합니다.\n1MB 이하의 파일을 업로드해주세요.`
          );
          fileInput.focus();
          return;
        }
      }
    }

    const formData = new FormData(this.form);
    formData.set("mode", "update");
    await this.sendRequest(formData, "사이트맵 배경 이미지가 저장되었습니다.");
  }

  async sendRequest(formData, successMessage) {
    try {
      const res = await fetcher(API.SITEMAP_BG, formData);

      alert(successMessage);
      location.href = "/admin/pages/sitemap/index.php";
    } catch (err) {
      alert(err.message || "처리 중 오류가 발생했습니다.");
    }
  }
}
