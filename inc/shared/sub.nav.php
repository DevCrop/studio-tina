<section class="no-sub-nav">
    <div class="container-xl">
        <?php
        $current_page_title = '';

        foreach ($CUR_PAGE_LIST[0]['pages'] as $v) {
            if ($v['isActive']) {
                $current_page_title = $v['title'];
                break;
            }
        }
        ?>

        <h2 <?= $aos_slow ?>><?= $current_page_title ?></h2>
        <h2></h2>
        <ul class="nav-list">
            <?php foreach ($CUR_PAGE_LIST[0]['pages'] as $v) :
                $is_active = $v['isActive'] ? 'active' : '';
            ?>
                <li class="<?= $is_active ?>">
                    <a href="<?= $v['path'] ?>"><?= $v['title'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>


<section class="no-sub-m-nav">
    <ul class="nav-wrap">
        <?php if ($CUR_PAGE_LIST[0]) : ?>
            <li class="nav-item ni1">
                <a href="#" onclick="return false;">
                    <p><?= $CUR_PAGE_LIST[0]['title'] ?></p>
                    <img src="/resource/images/icon/down.svg" />
                </a>

                <ul class="nav-sub-wrap nsw1">
                    <?php foreach ($MENU_ITEMS as $pi => $PAGE) :
                        $is_active = $PAGE['isActive'] ? 'active' : '';
                    ?>
                        <li class="<?= $is_active ?> nav-sub-item"><a href="<?= $PAGE['path'] ?>"><?= $PAGE['title'] ?></a></li> <?PHP endforeach; ?>

                </ul>
            </li>
        <?php endif; ?>


        <?php if ($CUR_PAGE_LIST[1]) : ?>
            <li class="nav-item ni2">
                <a href="#" onclick="return false;">
                    <p><?= $CUR_PAGE['title'] ?></p>
                    <img src="/resource/images/icon/down.svg" />

                </a>

                <ul class="nav-sub-wrap nsw2">
                    <?php foreach ($CUR_PAGE_LIST[0]['pages'] as $pi => $PAGE) :
                        $is_active = $PAGE['isActive'] ? 'active' : '';
                    ?>
                        <li class="<?= $is_active ?> nav-sub-item"><a href="<?= $PAGE['path'] ?>"><?= $PAGE['title'] ?></a></li> <?PHP endforeach; ?>
                </ul>
            </li>
        <?php endif; ?>

    </ul>
</section>