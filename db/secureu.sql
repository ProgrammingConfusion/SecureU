-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2019 at 02:51 AM
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
  `attempt_credits` int(11) NOT NULL DEFAULT '0',
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attempts`
--

INSERT INTO `attempts` (`attempt_id`, `attempt_time_elapsed`, `attempt_date`, `attempt_score`, `attempt_credits`, `quiz_id`, `user_id`) VALUES
(1, '00:00:00', '2019-08-16 02:10:56', 2, 5, 1, 11),
(2, '00:00:00', '2019-08-16 02:12:15', 3, 1, 1, 11),
(3, '00:00:00', '2019-08-16 02:27:23', 1, 2, 1, 12),
(4, '00:00:00', '2019-08-16 02:28:01', 3, 4, 1, 12),
(5, '00:00:00', '2019-08-16 15:19:49', 2, 0, 1, 12),
(6, '00:00:00', '2019-08-16 15:33:09', 0, 0, 6, 12),
(7, '00:00:00', '2019-08-16 15:33:26', 1, 3, 6, 12);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL,
  `content_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_num` int(11) NOT NULL,
  `content_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_code` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_file` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `content_name`, `content_num`, `content_type`, `content_code`, `content_file`, `unit_id`) VALUES
(5, 'How Password Managers Work', 1, 'Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/DI72oBhMgWs\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '', 3),
(6, 'How Passwords are stolen', 1, 'Video', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/S_i8EhJWQ48\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '', 9),
(8, 'Security PDF', 3, 'PDF', '', 'content_files/IPR_dosSantosLeandro.pdf', 9),
(10, 'How to secure your PC from phishing scam', 3, 'Slide', '<iframe src=\"//www.slideshare.net/slideshow/embed_code/key/ECvOWLJLfC2SJf\" width=\"595\" height=\"485\" frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" style=\"border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%;\" allowfullscreen> </iframe> <div style=\"margin-bottom:5px\"> <strong> <a href=\"//www.slideshare.net/xatechnologies/how-to-secure-your-pc-from-phishing-scams-162564490\" title=\"How to secure your pc from phishing scams\" target=\"_blank\">How to secure your pc from phishing scams</a> </strong> from <strong><a href=\"https://www.slideshare.net/xatechnologies\" target=\"_blank\">XA Technologies</a></strong> </div>', '', 9);

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
  `credits_req` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_desc`, `course_img`, `course_status`, `credits_req`, `date_created`, `user_id`) VALUES
(3, 'Anti-Phishing', 'Learn how to avoid Phishing Attacks', 'images/secure-your-computer-large-1024x669.jpg', '', 0, '2019-07-09 23:27:57', 11),
(5, 'Password Managers', 'Learn about Password Managers and how to use them', 'images/secure-your-computer-large-1024x669.jpg', '', 0, '2019-07-10 02:56:40', 11),
(6, '2-Factor Authentication', 'Learn how 2-Factor Authentication works and which one you should use', 'images/secure-your-computer-large-1024x669.jpg', '', 0, '2019-07-10 02:58:39', 12),
(7, 'How to choose a password', 'Learn how to best choose a password and secure your online accounts', 'images/secure-your-computer-large-1024x669.jpg', '', 0, '2019-08-15 17:00:01', 11);

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `post_id` int(11) NOT NULL,
  `post_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_credits` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`post_id`, `post_name`, `post_content`, `post_date`, `post_credits`, `unit_id`, `user_id`) VALUES
(1, 'Problems with question 2', 'Hi, I can\'t figure out the answer to question 2, the video in unit 3 doesn\'t seem to really answer it. Thanks', '2019-08-16 13:51:16', 0, 9, 11);

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
  `question_credits` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_type`, `question_content`, `answer_content`, `answer_a`, `answer_b`, `answer_c`, `answer_d`, `question_credits`, `user_id`) VALUES
(1, 'Fill in the blank', 'What is an opensource Password Manager?', 'Keypass', 'No answer set.', 'No answer set.', 'No answer set.', 'No answer set.', 2, 11),
(2, 'True or False', 'are password managers available for mobile', 'True', 'False', 'True', 'No answer set.', 'No answer set.', 1, 11),
(3, 'Multiple Choice', 'What is one feature password managers do not offer?', 'None of the above', 'Suggested passwords', 'Browser extensions', 'None of the above', 'Compromised password checks', 3, 11),
(28, 'Multiple Choice', 'What is the first thing to look for checking if a site is legitimate?', 'HTTPS in the address bar', 'URL ending with \".com\"', 'HTTPS in the address bar', 'Options for dark mode', 'If the site has any ads', 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_desc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_tip` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_tip_timer` int(11) NOT NULL,
  `quiz_question_total` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `quiz_name`, `quiz_desc`, `quiz_tip`, `quiz_tip_timer`, `quiz_question_total`, `unit_id`, `user_id`) VALUES
(1, 'Password Manager Quiz 1', 'Quiz on Password Manager Basics', '', 15, 3, 8, 11),
(6, 'Basic Phishing Avoidance', 'Quiz on the easiest ways to avoid being victim to a phishing attack.', 'If you are having difficulty, view units 1 and 2.', 15, 1, 4, 11);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `quiz_question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`quiz_question_id`, `quiz_id`, `question_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(25, 6, 28);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_responses`
--

CREATE TABLE `quiz_responses` (
  `response_id` int(11) NOT NULL,
  `response_score` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_responses`
--

INSERT INTO `quiz_responses` (`response_id`, `response_score`, `quiz_question_id`, `attempt_id`) VALUES
(1, 1, 1, 1),
(2, 0, 2, 1),
(3, 1, 3, 1),
(4, 1, 1, 2),
(5, 1, 2, 2),
(6, 1, 3, 2),
(7, 1, 1, 3),
(8, 0, 2, 3),
(9, 0, 3, 3),
(10, 1, 1, 4),
(11, 1, 2, 4),
(12, 1, 3, 4),
(13, 1, 1, 5),
(14, 0, 2, 5),
(15, 1, 3, 5),
(16, 0, 25, 6),
(17, 1, 25, 7);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_num` int(11) NOT NULL,
  `unit_desc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `unit_num`, `unit_desc`, `course_id`, `user_id`) VALUES
(3, 'Introduction to Password Managers', 1, 'An Introduction into how Password Managers work', 5, 11),
(4, 'Introduction to Anti-Phishing Quiz', 2, 'Introduction of phishing attacks', 3, 11),
(6, 'Common Password Manager Features', 2, 'An overview of the more common Password Manager features and how they protect your accounts', 5, 11),
(8, 'Password Manager Quiz', 3, 'First quiz on the basics of Password Managers', 5, 11),
(9, 'Phishing Explained', 1, 'Introduction to phishing attacks', 3, 11);

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
  `user_img` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_dob` date NOT NULL,
  `user_role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_credits` int(11) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `first_name`, `last_name`, `user_img`, `user_dob`, `user_role`, `user_credits`, `reg_date`) VALUES
(3, 'a@a.com', 'a', '$2y$10$bBI2aLNnm9rzKEkTPKe8mOe5RGYB8gE/tA2Vp9X/c5/JdwP.6IT.G', 'a', 'a', '', '0000-00-00', 'student', 0, '2019-07-03 15:15:18'),
(11, 'b@b.com', 'b', '$2y$10$5C1sZAutbhu2Su3FOKdKCuKGxpBKpAZ3z9TZ5FbrfxSz6Ay8A61QK', 'b', 'b', 'https://bootdey.com/img/Content/avatar/avatar3.png', '1995-05-19', 'teacher', 12, '2019-07-09 22:29:37'),
(12, 'c@c.com', 'c', '$2y$10$VAjW7SC2HBg6MZee6AA9PeTQhWokfUVL4HEYLusVQ5aAH3NBJ9P7y', 'c', 'c', '', '2019-07-17', 'teacher', 9, '2019-07-10 02:57:25');

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
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`post_id`);

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
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `quiz_responses`
--
ALTER TABLE `quiz_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
