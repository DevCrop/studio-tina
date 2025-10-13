<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "팝업";
$depthnum = 4;
$pagenum = 2;

try {
    $db = DB::getInstance(); 

} catch (Exception $e) {
    echo "DB 오류: " . $e->getMessage();
    exit;
}

include_once "../../inc/admin.title.php";
include_once "../../inc/admin.css.php";
include_once "../../inc/admin.js.php";
?>

</head>

<body data-page="popup">
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

                                <!-- 팝업 타입 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="popup_type">팝업 위치</label></h3>
                                    <div class="no-admin-content">
                                        <select name="popup_type" id="popup_type" required>
                                            <option value="">선택</option>
                                            <?php foreach ($popup_types as $key => $label): ?>
                                            <option value="<?= $key ?>"><?= htmlspecialchars($label) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 무기한 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">노출 설정</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($is_unlimited as $value => $label): 
                                                $id = "unlimited_$value";
                                                $checked = ($value == 1) ? 'checked' : ''; 
                                            ?>
                                            <label for="<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="is_unlimited" id="<?= $id ?>"
                                                        value="<?= $value ?>" <?= $checked ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text"><?= htmlspecialchars($label) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>


                                <!-- 노출 기간 -->
                                <div class="no-admin-block" id="display_period">
                                    <h3 class="no-admin-title">노출 기간</h3>
                                    <div class="no-admin-content no-admin-date">
                                        <input type="text" name="start_at" id="start_at"
                                            value="<?php echo isset($start_at) ? htmlspecialchars($start_at) : ''; ?>" />
                                        <span></span>
                                        <input type="text" name="end_at" id="end_at"
                                            value="<?php echo isset($end_at) ? htmlspecialchars($end_at) : ''; ?>" />
                                    </div>
                                </div>


                                <!-- 제목 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="title">제목</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" id="title" name="title" required>
                                    </div>
                                </div>

                                <!-- 설명글 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="description">설명</label></h3>
                                    <div class="no-admin-content">
                                        <textarea name="description" id="description" rows="4"></textarea>
                                    </div>
                                </div>

                                <!-- 링크 여부 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">링크 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($has_link as $value => $label): 
                                                $id = "link_$value";
                                                $checked = ($value == 2) ? 'checked' : '';
                                            ?>
                                            <label for="<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="has_link" id="<?= $id ?>"
                                                        value="<?= $value ?>" <?= $checked ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text"><?= htmlspecialchars($label) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- 새창 여부 -->
                                <div class="no-admin-block" id="link_target_block">
                                    <!-- <-- 여기에 id 추가 -->
                                    <h3 class="no-admin-title">새창 여부</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($link_targets as $value => $info): 
                                                $current_target = isset($popup['is_target']) ? (int)$popup['is_target'] : 1;
                                                $id = "target_$value";
                                                $checked = ($current_target === $value) ? 'checked' : '';
                                            ?>
                                            <label for="<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="is_target" id="<?= $id ?>"
                                                        value="<?= $value ?>" <?= $checked ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span
                                                    class="no-radio-text"><?= htmlspecialchars($info['label']) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>


                                <!-- 링크 URL -->
                                <div class="no-admin-block" id="link_url_block">
                                    <h3 class="no-admin-title"><label for="link_url">링크 URL</label></h3>
                                    <div class="no-admin-content">
                                        <input type="url" id="link_url" name="link_url"
                                            placeholder="http:// 또는 https://">
                                    </div>
                                </div>

                                <!-- 팝업 이미지 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="popup_image">팝업 이미지</label></h3>
                                    <div class="no-admin-content">
                                        <div class="no-file-control">
                                            <input type="text" class="no-fake-file" id="fakePopupFileTxt"
                                                placeholder="파일을 선택해주세요." readonly disabled />
                                            <div class="no-file-box">
                                                <input type="file" name="popup_image" id="popup_image"
                                                    onchange="document.getElementById('fakePopupFileTxt').value = this.value"
                                                    accept="image/*" />
                                                <button type="button" class="no-btn no-btn--main">파일찾기</button>
                                            </div>
                                        </div>
                                        <span class="no-admin-info"><i class="bx bxs-info-circle"></i>팝업에 사용되는
                                            이미지입니다.</span>
                                    </div>
                                </div>


                                <!-- 정렬 순서 -->
                                <!--
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="sort_no">정렬 순서</label></h3>
                                    <div class="no-admin-content">
                                        <input type="number" id="sort_no" name="sort_no" value="0" min="0">
                                    </div>
                                </div>-->


                                <!-- 버튼 -->
                                <div class="no-items-center center">
                                    <a href="./popup.list.php" class="no-btn no-btn--big no-btn--normal">목록</a>
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