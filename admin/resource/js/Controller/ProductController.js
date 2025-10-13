import { fetcher } from "../core/fetcher.js";
import { API } from "../core/apiRoutes.js";
import { summernoteInit } from "../core/summernoteInit.js";
import { initCheckboxManager } from "../utils/initCheckboxManager.js";

export class ProductController {
  constructor({
    formSelector = "#frm",
    insertBtnSelector = "#submitBtn",
    updateBtnSelector = "#editBtn",
    sortBtnSelector = ".sort-btn",
    deleteBtnSelector = ".delete-btn",
    categorySelector = "#product_category",
    secondaryWrapSelector = "#secondary-wrap",
    secondaryListSelector = "#secondary-list",
    preselectedInputSelector = "#secondary-selected",
  } = {}) {
    this.form = document.querySelector(formSelector);
    this.insertBtn = document.querySelector(insertBtnSelector);
    this.updateBtn = document.querySelector(updateBtnSelector);
    this.sortButtons = document.querySelectorAll(sortBtnSelector);
    this.deleteButtons = document.querySelectorAll(deleteBtnSelector);

    this.category = document.querySelector(categorySelector);
    this.secondaryWrap = document.querySelector(secondaryWrapSelector);
    this.secondaryList = document.querySelector(secondaryListSelector);
    this.preselectedInput = document.querySelector(preselectedInputSelector);
    this.loading = false;
  }

  init() {
    console.log("[ProductController] Initialized");

    this.bindFormEvents();
    this.attachDeleteEvents();
    this.initEditors();
    this.attachSortEvents();
    this.bindCategoryChange();

    if (this.category && this.category.value) {
      this.loadAndRenderSecondary(this.category.value);
    }

    initCheckboxManager(async (selectedIds) => {
      const formData = new FormData();
      formData.set("mode", "delete_array");
      formData.set("ids", JSON.stringify(selectedIds));
      await this.sendRequest(formData, "선택 항목이 삭제되었습니다.");
    });
  }

  bindFormEvents() {
    if (this.form && this.insertBtn) {
      this.insertBtn.addEventListener("click", this.insert.bind(this));
    }
    if (this.form && this.updateBtn) {
      this.updateBtn.addEventListener("click", this.update.bind(this));
    }
  }

  initEditors() {
    summernoteInit("#career");
    summernoteInit("#activity");
    summernoteInit("#education");
    summernoteInit("#publications");
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

  async insert(e) {
    e.preventDefault();
    const formData = new FormData(this.form);
    formData.set("mode", "insert");
    await this.sendRequest(formData, "의료진이 등록되었습니다.");
  }

  async update(e) {
    e.preventDefault();
    const formData = new FormData(this.form);
    formData.set("mode", "update");
    await this.sendRequest(formData, "의료진이 수정되었습니다.");
  }

  attachSortEvents() {
    this.sortButtons.forEach((btn) => {
      btn.addEventListener("click", async () => {
        const id = btn.dataset.id;
        const action = btn.dataset.action;
        if (!id || !action) return;

        const targetSortNo = parseInt(btn.dataset.no, 10);
        if (isNaN(targetSortNo) || targetSortNo <= 0) {
          alert("잘못된 순서 번호입니다.");
          return;
        }

        const formData = new FormData();
        formData.set("mode", "sort");
        formData.set("id", id);
        formData.set("new_no", targetSortNo);

        await this.sendRequest(formData, "순서가 변경되었습니다.");
      });
    });
  }

  bindCategoryChange() {
    if (!this.category) return;
    this.category.addEventListener("change", () => {
      const val = this.category.value;
      if (!val) {
        this.secondaryList.innerHTML = "";
        this.secondaryWrap.style.display = "none";
        return;
      }
      this.loadAndRenderSecondary(val);
    });
  }

  async loadAndRenderSecondary(categoryId) {
    if (this.loading) return;
    this.loading = true;

    // 로딩 스켈레톤 표시
    this.secondaryWrap.style.display = "flex"; // ✅ block → flex
    this.secondaryList.innerHTML = `
    <div class="sec-skeleton">
      <div class="sec-skel-item"></div>
      <div class="sec-skel-item"></div>
      <div class="sec-skel-item"></div>
      <div class="sec-skel-item"></div>
    </div>
  `;

    try {
      const fd = new FormData();
      fd.set("mode", "secondary_options");
      fd.set("category_id", categoryId);

      const res = await fetcher(API.PRODUCT, fd);
      const options = Array.isArray(res?.options) ? res.options : [];

      if (!options.length) {
        this.secondaryList.innerHTML = `
        <div class="sec-empty">
          <i class="bx bx-info-circle"></i> 선택 가능한 옵션이 없습니다.
        </div>`;
        return;
      }

      const preselected = this.getPreselectedSecondary();

      this.secondaryList.innerHTML = options
        .map((opt, idx) => {
          const id = `secondary_${opt.id}_${idx}`;
          const checked = preselected.has(String(opt.id)) ? "checked" : "";
          return `
      <div class="no-checkbox-form">
        <label for="${id}" class="no-checkbox">
          <input
            type="checkbox"
            name="secondary_ids[]"
            class="no-chk"
            id="${id}"
            value="${opt.id}"
            ${checked}
          />
          <span><i class="bx bxs-check-square"></i></span>
          <span class="no-chk-label">${opt.label}</span>
        </label>
      </div>
    `;
        })
        .join("");
    } catch (e) {
      alert(e?.message || "세컨더리 옵션을 불러오지 못했습니다.");
      this.secondaryList.innerHTML = `
      <div class="sec-error">
        <i class="bx bx-error-circle"></i> 불러오는 중 오류가 발생했습니다.
      </div>`;
    } finally {
      this.loading = false;
    }
  }

  getPreselectedSecondary() {
    try {
      if (!this.preselectedInput) return new Set();
      const raw = this.preselectedInput.value || "[]";
      const arr = JSON.parse(raw);
      return new Set(arr.map(String));
    } catch {
      return new Set();
    }
  }

  async sendRequest(formData, successMessage) {
    try {
      const res = await fetcher(API.PRODUCT, formData);
      const mode = formData.get("mode");

      if (["insert", "update", "delete", "delete_array"].includes(mode)) {
        alert(successMessage);
        if (mode === "delete" || mode === "delete_array") {
          location.reload();
        } else {
          location.href = "/admin/pages/product/index.php";
        }
        return;
      }

      if (mode === "sort") {
        if (
          res.message === "제일 높은 순서의 게시물입니다." ||
          res.message === "제일 낮은 순서의 게시물입니다."
        ) {
          alert(res.message);
        }
        location.reload();
        return;
      }

      location.href = "/admin/pages/product/index.php";
    } catch (err) {
      alert(err.message || "처리 중 오류가 발생했습니다.");
    }
  }
}
