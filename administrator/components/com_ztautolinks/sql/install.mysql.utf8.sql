-- phpMyAdmin SQL Dump
-- version 4.2.0-beta1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2014 at 09:59 AM
-- Server version: 5.6.16-log
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `zo2_joomla33`
--

-- --------------------------------------------------------

--
-- Table structure for table `#__ztautolinks`
--

CREATE TABLE IF NOT EXISTS `#__ztautolinks` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(1) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `limits` int(11) NOT NULL,
  `occurrence` tinyint(4) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `count` int(11) NOT NULL,
  `params` text NOT NULL,
   PRIMARY KEY (`id`), 
   UNIQUE KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

