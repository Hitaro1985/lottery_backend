/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : skydeve1_lottery

 Target Server Type    : MySQL
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 31/08/2018 21:16:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `amount` double(8, 2) NOT NULL DEFAULT 0.00,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admins_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2018_08_13_043815_create_sessions_table', 1);
INSERT INTO `migrations` VALUES (4, '2018_08_13_112817_create_admins_table', 1);
INSERT INTO `migrations` VALUES (5, '2018_08_19_154359_create_roles_table', 1);
INSERT INTO `migrations` VALUES (6, '2018_08_31_045219_create_reports_table', 1);
INSERT INTO `migrations` VALUES (7, '2018_08_31_092039_create_rounds_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for reports
-- ----------------------------
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `roundname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roundnumber` int(11) NOT NULL,
  `rightNumber` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `second` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `third` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firsttoeighteen` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `eighteentothirtysix` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `blackcolor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redcolor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `odd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `even` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalmoney` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rounds
-- ----------------------------
DROP TABLE IF EXISTS `rounds`;
CREATE TABLE `rounds`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `r0` int(11) NOT NULL DEFAULT 0,
  `p0` int(11) NOT NULL DEFAULT 0,
  `r1` int(11) NOT NULL DEFAULT 0,
  `p1` int(11) NOT NULL DEFAULT 0,
  `r2` int(11) NOT NULL DEFAULT 0,
  `p2` int(11) NOT NULL DEFAULT 0,
  `r3` int(11) NOT NULL DEFAULT 0,
  `p3` int(11) NOT NULL DEFAULT 0,
  `r4` int(11) NOT NULL DEFAULT 0,
  `p4` int(11) NOT NULL DEFAULT 0,
  `r5` int(11) NOT NULL DEFAULT 0,
  `p5` int(11) NOT NULL DEFAULT 0,
  `r6` int(11) NOT NULL DEFAULT 0,
  `p6` int(11) NOT NULL DEFAULT 0,
  `r7` int(11) NOT NULL DEFAULT 0,
  `p7` int(11) NOT NULL DEFAULT 0,
  `r8` int(11) NOT NULL DEFAULT 0,
  `p8` int(11) NOT NULL DEFAULT 0,
  `r9` int(11) NOT NULL DEFAULT 0,
  `p9` int(11) NOT NULL DEFAULT 0,
  `r10` int(11) NOT NULL DEFAULT 0,
  `p10` int(11) NOT NULL DEFAULT 0,
  `r11` int(11) NOT NULL DEFAULT 0,
  `p11` int(11) NOT NULL DEFAULT 0,
  `r12` int(11) NOT NULL DEFAULT 0,
  `p12` int(11) NOT NULL DEFAULT 0,
  `r13` int(11) NOT NULL DEFAULT 0,
  `p13` int(11) NOT NULL DEFAULT 0,
  `r14` int(11) NOT NULL DEFAULT 0,
  `p14` int(11) NOT NULL DEFAULT 0,
  `r15` int(11) NOT NULL DEFAULT 0,
  `p15` int(11) NOT NULL DEFAULT 0,
  `r16` int(11) NOT NULL DEFAULT 0,
  `p16` int(11) NOT NULL DEFAULT 0,
  `r17` int(11) NOT NULL DEFAULT 0,
  `p17` int(11) NOT NULL DEFAULT 0,
  `r18` int(11) NOT NULL DEFAULT 0,
  `p18` int(11) NOT NULL DEFAULT 0,
  `r19` int(11) NOT NULL DEFAULT 0,
  `p19` int(11) NOT NULL DEFAULT 0,
  `r20` int(11) NOT NULL DEFAULT 0,
  `p20` int(11) NOT NULL DEFAULT 0,
  `r21` int(11) NOT NULL DEFAULT 0,
  `p21` int(11) NOT NULL DEFAULT 0,
  `r22` int(11) NOT NULL DEFAULT 0,
  `p22` int(11) NOT NULL DEFAULT 0,
  `r23` int(11) NOT NULL DEFAULT 0,
  `p23` int(11) NOT NULL DEFAULT 0,
  `r24` int(11) NOT NULL DEFAULT 0,
  `p24` int(11) NOT NULL DEFAULT 0,
  `r25` int(11) NOT NULL DEFAULT 0,
  `p25` int(11) NOT NULL DEFAULT 0,
  `r26` int(11) NOT NULL DEFAULT 0,
  `p26` int(11) NOT NULL DEFAULT 0,
  `r27` int(11) NOT NULL DEFAULT 0,
  `p27` int(11) NOT NULL DEFAULT 0,
  `r28` int(11) NOT NULL DEFAULT 0,
  `p28` int(11) NOT NULL DEFAULT 0,
  `r29` int(11) NOT NULL DEFAULT 0,
  `p29` int(11) NOT NULL DEFAULT 0,
  `r30` int(11) NOT NULL DEFAULT 0,
  `p30` int(11) NOT NULL DEFAULT 0,
  `r31` int(11) NOT NULL DEFAULT 0,
  `p31` int(11) NOT NULL DEFAULT 0,
  `r32` int(11) NOT NULL DEFAULT 0,
  `p32` int(11) NOT NULL DEFAULT 0,
  `r33` int(11) NOT NULL DEFAULT 0,
  `p33` int(11) NOT NULL DEFAULT 0,
  `r34` int(11) NOT NULL DEFAULT 0,
  `p34` int(11) NOT NULL DEFAULT 0,
  `r35` int(11) NOT NULL DEFAULT 0,
  `p35` int(11) NOT NULL DEFAULT 0,
  `r36` int(11) NOT NULL DEFAULT 0,
  `p36` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE INDEX `sessions_id_unique`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accept` int(11) NOT NULL DEFAULT 0,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
