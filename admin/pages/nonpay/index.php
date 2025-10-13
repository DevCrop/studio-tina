<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "비급여 항목";
$depthnum = 6;

$db = DB::getInstance();

// 페이지네이션 변수 설정
$perpage = 20; 
$listCurPage = isset($_POST['page']) ? (int)$_POST['page'] : (isset($_GET['page']) ? (int)$_GET['page'] : 1);
$pageBlock = 2; // 좌우 페이지 넘버 표시 개수
$count = ($listCurPage - 1) * $perpage; // LIMIT 시작 인덱스


// 필터 입력값
$category_primary = $_GET['category_primary'] ?? '';
$searchKeyword = $_GET['searchKeyword'] ?? '';
$active_filter = $_GET['is_active'] ?? '';

// WHERE 절 및 파라미터 구성
$where = "WHERE 1=1";
$params = [];

if (!empty($category_primary)) {
    $where .= " AND f.category_primary = :category_primary";
    $params[':category_primary'] = $category_primary;
}

if ($active_filter !== '') {
    $where .= " AND f.is_active = :is_active";
    $params[':is_active'] = (int)$active_filter;
}

if (!empty($searchKeyword)) {
    $where .= " AND f.title LIKE :searchKeyword";
    $params[':searchKeyword'] = "%{$searchKeyword}%";
}

$totalSql = "SELECT COUNT(*) FROM nb_nonpay_items f {$where}";
$totalStmt = $db->prepare($totalSql);
$totalStmt->execute($params);
$totalCount = (int)$totalStmt->fetchColumn();
$Page = ceil($totalCount / $perpage); // 전체 페이지 수 계산

$sql = "
    SELECT f.*
    FROM nb_nonpay_items f
    {$where}
    ORDER BY f.sort_no ASC
    LIMIT {$count}, {$perpage}
";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!--=====================HEAD========================= -->
<?php include_once "../../inc/admin.head.php"; ?>

<body data-page="nonpay">
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
                            <?php if($role->canDelete()):?>
                            <div class="no-items-center">
                                <a href="./new.php" class="no-btn no-btn--main no-btn--big"> <?=$pageName?> 생성 </a>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>

                    <!-- 검색 조건 -->
                    <div class="no-search no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title"><?= $pageName ?> 검색</h2>
                            </div>
                            <div class="no-card-body no-admin-column">

                                <!-- 대카테고리 (1차) -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">1차 카테고리</h3>
                                    <div class="no-admin-content">
                                        <select name="category_primary" id="category_big">
                                            <option value="">전체</option>
                                            <?php foreach ($nonpay_primary_categories as $key => $label): ?>
                                            <option value="<?= $key ?>"
                                                <?= $category_primary == $key ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($label) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <!-- 전체 옵션 수동 추가 -->
                                            <label for="is_active_all">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="is_active" id="is_active_all" value=""
                                                        <?= $active_filter === '' ? 'checked' : '' ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text">전체</span>
                                            </label>

                                            <!-- $is_active 반복 -->
                                            <?php foreach ($is_active as $key => $label): 
                                                $id = "is_active_$key";
                                                $checked = ($active_filter !== '' && $active_filter == $key) ? 'checked' : '';
                                            ?>
                                            <label for="<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="is_active" id="<?= $id ?>"
                                                        value="<?= $key ?>" <?= $checked ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text"><?= htmlspecialchars($label) ?></span>
                                            </label>
                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>

                                <!-- 검색어 -->
                                <div class="no-admin-block wide">
                                    <h3 class="no-admin-title">검색어</h3>
                                    <div class="no-search-select">
                                        <div class="no-search-wrap ">
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
                                <!-- 체크 컨트롤 -->
                                <div class="no-table-option">
                                <?php if($role->canDelete()) :?>
                                    <ul class="no-table-check-control">
                                        <li>
                                            <a href="#" class="no-btn no-btn--sm no-btn--check active "
                                                data-action="selectAll">전체선택</a>
                                        </li>
                                        <li>
                                            <a href="#" class="no-btn no-btn--sm no-btn--check"
                                                data-action="deselectAll">선택해제</a>
                                        </li>
                                        <li>
                                            <a href="#" class="no-btn no-btn--sm no-btn--check"
                                                data-action="deleteSelected">선택삭제</a>
                                        </li>
                                    </ul>
                                <?php endif;?>
								<span>총 <?=$totalCount?>개</span>	
                                </div>

                                <div class="no-table-responsive">
                                    <table class="no-table">
                                        <thead>
                                            <tr>
                                                <?php if($role->canDelete()) :?>
                                                <th class="no-width-25 no-check">
                                                    <div class="no-checkbox-form">
                                                        <label>
                                                            <input type="checkbox" id="selectAllCheckbox" />
                                                            <span><i class="bx bxs-check-square"></i></span>
                                                        </label>
                                                    </div>
                                                </th>
                                                <?php endif;?>

                                                <th>1차 카테고리</th>
                                                <th>2차 카테고리</th>
                                                <th>항목명</th>
                                                <th>비용</th>
                                                <th>순서 변경</th>
                                                <th>노출 여부</th>
                                                <th>정렬</th>
                                                <th>수정일</th>
                                                <th>관리</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($rows) > 0): ?>
                                            <?php foreach ($rows as $row): ?>
                                            <tr>
                                                <?php if($role->canDelete()):?>
                                                <td class="no-check">
                                                    <div class="no-checkbox-form">
                                                        <label>
                                                            <input type="checkbox" class="no-chk"
                                                                value="<?= $row['id'] ?>">
                                                            <span><i class="bx bxs-check-square"></i></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <?php endif;?>
                                                <td><?= $nonpay_primary_categories[$row['category_primary']] ?? '-' ?>
                                                </td>
                                                <td><?= $nonpay_secondary_categories[$row['category_primary']][$row['category_secondary']] ?? '-' ?>
                                                </td>
                                                <td><?= htmlspecialchars($row['title']) ?></td>

                                                <td><?= number_format($row['cost']) ?> 원</td>

                                                <td class="sort-btn-group">
                                                    <!-- sort_no가 클수록 위니까 버튼 누르면 sort_no를 크게/작게 조절 -->
                                                    <button type="button" class="sort-btn" data-id="<?= $row['id'] ?>"
                                                        data-action="up" data-no="<?= $row['sort_no'] + 1 ?>">
                                                        <i class='bx bx-chevron-down'></i>
                                                    </button>
                                                    <button type="button" class="sort-btn" data-id="<?= $row['id'] ?>"
                                                        data-action="down" data-no="<?= $row['sort_no'] - 1 ?>">
                                                        
														<i class='bx bx-chevron-up'></i>
                                                    </button>
                                                    <button type="button" class="sort-btn" data-id="<?= $row['id'] ?>"
                                                        data-action="first" data-no="<?= $totalCount ?>">
                                                        <i class='bx bx-chevrons-down'></i>
                                                    </button>
                                                    <button type="button" class="sort-btn" data-id="<?= $row['id'] ?>"
                                                        data-action="last" data-no="1">
                                                        <i class='bx bx-chevrons-up'></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <span
                                                        class="no-btn <?= $row['is_active'] ? 'no-btn--notice' : 'no-btn--normal' ?>">
                                                        <?= htmlspecialchars($is_active[$row['is_active']] ?? '미정') ?>
                                                    </span>
                                                </td>
                                                <td><?= $row['sort_no'] ?></td>
                                                <td><?= substr($row['updated_at'], 0, 10) ?></td>
                                                <td>
                                                    <div class="no-table-role">
                                                        <span class="no-role-btn"><i
                                                                class="bx bx-dots-vertical-rounded"></i></span>
                                                        <div class="no-table-action">
                                                            <a href="edit.php?id=<?= $row['id'] ?>"
                                                                class="no-btn no-btn--sm no-btn--normal">보기</a>
                                                            <?php if($role->canDelete()) :?>
                                                            <button type="button"
                                                                class="no-btn no-btn--sm no-btn--delete-outline delete-btn"
                                                                data-id="<?= $row['id'] ?>">삭제</button>
                                                            <?php endif;?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="10" style="text-align: center; color: #888;">
                                                    비급여 항목이 등록되지 않았습니다.
                                                </td>
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

    <script>
    window.nonpaySecondaryCategories = <?= json_encode($nonpay_secondary_categories, JSON_UNESCAPED_UNICODE) ?>;
    </script>

    <?php include_once "../../inc/admin.footer.php"; ?>