<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lib/base.class.php";

$db = DB::getInstance();

$board_no = $_GET['board_no'] ?? 1;
$page = $_GET['page'] ?? 1;
$page = max(1, (int)$page);
$pageSize = 3;
$offset = ($page - 1) * $pageSize;

// ✴️ 무조건 전체글 기준 게시물 수 카운트
$sqlCnt = "SELECT COUNT(*) FROM nb_board WHERE board_no = :board_no AND is_notice != 'Y'";
$stmtCnt = $db->prepare($sqlCnt);
$stmtCnt->bindValue(':board_no', $board_no, PDO::PARAM_INT);
$stmtCnt->execute();
$totalItems = (int)$stmtCnt->fetchColumn();
$totalPages = ceil($totalItems / $pageSize);

// ✴️ 무조건 전체글 기준 최신글 3개 조회
$sql = "SELECT no, title, regdate, thumb_image FROM nb_board 
        WHERE board_no = :board_no AND is_notice != 'Y'
        ORDER BY regdate DESC LIMIT :offset, :limit";
$stmt = $db->prepare($sql);
$stmt->bindValue(':board_no', $board_no, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="no-prevnext no-pd-64--y no-pd-48--b">
    <a href="/pages/board/board.list.php?board_no=<?= $board_no ?>" class="no-body-lg fw600 category">
        전체글 <i class="fa-solid fa-angle-up fa-rotate-90"></i>
    </a>

    <ul class="content-list no-mg-8--y">
        <?php foreach ($posts as $post): ?>
            <li>
                <a href="/pages/board/board.view.php?board_no=<?= $board_no ?>&no=<?= $post['no'] ?>">
                    <div class="txt">
                        <h3 class="no-body-md fw300 no-mg-8--b"><?= htmlspecialchars($post['title']) ?></h3>
                        <p class="no-body-xs fw300 wgray"><?= date("y.m.d", strtotime($post['regdate'])) ?></p>
                    </div>
                    <img src="<?= $UPLOAD_WDIR_BOARD . '/' . $post['thumb_image'] ?>" class="no-radius-xx" alt="">
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php
    $listCurPage = $page;
    $Page = $totalPages;
    include_once $STATIC_ROOT . "/pages/board/components/pagination.php";
    ?>
</section>