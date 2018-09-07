-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2018 at 08:30 PM
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
(1, 'Course Survey');

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
(2, 'user2', 'pass2', 'sljs@sjl.com', 'user', '', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `survey_`
--
ALTER TABLE `survey_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `survey_qus`
--
ALTER TABLE `survey_qus`
  MODIFY `qus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
