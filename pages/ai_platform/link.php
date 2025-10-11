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
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">실시간 피드백과 간편한 파일 공유를 이메일과 카카오톡으로 연동하여 빠른 협업
</h2>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">피드백과 수정 요청을 체계적으로 관리해 업무 효율성 극대화
</h2>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">다운로드 없이 영상을 바로 스트리밍으로 확인하며 피드백을 남기고, 특정 프레임에 마크업을 추가해 작업을 명확하고 편리하게 관리하세요
</h2>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">영상제작의 기획부터 후반작업까지 과정을 체계적으로 관리하고, 마일스톤과 종속성 매핑으로 누락 없이 효율적인 워크플로를 구성하세요
</h2>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">영상과 문서를 포함한 모든 파일을 한곳에서 체계적으로 관리하고, 동영상, 이미지, 오디오를 간편하게 링크로 전송하세요
</h2>
 <h2 style=" position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    border: 0;
    clip: rect(0,0,0,0);">내부 직원뿐만 아니라 파트너사와도 유기적으로 연결되어 효과적인 협업을 이끌어내세요. 실시간으로 프로젝트 제안을 받고 새로운 일거리에 참여할 수 있습니다.
</h2>


    <section class="hub-headline">
        <figure class="back-bg" style="background-image: url('/resource/images/hub-bg.jpg');">
        </figure>
        <div class="container-xl">
            <hgroup class="reveal">
                <span class="letter">
                    <h2>누가 만드느냐에 따라, 콘텐츠는 달라집니다</h2>
                    <p>AI 아티스트를 선별하고 큐레이션 기반으로 연결하는 제작 플랫폼, &nbsp;
                        <span class="brand-gd">Palette Link</span>
                    </p>
                </span>
            </hgroup>
            <img src="/resource/images/hub-mockup.png" <?= $aos_slow_delay ?>>
        </div>
    </section>

    <section class="hub-effect">
        <div class="container-xl">
            <h2 class="sub-h2" <?= $aos_slow ?>>기대효과</h2>

            <article class="no-article">
                <ul class="effect-list">
                    <li>
                        <div class="txt">
                            <h3>Curation<br> <span class="f-heading-4">검증된 아티스트 매칭</span></h3>
                            <p>글로벌 수상·실무 경험을 갖춘 AI 아티스트 선별<br> 브랜드 스타일 기반 큐레이션 추천 제공</p>
                        </div>
                        <img src="/resource/images/hub-effect1.svg">
                    </li>

                    <li>
                        <div class="txt">
                            <h3>Safety<br> <span>콘텐츠에만 집중하는 제작 환경</span></h3>
                            <p>에스크로 결제와 PM 중재를 통한 안정적 운영<br> 투명하고 혼선 없는 제작 프로세스 구축</p>
                        </div>
                        <img src="/resource/images/hub-effect2.svg">
                    </li>

                    <li>
                        <div class="txt">
                            <h3>Quality<br> <span>브랜드 맞춤 콘텐츠 자산화<span></h3>
                            <p>검수 완료된 결과물 아카이빙 및 누적<br> 재활용 가능한 브랜드 콘텐츠 자산화 지원</p>
                        </div>
                        <img src="/resource/images/hub-effect3.svg">
                    </li>
                </ul>
            </article>
        </div>
    </section>

    <section class="hub-function">
        <div class="container-xl">
            <h2 class="sub-h2" <?= $aos_slow ?>>주요 기능</h2>

            <article class="no-article">
                <ul class="function-list">
                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/hub-function1.svg">
                        </figure>

                        <div class="txt">
                            <h3>AI 아티스트 탐색 및 연결 </h3>
                            <p>사용자는 원하는 스타일과 작업 방향에 맞는 아티스트를<br> 포트폴리오 기반으로 직접 탐색하고, 연결할 수 있는 구조를 제공합니다.<br> 수동적인 매칭이 아닌, 능동적인 연결 경험이 가능합니다.
                            </p>
                        </div>

                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/hub-function2.svg">
                        </figure>

                        <div class="txt">
                            <h3>간결한 견적 요청 프로세스 </h3>
                            <p>복잡한 절차 없이 간단한 양식만으로 프로젝트 제안과 협업 요청이 가능합니다.<br> 불필요한 커뮤니케이션 단계를 줄여, 더 빠르고 명확한 시작을 돕습니다.
                            </p>
                        </div>
                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/hub-function3.svg">
                        </figure>

                        <div class="txt">
                            <h3>포트폴리오 등록 및 개인 페이지 제공</h3>
                            <p>AI 아티스트는 작업물을 등록하여<br> 개별 포트폴리오 페이지를 구성할 수 있으며,<br> 링크 공유가 가능한 전용 도메인 주소를 통해 외부 활용도 가능합니다.
                            </p>
                        </div>
                    </li>

                    <li <?= $aos_slow ?>>
                        <figure>
                            <img src="/resource/images/hub-function4.svg">
                        </figure>

                        <div class="txt">
                            <h3>견적 요청 현황 확인 및 관리 </h3>
                            <p>보낸 견적 요청의 진행 상태를 플랫폼 내에서 직접 확인할 수 있습니다.<br> 협업 진행 상황을 더 투명하고 안정적으로 관리할 수 있습니다.
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