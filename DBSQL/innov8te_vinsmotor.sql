-- MySQL dump 10.13  Distrib 5.6.33, for Linux (x86_64)
--
-- Host: localhost    Database: innov8te_vinsmotor
-- ------------------------------------------------------
-- Server version	5.6.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `balance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (2,'K & V Car Rental','',NULL,'K & V Car Rental Pte Ltd','64532121','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67','12 Sin Ming Industrial Estate Sector B #01-67','M/S.','','2016-08-13 17:05:17','2016-09-05 13:24:09',1201,-121),(3,'Vin\'s Car Rental','',NULL,'Vin\'s Car Rental Pte Ltd','64532121','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67','12 Sin Ming Industrial Estate Sector B #01-67','M/S.','','2016-08-13 17:05:51','2016-09-05 13:24:17',1201,-10),(16,'Galvin Khong','',NULL,'Personal','96688951','galkkl@yahoo.com','52 Eng Kong Place S599124','52 Eng Kong Place S599124','Mr.','','2016-09-05 13:24:52','2016-09-05 15:36:17',1201,15000);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cn_items`
--

DROP TABLE IF EXISTS `cn_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cn_items` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cn_items`
--

LOCK TABLES `cn_items` WRITE;
/*!40000 ALTER TABLE `cn_items` DISABLE KEYS */;
INSERT INTO `cn_items` VALUES (1,'1d',1,'item001','product 001  x  x  mm',20.00,4,4,''),(2,'1e',1,'item001','product 001  x  x  mm',20.00,5,5,''),(3,'7a',3,'item0012','3333  x  x  mm',11.00,4,1,''),(4,'7a',1,'item001','product 001  x  x  mm',0.00,3,2,''),(5,'7a',5,'008382','Product 3568  x  x  mm',0.00,10,3,'');
/*!40000 ALTER TABLE `cn_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companyprofile`
--

DROP TABLE IF EXISTS `companyprofile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companyprofile` (
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
  `remarks4` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companyprofile`
--

LOCK TABLES `companyprofile` WRITE;
/*!40000 ALTER TABLE `companyprofile` DISABLE KEYS */;
INSERT INTO `companyprofile` VALUES (1,'VinMotors','201424327E','\n<div style=\"text-align: justify;\" align=\"left\">Innov8te</div>','Terms ','* Cheque payment ','Terms','<br>','Terms','* Cheque payment ','','');
/*!40000 ALTER TABLE `companyprofile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` int(11) NOT NULL,
  `product_qty_status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
INSERT INTO `invoice_items` VALUES (75,60,49,'GK8-1006737','Honda Shuttle 1.5G Pearl Grey','',0.00,54800.00,1,1,0,0,' x  x  mm',0,'enough'),(76,60,50,'COE_CatA','COE Cat A','',0.00,53000.00,1,0,0,0,' x  x  mm',0,'enough'),(77,61,32,'ENOC5W40','ENOC 5W40 Synthetic Engine Oil','',1.00,50.00,3,0,0,0,' x  x  mm',0,'enough');
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `delivery_address` varchar(256) DEFAULT NULL,
  `purchase_order` varchar(125) NOT NULL DEFAULT '1',
  `delivery_order` varchar(125) NOT NULL DEFAULT '1',
  `credit_note` varchar(16) NOT NULL DEFAULT '1',
  `total_price` decimal(11,2) DEFAULT NULL,
  `gst` decimal(11,2) NOT NULL,
  `gst_status` varchar(30) NOT NULL,
  `total_paid` decimal(11,2) NOT NULL,
  `remarks` text NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `middleman` int(11) NOT NULL,
  `installation` varchar(20) NOT NULL,
  `sales_staff` int(11) NOT NULL,
  `payment_mode` varchar(25) NOT NULL,
  `service_content` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (60,'INV00060',1201,16,'2016-09-05 16:10:32','2016-09-05 16:10:32',1,NULL,'1;36','1','1',107800.00,0.00,'gst_already',0.00,'','2000-10-10',5,'Yes',4,'Cheque','0'),(61,'INV00061',1200,-1,'2016-09-08 09:10:05','2016-09-08 09:10:05',0,NULL,'1','1','1',150.00,0.00,'no_gst',0.00,'','2000-10-10',7,'Yes',4,'Visa / Master','0');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` varchar(25) NOT NULL,
  `log` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'2','Innov8te Admin edited middleman from -1 to 7','2016-06-23 17:52:52'),(2,'4','Innov8te Admin edited middleman from -1 to 7','2016-06-23 17:54:11'),(3,'5','Innov8te Admin edited middleman from -1 to 7','2016-06-23 18:57:27'),(4,'3','Innov8te Admin edited middleman from -1 to 7','2016-06-23 18:58:54'),(5,'6','Innov8te Admin edited middleman from -1 to 7','2016-06-24 15:33:31'),(6,'1','Innov8te Admin edited middleman from 2 to 7','2016-06-27 12:49:52'),(7,'1','Innov8te Admin edited a product from AUDI A4 1.8T ENGINE to ENOC 5W40','2016-06-27 12:49:52'),(8,'2','Innov8te Admin edited middleman from -1 to 7','2016-06-27 18:03:56'),(9,'2','Innov8te Admin edited delivery date from PENDING to ','2016-06-27 18:03:57'),(10,'3','Innov8te Admin edited middleman from -1 to 7','2016-07-05 13:07:41'),(11,'3','Innov8te Admin edited delivery date from PENDING to ','2016-07-05 13:07:41'),(12,'3','Innov8te Admin edited delivery date from PENDING to ','2016-07-05 13:14:32'),(13,'3','Innov8te Admin edited delivery date from PENDING to ','2016-07-05 13:19:32'),(14,'3','Innov8te Admin edited delivery date from PENDING to ','2016-07-05 13:19:57'),(15,'3','Innov8te Admin edited delivery date from PENDING to ','2016-07-05 13:20:04'),(16,'8','Innov8te Admin edited middleman from -1 to 7','2016-07-05 13:28:02'),(17,'8','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-07-05 13:28:02'),(18,'8','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-07-05 13:44:58'),(19,'5','Innov8te Admin edited delivery date from PENDING to ','2016-07-05 13:45:02'),(20,'4','Innov8te Admin edited delivery date from PENDING to ','2016-07-05 13:45:06'),(21,'1','Innov8te Admin edited a product from ENOC 5W40 to AA01','2016-07-06 12:37:21'),(22,'5','Innov8te Admin edited middleman from -1 to 7','2016-07-06 12:41:04'),(23,'7','Vins Admin edited middleman from -1 to 7','2016-08-13 17:17:58'),(24,'17','Vins Admin edited delivery date from 2000-10-10 to ','2016-08-13 17:36:36'),(25,'17','Vins Admin edited delivery date from 2000-10-10 to ','2016-08-13 17:39:22'),(26,'17','Vins Admin edited delivery date from 2000-10-10 to ','2016-08-13 17:42:21'),(27,'10','Innov8te Admin edited a product from ENOC 5W40 Synthetic Engine Oil to Toyota Crown Athlete 2.0 ST Black','2016-08-17 16:09:06'),(28,'22','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-17 17:58:18'),(29,'23','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-17 18:45:39'),(30,'14','Innov8te Admin edited middleman from 7 to 5','2016-08-17 19:14:33'),(31,'27','Vins Admin edited delivery date from 2000-10-10 to ','2016-08-18 11:02:38'),(32,'28','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 11:22:01'),(33,'28','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 11:22:19'),(34,'27','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 11:24:18'),(35,'31','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 13:01:28'),(36,'31','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 13:01:40'),(37,'32','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 13:52:42'),(38,'32','Innov8te Admin edited middleman from 7 to 9','2016-08-18 13:54:53'),(39,'32','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 13:54:53'),(40,'32','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 15:16:12'),(41,'14','Innov8te Admin edited middleman from 5 to 9','2016-08-18 17:23:57'),(42,'15','Innov8te Admin edited middleman from 7 to 9','2016-08-18 17:27:56'),(43,'33','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 17:49:36'),(44,'33','Innov8te Admin edited middleman from 5 to 9','2016-08-18 18:01:07'),(45,'33','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-18 18:01:07'),(46,'35','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-19 15:31:39'),(47,'35','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-19 15:45:51'),(48,'39','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-22 13:19:53'),(49,'45','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-22 18:50:12'),(50,'48','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-22 19:07:52'),(51,'49','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-22 19:10:20'),(52,'49','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-22 19:15:10'),(53,'51','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-23 10:59:59'),(54,'51','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-23 11:07:01'),(55,'46','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-24 01:42:51'),(56,'46','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-24 11:37:45'),(57,'36','Innov8te Admin edited a product from  to Vinproduct Oil','2016-08-24 12:06:40'),(58,'36','Innov8te Admin edited a product from  to Vinproduct Oil','2016-08-24 12:07:03'),(59,'36','Innov8te Admin edited a product from  to Vinproduct Oil','2016-08-24 16:35:07'),(60,'29','Innov8te Admin edited a product from  to ENOC 5W40 Synthetic Engine Oil','2016-08-25 13:26:46'),(61,'29','Innov8te Admin edited a product from  to Toyota Corolla Axio 1.5X White','2016-08-25 13:26:46'),(62,'30','Innov8te Admin edited a product from  to Honda Vezel 1.5X Light Grey','2016-08-25 13:26:54'),(63,'31','Innov8te Admin edited a product from  to ENOC 5W40 Synthetic Engine Oil','2016-08-25 13:27:05'),(64,'33','Innov8te Admin edited a product from  to dfdfd','2016-08-25 13:27:14'),(65,'34','Innov8te Admin edited a product from  to Toyota Harrier Elegance Silver','2016-08-25 13:27:24'),(66,'35','Innov8te Admin edited a product from  to dfdfd','2016-08-25 13:27:39'),(67,'36','Innov8te Admin edited a product from  to Vinproduct Oil','2016-08-25 13:27:51'),(68,'37','Innov8te Admin edited a product from  to Gas Oil','2016-08-25 13:28:02'),(69,'38','Innov8te Admin edited a product from  to ENOC 5W40 Synthetic Engine Oil','2016-08-25 13:28:15'),(70,'38','Innov8te Admin edited a product from  to Honda Vezel 1.5X Pearl Blue','2016-08-25 13:28:15'),(71,'46','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-25 13:28:34'),(72,'47','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-25 13:28:42'),(73,'49','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-25 13:28:52'),(74,'50','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-25 13:29:02'),(75,'51','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-25 13:29:18'),(76,'52','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-25 13:29:28'),(77,'53','Innov8te Admin edited delivery date from 2000-10-10 to ','2016-08-25 13:29:37'),(78,'39','Vins Admin edited a product from  to Honda Vezel 1.5X Light Grey','2016-09-05 13:26:45');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `middlemen`
--

DROP TABLE IF EXISTS `middlemen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `middlemen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(120) NOT NULL,
  `last_name` varchar(120) NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `mobile_contact` varchar(16) NOT NULL,
  `email` varchar(1550) NOT NULL,
  `address` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `photo` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `middlemen`
--

LOCK TABLES `middlemen` WRITE;
/*!40000 ALTER TABLE `middlemen` DISABLE KEYS */;
INSERT INTO `middlemen` VALUES (4,'Vin\'s Motor Pte Ltd','','199906067G','64532121','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67 Singapore 575656','','10926345091471489387.png','2016-05-27 07:05:17','2016-08-18 11:03:07',1201),(5,'Vin\'s Auto Pte Ltd','','201109925E','64532121','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67 Singapore 575656','','10129283411471489377.png','2016-05-27 07:13:57','2016-08-18 11:02:57',1201),(6,'Vin\'s Car Rental Pte Ltd','','201533370W','64532121','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67 Singapore 575656','','19333165171471489307.png','2016-05-27 07:14:30','2016-08-18 11:01:47',1201),(7,'K & V Car Rental Pte Ltd','','199201997H','64532121','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67 Singapore 575656','','21012688251471489109.png','2016-05-27 07:14:49','2016-08-18 10:58:29',1201);
/*!40000 ALTER TABLE `middlemen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `po_items`
--

DROP TABLE IF EXISTS `po_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `po_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` varchar(15) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_itemno` varchar(20) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `buying_price` decimal(11,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `description` text,
  `items_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `po_items`
--

LOCK TABLES `po_items` WRITE;
/*!40000 ALTER TABLE `po_items` DISABLE KEYS */;
INSERT INTO `po_items` VALUES (5,'ddd uuu',2,'ENOC5W40','ENOC 5W40',0.00,90.00,1,' ',0),(11,'test0011',2,'ENOC5W40','ENOC 5W40',0.00,0.00,1,' ',0),(70,'36',49,'GK8-1006737','Honda Shuttle 1.5G Pearl Grey',0.00,1.00,1,NULL,0),(71,'37',26,'RU1-1200199','Honda Vezel 1.5X Light Grey',1.00,1.00,1,NULL,0);
/*!40000 ALTER TABLE `po_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_status`
--

DROP TABLE IF EXISTS `product_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_status`
--

LOCK TABLES `product_status` WRITE;
/*!40000 ALTER TABLE `product_status` DISABLE KEYS */;
INSERT INTO `product_status` VALUES (1,23,0,0,'','1','12',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(2,22,0,0,'','1','13',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(3,23,0,0,'','1','14',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(15,38,0,0,'','1','7',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(17,28,0,0,'','1','8',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(19,38,0,0,'','1','10',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(21,29,0,0,'','1','13',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(23,28,0,0,'','1','14',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(30,43,33,0,'19','1','25',0,'','2016-08-23 11:14:03','0000-00-00 00:00:00',1200),(31,43,0,0,'','1','26',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(32,43,0,0,'','1','27',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(34,29,0,0,'','10','29',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(45,26,0,0,'','1','37',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `product_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_catid` int(11) NOT NULL,
  `product_itemno` varchar(150) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `selling_price` decimal(11,2) NOT NULL,
  `supplier` int(11) NOT NULL,
  `measurements` varchar(60) NOT NULL,
  `weight` varchar(100) DEFAULT NULL,
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
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (26,6,'RU1-1200199','Honda Vezel 1.5X Light Grey','',5,1.00,1.00,3,';;','120','1','0','',0,'',4,1,0,'5/5/2016 12.00PM Sibak tow to Mike Soh,Petrol pump full tank.\r\n26/5/2016 Marcus drove over from Mike Soh, Galvin drove to VICOM\r\n11/6/2016 1.30PM Sibak tow back to Mike Soh\r\n11/8/2016 1.10PM Sibak tow back to Vins Auto <SOLD to A.Teo son>','2016-08-13 04:38:22','2016-09-05 03:28:37',1201),(27,6,'RU1-1204360','Honda Vezel 1.5X Pearl Blue','',5,1.00,1.00,3,';;','120','1','0','',0,'',4,1,0,'04/07/2016 12.35pm VIDA TOW TRUCK TOW TO TAKE PHOTO COMING BACK ON 3.30PM\r\n29/07/2016 galvin drive to vicom inspection,eric drive back at 5.35pm & pump full tank.','2016-08-13 04:40:46','2016-09-05 04:09:44',1201),(29,6,'ZSU60-0082929','Toyota Harrier Elegance Silver','',5,1.00,1.00,1,';;','120','1','0','',0,'',4,1,0,'','2016-08-13 04:42:31','2016-08-18 10:05:46',1201),(30,6,'Borrowed: Toyota Crown','Toyota Crown Athlete 2.0 ST Black','',5,1.00,1.00,3,';;','120','1','0','',0,'',7,1,0,'Borrowed from Vida','2016-08-13 04:44:27','2016-09-05 03:27:13',1201),(32,3,'ENOC5W40','ENOC 5W40 Synthetic Engine Oil','',4,1.00,1.00,18,';;','120','26','4','6301230921471423639.jpg',0,'',2,1,0,'','2016-08-13 04:58:07','2016-09-05 03:39:37',1201),(46,6,'ZSU60-0086855','Toyota Harrier Elegance Roof Black','',5,1.00,1.00,3,';;','120','1','0','',0,'',4,1,0,'24/8/2016 Realised that this unit is with roof. Supposed to be w/out roof.\r\n25/8/2016 12.00PM Vida arranged tow truck to tow back for customs check\r\n25/8/2016 6.15PM Vida arrange tow back to Blk 12','2016-09-05 03:22:45','2016-09-05 03:30:04',1201),(47,6,'ZSU60-0084066','Toyota Harrier Premium Roof Black','',5,1.00,1.00,-1,';;','120','1','0','',0,'',4,1,0,'','2016-09-05 03:23:23','2016-09-05 03:26:39',1201),(48,6,'ZSU60-0079835','Toyota Harrier Premium Roof Silver','',5,1.00,1.00,3,';;','120','1','0','',0,'',17,1,0,'','2016-09-05 03:24:20','2016-09-05 03:26:51',1201),(49,6,'GK8-1006737','Honda Shuttle 1.5G Pearl Grey','',5,1.00,1.00,3,';;','120','1','0','',0,'',17,1,0,'','2016-09-05 03:28:11','2016-09-05 03:28:19',1201),(50,16,'COE_CatA','COE Cat A','',5,1.00,1.00,-1,';;','120','9998','0','',0,'',2,1,0,'','2016-09-05 04:08:44','2016-09-05 04:08:44',1201);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_category`
--

DROP TABLE IF EXISTS `products_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) NOT NULL,
  `cat_status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_category`
--

LOCK TABLES `products_category` WRITE;
/*!40000 ALTER TABLE `products_category` DISABLE KEYS */;
INSERT INTO `products_category` VALUES (3,'Synthetic Engine Oil',1,'2016-05-27 07:16:33','2016-05-27 07:16:33','0000-00-00 00:00:00'),(4,'Automatic Transmission Fluid',1,'2016-05-27 08:26:02','2016-05-27 08:26:02','0000-00-00 00:00:00'),(5,'Mineral Engine Oil',1,'2016-05-27 08:26:16','2016-05-27 08:26:16','0000-00-00 00:00:00'),(6,'Brand New Parallel Imported Cars',1,'2016-08-13 04:37:29','2016-08-13 04:37:29','0000-00-00 00:00:00'),(16,'COE',1,'2016-09-05 04:07:54','2016-09-05 04:07:54','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `products_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_orders` (
  `showid` int(11) NOT NULL AUTO_INCREMENT,
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
  `total_price` int(11) NOT NULL,
  `purchase_order_no` varchar(100) DEFAULT NULL,
  `remarks` text NOT NULL,
  PRIMARY KEY (`showid`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_orders`
--

LOCK TABLES `purchase_orders` WRITE;
/*!40000 ALTER TABLE `purchase_orders` DISABLE KEYS */;
INSERT INTO `purchase_orders` VALUES (36,'36',-1,'21',1201,3,'2016-09-05 16:11:44','2016-09-05 16:12:52','5','Galvin Khong','2016-09-05',1,1,'PO00036',''),(37,'37',-1,'21',1201,3,'2016-09-05 16:16:28','2016-09-05 16:16:28','4','','1970-01-01',0,1,'PO00037','');
/*!40000 ALTER TABLE `purchase_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_items`
--

DROP TABLE IF EXISTS `quotation_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotation_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_itemno` varchar(20) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `category` varchar(60) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `selling_price` decimal(11,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL,
  `product_qty_status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_items`
--

LOCK TABLES `quotation_items` WRITE;
/*!40000 ALTER TABLE `quotation_items` DISABLE KEYS */;
INSERT INTO `quotation_items` VALUES (71,42,49,'GK8-1006737','Honda Shuttle 1.5G Pearl Grey','',0.00,54800.00,1,' x  x  mm',0,'enough'),(72,42,50,'COE_CatA','COE Cat A','',0.00,53000.00,1,' x  x  mm',0,'enough');
/*!40000 ALTER TABLE `quotation_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotations`
--

DROP TABLE IF EXISTS `quotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_no` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `pro_status` int(11) NOT NULL,
  `delivery_address` varchar(256) NOT NULL,
  `invoice` varchar(16) NOT NULL DEFAULT '0',
  `total_price` decimal(11,2) NOT NULL,
  `gst` decimal(11,2) NOT NULL,
  `gst_status` varchar(30) NOT NULL,
  `total_paid` decimal(11,2) NOT NULL,
  `remarks` text NOT NULL,
  `service_content` varchar(15) NOT NULL,
  `middleman` int(11) NOT NULL,
  `sales_staff` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotations`
--

LOCK TABLES `quotations` WRITE;
/*!40000 ALTER TABLE `quotations` DISABLE KEYS */;
INSERT INTO `quotations` VALUES (42,'QU00001',1201,16,'2016-09-05 16:09:33','2016-09-05 16:09:33',0,0,'','60',107800.00,0.00,'gst_already',0.00,'4 Bids Non Guaranteed','0',5,4);
/*!40000 ALTER TABLE `quotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `menu_color` varchar(25) NOT NULL,
  `button_color` varchar(16) NOT NULL,
  `button_hover` varchar(16) NOT NULL,
  `sidemenu_color` varchar(16) NOT NULL,
  `sidemenu_hover` varchar(16) NOT NULL,
  `version` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'St8cks','3498db','FFF','000','424a5d','68dff0','1.0');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `contact` varchar(16) NOT NULL,
  `email` varchar(1550) NOT NULL,
  `address` varchar(200) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffs`
--

LOCK TABLES `staffs` WRITE;
/*!40000 ALTER TABLE `staffs` DISABLE KEYS */;
INSERT INTO `staffs` VALUES (2,'Galvin Khong','96688951','vinsauto_galvin@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67 Singapore 575656','','2016-05-27 08:44:42','2016-05-27 08:44:42',1201),(3,'Jonny Goh','91071499','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67','','2016-08-13 04:53:49','2016-08-13 04:53:49',1201),(4,'Eric Goh','98268744','vinsauto87@yahoo.com.sg','12 Sin Ming Industrial Estate Sector B #01-67','Why do we use it?','2016-08-13 04:54:09','2016-08-18 05:19:29',1200);
/*!40000 ALTER TABLE `staffs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(50) NOT NULL,
  `store_type` int(11) NOT NULL,
  `store_description` varchar(255) NOT NULL,
  `store_address` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `remark` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store` DISABLE KEYS */;
INSERT INTO `store` VALUES (2,'Blk 12 #01-67 1F',5,' Underneath stairs','12 Sin Ming Industrial Estate Sector B #01-67',1,' ','2016-05-27 07:27:51','2016-08-18 12:59:24','0000-00-00 00:00:00'),(3,'Blk 20 #01-02 1F',6,' wewq','20 Sin Ming Industrial Estate Sector A #01-02',1,' ','2016-05-27 08:27:49','2016-08-19 10:57:08','0000-00-00 00:00:00'),(4,'SM 6',7,'','Outside of EX Space Marymount',1,'','2016-06-30 11:20:39','2016-08-13 04:35:15','0000-00-00 00:00:00'),(6,'Blk 12 #01-67 2F',5,'Staircase open area','12 Sin Ming Industrial Estate Sector B #01-67',1,' ','2016-08-13 04:36:03','2016-08-13 04:36:31','0000-00-00 00:00:00'),(7,'EX Space',8,' Car park lots that are loaned from Extra Space Marymount','9 Sin Ming Industrial Est Sector B S575654',1,' ','2016-08-13 04:39:28','2016-08-13 04:39:28','0000-00-00 00:00:00'),(17,'GMA Auto',17,' Mike Soh showroom','6D Mandai Estate #03-03\r\nM-Space\r\nSingapore 729938',1,' ','2016-09-05 03:26:04','2016-09-05 03:26:04','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_type`
--

DROP TABLE IF EXISTS `store_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_type` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_type`
--

LOCK TABLES `store_type` WRITE;
/*!40000 ALTER TABLE `store_type` DISABLE KEYS */;
INSERT INTO `store_type` VALUES (5,'Office Storage','2016-05-27 07:23:29','2016-06-30 12:29:38',1200),(6,'Workshop Area','2016-05-27 07:32:33','2016-05-27 07:32:42',1201),(7,'Open HDB Car Park','2016-08-13 04:33:38','2016-08-13 04:33:38',1201),(8,'Private Car Storage','2016-08-13 04:33:55','2016-08-13 04:34:06',1201),(9,'Office/Apartment','2016-08-19 12:08:08','2016-08-19 12:08:08',1200),(17,'Dealer Partner','2016-09-05 03:24:37','2016-09-05 03:24:37',1201);
/*!40000 ALTER TABLE `store_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_contacts`
--

DROP TABLE IF EXISTS `supplier_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `contact` varchar(16) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_contacts`
--

LOCK TABLES `supplier_contacts` WRITE;
/*!40000 ALTER TABLE `supplier_contacts` DISABLE KEYS */;
INSERT INTO `supplier_contacts` VALUES (9,1,'dd','2','e@gmail.com'),(10,1,'sdf','1','sdf@gmail.com'),(15,2,'sw','4','sw@gmail.com'),(21,3,'Mr Ang','84384559','wda@carism.com.sg'),(28,6,'wrwer','4546456','fd@gmail.com'),(29,5,'kaythi','6867867','kaythi@gmail.com'),(30,8,'may','1','dfsdf@gmail.com'),(31,9,'thant','3','thant@gmail.com'),(32,10,'dfdfdsf','2','test@gmail.com'),(33,11,'','',''),(34,12,'','',''),(35,13,'','',''),(37,14,'dfdfd','3','ddfdf@gmail.com'),(38,14,'kyi','23','kyi@gmail.com'),(39,15,'','',''),(40,15,'','',''),(46,4,'abc','1','abc@gmail.com'),(47,4,'def','2','def@gmail.com'),(48,4,'xyz','xyz','xyz@gmail.com'),(49,16,'abc','1','abc@gmail.com'),(50,16,'hhh','2','h@gmail.com'),(52,17,'kbzmalaysupplier','023232323','kbzmalay@gmail.com'),(53,18,'Desmond','92988849','');
/*!40000 ALTER TABLE `supplier_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(120) NOT NULL,
  `billing_address` varchar(200) NOT NULL,
  `delivery_address` varchar(200) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `website` varchar(120) NOT NULL,
  `tel` varchar(35) NOT NULL,
  `mobile` varchar(35) DEFAULT NULL,
  `fax` varchar(35) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (3,'Green Citi Singapore Pte Ltd','116 Punggol Walk #05-34\r\nSingapore 828768','12 Sin Ming Industrial Estate Sector B #01-67','wda@carism.com.sg','','84384559','84384559','84384559','','2016-08-18 11:06:34','2016-08-18 11:08:40',1201),(18,'Citygn Energy Pte Ltd','Blk 511 Kampong Bahru Road\r\n#04-05 Keppel Distripark\r\nSingapore 099447','12 Sin Ming Industrial Estate Sector B #01-67','info@citygroup.sg','','69080846','92988849','62706206','','2016-09-05 03:18:27','2016-09-05 03:18:27',1201);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `invoices` int(11) NOT NULL,
  `products` int(11) NOT NULL,
  `purchase_orders` int(11) NOT NULL,
  `delivery_orders` int(11) NOT NULL,
  `clients` int(11) NOT NULL,
  `suppliers` int(11) NOT NULL,
  `profile` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (0,'Superadmin',1111,1111,1111,1111,1111,1111,1111),(1,'Admin',1111,1111,1111,1111,1111,1111,1111),(2,'Editor',0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1202 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1200,'Innov8te','Admin','1998-02-03','Singapore','123456',0,'ivan.yeo@innov8te.com.sg','$2y$10$1nVQIolulr3wrolKu.KncO9qTrE6bk9E8wbgy7W4dtEry7rQP8RM.','9swLkLVEfaz3WKokVrWLdJZQ1lyju7NLaCGwuBLhrjSbF2RiJ56SxmLBzFnQ','2015-03-30 04:19:43','2016-05-12 01:39:29'),(1201,'Vins','Admin','1981-01-04','Innov8te','123456',0,'archana@innov8te.com.sg ','$2y$10$OnV8J3C8nqbaQTn58/wk4OX9JIkUVgk14IuCELa7Bvvvh.GMtPc2u','gjApO29qC5omB11iEqjJhtKbZEzEwJg2PyHOcMqVONgP0GMMgc0YDONFNcOZ','2016-05-12 09:30:15','2016-05-20 03:13:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-24 21:25:29
