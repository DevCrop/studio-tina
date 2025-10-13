<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

$board_no = $_GET['board_no'] ?? null;
?>


<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/shared/sub.visual.php'; ?>

<script type="text/javascript" src="<?= $NO_IS_SUBDIR ?>/pages/board/js/board.js?v=<?= $STATIC_FRONT_JS_MODIFY_DATE ?>">
</script>


<form id="frm" name="frm" method="post" action="board.confirm.process.php">
    <input type="hidden" id="mode" name="mode" value="">
    <input type="hidden" name="board_no" value="<?= htmlspecialchars($_REQUEST['board_no'] ?? '') ?>">
    <input type="hidden" name="no" value="<?= htmlspecialchars($_REQUEST['no'] ?? '') ?>">

    <!-- BEGIN :: CONTENT -->
    <section class="no-section-md no-confirm">
        <div class="no-container-sm">
            <article>

                <h3 class="no-confirm-title f-heading-5 --bold">
                    비밀번호 확인
                </h3>
                <p class="no-confirm-desc f-body-2">
                    작성자와 관리자만 열람하실 수 있습니다.
                    <span class="f-body-1"> 본인 확인을 위하여 비밀번호를 입력하세요.</span>
                </p>

                <div class="no-form-control">
                    <div class="no-input-box password">
                        <input type="password" id="pwd" name="pwd" placeholder="Password">
                    </div>
                </div>


                <div class="no-confirm-btn-wrap">
                    <a href="javascript:void(0);"
                        onclick="doPasswordConfirm('<?= htmlspecialchars($_REQUEST['mode'] ?? '') ?>')" title="confirm"
                        class="no-btn-primary no-btn-inquiry">확인</a>
                    <a href="javascript:void(0);" onclick="history.back();" class="no-btn-secondary no-btn-inquiry">취소하기
                    </a>

                </div>
            </article>
        </div>
    </section>
    <!-- END :: CONTENT -->
</form>
<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>