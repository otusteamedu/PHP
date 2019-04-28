CREATE DATABASE  IF NOT EXISTS `test_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `test_db`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: test_db
-- ------------------------------------------------------
-- Server version	5.7.25

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
-- Table structure for table `film`
--

DROP TABLE IF EXISTS `film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `annotation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `films_to_genre_idx` (`genre_id`),
  CONSTRAINT `films_to_genre` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film`
--

LOCK TABLES `film` WRITE;
/*!40000 ALTER TABLE `film` DISABLE KEYS */;
INSERT INTO `film` VALUES (1,'film 1',1,700,'text'),(2,'film 2',1,23423,'jdnfrjd'),(3,'film 3',2,2343,'sefef');
/*!40000 ALTER TABLE `film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,'horror'),(2,'comedy');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hall`
--

DROP TABLE IF EXISTS `hall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seats` int(11) NOT NULL,
  `some_staff` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hall`
--

LOCK TABLES `hall` WRITE;
/*!40000 ALTER TABLE `hall` DISABLE KEYS */;
INSERT INTO `hall` VALUES (5,200,'name1','name1'),(6,100,'name2','name2'),(7,150,'name3','name3');
/*!40000 ALTER TABLE `hall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seance`
--

DROP TABLE IF EXISTS `seance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hall_id` int(11) NOT NULL,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `film_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seance_to_film_idx` (`film_id`),
  KEY `seance_to_hall_idx` (`hall_id`),
  CONSTRAINT `seance_to_film` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `seance_to_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seance`
--

LOCK TABLES `seance` WRITE;
/*!40000 ALTER TABLE `seance` DISABLE KEYS */;
INSERT INTO `seance` VALUES (1,5,'2017-12-31 21:00:00','2017-12-31 22:00:00',1),(2,6,'2017-12-31 21:00:00','2017-12-31 22:00:00',2),(3,7,'2017-12-31 21:00:00','2017-12-31 22:00:00',1);
/*!40000 ALTER TABLE `seance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seat`
--

DROP TABLE IF EXISTS `seat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hall_id` int(11) NOT NULL,
  `line` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_seat` (`hall_id`,`line`,`number`),
  KEY `seats_to_hall_idx` (`hall_id`),
  CONSTRAINT `seats_to_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seat`
--

LOCK TABLES `seat` WRITE;
/*!40000 ALTER TABLE `seat` DISABLE KEYS */;
INSERT INTO `seat` VALUES (1,5,1,1),(2,5,1,2),(3,5,1,3),(4,5,1,4),(5,5,1,5),(6,5,1,6),(7,5,1,7),(8,5,1,8),(9,5,1,9),(10,5,1,10),(11,5,1,11),(12,5,1,12),(13,6,1,1),(14,6,1,2),(15,6,1,3),(16,6,1,4),(17,6,1,5),(18,6,1,6),(19,6,1,7),(20,6,1,8),(21,6,1,9),(22,6,1,10),(23,7,1,1),(24,7,1,2),(25,7,1,3),(26,7,1,4),(27,7,1,5),(28,7,1,6),(29,7,1,7),(30,7,1,8),(31,7,1,9),(32,7,1,10);
/*!40000 ALTER TABLE `seat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seance_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `price` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_seat` (`seance_id`,`seat_id`),
  KEY `ticket_to_seats_idx` (`seat_id`),
  KEY `ticket_to_seance_idx` (`seance_id`),
  CONSTRAINT `ticket_to_seance` FOREIGN KEY (`seance_id`) REFERENCES `seance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ticket_to_seats` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (1,1,1,26),(2,1,2,71),(3,1,3,78),(4,1,5,77),(5,1,7,52),(6,1,9,29),(7,2,13,89),(8,2,21,60),(9,2,20,31),(10,2,15,77),(11,2,17,93),(12,2,16,35),(13,1,23,94),(14,3,24,67),(15,3,25,54),(16,3,26,71),(17,3,27,91),(18,3,28,45),(19,3,29,51),(20,3,30,19),(21,1,4,43),(22,1,8,60);
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-28 15:32:37
