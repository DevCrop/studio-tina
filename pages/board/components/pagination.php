<?php
// Define default values if not already set
$listCurPage = $listCurPage ?? 1;
$pageBlock = 5; // Number of pages to show before and after the current page, for a total of 10
$pageActive = $listCurPage ? "active" : "";

// Total number of pages, replace $Page with the actual total page count
$Page = $Page ?? 1;
?>

<div class="no-board-pagination">
    <?php if ($listCurPage > 1): ?>
        <?php $prevpage = $listCurPage - 1; ?>
        <a href="javascript:void(0);" title="prev" class="prevnext prev" onClick="goListMove(<?= htmlspecialchars($prevpage, ENT_QUOTES, 'UTF-8') ?>, '<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>');">
             <i class="fa-sharp fa-regular fa-angle-right fa-rotate-180" style="color: #fff;" aria-hidden="true"></i>
        </a>
    <?php else: ?>
        <a href="javascript:void(0);" title="prev" class="prevnext prev">
             <i class="fa-sharp fa-regular fa-angle-right fa-rotate-180" style="color: #fff;" aria-hidden="true"></i>
        </a>
    <?php endif; ?>

    <ul>
        <?php 
        // Determine the start and end pages for pagination
        $startPage = max(1, $listCurPage - $pageBlock);
        $endPage = min($Page, $listCurPage + $pageBlock);

        for ($x = $startPage; $x <= $endPage; $x++):
            if ($x > 0 && $x <= $Page):
                if ($x == $listCurPage): ?>
                    <li>
                        <a href="javascript:void(0);" title="<?= htmlspecialchars($x, ENT_QUOTES, 'UTF-8') ?> page" class="<?= $pageActive ?> num"><p><?= htmlspecialchars($x, ENT_QUOTES, 'UTF-8') ?></p></a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="javascript:void(0);" title="<?= htmlspecialchars($x, ENT_QUOTES, 'UTF-8') ?> page" class="num" onClick="goListMove(<?= htmlspecialchars($x, ENT_QUOTES, 'UTF-8') ?>, '<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>');"><p><?= htmlspecialchars($x, ENT_QUOTES, 'UTF-8') ?></p></a>
                    </li>
                <?php endif;
            endif;
        endfor; 
        ?>
    </ul>

    <?php if ($listCurPage < $Page): ?>
        <?php $nextpage = $listCurPage + 1; ?>
        <a href="javascript:void(0);" title="next" class="prevnext next" onClick="goListMove(<?= htmlspecialchars($nextpage, ENT_QUOTES, 'UTF-8') ?>, '<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>');">
           <i class="fa-sharp fa-regular fa-angle-right" style="color: #fff;" aria-hidden="true"></i>
        </a>
    <?php else: ?>
        <a href="javascript:void(0);" title="next" class="prevnext next">
        <i class="fa-sharp fa-regular fa-angle-right" style="color: #fff;" aria-hidden="true"></i>
        </a>
    <?php endif; ?>
</div>

<script>
function goListMove(start, url) {
    const form = document.getElementById('frm');
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'page';
    hiddenInput.value = start;
    form.appendChild(hiddenInput);
    form.action = url;
    form.submit();
}
</script>
