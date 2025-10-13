<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "의료진";
$depthnum = 5;

try {
    $db = DB::getInstance();

    $stmt = $db->query("SELECT id, name_kr FROM nb_branches WHERE id IN (2, 3, 4) ORDER BY id ASC");
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 수정 대상 ID 받기
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("잘못된 접근입니다.");
    }

    $id = intval($_GET['id']);
    $stmt = $db->prepare("SELECT * FROM nb_doctors WHERE id = ?");
    $stmt->execute([$id]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$doctor) {
        throw new Exception("해당 의료진 정보를 찾을 수 없습니다.");
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

<body data-page="doctor">
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>
        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form id="frm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="mode" value="update">
                <input type="hidden" name="id" value="<?= $doctor['id'] ?>">
				<input type="hidden" name="sort_no" value="<?= $doctor['sort_no'] ?>">

                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?= $pageName ?> 수정</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                        <li class="no-breadcrumb-item"><span><?= $pageName ?></span></li>
                                        <li class="no-breadcrumb-item"><span><?= $pageName ?> 수정</span></li>
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

                                <!-- 지점 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="branch_category">지점</label></h3>
                                    <div class="no-admin-content">
                                        <select name="branch_id" id="branch_category" required>
                                            <option value="">지점 선택</option>
                                            <?php foreach ($branches as $branch): ?>
                                            <option value="<?= $branch['id'] ?>"
                                                <?= ($doctor['branch_id'] == $branch['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($branch['name_kr']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 대표원장 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">대표원장 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php
                                                foreach ($is_ceo_options as $value => $label):
                                                    $id = "is_ceo_$value";
                                                    $checked = ($doctor['is_ceo'] ?? 2) == $value ? 'checked' : '';
                                            ?>
                                            <label for="<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="is_ceo" id="<?= $id ?>"
                                                        value="<?= $value ?>" <?= $checked ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text"><?= htmlspecialchars($label) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>




                                <!-- 이름 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="title">이름</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="title" name="title"
                                            value="<?= htmlspecialchars($doctor['title']) ?>" required>
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
                                        <?php if (!empty($doctor['thumb_image'])): ?>
                                        <div class="no-image-preview">
                                            <img id="thumbPreview" src="/uploads/doctors/<?= $doctor['thumb_image'] ?>"
                                                alt="썸네일 미리보기" style="max-width:150px; margin-top:10px;">
                                        </div>
                                        <?php else: ?>
                                        <div class="no-image-preview">
                                            <img id="thumbPreview" src="" alt="썸네일 미리보기"
                                                style="display:none; max-width:150px; margin-top:10px;">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- 내부 이미지 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="detail_image">내부 이미지</label></h3>
                                    <div class="no-admin-content">
                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fakeDetailFileTxt"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="detail_image" id="detail_image"
                                                    accept="image/*"
                                                    onchange="previewImage(this, 'detailPreview', 'fakeDetailFileTxt')" />
                                                <button type="button" class="no-btn no-btn--main">파일찾기</button>
                                            </div>
                                        </div>
                                        <?php if (!empty($doctor['detail_image'])): ?>
                                        <div class="no-image-preview">
                                            <img id="detailPreview"
                                                src="/uploads/doctors/<?= $doctor['detail_image'] ?>" alt="내부 이미지 미리보기"
                                                style="max-width:150px; margin-top:10px;">
                                        </div>
                                        <?php else: ?>
                                        <div class="no-image-preview">
                                            <img id="detailPreview" src="" alt="내부 이미지 미리보기"
                                                style="display:none; max-width:150px; margin-top:10px;">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- 직급 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="position">직급</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="position" name="position"
                                            value="<?= htmlspecialchars($doctor['position']) ?>">
                                    </div>
                                </div>

                                <!-- 부서 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="department">부서</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="department" name="department"
                                            value="<?= htmlspecialchars($doctor['department']) ?>">
                                    </div>
                                </div>

                                <!-- 키워드 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="keywords">키워드</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="keywords" name="keywords"
                                            value="<?= htmlspecialchars($doctor['keywords']) ?>">
                                    </div>
                                </div>

                                <!-- 경력 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="career">경력</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="career" id="career"
                                            rows="4"><?= htmlspecialchars($doctor['career']) ?></textarea>
                                    </div>
                                </div>

                                <!-- 활동 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="activity">활동</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="activity" id="activity"
                                            rows="4"><?= htmlspecialchars($doctor['activity']) ?></textarea>
                                    </div>
                                </div>

                                <!-- 학력 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="education">학력</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="education" id="education"
                                            rows="4"><?= htmlspecialchars($doctor['education']) ?></textarea>
                                    </div>
                                </div>


                                <!-- 저서 및 논문 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="publications">저서 및 논문</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="publications" id="publications"
                                            rows="4"><?= htmlspecialchars($doctor['publications']) ?></textarea>
                                    </div>
                                </div>

                                <!-- 저서 노출 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">저서 및 논문 노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($publication_visible as $value => $label): 
                                                $id = "pub_visible_$value";
                                                $checked = ($doctor['publication_visible'] == $value) ? 'checked' : '';
                                            ?>
                                            <label for="<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="publication_visible" id="<?= $id ?>"
                                                        value="<?= $value ?>" <?= $checked ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text"><?= htmlspecialchars($label) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>



                                <!-- 정렬 순서 -->
                                <!--
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="sort_no">정렬 순서</label></h3>
                                    <div class="no-admin-content">
                                        <input type="number" id="sort_no" name="sort_no"
                                            value="<?= $doctor['sort_no'] ?>">
                                    </div>
                                </div> -->

                                <!-- 노출 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($is_active as $value => $label): 
                                                $id = "active_$value";
                                                $checked = ($doctor['is_active'] == $value) ? 'checked' : '';
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