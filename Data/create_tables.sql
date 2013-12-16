-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2013 at 07:22 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `seankraf_h4_seankraft_fall2013_biz`
--
CREATE DATABASE IF NOT EXISTS `seankraf_h4_seankraft_fall2013_biz` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `seankraf_h4_seankraft_fall2013_biz`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_name`) VALUES
(1, 'Concern Software'),
(2, 'Concern Software Systems'),
(3, 'Concern Software LLC'),
(4, 'Bubba Gump Shrimp');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned DEFAULT NULL,
  `answer_text` varchar(200) DEFAULT NULL,
  `answer_order` int(10) unsigned DEFAULT NULL,
  `correct` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `question_id`, `answer_text`, `answer_order`, `correct`) VALUES
(1, 12, 'True', 0, 0),
(2, 12, 'False', 1, 1),
(3, 13, 'True', 0, 1),
(4, 13, 'False', 1, 0),
(9, NULL, '15', 0, NULL),
(10, NULL, '15', 0, NULL),
(34, 16, 'Many', 6, 1),
(35, 16, 'A lot', 7, NULL),
(36, 16, 'Few', 8, 1),
(37, 16, '3', 9, 1),
(38, 17, 'Christmas 2007', 0, 1),
(39, 17, 'Octoberfest 2006', 1, 0),
(42, 19, 'Please fill out the essay question', 0, 1),
(43, 20, 'Please fill out the essay question', 0, 1),
(44, 21, 'True', 0, 1),
(45, 21, 'False', 1, 0),
(46, 22, 'Duster', 0, 1),
(48, 22, 'Challenger', 1, 1),
(49, 22, 'Nova', 2, 0),
(50, 22, 'Station Wagon', 3, 0),
(51, 22, 'Ferrarri', 4, NULL),
(52, 23, 'Please fill out the essay question', 0, 1),
(53, 24, 'Rav4', 0, 1),
(54, 24, 'Honda Accord', 1, 0),
(55, 24, 'Pickup', 2, 0),
(56, 25, 'The stop sign', 0, NULL),
(57, 25, 'The yield sign', 1, 1),
(58, 25, 'The go-forward sign', 2, NULL),
(59, 26, 'True', 0, 1),
(60, 26, 'False', 1, 0),
(61, 27, '1, 2, 3, 4, 5, 6, 7', 0, 0),
(62, 27, '1, 2, 3, 4, 5, 6, 7, 8, 9', 1, 0),
(63, 27, '1, 2, 3, 4, 5, 6, 7, 8, 9, 10', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `job_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `account_id`, `department_name`, `job_title`) VALUES
(1, 1, 'Administration', '0'),
(2, 2, 'Administration', 'Test Administrator'),
(3, 3, 'Administration', 'Test Administrator'),
(4, 4, 'Administration', 'Test Administrator'),
(5, 4, '', 'Special Projects'),
(6, 4, '', 'Build Engineer'),
(7, 4, '', 'Test Taker'),
(8, 4, '', '1000854'),
(9, 4, '', 'Farm Worker'),
(10, 4, '', 'Singer');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_order` int(10) unsigned NOT NULL,
  `test_id` int(10) unsigned NOT NULL,
  `created_by_user_id` int(10) unsigned NOT NULL,
  `question_text` varchar(2000) DEFAULT NULL,
  `question_type_id` int(10) unsigned DEFAULT NULL,
  `question_image` blob,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `all_or_none` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_order`, `test_id`, `created_by_user_id`, `question_text`, `question_type_id`, `question_image`, `created`, `updated`, `all_or_none`, `deleted`) VALUES
(1, 0, 1, 2, 'Which of the following are Woodpeckers or not', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(2, 1, 1, 2, 'Which is the state bird of New York', 2, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(3, 2, 1, 2, 'How much wood can a woodchuck chuck', 4, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(4, 3, 1, 2, 'test', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(5, 4, 1, 2, 'What type of bird was Woodstock', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(6, 5, 1, 2, 'Write a poem about a bird', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(7, 6, 1, 2, 'How many birds in this picture', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(8, 7, 1, 2, 'What\\''s the best bird', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(9, 8, 1, 2, 'How many', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(10, 9, 1, 2, 'Test 2', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(11, 10, 1, 2, 'test', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(12, 0, 6, 2, 'New Years 2008 was a great party', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(13, 1, 6, 2, '4th of July 2009 was "Cans and Clams"', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(16, 2, 6, 2, 'How many parties are there in a year', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(17, 3, 6, 2, 'Which party was the best', 2, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(19, 4, 6, 2, 'What would you like to see different at the parties', 4, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(20, 5, 6, 2, 'What was your favorite moment', 4, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(21, 0, 7, 3, 'Your first car was a Chevy Monza', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(22, 1, 7, 3, 'Which cars did I have in high school', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(23, 2, 7, 3, 'Which was your favorite car', 4, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(24, 3, 7, 3, 'Which car is your latest purchase', 2, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(25, 0, 8, 3, 'What sign is yield', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(26, 1, 8, 3, 'You need to stop at a stop sign', 3, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(27, 0, 9, 3, 'Which counts to ten', 2, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question_types`
--

CREATE TABLE IF NOT EXISTS `question_types` (
  `question_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_type_descr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`question_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `question_types`
--

INSERT INTO `question_types` (`question_type_id`, `question_type_descr`) VALUES
(1, 'Choose all correct answers'),
(2, 'Choose single correct answer'),
(3, 'True/False'),
(4, 'Essay Question');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `test_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL,
  `copied_from_test_id` int(10) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `test_descr` varchar(200) DEFAULT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `test_year` int(10) unsigned DEFAULT NULL,
  `created_by_user_id` int(10) unsigned DEFAULT NULL,
  `created_on_dt` datetime DEFAULT NULL,
  `last_updated_dt` datetime DEFAULT NULL,
  `minutes_to_complete` int(10) unsigned DEFAULT NULL,
  `passing_grade` int(10) unsigned DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_date` datetime DEFAULT NULL,
  `test_category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `account_id`, `copied_from_test_id`, `test_name`, `test_descr`, `public`, `test_year`, `created_by_user_id`, `created_on_dt`, `last_updated_dt`, `minutes_to_complete`, `passing_grade`, `deleted`, `deleted_date`, `test_category`) VALUES
(1, 3, 0, 'Birds I know of', 'these are some birds that I know and so should you', 0, 2012, NULL, NULL, '0000-00-00 00:00:00', 45, 75, 0, NULL, 'Birds'),
(2, 3, 0, 'Mountains of the hudson valley', 'know your hills', 0, 2013, NULL, NULL, '0000-00-00 00:00:00', 0, 65, 0, NULL, 'Outdoors'),
(3, 3, 0, 'Cheeses', '', 0, 2013, NULL, NULL, NULL, NULL, NULL, 0, NULL, ''),
(4, 3, 0, 'Birds I know Of 2013', 'Know your birds son', 0, 2013, NULL, NULL, '0000-00-00 00:00:00', 0, 45, 0, NULL, 'Birds'),
(5, 3, 0, 'Bikes of the 70s', 'Test about bikes', 0, 2013, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 100, 0, NULL, 'Bikes'),
(6, 3, 0, 'The Best Parties', 'Which parties were good', 0, 2013, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 100, 0, NULL, 'Party Time'),
(7, 4, 0, 'Cars I have owned', 'All about my cars', 0, 2013, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 100, 0, NULL, 'Cars'),
(8, 4, 0, 'Driving Test', 'New Jersey', 0, 2013, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 75, 0, NULL, 'Driving'),
(9, 4, 0, 'Counts I like', 'Some counts that I like', 0, 2013, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 100, 0, NULL, 'Counts');

-- --------------------------------------------------------

--
-- Table structure for table `testtaker_staging`
--

CREATE TABLE IF NOT EXISTS `testtaker_staging` (
  `testtaker_staging_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_by_user_id` int(10) unsigned DEFAULT NULL,
  `created` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`testtaker_staging_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `testtaker_staging_rows`
--

CREATE TABLE IF NOT EXISTS `testtaker_staging_rows` (
  `testtaker_staging_row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `testtaker_staging_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `person_id` varchar(100) DEFAULT NULL,
  `issue_text` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`testtaker_staging_row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_assign_status`
--

CREATE TABLE IF NOT EXISTS `test_assign_status` (
  `test_assign_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_assign_status_descr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`test_assign_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `test_assign_status`
--

INSERT INTO `test_assign_status` (`test_assign_status_id`, `test_assign_status_descr`) VALUES
(1, 'Assigned'),
(2, 'Started'),
(3, 'Finished'),
(4, 'Error');

-- --------------------------------------------------------

--
-- Table structure for table `test_assign_user`
--

CREATE TABLE IF NOT EXISTS `test_assign_user` (
  `test_assign_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `test_assign_status_id` int(10) unsigned DEFAULT NULL,
  `assigned_by_user_id` int(10) unsigned DEFAULT NULL,
  `assigned_on_dt` int(11) DEFAULT NULL,
  `due_on_dt` int(11) DEFAULT NULL,
  PRIMARY KEY (`test_assign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `test_assign_user`
--

INSERT INTO `test_assign_user` (`test_assign_id`, `test_id`, `user_id`, `test_assign_status_id`, `assigned_by_user_id`, `assigned_on_dt`, `due_on_dt`) VALUES
(2, 7, 3, 2, 3, 1386947105, 1392094800),
(3, 8, 10, 1, 3, 1386967166, 1392094800),
(4, 8, 3, 3, 3, 1386967166, 1392094800),
(5, 8, 9, 1, 3, 1386967220, 1402459200),
(6, 8, 8, 1, 3, 1386967220, 1402459200),
(7, 8, 11, 1, 3, 1386967220, 1402459200),
(8, 9, 3, 3, 3, 1387216103, 1389762000);

-- --------------------------------------------------------

--
-- Table structure for table `test_instance`
--

CREATE TABLE IF NOT EXISTS `test_instance` (
  `test_instance_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_assign_id` int(10) unsigned DEFAULT NULL,
  `start_dt` datetime DEFAULT NULL,
  `finish_dt` datetime DEFAULT NULL,
  `grade` int(10) unsigned DEFAULT NULL,
  `graded` tinyint(1) DEFAULT NULL,
  `seconds_elapsed` int(10) unsigned DEFAULT NULL,
  `review_override_grade` int(10) unsigned DEFAULT NULL,
  `review_override_user_id` int(10) unsigned DEFAULT NULL,
  `review_override_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`test_instance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `test_instance`
--

INSERT INTO `test_instance` (`test_instance_id`, `test_assign_id`, `start_dt`, `finish_dt`, `grade`, `graded`, `seconds_elapsed`, `review_override_grade`, `review_override_user_id`, `review_override_comment`) VALUES
(36, 2, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 8, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 4, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_instance_answer`
--

CREATE TABLE IF NOT EXISTS `test_instance_answer` (
  `test_instance_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned DEFAULT NULL,
  `answer_text` varchar(2000) DEFAULT NULL,
  `is_selected` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`test_instance_id`,`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_instance_answer`
--

INSERT INTO `test_instance_answer` (`test_instance_id`, `question_id`, `answer_id`, `answer_text`, `is_selected`) VALUES
(37, 27, 63, NULL, 1),
(38, 25, 57, NULL, 1),
(38, 26, 59, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `job_id` int(10) unsigned DEFAULT NULL,
  `account_id` int(10) unsigned DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `person_id` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `time_zone`, `first_name`, `last_name`, `email`, `job_id`, `account_id`, `is_admin`, `person_id`) VALUES
(1, 1386455902, 1386455902, '18e7df0d114a9e6b413d73e8b66ae1abcd5eab5b', 'c0393820285407ea0cdc26cb274516bc470e1274', NULL, NULL, 'sean', 'kraft', 'sean@seankraft.com', 2, 2, 1, ''),
(2, 1386459894, 1386459894, '9de5cd1e57cec18a4faa5a5c25185f8f870e49a1', 'b4de51ccd938dd20fcb68c79e1e5b56e43d73f8e', NULL, NULL, 'Sean', 'Kraft', 'sean@concernsoftware.com', 3, 3, 1, ''),
(3, 1386822142, 1386822142, '4a132cc72bfd17708537609dc59c83c6b743e0c8', 'b4de51ccd938dd20fcb68c79e1e5b56e43d73f8e', 1387204203, NULL, 'Bubba ', 'Gump', 'bubba@gump.com', 4, 4, 1, ''),
(8, 1386823460, 1386823460, '5146b002643e932220e38297644a6a2cbb2b2ee4', 'e9bbb16910bd91917754637c1aed28b8b2f1144d', NULL, NULL, 'Carolyn', 'Quoma', 'carolynquoma@yahoo.com', 5, 4, 0, ''),
(9, 1386823460, 1386823460, 'b576a4c40f0eadfa1b40270ae76f3e046669e52b', 'e9bbb16910bd91917754637c1aed28b8b2f1144d', NULL, NULL, 'Mellon', 'Javis', 'mj@jarvis.com', 6, 4, 0, ''),
(10, 1386823946, 1386823946, '2587e237bfecfd10ce2d1f5921e4bc8032d445e4', 'e9bbb16910bd91917754637c1aed28b8b2f1144d', 1386823982, NULL, 'John', 'Baldwin', 'jbaldwin@jb.com', 7, 4, 0, ''),
(11, 1386823946, 1386823946, 'aa0a83ca23f84c0df313d6dbb290e03d80c80325', 'e9bbb16910bd91917754637c1aed28b8b2f1144d', 1386967244, NULL, 'Mark', 'Spencer', 'ms@baldwin.com', 7, 4, 0, ''),
(12, 1386851973, 1386851973, '9a859b86582eb2be565db7371708f7683303e14c', 'e9bbb16910bd91917754637c1aed28b8b2f1144d', NULL, NULL, 'Mario', 'Andretti', 'mario@andretti.com', 8, 4, 0, ''),
(13, 1386852009, 1386852009, '792303efe752e150fbb6f22bdc53965fd296ac0f', 'e9bbb16910bd91917754637c1aed28b8b2f1144d', NULL, NULL, 'Jethro', 'Tull', 'jt@tull.com', 9, 4, 0, ''),
(14, 1386857965, 1386857965, '635a231ad3ea82f49cb6b9460711cece0ad1cdf9', 'e9bbb16910bd91917754637c1aed28b8b2f1144d', NULL, NULL, 'Mark', 'Anthony', 'mark@anthony.com', 10, 4, 0, '');
