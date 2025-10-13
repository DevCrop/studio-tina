<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/base.class.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/SearchFilter.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/lib/Paginator.php';



if (isset($_GET['board_no']) && (int)$_GET['board_no'] === 11) {
    if (empty($_SESSION['id'])) {
        echo "<script>
            alert('로그인이 필요합니다.');
            location.href = '/gangseo/pages/member/login.php';
        </script>";
        exit;
    }
}


$connect = DB::getInstance();

// 요청 파라미터 수집
$board_no         = $_REQUEST['board_no']        ?? null;
$category_no      = $_REQUEST['category_no']     ?? null;
$page             = $_REQUEST['page']            ?? 1;
$searchKeyword    = $_REQUEST['searchKeyword']   ?? '';
$searchColumn     = $_REQUEST['searchColumn']    ?? '';
$sdate            = $_REQUEST['sdate']           ?? '';
$edate            = $_REQUEST['edate']           ?? '';
$RtsearchKeyword  = $_REQUEST['RtsearchKeyword'] ?? null;
$RtsearchColumn   = $_REQUEST['RtsearchColumn']  ?? null;

$category_no      = is_array($category_no) ? null : $category_no;
$page             = is_array($page) ? 1 : (int)$page;
$searchKeyword    = is_array($searchKeyword) ? '' : $searchKeyword;
$searchColumn     = is_array($searchColumn) ? '' : $searchColumn;

if (!is_array($RtsearchKeyword) && $RtsearchKeyword) {
    $searchKeyword = base64_decode($RtsearchKeyword);
}
if (!is_array($RtsearchColumn) && $RtsearchColumn) {
    $searchColumn = base64_decode($RtsearchColumn);
}

// 게시판 정보
$board_info        = getBoardInfoByNo($board_no)         ?? [];
$role_info         = getBoardRole($board_no, $NO_USR_LEV) ?? [];
$boardManage_info  = getBoardManageInfoByNo($board_no)   ?? [];
$boardCategory     = getBoardCategory($board_no)         ?? [];

if (($board_info[0]['isOpen'] ?? 'Y') === "N") {
    if (!$role_info || ($role_info[0]['role_list'] ?? 'N') === "N") {
        error("열람 권한이 없습니다.", "/pages/member/login.php");
        exit;
    }
}

$skin     = $board_info[0]['skin'] ?? 'default';
$perpage  = (int)($_REQUEST['perpage'] ?? ($board_info[0]['list_size'] ?? 10));
$listRowCnt = $perpage;
$listCurPage = $page;

$filters = [
    'sitekey'       => $NO_SITE_UNIQUE_KEY,
    'board_no'      => $board_no,
    'category_no'   => $category_no,
    'searchKeyword' => $searchKeyword,
    'sdate'         => $sdate,
    'edate'         => $edate
];

$filter = new BoardFilter($filters);
$builder = new SearchQueryBuilder($filter);
$where = $builder->getWhere();
$params = $builder->getParams();

$countQuery = "SELECT COUNT(*) AS cnt FROM nb_board a $where";
$stmt = $connect->prepare($countQuery);
$stmt->execute($params);
$totalCnt = $stmt->fetchColumn();

$paginator = new Paginator($totalCnt, $page, $perpage);

$dataQuery = "
    SELECT a.*, b.title AS board_name, c.name AS category_name
    FROM nb_board a
    LEFT JOIN nb_board_manage b ON a.board_no = b.no
    LEFT JOIN nb_board_category c ON a.category_no = c.no
    $where
    ORDER BY a.is_notice='Y' DESC, a.sort_no ASC
    LIMIT {$paginator->getOffset()}, {$paginator->getLimit()}
";

$stmt = $connect->prepare($dataQuery);
$stmt->execute($params);
$arrResultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rnumber     = $totalCnt - (($listCurPage - 1) * $listRowCnt);
$board_title = $board_info[0]['title'] ?? '';


?>


<!-- HTML & PHP Integration -->

<?php include_once $STATIC_ROOT . '/inc/layouts/head.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/layouts/header.php'; ?>
<?php include_once $STATIC_ROOT . '/inc/shared/sub.visual.php'; ?>

<main>
    <form id="frm" name="frm" method="get" autocomplete='off'>
        <input type="hidden" id="board_no" name="board_no" value="<?= htmlspecialchars($board_no) ?>">
        <input type="hidden" id="category_no" name="category_no" value="<?= htmlspecialchars($category_no) ?>">
        <input type="hidden" id="mode" name="mode" value="">
        <?php
            switch($skin) {
                case "bbs":  include __DIR__."/skin/skin.list.php"; break;
                case "gal":   include __DIR__."/skin/skin.gallery.php"; break;
                case "faq":   include __DIR__."/skin/skin.faq.php"; break;
                case "pro":   include __DIR__."/skin/skin.product.php"; break;
            }
        ?>
    </form>
</main>

<?php include_once $STATIC_ROOT . '/inc/layouts/footer.php'; ?>

<script type="text/javascript" src="<?=$NO_IS_SUBDIR?>/pages/board/js/board.js?v=<?=$STATIC_FRONT_JS_MODIFY_DATE?>">
</script>