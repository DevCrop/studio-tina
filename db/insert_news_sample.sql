-- 스튜디오 티나 뉴스 샘플 데이터 (1개)
-- board_no: 25 (뉴스)

-- 기존 게시물 sort_no 밀기
UPDATE `nb_board` SET `sort_no` = `sort_no` + 1 WHERE `sitekey` = 'STTINA' AND `board_no` = 25;

-- 새 뉴스 추가
INSERT INTO `nb_board` (
    `no`, `sitekey`, `board_no`, `user_no`, `category_no`, `comment_cnt`, 
    `title`, `contents`, `regdate`, `read_cnt`, `thumb_image`, 
    `is_admin_writed`, `is_notice`, `is_secret`, `secret_pwd`, `write_name`, 
    `isFile`, `file_attach_1`, `file_attach_origin_1`, `file_attach_2`, `file_attach_origin_2`, 
    `file_attach_3`, `file_attach_origin_3`, `file_attach_4`, `file_attach_origin_4`, 
    `file_attach_5`, `file_attach_origin_5`, `is_admin_comment_yn`, `direct_url`, 
    `extra1`, `extra2`, `extra3`, `extra4`, `extra5`, `extra6`, `extra7`, `extra8`, `extra9`, `extra10`, 
    `extra11`, `extra12`, `extra13`, `extra14`, `extra15`, `extra16`, `extra17`, `extra18`, `extra19`, `extra20`, 
    `extra21`, `extra22`, `extra23`, `extra24`, `extra25`, `extra26`, `extra27`, `extra28`, `extra29`, `extra30`, 
    `sort_no`
) VALUES (
    150, 
    'STTINA', 
    25, 
    -1, 
    0, 
    0, 
    '스튜디오 티나, AI 기반 영상 제작 기술로 한국콘텐츠진흥원 선정', 
    '<div>
        <p>스튜디오 티나가 한국콘텐츠진흥원이 주관하는 2025년 \'AI 영상 콘텐츠 제작지원\' 사업 단편 부문에 선정되었습니다.</p>
        <p>이번 프로젝트에서는 영화 \'택시운전사\', \'고지전\', \'의형제\'의 장훈 감독이 연출과 각본에 참여하는 단편영화 &lt;아들니스&gt;를 제작하며, 스튜디오 티나는 AI 기반 영상 제작 기술을 총괄합니다.</p>
        <p>스튜디오 티나의 AI 풀파이프라인 기술은 기존 영상 제작 과정을 혁신적으로 개선하여 제작 시간을 단축하고 완성도 높은 결과물을 만들어내는 것으로 평가받고 있습니다.</p>
        <p>회사 관계자는 "이번 선정을 통해 AI 영상 제작 기술의 가능성을 더욱 확장할 수 있게 되었다"며 "앞으로도 혁신적인 기술로 콘텐츠 산업에 기여하겠다"고 밝혔습니다.</p>
    </div>', 
    '2025-10-13 16:00:00', 
    0, 
    '68ecacca8a4050.63791605.png', 
    'N', 
    'N', 
    'N', 
    NULL, 
    '관리자', 
    'N', 
    NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
    'N', 
    'studio-tina-selected-kocca-ai-content-production-2025', 
    '', '', '', '', '', '', '', '', '', '', 
    '', '', '', '', '', '', '', '', '', '', 
    '', '', '', '', '', '', '', '', '', '', 
    1
);

