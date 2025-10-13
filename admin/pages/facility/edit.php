<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "시설";
$depthnum = 5;

try {
    $db = DB::getInstance();

    $stmt = $db->query("SELECT id, name_kr FROM nb_branches WHERE id IN (2, 3, 4) ORDER BY id ASC");
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("잘못된 접근입니다.");
    }

    $id = intval($_GET['id']);
    $stmt = $db->prepare("SELECT * FROM nb_facilities WHERE id = ?");
    $stmt->execute([$id]);
    $facility = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$facility) {
        throw new Exception("해당 시설 정보를 찾을 수 없습니다.");
    }

} catch (Exception $e) {
    echo "오류: " . $e->getMessage();
    exit;
}

include_once "../../inc/admin.title.php";
include_once "../../inc/admin.css.php";
include_once "../../inc/admin.js.php";
?>
</head>

<body data-page="facility">
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>
        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form id="frm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="mode" value="update">
                <input type="hidden" name="id" value="<?= $facility['id'] ?>">
				<input type="hidden" name="sort_no" value="<?= $facility['sort_no'] ?>">

                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title">시설 수정</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item"><span>시설</span></li>
                                        <li class="no-breadcrumb-item"><span>시설 수정</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header no-card-header--detail">
                                <h2 class="no-card-title">시설 수정</h2>
                            </div>

                            <div class="no-card-body no-admin-column no-admin-column--detail">

                                <!-- 지점 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="branch_category">지점</label></h3>
                                    <div class="no-admin-content">
                                        <select name="branch_id" id="branch_category" required>
                                            <option value="">지점 선택</option>
                                            <?php foreach ($branches as $branch): ?>
                                            <option value="<?= $branch['id'] ?>"
                                                <?= ($facility['branch_id'] == $branch['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($branch['name_kr']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- 카테고리 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="categories">카테고리</label></h3>
                                    <div class="no-admin-content">
                                        <select name="categories" id="categories" required>
                                            <option value="">카테고리 선택</option>
                                            <?php foreach ($facilities as $key => $label): ?>
                                            <option value="<?= $key ?>"
                                                <?= ($facility['categories'] ?? '') == $key ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($label) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 이름 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="title">이름</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="title" name="title"
                                            value="<?= htmlspecialchars($facility['title']) ?>" required>
                                    </div>
                                </div>

                                <!-- 썸네일 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="thumb_image">썸네일 파일</label></h3>
                                    <div class="no-admin-content">
                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fakeThumbFileTxt"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="thumb_image" id="thumb_image" accept="image/*"
                                                    onchange="previewImage(this, 'thumbPreview', 'fakeThumbFileTxt')" />
                                                <button type="button" class="no-btn no-btn--main">파일찾기</button>
                                            </div>
                                        </div>
                                        <div class="no-image-preview">
                                            <?php if (!empty($facility['thumb_image'])): ?>
                                            <img id="thumbPreview"
                                                src="/uploads/facilities/<?= $facility['thumb_image'] ?>" alt="썸네일 미리보기"
                                                style="max-width:150px; margin-top:10px;">
                                            <?php else: ?>
                                            <img id="thumbPreview" src="" alt="썸네일 미리보기"
                                                style="display:none; max-width:150px; margin-top:10px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- 정렬 순서 -->
                                <!----
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="sort_no">정렬 순서</label></h3>
                                    <div class="no-admin-content">
                                        <input type="number" id="sort_no" name="sort_no"
                                            value="<?= $facility['sort_no'] ?>">
                                    </div>
                                </div>-->

                                <!-- 노출 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($is_active as $value => $label): 
                                            $id = "active_$value";
                                            $checked = ($facility['is_active'] == $value) ? 'checked' : '';
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
                                    <?php if($role->canDelete()):?>
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