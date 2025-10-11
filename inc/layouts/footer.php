<div class="videomodal" class="modal">
    <div class="modal-content">
        <i class="fa-sharp fa-light fa-xmark videoclose" style="color: #ffffff;"></i>
        <div class="videocontainer"></div>
    </div>
</div>

<footer class="no-footer">
    <div class="container-xl">
        <ul class="no-footer__menu">
            <li class="f-wrap">
                <h2 class="no-footer__logo">
                    <a href="<?= ($HTML_LANG == 'en') ? '/en' : '/' ?>">
						<img src="<?= $UPLOAD_SITEINFO_WDIR_LOGO ?>/<?= $SITEINFO_LOGO_FOOTER ?>" alt="<?= $SITEINFO_TITLE ?>" />
					</a>
                </h2>

				<?php 
					$arrBanner = getBanner("site_main",1,"data"); 
				?>
				<?php foreach($arrBanner as $k => $v) : 
					$link = "javascript:void(0);";
					  $target = "";
					  if($v['b_link']){
					   $link = $v['b_link'];
					   if($v['b_target'] == "_self")
						$target = "_self";
					   else if($v['b_target'] == "_blank")
						$target = "_blank";
					 }

					 $b_image = $UPLOAD_WDIR_BANNER."/".$v['b_img'];
				?>
				<a href="<?= $b_image ?>" class="f_down_wrap--item down_kr" download="<?= ($HTML_LANG == 'en') ? 'Pltt_Company Introduction' : 'Pltt_Company Introduction' ?>"><i class="fa-regular fa-file" aria-hidden="true"></i><?= ($HTML_LANG == 'en') ? 'Company Profile' : '회사소개서' ?></a>
				<?php endforeach; ?>
            </li>
            <li>
                <?php if (count($MENU_ITEMS) > 0) : ?>
                    <ul class="no-footer__menu--wrap">
                        <?php foreach ($MENU_ITEMS as $di => $depth) :
                            $depth_active = $depth['isActive'] ? 'active' : '';
                        ?>
                            <li>
                                <a href="<?= $depth['path'] ?>" class="<?= $depth_active ?> poppins"><?= $depth['title'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        </ul>
        <div class="no-footer__center">
            <ul class="no-footer__info">
                <div class="flex-wrap">
                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Company Name' : '상호명' ?></b>
                        <p><?= ($HTML_LANG == 'en') ? 'PALETTE CO. LTD.' : '팔레트 주식회사' ?></p>
                    </li>

                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Email' : '이메일' ?></b>
                        <p><?=$SITEINFO_FOOTER_EMAIL?></p>
                    </li>
                </div>

                <div class="flex-wrap">
                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Phone' : '전화번호' ?></b>
                        <p><?=$SITEINFO_FOOTER_PHONE?></p>
                    </li>

                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'Ceo' : '대표자' ?></b>
                       <p><?= ($HTML_LANG == 'en') ? 'Jongkeun Lee' : $SITEINFO_FOOTER_OWNER ?></p>
                    </li>

                    <li>
                        <b><?= ($HTML_LANG == 'en') ? 'SSN' : '사업자등록번호' ?></b>
                        <p><?=$SITEINFO_FOOTER_SSN?></p>
                    </li>
                </div>
            </ul>
            <div class="sns-group">
				<img src="<?=IMG_PATH?>/award-logo.svg" alt="" class="award">

				<div class="inner-group">
					<a href="https://www.youtube.com/@pltt_official" target="_blank"><img src="/resource/images/icon/youtube.svg"></a>
					<a href="<?=$SITEINFO_HP?>" target="_blank"><img src="/resource/images/icon/naver.svg"></a>
					<a href="<?=$SITEINFO_PHONE?>" target="_blank"><img src="/resource/images/icon/insta.svg"></a>
					<a href="<?=$SITEINFO_CUSTOMER_CENTER_ABLE_TIME?>" target="_blank"><img src="/resource/images/icon/linked.svg"></a>
				</div>
            </div>
        </div>
        <ul class="no-footer__address">
            <li>
				<b><?= ($HTML_LANG == 'en') ? 'Head Office' : '본사' ?></b>
				<p><?= ($HTML_LANG == 'en') ? '51Gil, Nonhyunro 161Gil Gangnam -Gu, Seoul Korea' : $SITEINFO_FOOTER_ADDRESS ?></p>
			</li>

			<li>
				<b><?= ($HTML_LANG == 'en') ? 'Singapore Office' : '싱가포르 법인 지사' ?></b>
				<p><?= ($HTML_LANG == 'en') ? '8 Marina View #39-04, Asia Square Tower 1, Singapore 018960' : $SITEINFO_FOOTER_CHARGER ?></p>
			</li>

			<li>
				<b><?= ($HTML_LANG == 'en') ? 'India Office' : '인도 법인 지사' ?></b>
				<p><?= $SITEINFO_EMAIL ?></p>
			</li>
        </ul>
        <ul class="no-footer__bottom">
            <div class="flex-wrap">
			<a href="<?= ($HTML_LANG == 'en') ? '/en/pages/policy/policy.php' : '/pages/policy/policy.php' ?>"><?= ($HTML_LANG == 'en') ? 'Privacy Policy' : '개인정보처리방침' ?></a>
            </div>

            <address>&copy; PALETTE CO. LTD. All rights reserved.</address>
        </ul>
    </div>
</footer>

<div class="form-popup">
    <i class="fa-sharp fa-light fa-xmark-large p-close" style="color: #fff;"></i>
    <h2 class="title">
        <p>개인정보처리방침</p>
    </h2>
    <div class="content" data-lenis-prevent-wheel>
        <div class="scroll-box" data-lenis-prevent-wheel>

		<?php if ($HTML_LANG == 'en') : ?>
			<section class="sub-policy-term en">
				<p>Palette Inc. ("Company") places great importance on users' personal information and complies with relevant laws and regulations.</p>

				<div class="section">
					<h3>1. Personal Information Collected</h3>
					<p>1.1 The company collects only the minimum necessary personal information for service provision.</p>
					<ul>
						<li>1.1.1 During the use of third-party services linked with the company, we may collect users' SNS accounts, post and advertisement performance data, and ad execution information.</li>
					</ul>
					<p>1.2 The company collects personal information through the following methods:</p>
					<ul>
						<li>1.2.1 Through customer service (webpage, email, fax, phone, etc.)</li>
						<li>1.2.2 Offline events, seminars, etc.</li>
						<li>1.2.3 When personal information is provided by affiliated third-party services or organizations</li>
					</ul>
					<p>1.3 During service use (on PC, mobile web/app), information such as device info (OS, screen size, device ID, phone model), IP address, cookies, visit timestamps, abnormal usage logs, and service usage history may be automatically collected.</p>
					<ul>
						<li>1.3.1 Cookies are small text files sent from the web server to the user's browser used to operate the website.</li>
						<li>1.3.2 Cookies enable the web server to read saved cookies on the user's PC upon return visits and provide a more convenient service by maintaining personalized settings.</li>
						<li>1.3.3 Users can choose whether to allow cookies through their browser settings to allow all, confirm each time, or reject all cookies.</li>
					</ul>
				</div>

				<div class="section">
					<h3>2. Use of Collected Personal Information</h3>
					<p>2.1 The company uses personal information for member management, service development, and operation.</p>
					<ul>
						<li>2.1.1 To provide personalized content based on usage statistics and analysis</li>
						<li>2.1.2 For marketing and promotions such as event info, participation opportunities, and ad info</li>
						<li>2.1.3 To build a secure service environment for privacy protection</li>
						<li>2.1.4 For service improvement, new service development, inquiry handling, and notices</li>
						<li>2.1.5 To offer third-party integration services such as social media sharing and ad performance analysis</li>
					</ul>
				</div>

				<div class="section">
					<h3>3. Provision and Entrustment of Personal Information to Third Parties</h3>
					<p>3.1 The company provides users' personal information to third parties for service provision, operation, and development.</p>
					<table>
						<thead>
							<tr>
								<th>Trustee Company</th>
								<th>Entrusted Task</th>
								<th>Retention & Use Period</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Google Analytics</td>
								<td>User data analysis</td>
								<td rowspan="3" style="text-align: center; vertical-align: middle;">Until end of service agreement</td>
							</tr>
							<tr>
								<td>Meta</td>
								<td>Targeted advertising services</td>
							</tr>
							<tr>
								<td>Stibee</td>
								<td>Email sending service</td>
							</tr>
						</tbody>
					</table>
					<p>3.1.2 When users use external affiliated services, the company may use their personal information within the necessary scope after obtaining their consent.</p>
					<ul>
						<li>3.1.2.1 The company does not provide personal information collected via affiliates to third parties for purposes such as:</li>
						<ul>
							<li>3.1.2.1.1 Direct sale or resale of user data</li>
							<li>3.1.2.1.2 Credit, collateral, or lending</li>
							<li>3.1.2.1.3 Targeted ads based on internet behavior, interests, demographics</li>
							<li>3.1.2.1.4 Retargeting, personalized ads, or user-specific ads</li>
						</ul>
						<li>3.1.2.2 To collect YouTube account data (views, likes, dislikes, comments), the company uses the Google API Client (YouTube Data API). Users can revoke access via Google Third-Party Apps & Services. By using YouTube services, users are considered to have agreed to YouTube and Google’s policies.</li>
						<ul>
							<li>3.1.2.2.1 YouTube Terms of Service</li>
							<li>3.1.2.2.2 YouTube Privacy Settings</li>
							<li>3.1.2.2.3 YouTube API Terms</li>
							<li>3.1.2.2.4 Google Privacy Policy</li>
						</ul>
					</ul>
					<p>3.2 The company may provide personal information in emergencies such as disasters, infectious diseases, life-threatening events, or urgent property loss situations, or when legally obligated.</p>
				</div>

				<div class="section">
					<h3>4. Destruction of Personal Information</h3>
					<p>4.1 According to relevant laws, the company retains certain data for the following periods:</p>
					<ul>
						<li>4.1.1 Records of consumer complaints or disputes: 3 years</li>
						<li>4.1.2 Service visit logs: 3 months</li>
					</ul>
					<p>4.2 Personal information is destroyed using non-recoverable methods. Electronic files are securely deleted using technical means, and physical copies are shredded or incinerated.</p>
				</div>

				<div class="section">
					<h3>5. Efforts to Protect Personal Information</h3>
					<ul>
						<li>5.1 Measures against hacking and viruses</li>
						<li>5.1.1 Systems are installed in restricted areas with access controls, and backups and antivirus software are regularly maintained to prevent leaks or damage.</li>
						<li>5.2 Minimizing and training personnel handling personal data</li>
						<li>5.2.1 Only a minimum number of staff handle personal information, and they receive regular training. Password and access controls are strictly managed for systems storing or processing personal data.</li>
					</ul>
				</div>

				<div class="section">
					<h3>6. Personal Information Manager and Department</h3>
					<div class="contact-info">
						<p><strong>Name:</strong> Jongkeun Lee</p>
						<p><strong>Position:</strong> CEO</p>
						<p><strong>Phone:</strong> 02-568-9181</p>
						<p><strong>Email:</strong> <a href="mailto:hello@pltt.xyz">hello@pltt.xyz</a></p>
					</div>
					<p>6.2 For any reports or consultations regarding personal information violations, users may contact the following institutions:</p>
					<ul>
						<li>Personal Information Infringement Report Center: <a href="https://privacy.kisa.or.kr">https://privacy.kisa.or.kr</a> / 118</li>
						<li>Supreme Prosecutors' Office Cybercrime Division: <a href="https://spo.go.kr">https://spo.go.kr</a> / 1301</li>
						<li>Korean National Police Agency Cyber Bureau: <a href="https://ecrm.police.go.kr">https://ecrm.police.go.kr</a> / 182</li>
					</ul>
				</div>

				<div class="section">
					<h3>7. Notification of Policy Revisions</h3>
					<p>If there are additions, deletions, or changes to this policy, we will notify users at least 7 days in advance. If the changes are significant, such as a change in the type or purpose of personal information collected, we will notify users at least 30 days in advance.</p>
					<p>Announcement Date: January 2, 2025</p>
					<p>Effective Date: January 2, 2025</p>
				</div>
			</section>
		<?php else : ?>
		     <section class="sub-policy-term">
                <p>팔레트 주식회사(이하 "회사")는 이용자의 개인 정보를 매우 중요하게 생각하며 관련 법령 및 규정을 준수하고 있습니다.</p>

                <div class="section">
                    <h3>1. 수집하는 개인정보</h3>
                    <p>1.1 회사는 서비스 제공을 위해 필요한 최소한의 개인정보를 수집합니다.</p>
                    <ul>
                        <li>1.1.1 사용자가 회사와 연동 된 제3자 서비스를 이용하는 과정에서 사용자의 ‘SNS 계정, 게시물 및 광고의 성과 데이터, 광고 집행 정보’를 수집합니다.</li>
                    </ul>
                    <p>1.2 회사는 아래의 방법을 통해 개인정보를 수집합니다.</p>
                    <ul>
                        <li>1.2.1 고객센터를 통한 상담 과정에서 웹페이지, 메일, 팩스, 전화 등</li>
                        <li>1.2.2 오프라인에서 진행되는 이벤트, 세미나 등</li>
                        <li>1.2.3 회사와 제휴한 외부 서비스나 단체로부터 개인정보를 제공받은 경우</li>
                    </ul>
                    <p>1.3 서비스 이용 과정에서 PC웹, 모바일 웹/앱 이용 과정에서 단말기정보(OS, 화면사이즈, 디바이스 아이디, 폰 기종, 단말기 모델명), IP주소, 쿠키(cookie), 방문일시, 부정이용기록, 서비스 이용 기록 등의 정보가 자동으로 생성되어 수집될 수 있습니다.</p>
                    <ul>
                        <li>1.3.1 쿠키(cookie)는 웹사이트를 운영하는데 이용되는 서버가 이용자의 브라우저에 보내는 아주 작은 크기의 텍스트 파일입니다.</li>
                        <li>1.3.2 쿠키는 이용자가 다시 웹사이트를 방문할 경우 웹사이트 서버가 PC에 저장된 쿠키의 내용을 읽어 이용자가 설정한 서비스 이용환경을 유지하여 편리한 인터넷 서비스 이용을 제공할 수 있게 합니다.</li>
                        <li>1.3.3 이용자는 쿠키에 대한 선택권을 가지고 있으며, 웹브라우저에서 옵션을 설정함으로써 모든 쿠키를 허용하거나, 쿠키가 저장될 때마다 확인을 거치거나, 아니면 모든 쿠키의 저장을 거부할 수도 있습니다.</li>
                    </ul>
                </div>

                <div class="section">
                    <h3>2. 수집한 개인정보의 이용</h3>
                    <p>2.1 회사는 회원관리, 서비스 개발, 서비스 운영 등을 위해 개인정보를 이용합니다.</p>
                    <ul>
                        <li>2.1.1 서비스 이용 기록, 접속 빈도 및 서비스 이용에 대한 통계 및 분석에 따른 맞춤형 콘텐츠 제공에 활용</li>
                        <li>2.1.2 이벤트 정보 및 참여 기회 제공, 광고성 정보 제공 등 마케팅 및 프로모션에 활용</li>
                        <li>2.1.3 보안, 프라이버시 보호 측면의 안전한 서비스 환경 구축</li>
                        <li>2.1.4 기존 서비스 개선, 신규 서비스 개발, 문의사항 처리, 공지사항 전달 등의 서비스 개발 및 운영</li>
                        <li>2.1.5 소셜 미디어 공유, 광고 집행, 광고 결과 분석 등의 제 3자 연동 서비스의 제공</li>
                    </ul>
                </div>

                <div class="section">
                    <h3>3. 개인정보의 제3자 제공 및 위탁</h3>
                    <p>3.1 회사는 서비스 제공, 운영 및 개발을 목적으로 이용자의 개인정보를 제3자에게 제공하고 있습니다.</p>
                    <table>
                        <thead>
                            <tr>
                                <th>수탁 업체</th>
                                <th>위탁업무 내용</th>
                                <th>개인정보의 보유 및 이용기간</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Google Analytics</td>
                                <td>사용 데이터 분석</td>
                                <td rowspan="3" style="text-align: center; vertical-align: middle;">위탁계약 종료 시까지</td>
                            </tr>
                            <tr>
                                <td>Meta</td>
                                <td>맞춤형 타겟팅 광고 서비스</td>
                            </tr>
                            <tr>
                                <td>Stibee</td>
                                <td>이메일 발송 서비스</td>
                            </tr>
                        </tbody>
                    </table>
                <p>3.1.2 회사는 이용자가 외부 제휴사의 서비스를 이용하는 경우 서비스 사용에 필요한 범위 내에서 이용자의 동의를 얻은 후에 개인정보를 활용할 수 있습니다.</p>
                    <ul>
                        <li>3.1.2.1 단, 회사는 외부 제휴사를 통해 수집한 이용자의 개인정보를 다음의 목적으로 제3자에게 제공하지 않습니다.</li>
                        <ul>
                            <li>3.1.2.1.1 이용자 개인정보의 직접 또는 정보판매 업체에 판매</li>
                            <li>3.1.2.1.2 신용, 담보 등의 대출</li>
                            <li>3.1.2.1.3 인터넷 사용 패턴, 관심사, 인구통계 등에 기반한 타겟 광고</li>
                            <li>3.1.2.1.4 리타겟 광고, 개인화 광고, 사용자 광고 등</li>
                        </ul>
                        <li>3.1.2.2 회사는 YouTube 계정의 정보(조회수, 좋아요, 싫어요, 댓글) 수집을 위해 Google API Client(YouTube Data API)를 이용합니다. 회사의 API접근을 원치 않는 경우 다음 링크 Google Third-Party Apps & Services에서 권한을 해제할 수 있습니다. 이용자가 유튜브 서비스 이용 시, 유튜브와 구글의 정책 및 약관에 동의한 것으로 간주합니다.</li>
                        <ul>
                            <li>3.1.2.2.1 YouTube 서비스 약관</li>
                            <li>3.1.2.2.2 YouTube 개인 정보 보호 설정</li>
                            <li>3.1.2.2.3 YouTube API 약관</li>
                            <li>3.1.2.2.4 구글 개인정보 처리방침</li>
                        </ul>
                    </ul>
                    <p>3.2 그리고 관련 법령에 의거해 회사에 개인정보 제출 의무가 발생한 경우, 재난, 감염병, 생명 위험을 초래하는 사건사고, 급박한 재산 손실 등의 긴급상황이 발생하는 경우 이를 해소하기 위한 경우에 한하여 개인정보를 제공하고 있습니다.</p>
                </div>

                <div class="section">
                    <h3>4. 개인정보의 파기</h3>
                    <p>4.1 법령에서 일정기간 정보의 보관을 규정하는 경우는 아래와 같습니다.</p>
                    <ul>
                        <li>4.1.1 소비자의 불만 또는 분쟁처리에 관한 기록: 3년 보관</li>
                        <li>4.1.2 서비스 방문 기록: 3개월</li>
                    </ul>
                    <p>4.2 개인정보는 형태를 고려하여 재생이 불가능한 방법으로 파기하고 있습니다. 전자적 파일 형태의 경우 복구 및 재생이 되지 않도록 기술적인 방법을 이용하여 안전하게 삭제하며, 출력물 등은 분쇄하거나 소각하는 방식 등으로 파기합니다.</p>
                </div>

                <div class="section">
                    <h3>5. 개인정보 보호를 위한 노력</h3>
                    <ul>
                        <li>5.1 해킹, 바이러스 등에 대비한 대책</li>
                        <li>5.1.1 해킹이나 컴퓨터 바이러스 등에 의해 회원의 개인정보가 유출되거나 훼손되는 것을 막기 위해 외부로부터 접근이 통제된 구역에 시스템을 설치하고 있으며, 출입통제 절차를 수립/운영하고 있습니다. 또한 개인정보 훼손에 대비하여 자료를 수시로 백업하고 있고, 백신 프로그램을 설치하여 시스템이 최신 악성코드나 바이러스에 감염되지 않도록 노력하고 있습니다.</li>
                        <li>5.2 개인정보 취급 직원의 최소화 및 교육</li>
                        <li>5.2.1 회사는 개인정보를 취급하는 직원을 최소한으로 제한하고 있으며, 관련 직원들에 대한 수시 교육을 실시하여 개인정보 취급방침의 중요성을 인지시키고 있습니다. 또한 개인정보를 보관하는 데이터베이스 시스템과 개인정보를 처리하는 시스템에 대한 비밀번호의 생성과 변경, 그리고 접근할 수 있는 권한에 대한 체계적인 기준을 마련하여 적용하고 있습니다.</li>
                    </ul>
                </div>

                <div class="section">
                    <h3>6. 개인정보 보호책임자 및 담당부서</h3>
                    <div class="contact-info">
                        <p><strong>이름:</strong> 이종근</p>
                        <p><strong>소속:</strong> 대표</p>
                        <p><strong>전화:</strong> 02-568-9181</p>
                        <p><strong>메일:</strong> <a href="mailto:hello@pltt.xyz">hello@pltt.xyz</a></p>
                    </div>

					<p>6.2 기타 개인정보 침해에 대한 신고나 상담이 필요한 경우에 아래 기관에 문의 가능합니다.</p>
                    <ul>
                        <li>개인정보 침해 신고센터 : <a href="https://privacy.kisa.or.kr">https://privacy.kisa.or.kr</a> / (국번없이)118</li>
                        <li>대검찰청 사이버수사과 : <a href="https://spo.go.kr">https://spo.go.kr</a> / (국번없이)1301</li>                        
						<li>경찰청 사이버안전국 : <a href="https://ecrm.police.go.kr">https://ecrm.police.go.kr</a> / (국번없이)182</li>
                    </ul>
                </div>

                <div class="section">
                    <h3>7. 개정 전 고지 의무</h3>
                    <p>본 개인정보처리방침의 내용 추가, 삭제 및 수정이 있을 경우 개정 최소 7일 전에 사전에 안내를 하겠습니다. 다만, 수집하는 개인정보의 항목, 이용목적의 변경 등과 같이 이용자 권리의 중대한 변경이 발생할 때에는 최소 30일 전에 미리 알려드리겠습니다.</p>
                    <p>공고일자: 2025년 01월 02일</p>
                    <p>시행일자: 2025년 01월 02일</p>
                </div>
			</section>
		<?php endif; ?>
        </div>
    </div>
</div>

<div class="popup-bg"></div>

<iframe name="common_frame" width=0 height=0 frameborder=0 style="display:none;"></iframe>

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"> </script> 
<script type="text/javascript"> 
if (!wcs_add) var wcs_add={};
wcs_add["wa"] = "s_1341fe2cf61e";
if (!_nasa) var _nasa={};
if(window.wcs){
wcs.inflow();
wcs_do();
}
</script>

</body>

</html>