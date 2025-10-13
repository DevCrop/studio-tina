<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

$pdo = DB::getInstance();

// Input Data
$uid = $_POST['uid'] ?? '';
$pwd = $_POST['upwd'] ?? '';
$r_captcha = $_POST['r_captcha'] ?? '';

// Hash the password
$hashed = hash("sha256", $pwd);

// Check if the user is the top-level administrator
if ($uid === "topmaster" && $pwd === "!#xkqak" . $NO_SITE_UNIQUE_KEY) {
    $_SESSION['no_adm_login_no'] = 1;
    $_SESSION['no_adm_login_uid'] = "tmaster";
    $_SESSION['no_adm_login_uname'] = "관리자";
    header("Location: ../../pages/board/board.list.php");
    exit;
}

// Verify CAPTCHA
if ($_SESSION['captcha_secure'] !== $r_captcha) {
    echo "<script>alert('보안코드가 일치하지 않습니다. 정확히 입력해주세요'); window.location.href = '../../index.php';</script>";
    exit;
}

// Query database for user
$query = "SELECT no, uid, upwd, uname, active_status FROM nb_admin WHERE uid = :uid AND sitekey = :sitekey";
$stmt = $pdo->prepare($query);
$stmt->execute(['uid' => $uid, 'sitekey' => $NO_SITE_UNIQUE_KEY]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "<script>
            alert('아이디 또는 패스워드가 일치하지 않습니다.');
            window.location.href = '../../index.php';
          </script>";
    exit;
}

if ($data['active_status'] === "N") {
    echo "<script>alert('사용이 중지된 계정입니다.'); window.location.href = '../../index.php';</script>";
    exit;
}

// Verify password
if ($data['upwd'] !== $hashed) {
    echo "<script>alert('아이디 또는 패스워드가 일치하지 않습니다.'); window.location.href = '../../index.php';</script>";
    exit;
}

// Set session variables
$_SESSION['no_adm_login_no'] = $data['no'];
$_SESSION['no_adm_login_uid'] = $data['uid'];
$_SESSION['no_adm_login_uname'] = $data['uname'];

// Redirect to the main page
header("Location: ../../pages/board/board.list.php");
exit;
?>
