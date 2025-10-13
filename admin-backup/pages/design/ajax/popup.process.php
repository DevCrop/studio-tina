<?php

include_once "../../../../inc/lib/base.class.php";
include_once "../../../lib/admin.check.ajax.php";

$mode = $_POST['mode'];
$db = DB::getInstance();

if ($mode === "save") {

    try {

    if ($mode === "save") {

        $p_view = $_POST['p_view'];
        $p_none_limit = $_POST['p_none_limit'];
        $p_sdate = $_POST['p_sdate'];
        $p_edate = $_POST['p_edate'];
        $p_title = $_POST['p_title'];
        $p_target = $_POST['p_target'];
        $p_link = $_POST['p_link'];
        $p_idx = $_POST['p_idx'];
        $p_loc = $_POST['p_loc'];
        $p_left = $_POST['p_left'];
        $p_top = $_POST['p_top'];

        if ($p_none_limit === "Y") {
            $p_sdate = null;
            $p_edate = null;
        }

        if ($p_loc === "M") {
            $p_left = null;
            $p_top = null;
        }

        $uploads_dir = $UPLOAD_DIR_POPUP;
        $uploadResult = imageUpload($uploads_dir, $_FILES['p_img']);
        $savedFile = $uploadResult['saved'];

        $stmt = $db->prepare("SELECT IFNULL((MAX(p_idx) + 1), 1) AS maxcnt FROM nb_popup WHERE sitekey = :sitekey AND p_loc = :p_loc");
        $stmt->execute(['sitekey' => $NO_SITE_UNIQUE_KEY, 'p_loc' => $p_loc]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception("정보를 찾을 수 없습니다");
        }

        $maxcnt = $data['maxcnt'];

        $query = "INSERT INTO nb_popup 
            (sitekey, p_title, p_img, p_target, p_link, p_view, p_left, p_top, p_idx, p_sdate, p_edate, p_rdate, p_none_limit, p_loc) 
            VALUES 
            (:sitekey, :p_title, :p_img, :p_target, :p_link, :p_view, :p_left, :p_top, :p_idx, :p_sdate, :p_edate, NOW(), :p_none_limit, :p_loc)";

        $stmt = $db->prepare($query);
        $result = $stmt->execute([
            'sitekey' => $NO_SITE_UNIQUE_KEY,
            'p_title' => $p_title,
            'p_img' => $savedFile,
            'p_target' => $p_target,
            'p_link' => $p_link,
            'p_view' => $p_view,
            'p_left' => $p_left,
            'p_top' => $p_top,
            'p_idx' => $maxcnt,
            'p_sdate' => $p_sdate,
            'p_edate' => $p_edate,
            'p_none_limit' => $p_none_limit,
            'p_loc' => $p_loc
        ]);

        if ($result) {
            echo json_encode(["result" => "success", "msg" => "정상적으로 등록되었습니다."]);
        } else {
            throw new Exception("처리중 문제가 발생하였습니다.[Error-DB]");
        }
    }
} catch (Exception $e) {
    // Catch any exceptions and return as a JSON response
    echo json_encode(["result" => "fail", "msg" => $e->getMessage()]);
    error_log("Error in saving data: " . $e->getMessage());
}

} elseif ($mode === "edit") {

    try {
		$no = $_POST['no'];
		$p_view = $_POST['p_view'];
		$p_none_limit = $_POST['p_none_limit'];
		$p_sdate = $_POST['p_sdate'];
		$p_edate = $_POST['p_edate'];
		$p_title = $_POST['p_title'];
		$p_target = $_POST['p_target'];
		$p_link = $_POST['p_link'];
		$p_idx = $_POST['p_idx'];
		$p_loc = $_POST['p_loc'];
		$p_left = $_POST['p_left'];
		$p_top = $_POST['p_top'];

		// Fetch existing image path
		$stmt = $db->prepare("SELECT p_img FROM nb_popup WHERE no = :no");
		$stmt->execute(['no' => $no]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			throw new Exception("정보를 찾을 수 없습니다");
		}

		$p_img = $data['p_img'];

		// Handle image upload
		$uploads_dir = $UPLOAD_DIR_POPUP;
		$uploadResult = imageUpload($uploads_dir, $_FILES['p_img'], $p_img);
		$savedFile = $uploadResult['saved'];

		// Prepare the update query
		$query = "UPDATE nb_popup SET p_title = :p_title, p_target = :p_target, p_link = :p_link, p_view = :p_view, 
				  p_left = :p_left, p_top = :p_top, p_idx = :p_idx, p_sdate = :p_sdate, p_edate = :p_edate, 
				  p_none_limit = :p_none_limit, p_loc = :p_loc";

		if ($savedFile) {
			$query .= ", p_img = :p_img";
		}
		$query .= " WHERE no = :no";

		$params = [
			'p_title' => $p_title,
			'p_target' => $p_target,
			'p_link' => $p_link,
			'p_view' => $p_view,
			'p_left' => $p_left,
			'p_top' => $p_top,
			'p_idx' => $p_idx,
			'p_sdate' => $p_sdate,
			'p_edate' => $p_edate,
			'p_none_limit' => $p_none_limit,
			'p_loc' => $p_loc,
			'no' => $no
		];
		if ($savedFile) {
			$params['p_img'] = $savedFile;
		}

		// Execute the update
		$stmt = $db->prepare($query);
		$result = $stmt->execute($params);

		if ($result) {
			echo json_encode(["result" => "success", "msg" => "정상적으로 수정되었습니다."]);
		} else {
			throw new Exception("처리중 문제가 발생하였습니다.[Error-DB]");
		}
	} catch (Exception $e) {
		// Catch any exceptions and return as a JSON response
		echo json_encode(["result" => "fail", "msg" => $e->getMessage()]);
		error_log("Error in updating data: " . $e->getMessage());
	}

} elseif ($mode === "delete") {
	try {
		$no = $_POST['no'];
		
		// Fetch existing image path
		$stmt = $db->prepare("SELECT p_img FROM nb_popup WHERE no = :no");
		$stmt->execute(['no' => $no]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$data) {
			throw new Exception("정보를 찾을 수 없습니다");
		}

		$filename = $data['p_img'];

		// Delete image if it exists
		if ($filename) {
			if (!imageDelete($UPLOAD_DIR_POPUP . "/" . $filename)) {
				throw new Exception("이미지 삭제에 실패했습니다.");
			}
		}

		// Delete database record
		$stmt = $db->prepare("DELETE FROM nb_popup WHERE no = :no");
		$result = $stmt->execute(['no' => $no]);

		if ($result) {
			echo json_encode(["result" => "success", "msg" => "정상적으로 삭제되었습니다."]);
		} else {
			throw new Exception("파일 삭제에 실패했습니다.");
		}
	} catch (Exception $e) {
		// Catch any exceptions and return as a JSON response
		echo json_encode(["result" => "fail", "msg" => $e->getMessage()]);
		error_log("Error in deletion: " . $e->getMessage());
	}
}

?>
