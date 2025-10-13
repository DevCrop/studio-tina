<?php
include_once "../../../inc/lib/base.class.php";

$pageName = "간편 문의 상세";
$depthnum = 11;
$pagenum = 1; 

try {
    $db = DB::getInstance(); 
} catch (Exception $e) {
    echo "DB 연결 오류: " . $e->getMessage();
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit;
}

// 데이터 조회
$stmt = $db->prepare("SELECT * FROM nb_simple_inquiries WHERE id = :id");
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "<script>alert('해당 문의를 찾을 수 없습니다.'); history.back();</script>";
    exit;
}

// 지점 목록
$stmt = $db->query("SELECT id, name_kr FROM nb_branches ORDER BY id ASC");
$branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include_once "../../inc/admin.head.php"; ?>

<body data-page="simple">
    <div class="no-wrap">
        <?php include_once "../../inc/admin.header.php"; ?>

        <main class="no-app no-container">
            <?php include_once "../../inc/admin.drawer.php"; ?>

            <form id="frm" method="post">
				<input type="hidden" name="id" value="<?=$_GET['id']?>">
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

                                <!-- 지점 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">지점</h3>
                                    <div class="no-admin-content">
                                        <select disabled id="branch_id">
                                            <?php foreach ($branches as $branch): ?>
                                            <option <?= ($data['branch_id'] == $branch['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($branch['name_kr']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 이름 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">이름</h3>
                                    <div class="no-admin-content">
                                        <input type="text" value="<?= htmlspecialchars($data['name']) ?>" readonly>
                                    </div>
                                </div>

                                <!-- 연락처 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">연락처</h3>
                                    <div class="no-admin-content">
                                        <input type="text" value="<?= htmlspecialchars($data['phone']) ?>" readonly>
                                    </div>
                                </div>

                                <!-- 상담 시간 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">상담 가능 시간</h3>
                                    <div class="no-admin-content">
                                        <input type="text"
                                            value="<?= $consult_time_options[$data['consult_time']] ?? '미선택' ?>"
                                            readonly>
                                    </div>
                                </div>

                                <!-- 희망 진료 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">희망 진료 항목</h3>
                                    <div class="no-admin-content">
                                        <input type="text"
                                            value="<?= $hope_treatments[$data['hope_treatment']] ?? '미선택' ?>" readonly>
                                    </div>
                                </div>

                                <!-- 문의 내용 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">문의 내용</h3>
                                    <div class="no-admin-content">
                                        <textarea rows="5"
                                            readonly><?= htmlspecialchars($data['contents']) ?></textarea>
                                    </div>
                                </div>

                                <!-- 개인정보 동의 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">개인정보 수집 동의</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <label>
                                                <div class="no-radio-box">
                                                    <input type="radio" name="private_check" value="1" disabled
                                                        <?= $data['private_check'] ? 'checked' : '' ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text">동의</span>
                                            </label>
                                            <label>
                                                <div class="no-radio-box">
                                                    <input type="radio" name="private_check" value="0" disabled
                                                        <?= !$data['private_check'] ? 'checked' : '' ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text">비동의</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 마케팅 동의 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">마케팅 수신 동의</h3>
                                    <div class="no-admin-content">
                                        <div class="no-radio-form no-list">
                                            <label>
                                                <div class="no-radio-box">
                                                    <input type="radio" name="marketing_check" value="1" disabled
                                                        <?= $data['marketing_check'] ? 'checked' : '' ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text">동의</span>
                                            </label>
                                            <label>
                                                <div class="no-radio-box">
                                                    <input type="radio" name="marketing_check" value="0" disabled
                                                        <?= !$data['marketing_check'] ? 'checked' : '' ?>>
                                                    <span><i class="bx bx-radio-circle-marked"></i></span>
                                                </div>
                                                <span class="no-radio-text">비동의</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 등록일 -->
                                <div class="no-admin-block">
                                    <h3 class="no-admin-title">등록일</h3>
                                    <div class="no-admin-content">
                                        <input type="text" readonly value="<?= $data['created_at'] ?>">
                                    </div>
                                </div>

                            </div>
                        </div>

						<div class="no-card">
							<div class="no-card-header no-card-header--detail">
								<h2 class="no-card-title">상담 확인 여부</h2>
							</div>
                            <div class="no-card-body no-admin-column no-admin-column--detail">
								<div class="no-admin-block">
									<h3 class="no-admin-title">상담 확인 여부</h3>
									<div class="no-admin-content">
										<div class="no-radio-form no-list">
											<?php foreach ($is_confirmed as $key => $label): ?>
												<label>
													<div class="no-radio-box">
														<input type="radio" name="is_confirmed" value="<?= $key ?>"
															   <?= ($data['is_confirmed'] == $key) ? 'checked' : '' ?>>
														<span><i class="bx bx-radio-circle-marked"></i></span>
													</div>
													<span class="no-radio-text"><?= $label ?></span>
												</label>
											<?php endforeach; ?>
										</div>
									</div>
								</div>

							  <!-- 확인자 -->
								<div class="no-admin-block" id="confirm_by_block">
								  <h3 class="no-admin-title">확인자</h3>
								  <div class="no-admin-content">
									<input type="text" name="confirm_by" value="<?= htmlspecialchars($data['confirm_by'] ?? '') ?>">
								  </div>
								</div>

								<!-- 확인 메모 -->
								<div class="no-admin-block" id="confirm_note_block">
								  <h3 class="no-admin-title">확인 메모</h3>
								  <div class="no-admin-content">
									<textarea name="confirm_note" rows="3" id="confirm_note"><?= htmlspecialchars($data['confirm_note'] ?? '') ?></textarea>
								  </div>
								</div>
								
								<!-- 버튼 -->
								<div class="no-items-center center">
                                    <a href="./simple.php" class="no-btn no-btn--big no-btn--normal">목록</a>
                                    <button type="submit" class="no-btn no-btn--big no-btn--main" id="submitBtn">저장</button>
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