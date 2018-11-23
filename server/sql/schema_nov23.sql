-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.35-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for airduino_db
CREATE DATABASE IF NOT EXISTS `airduino_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `airduino_db`;

-- Dumping structure for table airduino_db.administrator
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `timestamp_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table airduino_db.air_quality
CREATE TABLE IF NOT EXISTS `air_quality` (
  `id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `timestamp_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table airduino_db.device
CREATE TABLE IF NOT EXISTS `device` (
  `id` int(11) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table airduino_db.humidity
CREATE TABLE IF NOT EXISTS `humidity` (
  `id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `timestamp_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table airduino_db.temperature
CREATE TABLE IF NOT EXISTS `temperature` (
  `id` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `timestamp_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
