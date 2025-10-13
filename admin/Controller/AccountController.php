<?php

require_once "../../inc/lib/base.class.php";
require_once "../Model/AccountModel.php";
require_once "../core/Validator.php";

header('Content-Type: application/json');

try {
    $input = $_POST;
    $mode = $input['mode'] ?? '';

    // ========================================================
    // [mode = save] 계정 등록 처리
    // ========================================================
    if ($mode === 'save') {
        $validator = new Validator();
        $validator->require('uid', $input['uid'] ?? '', '아이디');
        $validator->require('upwd', $input['upwd'] ?? '', '비밀번호');
        $validator->require('uname', $input['uname'] ?? '', '이름');
        $validator->email('email', $input['email'] ?? '', '이메일');
        $validator->phone('phone', $input['phone'] ?? '', '휴대폰');

        if ($validator->fails()) {
            echo json_encode([
                'success' => false,
                'message' => implode("\n", $validator->getErrors())
            ]);
            exit;
        }

        if (AccountModel::exists(['uid' => $input['uid']])) {
            echo json_encode([
                'success' => false,
                'message' => '이미 사용 중인 아이디입니다.'
            ]);
            exit;
        }

        if (AccountModel::exists(['email' => $input['email']])) {
            echo json_encode([
                'success' => false,
                'message' => '이미 사용 중인 이메일입니다.'
            ]);
            exit;
        }

        if (AccountModel::exists(['phone' => $input['phone']])) {
            echo json_encode([
                'success' => false,
                'message' => '이미 사용 중인 전화번호입니다.'
            ]);
            exit;
        }

        $input['created_at'] = date('Y-m-d H:i:s');
        $input['upwd'] = password_hash($input['upwd'], PASSWORD_DEFAULT);

        $id = AccountModel::insert($input);

        echo json_encode([
            'success' => true,
            'message' => '계정이 등록되었습니다.',
            'id' => $id
        ]);
        exit;
    }

    // ========================================================
    // [mode = delete] 계정 삭제 처리
    // ========================================================
    if ($mode === 'delete') {
        $id = $input['id'] ?? null;

        if (!$id) {
            echo json_encode([
                'success' => false,
                'message' => '삭제할 ID가 없습니다.'
            ]);
            exit;
        }

        $deleted = AccountModel::delete($id);

        echo json_encode([
            'success' => $deleted,
            'message' => $deleted ? '삭제되었습니다.' : '삭제 실패'
        ]);
        exit;
    }

    // ========================================================
    // [mode = update] 계정 수정 처리
    // ========================================================
    if ($mode === 'update') {
        $id = $input['no'] ?? null;

        if (!$id) {
            echo json_encode([
                'success' => false,
                'message' => '수정할 ID가 없습니다.'
            ]);
            exit;
        }

        $validator = new Validator();
        $validator->require('uid', $input['uid'] ?? '', '아이디');
        $validator->require('uname', $input['uname'] ?? '', '이름');
        $validator->email('email', $input['email'] ?? '', '이메일');
        $validator->phone('phone', $input['phone'] ?? '', '휴대폰');

        if ($validator->fails()) {
            echo json_encode([
                'success' => false,
                'message' => implode("\n", $validator->getErrors()) ?: '입력값 오류가 있습니다.'
            ]);
            exit;
        }

        // 중복 검사
        if (AccountModel::existsExceptSelf(['uid' => $input['uid']], $id)) {
            echo json_encode(['success' => false, 'message' => '이미 사용 중인 아이디입니다.']);
            exit;
        }
        if (AccountModel::existsExceptSelf(['email' => $input['email']], $id)) {
            echo json_encode(['success' => false, 'message' => '이미 사용 중인 이메일입니다.']);
            exit;
        }
        if (AccountModel::existsExceptSelf(['phone' => $input['phone']], $id)) {
            echo json_encode(['success' => false, 'message' => '이미 사용 중인 전화번호입니다.']);
            exit;
        }

        // 비밀번호 처리
        $upwd = $input['upwd'] ?? '';
        $upwdConfirm = $input['upwd_confirm'] ?? '';

        if (!empty($upwd) || !empty($upwdConfirm)) {
            if ($upwd !== $upwdConfirm) {
                echo json_encode([
                    'success' => false,
                    'message' => '비밀번호와 비밀번호 확인이 일치하지 않습니다.'
                ]);
                exit;
            }

            $input['upwd'] = password_hash($upwd, PASSWORD_DEFAULT);
        } else {
            unset($input['upwd']);
        }

        $updated = AccountModel::update($id, $input);

        echo json_encode([
            'success' => $updated,
            'message' => $updated ? '수정되었습니다.' : '수정 실패'
        ]);
        exit;
    }



    // DELETE_ARRAY
    if ($mode === 'delete_array') {
        $ids = json_decode($input['ids'] ?? '[]', true);

        if (!is_array($ids) || empty($ids)) {
            echo json_encode(['success' => false, 'message' => '삭제할 항목이 없습니다.']);
            exit;
        }

        $result = AccountModel::deleteMultiple($ids);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '선택 항목이 삭제되었습니다.' : '삭제 실패'
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