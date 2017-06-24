-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2017 at 02:12 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pottery`
--
CREATE DATABASE IF NOT EXISTS `pottery` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `pottery`;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_general_ci NOT NULL,
  `location` text COLLATE latin1_general_ci,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `cost_upfront` decimal(6,2) DEFAULT NULL,
  `cost_sales` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Truncate table before insert `event`
--

TRUNCATE TABLE `event`;
--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `location`, `start`, `end`, `cost_upfront`, `cost_sales`) VALUES
(1, 'Craft Fair', 'MK', '2011-01-04', '0000-00-00', '20.00', '0.00'),
(2, 'Price per sale fair', 'Oxford', '2017-06-16', '2017-06-15', '0.00', '0.20'),
(3, 'No sale event', 'London', '2017-06-16', '2017-06-15', '20.00', NULL),
(5, 'test event', '', '0000-00-00', '0000-00-00', '0.00', '0.00'),
(6, 'testing 33', '', '0000-00-00', '0000-00-00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE IF NOT EXISTS `payment_method` (
  `type` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cut` decimal(7,4) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Truncate table before insert `payment_method`
--

TRUNCATE TABLE `payment_method`;
--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`type`, `cut`) VALUES
('Amex', '0.0500'),
('Card', '0.0195'),
('Cash', '0.0000'),
('PayPal', '0.0500'),
('Unsellable', '0.0000');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci,
  `time` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Truncate table before insert `product`
--

TRUNCATE TABLE `product`;
--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `time`) VALUES
(1, 'Big Blue Vase', 'Really big and nice and shiny. Blue. Also big. And a vase.', 2),
(3, 'Big Vase2', NULL, 2),
(4, 'broken', NULL, 2),
(5, 'Big Vase', NULL, 2),
(7, 'other vase', '', 2),
(8, 'old vase', NULL, 3),
(9, 'Big Red Vase', 'Big and red. And a vase.', 3),
(10, 'New test', '', 4),
(16, 'Dark Green Vase', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_resource`
--

DROP TABLE IF EXISTS `product_resource`;
CREATE TABLE IF NOT EXISTS `product_resource` (
  `pid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  PRIMARY KEY (`pid`,`rid`),
  KEY `rid_fk` (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Truncate table before insert `product_resource`
--

TRUNCATE TABLE `product_resource`;
--
-- Dumping data for table `product_resource`
--

INSERT INTO `product_resource` (`pid`, `rid`, `amount`) VALUES
(1, 1, '10.00'),
(1, 2, '10.00'),
(3, 1, '10.00'),
(3, 2, '10.00'),
(4, 1, '10.00'),
(4, 2, '12.00'),
(5, 1, '10.00'),
(5, 2, '10.00'),
(7, 1, '10.00'),
(7, 2, '12.00'),
(8, 2, '20.00'),
(10, 1, '2.00'),
(10, 4, '3.00'),
(16, 6, '10.00'),
(16, 7, '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `resource`
--

DROP TABLE IF EXISTS `resource`;
CREATE TABLE IF NOT EXISTS `resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci,
  `date_bought` date DEFAULT NULL,
  `size` float DEFAULT NULL,
  `unit_type` text COLLATE latin1_general_ci,
  `price_paid` decimal(5,2) DEFAULT NULL,
  `used` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Truncate table before insert `resource`
--

TRUNCATE TABLE `resource`;
--
-- Dumping data for table `resource`
--

INSERT INTO `resource` (`id`, `name`, `description`, `date_bought`, `size`, `unit_type`, `price_paid`, `used`) VALUES
(1, 'Clay', 'Bit like soil', '2017-06-02', 100, 'kg', '30.00', 0),
(2, 'Blue Glaze', 'Shiny', '2017-06-01', 100, 'ml', '20.50', 0),
(3, 'Kiln', 'Kiln Firing', '2015-04-01', 10000, 'fires', '999.99', 0),
(4, 'Red Glaze', 'Reddish', '2016-05-12', 200, 'ml', '40.00', 0),
(6, 'Green Glaze', 'Like grass', '2017-06-09', 100, 'ml', '10.00', 0),
(7, 'Dark Clay', 'Like mud', '2017-05-05', 10, 'kg', '40.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `sale_price` decimal(6,2) NOT NULL,
  `payment_method` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `product` int(11) NOT NULL,
  `event` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_sale` (`product`),
  KEY `sale_event` (`event`),
  KEY `sale_method` (`payment_method`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Truncate table before insert `sale`
--

TRUNCATE TABLE `sale`;
--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `date`, `sale_price`, `payment_method`, `product`, `event`) VALUES
(1, '2017-06-13', '30.00', 'Cash', 1, 1),
(2, '2017-06-13', '30.00', 'Cash', 1, 2),
(3, '2017-06-13', '30.00', 'Cash', 7, 1),
(4, '2017-06-07', '0.00', 'Unsellable', 1, NULL),
(5, '2017-06-11', '3.50', 'Card', 1, 2),
(6, '2017-06-01', '30.00', 'PayPal', 1, NULL),
(7, '2017-06-13', '30.00', 'Card', 1, 1),
(9, '2017-06-23', '37.88', 'Cash', 9, NULL),
(13, '2017-06-16', '40.00', 'Cash', 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vat`
--

DROP TABLE IF EXISTS `vat`;
CREATE TABLE IF NOT EXISTS `vat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `rate` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Truncate table before insert `vat`
--

TRUNCATE TABLE `vat`;
--
-- Dumping data for table `vat`
--

INSERT INTO `vat` (`id`, `start`, `end`, `rate`) VALUES
(1, '2011-01-04', NULL, '20.00'),
(2, '2010-01-01', '2011-01-03', '17.50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event` ADD FULLTEXT KEY `event_fulltext` (`name`,`location`);

--
-- Indexes for table `product`
--
ALTER TABLE `product` ADD FULLTEXT KEY `product_fulltext` (`name`,`description`);

--
-- Indexes for table `resource`
--
ALTER TABLE `resource` ADD FULLTEXT KEY `resource_fulltext` (`name`,`description`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_resource`
--
ALTER TABLE `product_resource`
  ADD CONSTRAINT `pid_fk` FOREIGN KEY (`pid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rid_fk` FOREIGN KEY (`rid`) REFERENCES `resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `product_sale` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_event` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_method` FOREIGN KEY (`payment_method`) REFERENCES `payment_method` (`type`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
