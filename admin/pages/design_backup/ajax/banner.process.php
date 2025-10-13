<?php

include_once "../../../../inc/lib/base.class.php";
include_once "../../../lib/admin.check.ajax.php";

$pdo = DB::getInstance();
$mode = $_POST['mode'];

if ($mode == "save") {
    try {
        $mode = $_POST['mode'] ?? '';
        $b_loc = $_POST['b_loc'] ?? '';
        $b_link = $_POST['b_link'] ?? '';
        $b_target = $_POST['b_target'] ?? '';
        $b_view = $_POST['b_view'] ?? '';
        $b_title = $_POST['b_title'] ?? '';
        $b_none_limit = $_POST['b_none_limit'] ?? '';
        $b_sdate = $_POST['b_sdate'] ?? null;
        $b_edate = $_POST['b_edate'] ?? null;
        $b_desc = $_POST['b_desc'] ?? '';

        // 날짜값 처리
        $b_sdate = trim($b_sdate) === '' ? null : $b_sdate;
        $b_edate = trim($b_edate) === '' ? null : $b_edate;

        // 이미지 업로드
        $uploadFile = $_FILES['b_img'] ?? null;
        $uploads_dir = $UPLOAD_DIR_BANNER;
        $uploadResult = imageUpload($uploads_dir, $uploadFile, '', false);
        $savedFile = $uploadResult['saved'];

        // 새로운 배너의 b_idx (순서) 설정
        $query = "SELECT IFNULL(MAX(b_idx) + 1, 1) AS maxcnt FROM nb_banner WHERE sitekey = :sitekey AND b_loc = :b_loc";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['sitekey' => $NO_SITE_UNIQUE_KEY, 'b_loc' => $b_loc]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxcnt = $data['maxcnt'] ?? 1;

        // INSERT 쿼리
        $query = "INSERT INTO nb_banner (
                    sitekey, b_loc, b_img, b_link, b_target, b_view, b_title, b_idx, 
                    b_none_limit, b_sdate, b_edate, b_rdate, b_desc
                  )
                  VALUES (
                    :sitekey, :b_loc, :b_img, :b_link, :b_target, :b_view, :b_title, :b_idx, 
                    :b_none_limit, :b_sdate, :b_edate, NOW(), :b_desc
                  )";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([
            'sitekey' => $NO_SITE_UNIQUE_KEY,
            'b_loc' => $b_loc,
            'b_img' => $savedFile,
            'b_link' => $b_link,
            'b_target' => $b_target,
            'b_view' => $b_view,
            'b_title' => $b_title,
            'b_idx' => $maxcnt,
            'b_none_limit' => $b_none_limit,
            'b_sdate' => $b_sdate,
            'b_edate' => $b_edate,
            'b_desc' => $b_desc
        ]);

        echo $result
            ? "{\"result\":\"success\", \"msg\":\"정상적으로 등록되었습니다.\"}"
            : "{\"result\":\"fail\", \"msg\":\"처리중 문제가 발생하였습니다.[Error-DB]\"}";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


if ($mode == "edit") {
    $no = $_POST['no'];
    $b_loc = $_POST['b_loc'];
    $b_link = $_POST['b_link'];
    $b_target = $_POST['b_target'];
    $b_view = $_POST['b_view'];
    $b_title = $_POST['b_title'];
    $b_idx = $_POST['b_idx'];
    $b_none_limit = $_POST['b_none_limit'];
    $b_sdate = isset($_POST['b_sdate']) ? $_POST['b_sdate'] : null;
    $b_edate = isset($_POST['b_edate']) ? $_POST['b_edate'] : null;

    $b_desc = $_POST['b_desc'];
    $uploads_dir = $UPLOAD_DIR_BANNER;

    $query = "SELECT b_img FROM nb_banner WHERE no = :no";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['no' => $no]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        echo "{\"result\":\"fail\", \"msg\":\"정보를 찾을 수 없습니다.\"}";
        exit;
    }
    $uploadResult = imageUpload($uploads_dir, $_FILES['b_img'], $data['b_img'], false);
    $savedFile = $uploadResult['saved'];

    $savedFile2 = '';
    if (isset($_FILES['b_img_mobile'])) {
        $uploadResult2 = imageUpload($uploads_dir, $_FILES['b_img_mobile'], $data['b_img_mobile'] ?? '', false);
        $savedFile2 = $uploadResult2['saved'];
    }

    
    $query = "UPDATE nb_banner SET 
                b_loc = :b_loc, 
                b_link = :b_link,
                b_target = :b_target,
                b_view = :b_view,
                b_title = :b_title,
                b_idx = :b_idx,
                b_none_limit = :b_none_limit,
                b_sdate = :b_sdate,
                b_edate = :b_edate,
                b_desc = :b_desc,
                b_img = IF(:b_img != '', :b_img, b_img)
            WHERE no = :no";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([
        'b_loc' => $b_loc,
        'b_link' => $b_link,
        'b_target' => $b_target,
        'b_view' => $b_view,
        'b_title' => $b_title,
        'b_idx' => $b_idx,
        'b_none_limit' => $b_none_limit,
        'b_sdate' => $b_sdate,
        'b_edate' => $b_edate,
        'b_desc' => $b_desc,
        'b_img' => $savedFile,
        'no' => $no,
    ]);

    echo $result
        ? "{\"result\":\"success\", \"msg\":\"정상적으로 수정되었습니다.\"}"
        : "{\"result\":\"fail\", \"msg\":\"처리중 문제가 발생하였습니다.[Error-DB]\"}";

} 

if ($mode == "delete") {
    $no = $_POST['no'] ?? null;

    if (!$no) {
        echo json_encode(["result" => "fail", "msg" => "전달된 no 값이 없습니다."]);
        exit;
    }

    // 전달된 no 확인 로그
    error_log("전달된 no: " . $no);

    // 데이터 확인
    $query = "SELECT b_img FROM nb_banner WHERE no = :no";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['no' => $no]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // 결과 로그
    error_log("쿼리 결과: " . print_r($data, true));

    if (!$data) {
        echo json_encode(["result" => "fail", "msg" => "정보를 찾을 수 없습니다"]);
        exit;
    }

    // 이미지 삭제
    if (!empty($data['b_img'])) {
        $filePath = $UPLOAD_DIR_BANNER . "/" . $data['b_img'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // DB에서 삭제
    $query = "DELETE FROM nb_banner WHERE no = :no";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute(['no' => $no]);

    echo $result
        ? json_encode(["result" => "success", "msg" => "정상적으로 삭제되었습니다."])
        : json_encode(["result" => "fail", "msg" => "DB 삭제에 실패했습니다."]);
}


?>