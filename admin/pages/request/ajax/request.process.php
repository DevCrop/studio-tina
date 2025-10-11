<?php

include_once "../../../../inc/lib/base.class.php";
include_once "../../../lib/admin.check.ajax.php";

$mode = $_POST['mode'] ?? null;

if ($mode === "delete") {
    try {
        // 데이터 확인
        if (!isset($_REQUEST['no']) || empty($_REQUEST['no'])) {
            throw new Exception("삭제할 항목 번호가 없습니다.");
        }

        $no = (int) $_REQUEST['no']; // 숫자 변환을 통해 안전성을 확보

        // DB 연결
        $db = DB::getInstance();
        if (!$db) {
            throw new Exception("DB 연결에 실패했습니다.");
        }

        // 삭제 쿼리 실행
        $query = "DELETE FROM nb_request WHERE no = :no";
        $stmt = $db->prepare($query);
        $stmt->execute([':no' => $no]);

        echo json_encode(["result" => "success", "msg" => "정상적으로 삭제되었습니다."]);
    } catch (PDOException $e) {
        echo json_encode([
            "result" => "fail",
            "msg" => "DB 처리 중 오류가 발생했습니다. [Error: " . $e->getMessage() . "]"
        ]);
    } catch (Exception $e) {
        echo json_encode(["result" => "fail", "msg" => $e->getMessage()]);
    }
}

?>
