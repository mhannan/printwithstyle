-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2012 at 10:39 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `brand`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_section`
--

CREATE TABLE IF NOT EXISTS `blog_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(550) NOT NULL,
  `description` text NOT NULL,
  `summary` text NOT NULL,
  `currentDate` date NOT NULL,
  `image` varchar(550) NOT NULL,
  `addedByAdminId` int(11) NOT NULL,
  `last_modified` date NOT NULL,
  `lastModifiedByAdminId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `blog_section`
--

INSERT INTO `blog_section` (`id`, `title`, `description`, `summary`, `currentDate`, `image`, `addedByAdminId`, `last_modified`, `lastModifiedByAdminId`) VALUES
(2, 'Article Post', '<p>\r\n	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to.</p>\r\n', '', '2012-05-04', 'Tulips_ff2e3edfaf65ee3a7738a3690b79eb64.jpg', 1, '2012-05-04', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
