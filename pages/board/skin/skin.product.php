<?php
    // 라침발리
    if (isset($board_no) && (int)$board_no === 23):
?>
<main class="no-sub">
    <section class="no-sub-product-list no-section-md">
        <div class="no-container-xl">
            <div class="product-banner">
                <figure>
                    <img src="<?=$ROOT?>/resource/images/sub/la_banner.png" alt="">
                </figure>
                <div class="product-banner-txt">
                    <span class="clr-primary-def">LACIMBALI</span>
                    <h3 class="f-heading-4">라심발리, 전통과 혁신의 완벽한 조화</h3>
                    <p class="f-body-3">
                        100년이 넘는 전통을 가진 라심발리는 세계적인 에스프레소 머신 브랜드로, <br>
                        정교한 기술력과 견고한 내구성으로 바리스타와 카페 운영자에게 최고의 선택을 제공합니다. <br>
                        끊임없는 혁신으로 언제나 완벽한 커피 경험을 선사합니다.
                    </p>

                </div>
            </div>
            <div class="--cnt">
                <ul class="product-list">
                    <?php if (!empty($arrResultSet)): ?>
                    <?php foreach ($arrResultSet as $v): ?>
                    <?php
                        // 타이틀
                        $title = isset($v['title']) && !is_array($v['title'])
                            ? iconv_substr($v['title'], 0, 2000, "utf-8")
                            : '';
                        // 링크 (no만 사용)
                        $link = "./board.view.php?board_no=$board_no&no={$v['no']}";
                        
                        // 제품 이미지 = file_attach_1 사용
                        $imgSrc = !empty($v['file_attach_1'])
                            ? $UPLOAD_WDIR_BOARD . '/' . $v['file_attach_1']
                            : '/assets/img/no-image.png';

                        // 카테고리명 (필요 시 활용)
                        $categoryName = $v['category_name'] ?? '';
                    ?>
                    <li class="product-item">
                        <a href="<?= $link ?>" target="_self">
                            <span class="--badge">New</span>
                            <figure>
                                <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>">
                            </figure>
                        </a>
                        <h5 class="f-heading-6 --tac"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h5>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </section>
</main>
<?php endif; ?>