-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 15, 2017 at 10:06 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_lagos`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_classitems`
--

DROP TABLE IF EXISTS `account_classitems`;
CREATE TABLE IF NOT EXISTS `account_classitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `signature_created` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'account_class',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_classitems`
--

INSERT INTO `account_classitems` (`ID`, `title`, `description`, `signature_created`, `type`, `date_created`, `date_modified`) VALUES
(1, 'DRINK', 'DRINKS', 'MAZ', 'account_class', '0000-00-00 00:00:00', '2017-08-02 20:19:28'),
(2, 'FOOD', 'FOOD', 'MAZ', 'account_class', '0000-00-00 00:00:00', '2017-05-03 21:42:43'),
(3, 'HALL', 'HALL', 'MAZ', 'account_class', '2015-10-09 00:00:00', '2017-04-28 20:27:08'),
(4, 'LAUND', 'LAUNDRY', 'MAZ', 'account_class', '2015-11-04 00:00:00', '0000-00-00 00:00:00'),
(5, 'OTHER', 'OTHERS', '', 'account_class', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'ROOM', 'ROOM', 'JBA', 'account_class', '2015-10-09 00:00:00', '2017-03-10 18:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `account_discountitems`
--

DROP TABLE IF EXISTS `account_discountitems`;
CREATE TABLE IF NOT EXISTS `account_discountitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'account_discount',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_discountitems`
--

INSERT INTO `account_discountitems` (`ID`, `title`, `description`, `type`, `signature_created`, `date_created`, `date_modified`) VALUES
(1, 'ROOM', 'ROOM', 'account_discount', 'JBA', '0000-00-00 00:00:00', '2017-03-10 17:49:03'),
(2, 'HALL', 'HALL', 'account_discount', 'MAZ', '0000-00-00 00:00:00', '2017-05-03 21:43:26'),
(3, 'RESTAURANT', NULL, 'account_discount', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'DRINKS', NULL, 'account_discount', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'LAUNDRY', NULL, 'account_discount', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `account_paymentitems`
--

DROP TABLE IF EXISTS `account_paymentitems`;
CREATE TABLE IF NOT EXISTS `account_paymentitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text,
  `alias` varchar(255) DEFAULT NULL,
  `accounttype` tinyint(3) NOT NULL,
  `debit_credit` enum('debit','credit') NOT NULL DEFAULT 'debit',
  `cash_declaration` enum('no','yes') NOT NULL DEFAULT 'no',
  `accountclass` tinyint(3) NOT NULL,
  `enable` enum('no','yes') NOT NULL DEFAULT 'yes',
  `type` varchar(255) NOT NULL DEFAULT 'account_payment',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `payment_index` (`code`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_paymentitems`
--

INSERT INTO `account_paymentitems` (`ID`, `title`, `code`, `description`, `alias`, `accounttype`, `debit_credit`, `cash_declaration`, `accountclass`, `enable`, `type`, `signature_created`, `date_created`, `date_modified`) VALUES
(1, 'CASH2', '1010', 'CASH PAYMENT', 'CASH PAYMENT', 5, 'credit', 'no', 2, 'yes', 'account_payment', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:50:24'),
(2, 'CHQ', '1020', 'CHEQUE PAYMENT', '', 1, 'credit', 'no', 2, 'yes', 'account_payment', 'MAZ', '2015-10-10 00:00:00', '2017-05-05 07:11:44'),
(3, 'DRCD', '1040', 'DEBIT CARD PAYMENT3', '', 1, 'credit', 'no', 5, 'yes', 'account_payment', 'MAZ', '2015-12-08 00:00:00', '2017-05-03 16:51:59'),
(4, 'CRCD', '1050', 'CREDIT CARD PAYMENT', '', 5, 'credit', 'no', 5, 'yes', 'account_payment', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:52:58'),
(5, 'REFUN', '1060', 'CASH REFUND', 'CASH REFUND', 5, 'credit', 'no', 6, 'yes', 'account_payment', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(6, 'COMP', '1090', 'COMPLIMENTARY', '', 1, 'credit', 'no', 5, 'yes', 'account_payment', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:54:53'),
(7, 'CLEDG', '4000', 'CITY LEDGER', '', 16, 'credit', 'no', 5, 'yes', 'account_payment', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:55:29'),
(8, 'GLEDG', '4010', 'GUEST LEDGER', '', 8, 'debit', 'no', 5, 'yes', 'account_payment', 'MAZ', '2015-12-08 00:00:00', '2017-05-03 16:55:54'),
(9, 'POSCH', '1015', 'POS PAYMENT', '', 5, 'credit', 'no', 5, 'yes', 'account_payment', 'MAZ', '2016-01-01 00:00:00', '2017-05-03 16:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `account_plu_groupitems`
--

DROP TABLE IF EXISTS `account_plu_groupitems`;
CREATE TABLE IF NOT EXISTS `account_plu_groupitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `signature_created` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'account_plu_group',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `type` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_plu_groupitems`
--

INSERT INTO `account_plu_groupitems` (`ID`, `title`, `description`, `signature_created`, `type`, `date_created`, `date_modified`) VALUES
(1, 'BF', 'BREAKFAST (100 - 200)', '', 'account_plu_group', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'CONFR', 'HALLS & CONFERENCES (701 - 705', 'MAZ', 'account_plu_group', '2015-11-28 00:00:00', '0000-00-00 00:00:00'),
(3, 'DINNE', 'DINNER (301 - 400)', 'JBA', 'account_plu_group', '2015-12-27 00:00:00', '0000-00-00 00:00:00'),
(4, 'DRINK', 'DRINK', 'JBA', 'account_plu_group', '2016-01-01 00:00:00', '0000-00-00 00:00:00'),
(5, 'HALLS', 'HALL CHARGES', 'JBA', 'account_plu_group', '2016-01-01 00:00:00', '0000-00-00 00:00:00'),
(6, 'LAUND', 'LAUNDRY', 'JBA', 'account_plu_group', '2016-01-01 00:00:00', '0000-00-00 00:00:00'),
(10, 'FOOD', 'FOOD', 'JBA', 'account_plu_group', '2016-01-01 00:00:00', '0000-00-00 00:00:00'),
(11, 'REST', 'RESTAURANT', 'JBA', 'account_plu_group', '2016-11-22 00:00:00', '0000-00-00 00:00:00'),
(12, 'ROOM', 'STANDARD', 'JBA', 'account_plu_group', '2017-09-11 06:26:00', '2017-09-11 06:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `account_plu_numberitems`
--

DROP TABLE IF EXISTS `account_plu_numberitems`;
CREATE TABLE IF NOT EXISTS `account_plu_numberitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `plu_group` tinyint(3) NOT NULL,
  `acctsale` tinyint(3) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(255) NOT NULL DEFAULT 'account_plu_number',
  `enable` enum('no','yes') NOT NULL DEFAULT 'no',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_plu_numberitems`
--

INSERT INTO `account_plu_numberitems` (`ID`, `title`, `plu_group`, `acctsale`, `description`, `price`, `cost`, `type`, `enable`, `signature_created`, `date_created`, `date_modified`) VALUES
(1, '100', 10, 13, 'FOOD', '0.00', '0.00', 'account_plu_number', 'yes', 'MAZ', '2016-01-01 00:00:00', '2017-02-16 15:55:31'),
(2, '101', 4, 14, 'DRINK', '0.00', '0.00', 'account_plu_number', 'yes', 'MAZ', '2016-01-01 00:00:00', '2017-02-16 15:56:57'),
(3, '407', 5, 9, 'HALL', '0.00', '0.00', 'account_plu_number', 'yes', 'MAZ', '2016-01-01 00:00:00', '2017-02-16 15:57:38'),
(7, '200', 6, 15, 'LAUNDRY', '0.00', '0.00', 'account_plu_number', 'yes', 'MAZ', '2016-01-01 00:00:00', '2017-02-16 15:58:09'),
(8, '1001', 11, 10, 'RESTAURANT', '0.00', '0.00', 'account_plu_number', 'yes', 'MAZ', '2016-11-22 00:00:00', '2017-02-16 15:59:08'),
(9, '300', 12, 5, 'STANDARD ROOM', '0.00', '0.00', 'account_plu_number', 'yes', 'JBA', '2017-09-11 06:27:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `account_saleitems`
--

DROP TABLE IF EXISTS `account_saleitems`;
CREATE TABLE IF NOT EXISTS `account_saleitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `alias` varchar(255) DEFAULT NULL,
  `accounttype` tinyint(3) NOT NULL,
  `accountclass` tinyint(3) NOT NULL,
  `debit_credit` enum('debit','credit') NOT NULL DEFAULT 'debit',
  `vattype` enum('excl','incl') NOT NULL DEFAULT 'excl',
  `vatpercent` decimal(10,2) DEFAULT '0.00',
  `salescategory` tinyint(3) NOT NULL,
  `discountcategory` tinyint(3) NOT NULL,
  `default_price` decimal(10,2) DEFAULT '0.00',
  `service_charge` enum('no','yes') NOT NULL DEFAULT 'no',
  `enable` enum('no','yes') NOT NULL DEFAULT 'yes',
  `type` varchar(255) NOT NULL DEFAULT 'account_sale',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name_title` (`code`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_saleitems`
--

INSERT INTO `account_saleitems` (`ID`, `code`, `title`, `description`, `alias`, `accounttype`, `accountclass`, `debit_credit`, `vattype`, `vatpercent`, `salescategory`, `discountcategory`, `default_price`, `service_charge`, `enable`, `type`, `signature_created`, `date_created`, `date_modified`) VALUES
(1, '1216', 'GLEDG', 'GUEST LEDGER', '', 8, 1, 'credit', 'excl', '0.00', 1, 1, '0.00', 'no', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:28:35'),
(2, '2400', 'IVAT', 'IN VAT', '', 7, 2, 'credit', 'excl', '5.00', 4, 3, '10.00', 'no', 'yes', 'account_sale', 'JBA', '2015-10-10 00:00:00', '2017-03-11 15:24:08'),
(3, '2410', 'OVAT', 'OUT VAT', '', 6, 5, 'debit', 'excl', '0.00', 5, 1, '0.00', 'no', 'yes', 'account_sale', 'MAZ', '2015-12-08 00:00:00', '2017-05-03 16:38:30'),
(4, '2420', 'SC', 'SERVICE CHARGE', '', 15, 5, 'debit', 'excl', '0.00', 5, 0, '0.00', 'no', 'yes', 'account_sale', 'MAZ', '2015-12-08 00:00:00', '2017-04-28 15:07:09'),
(5, '3010', 'STANDARD', 'STANDARD ROOM', '', 2, 6, 'debit', 'excl', '0.00', 1, 1, '0.00', 'no', 'yes', 'account_sale', 'MAZ', '2015-12-08 00:00:00', '2017-09-19 13:40:28'),
(9, '3060', 'HALL', 'HALLS', '', 1, 3, 'debit', 'incl', '5.00', 2, 2, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:39:21'),
(10, '3110', 'REST', 'BREAKFAST', '', 1, 2, 'debit', 'incl', '5.00', 4, 3, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:39:47'),
(11, '3120', 'LUNCH', 'LUNCH', '', 1, 2, 'debit', 'incl', '5.00', 2, 3, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:40:16'),
(12, '3130', 'DINN', 'DINNER', '', 1, 2, 'debit', 'incl', '5.00', 2, 3, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:40:38'),
(13, '3140', 'POS1', 'FOOD', '', 1, 2, 'debit', 'incl', '5.00', 4, 3, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:41:03'),
(14, '3145', 'POS2', 'DRINKS', '', 1, 1, 'debit', 'incl', '5.00', 3, 4, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-12-08 00:00:00', '2017-05-03 16:41:32'),
(15, '3150', 'LAUND', 'LAUNDRY', '', 1, 4, 'debit', 'incl', '5.00', 5, 5, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:41:54'),
(16, '3160', 'TEL', 'TELEPHONE', 'TEL', 21, 0, 'debit', 'incl', '5.00', 1, 5, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:42:31'),
(17, '3170', 'SURCH', 'EXECUTIVE ROOM', 'SURCHARGE FOR LATE CHECKOUT', 1, 5, 'debit', 'incl', '5.00', 1, 1, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:42:57'),
(18, '3190', 'SALES', 'OTHER SALES', '', 1, 5, 'debit', 'incl', '5.00', 5, 1, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:43:48'),
(19, '3310', 'DISRM', 'DISCOUNT ON ROOM', '', 25, 6, 'credit', 'incl', '5.00', 1, 1, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:44:22'),
(20, '3320', 'DISHL', 'DISCOUNT ON HALL', '', 25, 3, 'credit', 'incl', '5.00', 2, 2, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:44:53'),
(21, '7155', 'COMM', 'AGENCY  COMMISSION', '', 9, 2, 'credit', 'incl', '5.00', 5, 1, '0.00', 'yes', 'yes', 'account_sale', 'MAZ', '2015-10-10 00:00:00', '2017-05-03 16:45:21'),
(22, '2430', 'IVAT2', 'IN VAT2 DIFFERENT', '', 7, 5, 'credit', 'excl', '0.00', 5, 1, '0.00', 'no', 'yes', 'account_sale', 'MAZ', '2015-12-19 00:00:00', '2017-05-03 16:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `account_salescategoryitems`
--

DROP TABLE IF EXISTS `account_salescategoryitems`;
CREATE TABLE IF NOT EXISTS `account_salescategoryitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'account_salescategory',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_salescategoryitems`
--

INSERT INTO `account_salescategoryitems` (`ID`, `title`, `description`, `type`, `signature_created`, `date_created`, `date_modified`) VALUES
(1, 'ROOM', 'ROOM', 'account_salescategory', 'MAZ', '0000-00-00 00:00:00', '2017-04-28 19:43:46'),
(2, 'HALL', '', 'account_salescategory', 'JBA', '0000-00-00 00:00:00', '2017-03-10 18:44:47'),
(3, 'DRINKS', NULL, 'account_salescategory', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'FOOD', NULL, 'account_salescategory', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'OTHERS', NULL, 'account_salescategory', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `account_typeitems`
--

DROP TABLE IF EXISTS `account_typeitems`;
CREATE TABLE IF NOT EXISTS `account_typeitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'account_type',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_typeitems`
--

INSERT INTO `account_typeitems` (`ID`, `title`, `description`, `type`, `signature_created`, `date_created`, `date_modified`) VALUES
(1, 'STANDARD', 'STANDARD', 'account_type', 'JBA', '2015-10-06 00:00:00', '2017-03-10 17:31:15'),
(2, 'ROOM', '', 'account_type', 'OLA', '2015-10-07 00:00:00', '0000-00-00 00:00:00'),
(3, 'BOARD', 'BOARD', 'account_type', 'JBA', '2015-10-07 00:00:00', '2017-03-10 17:31:40'),
(4, 'N/A', '', 'account_type', 'OLA', '2015-09-04 00:00:00', '0000-00-00 00:00:00'),
(5, 'CASH', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(6, 'VAT OUT', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(7, 'VAT IN', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(8, 'GUEST LEDGER', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(9, 'COMMISSION', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(10, 'INVOICE CLOSING', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(11, 'FUNCTION ROOM', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(12, 'INVOICE FEE', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(13, 'ROUNDING', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(14, 'NIGHT TAX', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(15, 'SERVICE CHARGE', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(16, 'CITY LEDGER', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(17, 'DEPOSIT LEDGER', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(18, 'DEPOSIT REFUND', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(19, 'DEPOSIT PROFIT', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(20, 'REMOTE PAYMENT', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(21, 'TELEPHONE', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(22, 'CANCELLATION FEE', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(23, 'hPOS SERVICE CHARGE', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(24, 'hPOS MOVE', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(25, 'DISCOUNT', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(26, 'INTER HOTEL LEDGER', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(27, 'INTER HOTEL SALES', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(28, 'VOUCHER LEDGER', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(29, 'VOUCHER PAYMENT', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(30, 'VOUCHER REFUND', '', 'account_type', 'OLA', '2015-10-10 00:00:00', '0000-00-00 00:00:00'),
(31, 'VOUCHER PROFIT', 'VOCHER', 'account_type', 'JBA', '2015-10-10 00:00:00', '2017-03-10 17:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `limits`
--

DROP TABLE IF EXISTS `limits`;
CREATE TABLE IF NOT EXISTS `limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logitems`
--

DROP TABLE IF EXISTS `logitems`;
CREATE TABLE IF NOT EXISTS `logitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `description` text,
  `old_value` text,
  `new_value` text,
  `reason` text,
  `type` varchar(255) NOT NULL DEFAULT 'log',
  `signature_created` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='logs of sensitive activities';

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE IF NOT EXISTS `maintenance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `last_rooms_charge` datetime NOT NULL,
  `last_close_account` datetime NOT NULL,
  `charged_rooms_count` int(11) NOT NULL,
  `allow_pos` enum('0','1') NOT NULL DEFAULT '0',
  `license_key` varchar(50) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `install_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`ID`, `last_rooms_charge`, `last_close_account`, `charged_rooms_count`, `allow_pos`, `license_key`, `status`, `install_date`, `expire_date`) VALUES
(1, '2017-10-15 11:06:44', '2017-10-15 11:06:44', 0, '0', 'sha256:1000:Y2To7NU0srktPJv7kXOvhTaexvNb763E:NcizR', '1', '2017-10-15 11:06:44', '2017-10-15 11:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `personitems`
--

DROP TABLE IF EXISTS `personitems`;
CREATE TABLE IF NOT EXISTS `personitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sex` enum('m','f') NOT NULL DEFAULT 'm',
  `title_ref` varchar(255) DEFAULT NULL,
  `passport_no` varchar(255) DEFAULT NULL,
  `pp_issued_at` varchar(255) DEFAULT NULL,
  `pp_issued_date` date DEFAULT '0000-00-00',
  `pp_expiry_date` date DEFAULT '0000-00-00',
  `visa` varchar(255) DEFAULT NULL,
  `resident_permit_no` varchar(255) DEFAULT NULL,
  `spg_no` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT '0000-00-00',
  `birth_location` varchar(255) DEFAULT NULL,
  `reservation_id` varchar(255) DEFAULT NULL,
  `remarks` text,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `signature_created` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'person',
  `destination` varchar(255) DEFAULT NULL,
  `payment_method` enum('coy','cash','pos','cheque','others') NOT NULL DEFAULT 'cash',
  `group_name` varchar(255) DEFAULT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `contacts_id` (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `priceitems`
--

DROP TABLE IF EXISTS `priceitems`;
CREATE TABLE IF NOT EXISTS `priceitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinyint(3) NOT NULL,
  `description` text,
  `type` varchar(255) NOT NULL DEFAULT 'price',
  `acctsale` tinyint(3) NOT NULL,
  `comp_nights` tinyint(3) NOT NULL,
  `comp_visits` enum('no','yes') NOT NULL DEFAULT 'no',
  `enable` enum('no','yes') NOT NULL DEFAULT 'no',
  `adults` tinyint(3) NOT NULL,
  `children` tinyint(3) NOT NULL,
  `special` tinyint(3) NOT NULL,
  `weekday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weekend` decimal(10,2) NOT NULL DEFAULT '0.00',
  `holiday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_countryitems`
--

DROP TABLE IF EXISTS `ref_countryitems`;
CREATE TABLE IF NOT EXISTS `ref_countryitems` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_countryitems`
--

INSERT INTO `ref_countryitems` (`ID`, `title`) VALUES
(1, 'Afghanistan'),
(2, 'Akrotiri'),
(3, 'Albania'),
(4, 'Algeria'),
(5, 'American Samoa'),
(6, 'Andorra'),
(7, 'Angola'),
(8, 'Anguilla'),
(9, 'Antarctica'),
(10, 'Antigua and Barbuda'),
(11, 'Argentina'),
(12, 'Armenia'),
(13, 'Aruba'),
(14, 'Ashmore and Cartier '),
(15, 'Australia'),
(16, 'Austria'),
(17, 'Azerbaijan'),
(18, 'Bahamas, The'),
(19, 'Bahrain'),
(20, 'Bangladesh'),
(21, 'Barbados'),
(22, 'Bassas da India'),
(23, 'Belarus'),
(24, 'Belgium'),
(25, 'Belize'),
(26, 'Benin'),
(27, 'Bermuda'),
(28, 'Bhutan'),
(29, 'Bolivia'),
(30, 'Bosnia and Herzegovi'),
(31, 'Botswana'),
(32, 'Bouvet Island'),
(33, 'Brazil'),
(34, 'British Indian Ocean'),
(35, 'British Virgin Islan'),
(36, 'Brunei'),
(37, 'Bulgaria'),
(38, 'Burkina Faso'),
(39, 'Burma'),
(40, 'Burundi'),
(41, 'Cambodia'),
(42, 'Cameroon'),
(43, 'Canada'),
(44, 'Cape Verde'),
(45, 'Cayman Islands'),
(46, 'Central African Repu'),
(47, 'Chad'),
(48, 'Chile'),
(49, 'China'),
(50, 'Christmas Island'),
(51, 'Clipperton Island'),
(52, 'Cocos (Keeling) Isla'),
(53, 'Colombia'),
(54, 'Comoros'),
(55, 'Congo, Democratic Re'),
(56, 'Congo, Republic of t'),
(57, 'Cook Islands'),
(58, 'Coral Sea Islands'),
(59, 'Costa Rica'),
(60, 'Cote d&singlequot;Iv'),
(61, 'Croatia'),
(62, 'Cuba'),
(63, 'Cyprus'),
(64, 'Czech Republic'),
(65, 'Denmark'),
(66, 'Dhekelia'),
(67, 'Djibouti'),
(68, 'Dominica'),
(69, 'Dominican Republic'),
(70, 'Ecuador'),
(71, 'Egypt'),
(72, 'El Salvador'),
(73, 'Equatorial Guinea'),
(74, 'Eritrea'),
(75, 'Estonia'),
(76, 'Ethiopia'),
(77, 'Europa Island'),
(78, 'Falkland Islands (Is'),
(79, 'Faroe Islands'),
(80, 'Fiji'),
(81, 'Finland'),
(82, 'France'),
(83, 'French Guiana'),
(84, 'French Polynesia'),
(85, 'French Southern and '),
(86, 'Gabon'),
(87, 'Gambia, The'),
(88, 'Gaza Strip'),
(89, 'Georgia'),
(90, 'Germany'),
(91, 'Ghana'),
(92, 'Gibraltar'),
(93, 'Glorioso Islands'),
(94, 'Greece'),
(95, 'Greenland'),
(96, 'Grenada'),
(97, 'Guadeloupe'),
(98, 'Guam'),
(99, 'Guatemala'),
(100, 'Guernsey'),
(101, 'Guinea'),
(102, 'Guinea-Bissau'),
(103, 'Guyana'),
(104, 'Haiti'),
(105, 'Heard Island and McD'),
(106, 'Holy See (Vatican Ci'),
(107, 'Honduras'),
(108, 'Hong Kong'),
(109, 'Hungary'),
(110, 'Iceland'),
(111, 'India'),
(112, 'Indonesia'),
(113, 'Iran'),
(114, 'Iraq'),
(115, 'Ireland'),
(116, 'Isle of Man'),
(117, 'Israel'),
(118, 'Italy'),
(119, 'Jamaica'),
(120, 'Jan Mayen'),
(121, 'Japan'),
(122, 'Jersey'),
(123, 'Jordan'),
(124, 'Juan de Nova Island'),
(125, 'Kazakhstan'),
(126, 'Kenya'),
(127, 'Kiribati'),
(128, 'Korea, North'),
(129, 'Korea, South'),
(130, 'Kuwait'),
(131, 'Kyrgyzstan'),
(132, 'Laos'),
(133, 'Latvia'),
(134, 'Lebanon'),
(135, 'Lesotho'),
(136, 'Liberia'),
(137, 'Libya'),
(138, 'Liechtenstein'),
(139, 'Lithuania'),
(140, 'Luxembourg'),
(141, 'Macau'),
(142, 'Macedonia'),
(143, 'Madagascar'),
(144, 'Malawi'),
(145, 'Malaysia'),
(146, 'Maldives'),
(147, 'Mali'),
(148, 'Malta'),
(149, 'Marshall Islands'),
(150, 'Martinique'),
(151, 'Mauritania'),
(152, 'Mauritius'),
(153, 'Mayotte'),
(154, 'Mexico'),
(155, 'Micronesia, Federate'),
(156, 'Moldova'),
(157, 'Monaco'),
(158, 'Mongolia'),
(159, 'Montserrat'),
(160, 'Morocco'),
(161, 'Mozambique'),
(162, 'Namibia'),
(163, 'Nauru'),
(164, 'Navassa Island'),
(165, 'Nepal'),
(166, 'Netherlands'),
(167, 'Netherlands Antilles'),
(168, 'New Caledonia'),
(169, 'New Zealand'),
(170, 'Nicaragua'),
(171, 'Niger'),
(172, 'Nigeria'),
(173, 'Niue'),
(174, 'Norfolk Island'),
(175, 'Northern Mariana Isl'),
(176, 'Norway'),
(177, 'Oman'),
(178, 'Pakistan'),
(179, 'Palau'),
(180, 'Panama'),
(181, 'Papua New Guinea'),
(182, 'Paracel Islands'),
(183, 'Paraguay'),
(184, 'Peru'),
(185, 'Philippines'),
(186, 'Pitcairn Islands'),
(187, 'Poland'),
(188, 'Portugal'),
(189, 'Puerto Rico'),
(190, 'Qatar'),
(191, 'Reunion'),
(192, 'Romania'),
(193, 'Russia'),
(194, 'Rwanda'),
(195, 'Saint Helena'),
(196, 'Saint Kitts and Nevi'),
(197, 'Saint Lucia'),
(198, 'Saint Pierre and Miq'),
(199, 'Saint Vincent and th'),
(200, 'Samoa'),
(201, 'San Marino'),
(202, 'Sao Tome and Princip'),
(203, 'Saudi Arabia'),
(204, 'Senegal'),
(205, 'Serbia and Montenegr'),
(206, 'Seychelles'),
(207, 'Sierra Leone'),
(208, 'Singapore'),
(209, 'Slovakia'),
(210, 'Slovenia'),
(211, 'Solomon Islands'),
(212, 'Somalia'),
(213, 'South Africa'),
(214, 'South Georgia and th'),
(215, 'Spain'),
(216, 'Spratly Islands'),
(217, 'Sri Lanka'),
(218, 'Sudan'),
(219, 'Suriname'),
(220, 'Svalbard'),
(221, 'Swaziland'),
(222, 'Sweden'),
(223, 'Switzerland'),
(224, 'Syria'),
(225, 'Taiwan'),
(226, 'Tajikistan'),
(227, 'Tanzania'),
(228, 'Thailand'),
(229, 'Timor-Leste'),
(230, 'Togo'),
(231, 'Tokelau'),
(232, 'Tonga'),
(233, 'Trinidad and Tobago'),
(234, 'Tromelin Island'),
(235, 'Tunisia'),
(236, 'Turkey'),
(237, 'Turkmenistan'),
(238, 'Turks and Caicos Isl'),
(239, 'Tuvalu'),
(240, 'Uganda'),
(241, 'Ukraine'),
(242, 'United Arab Emirates'),
(243, 'United Kingdom'),
(244, 'United States'),
(245, 'Uruguay'),
(246, 'Uzbekistan'),
(247, 'Vanuatu'),
(248, 'Venezuela'),
(249, 'Vietnam'),
(250, 'Virgin Islands'),
(251, 'Wake Island'),
(252, 'Wallis and Futuna'),
(253, 'West Bank'),
(254, 'Western Sahara'),
(255, 'Yemen'),
(256, 'Zambia'),
(257, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `ref_roomstatus`
--

DROP TABLE IF EXISTS `ref_roomstatus`;
CREATE TABLE IF NOT EXISTS `ref_roomstatus` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `signature_created` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_roomstatus`
--

INSERT INTO `ref_roomstatus` (`ID`, `title`, `date_created`, `signature_created`) VALUES
(1, 'vacant', '2015-10-19 00:00:00', 'SAN'),
(2, 'vacant_dirty', '2015-10-19 00:00:00', 'SAN'),
(3, 'occupied', '2015-10-19 00:00:00', 'SAN'),
(4, 'occupied_dirty', '2015-10-19 00:00:00', 'SAN'),
(5, 'reserved', '2015-10-19 00:00:00', 'SAN'),
(6, 'out_of_use', '2015-10-19 00:00:00', 'SAN'),
(7, 'blocked', '2015-10-19 00:00:00', 'SAN');

-- --------------------------------------------------------

--
-- Table structure for table `reservationfolioitems`
--

DROP TABLE IF EXISTS `reservationfolioitems`;
CREATE TABLE IF NOT EXISTS `reservationfolioitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` varchar(255) NOT NULL,
  `description` text,
  `plu_group` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `debit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pak` varchar(10) DEFAULT NULL,
  `sub_folio` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `account_number` int(11) NOT NULL,
  `links` varchar(100) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `terminal` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `charge` varchar(255) DEFAULT NULL,
  `audit` varchar(255) DEFAULT NULL,
  `action` enum('sale','payment') NOT NULL DEFAULT 'sale',
  `plu` int(11) DEFAULT NULL,
  `reason` text,
  `type` varchar(255) NOT NULL DEFAULT 'reservationfolio',
  `signature_created` varchar(255) NOT NULL,
  `signature_modified` varchar(255) DEFAULT NULL,
  `status` enum('active','closed','ledger') NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservationitems`
--

DROP TABLE IF EXISTS `reservationitems`;
CREATE TABLE IF NOT EXISTS `reservationitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` varchar(255) NOT NULL,
  `account_type` enum('ROOM','HOUSE','GROUP') NOT NULL DEFAULT 'ROOM',
  `master_id` varchar(255) DEFAULT NULL,
  `arrival` date NOT NULL,
  `nights` int(11) NOT NULL DEFAULT '1',
  `departure` date NOT NULL,
  `room_number` tinyint(3) NOT NULL DEFAULT '0',
  `roomtype` int(2) NOT NULL,
  `client_type` enum('person','group') NOT NULL DEFAULT 'person',
  `client_name` varchar(255) NOT NULL,
  `agency_name` varchar(255) DEFAULT NULL,
  `agency_contact` text,
  `guest1` varchar(255) DEFAULT NULL,
  `guest2` varchar(255) DEFAULT NULL,
  `guest_count` int(3) DEFAULT '0',
  `adults` int(2) DEFAULT '1',
  `children` int(2) DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT 'reservation',
  `remarks` text,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `signature_created` varchar(255) NOT NULL,
  `signature_modified` varchar(255) DEFAULT NULL,
  `status` enum('staying','confirmed','departed','cancelled','provisional','ledger') NOT NULL DEFAULT 'confirmed',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `actual_arrival` datetime DEFAULT '0000-00-00 00:00:00',
  `actual_departure` datetime DEFAULT '0000-00-00 00:00:00',
  `last_room_charge` datetime DEFAULT '0000-00-00 00:00:00',
  `last_account_close` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `reservations_id` (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservationpriceitems`
--

DROP TABLE IF EXISTS `reservationpriceitems`;
CREATE TABLE IF NOT EXISTS `reservationpriceitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` varchar(255) NOT NULL,
  `price_rate` tinyint(3) NOT NULL,
  `folio_room` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `folio_extra` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `folio_other` enum('BILL1','BILL2','BILL3','BILL4','INV') NOT NULL DEFAULT 'BILL1',
  `weekday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weekend` decimal(10,2) NOT NULL DEFAULT '0.00',
  `holiday` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(255) NOT NULL DEFAULT 'reservationprice',
  `price_room` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_extra` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice` enum('none','client','agency') NOT NULL DEFAULT 'none',
  `comp_nights` int(3) NOT NULL DEFAULT '0',
  `comp_visits` enum('yes','no') NOT NULL DEFAULT 'no',
  `auto_deposit` enum('yes','no') NOT NULL DEFAULT 'no',
  `block_pos` enum('yes','no') NOT NULL DEFAULT 'no',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `charge_from_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `reservations_id` (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roleitems`
--

DROP TABLE IF EXISTS `roleitems`;
CREATE TABLE IF NOT EXISTS `roleitems` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `reserv_folio` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `reports` enum('1','2') NOT NULL DEFAULT '1',
  `utilities` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `maintenance` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `monitors` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `configuration` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `prices` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `overview` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `delete_group` enum('0','1') NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT 'role',
  `signature_created` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `usergroup_desc` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COMMENT='user roles';

--
-- Dumping data for table `roleitems`
--

INSERT INTO `roleitems` (`ID`, `title`, `description`, `reserv_folio`, `reports`, `utilities`, `maintenance`, `monitors`, `configuration`, `prices`, `overview`, `delete_group`, `type`, `signature_created`, `date_created`, `date_modified`) VALUES
(1, 'F/O', 'FRONT OFFICE STAFF', '3', '2', '3', '3', '1', '1', '1', '2', '0', 'role', '', '2017-03-02 21:33:35', '2017-08-02 20:37:41'),
(2, 'F/M', 'FRONT OFFICE MANAGER', '4', '2', '3', '3', '2', '1', '3', '2', '1', 'role', '', '2017-03-05 17:32:32', '1970-01-01 11:05:15'),
(3, 'ACC', 'ACCOUNTANT', '4', '2', '3', '3', '2', '1', '3', '3', '1', 'role', '', '2017-03-05 17:43:31', '2017-09-01 11:28:52'),
(4, 'IT', 'IT MANAGERS', '4', '2', '3', '3', '2', '3', '4', '3', '1', 'role', '', '2017-03-05 18:33:18', '2017-03-09 14:35:47'),
(8, 'F/O_FB', 'FRONT OFFICE, WITH FOOD AND BAR', '4', '2', '3', '3', '2', '3', '3', '3', '1', 'role', '', '2017-03-05 19:36:55', '2017-08-16 08:54:21'),
(9, 'F/O_HK', 'front office with housekeeping', '2', '2', '3', '4', '1', '1', '1', '1', '1', 'role', '', '2017-03-09 09:12:48', '0000-00-00 00:00:00'),
(28, 'ADMIN', 'ADMIN', '4', '2', '4', '4', '4', '4', '4', '4', '1', 'role', 'JBA', '2017-03-09 16:02:46', '2017-03-10 09:08:10'),
(29, 'SUPER', 'SUPER', '4', '2', '4', '4', '4', '4', '4', '4', '1', 'role', 'JBA', '2017-03-09 16:02:46', '2017-03-10 08:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `roomclassitems`
--

DROP TABLE IF EXISTS `roomclassitems`;
CREATE TABLE IF NOT EXISTS `roomclassitems` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `signature_created` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'roomclass',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `room_class` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roomclassitems`
--

INSERT INTO `roomclassitems` (`ID`, `title`, `description`, `signature_created`, `type`, `date_created`, `date_modified`) VALUES
(2, 'STANDARD', 'STANDARD ROOM', 'JBA', 'roomclass', '2017-09-01 11:30:46', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roomitems`
--

DROP TABLE IF EXISTS `roomitems`;
CREATE TABLE IF NOT EXISTS `roomitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `roomtype` tinyint(3) NOT NULL,
  `roomclass` tinyint(3) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `description` text,
  `bed` int(3) NOT NULL DEFAULT '1',
  `firstfloor` enum('0','1') DEFAULT '0',
  `secondfloor` enum('0','1') DEFAULT '0',
  `thirdfloor` enum('0','1') DEFAULT '0',
  `groundfloor` enum('0','1') DEFAULT '0',
  `frontview` enum('0','1') DEFAULT '0',
  `backview` enum('0','1') DEFAULT '0',
  `remark` text,
  `acctname` tinyint(3) NOT NULL,
  `lock_room` enum('0','1') DEFAULT '0',
  `close_phone_tv` enum('0','1') DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT 'room',
  `signature_created` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `room_number` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roomtypeitems`
--

DROP TABLE IF EXISTS `roomtypeitems`;
CREATE TABLE IF NOT EXISTS `roomtypeitems` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `roomclass` tinyint(3) NOT NULL,
  `beds` int(3) NOT NULL DEFAULT '0',
  `description` text,
  `remark` text,
  `type` varchar(255) NOT NULL DEFAULT 'roomtype',
  `signature_created` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `room_type` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roomtypeitems`
--

INSERT INTO `roomtypeitems` (`ID`, `title`, `roomclass`, `beds`, `description`, `remark`, `type`, `signature_created`, `date_created`, `date_modified`) VALUES
(2, 'STANDARD', 2, 1, 'STANDARD ROOM', 'GRAND FLOOR OUTSIDE ', 'roomtype', 'JBA', '2017-09-01 11:34:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `siteitems`
--

DROP TABLE IF EXISTS `siteitems`;
CREATE TABLE IF NOT EXISTS `siteitems` (
  `ID` int(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `street1` varchar(100) DEFAULT NULL,
  `street2` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `tel1` varchar(15) DEFAULT NULL,
  `tel2` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `show_passwords` enum('0','1') DEFAULT '0',
  `type` varchar(100) DEFAULT 'site',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `signature` varchar(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siteitems`
--

INSERT INTO `siteitems` (`ID`, `title`, `street1`, `street2`, `state`, `country`, `tel1`, `tel2`, `email`, `facebook`, `url`, `logo`, `bank_account`, `twitter`, `show_passwords`, `type`, `date_created`, `date_modified`, `signature`) VALUES
(1, 'PRIDE HOTEL SOFTWARE', 'address1', 'address2', 'abuja', '172', '', '', '', '', '', 'hotel1.png', '', '', '0', 'site', '2017-09-01 07:52:36', '2017-09-23 09:17:32', 'MAZ');

-- --------------------------------------------------------

--
-- Table structure for table `useritems`
--

DROP TABLE IF EXISTS `useritems`;
CREATE TABLE IF NOT EXISTS `useritems` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `role` tinyint(2) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `hashed_p` varchar(255) NOT NULL,
  `last_login_ip` varchar(20) DEFAULT NULL,
  `last_login_time` datetime DEFAULT '0000-00-00 00:00:00',
  `last_logout_time` datetime DEFAULT '0000-00-00 00:00:00',
  `signature` varchar(50) NOT NULL,
  `signature_created` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'user',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `signature` (`signature`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useritems`
--

INSERT INTO `useritems` (`ID`, `title`, `role`, `password`, `hashed_p`, `last_login_ip`, `last_login_time`, `last_logout_time`, `signature`, `signature_created`, `type`, `date_created`, `date_modified`) VALUES
(1, 'mark zucker', 29, NULL, 'sha256:1000:9iCcib68Vt+loKSgYIKkI+GKwCsLAmc/:6Ce+61huNhOTvQhNjFJdQBGNmh8fZ/4C', '::1', '2017-09-19 13:30:45', '2017-09-01 11:26:43', 'MAZ', 'SAN', 'user', '2015-10-18 20:44:55', '2015-11-11 00:00:00'),
(2, 'justin baker', 28, NULL, 'sha256:1000:oRg4AZ9uB6MyQN8eycditWONGkIDcCf8:mx7qMpgk60FukRXla1IDfHvVGbak9BYr', '::1', '2017-09-23 09:14:28', '2017-09-19 06:50:28', 'JBA', 'MAZ', 'user', '2015-10-19 02:34:17', '2017-09-01 11:26:35');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
