<?php
include_once "../../../inc/lib/base.class.php";

try {
    $db = DB::getInstance(); 
} catch (Exception $e) {
    echo "데이터베이스 연결 오류: " . $e->getMessage();
    exit;
}

$pageName = "계정";
$depthnum = 8;

include_once "../../inc/admin.title.php";
include_once "../../inc/admin.css.php";
include_once "../../inc/admin.js.php";
?>

</head>

<body data-page="account">
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>

        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form id="frm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="mode" value="save">

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
                                <h2 class="no-card-title">신규 계정 등록</h2>
                            </div>

                            <div class="no-card-body no-admin-column no-admin-column--detail">



                                <!-- 권한 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">권한</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($admin_roles as $id => $info): ?>
                                            <label for="role<?= $id ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="role_id" id="role<?= $id ?>"
                                                        value="<?= $id ?>" <?= $id === 3 ? 'checked' : '' ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span
                                                    class="no-radio-text"><?= htmlspecialchars($info['name']) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="uid">아이디</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" name="uid" id="uid" class="no-input--detail"
                                            placeholder="아이디를 입력하세요" required minlength="4" maxlength="20"
                                            pattern="^[a-zA-Z0-9_]+$" title="영문, 숫자, 언더바(_)만 허용하며 4~20자까지 가능합니다.">
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="upwd">비밀번호</label></h3>
                                    <div class="no-admin-content">
                                        <input type="password" name="upwd" id="upwd" class="no-input--detail"
                                            placeholder="비밀번호를 입력하세요" required minlength="6" maxlength="30"
                                            title="6자 이상 입력해주세요.">
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="uname">이름</label></h3>
                                    <div class="no-admin-content">
                                        <input type="text" name="uname" id="uname" class="no-input--detail"
                                            placeholder="이름을 입력하세요" required maxlength="20" pattern="^[가-힣a-zA-Z\s]+$"
                                            title="한글 또는 영문만 입력 가능합니다.">
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="email">이메일</label></h3>
                                    <div class="no-admin-content">
                                        <input type="email" name="email" id="email" class="no-input--detail"
                                            placeholder="예: admin@example.com" required>
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="phone">휴대폰</label></h3>
                                    <div class="no-admin-content">
                                        <input type="tel" name="phone" id="phone" class="no-input--detail"
                                            data-phone="true" placeholder="숫자만 입력 (예: 01012345678)"
                                            pattern="^01[016789][0-9]{7,8}$"
                                            title="올바른 휴대폰 번호를 입력해주세요. (예: 01012345678)">
                                    </div>
                                </div>

                                <div class="no-admin-block">
                                    <h3 class="no-admin-title"><label for="active_status">상태</label></h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <label for="activeY">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="active_status" id="activeY" value="Y"
                                                        checked>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text">활성</span>
                                            </label>
                                            <label for="activeN">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="active_status" id="activeN" value="N">
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text">비활성</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="no-items-center center">
                                    <a href="./index.php" class="no-btn no-btn--big no-btn--normal">목록</a>
                                    <button type="button" class="no-btn no-btn--big no-btn--main"
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