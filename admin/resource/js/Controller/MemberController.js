import { fetcher } from "../core/fetcher.js";
import { API } from "../core/apiRoutes.js";

export class MemberController {
  init() {
    console.log("[MemberController] 상태 변경 전용 INIT");
    this.attachStatusToggleEvents();
  }

  attachStatusToggleEvents() {
    document.querySelectorAll(".status-select").forEach((select) => {
      select.addEventListener("change", async () => {
        const userId = select.dataset.id;
        const newStatus = select.value;

        if (!userId) return;

        const formData = new FormData();
        formData.set("mode", "update_status");
        formData.set("id", userId);
        formData.set("active_status", newStatus);

        try {
          const res = await fetcher(API.MEMBER, formData);
          alert(res.message || "상태가 변경되었습니다.");
        } catch (err) {
          console.error("상태 변경 실패:", err);
          alert("상태 변경 중 오류가 발생했습니다.");
        }
      });
    });
  }
}
