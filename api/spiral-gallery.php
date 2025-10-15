<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php';
use Database\DB;

header('Content-Type: application/json; charset=utf-8');

try {
    $boardNo = 26; // Works 게시판
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;

    $db = \DB::getInstance();
    $stmt = $db->prepare("
        SELECT no, title, thumb_image, regdate, direct_url
        FROM nb_board
        WHERE board_no = :board_no
        ORDER BY no DESC
        LIMIT :limit
    ");
    $stmt->bindValue(':board_no', $boardNo, \PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $stmt->execute();
    
    $works = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    // 이미지 URL 처리
    foreach ($works as &$work) {
        $imageUrl = '';
        if (!empty($work['thumb_image'])) {
            $imageUrl = '/uploads/board/' . $work['thumb_image'];
        }
        $work['image_url'] = $imageUrl;
        
        // 링크 URL
        $work['link_url'] = '/works/' . $work['no'];
    }
    unset($work);

    echo json_encode([
        'success' => true,
        'data' => $works
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}