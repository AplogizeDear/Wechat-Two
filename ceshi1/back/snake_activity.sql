SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `snake_activity`;
CREATE TABLE `snake_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner` varchar(255) NOT NULL COMMENT '海报',
  `title` varchar(32) NOT NULL COMMENT '活动标题',
  `subtitle` varchar(32) NOT NULL COMMENT '活动副标题',
  `price` float(11,2) NOT NULL COMMENT '价格',
  `url` varchar(32) NOT NULL COMMENT '跳转url',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

insert into `snake_activity`(`id`,`banner`,`title`,`subtitle`,`price`,`url`,`add_time`) values('3','/upload/20180604/ce2bf0b52cd33d6d006468e3fb977cd9.jpg','33333','3333333','3333','333','2018-06-04 14:11:14');
