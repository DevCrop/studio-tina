<?php include_once "../../../inc/lib/base.class.php";

$pageName = "회원";
$depthnum = 9;

$perpage = 10;
$listCurPage = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$pageBlock = 2;
$count = ($listCurPage - 1) * $perpage;

$searchColumn = $_GET['searchColumn'] ?? '';
$searchKeyword = $_GET['searchKeyword'] ?? '';
$active_status = $_GET['active_status'] ?? '';
$sns_type = $_GET['sns_type'] ?? '';

$db = DB::getInstance();

// WHERE ==============================================
$where = "WHERE 1=1";
$params = [];

if (!empty($active_status)) {
    $where .= " AND active_status = :active_status";
    $params[':active_status'] = $active_status;
}

if ($sns_type === 'normal') {
    $where .= " AND kakao_id IS NULL";
} elseif ($sns_type === 'kakao') {
    $where .= " AND kakao_id IS NOT NULL";
}

if (!empty($searchColumn) && !empty($searchKeyword)) {
    $allowedColumns = ['user_id', 'name', 'email'];
    if (in_array($searchColumn, $allowedColumns)) {
        $where .= " AND {$searchColumn} LIKE :searchKeyword";
        $params[':searchKeyword'] = "%{$searchKeyword}%";
    }
}
// WHERE ==============================================

// 총 데이터 수 가져오기
$totalStmt = $db->prepare("SELECT COUNT(*) FROM nb_users {$where}");
$totalStmt->execute($params);
$totalCount = (int)$totalStmt->fetchColumn();
$Page = ceil($totalCount / $perpage);


// 실제 데이터 조회
$sql = "
    SELECT id, user_id, name, email, phone, regdate, active_status 
    FROM nb_users 
    {$where}
    ORDER BY regdate DESC
    LIMIT {$count}, {$perpage}
";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!--=====================HEAD========================= -->
<?php include_once "../../inc/admin.head.php"; ?>

<body data-page="member">
    <div class="no-wrap">

        <!--=====================HEADER========================= -->
        <?php include_once "../../inc/admin.header.php"; ?>

        <!--=====================MAIN========================= -->
        <main class="no-app no-container">

            <!--=====================DRAWER========================= -->
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <!--=====================CONTENTS========================= -->
            <form method="GET" name="frm" id="frm" autocomplete="off">
                <input type="hidden" name="mode" id="mode" value="update_status">
                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?=$pageName?> 관리</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item"><span>게시판</span></li>
                                        <li class="no-breadcrumb-item"><span><?=$pageName?> 관리</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Search -->
                    <div class="no-search no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title">회원 검색</h2>
                            </div>
                            <div class="no-card-body no-admin-column">

                                <!-- 활성화 상태 선택 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">계정 상태</h3>
                                    <div class="no-admin-content">
                                        <select name="active_status" id="active_status">
                                            <option value="">전체</option>
                                            <option value="Y"
                                                <?= isset($active_status) && $active_status === 'Y' ? 'selected' : '' ?>>
                                                활성</option>
                                            <option value="N"
                                                <?= isset($active_status) && $active_status === 'N' ? 'selected' : '' ?>>
                                                비활성</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">회원 유형</h3>
                                    <div class="no-admin-content">
                                        <select name="sns_type" id="sns_type">
                                            <option value="">전체</option>
                                            <option value="normal" <?= $sns_type === 'normal' ? 'selected' : '' ?>>일반
                                            </option>
                                            <option value="kakao" <?= $sns_type === 'kakao' ? 'selected' : '' ?>>카카오
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <!-- 검색 조건 -->
                                <div class="no-admin-block wide">
                                    <h3 class="no-admin-title">검색어</h3>
                                    <div class="no-search-select">
                                        <select name="searchColumn" id="searchColumn">
                                            <option value="">선택</option>
                                            <option value="user_id"
                                                <?= isset($searchColumn) && $searchColumn === 'user_id' ? 'selected' : '' ?>>
                                                아이디</option>
                                            <option value="name"
                                                <?= isset($searchColumn) && $searchColumn === 'name' ? 'selected' : '' ?>>
                                                이름</option>
                                            <option value="email"
                                                <?= isset($searchColumn) && $searchColumn === 'email' ? 'selected' : '' ?>>
                                                이메일</option>
                                        </select>

                                        <div class="no-search-wrap no-ml">
                                            <div class="no-search-input">
                                                <i class="bx bx-search-alt-2"></i>
                                                <input name="searchKeyword" id="searchKeyword" type="text"
                                                    placeholder="검색어를 입력해주세요."
                                                    value="<?= isset($searchKeyword) ? htmlspecialchars($searchKeyword) : '' ?>" />
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
                    <!-- Contents -->
                    <div class="no-content-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title"><?=$pageName?> 관리</h2>
                            </div>
                            <div class="no-card-body">

                                <div class="no-table-responsive">
                                    <table class="no-table">
                                        <thead>
                                            <tr>
                                                <th>번호</th>
                                                <th>아이디</th>
                                                <th>이름</th>
                                                <th>이메일</th>
                                                <th>휴대폰</th>
                                                <th>등록일</th>
                                                <th>상태</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($rows)): ?>
                                            <?php foreach ($rows as $row): ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= htmlspecialchars($row['user_id']) ?></td>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td><?= htmlspecialchars($row['email']) ?></td>
                                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                                <td><?= htmlspecialchars($row['regdate']) ?></td>
                                                <td>
                                                    <select class="status-select" data-id="<?= $row['id'] ?>">
                                                        <option value="Y"
                                                            <?= $row['active_status'] === 'Y' ? 'selected' : '' ?>>활성
                                                        </option>
                                                        <option value="N"
                                                            <?= $row['active_status'] === 'N' ? 'selected' : '' ?>>비활성
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="no-table-role">
                                                        <span class="no-role-btn"><i
                                                                class="bx bx-dots-vertical-rounded"></i></span>
                                                        <div class="no-table-action">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="9">등록된 계정이 없습니다.</td>
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