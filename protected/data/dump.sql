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
  ('Guest', '2', NULL, NULL, 'N;');

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
-- Structure for table `Comments`
-- 

DROP TABLE IF EXISTS `Comments`;
CREATE TABLE IF NOT EXISTS `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `class_name` varchar(100) NOT NULL,
  `object_pk` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `class_name_index` (`class_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- 
-- Structure for table `Order`
-- 

DROP TABLE IF EXISTS `Order`;
CREATE TABLE IF NOT EXISTS `Order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `delivery_id` int(11) NOT NULL,
  `delivery_price` float(10,2) NOT NULL,
  `total_price` float(10,2) NOT NULL,
  `status_id` int(11) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL COMMENT 'delivery address',
  `user_phone` varchar(30) NOT NULL,
  `user_comment` varchar(500) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- 
-- Data for table `Order`
-- 

INSERT INTO `Order` (`id`, `user_id`, `delivery_id`, `delivery_price`, `total_price`, `status_id`, `paid`, `user_name`, `user_email`, `user_address`, `user_phone`, `user_comment`, `ip_address`, `created`, `updated`) VALUES
  ('17', NULL, '11', '10', '30', '3', '0', 'tester', 'tester@lovalhost.loc', '', '', '', '127.0.0.1', '2012-04-02 22:01:59', '2012-04-02 22:04:38'),
  ('16', NULL, '11', '10', '30', '1', '0', 'Tester', 'tester@lovalhost.loc', 'str. Vodoginna 2', '380997537215', '', '127.0.0.1', '2012-04-01 19:05:14', '2012-04-01 20:01:30'),
  ('15', NULL, '11', '0', '200', '1', '1', 'Tester', 'tester@lovalhost.loc', '', '', '', '127.0.0.1', '2012-04-01 17:01:36', '2012-04-01 17:50:14'),
  ('11', NULL, '9', '0', '130', '2', '0', 'Tester', 'tester@lovalhost.loc', 'str. Vodoginna 2', '380997537215', '', '127.0.0.1', '2012-03-25 11:22:03', '2012-04-01 21:30:30'),
  ('14', NULL, '9', '0', '30', '3', '1', 'Tester', 'tester@lovalhost.loc', 'Lviv', '0990000000', 'testing new orders', '127.0.0.1', '2012-04-01 16:59:33', '2012-04-01 17:50:32'),
  ('18', NULL, '11', '10', '399', '2', '1', 'Andrew Firstrow', 'andrew@localhost.com', '', '', 'comment \">', '127.0.0.1', '2012-04-02 22:05:17', '2012-04-02 22:05:57');

-- 
-- Structure for table `OrderProduct`
-- 

DROP TABLE IF EXISTS `OrderProduct`;
CREATE TABLE IF NOT EXISTS `OrderProduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `configurable_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `configurable_name` text NOT NULL COMMENT 'Store name of configurable product',
  `variants` text NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `configurable_id` (`configurable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- 
-- Data for table `OrderProduct`
-- 

INSERT INTO `OrderProduct` (`id`, `order_id`, `product_id`, `configurable_id`, `name`, `configurable_name`, `variants`, `quantity`, `sku`, `price`) VALUES
  ('102', '11', '52', '0', 'Test one configuration', '', '', '1', '', '10'),
  ('104', '11', '53', '0', 'Test variants', '', '', '1', '123qwe34er3', '100'),
  ('105', '17', '48', '0', 'Белаяя средняя футболка', '', '', '2', '', '15'),
  ('106', '18', '46', '0', 'test nonebook', '', '', '1', '', '399'),
  ('94', '0', '48', '0', 'Белаяя средняя футболка', '', '', '2', '', '15'),
  ('95', '0', '48', '0', 'Белаяя средняя футболка', '', '', '2', '', '15'),
  ('92', '15', '53', '0', 'Test variants', '', '', '2', '123qwe34er3', '100'),
  ('93', '0', '48', '0', 'Белаяя средняя футболка', '', '', '2', '', '15'),
  ('89', '14', '48', '0', 'Белаяя средняя футболка', '', '', '2', '', '15'),
  ('83', '11', '52', '0', 'Test one configuration', '', '', '1', '', '10'),
  ('100', '16', '52', '0', 'Test one configuration', '', '', '3', '', '10'),
  ('103', '11', '47', '0', 'Красная маленькая футболка', '', '', '1', '', '10');

-- 
-- Structure for table `OrderStatus`
-- 

DROP TABLE IF EXISTS `OrderStatus`;
CREATE TABLE IF NOT EXISTS `OrderStatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- 
-- Data for table `OrderStatus`
-- 

INSERT INTO `OrderStatus` (`id`, `name`, `position`) VALUES
  ('1', 'Новый', '0'),
  ('2', 'Доставлен', '1'),
  ('3', 'Отменен', '2');

-- 
-- Structure for table `Page`
-- 

DROP TABLE IF EXISTS `Page`;
CREATE TABLE IF NOT EXISTS `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `publish_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `layout` varchar(2555) NOT NULL,
  `view` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 
-- Data for table `Page`
-- 

INSERT INTO `Page` (`id`, `user_id`, `category_id`, `url`, `created`, `updated`, `publish_date`, `status`, `layout`, `view`) VALUES
  ('1', '1', '5', 'russian', '2011-12-03 18:55:11', '2012-03-03 22:09:34', '2012-03-01 22:09:02', 'published', '', ''),
  ('4', '1', '5', 'test--page', '2012-04-01 21:20:25', '2012-04-01 21:20:25', '2012-04-01 21:20:00', 'published', '', '');

-- 
-- Structure for table `PageCategory`
-- 

DROP TABLE IF EXISTS `PageCategory`;
CREATE TABLE IF NOT EXISTS `PageCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `full_url` text NOT NULL,
  `layout` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `page_size` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- 
-- Data for table `PageCategory`
-- 

INSERT INTO `PageCategory` (`id`, `parent_id`, `url`, `full_url`, `layout`, `view`, `created`, `updated`, `page_size`) VALUES
  ('1', NULL, 'knigi', 'knigi', '', '', '2011-12-03 18:49:46', '2011-12-03 19:36:31', NULL),
  ('2', '1', 'fantastika', 'knigi/fantastika', '', '', '2011-12-03 18:50:25', '2011-12-03 22:35:07', NULL),
  ('4', '1', 'romani', 'knigi/romani', '', '', '2011-12-03 18:50:45', '2011-12-03 18:50:45', NULL),
  ('5', '1', 'nauchnie-knigi', 'knigi/nauchnie-knigi', '', '', '2011-12-03 18:51:03', '2011-12-27 22:51:57', NULL);

-- 
-- Structure for table `PageCategoryTranslate`
-- 

DROP TABLE IF EXISTS `PageCategoryTranslate`;
CREATE TABLE IF NOT EXISTS `PageCategoryTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- 
-- Data for table `PageCategoryTranslate`
-- 

INSERT INTO `PageCategoryTranslate` (`id`, `object_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
  ('1', '1', '1', 'Книги', '', '', '', ''),
  ('2', '1', '9', 'Books', '', '', '', ''),
  ('3', '2', '1', 'Фантастика', '', '', '', ''),
  ('4', '2', '9', 'Фантастика', '', '', '', ''),
  ('7', '4', '1', 'Романы', '', '', '', ''),
  ('8', '4', '9', 'Романы', '', '', '', ''),
  ('9', '5', '1', 'Научные книги', '', '', '', ''),
  ('10', '5', '9', 'Научные книги', '', '', '', '');

-- 
-- Structure for table `PageTranslate`
-- 

DROP TABLE IF EXISTS `PageTranslate`;
CREATE TABLE IF NOT EXISTS `PageTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text,
  `full_description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- 
-- Data for table `PageTranslate`
-- 

INSERT INTO `PageTranslate` (`id`, `object_id`, `language_id`, `title`, `short_description`, `full_description`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
  ('1', '1', '1', 'russian page title', 'Short Desc', 'Full Desc', '', '', ''),
  ('2', '1', '9', 'english', 'dsfsdfs', 'dfsdfsdfsdf', '', '', ''),
  ('7', '4', '1', 'test  page', 'short', 'full', '', '', ''),
  ('8', '4', '9', 'test  page', 'short', 'full', '', '', '');

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
-- Structure for table `StoreAttribute`
-- 

DROP TABLE IF EXISTS `StoreAttribute`;
CREATE TABLE IF NOT EXISTS `StoreAttribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `display_on_front` tinyint(1) NOT NULL DEFAULT '1',
  `use_in_filter` tinyint(1) NOT NULL,
  `use_in_variants` tinyint(1) NOT NULL,
  `select_many` tinyint(1) NOT NULL,
  `position` int(11) DEFAULT '0',
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `use_in_filter` (`use_in_filter`),
  KEY `display_on_front` (`display_on_front`),
  KEY `position` (`position`),
  KEY `use_in_variants` (`use_in_variants`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreAttribute`
-- 

INSERT INTO `StoreAttribute` (`id`, `name`, `title`, `type`, `display_on_front`, `use_in_filter`, `use_in_variants`, `select_many`, `position`, `required`) VALUES
  ('27', 'color', 'Цвет', '3', '1', '1', '1', '0', '0', '1'),
  ('28', 'size', 'Размер', '3', '1', '1', '1', '0', '1', '0');

-- 
-- Structure for table `StoreAttributeOption`
-- 

DROP TABLE IF EXISTS `StoreAttributeOption`;
CREATE TABLE IF NOT EXISTS `StoreAttributeOption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreAttributeOption`
-- 

INSERT INTO `StoreAttributeOption` (`id`, `attribute_id`, `value`, `position`) VALUES
  ('50', '27', 'Blue', '3'),
  ('51', '27', 'Silver', '4'),
  ('44', '28', 'Small', '0'),
  ('45', '28', 'Medium', '1'),
  ('46', '28', 'Large', '2'),
  ('47', '27', 'Red', '0'),
  ('48', '27', 'White', '1'),
  ('49', '27', 'Black', '2');

-- 
-- Structure for table `StoreCategory`
-- 

DROP TABLE IF EXISTS `StoreCategory`;
CREATE TABLE IF NOT EXISTS `StoreCategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `full_path` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`),
  KEY `url` (`url`),
  KEY `full_path` (`full_path`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreCategory`
-- 

INSERT INTO `StoreCategory` (`id`, `lft`, `rgt`, `level`, `name`, `url`, `full_path`, `meta_title`, `meta_keywords`, `meta_description`, `layout`, `view`) VALUES
  ('1', '1', '22', '1', 'root', 'root', '', '', '', '', '', ''),
  ('26', '4', '11', '2', 'Техника', 'tehnika', 'tehnika', 'title', 'keywords', 'desc', '', ''),
  ('29', '5', '6', '3', 'Холодильники', 'xolodilniki', 'tehnika/xolodilniki', '', '', '', '', ''),
  ('16', '8', '9', '4', 'Second', 'secosdfs-ssss', 'secosdfs-ssss', '', '', '', '', ''),
  ('35', '7', '10', '3', 'Ноутбуки', 'noutbuki', 'tehnika/noutbuki', '', '', '', '', ''),
  ('36', '2', '3', '2', 'Test Category', 'test-category', 'tehnika/noutbuki/test-category', '', '', '', '', ''),
  ('38', '12', '13', '2', 'Shirts', 'shirts', 'shirts', '', '', '', '', '');

-- 
-- Structure for table `StoreCurrency`
-- 

DROP TABLE IF EXISTS `StoreCurrency`;
CREATE TABLE IF NOT EXISTS `StoreCurrency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `iso` varchar(10) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `rate` float(10,3) NOT NULL,
  `main` tinyint(1) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreCurrency`
-- 

INSERT INTO `StoreCurrency` (`id`, `name`, `iso`, `symbol`, `rate`, `main`, `default`) VALUES
  ('1', 'Dollars', 'USD', '$', '1', '1', '1'),
  ('2', 'Гривня', 'UAH', 'грн.', '8', '0', '0');

-- 
-- Structure for table `StoreDeliveryMethod`
-- 

DROP TABLE IF EXISTS `StoreDeliveryMethod`;
CREATE TABLE IF NOT EXISTS `StoreDeliveryMethod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` float(10,2) DEFAULT '0.00',
  `free_from` float(10,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `position` smallint(6) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreDeliveryMethod`
-- 

INSERT INTO `StoreDeliveryMethod` (`id`, `name`, `price`, `free_from`, `description`, `position`, `active`) VALUES
  ('9', 'Курьер', '0', '0', 'test descriptino goes here', '3', '1'),
  ('10', 'Новая Почта', '0', '0', 'test descriptino goes here', '1', '1'),
  ('11', 'Самовывоз', '10', '0', 'test descriptino goes here', '2', '1'),
  ('12', 'Автолюкс', '0', '0', 'доставка автолюксом', '4', '1');

-- 
-- Structure for table `StoreDeliveryPayment`
-- 

DROP TABLE IF EXISTS `StoreDeliveryPayment`;
CREATE TABLE IF NOT EXISTS `StoreDeliveryPayment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='Saves relations between delivery and payment methods ';

-- 
-- Data for table `StoreDeliveryPayment`
-- 

INSERT INTO `StoreDeliveryPayment` (`id`, `delivery_id`, `payment_id`) VALUES
  ('24', '12', '14'),
  ('23', '10', '16'),
  ('22', '10', '13'),
  ('21', '10', '14'),
  ('34', '11', '16'),
  ('33', '11', '13'),
  ('25', '12', '15'),
  ('26', '12', '16');

-- 
-- Structure for table `StoreManufacturer`
-- 

DROP TABLE IF EXISTS `StoreManufacturer`;
CREATE TABLE IF NOT EXISTS `StoreManufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- 
-- Structure for table `StoreManufacturerTranslate`
-- 

DROP TABLE IF EXISTS `StoreManufacturerTranslate`;
CREATE TABLE IF NOT EXISTS `StoreManufacturerTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- 
-- Structure for table `StorePaymentMethod`
-- 

DROP TABLE IF EXISTS `StorePaymentMethod`;
CREATE TABLE IF NOT EXISTS `StorePaymentMethod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `active` tinyint(1) DEFAULT NULL,
  `position` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StorePaymentMethod`
-- 

INSERT INTO `StorePaymentMethod` (`id`, `name`, `description`, `active`, `position`) VALUES
  ('14', 'Second', '', '1', '1'),
  ('13', 'WebMoney', '', '1', '0'),
  ('15', 'Third', '', '1', '2'),
  ('16', 'Наличные', '', '1', '3');

-- 
-- Structure for table `StoreProduct`
-- 

DROP TABLE IF EXISTS `StoreProduct`;
CREATE TABLE IF NOT EXISTS `StoreProduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `use_configurations` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `max_price` float(10,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL,
  `layout` varchar(255) DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT '0',
  `availability` tinyint(2) NOT NULL DEFAULT '1',
  `auto_decrease_quantity` tinyint(2) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `manufacturer_id` (`manufacturer_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreProduct`
-- 

INSERT INTO `StoreProduct` (`id`, `manufacturer_id`, `type_id`, `use_configurations`, `url`, `price`, `max_price`, `is_active`, `layout`, `view`, `sku`, `quantity`, `availability`, `auto_decrease_quantity`, `created`, `updated`) VALUES
  ('55', '0', '2', '0', 'russian', '10', '0', '1', '', '', '', '0', '1', '1', '2012-04-05 21:41:07', '2012-04-05 22:25:59');

-- 
-- Structure for table `StoreProductAttributeEAV`
-- 

DROP TABLE IF EXISTS `StoreProductAttributeEAV`;
CREATE TABLE IF NOT EXISTS `StoreProductAttributeEAV` (
  `entity` int(11) unsigned NOT NULL,
  `attribute` varchar(250) NOT NULL,
  `value` text NOT NULL,
  KEY `ikEntity` (`entity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Structure for table `StoreProductCategoryRef`
-- 

DROP TABLE IF EXISTS `StoreProductCategoryRef`;
CREATE TABLE IF NOT EXISTS `StoreProductCategoryRef` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `is_main` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `product` (`product`),
  KEY `is_main` (`is_main`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreProductCategoryRef`
-- 

INSERT INTO `StoreProductCategoryRef` (`id`, `product`, `category`, `is_main`) VALUES
  ('106', '55', '35', '1'),
  ('105', '55', '29', '0');

-- 
-- Structure for table `StoreProductConfigurableAttributes`
-- 

DROP TABLE IF EXISTS `StoreProductConfigurableAttributes`;
CREATE TABLE IF NOT EXISTS `StoreProductConfigurableAttributes` (
  `product_id` int(11) NOT NULL COMMENT 'Attributes available to configure product',
  `attribute_id` int(11) NOT NULL,
  UNIQUE KEY `product_attribute_index` (`product_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Structure for table `StoreProductConfigurations`
-- 

DROP TABLE IF EXISTS `StoreProductConfigurations`;
CREATE TABLE IF NOT EXISTS `StoreProductConfigurations` (
  `product_id` int(11) NOT NULL COMMENT 'Saves relations beetwen product and configurations',
  `configurable_id` int(11) NOT NULL,
  UNIQUE KEY `idsunique` (`product_id`,`configurable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Structure for table `StoreProductImage`
-- 

DROP TABLE IF EXISTS `StoreProductImage`;
CREATE TABLE IF NOT EXISTS `StoreProductImage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT '0',
  `uploaded_by` int(11) NOT NULL,
  `date_uploaded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- 
-- Structure for table `StoreProductTranslate`
-- 

DROP TABLE IF EXISTS `StoreProductTranslate`;
CREATE TABLE IF NOT EXISTS `StoreProductTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` text,
  `full_description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreProductTranslate`
-- 

INSERT INTO `StoreProductTranslate` (`id`, `object_id`, `language_id`, `name`, `short_description`, `full_description`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
  ('57', '55', '9', 'English', '', '', '', '', ''),
  ('56', '55', '1', 'Russian', '', '', '', '', '');

-- 
-- Structure for table `StoreProductType`
-- 

DROP TABLE IF EXISTS `StoreProductType`;
CREATE TABLE IF NOT EXISTS `StoreProductType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `categories_preset` text NOT NULL,
  `main_category` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreProductType`
-- 

INSERT INTO `StoreProductType` (`id`, `name`, `categories_preset`, `main_category`) VALUES
  ('2', 'Ноутбук', 'a:2:{i:0;s:2:\"29\";i:1;s:2:\"35\";}', '35'),
  ('3', 'Телевизор', '', '0'),
  ('11', 'Футболка', 'a:1:{i:0;s:2:\"38\";}', '38');

-- 
-- Structure for table `StoreProductVariant`
-- 

DROP TABLE IF EXISTS `StoreProductVariant`;
CREATE TABLE IF NOT EXISTS `StoreProductVariant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `price_type` tinyint(1) NOT NULL,
  `sku` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`),
  KEY `option_id` (`option_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- 
-- Structure for table `StoreRelatedProduct`
-- 

DROP TABLE IF EXISTS `StoreRelatedProduct`;
CREATE TABLE IF NOT EXISTS `StoreRelatedProduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=452 DEFAULT CHARSET=utf8 COMMENT='Handle related products';

-- 
-- Structure for table `StoreTypeAttribute`
-- 

DROP TABLE IF EXISTS `StoreTypeAttribute`;
CREATE TABLE IF NOT EXISTS `StoreTypeAttribute` (
  `type_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  PRIMARY KEY (`type_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Data for table `StoreTypeAttribute`
-- 

INSERT INTO `StoreTypeAttribute` (`type_id`, `attribute_id`) VALUES
  ('11', '27'),
  ('11', '28');

-- 
-- Structure for table `SystemLanguage`
-- 

DROP TABLE IF EXISTS `SystemLanguage`;
CREATE TABLE IF NOT EXISTS `SystemLanguage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(25) NOT NULL,
  `locale` varchar(100) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `flag_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- 
-- Data for table `SystemLanguage`
-- 

INSERT INTO `SystemLanguage` (`id`, `name`, `code`, `locale`, `default`, `flag_name`) VALUES
  ('1', 'Russian', 'ru', 'ru', '1', 'ru.png'),
  ('9', 'English', 'en', 'en', '0', 'us.png');

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- 
-- Data for table `SystemModules`
-- 

INSERT INTO `SystemModules` (`id`, `name`, `enabled`) VALUES
  ('7', 'users', '1'),
  ('9', 'pages', '1'),
  ('11', 'core', '1'),
  ('12', 'rights', '1'),
  ('16', 'orders', '1'),
  ('15', 'store', '1'),
  ('17', 'comments', '1');

-- 
-- Structure for table `grid_view_filter`
-- 

DROP TABLE IF EXISTS `grid_view_filter`;
CREATE TABLE IF NOT EXISTS `grid_view_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `grid_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

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
  ('1', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'firstrow@gmail.com', '2011-08-21 10:17:15', '2012-04-01 11:14:38', '127.0.0.1'),
  ('10', 'tester', 'ab4d8d2a5f480a137067da17100271cd176607a1', 'tester@localhost.local', '2011-08-29 18:58:37', '2011-08-29 18:59:38', '127.0.0.1');


