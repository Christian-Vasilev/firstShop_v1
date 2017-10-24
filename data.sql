-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия на сървъра:            10.1.21-MariaDB - mariadb.org binary distribution
-- ОС на сървъра:                Win32
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for login
CREATE DATABASE IF NOT EXISTS `login` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `login`;

-- Дъмп структура за таблица login.inventory
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `product_quantity` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_MyProducts` (`user_id`),
  CONSTRAINT `FK_MyProducts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Дъмп структура за таблица login.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `product_price` varchar(50) NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Дъмп структура за таблица login.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '12500000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
