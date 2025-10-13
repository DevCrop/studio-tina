<?php
    include_once "../../../inc/lib/base.class.php";

    $pageName = "기타";
    $depthnum = 12;

    $db = DB::getInstance();

    // nb_etcs 테이블에서 단일 행 조회
    $sql = "SELECT non_pay_last_modified, banner_rolling_times FROM nb_etcs LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    include_once "../../inc/admin.title.php";
    include_once "../../inc/admin.css.php";
    include_once "../../inc/admin.js.php";
?>

</head>

<body data-page="etc">
    <div class="no-wrap">
        <!-- Header -->
        <?php 
        include_once "../../inc/admin.header.php";
        ?>

        <!-- Main -->
        <main class="no-app no-container">
            <!-- Drawer -->
            <?php
                include_once "../../inc/admin.drawer.php";
            ?>

            <!-- Contents -->
            <form id="frm" name="frm" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="mode" name="mode" value="update">
                <section class="no-content">
                    <!-- Page Title -->
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?=$pageName?> 관리</h1>
                                <div class="no-breadcrumb-container">
                                    <ul class="no-breadcrumb-list">
                                    </ul>
                                </div>
                            </div>
                            <!-- page indicator -->
                        </div>
                    </div>

                    <!-- card-title -->
                    <div class="no-toolbar-container">
                        <div class="no-card">
                            <div class="no-card-header no-card-header--detail">
                                <h2 class="no-card-title"><?=$pageName?> 설정</h2>
                            </div>
                            <div class="no-card-body no-admin-column no-admin-column--detail">

                                <!-- 비급여 항목 최종 수정일 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">
                                        <label for="non_pay_last_modified">비급여 항목 최종 수정일</label>
                                    </h3>
                                    <div class="no-admin-content">
                                        <input type="text" name="non_pay_last_modified" id="non_pay_last_modified"
                                            class="no-input--detail" placeholder='예: 1="4",2="6",3="8"'
                                            value="<?= htmlspecialchars($row['non_pay_last_modified']) ?>" />
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i>
                                            비급여 항목 최종 수정일을 입력해주세요.
                                        </span>
                                    </div>
                                </div>

                                <!-- 배너 롤링 시간 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">배너 롤링 시간</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <?php foreach ($banner_rollingtimes as $key => $time): ?>
                                            <label for="rolling<?= $key ?>">
                                                <div class="no-radio-box">
                                                    <input type="radio" name="banner_rolling_times"
                                                        id="rolling<?= $key ?>" value="<?= $time ?>"
                                                        <?= (string)$row['banner_rolling_times'] === (string)$time ? 'checked' : '' ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text"><?= $time ?>초</span>
                                            </label>
                                            <?php endforeach; ?>

                                        </div>
                                        <span class="no-admin-info">
                                            <i class="bx bxs-info-circle"></i>
                                            모든 배너에 적용되는 롤링 시간입니다.
                                        </span>
                                    </div>
                                </div>

                                <div class="no-items-center center">
                                    <button type="submit" class="no-btn no-btn--big no-btn--main"
                                        id="editBtn">수정</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </main>

        <!-- Footer -->
        <?php
            include_once "../../inc/admin.footer.php";
        ?>

    </div>
</body>

</html>