/*
Navicat MySQL Data Transfer

Source Server         : 测试
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : snake

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-07-02 13:51:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for snake_activity
-- ----------------------------
DROP TABLE IF EXISTS `snake_activity`;
CREATE TABLE `snake_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner` varchar(255) NOT NULL COMMENT '海报',
  `title` varchar(32) NOT NULL COMMENT '活动标题',
  `subtitle` varchar(32) NOT NULL COMMENT '活动副标题',
  `price` float(11,2) NOT NULL COMMENT '价格',
  `url` varchar(32) NOT NULL COMMENT '跳转url',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `start_time` int(11) NOT NULL COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL COMMENT '活动结束时间',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  `status` int(3) NOT NULL DEFAULT '1' COMMENT '默认为1,1为生效，2为失效',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_activity
-- ----------------------------
INSERT INTO `snake_activity` VALUES ('5', '/upload/20180614/57110170f5ff844b341d889b20514c47.jpg', '11', '11', '11.00', '11', '1528942646', '0', '0', '0', '1');
INSERT INTO `snake_activity` VALUES ('6', '/upload/20180614/6ec405b8b55199ee07e2f5c7b3b23715.jpg', '22', '22', '22.00', '22', '1528942959', '1528905600', '1530115200', '2', '1');
INSERT INTO `snake_activity` VALUES ('7', '/upload/20180614/6a588389d83c0373ef8f27e5a082f5c1.jpg', '33', '33', '33.00', '33', '1528943745', '1528905600', '1530115200', '2', '1');
INSERT INTO `snake_activity` VALUES ('8', '/upload/20180619/1aec9272bf1de08c3c7b855340668283.jpg', '111', '11', '11.00', '111', '1529375995', '1529337600', '1529424000', '0', '1');
INSERT INTO `snake_activity` VALUES ('12', '/upload/20180621/97aad3464fb4177160dc317367350d4e.jpg', '11', '22', '33.00', '44', '1529546957', '1529510400', '1529596800', '0', '2');
INSERT INTO `snake_activity` VALUES ('13', '/upload/20180621/b40af9776afddc41e0894298a8f1a36e.jpg', '11', '12', '34.00', '56', '1529547057', '1528905600', '1530201600', '0', '2');
INSERT INTO `snake_activity` VALUES ('14', '/upload/20180622/b33f2133322aa091dd05132bc53d30e8.jpg', '11', '11', '11.00', '11', '1529547157', '1529510400', '1528905600', '0', '1');
INSERT INTO `snake_activity` VALUES ('15', '/upload/20180621/ef707f77b3d836765cc8dd38d2f828ab.jpg', '11', '11', '11.00', '11', '1529547308', '1529510400', '1530115200', '218', '1');

-- ----------------------------
-- Table structure for snake_articles
-- ----------------------------
DROP TABLE IF EXISTS `snake_articles`;
CREATE TABLE `snake_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(155) NOT NULL COMMENT '文章标题',
  `description` varchar(255) NOT NULL COMMENT '文章描述',
  `keywords` varchar(155) NOT NULL COMMENT '文章关键字',
  `thumbnail` varchar(255) NOT NULL COMMENT '文章缩略图',
  `content` text NOT NULL COMMENT '文章内容',
  `add_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_articles
-- ----------------------------
INSERT INTO `snake_articles` VALUES ('3', '11', '11', '11', '/upload/20180604/d4677e5abfc3db22e3c27bdfb5023212.jpg', '<p>111</p>', '2018-06-04 11:08:52');

-- ----------------------------
-- Table structure for snake_brands_cate
-- ----------------------------
DROP TABLE IF EXISTS `snake_brands_cate`;
CREATE TABLE `snake_brands_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `pid` int(10) unsigned DEFAULT '0',
  `img` varchar(255) DEFAULT NULL COMMENT '分类图片',
  `img_banner` varchar(255) DEFAULT NULL COMMENT 'banner图片',
  `content` text COMMENT '分类描述',
  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态，0=不可用，1=可用',
  `date_range` varchar(200) DEFAULT NULL COMMENT '营业时间范围',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `contact_tel` varchar(200) DEFAULT NULL COMMENT '联系电话',
  `level` int(11) DEFAULT NULL COMMENT '等级',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=221 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_brands_cate
-- ----------------------------
INSERT INTO `snake_brands_cate` VALUES ('214', '111', '0', '/upload/20180619/8736ed58a33a7ef6f9306ba8d18278d1.jpg', null, '1111', '1529398094', '1', null, null, null, '1');
INSERT INTO `snake_brands_cate` VALUES ('216', '22', '214', '/upload/20180619/876a4fa41e6530e092bb3ddbfe750f77.jpg', null, '222', '1529401857', '1', null, null, null, '2');
INSERT INTO `snake_brands_cate` VALUES ('219', '5555', '216', '/upload/20180619/88aee2937ead94d66ac9ae8766acde17.jpg', null, '555', '1529405235', '1', null, null, null, '3');
INSERT INTO `snake_brands_cate` VALUES ('218', '444', '216', '/upload/20180619/f4686feabd8fda80ea80459d7e444bd5.jpg', null, '444', '1529404323', '1', null, null, null, '3');
INSERT INTO `snake_brands_cate` VALUES ('0', 'SPACE CLUB', '0', '/upload/20180627/eecc2fc57d14803fea1b79d8592ce074.png', '', '444', '1529404323', '1', '', '', '', '3');

-- ----------------------------
-- Table structure for snake_card
-- ----------------------------
DROP TABLE IF EXISTS `snake_card`;
CREATE TABLE `snake_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '会员卡名称',
  `image` varchar(255) NOT NULL COMMENT '会员卡图片',
  `point` int(11) NOT NULL COMMENT '所需积分',
  `explain` text COMMENT '特别说明',
  `explaint` text COMMENT '时效说明',
  `explainu` text COMMENT '使用须知',
  `c_id` int(11) NOT NULL COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_card
-- ----------------------------
INSERT INTO `snake_card` VALUES ('2', '灰雁卡', '/upload/20180622/81eb99273c43d885896527a4a1bdf786.jpg', '0', '<p>1、space club所有活动免票通行；</p><p>2、space club酒水会员价；</p><p>3、会员生日国际五星级房间赠送；</p><p>4、space club开业月蓝带、XO2瓶赠送；</p><p><br/></p>', '<p>有效期1年，不限时间段使用；</p>', '<p>1、每台一次</p><p>2、订台会员专享</p><p>3、最终解释权归space plus所有</p>', '0');
INSERT INTO `snake_card` VALUES ('3', '金卡', '/upload/20180625/3850895839dc5f832803fbd6a53881d9.jpg', '500', '<p>1111111111</p>', '<p>1111111111</p>', '<p>1111111111</p>', '0');

-- ----------------------------
-- Table structure for snake_log
-- ----------------------------
DROP TABLE IF EXISTS `snake_log`;
CREATE TABLE `snake_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL COMMENT '操作人',
  `content` varchar(255) NOT NULL COMMENT '日志内容',
  `add_ip` varchar(32) NOT NULL COMMENT '操作ip',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `log_detail` text COMMENT '日志明细',
  `c_id` int(11) NOT NULL COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_log
-- ----------------------------
INSERT INTO `snake_log` VALUES ('2', '0', '导出GOPAR会员信息表', '127.0.0.1', '1529546957', '', '0');
INSERT INTO `snake_log` VALUES ('3', '0', '导出GOPAR会员信息表', '127.0.0.1', '1529547057', '', '0');
INSERT INTO `snake_log` VALUES ('4', 'admin', '导出GOPAR会员信息表', '127.0.0.1', '1529547157', '', '0');
INSERT INTO `snake_log` VALUES ('5', 'linxsl', '添加活动', '127.0.0.1', '1529547308', '', '218');
INSERT INTO `snake_log` VALUES ('6', 'admin', '登录后台管理', '127.0.0.1', '1529558209', '', '0');
INSERT INTO `snake_log` VALUES ('7', 'admin', '登录后台管理', '127.0.0.1', '1529558904', '', '0');
INSERT INTO `snake_log` VALUES ('8', 'admin', '修改id为0的支付宝设定', '127.0.0.1', '1529569857', '', '0');
INSERT INTO `snake_log` VALUES ('9', 'admin', '登录后台管理', '127.0.0.1', '1529630215', '', '0');
INSERT INTO `snake_log` VALUES ('10', 'admin', '手动买单成功，订单id为：28', '127.0.0.1', '1529634271', '', '0');
INSERT INTO `snake_log` VALUES ('11', 'admin', '订单删除成功，订单id为：28', '127.0.0.1', '1529634493', '', '0');
INSERT INTO `snake_log` VALUES ('12', 'admin', '手动买单成功，订单id为：29', '127.0.0.1', '1529634507', '', '0');
INSERT INTO `snake_log` VALUES ('13', 'admin', '退出后台管理', '127.0.0.1', '1529651469', '', '0');
INSERT INTO `snake_log` VALUES ('14', 'admin', '登录后台管理', '127.0.0.1', '1529651482', '', '0');
INSERT INTO `snake_log` VALUES ('15', 'admin', 'id为14的活动进行了修改', '127.0.0.1', '1529655690', '', '0');
INSERT INTO `snake_log` VALUES ('16', 'admin', '登录后台管理', '127.0.0.1', '1529889480', '', '0');
INSERT INTO `snake_log` VALUES ('17', 'admin', '登录后台管理', '127.0.0.1', '1529979001', '', '0');
INSERT INTO `snake_log` VALUES ('18', 'admin', '添加酒种类', '127.0.0.1', '1529993075', '', '0');
INSERT INTO `snake_log` VALUES ('19', 'admin', '修改酒种类', '127.0.0.1', '1529993209', '', '0');
INSERT INTO `snake_log` VALUES ('20', 'admin', '修改酒种类', '127.0.0.1', '1529993215', '', '0');
INSERT INTO `snake_log` VALUES ('21', 'admin', '退出后台管理', '127.0.0.1', '1530010805', '', '0');
INSERT INTO `snake_log` VALUES ('22', 'admin', '登录后台管理', '127.0.0.1', '1530010820', '', '0');
INSERT INTO `snake_log` VALUES ('23', 'admin', '登录后台管理', '127.0.0.1', '1530063055', '', '0');
INSERT INTO `snake_log` VALUES ('24', 'admin', '退出后台管理', '127.0.0.1', '1530065785', '', '0');
INSERT INTO `snake_log` VALUES ('25', 'admin', '登录后台管理', '127.0.0.1', '1530065794', '', '0');
INSERT INTO `snake_log` VALUES ('26', 'admin', 'id为13的活动进行了修改', '127.0.0.1', '1530071508', '', '0');
INSERT INTO `snake_log` VALUES ('27', 'admin', 'id为14的活动进行了修改', '127.0.0.1', '1530071514', '', '0');
INSERT INTO `snake_log` VALUES ('28', 'admin', 'id为14的活动进行了修改', '127.0.0.1', '1530071517', '', '0');
INSERT INTO `snake_log` VALUES ('29', 'admin', 'id为0的品牌进行了修改', '127.0.0.1', '1530097041', '', '0');
INSERT INTO `snake_log` VALUES ('30', 'admin', '登录后台管理', '127.0.0.1', '1530148222', '', '0');
INSERT INTO `snake_log` VALUES ('31', 'admin', '登录后台管理', '127.0.0.1', '1530265010', '', '0');
INSERT INTO `snake_log` VALUES ('32', 'admin', '退出后台管理', '127.0.0.1', '1530265939', '', '0');
INSERT INTO `snake_log` VALUES ('33', 'admin', '登录后台管理', '127.0.0.1', '1530266620', '', '0');
INSERT INTO `snake_log` VALUES ('34', '小a', '登录服务员后台', '127.0.0.1', '1530497857', '', '0');
INSERT INTO `snake_log` VALUES ('35', '小a', '登录服务员后台', '127.0.0.1', '1530498962', '', '0');
INSERT INTO `snake_log` VALUES ('36', '小a', '登录服务员后台', '127.0.0.1', '1530499846', '', '0');
INSERT INTO `snake_log` VALUES ('37', '小a', '退出后台管理', '127.0.0.1', '1530501059', '', '0');
INSERT INTO `snake_log` VALUES ('38', '小a', '登录服务员后台', '127.0.0.1', '1530501075', '', '0');
INSERT INTO `snake_log` VALUES ('39', 'admin', '登录后台管理', '127.0.0.1', '1530501132', '', '0');
INSERT INTO `snake_log` VALUES ('40', '小a', '登录服务员后台', '127.0.0.1', '1530509924', '', '0');

-- ----------------------------
-- Table structure for snake_member
-- ----------------------------
DROP TABLE IF EXISTS `snake_member`;
CREATE TABLE `snake_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` int(32) NOT NULL COMMENT '用户名（存入手机号）',
  `password` varchar(225) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(225) DEFAULT NULL COMMENT '昵称（微信昵称）',
  `avatar` varchar(225) DEFAULT NULL COMMENT '微信头像',
  `openid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  `point` float(32,2) DEFAULT '0.00' COMMENT '积分',
  `money` float(32,2) DEFAULT '0.00' COMMENT '余额',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  `last_time` int(11) NOT NULL COMMENT '最近登录时间',
  `add_time` int(11) NOT NULL COMMENT '新增时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_member
-- ----------------------------
INSERT INTO `snake_member` VALUES ('1', '234123123', '11', '5555', '/static/admin/images/profile_small.jpg', 'eweqwe', '1611.00', '290.00', '0', '1529648435', '1529648435');
INSERT INTO `snake_member` VALUES ('2', '5656', '11', 'hghgh', '/static/admin/images/profile_small.jpg', '11', '811.00', '100.00', '0', '1529571398', '0');
INSERT INTO `snake_member` VALUES ('3', '21212', '11', '7777', '/static/admin/images/profile_small.jpg', 'ffff', '0.00', '0.00', '0', '1529571398', '1529571398');
INSERT INTO `snake_member` VALUES ('4', '66666', '11', '00oo', '/static/admin/images/profile_small.jpg', 'ggg', '0.00', '0.00', '0', '1529571398', '1529571398');

-- ----------------------------
-- Table structure for snake_node
-- ----------------------------
DROP TABLE IF EXISTS `snake_node`;
CREATE TABLE `snake_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `type_id` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of snake_node
-- ----------------------------
INSERT INTO `snake_node` VALUES ('1', '权限管理', '#', '#', '2', '0', 'fa fa-users');
INSERT INTO `snake_node` VALUES ('2', '管理员管理', 'user', 'index', '2', '1', '');
INSERT INTO `snake_node` VALUES ('3', '添加管理员', 'user', 'useradd', '1', '2', '');
INSERT INTO `snake_node` VALUES ('4', '编辑管理员', 'user', 'useredit', '1', '2', '');
INSERT INTO `snake_node` VALUES ('5', '删除管理员', 'user', 'userdel', '1', '2', '');
INSERT INTO `snake_node` VALUES ('6', '角色管理', 'role', 'index', '2', '1', '');
INSERT INTO `snake_node` VALUES ('7', '添加角色', 'role', 'roleadd', '1', '6', '');
INSERT INTO `snake_node` VALUES ('8', '编辑角色', 'role', 'roleedit', '1', '6', '');
INSERT INTO `snake_node` VALUES ('9', '删除角色', 'role', 'roledel', '1', '6', '');
INSERT INTO `snake_node` VALUES ('10', '分配权限', 'role', 'giveaccess', '1', '6', '');
INSERT INTO `snake_node` VALUES ('11', '系统管理', '#', '#', '2', '0', 'fa fa-desktop');
INSERT INTO `snake_node` VALUES ('12', '数据备份/还原', 'data', 'index', '2', '11', '');
INSERT INTO `snake_node` VALUES ('13', '备份数据', 'data', 'importdata', '1', '12', '');
INSERT INTO `snake_node` VALUES ('14', '还原数据', 'data', 'backdata', '1', '12', '');
INSERT INTO `snake_node` VALUES ('15', '节点管理', 'node', 'index', '2', '1', '');
INSERT INTO `snake_node` VALUES ('16', '添加节点', 'node', 'nodeadd', '1', '15', '');
INSERT INTO `snake_node` VALUES ('17', '编辑节点', 'node', 'nodeedit', '1', '15', '');
INSERT INTO `snake_node` VALUES ('18', '删除节点', 'node', 'nodedel', '1', '15', '');
INSERT INTO `snake_node` VALUES ('19', '文章管理', 'articles', 'index', '1', '0', 'fa fa-book');
INSERT INTO `snake_node` VALUES ('20', '文章列表', 'articles', 'index', '2', '19', '');
INSERT INTO `snake_node` VALUES ('21', '添加文章', 'articles', 'articleadd', '1', '19', '');
INSERT INTO `snake_node` VALUES ('22', '编辑文章', 'articles', 'articleedit', '1', '19', '');
INSERT INTO `snake_node` VALUES ('23', '删除文章', 'articles', 'articledel', '1', '19', '');
INSERT INTO `snake_node` VALUES ('24', '上传图片', 'articles', 'uploadImg', '1', '19', '');
INSERT INTO `snake_node` VALUES ('25', '用户管理', '#', '#', '2', '0', 'fa fa-user');
INSERT INTO `snake_node` VALUES ('26', '用户列表', 'member', 'index', '2', '25', '');
INSERT INTO `snake_node` VALUES ('27', '活动管理', '#', '#', '2', '0', 'fa fa-calendar');
INSERT INTO `snake_node` VALUES ('28', '活动列表', 'activity', 'index', '2', '27', '');
INSERT INTO `snake_node` VALUES ('29', '设置管理', '#', '#', '2', '0', 'fa fa-wrench');
INSERT INTO `snake_node` VALUES ('30', '支付宝设置', 'set', 'alipay', '2', '29', '');
INSERT INTO `snake_node` VALUES ('34', '基本信息设置', 'set', 'base_set', '2', '29', '');
INSERT INTO `snake_node` VALUES ('35', '积分设置', 'set', 'point_set', '2', '29', '');
INSERT INTO `snake_node` VALUES ('36', '充值规则', 'set', 'recharge', '2', '29', '');
INSERT INTO `snake_node` VALUES ('37', '微信设置', 'set', 'wx', '2', '29', '');
INSERT INTO `snake_node` VALUES ('38', '短信设置', 'set', 'sms', '2', '29', '');
INSERT INTO `snake_node` VALUES ('39', '台桌管理', '#', '#', '2', '0', 'fa fa-th');
INSERT INTO `snake_node` VALUES ('40', '台桌列表', 'seat', 'index', '2', '39', '');
INSERT INTO `snake_node` VALUES ('41', '资金管理', '#', '#', '2', '0', 'fa fa-cny');
INSERT INTO `snake_node` VALUES ('42', '充值流水', 'capital', 'recharge', '2', '41', '');
INSERT INTO `snake_node` VALUES ('43', '买单管理', '#', '#', '2', '0', 'fa fa-credit-card');
INSERT INTO `snake_node` VALUES ('44', '买单列表', 'pay', 'index', '2', '43', '');
INSERT INTO `snake_node` VALUES ('45', '存取酒管理', '#', '#', '2', '0', 'fa fa-beer');
INSERT INTO `snake_node` VALUES ('46', '存取酒列表', 'keepout', 'index', '2', '45', '');
INSERT INTO `snake_node` VALUES ('47', '添加台桌', 'seat', 'seatadd', '1', '39', '');
INSERT INTO `snake_node` VALUES ('48', '台桌编辑', 'seat', 'seatedit', '1', '39', '');
INSERT INTO `snake_node` VALUES ('49', '删除台桌', 'seat', 'seatdel', '1', '39', '');
INSERT INTO `snake_node` VALUES ('50', '添加活动', 'activity', 'activityadd', '1', '27', '');
INSERT INTO `snake_node` VALUES ('51', '编辑活动', 'activity', 'activityedit', '1', '27', '');
INSERT INTO `snake_node` VALUES ('52', '删除活动', 'activity', 'activitydel', '1', '27', '');
INSERT INTO `snake_node` VALUES ('53', '修改积分余额', 'member', 'memberedit', '1', '25', '');
INSERT INTO `snake_node` VALUES ('54', '酒类管理', '#', '#', '2', '0', 'fa fa-coffee');
INSERT INTO `snake_node` VALUES ('55', '酒种类管理', 'winetype', 'index', '2', '54', '');
INSERT INTO `snake_node` VALUES ('56', '酒品牌管理', 'winetype', 'winebrand', '2', '54', '');
INSERT INTO `snake_node` VALUES ('57', '酒种类添加', 'winetype', 'winetypeadd', '1', '54', '');
INSERT INTO `snake_node` VALUES ('58', '酒种类修改', 'winetype', 'winetypeedit', '1', '54', '');
INSERT INTO `snake_node` VALUES ('59', '酒种类删除', 'winetype', 'winetypedel', '1', '54', '');
INSERT INTO `snake_node` VALUES ('60', '酒品牌添加', 'winetype', 'winebrandadd', '1', '54', '');
INSERT INTO `snake_node` VALUES ('61', '酒品牌修改', 'winetype', 'winebrandedit', '1', '54', '');
INSERT INTO `snake_node` VALUES ('62', '酒品牌删除', 'winetype', 'winebranddel', '1', '54', '');
INSERT INTO `snake_node` VALUES ('63', '积分详情', 'member', 'point', '1', '25', '');
INSERT INTO `snake_node` VALUES ('64', '充值详情', 'member', 'recharge', '1', '25', '');
INSERT INTO `snake_node` VALUES ('65', '消费列表', 'member', 'order', '1', '25', '');
INSERT INTO `snake_node` VALUES ('66', '消费流水', 'capital', 'order', '2', '41', '');
INSERT INTO `snake_node` VALUES ('67', '消息提醒设置', 'set', 'remind', '2', '29', '');
INSERT INTO `snake_node` VALUES ('68', '手动买单', 'pay', 'payadd', '1', '43', '');
INSERT INTO `snake_node` VALUES ('69', '买单编辑', 'pay', 'payedit', '1', '43', '');
INSERT INTO `snake_node` VALUES ('70', '买单删除', 'pay', 'paydel', '1', '43', '');
INSERT INTO `snake_node` VALUES ('72', '自主取酒', 'keepout', 'outadd', '1', '45', '');
INSERT INTO `snake_node` VALUES ('73', '自主存酒', 'keepout', 'keepadd', '1', '45', '');
INSERT INTO `snake_node` VALUES ('74', '取酒编辑', 'keepout', 'outedit', '1', '45', '');
INSERT INTO `snake_node` VALUES ('76', '存取酒删除', 'keepout', 'keepoutdel', '1', '45', '');
INSERT INTO `snake_node` VALUES ('77', '存酒编辑', 'keepout', 'keepedit', '1', '45', '');
INSERT INTO `snake_node` VALUES ('78', '资金导出', 'capital', 'output_excel_order', '1', '41', '');
INSERT INTO `snake_node` VALUES ('79', '充值导出', 'capital', 'output_excel_recharge', '1', '41', '');
INSERT INTO `snake_node` VALUES ('80', '积分导出', 'member', 'output_excel_point', '1', '25', '');
INSERT INTO `snake_node` VALUES ('81', '充值导出', 'member', 'output_excel_recharge', '1', '25', '');
INSERT INTO `snake_node` VALUES ('82', '消费导出', 'member', 'output_excel_order', '1', '25', '');
INSERT INTO `snake_node` VALUES ('83', '过期处理', 'keepout', 'keepoutexpire', '2', '45', '');
INSERT INTO `snake_node` VALUES ('84', '有效期修改', 'keepout', 'stocktimeedit', '1', '45', '');
INSERT INTO `snake_node` VALUES ('85', '过期删除', 'keepout', 'stocktimedel', '1', '45', '');
INSERT INTO `snake_node` VALUES ('86', '密码修改', 'user', 'userpasswordedit', '1', '6', '');
INSERT INTO `snake_node` VALUES ('87', '门店管理', '#', '#', '2', '0', 'fa fa-institution');
INSERT INTO `snake_node` VALUES ('88', '集团列表', 'brandscate', 'group', '2', '87', '');
INSERT INTO `snake_node` VALUES ('89', '品牌列表', 'brandscate', 'brand', '2', '87', '');
INSERT INTO `snake_node` VALUES ('90', '门店列表', 'brandscate', 'store', '2', '87', '');
INSERT INTO `snake_node` VALUES ('91', '新增集团', 'brandscate', 'groupadd', '1', '87', '');
INSERT INTO `snake_node` VALUES ('92', '新增品牌', 'brandscate', 'brandadd', '1', '87', '');
INSERT INTO `snake_node` VALUES ('93', '新增门店', 'brandscate', 'storeadd', '1', '87', '');
INSERT INTO `snake_node` VALUES ('94', '集团编辑', 'brandscate', 'groupedit', '1', '87', '');
INSERT INTO `snake_node` VALUES ('95', '品牌编辑', 'brandscate', 'brandedit', '1', '87', '');
INSERT INTO `snake_node` VALUES ('96', '门店编辑', 'brandscate', 'storeedit', '1', '87', '');
INSERT INTO `snake_node` VALUES ('97', '集团删除', 'brandscate', 'groupdel', '1', '87', '');
INSERT INTO `snake_node` VALUES ('98', '品牌删除', 'brandscate', 'branddel', '1', '87', '');
INSERT INTO `snake_node` VALUES ('99', '门店删除', 'brandscate', 'storedel', '1', '87', '');
INSERT INTO `snake_node` VALUES ('100', '分配管理员', 'brandscate', 'brandscateuser', '1', '87', '');
INSERT INTO `snake_node` VALUES ('101', '日志管理', '#', '#', '2', '0', 'fa fa-file-text-o');
INSERT INTO `snake_node` VALUES ('102', '日志列表', 'log', 'index', '2', '101', '');
INSERT INTO `snake_node` VALUES ('103', '导出日志', 'log', 'output_excel_log', '1', '101', '');
INSERT INTO `snake_node` VALUES ('104', '会员卡管理', '#', '#', '2', '0', 'fa fa-credit-card');
INSERT INTO `snake_node` VALUES ('105', '会员卡列表', 'card', 'index', '2', '104', '');
INSERT INTO `snake_node` VALUES ('106', '新增会员卡', 'card', 'cardadd', '1', '104', '');
INSERT INTO `snake_node` VALUES ('107', '编辑会员卡', 'card', 'cardedit', '1', '104', '');
INSERT INTO `snake_node` VALUES ('108', '删除会员卡', 'card', 'carddel', '1', '104', '');
INSERT INTO `snake_node` VALUES ('109', '库存列表', 'stock', 'index', '2', '45', '');
INSERT INTO `snake_node` VALUES ('110', '酒卡列表', 'stock', 'index', '1', '25', '');

-- ----------------------------
-- Table structure for snake_order
-- ----------------------------
DROP TABLE IF EXISTS `snake_order`;
CREATE TABLE `snake_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL COMMENT '用户id',
  `order_id` varchar(32) NOT NULL COMMENT '订单号',
  `pay` float(32,2) NOT NULL COMMENT '消费金额',
  `s_id` int(11) NOT NULL COMMENT '卡座id',
  `content` varchar(255) DEFAULT NULL COMMENT '消费内容',
  `time` int(11) DEFAULT NULL COMMENT '订单生产时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态  1为未完成，2为已完成',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_order
-- ----------------------------
INSERT INTO `snake_order` VALUES ('1', '1', '232131', '100.00', '1', 'dfsafafasdfas', '1528263526', '2', '0');
INSERT INTO `snake_order` VALUES ('3', '1', '2147483647', '100.00', '8', '测试', '1528263373', '1', '0');
INSERT INTO `snake_order` VALUES ('4', '1', '1528263526393609', '100.00', '7', '测试2', '1528263526', '2', '0');
INSERT INTO `snake_order` VALUES ('5', '1', '1528263655103598', '111.00', '8', 'ceshi2侧耳色', '1528263526', '1', '0');
INSERT INTO `snake_order` VALUES ('16', '1', '20180612112857744953', '100.00', '8', '委屈二群翁群翁', '1528774137', '2', '0');
INSERT INTO `snake_order` VALUES ('22', '2', '20180619103710538629', '100.00', '9', '测试', '1529375830', '2', '0');
INSERT INTO `snake_order` VALUES ('23', '2', '20180619103928374768', '100.00', '9', '111', '1529375968', '2', '0');
INSERT INTO `snake_order` VALUES ('24', '2', '20180619104226606662', '100.00', '7', '测试', '1529376146', '2', '0');
INSERT INTO `snake_order` VALUES ('25', '1', '20180620133312961631', '10.00', '9', '100', '1529472792', '2', '0');
INSERT INTO `snake_order` VALUES ('29', '1', '20180622102827486691', '100.00', '9', '打算打算打', '1529634507', '2', '0');

-- ----------------------------
-- Table structure for snake_out_cursor
-- ----------------------------
DROP TABLE IF EXISTS `snake_out_cursor`;
CREATE TABLE `snake_out_cursor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL COMMENT '用户id',
  `data` varchar(255) NOT NULL COMMENT '存酒数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_out_cursor
-- ----------------------------

-- ----------------------------
-- Table structure for snake_point
-- ----------------------------
DROP TABLE IF EXISTS `snake_point`;
CREATE TABLE `snake_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL COMMENT '用户id',
  `nums` float(11,2) NOT NULL COMMENT '积分数量',
  `action_id` int(11) DEFAULT NULL COMMENT '动作id（为0时是注册给与的积分）',
  `type` tinyint(3) NOT NULL COMMENT 'type类型，1为消费，2为充值，3为注册',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注（主要给管理员准备）',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_point
-- ----------------------------
INSERT INTO `snake_point` VALUES ('1', '1', '100.00', '0', '3', '注册', '0');
INSERT INTO `snake_point` VALUES ('9', '2', '100.00', '22', '1', '测试', '0');
INSERT INTO `snake_point` VALUES ('10', '2', '100.00', '23', '1', '111', '0');
INSERT INTO `snake_point` VALUES ('11', '2', '100.00', '24', '1', '测试', '0');
INSERT INTO `snake_point` VALUES ('12', '1', '100.00', '25', '1', '100', '0');
INSERT INTO `snake_point` VALUES ('16', '1', '1000.00', '29', '1', '打算打算打', '1529634507');

-- ----------------------------
-- Table structure for snake_recharge
-- ----------------------------
DROP TABLE IF EXISTS `snake_recharge`;
CREATE TABLE `snake_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) DEFAULT NULL COMMENT '用户id',
  `pay_id` varchar(32) NOT NULL COMMENT '支付订单id',
  `order_id` int(32) NOT NULL COMMENT '订单号',
  `recharge` float(32,2) NOT NULL COMMENT '充值金额',
  `present` float(32,2) NOT NULL COMMENT '赠送金额',
  `time` int(11) NOT NULL COMMENT '充值时间',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_recharge
-- ----------------------------
INSERT INTO `snake_recharge` VALUES ('1', '1', 'dsdasdsa', '12121', '100.00', '20.00', '1528560001', '0');
INSERT INTO `snake_recharge` VALUES ('2', '1', 'dsdasdsa', '12121', '100.00', '20.00', '1529486028', '0');

-- ----------------------------
-- Table structure for snake_role
-- ----------------------------
DROP TABLE IF EXISTS `snake_role`;
CREATE TABLE `snake_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `role_name` varchar(155) NOT NULL COMMENT '角色名称',
  `rule` varchar(255) DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of snake_role
-- ----------------------------
INSERT INTO `snake_role` VALUES ('1', '超级管理员', '*');
INSERT INTO `snake_role` VALUES ('3', '管理员', '1,2,3,4,5,25,26,53,63,64,65,80,81,82,27,28,50,51,52,29,30,34,35,36,37,38,67,39,40,47,48,49,41,42,66,78,79,43,44,68,69,70,45,46,72,73,74,76,77,54,55,56,57,58,59,60,61,62');
INSERT INTO `snake_role` VALUES ('4', '收银', '43,44,68,69,70');
INSERT INTO `snake_role` VALUES ('5', '财务', '41,42,66,78,79');
INSERT INTO `snake_role` VALUES ('6', '服务员', '25,26,63,64,65,43,44,68,69,70,71');
INSERT INTO `snake_role` VALUES ('7', '运营', '25,26,63,64,65,80,81,82,27,28,50,51,52,29,30,34,35,36,37,38,67,39,40,47,48,49,54,55,56,57,58,59,60,61,62');
INSERT INTO `snake_role` VALUES ('8', '经理', '25,26,53,63,64,65,80,81,82,27,28,50,51,52,29,30,34,35,36,37,38,67,39,40,47,48,49,41,42,66,78,79,43,44,68,69,70,45,46,72,73,74,76,77,83,84,85,54,55,56,57,58,59,60,61,62');
INSERT INTO `snake_role` VALUES ('9', '存酒员', '45,46,72,73,83,84');

-- ----------------------------
-- Table structure for snake_seat
-- ----------------------------
DROP TABLE IF EXISTS `snake_seat`;
CREATE TABLE `snake_seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '台桌名称',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_seat
-- ----------------------------
INSERT INTO `snake_seat` VALUES ('1', '测试', '22222222', '1');
INSERT INTO `snake_seat` VALUES ('3', '222', '2222', '1');
INSERT INTO `snake_seat` VALUES ('4', '333', '333', '0');
INSERT INTO `snake_seat` VALUES ('5', '444', '4444', '0');
INSERT INTO `snake_seat` VALUES ('6', '44555', '5555', '0');
INSERT INTO `snake_seat` VALUES ('7', '666', '666', '0');
INSERT INTO `snake_seat` VALUES ('8', '777', '777', '0');
INSERT INTO `snake_seat` VALUES ('9', '999', '999', '0');
INSERT INTO `snake_seat` VALUES ('10', '369', '最低消费5000元，8人位', '0');

-- ----------------------------
-- Table structure for snake_set
-- ----------------------------
DROP TABLE IF EXISTS `snake_set`;
CREATE TABLE `snake_set` (
  `id` int(11) NOT NULL COMMENT '公司id',
  `base_content` text COMMENT '基础设置：描述',
  `base_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '基础设置：标题',
  `base_keys` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '基础设置：关键字',
  `base_logo` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '基础设置：logo',
  `alipay_id` int(32) DEFAULT NULL COMMENT '支付宝Id',
  `alipay_secret` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '支付宝Secret',
  `wx_appId` int(32) DEFAULT NULL COMMENT '身份标识 (appId)',
  `wx_appSecret` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '身份密钥 (appSecret)',
  `wx_paySignKey` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '通信密钥 (paySignKey)',
  `wx_partnerId` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '商户身份 (partnerId)',
  `wx_partnerKey` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '商户密钥 (partnerKey)',
  `SMS_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '短信服务商',
  `SMS_appid` int(32) DEFAULT NULL COMMENT '短信Appid',
  `SMS_secret` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '短信密钥',
  `point` int(32) DEFAULT NULL COMMENT '一元兑换积分',
  `point_info` text CHARACTER SET utf8 COMMENT '兑换积分内容',
  `point_register` int(32) DEFAULT NULL COMMENT '注册获取多少积分',
  `recharge` text CHARACTER SET utf8 COMMENT '充值规则',
  `first_remind` int(32) DEFAULT NULL COMMENT '第一次提醒时间',
  `second_remind` int(32) DEFAULT NULL COMMENT '第二次提醒时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of snake_set
-- ----------------------------
INSERT INTO `snake_set` VALUES ('0', '222', '11', '22', '/upload/20180619/36bbc20e91580abe0c0e01c716b8df5f.jpg', '111', '222', '11', '11', '11', '11', '11', '11', '11', '11', '10', '<p>111</p>', '12', '{\"1\":[\"100\",\"100\"],\"2\":[\"200\",\"200\"],\"3\":[\"300\",\"300\"]}', '7', '10');
INSERT INTO `snake_set` VALUES ('219', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `snake_set` VALUES ('218', null, null, null, null, '22', '22', null, null, null, null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for snake_user
-- ----------------------------
DROP TABLE IF EXISTS `snake_user`;
CREATE TABLE `snake_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `login_times` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `role_id` int(11) NOT NULL DEFAULT '1' COMMENT '用户角色id',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of snake_user
-- ----------------------------
INSERT INTO `snake_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '133', '127.0.0.1', '1530501132', 'admin', '1', '1', '0');
INSERT INTO `snake_user` VALUES ('2', '小a', 'e10adc3949ba59abbe56e057f20f883e', '8', '127.0.0.1', '1530509924', '123456', '1', '6', '0');
INSERT INTO `snake_user` VALUES ('3', 'linxsl', 'e10adc3949ba59abbe56e057f20f883e', '5', '127.0.0.1', '1529547286', '驱蚊器无', '1', '3', '218');
INSERT INTO `snake_user` VALUES ('4', '测试', 'e10adc3949ba59abbe56e057f20f883e', '6', '127.0.0.1', '1529056981', '林', '1', '5', '1');

-- ----------------------------
-- Table structure for snake_wine_brand
-- ----------------------------
DROP TABLE IF EXISTS `snake_wine_brand`;
CREATE TABLE `snake_wine_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL COMMENT '酒种类id',
  `name` varchar(32) NOT NULL COMMENT '酒品牌名称',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_wine_brand
-- ----------------------------
INSERT INTO `snake_wine_brand` VALUES ('7', '8', '人头马', '0');
INSERT INTO `snake_wine_brand` VALUES ('8', '7', '长城', '0');
INSERT INTO `snake_wine_brand` VALUES ('9', '6', '哈啤', '0');
INSERT INTO `snake_wine_brand` VALUES ('10', '6', '雪花', '0');

-- ----------------------------
-- Table structure for snake_wine_info
-- ----------------------------
DROP TABLE IF EXISTS `snake_wine_info`;
CREATE TABLE `snake_wine_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` int(11) NOT NULL COMMENT '库存id',
  `k_id` int(11) NOT NULL COMMENT '存酒表id',
  `num` int(11) NOT NULL COMMENT '数量',
  `nums` int(11) NOT NULL COMMENT 'nums是否有不满一瓶的情况，默认为0都为整瓶，1为10%，2为20%-----',
  `use_day` int(11) NOT NULL COMMENT '有效期  ',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_wine_info
-- ----------------------------
INSERT INTO `snake_wine_info` VALUES ('28', '12', '32', '10', '0', '1538150400', '0');
INSERT INTO `snake_wine_info` VALUES ('29', '12', '32', '10', '0', '1546790400', '0');
INSERT INTO `snake_wine_info` VALUES ('30', '13', '33', '10', '6', '1535126400', '0');
INSERT INTO `snake_wine_info` VALUES ('32', '15', '34', '100', '3', '1530633600', '0');
INSERT INTO `snake_wine_info` VALUES ('31', '14', '34', '100', '4', '1530633600', '0');
INSERT INTO `snake_wine_info` VALUES ('34', '17', '34', '100', '7', '1538668800', '0');
INSERT INTO `snake_wine_info` VALUES ('33', '16', '34', '100', '0', '1535212800', '0');
INSERT INTO `snake_wine_info` VALUES ('36', '14', '35', '10', '4', '1530720000', '0');
INSERT INTO `snake_wine_info` VALUES ('35', '16', '35', '10', '0', '1535299200', '0');
INSERT INTO `snake_wine_info` VALUES ('37', '15', '35', '10', '0', '1530720000', '0');
INSERT INTO `snake_wine_info` VALUES ('38', '12', '35', '10', '0', '1530465253', '0');
INSERT INTO `snake_wine_info` VALUES ('39', '16', '36', '10', '0', '1535299200', '0');
INSERT INTO `snake_wine_info` VALUES ('40', '14', '36', '10', '0', '1530720000', '0');
INSERT INTO `snake_wine_info` VALUES ('41', '15', '36', '10', '0', '1530720000', '0');

-- ----------------------------
-- Table structure for snake_wine_keepout
-- ----------------------------
DROP TABLE IF EXISTS `snake_wine_keepout`;
CREATE TABLE `snake_wine_keepout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `w_id` int(11) NOT NULL COMMENT '服务员id',
  `time` int(11) NOT NULL COMMENT '日期',
  `m_id` int(11) NOT NULL COMMENT '用户id',
  `type` tinyint(3) DEFAULT NULL COMMENT '类型  1为存酒，2为取酒',
  `s_id` int(11) DEFAULT NULL COMMENT '桌台id',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态  1未完成，2已完成',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_wine_keepout
-- ----------------------------
INSERT INTO `snake_wine_keepout` VALUES ('32', '2', '1529480658', '1', '1', '9', '2', '0');
INSERT INTO `snake_wine_keepout` VALUES ('33', '2', '1529897942', '1', '1', '9', '2', '0');
INSERT INTO `snake_wine_keepout` VALUES ('34', '2', '1529980693', '1', '1', '9', '2', '0');
INSERT INTO `snake_wine_keepout` VALUES ('35', '2', '1530002642', '1', '2', '9', '2', '0');
INSERT INTO `snake_wine_keepout` VALUES ('36', '2', '1530004366', '1', '2', '9', '2', '0');

-- ----------------------------
-- Table structure for snake_wine_stock
-- ----------------------------
DROP TABLE IF EXISTS `snake_wine_stock`;
CREATE TABLE `snake_wine_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL COMMENT '用户id',
  `t_id` int(11) NOT NULL COMMENT '酒种类id',
  `b_id` int(11) NOT NULL COMMENT '酒品牌id',
  `num` int(11) NOT NULL COMMENT '数量（整数）',
  `use_day` int(32) NOT NULL COMMENT '有效期',
  `nums` int(3) NOT NULL DEFAULT '0' COMMENT 'nums是否有不满一瓶的情况，默认为0都为整瓶，1为10%，2为20%-----',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_wine_stock
-- ----------------------------
INSERT INTO `snake_wine_stock` VALUES ('12', '1', '8', '7', '10', '1530378853', '0', '0');
INSERT INTO `snake_wine_stock` VALUES ('13', '1', '7', '8', '10', '1435126400', '6', '0');
INSERT INTO `snake_wine_stock` VALUES ('14', '1', '6', '9', '80', '1530633600', '0', '0');
INSERT INTO `snake_wine_stock` VALUES ('15', '1', '6', '10', '80', '1530633600', '3', '0');
INSERT INTO `snake_wine_stock` VALUES ('16', '1', '7', '8', '80', '1535212800', '0', '0');
INSERT INTO `snake_wine_stock` VALUES ('17', '1', '8', '7', '100', '1530068800', '7', '0');

-- ----------------------------
-- Table structure for snake_wine_type
-- ----------------------------
DROP TABLE IF EXISTS `snake_wine_type`;
CREATE TABLE `snake_wine_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类名称',
  `title` varchar(32) NOT NULL COMMENT '酒种类名称',
  `use_day` int(11) NOT NULL COMMENT '有效天数',
  `image` varchar(255) DEFAULT NULL COMMENT '酒种类图片',
  `c_id` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  `image1` varchar(255) DEFAULT NULL COMMENT '酒种类图片1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of snake_wine_type
-- ----------------------------
INSERT INTO `snake_wine_type` VALUES ('8', '香槟', '100', '/upload/20180620/c6cb5d236c876ab550de42d8ab28bf00.jpg', '0', null);
INSERT INTO `snake_wine_type` VALUES ('7', '红酒', '60', '/upload/20180620/51e8a245fcaa7e59a0c481a852884d2e.jpg', '0', null);
INSERT INTO `snake_wine_type` VALUES ('6', '啤酒', '7', '/upload/20180620/09ee358eb14ee49cd44852c499d19c26.jpg', '0', null);
INSERT INTO `snake_wine_type` VALUES ('9', '测试1', '40', '/upload/20180626/639c59530125d2472ce4378a77682ce1.png', '0', '/upload/20180626/3722c9822760e8b667d30082771660ee.png');
