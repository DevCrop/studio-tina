<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "시설";
$depthnum = 4;

$db = DB::getInstance();

// ====================== 페이지네이션 변수 ==========================
$perpage = 10;
$listCurPage = isset($_POST['page']) ? (int)$_POST['page'] : (isset($_GET['page']) ? (int)$_GET['page'] : 1);
$pageBlock = 2;
$count = ($listCurPage - 1) * $perpage;
// ==================================================================

// 지점 목록
$branchesStmt = $db->prepare("SELECT id, name_kr FROM nb_branches WHERE id IN (2, 3, 4) ORDER BY id ASC");
$branchesStmt->execute();
$branches = $branchesStmt->fetchAll(PDO::FETCH_ASSOC); 

// GET 파라미터
$branch_id = $_GET['branch_id'] ?? '';
$facilityCategory = $_GET['facilityCategory'] ?? '';
$active_filter = $_GET['is_active'] ?? '';  
$searchColumn = $_GET['searchColumn'] ?? '';
$searchKeyword = $_GET['searchKeyword'] ?? '';

// WHERE 조건 구성
$where = "WHERE 1=1";
$params = [];

if (!empty($branch_id)) {
    $where .= " AND f.branch_id = :branch_id";
    $params[':branch_id'] = $branch_id;
}

if (!empty($facilityCategory)) {
    $where .= " AND f.categories = :facilityCategory";
    $params[':facilityCategory'] = $facilityCategory;
}

if ($active_filter !== '') {
    $where .= " AND f.is_active = :is_active";
    $params[':is_active'] = (int)$active_filter;
}

if (!empty($searchColumn) && !empty($searchKeyword)) {
    $allowedColumns = ['title', 'categories'];
    if (in_array($searchColumn, $allowedColumns)) {
        if ($searchColumn === 'categories') {
            $where .= " AND f.categories = :searchCategory";
            $params[':searchCategory'] = array_search($searchKeyword, $facilities) ?: -1;
        } else {
            $where .= " AND f.{$searchColumn} LIKE :searchKeyword";
            $params[':searchKeyword'] = "%{$searchKeyword}%";
        }
    }
}

// ================== 전체 개수 조회 ==================
$totalSql = "SELECT COUNT(*) FROM nb_facilities f LEFT JOIN nb_branches b ON f.branch_id = b.id $where";
$totalStmt = $db->prepare($totalSql);
$totalStmt->execute($params);
$totalCount = (int)$totalStmt->fetchColumn();
$Page = ceil($totalCount / $perpage);
// ===================================================

// ================== 실제 데이터 조회 ==================
$sql = "
    SELECT f.*, b.name_kr AS branch_name
    FROM nb_facilities f
    LEFT JOIN nb_branches b ON f.branch_id = b.id
    $where
    ORDER BY f.sort_no ASC
    LIMIT {$count}, {$perpage}
";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
// =====================================================
?>


<?php include_once "../../inc/admin.head.php"; ?>

<body data-page="facility">
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>
        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form method="GET" name="frm" id="frm" autocomplete="off">
                <input type="hidden" name="mode" id="mode" value="list">

                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?= $pageName ?> 관리</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item"><span>환경설정</span></li>
                                        <li class="no-breadcrumb-item"><span><?= $pageName ?> 관리</span></li>
                                    </ul>
                                </div>
                            </div>
                            <?php if($role->canDelete()) :?>
                            <div class="no-items-center">
                                <a href="./new.php" class="no-btn no-btn--main no-btn--big"> <?= $pageName ?> 생성 </a>
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

                                <!-- 지점 선택 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">지점</h3>
                                    <div class="no-admin-content">
                                        <select name="branch_id" id="branch_category">
                                            <option value="">전체</option>
                                            <?php foreach ($branches as $b): ?>
                                            <option value="<?= $b['id'] ?>"
                                                <?= ($branch_id ?? '') == $b['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($b['name_kr']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 카테고리 선택 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">카테고리</h3>
                                    <div class="no-admin-content">
                                        <select name="facilityCategory" id="facilityCategory">
                                            <option value="">전체</option>
                                            <?php foreach ($facilities as $key => $label): ?>
                                            <option value="<?= $key ?>"
                                                <?= ($facilityCategory ?? '') == $key ? 'selected' : '' ?>>
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
                                        <select name="searchColumn" id="searchColumn">
                                            <option value="">선택</option>
                                            <option value="title"
                                                <?= ($searchColumn ?? '') === 'title' ? 'selected' : '' ?>>이름</option>
                                            <option value="categories"
                                                <?= ($searchColumn ?? '') === 'categories' ? 'selected' : '' ?>>카테고리
                                            </option>
                                        </select>
                                        <div class="no-search-wrap no-ml">
                                            <div class="no-search-input">
                                                <i class="bx bx-search-alt-2"></i>
                                                <input type="text" name="searchKeyword" id="searchKeyword"
                                                    placeholder="검색어 입력"
                                                    value="<?= htmlspecialchars($searchKeyword ?? '') ?>">
                                            </div>
                                            <div class="no-search-btn">
                                                <button type="submit"
                                                    class="no-btn no-btn--main no-btn--search">검색</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 리스트 -->
                    <div class="no-content-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title"><?= $pageName ?> 리스트</h2>
                            </div>

                            <div class="no-card-body">
                                <div class="no-table-option">
                                <?php if($role->canDelete()) : ?>
                                    <ul class="no-table-check-control">
                                        <li><a href="#" class="no-btn no-btn--sm no-btn--check active "
                                                data-action="selectAll">전체선택</a></li>
                                        <li><a href="#" class="no-btn no-btn--sm" data-action="deselectAll">선택해제</a>
                                        </li>
                                        <li><a href="#" class="no-btn no-btn--sm" data-action="deleteSelected">선택삭제</a>
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
                                                <th>지점</th>
                                                <th>이름</th>
                                                <th>썸네일</th>
                                                <th>카테고리</th>
                                                <th>순서변경</th>
                                                <th>정렬</th>
                                                <th>노출 여부</th>
                                                <th>관리</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($rows) > 0): ?>
                                            <?php foreach ($rows as $row): ?>
                                            <tr>
                                                <?php if($role->canDelete()) :?>
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
                                                <td><?= htmlspecialchars($row['branch_name'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row['title']) ?></td>
                                                <td>
                                                    <?php if (!empty($row['thumb_image'])): ?>
                                                    <img src="/uploads/facilities/<?= $row['thumb_image'] ?>" alt="썸네일"
                                                        style="max-width: 60px;">
                                                    <?php else: ?>
                                                    <span style="color: #aaa;">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($facilities[$row['categories']] ?? '-') ?>
                                                </td>
                                                <td class="sort-btn-group">
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
                                                <td><?= $row['sort_no'] ?></td>
                                                <td>
                                                    <span
                                                        class="no-btn <?= $row['is_active'] ? 'no-btn--notice' : 'no-btn--normal' ?>">
                                                        <?= htmlspecialchars($is_active[$row['is_active']] ?? '미정') ?>
                                                    </span>
                                                </td>
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
                                                <td colspan="8" style="text-align: center; color: #888;">등록된 시설이 없습니다.
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

    <?php include_once "../../inc/admin.footer.php"; ?>