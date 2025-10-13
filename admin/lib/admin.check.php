<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

if (empty($_SESSION["no_adm_login_uid"])) {
	alert("로그인이 필요합니다.", $NO_IS_SUBDIR . "/admin");
	exit;
}
