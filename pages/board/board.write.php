<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

// board_no 유효성 검사
$board_no = $_REQUEST['board_no'] ?? null;

if (!$board_no) {
    error("잘못된 접근입니다", $NO_IS_SUBDIR . "/");
}

// 검색 조건 설정
$searchKeyword = $_REQUEST['searchKeyword'] ?? null;
$searchColumn = $_REQUEST['searchColumn'] ?? null;
$sdate = $_REQUEST['sdate'] ?? null;
$edate = $_REQUEST['edate'] ?? null;
$RtsearchKeyword = $_REQUEST['RtsearchKeyword'] ?? null;
$RtsearchColumn = $_REQUEST['RtsearchColumn'] ?? null;

if ($RtsearchKeyword) {
    $searchKeyword = base64_decode($RtsearchKeyword);
}
if ($RtsearchColumn) {
    $searchColumn = base64_decode($RtsearchColumn);
}

// 게시판 정보 및 권한 설정
$board_info = getBoardInfoByNo($board_no);

$isSecret = ($board_info[0]['secret_yn'] === "Y");
$role_info = getBoardRole($board_no, $NO_USR_LEV);

if ($role_info[0]['role_write'] === "N") {
    alert("접근 권한이 없습니다.");
}

?>

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/shared/sub.visual.php'; ?>

<script type="text/javascript" src="<?= $NO_IS_SUBDIR ?>/pages/board/js/board.js?v=<?= $STATIC_FRONT_JS_MODIFY_DATE ?>">
</script>



<main>

    <section class="no-sub-write no-section-md">
        <div class="no-container-md">
            <div class="">
                <hgroup>
                    <h2 class="f-heading-3 clr-text-title --tac">AS Center</h2>
                </hgroup>

            </div>

            <div class="--cnt">
                <form id="frm" name="frm" method="post" action="board.submit.php">
                    <input type="hidden" id="mode" name="mode" value="" />
                    <input type="hidden" id="is_secret" name="is_secret"
                        value="<?= htmlspecialchars($board_info[0]['secret_yn']) ?>" />
                    <input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>" />

                    <div class="no-form-container">
                        <div class="no-form-control">
                            <label for="write_name">성함 <span class="--require-symbol">*</span></label>
                            <input type="text" id="write_name" name="write_name" placeholder="성함을 입력해주세요.">
                        </div>
                        <div class="no-form-control">
                            <label for="phone">연락처</label>
                            <input type="text" id="phone" name="phone" placeholder="연락처를 입력해주세요">
                        </div>
                        <div class="no-form-control">
                            <label for="company">업체명</label>
                            <input type="text" id="company" name="company" placeholder="업체명을 입력해주세요">
                        </div>
                        <div class="no-form-control">
                            <label for="title">제목 <span class="--require-symbol">*</span></label>
                            <input type="text" id="title" name="title" placeholder="제목을 입력해주세요">
                        </div>
                    </div>

                    <div class="no-form-control --mt-sm">
                        <label for="contents">내용 <span class="--require-symbol">*</span></label>
                        <textarea name="contents" id="contents" placeholder="내용을 입력해주세요"></textarea>
                    </div>

                    <div class="no-form-row --mt-sm">
                        <div class="no-form-captcha">
                            <figure><img id="captcha-img" src="/inc/lib/captcha.n.php" alt="captcha"></figure>
                            <button type="button" id="reloading"><i
                                    class="fa-regular fa-arrow-rotate-left"></i></button>
                            <input type="text" name="r_captcha" id="r_captcha" maxlength="5"
                                placeholder="스팸방지 5자리를 입력해 주세요" autocomplete="off">
                        </div>

                        <div class="no-form-control">
                            <input type="password" id="secret_pwd" name="secret_pwd" placeholder="비밀번호를 입력해주세요.">
                        </div>
                    </div>

                    <div class="no-btn-wrap">
                        <a href="javascript:void(0);" onclick="history.back();"
                            class="no-btn-secondary no-btn-inquiry">취소하기</a>
                        <a href="javascript:void(0);" onclick="doBoardSubmit(<?= $isSecret ? 'true' : 'false' ?>)"
                            class="no-btn-primary no-btn-inquiry">확인</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>