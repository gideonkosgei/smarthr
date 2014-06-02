-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2014 at 10:02 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smarthr`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `manager_status` varchar(30) DEFAULT NULL,
  `application_date` date NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `staff_id` (`staff_id`,`leave_id`),
  KEY `leave_id` (`leave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `staff_id`, `leave_id`, `date_from`, `date_to`, `status`, `manager_status`, `application_date`, `department_id`) VALUES
(1, 15, 13, '2014-04-29', '2014-05-02', 'granted', 'granted', '2014-04-29', 84),
(2, 17, 13, '2014-05-02', '2014-05-30', 'granted', 'granted', '2014-04-29', 84),
(3, 32, 13, '2014-05-02', '2014-05-15', 'rejected', 'rejected', '2014-04-29', 84),
(4, 33, 26, '2014-05-02', '2014-05-30', 'granted', 'granted', '2014-04-29', 84),
(5, 15, 26, '2014-05-02', '2014-05-30', 'cancelled', '', '2014-04-29', 84),
(6, 15, 26, '2014-04-29', '2014-05-28', 'cancelled', '', '2014-04-29', 84),
(7, 26, 13, '2014-05-02', '2014-05-30', 'cancelled', '', '2014-04-29', 87),
(9, 40, 13, '2014-04-30', '2014-05-09', 'granted', 'granted', '2014-04-30', 84),
(10, 40, 13, '2014-04-30', '2014-05-05', 'cancelled', '', '2014-04-30', 84),
(11, 40, 13, '2014-05-02', '2014-05-29', 'cancelled', '', '2014-04-30', 84),
(12, 40, 13, '2014-05-02', '2014-05-29', 'cancelled', '', '2014-04-30', 84);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'human resourses'),
(84, 'ICT'),
(85, 'finance'),
(87, 'security'),
(88, 'audit'),
(93, 'catering');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE IF NOT EXISTS `holidays` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(30) NOT NULL,
  `holiday_date` varchar(20) NOT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`holiday_id`, `holiday_name`, `holiday_date`) VALUES
(25, 'Christmass', '25-December'),
(26, 'Jamhuri', '12-December'),
(27, 'Madaraka', '01-May'),
(28, 'Labor Day', '26-April');

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE IF NOT EXISTS `leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_name` varchar(50) NOT NULL,
  `leave_type` varchar(20) NOT NULL,
  `max_days` int(11) NOT NULL,
  `qualification` varchar(30) NOT NULL,
  `applicability` varchar(30) NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`leave_id`, `leave_name`, `leave_type`, `max_days`, `qualification`, `applicability`) VALUES
(13, 'paternal', 'annual', 30, 'permanent', 'male'),
(26, 'maternal leave', 'spontaneous', 90, 'ALL', 'female'),
(31, 'annual leave', 'annual', 27, 'permanent', 'all'),
(36, 'sick leave', 'spontaneous', 20, 'all', 'all'),
(37, 'study leave', 'spontaneous', 50, 'permanent', 'all'),
(38, 'compassionate leave', 'spontaneous', 14, 'all', 'all');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `sender`, `receiver`, `subject`, `message`, `date_time`) VALUES
(1, 15, 16, 'Leave Application Request', 'I Have Sent A Leave Application For Your Approval', '0000-00-00 00:00:00'),
(2, 16, 1, ' Leave Approval', 'I Have Approved  A Leave Application For 15,Please Make The Necessary Facilitations', '0000-00-00 00:00:00'),
(3, 1, 15, 'Leave Application Granted', 'Your Leave Application Has Been Accepted.', '0000-00-00 00:00:00'),
(4, 17, 16, 'Leave Application Request', 'I Have Sent A Leave Application For Your Approval', '0000-00-00 00:00:00'),
(5, 16, 1, ' Leave Approval', 'I Have Approved  A Leave Application For 17,Please Make The Necessary Facilitations', '0000-00-00 00:00:00'),
(6, 1, 17, 'Leave Application Granted', 'Your Leave Application Has Been Accepted.', '0000-00-00 00:00:00'),
(7, 32, 16, 'Leave Application Request', 'I Have Sent A Leave Application For Your Approval', '0000-00-00 00:00:00'),
(8, 16, 0, 'Leave Application Rejected', 'Your Leave Application Has Cancelled ', '0000-00-00 00:00:00'),
(9, 33, 16, 'Leave Application Request', 'I Have Sent A Leave Application For Your Approval', '0000-00-00 00:00:00'),
(10, 16, 1, ' Leave Approval', 'I Have Approved  A Leave Application For 33,Please Make The Necessary Facilitations', '0000-00-00 00:00:00'),
(11, 1, 33, 'Leave Application Granted', 'Your Leave Application Has Been Accepted.', '0000-00-00 00:00:00'),
(12, 1, 15, 'salamu', 'niaje', '2014-04-29 07:52:11'),
(13, 15, 16, 'Cancellation Of LeaveApplication Request', 'I Have Cancelled My Leave Application', '0000-00-00 00:00:00'),
(14, 15, 16, 'Cancellation Of LeaveApplication Request', 'I Have Cancelled My Leave Application', '0000-00-00 00:00:00'),
(17, 39, 16, 'Leave Application Request', 'I Have Sent A Leave Application For Your Approval', '0000-00-00 00:00:00'),
(18, 16, 1, ' Leave Approval', 'I Have Approved  A Leave Application For temp temp,Please Make The Necessary Facilitations', '0000-00-00 00:00:00'),
(19, 40, 16, 'Leave Application Request', 'I Have Sent A Leave Application For Your Approval', '0000-00-00 00:00:00'),
(20, 16, 1, ' Leave Approval', 'I Have Approved  A Leave Application For julius kogo,Please Make The Necessary Facilitations', '0000-00-00 00:00:00'),
(21, 1, 40, 'Leave Application Granted', 'Your Leave Application Has Been Accepted.', '0000-00-00 00:00:00'),
(22, 40, 16, 'Cancellation Of LeaveApplication Request', 'I Have Cancelled My Leave Application', '0000-00-00 00:00:00'),
(23, 40, 16, 'Cancellation Of LeaveApplication Request', 'I Have Cancelled My Leave Application', '0000-00-00 00:00:00'),
(24, 40, 16, 'Cancellation Of LeaveApplication Request', 'I Have Cancelled My Leave Application', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `contract_type` varchar(30) NOT NULL,
  `department_id` int(11) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT ' session',
  `gender` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'regular',
  `locked` varchar(10) NOT NULL DEFAULT 'no',
  `adm` varchar(10) DEFAULT NULL,
  `manager` varchar(10) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`staff_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `first_name`, `last_name`, `contract_type`, `department_id`, `balance`, `username`, `password`, `status`, `gender`, `type`, `locked`, `adm`, `manager`) VALUES
(1, 'Racheal ', 'Njagi', 'permanent', 1, 0, 'hr', 'hr', ' session', 'female', 'hr', 'no', 'hr', 'yes'),
(14, 'Samuel', 'maina', 'permanent', 84, 70, 'samuel', 'maina', 'session', 'male', '', 'no', '', ''),
(15, 'Paul', 'Ruto', 'permanent', 84, 70, 'paul', 'ruto', 'session', 'male', '', 'no', '', ''),
(16, 'Paul', 'Njoroge', 'permanent', 84, 70, 'paul', 'njoroge', 'session', 'male', 'manager', 'no', 'manager', 'yes'),
(17, 'Hillary', 'mutai', 'permanent', 84, 70, 'hillary', 'mutai', 'leave', 'male', '', 'no', '', ''),
(18, 'anthony', 'Muchunu', 'permanent', 88, 70, '50809', '536001e71a3d8', 'session', 'male', '', '', '', ''),
(19, 'hellen', 'kwamboka', 'permanent', 88, 10, '67333', '5350de2e883ab', 'session', 'female', '', '', '', ''),
(20, 'William', 'Momanyi', 'permanent', 88, 70, '29633', '5350de468f79e', 'session', 'male', '', '', '', ''),
(21, 'Bildad', 'mutttu', 'permanent', 88, 70, '92300', '5350de6ac110f', 'session', 'male', '', '', '', ''),
(22, 'john', 'kebut', 'permanent', 85, 70, '95746', '5350de85cf09e', 'session', 'male', '', '', '', ''),
(23, 'pius', 'Njoka', 'permanent', 85, 60, '51163', '5350dea16fa04', 'session', 'male', '', '', '', ''),
(24, 'jerry', 'chongwony', 'permanent', 85, 60, '82313', '5350dec69da55', 'session', 'male', '', '', '', ''),
(25, 'martin', 'juma', 'permanent', 85, 60, '62795', '5350dee093e6d', 'session', 'male', '', '', '', ''),
(26, 'oloo', 'aringo', 'permanent', 87, 60, 'oloo', 'aringo', 'session', 'male', '', 'no', '', ''),
(27, 'steve', 'wafula', 'permanent', 87, 80, '33551', '5350df173ea86', 'session', 'male', '', '', '', ''),
(28, 'milka', 'nyasae', 'permanent', 93, 10, '76992', '5350df6ce1481', 'session', 'female', '', '', '', ''),
(29, 'justin', 'wamboi', 'permanent', 93, 10, '23145', '5350df8444324', 'session', 'female', '', '', '', ''),
(31, 'sophia', 'chebet', 'permanent', 93, 10, '41972', '5350ec5b7a751', 'session', 'female', 'manager', '', 'manager', 'yes'),
(32, 'gideon', 'kosgei', 'permanent', 84, 40, 'gideon', 'kosgei', 'session', 'male', '', 'no', '', ''),
(33, 'jacky', 'wangeci', 'permanent', 84, 10, 'jacky', '536002265e7b0', 'leave', 'female', '', 'no', '', ''),
(39, 'tempsd', 'tempsh', 'permanent', 1, 10, '20300', '5360087c5f10b', 'session', 'male', '', 'no', '', ''),
(40, 'julius', 'kogo', 'permanent', 84, 4, '15977', '5360a14aeb253', 'leave', 'male', '', 'no', '', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`leave_id`) REFERENCES `leave` (`leave_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
