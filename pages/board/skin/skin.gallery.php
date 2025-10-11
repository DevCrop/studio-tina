
<?php
	if ($board_no == 8 || $board_no == 12) {
?>

<main>
    <section class="sub-blog">
        <div class="container-xl">
            <hgroup>
                <h2 class="poppins">Palette Blog</h2>
                <p <?= $aos_slow_delay ?>>
					<?= ($HTML_LANG == 'en') 
						? 'Stay updated on the latest in video through the Palette blog.' 
						: '팔레트 블로그를 통해 영상과 관련된 최신 정보를 파악하세요.' ?>
				</p>
            </hgroup>

            <article class="no-article">
                <ul class="blog-list" <?= $aos_slow_delay ?>>
				<?php

					foreach ($arrResultSet as $k => $v) {
						$title = iconv_substr($v['title'], 0, 2000, "utf-8");
						$contents = strip_tags($v['contents']);
						$contents = iconv_substr($contents, 0, 500, "utf-8");

									// 타이틀의 공백을 '-'로 변환
						// 작은따옴표와 특수문자 제거 (한글, 영문, 숫자, 공백, 일부 기호만 허용)
						$cleanTitle = preg_replace('/[^가-힣a-zA-Z0-9\s\.\-]/u', '', str_replace("'", '', $title));

						// 공백을 '-'로 변환
						$encodedTitle = str_replace(' ', '-', $cleanTitle);

						// 링크에 타이틀을 추가 (urlencode 대신 rawurlencode 사용)
						$link = "./board.view.php?board_no=$board_no&no={$v['no']}&searchKeyword=" . rawurlencode($searchKeyword) . "&searchColumn=" . rawurlencode($searchColumn) . "&page=$page&category_no=$category_no&title=" . rawurlencode($encodedTitle);

						
						$imgSrc = "";
						if ($v['thumb_image']) {
							$imgSrc = $UPLOAD_WDIR_BOARD . "/" . $v['thumb_image'];
						} else {
					
						}

						$target = $v['direct_url'] ? '_blank' : '_self';
						$link = $v['direct_url'] ? $v['direct_url'] : $link;

						$imgData = 'data-pswp-width="1600" data-pswp-height="1024" class="my-image"';
						if ($v['direct_url']) {
							$imgData = '';
						}
					?>
                    <li>
                        <a href="<?= $link ?>">
                            <figure class="video-wrap" style="background-image: url(<?= $imgSrc ?>);">
                            </figure>
                            <div class="txt">
                                <span><?= date("Y.m.d", strtotime($v['regdate'])) ?></span>
                                <h3><?= $title ?></h3>
                            </div>

                            <div class="keyword">
                                <p><?=$v['extra1']?></p>
                                <p><?=$v['extra2']?></p>
                            </div>
                        </a>
                    </li>
					<?php
							$rnumber--;
						}
					?>
                </ul>

				<?php include_once $STATIC_ROOT."/pages/board/components/pagination.php"; ?>
            </article>
        </div>
    </section>
</main>

<?php
	}
?>