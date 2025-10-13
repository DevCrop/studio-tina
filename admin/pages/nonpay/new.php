<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "비급여 항목 ";
$depthnum = 6;


try {
    $db = DB::getInstance(); 
} catch (Exception $e) {
    echo "데이터베이스 연결 오류: " . $e->getMessage();
    exit;
}

include_once "../../inc/admin.title.php";
include_once "../../inc/admin.css.php";
include_once "../../inc/admin.js.php";


echo "<script>window.nonpaySecondaryCategories = " . json_encode($nonpay_secondary_categories, JSON_UNESCAPED_UNICODE) . ";</script>";

?>

</head>

<body data-page="nonpay">
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>

        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form id="frm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="mode" value="insert">

                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?= $pageName ?> 등록</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item"><span><?= $pageName ?></span></li>
                                        <li class="no-breadcrumb-item"><span><?= $pageName ?> 등록</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header no-card-header--detail">
                                <h2 class="no-card-title"><?=$pageName?> 등록</h2>
                            </div>

                            <div class="no-card-body no-admin-column no-admin-column--detail">


                                <!-- 1차 카테고리 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="category_primary">1차 카테고리</label></h3>
                                    <div class="no-admin-content">
                                        <select name="category_primary" id="category_primary" required>
                                            <option value="">1차 카테고리 선택</option>
                                            <?php foreach ($nonpay_primary_categories as $key => $label): ?>
                                            <option value="<?= $key ?>"><?= htmlspecialchars($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 2차 카테고리 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="category_secondary">2차 카테고리</label></h3>
                                    <div class="no-admin-content">
                                        <!-- category_secondary -->
                                        <select name="category_secondary" id="category_secondary"
                                            data-selected="<?= $item['category_secondary'] ?? '' ?>" required>
                                            <option value="">2차 카테고리 선택</option>

                                        </select>
                                    </div>
                                </div>

                                <!-- 항목명 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="title">항목명</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="title" name="title" placeholder="예: 비타민 주사, 도수치료 등"
                                            required>
                                    </div>
                                </div>

                                <!-- 비용 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="cost">비용 (원)</label></h3>
                                    <div class="no-admin-content">
                                        <input type="number" id="cost" name="cost" min="0" placeholder="예: 30000"
                                            required>
                                    </div>
                                </div>

                                <!-- 정렬 순서 -->
                                <!--
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="sort_no">정렬 순서</label></h3>
                                    <div class="no-admin-content">
                                        <input type="number" id="sort_no" name="sort_no" placeholder="작을수록 위에 노출됩니다"
                                            value="0">
                                        <div class="no-admin-desc" style="margin-top: 5px; color: #888;">
                                            같은 카테고리 내에서 순서를 지정합니다 (낮을수록 위에 표시됨).
                                        </div>
                                    </div>
                                </div>-->

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($is_active as $value => $label): 
                                                $current_value = 1;
                                            ?>
                                            <?php
                                                $id = 'active_' . $value;
                                                $checked = ($current_value == $value) ? 'checked' : '';
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
                                    <button type="submit" class="no-btn no-btn--big no-btn--main"
                                        id="submitBtn">저장</button>
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