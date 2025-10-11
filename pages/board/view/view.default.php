<?php
	$role_info		= getBoardRole($board_no, $NO_USR_LEV);

	if($role_info[0]['role_view'] == "N"){
		alert("접근 권한이 없습니다.");
	}
?>

<div class="no-skin">

	<div class="no-view-top">
		<span class="no-view-top__title"><?=$data['title']?></span>
		<span class="no-view-top__date"><?= date("Y.m.d", strtotime($data['regdate'])) ?></span>
	</div>

	<div class="no-view-bot">
		<div class="no-view-bot__contents"><?=htmlspecialchars_decode($data['contents'])//stripslashes(nl2br($data[contents]))?></div>
	</div>
</div>