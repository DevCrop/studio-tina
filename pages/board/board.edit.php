<?php
include_once "../../inc/lib/base.class.php";


$no = $_REQUEST['no'] ?? null;
$board_no = $_REQUEST['board_no'] ?? null;

if (!$board_no) {
    error("잘못된 접근입니다", $NO_IS_SUBDIR . "/");
}


try {
    // Obtain PDO instance
    $db = DB::getInstance();

    // 데이터베이스에서 게시물 정보 가져오기
    $query = "SELECT 
                a.no, a.board_no, a.user_no, a.category_no, a.comment_cnt, a.title, a.contents, a.regdate, a.read_cnt, 
                a.thumb_image, a.is_admin_writed, a.is_notice, a.is_secret, a.secret_pwd, a.write_name, a.isFile,
                file_attach_1, file_attach_origin_1, file_attach_2, file_attach_origin_2, 
                file_attach_3, file_attach_origin_3, file_attach_4, file_attach_origin_4, 
                file_attach_5, file_attach_origin_5 
              FROM nb_board a
              WHERE a.no = :no";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        error("정보를 찾을 수 없습니다");
    }

} catch (PDOException $e) {
    error("데이터를 불러오는 중 오류가 발생했습니다: " . $e->getMessage());
    exit;
}

// 비밀글 확인
if ($data['is_secret'] === "Y" && $_SESSION['board_secret_confirmed_' . $no] !== "Y") {
    error("비밀번호 확인이 필요한 게시물입니다.");
}

// Board and Role Information
$board_info = getBoardInfoByNo($board_no);
$isSecret = ($board_info[0]['secret_yn'] === "Y");
$role_info = getBoardRole($board_no, $NO_USR_LEV);

if ($role_info[0]['role_edit'] === "N") {
    alert("접근 권한이 없습니다.");
}



?>

<!-- Head -->
<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>

<!-- 스타일, 스크립트  -->
<script type="text/javascript" src="<?= $NO_IS_SUBDIR ?>/pages/board/js/board.js?v=<?= $STATIC_FRONT_JS_MODIFY_DATE ?>">
</script>

<!-- Header -->
<?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/shared/sub.visual.php'; ?>



<section class="no-sub-write no-section-md">
    <div class="no-container-lg">
        <div class="--section-title-with-button">
            <hgroup>
                <h2 class="f-heading-3 clr-text-title">AS Center</h2>
            </hgroup>

        </div>

        <div class="--cnt">
            <form id="frm" name="frm" method="post" action="board.submit.php">
                <input type="hidden" id="mode" name="mode" value="" />
                <input type="hidden" id="is_secret" name="is_secret"
                    value="<?= htmlspecialchars($board_info[0]['secret_yn']) ?>" />
                <input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>" />
                <input type="hidden" id="no" name="no" value="<?= htmlspecialchars($no) ?>" />

                <div class="no-form-container">
                    <div class="no-form-control">
                        <label for="write_name">성함 <span class="--require-symbol">*</span></label>
                        <input type="text" id="write_name" name="write_name" placeholder="성함을 입력해주세요."
                            value="<?= htmlspecialchars($data['write_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="no-form-control">
                        <label for="phone">연락처</label>
                        <input type="text" id="phone" name="phone" placeholder="연락처를 입력해주세요"
                            value="<?= htmlspecialchars($data['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="no-form-control">
                        <label for="company">업체명</label>
                        <input type="text" id="company" name="company" placeholder="업체명을 입력해주세요"
                            value="<?= htmlspecialchars($data['company'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="no-form-control">
                        <label for="title">제목 <span class="--require-symbol">*</span></label>
                        <input type="text" id="title" name="title" placeholder="제목을 입력해주세요"
                            value="<?= htmlspecialchars($data['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div class="no-form-control --mt-sm">
                    <label for="contents">내용 <span class="--require-symbol">*</span></label>
                    <textarea name="contents"
                        id="contents"><?= htmlspecialchars($data['contents'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <div class="no-form-row --mt-sm">
                    <div class="no-form-captcha">
                        <figure><img id="captcha-img" src="/inc/lib/captcha.n.php" alt="captcha"></figure>
                        <button type="button" id="reloading"><i class="fa-regular fa-arrow-rotate-left"></i></button>
                        <input type="text" name="r_captcha" id="r_captcha" maxlength="5" placeholder="스팸방지 5자리를 입력해 주세요"
                            autocomplete="off">
                    </div>

                    <div class="no-form-control">
                        <input type="password" id="secret_pwd" name="secret_pwd" placeholder="비밀번호를 입력해주세요.">
                    </div>
                </div>

                <div class="no-btn-wrap">
                    <a href="javascript:void(0);" onclick="history.back();"
                        class="no-btn-secondary no-btn-inquiry">취소하기</a>
                    <a href="javascript:void(0);" onclick="doBoardEditSubmit(<?= $isSecret ? 'true' : 'false' ?>)"
                        class="no-btn-primary no-btn-inquiry">확인</a>
                </div>

            </form>
        </div>
    </div>
</section>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>