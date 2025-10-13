<!DOCTYPE html>
<html lang="ko">
<?php

	include_once "../../../inc/lib/base.class.php";

	$depthnum = 3;
	$pagenum = 1;

	$searchKeyword = $_REQUEST['searchKeyword'];
	$searchColumn = $_REQUEST['searchColumn'];
	$sdate = $_REQUEST['sdate'];
	$edate = $_REQUEST['edate'];	

	$mainqry = " WHERE a.sitekey = :sitekey ";
	$params = ['sitekey' => $NO_SITE_UNIQUE_KEY];

	if ($searchColumn && $searchKeyword) {
		$mainqry .= " AND (REPLACE(a.title, ' ', '') LIKE :searchKeyword OR REPLACE(a.contents, ' ', '') LIKE :searchKeyword)";
		$params['searchKeyword'] = '%' . trim($searchKeyword) . '%';
	}

	if ($sdate && $edate) {
		$mainqry .= " AND (DATE_FORMAT(a.regdate, '%Y-%m-%d') BETWEEN :sdate AND :edate)";
		$params['sdate'] = $sdate;
		$params['edate'] = $edate;
	}

	$page = $_POST['page'] ?? 1;
	$perpage = $_POST['perpage'] ?? 20;
	$listRowCnt = $perpage;
	$listCurPage = $page;
	$count = ($listCurPage - 1) * $listRowCnt;

	$db = DB::getInstance();
	
	try {
		// Count query
		$countQuery = "SELECT COUNT(*) AS cnt FROM nb_request a $mainqry";
		$stmt = $db->prepare($countQuery);
		$stmt->execute($params);
		$totalCnt = $stmt->fetchColumn();

		// Calculate pagination
		$Page = ceil($totalCnt / $listRowCnt);

		// Main query for data retrieval
		$dataQuery = "SELECT a.* FROM nb_request a $mainqry ORDER BY a.regdate DESC LIMIT $count, $listRowCnt";

		$stmt = $db->prepare($dataQuery);
		$stmt->execute($params);
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Board List Query
		$boardListQuery = "SELECT no, title, skin, sort_no FROM nb_board_manage WHERE sitekey = '$NO_SITE_UNIQUE_KEY' ORDER BY no ASC";
		$stmtBoard = $db->prepare($boardListQuery);
		$stmtBoard->execute();
		$arrBoardList = $stmtBoard->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		exit;
	}

	$rnumber = $totalCnt - ($listCurPage - 1) * $listRowCnt;

	include_once "../../inc/admin.title.php";
	include_once "../../inc/admin.css.php";
	include_once "../../inc/admin.js.php";

?>

</head>

<body>
    <div class="no-wrap">
        <!-- Header -->
		<?php include_once "../../inc/admin.header.php"; ?>

        <!-- Main -->
        <main class="no-app no-container">
            <!-- Drawer -->
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <!-- Contents -->
            <form method="POST" name="frm" id="frm" autocomplete="off">
            <input type="hidden" name="mode" id="mode" value="">
                <section class="no-content">
                    <!-- Page Title -->
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                            <h1 class="no-page-title">게시글 관리</h1>
                            <div class="no-breadcrumb-container">
                                <ul class="no-breadcrumb-list">
                                <li class="no-breadcrumb-item">
                                    <span>게시판</span>
                                </li>
                                <li class="no-breadcrumb-item">
                                    <span>게시글 관리</span>
                                </li>
                                </ul>
                            </div>
                            </div>
                            <!-- page indicator -->

                        </div>
                    </div>

                    <!-- Search -->
                    <div class="no-search no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title">게시글 검색</h2>
                            </div>
                            <div class="no-card-body no-admin-column">
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">검색 일자</h3>
                                    <div class="no-admin-content no-admin-date">
                                        <input type="text" name="sdate" id="sdate" value="<?= htmlspecialchars($sdate) ?>"/>
                                        <span></span>
                                        <input type="text" name="edate" id="edate" value="<?= htmlspecialchars($edate) ?>"/>
                                    </div>
                                </div>
                                <!-- admin block -->

                                <div class="no-admin-block wide">
                                    <h3 class="no-admin-title">검색어</h3>
                                    
                                    <div class="no-search-select">
                                        <select name="searchColumn" id="searchColumn">
                                            <option value="">선택</option>
                                            <option value="a.title" <?= $searchColumn == "a.title" ? "selected" : "" ?>>게시물 제목</option>
                                            <option value="a.contents" <?= $searchColumn == "a.contents" ? "selected" : "" ?>>게시물 내용</option>
                                        </select>
                                        <div class="no-search-wrap no-ml">
                                            <div class="no-search-input">
                                                <i class="bx bx-search-alt-2"></i>
                                                <input
                                                    name="searchKeyword"
                                                    id="searchKeyword"
                                                    type="text"
                                                    title="검색어 입력"
                                                    placeholder="검색어를 입력해주세요."
                                                    value="<?= htmlspecialchars($searchKeyword) ?>"
                                                />
                                            </div>
                                            <div class="no-search-btn">
                                                <button
                                                    type="button"
                                                    title="검색"
                                                    class="no-btn no-btn--main no-btn--search"
                                                    onClick="doSearchList();"
                                                >
                                                검색
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contents -->
                    <div class="no-content-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title">게시글 관리</h2>
                            </div>

                            <div class="no-card-body">
                                <div class="no-table-option flex-end">
                                    <div class="no-perpage">
                                        <select name="perpage" id="perpage" onChange="document.frm.submit();">
                                            <option value="20" <?= $perpage == "20" ? "selected" : "" ?>>20개씩</option>
                                            <option value="50" <?= $perpage == "50" ? "selected" : "" ?>>50개씩</option>
                                            <option value="100" <?= $perpage == "100" ? "selected" : "" ?>>100개씩</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="no-table-responsive">
                                    <table class="no-table">
                                        <caption class="no-blind">
                                            번호, 게시판 이름, 공지, 제목, 작성자, 작성일, 조회수,
                                            관리로 구성된 게시글 관리표
                                        </caption>
                                        
                                        <thead>
                                            <tr>
                                                <th scope="col" class="no-width-120 no-min-width-60">
                                                    번호
                                                </th>
												<th scope="col" class="no-min-width-120">
													이름
                                                </th>
                                                <th scope="col" class="no-min-width-150">
                                                    연락처
                                                </th>
												<th scope="col" class="no-min-width-150">
                                                    업체명
                                                </th>
                                                <th scope="col" class="no-min-width-100">
                                                    등록일
                                                </th>
                                                <th scope="col" class="no-min-width-role no-td-center">
                                                    관리
                                                </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php
                                                foreach ($result as $v) {
                                                    $rnumber--;
                                            ?>
                                            <tr>
                                                <td>
                                                    <span> <?= $rnumber ?> </span>
                                                </td>
												<td>
													<a href="./request.view.php?no=<?= htmlspecialchars($v['no']) ?>">
                                                    <?= htmlspecialchars($v['name']) ?>
												</a>
                                                </td>
												<td>
                                                    <?= htmlspecialchars($v['phone']) ?>
                                                </td>
                                                <td>
                                                     <?= htmlspecialchars($v['company']) ?>
                                                </td>
                                                <td>
                                                   <span><?= date("Y-m-d", strtotime($v['regdate'])) ?></span>
                                                </td>
                                                <td>
                                                    <div class="no-table-role">
                                                        <span class="no-role-btn">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </span>
                                                        <div class="no-table-action">
                                                            
                                                            <a
                                                                href="./request.view.php?no=<?= htmlspecialchars($v['no']) ?>"
                                                                class="no-btn no-btn--sm no-btn--normal"
                                                                onClick="doRegSave();"
                                                            >
                                                                보기
                                                            </a>

                                                            <a
                                                            href="javascript:doDelete(<?= htmlspecialchars($v['no']) ?>);"
                                                            class="no-btn no-btn--sm no-btn--delete-outline"
                                                            >삭제</a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table>

                                    <?php if (empty($result)) { ?>
                                    <!-- 글이 하나라도 등록되지 않았을 때 보여줄 div -->
                                    <p>등록된 내용이 없습니다.</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- card body -->
                        </div>
                        <!-- card -->
                    </div>
                    <!-- contents -->

                    <!-- Pagination -->
                    <?php include_once "../../lib/admin.pagination.php"; ?>
                </section>
            </form>
        </main>

        <!-- Footer -->
        <script type="text/javascript" src="./js/request.process.js?c=<?= $STATIC_ADMIN_JS_MODIFY_DATE ?>"></script>
        <?php include_once "../../inc/admin.footer.php"; ?>
    </div>

	<script>
		
	</script>	
</body>
</html>
