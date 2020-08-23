DROP TABLE IF EXISTS `pre__luser_config`;
CREATE TABLE `pre__luser_config` (
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `value` text COMMENT '配置值',
  `tip` text COMMENT '配置说明',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置';

DROP TABLE IF EXISTS `pre__luser_user`;
CREATE TABLE `pre__luser_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) DEFAULT NULL COMMENT '名称，可用于登陆',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(6) DEFAULT NULL COMMENT '加密因子',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `sex` tinyint(1) NULL DEFAULT '1' COMMENT '1-男,2-女',
  `birthday` int(10) NULL DEFAULT '0' COMMENT '生日',
  `email` varchar(100) NULL DEFAULT '' COMMENT '邮件',
  `email_validated` tinyint(1) NULL DEFAULT '0' COMMENT '是否验证电子邮箱',
  `phone` varchar(20) NULL DEFAULT '' COMMENT '手机号码',
  `phone_validated` tinyint(1) NULL DEFAULT '0' COMMENT '是否验证手机',
  `qq` varchar(20) NULL DEFAULT '' COMMENT 'QQ',
  `province` varchar(50) DEFAULT '' COMMENT '省份',
  `city` varchar(50) DEFAULT '' COMMENT '市区',
  `district` varchar(50) DEFAULT '' COMMENT '县',
  `remark` varchar(250) NULL DEFAULT '' COMMENT '用户备注，仅管理员可看',
  `last_active` int(10) NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_ip` varchar(25) NULL DEFAULT '' COMMENT '最后登录ip',
  `is_lock` tinyint(1) DEFAULT '0' COMMENT '是否被锁定冻结,1-冻结',
  `status` varchar(20) DEFAULT 'hide' COMMENT '登录状态',
  `edit_time` int(10) NULL DEFAULT '0' COMMENT '更新时间',
  `edit_ip` varchar(25) DEFAULT '' COMMENT '更新IP',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(25) DEFAULT '' COMMENT '添加IP',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';

DROP TABLE IF EXISTS `pre__luser_access`;
CREATE TABLE `pre__luser_access` (
  `id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `token` varchar(36) NOT NULL DEFAULT '' COMMENT '用于app授权，类似于session_id',
  `expire_time` int(10) DEFAULT '0' COMMENT '过期时间',
  `is_logout` tinyint(1) DEFAULT '0' COMMENT '1-已退出',
  `logout_time` int(10) DEFAULT NULL COMMENT '退出时间',
  `logout_ip` varchar(25) DEFAULT NULL COMMENT '退出IP',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `add_ip` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户登录token';

DROP TABLE IF EXISTS `pre__luser_log`;
CREATE TABLE `pre__luser_log` (
  `id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `login_time` int(10) DEFAULT NULL COMMENT '登陆时间',
  `login_ip` varchar(25) DEFAULT NULL,
  `login_useragent` text,
  `login_referer` text,
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `add_ip` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='登陆记录';

REPLACE INTO `lake_luser_config` VALUES 
('access_type','jwt','授权方式，jwt和token'),
('jwt_iss','api.xxx.com',NULL),
('jwt_aud','lake_app',NULL),
('jwt_tokenid','sdwert5g',NULL),
('jwt_secrect','srGd8iwV',NULL),
('jwt_exptime','3600',NULL),
('jwt_notbeforetime','10',NULL),
('access_exptime','3600',NULL);
