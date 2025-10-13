import { fetcher } from "../core/fetcher.js";
import { API } from "../core/apiRoutes.js";

export class EtcController {
  constructor({ formSelector = "#frm", updateBtnSelector = "#editBtn" } = {}) {
    this.form = document.querySelector(formSelector);
    this.updateBtn = document.querySelector(updateBtnSelector);
  }

  init() {
    console.log("[EtcController.js] 초기화됨");

    if (this.form && this.updateBtn) {
      this.updateBtn.addEventListener("click", this.update.bind(this));
    }
  }

  async update(e) {
    e.preventDefault();
    const formData = new FormData(this.form);
    formData.set("mode", "update");

    try {
      const res = await fetcher(API.ETC, formData); //
      alert(res.message || "저장되었습니다.");
      location.reload();
    } catch (err) {
      alert(err.message || "처리 중 오류가 발생했습니다.");
    }
  }
}
