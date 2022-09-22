-- Adminer 4.8.1 MySQL 5.7.33 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `treatment_id` int(11) NOT NULL,
  `therapist_id` int(11) DEFAULT NULL,
  `station_id` int(11) DEFAULT NULL,
  `notes` text,
  `date` date DEFAULT NULL,
  `start_hour` int(11) DEFAULT NULL,
  `start_min` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cell` varchar(16) NOT NULL,
  `birthday` date DEFAULT NULL,
  `address` text,
  `notes` text,
  `last_treatment_id` int(11) DEFAULT NULL,
  `last_therapist_id` int(11) DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  `last_duration` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `stations`;
CREATE TABLE `stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `def_therapist_id` int(11) DEFAULT NULL,
  `colour` varchar(20) NOT NULL,
  `notes` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `therapists`;
CREATE TABLE `therapists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cell` varchar(16) NOT NULL,
  `birthday` date DEFAULT NULL,
  `std_rate` decimal(8,2) DEFAULT NULL,
  `address` text,
  `notes` text,
  `station_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `treatments`;
CREATE TABLE `treatments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_desc` varchar(255) NOT NULL,
  `long_desc` text,
  `def_station_id` int(11) DEFAULT NULL,
  `def_duration` int(11) DEFAULT NULL,
  `def_price` decimal(8,2) DEFAULT NULL,
  `def_unit` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `open_hours` varchar(255) NOT NULL DEFAULT '07,08,09,10,11,12,13,14,15,16,17,18,19',
  `slots_per_hour` varchar(255) NOT NULL DEFAULT '00,15,30,45',
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`open_hours`, `slots_per_hour`, `updated_at`, `updated_by`) VALUES
('07,08,09,10,11,12,13,14,15,16,17,18,19',  '00,15,30,45',  NULL, NULL);


-- 2022-07-21 18:07:53
