<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/inc/lib/base.class.php';

$response = $app->handleRequest();
echo $response->send(); 