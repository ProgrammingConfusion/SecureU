-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2019 at 02:22 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `secureu`
--

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE `attempts` (
  `attempt_id` int(11) NOT NULL,
  `attempt_time_elapsed` time NOT NULL,
  `attempt_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attempt_score` int(11) NOT NULL,
  `attempt_credits` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attempts`
--

INSERT INTO `attempts` (`attempt_id`, `attempt_time_elapsed`, `attempt_date`, `attempt_score`, `attempt_credits`, `quiz_id`, `user_id`) VALUES
(1, '00:00:00', '2019-08-04 15:13:47', 1, 0, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL,
  `content_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_num` int(11) NOT NULL,
  `content_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_code` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_name`, `content_num`, `content_type`, `content_code`, `unit_id`) VALUES
(5, 'How Password Managers Work', 1, 'video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/DI72oBhMgWs\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 3);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_desc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_img` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_status`, `date_created`, `user_id`) VALUES
(3, 'Anti-Phishing', 'Learn how to avoid Phishing Attacks', '', '', '2019-07-09 23:27:57', 11),
(5, 'Password Managers', 'Learn about Password Managers and how to use them', '', '', '2019-07-10 02:56:40', 11),
(6, '2-Factor Authentication', 'Learn how 2-Factor Authentication works and which one you should use', '', '', '2019-07-10 02:58:39', 12);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_a` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No answer set.',
  `answer_b` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No answer set.',
  `answer_c` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No answer set.',
  `answer_d` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No answer set.',
  `session` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_type`, `question_content`, `answer_content`, `answer_a`, `answer_b`, `answer_c`, `answer_d`, `session`) VALUES
(1, 'Fill in the blank', 'What is an opensource Password Manager?', 'Keypass', 'No answer set.', 'No answer set.', 'No answer set.', 'No answer set.', '0'),
(2, 'True or false', 'are password managers available for mobile', 'True', 'False', 'True', 'No answer set.', 'No answer set.', '0'),
(3, 'Multiple choice', 'What is one feature password managers do not offer?', 'None of the above', 'Suggested passwords', 'Browser extensions', 'None of the above', 'Compromised password checks', '0');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_desc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_tip` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_question_total` int(11) NOT NULL,
  `quiz_credits` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `quiz_name`, `quiz_desc`, `quiz_type`, `quiz_tip`, `quiz_question_total`, `quiz_credits`, `unit_id`) VALUES
(1, 'Password Manager Quiz 1', 'Quiz on Password Manager Basics', 'Mixed', '', 3, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `quiz_question_id` int(11) NOT NULL,
  `quiz_question_num` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`quiz_question_id`, `quiz_question_num`, `quiz_id`, `question_id`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 2),
(3, 3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_responses`
--

CREATE TABLE `quiz_responses` (
  `response_id` int(11) NOT NULL,
  `response_content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_score` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_responses`
--

INSERT INTO `quiz_responses` (`response_id`, `response_content`, `response_score`, `quiz_question_id`, `attempt_id`) VALUES
(1, '', 0, 1, 1),
(2, '', 1, 2, 1),
(3, '', 0, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_num` int(11) NOT NULL,
  `unit_desc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `unit_num`, `unit_desc`, `unit_type`, `content_id`, `quiz_id`, `course_id`) VALUES
(3, 'Introduction to Password Managers', 1, 'An Introduction into how Password Managers work', '', 0, 0, 5),
(4, 'Phishing Explained', 1, 'Introduction of phishing attacks', '', 0, 0, 3),
(6, 'Common Password Manager Features', 2, 'An overview of the more common Password Manager features and how they protect your accounts', '', 0, 0, 5),
(8, 'Password Manager Quiz', 3, 'First quiz on the basics of Password Managers', '', 0, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_dob` date NOT NULL,
  `user_role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `first_name`, `last_name`, `user_dob`, `user_role`, `reg_date`) VALUES
(3, 'a@a.com', 'a', '$2y$10$bBI2aLNnm9rzKEkTPKe8mOe5RGYB8gE/tA2Vp9X/c5/JdwP.6IT.G', 'a', 'a', '0000-00-00', 'student', '2019-07-03 15:15:18'),
(11, 'b@b.com', 'b', '$2y$10$5C1sZAutbhu2Su3FOKdKCuKGxpBKpAZ3z9TZ5FbrfxSz6Ay8A61QK', 'b', 'b', '1995-05-19', 'teacher', '2019-07-09 22:29:37'),
(12, 'c@c.com', 'c', '$2y$10$VAjW7SC2HBg6MZee6AA9PeTQhWokfUVL4HEYLusVQ5aAH3NBJ9P7y', 'c', 'c', '2019-07-17', 'teacher', '2019-07-10 02:57:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`attempt_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`quiz_question_id`);

--
-- Indexes for table `quiz_responses`
--
ALTER TABLE `quiz_responses`
  ADD PRIMARY KEY (`response_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_responses`
--
ALTER TABLE `quiz_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
