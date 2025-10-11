<?php
$MENU						  = new Menu();
$APP_NAME         = $MENU->getSiteName();
$PAGE_TITLE				= $MENU->getPageTitle();
$MENU_ITEMS				= $MENU->getMenuItems();
$CUR_PAGE				  = $MENU->getCurPage();
$CUR_PAGE_LIST		= $MENU->getCurPageList();
$CUR_PAGE_INDEX		= $MENU->getCurPageIndex();
?>

<!DOCTYPE html>
<html lang="<?= $LOCALE ?>">

<head>

	<?php
	include_once $STATIC_ROOT . '/inc/inc.titleMeta.php';
	include_once $STATIC_ROOT . '/inc/inc.css.php';
	include_once $STATIC_ROOT . '/inc/inc.script.php';
	?>

	<?php

	$aos_title = 'data-aos="fade-up" data-aos-once="true" data-aos-duration="1000"';
	$aos_slow = 'data-aos="fade-up"  data-aos-once="true"  data-aos-duration="800"';
	$aos_slow_delay = 'data-aos="fade-up"  data-aos-once="true"  data-aos-duration="1500" data-aos-delay="300"';
	$aos_slow_repeat = 'data-aos="fade-up" data-aos-duration="1500"';

	$aos_middle_up = 'data-aos="fade-down"  data-aos-once="true"  data-aos-duration="1500"';
	$aos_slow_up = 'data-aos="fade-down"  data-aos-once="true"  data-aos-duration="1500" data-aos-delay="400"';

	$aos_sslow = 'data-aos="fade-up"  data-aos-once="true"  data-aos-duration="1800"';
	$aos_ssslow = 'data-aos="fade-up"  data-aos-once="true"  data-aos-duration="2000"';
	$aos_sssslow = 'data-aos="fade-up"  data-aos-once="true"  data-aos-duration="2200"';
	$aos_ssssslow = 'data-aos="fade-up"  data-aos-once="true"  data-aos-duration="2400"';

	$aos_middle = 'data-aos="fade-up" data-aos-duration="1000"  data-aos-once="true"';
	$aos_fast = 'data-aos="fade-up" data-aos-duration="500"';
	$aos_right_slow = 'data-aos="fade-right"   data-aos-once="true" data-aos-duration="1500"';
	$aos_left_slow = 'data-aos="fade-left"  data-aos-once="true"  data-aos-duration="1500"';
	$aos_left_sslow = 'data-aos="fade-left"  data-aos-once="true"  data-aos-duration="1700"';
	$aos_left_ssslow = 'data-aos="fade-left"  data-aos-once="true"  data-aos-duration="1900"';
	$aos_left_sssslow = 'data-aos="fade-left"  data-aos-once="true"  data-aos-duration="2100"';
	$aos_right_slow_slide = 'data-aos="fade-right" data-aos-duration="1500"';
	$aos_left = 'data-aos="fade-left" data-aos-once="true" data-aos-duration="1000"';
	$aos_left_slow = 'data-aos="fade-left" data-aos-once="true" data-aos-duration="1500"';
	$aos_sub_visual_img = 'data-aos="fade-up" data-aos-duration="1000"';
	$aos_sub_visual_txt = ' data-aos-delay="400" data-aos="fade-up" data-aos-duration="1000"';
	$aos_fade = ' data-aos="fade-zoom-in"  data-aos-once="true" data-aos-easing="ease-in" data-aos-delay="200" data-aos-duration="1000"';
	$aos_fade_slow = ' data-aos="fade-zoom-in"  data-aos-once="true" data-aos-easing="ease" data-aos-duration="2000" ';

	?>