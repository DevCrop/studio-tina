<?php section('main_class', 'sub-works') ?>
<?php section('style') ?>
<style>
    main {
        min-height: 50vh;
    }
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
    }
</style>
<?php end_section() ?>
<?php section('content') ?>

<form id="frm" name="frm" method="get" autocomplete='off'>    
<input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>">
<input type="hidden" id="category_no" name="category_no" value="<?= htmlspecialchars($category_no) ?>">
<input type="hidden" id="mode" name="mode" value="">

<section class="works-wrap works-image" <?= AOS_SLOW ?>>
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

</form>
<?php end_section() ?>

<?php section('script') ?>
<script src="/resource/js/sub-works.js?v=<?= date('YmdHis') ?>" defer></script>
<script src="/resource/js/board.js?v=<?= date('YmdHis') ?>" defer></script>
<script src="/resource/js/filter_2.js?v=<?= date('YmdHis') ?>" defer></script>
<?php end_section() ?>
