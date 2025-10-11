<ul class="no-faq-list">
    <?php
    foreach($arrResultSet as $k=>$v){

    $title = $v['title'];
    $contents = $v['contents'];

    ?>
    <li class="no-faq-item">
       
        <div class="no-faq-block">
            <div class="no-faq-header">
                <strong><?=$title?></strong>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="no-faq-body">
                <div>
                    <?=$contents?>
                </div>
            </div>
        </div>
    </li>
    <?php
        $rnumber--;
        }
    ?>
</ul>