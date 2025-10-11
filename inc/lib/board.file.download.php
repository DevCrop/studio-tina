<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

$no = $_REQUEST['no'];
$fld = $_REQUEST['fld'];

// SQL 쿼리
$query = "SELECT thumb_image, file_attach_1, file_attach_2, file_attach_3, file_attach_4, file_attach_5,
                 file_attach_origin_1, file_attach_origin_2, file_attach_origin_3, file_attach_origin_4, file_attach_origin_5
          FROM nb_board 
          WHERE no = ?";

// mysqli prepare
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $no);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("정보를 찾을 수 없습니다");
}

$thumb_image = $data['thumb_image'];
$file_attach_1 = $data['file_attach_1'];
$file_attach_2 = $data['file_attach_2'];
$file_attach_3 = $data['file_attach_3'];
$file_attach_4 = $data['file_attach_4'];
$file_attach_5 = $data['file_attach_5'];

$file_attach_origin_1 = $data['file_attach_origin_1'];
$file_attach_origin_2 = $data['file_attach_origin_2'];
$file_attach_origin_3 = $data['file_attach_origin_3'];
$file_attach_origin_4 = $data['file_attach_origin_4'];
$file_attach_origin_5 = $data['file_attach_origin_5'];

$filename = "";
$filename_origin = "";

switch ($fld) {
    case "thumb":
        $filename = $thumb_image;
        $filename_origin = $thumb_image;
        break;
    case "attach1":
        $filename = $file_attach_1;
        $filename_origin = $file_attach_origin_1;
        break;
    case "attach2":
        $filename = $file_attach_2;
        $filename_origin = $file_attach_origin_2;
        break;
    case "attach3":
        $filename = $file_attach_3;
        $filename_origin = $file_attach_origin_3;
        break;
    case "attach4":
        $filename = $file_attach_4;
        $filename_origin = $file_attach_origin_4;
        break;
    case "attach5":
        $filename = $file_attach_5;
        $filename_origin = $file_attach_origin_5;
        break;
    default:
        die("유효하지 않은 필드 값입니다");
}

$filepath = $UPLOAD_DIR_BOARD . "/" . $filename;

if (!file_exists($filepath)) {
    die("파일을 찾을 수 없습니다.");
}

$filesize = filesize($filepath);
$path_parts = pathinfo($filepath);
$filename = $path_parts['basename'];
$extension = $path_parts['extension'];

// 브라우저 확인 (IE인지 아닌지)
$ie = isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false);

if ($ie) {
    // UTF-8에서 EUC-KR로 캐릭터셋 변경 (필요한 경우 함수 정의 필요)
    $filename_origin = utf2euc($filename_origin);

    // IE인 경우 헤더 변경
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
} else {
    // IE가 아닌 경우 일반 헤더 적용
    header("Cache-Control: no-cache, must-revalidate");
    header('Pragma: no-cache');
}

header("Pragma: public");
header("Expires: 0");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename_origin\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $filesize");

ob_clean();
flush();
readfile($filepath);

$stmt->close();

?>
