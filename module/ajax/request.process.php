<?php
include_once "../../inc/lib/base.class.php";

header('Content-Type: application/json; charset=utf-8');

$name				= $_POST['name'] ?? '';
$phone				= $_POST['phone'] ?? '';
$company			= $_POST['company'] ?? '';
$email				= $_POST['email'] ?? '';
$contents			= $_POST['contents'] ?? '';

// 필수 값 검증
if (empty($name) || empty($email) || empty($phone) || empty($contents)) {
    echo json_encode([
        "result" => "fail",
        "msg" => "필수 항목을 모두 입력해주세요."
    ]);
    exit;
}

try {
    // Obtain the PDO instance
    $db = DB::getInstance();

    // Prepare the SQL query
    $query = "INSERT INTO nb_request (
                sitekey,
				name,
                phone,
                company,
                email,
                contents,
                regdate
              ) VALUES (
                '$NO_SITE_UNIQUE_KEY',
                :name,
                :phone,
                :company,
                :email,
                :contents,
                NOW()
              )";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Bind parameters
	$stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':company', $company);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contents', $contents); 

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'result' => 'success',
            'msg' => 'Thank you for your message! We will get back to you soon.'
        ]);
    } else {
        echo json_encode([
            'result' => 'fail',
            'msg' => 'An error occurred while processing your request. Please try again or contact us directly.'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'result' => 'fail',
        'msg' => 'An error occurred while processing your request. Please try again later.',
        'error' => $e->getMessage()
    ]);
}
?>