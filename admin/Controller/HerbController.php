<?php
require_once "../../inc/lib/base.class.php";
require_once "../Model/HerbModel.php"; // ← 방금 만든 모델

header('Content-Type: application/json; charset=UTF-8');

try {
    // mode 체크: update만 허용
    $mode = $_POST['mode'] ?? '';
    if ($mode !== 'update') {
        echo json_encode(['success' => false, 'message' => '유효하지 않은 요청입니다.']);
        exit;
    }

    // 필수: id
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID가 없습니다.']);
        exit;
    }

    // 존재 확인(선택)
    $existing = HerbModel::find($id);
    if (!$existing) {
        echo json_encode(['success' => false, 'message' => '데이터를 찾을 수 없습니다.']);
        exit;
    }

    // 입력 정리: 세 필드만
    $is_confirmed = isset($_POST['is_confirmed']) ? (int)$_POST['is_confirmed'] : 0;
    $is_confirmed = ($is_confirmed === 1) ? 1 : 0;

    $confirm_by   = isset($_POST['confirm_by'])   ? trim($_POST['confirm_by'])   : '';
    $confirm_note = isset($_POST['confirm_note']) ? trim($_POST['confirm_note']) : '';

    // 규칙: 미확인(0)일 땐 확인자/메모 비움
    if ($is_confirmed === 0) {
        $confirm_by = '';
        $confirm_note = '';
    }

    $ok = HerbModel::updateConfirmFields($id, [
        'is_confirmed' => $is_confirmed,
        'confirm_by'   => $confirm_by,
        'confirm_note' => $confirm_note,
    ]);

    echo json_encode([
        'success' => (bool)$ok,
        'message' => $ok ? '저장되었습니다.' : '저장 실패'
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => '처리 중 오류 발생: ' . $e->getMessage()
    ]);
    exit;
}
