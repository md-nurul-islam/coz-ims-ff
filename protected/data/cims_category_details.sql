/*
Navicat MySQL Data Transfer

Source Server         : sitebuilder
Source Server Version : 50543
Source Host           : 192.168.0.109:3306
Source Database       : coz_ims_ff_db

Target Server Type    : MYSQL
Target Server Version : 50543
File Encoding         : 65001

Date: 2015-10-07 16:26:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cims_category_details
-- ----------------------------
DROP TABLE IF EXISTS `cims_category_details`;
CREATE TABLE `cims_category_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(120) NOT NULL,
  `category_description` text,
  `store_id` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_color
-- ----------------------------
DROP TABLE IF EXISTS `cims_color`;
CREATE TABLE `cims_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `hex_code` varchar(7) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_customer_details
-- ----------------------------
DROP TABLE IF EXISTS `cims_customer_details`;
CREATE TABLE `cims_customer_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(200) NOT NULL,
  `customer_contact1` varchar(100) DEFAULT NULL,
  `customer_contact2` varchar(100) DEFAULT NULL,
  `customer_address` text,
  `balance` decimal(13,2) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_exchange_products
-- ----------------------------
DROP TABLE IF EXISTS `cims_exchange_products`;
CREATE TABLE `cims_exchange_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` varchar(15) DEFAULT NULL,
  `main_product_details_id` int(11) DEFAULT NULL,
  `main_product_quantity` int(11) DEFAULT NULL,
  `main_product_subtotal` decimal(13,2) DEFAULT NULL,
  `exchange_product_details_id` int(11) DEFAULT NULL,
  `exchange_ref_num` bigint(30) DEFAULT NULL,
  `exchange_product_quantity` int(11) DEFAULT NULL,
  `exchange_product_subtotal` decimal(13,2) DEFAULT '0.00',
  `exchange_date` date DEFAULT NULL,
  `exchange_adjust_amount` decimal(13,2) DEFAULT NULL,
  `grand_total_payable` decimal(13,2) DEFAULT NULL,
  `grand_total_paid` decimal(13,2) DEFAULT NULL,
  `grand_total_balance` decimal(13,2) DEFAULT NULL,
  `due_payment_date` date DEFAULT NULL,
  `payment_method` tinyint(1) DEFAULT '1',
  `note` text,
  `dis_amount` decimal(13,2) DEFAULT '0.00',
  `store_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cims_exchange_products_ibfk_1` (`sales_id`),
  KEY `main_product_details_id` (`main_product_details_id`),
  KEY `exchange_product_details_id` (`exchange_product_details_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1139 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_grades
-- ----------------------------
DROP TABLE IF EXISTS `cims_grades`;
CREATE TABLE `cims_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `hex_code` varchar(7) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_product_details
-- ----------------------------
DROP TABLE IF EXISTS `cims_product_details`;
CREATE TABLE `cims_product_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `purchase_price` decimal(13,2) DEFAULT '0.00',
  `selling_price` decimal(13,2) DEFAULT '0.00',
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `uom` varchar(120) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `store_id` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2252 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_product_stock_avail
-- ----------------------------
DROP TABLE IF EXISTS `cims_product_stock_avail`;
CREATE TABLE `cims_product_stock_avail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_details_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `store_id` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3608 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_product_stock_entries
-- ----------------------------
DROP TABLE IF EXISTS `cims_product_stock_entries`;
CREATE TABLE `cims_product_stock_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` varchar(15) NOT NULL,
  `billnumber` varchar(120) DEFAULT NULL,
  `ref_num` varchar(30) DEFAULT '0',
  `supplier_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_details_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_price` decimal(13,2) NOT NULL,
  `selling_price` decimal(13,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `payment_type` tinyint(2) NOT NULL,
  `item_subtotal` decimal(13,2) NOT NULL,
  `note` text,
  `grand_total_payable` decimal(13,2) NOT NULL,
  `grand_total_paid` decimal(13,2) NOT NULL,
  `grand_total_balance` decimal(13,2) NOT NULL DEFAULT '0.00',
  `due_payment_date` date DEFAULT NULL,
  `serial_num` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39699 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_product_stock_sales
-- ----------------------------
DROP TABLE IF EXISTS `cims_product_stock_sales`;
CREATE TABLE `cims_product_stock_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` varchar(15) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `billnumber` varchar(150) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `ref_num` bigint(30) DEFAULT NULL,
  `product_details_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_selling_price` decimal(13,2) NOT NULL,
  `serial_num` int(11) NOT NULL,
  `sale_date` datetime NOT NULL,
  `item_subtotal` decimal(13,2) NOT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL,
  `dis_amount` decimal(13,2) DEFAULT NULL,
  `tax` decimal(13,2) DEFAULT NULL,
  `tax_dis` text,
  `grand_total_payable` decimal(13,2) NOT NULL,
  `grand_total_paid` decimal(13,2) NOT NULL,
  `grand_total_balance` decimal(13,2) NOT NULL DEFAULT '0.00',
  `due_payment_date` datetime DEFAULT NULL,
  `payment_method` tinyint(2) DEFAULT NULL,
  `note` text,
  `store_id` int(11) NOT NULL DEFAULT '1',
  `is_advance` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_id` (`sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122279 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_store_details
-- ----------------------------
DROP TABLE IF EXISTS `cims_store_details`;
CREATE TABLE `cims_store_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `log` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `pin` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_supplier_details
-- ----------------------------
DROP TABLE IF EXISTS `cims_supplier_details`;
CREATE TABLE `cims_supplier_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_address` text,
  `supplier_contact1` varchar(100) DEFAULT NULL,
  `supplier_contact2` varchar(100) DEFAULT NULL,
  `balance` decimal(13,2) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `store_id` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_transactions
-- ----------------------------
DROP TABLE IF EXISTS `cims_transactions`;
CREATE TABLE `cims_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `subtotal` decimal(13,2) DEFAULT NULL,
  `payment` decimal(13,2) DEFAULT NULL,
  `balance` decimal(13,2) DEFAULT NULL,
  `due` decimal(13,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `rid` varchar(100) DEFAULT NULL,
  `receiptid` varchar(200) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_uom_details
-- ----------------------------
DROP TABLE IF EXISTS `cims_uom_details`;
CREATE TABLE `cims_uom_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `spec` varchar(120) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cims_user
-- ----------------------------
DROP TABLE IF EXISTS `cims_user`;
CREATE TABLE `cims_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `user_type` tinyint(2) NOT NULL DEFAULT '2',
  `store_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
