
    <div class="no-container">
	<div class="no-components mb30">

          <div class="no-sub__title " <?=$aos_title?>>
			<span>RECRUIT</span>
            <h2>채용 안내</h2>
          </div>
		  
		  <!--search bar-->
			<div class="no-search__box">
			 <input type="search" placeholder="Search"  name="searchKeyword" id="searchKeyword" title="search" value="<?=$searchKeyword?>">
			  <button type="button" aria-label="search" onClick="doSearch();">
				<i class="bx bx-search"></i>
			  </button>
			</div>
		</div>


		  <div class="no-fac__inner">
            <!---게시판-->
            <div class="no_list-tbl" <?=$aos_middle?>>
              <p class="no-list-head">
                <span style="width: 7%">번호</span>
                <span style="width: 59%">제목</span>
                <span style="width: 12%">작성자</span>
                <span style="width: 12%">등록일</span>
              </p>
				<?
					$rn = 1;
					foreach($arrResultSet as $k=>$v){ 

					$title = $v[title];

					if($v[is_secret] == "Y"){
						if($_SESSION['board_secret_confirmed_'.$v[no]] == "Y"){
							$link = "./board.view.php?board_no=$board_no&no=$v[no]&searchKeyword=".base64_encode($searchKeyword)."&searchColumn=".base64_encode($searchColumn)."&page=$page&category_no=$category_no";
						}else{
							$link = "./board.confirm.php?mode=view&board_no=$board_no&no=$v[no]&searchKeyword=".base64_encode($searchKeyword)."&searchColumn=".base64_encode($searchColumn)."&page=$page&returnUrl=/pages/sub4/sub_inquiry_view.php";
						}
					}else{
						$link = "./board.view.php?board_no=$board_no&no=$v[no]&searchKeyword=".base64_encode($searchKeyword)."&searchColumn=".base64_encode($searchColumn)."&page=$page&category_no=$category_no";
					}

					$numZone = "";
					$numZoneName = "";

					if($v[is_notice] == "Y"){
						$numZone = "active\"";
						$numZoneName = "공지";
					}else{
						$numZoneName = $rn;
					}
					
					$new = "";
					if(time() - strtotime($v[regdate])< (60*60*24*2)) {	
						$new = "<img src=\"../../resource/images/no_new_icon.png\"/>";
					}	
				
					$commentCnt = "";
					if($v[comment_cnt])
						$commentCnt = "<span class=\"no_w_list_sign\">(".$v[comment_cnt].")</span>";
				?>
              <div class="no-list-row notice-row clearfix">
                <div class="no-list-col no-block"><?=$rn?></div>

                <div class="no-list-col no-title">
                  <a href="<?=$link?>">
                    <div class="no-title-link">
                      <span class="no_new_icon"></span><strong class="no-title-notice"><?=$title?></strong>
                    </div>
                  </a>
                </div>

                <div class="no-list-col no-inline" data-label="작성자">
                  <?=$v[write_name]?>
                </div>

                <div class="no-list-col no-inline" data-label="등록일">
                 <?=getChangeDate($v[regdate], "Y.m.d")?>
                </div>
              </div>
			  <?
					$rn++;
					}
				?>
              <!-- no-list-row-->
            </div>
            <!-- no-tb-con -->
          </div>
    </div>