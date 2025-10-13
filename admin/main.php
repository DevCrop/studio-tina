<?php
include_once "../inc/lib/base.class.php";

$pageName = "대시 보드";
$depthnum = 1;

$db = DB::getInstance();

/* =============================
 * 1) 공용 유틸
 * ============================= */
function sanitizeDateYmd($d, $fallback) {
    if ($d && preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) return $d;
    return $fallback;
}

function makeDateRange($start, $end) {
    $fallbackStart = date('Y-m-d', strtotime('-6 days'));
    $fallbackEnd   = date('Y-m-d'); // today

    $start = sanitizeDateYmd($start, $fallbackStart);
    $end   = sanitizeDateYmd($end,   $fallbackEnd);

    // start > end 이면 교환
    if (strtotime($start) > strtotime($end)) {
        $tmp = $start; $start = $end; $end = $tmp;
    }
    return array($start, $end);
}

function makeLabels($start, $end) {
    $labels = array();
    $period = new DatePeriod(
        new DateTime($start),
        new DateInterval('P1D'),
        (new DateTime($end))->modify('+1 day') // inclusive
    );
    foreach ($period as $dt) $labels[] = $dt->format('Y-m-d');
    return $labels;
}

/* =============================
 * 2) Repository: DB 전담 (PHP7 호환)
 * ============================= */
 class DashboardRepo {
    /** @var PDO */
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /** 날짜 구간 전체 카운트 */
    public function countInRange($table, $startYmd, $endYmd) {
        $sql = "SELECT COUNT(*) FROM {$table}
                WHERE created_at BETWEEN :s AND :e";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            ':s' => $startYmd . ' 00:00:00',
            ':e' => $endYmd   . ' 23:59:59',
        ));
        return (int)$stmt->fetchColumn();
    }

    /** 날짜별 카운트(키-값) */
    public function countsByDate($table, $startYmd, $endYmd) {
        $sql = "SELECT DATE(created_at) AS d, COUNT(*) AS cnt
                FROM {$table}
                WHERE created_at BETWEEN :s AND :e
                GROUP BY DATE(created_at)
                ORDER BY d ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            ':s' => $startYmd . ' 00:00:00',
            ':e' => $endYmd   . ' 23:59:59',
        ));
        $rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['YYYY-MM-DD' => cnt]
        return $rows ? $rows : array();
    }

    /** 최근 N개 목록 (기본 최근 7일 범위) */
    public function fetchRecent($table, $limit = 10, $since = '-7 days') {
        $sinceTs = date('Y-m-d H:i:s', strtotime($since));
        $sql = "SELECT id, name, phone, consult_time, created_at
                FROM {$table}
                WHERE created_at >= :since
                ORDER BY id DESC
                LIMIT {$limit}";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':since', $sinceTs);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/* =============================
 * 3) Service: 화면/차트용 가공 (PHP7 호환)
 * ============================= */
 class DashboardService {
    /** @var DashboardRepo */
    private $repo;

    public function __construct(DashboardRepo $repo) {
        $this->repo = $repo;
    }

    /** labels 기준으로 series 정렬/0채우기 */
    private function alignSeries($labels, $map) {
        $series = array();
        foreach ($labels as $d) $series[] = isset($map[$d]) ? (int)$map[$d] : 0;
        return $series;
    }

    /** 여러 테이블의 날짜별 카운트를 labels에 맞춰 반환 */
    public function buildChartSeries($tables, $start, $end, $labels) {
        $series = array();
        foreach ($tables as $key => $table) {
            $map = $this->repo->countsByDate($table, $start, $end);
            $series[$key] = $this->alignSeries($labels, $map);
        }
        return $series;
    }

    /** 여러 테이블의 총합 카운트 */
    public function sumCounts($tables, $start, $end) {
        $sum = 0;
        foreach ($tables as $t) $sum += $this->repo->countInRange($t, $start, $end);
        return $sum;
    }
}

/* =============================
 * 4) 실제 페이지 데이터 구성
 * ============================= */
list($startDate, $endDate) = makeDateRange(
    isset($_GET['start']) ? $_GET['start'] : null,
    isset($_GET['end'])   ? $_GET['end']   : null
);
$labels = makeLabels($startDate, $endDate);

$repo = new DashboardRepo($db);
$svc  = new DashboardService($repo);

$TABLES = array(
    'simple' => 'nb_simple_inquiries',
    'herb'   => 'nb_herb_inquiries',
    'custom' => 'nb_custom_inquires', // 주의: 실제 테이블명
);

/** 차트용 시리즈 */
$chartSeries   = $svc->buildChartSeries($TABLES, $startDate, $endDate, $labels);
$seriesSimple  = $chartSeries['simple'];
$seriesHerb    = $chartSeries['herb'];
$seriesCustom  = $chartSeries['custom'];

/** 기간 합계(텍스트 카드용) */
$simpleCount = $repo->countInRange($TABLES['simple'], $startDate, $endDate);
$herbCount   = $repo->countInRange($TABLES['herb'],   $startDate, $endDate);
$customCount = $repo->countInRange($TABLES['custom'], $startDate, $endDate);

/** 최근 목록 (최근 7일 내 최신 10건) */
$simpleInquiries = $repo->fetchRecent($TABLES['simple'], 10, '-7 days');
$herbInquiries   = $repo->fetchRecent($TABLES['herb'],   10, '-7 days');
$customInquiries = $repo->fetchRecent($TABLES['custom'], 10, '-7 days');

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
                        <div class="dashboard-charts">
                            <!-- 좌측: 바 차트 카드 -->
                            <div class="chart-card">
                                <div class="chart-card__header">
                                    <!-- 왼쪽: 제목 덩어리 -->
                                    <div class="chart-card__title-wrap">
                                        <h2 class="chart-card__title">문의 추이 (일별)</h2>
                                    </div>
                                    <div class="chart-filter__box">
                                        <div class="chart-filter__wrap">
                                            <!-- 오른쪽: 날짜/버튼 덩어리 -->
                                            <div class="chart-filter__group">
                                                <label for="start" class="chart-filter__label">시작일</label>
                                                <input type="date" id="start" name="start"
                                                    value="<?= htmlspecialchars($startDate) ?>"
                                                    class="chart-filter__input">
                                            </div>
                                            <div class="chart-filter__group">
                                                <label for="end" class="chart-filter__label">종료일</label>
                                                <input type="date" id="end" name="end"
                                                    value="<?= htmlspecialchars($endDate) ?>"
                                                    class="chart-filter__input">
                                            </div>
                                        </div>
                                        <div class="chart-filter_buttons">
                                            <button type="submit" class="btn btn--primary">조회</button>
                                            <a href="?start=<?= date('Y-m-d', strtotime('-6 days')) ?>&end=<?= date('Y-m-d') ?>"
                                                class="btn btn--ghost">최근 7일</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart-card__body">
                                    <canvas id="inquiryBarChart" height="120"></canvas>
                                </div>
                            </div>


                            <div class="stats-card">
                                <h2>기간별 문의 건수</h2>

                                <div class="stats-list">
                                    <div class="stats-item">
                                        <div class="stats-item__label">간편 문의</div>
                                        <div>
                                            <span class="stats-item__value"><?= number_format($simpleCount) ?></span>
                                            <span class="stats-item__unit">건</span>
                                        </div>
                                    </div>

                                    <div class="stats-item">
                                        <div class="stats-item__label">공진단 · 한약 문의</div>
                                        <div>
                                            <span class="stats-item__value"><?= number_format($herbCount) ?></span>
                                            <span class="stats-item__unit">건</span>
                                        </div>
                                    </div>

                                    <div class="stats-item">
                                        <div class="stats-item__label">개인맞춤 한약 문의</div>
                                        <div>
                                            <span class="stats-item__value"><?= number_format($customCount) ?></span>
                                            <span class="stats-item__unit">건</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 통합 카드: 최근 문의 + 빠른 메뉴 -->
                        <div class="stack-card">
                            <div class="stack-card__header">
                                <h2 class="stack-card__title">최근 문의</h2>
                                <!-- 필요 시 전체보기 링크 등을 오른쪽에 배치 -->
                            </div>

                            <div class="stack-card__body">
                                <!-- 위: 3개 문의 테이블 그리드 -->
                                <div class="inquiry-grid">

                                    <!-- 간편 문의 -->
                                    <section class="inquiry-col">
                                        <div class="inquiry-col__head">
                                            <h3 class="inquiry-col__title">간편 문의</h3>
                                            <a href="/admin/pages/inquiry/simple.php" class="btn-link">관리 바로가기 →</a>
                                        </div>
                                        <div class="inquiry-col__tablewrap">
                                            <table class="inquiry-table">
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
                                                            <a href="/admin/pages/inquiry/simple.view.php?id=<?= $row['id'] ?>"
                                                                class="table-mini-btn">보기</a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="td-empty">최근 들어온 데이터가 없습니다.</td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>

                                    <!-- 공진단 · 한약 문의 -->
                                    <section class="inquiry-col">
                                        <div class="inquiry-col__head">
                                            <h3 class="inquiry-col__title">공진단 · 한약 문의</h3>
                                            <a href="/admin/pages/inquiry/herb.php" class="btn-link">관리 바로가기 →</a>
                                        </div>
                                        <div class="inquiry-col__tablewrap">
                                            <table class="inquiry-table">
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
                                                            <a href="/admin/pages/inquiry/herb.view.php?id=<?= $row['id'] ?>"
                                                                class="table-mini-btn">보기</a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="td-empty">최근 들어온 데이터가 없습니다.</td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>

                                    <!-- 개인맞춤 한약 문의 -->
                                    <section class="inquiry-col">
                                        <div class="inquiry-col__head">
                                            <h3 class="inquiry-col__title">개인맞춤 한약 문의</h3>
                                            <a href="/admin/pages/inquiry/prescription.php" class="btn-link">관리 바로가기
                                                →</a>
                                        </div>
                                        <div class="inquiry-col__tablewrap">
                                            <table class="inquiry-table">
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
                                                            <a href="/admin/pages/inquiry/prescription.view.php?id=<?= $row['id'] ?>"
                                                                class="table-mini-btn">보기</a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="td-empty">최근 들어온 데이터가 없습니다.</td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>

                                </div>


                                <!-- 아래: 4개 빠른 메뉴 -->
                                <div class="quicklinks">
                                    <ul class="quicklinks__grid">
                                        <li class="quicklinks__item">
                                            <div class="quicklinks__title">
                                                <div class="quicklinks__icon"><i class="fa-regular fa-globe"></i></div>
                                                <h3>페이지별 SEO 관리</h3>
                                            </div>
                                            <p>페이지별 메타태그, 제목, 설명 등을 설정할 수 있습니다.</p>
                                            <a href="/admin/pages/setting/seo.php" class="btn-link">관리 바로가기 →</a>
                                        </li>

                                        <li class="quicklinks__item">
                                            <div class="quicklinks__title">
                                                <div class="quicklinks__icon"><i class="fa-solid fa-user-doctor"></i>
                                                </div>
                                                <h3>의료진 관리</h3>
                                            </div>
                                            <p>병원 의료진 정보를 등록하거나 수정할 수 있습니다.</p>
                                            <a href="/admin/pages/doctor" class="btn-link">관리 바로가기 →</a>
                                        </li>

                                        <li class="quicklinks__item">
                                            <div class="quicklinks__title">
                                                <div class="quicklinks__icon"><i class="fa-solid fa-flag-pennant"></i>
                                                </div>
                                                <h3>배너 관리</h3>
                                            </div>
                                            <p>홈페이지 상단/하단 등 위치에 출력되는 배너를 설정합니다.</p>
                                            <a href="/admin/pages/design/banner.list.php" class="btn-link">관리 바로가기 →</a>
                                        </li>

                                        <li class="quicklinks__item">
                                            <div class="quicklinks__title">
                                                <div class="quicklinks__icon"><i class="fa-solid fa-browsers"></i></div>
                                                <h3>팝업 관리</h3>
                                            </div>
                                            <p>공지사항, 이벤트 등의 팝업을 등록하고 노출을 설정합니다.</p>
                                            <a href="/admin/pages/design/popup.list.php" class="btn-link">관리 바로가기 →</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>


                </section>
            </form>
        </main>
    </div>



    <script>
    (function() {
        // PHP 데이터 → JS로 전달
        const labels = <?= json_encode($labels, JSON_UNESCAPED_UNICODE) ?>;
        const dataSimple = <?= json_encode($seriesSimple, JSON_UNESCAPED_UNICODE) ?>;
        const dataHerb = <?= json_encode($seriesHerb, JSON_UNESCAPED_UNICODE) ?>;
        const dataCustom = <?= json_encode($seriesCustom, JSON_UNESCAPED_UNICODE) ?>;

        const ctx = document.getElementById('inquiryBarChart').getContext('2d');

        // 막대 그래프 (그룹형)
        // 색상은 프로젝트 디자인 시스템에 맞춰 바꾸세요
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                        label: '간편 문의',
                        data: dataSimple,
                        backgroundColor: 'rgba(59, 130, 246, 0.6)', // blue-500
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '공진단 · 한약 문의',
                        data: dataHerb,
                        backgroundColor: 'rgba(34, 197, 94, 0.6)', // green-500
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '개인맞춤 한약 문의',
                        data: dataCustom,
                        backgroundColor: 'rgba(234, 179, 8, 0.6)', // yellow-500
                        borderColor: 'rgba(234, 179, 8, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // 카드 높이에 맞게
                scales: {
                    x: {
                        stacked: false,
                        ticks: {
                            maxRotation: 0,
                            autoSkip: true,
                            // 데이터가 길면 적절히 줄이기
                            callback: function(value, index, ticks) {
                                // 시작/끝/중간만 표기 등 커스터마이즈 가능
                                return this.getLabelForValue(value);
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // 정수 표시
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    })();
    </script>