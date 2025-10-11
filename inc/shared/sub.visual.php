<?php
$visual_title = $CUR_PAGE['title'];
$visualImageNum = '';

switch ($visual_title) {
  case "인사말":
    $visualImageNum = 'gt.jpg';
    break;
  case "강사소개":
    $visualImageNum = 'gt.jpg';
    break;
  case "오시는 길":
    $visualImageNum = 'gt.jpg';
    break;
  case "전체수업과정":
    $visualImageNum = 'all.jpg';
    break;
  case "기초 과정":
    $visualImageNum = 'prt.jpg';
    break;
  case "경매실전 과정":
    $visualImageNum = 'spc.jpg';
    break;
  case "NPL·GPL 수익실현 과정":
    $visualImageNum = 'dep.jpg';
    break;
  case "평생반 과정":
    $visualImageNum = 'fie.jpg';
    break;
}
?>

<section class="no-sub-visual">
  <figure class="no-sub-visual-bg" style="background-image: url('/resource/images/<?= $visualImageNum ?>?v=<?= date('YmdHis') ?>')"></figure>
</section>