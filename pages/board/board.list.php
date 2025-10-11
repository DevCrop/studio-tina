
<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/inc/lib/base.class.php';
$connect = DB::getInstance();

// Retrieve request variables with null coalescing
$board_no = $_REQUEST['board_no'] ?? null;
$category_no = $_REQUEST['category_no'] ?? null;
$searchKeyword = $_REQUEST['searchKeyword'] ?? '';
$searchColumn = $_REQUEST['searchColumn'] ?? '';
$sdate = $_REQUEST['sdate'] ?? '';
$edate = $_REQUEST['edate'] ?? '';
$RtsearchKeyword = $_REQUEST['RtsearchKeyword'] ?? null;
$RtsearchColumn = $_REQUEST['RtsearchColumn'] ?? null;

// Decode base64 search keywords if present
if ($RtsearchKeyword) {
    $searchKeyword = base64_decode($RtsearchKeyword);
}
if ($RtsearchColumn) {
    $searchColumn = base64_decode($RtsearchColumn);
}

// Set up the main query with a WHERE clause
$mainqry = " WHERE a.sitekey = :sitekey";

// Retrieve board info using nullsafe operator
$board_info = getBoardInfoByNo($board_no) ?? [];
$role_info = getBoardRole($board_no, $NO_USR_LEV) ?? [];
$boardManage_info = getBoardManageInfoByNo($board_no) ?? [];
$boardCategory = getBoardCategory($board_no) ?? [];

// Check for permissions and open status
if ($board_info[0]['isOpen'] === "N") {
    if (!$role_info) {
        alert("게시판 권한 설정이 먼저 필요합니다.");
        exit;
    }
    if ($role_info[0]['role_list'] === "N") {
        error("열람 권한이 없습니다.", "/pages/member/login.php");
        exit;
    }
}

$skin = $board_info[0]['skin'] ?? 'default';

// Append conditions to main query based on request data
if ($board_no) $mainqry .= " AND a.board_no = :board_no";
if ($category_no) $mainqry .= " AND a.category_no = :category_no";
if ($searchKeyword) {
    $mainqry .= " AND (REPLACE(a.title, ' ', '') LIKE :searchKeyword OR REPLACE(a.contents, ' ', '') LIKE :searchKeyword)";
    $searchKeyword = '%' . trim($searchKeyword) . '%';
}
if ($sdate && $edate) {
    $mainqry .= " AND (DATE_FORMAT(a.regdate, '%Y-%m-%d') BETWEEN :sdate AND :edate)";
}

// Pagination and list parameters
$page = (int)($_REQUEST['page'] ?? 1);
$perpage = (int)($_REQUEST['perpage'] ?? ($board_info[0]['list_size'] ?? 10));
$listRowCnt = $perpage;
$listCurPage = $page;
$count = ($listCurPage * $listRowCnt) - $listRowCnt;

// Prepare count query
$query = "SELECT COUNT(*) AS cnt FROM nb_board a $mainqry";

$stmt = $connect->prepare($query);
// Bind parameters to count query
$params = [
    ':sitekey' => $NO_SITE_UNIQUE_KEY,
    ':board_no' => $board_no,
    ':category_no' => $category_no,
    ':searchKeyword' => $searchKeyword,
    ':sdate' => $sdate,
    ':edate' => $edate,
];
$stmt->execute(array_filter($params)); // Filter out nulls

$totalCnt = $stmt->fetchColumn();
$Page = (int)ceil($totalCnt / $listRowCnt);

// Prepare main data query with LIMIT
$query = "
    SELECT a.*, b.title AS board_name, c.name AS category_name
    FROM nb_board a
    LEFT JOIN nb_board_manage b ON a.board_no = b.no
    LEFT JOIN nb_board_category c ON a.category_no = c.no
    $mainqry
    ORDER BY a.is_notice='Y' DESC, a.regdate DESC
    LIMIT $count, $listRowCnt
";
$stmt = $connect->prepare($query);

// Append count and listRowCnt to parameters for main data query
$stmt->execute(array_filter($params)); // Filter out nulls

$arrResultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rnumber = $totalCnt - (($listCurPage - 1) * $listRowCnt);
$board_title = $board_info[0]['title'] ?? '';

// Render results as needed
?>


<!-- HTML & PHP Integration -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>

<?php if ($board_no == 8 || $board_no == 12) {
echo '<script src="' . $ROOT . '/resource/js/sub-blog.js?' . date('YmdHis') . '" defer></script>';
}?>

<?php if ($board_no == 9 || $board_no == 13) {
echo '<script src="' . $ROOT . '/resource/js/sub-news.js?' . date('YmdHis') . '" defer></script>';
}?>

<?php if ($board_no == 10 || $board_no == 11 || $board_no == 14 || $board_no == 15 || $board_no == 16) {
echo '<script src="' . $ROOT . '/resource/js/sub-works.js?' . date('YmdHis') . '" defer></script>';
}?>

<?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>

<main <?= ($board_no == 15 || $board_no == 16) ? 'style="min-height: 50vh"' : '' ?>>
    <form id="frm" name="frm" method="get" autocomplete='off'>    
        <input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>">
        <input type="hidden" id="category_no" name="category_no" value="<?= htmlspecialchars($category_no) ?>">
        <input type="hidden" id="mode" name="mode" value="">
        <?php
            switch($skin) {
                case "bbs":  include __DIR__."/skin/skin.list.php"; break;
                case "gal":  include __DIR__."/skin/skin.gallery.php"; break;
                case "wok":  include __DIR__."/skin/skin.works.php"; break;
            }
        ?>
    </form>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>

<script type="text/javascript" src="<?=$NO_IS_SUBDIR?>/pages/board/js/board.js?v=<?=$STATIC_FRONT_JS_MODIFY_DATE?>"></script>
<?php if ($board_no == 10 || $board_no == 14): ?>
  <script src="/pages/board/js/filter.js?v=<?= $STATIC_FRONT_JS_MODIFY_DATE ?>"></script>
<?php endif; ?>
<?php if ($board_no == 15 || $board_no == 16): ?>
  <script src="/pages/board/js/filter_2.js?v=<?= $STATIC_FRONT_JS_MODIFY_DATE ?>"></script>
<?php endif; ?>
<?php include_once $STATIC_ROOT . '/inc/layouts/end.php'; ?>


