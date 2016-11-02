-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2016 at 11:40 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phbathro_dms`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(120) NOT NULL,
  `last_name` varchar(120) NOT NULL,
  `middleman` varchar(120) DEFAULT NULL,
  `organization` varchar(60) NOT NULL,
  `mobile_contact` varchar(16) NOT NULL,
  `email` varchar(1550) NOT NULL,
  `billing_address` varchar(200) NOT NULL,
  `delivery_address` varchar(200) NOT NULL,
  `salutation` varchar(11) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `middleman`, `organization`, `mobile_contact`, `email`, `billing_address`, `delivery_address`, `salutation`, `remarks`, `created_at`, `updated_at`, `updated_by`, `balance`) VALUES
(1, 'NIVEL ', 'LIM', '', 'NIVEL LIM', '96272587', '', 'BLK 258A PUNGGOL FIELD #05-11', '', 'Mr.', '', '2015-04-04 18:38:25', '2015-04-04 18:38:25', 1201, -248),
(2, 'SHAN', 'SHAN', '', '', '90058510', '', '', 'BLK 401 C.C.KANG AVE 3 #13-205', 'Mr.', '', '2015-04-26 16:54:06', '0000-00-00 00:00:00', 1202, -3202),
(3, 'NICOLE', 'LU', '', '', '81861556', '', '', 'BLK 29 AMBER RD THE SEAVIEW #20-01', 'Miss', '', '2015-04-29 13:37:17', '0000-00-00 00:00:00', 1202, -662),
(4, 'KEAT PIN', 'GOAY', '', 'PH PLUMBING SERVICES', '90687318', '', 'BLK 343 UBI AVE 1 #06-1119 , S400343', '', 'Mr.', '', '2015-05-13 18:19:48', '2015-05-13 18:37:44', 1202, -195),
(5, 'JOHN', 'TAN', '', '', '12345678', 'ROYCESEE30@GMAIL.COM', '', '200 jALAN SULTAN #02-19 199018', 'Mr.', '', '2015-05-13 18:42:50', '0000-00-00 00:00:00', 1202, -1554),
(7, 'Thomas', 'Yeo', '4', 'xyz company', '12345678', 'thomas@gmail.com', 'Tiong Bahru plaza', 'Tiong Bahru plaza', 'Dr.', 'testing', '2015-07-21 19:29:20', '2015-07-21 19:53:12', 1200, -374),
(8, 'erica', 'teo', '1', 'cde company', '91023567', '', 'Balestier 123', 'Balestier 123', 'Dr.', '', '2015-07-27 15:41:44', '2015-07-27 15:42:02', 1203, -1089),
(9, 'Alice', 'Goh', '1', 'wefweaf', '123355', '', '130 JOO SENG ROAD #05-05 SINGAPORE 368357', '130 JOO SENG ROAD #05-05 SINGAPORE 368357', 'Dr.', 'UGKYFKYUFKYUFKYUFKUYFKYUFKUYFLYIFLI;FG;IG;PGHP;GHPH8P8YHPHP;IOHOIHHI', '2015-07-27 16:29:14', '2015-09-21 17:21:35', 1201, -23432),
(10, 'tin tin', 'rog rog', '1', '12345678', '912345667', 'tintin@ymail.com', 'blk 164 KALLANG WAY KOLAM AYER INDUSTRIAL ESTATE', 'blk 164 KALLANG WAY KOLAM AYER INDUSTRIAL ESTATE', 'Mr.', 'Hit', '2015-08-06 18:51:58', '2015-08-06 18:52:32', 1203, -12398),
(11, 'dog', 'Cat', '1', '', '1234566', '', '', '', 'Miss', '', '2015-08-28 10:34:22', '2015-08-28 10:34:33', 1203, 0),
(12, 'Charlie', 'Young', '1', 'Winsland House', '912345434', 'charlieyoung@gmail.com', 'balestier point #02-03', 'balestier point #02-03', 'Dr.', 'Remove existing furnitures', '2015-08-31 15:17:48', '2015-08-31 15:18:02', 1203, -9610),
(13, 'Richard ', 'Marksman', NULL, 'Robert and Ho Holdings', 'Joshua', 'richard.marksman@gmail.com', 'London Road', 'Paris', 'Dr.', 'Big boss', '2015-08-31 15:30:16', '0000-00-00 00:00:00', 1203, 0),
(14, 'Sharon', 'Tan', '11', 'ABC Organisation', '912345678', 'sharontan@gmail.com', '12 Balestier rd', '', 'Miss', '', '2015-08-31 18:00:02', '2015-08-31 18:00:02', 1201, 0),
(15, 'Cynthia', 'Lim', NULL, '', '6275654949', '', '', '', 'Miss', '', '2015-08-31 18:16:39', '0000-00-00 00:00:00', 1201, -5104),
(16, 'PEH', 'PEH', NULL, '', '94522245', '', 'BLK 661D JURONG WEST ST 64 #14-458', 'BLK 661D JURONG WEST ST 64 #14-458', 'Mr.', '', '2015-09-04 18:59:40', '0000-00-00 00:00:00', 1201, 0),
(17, 'thia kiang', 'Low', NULL, 'WP', '91038526', 'low@gmail.com', 'blaestier 123', '', 'Mr.', '', '2015-09-15 12:39:39', '0000-00-00 00:00:00', 1200, -4543),
(18, 'abcmouse', 'abclion', NULL, 'garegeargaer', '91223356', 'abcmouse@gmail.com', 'Toa Payoh industrial', 'Toa Payoh industrial', 'Dr.', '', '2015-09-18 12:30:49', '0000-00-00 00:00:00', 1200, -4758),
(19, 'awegaesg', 'asgasgaw', '4', 'rgaegraeg', 'asgagaseg', 'asrgasgsg', 'sgasga', 'agawegweag', 'Ms.', 'agawewg', '2015-09-21 13:04:53', '2015-09-21 13:04:53', 1200, -1837),
(20, 'Baron', 'Huang', '6', 'Walton Holdings', '312345687', 'baronhuang@gmail.com', 'Everton Park 640436 #01-95', '', 'Dr.', '', '2015-10-08 16:35:13', '2015-10-08 16:35:13', 1201, -7528),
(21, 'TEOH', 'KELVIN', NULL, 'PAVILON INTERIOR DESIGN', '90090066', '', '', '', 'Mr.', '', '2015-10-10 17:49:57', '0000-00-00 00:00:00', 1201, 0),
(22, 'Lee', 'Carmen', NULL, '', '8131662', 'mrmhyy@gmail.com', 'BLK 325 SENGKANG EAST WAY #13-629 S543325', 'BLK 325 SENGKANG EAST WAY #13-629 S543325', 'Ms.', '', '2015-10-29 16:09:58', '0000-00-00 00:00:00', 1201, -724),
(23, 'LEE', 'LEE', NULL, 'PH PLUMBING SERVICES', '12345678', '', '', '123 JURONG', 'Dr.', '', '2015-10-30 16:48:02', '0000-00-00 00:00:00', 1201, -2410),
(24, 'ssfdfd', '', '2', 'ate', '445666', 'aaaa@gmail.com', 'dfdssdfsdf', 'sdfsdf', 'Miss', '', '2016-04-26 13:58:32', '2016-04-26 13:58:32', 1200, 0),
(25, 'Sweety', '', '3', 'innov8te', '3333', 'sweety@innvo8te.com', 'didi', 'iisdssddd', 'Ms.', '', '2016-04-26 13:59:23', '2016-04-26 14:04:01', 1200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cn_items`
--

CREATE TABLE IF NOT EXISTS `cn_items` (
  `id` int(11) NOT NULL,
  `cn_id` varchar(25) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_itemno` varchar(25) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `refund_price` decimal(11,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companyprofile`
--

CREATE TABLE IF NOT EXISTS `companyprofile` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `registration_no` varchar(20) NOT NULL,
  `header` text NOT NULL,
  `terms` text NOT NULL,
  `remarks` text NOT NULL,
  `terms2` text NOT NULL,
  `remarks2` text NOT NULL,
  `terms3` text NOT NULL,
  `remarks3` text NOT NULL,
  `terms4` text NOT NULL,
  `remarks4` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companyprofile`
--

INSERT INTO `companyprofile` (`id`, `company_name`, `registration_no`, `header`, `terms`, `remarks`, `terms2`, `remarks2`, `terms3`, `remarks3`, `terms4`, `remarks4`) VALUES
(0, 'St8cks', '201424327E', '\r\n<div style="text-align: justify;" align="left">Innov8te</div>', 'Terms ', '* Cheque payment ', 'Terms', '<br>', 'Terms', '* Cheque payment ', '* Goods are dully received in good order &amp; condition<div>* The deposit paid here in is NOT REFUNDABLE</div><div>* All confirmed items are not returnable &amp; exchangeable</div><div>* The balance shall be paid in FULL upon delivery of goods</div><div>* We retain the ownership &amp; property right on goods delivered until their entire payment is settled</div><div>* Settler''s obligation to supply item(s) ordered is/are subjected to the availability of such item(s):</div><div>&nbsp; &nbsp;the deposit in respect of the non available item(S) shall be refundable to the purchaser,</div><div>&nbsp; &nbsp;neither party shall have any right against each other</div><div>* Complaints of defective goods/items must be reported within 7 days they were delivered.</div><div>&nbsp; &nbsp;No complaints would be entertained after the date of delivery</div><div>* All non - DZR brass fitting / pipes, non-apprived / mixers/ fittings by&nbsp;</div><div>&nbsp; PUB water department are for export only and not for Singapore</div>', '* Cheque payment made payable to&nbsp;<u>PH BATHROOM GALLERY PTE LTD</u>');

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes`
--

CREATE TABLE IF NOT EXISTS `credit_notes` (
  `showid` int(11) NOT NULL,
  `cn_id` varchar(16) NOT NULL,
  `invoice_id` varchar(16) NOT NULL,
  `created_by` int(11) NOT NULL,
  `sales_staff` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `payment_method` varchar(128) NOT NULL,
  `deposit` decimal(11,2) NOT NULL,
  `updated_at` datetime NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currency_country`
--

CREATE TABLE IF NOT EXISTS `currency_country` (
  `id` int(11) NOT NULL,
  `country_name` varchar(70) NOT NULL,
  `country_currency` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_country`
--

INSERT INTO `currency_country` (`id`, `country_name`, `country_currency`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Singapore', 'SGD', '2016-02-24 02:26:05', '2016-02-24 02:36:26', 1200),
(2, 'USA', 'USD', '2016-02-24 02:36:40', '2016-02-24 02:36:40', 1200),
(4, 'China', 'yuan', '2016-02-24 06:14:47', '2016-02-24 06:14:47', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `currency_exchange`
--

CREATE TABLE IF NOT EXISTS `currency_exchange` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `currency_name` varchar(50) NOT NULL,
  `currency_rate` varchar(50) NOT NULL,
  `currency_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_exchange`
--

INSERT INTO `currency_exchange` (`id`, `country_id`, `currency_name`, `currency_rate`, `currency_date`, `status`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 1, 'SGD', '1', '2016-02-24', 0, '2016-02-24 06:13:28', '2016-02-24 06:13:28', 1200),
(2, 2, 'USD', '1.3', '2016-02-09', 0, '2016-02-24 06:05:58', '2016-02-24 06:05:58', 1200),
(3, 1, 'SGD', '1', '2016-04-14', 0, '2016-04-27 09:48:38', '2016-04-27 09:48:38', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_orders`
--

CREATE TABLE IF NOT EXISTS `delivery_orders` (
  `showid` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_sent` date NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `payment_mode` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `do_items`
--

CREATE TABLE IF NOT EXISTS `do_items` (
  `id` int(11) NOT NULL,
  `do_id` varchar(15) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_itemno` varchar(25) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `retail_price` decimal(11,2) NOT NULL,
  `items_id` int(11) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `delivery_address` varchar(256) NOT NULL,
  `purchase_order` varchar(125) NOT NULL DEFAULT '1',
  `delivery_order` varchar(125) NOT NULL DEFAULT '1',
  `credit_note` varchar(16) NOT NULL DEFAULT '1',
  `total_price` decimal(11,2) DEFAULT NULL,
  `total_paid` decimal(11,2) NOT NULL,
  `remarks` text NOT NULL,
  `delivery_date` date NOT NULL,
  `middleman` int(11) NOT NULL,
  `installation` varchar(20) NOT NULL,
  `sales_staff` int(11) NOT NULL,
  `payment_mode` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `created_by`, `client_id`, `date_created`, `updated_at`, `status`, `delivery_address`, `purchase_order`, `delivery_order`, `credit_note`, `total_price`, `total_paid`, `remarks`, `delivery_date`, `middleman`, `installation`, `sales_staff`, `payment_mode`) VALUES
(1, 1200, -1, '2016-04-29 11:22:33', '2016-04-29 17:21:37', 0, '  ', '1', '1', '1', NULL, '100.00', 'sdfsdfdsf', '0000-00-00', 6, 'Yes', 2, 'Visa / Master'),
(2, 1200, -1, '2016-04-29 16:20:52', '2016-04-29 16:20:52', 0, '			    ', '1', '1', '1', '66.00', '0.00', 'sdsdsd', '0000-00-00', -1, 'Yes', 2, 'Visa / Master'),
(3, 1200, -1, '2016-04-29 16:49:59', '2016-04-29 16:49:59', 0, '			    ', '1', '1', '1', '44.00', '0.00', 'dfdf', '0000-00-00', -1, 'Yes', 2, 'Visa / Master');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_itemno` varchar(20) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `category` varchar(60) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `selling_price` decimal(11,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_order` int(11) NOT NULL DEFAULT '0',
  `delivery_order` int(11) NOT NULL DEFAULT '0',
  `credit_note` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product_id`, `product_itemno`, `product_name`, `category`, `unit_price`, `selling_price`, `quantity`, `purchase_order`, `delivery_order`, `credit_note`, `description`, `status`) VALUES
(1, 1, 1, 'item001', 'product 001', '', '0.00', '20.00', 1, 0, 0, 0, ' x  x  mm', 0),
(2, 1, 3, 'item0012', '3333', '', '0.00', '11.00', 1, 0, 0, 0, ' x  x  mm', 0),
(3, 1, 4, 'sfsd', 'dsfsd', '', '0.00', '33.00', 1, 0, 0, 0, ' x  x  mm', 0),
(4, 1, 1, 'item001', 'product 001', '', '0.00', '20.00', 1, 0, 0, 0, ' x  x  mm', 0),
(5, 1, 4, 'sfsd', 'dsfsd', '', '0.00', '33.00', 1, 0, 0, 0, ' x  x  mm', 0),
(6, 2, 4, 'sfsd', 'dsfsd', '', '33.00', '33.00', 1, 0, 0, 0, ' x  x  mm', 0),
(7, 2, 3, 'item0012', '3333', '', '11.00', '11.00', 3, 0, 0, 0, ' x  x  mm', 0),
(8, 3, 3, 'item0012', '3333', '', '11.00', '11.00', 1, 0, 0, 0, ' x  x  mm', 0),
(9, 3, 4, 'sfsd', 'dsfsd', '', '0.00', '33.00', 1, 0, 0, 0, ' x  x  mm', 0),
(10, 1, 3, '', '3333', '', '0.00', '11.00', 1, 0, 0, 0, ' x  x  mm', 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `entity_id` varchar(25) NOT NULL,
  `log` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `entity_id`, `log`, `date`) VALUES
(1, '1', 'Admin See edited sales staff from 1 to 2', '2015-07-24 20:24:37'),
(2, '13', 'Admin See edited middleman from 3 to 4', '2015-08-06 18:57:24'),
(3, '1', 'Admin See edited middleman from 1 to 11', '2015-08-31 15:36:33'),
(4, '54', 'Sales  edited a product from CHIMNEY HOOD to CHIMNEY HOOD', '2015-09-29 14:11:15'),
(5, '8', 'Sales  edited middleman from 0 to 1', '2015-10-30 16:58:35'),
(6, '8', 'Sales  edited delivery date from PENDING to 10/31/2015', '2015-10-30 16:58:35'),
(7, '11', 'Katherine Admin edited middleman from -1 to 1', '2015-12-22 16:15:36'),
(8, '21', 'Katherine Admin edited middleman from -1 to 1', '2015-12-22 18:11:21'),
(9, '12', 'Katherine Admin edited middleman from -1 to 1', '2015-12-23 11:08:01'),
(10, '1', 'Katherine Admin edited middleman from 0 to 1', '2015-12-24 10:51:53'),
(11, '14', 'Katherine Admin edited middleman from -1 to 1', '2015-12-24 11:00:26'),
(12, '1', 'Katherine Admin deleted product 1 1/2 BOWLS S/S SINK ', '2015-12-30 11:03:07'),
(13, '1', 'Katherine Admin deleted product  BASIN MIXER', '2015-12-30 11:03:58'),
(14, '1', 'Katherine Admin deleted product  BASIN MIXER', '2015-12-30 11:07:37'),
(15, '1', 'Katherine Admin deleted product  BASIN MIXER', '2015-12-30 11:55:41'),
(16, '15', 'Katherine Admin deleted product  RECT RACK (L155xw120xh45mm)', '2015-12-30 16:09:28'),
(17, '15', 'Katherine Admin deleted product  FOR BASIN', '2015-12-30 16:09:28'),
(18, '15', 'Katherine Admin deleted product  FOR BASIN', '2015-12-30 16:09:28'),
(19, '15', 'Katherine Admin deleted product  FOR BASIN', '2015-12-30 16:49:35'),
(20, '15', 'Katherine Admin deleted product  RECT RACK (L250xw115xh45mm)', '2015-12-30 16:49:35'),
(21, '19', 'Katherine Admin edited middleman from -1 to 1', '2016-02-15 16:54:25'),
(22, '2', 'Katherine Admin edited middleman from -1 to 1', '2016-02-17 13:31:12'),
(23, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:14:27'),
(24, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:15:04'),
(25, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:15:23'),
(26, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:15:34'),
(27, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:16:20'),
(28, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:17:47'),
(29, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:18:49'),
(30, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:19:21'),
(31, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:19:28'),
(32, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:19:46'),
(33, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:19:52'),
(34, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:20:33'),
(35, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:21:34'),
(36, '2', 'Katherine Admin edited a product from product0002 to product ', '2016-02-17 14:21:48'),
(37, '2', 'Katherine Admin edited a product from product  to Pro0001', '2016-02-17 14:47:14'),
(38, '3', 'Katherine Admin edited middleman from -1 to 1', '2016-02-17 14:50:09'),
(39, '3', 'Katherine Admin edited a product from Pro0001 to product0003', '2016-02-17 15:02:21'),
(40, '3', 'Katherine Admin edited a product from Pro0001 to product0003', '2016-02-17 15:02:40'),
(41, '3', 'Katherine Admin edited a product from product0002 to Pro0001', '2016-02-17 15:04:52'),
(42, '3', 'Katherine Admin edited a product from product0002 to Pro0001', '2016-02-17 15:09:32'),
(43, '3', 'Katherine Admin edited a product from product0002 to Pro0001', '2016-02-17 15:09:53'),
(44, '2', 'Katherine Admin edited a product from product  to Pro0001', '2016-02-17 15:14:48'),
(45, '2', 'Katherine Admin edited a product from product  to Pro0001', '2016-02-17 15:15:29'),
(46, '2', 'Katherine Admin edited a product from product  to Pro0001', '2016-02-17 15:15:45'),
(47, '3', 'Katherine Admin edited a product from product0002 to Pro0001', '2016-02-17 15:31:39'),
(48, '4', 'Katherine Admin edited middleman from -1 to 1', '2016-02-17 15:33:10'),
(49, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:41:19'),
(50, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:41:38'),
(51, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:42:28'),
(52, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:42:51'),
(53, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:43:27'),
(54, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:43:46'),
(55, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:45:00'),
(56, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:45:11'),
(57, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:45:24'),
(58, '4', 'Katherine Admin edited a product from product0002 to product0003', '2016-02-17 15:46:01'),
(59, '4', 'Katherine Admin edited a product from product0003 to product0002', '2016-02-17 15:48:41'),
(60, '1', 'Katherine Admin edited middleman from -1 to 1', '2016-02-17 15:51:51'),
(61, '2', 'Katherine Admin edited a product from product0003 to product0001', '2016-02-29 17:07:39'),
(62, '1', 'Katherine Admin edited middleman from -1 to 5', '2016-02-29 17:07:59'),
(63, '1', 'Katherine Admin edited middleman from -1 to 5', '2016-02-29 17:32:23'),
(64, '4', 'Innov8te Admin edited middleman from -1 to 5', '2016-04-29 11:33:29'),
(65, '5', 'Innov8te Admin edited middleman from -1 to 5', '2016-04-29 14:48:06'),
(66, '5', 'Innov8te Admin deleted product dsfsd', '2016-04-29 15:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `middlemen`
--

CREATE TABLE IF NOT EXISTS `middlemen` (
  `id` int(11) NOT NULL,
  `first_name` varchar(120) NOT NULL,
  `last_name` varchar(120) NOT NULL,
  `mobile_contact` varchar(16) NOT NULL,
  `email` varchar(1550) NOT NULL,
  `address` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `middlemen`
--

INSERT INTO `middlemen` (`id`, `first_name`, `last_name`, `mobile_contact`, `email`, `address`, `remarks`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'GOAY', 'PIN', '90687319', '', '', '', '2015-10-30 04:55:09', '2015-10-30 04:55:09', 1201),
(2, 'test', 'test', '333', 'test@gmail.com', '33', '33', '2016-02-25 12:55:26', '2016-02-25 12:55:26', 1200),
(3, 'blabla', 'blabla', '1234', 'blabla@gmail.com', 'sfds', 'sdfsd', '2016-02-25 12:58:01', '2016-02-25 12:58:01', 1200),
(4, 'testing how to submit', 'testing', '84848', 'testing@gmail.com', 'lavendar', 'lavendar', '2016-02-25 02:52:09', '2016-02-25 02:52:09', 1200),
(5, 'aaa innov8te', 'aaa', '454354', 'aa@gmail.com', 'aaa', 'aaaa', '2016-02-25 03:26:12', '2016-04-27 10:34:26', 1200),
(6, 'sdfs', 'sdf', '333333', 'aaafds@gmail.com', 'vfsdfsdf', 'dfdsfsdf', '2016-04-27 10:33:48', '2016-04-27 10:33:48', 1200),
(7, 'sdfsdf', 'sdf', '44333', 'aaafds@gmail.com', '4r', 'erwer', '2016-04-27 10:34:37', '2016-04-27 10:34:37', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `po_items`
--

CREATE TABLE IF NOT EXISTS `po_items` (
  `id` int(11) NOT NULL,
  `po_id` varchar(15) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_itemno` varchar(20) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `buying_price` decimal(11,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text,
  `items_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po_items`
--

INSERT INTO `po_items` (`id`, `po_id`, `product_id`, `product_itemno`, `product_name`, `unit_price`, `buying_price`, `quantity`, `description`, `items_id`) VALUES
(1, '1', 2, 'item0002', 'Product Item 0002', '0.00', '20.00', 100, '', 0),
(2, '2', 2, 'item0002', 'Product Item 0002', '0.00', '20.00', 10, '', 0),
(3, '3', 2, 'item0002', 'Product Item 0002', '0.00', '20.00', 10, '', 0),
(4, '4', 0, 'item0003', 'product 0003 2 x 5 x 1 mm', '18.00', '18.00', 0, '', 0),
(5, '5', 0, 'item0003', 'product 0003 2 x 5 x 1 mm', '18.00', '18.00', 200, '', 0),
(6, '6', 0, 'item0003', 'product 0003 2 x 5 x 1 mm', '18.00', '18.00', 0, '', 0),
(7, '7', 0, 'item0003', 'product 0003 2 x 5 x 1 mm', '18.00', '18.00', 100, '', 0),
(8, '8', 0, 'item0003', 'product 0003 2 x 5 x 1 mm', '18.00', '18.00', 100, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `product_catid` int(11) NOT NULL,
  `product_itemno` varchar(25) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `selling_price` decimal(11,2) NOT NULL,
  `supplier` int(11) NOT NULL,
  `measurements` varchar(60) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `min_product_qty` varchar(100) NOT NULL,
  `pro_photos` varchar(255) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currencyrate_atpurchased` varchar(50) NOT NULL,
  `store_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `stock_status` int(11) NOT NULL,
  `pro_remark` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_catid`, `product_itemno`, `product_name`, `product_description`, `unit_price`, `selling_price`, `supplier`, `measurements`, `weight`, `quantity`, `min_product_qty`, `pro_photos`, `currency_id`, `currencyrate_atpurchased`, `store_id`, `status`, `stock_status`, `pro_remark`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 3, 'item001', 'product 001', 'product description', '20.00', '20.00', 4, ';;', '10', '21', '1', '', 1, '1', 1, 1, 0, 'w', '2016-03-03 02:54:49', '2016-03-03 03:25:10', 1200),
(3, 20, 'item0012', '3333', '3333', '11.00', '11.00', 16, ';;', '22', '20', '1', '', 1, '1', 2, 1, 0, '', '2016-04-28 09:12:49', '2016-04-28 09:12:49', 1200),
(4, 0, 'sfsd', 'dsfsd', 'dsfd', '33.00', '33.00', -1, ';;', '3', '3', '1', '', 1, '2', 0, 1, 0, '', '2016-04-29 10:15:02', '2016-04-29 10:15:02', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `products_category`
--

CREATE TABLE IF NOT EXISTS `products_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_category`
--

INSERT INTO `products_category` (`id`, `cat_name`, `cat_status`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'cat2', 1, '2016-02-19 01:46:10', '2016-02-29 03:20:32', '0000-00-00 00:00:00'),
(3, 'cat1', 1, '2016-02-19 02:22:24', '2016-02-29 03:20:53', '0000-00-00 00:00:00'),
(20, 'aaa', 1, '2016-04-26 03:09:10', '2016-04-26 03:09:10', '0000-00-00 00:00:00'),
(22, 'dfsdf', 1, '2016-04-26 03:23:03', '2016-04-26 03:23:03', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_status`
--

CREATE TABLE IF NOT EXISTS `product_status` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `quo_id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL,
  `required_qty` varchar(100) NOT NULL,
  `ordered_qty` varchar(100) NOT NULL,
  `po_id` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `showid` int(11) NOT NULL,
  `id` varchar(15) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `attn_to` varchar(128) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `delivery_address` varchar(256) DEFAULT NULL,
  `delivery_contact` varchar(25) NOT NULL,
  `delivery_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`showid`, `id`, `invoice_id`, `attn_to`, `created_by`, `supplier_id`, `date_created`, `updated_at`, `delivery_address`, `delivery_contact`, `delivery_date`, `status`, `total_price`) VALUES
(1, '1', -1, '4', 1200, 5, '2016-03-03 17:13:53', '2016-03-03 17:13:53', 'Jinlan Sultan', 'John Smith', '2016-03-05', 0, 2000),
(2, '2', -1, '66', 1200, 3, '2016-03-03 17:42:35', '2016-03-03 17:42:35', 'Jalan Sultan', 'Willian', '2016-03-10', 0, 200),
(3, '3', -1, '66', 1200, 3, '2016-03-03 17:43:09', '2016-03-03 17:43:09', 'Jalan Sultan', 'Willian', '2016-03-10', 1, 200),
(4, '4', -1, NULL, 1200, 3, '2016-03-04 10:26:21', '2016-03-04 10:26:21', '                         ', '', '1970-01-01', 0, 0),
(5, '5', -1, NULL, 1200, 3, '2016-03-04 10:26:58', '2016-03-04 10:26:58', '                         ', '', '1970-01-01', 0, 0),
(6, '6', -1, NULL, 1200, 3, '2016-03-04 10:38:42', '2016-03-04 10:38:42', '                         ', '', '1970-01-01', 0, 0),
(7, '7', -1, NULL, 1200, 3, '2016-03-04 11:56:37', '2016-03-04 11:56:37', '                         ', '', '1970-01-01', 0, 0),
(8, '8', -1, NULL, 1200, 3, '2016-03-04 11:57:40', '2016-03-04 11:57:40', '                         ', '', '1970-01-01', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE IF NOT EXISTS `quotations` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `pro_status` int(11) NOT NULL,
  `delivery_address` varchar(256) NOT NULL,
  `invoice` varchar(16) NOT NULL DEFAULT '0',
  `total_price` decimal(11,2) NOT NULL,
  `total_paid` decimal(11,2) NOT NULL,
  `remarks` text NOT NULL,
  `middleman` int(11) NOT NULL,
  `sales_staff` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `created_by`, `client_id`, `date_created`, `updated_at`, `status`, `pro_status`, `delivery_address`, `invoice`, `total_price`, `total_paid`, `remarks`, `middleman`, `sales_staff`) VALUES
(1, 1200, -1, '2016-04-29 11:15:28', '2016-04-29 11:15:28', 0, 0, '', '1', '117.00', '0.00', '', 6, 2),
(2, 1200, -1, '2016-04-29 11:17:51', '2016-04-29 11:21:57', 0, 0, '', '0', '44.00', '0.00', '', 3, 2),
(3, 1200, 20, '2016-04-29 11:18:39', '2016-04-29 11:18:39', 0, 0, '', '0', '20.00', '0.00', '', -1, 3),
(4, 1200, -1, '2016-04-29 11:30:47', '2016-04-29 11:33:29', 0, 0, '', '0', '44.00', '0.00', '', 5, 2),
(5, 1200, -1, '2016-04-29 14:47:34', '2016-04-29 15:15:48', 0, 0, '', '0', '64.00', '0.00', 'remark<div>remark</div>', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE IF NOT EXISTS `quotation_items` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_itemno` varchar(20) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `category` varchar(60) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `selling_price` decimal(11,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_items`
--

INSERT INTO `quotation_items` (`id`, `quotation_id`, `product_id`, `product_itemno`, `product_name`, `category`, `unit_price`, `selling_price`, `quantity`, `description`, `status`) VALUES
(1, 1, 1, 'item001', 'product 001', '', '20.00', '20.00', 1, ' x  x  mm', 0),
(2, 1, 3, 'item0012', '3333', '', '0.00', '11.00', 1, ' x  x  mm', 0),
(3, 1, 4, 'sfsd', 'dsfsd', '', '0.00', '33.00', 1, ' x  x  mm', 0),
(4, 1, 1, 'item001', 'product 001', '', '0.00', '20.00', 1, ' x  x  mm', 0),
(5, 1, 4, 'sfsd', 'dsfsd', '', '0.00', '33.00', 1, ' x  x  mm', 0),
(6, 2, 4, 'sfsd', 'dsfsd', '', '33.00', '33.00', 1, ' x  x  mm', 0),
(7, 3, 1, 'item001', 'product 001', '', '20.00', '20.00', 1, ' x  x  mm', 0),
(8, 2, 3, 'item0012', '3333', '', '11.00', '11.00', 1, ' x  x  mm', 0),
(9, 4, 4, 'sfsd', 'dsfsd', '', '0.00', '33.00', 1, ' x  x  mm', 0),
(10, 4, 3, 'item0012', '3333', '', '0.00', '11.00', 1, ' x  x  mm', 0),
(11, 4, 4, '', 'dsfsd', '', '0.00', '0.00', 1, '', 0),
(12, 5, 4, 'sfsd', 'dsfsd', '', '0.00', '33.00', 1, ' x  x  mm', 0),
(14, 5, 1, 'item001', 'product 001', '', '0.00', '20.00', 1, ' x  x  mm', 0),
(15, 5, 3, '', '3333', '', '0.00', '11.00', 1, ' x  x  mm', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `menu_color` varchar(25) NOT NULL,
  `button_color` varchar(16) NOT NULL,
  `button_hover` varchar(16) NOT NULL,
  `sidemenu_color` varchar(16) NOT NULL,
  `sidemenu_hover` varchar(16) NOT NULL,
  `version` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `menu_color`, `button_color`, `button_hover`, `sidemenu_color`, `sidemenu_hover`, `version`) VALUES
(1, 'St8cks', '3498db', 'FFF', '000', '424a5d', '68dff0', '1.0');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE IF NOT EXISTS `staffs` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `contact` varchar(16) NOT NULL,
  `email` varchar(1550) NOT NULL,
  `address` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `contact`, `email`, `address`, `remarks`, `created_at`, `updated_at`, `updated_by`) VALUES
(2, 'CYLEE', '86838684', 'cylee@phbathroom.com', '648, GEYLANG RD, S389578', '', '2015-04-26 02:25:00', '2015-04-26 02:25:00', 1202),
(3, 'KATHERINE LEE', '94789472', 'ph_bathroom@singnet.com.sg', '648 GEYLANG ROAD LOR 40, SINGAPORE 389578', '', '2015-10-08 01:52:06', '2015-10-08 01:52:44', 1201),
(4, 'IVY SEE', '91773500', 'ph_bathroom@hotmail.com', '648 GEYLANG ROAD LOR 40, SINGAPORE 389578', '', '2015-10-08 01:53:34', '2015-10-08 01:53:34', 1201),
(5, 'sdfd', '4444', 'dsfsdf@gmail.com', 'sdfdsf', '', '2016-04-27 10:40:14', '2016-04-27 10:42:03', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `id` int(11) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `store_type` int(11) NOT NULL,
  `store_description` varchar(255) NOT NULL,
  `store_address` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `remark` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `store_name`, `store_type`, `store_description`, `store_address`, `status`, `remark`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'ABC Warehouse', 1, ' aaa', 'aaa', 1, ' aa', '2016-02-26 11:24:42', '2016-02-26 11:24:42', '0000-00-00 00:00:00'),
(2, 'asd', 1, ' sdf', 'dfsd', 1, ' dfsd', '2016-04-26 05:05:27', '2016-04-26 05:40:24', '0000-00-00 00:00:00'),
(3, 'aaa', 1, ' asdfs', 'sdfd', 1, ' sdf', '2016-04-26 05:20:03', '2016-04-26 05:38:31', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `store_type`
--

CREATE TABLE IF NOT EXISTS `store_type` (
  `id` int(11) NOT NULL,
  `store_type` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_type`
--

INSERT INTO `store_type` (`id`, `store_type`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Warehouse', '2016-02-26 11:24:30', '2016-02-26 11:24:30', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(120) NOT NULL,
  `billing_address` varchar(200) NOT NULL,
  `delivery_address` varchar(200) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `website` varchar(120) NOT NULL,
  `tel` varchar(35) NOT NULL,
  `fax` varchar(35) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `billing_address`, `delivery_address`, `email`, `website`, `tel`, `fax`, `remarks`, `created_at`, `updated_at`, `updated_by`) VALUES
(3, 'CASA (S) PTE.LTD', '15 KIAN TECK CRESCENT ,SINGAPORE 628884', '15 KIAN TECK CRESCENT ,SINGAPORE 628884', 'SALE@CASA.COM.SG', 'www.casaholding.com.sg', '62680066', '62668069', '', '2015-04-01 06:37:02', '2015-09-05 04:17:49', 1201),
(4, 'NTL SUPPLY PTE LTD', '32 KALLANG PUDDING RD , #06-05 ,ELITE IND.BLDG.1. SINGAPORE 349313', '32 KALLANG PUDDING RD , #06-05 ,ELITE IND.BLDG.1. SINGAPORE 349313', '', '', '', '', '', '2015-04-01 07:06:48', '2015-04-01 07:12:31', 1200),
(5, 'ACORN MARKETING & SERVICES PTE LTD', '512 CHAI CHEE LANE #02-09 SINGAPORE 469028', '512 CHAI CHEE LANE #02-09 SINGAPORE 469028', '', '', '', '', '', '2015-04-01 07:11:37', '2015-04-01 07:11:37', 1200),
(6, 'ALPHA SALES & SERVICES PTE.LTD', '51 UBI AVENUE 1 #01-30,PAYA UBI INDUSTRIES PARK,SINGAPORE 408933', '51 UBI AVENUE 1 #01-30,PAYA UBI INDUSTRIES PARK,SINGAPORE 408933', '', '', '', '', '', '2015-04-01 07:16:48', '2015-04-01 07:16:48', 1200),
(7, 'TREO SANITARYWARE PTE.LTD', 'BLK 217 JURONG EAST STREET 21 #01-589 SINGAPORE 601217', 'BLK 217 JURONG EAST STREET 21 #01-589 SINGAPORE 601217', '', '', '', '', '', '2015-04-01 07:19:26', '2015-04-01 07:19:26', 1200),
(8, 'VIC-3 MARKETING (PTE) LTD', '379 GUILLEMARD ROAD ,SINGPORE 399783', '379 GUILLEMARD ROAD ,SINGPORE 399783', '', '', '', '', '', '2015-04-01 07:22:31', '2015-04-01 07:22:31', 1200),
(9, 'JOVEN ELECTRIC (S) PTE LTD', 'NO.10 UBI CRESCENT, #02-18 , UBI TECHPARK ,SINGAPORE 408564', 'NO.10 UBI CRESCENT, #02-18 , UBI TECHPARK ,SINGAPORE 408564', '', '', '', '', '', '2015-04-01 07:31:13', '2015-04-01 07:31:13', 1200),
(10, 'HAPPINESS PTE LTD', '52 LOYANG WAY , SINGAPORE 508745', '52 LOYANG WAY , SINGAPORE 508745', '', '', '', '', '', '2015-04-01 07:41:41', '2015-04-01 07:41:41', 1200),
(11, 'CRIZTO SINGAPORE PTE LTD', '605A MACPHERSON RD #02-03 CITIMAC INDUSTRIAL COMPLEX ,SINGAPORE 368240', '605A MACPHERSON RD #02-03 CITIMAC INDUSTRIAL COMPLEX ,SINGAPORE 368240', 'weijian.ho@crizto.com', 'www.crizto.com', '62875287', '62879287', '', '2015-04-01 08:27:14', '2015-09-23 11:51:55', 1201),
(12, 'FUJIOH INTERNATIONAL TRADING PTE LTD', '130 JOO SENG ROAD #05-05 SINGAPORE 368357', '130 JOO SENG ROAD #05-05 SINGAPORE 368357', '', '', '62863686 ', '62853285', '', '2015-04-10 07:53:27', '2015-04-10 07:53:27', 1202),
(13, 'MACLAIRE SANITARY WARE PTE LTD', '12 NEW INDUSTRIAL ROAD #02-04 MORNINGSTAR CENTRE , SINGAPORE 536202', '12 NEW INDUSTRIAL ROAD #02-04 MORNINGSTAR CENTRE , SINGAPORE 536202', '', '', '67467779', '67450220', '', '2015-04-10 07:56:05', '2015-04-10 07:56:05', 1202),
(16, 'RINNAI HOLDING (PACIFIC) PTE LTD', '47 TANNERY LANE #05-01/02 S347794', '67459240', '', '', '', '', '', '2015-04-13 10:40:58', '2015-04-13 11:06:00', 1201),
(18, 'SINGAPORE RADIO & INDUSTRY PTE LTD ', '465 TAGORA INDUSTRIAL AVENUE S.R.I BUILDING SINGAPORE S787834', '465 TAGORA INDUSTRIAL AVENUE S.R.I BUILDING SINGAPORE S787834', '', '', '65523318', '65523811', '', '2015-04-13 10:47:11', '2015-04-13 10:47:11', 1201),
(19, 'DBG TRADING PTE LTD', '2 JURONG EAST ST. 21. #04-33C2 IMM BUILDING S609601', '2 JURONG EAST ST. 21. #04-33C2 IMM BUILDING S609601', '', '', '67207019', '31516029', '', '2015-04-13 10:50:39', '2015-04-13 10:50:39', 1201),
(20, 'MELIOR ENTERPRISE PTE LTD ', 'NO. 30 OLD TOH TUCK RD #05-14 S 597654', 'NO. 30 OLD TOH TUCK RD #05-14 S 597654', '', '', '67762990', '67954779', '', '2015-04-13 10:59:32', '2015-04-13 10:59:32', 1201),
(21, 'AEROGAZ (S) PTE LTD', 'AEROGAZ (S) PTE LTD', '1 LOYANG WAY 1 s508702', '', '', '67469933', '67459923', '', '2015-04-13 11:01:14', '2015-04-13 11:01:14', 1201),
(22, 'GENOVA INDUSTRIES PTE LTD', '58 BENDEMEER RD SINGAPORE S339937', '62964831', 'GENOVA@SINGNET.COM', 'WWW.GENOVA.COM.SG', '62990222', '62964831', '', '2015-04-13 11:04:03', '2015-09-05 04:21:56', 1201),
(23, 'ASIA EXCEL PTE LTD', '2 JURONG EAST ST. 21. #04-32D1 IMM BUILDING S609601', '2 JURONG EAST ST. 21. #04-32D1 IMM BUILDING S609601', '', '', '66650828', '66650209', '', '2015-04-13 11:11:41', '2015-04-13 11:11:41', 1201),
(24, 'CHEONG HOCK GUAN WATER HEATER CENTRE PTE LTD', '512 CHAI CHEE LANE #07-07 S 469028', '512 CHAI CHEE LANE #07-07 S 469028', '', '', '67498885', '67498887', '', '2015-04-13 11:19:54', '2015-04-13 11:19:54', 1201),
(25, 'KOLM ENTERPRISE LLP', 'BLK 8 CHIA PING RD #04-07/08 SINGPORE 619973', 'BLK 8 CHIA PING RD #04-07/08 SINGPORE 619973', 'KOLM.STEEL@GMAIL.COM', 'www.kolm.com', '62768218, 62737060', '62768389', '', '2015-04-13 11:23:40', '2015-09-05 04:58:22', 1201),
(26, 'GTS ASIA MARKETING PTE LTD ', '32 KALLANG PUDDING RD #04-06 ELITE INDUSTRIAL BUIDING 1 S349313', '32 KALLANG PUDDING RD #04-06 ELITE INDUSTRIAL BUIDING 1 S349313', '', '', '68467737', '68467727', '', '2015-04-13 11:30:22', '2015-04-13 11:30:22', 1201),
(27, 'SHOWY PRIVATE LIMITED', 'NO. 35 SUNGAI KADUT ST 4 SUNGAI KADUT INDUSTRIAL ESTATE S729057', 'NO. 35 SUNGAI KADUT ST 4 SUNGAI KADUT INDUSTRIAL ESTATE S729057', '', '', '63656636', '63688289', '', '2015-04-13 11:41:18', '2015-04-13 11:41:18', 1201),
(28, 'HYDRABATHS ASIA PTE LTD', 'BLK 26 KALLANG PLACE, #05-02/03 S339157', 'BLK 26 KALLANG PLACE, #05-02/03 S339157', 'sales@hydrabaths.com.sg', 'www.hydrabaths.com.sg', '62811229', '62951063', '', '2015-04-13 11:45:47', '2015-09-23 12:03:47', 1201),
(29, 'SPLENDOUR CORPORATION PTE LTD ', '2 FAN YOONG ROAD SINGAPORE 629780', '2 FAN YOONG RD SINGAPORE 629780', 'SALES@SPLENDOUR.SG', 'www.splendour.sg', '62666698', '62659695', '', '2015-04-18 07:36:51', '2015-09-05 04:27:36', 1201),
(30, 'BMS GLOBAL MARETING PTE LTD', '9 YISHUN INDUSTRIAL STREET 1 #02-61/62 NORTH SPRING BIZHUB S768163', '9 YISHUN INDUSTRIAL STREET 1 #02-61/62 NORTH SPRING BIZHUB', 'SALES@NOBELBATHWARE.COM', 'www.nobelbathware.com', '67104173', '67104179', '', '2015-04-18 07:38:40', '2015-09-05 04:28:52', 1201),
(32, 'CRESTAR ENTERPRISE PTE LTD', 'BLK 164 KALLANG WAY KOLAM AYER INDUSTRIAL ESTATE', NULL, 'sales@crestarfan.com.sg', 'www.crestarfan.com.sg', '68416413', '62549438', '', '2015-07-27 03:49:50', '2015-09-13 05:48:29', 1201),
(36, 'VHIVE', 'Plaza Singapura', NULL, 'info@vhive.com.sg', 'vhive.com.sg', '67734567', '67734566', 'furniture supplier, office supplies', '2015-08-31 03:27:14', '2015-08-31 03:27:58', 1203),
(37, 'MONIC RESOURCES PTE LTD', '53 UBI AVENUE 1 #03-07 PAYA UBI INDUSTRIAL PARL SINGAPORE 408934', NULL, 'monic.spore@gmail.com/ sinks8taps@yahoo.com.sg', 'MONIC', '9677 4417', '6293 1653', '', '2015-09-03 12:24:04', '2015-09-03 12:28:24', 1201),
(38, 'ADAMAS BATHROOM PTE LTD', '199/201 JALAN BESAR SINGAPORE 208887', NULL, 'adamas@singnet.com.sg', 'adamas', '62984120, 62986721', '62973523', '', '2015-09-07 06:00:14', '2015-09-07 06:00:59', 1201),
(39, 'AMASCO INDUSTRIES PTE ', 'NO 135 JOO SENG ROAD, #02-01 PM INDUSTRIAL BUILDING, SINGAPORE 368363', NULL, 'www.amasco.com.sg', 'www.amascod.com', '62896947/ 62892210', '62897696', '', '2015-09-14 06:21:50', '0000-00-00 00:00:00', 1201),
(40, 'FRASCIO (S) PTE LTD ', 'No 1 Soon Lee St. #05-60 Pioneer Centre Singapore 627605', NULL, 'sales.sg@frascio-faucet.com', 'www.frascio-faucet.com', '+6568991787', '+6568991789', '', '2015-09-14 06:39:59', '2015-09-14 06:39:59', 1201),
(42, 'MEILOR ENTERPRISE PTE LTD', 'NO. 30 OLD TOH TUCK ROAD #05-14 SINGAPORE 597654', NULL, 'meilorpl@yahoo.com.sg', 'www.meilor.com', '67762990', '67954779', '', '2015-09-23 12:00:48', '2015-09-23 12:00:48', 1201),
(43, 'LION CITY COMPANY', '656 GEYLANG ROAD SINGAPORE 389586', NULL, 'lioncityco@singnet.com.sg', 'www.lioncityco.com', '67483367', '67489088', '', '2015-09-23 12:03:13', '2015-09-23 12:03:13', 1201),
(44, 'INZWERKZ PTE LTD', '33 UBI AVE 3 #01-33 VERTEX SINGAPORE 408868', NULL, 'alex@inzwerkz.com.sg', 'www.inzwerkz.com.sg', '66592533', '66592523', '', '2015-09-23 12:06:16', '2015-09-23 12:06:16', 1201),
(45, 'BENNINGTON TECHNOLOGIES PTE LTD', 'BLK 4009 ANG MO KIO AVE 10 #04-34 TECHPLACE 1 SINGAPORE 569738', NULL, 'mingwei@bennington.com.sg', 'www.bennington.com.sg', '65523033', '67526066', '', '2015-09-23 12:59:38', '2015-09-23 12:59:38', 1201),
(46, 'ELMARK MARKETING', '55 UBI AVENUE 1 #02-04/05/06 SINGAPORE 408935', NULL, 'elmark@elmark.com.sg', 'www.elmark.com.sg', '67410729', '67413742', '', '2015-09-23 01:04:52', '2015-09-23 01:04:52', 1201),
(47, 'FANCO FAN MARKETING PTE LTD', '30 MANDAI ESTATE #02-03 MANDAI INDUSTRIAL BUILDING SINGAPORE 729918', NULL, 'jasmine@fanco.com.sg', 'www.fanco.com.sg', '67667277', '67627277', '', '2015-09-23 01:07:06', '2015-09-23 01:07:06', 1201),
(48, 'ADL ENTERPRISE PTE LTD', '41 TOH GUAN ROAD EAST #02-01 ADL BUILDING SINGAPORE 608605', NULL, 'adlent@singnet.com.sg', 'www.adl.com.sg', '65617555', '65617666', '', '2015-09-23 01:10:27', '2015-09-23 01:10:27', 1201),
(49, 'Innov8te', 'jalan sultan', NULL, 'innov8te@innov8te.com', 'innov8te.com.sg', '93838', '84949', 'sdkfsdfdfs', '2016-04-27 09:20:44', '2016-04-27 09:21:08', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_contacts`
--

CREATE TABLE IF NOT EXISTS `supplier_contacts` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `contact` varchar(16) NOT NULL,
  `email` varchar(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_contacts`
--

INSERT INTO `supplier_contacts` (`id`, `supplier_id`, `name`, `contact`, `email`) VALUES
(4, 5, 'BENARD WANG 91164676', '66356147', 'ACORNSPECIALIST@GMAIL.COM'),
(5, 4, 'RAYMOND CHUNG 91822312', '68468522', 'ntl666@hotmail.com'),
(7, 6, 'ALOYSIUS MOK 98440066', '68410111', 'SALES1@ALPHASINGAPORE.COM'),
(8, 7, 'YI PENG 90061138', '63161274', 'SALES@TREO.COM.SG'),
(9, 8, 'ANG CHUAN HUA 91832882', '68421686', 'vicmktg@singnet.com.sg'),
(10, 9, 'AVAN CHUA 98577297', '62833181 , 67496', 'jovensgp@singnet.com'),
(11, 10, 'MR WOO KENG LAU 98507608', '65421635', ''),
(13, 12, '', '', ''),
(14, 12, 'PHILIP KIONG ', '97581781', 'FIT_PHILIP@FUJIOH.COM.SG'),
(15, 13, 'TAN SAY KOON ', '97396818', 'SALES@MACLAIRE.COM'),
(17, 14, 'BERNARD WANG', '91164676', 'ACORNSPCIALIST@GMAIL.COM'),
(18, 15, 'FRANKIE NG CCHIN HOCK', '98339198', 'SALES@SPLENDOUR.SG'),
(20, 17, 'TRICIA PANG', '97419232', 'SALES@NOBELBATHWARE.COM'),
(21, 18, 'KIM ONG', '82988884', 'IINFO@TECNO.COM.SG'),
(24, 19, 'IVAN THAM', '83578445', 'DGB.TRADING@HOTMAIL.COM'),
(25, 20, 'JEFFREY CHIANG', '98506302', 'MELIORPL@YAHOO.COM.SG'),
(26, 21, 'GINA TAN', '81639988', 'GINA@AEROGAZ.COM'),
(28, 16, 'JEFFREY SEAH', '91181228', 'JEFFREYSEAH@RINNAI.SG'),
(29, 16, 'JOHNNY SIM ', '96221647', 'SALES@RINNAI.SG'),
(31, 23, 'ALAN DING ', '91016972', 'ALAM.DING@ASIAEXCEL.COM.SG'),
(32, 23, '', '', ''),
(33, 24, 'JUNE TAN', '92312555', 'SALESTEAMA@CHG.COM.SG'),
(36, 26, 'DESMOND LEE', '90259889', 'SALES@SAMAIRE.COM.SG'),
(37, 27, 'JIMMY K.B.CHNG', '96355091', 'JIMMY@SHOWY.COM.SG'),
(47, 31, 'fgfd', '456', '32@gmail.com'),
(48, 31, 'Vincent', '8888888888', 'vincent@jacksoncarpet.com'),
(54, 33, 'henry tan', '123456889', 'henry@inagge.com.sg'),
(56, 34, 'awefwaef', 'asgwa', 'wfwaeg'),
(57, 35, 'Mike Tyson', '900098987', 'miketyson@hotmail.com'),
(58, 35, 'Rock Balbore', '909080897', 'rocky@outlook.com'),
(61, 36, 'Eric Koh', '9688765445', 'erickoh@vhive.com.sg'),
(62, 36, 'Darren Teo', '988689089', 'darren.teo@vhive.com.sg'),
(64, 37, 'BILLY', '9677 4417', 'monic.spore@gmail.com'),
(65, 37, '', '', 'sinks8taps@yahoo.com.sg'),
(66, 3, 'ERIC CHUA ', '96609049', 'ericchua@casa.com.sg'),
(67, 3, 'DERICK TAY ', '90669100', 'DERICKTAY@CASA.COM.SG'),
(68, 22, 'LAWRANCE ', '93809000', 'GENOVA@SINGNET.COM.SG'),
(69, 29, 'GARY NG ', '81813829', 'SALES@SPLENDOUR.SG'),
(70, 29, 'FRANKIE NG CHIN HOCK', '98339198', 'SALES@SPLENDOUR.SG'),
(71, 30, 'TRICIA PANG', '97419232', 'SALES@NOBELBATHWARE.COM'),
(73, 25, 'TAN LIAN SENG', '98456463', 'KOLM.STEEL@GMAIL.COM'),
(74, 25, 'VICTOR LEE', '97522648', 'VICTORLEE_7@MSN.COM'),
(76, 38, 'Martin ', '90300188', ''),
(77, 32, 'Jerald Tew', '98384682', ''),
(78, 40, 'Jeffery Ong ', '+6598797606', ''),
(79, 41, 'feawefwef', 'asegawegwaeg', 'wegwaegewg'),
(80, 11, 'WEI JIAN 82825022', '62875287', 'weijian.ho@crizto.com'),
(81, 42, 'JEFFREY CHIANG ', '98506302', ''),
(82, 43, 'MDM ONG', '67483367', ''),
(83, 28, 'JIMMY KHOO', '96386141', 'JIMMY@HYDRABATHS.COM.SG'),
(84, 44, 'ALEX YEO', '97398214', ''),
(85, 45, 'HUANG MING WEI ', '92979080', ''),
(86, 46, 'LAWRENCE LOH', '90095500', ''),
(87, 47, 'JASMINE TAY ', '97778333', ''),
(88, 48, 'MR .NG', '97852411', ''),
(90, 49, 'khine', '883838383', 'khine@innov8te.com.sg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(128) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `userrole` int(11) NOT NULL DEFAULT '0',
  `email` varchar(128) NOT NULL,
  `password` varchar(200) NOT NULL,
  `remember_token` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1201 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `dob`, `address`, `contact`, `userrole`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1200, 'Innov8te', 'Admin', '1998-02-03', 'Singapore', '123456', 0, 'ivan.yeo@innov8te.com.sg', '$2y$10$1nVQIolulr3wrolKu.KncO9qTrE6bk9E8wbgy7W4dtEry7rQP8RM.', '3KR3dICofmkj5xzRhtxTLE15CqPNMlS45V4aGvrz79WTnOEI6IPuPGGSPbwd', '2015-03-30 04:19:43', '2016-04-26 08:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `invoices` int(11) NOT NULL,
  `products` int(11) NOT NULL,
  `purchase_orders` int(11) NOT NULL,
  `delivery_orders` int(11) NOT NULL,
  `clients` int(11) NOT NULL,
  `suppliers` int(11) NOT NULL,
  `profile` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `invoices`, `products`, `purchase_orders`, `delivery_orders`, `clients`, `suppliers`, `profile`) VALUES
(0, 'Superadmin', 1111, 1111, 1111, 1111, 1111, 1111, 1111),
(1, 'Admin', 1111, 1111, 1111, 1111, 1111, 1111, 1111),
(2, 'Editor', 0, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cn_items`
--
ALTER TABLE `cn_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companyprofile`
--
ALTER TABLE `companyprofile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`showid`);

--
-- Indexes for table `currency_country`
--
ALTER TABLE `currency_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_exchange`
--
ALTER TABLE `currency_exchange`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  ADD PRIMARY KEY (`showid`);

--
-- Indexes for table `do_items`
--
ALTER TABLE `do_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `middlemen`
--
ALTER TABLE `middlemen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po_items`
--
ALTER TABLE `po_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `product_itemno` (`product_itemno`);

--
-- Indexes for table `products_category`
--
ALTER TABLE `products_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_status`
--
ALTER TABLE `product_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`showid`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_type`
--
ALTER TABLE `store_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_contacts`
--
ALTER TABLE `supplier_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `cn_items`
--
ALTER TABLE `cn_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `showid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currency_country`
--
ALTER TABLE `currency_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `currency_exchange`
--
ALTER TABLE `currency_exchange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  MODIFY `showid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `do_items`
--
ALTER TABLE `do_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `middlemen`
--
ALTER TABLE `middlemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `po_items`
--
ALTER TABLE `po_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `products_category`
--
ALTER TABLE `products_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `product_status`
--
ALTER TABLE `product_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `showid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `store_type`
--
ALTER TABLE `store_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `supplier_contacts`
--
ALTER TABLE `supplier_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1201;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
