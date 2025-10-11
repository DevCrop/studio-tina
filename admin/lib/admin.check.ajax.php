<?php 
	if( !$_SESSION["no_adm_login_uid"]){
		echo "{\"result\":\"fail\", \"msg\":\"로그인이 필요합니다. 다시 로그인해주세요\"}";
		exit;
	}

?>