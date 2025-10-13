<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "비급여 항목";
$depthnum = 6;

try {
    $db = DB::getInstance();
} catch (Exception $e) {
    echo "DB 연결 실패: " . $e->getMessage();
    exit;
}

$id = $_GET['id'] ?? null;
$item = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM nb_nonpay_items WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo "<script>alert('존재하지 않는 항목입니다.'); history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

// JS에 2차 카테고리 데이터 주입
echo "<script>window.nonpaySecondaryCategories = " . json_encode($nonpay_secondary_categories, JSON_UNESCAPED_UNICODE) . ";</script>";

include_once "../../inc/admin.title.php";
include_once "../../inc/admin.css.php";
include_once "../../inc/admin.js.php";
?>

</head>

<body data-page="nonpay">
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>

        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form id="frm" method="post">
                <input type="hidden" name="mode" value="update">
                <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
				<input type="hidden" name="sort_no" value="<?= htmlspecialchars($item['sort_no']) ?>">

                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?= $pageName ?> 수정</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item"><span><?= $pageName ?></span></li>
                                        <li class="no-breadcrumb-item"><span>수정</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header no-card-header--detail">
                                <h2 class="no-card-title"><?= $pageName ?> 수정</h2>
                            </div>

                            <div class="no-card-body no-admin-column no-admin-column--detail">

                                <!-- 1차 카테고리 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="category_primary">1차 카테고리</label></h3>
                                    <div class="no-admin-content">
                                        <select name="category_primary" id="category_primary" required>
                                            <option value="">1차 카테고리 선택</option>
                                            <?php foreach ($nonpay_primary_categories as $key => $label): ?>
                                            <option value="<?= $key ?>"
                                                <?= $item['category_primary'] == $key ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($label) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 2차 카테고리 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="category_secondary">2차 카테고리</label></h3>
                                    <div class="no-admin-content">
                                        <select name="category_secondary" id="category_secondary" required
                                            data-selected="<?= htmlspecialchars($item['category_secondary'] ?? '') ?>">
                                            <option value="">2차 카테고리 선택</option>
                                        </select>

                                    </div>
                                </div>


                                <!-- 항목명 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="title">항목명</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" name="title" id="title" required
                                            value="<?= htmlspecialchars($item['title']) ?>">
                                    </div>
                                </div>

                                <!-- 비용 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="cost">비용 (원)</label></h3>
                                    <div class="no-admin-content">
                                        <input type="number" name="cost" id="cost" min="0" required
                                            value="<?= (int)$item['cost'] ?>">
                                    </div>
                                </div>

                                <!-- 정렬 -->
                                <!--
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="sort_no">정렬 순서</label></h3>
                                    <div class="no-admin-content">
                                        <input type="number" name="sort_no" id="sort_no"
                                            value="<?= (int)$item['sort_no'] ?>">
                                    </div>
                                </div>-->

                                <!-- 노출 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($is_active as $value => $label): 
                                                $id = 'active_' . $value;
                                                $checked = ((int)$item['is_active'] === $value) ? 'checked' : '';
                                            ?>
                                            <label for="<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="is_active" id="<?= $id ?>"
                                                        value="<?= $value ?>" <?= $checked ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text"><?= htmlspecialchars($label) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- 버튼 -->
                                <div class="no-items-center center">
                                    <a href="./index.php" class="no-btn no-btn--big no-btn--normal">목록</a>
                                    <?php if($role->canDelete()) :?>
                                    <button type="submit" class="no-btn no-btn--big no-btn--main"
                                        id="editBtn">수정</button>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </main>
        <?php include_once "../../inc/admin.footer.php"; ?>
    </div>

</body>

</html>