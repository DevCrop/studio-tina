-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- 호스트: db:3306
-- 생성 시간: 25-10-14 07:03
-- 서버 버전: 8.0.43
-- PHP 버전: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `nineonelabs`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_admin`
--

CREATE TABLE `nb_admin` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `uid` varchar(25) NOT NULL COMMENT '아이디',
  `upwd` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '패스워드',
  `uname` varchar(25) NOT NULL COMMENT '관리자명',
  `active_status` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '사용여부',
  `role_id` int NOT NULL DEFAULT '3' COMMENT '권한 ID (nb_roles 참조)',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='관리자 계정 관리';

--
-- 테이블의 덤프 데이터 `nb_admin`
--

INSERT INTO `nb_admin` (`no`, `sitekey`, `uid`, `upwd`, `uname`, `active_status`, `role_id`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'STTINA', 'tmaster', '$2y$10$JxWvgydNpaNoCV0HG1RCLOSLBxXpdkm5jwptaogaJ7uo5hSUE4dqu', '관리자', 'Y', 2, 'nineonelabs@co.kr', '010-1111-3333', '2025-07-31 08:23:14', '2025-10-13 07:09:28');

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_analytics`
--

CREATE TABLE `nb_analytics` (
  `id` bigint UNSIGNED NOT NULL,
  `year` smallint UNSIGNED NOT NULL,
  `month` tinyint UNSIGNED NOT NULL,
  `day` tinyint UNSIGNED NOT NULL,
  `time` time NOT NULL,
  `user_agent` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referrer` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_banner`
--

CREATE TABLE `nb_banner` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `b_loc` varchar(64) NOT NULL COMMENT '노출위치 main, main_top_right 등',
  `b_img` varchar(64) NOT NULL COMMENT '이미지파일명',
  `b_link` varchar(128) NOT NULL COMMENT '배너링크',
  `b_target` enum('_none','_self','_blank') NOT NULL DEFAULT '_self' COMMENT '링크 형식',
  `b_view` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '관리자명',
  `b_title` varchar(50) NOT NULL COMMENT '배너 제목',
  `b_idx` int NOT NULL DEFAULT '0' COMMENT '순서',
  `b_none_limit` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '무기한 배너여부(Y:무기한, 기한)',
  `b_sdate` date DEFAULT NULL COMMENT '시작일 - 00 시부터 시작',
  `b_edate` date DEFAULT NULL COMMENT '종료일 - 23시 59분 59초까지',
  `b_rdate` datetime DEFAULT NULL COMMENT '배너등록일',
  `b_desc` varchar(256) DEFAULT NULL COMMENT '배너설명(필요한경우)',
  `b_img_mobile` varchar(64) DEFAULT NULL,
  `b_contents` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='배너 관리';

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_banners`
--

CREATE TABLE `nb_banners` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '관리용 제목',
  `banner_type` int NOT NULL COMMENT '전역 변수 banner_types의 키 (int)',
  `is_active` int DEFAULT '1' COMMENT '전역 변수 $is_active의 값 (0=숨김, 1=노출)',
  `start_at` varchar(20) DEFAULT NULL,
  `end_at` varchar(20) DEFAULT NULL,
  `description` text COMMENT '설명글',
  `has_link` int DEFAULT '2' COMMENT '전역 변수 $has_link의 값 (1=링크, 2=비링크)',
  `link_url` varchar(1024) DEFAULT NULL COMMENT '링크 URL',
  `duration` int DEFAULT '6' COMMENT '지속 시간 (초)',
  `banner_image` varchar(1024) DEFAULT NULL COMMENT '배너 이미지 경로',
  `branch_id` int DEFAULT NULL COMMENT 'nb_branches.id 참조, NULL이면 공통 배너',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sort_no` int NOT NULL DEFAULT '0' COMMENT '정렬 순서',
  `is_unlimited` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = 무기한 노출, 0 = 노출 기간 사용',
  `is_target` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=현재창(_self), 1=새창(_blank)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_board`
--

CREATE TABLE `nb_board` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `board_no` int NOT NULL COMMENT '게시판 고유번호',
  `user_no` int NOT NULL DEFAULT '0' COMMENT '회원 고유번호',
  `category_no` int NOT NULL DEFAULT '0' COMMENT '게시판 카테고리 번호',
  `comment_cnt` int NOT NULL DEFAULT '0' COMMENT '등록된 댓글수',
  `title` varchar(200) NOT NULL COMMENT '제목',
  `contents` text NOT NULL COMMENT '내용',
  `regdate` datetime DEFAULT NULL COMMENT '등록일',
  `read_cnt` int NOT NULL DEFAULT '0' COMMENT '조회수',
  `thumb_image` varchar(125) DEFAULT NULL COMMENT '썸네일 이미지(게시판에 따라 필요한 경우)',
  `is_admin_writed` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '관리자작성 여부',
  `is_notice` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '공지여부',
  `is_secret` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '비밀글여부',
  `secret_pwd` varchar(64) DEFAULT NULL COMMENT '비밀글 비밀번호',
  `write_name` varchar(25) DEFAULT NULL COMMENT '작성자',
  `isFile` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '첨부파일이 있는지 여부',
  `file_attach_1` varchar(125) DEFAULT NULL COMMENT '파일첨부',
  `file_attach_origin_1` varchar(125) DEFAULT NULL COMMENT '원래 파일명',
  `file_attach_2` varchar(125) DEFAULT NULL,
  `file_attach_origin_2` varchar(125) DEFAULT NULL,
  `file_attach_3` varchar(125) DEFAULT NULL,
  `file_attach_origin_3` varchar(125) DEFAULT NULL,
  `file_attach_4` varchar(125) DEFAULT NULL,
  `file_attach_origin_4` varchar(125) DEFAULT NULL,
  `file_attach_5` varchar(125) DEFAULT NULL,
  `file_attach_origin_5` varchar(125) DEFAULT NULL,
  `is_admin_comment_yn` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '관리자가 댓글 달았는지 여부 ',
  `direct_url` varchar(255) DEFAULT NULL COMMENT '바로연결할 URL',
  `extra1` varchar(50) DEFAULT NULL,
  `extra2` varchar(50) DEFAULT NULL,
  `extra3` varchar(50) DEFAULT NULL,
  `extra4` varchar(50) DEFAULT NULL,
  `extra5` varchar(50) DEFAULT NULL,
  `extra6` varchar(50) DEFAULT NULL,
  `extra7` varchar(50) DEFAULT NULL,
  `extra8` varchar(50) DEFAULT NULL,
  `extra9` varchar(50) DEFAULT NULL,
  `extra10` varchar(50) DEFAULT NULL,
  `extra11` varchar(50) DEFAULT NULL,
  `extra12` varchar(50) DEFAULT NULL,
  `extra13` varchar(50) DEFAULT NULL,
  `extra14` varchar(50) DEFAULT NULL,
  `extra15` varchar(50) DEFAULT NULL,
  `extra16` varchar(50) DEFAULT NULL,
  `extra17` varchar(50) DEFAULT NULL,
  `extra18` varchar(50) DEFAULT NULL,
  `extra19` varchar(50) DEFAULT NULL,
  `extra20` varchar(50) DEFAULT NULL,
  `extra21` varchar(50) DEFAULT NULL,
  `extra22` varchar(50) DEFAULT NULL,
  `extra23` varchar(50) DEFAULT NULL,
  `extra24` varchar(50) DEFAULT NULL,
  `extra25` varchar(50) DEFAULT NULL,
  `extra26` varchar(50) DEFAULT NULL,
  `extra27` varchar(50) DEFAULT NULL,
  `extra28` varchar(50) DEFAULT NULL,
  `extra29` varchar(50) DEFAULT NULL,
  `extra30` varchar(50) DEFAULT NULL,
  `sort_no` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='통합 게시판';

--
-- 테이블의 덤프 데이터 `nb_board`
--

INSERT INTO `nb_board` (`no`, `sitekey`, `board_no`, `user_no`, `category_no`, `comment_cnt`, `title`, `contents`, `regdate`, `read_cnt`, `thumb_image`, `is_admin_writed`, `is_notice`, `is_secret`, `secret_pwd`, `write_name`, `isFile`, `file_attach_1`, `file_attach_origin_1`, `file_attach_2`, `file_attach_origin_2`, `file_attach_3`, `file_attach_origin_3`, `file_attach_4`, `file_attach_origin_4`, `file_attach_5`, `file_attach_origin_5`, `is_admin_comment_yn`, `direct_url`, `extra1`, `extra2`, `extra3`, `extra4`, `extra5`, `extra6`, `extra7`, `extra8`, `extra9`, `extra10`, `extra11`, `extra12`, `extra13`, `extra14`, `extra15`, `extra16`, `extra17`, `extra18`, `extra19`, `extra20`, `extra21`, `extra22`, `extra23`, `extra24`, `extra25`, `extra26`, `extra27`, `extra28`, `extra29`, `extra30`, `sort_no`) VALUES
(150, 'STTINA', 25, -1, 0, 0, '스튜디오 티나, AI 기반 영상 제작 기술로 한국콘텐츠진흥원 선정', '<div><p>스튜디오 티나가 한국콘텐츠진흥원이 주관하는 2025년 \'AI 영상 콘텐츠 제작지원\' 사업 단편 부문에 선정되었습니다.</p><p>이번 프로젝트에서는 영화 \'택시운전사\', \'고지전\', \'의형제\'의 장훈 감독이 연출과 각본에 참여하는 단편영화 &lt;아들니스&gt;를 제작하며, 스튜디오 티나는 AI 기반 영상 제작 기술을 총괄합니다.</p><p>스튜디오 티나의 AI 풀파이프라인 기술은 기존 영상 제작 과정을 혁신적으로 개선하여 제작 시간을 단축하고 완성도 높은 결과물을 만들어내는 것으로 평가받고 있습니다.</p></div>', '2025-10-13 16:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'studio-tina-selected-kocca-ai-content-production-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 8),
(151, 'STTINA', 25, -1, 0, 0, '단편영화 \'사랑의 아포칼립스\' 서울예술대학교 아트프로젝트 선정', '<div><p>스튜디오 티나가 제작에 참여한 단편영화 &lt;사랑의 아포칼립스&gt;가 서울예술대학교 2025년 미디어컨텐츠산업 아트프로젝트에 선정되었습니다.</p><p>영화 \'극한직업\'의 문충일 작가가 연출과 각본에 참여한 이번 작품은 AI 영상 기술과 전통적인 영화 제작 기법을 조화롭게 결합한 것이 특징입니다.</p><p>스튜디오 티나는 AI 기반 배경 생성과 후반 작업을 담당하며 완성도 높은 영상미를 구현했습니다.</p></div>', '2025-10-10 14:30:00', 1, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'love-apocalypse-seoul-art-university-project-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 9),
(152, 'STTINA', 25, -1, 0, 0, '숏폼드라마 \'자매전쟁\' 기술총괄 참여', '<div><p>스튜디오 티나가 숏폼드라마 &lt;자매전쟁&gt; 제작에 기술총괄로 참여합니다.</p><p>이번 프로젝트에서는 AI 기반 편집 자동화 시스템과 실시간 렌더링 기술을 활용하여 빠른 제작 속도와 높은 완성도를 동시에 달성했습니다.</p><p>숏폼 콘텐츠에 최적화된 스튜디오 티나의 기술력이 새로운 콘텐츠 제작 방식을 제시할 것으로 기대됩니다.</p></div>', '2025-09-28 11:20:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'short-drama-sisters-war-technical-director-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 10),
(153, 'STTINA', 25, -1, 0, 0, 'Netflix 오리지널 시리즈 VFX 파트너십 체결', '<div><p>스튜디오 티나가 글로벌 OTT 플랫폼 Netflix와 VFX 파트너십을 체결했습니다.</p><p>이번 협약을 통해 스튜디오 티나는 Netflix 오리지널 한국 시리즈의 시각효과 제작에 참여하게 되며, AI 기반 VFX 기술을 활용한 혁신적인 영상미를 선보일 예정입니다.</p><p>스튜디오 티나 관계자는 \"글로벌 플랫폼과의 협력을 통해 K-콘텐츠의 기술적 경쟁력을 한층 강화할 수 있게 되었다\"고 밝혔습니다.</p></div>', '2025-09-15 15:40:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'netflix-original-series-vfx-partnership-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 11),
(154, 'STTINA', 25, -1, 0, 0, '제59회 백상예술대상 기술상 수상', '<div><p>스튜디오 티나가 제59회 백상예술대상 기술상을 수상했습니다.</p><p>영화 &lt;더 문&gt;의 AI 기반 VFX 제작에 기여한 공로를 인정받아 이번 수상의 영예를 안았습니다.</p><p>심사위원단은 \"AI 기술과 전통적인 VFX 기법의 조화로운 결합이 한국 영상 산업의 기술적 발전을 이끌었다\"고 평가했습니다.</p><p>스튜디오 티나는 앞으로도 기술 혁신을 통해 영상 산업 발전에 기여하겠다는 포부를 밝혔습니다.</p></div>', '2025-08-20 18:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'baeksang-arts-awards-technical-award-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 12),
(155, 'STTINA', 25, -1, 0, 0, 'AI 영상 제작 툴킷 v2.0 정식 출시', '<div><p>스튜디오 티나가 자체 개발한 AI 영상 제작 툴킷 v2.0을 정식 출시했습니다.</p><p>이번 버전은 실시간 렌더링 속도가 기존 대비 300% 향상되었으며, 자동 편집 기능이 대폭 강화되었습니다.</p><p>특히 딥러닝 기반의 장면 인식 기술을 적용하여 편집자의 작업 효율을 획기적으로 개선했습니다.</p><p>업계 관계자들은 \"중소 제작사도 고품질 영상을 빠르게 제작할 수 있는 환경이 조성되었다\"며 긍정적인 반응을 보이고 있습니다.</p></div>', '2025-07-12 10:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'ai-video-production-toolkit-v2-release-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 13),
(156, 'STTINA', 25, -1, 0, 0, '스튜디오 티나, 강남 신사옥으로 이전', '<div><p>스튜디오 티나가 강남구 테헤란로에 위치한 신사옥으로 이전했습니다.</p><p>500평 규모의 새 사옥에는 최신 AI 렌더링 장비와 프로덕션 스튜디오가 구축되어 대규모 프로젝트 수행이 가능해졌습니다.</p><p>특히 4K/8K 영상 제작을 위한 전용 렌더팜과 실시간 협업이 가능한 스마트 워크스페이스를 갖추었습니다.</p><p>회사 측은 \"확장된 공간과 최신 설비를 바탕으로 더 많은 혁신적인 프로젝트를 진행할 계획\"이라고 밝혔습니다.</p></div>', '2025-06-05 13:30:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'studio-tina-gangnam-new-office-relocation-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 14),
(157, 'STTINA', 25, -1, 0, 0, 'tvN 드라마 \'시간의 저편\' AI 배경 제작 참여', '<div><p>스튜디오 티나가 tvN 드라마 &lt;시간의 저편&gt;의 AI 배경 제작에 참여했습니다.</p><p>SF 장르 특성상 현실에 존재하지 않는 미래 도시와 우주 공간을 구현해야 했던 이번 프로젝트에서 AI 기반 배경 생성 기술이 큰 역할을 했습니다.</p><p>제작진은 \"촬영 비용을 30% 절감하면서도 시각적 완성도를 높일 수 있었다\"며 만족감을 표했습니다.</p></div>', '2025-05-18 16:20:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'tvn-drama-beyond-time-ai-background-production-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 15),
(158, 'STTINA', 25, -1, 0, 0, '부산국제영화제 VR 콘텐츠 제작 참여', '<div><p>스튜디오 티나가 부산국제영화제 VR 시네마 부문 공식 초청작 제작에 참여했습니다.</p><p>AI 기반 360도 영상 생성 기술과 실시간 렌더링을 활용하여 몰입감 높은 VR 콘텐츠를 구현했습니다.</p><p>관람객들은 \"기존 VR 콘텐츠와는 차원이 다른 시각적 경험\"이라며 높은 평가를 내렸습니다.</p><p>스튜디오 티나는 이번 성과를 바탕으로 VR/AR 콘텐츠 제작 영역을 확대할 계획입니다.</p></div>', '2025-04-22 14:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'busan-film-festival-vr-content-production-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 16),
(159, 'STTINA', 25, -1, 0, 0, '문화체육관광부 우수 콘텐츠 기업 선정', '<div><p>스튜디오 티나가 문화체육관광부가 선정하는 2025년 우수 콘텐츠 기업에 이름을 올렸습니다.</p><p>AI 기술을 활용한 혁신적인 영상 제작 방식과 콘텐츠 산업 발전에 기여한 공로를 인정받았습니다.</p><p>선정 기업에는 R&D 지원금과 해외 진출 지원 등 다양한 혜택이 제공됩니다.</p></div>', '2025-03-10 11:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'ministry-culture-sports-tourism-excellent-company-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 17),
(160, 'STTINA', 25, -1, 0, 0, '영상 AI 전문 인력 30명 추가 채용', '<div><p>스튜디오 티나가 사업 확장에 따라 영상 AI 전문 인력 30명을 추가로 채용합니다.</p><p>AI 엔지니어, 딥러닝 연구원, VFX 아티스트 등 다양한 직군에서 인재를 모집하며, 업계 최고 수준의 복지와 연봉을 제시할 예정입니다.</p><p>특히 신입 개발자를 위한 체계적인 교육 프로그램과 멘토링 시스템을 운영하여 AI 영상 전문가 양성에도 힘쓸 계획입니다.</p></div>', '2025-02-14 09:30:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'ai-video-specialist-recruitment-30-positions-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 18),
(161, 'STTINA', 25, -1, 0, 0, 'AI 모션 캡처 시스템 구축 완료', '<div><p>스튜디오 티나가 최신 AI 모션 캡처 시스템 구축을 완료했습니다.</p><p>기존 모션 캡처 장비와 달리 별도의 마커 없이도 정확한 동작 추적이 가능하며, 실시간으로 3D 캐릭터에 적용할 수 있습니다.</p><p>이 시스템은 메타휴먼 제작과 가상 프로덕션에 활용되어 제작 효율을 크게 높일 것으로 기대됩니다.</p></div>', '2025-01-28 15:45:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'ai-motion-capture-system-completion-2025', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 19),
(162, 'STTINA', 25, -1, 0, 0, '서울대학교 AI 연구소와 산학협력 MOU 체결', '<div><p>스튜디오 티나가 서울대학교 AI 연구소와 산학협력 업무협약을 체결했습니다.</p><p>양측은 AI 영상 기술 공동 연구, 인재 양성, 기술 이전 등에서 협력하기로 합의했습니다.</p><p>특히 차세대 영상 생성 AI 모델 개발과 실시간 렌더링 기술 고도화를 위한 공동 연구가 진행될 예정입니다.</p><p>연구 성과는 학술 논문 발표와 함께 실제 콘텐츠 제작에도 적용될 계획입니다.</p></div>', '2024-12-15 10:20:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'seoul-national-university-ai-lab-mou-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 20),
(163, 'STTINA', 25, -1, 0, 0, '중소벤처기업부 기술혁신대상 수상', '<div><p>스튜디오 티나가 중소벤처기업부가 주관하는 2024년 기술혁신대상을 수상했습니다.</p><p>AI 기반 영상 편집 자동화 시스템 개발로 콘텐츠 제작 산업의 혁신을 이끈 공로를 인정받았습니다.</p><p>심사위원단은 \"중소 규모 제작사도 고품질 콘텐츠를 효율적으로 만들 수 있는 생태계를 조성했다\"며 높이 평가했습니다.</p></div>', '2024-11-08 17:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'mss-technology-innovation-award-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 21),
(164, 'STTINA', 25, -1, 0, 0, '일본 도쿄 지사 설립으로 글로벌 확장', '<div><p>스튜디오 티나가 일본 도쿄에 해외 첫 지사를 설립했습니다.</p><p>일본 애니메이션 및 영상 제작 시장 진출을 목표로 현지 파트너사들과 협력 체계를 구축할 예정입니다.</p><p>도쿄 지사는 일본 시장 특화 콘텐츠 제작 지원과 함께 현지 기술 인력 채용도 진행할 계획입니다.</p><p>회사 측은 \"2026년까지 미주 및 유럽 시장에도 진출할 것\"이라며 글로벌 확장 계획을 밝혔습니다.</p></div>', '2024-10-20 13:15:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'tokyo-branch-office-global-expansion-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 22),
(165, 'STTINA', 25, -1, 0, 0, 'CJ ENM과 AI 콘텐츠 제작 전략적 파트너십 체결', '<div><p>스튜디오 티나가 국내 최대 콘텐츠 기업 CJ ENM과 전략적 파트너십을 체결했습니다.</p><p>양사는 AI 기술을 활용한 드라마, 예능, 영화 등 다양한 장르의 콘텐츠 공동 제작에 협력하기로 했습니다.</p><p>특히 CJ ENM의 콘텐츠 기획력과 스튜디오 티나의 AI 기술력이 결합하여 글로벌 시장을 겨냥한 차별화된 콘텐츠를 선보일 예정입니다.</p></div>', '2024-09-05 11:40:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'cj-enm-strategic-partnership-ai-content-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 23),
(166, 'STTINA', 25, -1, 0, 0, '숏폼 콘텐츠 플랫폼 \'티나TV\' 정식 런칭', '<div><p>스튜디오 티나가 자체 숏폼 콘텐츠 플랫폼 \'티나TV\'를 정식 런칭했습니다.</p><p>AI 기반 추천 알고리즘과 크리에이터 지원 시스템을 갖춘 티나TV는 누구나 쉽게 고품질 숏폼 콘텐츠를 제작하고 공유할 수 있는 환경을 제공합니다.</p><p>특히 AI 편집 도구를 무료로 제공하여 일반 사용자도 전문가 수준의 영상을 만들 수 있습니다.</p><p>베타 테스트 기간 동안 10만 명 이상의 크리에이터가 등록하며 뜨거운 관심을 받았습니다.</p></div>', '2024-07-18 14:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'tina-tv-short-form-platform-launch-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 24),
(167, 'STTINA', 25, -1, 0, 0, 'AI 가상 배우 생성 기술 개발 착수', '<div><p>스튜디오 티나가 차세대 AI 가상 배우 생성 기술 개발에 착수했습니다.</p><p>실제 배우의 동작과 표정을 학습하여 자연스러운 연기가 가능한 디지털 휴먼을 만드는 것이 목표입니다.</p><p>이 기술이 상용화되면 촬영 일정 조율, 배우 섭외 등의 어려움을 해결하고 제작 비용도 크게 절감할 수 있을 것으로 기대됩니다.</p><p>2026년 상반기 프로토타입 공개를 목표로 연구 개발을 진행 중입니다.</p></div>', '2024-05-30 16:30:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'ai-virtual-actor-technology-development-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 25),
(168, 'STTINA', 25, -1, 0, 0, '시리즈 B 투자 유치 100억원 달성', '<div><p>스튜디오 티나가 시리즈 B 라운드에서 100억원 규모의 투자를 유치했습니다.</p><p>국내 주요 벤처캐피털과 전략적 투자자들이 참여한 이번 투자는 AI 영상 기술 R&D 강화와 글로벌 시장 진출에 사용될 예정입니다.</p><p>투자사 관계자는 \"AI 기반 콘텐츠 제작 시장의 폭발적 성장이 예상되는 가운데 스튜디오 티나의 기술력과 실행력을 높이 평가했다\"고 밝혔습니다.</p><p>회사 측은 이번 투자를 바탕으로 2025년 매출 500억원 달성을 목표로 하고 있습니다.</p></div>', '2024-04-12 10:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'series-b-investment-10-billion-won-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 26),
(169, 'STTINA', 25, -1, 0, 0, 'KAIST AI 대학원과 공동 연구 프로젝트 시작', '<div><p>스튜디오 티나가 KAIST AI 대학원과 공동 연구 프로젝트를 시작했습니다.</p><p>차세대 영상 생성 AI 모델 개발을 주제로 3년간 진행되는 이번 연구는 정부 R&D 과제로도 선정되었습니다.</p><p>연구팀은 텍스트나 간단한 스케치만으로 영화급 퀄리티의 영상을 생성할 수 있는 AI 모델 개발을 목표로 하고 있습니다.</p><p>연구 성과는 국제 학술지 발표는 물론 실제 콘텐츠 제작 현장에도 즉시 적용될 예정입니다.</p></div>', '2024-02-25 09:00:00', 0, '68ecacca8a4050.63791605.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'kaist-ai-graduate-school-joint-research-2024', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 27),
(170, 'STTINA', 26, -1, 27, 0, 'Short Drama SPERMAN(스퍼맨)', '&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;KOCCA ‘2025년 AI 영상 콘텐츠 제작지원 장편부문’ 선정작&lt;/div&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;사랑하는 여자친구와 드디어 첫날밤을 맞게 된 김기두 갑자기 정체모를 사람들에게 납치되고 자신이 슈퍼정자를 가진 능력자라는 얘기를 듣게 되는데...&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;', '2025-10-14 04:44:26', 0, '68eddb914bdf88.00643643.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '', '숏드라마 (45부작)', 'NAVER CHZZK(네이버 치치직) ', 'STUDIO TINA, STUDIO X+U', '네이버 웹툰 ‘스퍼맨’ 작가: 하일권 ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 7),
(171, 'STTINA', 26, -1, 27, 0, 'Short Drama 자매전쟁 ', '<div><p>단 하나로 인정받고 싶었던 두 소녀, 예술고등학교 1등과 2등을 앞다투는 </p><p>\'원리온\'과 \'추해라\'. \'진짜\'가 되기 위한 천재 소녀들의 치명적인 전쟁이 시작된다.</p></div>', '2025-10-14 05:19:30', 0, '68eddd62567e23.88802036.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '', '숏드라마 (40부작)', 'NAVER CHZZK(네이버 치치직) ', 'STUDIO TINA, STUDIO X+U', '네이버 웹툰 ‘자매전쟁’ 작가: 기맹기', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 6),
(172, 'STTINA', 26, -1, 28, 0, 'AI Film 사랑의 아포칼립스 ', '<div><p>좀비 아포칼립스 속, 유치하고 엉뚱한 연애 감정과 갈등이 계속되는 남녀의 코믹한생존기. </p><p>사랑하고 싸우며 끝까지 살아남으려는 인간의 아이러니 한 본성이야기</p></div>', '2025-10-14 05:20:15', 0, '68eddd8fe9de43.49625392.png', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '', '영화(AI영화)', '', 'STUDIO TINA', '', '', '문충일', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 5),
(173, 'STTINA', 26, -1, 28, 0, 'AI Film 신기록 ', '<div><p>한국의 설화들을 재해석해 만들어낸 새로운 비주얼의 귀신들이 등장하고,</p><p> 귀신들의 안타까운 사연을 풀어가는 판타지 사극 장르영화</p></div>', '2025-10-14 05:20:59', 0, '', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '', '영화(AI영화)', '', 'STUDIO TINA', '레진코믹스 웹툰 ‘신기록', '', '김성수 ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 4),
(174, 'STTINA', 26, -1, 29, 0, '히든아이', '&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;p&gt;경찰 시점으로 보는 범죄 현장, 전무후무 범죄 분석 코멘터리쇼&lt;/p&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;', '2025-10-14 05:21:34', 0, '68edddde59fcd9.66579599.png', 'N', 'N', 'N', NULL, '관리자', 'N', '68eddf71655a94.92548918.png', 'image 51.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'https://www.youtube.com/embed/tLLg5PsofD0?si=qpk0TpZlutd1xU5c', '예능프로그램', 'MBC every1 ', 'STUDIO TINA', '', '김성주, 박하선, 권일용, 표창원, 이대우, 소유, 김동현', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 3),
(175, 'STTINA', 26, -1, 30, 0, 'SACCIBIO- McCoom 7', '<div><span style=\"font-family: \'Noto Sans KR\', sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; text-align: justify;\">전 과정 생성형 AI 기술을 활용한 Commercial Film</span></div>', '2025-10-14 05:21:59', 0, '', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 2),
(176, 'STTINA', 26, -1, 30, 0, 'SPECULUM EYEWEAR “JEONGHAN, THE 8 of SEVENTEEN', '<div><p>SPECULUM EYEWEAR BRAND Flim&nbsp;</p></div>', '2025-10-14 05:22:20', 0, '', 'N', 'N', 'N', NULL, '관리자', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '', '', '', '', '', 'JEONGHAN, THE 8 of SEVENTEEN', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_board_category`
--

CREATE TABLE `nb_board_category` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `board_no` int NOT NULL COMMENT '게시판 고유번호',
  `name` varchar(125) NOT NULL COMMENT '카테고리명',
  `sort_no` int NOT NULL DEFAULT '0' COMMENT '정렬번호'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 테이블의 덤프 데이터 `nb_board_category`
--

INSERT INTO `nb_board_category` (`no`, `sitekey`, `board_no`, `name`, `sort_no`) VALUES
(27, 'STTINA', 26, 'Drama', 1),
(28, 'STTINA', 26, 'Film', 2),
(29, 'STTINA', 26, 'Broadcast', 3),
(30, 'STTINA', 26, 'AI CF', 4);

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_board_comment`
--

CREATE TABLE `nb_board_comment` (
  `no` int UNSIGNED NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `parent_no` int NOT NULL COMMENT '게시물 부모 번호',
  `user_no` int NOT NULL DEFAULT '0' COMMENT '회원 고유번호',
  `write_name` varchar(25) DEFAULT NULL COMMENT '작성자',
  `regdate` datetime NOT NULL COMMENT '등록일',
  `contents` text NOT NULL COMMENT '내용',
  `isAdmin` varchar(1) NOT NULL DEFAULT 'N',
  `pwd` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_board_lev_manage`
--

CREATE TABLE `nb_board_lev_manage` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `board_no` int NOT NULL COMMENT '게시판 고유번호',
  `lev_no` int NOT NULL COMMENT '등급 번호',
  `role_write` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '메뉴 쓰기 권한',
  `role_edit` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '메뉴 수정 권한',
  `role_view` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '메뉴 상세보기 권한',
  `role_list` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '메뉴 목록보기 권한',
  `role_delete` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '삭제 권한',
  `role_comment` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '댓글쓰기 권한'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_board_manage`
--

CREATE TABLE `nb_board_manage` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `title` varchar(50) NOT NULL COMMENT '게시판명',
  `skin` varchar(3) NOT NULL COMMENT '게시판종류(bbs : 일반, img : 갤러리 , web : 웹진)',
  `regdate` datetime NOT NULL COMMENT '등록일',
  `top_banner_image` varchar(255) DEFAULT NULL COMMENT '상단배너 이미지',
  `contents` text,
  `view_yn` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '사용여부',
  `secret_yn` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '비밀글기능 활성화',
  `sort_no` int NOT NULL DEFAULT '0' COMMENT '정렬번호',
  `list_size` int NOT NULL DEFAULT '20' COMMENT '목록출력수',
  `block_size` int NOT NULL DEFAULT '0' COMMENT '페이지 카운',
  `fileattach_yn` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '파일첨부 여부',
  `fileattach_cnt` int NOT NULL DEFAULT '0' COMMENT '파일첨부 갯수',
  `comment_yn` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '댓글기능 활성화',
  `depth1` varchar(20) DEFAULT NULL COMMENT '1뎁스',
  `depth2` varchar(20) DEFAULT NULL COMMENT '2뎁스',
  `depth3` varchar(20) DEFAULT NULL COMMENT '3뎁스',
  `lnb_path` varchar(50) DEFAULT NULL COMMENT '좌측 메뉴 경로',
  `category_yn` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '카테고리 사용여부',
  `extra_match_field1` varchar(100) DEFAULT NULL,
  `extra_match_field2` varchar(100) DEFAULT NULL,
  `extra_match_field3` varchar(100) DEFAULT NULL,
  `extra_match_field4` varchar(100) DEFAULT NULL,
  `extra_match_field5` varchar(100) DEFAULT NULL,
  `extra_match_field6` varchar(100) DEFAULT NULL,
  `extra_match_field7` varchar(100) DEFAULT NULL,
  `extra_match_field8` varchar(100) DEFAULT NULL,
  `extra_match_field9` varchar(100) DEFAULT NULL,
  `extra_match_field10` varchar(100) DEFAULT NULL,
  `extra_match_field11` varchar(100) DEFAULT NULL,
  `extra_match_field12` varchar(100) DEFAULT NULL,
  `extra_match_field13` varchar(100) DEFAULT NULL,
  `extra_match_field14` varchar(100) DEFAULT NULL,
  `extra_match_field15` varchar(100) DEFAULT NULL,
  `extra_match_field16` varchar(255) DEFAULT NULL,
  `extra_match_field17` varchar(255) DEFAULT NULL,
  `extra_match_field18` varchar(255) DEFAULT NULL,
  `extra_match_field19` varchar(255) DEFAULT NULL,
  `extra_match_field20` varchar(255) DEFAULT NULL,
  `extra_match_field21` varchar(255) DEFAULT NULL,
  `extra_match_field22` varchar(255) DEFAULT NULL,
  `extra_match_field23` varchar(255) DEFAULT NULL,
  `extra_match_field24` varchar(255) DEFAULT NULL,
  `extra_match_field25` varchar(255) DEFAULT NULL,
  `extra_match_field26` varchar(255) DEFAULT NULL,
  `extra_match_field27` varchar(255) DEFAULT NULL,
  `extra_match_field28` varchar(255) DEFAULT NULL,
  `extra_match_field29` varchar(255) DEFAULT NULL,
  `extra_match_field30` varchar(255) DEFAULT NULL,
  `isOpen` varchar(1) NOT NULL DEFAULT 'Y' COMMENT '공개게시판 여부 ',
  `view_skin` varchar(4) NOT NULL DEFAULT 'init'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 테이블의 덤프 데이터 `nb_board_manage`
--

INSERT INTO `nb_board_manage` (`no`, `sitekey`, `title`, `skin`, `regdate`, `top_banner_image`, `contents`, `view_yn`, `secret_yn`, `sort_no`, `list_size`, `block_size`, `fileattach_yn`, `fileattach_cnt`, `comment_yn`, `depth1`, `depth2`, `depth3`, `lnb_path`, `category_yn`, `extra_match_field1`, `extra_match_field2`, `extra_match_field3`, `extra_match_field4`, `extra_match_field5`, `extra_match_field6`, `extra_match_field7`, `extra_match_field8`, `extra_match_field9`, `extra_match_field10`, `extra_match_field11`, `extra_match_field12`, `extra_match_field13`, `extra_match_field14`, `extra_match_field15`, `extra_match_field16`, `extra_match_field17`, `extra_match_field18`, `extra_match_field19`, `extra_match_field20`, `extra_match_field21`, `extra_match_field22`, `extra_match_field23`, `extra_match_field24`, `extra_match_field25`, `extra_match_field26`, `extra_match_field27`, `extra_match_field28`, `extra_match_field29`, `extra_match_field30`, `isOpen`, `view_skin`) VALUES
(27, 'STTINA', '크리에이터', 'cre', '2025-10-14 06:40:10', '', NULL, 'Y', 'N', 0, 200, 0, 'N', 0, 'N', NULL, NULL, NULL, NULL, 'N', '현재 진행중인 프로젝트', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', 'init'),
(26, 'STTINA', '포토폴리오', 'wok', '2025-10-14 04:34:46', '', NULL, 'Y', 'N', 0, 24, 0, 'N', 0, 'N', NULL, NULL, NULL, NULL, 'Y', '형식', '채널', '제작', '원작', '출연', '감독', 'Model', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', 'init'),
(25, 'STTINA', 'News', 'gal', '2025-10-13 07:14:01', '', NULL, 'Y', 'N', 0, 12, 0, 'N', 0, 'N', NULL, NULL, NULL, NULL, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', 'init');

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_branches`
--

CREATE TABLE `nb_branches` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `name_kr` varchar(100) NOT NULL,
  `json_path` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_branch_seos`
--

CREATE TABLE `nb_branch_seos` (
  `id` int NOT NULL,
  `path` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `section_title` varchar(255) DEFAULT NULL COMMENT '중간 카테고리 제목',
  `topic_title` varchar(255) DEFAULT NULL COMMENT '세부 주제 제목'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_counter`
--

CREATE TABLE `nb_counter` (
  `uid` int NOT NULL,
  `Connect_IP` varchar(30) NOT NULL DEFAULT '',
  `id` varchar(30) NOT NULL DEFAULT '',
  `Time` int NOT NULL DEFAULT '0',
  `Year` int NOT NULL DEFAULT '0',
  `Month` int NOT NULL DEFAULT '0',
  `Day` int NOT NULL DEFAULT '0',
  `Hour` int NOT NULL DEFAULT '0',
  `Week` char(3) NOT NULL DEFAULT '',
  `OS` varchar(50) NOT NULL DEFAULT '',
  `Browser` varchar(50) NOT NULL DEFAULT '',
  `Connect_Route` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_counter_config`
--

CREATE TABLE `nb_counter_config` (
  `uid` int NOT NULL,
  `Cookie_Use` enum('A','T','O') NOT NULL DEFAULT 'A' COMMENT '중복 카운터 적용 여부',
  `Cookie_Term` int NOT NULL DEFAULT '0' COMMENT '쿠키 지속 시간',
  `Counter_Use` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '카운터 사용여부',
  `Now_Connect_Use` enum('Y','N') NOT NULL DEFAULT 'Y',
  `Route_Use` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '접속경로 저장여부',
  `Now_Connect_Term` int NOT NULL DEFAULT '0',
  `Total_Num` int NOT NULL DEFAULT '0' COMMENT '총 접속자 수',
  `Admin_Check_Use` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '관리자 접속 카운터 여부',
  `Admin_IP` char(30) NOT NULL COMMENT '관리자 아이피'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_counter_data`
--

CREATE TABLE `nb_counter_data` (
  `uid` int NOT NULL,
  `Year` int NOT NULL DEFAULT '0',
  `Month` int NOT NULL DEFAULT '0',
  `Day` int NOT NULL DEFAULT '0',
  `Hour00` int NOT NULL DEFAULT '0',
  `Hour01` int NOT NULL DEFAULT '0',
  `Hour02` int NOT NULL DEFAULT '0',
  `Hour03` int NOT NULL DEFAULT '0',
  `Hour04` int NOT NULL DEFAULT '0',
  `Hour05` int NOT NULL DEFAULT '0',
  `Hour06` int NOT NULL DEFAULT '0',
  `Hour07` int NOT NULL DEFAULT '0',
  `Hour08` int NOT NULL DEFAULT '0',
  `Hour09` int NOT NULL DEFAULT '0',
  `Hour10` int NOT NULL DEFAULT '0',
  `Hour11` int NOT NULL DEFAULT '0',
  `Hour12` int NOT NULL DEFAULT '0',
  `Hour13` int NOT NULL DEFAULT '0',
  `Hour14` int NOT NULL DEFAULT '0',
  `Hour15` int NOT NULL DEFAULT '0',
  `Hour16` int NOT NULL DEFAULT '0',
  `Hour17` int NOT NULL DEFAULT '0',
  `Hour18` int NOT NULL DEFAULT '0',
  `Hour19` int NOT NULL DEFAULT '0',
  `Hour20` int NOT NULL DEFAULT '0',
  `Hour21` int NOT NULL DEFAULT '0',
  `Hour22` int NOT NULL DEFAULT '0',
  `Hour23` int NOT NULL DEFAULT '0',
  `Week` char(3) NOT NULL DEFAULT '',
  `Visit_Num` int NOT NULL DEFAULT '0',
  `Counter_ID` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_counter_route`
--

CREATE TABLE `nb_counter_route` (
  `uid` int NOT NULL,
  `Connect_Route` varchar(255) NOT NULL DEFAULT '',
  `Time` int NOT NULL DEFAULT '0',
  `BookMark` char(1) NOT NULL DEFAULT '',
  `Visit_Num` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_custom_inquires`
--

CREATE TABLE `nb_custom_inquires` (
  `id` int NOT NULL COMMENT '기본 PK',
  `name` varchar(100) NOT NULL COMMENT '성명',
  `birth` varchar(10) NOT NULL COMMENT '생년월일 (YYMMDD)',
  `gender` tinyint NOT NULL COMMENT '0: 남자, 1: 여자',
  `height` int NOT NULL,
  `weight` int NOT NULL,
  `phone` varchar(20) NOT NULL,
  `job` varchar(100) NOT NULL,
  `consult_time` tinyint NOT NULL COMMENT '상담 가능 시간 (1=10~12시, 2=12~14시 등)',
  `first_visit` tinyint NOT NULL COMMENT '첫 방문 여부 (1=첫 방문, 0=재방문)',
  `branch_id` int DEFAULT NULL COMMENT '지점 ID (nb_branches.id 참조)',
  `treatment` text,
  `symptoms` text,
  `drink` varchar(255) DEFAULT NULL,
  `headache` varchar(255) DEFAULT NULL,
  `dizzy` varchar(255) DEFAULT NULL,
  `pain_etc` varchar(255) DEFAULT NULL,
  `appetite` text,
  `digestion` text,
  `water` text,
  `feces` text,
  `urine` text,
  `sweat` text,
  `sweat_part` text,
  `temperature` text,
  `ent` text,
  `resp` text,
  `chest` text,
  `sleep` text,
  `body_skin` text,
  `pain_area` text,
  `pain_condition` text,
  `pain_special` text,
  `men_health` text,
  `pain_menstrual` text,
  `feces_time` varchar(100) DEFAULT NULL,
  `urine_time` varchar(100) DEFAULT NULL,
  `birth_exp` tinyint DEFAULT NULL,
  `birth_count` varchar(10) DEFAULT NULL,
  `miscarriage_exp` tinyint DEFAULT NULL,
  `miscarriage_count` varchar(10) DEFAULT NULL,
  `menstrual_status` tinyint DEFAULT NULL,
  `menstrual_cycle` varchar(10) DEFAULT NULL,
  `menopause_age` varchar(10) DEFAULT NULL,
  `hand_temp` tinyint DEFAULT NULL COMMENT '글로벌 옵션 매핑',
  `foot_temp` tinyint DEFAULT NULL COMMENT '글로벌 옵션 매핑',
  `swelling_area` tinyint DEFAULT NULL COMMENT '글로벌 옵션 매핑',
  `swelling_time` tinyint DEFAULT NULL COMMENT '글로벌 옵션 매핑',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `feces_days` int DEFAULT NULL COMMENT '대변 주기 - 며칠 간격',
  `feces_count` int DEFAULT NULL COMMENT '대변 주기 - 하루 횟수',
  `urine_days` int DEFAULT NULL COMMENT '소변 주기 - 며칠 간격',
  `urine_count` int DEFAULT NULL COMMENT '소변 주기 - 하루 횟수'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_data`
--

CREATE TABLE `nb_data` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `target` varchar(25) NOT NULL COMMENT '데이터가 사용될 곳 아이디 구분값',
  `contents` text NOT NULL,
  `regdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_doctors`
--

CREATE TABLE `nb_doctors` (
  `id` int UNSIGNED NOT NULL COMMENT 'PK',
  `title` varchar(255) NOT NULL COMMENT '이름',
  `branch_id` int NOT NULL COMMENT '지점 FK (nb_branches.id)',
  `position` varchar(100) DEFAULT NULL COMMENT '직급',
  `department` varchar(20) NOT NULL,
  `keywords` varchar(500) DEFAULT NULL COMMENT '키워드 (콤마 구분)',
  `career` text COMMENT '경력',
  `activity` text COMMENT '활동',
  `education` text COMMENT '학력',
  `publication_visible` tinyint(1) DEFAULT '1' COMMENT '저서 및 논문 노출 여부 (1:노출, 0:숨김)',
  `publications` text COMMENT '저서 및 논문',
  `thumb_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '썸네일 이미지 URL (누끼)',
  `detail_image` varchar(255) DEFAULT NULL COMMENT '상세 이미지 URL',
  `sort_no` int DEFAULT '0' COMMENT '정렬 순서',
  `is_active` tinyint(1) DEFAULT '1' COMMENT '노출 여부 (1:노출, 0:숨김)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',
  `is_ceo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '대표원장 여부 (1:대표, 0:일반)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_etcs`
--

CREATE TABLE `nb_etcs` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `bg_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 테이블의 덤프 데이터 `nb_etcs`
--

INSERT INTO `nb_etcs` (`id`, `title`, `bg_image`) VALUES
(1, 'default', '68edf49f0b1c23.98202890.jpg'),
(2, 'about', '68edf4bcd01833.49276019.jpg'),
(3, 'works', '68edf4bcd4d9b7.64138912.jpg'),
(4, 'news', '68edf4bcda9e28.21925107.jpg'),
(5, 'contact', '68edf4bcdf3d79.12083978.jpg');

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_facilities`
--

CREATE TABLE `nb_facilities` (
  `id` int NOT NULL COMMENT '시설 고유 ID',
  `title` varchar(255) NOT NULL COMMENT '시설명',
  `branch_id` int NOT NULL COMMENT '지점 ID (nb_branches 외래키)',
  `categories` int NOT NULL COMMENT '카테고리 ID (전역 설정으로 관리)',
  `thumb_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '썸네일 이미지 URL (누끼)',
  `is_active` tinyint(1) DEFAULT '1' COMMENT '노출 여부 (1:노출, 0:숨김)',
  `sort_no` int NOT NULL DEFAULT '0' COMMENT '정렬 순서 (낮을수록 위)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '생성일시',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일시'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='시설 관리 테이블';

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_faqs`
--

CREATE TABLE `nb_faqs` (
  `id` int UNSIGNED NOT NULL,
  `categories` int NOT NULL COMMENT 'FAQ 카테고리 코드 (var.php에 매핑)',
  `question` text NOT NULL COMMENT '질문',
  `answer` text NOT NULL COMMENT '답변',
  `sort_no` int NOT NULL DEFAULT '0' COMMENT '정렬 순서 (낮을수록 위)',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: 활성화, 2: 비활성화',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='지점별 FAQ';

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_herb_inquiries`
--

CREATE TABLE `nb_herb_inquiries` (
  `id` int NOT NULL COMMENT '기본 PK',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '성명',
  `birth` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '생년월일 (YYMMDD)',
  `gender` tinyint NOT NULL COMMENT '성별 (0=여성, 1=남성)',
  `height` int NOT NULL COMMENT '키 (cm)',
  `weight` int NOT NULL COMMENT '몸무게 (kg)',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '연락처',
  `consult_time` tinyint NOT NULL COMMENT '상담 가능 시간 (1=10~12시, 2=12~14시 등)',
  `first_visit` tinyint NOT NULL COMMENT '첫 방문 여부 (1=첫 방문, 0=재방문)',
  `branch_id` int DEFAULT NULL COMMENT '지점 ID (nb_branches.id 참조)',
  `treatment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '치료 이력 / 복용 약물',
  `symptoms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '현재 증상',
  `drink` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '음주 습관',
  `feces_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '대변 주기',
  `urine_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '소변 주기',
  `appetite` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '식욕 관련 선택사항 (checkbox)',
  `digestion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '소화 관련 선택사항 (checkbox)',
  `feces` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '대변 관련 선택사항 (checkbox)',
  `urine` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '소변 관련 선택사항 (checkbox)',
  `sleep` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '수면 관련 선택사항 (checkbox)',
  `indigest` tinyint DEFAULT NULL COMMENT '소화불량 주기 (1=항상, 2=가끔)',
  `belly_pain` tinyint DEFAULT NULL COMMENT '복통 시기 (1=공복, 2=식후, 3=스트레스)',
  `reason` tinyint DEFAULT NULL COMMENT '속쓰림 이유 (1=공복, 2=매운 것)',
  `inquiry_type` tinyint NOT NULL COMMENT '상담 종류 (1=공진단, 2=경옥고, 3=관절고)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '등록 일시',
  `feces_days` int DEFAULT NULL COMMENT '대변 주기 - 며칠 간격',
  `feces_count` int DEFAULT NULL COMMENT '대변 주기 - 하루 횟수',
  `urine_days` int DEFAULT NULL COMMENT '소변 주기 - 며칠 간격',
  `urine_count` int DEFAULT NULL COMMENT '소변 주기 - 하루 횟수'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_member`
--

CREATE TABLE `nb_member` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `lev` int NOT NULL DEFAULT '0' COMMENT '회원등급(코드 별도로 있음)기본 0',
  `campus` int NOT NULL DEFAULT '0' COMMENT '캠퍼스 코드 (별도 테이블)',
  `gubun` varchar(3) NOT NULL COMMENT '가입구분 (재학생, 학부모)',
  `grade` varchar(4) NOT NULL COMMENT '학년 KIN, G1~G12',
  `uid` varchar(30) NOT NULL COMMENT '아이디',
  `upwd` varchar(64) NOT NULL COMMENT '패스워드',
  `uname` varchar(30) NOT NULL COMMENT '이름',
  `name_first` varchar(20) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL COMMENT '연락처',
  `hp` varchar(15) NOT NULL COMMENT '휴대폰번호',
  `hp_recieve_yn` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '휴대폰 광고 동의',
  `email` varchar(125) NOT NULL COMMENT '이메일 주소',
  `email_recieve_yn` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '이메일 수신 동의',
  `zipcode` varchar(6) DEFAULT NULL COMMENT '우편번호',
  `addr1` varchar(50) DEFAULT NULL COMMENT '주소',
  `addr2` varchar(100) DEFAULT NULL COMMENT '상세 주소',
  `regdate` datetime NOT NULL COMMENT '등록일',
  `child_name` varchar(20) DEFAULT NULL COMMENT '자녀이',
  `child_no` int NOT NULL DEFAULT '-1' COMMENT '자녀 회원 테이블 no 맵핑용 ',
  `name_last` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_member_level`
--

CREATE TABLE `nb_member_level` (
  `no` int NOT NULL,
  `sitekey` varchar(6) DEFAULT NULL,
  `lev_name` varchar(125) NOT NULL COMMENT '등급명',
  `is_join` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '회원가입시 부여 등급'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_nonpay_items`
--

CREATE TABLE `nb_nonpay_items` (
  `id` int UNSIGNED NOT NULL,
  `category_primary` varchar(50) NOT NULL COMMENT '1차 카테고리',
  `category_secondary` varchar(50) NOT NULL COMMENT '2차 카테고리',
  `title` varchar(255) NOT NULL COMMENT '항목명',
  `cost` int UNSIGNED DEFAULT '0' COMMENT '비용 (원)',
  `notice` text COMMENT '비고',
  `sort_no` int DEFAULT '0' COMMENT '정렬 순서',
  `is_active` tinyint(1) DEFAULT '1' COMMENT '노출 여부 (1:노출, 0:숨김)',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '최종 수정일',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='비급여 항목 관리';

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_popup`
--

CREATE TABLE `nb_popup` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `p_title` varchar(50) NOT NULL COMMENT '팝업 제목',
  `p_img` varchar(128) NOT NULL COMMENT '팝업 이미지',
  `p_target` enum('_none','_self','_blank') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '_self' COMMENT '링크 오픈 형식',
  `p_link` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '팝업 링크',
  `p_view` enum('Y','N') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'Y' COMMENT '노출 여부',
  `p_left` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '노출위치(px) 왼쪽으로부터',
  `p_top` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '노출위치(px) 위쪽으로부터',
  `p_idx` int DEFAULT '0' COMMENT '순서',
  `p_sdate` date DEFAULT NULL COMMENT '시작일 - 00 시부터 시작',
  `p_edate` date DEFAULT NULL COMMENT '종료일 - 23시 59분 59초까지',
  `p_rdate` datetime NOT NULL COMMENT '등록일',
  `p_none_limit` enum('N','Y') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'N' COMMENT '기한설정 Y:무기한 N:기한설',
  `p_loc` enum('P','M') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'P' COMMENT '노출위치 P : PC M : 모받',
  `p_is_link` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '링크 여부'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_popups`
--

CREATE TABLE `nb_popups` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '관리용 제목',
  `popup_type` int NOT NULL COMMENT '전역 변수 banner_types의 키 (int)',
  `is_active` int DEFAULT '1' COMMENT '전역 변수 $is_active의 값 (0=숨김, 1=노출)',
  `start_at` varchar(20) DEFAULT NULL,
  `end_at` varchar(20) DEFAULT NULL,
  `description` text COMMENT '설명글',
  `has_link` int DEFAULT '2' COMMENT '전역 변수 $has_link의 값 (1=링크, 2=비링크)',
  `link_url` varchar(1024) DEFAULT NULL COMMENT '링크 URL',
  `popup_image` varchar(1024) DEFAULT NULL COMMENT '배너 이미지 경로',
  `branch_id` int DEFAULT NULL COMMENT 'nb_branches.id 참조, NULL이면 공통 배너',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sort_no` int NOT NULL DEFAULT '0' COMMENT '정렬 순서',
  `is_unlimited` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = 무기한 노출, 0 = 노출 기간 사용',
  `is_target` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=현재창(_self), 1=새창(_blank)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_products`
--

CREATE TABLE `nb_products` (
  `id` int NOT NULL,
  `product_category_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `sub_title` varchar(100) DEFAULT NULL,
  `description` text,
  `url` varchar(200) DEFAULT NULL,
  `thumb_image` varchar(255) DEFAULT NULL,
  `detail_image` varchar(255) DEFAULT NULL,
  `banner_img` varchar(255) DEFAULT NULL,
  `product_img_1` varchar(255) DEFAULT NULL,
  `product_img_2` varchar(255) DEFAULT NULL,
  `product_img_3` varchar(255) DEFAULT NULL,
  `product_img_4` varchar(255) DEFAULT NULL,
  `product_img_5` varchar(255) DEFAULT NULL,
  `feature` text,
  `feature_desc` text,
  `sort_no` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `selected_variants` json DEFAULT NULL,
  `variant_specs` json DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_request`
--

CREATE TABLE `nb_request` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `name` varchar(30) DEFAULT NULL COMMENT '이름',
  `phone` varchar(13) DEFAULT NULL COMMENT '연락처',
  `company` varchar(100) DEFAULT NULL,
  `area` varchar(10) NOT NULL COMMENT '설치 지역 코드/명',
  `is_confirmed` int NOT NULL DEFAULT '0',
  `contents` varchar(4000) DEFAULT NULL COMMENT '내용',
  `regdate` datetime DEFAULT NULL COMMENT '등록일'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_roles`
--

CREATE TABLE `nb_roles` (
  `role_id` int NOT NULL,
  `role_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '沅뚰븳 ?대쫫 (?? superadmin, editor, viewer)',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '沅뚰븳 ?ㅻ챸'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `nb_roles`
--

INSERT INTO `nb_roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'superadmin', '최고 관리자 - 모든 기능 사용 가능'),
(2, 'manager', '중간 관리자 - 일부 기능 제한'),
(3, 'external', '외부인 - 조회 전용');

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_simple_inquiries`
--

CREATE TABLE `nb_simple_inquiries` (
  `id` int NOT NULL COMMENT '고유번호',
  `branch_id` int NOT NULL COMMENT '지점 ID (nb_branches.id)',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이름',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '연락처',
  `consult_time` tinyint NOT NULL DEFAULT '1' COMMENT '상담 가능 시간 키 (1~9)',
  `hope_treatment` tinyint NOT NULL DEFAULT '1' COMMENT '희망 진료 항목 키 (1~5)',
  `inquiry_type` tinyint NOT NULL DEFAULT '1' COMMENT '문의 종류 키 (1: 공진단, 2: 경옥고, 3: 관절고)',
  `contents` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '문의 내용',
  `private_check` tinyint(1) NOT NULL DEFAULT '0' COMMENT '개인정보 수집 동의 (1:동의)',
  `marketing_check` tinyint(1) NOT NULL DEFAULT '0' COMMENT '마케팅 수신 동의 (1:동의, 선택)',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='간편 문의 접수';

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_siteinfo`
--

CREATE TABLE `nb_siteinfo` (
  `no` int NOT NULL,
  `sitekey` varchar(6) NOT NULL COMMENT '사이트 유니크 키',
  `title` varchar(50) DEFAULT NULL,
  `phone` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '대표 연락처',
  `hp` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '대표 휴대폰',
  `fax` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '대표 팩스',
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '대표 이메일',
  `customercenter_able_time` varchar(50) DEFAULT NULL COMMENT '상담가능시간',
  `company_able_time` varchar(50) DEFAULT NULL COMMENT '회사운영시간',
  `google_map_key` varchar(256) DEFAULT NULL COMMENT '구글 지도 키',
  `logo_top` varchar(50) DEFAULT NULL COMMENT '상단 로고 이미지',
  `logo_footer` varchar(50) DEFAULT NULL COMMENT '하단 로고 이미지',
  `footer_name` varchar(50) DEFAULT NULL COMMENT '하단 사이트명',
  `footer_address` varchar(125) DEFAULT NULL COMMENT '하단 주소',
  `footer_phone` varchar(13) DEFAULT NULL COMMENT '하단 연락처',
  `footer_hp` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '하단 휴대폰',
  `footer_fax` varchar(13) DEFAULT NULL COMMENT '하단 팩스',
  `footer_email` varchar(50) DEFAULT NULL COMMENT '하단 이메일',
  `footer_owner` varchar(15) DEFAULT NULL COMMENT '하단 대표자',
  `footer_ssn` varchar(13) DEFAULT NULL COMMENT '하단 사업자번호',
  `footer_policy_charger` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '하단 개인정보책임자',
  `meta_keywords` varchar(256) DEFAULT NULL,
  `meta_description` varchar(256) DEFAULT NULL,
  `meta_thumb` varchar(50) DEFAULT NULL COMMENT '메타 이미지 파일',
  `meta_favicon_ico` varchar(50) DEFAULT NULL COMMENT 'ico 파'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_site_tags`
--

CREATE TABLE `nb_site_tags` (
  `id` int NOT NULL,
  `sitekey` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `tag_content` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_users`
--

CREATE TABLE `nb_users` (
  `id` int NOT NULL,
  `sitekey` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_id` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `kakao_id` bigint UNSIGNED DEFAULT NULL,
  `kakao_nickname` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `kakao_profile_img` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `regdate` timestamp NULL DEFAULT (now()),
  `birth` varchar(8) DEFAULT NULL COMMENT '생년월일 (예: 19900101)',
  `agree_receive_notice` tinyint(1) DEFAULT '0',
  `agree_privacy_policy` tinyint(1) NOT NULL,
  `agree_terms_of_service` tinyint(1) NOT NULL,
  `active_status` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT '활성화 상태'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 테이블 구조 `nb_user_search_history`
--

CREATE TABLE `nb_user_search_history` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `search_keyword` varchar(255) NOT NULL,
  `searched_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `nb_admin`
--
ALTER TABLE `nb_admin`
  ADD PRIMARY KEY (`no`),
  ADD KEY `fk_nb_admin_role` (`role_id`);

--
-- 테이블의 인덱스 `nb_analytics`
--
ALTER TABLE `nb_analytics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_day_ip` (`year`,`month`,`day`,`ip_address`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- 테이블의 인덱스 `nb_banner`
--
ALTER TABLE `nb_banner`
  ADD PRIMARY KEY (`no`),
  ADD KEY `b_loc` (`b_loc`);

--
-- 테이블의 인덱스 `nb_banners`
--
ALTER TABLE `nb_banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nb_banners_branch` (`branch_id`);

--
-- 테이블의 인덱스 `nb_board`
--
ALTER TABLE `nb_board`
  ADD PRIMARY KEY (`no`),
  ADD KEY `IDX_NB_BOARD4` (`sitekey`,`board_no`);

--
-- 테이블의 인덱스 `nb_board_category`
--
ALTER TABLE `nb_board_category`
  ADD PRIMARY KEY (`no`),
  ADD KEY `IDX_NB_BOARD_CATEGORY` (`board_no`);

--
-- 테이블의 인덱스 `nb_board_comment`
--
ALTER TABLE `nb_board_comment`
  ADD PRIMARY KEY (`no`),
  ADD KEY `IDX_NB_BOARD_COMMENT` (`parent_no`);

--
-- 테이블의 인덱스 `nb_board_lev_manage`
--
ALTER TABLE `nb_board_lev_manage`
  ADD PRIMARY KEY (`no`),
  ADD KEY `IDX_NB_BOARD_LEV_MANAGE` (`board_no`,`lev_no`);

--
-- 테이블의 인덱스 `nb_board_manage`
--
ALTER TABLE `nb_board_manage`
  ADD PRIMARY KEY (`no`);

--
-- 테이블의 인덱스 `nb_branches`
--
ALTER TABLE `nb_branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 테이블의 인덱스 `nb_branch_seos`
--
ALTER TABLE `nb_branch_seos`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_counter`
--
ALTER TABLE `nb_counter`
  ADD PRIMARY KEY (`uid`);

--
-- 테이블의 인덱스 `nb_counter_config`
--
ALTER TABLE `nb_counter_config`
  ADD PRIMARY KEY (`uid`);

--
-- 테이블의 인덱스 `nb_counter_data`
--
ALTER TABLE `nb_counter_data`
  ADD PRIMARY KEY (`uid`);

--
-- 테이블의 인덱스 `nb_counter_route`
--
ALTER TABLE `nb_counter_route`
  ADD PRIMARY KEY (`uid`);

--
-- 테이블의 인덱스 `nb_custom_inquires`
--
ALTER TABLE `nb_custom_inquires`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_data`
--
ALTER TABLE `nb_data`
  ADD PRIMARY KEY (`no`),
  ADD KEY `IDX_NB_DATA1` (`sitekey`,`target`);

--
-- 테이블의 인덱스 `nb_doctors`
--
ALTER TABLE `nb_doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor_branch` (`branch_id`);

--
-- 테이블의 인덱스 `nb_etcs`
--
ALTER TABLE `nb_etcs`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_facilities`
--
ALTER TABLE `nb_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_facility_branch` (`branch_id`);

--
-- 테이블의 인덱스 `nb_faqs`
--
ALTER TABLE `nb_faqs`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_herb_inquiries`
--
ALTER TABLE `nb_herb_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_member`
--
ALTER TABLE `nb_member`
  ADD PRIMARY KEY (`no`),
  ADD KEY `IDX_NB_MEMBER` (`lev`,`campus`);

--
-- 테이블의 인덱스 `nb_member_level`
--
ALTER TABLE `nb_member_level`
  ADD PRIMARY KEY (`no`);

--
-- 테이블의 인덱스 `nb_nonpay_items`
--
ALTER TABLE `nb_nonpay_items`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_popup`
--
ALTER TABLE `nb_popup`
  ADD PRIMARY KEY (`no`);

--
-- 테이블의 인덱스 `nb_popups`
--
ALTER TABLE `nb_popups`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_products`
--
ALTER TABLE `nb_products`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_request`
--
ALTER TABLE `nb_request`
  ADD PRIMARY KEY (`no`);

--
-- 테이블의 인덱스 `nb_roles`
--
ALTER TABLE `nb_roles`
  ADD PRIMARY KEY (`role_id`) USING BTREE,
  ADD UNIQUE KEY `role_name` (`role_name`) USING BTREE;

--
-- 테이블의 인덱스 `nb_simple_inquiries`
--
ALTER TABLE `nb_simple_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_branch_id` (`branch_id`);

--
-- 테이블의 인덱스 `nb_siteinfo`
--
ALTER TABLE `nb_siteinfo`
  ADD PRIMARY KEY (`no`);

--
-- 테이블의 인덱스 `nb_site_tags`
--
ALTER TABLE `nb_site_tags`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `nb_users`
--
ALTER TABLE `nb_users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE,
  ADD UNIQUE KEY `uniq_kakao_id` (`kakao_id`);

--
-- 테이블의 인덱스 `nb_user_search_history`
--
ALTER TABLE `nb_user_search_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `nb_admin`
--
ALTER TABLE `nb_admin`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 테이블의 AUTO_INCREMENT `nb_analytics`
--
ALTER TABLE `nb_analytics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- 테이블의 AUTO_INCREMENT `nb_banner`
--
ALTER TABLE `nb_banner`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `nb_banners`
--
ALTER TABLE `nb_banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 테이블의 AUTO_INCREMENT `nb_board`
--
ALTER TABLE `nb_board`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- 테이블의 AUTO_INCREMENT `nb_board_category`
--
ALTER TABLE `nb_board_category`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 테이블의 AUTO_INCREMENT `nb_board_comment`
--
ALTER TABLE `nb_board_comment`
  MODIFY `no` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `nb_board_lev_manage`
--
ALTER TABLE `nb_board_lev_manage`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `nb_board_manage`
--
ALTER TABLE `nb_board_manage`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 테이블의 AUTO_INCREMENT `nb_branches`
--
ALTER TABLE `nb_branches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `nb_branch_seos`
--
ALTER TABLE `nb_branch_seos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- 테이블의 AUTO_INCREMENT `nb_counter`
--
ALTER TABLE `nb_counter`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `nb_counter_config`
--
ALTER TABLE `nb_counter_config`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `nb_counter_data`
--
ALTER TABLE `nb_counter_data`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `nb_counter_route`
--
ALTER TABLE `nb_counter_route`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `nb_custom_inquires`
--
ALTER TABLE `nb_custom_inquires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT '기본 PK', AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `nb_data`
--
ALTER TABLE `nb_data`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `nb_doctors`
--
ALTER TABLE `nb_doctors`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK', AUTO_INCREMENT=15;

--
-- 테이블의 AUTO_INCREMENT `nb_etcs`
--
ALTER TABLE `nb_etcs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `nb_facilities`
--
ALTER TABLE `nb_facilities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT '시설 고유 ID', AUTO_INCREMENT=25;

--
-- 테이블의 AUTO_INCREMENT `nb_faqs`
--
ALTER TABLE `nb_faqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- 테이블의 AUTO_INCREMENT `nb_herb_inquiries`
--
ALTER TABLE `nb_herb_inquiries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT '기본 PK', AUTO_INCREMENT=19;

--
-- 테이블의 AUTO_INCREMENT `nb_member`
--
ALTER TABLE `nb_member`
  MODIFY `no` int NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `nb_member_level`
--
ALTER TABLE `nb_member_level`
  MODIFY `no` int NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `nb_nonpay_items`
--
ALTER TABLE `nb_nonpay_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- 테이블의 AUTO_INCREMENT `nb_popup`
--
ALTER TABLE `nb_popup`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 테이블의 AUTO_INCREMENT `nb_popups`
--
ALTER TABLE `nb_popups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 테이블의 AUTO_INCREMENT `nb_products`
--
ALTER TABLE `nb_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `nb_request`
--
ALTER TABLE `nb_request`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 테이블의 AUTO_INCREMENT `nb_roles`
--
ALTER TABLE `nb_roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `nb_simple_inquiries`
--
ALTER TABLE `nb_simple_inquiries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT '고유번호', AUTO_INCREMENT=20;

--
-- 테이블의 AUTO_INCREMENT `nb_siteinfo`
--
ALTER TABLE `nb_siteinfo`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `nb_site_tags`
--
ALTER TABLE `nb_site_tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `nb_users`
--
ALTER TABLE `nb_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- 테이블의 AUTO_INCREMENT `nb_user_search_history`
--
ALTER TABLE `nb_user_search_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `nb_banners`
--
ALTER TABLE `nb_banners`
  ADD CONSTRAINT `fk_nb_banners_branch` FOREIGN KEY (`branch_id`) REFERENCES `nb_branches` (`id`) ON DELETE SET NULL;

--
-- 테이블의 제약사항 `nb_doctors`
--
ALTER TABLE `nb_doctors`
  ADD CONSTRAINT `fk_doctor_branch` FOREIGN KEY (`branch_id`) REFERENCES `nb_branches` (`id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `nb_facilities`
--
ALTER TABLE `nb_facilities`
  ADD CONSTRAINT `fk_facility_branch` FOREIGN KEY (`branch_id`) REFERENCES `nb_branches` (`id`);

--
-- 테이블의 제약사항 `nb_simple_inquiries`
--
ALTER TABLE `nb_simple_inquiries`
  ADD CONSTRAINT `fk_simple_inquiry_branch` FOREIGN KEY (`branch_id`) REFERENCES `nb_branches` (`id`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `nb_user_search_history`
--
ALTER TABLE `nb_user_search_history`
  ADD CONSTRAINT `nb_user_search_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `nb_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
