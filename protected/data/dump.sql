-- 
-- Structure for table `AuthAssignment`
-- 

DROP TABLE IF EXISTS `AuthAssignment`;
CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Data for table `AuthAssignment`
-- 

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
  ('Admin', '1', NULL, NULL);

-- 
-- Structure for table `AuthItem`
-- 

DROP TABLE IF EXISTS `AuthItem`;
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Data for table `AuthItem`
-- 

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
  ('Admin', '2', NULL, NULL, 'N;'),
  ('Authenticated', '2', NULL, NULL, 'N;'),
  ('Guest', '2', NULL, NULL, 'N;'),
  ('Users.Default.*', '1', 'Users.Default.*', NULL, 'N;'),
  ('Users.Default.Update', '0', 'Update user info', NULL, 'N;'),
  ('Users.Default.Create', '0', 'Create new users', NULL, 'N;'),
  ('Users.Default.Index', '0', 'View users list', NULL, 'N;'),
  ('Users.Default.Delete', '0', 'Delete users', NULL, 'N;'),
  ('Site.*', '1', NULL, NULL, 'N;'),
  ('Admin.Auth.*', '1', 'Admin.Auth.*', NULL, 'N;'),
  ('Admin.Default.*', '1', NULL, NULL, 'N;'),
  ('Site.Login', '0', NULL, NULL, 'N;'),
  ('Site.Index', '0', NULL, NULL, 'N;'),
  ('Site.Error', '0', NULL, NULL, 'N;'),
  ('Admin.Auth.Index', '0', NULL, NULL, 'N;'),
  ('Admin.Auth.Logout', '0', NULL, NULL, 'N;'),
  ('Admin.Default.Index', '0', NULL, NULL, 'N;');

-- 
-- Structure for table `AuthItemChild`
-- 

DROP TABLE IF EXISTS `AuthItemChild`;
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Structure for table `Pages`
-- 

DROP TABLE IF EXISTS `Pages`;
CREATE TABLE IF NOT EXISTS `Pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `full_description` tinytext NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Structure for table `Rights`
-- 

DROP TABLE IF EXISTS `Rights`;
CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Structure for table `SystemModules`
-- 

DROP TABLE IF EXISTS `SystemModules`;
CREATE TABLE IF NOT EXISTS `SystemModules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- 
-- Data for table `SystemModules`
-- 

INSERT INTO `SystemModules` (`id`, `name`, `enabled`) VALUES
  ('7', 'users', '1'),
  ('8', 'tests', '1'),
  ('9', 'pages', '1');

-- 
-- Structure for table `user`
-- 

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `login_ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Saves user accounts';

-- 
-- Data for table `user`
-- 

INSERT INTO `user` (`id`, `username`, `password`, `email`, `created_at`, `last_login`, `login_ip`) VALUES
  ('1', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'firstrow@gmail.com', '2011-08-21 10:17:15', '2011-10-23 22:29:10', '127.0.0.1'),
  ('10', 'tester', 'ab4d8d2a5f480a137067da17100271cd176607a1', 'tester@localhost.local', '2011-08-29 18:58:37', '2011-08-29 18:59:38', '127.0.0.1');


