<?

	include_once "../../../inc/lib/base.class.php";

	session_start();
    session_destroy();

	location("../../");

?>