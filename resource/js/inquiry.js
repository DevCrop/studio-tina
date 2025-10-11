  function validateFiles() {
			// 각 파일 input 요소
			const file1 = document.getElementById('file1').files[0];

			// 10MB 크기 제한 (10 * 1024 * 1024 바이트)
			const maxSize = 10 * 1024 * 1024;

			// 파일 크기 검사
			if (file1 && file1.size > maxSize) {
				alert("파일 크기는 10MB를 초과할 수 없습니다.");
				return false;
			}

			return true; 
		}

function doRequest() {

   if ($("#name").val() =="") {
    alert('이름을 입력해주세요.');
    $("#name").focus();
    return;
  }

    if ($("#company").val() =="") {
    alert('업체명을 입력해주세요.');
    $("#company").focus();
    return;
  }

   if ($("#email").val() =="") {
    alert('메일을 입력해주세요.');
    $("#email").focus();
    return;
  }

  if ($("#phone").val() =="") {
    alert('연락처를 입력해주세요.');
    $("#phone").focus();
    return;
  }

     var selectedValue = $('#budget').val();
	if (!selectedValue) { 
		alert("예산을 선택해주세요."); 
		$('#budget').focus(); 
		return; 
	}

	if ($("#contents").val() =="") {
    alert('내용을 입력해주세요.');
    $("#contents").focus();
    return;
  }

      if ($("#r_captcha").val() == "") {
    alert('보안문자를 입력해주세요');
    $("#r_captcha").focus();
    return;
  }

    if ($("input:checkbox[id='check']").is(":checked") == false) {
    alert("개인정보수집/이용 제공 약관에 동의하셔야 합니다.");
    return;
  }

  if (!validateFiles()) {
			return;
	}


  // Get form
   var params = jQuery("#frm").serialize();
 
  // Get form
  var form = $("#frm")[0];
 
  // Create an FormData object
  var data = new FormData(form);

  console.log(Object.fromEntries(data));
 
  $.ajax({
        type: "POST",
        url: "/module/ajax/request.process.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            var jsonData = $.parseJSON(data);

            if (jsonData.result == "fail") {
                alert(jsonData.msg);
                submitBtn.disabled = false; 
            } else if (jsonData.result == "success") {
                alert(jsonData.msg);

                if (window.wcs) {
                    var _conv = {};
                    _conv.type = 'custom002'; 
                    wcs.trans(_conv);
                }

                location.reload();
            }
        },
        error: function (e) {
            submitBtn.disabled = false; 
        },
        complete: function () {
            $('.no_contact_btn button').text('문의하기');
            $('.no_contact_btn button').attr('disabled', false);
        },
    });
}