        <!--certification-->
        <div class="no-cer" <?=$aos_middle?>>
          <!-- tab -->
          <div class="no-tab mb50 no-container" <?=$aos_slow?>>
            <ul class="no-tab__wrap">
              <li class="no-tab__item no-tab__item--cer">
                <button class="active">인증서</button>
              </li>
              <li class="no-tab__item no-tab__item--cer">
                <button>국내 건설업 등록현황</button>
              </li>
            </ul>
          </div>
          <div class="no-container">
            <!--인증서 컨텐츠-->
            <div class="no-cer__cnt">
              <div class="no-sub__title" <?=$aos_title?>>
                <span>certification</span>
                <h2>인증서</h2>
              </div>
              <!--certification inner-->
              <div class="no-certi__inner mt80">
                <ul class="no-certi__wrap">
					<?
				foreach($arrResultSet as $k=>$v){

				//$title = iconv_substr($v[title], 0, 16, "utf-8");
				$title = $v[title];
				$contents = strip_tags($v[contents]);
				$contents = iconv_substr($contents, 0, 500, "utf-8");
				$link = "./board.view.php?board_no=$board_no&no=$v[no]&searchKeyword=".base64_encode($searchKeyword)."&searchColumn=".base64_encode($searchColumn)."&page=$page";

				$imgSrc = "";
				if($v[thumb_image])
					$imgSrc = $UPLOAD_WDIR_BOARD."/".$v[thumb_image];
				else{
					$imgSrc = getImageTag($v[contents], "src");
					$imgSrc = $imgSrc[0];
				}
			?>
                  <li class="no-certi__item">
                    <!--img-->
                   <div class="no-certi__img">
				 <img
					src="<?=$imgSrc?>"
					alt="<?=$title?>"
				  />
                    </div>
                    <!--txt-->
                    <div class="no-certi__txt">
                      <p class="no-certi__title"><?=$title?></p>
                    </div>
                  </li>
				  <?
					}
				?>
                </ul>
              </div>
            </div>
            <!--건설업 테이블 컨텐츠-->
            <div class="no-cer__cnt">
              <!--건설업 등록 테이블-->
              <div class="no-sub__title mb80">
                <span>certification</span>
                <h2>국내 건설업 등록현황</h2>
              </div>
              <div class="table">
                <table class="tg">
                  <thead>
                    <tr>
                      <th class="tg-0pky">업종</th>
                      <th class="tg-0lax">등록번호</th>
                      <th class="tg-0lax">시공능력평가액(백만원)</th>
                      <th class="tg-0lax">등록일자</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="tg-0lax">토목건축공사업</td>
                      <td class="tg-0lax">제1229호</td>
                      <td class="tg-0lax">744,672</td>
                      <td class="tg-0lax">92.12.04</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">토목공사업</td>
                      <td class="tg-0lax">제1229호</td>
                      <td class="tg-0lax">350,207</td>
                      <td class="tg-0lax">92.12.04</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">건축공사업</td>
                      <td class="tg-0lax">제1229호</td>
                      <td class="tg-0lax">643,779</td>
                      <td class="tg-0lax">92.12.04</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">산업, 환경설비공사</td>
                      <td class="tg-0lax">산업설비 13-0001호</td>
                      <td class="tg-0lax">279,172</td>
                      <td class="tg-0lax">99.03.10</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">조경공사업</td>
                      <td class="tg-0lax">조경-13-0001호</td>
                      <td class="tg-0lax">163,592</td>
                      <td class="tg-0lax">99.03.10</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">시설물유지관리업</td>
                      <td class="tg-0lax">충남 보령 2000-29-01</td>
                      <td class="tg-0lax">99,039</td>
                      <td class="tg-0lax">00.04.20</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">가스시설시공업 제1종</td>
                      <td class="tg-0lax">98-27-1-1</td>
                      <td class="tg-0lax">36,106</td>
                      <td class="tg-0lax">98.05.22</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">전문소방시설공사</td>
                      <td class="tg-0lax">경기화성 제2008-27호</td>
                      <td class="tg-0lax">25,739</td>
                      <td class="tg-0lax">00.09.06</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">전기공사업</td>
                      <td class="tg-0lax">충남-00130호</td>
                      <td class="tg-0lax">27,777</td>
                      <td class="tg-0lax">98.06.20</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">정보통신공사업</td>
                      <td class="tg-0lax">제112382호</td>
                      <td class="tg-0lax">8,703</td>
                      <td class="tg-0lax">02.03.06</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">부동산개발</td>
                      <td class="tg-0lax">경기080272</td>
                      <td class="tg-0lax">-</td>
                      <td class="tg-0lax">08.06.04</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">토양정화</td>
                      <td class="tg-0lax">제2007-01호</td>
                      <td class="tg-0lax">-</td>
                      <td class="tg-0lax">07.01.12</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">엔지니어링사업(품질시험)</td>
                      <td class="tg-0lax">제E-9-2481호</td>
                      <td class="tg-0lax">-</td>
                      <td class="tg-0lax">06.09.28</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">주택건설사업</td>
                      <td class="tg-0lax">제경기-주택대지 2004-0035</td>
                      <td class="tg-0lax">-</td>
                      <td class="tg-0lax">04.03.22</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">건물(시설)관리용역</td>
                      <td class="tg-0lax">제3138102806호</td>
                      <td class="tg-0lax">-</td>
                      <td class="tg-0lax">06.09.28</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">석유판매업(주유소)</td>
                      <td class="tg-0lax">경남함안제78호</td>
                      <td class="tg-0lax">-</td>
                      <td class="tg-0lax">15.09.15</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>