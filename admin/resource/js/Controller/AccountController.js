import { fetcher } from "../core/fetcher.js";
import { attachPhoneAutoHyphen } from "../core/formatter.js";
import { API } from "../core/apiRoutes.js";
import { initCheckboxManager } from "../utils/initCheckboxManager.js";

export class AccountController {
  constructor(
    formSelector = "#frm",
    insertBtnSelector = "#submitBtn",
    updateBtnSelector = "#editBtn",
    deleteBtnSelector = ".delete-btn"
  ) {
    this.form = document.querySelector(formSelector);
    this.insertBtn = document.querySelector(insertBtnSelector);
    this.updateBtn = document.querySelector(updateBtnSelector);
    this.deleteButtons = document.querySelectorAll(deleteBtnSelector);
  }

  init() {
    console.log("[AccountController.js]");
    attachPhoneAutoHyphen();

    if (this.form && this.insertBtn) {
      this.insertBtn.addEventListener("click", this.insert.bind(this));
    }

    if (this.form && this.updateBtn) {
      this.updateBtn.addEventListener("click", this.update.bind(this));
    }

    this.attachDeleteEvents();

    initCheckboxManager(async (selectedIds) => {
      const formData = new FormData();
      formData.set("mode", "delete_array");
      formData.set("ids", JSON.stringify(selectedIds));
      await this.sendRequest(formData, "선택 항목이 삭제되었습니다.");
    });
  }

  async insert(e) {
    e.preventDefault();
    const formData = new FormData(this.form);
    formData.set("mode", "save");

    await this.sendRequest(formData, "저장되었습니다.");
  }

  async update(e) {
    e.preventDefault();
    const formData = new FormData(this.form);
    formData.set("mode", "update");

    await this.sendRequest(formData, "수정되었습니다.");
  }

  attachDeleteEvents() {
    this.deleteButtons.forEach((btn) => {
      btn.addEventListener("click", async () => {
        const id = btn.dataset.id;
        if (!id) return;
        if (!confirm("정말 삭제하시겠습니까?")) return;

        const formData = new FormData();
        formData.set("mode", "delete");
        formData.set("id", id);

        await this.sendRequest(formData, "삭제되었습니다.");
      });
    });
  }

  async sendRequest(formData, successMessage) {
    try {
      const res = await fetcher(API.ACCOUNT, formData);
      alert(res.message || successMessage);

      const mode = formData.get("mode");
      if (mode === "delete" || mode === "delete_array") {
        location.reload();
      } else {
        location.href = "/admin/pages/account";
      }
    } catch (err) {
      alert(err.message || "처리 중 오류가 발생했습니다.");
    }
  }
}
