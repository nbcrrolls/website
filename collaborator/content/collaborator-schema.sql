-- MySQL dump 10.11
--
-- Host: localhost    Database: collaborators
-- ------------------------------------------------------
-- Server version	5.0.77

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
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `applications` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date` varchar(10) default NULL,
  `pi_first_name` varchar(50) default NULL,
  `pi_last_name` varchar(50) default NULL,
  `app_first_name` varchar(50) default NULL,
  `app_last_name` varchar(50) default NULL,
  `pi_title` varchar(50) default NULL,
  `app_title` varchar(50) default NULL,
  `pi_degree` varchar(30) default NULL,
  `app_degree` varchar(30) default NULL,
  `pi_phone` varchar(22) default NULL,
  `app_phone` varchar(22) default NULL,
  `pi_fax` varchar(22) default NULL,
  `app_fax` varchar(22) default NULL,
  `pi_email` varchar(40) default NULL,
  `app_email` varchar(40) default NULL,
  `lab` varchar(75) default NULL,
  `department` varchar(75) default NULL,
  `institution` varchar(100) default NULL,
  `street1` varchar(75) default NULL,
  `street2` varchar(75) default NULL,
  `city` varchar(75) default NULL,
  `state` char(2) default NULL,
  `zip` varchar(25) default NULL,
  `country` varchar(50) default NULL,
  `research_area` varchar(100) default NULL,
  `project_title` varchar(200) default NULL,
  `keywords` varchar(200) default NULL,
  `app_type` varchar(8) default NULL,
  `abs_sum` text,
  `resource_software` varchar(50) default NULL,
  `resource_computer` varchar(50) default NULL,
  `personnel` char(3) default NULL,
  `personnel_first_name` varchar(50) default NULL,
  `personnel_last_name` varchar(50) default NULL,
  `personnel_title` varchar(50) default NULL,
  `personnel_email` varchar(40) default NULL,
  `visits` varchar(4) default NULL,
  `visits_per` varchar(5) default NULL,
  `status` varchar(10) default NULL,
  `status_date` varchar(10) default NULL,
  `personnel_degree` varchar(30) default NULL,
  `full_sum` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fundings`
--

DROP TABLE IF EXISTS `fundings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fundings` (
  `app_id` int(10) unsigned NOT NULL default '0',
  `source` char(20) default NULL,
  `grant_info` char(20) default NULL,
  `pi_first_name` char(50) default NULL,
  `pi_last_name` char(50) default NULL,
  `title` char(40) default NULL,
  `period` char(100) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `fundings`
--

LOCK TABLES `fundings` WRITE;
/*!40000 ALTER TABLE `fundings` DISABLE KEYS */;
/*!40000 ALTER TABLE `fundings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `publications` (
  `app_id` int(10) unsigned default NULL,
  `type` varchar(16) default NULL,
  `reference` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `publications`
--

LOCK TABLES `publications` WRITE;
/*!40000 ALTER TABLE `publications` DISABLE KEYS */;
/*!40000 ALTER TABLE `publications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summary_log`
--

DROP TABLE IF EXISTS `summary_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `summary_log` (
  `app_id` int(10) unsigned NOT NULL default '0',
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `full_summary` text,
  `modified_by` varchar(255) default NULL,
  `abs_sum` text,
  PRIMARY KEY  (`app_id`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `summary_log`
--

LOCK TABLES `summary_log` WRITE;
/*!40000 ALTER TABLE `summary_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `summary_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-10 22:05:59
