-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2017 at 11:18 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.1.8RC1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `uthando-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogCategory`
--

DROP TABLE IF EXISTS `blogCategory`;
CREATE TABLE `blogCategory` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rgt` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogComment`
--

DROP TABLE IF EXISTS `blogComment`;
CREATE TABLE `blogComment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(128) NOT NULL,
  `url` varchar(255) NOT NULL,
  `email` varchar(500) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rgt` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogPost`
--

DROP TABLE IF EXISTS `blogPost`;
CREATE TABLE `blogPost` (
  `postId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `categoryId` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text,
  `layout` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lead` tinytext,
  `hits` int(10) UNSIGNED NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogPostTag`
--

DROP TABLE IF EXISTS `blogPostTag`;
CREATE TABLE `blogPostTag` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogTag`
--

DROP TABLE IF EXISTS `blogTag`;
CREATE TABLE `blogTag` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogCategory`
--
ALTER TABLE `blogCategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogComment`
--
ALTER TABLE `blogComment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogPost`
--
ALTER TABLE `blogPost`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `blogPostTag`
--
ALTER TABLE `blogPostTag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogTag`
--
ALTER TABLE `blogTag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogCategory`
--
ALTER TABLE `blogCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blogComment`
--
ALTER TABLE `blogComment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blogPost`
--
ALTER TABLE `blogPost`
  MODIFY `postId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blogPostTag`
--
ALTER TABLE `blogPostTag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blogTag`
--
ALTER TABLE `blogTag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;SET FOREIGN_KEY_CHECKS=1;
COMMIT;
