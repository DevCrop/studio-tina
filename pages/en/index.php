<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/lib/counter.inc.php';?>
<script src="<?= $ROOT ?>/resource/js/main.js" <?= date('YmdHis') ?> defer></script>
<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<?php include_once $STATIC_ROOT . '/inc/lib/popup.php'; ?>

<main>

<h1 style="position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0); color: #fff;">
Palette AI, Palette Hub, Video Production, Digital Marketing
</h1>
<h2 style="position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">
AI Video, AI Platform, Video Production, Video Platform, Professional Services, Planning, Filming, Editing, Feedback, Social Media Marketing, Content Marketing, Branding
</h2>

	<section class="no-visual">
		<video autoplay loop muted preload="auto" playsinline>
			<source src="/resource/video/main_video.mp4" type="video/mp4">
		</video>
		<div class="container-xl">
			<hgroup class="no-visual__title">
				<h2 class="fjalla visual-title">Artful Craft, Colorful Tech</h2>
				<div class="btn-wrap">
					<a href="/pages/board/board.list.php?board_no=14" class="btn-base">
						<p class="poppins">Go To AI Creative</p>
						<i>
							<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
							<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
						</i>
					</a>
				</div>
			</hgroup>
		</div>

		<div class="scroll-line">
			<p>Scroll</p>
			<div class="line"></div>
		</div>
	</section>

	<!-- <section class="no-about">
		<div class="container-xl">
			<div class="txt">
				<h2 class="poppins">Who We Are</h2>
				<h3>We provide a comprehensive suite of services from commercial advertising and<br> branded content to AI-powered production platforms.</h3>
				<h3>Our open ecosystem bridges creators and clients through seamless collaboration.</h3>
				<h3>
				  As <span class="brand-gd">solutionists</span>, we pursue harmony across creativity, visual design, technology, and marketing.
				</h3>
	
				<a href="/en/pages/company/about.php" class="btn-solid-sm">
					<p class="poppins">View More</p>
					<i>
						<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
						<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
					</i>
				</a>
			</div>
	
			<div class="img-wrap">
				<img src="/resource/images/si1.jpg" class="si1 si">
				<img src="/resource/images/si2.jpg" class="si2 si">
				<img src="/resource/images/si3.jpg" class="si3 si">
				<img src="/resource/images/si4.jpg" class="si4 si">
				<img src="/resource/images/si5.jpg" class="si5 si">
			</div>
		</div>
	</section> -->

	<!--<section class="no-works">
		<div class="container-xl">
			<h2 class="main-h2">Our Works</h2>

				<!-- works-movie 

			<?php
				$board_info = getBoardInfoByName("works-movie[영문]");
				$board_no = $board_info[0]['no'];
				$arrLenders = getBoardLimit($board_no, 100, "");
				$board_category = getBoardCategory($board_no);
			?>

			<article class="no-article works-movie-wrap">
				<div class="category-wrap">
					<ul class="swiper-wrapper">
						<?php foreach ($board_category as $category): ?>
							<li class="swiper-slide">
								<button
									  type="button"
									  class="no-btn category-btn"
									  data-board="works-movie"
									  data-content="<?= htmlspecialchars($category['name']) ?>"
									  data-category="<?= htmlspecialchars($category['no']) ?>"
									>
									<span><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></span>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				
				<div class="work-wrap">
					<?php foreach ($board_category as $category): ?>
						<div class="category-content"
						  data-board="works-movie"
						  data-category="<?= htmlspecialchars($category['no']) ?>">
						   <ul class="videolist">
							<?php
								// 해당 카테고리의 게시글들만 필터링
								$categoryPosts = array_filter($arrLenders, function($v) use ($category) {
									return $v['category_no'] == $category['no'];
								});
								
								// 각 카테고리에서 최대 6개 게시글만 표시
								$categoryPosts = array_slice($categoryPosts, 0, 6); // 최대 6개까지만 가져오기

								// 필터링된 게시글 출력
								foreach ($categoryPosts as $v):
									$title = iconv_substr($v['title'], 0, 150, "utf-8");
									$link = "/pages/board/board.view.php?board_no=$board_no&no=" . (isset($v['no']) ? htmlspecialchars($v['no'], ENT_QUOTES, 'UTF-8') : '') . "&searchKeyword=" . base64_encode($searchKeyword) . "&searchColumn=" . base64_encode($searchColumn) . "&page=$page";
									
									// 이미지 처리
									$imgSrc = "";
									if ($v['thumb_image']) {
										$imgSrc = $UPLOAD_WDIR_BOARD . "/" . $v['thumb_image'];
									}

									// 유튜브 ID 추출
									$youtubeId = null;
									if (!empty($v['direct_url'])) {
										preg_match('/v=([a-zA-Z0-9_-]+)/', $v['direct_url'], $matches);
										if (!empty($matches[1])) {
											$youtubeId = $matches[1];
										}
									}
									?>
									<li class="work">
										<a href="javascript:void(0);" data-youtube-id="<?= $youtubeId ?>">
											<figure style="background-image: url('<?= $imgSrc ?>');"></figure>
											<span class="category poppins"><?= htmlspecialchars($v['category_name'] ?? '') ?></span>
											<div class="txt">
												<h3 class="poppins"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h3>
											</div>
										</a>
									</li>
							<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="btn-wrap">
					<a href="/pages/board/board.list.php?board_no=10" class="btn-solid-sm">
						<p class="poppins">View More</p>
						<i>
							<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
							<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
						</i>
					</a>
				</div>
			</article>

				<!-- works-image 

				<?php
					$board_info = getBoardInfoByName("works-image[영문]");
					$board_no = $board_info[0]['no'];
					$arrLenders = getBoardLimit($board_no, 100, "");
					$board_category = getBoardCategory($board_no);
				?>

				<article class="works-image-wrap no-mg-120--t">
					<div class="category-wrap">
						<ul class="swiper-wrapper">
							<?php foreach ($board_category as $category): ?>
								<li class="swiper-slide">
									<button
										  type="button"
										  class="no-btn category-btn"
										  data-board="works-image"
										  data-content="<?= htmlspecialchars($category['name']) ?>"
										  data-category="<?= htmlspecialchars($category['no']) ?>"
										>
										<span><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></span>
									</button>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>

				<div class="works-image no-mg-64--t">
				  <?php foreach ($board_category as $category): ?>
					<div class="category-content"
					  data-board="works-image"
					  data-category="<?= htmlspecialchars($category['no']) ?>">
					  <ul class="imagelist main">
						<?php
						  $categoryPosts = array_filter($arrLenders, function($v) use ($category) {
							  return $v['category_no'] == $category['no'];
						  });

						  $categoryPosts = array_slice($categoryPosts, 0, 3);

						  foreach ($categoryPosts as $v):
							  $no = $v['no'];
							  $title = iconv_substr($v['title'], 0, 150, "utf-8");
							  $imgSrc = $v['thumb_image'] 
								? (strpos($v['thumb_image'], '/') === 0 ? $v['thumb_image'] : $UPLOAD_WDIR_BOARD . '/' . $v['thumb_image']) 
								: '';
							  $galleryId = 'gallery_' . $no;
						?>
							<li data-no="<?= $no ?>" data-regdate="<?= $v['regdate'] ?>">
							  <a data-fslightbox="<?= $galleryId ?>" href="<?= $imgSrc ?>">
								<figure>
								  <span class="category poppins"><?= htmlspecialchars($v['category_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
								  <img src="<?= $imgSrc ?>" loading="lazy">
								  <div class="txt">
									<h3 class="poppins --tac"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h3>
								  </div>
								</figure>
							  </a>

							  <?php
								for ($i = 1; $i <= 5; $i++) {
								  $fileKey = 'file_attach_' . $i;
								  if (!empty($v[$fileKey])) {
									  $subPath = strpos($v[$fileKey], '/') === 0 ? $v[$fileKey] : $UPLOAD_WDIR_BOARD . '/' . $v[$fileKey];
									  echo '<a data-fslightbox="' . $galleryId . '" href="' . $subPath . '" style="display: none"></a>';
								  }
								}
							  ?>
							</li>
						<?php endforeach; ?>
					  </ul>
					</div>
				  <?php endforeach; ?>
				</div>

				<div class="btn-wrap">
					<a href="/pages/board/board.list.php?board_no=16" class="btn-solid-sm">
						<p class="poppins">View More</p>
						<i>
							<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
							<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
						</i>
					</a>
				</div>
			</article>
		</div>
	</section>-->

	<!--<section class="no-service">
		<div class="container-xl">
			<h2 class="main-h2">Our Service</h2>

			<article class="no-article">
				<ul class="service-list">
					<li>
						<figure class="move-img">
							<img src="/resource/images/main-service1.jpg">
						</figure>

						<div class="txt">
							<h3 class="poppins">Palette AI</h3>
							<p>Create videos for your business quickly and easily with Palette AI. Create premium content without the need for complex editing. A professional-level finish, but a surprisingly simple production process. This is the new paradigm of video production brought to you by AI.</p>

							<a href="/en/pages/service/ai.php" class="btn-solid-sm">
								<p class="poppins">View More</p>
								<i>
									<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
									<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
								</i>
							</a>
						</div>
					</li>

					<li>
						<figure class="move-img">
							<img src="/resource/images/main-service2.jpg">
						</figure>
					
						<div class="txt">
							<h3 class="poppins">Palette Link</h3>
							<p>Build your professional portfolio and present your expertise to a global audience. Discover new project opportunities and kickstart meaningful collaborations. Clients seeking high-quality video production can easily browse verified portfolios and connect directly with the right creators for their needs. Collaborate with seasoned professionals across advertising, YouTube editing, corporate promos, and more.
							</p>
					
							<a href="/pages/board/board.list.php?board_no=14" class="btn-solid-sm">
								<p class="poppins">View More</p>
								<i>
									<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
									<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
								</i>
							</a>
						</div>
					</li>

					<li>
						<figure class="move-img">
							<img src="/resource/images/main-service3.jpg">
						</figure>

						<div class="txt">
							<h3 class="poppins">AI Creatives</h3>
							<p>Palette enhances AI technology with a professional human touch, creating well-made creative content that elevates your brand. We provide a comprehensive AI creative solution—from brand diagnosis and strategic planning to concept expansion using AI and the realization of technically sophisticated visuals. Across all creative domains, including brand films, advertisements, and lookbooks, we help your brand prove its unique value.</p>

							<a href="/pages/board/board.list.php?board_no=14" class="btn-solid-sm">
								<p class="poppins">View More</p>
								<i>
									<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
									<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
								</i>
							</a>
						</div>
					</li>

					<li>
						<figure class="move-img">
							<img src="/resource/images/main-service4.jpg">
						</figure>
					
						<div class="txt">
							<h3 class="poppins">Digital Marketing</h3>
							<p>We deliver your message effectively by creating content that stands out on social media. We combine AI and creative marketing know-how to capture the hearts of your followers and increase brand value with the perfect harmony of data and emotion.</p>
					
							<a href="/pages/board/board.list.php?board_no=14" class="btn-solid-sm">
								<p class="poppins">View More</p>
								<i>
									<img src="/resource/images/icon/wh-arrow.svg" alt="arrow" class="wh-arrow">
									<img src="/resource/images/icon/bl-arrow.svg" alt="arrow" class="bl-arrow">
								</i>
							</a>
						</div>
					</li>
				</ul>
			</article>
		</div>
	</section>-->

<!-- 	<section class="no-partner">
		<img src="/resource/images/partner-marquee.svg">
		<img src="/resource/images/partner-marquee.svg">
	</section> -->

	<?php include_once $STATIC_ROOT . '/inc/layouts/gocontact.php'; ?>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>