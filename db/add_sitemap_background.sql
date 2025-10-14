-- 1. 기존 테이블 삭제
DROP TABLE IF EXISTS nb_etcs;

-- 2. 새 테이블 생성
CREATE TABLE nb_etcs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    bg_image VARCHAR(255) DEFAULT NULL
);

-- 3. 기본 데이터 삽입
INSERT INTO nb_etcs (title, bg_image)
VALUES
('default', NULL),
('about', NULL),
('works', NULL),
('news', NULL),
('contact', NULL);

