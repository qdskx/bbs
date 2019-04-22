/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : 9314

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2017-12-05 22:46:54
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `9314_category`
-- ----------------------------
DROP TABLE IF EXISTS `9314_category`;
CREATE TABLE `9314_category` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `classname` varchar(60) NOT NULL,
  `parentid` int(10) NOT NULL,
  `replynum` int(10) NOT NULL DEFAULT '0',
  `postnum` int(10) NOT NULL DEFAULT '0',
  `compere` char(10) DEFAULT NULL COMMENT '版主',
  `classpic` varchar(200) NOT NULL DEFAULT 'public/images/forum.gif' COMMENT '板块的图片',
  `orderby` smallint(6) NOT NULL DEFAULT '0',
  `lastpost` varchar(600) DEFAULT NULL,
  `ispass` tinyint(2) NOT NULL DEFAULT '1' COMMENT '审核状态,1为通过,0为未通过',
  `isremove` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否被删除',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 9314_category
-- ----------------------------
INSERT INTO 9314_category VALUES ('3', 'PHP框架', '1', '0', '1', '0', 'public/img/forum.gif', '3', '1512385758', '1', '0');
INSERT INTO 9314_category VALUES ('4', '开源产品', '1', '0', '1', '0', 'public/img/forum.gif', '2', '0', '1', '0');
INSERT INTO 9314_category VALUES ('5', '内核源码', '1', '0', '0', '0', 'public/img/forum.gif', '5', '0', '1', '0');
INSERT INTO 9314_category VALUES ('6', '进阶讨论', '1', '0', '1', '1', 'public/img/forum.gif', '1', '1512388124', '1', '0');
INSERT INTO 9314_category VALUES ('7', '名人故事', '2', '0', '0', '0', 'public/img/forum.gif', '1', '0', '1', '0');
INSERT INTO 9314_category VALUES ('8', '经验分享', '2', '0', '0', '0', 'public/img/forum.gif', '2', '0', '1', '0');
INSERT INTO 9314_category VALUES ('9', '求职招聘', '2', '0', '0', '0', 'public/img/forum.gif', '3', '0', '1', '0');
INSERT INTO 9314_category VALUES ('1', 'PHP技术交流', '0', '0', '3', '0', 'public/img/forum.gif', '3', '1512388124', '1', '0');
INSERT INTO 9314_category VALUES ('2', '程序人生', '0', '0', '1', '0', 'public/img/forum.gif', '1', '1512214426', '1', '0');
INSERT INTO 9314_category VALUES ('13', '一季飞舞', '0', '7', '12', '0', 'public/img/forum.gif', '6', '1512454936', '1', '0');
INSERT INTO 9314_category VALUES ('14', '时光巷陌', '13', '0', '1', '0', 'public/img/forum.gif', '11', '1512388886', '1', '0');
INSERT INTO 9314_category VALUES ('15', '凭兰秋思', '13', '0', '0', '0', 'public/img/forum.gif', '12', '0', '1', '0');
INSERT INTO 9314_category VALUES ('16', ' 凤凰台上忆吹箫', '0', '0', '1', '0', 'public/img/forum.gif', '21', '1512213418', '1', '0');
INSERT INTO 9314_category VALUES ('17', '恋慕如斯', '16', '0', '0', '0', 'public/img/forum.gif', '17', '0', '1', '0');
INSERT INTO 9314_category VALUES ('18', ' 断桥素伞', '16', '0', '0', '0', 'public/img/forum.gif', '18', '0', '1', '0');
INSERT INTO 9314_category VALUES ('19', '北以晨安', '13', '7', '11', '4', 'public/img/forum.gif', '0', '1512442164', '1', '0');
INSERT INTO 9314_category VALUES ('20', '琴瑟相思引', '16', '0', '0', '0', 'public/img/forum.gif', '20', '0', '1', '0');
INSERT INTO 9314_category VALUES ('36', '77777773', '33', '0', '0', '0', 'public/images/forum.gif', '0', '0', '1', '0');
INSERT INTO 9314_category VALUES ('26', '如花美眷', '16', '0', '0', '0', 'public/img/forum.gif', '0', '0', '1', '0');
INSERT INTO 9314_category VALUES ('27', '落晚芳菲', '13', '0', '1', '0', 'public/img/tle1.png', '0', '1512454936', '1', '0');
INSERT INTO 9314_category VALUES ('25', '彼年微凉', '13', '0', '1', '0', 'public/img/forum.gif', '0', '1512391926', '1', '0');
INSERT INTO 9314_category VALUES ('28', ' 兽炉沈水烟', '0', '0', '0', '0', 'public/images/forum.gif', '10', '0', '1', '0');
INSERT INTO 9314_category VALUES ('29', '彼岸蔚蓝', '28', '0', '0', '0', 'public/images/forum.gif', '0', '0', '1', '0');
INSERT INTO 9314_category VALUES ('33', '于鱼鱼鱼鱼1', '0', '0', '0', '', 'public/images/forum.gif', '45', '0', '1', '0');
INSERT INTO 9314_category VALUES ('34', '一样2', '33', '0', '0', '0', 'public/images/forum.gif', '5', '0', '1', '0');
INSERT INTO 9314_category VALUES ('37', 'yyyyyyyyyy1', '0', '0', '0', '', 'public/images/forum.gif', '0', '0', '1', '0');
INSERT INTO 9314_category VALUES ('38', 'uuuuuuu2', '37', '0', '0', '0', 'public/images/forum.gif', '0', '0', '0', '0');
INSERT INTO 9314_category VALUES ('39', '3m', '37', '0', '0', '0', 'public/images/forum.gif', '0', '0', '0', '0');
INSERT INTO 9314_category VALUES ('40', 'hhhhh4', '33', '0', '0', '0', 'public/images/forum.gif', '0', '0', '1', '0');
INSERT INTO 9314_category VALUES ('41', 'EEEEEEEE', '37', '0', '0', null, 'public/images/forum.gif', '0', null, '0', '0');
INSERT INTO 9314_category VALUES ('42', 'FFFFFFFFFF', '0', '0', '0', null, 'public/images/forum.gif', '0', null, '0', '0')

-- ----------------------------
-- Table structure for `9314_closeip`
-- ----------------------------
DROP TABLE IF EXISTS `9314_closeip`;
CREATE TABLE `9314_closeip` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `ip` int(12) NOT NULL,
  `addtime` int(12) NOT NULL,
  `overtime` int(11) DEFAULT NULL,
  `forever` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否永久禁止,默认为0,不永久禁止',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 9314_closeip
-- ----------------------------

-- ----------------------------
-- Table structure for `9314_details`
-- ----------------------------
DROP TABLE IF EXISTS `9314_details`;
CREATE TABLE `9314_details` (
  `tid` int(10) NOT NULL AUTO_INCREMENT,
  `tidtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '判断是发帖还是回帖,0为回帖,1为发帖',
  `replyid` int(10) NOT NULL DEFAULT '0' COMMENT '看用户针对哪一条帖子做的回复,默认为0,即发帖',
  `authorid` int(10) NOT NULL,
  `title` varchar(600) DEFAULT NULL,
  `content` mediumtext NOT NULL,
  `postime` int(12) NOT NULL,
  `postip` int(12) NOT NULL,
  `cid` int(10) NOT NULL COMMENT '板块cid',
  `replycount` int(12) NOT NULL DEFAULT '0' COMMENT '回复数量',
  `views` int(12) NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `ishot` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否是热门贴,默认0为非热门,1为热门',
  `essence` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否是精华帖,0为非精华帖,1为精华帖',
  `istop` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否置顶,默认0不置顶,1置顶',
  `toptime` int(10) DEFAULT '0' COMMENT '置顶时间',
  `price` smallint(3) NOT NULL DEFAULT '0' COMMENT '帖子售价',
  `isdel` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否放入回收站,默认为0不放入,1加入回收站',
  `ishighlight` char(10) DEFAULT NULL COMMENT '是否高亮',
  `isdisplay` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否屏蔽回复的内容,默认0不屏蔽,1屏蔽',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 9314_details
-- ----------------------------
INSERT INTO 9314_details VALUES ('1', '1', '0', '4', 'efref', 'ergrg', '1512206843', '2130706433', '19', '0', '0', '0', '1', '0', '0', '4', '0', null, '0');
INSERT INTO 9314_details VALUES ('2', '1', '0', '4', 'free', '个人', '1512208396', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '1', null, '0');
INSERT INTO 9314_details VALUES ('3', '1', '0', '4', 'grt', 'rtg', '1512208451', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '1', null, '0');
INSERT INTO 9314_details VALUES ('4', '1', '0', '4', 'fffff', 'dfser', '1512208571', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('5', '1', '0', '4', 'sdfsc', 'sdcde', '1512209241', '2130706433', '19', '7', '0', '0', '0', '0', '0', '3', '0', null, '0');
INSERT INTO 9314_details VALUES ('6', '1', '0', '1', '如图', '功夫功夫', '1512213418', '2130706433', '18', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('7', '1', '0', '1', 'ffff飞凤飞飞', '啊水滴石穿', '1512214426', '2130706433', '9', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('8', '1', '0', '1', 'tyt', 'dvcdv', '1512215266', '2130706433', '15', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('9', '1', '0', '1', '规范化菲', 'sea发热菲', '1512224746', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('10', '1', '0', '1', 'rgftrg ', 'erf e', '1512224816', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('11', '1', '0', '4', '发反反复复', '<p>\r\n	房东v</p>\r\n', '1512348128', '2130706433', '4', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('12', '1', '0', '1', 'ffffffff ', '<p>\r\n	ffffffffffffff&nbsp;</p>\r\n', '1512385758', '2130706433', '3', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('13', '1', '0', '1', '发DVD', '<p>\r\n	成都市场是</p>\r\n', '1512388124', '2130706433', '6', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('14', '1', '0', '1', 'fgfgf', '<p>\r\n	rtgr4tgfe</p>\r\n', '1512388886', '2130706433', '14', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('15', '1', '0', '5', '修改头像成功啦', '<p>\r\n	哈哈哈哈哈哈哈哈哈哈哈或或或或</p>\r\n', '1512391926', '2130706433', '25', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('16', '1', '0', '5', '法国分别', '<p>\r\n	松岛枫侧</p>\r\n', '1512392607', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('17', '0', '5', '4', null, '<p>\r\n	hey ! i saw you !!</p>\r\n', '1512439835', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('18', '0', '5', '4', null, '<p>\r\n	发现回复的时候大板块的replynum没有加1</p>\r\n', '1512440040', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('19', '0', '5', '4', null, '<p>\r\n	这次看有没有加一啊???</p>\r\n', '1512440650', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('20', '0', '5', '4', null, '<p>\r\n	那这一次呢？？？</p>\r\n', '1512440714', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('21', '0', '5', '4', null, '<p>\r\n	最后一次？？？</p>\r\n', '1512440765', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '0', null, '0');
INSERT INTO 9314_details VALUES ('22', '0', '5', '4', null, '<p>\r\n	对啦</p>\r\n', '1512441936', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '1', null, '0');
INSERT INTO 9314_details VALUES ('23', '0', '5', '4', null, '<p>\r\n	黑</p>\r\n', '1512441985', '2130706433', '19', '0', '0', '0', '0', '0', '0', '0', '1', null, '0');
INSERT INTO 9314_details VALUES ('24', '1', '0', '4', 'erewe', '<p>\r\n	dfwe</p>\r\n', '1512442164', '2130706433', '19', '0', '0', '0', '0', '0', '0', '2', '0', null, '0');
INSERT INTO 9314_details VALUES ('25', '1', '0', '1', '吞吞吐吐', '<p>\r\n	你妈妈木木木木木木木</p>\r\n', '1512454936', '2130706433', '27', '0', '0', '0', '0', '0', '0', '9', '0', null, '0')

-- ----------------------------
-- Table structure for `9314_link`
-- ----------------------------
DROP TABLE IF EXISTS `9314_link`;
CREATE TABLE `9314_link` (
  `lid` smallint(6) NOT NULL AUTO_INCREMENT,
  `showorder` tinyint(2) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` mediumtext,
  `logo` varchar(255) DEFAULT NULL,
  `addtime` int(12) NOT NULL,
  `ishow` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否被显示',
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 9314_link
-- ----------------------------
INSERT INTO 9314_link VALUES ('1', '1', '官方论坛', 'http://www.discuz.net', '提供最新 Discuz! 产品新闻、软件下载与技术交流', 'public/img/link.gif', '1508649238', '0');
INSERT INTO 9314_link VALUES ('2', '3', '漫游平台', 'http://www.manyou.com/', '', '', '2147483647', '0');
INSERT INTO 9314_link VALUES ('3', '2', 'Yeswan', 'http://www.yeswan.com/', '', '', '1508649284', '0');
INSERT INTO 9314_link VALUES ('4', '1', '我的领地', 'http://www.5d6d.com/', '', '', '2147483647', '1');
INSERT INTO 9314_link VALUES ('5', '4', '百度', 'http://www.baidu.com', '', '', '1508999422', '0');
INSERT INTO 9314_link VALUES ('6', '5', '亡与栀枯', 'http://www.skxto9314.com', '个人网站,bbs论坛', 'hi chuan', '1512395837', '0');
INSERT INTO 9314_link VALUES ('7', '6', '风花雪月话阳光', 'http://www.skxto9314.com', '若有风来 便随风来 等风走 若有思念来袭 便随思念来 等思念走 如此 定然会有痛苦吧  或许会留下来就此生活吧 或许在生活中会就此离去吧', '没关系,是爱情', '1512395837', '0');
INSERT INTO 9314_link VALUES ('8', '56', 'rrrrrrrrrrr', 'tttttttttt', 'hhhhhhhhh', 'hhhhhhhh', '1508999488', '1');
INSERT INTO 9314_link VALUES ('9', '8', 'EWR', '', '', '', '1512395861', '0');

-- ----------------------------
-- Table structure for `9314_order`
-- ----------------------------
DROP TABLE IF EXISTS `9314_order`;
CREATE TABLE `9314_order` (
  `oid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `addtime` int(11) NOT NULL,
  `ispay` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否已付款',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 9314_order
-- ----------------------------
INSERT INTO 9314_order VALUES ('1', '5', '5', '3', '1512377025', '1');
INSERT INTO 9314_order VALUES ('2', '1', '5', '3', '1512379501', '1');
INSERT INTO 9314_order VALUES ('3', '1', '24', '2', '1512442222', '1');
INSERT INTO 9314_order VALUES ('4', '3', '25', '9', '1512455091', '1');

-- ----------------------------
-- Table structure for `9314_user`
-- ----------------------------
DROP TABLE IF EXISTS `9314_user`;
CREATE TABLE `9314_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` char(32) NOT NULL,
  `email` char(30) NOT NULL,
  `undertype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0为普通用户,1为管理员',
  `regtime` int(10) NOT NULL,
  `checkdel` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否被删除,默认为0不删除,1为删除',
  `lastime` int(10) NOT NULL,
  `regip` int(10) NOT NULL,
  `pic` varchar(60) NOT NULL DEFAULT 'public/img/avatar.gif' COMMENT '用户头像',
  `grade` int(10) DEFAULT '0' COMMENT '积分',
  `realname` varchar(50) DEFAULT NULL,
  `sex` tinyint(2) DEFAULT NULL,
  `birthday` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `autograph` varchar(50) DEFAULT NULL,
  `qq` bigint(10) DEFAULT NULL,
  `allowlogin` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否运行登录,0为允许,1为不允许登录',
  `problem` varchar(255) DEFAULT NULL COMMENT '是否设置安全提问,默认为空',
  `anser` varchar(255) DEFAULT NULL COMMENT '安全提问的答案',
  `trynum` int(10) NOT NULL DEFAULT '0' COMMENT '用户登录失败的次数',
  `everlogin` tinyint(2) DEFAULT '0' COMMENT '判断是否登陆过,默认为0,没有登陆过',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 9314_user
-- ----------------------------
INSERT INTO 9314_user VALUES ('1', '奚梦瑶-Miss', 'eced110fa1737081f2ea67d875118c62', '2608153909@qq.com', '0', '1512182400', '0', '1512182400', '2130706433', '../upload/2017/12/05/5a25f798b61fc.gif', '65', 'WHY', '3', '1990-11-15', '江西省', '<p>	ffffffffffff</p>', '2608153909', '0', '', null, '1', '1');
INSERT INTO 9314_user VALUES ('2', '大幂幂-Miss', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '0', '1512183257', '0', '1512183257', '2130706433', '../upload/2017/12/04/5a254452a423b.jpg', '57', '', '2', '年-月-日', null, '', null, '0', '', null, '0', '0');
INSERT INTO 9314_user VALUES ('3', '唐嫣-Miss', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '0', '1512183336', '0', '1512183336', '2130706433', '../upload/2017/12/05/5a2612177cd53.jpg', '15', '', '2', '年-月-日', null, '<p>	gggggggggggggggggggg</p>', null, '1', '', null, '0', '1');
INSERT INTO 9314_user VALUES ('4', '郑智薰-Mr', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '0', '1512183434', '0', '1512183434', '2130706433', '../upload/2017/12/05/5a25fa64819e8.jpg', '18', null, null, null, null, null, null, '0', null, null, '0', '0');
INSERT INTO 9314_user VALUES ('5', '言承旭-Jerry', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '1', '1512182400', '0', '1512182400', '2130706433', '../upload/2017/12/04/5a2544c98a74c.jpg', '38', 'WHY', '3', '', '江西省', '<p>	ffffffffffff</p>', null, '0', '', null, '1', '1');
INSERT INTO 9314_user VALUES ('6', '周杰伦-Mr', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '0', '1512470836', '0', '1512470836', '2130706433', 'public/img/avatar.gif', '5', '', '2', '年-月-日', null, '', null, '0', '', null, '0', '0')

-- ----------------------------
-- Table structure for `9314_user_copy`
-- ----------------------------
DROP TABLE IF EXISTS `9314_user_copy`;
CREATE TABLE `9314_user_copy` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` char(32) NOT NULL,
  `email` char(30) NOT NULL,
  `undertype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0为普通用户,1为管理员',
  `regtime` int(10) NOT NULL,
  `checkdel` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否被删除,默认为0不删除,1为删除',
  `lastime` int(10) NOT NULL,
  `regip` int(10) NOT NULL,
  `pic` varchar(60) NOT NULL DEFAULT 'public/img/avatar.gif' COMMENT '用户头像',
  `grade` int(10) DEFAULT '0' COMMENT '积分',
  `realname` varchar(50) DEFAULT NULL,
  `sex` tinyint(2) DEFAULT NULL,
  `birthday` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `autograph` varchar(50) DEFAULT NULL,
  `qq` bigint(10) DEFAULT NULL,
  `allowlogin` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否运行登录,0为允许,1为不允许登录',
  `problem` varchar(255) DEFAULT NULL COMMENT '是否设置安全提问,默认为空',
  `anser` varchar(255) DEFAULT NULL COMMENT '安全提问的答案',
  `trynum` int(10) NOT NULL DEFAULT '0' COMMENT '用户登录失败的次数',
  `everlogin` tinyint(2) DEFAULT '0' COMMENT '判断是否登陆过,默认为0,没有登陆过',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of 9314_user_copy
-- ----------------------------
INSERT INTO 9314_user_copy VALUES ('1', '奚梦瑶-Miss', 'eced110fa1737081f2ea67d875118c62', '2608153909@qq.com', '0', '1512182400', '0', '1512182400', '2130706433', '../upload/2017/12/05/5a25f798b61fc.gif', '65', 'WHY', '3', '1990-11-15', '江西省', '<p>	ffffffffffff</p>', '2608153909', '0', '', null, '1', '1');
INSERT INTO 9314_user_copy VALUES ('2', '大幂幂-Miss', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '0', '1512183257', '0', '1512183257', '2130706433', '../upload/2017/12/04/5a254452a423b.jpg', '57', '', '2', '年-月-日', null, '', null, '0', '', null, '0', '0');
INSERT INTO 9314_user_copy VALUES ('3', '唐嫣-Miss', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '0', '1512183336', '0', '1512183336', '2130706433', '../upload/2017/12/05/5a2612177cd53.jpg', '15', '', '2', '年-月-日', null, '<p>	gggggggggggggggggggg</p>', null, '1', '', null, '0', '1');
INSERT INTO 9314_user_copy VALUES ('4', '郑智薰-Mr', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '0', '1512183434', '0', '1512183434', '2130706433', '../upload/2017/12/05/5a25fa64819e8.jpg', '18', null, null, null, null, null, null, '0', null, null, '0', '0');
INSERT INTO 9314_user_copy VALUES ('5', '言承旭-Jerry', '8ce303623c33ebf2063ba5822f5b1c52', '2608153909@qq.com', '1', '1512182400', '0', '1512182400', '2130706433', '../upload/2017/12/04/5a2544c98a74c.jpg', '38', 'WHY', '3', '', '江西省', '<p>	ffffffffffff</p>', null, '0', '', null, '1', '1')
