-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 06 2015 г., 16:38
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `tmp_defects`
--

-- --------------------------------------------------------

--
-- Структура таблицы `def_defects`
--

CREATE TABLE IF NOT EXISTS `def_defects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `def_date` date NOT NULL,
  `department_id` int(11) unsigned NOT NULL,
  `equip_name_id` int(11) unsigned NOT NULL,
  `equip_type_id` int(11) unsigned NOT NULL,
  `equip_object_id` int(11) unsigned NOT NULL,
  `def_count` int(11) unsigned NOT NULL,
  `unit_id` int(11) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `correct_measures` varchar(255) NOT NULL,
  `ins_user_id` int(11) unsigned NOT NULL,
  `ins_date` int(11) unsigned NOT NULL,
  `del_user_id` int(11) unsigned NOT NULL,
  `del_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `def_defects`
--

INSERT INTO `def_defects` (`id`, `def_date`, `department_id`, `equip_name_id`, `equip_type_id`, `equip_object_id`, `def_count`, `unit_id`, `description`, `correct_measures`, `ins_user_id`, `ins_date`, `del_user_id`, `del_date`) VALUES
(1, '0000-00-00', 1, 2, 3, 4, 5, 6, '7', '8', 9, 1446805972, 0, 0),
(2, '2015-11-06', 1, 2, 3, 4, 5, 6, '7', '8', 9, 1446805995, 0, 0),
(3, '2015-11-06', 1, 2, 3, 4, 5, 6, '7', '8', 9, 1446806030, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `def_departments`
--

CREATE TABLE IF NOT EXISTS `def_departments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `def_equipment_names`
--

CREATE TABLE IF NOT EXISTS `def_equipment_names` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `def_equipment_objects`
--

CREATE TABLE IF NOT EXISTS `def_equipment_objects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `def_equipment_types`
--

CREATE TABLE IF NOT EXISTS `def_equipment_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `def_units`
--

CREATE TABLE IF NOT EXISTS `def_units` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `def_units`
--

INSERT INTO `def_units` (`id`, `name`) VALUES
(1, 'шт.');

-- --------------------------------------------------------

--
-- Структура таблицы `def_users`
--

CREATE TABLE IF NOT EXISTS `def_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `group_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `def_users`
--

INSERT INTO `def_users` (`id`, `login`, `password`, `group_id`) VALUES
(1, 'admin', '391e893e26ff1fe8a6f376c6611e657b', 1),
(2, 'Харламов И.П.', '391e893e26ff1fe8a6f376c6611e657b', 1),
(3, 'user', '6b997a2c86ca038645f9d6e664c19802', 1),
(4, 'user1', '6b997a2c86ca038645f9d6e664c19802', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `def_user_groups`
--

CREATE TABLE IF NOT EXISTS `def_user_groups` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `def_user_groups`
--

INSERT INTO `def_user_groups` (`id`, `name`, `description`) VALUES
(1, 'Администратор', 'Администраторы имеют полные, ничем неограниченные права при работе.'),
(2, 'Пользователь', 'Пользователи имеют ограниченные права.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
