export function previewImage(input, imgId, txtId) {
  const file = input.files[0];
  const preview = document.getElementById(imgId);
  const fakeInput = document.getElementById(txtId);

  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = "block";
    };
    reader.readAsDataURL(file);
    fakeInput.value = file.name;
  } else {
    preview.src = "";
    preview.style.display = "none";
    fakeInput.value = "";
  }
}

// 등록용
window.previewImage = previewImage;
