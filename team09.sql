-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: team09
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.2

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
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  UNIQUE KEY `user1` (`user1`,`user2`),
  KEY `user2` (`user2`),
  CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user1`) REFERENCES `users` (`id`),
  CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user2`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (20,21),(22,21);
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (24,'Josh Post',20,'2012-12-07 15:00:09'),(25,'asdf',20,'2012-12-07 15:04:15'),(26,'asdfgh',20,'2012-12-07 15:08:01'),(27,'Ian Status',21,'2012-12-07 15:17:47'),(28,'Ian Status 2',21,'2012-12-07 15:17:53'),(29,'Josh Post 2',20,'2012-12-07 15:19:02'),(30,'asdf',20,'2012-12-07 15:19:48'),(31,'asdf',20,'2012-12-07 15:19:49'),(32,'asdf',20,'2012-12-07 15:19:51'),(33,'asdf',20,'2012-12-07 15:20:36'),(34,'asdf',20,'2012-12-07 15:20:37'),(35,'asdf',20,'2012-12-07 15:20:39'),(36,'asdf',20,'2012-12-07 15:20:40'),(37,'asdf',20,'2012-12-07 15:20:41'),(38,'asdf',22,'2012-12-07 15:20:55'),(39,'asdf',22,'2012-12-07 15:20:57'),(40,'asdf',22,'2012-12-07 15:20:58'),(41,'asdf',22,'2012-12-07 15:21:00'),(42,'asdfiyhiiuiyh',22,'2012-12-07 15:21:02'),(43,'asdf',22,'2012-12-07 15:21:04'),(44,'fdsa',22,'2012-12-07 15:21:05'),(45,'qwer',22,'2012-12-07 15:21:07'),(46,'casdef',22,'2012-12-07 15:21:08'),(47,'casdeeet',22,'2012-12-07 15:21:11'),(48,'Sdfaef',22,'2012-12-07 15:21:14'),(49,'asdfgrerv',22,'2012-12-07 15:21:17'),(50,'sfgrt4ef',22,'2012-12-07 15:21:20'),(51,'sdfgrefg',22,'2012-12-07 15:21:22'),(52,'sdfgsdfg',22,'2012-12-07 15:21:32'),(53,'sdfgdsfg',22,'2012-12-07 15:21:34'),(54,'ererg',22,'2012-12-07 15:21:36'),(55,'sdfvserv',22,'2012-12-07 15:21:38'),(56,'sdvrgr',22,'2012-12-07 15:21:41');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work` varchar(100) DEFAULT NULL,
  `edu` varchar(100) DEFAULT NULL,
  `liveCity` varchar(100) DEFAULT NULL,
  `liveState` varchar(100) DEFAULT NULL,
  `fromCity` varchar(100) DEFAULT NULL,
  `fromState` varchar(100) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'default.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('Joshua','French','jfrench@mines.edu','asdf',20,'Grader','College','Golden','Colorado','Broomfield','Colorado','single','default.jpg'),('Ian','Smith','iasmith@mines.edu','asdf',21,'Grader','CSM','Golden','Colorado','Broomfield','Colorado','single','default.jpg'),('Joe','Shmoe','jshmoe@mines.edu','asdf',22,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'default.jpg');
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

-- Dump completed on 2012-12-07 18:27:54
