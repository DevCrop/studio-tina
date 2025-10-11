<section class="no-business mt80">
  <div class="no-business__cnt" <?=$aos_middle?>>
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
		  <a href="<?=$link?>">
			<!--img-->
			<div class="no-business__cnt-img">
			  <img src="<?=$imgSrc?>"alt="<?=$title?>" />
			</div>

			<!--txt-->
			<div class="no-business__cnt-txt">

				<?
					if($board_no !== 81 || $board_no !== "81"){	
				?>
				<!--카테고리-->
				  <div class="no-category">
					<span><?=$v['category_name']?></span>
				  </div>
				<?
					} 
				?>
			  <!--제목-->
			  <div class="no-business__cnt-title">
				<p>
				  <?=$title?>
				</p>
			  </div>
			  <!--info-->
			  <div class="no-news__cnt-info">
				<?=$contents?>
			  </div>
			  <div class="no-news__cnt-date"><?=getChangeDate($v[regdate], "Y.m.d")?></div>
			</div>
		  </a>
		</li>
		  <?
        $rnumber--;
        }
    ?>
	  </ul>
	</div>
</section>

<script type="module">
	import Lightbox from '/resource/vendor/photoswipe/photoswipe-lightbox.esm.js';
	const lightbox = new Lightbox({
	  gallery: '#my-gallery',
	  children: '.my-image',
	  pswpModule: () => import('/resource/vendor/photoswipe/photoswipe.esm.js')
	});
	lightbox.init();
</script>



