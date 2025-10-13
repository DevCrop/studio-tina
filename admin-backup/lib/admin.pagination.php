<div class="no-pagination">
    <ul class="no-page-list">
        <?php if (isset($listCurPage) && $listCurPage > 1) {
            $prevpage = $listCurPage - 1;
        ?>
            <li class="no-page-item">
                <a href="javascript:void(0);" class="no-page-link" onClick="goListMove(<?php echo $prevpage; ?>, '<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>');">
                    <i class="bx bx-chevron-left"></i>
                </a>
            </li>
        <?php } else { ?>
            <li class="no-page-item">
                <a href="javascript:void(0);" class="no-page-link">
                    <i class="bx bx-chevron-left"></i>
                </a>
            </li>
        <?php } ?>

        <?php
        if (isset($listCurPage) && isset($pageBlock) && isset($Page)) {
            for ($x = ($listCurPage - $pageBlock); $x < (($listCurPage + $pageBlock) + 1); $x++) {
                if ($x > 0 && $x <= $Page) {
                    if ($x == $listCurPage) {
        ?>
                        <li class="no-page-item">
                            <a href="javascript:void(0);" class="no-page-link active"><?php echo $x; ?></a>
                        </li>
        <?php 
                    } else {
        ?>
                        <li class="no-page-item">
                            <a href="javascript:void(0);" onClick="goListMove(<?php echo $x; ?>, '<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>');" class="no-page-link"><?php echo $x; ?></a>
                        </li>
        <?php
                    }
                }
            }
        }
        ?>

        <?php if (isset($listCurPage) && isset($Page) && $listCurPage != $Page) {
            $nextpage = $listCurPage + 1;
        ?>
            <li class="no-page-item">
                <a href="javascript:void(0);" class="no-page-link" onClick="goListMove(<?php echo $nextpage; ?>, '<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>');">
                    <i class="bx bx-chevron-right"></i>
                </a>
            </li>
        <?php } else { ?>
            <li class="no-page-item">
                <a href="javascript:void(0);" class="no-page-link">
                    <i class="bx bx-chevron-right"></i>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<script>
function goListMove(start, url) {
    const form = document.getElementById('frm');
    const pageInput = document.createElement('input');
    pageInput.type = 'hidden';
    pageInput.name = 'page';
    pageInput.value = start;
    form.appendChild(pageInput);
    form.setAttribute('action', url);
    form.submit();
}
</script>
