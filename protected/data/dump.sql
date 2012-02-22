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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Data for table `Page`
--

INSERT INTO `Page` (`id`, `user_id`, `category_id`, `url`, `created`, `updated`, `publish_date`, `status`, `layout`, `view`) VALUES
  ('1', '1', '5', 'russian', '2011-12-03 18:55:11', '2012-02-07 00:48:17', '2011-12-03 18:55:06', 'published', '', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Data for table `PageTranslate`
--

INSERT INTO `PageTranslate` (`id`, `object_id`, `language_id`, `title`, `short_description`, `full_description`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
  ('1', '1', '1', 'russian page title', 'Short Desc', 'Full Desc', '', '', ''),
  ('2', '1', '9', 'english', 'dsfsdfs', 'dfsdfsdfsdf', '', '', '');

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
  PRIMARY KEY (`id`),
  KEY `use_in_filter` (`use_in_filter`),
  KEY `display_on_front` (`display_on_front`),
  KEY `position` (`position`),
  KEY `use_in_variants` (`use_in_variants`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreAttribute`
--

INSERT INTO `StoreAttribute` (`id`, `name`, `title`, `type`, `display_on_front`, `use_in_filter`, `use_in_variants`, `select_many`, `position`) VALUES
  ('27', 'color', 'Цвет', '3', '1', '1', '0', '0', '0'),
  ('28', 'size', 'Размер', '3', '1', '1', '0', '0', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

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
-- Structure for table `StoreManufacturer`
--

DROP TABLE IF EXISTS `StoreManufacturer`;
CREATE TABLE IF NOT EXISTS `StoreManufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreManufacturer`
--

INSERT INTO `StoreManufacturer` (`id`, `name`, `url`, `description`, `meta_title`, `meta_keywords`, `meta_description`, `layout`, `view`) VALUES
  ('1', 'Asus', 'asus', '', '', '', '', '', ''),
  ('2', 'Samsung', 'samsung', '', '', '', '', '', ''),
  ('3', 'Apple', 'apple', '', '', '', '', '', ''),
  ('9', 'Nokia', 'nokia', '', '', '', '', '', '');

--
-- Structure for table `StoreProduct`
--

DROP TABLE IF EXISTS `StoreProduct`;
CREATE TABLE IF NOT EXISTS `StoreProduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `use_configurations` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `short_description` text,
  `full_description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreProduct`
--

INSERT INTO `StoreProduct` (`id`, `manufacturer_id`, `type_id`, `use_configurations`, `name`, `url`, `price`, `is_active`, `short_description`, `full_description`, `meta_title`, `meta_keywords`, `meta_description`, `layout`, `view`, `sku`, `quantity`, `availability`, `auto_decrease_quantity`, `created`, `updated`) VALUES
  ('6', '3', '2', '0', 'Apple iPod touch 4Gen 8GB', 'apple-ipod-touch-4gen-8gb', '455', '1', '8 ГБ / AAC, защищённый AAC, HE-AAC, MP3, MP3 VBR, Audible, Apple Lossless, AIFF, WAV, H.264, M4V, MP4, MOV, MPEG-4, M-JPEG / сенсорный 3.5\" Multi-Touch дисплей / камера / USB 2.0 / 101 г', 'Теперь, с новым усовершенствованным Apple iPod touch, ваша любимая музыка, фильмы, игры и многое другое умещаются у вас на ладони.\r\nОтличный iPod\r\niPod Touch работает до 40 часов в режиме воспроизведения аудио — вся ваша любимая музыка всегда будет с вами.\r\nОтличный карманный компьютер\r\nНовое поколение iPod Touch почти на 50% быстрее, чем предыдущее. Программы запускаются быстрее, а веб-страницы загружаются почти мгновенно.', 'custom meta title', 'description', 'meta desc', '', '', '21334213', '0', '1', '1', '2012-01-07 21:31:35', '2012-02-16 22:09:28'),
  ('12', '3', '2', '0', 'Android Tablet', 'android-tablet', '344', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 16:26:05', '2012-02-05 18:17:09'),
  ('13', '2', '2', '0', 'Samsung Galaxy', 'samsung-galaxy', '233', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 16:26:23', '2012-01-28 11:40:20'),
  ('14', '2', '2', '0', 'Lenovo G656', 'lenovo-g656', '350', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 18:10:00', '2012-02-11 19:50:44'),
  ('15', '1', '2', '0', 'Antlant Cooler', 'antlant-cooler', '1200', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 19:28:13', '2012-02-05 18:18:24'),
  ('16', '1', '2', '0', 'Asus eee pc', 'asus-eee-pc', '345', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 22:41:17', '2012-02-09 00:56:13'),
  ('21', NULL, '3', '0', 'LG Flatron', 'lg-flatron', '570', '1', 'Среди производителей мониторов компания LG занимает одно из ведущих мест. Это стало возможным благодаря тому, что мониторы LG обладают исключительно высоким качеством изображения, эргономичным дизайном и высокой технологичностью. Неповторимый контраст, цвет \"<и обработка данных у мониторов CINEMA 3D, LCD мониторов и LED мониторов дают изображение невероятного качества.', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-28 00:18:57', '2012-02-05 22:37:19'),
  ('27', NULL, '11', '0', 'Red medium shirt', 'red-medium-shirt', '16', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-16 23:14:24', '2012-02-16 23:14:24'),
  ('26', NULL, '11', '0', 'White small shirt', 'white-small-shirt', '15', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-16 23:13:47', '2012-02-16 23:13:47'),
  ('28', NULL, '11', '1', 'Configurbale T-Shirt', 'configurbale-t-shirt', '0', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-16 23:48:01', '2012-02-19 17:34:52'),
  ('32', NULL, '11', '1', 'Antoher White Small Shirt', 'antoher-white-small-shirt', '12', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-18 13:57:48', '2012-02-18 13:57:48'),
  ('33', NULL, '11', '1', 'Red Medium Futbolko', 'red-medium-futbolko', '12', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-18 19:00:21', '2012-02-18 20:01:57'),
  ('34', NULL, '11', '0', 'White medium t-shirt', 'white-medium-t-shirt', '16', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-19 17:34:43', '2012-02-19 17:34:43');

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
-- Data for table `StoreProductAttributeEAV`
--

INSERT INTO `StoreProductAttributeEAV` (`entity`, `attribute`, `value`) VALUES
  ('27', 'color', '47'),
  ('26', 'size', '44'),
  ('26', 'color', '48'),
  ('34', 'size', '45'),
  ('34', 'color', '48'),
  ('32', 'size', '44'),
  ('27', 'size', '45'),
  ('32', 'color', '48');

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
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreProductCategoryRef`
--

INSERT INTO `StoreProductCategoryRef` (`id`, `product`, `category`, `is_main`) VALUES
  ('66', '27', '1', '1'),
  ('42', '13', '1', '0'),
  ('41', '13', '35', '1'),
  ('45', '14', '35', '1'),
  ('59', '12', '35', '0'),
  ('50', '16', '35', '0'),
  ('47', '6', '35', '1'),
  ('48', '15', '29', '1'),
  ('49', '16', '1', '1'),
  ('51', '12', '26', '1'),
  ('58', '21', '35', '1'),
  ('65', '26', '38', '1'),
  ('76', '34', '1', '1'),
  ('75', '28', '38', '1'),
  ('72', '32', '1', '1'),
  ('74', '33', '38', '1');

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
-- Data for table `StoreProductConfigurableAttributes`
--

INSERT INTO `StoreProductConfigurableAttributes` (`product_id`, `attribute_id`) VALUES
  ('28', '27'),
  ('28', '28'),
  ('32', '27'),
  ('32', '28'),
  ('33', '27'),
  ('33', '28');

--
-- Structure for table `StoreProductConfigurations`
--

DROP TABLE IF EXISTS `StoreProductConfigurations`;
CREATE TABLE IF NOT EXISTS `StoreProductConfigurations` (
  `product_id` int(11) NOT NULL COMMENT 'Saves relations beetwen product and configurations',
  `configurable_id` int(11) NOT NULL,
  UNIQUE KEY `product_conf_index` (`product_id`,`configurable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Data for table `StoreProductConfigurations`
--

INSERT INTO `StoreProductConfigurations` (`product_id`, `configurable_id`) VALUES
  ('28', '27'),
  ('28', '32'),
  ('28', '34');

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
-- Data for table `StoreProductImage`
--

INSERT INTO `StoreProductImage` (`id`, `product_id`, `name`, `is_main`, `uploaded_by`, `date_uploaded`) VALUES
  ('66', '16', '16.jpg', '1', '1', '2012-02-09 00:52:27'),
  ('65', '14', '14.png', '0', '1', '2012-02-08 22:42:07'),
  ('59', '6', '6.jpg', '1', '1', '2012-01-09 22:16:43'),
  ('61', '14', '14.jpg', '0', '1', '2012-02-08 22:41:41'),
  ('62', '14', '14_5f4207c3face408550da29f525c708e1.jpg', '0', '1', '2012-02-08 22:42:05'),
  ('63', '14', '14_3f3087cb89ea747610f6069ffa45e193.jpg', '1', '1', '2012-02-08 22:42:06'),
  ('64', '14', '14_017e58d3a0d03557f3893167e5000628.jpg', '0', '1', '2012-02-08 22:42:07');

--
-- Structure for table `StoreProductType`
--

DROP TABLE IF EXISTS `StoreProductType`;
CREATE TABLE IF NOT EXISTS `StoreProductType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreProductType`
--

INSERT INTO `StoreProductType` (`id`, `name`) VALUES
  ('2', 'Ноутбук'),
  ('3', 'Телевизор'),
  ('11', 'Shirt');

--
-- Structure for table `StoreProductVariant`
--

DROP TABLE IF EXISTS `StoreProductVariant`;
CREATE TABLE IF NOT EXISTS `StoreProductVariant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `price_type` tinyint(1) NOT NULL,
  `sku` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`),
  KEY `option_id` (`option_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=446 DEFAULT CHARSET=utf8 COMMENT='Handle related products';

--
-- Data for table `StoreRelatedProduct`
--

INSERT INTO `StoreRelatedProduct` (`id`, `product_id`, `related_id`) VALUES
  ('441', '14', '12'),
  ('440', '14', '15'),
  ('439', '14', '6'),
  ('438', '14', '16'),
  ('437', '14', '21');

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Data for table `SystemModules`
--

INSERT INTO `SystemModules` (`id`, `name`, `enabled`) VALUES
  ('7', 'users', '1'),
  ('9', 'pages', '1'),
  ('11', 'core', '1'),
  ('12', 'rights', '1'),
  ('15', 'store', '1');

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
  ('1', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'firstrow@gmail.com', '2011-08-21 10:17:15', '2012-02-19 16:55:12', '127.0.0.1'),
  ('10', 'tester', 'ab4d8d2a5f480a137067da17100271cd176607a1', 'tester@localhost.local', '2011-08-29 18:58:37', '2011-08-29 18:59:38', '127.0.0.1');

