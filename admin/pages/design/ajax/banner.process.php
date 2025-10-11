<?php

include_once "../../../../inc/lib/base.class.php";
include_once "../../../lib/admin.check.ajax.php";

$pdo = DB::getInstance();
$mode = $_POST['mode'];

if ($mode == "save") {
    try {

		$mode = $_POST['mode'];
		$b_loc = $_POST['b_loc'];
		$b_link = $_POST['b_link'];
		$b_target = $_POST['b_target'];
		$b_view = $_POST['b_view'];
		$b_title = $_POST['b_title'];
		$b_none_limit = $_POST['b_none_limit'];
		$b_sdate = $_POST['b_sdate'];
		$b_edate = $_POST['b_edate'];
		$b_desc = $_POST['b_desc'];
		$b_contents = $_POST['content'];

		// Ensure $UPLOAD_DIR_BANNER is defined correctly
		// echo $UPLOAD_DIR_BANNER;
		// echo json_encode(['file' => $_FILES]);
		// exit;

		$uploads_dir = $UPLOAD_DIR_BANNER;
		$uploadResult = imageUpload($uploads_dir, $_FILES['b_img'], '', false);
		$savedFile = $uploadResult['saved'];
		$uploadResult2 = imageUpload($uploads_dir, $_FILES['b_img_mobile'], '', false);
		$savedFile2 = $uploadResult2['saved'];

		// Retrieve the maximum index for the new banner
		$query = "SELECT IFNULL(MAX(b_idx) + 1, 1) AS maxcnt FROM nb_banner WHERE sitekey = :sitekey AND b_loc = :b_loc";
		$stmt = $pdo->prepare($query);
		$stmt->execute(['sitekey' => $NO_SITE_UNIQUE_KEY, 'b_loc' => $b_loc]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		$maxcnt = $data['maxcnt'] ?? 1;

		// Prepare and execute the insert query
		$query = "INSERT INTO nb_banner (sitekey, b_loc, b_img, b_img_mobile, b_link, b_target, b_view, b_title, b_idx, 
										 b_none_limit, b_sdate, b_edate, b_rdate, b_desc, b_contents)
				  VALUES (:sitekey, :b_loc, :b_img, :b_img_mobile, :b_link, :b_target, :b_view, :b_title, :b_idx, :b_none_limit, 
						  :b_sdate, :b_edate, NOW(), :b_desc, :b_contents)";
		$stmt = $pdo->prepare($query);
		$result = $stmt->execute([
			'sitekey' => $NO_SITE_UNIQUE_KEY,
			'b_loc' => $b_loc,
			'b_img' => $savedFile,
			'b_img_mobile' => $savedFile2,
			'b_link' => $b_link,
			'b_target' => $b_target,
			'b_view' => $b_view,
			'b_title' => $b_title,
			'b_idx' => $maxcnt,
			'b_none_limit' => $b_none_limit,
			'b_sdate' => $b_sdate,
			'b_edate' => $b_edate,
			'b_desc' => $b_desc,
			'b_contents' => $b_contents,
		]);

		echo $result
			? "{\"result\":\"success\", \"msg\":\"정상적으로 등록되었습니다.\"}"
			: "{\"result\":\"fail\", \"msg\":\"처리중 문제가 발생하였습니다.[Error-DB]\"}";
	} catch (Exception $e) {
		echo "Error: " . $e->getMessage();
	}

} else if ($mode == "edit") {
    $no = $_POST['no'];
    $b_loc = $_POST['b_loc'];
    $b_link = $_POST['b_link'];
    $b_target = $_POST['b_target'];
    $b_view = $_POST['b_view'];
    $b_title = $_POST['b_title'];
    $b_idx = $_POST['b_idx'];
    $b_none_limit = $_POST['b_none_limit'];
    $b_sdate = $_POST['b_sdate'];
    $b_edate = $_POST['b_edate'];
    $b_desc = $_POST['b_desc'];
    $b_contents = $_POST['content'];
    $uploads_dir = $UPLOAD_DIR_BANNER;

    $query = "SELECT b_img, b_img_mobile FROM nb_banner WHERE no = :no";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['no' => $no]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        echo "{\"result\":\"fail\", \"msg\":\"정보를 찾을 수 없습니다.\"}";
        exit;
    }

    // Process image uploads
    $uploadResult = imageUpload($uploads_dir, $_FILES['b_img'], $data['b_img'], false);
    $savedFile = $uploadResult['saved'];
    $uploadResult2 = imageUpload($uploads_dir, $_FILES['b_img_mobile'], $data['b_img_mobile'], false);
    $savedFile2 = $uploadResult2['saved'];

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
                b_contents = :b_contents,
                b_img = IF(:b_img != '', :b_img, b_img),
                b_img_mobile = IF(:b_img_mobile != '', :b_img_mobile, b_img_mobile)
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
        'b_contents' => $b_contents,
        'b_img' => $savedFile,
        'b_img_mobile' => $savedFile2,
        'no' => $no,
    ]);

    echo $result
        ? "{\"result\":\"success\", \"msg\":\"정상적으로 수정되었습니다.\"}"
        : "{\"result\":\"fail\", \"msg\":\"처리중 문제가 발생하였습니다.[Error-DB]\"}";

} else if ($mode == "delete") {
    $no = $_POST['no'];

    $query = "SELECT b_img, b_img_mobile FROM nb_banner WHERE no = :no";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['no' => $no]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo "{\"result\":\"fail\", \"msg\":\"정보를 찾을 수 없습니다\"}";
        exit;
    }

    // Delete images
    if ($data['b_img']) {
        imageDelete($UPLOAD_DIR_BANNER . "/" . $data['b_img']);
    }
    if ($data['b_img_mobile']) {
        imageDelete($UPLOAD_DIR_BANNER . "/" . $data['b_img_mobile']);
    }

    $query = "DELETE FROM nb_banner WHERE no = :no";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute(['no' => $no]);

    echo $result
        ? "{\"result\":\"success\", \"msg\":\"정상적으로 삭제되었습니다.\"}"
        : "{\"result\":\"fail\", \"msg\":\"파일 삭제에 실패했습니다.\"}";
}

?>
