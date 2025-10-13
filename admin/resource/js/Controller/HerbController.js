import { fetcher } from "../core/fetcher.js";
import { API } from "../core/apiRoutes.js";
import { summernoteInit } from "../core/summernoteInit.js";
import { attachRadioToggle } from "../utils/initRadioToggle.js";

export class HerbController {
  constructor({
    formSelector = "#frm",
    updateBtnSelector = "#editBtn",
  } = {}) {
    this.form = document.querySelector(formSelector);
    this.updateBtn = document.querySelector(updateBtnSelector);
  }

  init() {
    console.log("[HerbController] Initialized");

    this.initEditors();
    this.bindFormEvents();

    attachRadioToggle({
      radioName: "is_confirmed",
      targetIds: ["confirm_by_block", "confirm_note_block"],
      toggleOnValue: "1",
      mode: "visibility",
    });
  }

  initEditors() {
    const noteEl = document.querySelector("#confirm_note");
    if (noteEl) {
      summernoteInit("#confirm_note");
    }
  }

  bindFormEvents() {
    if (this.form && this.updateBtn) {
      this.updateBtn.addEventListener("click", this.update.bind(this));
    }
    // 엔터로 submit될 수도 있으니 폼 submit도 케어
    if (this.form) {
      this.form.addEventListener("submit", (e) => {
        e.preventDefault();
        this.update(e);
      });
    }
  }

  async update(e) {
    e?.preventDefault?.();

    if (!this.form) return;

    // 더블클릭 방지
    if (this.updateBtn) this.updateBtn.disabled = true;

    try {
      const formData = new FormData(this.form);
      formData.set("mode", "update");

      const isConfirmed = formData.get("is_confirmed");
      if (String(isConfirmed) !== "1") {
        formData.set("confirm_by", "");
        formData.set("confirm_note", "");
      }

      const res = await fetcher(API.HERB, formData);

      if (res?.success) {
        alert(res.message || "저장되었습니다.");
        // 단순 리로드 (원하면 목록 경로로 변경)
        location.reload();
      } else {
        alert(res?.message || "저장 실패");
      }
    } catch (err) {
      alert(err?.message || "처리 중 오류가 발생했습니다.");
    } finally {
      if (this.updateBtn) this.updateBtn.disabled = false;
    }
  }
}
