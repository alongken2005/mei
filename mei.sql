/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50515
Source Host           : localhost:3306
Source Database       : mei

Target Server Type    : MYSQL
Target Server Version : 50515
File Encoding         : 65001

Date: 2014-09-01 18:31:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mt_adminer
-- ----------------------------
DROP TABLE IF EXISTS `mt_adminer`;
CREATE TABLE `mt_adminer` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `power` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ctime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mt_adminer
-- ----------------------------
INSERT INTO `mt_adminer` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '1', '0');

-- ----------------------------
-- Table structure for mt_pageurl
-- ----------------------------
DROP TABLE IF EXISTS `mt_pageurl`;
CREATE TABLE `mt_pageurl` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageUrl` varchar(255) DEFAULT NULL,
  `siteId` int(10) DEFAULT NULL,
  `state` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mt_pageurl
-- ----------------------------
INSERT INTO `mt_pageurl` VALUES ('1', 'http://www.juemei.cc/html/list/PiaCdJCbHHaammbaC.html', '1', '0');
