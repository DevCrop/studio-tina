<?php
// 안전한 출력 헬퍼
function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

// 날짜 포맷
$regdate_fmt = !empty($data['regdate']) ? date('Y-m-d H:i', strtotime($data['regdate'])) : '';

// 콘텐츠(HTML을 허용하지 않는 경우 안전하게)
$content_safe = nl2br(h($data['contents'] ?? ''));

?>
<section class="no-sub-view no-section-md">
    <div class="no-container-lg">
        <article class="no-view">
            <div class="--section-title-with-button">
                <hgroup>
                    <h2 class="f-heading-4 clr-text-title">
                        <?= h($data['title'] ?? '') ?>
                    </h2>

                </hgroup>
                <div class="no-view-meta">
                    <span class="author">
                        <i class="fa-solid fa-circle-user"></i>
                        <?= h($data['write_name'] ?? '익명') ?>
                    </span>
                    <span class="date">
                        <i class="fa-regular fa-calendar"></i>
                        <?= h($regdate_fmt) ?>
                    </span>
                </div>
            </div>

            <div class="no-view-body">
                <div class="no-view-content">
                    <?= $content_safe ?>
                </div>
            </div>

            <?php include_once $STATIC_ROOT . '/pages/board/board.comment.php'; ?>
        </article>
    </div>
</section>