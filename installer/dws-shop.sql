/*
 Navicat Premium Data Transfer

 Source Server         : [MariaDB] localhost
 Source Server Type    : MariaDB
 Source Server Version : 110502 (11.5.2-MariaDB-log)
 Source Host           : localhost:3306
 Source Schema         : dws-shop

 Target Server Type    : MariaDB
 Target Server Version : 110502 (11.5.2-MariaDB-log)
 File Encoding         : 65001

 Date: 26/01/2025 23:37:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `category_type` enum('product','option') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `category_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `select_type` enum('sigle','nolimit','limit') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `select_limit` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'จานหลัก', 'product', NULL, NULL, NULL);
INSERT INTO `categories` VALUES (2, 'ราคาพิเศษ', 'option', NULL, 'nolimit', NULL);
INSERT INTO `categories` VALUES (3, 'ราคาทั่วไป', 'option', NULL, 'nolimit', NULL);

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of members
-- ----------------------------

-- ----------------------------
-- Table structure for members_contacts
-- ----------------------------
DROP TABLE IF EXISTS `members_contacts`;
CREATE TABLE `members_contacts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NULL DEFAULT NULL,
  `contact_type` enum('tel','address','map_latlong','email','facebook','line') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `contact_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `member_id`(`member_id` ASC) USING BTREE,
  CONSTRAINT `members_contacts_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of members_contacts
-- ----------------------------

-- ----------------------------
-- Table structure for members_keys
-- ----------------------------
DROP TABLE IF EXISTS `members_keys`;
CREATE TABLE `members_keys`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_type` enum('line','messenger') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'line',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of members_keys
-- ----------------------------

-- ----------------------------
-- Table structure for members_sessions
-- ----------------------------
DROP TABLE IF EXISTS `members_sessions`;
CREATE TABLE `members_sessions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `session_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of members_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NULL DEFAULT NULL,
  `is_checkout` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `is_paid` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `create_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(255) NULL DEFAULT NULL,
  `product_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `product_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `product_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id` ASC) USING BTREE,
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 1, 'ข้าวต้ม', NULL, NULL);

-- ----------------------------
-- Table structure for products_options
-- ----------------------------
DROP TABLE IF EXISTS `products_options`;
CREATE TABLE `products_options`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NULL DEFAULT NULL,
  `category_id` int(11) NULL DEFAULT NULL,
  `option_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `option_price` int(11) NULL DEFAULT NULL,
  `option_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  INDEX `category_id`(`category_id` ASC) USING BTREE,
  CONSTRAINT `products_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `products_options_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products_options
-- ----------------------------
INSERT INTO `products_options` VALUES (1, 1, 1, 'กุ้ง', 15, NULL);
INSERT INTO `products_options` VALUES (2, 1, 1, 'ไข่เยี่ยวม้า', 15, NULL);
INSERT INTO `products_options` VALUES (3, 1, 1, 'เบคอน', 15, NULL);
INSERT INTO `products_options` VALUES (4, 1, 1, 'ซี่โครงอบชีส', 15, NULL);
INSERT INTO `products_options` VALUES (5, 1, 1, 'ตับหมู', 15, NULL);
INSERT INTO `products_options` VALUES (6, 1, 1, 'หมูเด้ง', 15, NULL);
INSERT INTO `products_options` VALUES (7, 1, 1, 'หมูกรอบ', 15, NULL);
INSERT INTO `products_options` VALUES (8, 1, 1, 'ไข่เค็ม', 15, NULL);
INSERT INTO `products_options` VALUES (9, 1, 2, 'ไข่ต้ม', 10, NULL);
INSERT INTO `products_options` VALUES (10, 1, 2, 'เห็ดหอม', 10, NULL);
INSERT INTO `products_options` VALUES (11, 1, 2, 'ปูอัด', 10, NULL);
INSERT INTO `products_options` VALUES (12, 1, 2, 'ไก่ฉีก', 10, NULL);
INSERT INTO `products_options` VALUES (13, 1, 2, 'ไข่ลวก', 10, NULL);
INSERT INTO `products_options` VALUES (14, 1, 2, 'หมูยอ', 10, NULL);
INSERT INTO `products_options` VALUES (15, 1, 2, 'หมูหยอง', 10, NULL);
INSERT INTO `products_options` VALUES (16, 1, 2, 'เห็ดออรินจิ', 10, NULL);
INSERT INTO `products_options` VALUES (17, 1, 2, 'กุนเชียง', 10, NULL);
INSERT INTO `products_options` VALUES (18, 1, 2, 'หมูสับผัดซอส', 10, NULL);

-- ----------------------------
-- Table structure for shops
-- ----------------------------
DROP TABLE IF EXISTS `shops`;
CREATE TABLE `shops`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `shop_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shops
-- ----------------------------
INSERT INTO `shops` VALUES (1, 'ข้าวต้มหน้าแน่น', NULL);

-- ----------------------------
-- Table structure for shops_branches
-- ----------------------------
DROP TABLE IF EXISTS `shops_branches`;
CREATE TABLE `shops_branches`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NULL DEFAULT NULL,
  `branch_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `shop_id`(`shop_id` ASC) USING BTREE,
  CONSTRAINT `shops_branches_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shops_branches
-- ----------------------------
INSERT INTO `shops_branches` VALUES (1, 1, 'สาขาใหญ่');

-- ----------------------------
-- Table structure for shops_contacts
-- ----------------------------
DROP TABLE IF EXISTS `shops_contacts`;
CREATE TABLE `shops_contacts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NULL DEFAULT NULL,
  `contact_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `contact_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `shop_id`(`shop_id` ASC) USING BTREE,
  CONSTRAINT `shops_contacts_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shops_contacts
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
