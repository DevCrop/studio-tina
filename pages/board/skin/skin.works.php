<style>

    .swiper-slide input[type="checkbox"] {
        display: none; /* 기본 체크박스 숨기기 */
    }
	.no-category-nav__btn {
        display: none; /* 기본 체크박스 숨기기 */
    }
    .swiper-slide input[type="checkbox"]:checked + span {
        color: #000;
		background-color: #fff;
    }
	.no-more-button {
	display: flex;
	align-item: center;
	justify-content: center;
	margin-top: 8rem;

	button{
	h3{color: #fff; font-size: 1.8rem; border-radius: 5.5rem; padding: 1rem 2rem; border: 1px solid #fff; transition: all .3s}
		}

	button:hover{
	h3{background: #fff; color: #000;}
	}
</style>

<?php
	if ($board_no == 10 || $board_no == 14) {
?>

 <section class="sub-works">
 		<hgroup <?=$aos_slow?>>
			<h2>How We Craft<br class="m-br"> Art with AI</h2>
			<p><?= ($HTML_LANG == 'en') ? 'Fusing core brand messages with AI technology to create visual creativity on another level.' : '브랜드의 핵심 메시지를 AI 기술과 결합하여, 차원이 다른 비주얼 크리에이티브로 완성합니다.' ?>
			</p>
		</hgroup>

	<div class="works-slider" <?=$aos_slow?>>
		<ul class="swiper-wrapper videolist">
				<?php
					foreach ($arrResultSet as $k => $v) {
					$title = iconv_substr($v['title'], 0, 2000, "utf-8");
					$contents = strip_tags(html_entity_decode($v['contents'], ENT_QUOTES, 'UTF-8'));
					$contents = iconv_substr($contents, 0, 500, "utf-8");
					$link = "./board.view.php?board_no=$board_no&no={$v['no']}&searchKeyword=" . base64_encode($searchKeyword) . "&searchColumn=" . base64_encode($searchColumn) . "&page=$page&category_no=$category_no";
					$youtubeId = "";

					// 유튜브 URL에서 ID 추출
					if (!empty($v['direct_url']) && preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/|live\/))([\w-]+)/', $v['direct_url'], $matches)) {
						$youtubeId = $matches[1];
					}

					$imgSrc = "";
					if ($v['thumb_image']) {
						$imgSrc = $UPLOAD_WDIR_BOARD . "/" . $v['thumb_image'];
					}

					$target = '_self';
					$link = $link;
				?>
					<li class="swiper-slide">
						<a href="javascript:void(0);" data-youtube-id="<?= $youtubeId ?>">
							<figure style="background-image: url('<?= $imgSrc ?>');">
								<span class="category poppins"><?= htmlspecialchars($v['category_name'] ?? '') ?></span>
							</figure>
							<div class="txt">
								<h3 class="poppins"><?= htmlspecialchars($title) ?></h3>
							</div>
						</a>
					</li>
			<?php } ?>
		</ul>
		<div class="swiper-button-prev arrow"><i class="fa-light fa-arrow-right fa-rotate-180" style="color: #ffffff;"></i></div>
		<div class="swiper-button-next arrow"><i class="fa-light fa-arrow-right" style="color: #ffffff;"></i></div>
		<div class="swiper-pagination"></div>
	</div>
</section>

<section class="works-wrap" <?= $aos_slow ?>>
	<div class="container-bl" style="padding-top: 0">
		<section class="no-category-section ">
			<div class="no-category ">
				<div class="no-category__box">
					<div class="no-category__swiper no-sector-category no-filter__low category-wrap" id="filter-sector">
						<ul class="swiper-wrapper no-category__wrap no-filter__low--wrap" id="catg-hook">
						</ul>
						<div class="no-category-nav__btn">
							<div class="swiper-button-next category-btn category-next sector-next"></div>
							<div class="swiper-button-prev category-btn category-prev sector-prev"></div>
						</div>
					</div>
				</div>
		</section>

		<article class="no-article">
			<ul id="work-hook " class="work-list videolist">
				
			</ul>
				
			<div id="no-item-hook"></div>
			<div class="no-items-message">
				NO ITEM
			</div>

				<div class="no-more-button pt80">
				<button type="button">
					<h3>View More</h3>
				</button>
			</div>
		</article>
	</div>
</section>

<?php
	}
?>

<?php
	if ($board_no == 15 || $board_no == 16) {
?>

<section class="works-wrap works-image" <?= $aos_slow ?>>
	<div class="container-xl">
		<section class="no-category-section ">
			<div class="no-category ">
				<div class="no-category__box">
					<div class="no-category__swiper no-sector-category no-filter__low category-wrap" id="filter-sector">
						<ul class="swiper-wrapper no-category__wrap no-filter__low--wrap" id="catg-hook">
						</ul>
						<div class="no-category-nav__btn">
							<div class="swiper-button-next category-btn category-next sector-next"></div>
							<div class="swiper-button-prev category-btn category-prev sector-prev"></div>
						</div>
					</div>
				</div>
		</section>

		<article class="no-article">
			<ul id="work-hook" class="work-list imagelist">
				
			</ul>
				
			<div id="no-item-hook"></div>
			<div class="no-items-message">
				NO ITEM
			</div>

				<div class="no-more-button pt80">
				<button type="button">
					<h3>View More</h3>
				</button>
			</div>
		</article>
	</div>
</section>


<?php
	}
?>

