-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.37 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for web_viver
CREATE DATABASE IF NOT EXISTS `web_viver` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `web_viver`;

-- Dumping structure for table web_viver.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `idcart` int NOT NULL AUTO_INCREMENT,
  `stock_stock_id` int NOT NULL,
  `cart_qty` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`idcart`),
  KEY `fk_cart_stock1_idx` (`stock_stock_id`),
  KEY `fk_cart_user1_idx` (`user_email`),
  CONSTRAINT `fk_cart_stock1` FOREIGN KEY (`stock_stock_id`) REFERENCES `stock` (`stock_id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cat_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.color
CREATE TABLE IF NOT EXISTS `color` (
  `color_id` int NOT NULL AUTO_INCREMENT,
  `color_name` varchar(45) DEFAULT NULL,
  `color_hex` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.order
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int NOT NULL,
  `shipping_address` varchar(100) DEFAULT NULL,
  `shipping_city` varchar(45) DEFAULT NULL,
  `shipping_province` varchar(45) DEFAULT NULL,
  `shipping_district` varchar(45) DEFAULT NULL,
  `shipping_country` varchar(45) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_order_user1_idx` (`user_email`),
  CONSTRAINT `fk_order_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.order_has_stock
CREATE TABLE IF NOT EXISTS `order_has_stock` (
  `order_order_id` int NOT NULL,
  `stock_stock_id` int NOT NULL,
  `order_qty` int DEFAULT NULL,
  PRIMARY KEY (`order_order_id`,`stock_stock_id`),
  KEY `fk_order_has_stock_stock1_idx` (`stock_stock_id`),
  KEY `fk_order_has_stock_order1_idx` (`order_order_id`),
  CONSTRAINT `fk_order_has_stock_order1` FOREIGN KEY (`order_order_id`) REFERENCES `order` (`order_id`),
  CONSTRAINT `fk_order_has_stock_stock1` FOREIGN KEY (`stock_stock_id`) REFERENCES `stock` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.order_status
CREATE TABLE IF NOT EXISTS `order_status` (
  `idorder_status` int NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `order_order_id` int NOT NULL,
  PRIMARY KEY (`idorder_status`),
  KEY `fk_order_status_order_idx` (`order_order_id`),
  CONSTRAINT `fk_order_status_order` FOREIGN KEY (`order_order_id`) REFERENCES `order` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `product_description` varchar(500) NOT NULL,
  `is_active` int DEFAULT '1',
  `category_id` int DEFAULT '1',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(150) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.product_images_has_product
CREATE TABLE IF NOT EXISTS `product_images_has_product` (
  `product_images_image_id` int NOT NULL,
  `product_product_id` int NOT NULL,
  PRIMARY KEY (`product_images_image_id`,`product_product_id`),
  KEY `fk_product_images_has_product_product1_idx` (`product_product_id`),
  KEY `fk_product_images_has_product_product_images1_idx` (`product_images_image_id`),
  CONSTRAINT `fk_product_images_has_product_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `fk_product_images_has_product_product_images1` FOREIGN KEY (`product_images_image_id`) REFERENCES `product_images` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.size
CREATE TABLE IF NOT EXISTS `size` (
  `size_iid` int NOT NULL AUTO_INCREMENT,
  `size` varchar(45) NOT NULL,
  PRIMARY KEY (`size_iid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.stock
CREATE TABLE IF NOT EXISTS `stock` (
  `stock_id` int NOT NULL AUTO_INCREMENT,
  `stock_price` double DEFAULT NULL,
  `color_color_id` int NOT NULL,
  `size_size_iid` int NOT NULL,
  `product_product_id` int NOT NULL,
  `qty` int NOT NULL,
  `shipping_cost` double NOT NULL,
  PRIMARY KEY (`stock_id`),
  KEY `fk_stock_color_idx` (`color_color_id`),
  KEY `fk_stock_size1_idx` (`size_size_iid`),
  KEY `fk_stock_product1_idx` (`product_product_id`),
  CONSTRAINT `fk_stock_color` FOREIGN KEY (`color_color_id`) REFERENCES `color` (`color_id`),
  CONSTRAINT `fk_stock_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `fk_stock_size1` FOREIGN KEY (`size_size_iid`) REFERENCES `size` (`size_iid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.user
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `mobile` varchar(12) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `vc` varchar(50) DEFAULT NULL,
  `is_verified` int DEFAULT '0',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table web_viver.whish_list
CREATE TABLE IF NOT EXISTS `whish_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `product_product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_whish_list_user1_idx` (`user_email`),
  KEY `fk_whish_list_product1_idx` (`product_product_id`),
  CONSTRAINT `fk_whish_list_product1` FOREIGN KEY (`product_product_id`) REFERENCES `product` (`product_id`),
  CONSTRAINT `fk_whish_list_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
