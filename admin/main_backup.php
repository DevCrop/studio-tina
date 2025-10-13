<?php
include_once "../inc/lib/base.class.php";

$pageName = "대시 보드";
$depthnum = 1;

$db = DB::getInstance();

// 최근 7일 기준 날짜
$sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));

// 간편 문의
$simpleSql = "
    SELECT id, name, phone, consult_time, created_at
    FROM nb_simple_inquiries
    WHERE created_at >= :sevenDaysAgo
    ORDER BY id DESC
    LIMIT 10
";
$simpleStmt = $db->prepare($simpleSql);
$simpleStmt->bindValue(':sevenDaysAgo', $sevenDaysAgo);
$simpleStmt->execute();
$simpleInquiries = $simpleStmt->fetchAll(PDO::FETCH_ASSOC);

// 공진단 · 한약 문의
$herbSql = "
    SELECT id, name, phone, consult_time, created_at
    FROM nb_herb_inquiries
    WHERE created_at >= :sevenDaysAgo
    ORDER BY id DESC
    LIMIT 10
";
$herbStmt = $db->prepare($herbSql);
$herbStmt->bindValue(':sevenDaysAgo', $sevenDaysAgo);
$herbStmt->execute();
$herbInquiries = $herbStmt->fetchAll(PDO::FETCH_ASSOC);

// 개인맞춤 한약 문의
$customSql = "
    SELECT id, name, phone, consult_time, created_at
    FROM nb_custom_inquires
    WHERE created_at >= :sevenDaysAgo
    ORDER BY id DESC
    LIMIT 10
";
$customStmt = $db->prepare($customSql);
$customStmt->bindValue(':sevenDaysAgo', $sevenDaysAgo);
$customStmt->execute();
$customInquiries = $customStmt->fetchAll(PDO::FETCH_ASSOC);


?>




<!--=====================HEAD========================= -->
<?php include_once "inc/admin.head.php"; ?>

<body data-page="inquiry">
    <div class="no-wrap">

        <!--=====================HEADER========================= -->
        <?php include_once "inc/admin.header.php"; ?>

        <main class="no-app no-container">

            <!--=====================DRAWER========================= -->
            <?php include_once "inc/admin.drawer.php"; ?>

            <form method="GET" name="frm" id="frm" autocomplete="off">
                <input type="hidden" name="mode" id="mode" value="list">

                <section class="no-content">
                    <div class="no-toolbar">
                        <div class="no-toolbar-container no-flex-stack">
                            <div class="no-page-indicator">
                                <h1 class="no-page-title"><?=$pageName?> </h1>

                            </div>
                        </div>
                    </div>

                    <div class="no-content-container">
                        <ul class="no-admin-grid--3">
                            <!-- 간편 문의 -->
                            <li class="">
                                <div class="no-card">
                                    <div class="no-card-header">
                                        <h2 class="no-card-title">간편 문의</h2>
                                        <a href="/admin/pages/inquiry/simple.php" class="btn-link">관리 바로가기 →</a>
                                    </div>
                                    <div class="no-card-body">
                                        <div class="no-table-responsive">
                                            <table class="no-table">
                                                <thead>
                                                    <tr>
                                                        <th>이름</th>
                                                        <th>연락처</th>
                                                        <th>상담 시간</th>
                                                        <th>관리</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (count($simpleInquiries) > 0): ?>
                                                    <?php foreach ($simpleInquiries as $row): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                                        <td><?= $consult_time_options[$row['consult_time']] ?? '미정' ?>
                                                        </td>
                                                        <td>
                                                            <div class="no-table-role">
                                                                <span class="no-role-btn"><i
                                                                        class="bx bx-dots-vertical-rounded"></i></span>
                                                                <div class="no-table-action">
                                                                    <a href="/admin/pages/inquiry/simple.view.php?id=<?=$row['id']?>"
                                                                        class="no-btn no-btn--sm no-btn--normal">보기</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" style="text-align:center;">최근 들어온 데이터가 없습니다.
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <!-- 공진단 · 한약 문의 -->
                            <li class="">
                                <div class="no-card">
                                    <div class="no-card-header">
                                        <h2 class="no-card-title"> 공진단 · 한약 문의</h2>
                                        <a href="/admin/pages/inquiry/herb.php" class="btn-link">관리 바로가기 →</a>
                                    </div>
                                    <div class="no-card-body">
                                        <div class="no-table-responsive">
                                            <table class="no-table">
                                                <thead>
                                                    <tr>
                                                        <th>이름</th>
                                                        <th>연락처</th>
                                                        <th>상담 시간</th>
                                                        <th>관리</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (count($herbInquiries) > 0): ?>
                                                    <?php foreach ($herbInquiries as $row): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                                        <td><?= $consult_time_options[$row['consult_time']] ?? '미정' ?>
                                                        </td>
                                                        <td>
                                                            <div class="no-table-role">
                                                                <span class="no-role-btn"><i
                                                                        class="bx bx-dots-vertical-rounded"></i></span>
                                                                <div class="no-table-action">
                                                                    <a href="/admin/pages/inquiry/herb.view.php?id=<?=$row['id']?>"
                                                                        class="no-btn no-btn--sm no-btn--normal">보기</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" style="text-align:center;">최근 들어온 데이터가 없습니다.
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <!-- 개인맞춤 한약 문의 -->
                            <li class="">
                                <div class="no-card">
                                    <div class="no-card-header">
                                        <h2 class="no-card-title">개인맞춤 한약 문의</h2>
                                        <a href="/admin/pages/inquiry/prescription.php" class="btn-link">관리 바로가기 →</a>
                                    </div>
                                    <div class="no-card-body">
                                        <div class="no-table-responsive">
                                            <table class="no-table">
                                                <thead>
                                                    <tr>
                                                        <th>이름</th>
                                                        <th>연락처</th>
                                                        <th>상담 시간</th>
                                                        <th>관리</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (count($customInquiries) > 0): ?>
                                                    <?php foreach ($customInquiries as $row): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                                        <td><?= $consult_time_options[$row['consult_time']] ?? '미정' ?>
                                                        </td>
                                                        <td>
                                                            <div class="no-table-role">
                                                                <span class="no-role-btn"><i
                                                                        class="bx bx-dots-vertical-rounded"></i></span>
                                                                <div class="no-table-action">
                                                                    <a href="/admin/pages/inquiry/prescription.view.php?id=<?=$row['id']?>"
                                                                        class="no-btn no-btn--sm no-btn--normal">보기</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" style="text-align:center;">최근 들어온 데이터가 없습니다.
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </li>


                        </ul>

                        <div class="no-admmin-link--card">
                            <ul class="no-admin-grid--4">
                                <!-- 1. 페이지별 SEO 관리 -->
                                <li class="no-dashboard-item">
                                    <div class="no-dashboard-title">
                                        <div class="no-dashboard-icon">
                                            <i class="fa-regular fa-globe"></i>
                                        </div>
                                        <h3>페이지별 SEO 관리</h3>
                                    </div>
                                    <p>페이지별 메타태그, 제목, 설명 등을 설정할 수 있습니다.</p>
                                    <a href="/admin/pages/setting/seo.php" class="btn-link">관리 바로가기 →</a>
                                </li>

                                <!-- 2. 의료진 관리 -->
                                <li class="no-dashboard-item">
                                    <div class="no-dashboard-title">
                                        <div class="no-dashboard-icon">
                                            <i class="fa-solid fa-user-doctor"></i>
                                        </div>
                                        <h3>의료진 관리</h3>
                                    </div>
                                    <p>병원 의료진 정보를 등록하거나 수정할 수 있습니다.</p>
                                    <a href="/admin/pages/doctor" class="btn-link">관리 바로가기 →</a>
                                </li>

                                <!-- 3. 배너 관리 -->
                                <li class="no-dashboard-item">
                                    <div class="no-dashboard-title">
                                        <div class="no-dashboard-icon">
                                            <i class="fa-solid fa-flag-pennant"></i>
                                        </div>
                                        <h3>배너 관리</h3>
                                    </div>
                                    <p>홈페이지 상단/하단 등 위치에 출력되는 배너를 설정합니다.</p>
                                    <a href="/admin/pages/design/banner.list.php" class="btn-link">관리 바로가기 →</a>
                                </li>

                                <!-- 4. 팝업 관리 -->
                                <li class="no-dashboard-item">
                                    <div class="no-dashboard-title">
                                        <div class="no-dashboard-icon">
                                            <i class="fa-solid fa-browsers"></i>
                                        </div>
                                        <h3>팝업 관리</h3>
                                    </div>
                                    <p>공지사항, 이벤트 등의 팝업을 등록하고 노출을 설정합니다.</p>
                                    <a href="/admin/pages/design/popup.list.php" class="btn-link">관리 바로가기 →</a>
                                </li>

                            </ul>

                        </div>
                    </div>
                </section>
            </form>
        </main>
    </div>