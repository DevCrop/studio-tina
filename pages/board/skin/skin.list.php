<?php
	if ($board_no == 9 || $board_no == 13) {
?>

<main>
    <section class="sub-news">
        <div class="container-xl">
            <h2 class="sub-h2 poppins">News</h2>

            <article class="no-article">
                <ul class="news-list" <?= $aos_slow_delay ?>>
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
                            <h3><?= $title ?></h3>
                            <span><?= date("Y.m.d", strtotime($v['regdate'])) ?></span>

                            <img src="<?= $imgSrc ?>">
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