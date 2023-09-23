-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2023 at 06:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi-aziz`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `classes_name` varchar(255) DEFAULT NULL,
  `classes_image` varchar(255) DEFAULT 'static/image/classes/default.png',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `classes_name`, `classes_image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Class 1', 'static/image/classes/default.png', 'Production season themselves arm material in. This kid fish right page green. Present family official save eye.', '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(2, 'Class 2', 'static/image/classes/default.png', 'Plant religious most smile politics step business. Man trial condition it move bank hard full.\nOrganization imagine really positive voice sure education. Science most of enter live.', '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(3, 'Class 3', 'static/image/classes/default.png', 'Federal fish worker model this no week. View anyone TV price weight. Pressure happen service no say back.', '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(9, 'asdasd', '9.', 'asdasffasdf', '2023-08-22 02:50:35', '2023-08-22 02:50:35'),
(10, 'ASDASD', '10.png', 'ASDASD', '2023-08-22 03:04:27', '2023-08-22 03:04:27'),
(11, 'ASDASD', '11.png', 'SADASD', '2023-08-22 03:05:00', '2023-08-22 03:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `classes_subjects`
--

CREATE TABLE `classes_subjects` (
  `id` int(11) NOT NULL,
  `classes_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes_subjects`
--

INSERT INTO `classes_subjects` (`id`, `classes_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(2, 1, 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(3, 1, 3, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(4, 2, 1, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(5, 2, 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(6, 2, 3, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(7, 3, 1, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(8, 3, 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(9, 3, 3, '2023-08-14 22:07:00', '2023-08-14 22:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` enum('video','gambar','penjelasan') NOT NULL,
  `content` text DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `subject_id`, `title`, `type`, `content`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 2, 'Air administration adult reach.', 'penjelasan', '0', 1, '2023-08-14 22:07:00', '2023-09-23 01:08:49'),
(2, 1, 'According practice bit attention answer staff.', 'penjelasan', 'Record city become source report. Teacher answer food site south town.', 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(3, 1, 'Floor Mrs just.', 'video', 'Set race west month strategy. Partner treatment onto participant agent although. Past note now thus same.', 3, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(4, 1, 'Government eye that different may.', 'gambar', 'Any people say nation you surface. Tv fine impact history later number law.', 4, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(5, 1, 'Exist police something chair civil senior alone.', 'gambar', 'Dream benefit summer best anything decision. Ready degree task itself call bring behind.', 5, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(6, 1, 'Deal face maintain on.', 'video', 'Physical performance special six yourself management itself food. Than loss benefit. Organization soon art.', 6, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(7, 1, 'Then read base because option responsibility outside.', 'gambar', 'Speak risk light important minute training power. Fish little third it if. Trouble perhaps be.', 7, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(8, 1, 'Various then magazine law mouth out.', 'penjelasan', 'Behavior activity through offer over change. Body trouble onto may form really radio news. Nearly like industry international most give.', 8, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(9, 1, 'Me Mrs now fine candidate.', 'video', 'Least stage read where. Camera white determine recently.', 9, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(10, 1, 'Item heavy spend technology weight fast.', 'video', 'Bar add detail seem explain occur activity despite. Specific enough seat animal administration. Hard senior then education guy.', 10, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(11, 2, 'Southern life degree.', 'video', 'When difference top eat contain scene. Record environment enough open environmental certainly. None offer successful but real with.', 1, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(12, 2, 'Economy amount if more financial five ten.', 'gambar', 'Finally go cost who. Record value create challenge office form. Others huge property administration could concern get.', 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(13, 2, 'About none dinner scientist development article court.', 'penjelasan', 'Make population able ground seek ball success often. Sell pretty forward explain popular. Begin really check interview the try.', 3, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(14, 2, 'Road relate despite sport treatment life improve get.', 'video', 'Main customer sing research pattern. Fund stock house entire pick less charge. Vote issue with church life.', 4, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(15, 2, 'Realize according require short ago.', 'gambar', 'Tend administration simply scientist. Trip while social outside.', 5, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(16, 2, 'Film yeah certainly.', 'penjelasan', 'Career interesting head upon main. Role doctor federal word. Theory example language include small. Partner investment notice apply high.', 6, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(17, 2, 'Land once success fact audience.', 'penjelasan', 'Note offer head like present deep according. Return suddenly technology whose early meeting.', 7, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(18, 2, 'There newspaper lay behavior.', 'penjelasan', 'Method whether take. Along call say why decide test compare.', 8, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(19, 2, 'Especially instead system.', 'video', 'Allow law spring. Just decade skin.', 9, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(20, 2, 'Pattern college federal office reduce despite dark.', 'video', 'Report about difficult certain just.', 10, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(21, 3, 'Test run executive draw eat.', 'gambar', 'Traditional eight wish per throw. Manage red TV another century current.', 1, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(22, 3, 'Sport follow PM fall road police worker.', 'gambar', 'Although generation debate fill resource air arm. Series child someone ten. Should happy stage pass indeed president.', 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(23, 3, 'Feeling drug television those look bag present.', 'gambar', 'Term perform book something form least show water. Sport five rise operation. Nothing live forward woman. Tax section think themselves road lead.', 3, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(24, 3, 'Degree rather two free half certain life among.', 'gambar', 'Laugh conference crime.', 4, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(25, 3, 'Technology perhaps policy evening similar.', 'penjelasan', 'Born always theory. Along sometimes sure national.', 5, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(26, 3, 'Speak past cell discuss.', 'video', 'Form reduce wide less far cost daughter. Weight do hear. Expect walk also couple.', 6, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(27, 3, 'Foreign help yard industry.', 'gambar', 'Play learn clear again successful station. Really its join stop. Treatment exactly little seek road side computer especially.', 7, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(28, 3, 'Thing price picture between.', 'penjelasan', 'Speak animal east concern station customer until their. Read lead pattern scene when attention. Possible modern either.', 8, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(29, 3, 'Some degree one least agency participant.', 'video', 'Present baby smile night. Benefit member at buy huge crime pressure. Music perform parent paper little politics find.', 9, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(30, 3, 'Child she remain guy task.', 'penjelasan', 'No coach election officer sure other. Site nearly sell wife evidence.', 10, '2023-08-14 22:07:00', '2023-08-14 22:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `post_tests`
--

CREATE TABLE `post_tests` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` enum('pilihan_ganda','jawaban_singkat') NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions`)),
  `sequence` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_tests`
--

INSERT INTO `post_tests` (`id`, `subject_id`, `title`, `type`, `questions`, `sequence`, `material_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Front area easy one must.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 1, 5, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(2, 1, 'During voice top far.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 2, 10, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(3, 1, 'Several almost note just people.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 3, 30, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(4, 1, 'Region quality type major daughter interview hour.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 4, 4, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(5, 1, 'Show fly add return a six.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 5, 29, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(6, 1, 'Have laugh whom.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 6, 9, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(7, 1, 'Few foot use pay local.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 7, 20, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(8, 1, 'Remember forget this.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 8, 5, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(9, 1, 'Scientist play between because learn.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 9, 11, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(10, 1, 'Get race good little sound rest adult position.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 10, 15, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(11, 2, 'Let affect among face people bill.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 1, 28, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(12, 2, 'Visit together manager reality truth back.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 2, 10, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(13, 2, 'By protect either action action back allow article.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 3, 22, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(14, 2, 'Very to trouble happy.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 4, 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(15, 2, 'Wrong issue middle laugh wall about fish.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 5, 2, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(16, 2, 'Between one against who.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 6, 25, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(17, 2, 'Music understand attention rest avoid.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 7, 26, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(18, 2, 'Time save discuss service just later.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 8, 4, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(19, 2, 'Evidence could usually data letter its.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 9, 25, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(20, 2, 'Send them suddenly first still while.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 10, 22, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(21, 3, 'Pull country bring one evening.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 1, 14, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(22, 3, 'Rest who be paper right crime dark family.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 2, 5, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(23, 3, 'Teach ask part former above area draw.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 3, 15, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(24, 3, 'Understand book when send.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 4, 27, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(25, 3, 'Approach say appear.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 5, 30, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(26, 3, 'Space avoid new may building deal weight.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 6, 28, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(27, 3, 'Goal read food president enter leg.', 'pilihan_ganda', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 7, 21, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(28, 3, 'Detail south mention section wonder true.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 8, 27, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(29, 3, 'Red order structure go hold traditional.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 9, 27, '2023-08-14 22:07:00', '2023-08-14 22:07:00'),
(30, 3, 'Stay decision city safe born.', 'jawaban_singkat', '{\"question1\": {\"question\": \"Question1\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation1\"}, \"question2\": {\"question\": \"Question2\", \"options\": [\"Option1\", \"Option2\", \"Option3\", \"Option4\"], \"answer\": 1, \"explanation\": \"Explanation2\"}}', 10, 25, '2023-08-14 22:07:00', '2023-08-14 22:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `pre_tests`
--

CREATE TABLE `pre_tests` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` enum('pilihan_ganda','jawaban_singkat') NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions`)),
  `sequence` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `subject_image` varchar(255) DEFAULT NULL,
  `subject_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_description`, `created_at`, `updated_at`, `subject_image`, `subject_code`) VALUES
(1, 'firm', 'Three might piece build hard. How people phone through performance miss police nation.\nPolicy realize several continue live economic. Deal miss miss bed add thus thousand. Message of quickly.', '2023-08-14 22:07:00', '2023-08-31 00:56:52', NULL, 'SUB0001'),
(2, 'reach', 'Out nothing hour as land then. All force weight loss in return man.\nCheck hold charge lawyer situation.\nThus fine month without different. Father security act feeling.', '2023-08-14 22:07:00', '2023-08-31 00:56:52', NULL, 'SUB0002'),
(3, 'example', 'Forget court some color about fill fund. Benefit tough share design partner. North because discussion travel collection imagine somebody.', '2023-08-14 22:07:00', '2023-08-31 00:56:52', NULL, 'SUB0003');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','teacher') NOT NULL DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fullname` varchar(100) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `profile_url` varchar(255) DEFAULT 'static/image/profile/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `fullname`, `nisn`, `class_id`, `profile_url`) VALUES
(1, 'rrobertsonss', 'julie75@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 01:42:39', 'Christine Banks', '1235906126', 3, 'static/image/profile/student_594787ac9aecf6d4a5dcf95efb7a272ab824061d837b7e99624982c73407dffc.png'),
(2, 'heathkristina', 'susan53@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Shaun Aguilar', '2461851933', 3, 'static/image/profile/default.png'),
(3, 'erika08', 'heather44@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Barbara Lang', '1004669420', 2, 'static/image/profile/default.png'),
(4, 'rebecca46', 'rodriguezlori@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:45', 'Marvin Moreno', '2678038984', 2, 'static/image/profile/default.png'),
(5, 'wileyjames', 'justin93@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Christian Barker', '6967833015', 2, 'static/image/profile/default.png'),
(6, 'sarahmorris', 'mollyjones@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Lisa Johnson', '1295512280', 1, 'static/image/profile/default.png'),
(7, 'mitchellcraig', 'oharris@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Joshua Sexton', '2336554861', 2, 'static/image/profile/default.png'),
(8, 'brewerdebbie', 'jwood@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Billy Mcbride', '9853326415', 3, 'static/image/profile/default.png'),
(10, 'dominguezsara', 'bharrison@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Jennifer Gill', '5524572145', 1, 'static/image/profile/default.png'),
(11, 'matthew34', 'chad82@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-31 00:03:39', 'Richard Daviss', '7415500328', 3, 'static/image/profile/default.png'),
(12, 'karen09', 'brianmurphy@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Paul Howard', '2559358428', 2, 'static/image/profile/default.png'),
(13, 'rodneyhowe', 'mendezrebecca@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Michael Morgan', '7116988265', 3, 'static/image/profile/default.png'),
(14, 'melvinshaw', 'paul94@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Martin Cobb', '8717650171', 3, 'static/image/profile/default.png'),
(16, 'alex96', 'ajefferson@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Andrea Chaney', '7907633104', 2, 'static/image/profile/default.png'),
(17, 'anachan', 'melissa40@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Joseph Adams', '8636619076', 1, 'static/image/profile/default.png'),
(18, 'ramosstuart', 'ronald71@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Christopher Anderson', '4420582803', 1, 'static/image/profile/default.png'),
(19, 'petersenjustin', 'vherrera@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Alyssa Shields DDS', '9995004733', 2, 'static/image/profile/default.png'),
(21, 'stephanie12', 'courtney86@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Zachary Bell', '7117223143', 2, 'static/image/profile/default.png'),
(22, 'owhite', 'michael44@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Michelle Simpson', '8369179109', 2, 'static/image/profile/default.png'),
(23, 'jporter', 'jennifer77@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Scott Stuart', '1883091900', 1, 'static/image/profile/default.png'),
(24, 'mitchellalexissssss', 'bonniebowen@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-31 00:03:57', 'Dean Velez', '2065309821', 2, 'static/image/profile/default.png'),
(25, 'kayla26', 'colton19@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Dana Bailey', '4048311188', 3, 'static/image/profile/default.png'),
(26, 'joelstewart', 'brownashley@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Lisa Howe', '7916921045', 3, 'static/image/profile/default.png'),
(28, 'sabrina25', 'bobby62@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Brian Smith', '5288324133', 2, 'static/image/profile/default.png'),
(29, 'rachael75', 'yphelps@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Matthew Wong', '1062081755', 1, 'static/image/profile/default.png'),
(30, 'pwade', 'wagnercheryl@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Betty Harmon', '2747789977', 1, 'static/image/profile/default.png'),
(31, 'williamsbrandonasdas', 'mcox@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-31 00:05:21', 'Francisco Dawson', '7532219980', 3, 'static/image/profile/default.png'),
(33, 'oliverbrandons', 'christopher63@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-31 00:06:27', 'Victor Stephenson', '9469475305', 3, 'static/image/profile/default.png'),
(35, 'sanchezbrian', 'brandonyoung@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Duane Duncan', '1075375802', 1, 'static/image/profile/default.png'),
(37, 'xrodriguez', 'ronaldwright@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Jacob Russo', '4611979189', 3, 'static/image/profile/default.png'),
(39, 'williamsjohnasdasdas', 'jamesdavis@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-31 00:04:53', 'Kayla Murillo', '5140217534', 2, 'static/image/profile/default.png'),
(42, 'ngarza', 'reneeking@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Thomas Price', '6466875047', 1, 'static/image/profile/default.png'),
(43, 'natalietaylorasdasda', 'hcurtis@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-31 00:04:21', 'Linda Simpson', '1738719994', 2, 'static/image/profile/default.png'),
(44, 'johnhoward', 'clarksteven@example.net', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Daniel Nelson', '8207440730', 2, 'static/image/profile/default.png'),
(46, 'xbishop', 'sarah54@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Marcus Montgomery', '3791059693', 1, 'static/image/profile/default.png'),
(47, 'jonesscott', 'justincarroll@example.org', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Marcus Sanchez', '6295142640', 3, 'static/image/profile/default.png'),
(48, 'wscott', 'williamsterri@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'student', '2023-08-14 22:07:00', '2023-08-30 00:32:06', 'Christina Arnold', '3683671269', 2, 'static/image/profile/default.png'),
(52, 'stevehernandez', 'williamstyler@example.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'teacher', '2023-08-14 22:07:00', '2023-08-22 02:38:59', 'Tammy Knight', NULL, NULL, 'static/image/profile/default.png'),
(53, 'ikimukti', 'iki.mukti@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'admin', '2023-08-15 06:16:18', '2023-08-22 02:38:04', 'Firmansyah Mukti Wijaya', 'dafault', NULL, 'static/image/profile/default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes_subjects`
--
ALTER TABLE `classes_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`classes_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `post_tests`
--
ALTER TABLE `post_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `pre_tests`
--
ALTER TABLE `pre_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_subject_code` (`subject_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `classes_subjects`
--
ALTER TABLE `classes_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `post_tests`
--
ALTER TABLE `post_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pre_tests`
--
ALTER TABLE `pre_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes_subjects`
--
ALTER TABLE `classes_subjects`
  ADD CONSTRAINT `classes_subjects_ibfk_1` FOREIGN KEY (`classes_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `classes_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `post_tests`
--
ALTER TABLE `post_tests`
  ADD CONSTRAINT `post_tests_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `post_tests_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

--
-- Constraints for table `pre_tests`
--
ALTER TABLE `pre_tests`
  ADD CONSTRAINT `pre_tests_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `pre_tests_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
