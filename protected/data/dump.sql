-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: my_db
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.13.04.1

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
-- Dumping data for table `ActionLog`
--

LOCK TABLES `ActionLog` WRITE;
/*!40000 ALTER TABLE `ActionLog` DISABLE KEYS */;
INSERT INTO `ActionLog` VALUES (1,'admin',1,'StoreAttribute','simple_product','2012-07-10 21:57:29'),(2,'admin',1,'StoreProductType','Simple Product','2012-07-10 21:57:55'),(3,'admin',1,'StoreProduct','Simple product test','2012-07-10 21:58:34'),(4,'admin',2,'StoreAttribute','simple_product','2012-07-10 22:11:20'),(5,'admin',2,'StoreProductType','Simple Product','2012-07-10 22:11:28'),(19,'admin',1,'StoreProductType','laptop','2012-07-30 22:55:28'),(8,'admin',2,'StoreAttribute','simple_product','2012-07-10 22:35:12'),(9,'admin',2,'StoreAttribute','simple_product','2012-07-10 22:35:57'),(10,'admin',1,'StoreAttribute','color','2012-07-10 22:36:22'),(11,'admin',2,'StoreProductType','Simple Product','2012-07-10 22:36:32'),(12,'admin',2,'StoreProduct','Simple product test','2012-07-10 22:36:51'),(13,'admin',2,'StoreAttribute','color','2012-07-10 22:37:16'),(14,'admin',2,'StoreProduct','Simple product test','2012-07-10 22:37:47'),(15,'admin',2,'Discount','Скидка на всю технику Apple','2012-07-10 22:38:20'),(16,'admin',2,'StoreAttribute','color','2012-07-10 22:42:51'),(17,'admin',2,'StoreAttribute','color','2012-07-10 22:43:27'),(20,'admin',1,'StoreManufacturer','Lenovo','2012-07-30 22:55:29'),(21,'admin',1,'StoreAttribute','processor_manufacturer','2012-07-30 22:55:30'),(22,'admin',1,'StoreAttribute','freq','2012-07-30 22:55:30'),(23,'admin',1,'StoreAttribute','memmory','2012-07-30 22:55:30'),(24,'admin',1,'StoreAttribute','memmory_type','2012-07-30 22:55:30'),(25,'admin',1,'StoreAttribute','screen','2012-07-30 22:55:30'),(26,'admin',1,'StoreAttribute','video','2012-07-30 22:55:30'),(27,'admin',1,'StoreAttribute','screen_dimension','2012-07-30 22:55:30'),(28,'admin',1,'StoreProduct','Lenovo B570','2012-07-30 22:55:30'),(29,'admin',1,'StoreProduct','Lenovo G570','2012-07-30 22:55:31'),(30,'admin',1,'StoreManufacturer','Asus','2012-07-30 22:55:31'),(31,'admin',1,'StoreProduct','ASUS K53U','2012-07-30 22:55:31'),(32,'admin',1,'StoreProduct','ASUS X54C','2012-07-30 22:55:31'),(33,'admin',1,'StoreManufacturer','Dell','2012-07-30 22:55:32'),(34,'admin',1,'StoreProduct','DELL INSPIRON N5050','2012-07-30 22:55:32'),(35,'admin',1,'StoreManufacturer','Fujitsu','2012-07-30 22:55:32'),(36,'admin',1,'StoreProduct','Fujitsu LIFEBOOK AH531','2012-07-30 22:55:32'),(37,'admin',1,'StoreManufacturer','HP','2012-07-30 22:55:32'),(38,'admin',1,'StoreProduct','HP EliteBook 8560w','2012-07-30 22:55:32'),(39,'admin',1,'StoreProduct','DELL ALIENWARE M17x','2012-07-30 22:55:32'),(40,'admin',1,'StoreManufacturer','Apple','2012-07-30 22:55:32'),(41,'admin',1,'StoreProduct','Apple MacBook Pro 15 Late 2011','2012-07-30 22:55:33'),(42,'admin',1,'StoreProduct','Lenovo THINKPAD W520','2012-07-30 22:55:33'),(43,'admin',1,'StoreManufacturer','Sony','2012-07-30 22:55:33'),(44,'admin',1,'StoreProduct','Sony VAIO VPC-F13S8R','2012-07-30 22:55:33'),(45,'admin',1,'StoreManufacturer','Acer','2012-07-30 22:55:33'),(46,'admin',1,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2012-07-30 22:55:33'),(47,'admin',2,'Discount','Скидка на всю технику Apple','2012-07-31 21:19:32'),(48,'admin',2,'Discount','Скидка на всю технику Apple','2012-07-31 21:20:01'),(49,'admin',2,'User','admin','2012-08-01 23:06:14'),(50,'admin',2,'User','admin','2012-08-01 23:15:22'),(51,'admin',1,'User','tester','2012-08-01 23:16:49'),(52,'admin',3,'User','tester','2012-08-01 23:17:24'),(53,'admin',1,'User','admin222','2012-08-01 23:18:34'),(54,'admin',3,'User','admin222','2012-08-01 23:18:50'),(55,'admin',3,'User','user1','2012-08-01 23:20:25'),(56,'admin',1,'Order','','2012-08-04 21:17:15'),(57,'admin',2,'Order','72','2012-08-04 21:17:22'),(58,'admin',2,'Order','72','2012-08-04 21:17:25'),(59,'admin',3,'Order','72','2012-08-17 00:22:25'),(60,'admin',3,'Order','71','2012-08-17 00:22:25'),(61,'admin',3,'Order','69','2012-08-17 00:22:25'),(62,'admin',3,'Order','70','2012-08-17 00:22:25'),(63,'admin',1,'StoreAttribute','textbox','2012-10-16 20:19:40'),(64,'admin',2,'StoreProductType','laptop','2012-10-16 20:20:09'),(65,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011','2012-10-16 20:20:48'),(66,'admin',2,'StoreAttribute','textbox','2012-10-16 20:22:04'),(67,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 sjdklfjskldfjk dslkj klsdjf klsfj klsdfj klsf klsjf klsjfkl sjfklsjfkl sjfkl sjflk sfj klsfj klsjf lksjf lskfj lsjdf ','2012-10-27 23:14:37'),(68,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2012-10-27 23:20:56'),(69,'admin',2,'StorePaymentMethod','Безналичная','2012-11-10 21:33:31'),(70,'admin',2,'StorePaymentMethod','Безналичная','2012-11-10 21:33:40'),(71,'admin',1,'StorePaymentMethod','Qiwi','2012-11-10 22:37:18'),(72,'admin',2,'StoreDeliveryMethod','Курьером','2012-11-10 22:37:56'),(73,'admin',1,'SystemModules','notifier','2012-11-17 21:16:33'),(74,'admin',2,'Order','73','2012-11-17 21:41:34'),(75,'admin',2,'StoreProduct','DELL INSPIRON N5050','2012-11-17 21:47:53'),(76,'admin',2,'StoreProduct','DELL ALIENWARE M17x','2012-11-17 21:47:53'),(77,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2012-11-17 21:47:53'),(78,'admin',2,'StoreProduct','Simple product test','2012-11-17 21:48:00'),(79,'admin',2,'StoreProduct','Lenovo B570','2012-11-17 21:48:00'),(80,'admin',2,'StoreProduct','Lenovo G570','2012-11-17 21:48:00'),(81,'admin',2,'StoreProduct','ASUS K53U','2012-11-17 21:48:00'),(82,'admin',2,'StoreProduct','ASUS X54C','2012-11-17 21:48:00'),(83,'admin',2,'StoreProduct','DELL INSPIRON N5050','2012-11-17 21:48:00'),(84,'admin',2,'StoreProduct','Fujitsu LIFEBOOK AH531','2012-11-17 21:48:00'),(85,'admin',2,'StoreProduct','HP EliteBook 8560w','2012-11-17 21:48:00'),(86,'admin',2,'StoreProduct','DELL ALIENWARE M17x','2012-11-17 21:48:00'),(87,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2012-11-17 21:48:00'),(88,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2012-11-17 21:48:00'),(89,'admin',2,'StoreProduct','Sony VAIO VPC-F13S8R','2012-11-17 21:48:00'),(90,'admin',2,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2012-11-17 21:48:00'),(91,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2012-11-19 21:05:00'),(92,'admin',2,'Comment','this is test comment for test product','2013-02-13 16:25:29'),(93,'admin',2,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2013-02-13 16:38:32'),(94,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2013-02-13 17:51:42'),(95,'admin',2,'StoreCategory','Ноутбуки','2013-02-13 17:58:57'),(96,'admin',2,'StoreCategory','Ноутбуки','2013-02-13 17:59:02'),(97,'admin',2,'StoreCategory','Ноутбуки','2013-02-18 21:11:40'),(98,'admin',2,'StoreCategory','Бюджетный','2013-02-18 21:11:45'),(99,'admin',2,'StoreCategory','Ноутбуки','2013-02-18 21:14:54'),(100,'admin',2,'StoreManufacturer','Asus','2013-02-18 22:02:14'),(101,'admin',2,'StoreManufacturer','Asus','2013-02-18 22:09:02'),(102,'admin',2,'StoreManufacturer','Asus','2013-02-18 22:14:35'),(103,'admin',2,'StoreManufacturer','Asus','2013-02-18 22:14:40'),(104,'admin',2,'StoreManufacturer','Asus','2013-02-18 22:14:45'),(105,'admin',2,'StoreAttribute','screen','2013-02-19 21:41:47'),(106,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2013-02-19 21:43:35'),(107,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2013-02-19 21:56:43'),(108,'admin',1,'SystemModules','statistics','2013-02-21 20:51:32'),(109,'admin',2,'StoreProduct','DELL ALIENWARE M17x','2013-04-03 21:40:56'),(110,'admin',2,'StoreProduct','Fujitsu LIFEBOOK AH531','2013-04-03 21:41:18'),(111,'admin',2,'StoreProduct','DELL ALIENWARE M17x','2013-04-03 21:43:59'),(112,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:24:04'),(113,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:24:50'),(114,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:25:31'),(115,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:34:39'),(116,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:35:09'),(117,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:35:11'),(118,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:40:55'),(119,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:41:02'),(120,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:41:31'),(121,'admin',2,'StoreProduct','Simple product test','2013-04-06 23:41:50'),(122,'admin',2,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2013-04-07 13:59:15'),(123,'admin',1,'StoreProductType','Набор стандартных атрибутов','2013-04-08 21:26:13'),(124,'admin',1,'StoreManufacturer','ВолгаАвтоПром','2013-04-08 21:26:13'),(125,'admin',1,'StoreAttribute','vesbrutto','2013-04-08 21:26:13'),(126,'admin',1,'StoreAttribute','vesnetto','2013-04-08 21:26:13'),(127,'admin',1,'StoreAttribute','kolvovtranspupak','2013-04-08 21:26:13'),(128,'admin',1,'StoreAttribute','individualupak','2013-04-08 21:26:13'),(129,'admin',3,'StoreProduct','Apple MacBook Pro 15 Late 2011 ','2013-04-08 21:28:03'),(130,'admin',3,'StoreProduct','Lenovo THINKPAD W520','2013-04-08 21:28:06'),(131,'admin',3,'StoreProduct','Simple product test','2013-04-08 21:28:18'),(132,'admin',3,'StoreProduct','Sony VAIO VPC-F13S8R','2013-04-08 21:28:32'),(133,'admin',3,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2013-04-08 21:28:35'),(134,'admin',3,'StoreProduct','DELL INSPIRON N5050','2013-04-08 21:28:38'),(135,'admin',3,'StoreProduct','Fujitsu LIFEBOOK AH531','2013-04-08 21:28:42'),(136,'admin',3,'StoreProduct','HP EliteBook 8560w','2013-04-08 21:28:45'),(137,'admin',3,'StoreProduct','DELL ALIENWARE M17x','2013-04-08 21:28:48'),(138,'admin',3,'StoreProduct','Lenovo G570','2013-04-08 21:28:51'),(139,'admin',3,'StoreProduct','ASUS K53U','2013-04-08 21:28:54'),(140,'admin',3,'StoreProduct','ASUS X54C','2013-04-08 21:28:57'),(141,'admin',3,'StoreProduct','Lenovo B570','2013-04-08 21:29:00'),(142,'admin',3,'StoreProduct','dfgdfg','2013-04-08 21:29:03'),(143,'admin',1,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:32:23'),(144,'admin',1,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:32:23'),(145,'admin',1,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:32:23'),(146,'admin',1,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:32:23'),(147,'admin',3,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:35:08'),(148,'admin',3,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:35:10'),(149,'admin',3,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:35:12'),(150,'admin',3,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:35:15'),(151,'admin',1,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:35:20'),(152,'admin',1,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:35:20'),(153,'admin',1,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:35:20'),(154,'admin',1,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:35:20'),(155,'admin',2,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:39:10'),(156,'admin',2,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:39:10'),(157,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:39:10'),(158,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:39:10'),(159,'admin',2,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:39:18'),(160,'admin',2,'StoreProduct','Крестовина ВАЗ 2101','2013-04-08 21:39:18'),(161,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:39:18'),(162,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-08 21:39:18'),(163,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:35:13'),(164,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:35:17'),(165,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:40:56'),(166,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:40:58'),(167,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:41:00'),(168,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:46:48'),(169,'admin',2,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:46:50'),(170,'admin',3,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:48:27'),(171,'admin',3,'StoreProduct','Крестовина ВАЗ 2105 (усиленный)','2013-04-11 23:48:42'),(172,'admin',3,'StoreProduct','Крестовина ВАЗ 2101','2013-04-11 23:48:50'),(173,'admin',2,'StoreProduct','Крестовина ВАЗ 2101','2013-04-11 23:48:54'),(174,'admin',2,'StoreProduct','Крестовина ВАЗ 2101','2013-04-11 23:48:57'),(175,'admin',3,'OrderStatus','Доставлен','2013-04-13 00:54:12'),(176,'admin',3,'OrderStatus','Отменен','2013-04-13 00:54:15'),(177,'admin',1,'StoreProduct','Lenovo B570','2013-04-13 00:58:36'),(178,'admin',1,'StoreProduct','Lenovo G570','2013-04-13 00:58:36'),(179,'admin',1,'StoreProduct','ASUS K53U','2013-04-13 00:58:36'),(180,'admin',1,'StoreProduct','ASUS X54C','2013-04-13 00:58:36'),(181,'admin',1,'StoreProduct','DELL INSPIRON N5050','2013-04-13 00:58:36'),(182,'admin',1,'StoreProduct','Fujitsu LIFEBOOK AH531','2013-04-13 00:58:36'),(183,'admin',1,'StoreProduct','HP EliteBook 8560w','2013-04-13 00:58:36'),(184,'admin',1,'StoreProduct','DELL ALIENWARE M17x','2013-04-13 00:58:36'),(185,'admin',1,'StoreProduct','Apple MacBook Pro 15 Late 2011','2013-04-13 00:58:37'),(186,'admin',1,'StoreProduct','Lenovo THINKPAD W520','2013-04-13 00:58:37'),(187,'admin',1,'StoreProduct','Sony VAIO VPC-F13S8R','2013-04-13 00:58:37'),(188,'admin',1,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2013-04-13 00:58:37'),(189,'admin',2,'Comment','this is test comment','2013-04-13 01:00:36'),(190,'admin',2,'Comment','this is test comment','2013-04-13 01:01:08'),(191,'admin',2,'Comment','this is test comment','2013-04-13 01:01:12'),(192,'admin',2,'Comment','this is test comment','2013-04-13 01:01:30'),(193,'admin',2,'Comment','this is test comment','2013-04-13 01:01:31'),(194,'admin',2,'Comment','this is test comment','2013-04-13 01:01:35'),(195,'admin',2,'Comment','this is test comment','2013-04-13 01:08:46'),(196,'admin',2,'Comment','this is test comment','2013-04-13 01:08:48'),(197,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011','2013-04-13 01:23:20'),(198,'admin',2,'Comment','this is test comment','2013-04-13 12:39:12'),(199,'admin',2,'StorePaymentMethod','WebMoney','2013-04-17 23:48:58'),(200,'admin',2,'StorePaymentMethod','WebMoney','2013-04-17 23:49:58'),(201,'admin',2,'StorePaymentMethod','WebMoney','2013-04-17 23:54:00'),(202,'admin',2,'StorePaymentMethod','WebMoney','2013-04-17 23:54:30'),(203,'admin',2,'StorePaymentMethod','WebMoney','2013-04-17 23:56:51'),(204,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:04:06'),(205,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:05:03'),(206,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:05:45'),(207,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:06:42'),(208,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:06:56'),(209,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:08:29'),(210,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:08:34'),(211,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:08:40'),(212,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:12:27'),(213,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:31:17'),(214,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:31:53'),(215,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-20 23:32:11'),(216,'admin',2,'User','admin','2013-04-20 23:52:52'),(217,'admin',2,'User','admin','2013-04-20 23:57:47'),(218,'admin',2,'User','admin','2013-04-20 23:59:56'),(219,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-21 00:00:11'),(220,'admin',2,'Discount','Скидка на всю технику Apple','2013-04-21 00:00:16'),(221,'admin',2,'StoreProduct','Lenovo G570','2013-04-21 09:58:21'),(222,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2013-04-21 09:59:50'),(223,'admin',1,'SystemModules','sitemap','2013-04-21 11:24:21'),(224,'admin',2,'User','admin','2013-04-21 12:04:44'),(225,'admin',2,'StorePaymentMethod','WebMoney','2013-04-21 12:51:22'),(226,'admin',2,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2013-04-21 13:01:09'),(227,'admin',2,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2013-04-21 13:01:23'),(228,'admin',2,'StoreProduct','Acer ASPIRE 5943G-7748G75TWiss','2013-04-21 13:03:52'),(229,'admin',2,'Order','78','2013-04-27 13:51:55'),(230,'admin',2,'Order','78','2013-04-27 13:51:56'),(231,'admin',2,'Order','78','2013-04-27 13:51:57'),(232,'admin',2,'User','admin','2013-04-27 15:16:20'),(233,'admin',2,'User','admin','2013-04-27 15:16:31'),(234,'admin',1,'StoreCategory','Ассортимент','2013-04-27 22:39:47'),(235,'admin',1,'StoreProductType','Напильник','2013-04-27 22:39:47'),(236,'admin',1,'StoreAttribute','additional_type','2013-04-27 22:39:47'),(237,'admin',1,'StoreProduct','Продукт 1','2013-04-27 22:39:47'),(238,'admin',1,'StoreCategory','Категория 1','2013-04-27 22:39:47'),(239,'admin',1,'StoreProductType','Насос','2013-04-27 22:39:47'),(240,'admin',1,'StoreProduct','Продукт 2','2013-04-27 22:39:47'),(241,'admin',2,'StoreProduct','Sony VAIO VPC-F13S8R','2013-04-29 22:08:36'),(242,'admin',2,'StoreProduct','Sony VAIO VPC-F13S8R','2013-04-29 22:15:23'),(243,'admin',2,'StoreProduct','Sony VAIO VPC-F13S8R','2013-04-29 22:15:58'),(244,'admin',2,'StoreDeliveryMethod','Курьером','2013-04-29 22:19:10'),(245,'admin',3,'Order','73','2013-04-29 22:20:14'),(246,'admin',3,'Order','74','2013-04-29 22:20:14'),(247,'admin',3,'Order','75','2013-04-29 22:20:14'),(248,'admin',3,'Order','76','2013-04-29 22:20:14'),(249,'admin',3,'Order','77','2013-04-29 22:20:14'),(250,'admin',3,'Order','78','2013-04-29 22:20:14'),(251,'admin',3,'Order','79','2013-04-29 22:20:14'),(252,'admin',2,'Order','80','2013-04-29 22:20:34'),(253,'admin',3,'Order','80','2013-04-29 22:21:05'),(254,'admin',2,'StoreDeliveryMethod','Курьером','2013-04-29 22:24:44'),(255,'admin',2,'StoreDeliveryMethod','Курьером','2013-04-29 22:25:32'),(256,'admin',2,'PageCategory','Новости','2013-04-29 22:45:32'),(257,'admin',2,'PageCategory','Новости','2013-04-29 22:45:32'),(258,'admin',2,'PageCategory','Новости','2013-04-29 23:18:02'),(259,'admin',2,'PageCategory','Новости','2013-04-29 23:18:02'),(260,'admin',2,'PageCategory','Новости','2013-04-29 23:18:10'),(261,'admin',2,'PageCategory','Новости','2013-04-29 23:18:10'),(262,'admin',2,'PageCategory','Новости','2013-04-29 23:19:32'),(263,'admin',2,'PageCategory','Новости','2013-04-29 23:19:32'),(264,'admin',2,'PageCategory','Новости','2013-04-29 23:22:46'),(265,'admin',2,'PageCategory','Новости','2013-04-29 23:22:46'),(266,'admin',2,'PageCategory','Новости','2013-04-29 23:24:05'),(267,'admin',2,'PageCategory','Новости','2013-04-29 23:24:05'),(268,'admin',2,'Order','81','2013-05-04 20:03:10'),(269,'admin',2,'Order','81','2013-05-04 20:03:17'),(270,'admin',2,'Order','81','2013-05-04 20:07:48'),(271,'admin',2,'Order','81','2013-05-04 20:08:53'),(272,'admin',2,'Order','81','2013-05-04 20:09:48'),(273,'admin',2,'Order','81','2013-05-04 20:10:00'),(274,'admin',2,'Order','81','2013-05-04 20:35:32'),(275,'admin',2,'Order','81','2013-05-04 20:35:33'),(276,'admin',2,'Order','81','2013-05-04 20:35:34'),(277,'admin',2,'Order','81','2013-05-04 20:49:00'),(278,'admin',2,'Order','81','2013-05-04 20:49:00'),(279,'admin',2,'Order','81','2013-05-04 20:49:00'),(280,'admin',2,'Order','81','2013-05-04 20:49:00'),(281,'admin',2,'Order','81','2013-05-04 20:49:00'),(282,'admin',2,'Order','81','2013-05-04 20:49:07'),(283,'admin',2,'Order','81','2013-05-04 20:49:07'),(284,'admin',2,'Order','81','2013-05-04 20:49:07'),(285,'admin',2,'Order','81','2013-05-04 20:49:07'),(286,'admin',2,'Order','81','2013-05-04 20:49:07'),(287,'admin',2,'Order','81','2013-05-04 20:49:14'),(288,'admin',2,'Order','81','2013-05-04 20:49:14'),(289,'admin',2,'Order','81','2013-05-04 20:49:14'),(290,'admin',2,'Order','81','2013-05-04 20:49:14'),(291,'admin',2,'Order','81','2013-05-04 20:49:14'),(292,'admin',2,'Order','81','2013-05-04 20:49:58'),(293,'admin',2,'Order','81','2013-05-04 20:49:58'),(294,'admin',2,'Order','81','2013-05-04 20:49:58'),(295,'admin',2,'Order','81','2013-05-04 20:49:58'),(296,'admin',2,'Order','81','2013-05-04 20:49:58'),(297,'admin',2,'Order','81','2013-05-04 20:51:27'),(298,'admin',2,'Order','81','2013-05-04 20:51:27'),(299,'admin',2,'Order','81','2013-05-04 20:51:27'),(300,'admin',2,'Order','81','2013-05-04 20:51:27'),(301,'admin',2,'Order','81','2013-05-04 20:51:27'),(302,'admin',2,'Order','81','2013-05-04 20:51:32'),(303,'admin',2,'Order','81','2013-05-04 20:51:32'),(304,'admin',2,'Order','81','2013-05-04 20:51:32'),(305,'admin',2,'Order','81','2013-05-04 20:51:32'),(306,'admin',2,'Order','81','2013-05-04 20:51:32'),(307,'admin',2,'Order','81','2013-05-04 20:51:40'),(308,'admin',2,'Order','81','2013-05-04 20:51:40'),(309,'admin',2,'Order','81','2013-05-04 20:51:40'),(310,'admin',2,'Order','81','2013-05-04 20:51:40'),(311,'admin',2,'Order','81','2013-05-04 20:51:40'),(312,'admin',2,'Order','81','2013-05-04 20:51:44'),(313,'admin',2,'Order','81','2013-05-04 20:51:52'),(314,'admin',2,'Order','81','2013-05-04 20:51:52'),(315,'admin',2,'Order','81','2013-05-04 20:51:53'),(316,'admin',2,'Order','81','2013-05-04 20:51:53'),(317,'admin',2,'Order','81','2013-05-04 20:52:05'),(318,'admin',2,'Order','81','2013-05-04 20:52:05'),(319,'admin',2,'Order','81','2013-05-04 20:52:05'),(320,'admin',2,'Order','81','2013-05-04 20:52:05'),(321,'admin',2,'Order','81','2013-05-04 20:52:10'),(322,'admin',2,'Order','81','2013-05-04 20:52:10'),(323,'admin',2,'Order','81','2013-05-04 20:52:10'),(324,'admin',2,'Order','81','2013-05-04 20:52:10'),(325,'admin',2,'Order','81','2013-05-04 20:53:57'),(326,'admin',2,'Order','81','2013-05-04 20:54:03'),(327,'admin',2,'Order','81','2013-05-04 20:54:03'),(328,'admin',2,'Order','81','2013-05-04 20:54:03'),(329,'admin',2,'Order','81','2013-05-04 20:54:03'),(330,'admin',2,'Order','81','2013-05-04 20:55:23'),(331,'admin',2,'Order','81','2013-05-04 20:55:23'),(332,'admin',2,'Order','81','2013-05-04 20:55:23'),(333,'admin',2,'Order','81','2013-05-04 20:55:23'),(334,'admin',2,'Order','81','2013-05-04 20:55:28'),(335,'admin',2,'Order','81','2013-05-04 20:55:34'),(336,'admin',2,'Order','81','2013-05-04 20:55:34'),(337,'admin',2,'Order','81','2013-05-04 20:55:34'),(338,'admin',2,'Order','81','2013-05-04 20:55:40'),(339,'admin',2,'Order','81','2013-05-04 20:55:40'),(340,'admin',2,'Order','81','2013-05-04 20:55:40'),(341,'admin',2,'Order','81','2013-05-04 20:55:46'),(342,'admin',2,'Order','81','2013-05-04 20:55:46'),(343,'admin',2,'Order','81','2013-05-04 20:55:46'),(344,'admin',2,'Order','81','2013-05-04 20:55:58'),(345,'admin',2,'Order','81','2013-05-04 20:55:58'),(346,'admin',2,'Order','81','2013-05-04 20:55:58'),(347,'admin',2,'Order','81','2013-05-04 20:56:08'),(348,'admin',2,'Order','81','2013-05-04 20:56:08'),(349,'admin',2,'Order','81','2013-05-04 20:56:08'),(350,'admin',2,'Order','81','2013-05-04 20:58:03'),(351,'admin',2,'Order','81','2013-05-04 20:58:09'),(352,'admin',2,'Order','81','2013-05-04 20:58:12'),(353,'admin',2,'Order','81','2013-05-04 20:58:27'),(354,'admin',2,'Order','81','2013-05-04 20:58:27'),(355,'admin',2,'Order','81','2013-05-04 21:01:51'),(356,'admin',2,'Order','81','2013-05-04 21:01:52'),(357,'admin',2,'Order','81','2013-05-04 21:01:53'),(358,'admin',2,'Order','81','2013-05-04 21:01:53'),(359,'admin',2,'Order','81','2013-05-04 21:05:58'),(360,'admin',2,'Order','81','2013-05-04 21:06:01'),(361,'admin',2,'Order','81','2013-05-04 21:06:04'),(362,'admin',2,'Order','81','2013-05-04 21:06:06'),(363,'admin',2,'Order','81','2013-05-04 21:06:09'),(364,'admin',2,'Order','81','2013-05-04 21:06:09'),(365,'admin',2,'Order','81','2013-05-04 21:06:47'),(366,'admin',2,'Order','81','2013-05-04 21:06:50'),(367,'admin',2,'Order','81','2013-05-04 21:06:50'),(368,'admin',2,'Order','81','2013-05-04 21:06:50'),(369,'admin',2,'Order','81','2013-05-04 21:06:57'),(370,'admin',2,'Order','81','2013-05-04 21:06:57'),(371,'admin',2,'Order','81','2013-05-04 21:06:57'),(372,'admin',2,'Order','81','2013-05-04 21:07:02'),(373,'admin',2,'Order','81','2013-05-04 21:07:03'),(374,'admin',2,'Order','81','2013-05-04 21:07:03'),(375,'admin',2,'Order','81','2013-05-04 21:07:04'),(376,'admin',2,'Order','81','2013-05-04 21:07:04'),(377,'admin',2,'Order','81','2013-05-04 21:07:06'),(378,'admin',2,'Order','81','2013-05-04 21:07:06'),(379,'admin',2,'Order','81','2013-05-04 21:07:12'),(380,'admin',2,'Order','81','2013-05-04 21:07:16'),(381,'admin',2,'Order','81','2013-05-04 21:07:18'),(382,'admin',2,'Order','81','2013-05-04 21:07:22'),(383,'admin',2,'Order','81','2013-05-04 21:07:24'),(384,'admin',2,'Order','81','2013-05-04 21:07:28'),(385,'admin',2,'Order','81','2013-05-04 21:07:32'),(386,'admin',2,'Order','81','2013-05-04 21:07:34'),(387,'admin',2,'Order','81','2013-05-04 21:07:36'),(388,'admin',2,'Order','81','2013-05-04 21:07:41'),(389,'admin',2,'Order','81','2013-05-04 21:07:48'),(390,'admin',2,'Order','81','2013-05-04 21:07:48'),(391,'admin',2,'Order','81','2013-05-04 21:09:12'),(392,'admin',2,'Order','81','2013-05-04 21:09:17'),(393,'admin',2,'Order','81','2013-05-04 21:09:23'),(394,'admin',2,'Order','81','2013-05-04 21:09:26'),(395,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011','2013-05-04 21:40:33'),(396,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011','2013-05-04 21:47:09'),(397,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011','2013-05-04 21:47:19'),(398,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011','2013-05-04 21:48:18'),(399,'admin',2,'StoreProduct','Apple MacBook Pro 15 Late 2011','2013-05-04 21:48:33'),(400,'admin',2,'StoreProduct','Продукт 2','2013-05-04 21:49:52'),(401,'admin',2,'Order','81','2013-05-05 00:48:48'),(402,'admin',2,'Order','81','2013-05-05 00:48:48'),(403,'admin',2,'Order','81','2013-05-05 00:48:58'),(404,'admin',2,'Order','81','2013-05-05 00:48:58'),(405,'admin',2,'Order','81','2013-05-05 00:49:04'),(406,'admin',2,'Order','81','2013-05-05 00:49:04'),(407,'admin',1,'SystemModules','programm','2013-05-06 15:19:39'),(408,'admin',2,'User','tester2','2013-05-07 13:38:49'),(409,'admin',2,'User','tester2','2013-05-07 13:39:06'),(410,'admin',1,'Order','','2013-05-07 14:22:53'),(411,'admin',2,'Order','82','2013-05-07 14:23:05'),(412,'admin',2,'Order','82','2013-05-07 14:23:07'),(413,'admin',2,'Order','82','2013-05-07 14:23:21'),(414,'admin',2,'Order','82','2013-05-07 14:23:21'),(415,'admin',2,'Order','82','2013-05-07 14:23:21'),(416,'admin',3,'Order','82','2013-05-07 14:30:54'),(417,'admin',2,'Comment','sony test comment','2013-05-07 19:25:24'),(418,'admin',1,'Discount','Скидка на всю технику Apple 2','2013-05-14 22:22:48'),(419,'admin',2,'StoreDeliveryMethod','Самовывоз','2013-05-14 23:12:03'),(420,'admin',2,'StoreDeliveryMethod','Самовывоз','2013-05-14 23:16:05'),(421,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2013-05-20 23:22:39'),(422,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2013-05-20 23:23:36'),(423,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2013-05-20 23:25:27'),(424,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2013-05-20 23:26:20'),(425,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2013-05-20 23:29:37'),(426,'admin',2,'StoreProduct','Lenovo THINKPAD W520','2013-05-20 23:30:21'),(427,'admin',2,'StoreProduct','Продукт 1','2013-05-20 23:46:55'),(428,'admin',3,'Order','81','2013-05-21 00:21:30'),(429,'admin',1,'PageCategory','Тесстовя','2013-05-21 23:52:33'),(430,'admin',2,'PageCategory','Новости','2013-05-21 23:52:33'),(431,'admin',1,'StoreProduct','test','2013-05-21 23:55:52'),(432,'admin',1,'PageCategory','Тесстовя2','2013-05-21 23:57:27'),(433,'admin',2,'PageCategory','Новости','2013-05-21 23:57:27'),(434,'admin',1,'PageCategory','Тесстовя2','2013-05-21 23:59:34'),(435,'admin',2,'PageCategory','Новости','2013-05-21 23:59:34'),(436,'admin',1,'PageCategory','sdfsdf','2013-05-22 00:02:45'),(437,'admin',2,'PageCategory','Новости','2013-05-22 00:02:45'),(438,'admin',2,'PageCategory','sdfsdf','2013-05-22 00:02:45'),(439,'admin',1,'PageCategory','Тесстовя2','2013-05-22 00:07:01'),(440,'admin',2,'PageCategory','Новости','2013-05-22 00:07:01'),(441,'admin',2,'PageCategory','Тесстовя2','2013-05-22 00:07:01');
/*!40000 ALTER TABLE `ActionLog` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `AuthAssignment`
--

LOCK TABLES `AuthAssignment` WRITE;
/*!40000 ALTER TABLE `AuthAssignment` DISABLE KEYS */;
INSERT INTO `AuthAssignment` VALUES ('Admin','1',NULL,NULL),('Authenticated','57',NULL,'N;'),('Authenticated','58',NULL,'N;'),('Orders.Orders.*','56',NULL,'N;'),('Orders.Statuses.*','56',NULL,'N;'),('Authenticated','56',NULL,'N;');
/*!40000 ALTER TABLE `AuthAssignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `AuthItem`
--

LOCK TABLES `AuthItem` WRITE;
/*!40000 ALTER TABLE `AuthItem` DISABLE KEYS */;
INSERT INTO `AuthItem` VALUES ('Admin',2,NULL,NULL,'N;'),('Authenticated',2,NULL,NULL,'N;'),('Guest',2,NULL,NULL,'N;'),('Orders.Orders.*',1,NULL,NULL,'N;'),('Orders.Statuses.*',1,NULL,NULL,'N;'),('Orders.Orders.Index',0,NULL,NULL,'N;'),('Orders.Orders.Create',0,NULL,NULL,'N;'),('Orders.Orders.Update',0,NULL,NULL,'N;'),('Orders.Orders.AddProductList',0,NULL,NULL,'N;'),('Orders.Orders.AddProduct',0,NULL,NULL,'N;'),('Orders.Orders.RenderOrderedProducts',0,NULL,NULL,'N;'),('Orders.Orders.JsonOrderedProducts',0,NULL,NULL,'N;'),('Orders.Orders.Delete',0,NULL,NULL,'N;'),('Orders.Orders.DeleteProduct',0,NULL,NULL,'N;'),('Orders.Statuses.Index',0,NULL,NULL,'N;'),('Orders.Statuses.Create',0,NULL,NULL,'N;'),('Orders.Statuses.Update',0,NULL,NULL,'N;'),('Orders.Statuses.Delete',0,NULL,NULL,'N;');
/*!40000 ALTER TABLE `AuthItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `AuthItemChild`
--

LOCK TABLES `AuthItemChild` WRITE;
/*!40000 ALTER TABLE `AuthItemChild` DISABLE KEYS */;
/*!40000 ALTER TABLE `AuthItemChild` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
INSERT INTO `Comments` VALUES (9,1,'application.modules.store.models.StoreProduct',32,1,'admin@localhost.loc','admin','this is test comment','2013-04-13 01:00:18','2013-04-13 12:39:12','127.0.0.1'),(10,1,'application.modules.store.models.StoreProduct',33,1,'admin@localhost.loc','admin','sony test comment','2013-05-06 14:03:50','2013-05-07 19:25:24','127.0.0.1');
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Discount`
--

LOCK TABLES `Discount` WRITE;
/*!40000 ALTER TABLE `Discount` DISABLE KEYS */;
INSERT INTO `Discount` VALUES (3,'Скидка на всю технику Apple',1,'5%','2012-07-01 13:03:20','2013-07-01 13:03:20','[\"Authenticated\"]');
/*!40000 ALTER TABLE `Discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `DiscountCategory`
--

LOCK TABLES `DiscountCategory` WRITE;
/*!40000 ALTER TABLE `DiscountCategory` DISABLE KEYS */;
INSERT INTO `DiscountCategory` VALUES (191,3,218),(190,3,217),(189,3,219),(188,3,216),(187,3,215),(186,3,214),(185,3,213),(184,3,212),(183,3,1);
/*!40000 ALTER TABLE `DiscountCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `DiscountManufacturer`
--

LOCK TABLES `DiscountManufacturer` WRITE;
/*!40000 ALTER TABLE `DiscountManufacturer` DISABLE KEYS */;
INSERT INTO `DiscountManufacturer` VALUES (15,3,6);
/*!40000 ALTER TABLE `DiscountManufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Order`
--

LOCK TABLES `Order` WRITE;
/*!40000 ALTER TABLE `Order` DISABLE KEYS */;
/*!40000 ALTER TABLE `Order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `OrderProduct`
--

LOCK TABLES `OrderProduct` WRITE;
/*!40000 ALTER TABLE `OrderProduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `OrderProduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `OrderStatus`
--

LOCK TABLES `OrderStatus` WRITE;
/*!40000 ALTER TABLE `OrderStatus` DISABLE KEYS */;
INSERT INTO `OrderStatus` VALUES (1,'Новый',0);
/*!40000 ALTER TABLE `OrderStatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Page`
--

LOCK TABLES `Page` WRITE;
/*!40000 ALTER TABLE `Page` DISABLE KEYS */;
INSERT INTO `Page` VALUES (8,1,NULL,'help','2012-06-10 22:35:51','2012-07-07 11:47:09','2012-06-10 22:35:29','published','',''),(9,1,NULL,'how-to-create-order','2012-06-10 22:36:50','2012-07-07 11:45:53','2012-06-10 22:36:27','published','',''),(10,1,NULL,'garantiya','2012-06-10 22:37:06','2012-07-07 11:45:38','2012-06-10 22:36:50','published','',''),(11,1,NULL,'dostavka-i-oplata','2012-06-10 22:37:18','2012-07-07 11:41:49','2012-06-10 22:37:07','published','',''),(12,1,7,'samsung-pitaetsya-izbezhat-zapreta-na-galaxy-nexus-v-shtatah-pri-pomoshi-patcha','2012-07-07 12:08:50','2012-07-07 12:09:33','2012-07-07 12:06:19','published','',''),(13,1,7,'za-85-mesyacev-android-40-popal-na-11-ustroistv','2012-07-07 12:19:44','2012-07-07 12:33:48','2012-07-07 12:14:48','published','',''),(14,1,7,'google-prezentoval-svoi-ochki-dopolnennoi-realnosti','2012-07-07 12:26:11','2012-07-07 12:26:11','2012-07-07 12:25:48','published','','');
/*!40000 ALTER TABLE `Page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `PageCategory`
--

LOCK TABLES `PageCategory` WRITE;
/*!40000 ALTER TABLE `PageCategory` DISABLE KEYS */;
INSERT INTO `PageCategory` VALUES (7,NULL,'news','news','','','2012-07-07 12:06:03','2013-04-29 23:24:05',NULL),(10,NULL,'tesstovya2','tesstovya2','','','2013-05-21 23:59:34','2013-05-21 23:59:34',NULL),(12,7,'tesstovya2','news/tesstovya2','','','2013-05-22 00:07:01','2013-05-22 00:07:01',NULL);
/*!40000 ALTER TABLE `PageCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `PageCategoryTranslate`
--

LOCK TABLES `PageCategoryTranslate` WRITE;
/*!40000 ALTER TABLE `PageCategoryTranslate` DISABLE KEYS */;
INSERT INTO `PageCategoryTranslate` VALUES (13,7,1,'Новости','','','',''),(14,7,9,'Новости','','','',''),(15,11,1,'sdfsdf','','','',''),(16,11,9,'sdfsdf','','','',''),(17,12,1,'Тесстовя2','','','',''),(18,12,9,'Тесстовя2','','','','');
/*!40000 ALTER TABLE `PageCategoryTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `PageTranslate`
--

LOCK TABLES `PageTranslate` WRITE;
/*!40000 ALTER TABLE `PageTranslate` DISABLE KEYS */;
INSERT INTO `PageTranslate` VALUES (22,11,9,'Доставка и оплата','','','','',''),(15,8,1,'Помощь','Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации \"Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..\" Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам \"lorem ipsum\" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).','','','',''),(16,8,9,'Помощь','','','','',''),(17,9,1,'Как сделать заказ','<p>Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь. Если вам нужен Lorem Ipsum для серьёзного проекта, вы наверняка не хотите какой-нибудь шутки, скрытой в середине абзаца. Также все другие известные генераторы Lorem Ipsum используют один и тот же текст, который они просто повторяют, пока не достигнут нужный объём. Это делает предлагаемый здесь генератор единственным настоящим Lorem Ipsum генератором. Он использует словарь из более чем 200 латинских слов, а также набор моделей предложений. В результате сгенерированный Lorem Ipsum выглядит правдоподобно, не имеет повторяющихся абзацей или \"невозможных\" слов.</p>','','','',''),(18,9,9,'Как сделать заказ','','','','',''),(19,10,1,'Гарантия','<p>Многие думают, что Lorem Ipsum - взятый с потолка псевдо-латинский набор слов, но это не совсем так. Его корни уходят в один фрагмент классической латыни 45 года н.э., то есть более двух тысячелетий назад. Ричард МакКлинток, профессор латыни из колледжа Hampden-Sydney, штат Вирджиния, взял одно из самых странных слов в Lorem Ipsum, \"consectetur\", и занялся его поисками в классической латинской литературе.</p>\r\n<p>В результате он нашёл неоспоримый первоисточник Lorem Ipsum в разделах 1.10.32 и 1.10.33 книги \"de Finibus Bonorum et Malorum\" (\"О пределах добра и зла\"), написанной Цицероном в 45 году н.э. Этот трактат по теории этики был очень популярен в эпоху Возрождения. Первая строка Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", происходит от одной из строк в разделе 1.10.32 Классический текст Lorem Ipsum, используемый с XVI века, приведён ниже. Также даны разделы 1.10.32 и 1.10.33 \"de Finibus Bonorum et Malorum\" Цицерона и их английский перевод, сделанный H. Rackham, 1914 год.</p>','','','',''),(20,10,9,'Гарантия','','','','',''),(21,11,1,'Доставка и оплата','<p>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации \"Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..\" Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам \"lorem ipsum\" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).</p>','','','',''),(23,12,1,'Samsung пытается избежать запрета на Galaxy Nexus','Текущую ситуацию с судебным противостоянием Apple и Samsung в Штатах (ссылка по теме) можно описать строчкой их двух слов: всё плохо. ','В смысле всё плохо для Samsung — южнокорейская корпорация так и не сумела отбиться от назначенного судом предварительного запрета на американские продажи планшетников Galaxy Tab 10.1 и, главное, новейших смартфонов Galaxy Nexus. Расклад намечается хуже некуда: по некоторым выкладкам, потенциальный ущерб от подобного запрета может достигнуть 180 млн. долларов, две трети из которых придутся на непроданные Galaxy Nexus.','','',''),(25,13,1,'За 8,5 месяцев Android 4.0 попал на 11% устройств','В свое время платформа Android 2.x распространялась активнее, чем Android 4.0 Ice Cream Sandwich, а ведь уже появилась новая мобильная ОС от Google — Android 4.1 Jelly Bean. За 8,5 месяцев своего существования Android ICS попал на 10,9% устройств, а лидировать на рынке продолжает Android 2,3 Gingerbread.','','','',''),(24,12,9,'Samsung пытается избежать запрета на Galaxy Nexus в Штатах при помощи патча','Текущую ситуацию с судебным противостоянием Apple и Samsung в Штатах (ссылка по теме) можно описать строчкой их двух слов: всё плохо. В смысле всё плохо для Samsung — южнокорейская корпорация так и не сумела отбиться от назначенного судом предварительного запрета на американские продажи планшетников Galaxy Tab 10.1 и, главное, новейших смартфонов Galaxy Nexus. Расклад намечается хуже некуда: по некоторым выкладкам, потенциальный ущерб от подобного запрета может достигнуть 180 млн. долларов, две трети из которых придутся на непроданные Galaxy Nexus.','','','',''),(26,13,9,'За 8,5 месяцев Android 4.0 попал на 11% устройств','В свое время платформа Android 2.x распространялась активнее, чем Android 4.0 Ice Cream Sandwich, а ведь уже появилась новая мобильная ОС от Google — Android 4.1 Jelly Bean. За 8,5 месяцев своего существования Android ICS попал на 10,9% устройств, а лидировать на рынке продолжает Android 2,3 Gingerbread.','','','',''),(27,14,1,'Google презентовал свои очки дополненной реальности‎','Компания Google приступит к продаже очков дополненной реальности, который разрабатываются в рамках проекта Google Project Glass, пишет блог All Things Digital. ','Очки будут стоить 1,5 тысячи долларов, и поставки стартуют в начале 2013 года. Устройство, однако, будет предназначено только для разработчиков. Оформить предварительный заказ на него смогут исключительно посетители конференции I/O, открывшейся 27 июня в Сан-Франциско. ','','',''),(28,14,9,'Google презентовал свои очки дополненной реальности‎','Компания Google приступит к продаже очков дополненной реальности, который разрабатываются в рамках проекта Google Project Glass, пишет блог All Things Digital. ','Очки будут стоить 1,5 тысячи долларов, и поставки стартуют в начале 2013 года. Устройство, однако, будет предназначено только для разработчиков. Оформить предварительный заказ на него смогут исключительно посетители конференции I/O, открывшейся 27 июня в Сан-Франциско. ','','','');
/*!40000 ALTER TABLE `PageTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Rights`
--

LOCK TABLES `Rights` WRITE;
/*!40000 ALTER TABLE `Rights` DISABLE KEYS */;
/*!40000 ALTER TABLE `Rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreAttribute`
--

LOCK TABLES `StoreAttribute` WRITE;
/*!40000 ALTER TABLE `StoreAttribute` DISABLE KEYS */;
INSERT INTO `StoreAttribute` VALUES (1,'simple_product',3,1,1,1,0,0,0,0),(2,'color',3,1,1,1,0,0,1,0),(3,'processor_manufacturer',3,1,0,0,0,0,0,0),(4,'freq',3,1,0,0,0,0,0,0),(5,'memmory',3,1,0,0,0,0,0,0),(6,'memmory_type',3,1,0,0,0,0,0,0),(7,'screen',3,1,0,1,0,0,0,0),(8,'video',3,1,0,0,0,0,0,0),(9,'screen_dimension',3,1,0,0,0,0,0,0),(10,'textbox',1,1,1,0,1,0,0,0),(11,'vesbrutto',3,1,0,0,0,0,0,0),(12,'vesnetto',3,1,0,0,0,0,0,0),(13,'kolvovtranspupak',3,1,0,0,0,0,0,0),(14,'individualupak',3,1,0,0,0,0,0,0),(15,'additional_type',3,1,0,0,0,0,0,0);
/*!40000 ALTER TABLE `StoreAttribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreAttributeOption`
--

LOCK TABLES `StoreAttributeOption` WRITE;
/*!40000 ALTER TABLE `StoreAttributeOption` DISABLE KEYS */;
INSERT INTO `StoreAttributeOption` VALUES (1,1,0),(2,1,1),(3,1,2),(4,1,3),(5,2,1),(6,2,0),(7,2,2),(8,3,0),(9,4,0),(10,5,0),(11,6,0),(12,7,0),(13,8,0),(14,9,0),(15,3,0),(16,4,0),(17,4,0),(18,8,0),(19,4,0),(20,3,0),(21,4,0),(22,5,0),(23,8,0),(24,9,0),(25,4,0),(26,8,0),(27,9,0),(28,5,0),(29,7,1),(30,8,0),(31,3,0),(32,4,0),(33,7,2),(34,8,0),(35,4,0),(36,8,0),(37,7,0),(38,7,0),(39,7,0),(40,7,0),(41,5,0),(42,5,0),(43,5,0),(44,5,0),(45,5,0),(46,6,0),(47,6,0),(48,7,0),(49,7,0),(50,11,0),(51,12,0),(52,13,0),(53,14,0),(54,14,0),(55,11,0),(56,12,0),(57,15,0),(58,15,0);
/*!40000 ALTER TABLE `StoreAttributeOption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreAttributeOptionTranslate`
--

LOCK TABLES `StoreAttributeOptionTranslate` WRITE;
/*!40000 ALTER TABLE `StoreAttributeOptionTranslate` DISABLE KEYS */;
INSERT INTO `StoreAttributeOptionTranslate` VALUES (1,1,1,'s1'),(2,9,1,''),(3,1,2,'s2'),(4,9,2,''),(5,1,3,'s3'),(6,9,3,''),(7,1,4,'s4'),(8,9,4,''),(9,1,5,'red'),(10,9,5,''),(11,1,6,'green'),(12,9,6,''),(13,1,7,'blue'),(14,9,7,''),(15,1,8,'Celeron'),(16,9,8,'Celeron'),(17,1,9,'2200 МГц'),(18,9,9,'2200 МГц'),(19,1,10,'2048 Мб'),(20,9,10,'2048 Мб'),(21,1,11,'DDR3'),(22,9,11,'DDR3'),(23,1,12,'15.6 дюйм'),(24,9,12,'15.6 дюйм'),(25,1,13,'Intel GMA HD'),(26,9,13,'Intel GMA HD'),(27,1,14,'1366x768'),(28,9,14,'1366x768'),(29,1,15,'E-240'),(30,9,15,'E-240'),(31,1,16,'1650 МГц'),(32,9,16,'1650 МГц'),(33,1,17,'1500 МГц'),(34,9,17,'1500 МГц'),(35,1,18,'Intel HD Graphics 3000'),(36,9,18,'Intel HD Graphics 3000'),(37,1,19,'1700 МГц'),(38,9,19,'1700 МГц'),(39,1,20,'Core i7'),(40,9,20,'Core i7'),(41,1,21,'2500 МГц'),(42,9,21,'2500 МГц'),(43,1,22,'8192 Мб'),(44,9,22,'8192 Мб'),(45,1,23,'NVIDIA Quadro 2000M'),(46,9,23,'NVIDIA Quadro 2000M'),(47,1,24,'1920x1080'),(48,9,24,'1920x1080'),(49,1,25,'2700 МГц'),(50,9,25,'2700 МГц'),(51,1,26,'AMD Radeon HD 6990M'),(52,9,26,'AMD Radeon HD 6990M'),(53,1,27,'1920x1200'),(54,9,27,'1920x1200'),(55,1,28,'4096 Мб'),(56,9,28,'4096 Мб'),(57,1,29,'15.4 дюйм'),(58,9,29,'15.4 дюйм'),(59,1,30,'ATI Radeon HD 6770М'),(60,9,30,'ATI Radeon HD 6770М'),(61,1,31,'Core i5'),(62,9,31,'Core i5'),(63,1,32,'2660 МГц'),(64,9,32,'2660 МГц'),(65,1,33,'16.4 дюйм'),(66,9,33,'16.4 дюйм'),(67,1,34,'NVIDIA GeForce GT 425M'),(68,9,34,'NVIDIA GeForce GT 425M'),(69,1,35,'1730 МГц'),(70,9,35,'1730 МГц'),(71,1,36,'ATI Mobility Radeon HD 5850'),(72,9,36,'ATI Mobility Radeon HD 5850'),(73,1,37,'ololo'),(74,9,37,'ololo'),(75,1,38,'ыфв'),(76,9,38,'ыфв'),(77,1,39,'1111'),(78,9,39,'1111'),(79,1,40,'2222222'),(80,9,40,'2222222'),(81,1,41,'6046 Mb'),(82,9,41,'6046 Mb'),(83,1,42,'222'),(84,9,42,'222'),(85,1,43,'3'),(86,9,43,'3'),(87,1,44,'4'),(88,9,44,'4'),(89,1,45,'5'),(90,9,45,'5'),(91,1,46,'DDR2'),(92,9,46,'DDR2'),(93,1,47,'DDR4'),(94,9,47,'DDR4'),(95,1,48,'555111'),(96,9,48,'555111'),(97,1,49,'222333'),(98,9,49,'222333'),(99,1,50,'0.274'),(100,9,50,'0.274'),(101,1,51,'0.26'),(102,9,51,'0.26'),(103,1,52,'60'),(104,9,52,'60'),(105,1,53,'Да'),(106,9,53,'Да'),(107,1,54,'Нет'),(108,9,54,'Нет'),(109,1,55,'0.284'),(110,9,55,'0.284'),(111,1,56,'0.274'),(112,9,56,'0.274'),(113,1,57,'Type 2'),(114,9,57,'Type 2'),(115,1,58,'Type 1'),(116,9,58,'Type 1');
/*!40000 ALTER TABLE `StoreAttributeOptionTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreAttributeTranslate`
--

LOCK TABLES `StoreAttributeTranslate` WRITE;
/*!40000 ALTER TABLE `StoreAttributeTranslate` DISABLE KEYS */;
INSERT INTO `StoreAttributeTranslate` VALUES (1,1,1,'Simple attr'),(2,1,9,'Simple product'),(3,2,1,'Color'),(4,2,9,'Color'),(5,3,1,'Processor manufacturer'),(6,3,9,'Processor manufacturer'),(7,4,1,'Freq'),(8,4,9,'Freq'),(9,5,1,'Memmory'),(10,5,9,'Memmory'),(11,6,1,'Memmory type'),(12,6,9,'Memmory type'),(13,7,1,'Screen'),(14,7,9,'Screen'),(15,8,1,'Video'),(16,8,9,'Video'),(17,9,1,'Screen dimension'),(18,9,9,'Screen dimension'),(19,10,1,'textbox'),(20,10,9,'textbox'),(21,11,1,'Vesbrutto'),(22,11,9,'Vesbrutto'),(23,12,1,'Vesnetto'),(24,12,9,'Vesnetto'),(25,13,1,'Kolvovtranspupak'),(26,13,9,'Kolvovtranspupak'),(27,14,1,'Individualupak'),(28,14,9,'Individualupak'),(29,15,1,'Additional type'),(30,15,9,'Additional type');
/*!40000 ALTER TABLE `StoreAttributeTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreCategory`
--

LOCK TABLES `StoreCategory` WRITE;
/*!40000 ALTER TABLE `StoreCategory` DISABLE KEYS */;
INSERT INTO `StoreCategory` VALUES (1,1,30,1,'root','','','',NULL),(212,10,15,2,'noutbuki','noutbuki','','','this is desc in eng'),(213,11,12,3,'byudzhetnii','noutbuki/byudzhetnii','','',''),(214,13,14,3,'igrovoi','noutbuki/igrovoi','','',NULL),(215,16,21,2,'kompyuteri','kompyuteri','','',NULL),(216,17,18,3,'kompyuternaya-akustika','kompyuteri/kompyuternaya-akustika','','',NULL),(217,22,23,2,'monitori','monitori','','',NULL),(218,24,25,2,'telefoni','telefoni','','',NULL),(219,19,20,3,'plansheti','kompyuteri/plansheti','','',NULL),(220,26,27,2,'assortiment','assortiment','','',NULL),(221,28,29,2,'kategoriya-1','kategoriya-1','','',NULL);
/*!40000 ALTER TABLE `StoreCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreCategoryTranslate`
--

LOCK TABLES `StoreCategoryTranslate` WRITE;
/*!40000 ALTER TABLE `StoreCategoryTranslate` DISABLE KEYS */;
INSERT INTO `StoreCategoryTranslate` VALUES (1,1,1,'root','','','',NULL),(9,212,9,'Ноутбуки','','','','this is desc in eng'),(8,212,1,'Ноутбуки','','','','this is test description'),(10,213,1,'Бюджетный','','','',''),(11,213,9,'Бюджетный','','','',NULL),(12,214,1,'Игровой','','','',NULL),(13,214,9,'Игровой','','','',NULL),(14,215,1,'Компьютеры','','','',NULL),(15,215,9,'Компьютеры','','','',NULL),(16,216,1,'Компьютерная акустика','','','',NULL),(17,216,9,'Компьютерная акустика','','','',NULL),(18,217,1,'Мониторы','','','',NULL),(19,217,9,'Мониторы','','','',NULL),(20,218,1,'Телефоны','','','',NULL),(21,218,9,'Телефоны','','','',NULL),(22,219,1,'Планшеты','','','',NULL),(23,219,9,'Планшеты','','','',NULL),(24,220,1,'Ассортимент','','','',NULL),(25,220,9,'Ассортимент','','','',NULL),(26,221,1,'Категория 1','','','',NULL),(27,221,9,'Категория 1','','','',NULL);
/*!40000 ALTER TABLE `StoreCategoryTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreCurrency`
--

LOCK TABLES `StoreCurrency` WRITE;
/*!40000 ALTER TABLE `StoreCurrency` DISABLE KEYS */;
INSERT INTO `StoreCurrency` VALUES (1,'Доллары','USD','$',1.000,1,1),(2,'Рубли','RUR','руб.',32.520,0,0);
/*!40000 ALTER TABLE `StoreCurrency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreDeliveryMethod`
--

LOCK TABLES `StoreDeliveryMethod` WRITE;
/*!40000 ALTER TABLE `StoreDeliveryMethod` DISABLE KEYS */;
INSERT INTO `StoreDeliveryMethod` VALUES (14,10.00,1000.00,0,1),(15,0.00,0.00,1,1),(16,30.00,0.00,2,1);
/*!40000 ALTER TABLE `StoreDeliveryMethod` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `StoreDeliveryMethodTranslate`
--

LOCK TABLES `StoreDeliveryMethodTranslate` WRITE;
/*!40000 ALTER TABLE `StoreDeliveryMethodTranslate` DISABLE KEYS */;
INSERT INTO `StoreDeliveryMethodTranslate` VALUES (1,14,1,'Курьером',''),(2,14,9,'English','english description'),(3,15,1,'Самовывоз',''),(4,15,9,'Самовывоз',''),(5,16,1,'Адресная доставка по стране',''),(6,16,9,'Адресная доставка по стране','');
/*!40000 ALTER TABLE `StoreDeliveryMethodTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreDeliveryPayment`
--

LOCK TABLES `StoreDeliveryPayment` WRITE;
/*!40000 ALTER TABLE `StoreDeliveryPayment` DISABLE KEYS */;
INSERT INTO `StoreDeliveryPayment` VALUES (24,12,14),(23,10,16),(22,10,13),(21,10,14),(34,11,16),(33,11,13),(25,12,15),(26,12,16),(78,14,21),(77,14,19),(76,14,20),(75,14,18),(82,15,20),(81,15,18),(55,16,17),(56,16,18),(57,16,20),(58,16,19),(74,14,17);
/*!40000 ALTER TABLE `StoreDeliveryPayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreManufacturer`
--

LOCK TABLES `StoreManufacturer` WRITE;
/*!40000 ALTER TABLE `StoreManufacturer` DISABLE KEYS */;
INSERT INTO `StoreManufacturer` VALUES (1,'lenovo','',''),(2,'asus','',''),(3,'dell','',''),(4,'fujitsu','',''),(5,'hp','',''),(6,'apple','',''),(7,'sony','',''),(8,'acer','',''),(9,'volgaavtoprom','','');
/*!40000 ALTER TABLE `StoreManufacturer` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `StoreManufacturerTranslate`
--

LOCK TABLES `StoreManufacturerTranslate` WRITE;
/*!40000 ALTER TABLE `StoreManufacturerTranslate` DISABLE KEYS */;
INSERT INTO `StoreManufacturerTranslate` VALUES (1,1,1,'Lenovo','','','',''),(2,1,9,'Lenovo','','','',''),(3,2,1,'Asus','','','',''),(4,2,9,'Asus','','','',''),(5,3,1,'Dell','','','',''),(6,3,9,'Dell','','','',''),(7,4,1,'Fujitsu','','','',''),(8,4,9,'Fujitsu','','','',''),(9,5,1,'HP','','','',''),(10,5,9,'HP','','','',''),(11,6,1,'Apple','','','',''),(12,6,9,'Apple','','','',''),(13,7,1,'Sony','','','',''),(14,7,9,'Sony','','','',''),(15,8,1,'Acer','','','',''),(16,8,9,'Acer','','','',''),(17,9,1,'ВолгаАвтоПром','','','',''),(18,9,9,'ВолгаАвтоПром','','','','');
/*!40000 ALTER TABLE `StoreManufacturerTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StorePaymentMethod`
--

LOCK TABLES `StorePaymentMethod` WRITE;
/*!40000 ALTER TABLE `StorePaymentMethod` DISABLE KEYS */;
INSERT INTO `StorePaymentMethod` VALUES (17,1,1,'webmoney',0),(18,2,1,'',2),(19,1,1,'robokassa',1),(20,2,1,'',3),(21,2,1,'qiwi',4);
/*!40000 ALTER TABLE `StorePaymentMethod` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `StorePaymentMethodTranslate`
--

LOCK TABLES `StorePaymentMethodTranslate` WRITE;
/*!40000 ALTER TABLE `StorePaymentMethodTranslate` DISABLE KEYS */;
INSERT INTO `StorePaymentMethodTranslate` VALUES (1,17,1,'WebMoney','WebMoney — это универсальное средство для расчетов в Сети, целая среда финансовых взаимоотношений, которой сегодня пользуются миллионы людей по всему миру.'),(2,17,9,'English payment1','russian description'),(3,18,1,'Наличная','Наличная оплата осуществляется только в рублях при доставке товара курьером покупателю.'),(7,20,1,'Безналичная',' Стоимость товара при безналичной оплате без ПДВ равна розничной цене товара + 2% '),(8,20,9,'Безналичная',''),(4,18,9,'Наличка','<p>ыла оылдао ылдао ылдоа ылдва<br />ыаол ывла оывалд ыова</p>'),(5,19,1,'Robokassa','Многими пользователями электронные платежные системы расцениваются в качестве наиболее удобного средства оплаты товаров и услуг в Интернете.'),(6,19,9,'Robokassa','<p>Description goes here</p>'),(9,21,1,'Qiwi','Оплата с помощью Qiwi'),(10,21,9,'Qiwi','Оплата с помощью Qiwi');
/*!40000 ALTER TABLE `StorePaymentMethodTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProduct`
--

LOCK TABLES `StoreProduct` WRITE;
/*!40000 ALTER TABLE `StoreProduct` DISABLE KEYS */;
INSERT INTO `StoreProduct` VALUES (34,8,2,0,'acer-aspire-5943g-7748g75twiss',2350.00,0.00,1,'','','',0,1,1,4,'2013-04-13 00:58:37','2013-04-21 13:03:52',0,0,0,'5'),(19,9,3,0,'krestovina-vaz-2101',105.00,0.00,0,NULL,NULL,'2101-2202025',0,1,1,0,'2013-04-08 21:39:18','2013-04-08 21:39:18',0,0,0,NULL),(23,1,2,0,'lenovo-b570',345.00,0.00,1,NULL,NULL,NULL,0,1,1,7,'2013-04-13 00:58:36','2013-04-13 00:58:35',0,0,0,NULL),(24,1,2,0,'lenovo-g570',360.00,0.00,1,'','','',0,1,1,0,'2013-04-13 00:58:36','2013-04-21 09:58:21',0,0,0,NULL),(25,2,2,0,'asus-k53u',375.00,0.00,1,NULL,NULL,NULL,0,1,1,3,'2013-04-13 00:58:36','2013-04-13 00:58:36',0,0,0,NULL),(26,2,2,0,'asus-x54c',370.00,0.00,1,NULL,NULL,NULL,0,1,1,1,'2013-04-13 00:58:36','2013-04-13 00:58:36',0,0,0,NULL),(27,3,2,0,'dell-inspiron-n5050',380.00,0.00,1,NULL,NULL,NULL,0,1,1,0,'2013-04-13 00:58:36','2013-04-13 00:58:36',0,0,0,NULL),(28,4,2,0,'fujitsu-lifebook-ah531',395.00,0.00,1,NULL,NULL,NULL,0,1,1,0,'2013-04-13 00:58:36','2013-04-13 00:58:36',0,0,0,NULL),(29,5,2,0,'hp-elitebook-8560w',3150.00,0.00,1,NULL,NULL,NULL,0,1,1,0,'2013-04-13 00:58:36','2013-04-13 00:58:36',0,0,0,NULL),(30,3,2,0,'dell-alienware-m17x',2850.00,0.00,1,NULL,NULL,NULL,0,1,1,0,'2013-04-13 00:58:36','2013-04-13 00:58:36',0,0,0,NULL),(31,6,2,0,'apple-macbook-pro-15-late-2011',2600.00,0.00,1,'','','',0,2,1,12,'2013-04-13 00:58:37','2013-05-04 21:48:33',0,0,0,''),(32,1,2,0,'lenovo-thinkpad-w520',2450.00,0.00,1,'','','',0,1,1,25,'2013-04-13 00:58:37','2013-05-20 23:30:21',6,0,0,''),(33,7,2,0,'sony-vaio-vpc-f13s8r',1950.00,0.00,1,'','','',0,1,1,27,'2013-04-13 00:58:37','2013-04-29 22:15:58',3,1,3,''),(35,NULL,4,0,'produkt-1',1.00,0.00,1,'','','',0,1,1,4,'2013-04-27 22:39:47','2013-05-20 23:46:55',1,0,0,''),(36,NULL,5,0,'produkt-2',15.00,0.00,1,'','','',0,1,1,1,'2013-04-27 22:39:47','2013-05-04 21:49:52',1,0,0,''),(37,NULL,2,0,'test',99.00,0.00,1,'','','',0,1,1,0,'2013-05-21 23:55:52','2013-05-21 23:55:52',0,0,0,'');
/*!40000 ALTER TABLE `StoreProduct` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `StoreProductAttributeEAV`
--

LOCK TABLES `StoreProductAttributeEAV` WRITE;
/*!40000 ALTER TABLE `StoreProductAttributeEAV` DISABLE KEYS */;
INSERT INTO `StoreProductAttributeEAV` VALUES (29,'memmory','22'),(29,'freq','21'),(25,'screen_dimension','14'),(26,'processor_manufacturer','8'),(26,'freq','17'),(26,'memmory','10'),(19,'individualupak','53'),(19,'kolvovtranspupak','52'),(19,'vesnetto','51'),(19,'vesbrutto','50'),(25,'video','13'),(25,'screen','12'),(25,'memmory_type','11'),(25,'memmory','10'),(25,'freq','16'),(25,'processor_manufacturer','15'),(24,'processor_manufacturer','8'),(24,'screen_dimension','14'),(24,'video','13'),(24,'screen','12'),(23,'screen_dimension','14'),(23,'processor_manufacturer','8'),(23,'freq','9'),(23,'memmory','10'),(23,'memmory_type','11'),(23,'screen','12'),(23,'video','13'),(27,'memmory_type','11'),(27,'memmory','10'),(27,'freq','19'),(27,'processor_manufacturer','8'),(26,'screen_dimension','14'),(30,'screen','12'),(30,'processor_manufacturer','20'),(29,'screen_dimension','24'),(29,'video','23'),(29,'screen','12'),(29,'memmory_type','11'),(29,'processor_manufacturer','20'),(28,'screen_dimension','14'),(28,'video','18'),(28,'screen','12'),(28,'memmory','10'),(28,'memmory_type','11'),(28,'freq','19'),(28,'processor_manufacturer','8'),(30,'memmory_type','11'),(27,'screen_dimension','14'),(27,'video','18'),(30,'memmory','22'),(30,'freq','25'),(26,'video','18'),(26,'screen','12'),(26,'memmory_type','11'),(27,'screen','12'),(30,'video','26'),(30,'screen_dimension','27'),(31,'screen_dimension','24'),(31,'video','30'),(31,'screen','29'),(31,'memmory_type','11'),(32,'processor_manufacturer','20'),(32,'screen_dimension','24'),(32,'video','23'),(32,'screen','12'),(33,'screen_dimension','24'),(33,'screen','33'),(33,'video','34'),(33,'memmory_type','11'),(34,'memmory','22'),(34,'freq','35'),(31,'memmory','28'),(24,'freq','9'),(24,'memmory','10'),(24,'memmory_type','11'),(32,'memmory_type','11'),(34,'processor_manufacturer','20'),(34,'screen_dimension','24'),(34,'video','36'),(34,'screen','12'),(34,'memmory_type','11'),(35,'additional_type','57'),(32,'memmory','28'),(33,'memmory','28'),(33,'freq','32'),(33,'processor_manufacturer','31'),(31,'freq','21'),(31,'processor_manufacturer','20'),(32,'freq','25');
/*!40000 ALTER TABLE `StoreProductAttributeEAV` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProductCategoryRef`
--

LOCK TABLES `StoreProductCategoryRef` WRITE;
/*!40000 ALTER TABLE `StoreProductCategoryRef` DISABLE KEYS */;
INSERT INTO `StoreProductCategoryRef` VALUES (57,33,212,0),(56,33,214,1),(32,19,1,1),(37,23,212,0),(36,23,213,1),(43,26,212,0),(42,26,213,1),(41,25,212,0),(40,25,213,1),(39,24,212,0),(38,24,213,1),(51,30,212,0),(50,30,214,1),(49,29,212,0),(48,29,214,1),(47,28,212,0),(46,28,213,1),(45,27,212,0),(44,27,213,1),(59,34,212,0),(58,34,214,1),(55,32,212,0),(54,32,214,1),(53,31,212,0),(52,31,214,1),(65,36,215,1),(68,37,1,1),(62,35,215,1),(63,35,216,0),(64,35,219,0),(66,36,216,0),(67,36,219,0);
/*!40000 ALTER TABLE `StoreProductCategoryRef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProductConfigurableAttributes`
--

LOCK TABLES `StoreProductConfigurableAttributes` WRITE;
/*!40000 ALTER TABLE `StoreProductConfigurableAttributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `StoreProductConfigurableAttributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProductConfigurations`
--

LOCK TABLES `StoreProductConfigurations` WRITE;
/*!40000 ALTER TABLE `StoreProductConfigurations` DISABLE KEYS */;
/*!40000 ALTER TABLE `StoreProductConfigurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProductImage`
--

LOCK TABLES `StoreProductImage` WRITE;
/*!40000 ALTER TABLE `StoreProductImage` DISABLE KEYS */;
INSERT INTO `StoreProductImage` VALUES (18,23,'23_2845451760.jpg',1,1,'2013-04-13 00:58:36',NULL),(20,25,'25_3179427205.jpg',1,1,'2013-04-13 00:58:36',NULL),(19,24,'24_554493234.jpg',1,1,'2013-04-13 00:58:36',NULL),(22,27,'27_4066735307.jpg',1,1,'2013-04-13 00:58:36',NULL),(21,26,'26_2066880789.jpg',1,1,'2013-04-13 00:58:36',NULL),(25,30,'30_3540854167.jpg',1,1,'2013-04-13 00:58:37',NULL),(23,28,'28_2974646102.jpg',1,1,'2013-04-13 00:58:36',NULL),(24,29,'29_3712199739.jpg',1,1,'2013-04-13 00:58:36',NULL),(26,31,'31_547586970.jpg',1,1,'2013-04-13 00:58:37','apple'),(27,32,'32_2152046546.jpg',1,1,'2013-04-13 00:58:37',''),(28,33,'33_1648153485.jpg',0,1,'2013-04-13 00:58:37',NULL),(29,34,'34_3337334245.jpg',1,1,'2013-04-13 00:58:37',NULL),(30,33,'33_1840327326.jpg',0,1,'2013-04-29 22:08:37',NULL),(31,33,'33_4162505954.jpg',0,1,'2013-04-29 22:08:37',NULL),(32,33,'33_2099860.jpg',1,1,'2013-04-29 22:08:37',NULL),(33,33,'33_2545732078.jpg',0,1,'2013-04-29 22:15:23',NULL),(34,31,'31_3623958655.jpg',0,1,'2013-05-04 21:40:33','sky'),(41,35,'35_2833106910.jpg',1,1,'2013-05-20 23:46:55',NULL);
/*!40000 ALTER TABLE `StoreProductImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProductTranslate`
--

LOCK TABLES `StoreProductTranslate` WRITE;
/*!40000 ALTER TABLE `StoreProductTranslate` DISABLE KEYS */;
INSERT INTO `StoreProductTranslate` VALUES (65,33,1,'Sony VAIO VPC-F13S8R','Core i5, 2660 МГц, 4096 Мб, 640 Гб, 16.4 дюйм, NVIDIA GeForce GT 425M, Blu-Ray, Wi-Fi, Bluetooth, 3.1 кг','','','',''),(37,19,1,'Крестовина ВАЗ 2101','Поставляется в индивидуальной упаковке',NULL,NULL,NULL,NULL),(38,19,9,'Крестовина ВАЗ 2101','Поставляется в индивидуальной упаковке',NULL,NULL,NULL,NULL),(46,23,9,'Lenovo B570','Celeron / Pentium, 1500-2200 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, Intel GMA HD, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.35 кг',NULL,NULL,NULL,NULL),(45,23,1,'Lenovo B570','Celeron / Pentium, 1500-2200 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, Intel GMA HD, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.35 кг',NULL,NULL,NULL,NULL),(47,24,1,'Lenovo G570','Celeron / Pentium, 1500-2200 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, ATI Radeon HD 6370M, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.43 кг','','','',''),(48,24,9,'Lenovo G570','Celeron / Pentium, 1500-2200 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, ATI Radeon HD 6370M, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.43 кг',NULL,NULL,NULL,NULL),(49,25,1,'ASUS K53U','C-60 / E-240 / E-450, 1000-1650 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.6 кг',NULL,NULL,NULL,NULL),(50,25,9,'ASUS K53U','C-60 / E-240 / E-450, 1000-1650 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.6 кг',NULL,NULL,NULL,NULL),(51,26,1,'ASUS X54C','Celeron / Pentium, 1500-2200 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, Intel HD Graphics 3000, DVD-RW, Wi-Fi, Bluetooth, 2.6 кг',NULL,NULL,NULL,NULL),(52,26,9,'ASUS X54C','Celeron / Pentium, 1500-2200 МГц, 2048-4096 Мб, 320-500 Гб, 15.6 дюйм, Intel HD Graphics 3000, DVD-RW, Wi-Fi, Bluetooth, 2.6 кг',NULL,NULL,NULL,NULL),(53,27,1,'DELL INSPIRON N5050','Celeron, 1500-1700 МГц, 2048 Мб, 320-500 Гб, 15.6 дюйм, Intel HD Graphics 3000, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.37 кг',NULL,NULL,NULL,NULL),(54,27,9,'DELL INSPIRON N5050','Celeron, 1500-1700 МГц, 2048 Мб, 320-500 Гб, 15.6 дюйм, Intel HD Graphics 3000, DVD-RW, Wi-Fi, Bluetooth (опционально), 2.37 кг',NULL,NULL,NULL,NULL),(55,28,1,'Fujitsu LIFEBOOK AH531','Celeron / Pentium, 1500-2200 МГц, 2048 Мб, 320 Гб, 15.6 дюйм, Intel HD Graphics 3000, DVD-RW, Wi-Fi, Bluetooth, 2.5 кг',NULL,NULL,NULL,NULL),(56,28,9,'Fujitsu LIFEBOOK AH531','Celeron / Pentium, 1500-2200 МГц, 2048 Мб, 320 Гб, 15.6 дюйм, Intel HD Graphics 3000, DVD-RW, Wi-Fi, Bluetooth, 2.5 кг',NULL,NULL,NULL,NULL),(57,29,1,'HP EliteBook 8560w','Core i7, 2500 МГц, 8192 Мб, 750 Гб, 15.6 дюйм, NVIDIA Quadro 2000M, BD-RE, Wi-Fi, Bluetooth, 3 кг',NULL,NULL,NULL,NULL),(58,29,9,'HP EliteBook 8560w','Core i7, 2500 МГц, 8192 Мб, 750 Гб, 15.6 дюйм, NVIDIA Quadro 2000M, BD-RE, Wi-Fi, Bluetooth, 3 кг',NULL,NULL,NULL,NULL),(59,30,1,'DELL ALIENWARE M17x','Core i7, 2200-2400 МГц, 8192-16384 Мб, 750-1500 Гб, 17 дюйм, AMD Radeon HD 6990M, BD-RE / Blu-Ray / DVD-RW, Wi-Fi, Bluetooth, 5.3 кг',NULL,NULL,NULL,NULL),(60,30,9,'DELL ALIENWARE M17x','Core i7, 2200-2400 МГц, 8192-16384 Мб, 750-1500 Гб, 17 дюйм, AMD Radeon HD 6990M, BD-RE / Blu-Ray / DVD-RW, Wi-Fi, Bluetooth, 5.3 кг',NULL,NULL,NULL,NULL),(61,31,1,'Apple MacBook Pro 15 Late 2011','Core i7, 2200-2400 МГц, 4096 Мб, 500-750 Гб, 15.4 дюйм, ATI Radeon HD 6750M / ATI Radeon HD 6770М, DVD-RW, Wi-Fi, Bluetooth, 2.54 кг','','','',''),(62,31,9,'Apple MacBook Pro 15 Late 2011','Core i7, 2200-2400 МГц, 4096 Мб, 500-750 Гб, 15.4 дюйм, ATI Radeon HD 6750M / ATI Radeon HD 6770М, DVD-RW, Wi-Fi, Bluetooth, 2.54 кг',NULL,NULL,NULL,NULL),(63,32,1,'Lenovo THINKPAD W520','Core i7 / Core i7 Extreme, 2000-2700 МГц, 4096-8192 Мб, 160-580 Гб, 15.6 дюйм, NVIDIA Quadro 2000M, DVD-RW, Wi-Fi, Bluetooth, 2.45 кг','','','',''),(64,32,9,'Lenovo THINKPAD W520','Core i7 / Core i7 Extreme, 2000-2700 МГц, 4096-8192 Мб, 160-580 Гб, 15.6 дюйм, NVIDIA Quadro 2000M, DVD-RW, Wi-Fi, Bluetooth, 2.45 кг',NULL,NULL,NULL,NULL),(66,33,9,'Sony VAIO VPC-F13S8R','Core i5, 2660 МГц, 4096 Мб, 640 Гб, 16.4 дюйм, NVIDIA GeForce GT 425M, Blu-Ray, Wi-Fi, Bluetooth, 3.1 кг',NULL,NULL,NULL,NULL),(67,34,1,'Acer ASPIRE 5943G-7748G75TWiss','Core i7, 1730 МГц, 8192 Мб, 750 Гб, 15.6 дюйм, ATI Mobility Radeon HD 5850, BD-RE, Wi-Fi, Bluetooth, 3.3 кг','','','',''),(68,34,9,'Acer ASPIRE 5943G-7748G75TWiss','Core i7, 1730 МГц, 8192 Мб, 750 Гб, 15.6 дюйм, ATI Mobility Radeon HD 5850, BD-RE, Wi-Fi, Bluetooth, 3.3 кг',NULL,NULL,NULL,NULL),(69,35,1,'Продукт 1','','','','',''),(70,35,9,'Продукт 1',NULL,NULL,NULL,NULL,NULL),(71,36,1,'Продукт 2','','','','',''),(72,36,9,'Продукт 2',NULL,NULL,NULL,NULL,NULL),(73,37,1,'test','','','','',''),(74,37,9,'test','','','','','');
/*!40000 ALTER TABLE `StoreProductTranslate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProductType`
--

LOCK TABLES `StoreProductType` WRITE;
/*!40000 ALTER TABLE `StoreProductType` DISABLE KEYS */;
INSERT INTO `StoreProductType` VALUES (1,'Simple Product','',0),(2,'laptop','',0),(3,'Набор стандартных атрибутов','',0),(4,'Напильник','',0),(5,'Насос','',0);
/*!40000 ALTER TABLE `StoreProductType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreProductVariant`
--

LOCK TABLES `StoreProductVariant` WRITE;
/*!40000 ALTER TABLE `StoreProductVariant` DISABLE KEYS */;
/*!40000 ALTER TABLE `StoreProductVariant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreRelatedProduct`
--

LOCK TABLES `StoreRelatedProduct` WRITE;
/*!40000 ALTER TABLE `StoreRelatedProduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `StoreRelatedProduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreTypeAttribute`
--

LOCK TABLES `StoreTypeAttribute` WRITE;
/*!40000 ALTER TABLE `StoreTypeAttribute` DISABLE KEYS */;
INSERT INTO `StoreTypeAttribute` VALUES (1,1),(1,2),(2,3),(2,4),(2,5),(2,6),(2,7),(2,8),(2,9),(2,10),(3,11),(3,12),(3,13),(3,14),(4,15);
/*!40000 ALTER TABLE `StoreTypeAttribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreWishlist`
--

LOCK TABLES `StoreWishlist` WRITE;
/*!40000 ALTER TABLE `StoreWishlist` DISABLE KEYS */;
INSERT INTO `StoreWishlist` VALUES (4,'ju9gvr5cyd',1);
/*!40000 ALTER TABLE `StoreWishlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StoreWishlistProducts`
--

LOCK TABLES `StoreWishlistProducts` WRITE;
/*!40000 ALTER TABLE `StoreWishlistProducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `StoreWishlistProducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `SystemLanguage`
--

LOCK TABLES `SystemLanguage` WRITE;
/*!40000 ALTER TABLE `SystemLanguage` DISABLE KEYS */;
INSERT INTO `SystemLanguage` VALUES (1,'Русский','ru','ru',1,'ru.png'),(9,'English','en','en',0,'us.png');
/*!40000 ALTER TABLE `SystemLanguage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `SystemModules`
--

LOCK TABLES `SystemModules` WRITE;
/*!40000 ALTER TABLE `SystemModules` DISABLE KEYS */;
INSERT INTO `SystemModules` VALUES (7,'users',1),(9,'pages',1),(11,'core',1),(12,'rights',1),(16,'orders',1),(15,'store',1),(17,'comments',1),(37,'feedback',1),(38,'discounts',1),(39,'newsletter',1),(40,'csv',1),(41,'logger',1),(52,'accounting1c',1),(53,'yandexMarket',1),(54,'notifier',1),(55,'statistics',1),(56,'sitemap',1),(57,'programm',1);
/*!40000 ALTER TABLE `SystemModules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `SystemSettings`
--

LOCK TABLES `SystemSettings` WRITE;
/*!40000 ALTER TABLE `SystemSettings` DISABLE KEYS */;
INSERT INTO `SystemSettings` VALUES (9,'feedback','max_message_length','1000'),(8,'feedback','enable_captcha','1'),(7,'feedback','admin_email','admin@localhost.local'),(10,'17_WebMoneyPaymentSystem','LMI_PAYEE_PURSE','Z123456578811'),(11,'17_WebMoneyPaymentSystem','LMI_SECRET_KEY','theSercretPassword'),(12,'18_WebMoneyPaymentSystem','LMI_PAYEE_PURSE','1'),(13,'18_WebMoneyPaymentSystem','LMI_SECRET_KEY','2'),(14,'19_RobokassaPaymentSystem','login','login'),(15,'19_RobokassaPaymentSystem','password1','password1value'),(16,'19_RobokassaPaymentSystem','password2','password2value'),(22,'accounting1c','password','f880fefe2aff8130bb31d480f08e47c03e655b60'),(21,'accounting1c','ip','127.0.0.1'),(23,'accounting1c','tempdir','application.runtime'),(24,'yandexMarket','name','Демо магазин'),(25,'yandexMarket','company','Демо кампания'),(26,'yandexMarket','url','http://demo-company.loc/'),(27,'yandexMarket','currency_id','2'),(28,'core','siteName','Eximus Commerce'),(29,'core','productsPerPage','12,18,24'),(30,'core','productsPerPageAdmin','20'),(31,'core','theme','default'),(32,'20_QiwiPaymentSystem','shop_id',''),(33,'20_QiwiPaymentSystem','password',''),(34,'21_QiwiPaymentSystem','shop_id','211182'),(35,'21_QiwiPaymentSystem','password','xsi100500'),(36,'core','editorTheme','compant'),(37,'core','editorHeight','300'),(38,'core','editorAutoload','0'),(39,'images','path','webroot.uploads.product'),(40,'images','thumbPath','webroot.assets.productThumbs'),(41,'images','url','/uploads/product/'),(42,'images','thumbUrl','/assets/productThumbs/'),(43,'images','maxFileSize','10485760'),(44,'images','max_sizes','1800х1600'),(45,'images','maximum_image_size','800x600');
/*!40000 ALTER TABLE `SystemSettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `accounting1c`
--

LOCK TABLES `accounting1c` WRITE;
/*!40000 ALTER TABLE `accounting1c` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounting1c` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `grid_view_filter`
--

LOCK TABLES `grid_view_filter` WRITE;
/*!40000 ALTER TABLE `grid_view_filter` DISABLE KEYS */;
/*!40000 ALTER TABLE `grid_view_filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,11,'firstrow@gmail.com'),(2,31,'sdfsdf@sdfsdf.ccc'),(3,31,'sdf@ddd.ccc');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','admin@localhost.loc','2011-08-21 10:17:15','2013-05-27 21:25:31','127.0.0.1','PXKMUEHFNK','01A2QOPJE1KIYRP','',0),(56,'tester','ab4d8d2a5f480a137067da17100271cd176607a1','tester@localhodst.loc','2013-04-09 19:54:42','2013-05-07 19:09:40','127.0.0.1','','',NULL,0),(57,'tester2','5e86e8cdc7188d53916fcd1d7294cee4611c7c49','tester2@loc.loc','2013-04-20 23:49:05','2013-04-20 23:49:05','127.0.0.1','','','',0),(58,'tester3','97898ea0f2dea62149cdae4f073b442ff123aaf6','tester3@tester3.loc','2013-04-20 23:49:21','2013-04-20 23:49:21','127.0.0.1','','',NULL,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (1,1,'Administrator','000-000-00-00','where to delivery'),(5,56,'tester','',''),(6,57,'tester tow','',''),(7,58,'tester3','','');
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-27 23:49:06
