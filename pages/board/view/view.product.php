<?php
$bannerImg = !empty($data['thumb_image'])
    ? $UPLOAD_WDIR_BOARD . '/' . $data['thumb_image']
    : $ROOT . '/resource/images/sub/view_banner.jpg';

$bannerAlt = htmlspecialchars($data['title'] ?? '배너 이미지', ENT_QUOTES, 'UTF-8');


$attachments = [];
for ($i = 1; $i <= 5; $i++) {
    if (!empty($data["file_attach_$i"])) {
        $attachments[] = $UPLOAD_WDIR_BOARD . '/' . $data["file_attach_$i"];
    }
}

$specGroups = [
  '전기'        => [1, 2],     // extra1, extra2
  '전력'        => [3, 4],     // extra3, extra4
  '크기'        => [5, 6],     // extra5, extra6
  '보일러 용량'  => [7, 8],     // extra7, extra8
  '커피 보일러'  => [9, 10],    // extra9, extra10
  '중량'        => [11, 12],   // extra11, extra12
];

function parseLabelValue(?string $str): ?array {
  if (!$str) return null;
  $parts = preg_split('/\s*[:：]\s*/u', $str, 2);
  if (!$parts || count($parts) < 2) {
    return ['label' => '', 'value' => trim($str)];
  }
  return ['label' => trim($parts[0]), 'value' => trim($parts[1])];
}

$specData = []; // ['섹션명' => [['label'=>'2GR','value'=>'220~240V 60Hz'], ...], ...]
foreach ($specGroups as $section => $indices) {
  $items = [];
  foreach ($indices as $idx) {
    $raw = $data["extra{$idx}"] ?? '';
    $parsed = parseLabelValue($raw);
    if ($parsed && ($parsed['label'] !== '' || $parsed['value'] !== '')) {
      $items[] = $parsed;
    }
  }
  if (!empty($items)) {
    $specData[$section] = $items;
  }
}



?>
<div class="no-sub no-sub-view ">
    <section class="no-sub-product-view no-section-md">
        <div class="no-container-xl">
            <h2 class="f-heading-2" <?=$aos['middle']?>>
                <?=$data['manage_title']?> <?=$data['title']?>
            </h2>
            <div class="product-view-banner" <?=$aos['fast']?>>
                <figure>
                    <img src="<?= $bannerImg ?>" alt="<?= $bannerAlt ?>">
                </figure>
            </div>
        </div>
        <div class="product-view-youtube no-section-md">
            <div class="no-container-xl">
                <div class="desc --tac" <?=$aos['fast']?>>
                    <?=htmlspecialchars_decode($data['post_description'])?>
                </div>
                <figure <?=$aos['middle']?>>
                    <iframe src="<?=$data['direct_url']?>" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </figure>
            </div>
        </div>
        <div class="--mg-t--lg">
            <div class="no-container-xl">
                <div class="--cnt">
                    <div class="left" <?=$aos['fast']?>>
                        <div class="no-sub-product-view-swiper swiper">
                            <ul class="swiper-wrapper">
                                <?php foreach ($attachments as $imgSrc): ?>
                                <li class="swiper-slide">
                                    <figure>
                                        <img src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8') ?>" alt="제품 이미지">
                                    </figure>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="no-sub-product-thumb-swiper swiper">
                            <ul class="swiper-wrapper">
                                <?php foreach ($attachments as $imgSrc): ?>
                                <li class="swiper-slide">
                                    <figure>
                                        <img src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8') ?>" alt="제품 썸네일">
                                    </figure>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="right" <?=$aos['middle']?>>
                        <h3 class="f-heading-3 --bold"><?=$data['manage_title']?> <span
                                class="clr-primary-def"><?=$data['title']?></span></h3>
                        <div class="info-wrap">

                            <div class="info-block">
                                <h5 class="f-heading-5 --semibold">Specifications</h5>
                                <ul class="no-sub-view-spec-list info-feature">
                                    <?php foreach ($specData as $sectionTitle => $items): ?>
                                    <li>
                                        <h4 class="f-body-1 --bold">
                                            <?= htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8') ?></h4>
                                        <ul class="no-sub-view-spec-item">
                                            <?php foreach ($items as $it): ?>
                                            <li>
                                                <span><?= htmlspecialchars($it['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                                <p><?= htmlspecialchars($it['value'], ENT_QUOTES, 'UTF-8') ?></p>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="info-block">
                                <h5 class="f-heading-5 --semibold">Features</h5>
                                <div class="info-feature">
                                    <?=htmlspecialchars_decode($data['feature_description'])?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

</div>