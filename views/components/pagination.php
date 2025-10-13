<div class="no-pagination">
    <?php
    $totalPages = $Page;
    $curPage = $listCurPage;
    $side = 2; // 좌우 표시할 개수
    ?>

    <!-- 맨 처음 -->
    <a href="javascript:void(0);" class="--arrow --first" onClick="goListMove(1)"
        <?= $curPage === 1 ? 'disabled' : '' ?>>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="11 17 6 12 11 7"></polyline>
            <polyline points="18 17 13 12 18 7"></polyline>
        </svg>
    </a>

    <!-- 이전 -->
    <a href="javascript:void(0);" class="--arrow --prev" onClick="goListMove(<?= max(1, $curPage - 1) ?>)"
        <?= $curPage === 1 ? 'disabled' : '' ?>>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </a>

    <div class="--numbers">
        <?php
        $start = max(1, $curPage - $side);
        $end = min($totalPages, $curPage + $side);

        // 시작 부분 처리
        if ($start > 1) {
            echo '<a href="javascript:void(0);" onClick="goListMove(1)">1</a>';
            if ($start > 2) {
                echo '<span class="--dots">...</span>';
            }
        }

        // 중앙 페이지 출력
        for ($i = $start; $i <= $end; $i++) {
            $active = ($i === $curPage) ? 'active' : '';
            echo '<a href="javascript:void(0);" class="' . $active . '" onClick="goListMove(' . $i . ')">' . $i . '</a>';
        }

        // 끝 부분 처리
        if ($end < $totalPages) {
            if ($end < $totalPages - 1) {
                echo '<span class="--dots">...</span>';
            }
            echo '<a href="javascript:void(0);" onClick="goListMove(' . $totalPages . ')">' . $totalPages . '</a>';
        }
        ?>
    </div>

    <!-- 다음 -->
    <a href="javascript:void(0);" class="--arrow --next" onClick="goListMove(<?= min($totalPages, $curPage + 1) ?>)"
        <?= $curPage === $totalPages ? 'disabled' : '' ?>>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </a>

    <!-- 맨 끝 -->
    <a href="javascript:void(0);" class="--arrow --last" onClick="goListMove(<?= $totalPages ?>)"
        <?= $curPage === $totalPages ? 'disabled' : '' ?>>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="13 17 18 12 13 7"></polyline>
            <polyline points="6 17 11 12 6 7"></polyline>
        </svg>
    </a>
</div>

<script>
function goListMove(page) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('page', page);
    window.location.href = window.location.pathname + '?' + urlParams.toString();
}
</script>