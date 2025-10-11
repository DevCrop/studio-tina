<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php'; ?>

<!-- dev -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<script src="<?= $ROOT ?>/resource/js/sub-hub.js" <?= date('YmdHis') ?> defer></script>
<!-- css, js  -->

<?php
include_once $STATIC_ROOT . '/inc/layouts/header.php';
?>

<!-- contents -->

<main class="sub-hub">
	<h1 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">영상제작 중심 워크플로 관리, 팀 협업 최적화, 클라이언트와의 연결 강화, 실시간 스트리밍 피드백, 맞춤형 작업 프로세스, 간편한 파일 공유, 협력사 초대
</h1>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">기획부터 후반작업까지의 모든 단계를 효율적으로 관리
</h2>

    <section class="hub-headline hub-headline-new ">
        <figure class="back-bg" style="background-image: url('/resource/images/new-ai-bg.jpg');">
        </figure>
        <div class="container-xl">
            <hgroup class="reveal">
                <span class="letter">
                    <h2>How We Color Tech<br class="m-br"> with AI</h2>
                    <p>긴 영상 제작 과정은 이제 잊으세요! AI가 빠르고 간편하게<br> 당신의 아이디어를 고퀄리티 영상으로 완성합니다.
                    </p>
                </span>
            </hgroup>

			<img src="/resource/images/new-ai-center.png" class="visual-img" <?= $aos_slow_delay ?>>
        </div>
    </section>

    <section class="hub-effect">
        <div class="container-xl">
            <h2 class="sub-h2" <?= $aos_slow ?>>기대효과</h2>

            <article class="no-article">
                <ul class="effect-list">
                    <li>
                        <div class="txt">
                            <h3>영상 제작 AI가 다 알아서</h3>
                            <p>주제만 입력하면 AI가 스토리보드부터 완성된 영상까지 <br>
							빠르고 간편하게 제작해 드립니다.</p>
                        </div>
                        <img src="/resource/images/ai-effect1.svg">
                    </li>

                    <li>
                        <div class="txt">
                            <h3>AI로 간편하게 비용은 합리적으로</h3>
                            <p>템플릿과 AI 자동화로 제작 비용을 최소화하며, <br>
							전문가 없이도 고퀄리티 영상을 완성할 수 있습니다.</p>
                        </div>
                        <img src="/resource/images/ai-effect2.svg">
                    </li>

                    <li>
                        <div class="txt">
                            <h3>다국어 지원으로 전 세계로 확장 </h3>
                            <p>다양한 스타일과 언어를 지원해 글로벌 시장에 적합한<br>
							맞춤형 콘텐츠를 손쉽게 제작할 수 있습니다.</p>
                        </div>
                        <img src="/resource/images/ai-effect3.svg">
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <section class="hub-function">
        <div class="container-bl">
            <h2 class="sub-h2" <?= $aos_slow ?>>주요 기능</h2>

            <article class="no-article">
                <ul class="function-list function-list-new">
                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_1.png">
                        </figure>
                        <div class="txt">
							<div>
								  <span class="fjalla">One-Click Video Creation</span>
								<h3>원클릭 비디오 제작</h3>
							</div>
                            <p>0에서 시작하는 영상 만들기, 간단한 주제 또는 이미지를 입력하면 AI가 스토리보드 제작, 영상 제작까지 한 번에 완료해 줍니다.
                            </p>
                        </div>

                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_2.png">
                        </figure>

                        <div class="txt">
							<div>
								 <span class="fjalla">News Article Video Generation</span>
								<h3>뉴스 기사 비디오 제작 </h3>
							</div>
                            <p>뉴스 기사 링크만 첨부하면 AI가 기사를 요약하고<br> 짧고 임팩트 있는 비디오를 자동으로 제작합니다.
                            </p>
                        </div>
                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_3.png">
                        </figure>

                        <div class="txt">
							<div>
								<span class="fjalla">Template-Based Video Creation</span>
								<h3>템플릿 기반 제작 <br>
								Magic Create
								</h3>
							</div>
                            <p>제공된 템플릿을 활용해 누구나 손쉽게 원하는 영상을 제작할 수 있습니다.
부동산, 마케팅, 이벤트 홍보 등 다양한 산업과 목적에 최적화된 템플릿으로 시간을 절약하세요.</p>
                        </div>
                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/new/ai_new_img_4.png">
                        </figure>

                        <div class="txt">
							<div>
							<span class="fjalla">Detailed Customization</span>
								<h3>디테일한 커스터마이징</h3>
							</div>
                            <p>장면 추가부터 자막 수정, 영상 스타일, 배경음악까지 자유롭게 편집하며 원하는 방향으로 영상을 완성할 수 있습니다.
                            </p>
                        </div>
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <?php include_once $STATIC_ROOT . '/inc/layouts/gocontact.php'; ?>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>