-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 18, 2020 at 07:14 PM
-- Server version: 5.7.19
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simpleadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

DROP TABLE IF EXISTS `auth_logins`;
CREATE TABLE IF NOT EXISTS `auth_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `successfull` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedvalidator` varchar(255) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(250) NOT NULL,
  `reset_expire` datetime DEFAULT NULL,
  `activated` tinyint(1) NOT NULL,
  `activate_token` varchar(250) DEFAULT NULL,
  `activate_expire` varchar(250) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `avatar` varchar(250) NOT NULL,
  `about` varchar(250) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `status` varchar(250) NOT NULL,
  `my_blog` int(11) NOT NULL,
  `post_profile` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
 
-- --------------------------------------------------------

--
-- Table structure for table `posts`
-- 

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_title` varchar(250) NOT NULL,
  `post_slug` varchar(128) NOT NULL,
  `post_cat_id` varchar(128) DEFAULT NULL,
  `post_blog_id` int(11) DEFAULT NULL,
  `post_src` enum('web','api','mobile','phone') NOT NULL DEFAULT 'web',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_user_id` int(11) unsigned NOT NULL,
  `post_visible` enum('all','friends') NOT NULL DEFAULT 'all',
  `post_ip_int` decimal(39,0) DEFAULT NULL,
  `post_votes` smallint(4) NOT NULL DEFAULT '0',
  `post_karma` smallint(6) NOT NULL DEFAULT '0', 
  `post_comments` smallint(6) NOT NULL DEFAULT '0',
  `post_content` text NOT NULL,
  `post_top` tinyint(1) NOT NULL DEFAULT 0,
  `post_is_delete` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`post_id`),
  KEY `post_date` (`post_date`),
  KEY `post_user_id` (`post_user_id`,`post_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `favorites`
-- 

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `favorite_user_id` int(10) unsigned NOT NULL,
  `favorite_type` enum('link','post','comment') NOT NULL DEFAULT 'post',
  `favorite_link_id` int(10) unsigned NOT NULL,
  `favorite_link_readed` int(1) unsigned NOT NULL DEFAULT 0,
  `favorite_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `favorite_user_id_2` (`favorite_user_id`,`favorite_type`,`favorite_link_id`),
  KEY `favorite_type` (`favorite_type`,`favorite_link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
-- 

CREATE TABLE `comments` (
  `comment_id` int(20) NOT NULL,
  `comment_type` enum('normal','admin','private') NOT NULL DEFAULT 'normal',
  `comment_post_id` int(20) NOT NULL DEFAULT 0,
  `comment_user_id` int(20) NOT NULL DEFAULT 0,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment_modified` timestamp NOT NULL DEFAULT '2020-12-31 18:00:00',
  `comment_ip` varbinary(42) DEFAULT NULL,
  `comment_order` smallint(6) NOT NULL DEFAULT 0,
  `comment_on` smallint(6) NOT NULL DEFAULT 0,
  `comment_after` smallint(6) NOT NULL DEFAULT 0,
  `comment_votes` smallint(4) NOT NULL DEFAULT 0,
  `comment_content` text NOT NULL,
  `comment_del` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_link_id_2` (`comment_post_id`,`comment_date`),
  ADD KEY `comment_date` (`comment_date`),
  ADD KEY `comment_user_id` (`comment_user_id`,`comment_date`),
  ADD KEY `comment_post_id` (`comment_post_id`,`comment_order`);

ALTER TABLE `comments`
  MODIFY `comment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;