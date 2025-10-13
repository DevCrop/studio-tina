<div class="no-pagination">
    <!-- 이전 페이지 -->
    <a href="javascript:void(0);" class="prev arrow wgray i-24" onClick="goListMove(<?= max(1, $listCurPage - 1) ?>)">◣</a>

    <ul class="page_num">
        <?php
        $totalPages = $Page;
        $curPage = $listCurPage;
        $side = 4; // 좌우 표시할 개수

        $start = max(2, $curPage - $side);
        $end = min($totalPages - 1, $curPage + $side);

        // 항상 첫 페이지 출력
        echo '<li><a href="javascript:void(0);" class="no-body-md wgray ' . ($curPage === 1 ? 'active' : '') . '" onClick="goListMove(1)">1</a></li>';

        // 앞쪽 ... 처리
        if ($start > 2) {
            echo '<li><a href="javascript:void(0);" class="no-body-md wgray">•••</a></li>';
        }

        // 중앙 페이지 출력
        for ($i = $start; $i <= $end; $i++) {
            $active = ($i === $curPage) ? 'active' : '';
            echo '<li><a href="javascript:void(0);" class="no-body-md wgray ' . $active . '" onClick="goListMove(' . $i . ')">' . $i . '</a></li>';
        }

        // 뒤쪽 ... 처리
        if ($end < $totalPages - 1) {
            echo '<li><a href="javascript:void(0);" class="no-body-md wgray">•••</a></li>';
        }

        // 마지막 페이지 출력 (중복 방지)
        if ($totalPages > 1) {
            echo '<li><a href="javascript:void(0);" class="no-body-md wgray ' . ($curPage === $totalPages ? 'active' : '') . '" onClick="goListMove(' . $totalPages . ')">' . $totalPages . '</a></li>';
        }
        ?>
    </ul>

    <!-- 다음 페이지 -->
    <a href="javascript:void(0);" class="prev arrow wgray i-24" onClick="goListMove(<?= min($totalPages, $curPage + 1) ?>)">◥</a>
</div>

<script>
function goListMove(page) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('page', page);
    window.location.href = window.location.pathname + '?' + urlParams.toString();
}
</script>
