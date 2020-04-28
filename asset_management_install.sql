-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2020 at 08:20 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asset_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `am_asset`
--

CREATE TABLE `am_asset` (
  `asset_id` varchar(36) NOT NULL,
  `a_name` varchar(40) NOT NULL,
  `a_desc` varchar(1000) NOT NULL,
  `code` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT NULL COMMENT 'active, broken, disabled, etc.',
  `purchase_date` date NOT NULL,
  `purchase_price` decimal(10,0) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `qty` int(11) NOT NULL,
  `a_type` varchar(40) NOT NULL COMMENT 'Asset Type (software, hardware)',
  `serial_num` varchar(100) NOT NULL,
  `owning_company_id` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_asset`
--

INSERT INTO `am_asset` (`asset_id`, `a_name`, `a_desc`, `code`, `status`, `purchase_date`, `purchase_price`, `create_date`, `modify_date`, `qty`, `a_type`, `serial_num`, `owning_company_id`) VALUES
('00422f06-80c4-11ea-87ef-309c23644c79', 'test', 'tesa', '', 'unavailable', '0000-00-00', '0', '2020-03-01 16:56:29', '2020-04-17 21:11:55', 0, 'hardware', '', '694ce3ad-7f51-11ea-8cae-309c23644c79'),
('10cab2da-80d1-11ea-87ef-309c23644c79', 'test', 'tase', '', 'active', '0000-00-00', '0', '2020-04-17 17:30:00', '2020-04-17 17:30:00', 0, 'hardware', '', '694ce3ad-7f51-11ea-8cae-309c23644c79'),
('236c261f-80c2-11ea-87ef-309c23644c79', 'adobe', 'ast', '150', 'active', '2020-05-05', '150', '2020-04-17 15:43:09', '2020-04-17 15:43:09', 2, 'software', '156-1563', '694ce3ad-7f51-11ea-8cae-309c23644c79'),
('a85ee352-80d0-11ea-87ef-309c23644c79', 'test', 'taes', '', 'broken', '0000-00-00', '0', '2020-04-17 17:27:05', '2020-04-17 17:27:05', 0, 'software', '', '694ce3ad-7f51-11ea-8cae-309c23644c79'),
('b05c87bd-80d0-11ea-87ef-309c23644c79', 'Newffji', 'gfaoki', '150', 'active', '0000-00-00', '0', '2020-04-17 17:27:18', '2020-04-17 17:27:18', 0, 'software', '', '694ce3ad-7f51-11ea-8cae-309c23644c79');

-- --------------------------------------------------------

--
-- Table structure for table `am_assets_managed_by`
--

CREATE TABLE `am_assets_managed_by` (
  `asset_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_assets_managed_by`
--

INSERT INTO `am_assets_managed_by` (`asset_id`, `user_id`) VALUES
('00422f06-80c4-11ea-87ef-309c23644c79', '4a9ea2e1-7ff0-11ea-8cee-309c23644c79');

-- --------------------------------------------------------

--
-- Table structure for table `am_asset_location`
--

CREATE TABLE `am_asset_location` (
  `asset_id` varchar(36) NOT NULL,
  `location_id` varchar(36) NOT NULL,
  `location_desc` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_asset_location`
--

INSERT INTO `am_asset_location` (`asset_id`, `location_id`, `location_desc`) VALUES
('00422f06-80c4-11ea-87ef-309c23644c79', 'a4628e4b-80ce-11ea-87ef-309c23644c79', 'This is a very long locational description of where this asset can be located.\nThis is a very long locational description of where this asset can be located.This is a very long locational description of where this asset can be located.This is a very long locational description of where this asset can be located.This is a very long locational description of where this asset can be located.This is a very long locational description of where this asset can be located.This is a very long locational description of where this asset can be located.This is a very long locational description of where this asset can be located.');

-- --------------------------------------------------------

--
-- Table structure for table `am_company`
--

CREATE TABLE `am_company` (
  `company_id` varchar(36) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_desc` varchar(1000) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_company`
--

INSERT INTO `am_company` (`company_id`, `company_name`, `company_desc`, `create_date`, `modify_date`) VALUES
('694ce3ad-7f51-11ea-8cae-309c23644c79', 'walmart', 'test', '2020-04-16 12:57:28', '2020-04-16 13:28:16'),
('beb3faad-7fe7-11ea-8cee-309c23644c79', 'XYZ Company', 'This is the XYZ company ', '2020-04-16 13:39:50', '2020-04-16 13:39:50'),
('d3375c67-7f4f-11ea-8cae-309c23644c79', 'Test', 'test123', '2020-04-16 12:57:28', '2020-04-16 12:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `am_company_employs`
--

CREATE TABLE `am_company_employs` (
  `company_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_company_employs`
--

INSERT INTO `am_company_employs` (`company_id`, `user_id`) VALUES
('694ce3ad-7f51-11ea-8cae-309c23644c79', '4a9ea2e1-7ff0-11ea-8cee-309c23644c79'),
('694ce3ad-7f51-11ea-8cae-309c23644c79', '83cee67c-80f0-11ea-87ef-309c23644c79');

-- --------------------------------------------------------

--
-- Table structure for table `am_user`
--

CREATE TABLE `am_user` (
  `user_id` varchar(36) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(36) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_user`
--

INSERT INTO `am_user` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `dob`, `create_date`, `modify_date`) VALUES
('4a9ea2e1-7ff0-11ea-8cee-309c23644c79', 'test234', 'tewta', 'tewa', '', '0000-00-00', '2020-04-16 14:41:00', '2020-04-16 14:41:00'),
('75879e08-7f31-11ea-8cae-309c23644c79', 'Nathaniel', 'Zimmer', 'Nathaniel.zimmer@okstate.edu', '9187984323', '2000-05-05', '2020-04-15 15:54:56', '2020-04-15 15:54:56'),
('83cee67c-80f0-11ea-87ef-309c23644c79', 'John', 'Low', 'j.low@okstate.edu', '918-777-7575', '2020-05-05', '2020-04-17 21:15:07', '2020-04-17 21:15:07');

-- --------------------------------------------------------

--
-- Table structure for table `am_user_cred`
--

CREATE TABLE `am_user_cred` (
  `user_id` varchar(36) NOT NULL,
  `user_cred_id` varchar(36) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `am_user_cred`
--

INSERT INTO `am_user_cred` (`user_id`, `user_cred_id`, `username`, `password`, `create_date`, `modify_date`) VALUES
('75879e08-7f31-11ea-8cae-309c23644c79', '7587ed9f-7f31-11ea-8cae-309c23644c79', 'nzimmer', 'test', '2020-04-15 15:54:56', '2020-04-15 15:54:56'),
('83cee67c-80f0-11ea-87ef-309c23644c79', '83cf2ffc-80f0-11ea-87ef-309c23644c79', 'j.low@okstate.edu', 'test', '2020-04-17 21:15:07', '2020-04-17 21:15:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `am_asset`
--
ALTER TABLE `am_asset`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `FK_Company_H` (`owning_company_id`);

--
-- Indexes for table `am_assets_managed_by`
--
ALTER TABLE `am_assets_managed_by`
  ADD PRIMARY KEY (`asset_id`,`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `am_asset_location`
--
ALTER TABLE `am_asset_location`
  ADD PRIMARY KEY (`asset_id`,`location_id`),
  ADD UNIQUE KEY `location_id` (`location_id`);

--
-- Indexes for table `am_company`
--
ALTER TABLE `am_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `am_company_employs`
--
ALTER TABLE `am_company_employs`
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `am_user`
--
ALTER TABLE `am_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `am_user_cred`
--
ALTER TABLE `am_user_cred`
  ADD PRIMARY KEY (`user_id`,`user_cred_id`),
  ADD UNIQUE KEY `user_cred_id` (`user_cred_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `am_asset`
--
ALTER TABLE `am_asset`
  ADD CONSTRAINT `FK_Company_H` FOREIGN KEY (`owning_company_id`) REFERENCES `am_company` (`company_id`);

--
-- Constraints for table `am_assets_managed_by`
--
ALTER TABLE `am_assets_managed_by`
  ADD CONSTRAINT `FK_Assets_MG` FOREIGN KEY (`asset_id`) REFERENCES `am_asset` (`asset_id`);

--
-- Constraints for table `am_asset_location`
--
ALTER TABLE `am_asset_location`
  ADD CONSTRAINT `FK_asset_l` FOREIGN KEY (`asset_id`) REFERENCES `am_asset` (`asset_id`);

--
-- Constraints for table `am_company_employs`
--
ALTER TABLE `am_company_employs`
  ADD CONSTRAINT `am_company_employs_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `am_company` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `am_company_employs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `am_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `am_user_cred`
--
ALTER TABLE `am_user_cred`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`user_id`) REFERENCES `am_user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
