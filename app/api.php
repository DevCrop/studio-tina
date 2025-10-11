<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/inc/lib/base.class.php';

// 데이터베이스 인스턴스 가져오기
$db = DB::getInstance();

// 기본 엔터티
$board_no = $_GET['board_no'] ?? ''; 
$category_no = $_GET['category_no'] ?? '';
$regdate = $_GET['regdate'] ?? '';

try {
    // SQL 쿼리 작성
    $query = "SELECT 
                  nb.*, 
                  nbc.name AS category_name
              FROM 
                  nb_board AS nb
              LEFT JOIN 
                  nb_board_category AS nbc 
              ON 
                  nb.category_no = nbc.no
              WHERE 
                  nb.board_no = :board_no";
	
    // 조건 추가
	if ($category_no) {
		$query .= " AND nb.category_no in ($category_no)"; 
	} 

	if ($regdate) {
		$query .= " AND nb.regdate < :regdate"; 
	}

	$query .= " ORDER BY nb.regdate DESC LIMIT 6"; 

    // 쿼리 준비
    $stmt = $db->prepare($query);

    // 바인딩
    $stmt->bindValue(':board_no', $board_no, PDO::PARAM_INT);

    if ($regdate) {
        $stmt->bindValue(':regdate', $regdate, PDO::PARAM_STR);
    }

    // 쿼리 실행
    $stmt->execute();

    // 결과 가져오기
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // JSON으로 반환
    header('Content-Type: application/json');
    echo json_encode([
		'ct' => $category_no,
        'rows' => $rows,
        'sql' => $query, // 디버깅용으로 SQL 반환
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    // 에러 발생 시 JSON 응답으로 반환
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Database error: ' . $e->getMessage(),
    ]);
}

?>
