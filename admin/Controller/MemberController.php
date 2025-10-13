<?php

require_once "../../inc/lib/base.class.php";
require_once "../Model/MemberModel.php";

header('Content-Type: application/json');

try {
    $input = $_POST;
    $mode = $input['mode'] ?? '';

    // ========================================================
    // [mode = update_status] 활성/비활성 상태만 수정
    // ========================================================
    if ($mode === 'update_status') {
        $id = $input['id'] ?? null;
  
        $status = $input['active_status'] ?? null;

        if (!$id || !in_array($status, ['Y', 'N'])) {
            echo json_encode([
                'success' => false,
                'message' => '잘못된 요청입니다.'
            ]);
            exit;
        }

        $updated = MemberModel::updateStatus($id, $status);

        echo json_encode([
            'success' => $updated,
            'message' => $updated ? '상태가 변경되었습니다.' : '변경 실패'
        ]);
        exit;
    }

    // ========================================================
    // [기타: 정의되지 않은 mode]
    // ========================================================
    echo json_encode([
        'success' => false,
        'message' => '유효하지 않은 요청입니다. (mode 없음 또는 잘못됨)'
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => '처리 중 오류 발생: ' . $e->getMessage()
    ]);
}