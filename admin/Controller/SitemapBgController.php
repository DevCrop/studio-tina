<?php
require_once "../../inc/lib/base.class.php";
require_once "../core/Validator.php";
require_once "../Model/SitemapBgModel.php";

header('Content-Type: application/json');

try {
    $input = $_POST;
    $mode = $input['mode'] ?? '';
    $upload_path = $UPLOAD_SITEINFO_DIR_LOGO;

    $validator = new Validator();

    // UPDATE (sitemap background는 update만 사용)
    if ($mode === 'update') {
        // 기존 데이터 조회
        $existingData = SitemapBgModel::getAllSitemapBackgrounds();
        $existingMap = [];
        foreach ($existingData as $item) {
            $existingMap[$item['title']] = $item['bg_image'];
        }
        
        // 5개의 이미지 필드와 title 매핑
        $imageFieldMap = [
            'sitemap_bg_default' => 'default',
            'sitemap_bg_about' => 'about',
            'sitemap_bg_works' => 'works',
            'sitemap_bg_news' => 'news',
            'sitemap_bg_contact' => 'contact'
        ];
        
        $uploadedImages = [];
        
        // 각 이미지 필드 처리
        foreach ($imageFieldMap as $field => $title) {
            $hasNewImage = !empty($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE;
            
            if ($hasNewImage) {
                // 파일 크기 체크 (1MB = 1048576 bytes)
                if ($_FILES[$field]['size'] > 1048576) {
                    echo json_encode([
                        'success' => false,
                        'message' => $title . ': 파일 크기가 1MB를 초과합니다. 1MB 이하의 파일을 업로드해주세요.'
                    ]);
                    exit;
                }
                
                // 기존 파일 삭제
                if (isset($existingMap[$title]) && !empty($existingMap[$title])) {
                    imageDelete($upload_path . '/' . $existingMap[$title]);
                }
                
                // 새 파일 업로드
                $uploadResult = imageUpload($upload_path, $_FILES[$field], '', false);
                
                if (empty($uploadResult['saved'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => $title . ': 파일 업로드에 실패했습니다.'
                    ]);
                    exit;
                }
                
                $uploadedImages[$title] = $uploadResult['saved'];
            }
        }
        
        // DB 저장
        $result = SitemapBgModel::updateMultipleSitemapBackgrounds($uploadedImages);
        
        echo json_encode([
            'success' => $result,
            'message' => $result ? '사이트맵 배경 이미지가 정상적으로 저장되었습니다.' : '저장 실패'
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => '유효하지 않은 요청입니다.'
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => '처리 중 오류 발생: ' . $e->getMessage()
    ]);
}