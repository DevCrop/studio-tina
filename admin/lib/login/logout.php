<?php
include_once "../../../inc/lib/base.class.php";

session_destroy();

header("Location: ../../");
exit;
