<?php 
	$imgSrc = $UPLOAD_WDIR_BOARD . '/' . $data['thumb_image'];
?>

<main>
    <section class="no-cetner-visual">
        <div class="no-container-pc">
            <div class="visual-wrap">
                <?php include_once $STATIC_ROOT . '/inc/shared/pc-info.php'; ?>

                <div class="mobile-visual-wrap">
                    <?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
                    <?php include_once $STATIC_ROOT . '/inc/shared/sub.nav-board.php'; ?>

                    <div class="no-cancer no-neuro no-rehab no-doctor">
                        <section class="no-doctor-view-visual">
                            <hgroup class="fade-up">
                                <h2 class="no-heading-sl blue"><?=$data['title']?></h2>
                                <p class="no-body-xl fw600"><?=$data['category_name']?> <?=$data['extra1']?></p>
                                <span class="no-body-xs fw300"><?=$data['extra2']?></span>
                            </hgroup>

                            <figure>
                                <img src="/uploads/board/<?=$data['file_attach_1']?>">
                            </figure>
                        </section>

                        <section class="no-doctor-view-keyword no-pd-48--y">
                            <div class="no-container-sm">
                                <h2 class="no-heading-sm fade-up fw600">내가 보는 <?=$data['title']?> 원장님은<br>
                                    <b class="blue">어떤 분일까?</b>
                                </h2>

                                <ul class="keyword-list no-mg-24--t list-js">
                                    <?php
									$tags = explode(' ', trim($data['extra3']));
									foreach ($tags as $tag) :
										if ($tag === '') continue;
									?>
										<li class="no-body-md">
											<?= htmlspecialchars($tag) ?>
										</li>
									<?php endforeach; ?>
                                </ul>
                            </div>
                        </section>

                        <section class="no-doctor-view-profile no-pd-48--y">
                            <div class="no-container-sm">
                                <ul class="profile-list">
                                    <li class="fade-up">
                                        <h3 class="no-heading-sm fw600">경력</h3>
                                        <ul class="dept2 no-mg-16--t">
                                            <?=$data['extra12']?>
                                        </ul>
                                    </li>

                                    <li class="fade-up">
                                        <h3 class="no-heading-sm fw600">활동</h3>
                                        <ul class="dept2 no-mg-16--t">
                                            <?=$data['extra13']?>
                                        </ul>
                                    </li>

                                    <li class="fade-up">
                                        <h3 class="no-heading-sm fw600">학력</h3>
                                        <ul class="dept2 no-mg-16--t">
                                            <?=$data['extra14']?>
                                        </ul>
                                    </li>

                                    <li class="fade-up">
                                        <h3 class="no-heading-sm fw600">저서 및 논문</h3>
                                        <ul class="dept2 no-mg-16--t">
                                            <?=$data['extra15']?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </section>

                        <?php include_once $STATIC_ROOT . '/inc/layouts/integrate-link.php'; ?>
                    </div>

                    <?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>

                    <?php include_once $STATIC_ROOT . '/inc/layouts/floating-bottom.php'; ?>
                </div>
            </div>
        </div>
    </section>
</main>