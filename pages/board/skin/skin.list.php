    <section class="no-sub-notice no-section-md">
        <div class="no-container-xl">
            <div class="--section-title-with-search">
                <hgroup>
                    <h2 class="f-heading-3 clr-text-title">제품 문의</h2>
                </hgroup>

                <div class="no-form-search ">
                    <input type="text" name="searchKeyword" id="searchKeyword" placeholder="검색어를 입력해주세요.">
                    <button type="button" class="" aria-label="search" onclick="doSearch();">
                        <i class="fa-light fa-magnifying-glass" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="--cnt">
                <!-- --cnt 내부 -->
                <div class="notice">
                    <table class="notice">
                        <colgroup>
                            <col style="width: auto;" />
                            <col />
                            <col />
                        </colgroup>
                        <thead>
                            <tr class="">
                                <th class="notice-head notice-title f-body-2">제목</th>
                                <th class="notice-head notice-date f-body-2">작성일</th>
                                <th class="notice-head notice-views f-body-2">조회수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrResultSet as $row): ?>
                            <tr class="notice-row">
                                <td class="notice-cell notice-title">
                                    <a class="f-body-1 --semibold"
                                        href="<?=$ROOT?>/pages/board/board.confirm.php?mode=view&board_no=<?=$board_no?>&no=<?=$row['no']?>">
                                        <i class="fa-regular fa-lock"></i>
                                        <?= htmlspecialchars($row['title']) ?>
                                        <?php if ((int)$row['comment_cnt'] > 0): ?>
                                        <span class="answer-status complete">답변 완료</span>
                                        <?php else: ?>
                                        <span class="answer-status pending">답변 대기</span>
                                        <?php endif; ?>
                                    </a>

                                </td>
                                <td class="notice-cell notice-date">
                                    <time datetime="<?= $row['date'] ?>">
                                        <?= date("Y-m-d", strtotime($row['regdate'])) ?>
                                    </time>
                                </td>
                                <td class="notice-cell notice-views">
                                    <?= number_format($row['read_cnt']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>

                <div class="no-write-btn">
                    <a href="<?=$ROOT?>/pages/board/board.write.php?board_no=<?=$board_no?>" class="no-btn-primary">
                        글 등록하기
                    </a>
                </div>


                <?php include_once $STATIC_ROOT . '/inc/layouts/pagination.php'; ?>

            </div>
    </section>