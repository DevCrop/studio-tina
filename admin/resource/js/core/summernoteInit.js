export function summernoteInit(selector) {
  $(document).ready(function () {
    if ($(selector).length > 0) {
      $(selector).summernote({
        lang: "ko-KR",
        height: 300,
        placeholder: "내용을 입력하세요",
      });
    }
  });
}
