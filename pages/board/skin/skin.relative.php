
<?php
	$relative_skin = '';
	switch ($CUR_PAGE['title']) {
		case '대흥토건': {
			$relative_skin = "civil";
		} break; 
		case '디에이치건설': {
			$relative_skin = "construction";
		} break; 
		case '대흥레미콘': {
			$relative_skin = "remicon";
		} break; 
		case '대흥아스콘': {
			$relative_skin = "ascon";
		} break; 
	}

	include_once $STATIC_ROOT."/pages/board/skin/relative/relative.{$relative_skin}.php";
?>