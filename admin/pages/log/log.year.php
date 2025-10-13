<!DOCTYPE html>
<html lang="ko">
<?php
	include_once "../../../inc/lib/base.class.php";

	$pdo = DB::getInstance();
	$depthnum = 13;
	$pagenum = 4;

	include_once "../../inc/admin.title.php";
	include_once "../../inc/admin.css.php";
	include_once "../../inc/admin.js.php";
?>
</head>

<body>
	<div class="no-wrap">
		<!-- Header -->
		<?php include_once "../../inc/admin.header.php"; ?>

		<!-- Main -->
		<main class="no-app no-container">
			<!-- Drawer -->
			<?php include_once "../../inc/admin.drawer.php"; ?>

			<?php
				// ===== 연도 입력 처리 (YYYY만 허용) =====
				$sdate = $_REQUEST['sdate'] ?? '';
				if (!preg_match('/^\d{4}$/', $sdate)) {
					$sdate = date('Y');
				}
				$Select_Year = (int)$sdate;
				$curY = (string)$Select_Year;

				// 전체 총 방문자 (모든 연도 합)
				$stmt = $pdo->query("SELECT COUNT(*) FROM nb_analytics");
				$TotalAll = (int)($stmt->fetchColumn() ?: 0);

				// 선택 연도 총 방문자
				$stmt = $pdo->prepare("SELECT COUNT(*) FROM nb_analytics WHERE `year`=:y");
				$stmt->execute([':y'=>$Select_Year]);
				$YearCount = (int)($stmt->fetchColumn() ?: 0);

				// 퍼센트(전체 대비), 막대 폭/색
				$Percent  = $TotalAll ? round(($YearCount / $TotalAll) * 100, 2) : 0.00;
				$barWidth = $YearCount > 0 ? 100 : 1;
				$barColor = $YearCount > 0 ? '#0083e8' : '#ccc';
			?>

			<form id="frm" name="frm" method="post" autocomplete="off">
				<input type="hidden" id="mode" name="mode" value="">
				<section class="no-content">
					<!-- Page Title -->
					<div class="no-toolbar">
						<div class="no-toolbar-container no-flex-stack">
							<div class="no-page-indicator">
								<h1 class="no-page-title">접속통계</h1>
								<div class="no-breadcrumb-container">
									<ul class="no-breadcrumb-list">
										<li class="no-breadcrumb-item"><span>접속통계</span></li>
										<li class="no-breadcrumb-item"><span>년도별</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<!-- Search -->
					<div class="no-search no-toolbar-container">
						<div class="no-card">
							<div class="no-card-body no-admin-column">
								<div class="no-admin-block no-w-20">
									<h3 class="no-admin-title">총방문자(전체)</h3>
									<div class="no-admin-content">
										<span class="no-admin-cnt"><?= htmlspecialchars(number_format($TotalAll)) ?>명</span>
									</div>
								</div>

								<div class="no-admin-block no-w-80">
									<h3 class="no-admin-title">연도선택</h3>
									<div class="no-admin-content no-admin-date">
										<div class="no-search-wrap" style="gap:12px;display:flex;align-items:center;">
											<input
												type="number"
												name="sdate"
												id="s_date"
												value="<?= htmlspecialchars($curY) ?>"
												step="1"
												inputmode="numeric"
												pattern="\d{4}"
												placeholder="YYYY">
											<div class="no-search-btn">
												<button type="submit" class="no-btn no-btn--main no-btn--search">검색</button>
											</div>
										</div>
									</div>
								</div>
							</div> <!-- /.no-card-body -->
						</div>
					</div>

					<!-- Contents -->
					<div class="no-content-container">
						<div class="no-card">
							<div class="no-card-header">
								<h2 class="no-card-title">년도별 접속통계 (선택 연도)</h2>
							</div>

							<div class="no-card-body">
								<div class="no-table-responsive">
									<table class="no-table">
										<caption class="no-blind">연도, 접속수, 접속수 그래프, 퍼센트(전체 대비)</caption>
										<thead class="">
											<tr>
												<th scope="col" class="no-min-width-60">연도</th>
												<th scope="col" class="no-min-width-60">접속수</th>
												<th scope="col" class="no-min-width-150">접속수 그래프</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><span><?= htmlspecialchars($curY) ?>년</span></td>
												<td><span><?= htmlspecialchars(number_format($YearCount)) ?>명</span></td>
												<td>
													<div style="width:100%;background:#eee;height:8px;">
														<div style="width:<?= $barWidth ?>%;height:8px;background:<?= $barColor ?>;"></div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div> <!-- /.no-card-body -->
						</div>
					</div>
				</section>
			</form>
		</main>

		<!-- Footer -->
		<?php include_once "../../inc/admin.footer.php"; ?>
	</div>
</body>
</html>
