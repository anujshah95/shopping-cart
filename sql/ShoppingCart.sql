-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 04, 2017 at 02:15 AM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ShoppingCart`
--

-- --------------------------------------------------------

--
-- Table structure for table `Carts`
--

CREATE TABLE IF NOT EXISTS `Carts` (
  `iCartId` int(11) NOT NULL AUTO_INCREMENT,
  `sCartName` varchar(256) NOT NULL,
  `iProductId` int(11) NOT NULL,
  `iTotal` int(11) NOT NULL DEFAULT '0',
  `iTotalDiscount` int(11) NOT NULL DEFAULT '0',
  `iTotalWithDiscount` int(11) NOT NULL DEFAULT '0',
  `iTotalTax` int(11) NOT NULL DEFAULT '0',
  `iTotalWithTax` int(11) NOT NULL DEFAULT '0',
  `iGrandTotal` int(11) NOT NULL DEFAULT '0',
  `dCreated` datetime NOT NULL,
  `dModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iCartId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `iCategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `sCategoryName` varchar(256) NOT NULL,
  `txtCategoryDescription` text NOT NULL,
  `iCategoryTax` int(11) NOT NULL COMMENT 'percentage',
  `dCreated` datetime NOT NULL,
  `dModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iCategoryId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`iCategoryId`, `sCategoryName`, `txtCategoryDescription`, `iCategoryTax`, `dCreated`, `dModified`) VALUES
(1, 'Clothes', 'Fancy clothes', 12, '2017-09-01 10:48:23', '2017-09-03 20:25:51'),
(2, 'Jackets', 'Fancy jackets', 18, '2017-09-01 10:48:51', '2017-09-01 05:18:51'),
(3, 'Shoes', 'Fancy shoes', 12, '2017-09-01 10:49:29', '2017-09-01 05:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
  `iProductId` int(11) NOT NULL AUTO_INCREMENT,
  `iCategoryId` int(11) NOT NULL,
  `sProductName` varchar(256) NOT NULL,
  `txtProductDescription` text NOT NULL,
  `iProductPrice` int(11) NOT NULL,
  `iProductDiscount` int(11) NOT NULL DEFAULT '0' COMMENT 'percentage',
  `dCreated` datetime NOT NULL,
  `dModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iProductId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`iProductId`, `iCategoryId`, `sProductName`, `txtProductDescription`, `iProductPrice`, `iProductDiscount`, `dCreated`, `dModified`) VALUES
(1, 3, 'Adidas Neo', 'adidas neo shoes', 2200, 0, '2017-09-01 10:51:27', '2017-09-01 05:21:27'),
(2, 3, 'Nike sports', 'Nike sports shoes', 1600, 10, '2017-09-01 10:52:00', '2017-09-01 05:22:00'),
(3, 2, 'Puma jackets', 'Nike sports shoes', 2500, 12, '2017-09-01 10:52:47', '2017-09-01 05:22:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
