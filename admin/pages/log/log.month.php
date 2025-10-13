<?php
	include_once "../../../inc/lib/base.class.php";

	$pdo = DB::getInstance();
	$depthnum = 13;
	$pagenum = 3;

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
				// Date Processing (YYYY 또는 YYYY-MM 허용)
				$sdate = trim($_REQUEST['sdate'] ?? '');

				// 기본: 현재 연도
				$Select_Year  = (int)date('Y');
				if (preg_match('/^\d{4}$/', $sdate)) {
					$Select_Year = (int)$sdate;
				} elseif (preg_match('/^\d{4}-(\d{1,2})$/', $sdate, $m)) {
					$Select_Year  = (int)substr($sdate, 0, 4);
				}

				$curYM = sprintf('%04d-%02d', $Select_Year, (int)date('n')); // 인풋 유지용

				// 연도 총 방문자
				$stmt = $pdo->prepare("SELECT COUNT(*) FROM nb_analytics WHERE `year`=:y");
				$stmt->execute([':y'=>$Select_Year]);
				$TotalYear = (int)$stmt->fetchColumn();

				// 월별 집계
				$stmt = $pdo->prepare("
					SELECT `month`, COUNT(*) AS cnt
					FROM nb_analytics
					WHERE `year`=:y
					GROUP BY `month`
				");
				$stmt->execute([':y'=>$Select_Year]);

				$monthMap = array_fill(1, 12, 0);
				$maxMonth = 0;
				foreach ($stmt as $r) {
					$m = (int)$r['month'];
					$c = (int)$r['cnt'];
					if ($m >= 1 && $m <= 12) {
						$monthMap[$m] = $c;
						if ($c > $maxMonth) $maxMonth = $c;
					}
				}
				?>



			<form id="frm" name="frm" method="post" autocomplete="off">
				<input type="hidden" id="mode" name="mode" value="">
				<section class="no-content">
					<div class="no-toolbar">
						<div class="no-toolbar-container no-flex-stack">
							<div class="no-page-indicator">
								<h1 class="no-page-title">접속통계</h1>
								<div class="no-breadcrumb-container">
									<ul class="no-breadcrumb-list">
										<li class="no-breadcrumb-item"><span>접속통계</span></li>
										<li class="no-breadcrumb-item"><span>월별</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="no-search no-toolbar-container">
						<div class="no-card">
							<div class="no-card-body no-admin-column">
								<div class="no-admin-block no-w-20">
									<h3 class="no-admin-title">총방문자</h3>
									<div class="no-admin-content">
										<span class="no-admin-cnt"><?= htmlspecialchars(number_format($TotalYear)) ?>명</span>
									</div>
								</div>
								<div class="no-admin-block no-w-80">
									<h3 class="no-admin-title">연도선택</h3>
									<div class="no-admin-content no-admin-date">
										<div class="no-search-wrap" style="gap:12px;display:flex;align-items:center;">
											<input
											  type="text"
											  name="sdate"
											  id="s_date"
											  value="<?= htmlspecialchars($curYM) ?>"
											  inputmode="numeric"
											  placeholder="YYYY 또는 YYYY-MM">
											<div class="no-search-btn">
												<button type="submit" class="no-btn no-btn--main no-btn--search">검색</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="no-content-container">
						<div class="no-card">
							<div class="no-card-header">
								<h2 class="no-card-title">월별 접속통계</h2>
							</div>
							<div class="no-card-body">
								<div class="no-table-responsive">
									<table class="no-table">
										<caption class="no-blind">월, 접속수, 접속수 그래프, 접속수 퍼센트</caption>
										<thead class="">
											<tr>
												<th class="no-min-width-60">월</th>
												<th class="no-min-width-60">접속수</th>
												<th class="no-min-width-150">접속수 그래프</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=1; $i<=12; $i++):
												$cnt = $monthMap[$i] ?? 0;
												$percent       = $TotalYear ? round(($cnt / $TotalYear) * 100, 2) : 0;
												$percentOfMax  = $maxMonth  ? round(($cnt / $maxMonth)  * 100, 2) : 0;
												$barWidth = max(1, $percentOfMax);
												$isMax    = ($cnt > 0 && $cnt === $maxMonth);
											?>
											  <tr>
												<td><span><?= $i ?>월</span></td>
												<td><span><?= htmlspecialchars(number_format($cnt)) ?>명</span></td>
												<td>
												  <div style="width:100%;background:#eee;height:8px;">
													<div style="width:<?= $barWidth ?>%;height:8px;<?= $isMax ? 'background:#0083e8;' : 'background:#ccc;' ?>"></div>
												  </div>
												</td>
											  </tr>
											<?php endfor; ?>
											</tbody>

									</table>
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
