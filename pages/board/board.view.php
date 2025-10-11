<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php';
$connect = DB::getInstance();

$no = (int)($_REQUEST['no'] ?? 0);
$board_no = (int)($_REQUEST['board_no'] ?? 0);

$searchKeyword = $_REQUEST['searchKeyword'] ?? '';
$searchColumn = $_REQUEST['searchColumn'] ?? '';
$page = (int)($_REQUEST['page'] ?? 1);

// 게시물 정보 조회
$query = "SELECT a.*, c.name as category_name  
          FROM nb_board a
		  LEFT JOIN nb_board_category as c on a.category_no = c.no 
          WHERE a.no = :no";
$stmt = $connect->prepare($query);
$stmt->bindParam(':no', $no, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// 게시물 데이터 확인
if (!$data) {
    error("정보를 찾을 수 없습니다");
}

// 게시판 정보와 역할 정보 조회
$board_info = getBoardInfoByNo($board_no);
$role_info = getBoardRole($board_no, $NO_USR_LEV);

// 비밀글 확인
if ($data['is_secret'] === "Y" && ($_SESSION['board_secret_confirmed_' . $no] ?? "N") !== "Y") {
    error("비밀번호 확인이 필요한 게시물입니다.");
}

// 열람 권한 확인
if (($board_info[0]['isOpen'] ?? "N") === "N" && $NO_USR_NO !== $data['user_no']) {
    alert("열람 권한이 없습니다.");
    exit;
}

// 조회수 증가 처리 (중복 방지 세션 확인)
if (!isset($_SESSION['nb_board_view_count'])) {
    $query = "UPDATE nb_board SET read_cnt = read_cnt + 1 WHERE no = :no AND board_no = :board_no";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $stmt->bindParam(':board_no', $board_no, PDO::PARAM_INT);
    $stmt->execute();
    $_SESSION['nb_board_view_count'] = time();
}

// 게시판 제목 및 목록 페이지 URL 생성
$board_title = $board_info[0]['title'] ?? '게시판';
$go_to_list = "./board.list.php?board_no=" . $board_no . "&RtsearchKeyword=" . urlencode($searchKeyword) . "&RtsearchColumn=" . urlencode($searchColumn) . "&page=" . $page;


?>

<!-- Head -->
<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>

<!-- 스타일, 스크립트  -->
<script type="text/javascript" src="<?= $NO_IS_SUBDIR ?>/pages/board/js/board.js?v=<?= $STATIC_FRONT_JS_MODIFY_DATE ?>"></script>

<!-- Header -->
<?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
<main>
<?php
if ($board_no == 8) {
    echo '<h1 style="position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0);">Palette AI, Palette Hub, 영상제작, 디지털마케팅</h1>';
    echo '<h2 style="position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0);">AI영상, AI 플랫폼, 영상</h2>';
    echo '<h2 style="position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0);">영상제작, 영상 플랫폼</h2>';
    echo '<h2 style="position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0);">영상 제작, 전문가, 기획, 촬영, 편집</h2>';
    echo '<h2 style="position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0);">SNS 마케팅, 콘텐츠 마케팅, 브랜딩</h2>';
}

if ($board_no == 9) {
    echo '<h1 style="position: absolute;
        overflow: hidden;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        border: 0;
        clip: rect(0,0,0,0);">영상트렌드, AI영상 트렌드, 마케팅 트렌드, 스타트업 마케팅</h1>';
}
?>
	<div class="container-bl" style="margin-top: 12rem;">
    <form id="frm" name="frm" method="post">
        <input type="hidden" id="mode" name="mode" value="">
        <input type="hidden" id="comment_no" name="comment_no" value="">
        <input type="hidden" id="no" name="no" value="<?= $no ?>">
        <input type="hidden" id="board_no" name="board_no" value="<?= $board_no ?>">
        <input type="hidden" id="returnUrl" value="">

            <div class="no-skin">

                <div class="no-view-top">
                    <span class="no-view-top__title"><?=$data['title']?></span>
                    <span class="no-view-top__date"><?= date("Y.m.d", strtotime($data['regdate'])) ?></span>
                </div>

                <div class="no-view-bot">
                    <div class="no-view-bot__contents"><?=htmlspecialchars_decode($data['contents'])//stripslashes(nl2br($data[contents]))?></div>
                </div>
            </div>


            <?php
            try {
                // Obtain PDO instance
                $db = DB::getInstance();

                // Previous post query
                $query = "SELECT title, no, regdate FROM nb_board 
                        WHERE board_no = :board_no AND is_notice != 'Y' AND no < :no 
                        ORDER BY no DESC LIMIT 1";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':board_no', $board_no, PDO::PARAM_INT);
                $stmt->bindParam(':no', $no, PDO::PARAM_INT);
                $stmt->execute();
                $r1 = $stmt->fetch(PDO::FETCH_ASSOC);

                // Set previous post title and link
                $hasPrev = $r1 ? true : false;
                $prev_title = $r1 ? $r1['title'] : (($HTML_LANG == 'en') ? "No previous post." : "이전글이 없습니다.");
                $prev_link = $r1 ? $_SERVER['PHP_SELF'] . "?no=" . $r1['no'] . "&board_no=" . $board_no : 'javascript:void(0)';
                $prevBack = $r1 ? '' : 'onClick="redirectToList();"';

                // Next post query
                $query = "SELECT title, no, regdate FROM nb_board 
                        WHERE board_no = :board_no AND is_notice != 'Y' AND no > :no 
                        ORDER BY no ASC LIMIT 1";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':board_no', $board_no, PDO::PARAM_INT);
                $stmt->bindParam(':no', $no, PDO::PARAM_INT);
                $stmt->execute();
                $r2 = $stmt->fetch(PDO::FETCH_ASSOC);

                // Set next post title and link
                $hasNext = $r2 ? true : false;
                $next_title = $r2 ? $r2['title'] : (($HTML_LANG == 'en') ? "No next post." : "다음글이 없습니다.");
                $next_link = $r2 ? $_SERVER['PHP_SELF'] . "?no=" . $r2['no'] . "&board_no=" . $board_no : 'javascript:void(0)';
                $nextBack = $r2 ? '' : 'onClick="redirectToList();"';

            } catch (PDOException $e) {
                echo "데이터를 불러오는 중 오류가 발생했습니다: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                exit;
            }

            ?>

            <div class="no-board-nav mb60">
                <ul class="no-board-nav__items">
                    <li>
                        <a href="<?= $prev_link ?>" <?= $prevBack ?> class="no-board-nav__link">
                            <div class="no-board-nav__division">
                                <i class="fa-sharp fa-regular fa-angle-up" style="color: #fff;"></i>
                                <p><?= ($HTML_LANG == 'en') ? 'Previous' : '이전글' ?></p>
                                <span class="no-board-nav__title"><?= $prev_title ?></span>
                            </div>
                            <span class="no-board-nav__date"><?= $hasPrev ? date('Y-m-d', strtotime($r1['regdate'])) : '' ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= $next_link ?>" <?= $nextBack ?> class="no-board-nav__link">
                            <div class="no-board-nav__division">
                                <i class="fa-sharp fa-regular fa-angle-down" style="color: #fff;"></i>
                                <p><?= ($HTML_LANG == 'en') ? 'Next' : '다음글' ?></p>
                                <span class="no-board-nav__title"><?= $next_title ?></span>
                            </div>
                            <span class="no-board-nav__date"><?= $hasNext ? date('Y-m-d', strtotime($r2['regdate'])) : '' ?></span>
                        </a>
                    </li>
                </ul>

                <div class="view-btn">
                    <a href="./board.list.php?board_no=<?= $board_no ?>&category_no=<?= $cate_no ?>&RtsearchKeyword=<?= $searchKeyword ?>&RtsearchColumn=<?= $searchColumn ?>&page=<?= $page ?? 1 ?>">
                        <?= ($HTML_LANG == 'en') ? 'List' : '목록' ?>
                    </a>
                </div>
            </div>

            <?php
            $cate_no = $_GET['category_no'] ?? '';
            ?>

            <script>
            function redirectToList() {
                alert('정보를 찾을 수 없습니다.');
                const board_no = searchParam('board_no');
                location.href = './board.list.php?board_no=' + board_no;
            }

            function searchParam(key) {
                return new URLSearchParams(location.search).get(key);
            }
            </script>

    </form>
	</div>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/layouts/end.php'; ?>
