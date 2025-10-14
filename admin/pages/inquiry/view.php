<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "문의 상세";
$depthnum = 7;
$pagenum = 0; 

try {
    $db = DB::getInstance(); 
} catch (Exception $e) {
    echo "DB 연결 오류: " . $e->getMessage();
    exit;
}

$no = $_GET['no'] ?? null;

if (!$no) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

// 데이터 조회
$stmt = $db->prepare("SELECT * FROM nb_request WHERE no = :no");
$stmt->execute([':no' => $no]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "<script>alert('해당 문의를 찾을 수 없습니다.'); history.back();</script>";
    exit;
}

?>

<?php include_once "../../inc/admin.head.php"; ?>

<body>
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>

        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <section class="no-content">
                <div class="no-toolbar">
                    <div class="no-toolbar-container no-flex-stack">
                        <div class="no-page-indicator">
                            <h1 class="no-page-title"><?= $pageName ?></h1>
                        </div>
                    </div>
                </div>

                <div class="no-toolbar-container">
                    <div class="no-card">
                        <div class="no-card-header no-card-header--detail">
                            <h2 class="no-card-title"><?= $pageName ?></h2>
                        </div>

                        <div class="no-card-body no-admin-column no-admin-column--detail">

                            <!-- 이름 -->
                            <div class="no-admin-block">
                                <h3 class="no-admin-title">이름</h3>
                                <div class="no-admin-content">
                                    <input type="text" value="<?= htmlspecialchars($data['name']) ?>" readonly>
                                </div>
                            </div>

                            <!-- 회사명 -->
                            <div class="no-admin-block">
                                <h3 class="no-admin-title">회사명</h3>
                                <div class="no-admin-content">
                                    <input type="text" value="<?= htmlspecialchars($data['company']) ?>" readonly>
                                </div>
                            </div>

                            <!-- 연락처 -->
                            <div class="no-admin-block">
                                <h3 class="no-admin-title">연락처</h3>
                                <div class="no-admin-content">
                                    <input type="text" value="<?= htmlspecialchars($data['phone']) ?>" readonly>
                                </div>
                            </div>

                            <!-- 이메일 -->
                            <div class="no-admin-block">
                                <h3 class="no-admin-title">이메일</h3>
                                <div class="no-admin-content">
                                    <input type="text" value="<?= htmlspecialchars($data['email']) ?>" readonly>
                                </div>
                            </div>

                            <!-- 문의 내용 -->
                            <div class="no-admin-block">
                                <h3 class="no-admin-title">문의 내용</h3>
                                <div class="no-admin-content">
                                    <textarea rows="5" readonly><?= htmlspecialchars($data['contents']) ?></textarea>
                                </div>
                            </div>

                            <!-- 등록일 -->
                            <div class="no-admin-block">
                                <h3 class="no-admin-title">등록일</h3>
                                <div class="no-admin-content">
                                    <input type="text" readonly value="<?= $data['regdate'] ?>">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- 버튼 -->
                    <div class="no-items-center center">
                        <a href="./index.php" class="no-btn no-btn--big no-btn--normal">목록</a>
                    </div>
                </div>
            </section>
        </main>
        <?php include_once "../../inc/admin.footer.php"; ?>
    </div>
</body>

</html>