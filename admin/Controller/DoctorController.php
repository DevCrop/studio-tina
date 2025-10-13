<?php
require_once "../../inc/lib/base.class.php";
require_once "../core/Validator.php";
require_once "../Model/DoctorModel.php";

header('Content-Type: application/json');

try {
    $input = $_POST;
    $mode = $input['mode'] ?? '';
    $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/doctors";

    $validator = new Validator();

    // INSERT
    if ($mode === 'insert') {
        $data = [
            'title'               => trim($input['title'] ?? ''),
            'branch_id'           => (int)($input['branch_id'] ?? 0),
            'position'            => trim($input['position'] ?? ''),
            'department'          => trim($input['department'] ?? ''),
            'keywords'            => trim($input['keywords'] ?? ''),
            'is_ceo'              => (int)($input['is_ceo'] ?? 2),
            'career'              => trim($input['career'] ?? ''),
            'activity'            => trim($input['activity'] ?? ''),
            'education'           => trim($input['education'] ?? ''),
            'publications'        => trim($input['publications'] ?? ''),
            'publication_visible' => (int)($input['publication_visible'] ?? 1),
            'is_active'           => (int)($input['is_active'] ?? 1),
        ];

        // ✅ sort_no 자동 지정
		/*
        $sortNo = isset($input['sort_no']) && (int)$input['sort_no'] > 0
            ? (int)$input['sort_no']
            : DoctorModel::getMaxSortNo() + 1;

        $data['sort_no'] = $sortNo;
		*/

        // 유효성 검사
        $validator->require('title', $data['title'], '이름');
        $validator->require('branch_id', $data['branch_id'], '지점');
        $validator->require('position', $data['position'], '직책');
        $validator->require('department', $data['department'], '진료과');
        $validator->require('keywords', $data['keywords'], '키워드');
        $validator->require('is_ceo', $data['is_ceo'], '대표 여부');

        if ($validator->fails()) {
            echo json_encode([
                'success' => false,
                'message' => implode("\n", $validator->getErrors())
            ]);
            exit;
        }

        // 이미지 업로드
        $thumb = imageUpload($upload_path, $_FILES['thumb_image'] ?? []);
        $detail = imageUpload($upload_path, $_FILES['detail_image'] ?? []);
        $data['thumb_image'] = $thumb['saved'] ?? '';
        $data['detail_image'] = $detail['saved'] ?? '';

		DoctorModel::bumpSortNosOnInsert(); // 필요 시 범위 제한하려면 인자 전달 (아래 2) 참고)
		$data['sort_no'] = 1;

		$result = DoctorModel::insert($data);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '의료진이 등록되었습니다.' : '등록 실패'
        ]);
        exit;
    }

    // UPDATE
    if ($mode === 'update') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) throw new Exception("ID가 없습니다.");

        $data = [
            'title'               => trim($input['title'] ?? ''),
            'branch_id'           => (int)($input['branch_id'] ?? 0),
            'position'            => trim($input['position'] ?? ''),
            'department'          => trim($input['department'] ?? ''),
            'keywords'            => trim($input['keywords'] ?? ''),
            'career'              => trim($input['career'] ?? ''),
            'activity'            => trim($input['activity'] ?? ''),
            'education'           => trim($input['education'] ?? ''),
            'publications'        => trim($input['publications'] ?? ''),
            'publication_visible' => (int)($input['publication_visible'] ?? 1),
            'is_active'           => (int)($input['is_active'] ?? 1),
            'is_ceo'              => (int)($input['is_ceo'] ?? 2),
        ];

        $newSortNo = (int)($input['sort_no'] ?? 0);
        $data['sort_no'] = $newSortNo;

        // 유효성 검사
        $validator->require('title', $data['title'], '이름');
        $validator->require('branch_id', $data['branch_id'], '지점');
        $validator->require('position', $data['position'], '직책');
        $validator->require('department', $data['department'], '진료과');
        $validator->require('keywords', $data['keywords'], '키워드');
        $validator->require('is_ceo', $data['is_ceo'], '대표 여부');

        if ($validator->fails()) {
            echo json_encode([
                'success' => false,
                'message' => implode("\n", $validator->getErrors())
            ]);
            exit;
        }

        // 기존 데이터
        $existing = DoctorModel::find($id);
        if (!$existing) {
            echo json_encode(['success' => false, 'message' => '데이터를 찾을 수 없습니다.']);
            exit;
        }

        $oldSortNo = (int)$existing['sort_no'];

        // ✅ 정렬 충돌 처리
        if ($newSortNo !== $oldSortNo && $newSortNo > 0) {
            DoctorModel::shiftSortNosForUpdate($oldSortNo, $newSortNo, $id);
        }

        // 이미지 교체 처리
        if (!empty($_FILES['thumb_image']) && $_FILES['thumb_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            imageDelete($upload_path . '/' . $existing['thumb_image']);
            $thumb = imageUpload($upload_path, $_FILES['thumb_image']);
            $data['thumb_image'] = $thumb['saved'];
        }

        if (!empty($_FILES['detail_image']) && $_FILES['detail_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            imageDelete($upload_path . '/' . $existing['detail_image']);
            $detail = imageUpload($upload_path, $_FILES['detail_image']);
            $data['detail_image'] = $detail['saved'];
        }

        $result = DoctorModel::update($id, $data);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '수정되었습니다.' : '수정 실패'
        ]);
        exit;
    }

    // DELETE
    if ($mode === 'delete') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) throw new Exception("ID가 없습니다.");

        $existing = DoctorModel::find($id);

        if ($existing) {
            imageDelete($upload_path . '/' . $existing['thumb_image']);
            imageDelete($upload_path . '/' . $existing['detail_image']);
        }

        $result = DoctorModel::delete($id);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '삭제되었습니다.' : '삭제 실패'
        ]);
        exit;
    }

    // DELETE ARRAY
    if ($mode === 'delete_array') {
        $ids = json_decode($input['ids'] ?? '[]', true);

        if (!is_array($ids) || empty($ids)) {
            throw new Exception("삭제할 ID 목록이 없습니다.");
        }

        foreach ($ids as $id) {
            $existing = DoctorModel::find((int)$id);
            if ($existing) {
                imageDelete($upload_path . '/' . $existing['thumb_image']);
                imageDelete($upload_path . '/' . $existing['detail_image']);
            }
        }

        $result = DoctorModel::deleteMultiple($ids);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '선택 항목이 삭제되었습니다.' : '삭제 실패'
        ]);
        exit;
    }

    if ($mode === 'sort') {
        $id = (int)($input['id'] ?? 0);
        $newNo = (int)($input['new_no'] ?? 0);


        
        if (!$id || $newNo <= 0) {  // 0 이하는 잘못된 데이터로 처리
            echo json_encode(['success' => false, 'message' => '잘못된 데이터']);
            exit;
        }

        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM nb_doctors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$currentData) {
            echo json_encode(['success' => false, 'message' => '존재하지 않는 항목입니다.']);
            exit;
        }

        $oldNo = (int)$currentData['sort_no'];

        if ($oldNo === $newNo) {
            echo json_encode(['success' => true, 'message' => '변경 없음']);
            exit;
        }

        $minSortNo = DoctorModel::getMinSortNo();
        $maxSortNo = DoctorModel::getMaxSortNo();
        
        if ($newNo > $maxSortNo) {
            echo json_encode(['success' => false, 'message' => '제일 높은 순서의 게시물입니다.']);
            exit;
        }

        if ($newNo < $minSortNo) {
            echo json_encode(['success' => false, 'message' => '제일 낮은 순서의 게시물입니다.']);
            exit;
        }


        DoctorModel::shiftSortNosForUpdate($oldNo, $newNo, $id);

        $dataToUpdate = [
            'title'               => $currentData['title'],
            'branch_id'           => (int)$currentData['branch_id'],
            'position'            => $currentData['position'],
            'department'          => $currentData['department'],
            'keywords'            => $currentData['keywords'],
            'career'              => $currentData['career'],
            'activity'            => $currentData['activity'],
            'education'           => $currentData['education'],
            'publications'        => $currentData['publications'],
            'publication_visible' => (int)$currentData['publication_visible'],
            'is_active'           => (int)$currentData['is_active'],
            'is_ceo'              => (int)$currentData['is_ceo'],
            'sort_no'             => $newNo,
        ];

        $updateResult = DoctorModel::update($id, $dataToUpdate);

        echo json_encode([
            'success' => (bool)$updateResult,
            'message' => $updateResult ? '순서가 변경되었습니다.' : '변경 실패'
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