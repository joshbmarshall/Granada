SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `car`;
CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `name` varchar(190) NOT NULL,
  `manufactor_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT 1,
  `stealth` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manufactor_id` (`manufactor_id`),
  KEY `owner_id` (`owner_id`),
  KEY `enabled` (`enabled`),
  KEY `is_deleted` (`is_deleted`),
  CONSTRAINT `car_ibfk_1` FOREIGN KEY (`manufactor_id`) REFERENCES `manufactor` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `car_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `car` (`id`, `name`, `manufactor_id`, `owner_id`, `enabled`, `stealth`, `is_deleted`, `sort_order`, `created_at`, `updated_at`) VALUES
(1,	'Car1',	1,	1,	1,	0,	0,	1, NULL,	NULL),
(2,	'Car2',	1,	2,	1,	0,	0,	2, NULL,	NULL),
(3,	'Car3',	2,	3,	1,	0,	0,	3, NULL,	NULL),
(4,	'Car4',	2,	4,	1,	0,	0,	5, NULL,	NULL),
(5,	'Car5',	2,	4,	1,	0,	1,	6, NULL,	NULL),
(6,	'Car6',	2,	4,	0,	0,	0,	4, NULL,	NULL);

DROP TABLE IF EXISTS `car_part`;
CREATE TABLE `car_part` (
  `id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  KEY `part_id` (`part_id`),
  CONSTRAINT `car_part_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`) ON DELETE CASCADE,
  CONSTRAINT `car_part_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `part` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `car_part` (`id`, `car_id`, `part_id`) VALUES
(1,	1,	1),
(2,	2,	1),
(3,	3,	1),
(4,	4,	1),
(5,	1,	2),
(6,	2,	3),
(7,	3,	4),
(8,	4,	5),
(9,	1,	1);

DROP TABLE IF EXISTS `manufactor`;
CREATE TABLE `manufactor` (
  `id` int(11) NOT NULL,
  `name` varchar(190) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `manufactor` (`id`, `name`) VALUES
(1,	'Manufactor1'),
(2,	'Manufactor2');

DROP TABLE IF EXISTS `owner`;
CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `name` varchar(190) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `owner` (`id`, `name`) VALUES
(1,	'Owner1'),
(2,	'Owner2'),
(3,	'Owner3'),
(4,	'Owner4');

DROP TABLE IF EXISTS `part`;
CREATE TABLE `part` (
  `id` int(11) NOT NULL,
  `name` varchar(190) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `part` (`id`, `name`) VALUES
(1,	'Part1'),
(2,	'Part2'),
(3,	'Part3'),
(4,	'Part4'),
(5,	'Part5');

DROP TABLE IF EXISTS `timezone_test`;
CREATE TABLE `timezone_test` (
  `id` int(11) NOT NULL,
  `datetime1` datetime DEFAULT NULL COMMENT "",
  `datetime2` datetime DEFAULT NULL COMMENT "_timezone_none",
  `datetime3` datetime DEFAULT NULL COMMENT "_timezone_sitewide",
  `datetime4` datetime DEFAULT NULL COMMENT "_timezone_compare_user",
  `datetime5` datetime DEFAULT NULL COMMENT "_timezone_compare_sitewide",
  `date1` date DEFAULT NULL,
  `time1` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `timezone_test` (`id`, `datetime1`, `datetime2`, `datetime3`, `datetime4`, `datetime5`, `date1`, `time1`) VALUES
(1, '2020-08-11 21:47:18', '2020-08-11 21:47:18', '2020-08-11 21:47:18', '2020-08-11 21:47:18', '2020-08-11 21:47:18', '2020-08-11', '21:47:18');