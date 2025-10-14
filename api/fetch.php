<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php';

use Database\DB;

header('Content-Type: application/json; charset=utf-8');

try {
    $boardNo = 26;
    $categoryNo = isset($_GET['category_no']) ? (int)$_GET['category_no'] : null;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perpage = isset($_GET['perpage']) ? (int)$_GET['perpage'] : 12;

    // 카테고리가 0이면 null로 처리 (전체)
    if ($categoryNo === 0) {
        $categoryNo = null;
    }

    // 카테고리 목록 가져오기 (첫 요청 시만 필요)
    $includeCategories = isset($_GET['include_categories']) && $_GET['include_categories'] === '1';
    $categories = [];
    if ($includeCategories) {
        $categories = getBoardCategory($boardNo) ?: [];
    }

    // DB에서 게시글 목록 가져오기
    $data = DB::fetchBoardList([
        'board_no'   => $boardNo,
        'category_no'=> $categoryNo,
        'page'       => $page,
        'perpage'    => $perpage,
        'search'     => [
            'keyword' => '',
            'column'  => '',
            'sdate'   => '',
            'edate'   => '',
        ],
    ]);

    // 이미지 경로 처리 및 contents 전처리
    $list = $data['arrResultSet'] ?? [];
    foreach ($list as &$item) {
        // 이미지 URL 처리
        $imageUrl = '';
        if (!empty($item['thumb_image'])) {
            $imageUrl = '/uploads/board/' . $item['thumb_image'];
        }
        $item['image_url'] = $imageUrl;
        
        // contents 전처리: HTML 엔티티 디코딩 -> 태그 제거 -> 텍스트만 추출
        if (!empty($item['contents'])) {
            $contents = $item['contents'];
            // HTML 엔티티 디코딩
            $contents = html_entity_decode($contents, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            // HTML 태그 제거
            $contents = strip_tags($contents);
            // 앞뒤 공백 제거
            $contents = trim($contents);
            $item['contents'] = $contents;
        }
    }
    unset($item);

    // 성공 응답
    $response = [
        'success' => true,
        'data' => [
            'list' => $list,
            'pagination' => [
                'total' => $data['totalCnt'] ?? 0,
                'current_page' => $data['listCurPage'] ?? 1,
                'per_page' => $data['listRowCnt'] ?? 12,
                'total_pages' => $data['Page'] ?? 0,
            ],
            'category_no' => $categoryNo,
            'board_title' => $data['board_title'] ?? '',
        ],
    ];

    // 카테고리 정보가 요청된 경우 포함
    if ($includeCategories) {
        $response['data']['categories'] = $categories;
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // 오류 응답
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}