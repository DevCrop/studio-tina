<?php
include_once "../../inc/lib/base.class.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use FileUploader\FileUploader; 

require  $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/PHPMailer_new/src/Exception.php';
require  $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/PHPMailer_new/src/PHPMailer.php';
require  $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/PHPMailer_new/src/SMTP.php';
require	 dirname(__DIR__).'/FileUploader/autoload.php';



$name				= $_POST['name'];
$phone				= $_POST['phone'];
$company			= $_POST['company'];
$email				= $_POST['email'];
$budget				= $_POST['budget'];
$contents			= $_POST['contents'];

$r_captcha		= $_POST['r_captcha'];

session_start();

if ($_SESSION['captcha_secure'] != $r_captcha) {
    echo json_encode([
        "result" => "fail",
        "msg" => "보안코드가 일치하지 않습니다. 정확히 입력해주세요"
    ]);
    exit;
}

try {

	$mail = new PHPMailer(true);
	
	// 고객 계정으로 변경.
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'plttxyz0104@gmail.com'; // SMTP 사용자 이름
	$mail->Password = 'wwzy sdww luat jihe';   // SMTP 비밀번호
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

	// 보내는 사람 (고객) -> 구글
	$mail->setFrom('plttxyz0104@gmail.com', '사이트 문의내용');

	// 받는 사람 --> hello
	$mail->addAddress('hello@pltt.xyz', 'pallte');

	$mail->CharSet = 'UTF-8'; // 문자 인코딩 설정
	$mail->Encoding = 'base64'; // 인코딩 형식 설정
	$mail->Subject = '=?UTF-8?B?' . base64_encode('팔레트 주식회사 - 문의 건') . '?=';

	// HTML 메일 내용 작성
	$mail->isHTML(true); // HTML 형식 설정

	$mail->Body = "
		<html>
			<head>
				<style>
					body { font-family: Arial, sans-serif; color: #333; }
					h1 { color: #007BFF; }
					p { font-size: 14px; }
					.footer { margin-top: 20px; font-size: 12px; color: #777; }
				</style>
			</head>
			<body>
				<h1>안녕하세요, 팔레트님!</h1>
				<ul>
					<li><strong>이름:</strong> $name</li>
					<li><strong>회사명:</strong> $company</li>
					<li><strong>이메일:</strong> $email</li>
					<li><strong>전화번호 :</strong> $phone</li>
					<li><strong>예산 :</strong> $budget</li>
					<li><strong>내용 :</strong> $contents</li>
				</ul>
				<p>*첨부파일은 나인원랩스 관리자페이지에서 확인 바랍니다.*</p>
				<p>감사합니다.</p>
				<div class='footer'>
					<p>&copy; Palette. All rights reserved.</p>
				</div>
			</body>
		</html>
	";

	// 텍스트 형식도 추가 (Optional: Plain text fallback)
	$mail->AltBody = "안녕하세요, 테스트 님!\n이메일을 통해 테스트 메일을 보내드립니다.\n이름: 이메일\n이메일: 이메일\n감사합니다.";

	// 메일 전송
	$mail->send();


    // Obtain the PDO instance
    $db = DB::getInstance();
	$newFileName = null; 
	 try {
		 $newFileName = FileUploader::store('file1');
		 //echo "File uploaded successfully: " . $newFileName;
	 } catch (\RuntimeException $e) {
		 //echo "Error: " . $e->getMessage();
	 }

    // Prepare the SQL query
    $query = "INSERT INTO nb_request (
                sitekey,
				name,
                phone,
                company,
                email,
				budget,
                contents,
				file1,
                regdate
              ) VALUES (
                '$NO_SITE_UNIQUE_KEY',
                :name,
                :phone,
                :company,
                :email,
				:budget,
                :contents,
				:file1,
                NOW()
              )";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Bind parameters
	$stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':company', $company);
    $stmt->bindParam(':email', $email);
	$stmt->bindParam(':budget', $budget);
    $stmt->bindParam(':contents', $contents);
	$stmt->bindParam(':file1', $newFileName); 

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'result' => 'success',
            'msg' => '정상적으로 등록 되었습니다. 담당자가 확인하는대로 연락드리겠습니다.'
        ]);
    } else {
        echo json_encode([
            'result' => 'fail',
            'msg' => '처리중 문제가 발생하였습니다. 관리자에게 문의해주세요 [CODE001]',
            //'q' => $query,
            //'r' => $result
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'result' => 'fail',
        'msg' => '처리중 문제가 발생하였습니다. 관리자에게 문의해주세요 [CODE002]',
        'error' => $e->getMessage()
    ]);
}
?>
