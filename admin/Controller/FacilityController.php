<?php
require_once "../../inc/lib/base.class.php";
require_once "../core/Validator.php";
require_once "../Model/FacilityModel.php";

header('Content-Type: application/json');

try {
    $input = $_POST;
    $mode = $input['mode'] ?? '';
    $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/facilities";

    $validator = new Validator();

    // INSERT
    if ($mode === 'insert') {
        $data = [
            'branch_id'  => (int)($input['branch_id'] ?? 0),
            'title'      => trim($input['title'] ?? ''),
            'categories' => (int)($input['categories'] ?? 0),
            'is_active'  => (int)($input['is_active'] ?? 1),
        ];

        // ✅ sort_no 자동 지정
		/*
        $sortNo = isset($input['sort_no']) && (int)$input['sort_no'] > 0
            ? (int)$input['sort_no']
            : FacilityModel::getMaxSortNo() + 1;

        $data['sort_no'] = $sortNo;
		*/

        $validator->require('title', $data['title'], '시설명');
        $validator->require('branch_id', $data['branch_id'], '지점');
        $validator->require('categories', $data['categories'], '시설 카테고리');

        if (empty($_FILES['thumb_image']) || $_FILES['thumb_image']['error'] === UPLOAD_ERR_NO_FILE) {
            $validator->require('thumb_image', '', '썸네일 이미지');
        }

        if ($validator->fails()) {
            echo json_encode([
                'success' => false,
                'message' => implode("\n", $validator->getErrors())
            ]);
            exit;
        }

        $thumb = imageUpload($upload_path, $_FILES['thumb_image'] ?? []);
        $data['thumb_image'] = $thumb['saved'] ?? '';
		
		FacilityModel::bumpSortNosOnInsert();
		$data['sort_no'] = 1;

		$result = FacilityModel::insert($data);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '시설이 등록되었습니다.' : '등록 실패'
        ]);
        exit;
    }



    // UPDATE
    if ($mode === 'update') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) throw new Exception("ID가 없습니다.");

        $data = [
            'title'      => trim($input['title'] ?? ''),
            'branch_id'  => (int)($input['branch_id'] ?? 0),
            'categories' => (int)($input['categories'] ?? 0),
            'is_active'  => (int)($input['is_active'] ?? 1),
        ];

        $newSortNo = (int)($input['sort_no'] ?? 0);
        $data['sort_no'] = $newSortNo;

        $validator->require('title', $data['title'], '시설명');
        $validator->require('branch_id', $data['branch_id'], '지점');
        $validator->require('categories', $data['categories'], '시설 카테고리');

        $existing = FacilityModel::find($id);
        if (!$existing) {
            echo json_encode(['success' => false, 'message' => '데이터를 찾을 수 없습니다.']);
            exit;
        }

        // ✅ 정렬 충돌 처리
        $oldSortNo = (int)$existing['sort_no'];
        if ($newSortNo !== $oldSortNo && $newSortNo > 0) {
            FacilityModel::shiftSortNosForUpdate($oldSortNo, $newSortNo, $id);
        }

        $hasNewThumb = !empty($_FILES['thumb_image']) && $_FILES['thumb_image']['error'] !== UPLOAD_ERR_NO_FILE;
        if (!$hasNewThumb && empty($existing['thumb_image'])) {
            $validator->require('thumb_image', '', '썸네일 이미지');
        }

        if ($validator->fails()) {
            echo json_encode([
                'success' => false,
                'message' => implode("\n", $validator->getErrors())
            ]);
            exit;
        }

        if ($hasNewThumb) {
            imageDelete($upload_path . '/' . $existing['thumb_image']);
            $thumb = imageUpload($upload_path, $_FILES['thumb_image']);
            $data['thumb_image'] = $thumb['saved'];
        }

        $result = FacilityModel::update($id, $data);

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

        $existing = FacilityModel::find($id);

        if ($existing) {
            imageDelete($upload_path . '/' . $existing['thumb_image']);
        }

        $result = FacilityModel::delete($id);

        echo json_encode([
            'success' => $result,
            'message' => $result ? '삭제되었습니다.' : '삭제 실패'
        ]);
        exit;
    }

    // DELETE MULTIPLE
    if ($mode === 'delete_array') {
        $ids = json_decode($input['ids'] ?? '[]', true);

        if (!is_array($ids) || empty($ids)) {
            throw new Exception("삭제할 ID 목록이 없습니다.");
        }

        foreach ($ids as $id) {
            $existing = FacilityModel::find((int)$id);
            if ($existing) {
                imageDelete($upload_path . '/' . $existing['thumb_image']);
            }
        }

        $result = FacilityModel::deleteMultiple($ids);

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
        $stmt = $db->prepare("SELECT * FROM nb_facilities WHERE id = :id");
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

        $minSortNo = FacilityModel::getMinSortNo();
        $maxSortNo = FacilityModel::getMaxSortNo();
        
        if ($newNo > $maxSortNo) {
            echo json_encode(['success' => false, 'message' => '제일 높은 순서의 게시물입니다.']);
            exit;
        }

        if ($newNo < $minSortNo) {
            echo json_encode(['success' => false, 'message' => '제일 낮은 순서의 게시물입니다.']);
            exit;
        }


        FacilityModel::shiftSortNosForUpdate($oldNo, $newNo, $id);

        $dataToUpdate = [
            'title'      => $currentData['title'],
            'branch_id'  => (int)$currentData['branch_id'],
            'categories' => (int)$currentData['categories'],
            'is_active'  => (int)$currentData['is_active'],
            'thumb_image'=> $currentData['thumb_image'],
            'sort_no'    => $newNo,
        ];

        $updateResult = FacilityModel::update($id, $dataToUpdate);

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