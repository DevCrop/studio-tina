<?php
		{
     ?>        
		 <div class="no-relative__txt-card">
				<ul>
					<?
					foreach($arrResultSet as $k=>$v){
					$title = iconv_substr($v[title], 0, 100, "utf-8");
					$contents = strip_tags($v[contents]);
					$contents = iconv_substr($contents, 0, 500, "utf-8");
					$link = "./board.view.php?board_no=$board_no&no=$v[no]&searchKeyword=".base64_encode($searchKeyword)."&searchColumn=".base64_encode($searchColumn)."&page=$page";

					$imgSrc = "";
					if($v[thumb_image])
						$imgSrc = $UPLOAD_WDIR_BOARD."/".$v[thumb_image];
					else{
						$imgSrc = getImageTag($v[contents], "src");
						$imgSrc = $imgSrc[0];
					} 

					$link_image = $imgSrc;

					$imgData = 'data-pswp-width="1600" data-pswp-height="1024" class="my-image"';
					
					if($v['direct_url']){
						$link_image = $v['direct_url'];
						$imgData = '';
					} 
				?>
				  <li>
					<!--logo-->
					<div class="no-relative__logo">
					  <img
						src="/resource/images/dh_bulid_logo.png"
						alt="디에이치건설(주) 로고"
					  />
					</div>
					<!--공사명-->
					<div class="no-relative__name"><?=$v['extra1']?></div>
					<!--발주처-->
					<div class="no-relative__client"><?=$v['extra2']?></div>
					<!--공사금액-->
					<div class="no-relative__cost"><?=$v['extra3']?></div>
					<!--년도-->
					<div class="no-relative__year"><?=$v['extra4']?></div>
				  </li>
				     <?
						$rnumber--;
						}
					?>
				</ul>
			</div>
	<?php
		}
    ?>