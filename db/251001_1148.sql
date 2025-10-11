-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- 호스트: db:3306
-- 생성 시간: 25-09-04 09:05
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
(1, 'SIXDOT', 'tmaster', '$2y$10$JxWvgydNpaNoCV0HG1RCLOSLBxXpdkm5jwptaogaJ7uo5hSUE4dqu', '관리자', 'Y', 2, 'nineonelabs@co.kr', '010-1111-3333', '2025-07-31 08:23:14', '2025-08-28 04:56:24');

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

--
-- 테이블의 덤프 데이터 `nb_analytics`
--

INSERT INTO `nb_analytics` (`id`, `year`, `month`, `day`, `time`, `user_agent`, `ip_address`, `referrer`, `created_at`) VALUES
(40, 2025, 8, 28, '14:04:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '172.27.0.1', '', '2025-08-28 05:04:27');

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

--
-- 테이블의 덤프 데이터 `nb_banners`
--

INSERT INTO `nb_banners` (`id`, `title`, `banner_type`, `is_active`, `start_at`, `end_at`, `description`, `has_link`, `link_url`, `duration`, `banner_image`, `branch_id`, `created_at`, `updated_at`, `sort_no`, `is_unlimited`, `is_target`) VALUES
(28, 'ㄴㅇㅁㄴㅇㅁ', 1, 0, '', '', '<p>asdasdasdasd</p>', 2, '', 6, '68b79e6aa0b688.36076476.png', NULL, '2025-09-03 01:48:26', '2025-09-03 01:51:50', 1, 1, 1);

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
  `post_description` text,
  `feature_list` text,
  `feature_description` text,
  `tech_title_description` text,
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

INSERT INTO `nb_board` (`no`, `sitekey`, `board_no`, `user_no`, `category_no`, `comment_cnt`, `title`, `contents`, `post_description`, `feature_list`, `feature_description`, `tech_title_description`, `regdate`, `read_cnt`, `thumb_image`, `is_admin_writed`, `is_notice`, `is_secret`, `secret_pwd`, `write_name`, `isFile`, `file_attach_1`, `file_attach_origin_1`, `file_attach_2`, `file_attach_origin_2`, `file_attach_3`, `file_attach_origin_3`, `file_attach_4`, `file_attach_origin_4`, `file_attach_5`, `file_attach_origin_5`, `is_admin_comment_yn`, `direct_url`, `extra1`, `extra2`, `extra3`, `extra4`, `extra5`, `extra6`, `extra7`, `extra8`, `extra9`, `extra10`, `extra11`, `extra12`, `extra13`, `extra14`, `extra15`, `extra16`, `extra17`, `extra18`, `extra19`, `extra20`, `extra21`, `extra22`, `extra23`, `extra24`, `extra25`, `extra26`, `extra27`, `extra28`, `extra29`, `extra30`, `sort_no`) VALUES
(126, 'SIXDOT', 23, -1, 0, 0, 'M200', '&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;', '&lt;p&gt;Lacimbali New 하이앤드 머신, &lt;b&gt;M200&lt;/b&gt;&lt;/p&gt;&lt;p&gt;시선을 사로잡는 디자인, Lacimbali 100년의 최고의 기술력을 집약한 모델&lt;/p&gt;&lt;p&gt;M200은 최고의 바리스타, 최고의 커피를 위한 최선의 선택입니다.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '&lt;p&gt;- 스마트보일러&lt;/p&gt;&lt;p&gt;- 멀티보일러&lt;/p&gt;&lt;p&gt;- 그룹별 온도설정&lt;/p&gt;&lt;p&gt;- 인퓨전 시간 조절&lt;/p&gt;&lt;p&gt;- USB포트&lt;/p&gt;&lt;p&gt;- 블루투스&lt;/p&gt;&lt;p&gt;- 그룹별 디스플레이&lt;/p&gt;&lt;p&gt;- 바리스타라이트&lt;/p&gt;&lt;p&gt;- 백판낼 하이라이트&lt;/p&gt;&lt;p&gt;- 콜드터치 스팀완드&lt;/p&gt;&lt;p&gt;- 터보스팀밀크4(옵션)&lt;/p&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', '&lt;p data-start=&quot;57&quot; data-end=&quot;122&quot;&gt;&lt;b&gt;스마트보일러&lt;/b&gt;&lt;br data-start=&quot;63&quot; data-end=&quot;66&quot;&gt;\r\n라심발리만의 독자적인 보일러 시스템으로 보일러 성능을 최적화 하고&lt;br data-start=&quot;102&quot; data-end=&quot;105&quot;&gt;\r\n에너지 소비를 줄여 줍니다.&lt;/p&gt;&lt;p data-start=&quot;124&quot; data-end=&quot;185&quot;&gt;&lt;b&gt;멀티보일러&lt;/b&gt;&lt;br data-start=&quot;129&quot; data-end=&quot;132&quot;&gt;\r\n그룹별 멀티보일러를 통해 그룹헤드별 온도설정이 가능하며&lt;br data-start=&quot;162&quot; data-end=&quot;165&quot;&gt;\r\n안정적인 샷 온도를 유지 합니다.&lt;/p&gt;&lt;p data-start=&quot;187&quot; data-end=&quot;252&quot;&gt;&lt;b&gt;인퓨전 시간 조절&lt;/b&gt;&lt;br data-start=&quot;196&quot; data-end=&quot;199&quot;&gt;\r\n인퓨전 on/off 및 시간 조절을 통해 원두성향에 맞는&lt;br data-start=&quot;230&quot; data-end=&quot;233&quot;&gt;\r\n다양한 샷의 셋팅이 가능합니다.&lt;/p&gt;&lt;p data-start=&quot;254&quot; data-end=&quot;334&quot;&gt;&lt;b&gt;블루투스(PGS, BDS)&lt;/b&gt;&lt;br data-start=&quot;268&quot; data-end=&quot;271&quot;&gt;\r\n블루투스 연결을 통하여 LACIMBALI GRINDER와 연동하여&lt;br data-start=&quot;307&quot; data-end=&quot;310&quot;&gt;\r\n자동으로 그라인더의 분쇄도를 조절합니다.&lt;/p&gt;&lt;p data-start=&quot;336&quot; data-end=&quot;396&quot;&gt;&lt;b&gt;그룹별 디스플레이&lt;/b&gt;&lt;br data-start=&quot;345&quot; data-end=&quot;348&quot;&gt;\r\n그룹별 Led 디스플레이를 통해 머신의 운영을 직관적으로&lt;br data-start=&quot;379&quot; data-end=&quot;382&quot;&gt;\r\n확인 할수 있습니다.&lt;/p&gt;&lt;p data-start=&quot;398&quot; data-end=&quot;474&quot;&gt;&lt;b&gt;바리스타 라이트, 백판낼 하이라이트&lt;/b&gt;&lt;br data-start=&quot;417&quot; data-end=&quot;420&quot;&gt;\r\n머신의 전면과 후면의 라이트를 통하여 머신과 공간을 한층 더&lt;br data-start=&quot;453&quot; data-end=&quot;456&quot;&gt;\r\n고급스럽게 업그레이드 합니다.&lt;/p&gt;&lt;p data-start=&quot;476&quot; data-end=&quot;547&quot;&gt;&lt;b&gt;콜드터치 스팀완드&lt;/b&gt;&lt;br data-start=&quot;485&quot; data-end=&quot;488&quot;&gt;\r\n특수코팅처리된 스팀완드는 뜨거워지는 것을 방지하며 머신을 한층 더 안전하게&lt;br data-start=&quot;529&quot; data-end=&quot;532&quot;&gt;\r\n사용할 수 있게 합니다.&lt;/p&gt;&lt;p data-start=&quot;549&quot; data-end=&quot;610&quot;&gt;&lt;b&gt;터보스팀밀크4&lt;/b&gt;&lt;br data-start=&quot;556&quot; data-end=&quot;559&quot;&gt;\r\n4가지로 다양한 밀크폼 셋팅이 가능하여 누구나 바리스타 퀄리티의&lt;br data-start=&quot;594&quot; data-end=&quot;597&quot;&gt;\r\n스티밍이 가능합니다.&lt;/p&gt;', '', '2025-09-03 08:15:04', 2, '68b7fc7ba0a094.66450922.jpg', 'N', 'N', 'N', NULL, '관리자', 'N', '68b80fd7de7647.53509704.png', 'Frame_125820-removebg-preview (1).png', '68b80fd7e15a78.24392900.png', 'Frame_125820-removebg-preview (1).png', '68b80fd7e35eb3.94222068.png', 'Frame_125820-removebg-preview (1).png', '68b80fd7e5a5c9.22709216.png', 'Frame_125820-removebg-preview (1).png', '68b80fd7e7f2d4.75774070.png', 'Frame_125820-removebg-preview (1).png', 'N', 'https://www.youtube.com/embed/L1oiYWCWUmM?si=EmVYpFQNQLseMDzV', '2GR : 220~240V 60Hz', '3GR : 380~425V 60Hz', '2GR :6200~7400W', '3GR :7500~8800W', '2GR : 887 * 649 * 516', '3GR : 1087 * 649 * 516', '2GR : 7L', '3GR : 7L', '2GR : 0.6L * 2EA', '3GR : 0.6L * 3EA', '2GR : 70kg', '3GR : 70kg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(127, 'SIXDOT', 23, -1, 0, 0, 'M40', '&lt;div&gt;&lt;div&gt;&lt;div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;', '&lt;p data-pm-slice=&quot;1 1 []&quot;&gt;M39의 모던함과 안정성의 명성 그대로&lt;/p&gt;&lt;p&gt;새로운 디자인, 새로운 기술을 더한&lt;/p&gt;&lt;p&gt;Lacimbali의 새로운 비전 &lt;b&gt;M40은 완벽한 커피머신&lt;/b&gt;입니다.&lt;/p&gt;', '', '&lt;p data-start=&quot;57&quot; data-end=&quot;122&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;스마트보일러&lt;/b&gt;&lt;br data-start=&quot;63&quot; data-end=&quot;66&quot;&gt;라심발리만의 독자적인 보일러 시스템으로 보일러 성능을 최적화 하고&lt;br data-start=&quot;102&quot; data-end=&quot;105&quot;&gt;에너지 소비를 줄여 줍니다.&lt;/p&gt;&lt;p data-start=&quot;124&quot; data-end=&quot;185&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;멀티보일러&lt;/b&gt;&lt;br data-start=&quot;129&quot; data-end=&quot;132&quot;&gt;그룹별 멀티보일러를 통해 그룹헤드별 온도설정이 가능하며&lt;br data-start=&quot;162&quot; data-end=&quot;165&quot;&gt;안정적인 샷 온도를 유지 합니다.&lt;/p&gt;&lt;p data-start=&quot;187&quot; data-end=&quot;252&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;인퓨전 시간 조절&lt;/b&gt;&lt;br data-start=&quot;196&quot; data-end=&quot;199&quot;&gt;인퓨전 on/off 및 시간 조절을 통해 원두성향에 맞는&lt;br data-start=&quot;230&quot; data-end=&quot;233&quot;&gt;다양한 샷의 셋팅이 가능합니다.&lt;/p&gt;&lt;p data-start=&quot;254&quot; data-end=&quot;334&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;블루투스(PGS, BDS)&lt;/b&gt;&lt;br data-start=&quot;268&quot; data-end=&quot;271&quot;&gt;블루투스 연결을 통하여 LACIMBALI GRINDER와 연동하여&lt;br data-start=&quot;307&quot; data-end=&quot;310&quot;&gt;자동으로 그라인더의 분쇄도를 조절합니다.&lt;/p&gt;&lt;p data-start=&quot;336&quot; data-end=&quot;396&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;그룹별 디스플레이&lt;/b&gt;&lt;br data-start=&quot;345&quot; data-end=&quot;348&quot;&gt;그룹별 Led 디스플레이를 통해 머신의 운영을 직관적으로&lt;br data-start=&quot;379&quot; data-end=&quot;382&quot;&gt;확인 할수 있습니다.&lt;/p&gt;&lt;p data-start=&quot;398&quot; data-end=&quot;474&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;바리스타 라이트, 백판낼 하이라이트&lt;/b&gt;&lt;br data-start=&quot;417&quot; data-end=&quot;420&quot;&gt;머신의 전면과 후면의 라이트를 통하여 머신과 공간을 한층 더&lt;br data-start=&quot;453&quot; data-end=&quot;456&quot;&gt;고급스럽게 업그레이드 합니다.&lt;/p&gt;&lt;p data-start=&quot;476&quot; data-end=&quot;547&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;콜드터치 스팀완드&lt;/b&gt;&lt;br data-start=&quot;485&quot; data-end=&quot;488&quot;&gt;특수코팅처리된 스팀완드는 뜨거워지는 것을 방지하며 머신을 한층 더 안전하게&lt;br data-start=&quot;529&quot; data-end=&quot;532&quot;&gt;사용할 수 있게 합니다.&lt;/p&gt;&lt;p data-start=&quot;549&quot; data-end=&quot;610&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;터보스팀밀크4&lt;/b&gt;&lt;br data-start=&quot;556&quot; data-end=&quot;559&quot;&gt;4가지로 다양한 밀크폼 셋팅이 가능하여 누구나 바리스타 퀄리티의&lt;br data-start=&quot;594&quot; data-end=&quot;597&quot;&gt;스티밍이 가능합니다.&lt;/p&gt;', '', '2025-09-03 09:51:12', 0, '68b80f902f9188.97486413.jpg', 'N', 'N', 'N', NULL, '관리자', 'N', '68b80f9032e292.36137546.png', 'Frame_125820-removebg-preview.png', '68b80f90353134.44860745.png', 'Frame_125820-removebg-preview.png', '68b80f90374db3.38169010.png', 'Frame_125820-removebg-preview.png', '68b80f90397555.40007470.png', 'Frame_125820-removebg-preview.png', '68b80f903b7784.67977255.png', 'Frame_125820-removebg-preview.png', 'N', 'https://www.youtube.com/embed/YGfQ3jbcs3g?si=C8RdlfVhWLFn9gFX', '2GR : 220~240V 60Hz', '3GR : 380~425V 60Hz', '2GR : 7200~8600W', '3GR : 7400~8800W', '2GR : 768 * 592 * 531', '3GR : 988 * 592 * 531', '2GR : 3.9L', '3GR : 3.9L', '3GR : 1.1L', '3GR : 1.1L', '2GR : 65kg', '3GR : 74kg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(130, 'SIXDOT', 23, -1, 0, 0, 'M26', '&lt;div&gt;&lt;div&gt;&lt;/div&gt;&lt;/div&gt;', '&lt;p&gt;탄탄한 기본, 견고함에 Lacimbali만의 최고 기술력을 더하다. &lt;/p&gt;&lt;p&gt;언제든, 누구나 만족할 수 있는 결과물을 보여줍니다. &lt;b&gt;M26&lt;/b&gt;&lt;/p&gt;', '', '&lt;p data-start=&quot;57&quot; data-end=&quot;122&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;스마트보일러&lt;/b&gt;&lt;br data-start=&quot;63&quot; data-end=&quot;66&quot;&gt;라심발리만의 독자적인 보일러 시스템으로 보일러 성능을 최적화 하고&lt;br data-start=&quot;102&quot; data-end=&quot;105&quot;&gt;에너지 소비를 줄여 줍니다.&lt;/p&gt;&lt;p data-start=&quot;254&quot; data-end=&quot;334&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;블루투스(PGS, BDS)&lt;/b&gt;&lt;br data-start=&quot;268&quot; data-end=&quot;271&quot;&gt;블루투스 연결을 통하여 LACIMBALI GRINDER와 연동하여&lt;br data-start=&quot;307&quot; data-end=&quot;310&quot;&gt;자동으로 그라인더의 분쇄도를 조절합니다.&lt;/p&gt;&lt;p data-start=&quot;398&quot; data-end=&quot;474&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;바리스타 라이트&lt;/b&gt;&lt;br data-start=&quot;417&quot; data-end=&quot;420&quot;&gt;머신의 전면과 후면의 라이트를 통하여 머신과 공간을 한층 더&lt;br data-start=&quot;453&quot; data-end=&quot;456&quot;&gt;고급스럽게 업그레이드 합니다.&lt;/p&gt;&lt;p data-start=&quot;476&quot; data-end=&quot;547&quot; style=&quot;font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-size: 16px; font-family: &amp;quot;Noto Sans KR&amp;quot;, sans-serif;&quot;&gt;&lt;b&gt;Thermo Drive&lt;/b&gt;&lt;br data-start=&quot;485&quot; data-end=&quot;488&quot;&gt;그룹에서 나오는 물에 찬물을 혼합하여 모든 음료에 대한 이상적인 온도를 조절 할 수 있습니다.&lt;/p&gt;', '', '2025-09-03 10:03:45', 0, '68b81281666008.46945052.jpg', 'N', 'N', 'N', NULL, '관리자', 'N', '68b812816abef1.33172008.png', 'Frame_125822-removebg-preview.png', '68b812816d6430.84407137.png', 'Frame_125822-removebg-preview.png', '68b812816f6e81.07728690.png', 'Frame_125822-removebg-preview.png', '68b81281718c71.03120295.png', 'Frame_125822-removebg-preview.png', '68b8128173d838.08990954.png', 'Frame_125822-removebg-preview.png', 'N', 'https://www.youtube.com/embed/T9_cFpnZ-R4?si=BZq_ikb0APsu1oUq', '2GR : 220~240V 60Hz / 380~425V 60Hz', '', '2GR : 4200~4900W', '', '2GR : 798 * 528 * 555', '', '2GR : 10L', '', '', '', '2GR : 75kg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(134, 'SIXDOT', 24, 0, 0, 0, 'sad', 'sad', NULL, NULL, NULL, NULL, '2025-09-03 13:35:55', 0, NULL, 'N', 'N', 'Y', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'dsa', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(138, 'SIXDOT', 24, 0, 0, 0, '제목 테스트입니다.', '안녕하세요.\r\n안녕하세요.\r\n\r\n안녕하세요.\r\n\r\n안녕하세요.\r\n안녕하세요.sdasdasdasdadsadsadsadsa\r\n', NULL, NULL, NULL, NULL, '2025-09-03 14:15:03', 1, NULL, 'N', 'N', 'Y', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '홍길동', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(140, 'SIXDOT', 24, 0, 0, 1, '견적 문의드립니다.', 'ㅇㅁㄴㅁㄴㅇㄴㅁㅇㄴㅇㅁㅁㄴㅇ', NULL, NULL, NULL, NULL, '2025-09-04 06:45:19', 0, NULL, 'N', 'N', 'Y', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '홍길동', 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

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
(26, 'SIXDOT', 22, '카테1', 1);

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

--
-- 테이블의 덤프 데이터 `nb_board_comment`
--

INSERT INTO `nb_board_comment` (`no`, `sitekey`, `parent_no`, `user_no`, `write_name`, `regdate`, `contents`, `isAdmin`, `pwd`) VALUES
(15, 'SIXDOT', 140, -1, '관리자', '2025-09-04 08:02:12', '안녕하세요', 'Y', NULL),
(14, 'SIXDOT', 140, 0, '홍길동', '2025-09-04 07:14:44', '질문 있습니다.\r\n\r\n그러면 이건 이렇게 되는건가요?', 'N', NULL);

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

--
-- 테이블의 덤프 데이터 `nb_board_lev_manage`
--

INSERT INTO `nb_board_lev_manage` (`no`, `sitekey`, `board_no`, `lev_no`, `role_write`, `role_edit`, `role_view`, `role_list`, `role_delete`, `role_comment`) VALUES
(3, 'SIXDOT', 24, 0, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');

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
(22, 'SIXDOT', 'SCOTSMAN', 'pro', '2025-09-03 07:25:02', '', NULL, 'Y', 'N', 0, 12, 0, 'N', 0, 'N', NULL, NULL, NULL, NULL, 'Y', 'SAD', '', '', '', '', '', '', '', '', '', '', '', '', '', 'SDA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y', 'init'),
(23, 'SIXDOT', 'Lacimbali', 'pro', '2025-09-03 07:46:08', '', NULL, 'Y', 'N', 0, 20, 0, 'N', 0, 'N', NULL, NULL, NULL, NULL, 'N', '전기 모델 1 ', '전기 모델 2', '전력 모델 1', '전력 모델 2', '사이즈 모델 1', '사이즈 모델 2', '스팀보일러 모델 1', '스팀보일러 모델 2', '커피보일러 모델 1', '커피보일러 모델 2', '무게 모델 1', '무게 모델 2', '메뉴 모델 1', '메뉴 모델 2', '추출양 모델 1', '추출양 모델 2', 'HOT WATER WAND 모델 1', 'HOT WATER WAND 모델 2', 'TURBO STEAM 모델 1', 'TURBO STEAM 모델 2', 'MILK 모델 1', 'MILK 모델 2', 'GRINDER/HOPER 모델 1', 'GRINDER/HOPER 모델 2 ', 'HOPER CAP 모델 1', 'HOPER CAP 모델 2', '', '', '', '', 'Y', 'init'),
(24, 'SIXDOT', '간편 문의', 'bbs', '2025-09-03 12:59:09', '', NULL, 'Y', 'Y', 0, 20, 0, 'N', 0, 'Y', NULL, NULL, NULL, NULL, 'N', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', 'init');

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

--
-- 테이블의 덤프 데이터 `nb_branch_seos`
--

INSERT INTO `nb_branch_seos` (`id`, `path`, `page_title`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`, `section_title`, `topic_title`) VALUES
(57, 'products/view.php', 'ㄴㅁㅇㅁㄴㅇ', 'ㅁㄴㅇㅁㄴ', 'ㅁㄴ', 'ㄴㅇ', '2025-09-03 01:13:48', '2025-09-03 01:13:54', NULL, NULL);

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
  `non_pay_last_modified` varchar(255) DEFAULT NULL,
  `banner_rolling_times` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

--
-- 테이블의 덤프 데이터 `nb_faqs`
--

INSERT INTO `nb_faqs` (`id`, `categories`, `question`, `answer`, `sort_no`, `is_active`, `created_at`, `updated_at`) VALUES
(41, 1, '주문 후 배송까지 얼마나 걸리나요?', '주문 확정 후 평균 2~3 영업일 내 출고되며, 지역에 따라 수령까지 1~2일 추가 소요될 수 있습니다.', 9, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(42, 1, '주문 내역은 어디서 확인하나요?', '마이페이지 > 주문내역에서 실시간으로 확인할 수 있습니다.', 49, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(43, 1, '현금영수증 발급이 가능한가요?', '가능합니다. 결제 완료 후 마이페이지에서 자진발급하거나 고객센터로 요청해 주세요.', 89, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(44, 1, '예약 상품과 일반 상품을 함께 주문해도 되나요?', '가능하지만 예약 상품의 출고일에 맞춰 일괄 발송됩니다.', 129, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(45, 1, '대량 구매 할인 있나요?', '수량 및 품목에 따라 협의가 가능합니다. 고객센터로 문의해 주세요.', 169, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(46, 2, '제품이 고장났어요. A/S는 어떻게 신청하나요?', '마이페이지 > A/S 신청에서 접수하거나, 고객센터(이메일/전화)로 접수해 주세요.', 19, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(47, 2, '보증 기간은 얼마나 되나요?', '구매일로부터 1년입니다. 소모품은 보증 대상에서 제외될 수 있습니다.', 59, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(48, 2, '택배비는 누가 부담하나요?', '제품 불량 등 당사 귀책은 당사가 왕복 배송비를 부담합니다. 단순 과실은 고객 부담일 수 있습니다.', 99, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(49, 2, 'A/S 처리 기간은 보통 어느 정도인가요?', '접수 후 평균 5~7 영업일 소요됩니다. 부품 수급 상황에 따라 변동될 수 있습니다.', 139, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(50, 2, '서비스센터 방문 접수도 가능한가요?', '가능합니다. 방문 전 예약을 권장드립니다.', 179, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(51, 3, '단순 변심 환불이 가능한가요?', '수령 후 7일 이내 미사용/미개봉 시 가능하며 왕복 배송비가 발생할 수 있습니다.', 20, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:06'),
(52, 3, '환불은 언제 처리되나요?', '반품 상품 도착 및 확인 후 영업일 기준 3~5일 내 결제수단으로 환급됩니다.', 69, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(53, 3, '카드 취소가 보이지 않아요.', '카드사 반영까지 3~7일 걸릴 수 있습니다. 여전히 미반영이면 카드사로 문의해 주세요.', 109, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(54, 3, '교환과 환불 중 무엇이 더 빠른가요?', '일반적으로 교환보다 환불 후 재구매가 더 빠릅니다.', 149, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(55, 3, '프로모션 상품도 환불 가능한가요?', '가능하지만 사은품/쿠폰 등 프로모션 혜택도 함께 반납해야 합니다.', 189, 0, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(56, 4, '회원가입 없이도 구매할 수 있나요?', '비회원 구매가 가능합니다. 다만 주문 조회 및 A/S 편의를 위해 회원가입을 권장드립니다.', 39, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(57, 4, '영업 시간은 어떻게 되나요?', '평일 09:00~18:00 (주말/공휴일 휴무)입니다.', 79, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(58, 4, '해외 배송이 가능한가요?', '현재는 국내 배송만 지원합니다.', 119, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(59, 4, '세금계산서 발행이 되나요?', '사업자 등록증을 제출해 주시면 발행 가능합니다.', 159, 1, '2025-09-03 15:48:47', '2025-09-03 15:49:00'),
(60, 4, '뉴스레터 구독을 해지하고 싶어요.', '마이페이지 > 알림설정에서 구독 해지할 수 있습니다.', 199, 0, '2025-09-03 15:48:47', '2025-09-03 15:49:00');

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

--
-- 테이블의 덤프 데이터 `nb_popups`
--

INSERT INTO `nb_popups` (`id`, `title`, `popup_type`, `is_active`, `start_at`, `end_at`, `description`, `has_link`, `link_url`, `popup_image`, `branch_id`, `created_at`, `updated_at`, `sort_no`, `is_unlimited`, `is_target`) VALUES
(25, 'ㅁㄴㅇㅇㄴㅁ', 2, 0, '2025-09-01', '2025-09-25', 'ㅁㄴㅇ', 2, '', '68b7a0b5643499.59206479.png', NULL, '2025-09-03 01:58:13', '2025-09-03 01:58:41', 1, 2, 1);

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

--
-- 테이블의 덤프 데이터 `nb_request`
--

INSERT INTO `nb_request` (`no`, `sitekey`, `name`, `phone`, `company`, `area`, `is_confirmed`, `contents`, `regdate`) VALUES
(27, 'SIXDOT', 'ㅁㄴㅇ', 'ㅇㄴㅁ', 'ㄴㅇㅁ', '0', 0, 'ㅁㅇㄴㅇㄴㅁ', '2025-09-03 16:08:37');

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
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- 테이블의 AUTO_INCREMENT `nb_board_category`
--
ALTER TABLE `nb_board_category`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
