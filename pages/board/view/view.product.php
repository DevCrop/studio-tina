
<?php 
	$imgSrc = $UPLOAD_WDIR_BOARD . '/' . $data['thumb_image'];
?>
<main>
    <section class="sub-pd-info">
            <div class="flex-wrap">
                <div class="pd-img-wrap">
                    <figure>
                        <img src="<?=$imgSrc?>" alt="<?=$data['title']?>" class="view-pd">
                    </figure>
                </div>

                <div class="pd-info-sm-tb">
                    <p class="ct"><?=$data['category_name']?></p>
                    <h2><?=$data['title']?></h2>
                    <ul class="sm-tb-list">
                        <li>
                            <h3>제품군</h3>
                            <p><?=$data['extra1']?></p>
                        </li>

                        <li>
                            <h3>모델명</h3>
                            <p><?=$data['extra2']?></p>
                        </li>

                        <li>
                            <h3>전체용량</h3>
                            <p><?=$data['extra3']?></p>
                        </li>

                        <li>
                            <h3>재질</h3>
                            <p><?=$data['extra4']?></p>
                        </li>

                        <li>
                            <h3>사이즈</h3>
                            <p><?=$data['extra5']?></p>
                        </li>
                        <li>
                            <h3>단열방식</h3>
                            <p><?=$data['extra6']?></p>
                        </li>
                        <li>
                            <h3>제어방식</h3>
                            <p><?=$data['extra7']?></p>
                        </li>
						<li>
                            <h3>권장온도범위</h3>
                            <p><?=$data['extra8']?></p>
                        </li>
						<li>
                            <h3>중량</h3>
                            <p><?=$data['extra9']?></p>
                        </li>
						<li>
                            <h3>냉장/냉동</h3>
                            <p><?=$data['extra10']?></p>
                        </li>
                    </ul>

                    <ul class="link-wrap">
                        <li>
                            <a href="tel:<?=$SITEINFO_FOOTER_HP?>">
                                전화문의 <p><?=$SITEINFO_FOOTER_HP?></p>
                            </a>
                        </li>

                        <li>
                             <a href="javascript:window.history.back();"">
                                목록
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

			<div class="particular">
				<div class="no-view-bot">
					<div class="no-view-bot__contents"><?=htmlspecialchars_decode($data['contents'])?></div>
				</div>
			</div>
    </section>
</main>

