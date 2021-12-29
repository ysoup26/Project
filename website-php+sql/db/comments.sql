-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 21-11-01 10:24
-- 서버 버전: 10.4.20-MariaDB
-- PHP 버전: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `my_db`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user` varchar(40) NOT NULL,
  `content` varchar(50) NOT NULL,
  `postId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `comments`
--

INSERT INTO `comments` (`id`, `user`, `content`, `postId`) VALUES
(1, 'one', '좋은 자료 감사합니다', 2),
(2, 'admin', '와! 정말 유용한 글이네요!', 1),
(3, 'four', '요즘 이것저것 하느라 늦게 자곤 하는데 고쳐야겠네요', 5),
(4, 'four', '무작정 많이 하면 좋을 줄 알았는데 몸에 부담을 주고있었네요..', 7),
(5, 'four', '긍정적 마인드!', 11),
(6, 'four', '너무 막막하게 생각하지 말고 작은 것부터 시작해보아요.', 28),
(7, 'one', '마지막 문장이 너무 맘에 드네요~', 26),
(8, 'one', '중요성을 깨닫고 실천하시다니 충분히 멋있습니다! 너무 부담같지 말고 하나씩 해보아요', 21),
(9, 'one', '음 저도 햄버거를 먹으면 항상 기분이 좋아져여ㅋㅋ', 31),
(10, 'two', '와 멋있는 식단이에요 저탄고지를 완벽하게 지키셨네요', 25),
(11, 'two', '좋아요! 말하는 것만큼 사람을 긍정적이게 만드는건 없죠!', 11),
(12, 'two', '걱정하지마세요! 저도 많이 나가지만 열심히 하고 있어요^^', 28),
(13, 'one', '살찐 우리집 고양이는 귀여운데...저는 왜이렇게...', 28),
(14, 'one', '아니 스쿼트 자세가 잘못되었네요. 다른 사람을 위해서 수정해주세요!', 9),
(15, 'one', '와! 집에서 하기 간단해보이네요 집에서하는 운동이 참 편하죠', 16),
(16, 'one', '하루에 하나씩! 좋은 것 같아요', 18),
(17, 'one', '헬스장 어디가야 고민했는데 감사합니다.', 24),
(18, 'one', '좋은 글이네요! 제 글도 보러와주세요^^', 10);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
