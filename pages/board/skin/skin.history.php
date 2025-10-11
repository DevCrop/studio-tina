        <section class="no-history">
          <div class="no-container">
            <!--서브페이지 타이틀-->
            <div class="no-sub__title mb80" <?=$aos_title?>>
              <span>HISOTRY</span>
              <h2>연혁</h2>
            </div>
            <div class="no-history__inner mt80">
                <div class="no-history__inner-box">
                  <ul class="no-history__wrap">
				  <?
						foreach($boardCategory as $kk=>$vv){
							
							$arrResultSet = null;
							$subqry = " and a.category_no = ".$vv['no'];
							$query = " select a.no, a.board_no, a.user_no, a.category_no, a.comment_cnt, a.title, a.contents, a.regdate, a.read_cnt, a.thumb_image, 
								a.is_admin_writed, a.is_notice, a.is_secret, a.secret_pwd, a.write_name, a.isFile
								  ,a.file_attach_1, a.file_attach_origin_1 , a.file_attach_2, a.file_attach_origin_2 , a.file_attach_3, a.file_attach_origin_3 , a.file_attach_4, a.file_attach_origin_4 , a.file_attach_5, a.file_attach_origin_5, a.is_admin_comment_yn
								  ,a.extra1 ,a.extra2, a.extra3, a.extra4, a.extra5
												  ,b.title as board_name, c.name as category_name
												from nb_board a
												left join nb_board_manage b on a.board_no = b.no
												left join nb_board_category c on a.category_no = c.no
												$mainqry  $subqry order by  a.is_notice='Y' desc , a.regdate desc

								limit $count , $listRowCnt 
							";
							//echo $query;

							$result =mysql_query($query);
							$arrResultSet = array(); 
							while($row = mysql_fetch_assoc($result)) { 
								$arrResultSet[] = $row; 
							}

					$year = $vv['name'];

					?>
                    <li class="mb50" <?=$aos_middle?>>
                      <div class="no-history__inner-txt-wrap">
                          <!-- 연도 -->
                          <div class="no-history__year">
                            <h4><?=$year?></h4>
                          </div>
                          <!-- 월 및 정보 -->
                          <ul class="no-history__info">
						  <? 
								foreach($arrResultSet as $k=>$v){

								$history_month = $v['extra1'];
								$history_title = $v['title'];
		
							?>
                              <li>
                              <div class="no-history__month">
                                <p><?=$history_month?></p>
                              </div>
                              <div class="no-history__desc">
                                <p><?=$history_title?></p>
                              </div>
                            </li>
							<?
								$rnumber--;
								}
							?>
                        </ul>
                        
                      </div>
                    </li>
					<? } ?> 
                  </ul>
              </div>
            </div>
        </section>