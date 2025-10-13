<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "의료진 ";
$depthnum = 5;

try {
    $db = DB::getInstance(); 
    $branches = [];
    $stmt = $db->query("SELECT id, name_kr FROM nb_branches WHERE id IN (2, 3, 4) ORDER BY id ASC");
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "데이터베이스 연결 오류: " . $e->getMessage();
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

                                <!-- 지점 선택 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="branch_category">지점</label></h3>
                                    <div class="no-admin-content">
                                        <select name="branch_id" id="branch_category" required>
                                            <option value="">지점 선택</option>
                                            <?php foreach ($branches as $branch): ?>
                                            <option value="<?= $branch['id'] ?>"
                                                <?= isset($branch_id) && $branch_id == $branch['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($branch['name_kr']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i> SEO를 등록할 지점을 선택하세요
                                        </span>
                                    </div>
                                </div>
                                <!-- 대표 원장 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">대표 원장 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php 
                                            foreach ($is_ceo_options as $value => $label): 
                                                $checked = ($row['is_ceo'] ?? 2) == $value ? 'checked' : '';
                                                $id = "is_ceo_$value";
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
                                        <input type="text" id="title" name="title" placeholder="예: 홍길동" required>
                                    </div>
                                </div>


                                <!-- 썸네일 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="title">썸네일 파일</label></h3>
                                    <div class="no-admin-content">
                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fakeThumbFileTxt"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="thumb_image" id="thumb_image"
                                                    onchange="document.getElementById('fakeThumbFileTxt').value = this.value" />
                                                <button type="button" class="no-btn no-btn--main">파일찾기</button>
                                            </div>
                                        </div>
                                        <span class="no-admin-info"><i class="bx bxs-info-circle"></i>썸네일 이미지입니다.</span>
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
                                                    onchange="document.getElementById('fakeDetailFileTxt').value = this.value" />
                                                <button type="button" class="no-btn no-btn--main">파일찾기</button>
                                            </div>
                                            <span class="no-admin-info"><i class="bx bxs-info-circle"></i>상세페이지에 들어가는
                                                이미지입니다.</span>

                                        </div>
                                    </div>
                                </div>


                                <!-- 직급 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="position">직급</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="position" name="position" placeholder="예: 원장, 과장 등">
                                    </div>
                                </div>


                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="department">부서</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="department" name="department" placeholder="예: 통합면역 대표원장">
                                    </div>
                                </div>

                                <!-- 키워드 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="keywords">키워드</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="keywords" name="keywords"
                                            placeholder="예: 통증, 재활, 물리치료 (콤마로 구분)">
                                    </div>
                                </div>

                                <!-- 경력 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="career">경력</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="career" id="career" rows="4" placeholder="경력 사항 입력"></textarea>
                                    </div>
                                </div>

                                <!-- 활동 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="activity">활동</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="activity" id="activity" rows="4"
                                            placeholder="활동 이력 입력"></textarea>
                                    </div>
                                </div>

                                <!-- 학력 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="education">학력</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="education" id="education" rows="4"
                                            placeholder="학력 정보 입력"></textarea>
                                    </div>
                                </div>


                                <!-- 저서 및 논문 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="publications">저서 및 논문</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="publications" id="publications" rows="4"
                                            placeholder="저서 또는 논문 목록 입력"></textarea>
                                    </div>
                                </div>

                                <!-- 저서 및 논문 노출 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">저서 및 논문 노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($publication_visible as $value => $label): 
                                                    $checked = ($value == 1) ? 'checked' : '';
                                                    $id = "pub_visible_$value";
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
                                        <input type="number" id="sort_no" name="sort_no" value="0"
                                            placeholder="낮을수록 상단에 표시됩니다">
                                    </div>
                                </div> -->

                                <!-- 노출 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">노출 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($is_active as $value => $label): 
                                                $checked = ($value == 1) ? 'checked' : '';
                                                $id = "active_$value";
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