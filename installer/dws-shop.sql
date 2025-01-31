/*
 Navicat Premium Dump SQL

 Source Server         : MariaDB_localhost
 Source Server Type    : MariaDB
 Source Server Version : 110502 (11.5.2-MariaDB-log)
 Source Host           : localhost:3306
 Source Schema         : dws-shop

 Target Server Type    : MariaDB
 Target Server Version : 110502 (11.5.2-MariaDB-log)
 File Encoding         : 65001

 Date: 31/01/2025 16:38:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NULL DEFAULT NULL,
  `category_sort` int(11) NULL DEFAULT NULL,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `category_type` enum('product','option') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `category_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `category_status` enum('published','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'published',
  `select_type` enum('sigle','nolimit','limit') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'sigle',
  `select_limit` int(255) NULL DEFAULT 0,
  `select_require` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Y',
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `shop_id`(`shop_id` ASC) USING BTREE,
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 1, 1, 'จานหลัก', 'product', NULL, 'published', 'nolimit', NULL, 'Y', '2025-01-31 14:31:23');
INSERT INTO `categories` VALUES (2, 1, 1, 'ท็อปปิ้ง', 'option', NULL, 'published', 'nolimit', NULL, 'Y', '2025-01-31 14:31:25');
INSERT INTO `categories` VALUES (3, 1, 2, 'บรรจุภัณฑ์', 'option', NULL, 'published', 'nolimit', NULL, 'Y', '2025-01-31 14:31:27');

-- ----------------------------
-- Table structure for discounts
-- ----------------------------
DROP TABLE IF EXISTS `discounts`;
CREATE TABLE `discounts`  (
  `id` int(11) NOT NULL,
  `discount_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `discount_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `discount_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `discount_start` datetime NULL DEFAULT current_timestamp(),
  `discount_end` datetime NULL DEFAULT current_timestamp(),
  `discount_type` enum('fix','percen') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'fix',
  `discount_value` int(11) NULL DEFAULT 1,
  `discount_max` int(11) NULL DEFAULT 0,
  `order_min_price` int(11) NULL DEFAULT 0,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of discounts
-- ----------------------------

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
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
  `contact_status` enum('created','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'created',
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
  `member_id` int(11) NULL DEFAULT NULL,
  `key_type` enum('line','messenger') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'line',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `member_id`(`member_id` ASC) USING BTREE,
  CONSTRAINT `members_keys_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
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
  `member_id` int(11) NULL DEFAULT NULL,
  `ipaddress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `session_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `member_id`(`member_id` ASC) USING BTREE,
  CONSTRAINT `members_sessions_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
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
  `product_id` int(11) NULL DEFAULT NULL,
  `product_qty` int(11) NULL DEFAULT 1,
  `is_checkout` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `is_paid` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `discount_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `price_order` decimal(10, 2) NULL DEFAULT NULL,
  `price_shipping` decimal(10, 2) NULL DEFAULT NULL,
  `price_discount` decimal(10, 2) NULL DEFAULT NULL,
  `price_vat` decimal(10, 2) NULL DEFAULT NULL,
  `price_final` decimal(10, 2) NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for orders_options
-- ----------------------------
DROP TABLE IF EXISTS `orders_options`;
CREATE TABLE `orders_options`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NULL DEFAULT NULL,
  `option_id` int(11) NULL DEFAULT NULL,
  `option_qty` int(11) NULL DEFAULT 1,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `option_id`(`option_id` ASC) USING BTREE,
  INDEX `order_id`(`order_id` ASC) USING BTREE,
  CONSTRAINT `orders_options_ibfk_1` FOREIGN KEY (`option_id`) REFERENCES `products_options` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `orders_options_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders_options
-- ----------------------------

-- ----------------------------
-- Table structure for orders_reviews
-- ----------------------------
DROP TABLE IF EXISTS `orders_reviews`;
CREATE TABLE `orders_reviews`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NULL DEFAULT NULL,
  `review_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `review_star` int(11) NULL DEFAULT NULL,
  `member_id` int(11) NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id` ASC) USING BTREE,
  INDEX `member_id`(`member_id` ASC) USING BTREE,
  CONSTRAINT `orders_reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `orders_reviews_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders_reviews
-- ----------------------------

-- ----------------------------
-- Table structure for payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `method_icon_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `method_icon_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment_methods
-- ----------------------------
INSERT INTO `payment_methods` VALUES (1, 'QRCode', 'fa-solid fa-qrcode', NULL, '2025-01-31 10:11:44');

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
  `product_status` enum('published','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'published',
  `product_sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `product_barcode` int(11) NULL DEFAULT NULL,
  `product_qty` int(11) NULL DEFAULT -1,
  `product_price` int(11) NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id` ASC) USING BTREE,
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 1, 'ข้าวต้ม', NULL, NULL, 'published', NULL, NULL, -1, 10, '2025-01-30 23:32:47');

-- ----------------------------
-- Table structure for products_images
-- ----------------------------
DROP TABLE IF EXISTS `products_images`;
CREATE TABLE `products_images`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NULL DEFAULT NULL,
  `file_sort` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `file_status` enum('publish','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'publish',
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `products_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products_images
-- ----------------------------

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
  `option_status` enum('created','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `option_qty` int(11) NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  INDEX `category_id`(`category_id` ASC) USING BTREE,
  CONSTRAINT `products_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `products_options_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products_options
-- ----------------------------
INSERT INTO `products_options` VALUES (1, 1, 1, 'กุ้ง', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (2, 1, 1, 'ไข่เยี่ยวม้า', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (3, 1, 1, 'เบคอน', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (4, 1, 1, 'ซี่โครงอบชีส', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (5, 1, 1, 'ตับหมู', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (6, 1, 1, 'หมูเด้ง', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (7, 1, 1, 'หมูกรอบ', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (8, 1, 1, 'ไข่เค็ม', 15, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (9, 1, 2, 'ไข่ต้ม', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (10, 1, 2, 'เห็ดหอม', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (11, 1, 2, 'ปูอัด', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (12, 1, 2, 'ไก่ฉีก', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (13, 1, 2, 'ไข่ลวก', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (14, 1, 2, 'หมูยอ', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (15, 1, 2, 'หมูหยอง', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (16, 1, 2, 'เห็ดออรินจิ', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (17, 1, 2, 'กุนเชียง', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');
INSERT INTO `products_options` VALUES (18, 1, 2, 'หมูสับผัดซอส', 10, NULL, NULL, NULL, '2025-01-30 23:34:57');

-- ----------------------------
-- Table structure for shippings_methods
-- ----------------------------
DROP TABLE IF EXISTS `shippings_methods`;
CREATE TABLE `shippings_methods`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `method_icon_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `method_icon_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shippings_methods
-- ----------------------------
INSERT INTO `shippings_methods` VALUES (1, 'รถจักรยานยนต์', 'fa-solid fa-moped', 'shipping_method_01', '2025-01-31 09:46:24');

-- ----------------------------
-- Table structure for shippings_rates
-- ----------------------------
DROP TABLE IF EXISTS `shippings_rates`;
CREATE TABLE `shippings_rates`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_id` int(11) NULL DEFAULT NULL,
  `rate_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rate_min` int(11) NULL DEFAULT NULL,
  `rate_max` int(255) NULL DEFAULT NULL,
  `rate_price` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shippings_rates
-- ----------------------------
INSERT INTO `shippings_rates` VALUES (1, 1, 'ฟรี 3 กม. แรก', 0, 3, 0);
INSERT INTO `shippings_rates` VALUES (2, 1, '3-5 กม.', 3, 5, 20);
INSERT INTO `shippings_rates` VALUES (3, 1, '5-8 กม.', 5, 8, 30);
INSERT INTO `shippings_rates` VALUES (4, 1, '8 กม. ขึ้นไป', 8, -1, 40);

-- ----------------------------
-- Table structure for shops
-- ----------------------------
DROP TABLE IF EXISTS `shops`;
CREATE TABLE `shops`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `shop_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `shop_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `shop_status` enum('published','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'published',
  `shop_image_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `shop_image_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shops
-- ----------------------------
INSERT INTO `shops` VALUES (1, NULL, 'ข้าวต้มหน้าแน่น', NULL, 'published', NULL, NULL, '2025-01-30 23:38:50');

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
  `contact_type` enum('tel','facebook','line','instagram','telegram','link','navigation') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'tel',
  `contact_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `shop_id`(`shop_id` ASC) USING BTREE,
  CONSTRAINT `shops_contacts_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shops_contacts
-- ----------------------------
INSERT INTO `shops_contacts` VALUES (1, 1, 'tel', '0999999999', '2025-01-31 00:36:48');
INSERT INTO `shops_contacts` VALUES (2, 1, 'line', '@12341234', '2025-01-31 00:39:20');

-- ----------------------------
-- Table structure for shops_favorite
-- ----------------------------
DROP TABLE IF EXISTS `shops_favorite`;
CREATE TABLE `shops_favorite`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NULL DEFAULT NULL,
  `member_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `shop_id`(`shop_id` ASC) USING BTREE,
  CONSTRAINT `shops_favorite_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shops_favorite
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
