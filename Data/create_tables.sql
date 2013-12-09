-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 09, 2013 at 02:37 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `seankraf_h4_seankraft_fall2013_biz`
--
CREATE DATABASE IF NOT EXISTS `seankraf_h4_seankraft_fall2013_biz` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `seankraf_h4_seankraft_fall2013_biz`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_name`) VALUES
(1, 'Concern Software'),
(2, 'Concern Software Systems'),
(3, 'Concern Software LLC');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `account_id`, `department_name`, `job_title`) VALUES
(1, 1, 'Administration', '0'),
(2, 2, 'Administration', 'Test Administrator'),
(3, 3, 'Administration', 'Test Administrator');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_order`, `test_id`, `created_by_user_id`, `question_text`, `question_type_id`, `question_image`, `created`, `updated`, `all_or_none`, `deleted`) VALUES
(1, 0, 1, 2, 'Which of the following are Woodpeckers', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(2, 1, 1, 2, 'Which is the state bird of New York', 2, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(3, 2, 1, 2, 'How much wood can a woodchuck chuck', 4, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question_types`
--

CREATE TABLE IF NOT EXISTS `question_types` (
  `question_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_type_descr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`question_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `account_id`, `copied_from_test_id`, `test_name`, `test_descr`, `public`, `test_year`, `created_by_user_id`, `created_on_dt`, `last_updated_dt`, `minutes_to_complete`, `passing_grade`, `deleted`, `deleted_date`, `test_category`) VALUES
(1, 3, 0, 'Birds I know of', 'these are some birds that I know and so should you', 0, 2012, NULL, NULL, '0000-00-00 00:00:00', 45, 75, 0, NULL, 'Birds'),
(2, 3, 0, 'Mountains of the hudson valley', 'know your hills', 0, 2013, NULL, NULL, '0000-00-00 00:00:00', 0, 65, 0, NULL, 'Outdoors'),
(3, 3, 0, 'Cheeses', '', 0, 2013, NULL, NULL, NULL, NULL, NULL, 0, NULL, ''),
(4, 3, 0, 'Birds I know Of 2013', 'Know your birds son', 0, 2013, NULL, NULL, '0000-00-00 00:00:00', 0, 45, 0, NULL, 'Birds'),
(5, 3, 0, 'Bikes of the 70s', 'Test about bikes', 0, 2013, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 100, 0, NULL, 'Bikes');

-- --------------------------------------------------------

--
-- Table structure for table `test_assign_status`
--

CREATE TABLE IF NOT EXISTS `test_assign_status` (
  `test_assign_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_assign_status_descr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`test_assign_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `assigned_on_dt` datetime DEFAULT NULL,
  `due_on_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`test_assign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_instance_answer`
--

CREATE TABLE IF NOT EXISTS `test_instance_answer` (
  `tests_instance_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned DEFAULT NULL,
  `answer_text` varchar(2000) DEFAULT NULL,
  `is_selected` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tests_instance_id`,`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `time_zone`, `first_name`, `last_name`, `email`, `job_id`, `account_id`, `is_admin`) VALUES
(1, 1386455902, 1386455902, '18e7df0d114a9e6b413d73e8b66ae1abcd5eab5b', 'c0393820285407ea0cdc26cb274516bc470e1274', NULL, NULL, 'sean', 'kraft', 'sean@seankraft.com', 2, 2, 1),
(2, 1386459894, 1386459894, '50fe6534337198545a08829c7ad0d1e8e5ed5791', 'b4de51ccd938dd20fcb68c79e1e5b56e43d73f8e', NULL, NULL, 'Sean', 'Kraft', 'sean@concernsoftware.com', 3, 3, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
