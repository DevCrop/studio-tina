<?php
require_once "../../inc/lib/base.class.php";
require_once "../core/Validator.php";
require_once "../Model/ProductModel.php";

header('Content-Type: application/json; charset=utf-8');

try {
    $input = $_POST;
    $mode = $input['mode'] ?? '';
    $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/products";
    $validator = new Validator();


        // 세컨더리 옵션 목록 (셀렉트 변경 시 호출)
    if ($mode === 'secondary_options') {
        // 전역 매핑이 여기서도 보이도록 include 되어있어야 함
        // 예: $product_secondary_categories 가 위에서 정의돼 있거나 include
        $categoryId = (int)($input['category_id'] ?? 0);
        $options = [];



        if (isset($product_secondary_categories[$categoryId]) && is_array($product_secondary_categories[$categoryId])) {
            foreach ($product_secondary_categories[$categoryId] as $id => $label) {
                $options[] = ['id' => (string)$id, 'label' => (string)$label];
            }
        }

        echo json_encode(['options' => $options], JSON_UNESCAPED_UNICODE);
        exit;
    }


    if ($mode === 'insert') {
        $data = [
            'product_category_id' => (int)($input['product_category_id'] ?? 0),
            'title'               => trim($input['title'] ?? ''),
            'sub_title'           => trim($input['sub_title'] ?? ''),
            'description'         => trim($input['description'] ?? ''),
            'url'                 => trim($input['url'] ?? ''),
            'feature'             => trim($input['feature'] ?? ''),
            'feature_desc'        => trim($input['feature_desc'] ?? ''),
            'is_active'           => (int)($input['is_active'] ?? 1),
        ];

        $validator->require('title', $data['title'], '제품명');
        $validator->require('product_category_id', $data['product_category_id'], '제품 카테고리');
        $validator->require('is_active', $data['is_active'], '노출 여부');

        if ($validator->fails()) {
            echo json_encode(['success' => false, 'message' => implode("\n", $validator->getErrors())], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $imgNames = ['thumb_image','detail_image','banner_img','product_img_1','product_img_2','product_img_3','product_img_4','product_img_5'];
        foreach ($imgNames as $n) {
            if (!empty($_FILES[$n]) && $_FILES[$n]['error'] !== UPLOAD_ERR_NO_FILE) {
                $u = imageUpload($upload_path, $_FILES[$n]);
                $data[$n] = $u['saved'] ?? '';
            } else {
                $data[$n] = '';
            }
        }

        $data['selected_variants'] = json_encode((array)($input['selected_variants'] ?? []), JSON_UNESCAPED_UNICODE);

        $specs = [];
        $titles = (array)($input['spec_title'] ?? []);
        $descs  = (array)($input['spec_desc'] ?? []);
        $len = max(count($titles), count($descs));
        for ($i=0;$i<$len;$i++) {
            $t = trim($titles[$i] ?? '');
            $d = trim($descs[$i] ?? '');
            if ($t === '' && $d === '') continue;
            $specs[] = ['title'=>$t, 'desc'=>$d];
        }
        $data['variant_specs'] = json_encode($specs, JSON_UNESCAPED_UNICODE);

        ProductModel::bumpSortNosOnInsert();
        $data['sort_no'] = 1;

        $result = ProductModel::insert($data);
        echo json_encode(['success' => (bool)$result, 'message' => $result ? '제품이 등록되었습니다.' : '등록 실패'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($mode === 'update') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) throw new Exception("ID가 없습니다.");

        $data = [
            'product_category_id' => (int)($input['product_category_id'] ?? 0),
            'title'               => trim($input['title'] ?? ''),
            'sub_title'           => trim($input['sub_title'] ?? ''),
            'description'         => trim($input['description'] ?? ''),
            'url'                 => trim($input['url'] ?? ''),
            'feature'             => trim($input['feature'] ?? ''),
            'feature_desc'        => trim($input['feature_desc'] ?? ''),
            'is_active'           => (int)($input['is_active'] ?? 1),
        ];

        $newSortNo = (int)($input['sort_no'] ?? 0);
        $data['sort_no'] = $newSortNo;

        $validator->require('title', $data['title'], '제품명');
        $validator->require('product_category_id', $data['product_category_id'], '제품 카테고리');
        $validator->require('is_active', $data['is_active'], '노출 여부');

        if ($validator->fails()) {
            echo json_encode(['success' => false, 'message' => implode("\n", $validator->getErrors())], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $existing = ProductModel::find($id);
        if (!$existing) {
            echo json_encode(['success' => false, 'message' => '데이터를 찾을 수 없습니다.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $oldSortNo = (int)$existing['sort_no'];
        if ($newSortNo !== $oldSortNo && $newSortNo > 0) {
            ProductModel::shiftSortNosForUpdate($oldSortNo, $newSortNo, $id);
        }

        $imgNames = ['thumb_image','detail_image','banner_img','product_img_1','product_img_2','product_img_3','product_img_4','product_img_5'];
        foreach ($imgNames as $n) {
            if (!empty($_FILES[$n]) && $_FILES[$n]['error'] !== UPLOAD_ERR_NO_FILE) {
                if (!empty($existing[$n])) imageDelete($upload_path . '/' . $existing[$n]);
                $u = imageUpload($upload_path, $_FILES[$n]);
                $data[$n] = $u['saved'] ?? '';
            }
        }

        $data['selected_variants'] = json_encode((array)($input['selected_variants'] ?? []), JSON_UNESCAPED_UNICODE);

        $specs = [];
        $titles = (array)($input['spec_title'] ?? []);
        $descs  = (array)($input['spec_desc'] ?? []);
        $len = max(count($titles), count($descs));
        for ($i=0;$i<$len;$i++) {
            $t = trim($titles[$i] ?? '');
            $d = trim($descs[$i] ?? '');
            if ($t === '' && $d === '') continue;
            $specs[] = ['title'=>$t, 'desc'=>$d];
        }
        $data['variant_specs'] = json_encode($specs, JSON_UNESCAPED_UNICODE);

        $result = ProductModel::update($id, $data);
        echo json_encode(['success' => (bool)$result, 'message' => $result ? '수정되었습니다.' : '수정 실패'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($mode === 'delete') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) throw new Exception("ID가 없습니다.");

        $existing = ProductModel::find($id);
        if ($existing) {
            $imgNames = ['thumb_image','detail_image','banner_img','product_img_1','product_img_2','product_img_3','product_img_4','product_img_5'];
            foreach ($imgNames as $n) {
                if (!empty($existing[$n])) imageDelete($upload_path . '/' . $existing[$n]);
            }
        }

        $result = ProductModel::delete($id);
        echo json_encode(['success' => (bool)$result, 'message' => $result ? '삭제되었습니다.' : '삭제 실패'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($mode === 'delete_array') {
        $ids = json_decode($input['ids'] ?? '[]', true);
        if (!is_array($ids) || empty($ids)) throw new Exception("삭제할 ID 목록이 없습니다.");

        foreach ($ids as $pid) {
            $existing = ProductModel::find((int)$pid);
            if ($existing) {
                $imgNames = ['thumb_image','detail_image','banner_img','product_img_1','product_img_2','product_img_3','product_img_4','product_img_5'];
                foreach ($imgNames as $n) {
                    if (!empty($existing[$n])) imageDelete($upload_path . '/' . $existing[$n]);
                }
            }
        }

        $result = ProductModel::deleteMultiple($ids);
        echo json_encode(['success' => (bool)$result, 'message' => $result ? '선택 항목이 삭제되었습니다.' : '삭제 실패'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($mode === 'sort') {
        $id = (int)($input['id'] ?? 0);
        $newNo = (int)($input['new_no'] ?? 0);
        if (!$id || $newNo <= 0) {
            echo json_encode(['success' => false, 'message' => '잘못된 데이터'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM nb_products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$currentData) {
            echo json_encode(['success' => false, 'message' => '존재하지 않는 항목입니다.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $oldNo = (int)$currentData['sort_no'];
        if ($oldNo === $newNo) {
            echo json_encode(['success' => true, 'message' => '변경 없음'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $minSortNo = ProductModel::getMinSortNo();
        $maxSortNo = ProductModel::getMaxSortNo();
        if ($newNo > $maxSortNo) {
            echo json_encode(['success' => false, 'message' => '제일 높은 순서의 게시물입니다.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        if ($newNo < $minSortNo) {
            echo json_encode(['success' => false, 'message' => '제일 낮은 순서의 게시물입니다.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        ProductModel::shiftSortNosForUpdate($oldNo, $newNo, $id);

        $dataToUpdate = [
            'product_category_id' => (int)$currentData['product_category_id'],
            'title'               => $currentData['title'],
            'sub_title'           => $currentData['sub_title'],
            'description'         => $currentData['description'],
            'url'                 => $currentData['url'],
            'feature'             => $currentData['feature'],
            'feature_desc'        => $currentData['feature_desc'],
            'thumb_image'         => $currentData['thumb_image'],
            'detail_image'        => $currentData['detail_image'],
            'banner_img'          => $currentData['banner_img'],
            'product_img_1'       => $currentData['product_img_1'],
            'product_img_2'       => $currentData['product_img_2'],
            'product_img_3'       => $currentData['product_img_3'],
            'product_img_4'       => $currentData['product_img_4'],
            'product_img_5'       => $currentData['product_img_5'],
            'selected_variants'   => $currentData['selected_variants'],
            'variant_specs'       => $currentData['variant_specs'],
            'is_active'           => (int)$currentData['is_active'],
            'sort_no'             => $newNo,
        ];

        $updateResult = ProductModel::update($id, $dataToUpdate);
        echo json_encode(['success' => (bool)$updateResult, 'message' => $updateResult ? '순서가 변경되었습니다.' : '변경 실패'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode(['success' => false, 'message' => '유효하지 않은 요청입니다.'], JSON_UNESCAPED_UNICODE);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => '처리 중 오류 발생: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}