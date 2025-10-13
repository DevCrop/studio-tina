<?php
include_once "../../../inc/lib/base.class.php";

$pageName = " 문의";
$depthnum = 7;

$db = DB::getInstance();

/* =============================
 * 페이지네이션 기본값
 * ============================= */
$perpage     = 10; // 페이지당 개수
$listCurPage = isset($_POST['page']) ? (int)$_POST['page'] : (isset($_GET['page']) ? (int)$_GET['page'] : 1);
if ($listCurPage < 1) $listCurPage = 1;
$pageBlock   = 2;   // 좌우 페이지 번호 개수
$offset      = ($listCurPage - 1) * $perpage;

/* =============================
 * GET 필터 파라미터
 * ============================= */
$searchColumn   = isset($_GET['searchColumn'])   ? trim($_GET['searchColumn'])   : '';
$searchKeyword  = isset($_GET['searchKeyword'])  ? trim($_GET['searchKeyword'])  : '';

/* =============================
 * WHERE 절 구성
 * ============================= */
$where  = "WHERE 1=1";
$params = [];

if ($searchColumn !== '' && $searchKeyword !== '') {
    $allowedColumns = ['name', 'phone'];
    if (in_array($searchColumn, $allowedColumns, true)) {
        $where .= " AND r.`{$searchColumn}` LIKE :searchKeyword";
        $params[':searchKeyword'] = "%{$searchKeyword}%";
    }
}

/* =============================
 * 총 개수 → 전체 페이지 수
 * ============================= */
$countSql = "
    SELECT COUNT(*)
    FROM nb_request r
    {$where}
";
$countStmt = $db->prepare($countSql);
$countStmt->execute($params);
$totalCount = (int)$countStmt->fetchColumn();

$Page = (int)ceil($totalCount / $perpage);
if ($Page > 0 && $listCurPage > $Page) {
    $listCurPage = $Page;
    $offset = ($listCurPage - 1) * $perpage;
}

/* =============================
 * 리스트 조회 (LIMIT)
 * ============================= */
$sql = "
    SELECT *
    FROM nb_request r
    {$where}
    ORDER BY r.regdate DESC
    LIMIT {$offset}, {$perpage}
";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!--=====================HEAD========================= -->
<?php include_once "../../inc/admin.head.php"; ?>

<body data-page="inquiry">
    <div class="no-wrap">

        <!--=====================HEADER========================= -->
        <?php include_once "../../inc/admin.header.php"; ?>

        <main class="no-app no-container">

            <!--=====================DRAWER========================= -->
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form method="GET" name="frm" id="frm" autocomplete="off">
                <input type="hidden" name="mode" id="mode" value="list">

                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?=$pageName?> 관리</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item"><span>환경설정</span></li>
                                        <li class="no-breadcrumb-item"><span><?=$pageName?> 관리</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 검색 조건 -->
                    <div class="no-search no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title"><?= $pageName ?> 검색</h2>
                            </div>
                            <div class="no-card-body no-admin-column">


                                <!-- 검색어 -->
                                <div class="no-admin-block wide">
                                    <h3 class="no-admin-title">검색어</h3>
                                    <div class="no-search-select">
                                        <select name="searchColumn" id="searchColumn">
                                            <option value="">선택</option>
                                            <option value="name"
                                                <?= ($searchColumn ?? '') === 'name' ? 'selected' : '' ?>>이름</option>
                                            <option value="phone"
                                                <?= ($searchColumn ?? '') === 'phone' ? 'selected' : '' ?>>연락처</option>
                                        </select>
                                        <div class="no-search-wrap no-ml">
                                            <div class="no-search-input">
                                                <i class="bx bx-search-alt-2"></i>
                                                <input type="text" name="searchKeyword" id="searchKeyword"
                                                    placeholder="검색어 입력"
                                                    value="<?= htmlspecialchars($searchKeyword ?? '') ?>">
                                            </div>
                                            <div class="no-search-btn">
                                                <button type="submit" class="no-btn no-btn--main no-btn--search">
                                                    검색
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="no-content-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title"><?=$pageName?> 리스트</h2>
                            </div>

                            <div class="no-card-body">

                                <div class="no-table-responsive">
                                    <table class="no-table">
                                        <thead>
                                            <tr>
                                                <th>번호</th>
                                                <th>이름</th>
                                                <th>업체명</th>
                                                <th>연락처</th>
                                                <th>설치 지역</th>
                                                <th>문의 일자</th>
                                                <th>확인 여부</th>
                                                <th>관리</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($requests) > 0): ?>
                                            <?php foreach ($requests as $request): ?>
                                            <tr>

                                                <td><?= $request['no'] ?></td>
                                                <td><?= htmlspecialchars($request['name']) ?></td>
                                                <td><?= htmlspecialchars($request['company']) ?></td>
                                                <td><?= htmlspecialchars($request['phone']) ?></td>
                                                <td><?= $area_categories[$request['area']] ?? '미정' ?></td>
                                                <td><?= htmlspecialchars($request['regdate']) ?></td>
                                                <td>
                                                    <span
                                                        class="no-btn <?= ((int)$request['is_confirmed'] === 1) ? 'no-btn--notice' : 'no-btn--normal' ?>">
                                                        <?= htmlspecialchars($is_confirmed[(int)$row['is_confirmed']] ?? '미정', ENT_QUOTES, 'UTF-8') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="no-table-role">
                                                        <span class="no-role-btn"><i
                                                                class="bx bx-dots-vertical-rounded"></i></span>
                                                        <div class="no-table-action">
                                                            <a href="simple.view.php?id=<?= $row['id'] ?>"
                                                                class="no-btn no-btn--sm no-btn--normal">자세히 보기</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="10" style="text-align:center;">문의 내역이 없습니다.</td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include_once "../../lib/admin.pagination.php"; ?>
                </section>
            </form>
        </main>
    </div>

    <?php include_once "../../inc/admin.footer.php"; ?>