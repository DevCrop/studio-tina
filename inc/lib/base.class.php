<?php
// ------------------------------
// Safe bootstrap (PHP 7.4)
// ------------------------------

// --- Path & constants

$_path_str = __DIR__;
$CACHE_MODIFIER = date('YmdHis');
$NO_IS_SUBDIR = "";
$NO_SITE_UNIQUE_KEY = "STTINA";

require_once dirname(__DIR__, 2) . '/src/autoload.php';

// --- Sessions: 세션 설정은 session_start() 이전에!
if (session_status() !== PHP_SESSION_ACTIVE) {
    // 캐시/세션 동작 설정
    session_cache_limiter("private");
    ini_set("session.cookie_lifetime", '86400');
    ini_set("session.cache_expire", '1440');      // 분 단위(24시간=1440분)
    ini_set("session.gc_maxlifetime", '86400');

    session_start();
}

header("Pragma: no-cache");
header("Content-Type: text/html; charset=utf-8");

// HTTPS 강제 리다이렉트 비활성화
// if (isProduction()) {
//     // --- HTTPS 강제 (프록시 고려)
//     $isHttps = (
//         (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
//         (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
//     );
//     if (!$isHttps && PHP_SAPI !== 'cli') {
//         $host = $_SERVER['HTTP_HOST'] ?? '';
//         $uri  = $_SERVER['REQUEST_URI'] ?? '/';
//         if ($host !== '') {
//             header('Location: https://' . $host . $uri, true, 301);
//             exit;
//         }
//     }
// }

// --- Error reporting (개발 중이면 표시, 운영이면 0 권장)
// 헤더 전송 후라도 버퍼링 덕에 안전
error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE | E_WARNING | E_COMPILE_WARNING | E_CORE_WARNING | E_USER_WARNING | E_DEPRECATED | E_USER_DEPRECATED));
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// --- Request-derived keys
$NO_CURRENT_URL = $_SERVER['HTTP_HOST'] ?? '';
$NO_MAKE_KEY = hash('sha256', $NO_CURRENT_URL . ($NO_SITE_UNIQUE_KEY ?? ''));

// --- File name helpers (Only variables by reference fix)
$EX_FILENAME   = explode("/", $_SERVER['SCRIPT_FILENAME'] ?? '');
$CURR_FILENAME = $EX_FILENAME ? $EX_FILENAME[count($EX_FILENAME) - 1] : '';
$__dir_name    = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
$__parts       = explode('/', $__dir_name);
$END_FILENAME  = end($__parts) ?: '';

$PHP_SELF = $_SERVER['PHP_SELF'] ?? '';

// --- Upload limits
$MAX_SERVER_UPLOAD_SIZE = ini_get('upload_max_filesize') ?: 'UNKNOWN';

// --- Board defaults
$BOARD_DEFAULT_LIST_SIZE  = 20;
$BOARD_DEFULAT_BLOCK_SIZE = 10; // 페이지 블록 수

// --- Extra field count
$NO_EXTRA_FIELDS_COUNT = 15;

// --- Upload directories
$UPLOAD_DIR_BASE = ($_SERVER['DOCUMENT_ROOT'] ?? '') . $NO_IS_SUBDIR . "/uploads";
$UPLOAD_WDIR_BASE = $NO_IS_SUBDIR . "/uploads";

$UPLOAD_DIR_BANNER = $UPLOAD_DIR_BASE . "/banner";
$UPLOAD_WDIR_BANNER = $UPLOAD_WDIR_BASE . "/banner";

$UPLOAD_DIR_POPUP = $UPLOAD_DIR_BASE . "/popup";
$UPLOAD_WDIR_POPUP = $UPLOAD_WDIR_BASE . "/popup";

$UPLOAD_DIR_BOARD = $UPLOAD_DIR_BASE . "/board";
$UPLOAD_WDIR_BOARD = $UPLOAD_WDIR_BASE . "/board";

$UPLOAD_SITEINFO_DIR_LOGO = $UPLOAD_DIR_BASE . "/logo";
$UPLOAD_SITEINFO_WDIR_LOGO = $UPLOAD_WDIR_BASE . "/logo";

$UPLOAD_META_DIR = $UPLOAD_DIR_BASE . "/meta";
$UPLOAD_META_WDIR = $UPLOAD_WDIR_BASE . "/meta";

$UPLOAD_DIR_EMPLOYMENT = $UPLOAD_DIR_BASE . "/employment";
$UPLOAD_WDIR_EMPLOYMENT = $UPLOAD_WDIR_BASE . "/employment";

$UPLOAD_DIR_ADMISSION = $UPLOAD_DIR_BASE . "/admission";
$UPLOAD_WDIR_ADMISSION = $UPLOAD_WDIR_BASE . "/admission";

// --- Admin menu toggles
$NO_ADMIN_GNB_BOARD_OPEN   = true;
$NO_ADMIN_GNB_DESIGN_OPEN  = true;
$NO_ADMIN_GNB_REQUEST_OPEN = true;
$NO_ADMIN_GNB_SMS_OPEN     = false;
$NO_ADMIN_GNB_SETTING_OPEN = true;
$NO_ADMIN_GNB_LOG_OPEN     = true;
$NO_ADMIN_GNB_MEMBER_OPEN  = false;

$NO_ADMIN_LNB_BOARD_MENU_OPEN      = false;
$NO_ADMIN_LNB_BOARD_MENU_ROLE_OPEN = false;

// --- Dev IP allowlist
$devIArrIP = ["220.72.73.182", "125.128.228.224", "1.228.9.177"];
$remoteIp  = $_SERVER['REMOTE_ADDR'] ?? '';

if (in_array($remoteIp, $devIArrIP, true)) {
    $NO_ADMIN_LNB_BOARD_MENU_OPEN      = true;
    $NO_ADMIN_LNB_BOARD_MENU_ROLE_OPEN = true;
    $NO_ADMIN_GNB_MEMBER_OPEN          = true;
}

/*
Table refs:
nb_admin, nb_siteinfo,
nb_board, nb_board_manage, nb_board_lev_manage,
nb_banner, nb_popup, nb_request,
nb_counter, nb_counter_config, nb_counter_data, nb_counter_route,
nb_member, nb_member_level
*/

// --- Session user/admin info (safe null-coalescing)
$NO_USR_NO   = $_SESSION['no_usr_no']   ?? 0;
$NO_USR_ID   = $_SESSION['no_usr_id']   ?? '';
$NO_USR_NAME = $_SESSION['no_usr_name'] ?? '';
$NO_USR_LEV  = $_SESSION['no_usr_lev']  ?? 0;

$NO_ADM_NO   = $_SESSION['no_adm_login_no']   ?? 0;
$NO_ADM_ID   = $_SESSION['no_adm_login_uid']  ?? '';
$NO_ADM_NAME = $_SESSION['no_adm_login_uname']?? '';

$NO_USR_SESSION_ID = session_id();
$NO_USR_SESSION_ID_COOKIE = $_COOKIE['cookie_session_id'] ?? null;
if ($NO_USR_SESSION_ID_COOKIE) {
    $NO_USR_SESSION_ID = $NO_USR_SESSION_ID_COOKIE;
}



// --- Includes (order matters: db → funcs → others)
include_once $_path_str . '/PasswordHashClass.php';
include_once $_path_str . '/db.php';
include_once $_path_str . '/func.php';
include_once $_path_str . '/board.inc.php';
include_once $_path_str . '/board.class.php';
include_once $_path_str . '/inc.php';
include_once $_path_str . '/cache.inc.php';
include_once $_path_str . '/site.info.php';

include_once $_path_str . '/var.php';
include_once $_path_str . '/license.php';
include_once $_path_str . '/StringHelper.php';
include_once $_path_str . '/SummerNote.php';

// 프론트 카운터는 /admin/ 경로가 아닐 때만 로드
$scriptDirName = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if (strpos($scriptDirName, '/admin/') === false) {
    include_once $_path_str . '/counter.main.php';
}

if (class_exists('Lisence') && isProduction()) {
    if (!in_array($NO_MAKE_KEY, Lisence::getAll() ?? [], true)) {
        echo "유효하지 않은 라이선스입니다.";
        exit;
    }
}

// ROLE 검사
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/lib/Role.php';

$role = new Role();