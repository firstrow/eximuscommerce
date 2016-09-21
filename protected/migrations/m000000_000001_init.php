<?php
class m000000_000001_init extends CDbMigration
{
    public function up()
    {
        $this->execute('
CREATE TABLE `ActionLog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `event` tinyint(255) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `model_title` text NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `event` (`event`),
  KEY `datetime` (`datetime`),
  KEY `model_name` (`model_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT \'0\',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `Discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `sum` varchar(10) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `roles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `DiscountCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `DiscountManufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id` (`discount_id`),
  KEY `manufacturer_id` (`manufacturer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `Order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `secret_key` varchar(10) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `delivery_price` float(10,2) NOT NULL,
  `total_price` float(10,2) NOT NULL,
  `status_id` int(11) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL COMMENT \'delivery address\',
  `user_phone` varchar(30) NOT NULL,
  `user_comment` varchar(500) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `discount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `secret_key` (`secret_key`),
  KEY `delivery_id` (`delivery_id`),
  KEY `status_id` (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `OrderProduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `configurable_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `configurable_name` text NOT NULL COMMENT \'Store name of configurable product\',
  `configurable_data` text NOT NULL,
  `variants` text NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `configurable_id` (`configurable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `OrderStatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` int(11) DEFAULT \'0\',
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `Page` (
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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `url` (`url`),
  KEY `created` (`created`),
  KEY `updated` (`updated`),
  KEY `publish_date` (`publish_date`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `PageCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `full_url` text NOT NULL,
  `layout` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `page_size` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `url` (`url`),
  KEY `created` (`created`),
  KEY `updated` (`updated`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `PageCategoryTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `PageTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text,
  `full_description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreAttribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `display_on_front` tinyint(1) NOT NULL DEFAULT \'1\',
  `use_in_filter` tinyint(1) NOT NULL,
  `use_in_variants` tinyint(1) NOT NULL,
  `use_in_compare` tinyint(1) NOT NULL DEFAULT \'0\',
  `select_many` tinyint(1) NOT NULL,
  `position` int(11) DEFAULT \'0\',
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `use_in_filter` (`use_in_filter`),
  KEY `display_on_front` (`display_on_front`),
  KEY `position` (`position`),
  KEY `use_in_variants` (`use_in_variants`),
  KEY `use_in_compare` (`use_in_compare`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreAttributeOption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`),
  KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreAttributeOptionTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  KEY `object_id` (`object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreAttributeTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreCategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `full_path` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`),
  KEY `url` (`url`),
  KEY `full_path` (`full_path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreCategoryTranslate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreCurrency` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `iso` varchar(10) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `rate` float(10,3) NOT NULL,
  `main` tinyint(1) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreDeliveryMethod` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` float(10,2) NOT NULL DEFAULT \'0.00\',
  `free_from` float(10,2) NOT NULL DEFAULT \'0.00\',
  `position` smallint(6) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('
CREATE TABLE `StoreDeliveryMethodTranslate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
');

        $this->execute('CREATE TABLE `StoreDeliveryPayment` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'Saves relations between delivery and payment methods \';');

        $this->execute('CREATE TABLE `StoreManufacturer` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreManufacturerTranslate` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StorePaymentMethod` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `payment_system` varchar(100) NOT NULL,
  `position` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currency_id` (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StorePaymentMethodTranslate` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProduct` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `use_configurations` tinyint(1) NOT NULL DEFAULT \'0\',
  `url` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `max_price` float(10,2) NOT NULL DEFAULT \'0.00\',
  `is_active` tinyint(1) NOT NULL,
  `layout` varchar(255) DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT \'0\',
  `availability` tinyint(2) NOT NULL DEFAULT \'1\',
  `auto_decrease_quantity` tinyint(2) NOT NULL DEFAULT \'1\',
  `views_count` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `added_to_cart_count` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `discount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manufacturer_id` (`manufacturer_id`),
  KEY `type_id` (`type_id`),
  KEY `price` (`price`),
  KEY `max_price` (`max_price`),
  KEY `is_active` (`is_active`),
  KEY `sku` (`sku`),
  KEY `created` (`created`),
  KEY `updated` (`updated`),
  KEY `added_to_cart_count` (`added_to_cart_count`),
  KEY `views_count` (`views_count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProductAttributeEAV` (
    `entity` int(11) unsigned NOT NULL,
  `attribute` varchar(250) NOT NULL,
  `value` text NOT NULL,
  KEY `ikEntity` (`entity`),
  KEY `attribute` (`attribute`),
  KEY `value` (`value`(50))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProductCategoryRef` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `is_main` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `product` (`product`),
  KEY `is_main` (`is_main`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
        $this->execute('CREATE TABLE `StoreProductConfigurableAttributes` (
    `product_id` int(11) NOT NULL COMMENT \'Attributes available to configure product\',
  `attribute_id` int(11) NOT NULL,
  UNIQUE KEY `product_attribute_index` (`product_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProductConfigurations` (
    `product_id` int(11) NOT NULL COMMENT \'Saves relations beetwen product and configurations\',
  `configurable_id` int(11) NOT NULL,
  UNIQUE KEY `idsunique` (`product_id`,`configurable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProductImage` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT \'0\',
  `uploaded_by` int(11) NOT NULL,
  `date_uploaded` datetime NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProductTranslate` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProductType` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `categories_preset` text NOT NULL,
  `main_category` int(11) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreProductVariant` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float(10,2) NOT NULL DEFAULT \'0.00\',
  `price_type` tinyint(1) NOT NULL,
  `sku` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`),
  KEY `option_id` (`option_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreRelatedProduct` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'Handle related products\';');

        $this->execute('CREATE TABLE `StoreTypeAttribute` (
    `type_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  PRIMARY KEY (`type_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreWishlist` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `StoreWishlistProducts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `wishlist_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlist_id` (`wishlist_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `SystemLanguage` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(25) NOT NULL,
  `locale` varchar(100) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `flag_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `SystemModules` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `SystemSettings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `accounting1c` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT NULL,
  `object_type` int(11) DEFAULT NULL,
  `external_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `object_type` (`object_type`),
  KEY `external_id` (`external_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `grid_view_filter` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `grid_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `notifications` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $this->execute('CREATE TABLE `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `login_ip` varchar(255) NOT NULL,
  `recovery_key` varchar(20) NOT NULL,
  `recovery_password` varchar(100) NOT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\'Saves user accounts\';');

        $this->execute('CREATE TABLE `user_profile` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
    }
    public function down()
    {
        $this->execute('DROP TABLE `StoreProductCategoryRef`;');
        $this->execute('DROP TABLE `StoreProductAttributeEAV`;');
        $this->execute('DROP TABLE `StoreProduct`;');
        $this->execute('DROP TABLE `StoreProductImage`;');
        $this->execute('DROP TABLE `StoreProductConfigurations`;');
        $this->execute('DROP TABLE `StoreProductConfigurableAttributes`;');
        $this->execute('DROP TABLE `StorePaymentMethodTranslate`;');
        $this->execute('DROP TABLE `StoreDeliveryPayment`;');
        $this->execute('DROP TABLE `StoreDeliveryMethodTranslate`;');
        $this->execute('DROP TABLE `StoreDeliveryMethod`;');
        $this->execute('DROP TABLE `StorePaymentMethod`;');
        $this->execute('DROP TABLE `StoreManufacturerTranslate`;');
        $this->execute('DROP TABLE `StoreManufacturer`;');
        $this->execute('DROP TABLE `SystemSettings`;');
        $this->execute('DROP TABLE `SystemModules`;');
        $this->execute('DROP TABLE `SystemLanguage`;');
        $this->execute('DROP TABLE `user_profile`;');
        $this->execute('DROP TABLE `user`;');
        $this->execute('DROP TABLE `tbl_migration`;');
        $this->execute('DROP TABLE `StoreWishlistProducts`;');
        $this->execute('DROP TABLE `StoreProductVariant`;');
        $this->execute('DROP TABLE `StoreProductType`;');
        $this->execute('DROP TABLE `StoreProductTranslate`;');
        $this->execute('DROP TABLE `StoreWishlist`;');
        $this->execute('DROP TABLE `StoreTypeAttribute`;');
        $this->execute('DROP TABLE `StoreRelatedProduct`;');
        $this->execute('DROP TABLE `StoreCurrency`;');
        $this->execute('DROP TABLE `grid_view_filter`;');
        $this->execute('DROP TABLE `DiscountManufacturer`;');
        $this->execute('DROP TABLE `DiscountCategory`;');
        $this->execute('DROP TABLE `OrderHistory`;');
        $this->execute('DROP TABLE `Order`;');
        $this->execute('DROP TABLE `notifications`;');
        $this->execute('DROP TABLE `Discount`;');
        $this->execute('DROP TABLE `AuthAssignment`;');
        $this->execute('DROP TABLE `ActionLog`;');
        $this->execute('DROP TABLE `accounting1c`;');
        $this->execute('DROP TABLE `Comments`;');
        $this->execute('DROP TABLE `AuthItemChild`;');
        $this->execute('DROP TABLE `AuthItem`;');
        $this->execute('DROP TABLE `StoreAttributeOptionTranslate`;');
        $this->execute('DROP TABLE `StoreAttributeOption`;');
        $this->execute('DROP TABLE `StoreAttribute`;');
        $this->execute('DROP TABLE `StoreCategoryTranslate`;');
        $this->execute('DROP TABLE `StoreCategory`;');
        $this->execute('DROP TABLE `StoreAttributeTranslate`;');
        $this->execute('DROP TABLE `Rights`;');
        $this->execute('DROP TABLE `Page`;');
        $this->execute('DROP TABLE `OrderStatus`;');
        $this->execute('DROP TABLE `OrderProduct`;');
        $this->execute('DROP TABLE `PageTranslate`;');
        $this->execute('DROP TABLE `PageCategoryTranslate`;');
        $this->execute('DROP TABLE `PageCategory`;');
    }
}