<?php
	include_once "../../../inc/lib/base.class.php";

	$pdo = DB::getInstance();
	$depthnum = 13;
	$pagenum = 1;

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
				// Date Processing (month only)
				$sdate = $_REQUEST['sdate'] ?? ''; // YYYY-MM
				if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $sdate)) {
					$sdate = date('Y-m');
				}
				[$Select_Year, $Select_Month] = array_map('intval', explode('-', $sdate));
				$curYM = sprintf('%04d-%02d', $Select_Year, $Select_Month);

				// 월 총 방문자
				$stmt = $pdo->prepare("SELECT COUNT(*) FROM nb_analytics WHERE `year`=:y AND `month`=:m");
				$stmt->execute([':y'=>$Select_Year, ':m'=>$Select_Month]);
				$TotalMonth = (int)$stmt->fetchColumn();

				// 일별 카운트
				$stmt = $pdo->prepare("
					SELECT `day`, COUNT(*) AS cnt
					FROM nb_analytics
					WHERE `year`=:y AND `month`=:m
					GROUP BY `day`
				");
				$stmt->execute([':y'=>$Select_Year, ':m'=>$Select_Month]);

				$dayMap = [];
				$max = 0;
				foreach ($stmt as $r) {
					$d = (int)$r['day'];
					$c = (int)$r['cnt'];
					$dayMap[$d] = $c;
					if ($c > $max) $max = $c;
				}

				$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $Select_Month, $Select_Year);
				$loopStart = 1;
				$loopEnd   = $daysInMonth;

			?>



            <!-- Contents -->
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
                                        <li class="no-breadcrumb-item"><span>일자별</span></li>
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
								<h3 class="no-admin-title">총방문자</h3>
								<div class="no-admin-content">
								  <span class="no-admin-cnt"><?= number_format($TotalMonth) ?>명</span>
								  <?php if ($Filter_Day !== null): ?>
									<div class="no-pd-8--t">
									  <small>선택일 :</small> <strong><?= number_format($TotalDay) ?>명</strong>
									</div>
								  <?php endif; ?>
								</div>
							  </div>

							  <div class="no-admin-block no-w-80">
								<h3 class="no-admin-title">날짜선택</h3>
								<div class="no-admin-content no-admin-date">
								  <div class="no-search-wrap" style="gap:12px;display:flex;align-items:center;">
									<div>
									  <input type="month" name="sdate" id="s_date" value="<?= htmlspecialchars($curYM) ?>">
									</div>
								
									<div class="no-search-btn">
									  <button type="submit" class="no-btn no-btn--main no-btn--search">검색</button>
									</div>
								  </div>
								</div>
							  </div>
							</div>


                        </div>
                    </div>

                    <!-- Contents -->
                    <div class="no-content-container">
                        <div class="no-card">
                            <div class="no-card-header">
                                <h2 class="no-card-title">일자별 접속통계</h2>
                            </div>

                            <div class="no-card-body">
                                <div class="no-table-responsive">
								  <table class="no-table">
									<caption class="no-blind">일자, 접속수, 접속수 그래프, 접속수 퍼센트</caption>
									<thead class="">
									  <tr>
										<th scope="col" class="no-min-width-60">일자</th>
										<th scope="col" class="no-min-width-60">접속수</th>
										<th scope="col" class="no-min-width-150">접속수 그래프</th>
									  </tr>
									</thead>
									<tbody>
									<?php for ($i = $loopStart; $i <= $loopEnd; $i++):
										$cnt = $dayMap[$i] ?? 0;
										$percentOfTotal = $TotalMonth ? round(($cnt / $TotalMonth) * 100, 2) : 0;
										$percentOfMax   = $max ? round(($cnt / $max) * 100, 2) : 0;
										$barWidth = max(1, $percentOfMax);
										$isMax = ($cnt > 0 && $cnt === $max);
									?>
									  <tr>
										<td><?= $i ?>일</td>
										<td><?= number_format($cnt) ?>명</td>
										<td>
										  <div style="width:100%;background:#eee;height:8px;">
											<div style="width:<?= $barWidth ?>%;height:8px;<?= $isMax ? 'background:#0083e8;' : 'background:#ccc;' ?>"></div>
										  </div>
										  <small style="margin-left:6px;"><?= number_format($percentOfTotal,2) ?>%</small>
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
    <style>
        table.ui-datepicker-calendar { display: none; }
    </style>
</body>
</html>
