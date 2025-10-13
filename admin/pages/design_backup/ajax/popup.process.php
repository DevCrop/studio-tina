<?php

include_once "../../../../inc/lib/base.class.php";
include_once "../../../lib/admin.check.ajax.php";

$mode = $_POST['mode'];
$db = DB::getInstance();


if ($mode === "save") {
    try {
        $p_view = $_POST['p_view'] ?? '';
        $p_none_limit = $_POST['p_none_limit'] ?? '';
        $p_sdate = $_POST['p_sdate'] ?? null;
        $p_edate = $_POST['p_edate'] ?? null;
        $p_title = $_POST['p_title'] ?? '';
        $p_target = trim($_POST['p_target'] ?? '') !== '' ? $_POST['p_target'] : '_self';
        $p_link = $_POST['p_link'] ?? '';
        $p_idx = $_POST['p_idx'] ?? '';
		$p_is_link = $_POST['p_is_link'] ?? 'N'; // 기본값 N
        
		// 날짜가 공백이면 null 처리
        $p_sdate = trim($p_sdate) === '' ? null : $p_sdate;
        $p_edate = trim($p_edate) === '' ? null : $p_edate;

        // 무기한 설정이면 날짜 비움
        if ($p_none_limit === "Y") {
            $p_sdate = null;
            $p_edate = null;
        }

        // 파일 업로드
        $uploads_dir = $UPLOAD_DIR_POPUP;
        $uploadResult = imageUpload($uploads_dir, $_FILES['p_img']);
        $savedFile = $uploadResult['saved'];

        // 최대 idx 구하기
        $stmt = $db->prepare("SELECT IFNULL((MAX(p_idx) + 1), 1) AS maxcnt FROM nb_popup WHERE sitekey = :sitekey");
        $stmt->execute(['sitekey' => $NO_SITE_UNIQUE_KEY]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $maxcnt = $data['maxcnt'] ?? 1;

       $query = "INSERT INTO nb_popup 
			(sitekey, p_title, p_img, p_target, p_link, p_view, p_idx, p_sdate, p_edate, p_rdate, p_none_limit, p_is_link) 
			VALUES 
			(:sitekey, :p_title, :p_img, :p_target, :p_link, :p_view, :p_idx, :p_sdate, :p_edate, NOW(), :p_none_limit, :p_is_link)";

		$stmt = $db->prepare($query);
		$result = $stmt->execute([
			'sitekey' => $NO_SITE_UNIQUE_KEY,
			'p_title' => $p_title,
			'p_img' => $savedFile,
			'p_target' => $p_target,
			'p_link' => $p_link,
			'p_view' => $p_view,
			'p_idx' => $maxcnt,
			'p_sdate' => $p_sdate,
			'p_edate' => $p_edate,
			'p_none_limit' => $p_none_limit,
			'p_is_link' => $p_is_link
		]);

        if ($result) {
            echo json_encode(["result" => "success", "msg" => "정상적으로 등록되었습니다."]);
        } else {
            throw new Exception("처리중 문제가 발생하였습니다.[Error-DB]");
        }
    } catch (Exception $e) {
        echo json_encode(["result" => "fail", "msg" => $e->getMessage()]);
        error_log("Error in saving data: " . $e->getMessage());
    }
}




if ($mode === "edit") {
    try {
        $no = $_POST['no'];
        $p_view = $_POST['p_view'];
        $p_none_limit = $_POST['p_none_limit'];
        $p_sdate = $_POST['p_sdate'];
        $p_edate = $_POST['p_edate'];
        $p_title = $_POST['p_title'];
        $p_is_link = $_POST['p_is_link'] ?? 'N';
        $p_target = $_POST['p_target'] ?? '_self';
        $p_link = $_POST['p_link'];
        $p_idx = $_POST['p_idx'];

        if (trim($p_target) === '') {
            $p_target = '_self';
        }

        // p_is_link에 따라 링크값 없을 경우 처리
        if ($p_is_link === 'N') {
            $p_link = '';
            $p_target = '_self';
        }

        // 이미지 처리
        $stmt = $db->prepare("SELECT p_img FROM nb_popup WHERE no = :no");
        $stmt->execute(['no' => $no]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception("정보를 찾을 수 없습니다");
        }

        $p_img = $data['p_img'];
        $uploads_dir = $UPLOAD_DIR_POPUP;
        $uploadResult = imageUpload($uploads_dir, $_FILES['p_img'], $p_img);
        $savedFile = $uploadResult['saved'];

        // 쿼리 작성
        $query = "UPDATE nb_popup SET 
            p_title = :p_title, 
            p_is_link = :p_is_link,
            p_target = :p_target, 
            p_link = :p_link, 
            p_view = :p_view, 
            p_idx = :p_idx, 
            p_sdate = :p_sdate, 
            p_edate = :p_edate, 
            p_none_limit = :p_none_limit";

        if ($savedFile) {
            $query .= ", p_img = :p_img";
        }

        $query .= " WHERE no = :no";

        $params = [
            'p_title' => $p_title,
            'p_is_link' => $p_is_link,
            'p_target' => $p_target,
            'p_link' => $p_link,
            'p_view' => $p_view,
            'p_idx' => $p_idx,
            'p_sdate' => $p_sdate,
            'p_edate' => $p_edate,
            'p_none_limit' => $p_none_limit,
            'no' => $no
        ];

        if ($savedFile) {
            $params['p_img'] = $savedFile;
        }

        // 업데이트 실행
        $stmt = $db->prepare($query);
        $result = $stmt->execute($params);

        if ($result) {
            echo json_encode(["result" => "success", "msg" => "정상적으로 수정되었습니다."]);
        } else {
            throw new Exception("처리중 문제가 발생하였습니다.[Error-DB]");
        }
    } catch (Exception $e) {
        echo json_encode(["result" => "fail", "msg" => $e->getMessage()]);
        error_log("Error in updating data: " . $e->getMessage());
    }
}


if ($mode === "delete") {
    try {
        $no = $_POST['no'];

        // 이미지 경로 조회
        $stmt = $db->prepare("SELECT p_img FROM nb_popup WHERE no = :no");
        $stmt->execute(['no' => $no]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception("정보를 찾을 수 없습니다");
        }

        $filename = $data['p_img'];

        // 이미지 파일 삭제
        if ($filename) {
            $filePath = $UPLOAD_DIR_POPUP . "/" . $filename;
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    throw new Exception("이미지 삭제에 실패했습니다.");
                }
            }
        }

        // DB 레코드 삭제
        $stmt = $db->prepare("DELETE FROM nb_popup WHERE no = :no");
        $result = $stmt->execute(['no' => $no]);

        if ($result) {
            echo json_encode(["result" => "success", "msg" => "정상적으로 삭제되었습니다."]);
        } else {
            throw new Exception("데이터 삭제에 실패했습니다.");
        }
    } catch (Exception $e) {
        echo json_encode(["result" => "fail", "msg" => $e->getMessage()]);
        error_log("Error in deletion: " . $e->getMessage());
    }
}


?>