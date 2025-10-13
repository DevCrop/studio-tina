<?php
require_once "../../inc/lib/base.class.php";
require_once "../Model/EtcModel.php";

header('Content-Type: application/json');

try {
    $input = $_POST;
    $mode = $input['mode'] ?? '';

    if ($mode === 'update') {
        $data = [
            'non_pay_last_modified' => trim($input['non_pay_last_modified'] ?? ''),
            'banner_rolling_times' => (int)($input['banner_rolling_times'] ?? 0),
        ];

        $result = EtcModel::update($data);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '저장되었습니다.' : '저장 실패'
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => '유효하지 않은 요청입니다.']);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => '처리 중 오류 발생: ' . $e->getMessage()
    ]);
}