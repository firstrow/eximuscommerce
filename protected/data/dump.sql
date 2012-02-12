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
  ('Store.FrontProduct.View', '0', NULL, NULL, 'N;'),
  ('Store.FrontProduct.*', '1', NULL, NULL, 'N;');

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
  `select_many` tinyint(1) NOT NULL,
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `use_in_filter` (`use_in_filter`),
  KEY `display_on_front` (`display_on_front`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreAttribute`
--

INSERT INTO `StoreAttribute` (`id`, `name`, `title`, `type`, `display_on_front`, `use_in_filter`, `select_many`, `position`) VALUES
  ('1', 'color', 'Цвет', '6', '1', '1', '1', '1'),
  ('3', 'size', 'Размер', '3', '1', '1', '0', '2'),
  ('7', 'garanty', 'Имеет гарантию', '7', '1', '0', '0', '4'),
  ('6', 'display', 'Дисплей', '2', '1', '0', '0', '3');

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
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreAttributeOption`
--

INSERT INTO `StoreAttributeOption` (`id`, `attribute_id`, `value`, `position`) VALUES
  ('43', '1', 'Orange', '5'),
  ('24', '3', 'XXL', '2'),
  ('23', '3', 'XL', '1'),
  ('22', '3', 'L', '0'),
  ('42', '1', 'Yellow', '4'),
  ('41', '1', 'Silver', '3'),
  ('40', '1', 'Blue', '2'),
  ('36', '1', 'Green', '1'),
  ('39', '1', 'Red', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreCategory`
--

INSERT INTO `StoreCategory` (`id`, `lft`, `rgt`, `level`, `name`, `url`, `full_path`, `meta_title`, `meta_keywords`, `meta_description`, `layout`, `view`) VALUES
  ('1', '1', '20', '1', 'root', 'root', '', '', '', '', '', ''),
  ('26', '4', '11', '2', 'Техника', 'tehnika', 'tehnika', 'title', 'keywords', 'desc', '', ''),
  ('29', '5', '6', '3', 'Холодильники', 'xolodilniki', 'tehnika/xolodilniki', '', '', '', '', ''),
  ('16', '8', '9', '4', 'Second', 'secosdfs-ssss', 'secosdfs-ssss', '', '', '', '', ''),
  ('35', '7', '10', '3', 'Ноутбуки', 'noutbuki', 'tehnika/noutbuki', '', '', '', '', ''),
  ('36', '2', '3', '2', 'Test Category', 'test-category', 'tehnika/noutbuki/test-category', '', '', '', '', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreProduct`
--

INSERT INTO `StoreProduct` (`id`, `manufacturer_id`, `type_id`, `name`, `url`, `price`, `is_active`, `short_description`, `full_description`, `meta_title`, `meta_keywords`, `meta_description`, `layout`, `view`, `sku`, `quantity`, `availability`, `auto_decrease_quantity`, `created`, `updated`) VALUES
  ('6', '3', '2', 'Apple iPod touch 4Gen 8GB', 'apple-ipod-touch-4gen-8gb', '455', '1', '8 ГБ / AAC, защищённый AAC, HE-AAC, MP3, MP3 VBR, Audible, Apple Lossless, AIFF, WAV, H.264, M4V, MP4, MOV, MPEG-4, M-JPEG / сенсорный 3.5\" Multi-Touch дисплей / камера / USB 2.0 / 101 г', 'Теперь, с новым усовершенствованным Apple iPod touch, ваша любимая музыка, фильмы, игры и многое другое умещаются у вас на ладони.\r\nОтличный iPod\r\niPod Touch работает до 40 часов в режиме воспроизведения аудио — вся ваша любимая музыка всегда будет с вами.\r\nОтличный карманный компьютер\r\nНовое поколение iPod Touch почти на 50% быстрее, чем предыдущее. Программы запускаются быстрее, а веб-страницы загружаются почти мгновенно.', 'custom meta title', 'description', 'meta desc', '', '', '21334213', '0', '1', '1', '2012-01-07 21:31:35', '2012-02-09 00:27:55'),
  ('12', '3', '2', 'Android Tablet', 'android-tablet', '344', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 16:26:05', '2012-02-05 18:17:09'),
  ('13', '2', '2', 'Samsung Galaxy', 'samsung-galaxy', '233', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 16:26:23', '2012-01-28 11:40:20'),
  ('14', '2', '2', 'Lenovo G656', 'lenovo-g656', '350', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 18:10:00', '2012-02-11 19:50:44'),
  ('15', '1', '2', 'Antlant Cooler', 'antlant-cooler', '1200', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 19:28:13', '2012-02-05 18:18:24'),
  ('16', '1', '2', 'Asus eee pc', 'asus-eee-pc', '345', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-14 22:41:17', '2012-02-09 00:56:13'),
  ('21', NULL, '3', 'LG Flatron', 'lg-flatron', '570', '1', 'Среди производителей мониторов компания LG занимает одно из ведущих мест. Это стало возможным благодаря тому, что мониторы LG обладают исключительно высоким качеством изображения, эргономичным дизайном и высокой технологичностью. Неповторимый контраст, цвет \"<и обработка данных у мониторов CINEMA 3D, LCD мониторов и LED мониторов дают изображение невероятного качества.', '', '', '', '', '', '', '', '0', '1', '1', '2012-01-28 00:18:57', '2012-02-05 22:37:19'),
  ('23', NULL, '2', 'test product', 'test-product', '123', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-06 23:48:47', '2012-02-09 00:57:36'),
  ('24', NULL, '2', 'no category product', 'no-category-product', '5', '1', '', '', '', '', '', '', '', '', '0', '1', '1', '2012-02-09 00:56:29', '2012-02-09 00:56:29');

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
  ('16', 'size', '23'),
  ('16', 'color', '42'),
  ('12', 'size', '24'),
  ('12', 'color', '40'),
  ('12', 'color', '36'),
  ('12', 'color', '39'),
  ('6', 'size', '22'),
  ('6', 'color', '36'),
  ('15', 'color', '39'),
  ('15', 'color', '36'),
  ('15', 'color', '40'),
  ('15', 'size', '23'),
  ('16', 'color', '36'),
  ('21', 'size', '22'),
  ('21', 'color', '39');

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
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreProductCategoryRef`
--

INSERT INTO `StoreProductCategoryRef` (`id`, `product`, `category`, `is_main`) VALUES
  ('63', '23', '1', '1'),
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
  ('62', '24', '1', '1');

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Data for table `StoreProductType`
--

INSERT INTO `StoreProductType` (`id`, `name`) VALUES
  ('2', 'Ноутбук'),
  ('3', 'Телевизор');

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
) ENGINE=MyISAM AUTO_INCREMENT=442 DEFAULT CHARSET=utf8 COMMENT='Handle related products';

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
  ('2', '1'),
  ('2', '3'),
  ('2', '6'),
  ('2', '7'),
  ('3', '1'),
  ('3', '3'),
  ('3', '6'),
  ('3', '7');

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
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

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
  ('1', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'firstrow@gmail.com', '2011-08-21 10:17:15', '2012-02-07 23:33:52', '127.0.0.1'),
  ('10', 'tester', 'ab4d8d2a5f480a137067da17100271cd176607a1', 'tester@localhost.local', '2011-08-29 18:58:37', '2011-08-29 18:59:38', '127.0.0.1');

