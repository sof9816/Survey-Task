-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2018 at 02:16 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  `qus_id` int(10) NOT NULL,
  `a1` varchar(55) NOT NULL,
  `a2` varchar(55) NOT NULL,
  `a3` varchar(55) NOT NULL,
  `a4` varchar(55) NOT NULL,
  `a5` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `survey_id`, `page_id`, `qus_id`, `a1`, `a2`, `a3`, `a4`, `a5`) VALUES
(1, 2, 1, 1, 'a1', 'a2', 'a3', 'a4', 'a5'),
(2, 2, 1, 2, 'a1', 'a22', 'a3', 'a4', 'a5'),
(3, 2, 1, 3, 'a1', 'a2', 'a3', 'a4', 'a5'),
(4, 2, 1, 4, 'a1', 'a2', 'a3', 'a4', 'a5'),
(5, 2, 1, 5, 'a1', 'a2', 'a3', 'a4', 'a5'),
(6, 2, 2, 1, 'a12', 'a2', 'a3', 'a4', 'a5'),
(7, 2, 2, 2, 'a1', 'a2', 'a3', 'a4', 'a5'),
(8, 2, 2, 3, 'a1', 'a2', 'a3', 'a4', 'a5'),
(9, 2, 2, 4, 'a1', 'a2', 'a3', 'a4', 'a5'),
(10, 2, 2, 5, 'a1', 'a2', 'a3', 'a4', 'a5'),
(11, 2, 3, 1, 'a13', 'a2', 'a3', 'a4', 'a5'),
(12, 2, 3, 2, 'a1', 'a2', 'a3', 'a4', 'a5'),
(13, 2, 3, 3, 'a1', 'a2', 'a3', 'a4', 'a5'),
(14, 2, 3, 4, 'a1', 'a2', 'a3', 'a4', 'a5'),
(15, 2, 3, 5, 'a1', 'a2', 'a3', 'a4', 'a5');

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `id` int(5) UNSIGNED NOT NULL,
  `c_one` int(5) UNSIGNED NOT NULL,
  `c_two` int(5) UNSIGNED NOT NULL,
  `c_three` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poll`
--

INSERT INTO `poll` (`id`, `c_one`, `c_two`, `c_three`) VALUES
(1, 10, 1, 0),
(2, 1, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  `q1` varchar(255) NOT NULL,
  `q2` varchar(255) NOT NULL,
  `q3` varchar(255) NOT NULL,
  `q4` varchar(255) NOT NULL,
  `q5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `survey_id`, `page_id`, `q1`, `q2`, `q3`, `q4`, `q5`) VALUES
(1, 2, 1, 'q1', 'q2', 'q3', 'q4', 'q5'),
(2, 2, 2, 'q12', 'q2', 'q3', 'q4', 'q5'),
(3, 2, 3, 'q13', 'q2', 'q3', 'q4', 'q5');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  `qus_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `ansr_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `surisdone`
--

CREATE TABLE `surisdone` (
  `id` int(10) NOT NULL,
  `Done` bit(1) NOT NULL,
  `user_id` int(10) NOT NULL,
  `sur_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `survey_`
--

CREATE TABLE `survey_` (
  `id` int(11) NOT NULL,
  `survey_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `survey_`
--

INSERT INTO `survey_` (`id`, `survey_name`) VALUES
(1, 'Classic Survey'),
(2, 'sur2');

-- --------------------------------------------------------

--
-- Table structure for table `survey_qus`
--

CREATE TABLE `survey_qus` (
  `qus_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `question_body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `survey_qus`
--

INSERT INTO `survey_qus` (`qus_id`, `survey_id`, `question_body`) VALUES
(1, 1, 'Did you liked the subjects that is represented in the course ? '),
(2, 1, 'Do you want to attend to anther of our courses in the future ?');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(25) NOT NULL,
  `city` varchar(25) CHARACTER SET utf32 DEFAULT NULL,
  `done` tinyint(1) NOT NULL,
  `ansr1` varchar(6) DEFAULT NULL,
  `ansr2` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `email`, `fullname`, `city`, `done`, `ansr1`, `ansr2`) VALUES
(1, 'user1', 'pass1', 'e1@eamil.com', 'Full User', 'city1', 1, 'yes', 'maybe'),
(2, 'user2', 'pass2', 'sljs@sjl.com', 'user2', '', 0, NULL, NULL),
(3, 'user3', 'WNTY1MEYYdOO9gXwmvykG/RmKI6ZDU1ohqqGBYpvpp4=', 'u3@em.com', 'mustafa', '', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `qus_id` (`qus_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ansr_id` (`ansr_id`);

--
-- Indexes for table `surisdone`
--
ALTER TABLE `surisdone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sur_id` (`sur_id`);

--
-- Indexes for table `survey_`
--
ALTER TABLE `survey_`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_qus`
--
ALTER TABLE `survey_qus`
  ADD PRIMARY KEY (`qus_id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `surisdone`
--
ALTER TABLE `surisdone`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `survey_`
--
ALTER TABLE `survey_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `survey_qus`
--
ALTER TABLE `survey_qus`
  MODIFY `qus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
