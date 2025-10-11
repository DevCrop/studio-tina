<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

// 입력값 유효성 검사
$no = $_REQUEST['no'] ?? null;
$fld = $_REQUEST['fld'] ?? null;

if (!$no || !$fld) {
    error("잘못된 접근입니다.");
}

try {
    // 데이터베이스 연결 및 쿼리 실행
    $db = DB::getInstance();

    $query = "SELECT thumb_image, file_attach_1, file_attach_2, file_attach_3, file_attach_4, file_attach_5,
                     file_attach_origin_1, file_attach_origin_2, file_attach_origin_3, file_attach_origin_4, file_attach_origin_5
              FROM nb_board 
              WHERE no = :no";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        error("정보를 찾을 수 없습니다.");
    }

    // 파일 이름 설정
    $filename = "";
    $filename_origin = "";

    switch ($fld) {
        case "thumb":
            $filename = $data['thumb_image'];
            $filename_origin = $data['thumb_image'];
            break;
        case "attach1":
            $filename = $data['file_attach_1'];
            $filename_origin = $data['file_attach_origin_1'];
            break;
        case "attach2":
            $filename = $data['file_attach_2'];
            $filename_origin = $data['file_attach_origin_2'];
            break;
        case "attach3":
            $filename = $data['file_attach_3'];
            $filename_origin = $data['file_attach_origin_3'];
            break;
        case "attach4":
            $filename = $data['file_attach_4'];
            $filename_origin = $data['file_attach_origin_4'];
            break;
        case "attach5":
            $filename = $data['file_attach_5'];
            $filename_origin = $data['file_attach_origin_5'];
            break;
        default:
            error("잘못된 파일 접근입니다.");
    }

    // 파일 경로 설정
    $filepath = $UPLOAD_DIR_BOARD . "/" . $filename;

    if (!file_exists($filepath)) {
        error("파일을 찾을 수 없습니다.");
    }

    $filesize = filesize($filepath);
    $path_parts = pathinfo($filepath);
    $filename_origin = $path_parts['basename'];
    $extension = $path_parts['extension'];

    // IE 브라우저인지 확인
    $ie = isset($_SERVER['HTTP_USER_AGENT']) && 
          (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false);

    if ($ie) {
        $filename_origin = utf2euc($filename_origin);
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    } else {
        header("Cache-Control: no-cache, must-revalidate"); 
        header('Pragma: no-cache');
    }

    header("Pragma: public");
    header("Expires: 0");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . basename($filename_origin) . "\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $filesize);

    ob_clean();
    flush();
    readfile($filepath);

} catch (PDOException $e) {
    error("데이터베이스 오류가 발생했습니다: " . $e->getMessage());
    exit;
} catch (Exception $e) {
    error("파일을 처리하는 중 오류가 발생했습니다: " . $e->getMessage());
    exit;
}
?>
