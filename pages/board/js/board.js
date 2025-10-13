function doPasswordConfirm(mode) {
  if ($("#pwd").val() === "") {
    alert("비밀번호를 입력해주세요");
    $("#pwd").focus();
    return;
  }

  $("#mode").val("board.password.confirm");
  const form = $("#frm")[0];
  const data = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./ajax/board.process.php",
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    success: function (res) {
      const jsonData = typeof res === "string" ? $.parseJSON(res) : res;

      if (jsonData.result === "fail") {
        alert(jsonData.msg);
        return;
      }

      if (mode === "edit") {
        $("#frm").attr("action", "./board.edit.php").submit();
      } else if (mode === "view") {
        $("#frm").attr("action", "./board.view.php").submit();
      } else if (mode === "delete") {
        if (!confirm("정말 삭제하시겠습니까?")) return;

        // 삭제 요청
        $("#mode").val("board.delete");
        const delData = new FormData($("#frm")[0]);

        $.ajax({
          type: "POST",
          url: "./ajax/board.process.php",
          data: delData,
          processData: false,
          contentType: false,
          cache: false,
          success: function (res2) {
            const r = typeof res2 === "string" ? $.parseJSON(res2) : res2;
            alert(r.msg);
            if (r.result === "success") {
              const boardNo = $("input[name='board_no']").val() || "";
              location.href =
                "./board.list.php" +
                (boardNo ? "?board_no=" + encodeURIComponent(boardNo) : "");
            }
          },
        });
      } else {
        $("#frm").attr("action", "./board.view.php").submit();
      }
    },
  });
}

function doBoardSubmit(isSecret) {
  if ($("#title").val().trim() === "") {
    alert("제목을 입력해주세요");
    $("#title").focus();
    return;
  }
  if ($("#write_name").val().trim() === "") {
    alert("이름을 입력해주세요");
    $("#write_name").focus();
    return;
  }
  if (isSecret) {
    if ($("#secret_pwd").val().trim() === "") {
      alert("비밀번호를 입력해주세요");
      $("#secret_pwd").focus();
      return;
    }
  }
  if ($("#contents").val().trim() === "") {
    alert("내용을 입력해주세요");
    $("#contents").focus();
    return;
  }
  if ($("#r_captcha").val().trim() === "") {
    alert("보안코드를 입력해주세요");
    $("#r_captcha").focus();
    return;
  }

  $("#mode").val("board.write");

  const form = $("#frm")[0];
  const data = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./ajax/board.process.php",
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    success: function (data) {
      let jsonData;
      try {
        jsonData = $.parseJSON(data);
      } catch (e) {
        alert("서버 응답 오류");
        return;
      }

      if (jsonData.result === "fail") {
        alert(jsonData.msg);
      } else if (jsonData.result === "success") {
        location.href = "./board.list.php?board_no=" + $("#board_no").val();
      }
    },
  });
}

function doBoardEditSubmit() {
  if ($("#title").val() == "") {
    alert("제목을 입력해주세요");
    $("#title").focus();
    return;
  }

  if ($("#write_name").val() == "") {
    alert("이름을 입력해주세요");
    $("#write_name").focus();
    return;
  }

  if ($("#contents").val() == "") {
    alert("내용을 입력해주세요");
    $("#contents").focus();
    return;
  }

  if ($("#r_captcha").val() == "") {
    alert("보안코드를 입력해주세요");
    $("#r_captcha").focus();
    return;
  }

  $("#mode").val("board.edit");

  var params = jQuery("#frm").serialize();

  // Get form
  var form = $("#frm")[0];

  // Create an FormData object
  var data = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./ajax/board.process.php",
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    success: function (data) {
      var jsonData = $.parseJSON(data);

      if (jsonData.result == "fail") {
        alert(jsonData.msg);
      } else if (jsonData.result == "success") {
        alert(jsonData.msg);
        location.href =
          "./board.view.php?no=" +
          $("#no").val() +
          "&board_no=" +
          $("#board_no").val();
      }
    },
    error: function (e) {},
    complete: function () {},
  });
}

function doBoardEditUserConfirm() {
  $("#frm").attr("action", "./board.confirm.php");
  $("#mode").val("edit");
  $("#frm").submit();
}

function doBoardEditUser() {
  $("#frm").attr("action", "./board.edit.php");
  $("#frm").submit();
}

function doBoardDeleteUser() {
  var c = confirm("정말 삭제하시겠습니까?");
  if (c) {
    $("#mode").val("board.delete.user");

    var params = jQuery("#frm").serialize();

    // Get form
    var form = $("#frm")[0];

    // Create an FormData object
    var data = new FormData(form);

    $.ajax({
      type: "POST",
      url: "./ajax/board.process.php",
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      success: function (data) {
        var jsonData = $.parseJSON(data);

        if (jsonData.result == "fail") {
          alert(jsonData.msg);
        } else if (jsonData.result == "success") {
          alert(jsonData.msg);
          location.href = "./board.list.php?board_no=" + $("#board_no").val();
        }
      },
      error: function (e) {},
      complete: function () {},
    });
  }
}

function doCommentSave(lev) {
  if (lev == 0) {
    if ($("#write_name").val() == "") {
      alert("이름을 입력해주세요");
      $("#write_name").focus();
      return;
    }

    if ($("#pwd").val() == "") {
      alert("비밀번호를 입력해주세요");
      $("#pwd").focus();
      return;
    }
  }

  if ($("#comment_contents").val() == "") {
    alert("댓글 내용을 입력해주세요");
    $("#comment_contents").focus();
    return;
  }

  $("#mode").val("comment.save");

  var params = jQuery("#frm").serialize();

  // Get form
  var form = $("#frm")[0];

  // Create an FormData object
  var data = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./ajax/board.process.php",
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    success: function (data) {
      var jsonData = $.parseJSON(data);

      if (jsonData.result == "fail") {
        alert(jsonData.msg);
      } else if (jsonData.result == "success") {
        alert(jsonData.msg);
        location.reload();
      }
    },
    error: function (e) {},
    complete: function () {},
  });
}

function doCommentDelete(no) {
  if (!confirm("정말 삭제하시겠습니까?")) return;

  const data = new FormData();
  data.append("mode", "comment.delete");
  data.append("no", no);

  $.ajax({
    type: "POST",
    url: "./ajax/board.process.php",
    data,
    processData: false,
    contentType: false,
    cache: false,
    success: function (res) {
      const jsonData = typeof res === "string" ? $.parseJSON(res) : res;
      alert(jsonData.msg);
      if (jsonData.result === "success") location.reload();
    },
  });
}

function doCommentDeleteSecret(no) {
  $("#comment_no").val(no);
  $("#frm").attr("action", "../board.comment.confirm.php");
  $("#frm").submit();
}

function doCommentPasswordConfirm() {
  if ($("#pwd").val() == "") {
    alert("비밀번호를 입력해주세요");
    $("#pwd").focus();
    return;
  }

  $("#mode").val("comment.password.delete.confirm");
  var params = jQuery("#frm").serialize();

  // Get form
  var form = $("#frm")[0];

  // Create an FormData object
  var data = new FormData(form);

  $.ajax({
    type: "POST",
    url: "./ajax/board.process.php",
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    success: function (data) {
      var jsonData = $.parseJSON(data);

      if (jsonData.result == "fail") {
        alert(jsonData.msg);
      } else if (jsonData.result == "success") {
        alert(jsonData.msg);
        location.href =
          "./board.view.php?no=" +
          $("#no").val() +
          "&board_no=" +
          $("#board_no").val();
      }
    },
    error: function (e) {},
    complete: function () {},
  });
}

function doCategoryChange(v) {
  $("#frm").submit();
}

function doCategoryClick(v) {
  $("#category_no").val(v);
  $("#frm").submit();
}

function doSearch() {
  if ($("#searchColumn").val() == "") {
    alert("컬럼을 선택해주세요");
    return;
  }

  $("#frm").submit();
}
