-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2017 at 01:55 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.1.9

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
  `categoryId` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `seo` varchar(255) NOT NULL,
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rgt` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `blogCategory`
--

TRUNCATE TABLE `blogCategory`;
-- --------------------------------------------------------

--
-- Table structure for table `blogComment`
--

DROP TABLE IF EXISTS `blogComment`;
CREATE TABLE `blogComment` (
  `commentId` int(11) UNSIGNED NOT NULL,
  `postId` int(11) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `author` varchar(128) NOT NULL,
  `authorIp` varchar(15) NOT NULL,
  `url` varchar(255) NOT NULL,
  `email` varchar(500) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `appoved` tinyint(1) UNSIGNED NOT NULL,
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rgt` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `blogComment`
--

TRUNCATE TABLE `blogComment`;
-- --------------------------------------------------------

--
-- Table structure for table `blogPost`
--

DROP TABLE IF EXISTS `blogPost`;
CREATE TABLE `blogPost` (
  `postId` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `categoryId` int(10) UNSIGNED DEFAULT NULL,
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
  `dateModified` datetime NOT NULL,
  `status` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `blogPost`
--

TRUNCATE TABLE `blogPost`;
-- --------------------------------------------------------

--
-- Table structure for table `blogPostTag`
--

DROP TABLE IF EXISTS `blogPostTag`;
CREATE TABLE `blogPostTag` (
  `postTagId` int(11) UNSIGNED NOT NULL,
  `postId` int(11) UNSIGNED NOT NULL,
  `tagId` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `blogPostTag`
--

TRUNCATE TABLE `blogPostTag`;
-- --------------------------------------------------------

--
-- Table structure for table `blogTag`
--

DROP TABLE IF EXISTS `blogTag`;
CREATE TABLE `blogTag` (
  `tagId` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `seo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `blogTag`
--

TRUNCATE TABLE `blogTag`;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogCategory`
--
ALTER TABLE `blogCategory`
  ADD PRIMARY KEY (`categoryId`),
  ADD UNIQUE KEY `seo` (`seo`);

--
-- Indexes for table `blogComment`
--
ALTER TABLE `blogComment`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `blogPost`
--
ALTER TABLE `blogPost`
  ADD PRIMARY KEY (`postId`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `userId` (`userId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `blogPostTag`
--
ALTER TABLE `blogPostTag`
  ADD PRIMARY KEY (`postTagId`),
  ADD KEY `postId` (`postId`),
  ADD KEY `tagId` (`tagId`);

--
-- Indexes for table `blogTag`
--
ALTER TABLE `blogTag`
  ADD PRIMARY KEY (`tagId`),
  ADD UNIQUE KEY `seo` (`seo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogCategory`
--
ALTER TABLE `blogCategory`
  MODIFY `categoryId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `blogComment`
--
ALTER TABLE `blogComment`
  MODIFY `commentId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blogPost`
--
ALTER TABLE `blogPost`
  MODIFY `postId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `blogPostTag`
--
ALTER TABLE `blogPostTag`
  MODIFY `postTagId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `blogTag`
--
ALTER TABLE `blogTag`
  MODIFY `tagId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogComment`
--
ALTER TABLE `blogComment`
  ADD CONSTRAINT `blogComment_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `blogPost` (`postId`);

--
-- Constraints for table `blogPost`
--
ALTER TABLE `blogPost`
  ADD CONSTRAINT `blogPost_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`),
  ADD CONSTRAINT `blogPost_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `blogCategory` (`categoryId`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `blogPostTag`
--
ALTER TABLE `blogPostTag`
  ADD CONSTRAINT `blogPostTag_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `blogPost` (`postId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blogPostTag_ibfk_2` FOREIGN KEY (`tagId`) REFERENCES `blogTag` (`tagId`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
