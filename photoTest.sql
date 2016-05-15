-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 15 2016 г., 18:14
-- Версия сервера: 5.7.11
-- Версия PHP: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `photoTest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `modified_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Дамп данных таблицы `albums`
--

INSERT INTO `albums` (`id`, `user_id`, `name`, `active`, `created_at`, `modified_at`) VALUES
(78, 123, 'Animals', 1, 1463007644, 1463007644),
(82, 123, 'Fifties', 1, 1463016461, 1463016461),
(83, 125, 'Fifties', 1, 1463017989, 1463035802),
(84, 123, 'Fifties', 1, 1463017989, 1463017990),
(85, 125, 'Fifties', 1, 1463035802, 1463141298),
(86, 123, 'Fifties', 1, 1463035802, 1463035802),
(87, 125, 'Fifties', 1, 1463141297, 1463142890),
(88, 123, 'Fifties', 1, 1463141298, 1463141299),
(89, 125, 'Fifties', 1, 1463142890, 1463142931),
(90, 123, 'Fifties', 1, 1463142891, 1463142891),
(91, 125, 'Fifties', 1, 1463142930, 1463148053),
(92, 123, 'Fifties', 1, 1463142931, 1463142931),
(93, 125, 'Fifties', 1, 1463148052, 1463229678),
(94, 123, 'Fifties', 1, 1463148053, 1463148054),
(95, 125, 'Wedding', 1, 1463229678, 1463229678),
(96, 123, 'Fifties', 1, 1463229679, 1463229679);

-- --------------------------------------------------------

--
-- Структура таблицы `album_clients`
--

CREATE TABLE IF NOT EXISTS `album_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `access` enum('read','grant') NOT NULL DEFAULT 'read',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  KEY `album/clients_ibfk_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `album_clients`
--

INSERT INTO `album_clients` (`id`, `album_id`, `user_id`, `access`, `created_at`) VALUES
(16, 78, 122, 'read', 1463013875);

-- --------------------------------------------------------

--
-- Структура таблицы `album_images`
--

CREATE TABLE IF NOT EXISTS `album_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(10) unsigned NOT NULL,
  `image` varchar(50) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album` (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Дамп данных таблицы `album_images`
--

INSERT INTO `album_images` (`id`, `album_id`, `image`, `created_at`) VALUES
(121, 78, 'fly1_1463240722.jpg', 1463240722),
(122, 78, 'fly2_1463240728.jpg', 1463240728),
(123, 78, 'fly3_1463240734.jpg', 1463240734),
(124, 78, 'IonicSea_1463240740.jpg', 1463240740),
(125, 78, 'IonicSea1_1463240745.jpg', 1463240745),
(126, 78, 'IonicSea2_1463240752.jpg', 1463240752),
(127, 78, 'fly4_1463246980.jpg', 1463246980),
(128, 78, 'fly4_1463256563.jpg', 1463256563),
(129, 78, 'fly4_1463256585.jpg', 1463256585),
(130, 78, 'fly4_1463256603.jpg', 1463256603),
(131, 78, 'fly4_1463257317.jpg', 1463257317);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_ibfk_2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 121, NULL),
('admin', 125, 1463008219),
('client', 122, 1463005886),
('photographer', 123, 1463005915);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1460585115, 1460585115),
('client', 1, NULL, NULL, NULL, 1460995412, 1460995412),
('createAlbumClients', 2, 'Create an client album', NULL, NULL, 1460585102, 1460585102),
('createAlbums', 2, 'Create an album', NULL, NULL, 1460585102, 1460585102),
('createImages', 2, 'Create an image', NULL, NULL, 1460585102, 1460585102),
('createOwnImages', 2, 'Create an image in own allow album', 'isAuthor', NULL, 1460585102, 1460585102),
('createUsers', 2, 'Create an user', NULL, NULL, 1461801131, 1461801131),
('deleteAlbumClients', 2, 'Delete an client album', NULL, NULL, 1460585102, 1460585102),
('deleteAlbums', 2, 'Delete album', NULL, NULL, 1460585102, 1460585102),
('deleteAllowAlbumClients', 2, 'Index allowed album clients', 'isAllow', NULL, 1460995413, 1460995413),
('deleteImages', 2, 'Delete an image', NULL, NULL, 1460585102, 1460585102),
('deleteOwnImages', 2, 'Delete own images', 'isAuthor', NULL, 1460995413, 1460995413),
('deleteUsers', 2, 'Delete user', NULL, NULL, 1461801131, 1461801131),
('indexAlbumClients', 2, 'Index an client album', NULL, NULL, 1460585102, 1460585102),
('indexAlbums', 2, 'Index an album', NULL, NULL, 1460585102, 1460585102),
('indexAllowAlbumClients', 2, 'Index allowed album clients', 'isAllow', NULL, 1460995413, 1460995413),
('indexAllowAlbums', 2, 'Index allowed album', 'isAllow', NULL, 1460995413, 1460995413),
('indexAllowImages', 2, 'Index allow images', 'isAllow', NULL, 1461100347, 1461100347),
('indexImages', 2, 'Index images', NULL, NULL, 1461100347, 1461100347),
('indexOwnAlbums', 2, 'Index own album', 'isAuthor', NULL, 1460995413, 1460995413),
('indexOwnImages', 2, 'Index own images', 'isAuthor', NULL, 1460995413, 1460995413),
('indexOwnUsers', 2, 'Index own user', 'isOwner', NULL, 1461801131, 1461801131),
('indexUsers', 2, 'Index an user', NULL, NULL, 1461801131, 1461801131),
('photographer', 1, NULL, NULL, NULL, 1460585115, 1460585115),
('updateAlbumClients', 2, 'Update an client album', NULL, NULL, 1460585102, 1460585102),
('updateAlbums', 2, 'Update album', NULL, NULL, 1460585102, 1460585102),
('updateAllowAlbumClients', 2, 'Index allowed album clients', 'isAllow', NULL, 1460995413, 1460995413),
('updateImages', 2, 'Update image', NULL, NULL, 1460585102, 1460585102),
('updateOwnAlbums', 2, 'Update own album', 'isAuthor', NULL, 1460585130, 1460585130),
('updateOwnImages', 2, 'Update own images', 'isAuthor', NULL, 1460995413, 1460995413),
('updateOwnUsers', 2, 'Update own user', 'isOwner', NULL, 1461801131, 1461801131),
('updateUsers', 2, 'Update user', NULL, NULL, 1461801131, 1461801131),
('viewAlbumClients', 2, 'View an client album', NULL, NULL, 1460585102, 1460585102),
('viewAlbums', 2, 'View album', NULL, NULL, 1460585102, 1460585102),
('viewAllowAlbumClients', 2, 'Index allowed album clients', 'isAllow', NULL, 1460995413, 1460995413),
('viewAllowAlbums', 2, 'View allowed album', 'isAllow', NULL, 1460995413, 1460995413),
('viewAllowImages', 2, 'View allow images', 'isAllow', NULL, 1460995413, 1460995413),
('viewImages', 2, 'View images', NULL, NULL, 1460585102, 1460585102),
('viewOwnAlbums', 2, 'View own album', 'isAuthor', NULL, 1460633268, 1460633268),
('viewOwnImages', 2, 'View own images', 'isAuthor', NULL, 1460995413, 1460995413),
('viewOwnUsers', 2, 'View own user', 'isOwner', NULL, 1461801131, 1461801131),
('viewUsers', 2, 'View user', NULL, NULL, 1461801131, 1461801131);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'createAlbumClients'),
('photographer', 'createAlbumClients'),
('admin', 'createAlbums'),
('photographer', 'createAlbums'),
('admin', 'createImages'),
('createOwnImages', 'createImages'),
('photographer', 'createOwnImages'),
('admin', 'createUsers'),
('admin', 'deleteAlbumClients'),
('deleteAllowAlbumClients', 'deleteAlbumClients'),
('admin', 'deleteAlbums'),
('photographer', 'deleteAllowAlbumClients'),
('admin', 'deleteImages'),
('deleteOwnImages', 'deleteImages'),
('photographer', 'deleteOwnImages'),
('admin', 'deleteUsers'),
('admin', 'indexAlbumClients'),
('indexAllowAlbumClients', 'indexAlbumClients'),
('admin', 'indexAlbums'),
('indexAllowAlbums', 'indexAlbums'),
('indexOwnAlbums', 'indexAlbums'),
('photographer', 'indexAllowAlbumClients'),
('client', 'indexAllowAlbums'),
('client', 'indexAllowImages'),
('admin', 'indexImages'),
('indexAllowImages', 'indexImages'),
('indexOwnImages', 'indexImages'),
('photographer', 'indexOwnAlbums'),
('photographer', 'indexOwnImages'),
('client', 'indexOwnUsers'),
('photographer', 'indexOwnUsers'),
('admin', 'indexUsers'),
('indexOwnUsers', 'indexUsers'),
('admin', 'updateAlbumClients'),
('updateAllowAlbumClients', 'updateAlbumClients'),
('admin', 'updateAlbums'),
('updateOwnAlbums', 'updateAlbums'),
('photographer', 'updateAllowAlbumClients'),
('admin', 'updateImages'),
('updateOwnImages', 'updateImages'),
('photographer', 'updateOwnAlbums'),
('photographer', 'updateOwnImages'),
('client', 'updateOwnUsers'),
('photographer', 'updateOwnUsers'),
('admin', 'updateUsers'),
('updateOwnUsers', 'updateUsers'),
('admin', 'viewAlbumClients'),
('viewAllowAlbumClients', 'viewAlbumClients'),
('admin', 'viewAlbums'),
('viewAllowAlbums', 'viewAlbums'),
('viewOwnAlbums', 'viewAlbums'),
('photographer', 'viewAllowAlbumClients'),
('client', 'viewAllowAlbums'),
('client', 'viewAllowImages'),
('admin', 'viewImages'),
('viewAllowImages', 'viewImages'),
('viewOwnImages', 'viewImages'),
('photographer', 'viewOwnAlbums'),
('photographer', 'viewOwnImages'),
('client', 'viewOwnUsers'),
('photographer', 'viewOwnUsers'),
('admin', 'viewUsers'),
('viewOwnUsers', 'viewUsers');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAllow', 'O:30:"app\\controllers\\auth\\AllowRule":3:{s:4:"name";s:7:"isAllow";s:9:"createdAt";i:1460995412;s:9:"updatedAt";i:1460995412;}', 1460995412, 1460995412),
('isAuthor', 'O:31:"app\\controllers\\auth\\AuthorRule":3:{s:4:"name";s:8:"isAuthor";s:9:"createdAt";i:1460585130;s:9:"updatedAt";i:1460585130;}', 1460585130, 1460585130),
('isOwner', 'O:30:"app\\controllers\\auth\\OwnerRule":3:{s:4:"name";s:7:"isOwner";s:9:"createdAt";i:1462201101;s:9:"updatedAt";i:1462201101;}', 1462201101, 1462201101);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1460360729),
('m140506_102106_rbac_init', 1460360732);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `status` enum('new','in progress','reject','done') NOT NULL DEFAULT 'new',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order_images`
--

CREATE TABLE IF NOT EXISTS `order_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  `type` enum('print','digital') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order` (`order_id`,`image_id`) USING BTREE,
  KEY `order/images_ibfk_2` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `packages`
--

CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` smallint(5) unsigned NOT NULL,
  `limitation` smallint(5) unsigned NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `reset_pass`
--

CREATE TABLE IF NOT EXISTS `reset_pass` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(25) NOT NULL,
  `created_at` int(11) NOT NULL,
  `valid_at` int(11) DEFAULT NULL,
  `used` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `reset_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Дамп данных таблицы `reset_pass`
--

INSERT INTO `reset_pass` (`id`, `email`, `created_at`, `valid_at`, `used`, `user_id`, `reset_code`) VALUES
(72, 'travers.nk@gmail.com', 1463005395, 1463008995, 1, 121, 'fQPP7Aon7TiDsdS3RQodypm6WiJ0Dllk'),
(73, 'travers.nk@gmail.com', 1463005559, 1463009159, 1, 121, 'bOXOzKWeMWYT3DaPas7Uz-Sl8xCuLsk9'),
(74, 'photo@gmail.com', 1463006087, 1463009687, 0, 123, '25Ql99p_oYHs18MiU9jOiOc10qFLxe0W'),
(75, 'travers.nk@gmail.com', 1463007651, 1463011251, 1, 121, '4e7OHTLFXWeIwP6WSF8jjoac5EJpWpci'),
(76, 'travers.nk@gmail.com', 1463007992, 1463011592, 1, 121, 'DVGwdpXy9qHOym7HtfY5J6BW7W4JwvP2'),
(77, 'travers.nk@gmail.com', 1463008025, 1463011625, 1, 121, '6m-uF1Rni7ulsiE9frfTFs9bd1STxtka'),
(78, 'travers.nk@gmail.com', 1463008062, 1463011662, 1, 121, '3_M5YECzT9L1t3LWaJ4NNbSI1UIcXF8r'),
(79, 'travers.nk@gmail.com', 1463013873, 1463017473, 1, 121, 'hXOjISd2xA9w6dLXtFdPizu59sisvizB'),
(80, 'travers.nk@gmail.com', 1463014082, 1463017682, 1, 121, 'WFggjcr8NerXIe9WVMfQF8iatPH5pAIa'),
(81, 'travers.nk@gmail.com', 1463016467, 1463020067, 1, 121, 'ipN7D4xOZ5awPW0NXfIqXlQWIj9lJSy0'),
(82, 'travers.nk@gmail.com', 1463017996, 1463021596, 1, 121, '02XIKcRLZBRklI3vJdViK47kbkBQxq8E'),
(83, 'travers.nk@gmail.com', 1463035809, 1463039409, 1, 121, 'uiDzzooei52dUrzhyOvD7Ts9b5wxeMIu'),
(84, 'travers.nk@gmail.com', 1463141306, 1463144906, 1, 121, 'vuj9qywy5mL1Qxr-sMfzChgtCiYWs-X_'),
(85, 'travers.nk@gmail.com', 1463142899, 1463146499, 1, 121, 'iped2dWNgLG2HXxK2-XZ4Kc9jNBrdWOo'),
(86, 'travers.nk@gmail.com', 1463142938, 1463146538, 1, 121, 'jhuSXBykQ2NvH7SX66A0bLkelZo71Ntg'),
(87, 'travers.nk@gmail.com', 1463148061, 1463151661, 1, 121, '0FQl5kzvycKIQWZtoGJ7nVLd4tWvH6Pe'),
(88, 'travers.nk@gmail.com', 1463229686, 1463233286, 1, 121, 'xV7lfs9vit4R0P93ZmmeWCcek7Dltifn');

-- --------------------------------------------------------

--
-- Структура таблицы `resized_photos`
--

CREATE TABLE IF NOT EXISTS `resized_photos` (
  `status` enum('new','in progress','complete','error') NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(50) DEFAULT NULL,
  `origin` varchar(50) DEFAULT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`),
  KEY `image_id_2` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=263 ;

--
-- Дамп данных таблицы `resized_photos`
--

INSERT INTO `resized_photos` (`status`, `image_id`, `id`, `size`, `origin`, `comment`) VALUES
('complete', 121, 241, '100', 'fly1_1463240722.jpg', NULL),
('complete', 121, 242, '400', 'fly1_1463240722.jpg', NULL),
('complete', 122, 243, '100', 'fly2_1463240728.jpg', NULL),
('complete', 122, 244, '400', 'fly2_1463240728.jpg', NULL),
('complete', 123, 245, '100', 'fly3_1463240734.jpg', NULL),
('complete', 123, 246, '400', 'fly3_1463240734.jpg', NULL),
('complete', 124, 247, '100', 'IonicSea_1463240740.jpg', NULL),
('complete', 124, 248, '400', 'IonicSea_1463240740.jpg', NULL),
('complete', 125, 249, '100', 'IonicSea1_1463240745.jpg', NULL),
('complete', 125, 250, '400', 'IonicSea1_1463240745.jpg', NULL),
('complete', 126, 251, '100', 'IonicSea2_1463240752.jpg', NULL),
('complete', 126, 252, '400', 'IonicSea2_1463240752.jpg', NULL),
('complete', 127, 253, '100', 'fly4_1463246980.jpg', NULL),
('complete', 127, 254, '400', 'fly4_1463246980.jpg', NULL),
('new', 128, 255, NULL, NULL, NULL),
('new', 128, 256, NULL, NULL, NULL),
('new', 129, 257, NULL, NULL, NULL),
('new', 129, 258, NULL, NULL, NULL),
('new', 130, 259, NULL, NULL, NULL),
('new', 130, 260, NULL, NULL, NULL),
('new', 131, 261, NULL, NULL, NULL),
('new', 131, 262, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(100) DEFAULT NULL,
  `role` enum('client','photographer','admin') NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `modified_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=126 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `access_token`, `role`, `name`, `email`, `password`, `phone`, `modified_at`, `created_at`) VALUES
(121, '', 'admin', 'nata', 'travers.nk@gmail.com', '$2y$13$q8.crMowJbUouEFAAPvqduufw2GcGFykqP5uaNxFLGhG7Tt1M1GuS', '0000000', 1463257814, 1461100347),
(122, 'kKdzaUE10lMa13EqgC1uRGgNYmeuQJt2', 'client', 'client', 'client3@gmail.com', '$2y$13$d81Fsc2fdfCQFH/kroUsQOHaUkq5VNWDC50pPS.a2pLMgcTJBc1rq', '000-000-00-00', 1463324956, 1463005884),
(123, '3fEwuRzczeguZNny4T9Z2LG_1feu0S-A', 'photographer', 'photo', 'photo23@gmail.com', '$2y$13$ENFcZZHqoZE26oxsG57P6e0Y9Sqz3BMiTB0ShUWqvk0HV/8pI7j5m', '000-000-00-00', 1463263234, 1463005913),
(125, '8LXKDTVIf2URBBtyMW-Cl597nvCVW1q0', 'admin', 'admin', 'admin@gmail.com', '$2y$13$iX9wuFwQzPyEclNUN2/oqeFQuV9phlmHKKao/7OoZ1f5UEdB2dMQm', NULL, 1463013573, 1463008217);

-- --------------------------------------------------------

--
-- Структура таблицы `user_packages`
--

CREATE TABLE IF NOT EXISTS `user_packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `package` (`package_id`) USING BTREE,
  KEY `user` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `album_clients`
--
ALTER TABLE `album_clients`
  ADD CONSTRAINT `album_clients_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `album_clients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `album_images`
--
ALTER TABLE `album_images`
  ADD CONSTRAINT `album_images_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_images`
--
ALTER TABLE `order_images`
  ADD CONSTRAINT `order_images_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `album_images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reset_pass`
--
ALTER TABLE `reset_pass`
  ADD CONSTRAINT `resetpass_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `resized_photos`
--
ALTER TABLE `resized_photos`
  ADD CONSTRAINT `image_resized_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `album_images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_packages`
--
ALTER TABLE `user_packages`
  ADD CONSTRAINT `user_packages_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_packages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
