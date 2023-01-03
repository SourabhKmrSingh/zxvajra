-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 20, 2020 at 12:27 PM
-- Server version: 8.0.21
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grocerymaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `mlm_challenges`
--

CREATE TABLE `mlm_challenges` (
  `challengeid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `planid` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `time_period` int DEFAULT '0',
  `members` int DEFAULT '0',
  `reward` text CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_challenges_history`
--

CREATE TABLE `mlm_challenges_history` (
  `historyid` int NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `challengeid` int DEFAULT '0',
  `membership_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `refno` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `time_period` int DEFAULT '0',
  `members` int DEFAULT '0',
  `reward` text CHARACTER SET utf8 COLLATE utf8_bin,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(20) DEFAULT 'pending',
  `user_ip` longtext,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_config`
--

CREATE TABLE `mlm_config` (
  `configid` int NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `cms_title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `cms_url` text CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `site_url` text CHARACTER SET utf8 COLLATE utf8_bin,
  `site_url_extension` text CHARACTER SET utf8 COLLATE utf8_bin,
  `site_url_web` text CHARACTER SET utf8 COLLATE utf8_bin,
  `script` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `style` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `logo` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `favicon` text CHARACTER SET utf8 COLLATE utf8_bin,
  `timezone` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date_format` text CHARACTER SET utf8 COLLATE utf8_bin,
  `time_format` text CHARACTER SET utf8 COLLATE utf8_bin,
  `records_perpage` int DEFAULT '50',
  `google_indexing` int DEFAULT '0',
  `referral_amount` decimal(65,2) DEFAULT '0.00',
  `mail_server` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_port` int DEFAULT '0',
  `mail_encryption` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_password` text CHARACTER SET utf8 COLLATE utf8_bin,
  `thumb_width` int DEFAULT '0',
  `thumb_height` int DEFAULT '0',
  `thumb_ratio` text CHARACTER SET utf8 COLLATE utf8_bin,
  `large_width` int DEFAULT '0',
  `large_height` int DEFAULT '0',
  `large_ratio` text CHARACTER SET utf8 COLLATE utf8_bin,
  `image_maxsize` int DEFAULT '0',
  `file_maxsize` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mlm_config`
--

INSERT INTO `mlm_config` (`configid`, `userid`, `userid_updt`, `cms_title`, `cms_url`, `meta_title`, `meta_keywords`, `meta_description`, `site_url`, `site_url_extension`, `site_url_web`, `script`, `style`, `logo`, `favicon`, `timezone`, `date_format`, `time_format`, `records_perpage`, `google_indexing`, `referral_amount`, `mail_server`, `mail_port`, `mail_encryption`, `mail_name`, `mail_email`, `mail_password`, `thumb_width`, `thumb_height`, `thumb_ratio`, `large_width`, `large_height`, `large_ratio`, `image_maxsize`, `file_maxsize`, `status`, `user_ip`, `modifytime`, `modifydate`, `createtime`, `createdate`) VALUES
(1, 1, 1, 'MLM (Backend) | Grocery Master', 'http://www.grocerymaster.in/demo/mlm/admin/', 'MLM | Grocery Master', '', '', 'http://www.grocerymaster.in/demo/mlm/', '.php', 'http://www.grocerymaster.in/demo/', '', '', 'logo.png', 'favicon.ico', 'Asia/Kolkata', 'F d, Y', 'h:i a', 50, 0, '100.00', 'smtp.hostinger.in', 587, 'tls', 'Grocery Master', 'no-reply@grocerymaster.in', 'Tech#90#90', 150, 150, 'true', 1600, 1600, 'true', 5242880, 10485760, 'active', '182.77.124.199', '15:36:00', '2020-10-19', '22:03:09', '2020-07-23');

-- --------------------------------------------------------

--
-- Table structure for table `mlm_enquiries`
--

CREATE TABLE `mlm_enquiries` (
  `enquiryid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `first_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `last_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mobile` text CHARACTER SET utf8 COLLATE utf8_bin,
  `subject` text CHARACTER SET utf8 COLLATE utf8_bin,
  `message` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `remarks` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `read_check` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_enquiries_replies`
--

CREATE TABLE `mlm_enquiries_replies` (
  `replyid` bigint NOT NULL,
  `enquiryid` int DEFAULT '0',
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `posted_by` text CHARACTER SET utf8 COLLATE utf8_bin,
  `message` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `remarks` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_ewallet`
--

CREATE TABLE `mlm_ewallet` (
  `ewalletid` int NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `membership_id` text,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `refno` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT '0.00',
  `type` text CHARACTER SET utf8 COLLATE utf8_bin,
  `reason` text CHARACTER SET utf8 COLLATE utf8_bin,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(20) DEFAULT 'pending',
  `user_ip` longtext,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_logdetail`
--

CREATE TABLE `mlm_logdetail` (
  `id` int NOT NULL,
  `userid` int DEFAULT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` text CHARACTER SET utf8 COLLATE utf8_bin,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mlm_logdetail`
--

INSERT INTO `mlm_logdetail` (`id`, `userid`, `username`, `status`, `user_ip`, `createtime`, `createdate`) VALUES
(1, 1, 'mlm@grocery', 'active', '182.77.124.199', '15:34:50', '2020-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `mlm_logdetail_frontend`
--

CREATE TABLE `mlm_logdetail_frontend` (
  `id` int NOT NULL,
  `regid` int DEFAULT NULL,
  `membership_id` text,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` text CHARACTER SET utf8 COLLATE utf8_bin,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_plans`
--

CREATE TABLE `mlm_plans` (
  `planid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `amount` decimal(65,2) DEFAULT '0.00',
  `order_custom` int DEFAULT '0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mlm_plans`
--

INSERT INTO `mlm_plans` (`planid`, `userid`, `userid_updt`, `title`, `title_id`, `amount`, `order_custom`, `description`, `imgName`, `fileName`, `priority`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 1, 'Plan A - 1500', 'plan-a-1500', '1500.00', 1, '', '', '', 0, 'active', '::1', '2020-09-28', '16:28:11', '15:39:51', '2020-09-28');

-- --------------------------------------------------------

--
-- Table structure for table `mlm_registrations`
--

CREATE TABLE `mlm_registrations` (
  `regid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `membership_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `membership_id_value` int DEFAULT '0',
  `rewardid` int DEFAULT '0',
  `members` int DEFAULT '0',
  `sponsor_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `sponsor_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `planid` int DEFAULT '0',
  `first_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `last_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `password` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mobile` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mobile_alter` text CHARACTER SET utf8 COLLATE utf8_bin,
  `pin_code` int DEFAULT '0',
  `bank_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `account_number` text CHARACTER SET utf8 COLLATE utf8_bin,
  `ifsc_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `account_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `pan_card` text CHARACTER SET utf8 COLLATE utf8_bin,
  `aadhar_card` text CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `remarks` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `member_check` int DEFAULT '0',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `expirydatetime` datetime DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mlm_registrations`
--

INSERT INTO `mlm_registrations` (`regid`, `userid`, `userid_updt`, `membership_id`, `membership_id_value`, `rewardid`, `members`, `sponsor_id`, `sponsor_name`, `planid`, `first_name`, `last_name`, `username`, `email`, `password`, `mobile`, `mobile_alter`, `pin_code`, `bank_name`, `account_number`, `ifsc_code`, `account_name`, `pan_card`, `aadhar_card`, `imgName`, `remarks`, `status`, `member_check`, `user_ip`, `expirydatetime`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 0, 1, 'GM001', 1, 0, 1, '', '', 1, 'Admin', '', 'admin', 'admin@grocerymaster', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0000000000', '', 110092, 'Test', 'Test', 'Test', 'Test', 'Test', 'Test', '', '', 'active', 1, '::1', '2020-09-28 17:45:05', '2020-09-29', '17:38:42', '15:43:58', '2020-09-28');

-- --------------------------------------------------------

--
-- Table structure for table `mlm_registrations_history`
--

CREATE TABLE `mlm_registrations_history` (
  `historyid` int NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `membership_id` text,
  `sponsor_id` text,
  `member` int DEFAULT '0',
  `total_members` int DEFAULT '0',
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(20) DEFAULT 'active',
  `user_ip` longtext,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_rewards`
--

CREATE TABLE `mlm_rewards` (
  `rewardid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `planid` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `members` int DEFAULT '0',
  `earnings` decimal(65,2) DEFAULT '0.00',
  `amount` decimal(65,2) DEFAULT '0.00',
  `order_custom` int DEFAULT '0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mlm_rewards`
--

INSERT INTO `mlm_rewards` (`rewardid`, `userid`, `userid_updt`, `planid`, `title`, `title_id`, `members`, `earnings`, `amount`, `order_custom`, `description`, `imgName`, `fileName`, `priority`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 0, 1, 'Star', 'star', 0, '1000.00', '100.00', 1, '', '', '', 0, 'active', '::1', NULL, NULL, '11:27:48', '2020-09-30'),
(2, 1, 0, 1, 'Silver', 'silver', 0, '10000.00', '1000.00', 2, '', '', '', 0, 'active', '::1', NULL, NULL, '11:28:40', '2020-09-30'),
(3, 1, 0, 1, 'Gold', 'gold', 0, '100000.00', '10000.00', 3, '', '', '', 0, 'active', '::1', NULL, NULL, '11:29:28', '2020-09-30'),
(4, 1, 0, 1, 'Platinum', 'platinum', 0, '1000000.00', '100000.00', 4, '', '', '', 0, 'active', '::1', NULL, NULL, '11:30:09', '2020-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `mlm_transactions`
--

CREATE TABLE `mlm_transactions` (
  `transactionid` int NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `membership_id` text,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `refno` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT '0.00',
  `type` text CHARACTER SET utf8 COLLATE utf8_bin,
  `reason` text CHARACTER SET utf8 COLLATE utf8_bin,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(20) DEFAULT 'pending',
  `user_ip` longtext,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mlm_users`
--

CREATE TABLE `mlm_users` (
  `userid` int NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `display_name` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `email` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `per_read` int DEFAULT '0',
  `per_write` int DEFAULT '0',
  `per_update` int DEFAULT '0',
  `per_delete` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mlm_users`
--

INSERT INTO `mlm_users` (`userid`, `type`, `username`, `password`, `display_name`, `email`, `imgName`, `per_read`, `per_write`, `per_update`, `per_delete`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 'admin', 'mlm@grocery', 'eb735ed2109414a4849f214c4c25c7f6e97597ca', 'Admin', '', '', 1, 1, 1, 1, 'active', '::1', '2020-09-06', '01:40:35', '01:12:15', '2020-07-24');

-- --------------------------------------------------------

--
-- Table structure for table `rb_badlinks`
--

CREATE TABLE `rb_badlinks` (
  `badlinkid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `url_redirect_from` text CHARACTER SET utf8 COLLATE utf8_bin,
  `url_redirect_to` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_cart`
--

CREATE TABLE `rb_cart` (
  `cartid` int NOT NULL,
  `regid` int DEFAULT '0',
  `refno` text,
  `productid` int DEFAULT '0',
  `variantid` int DEFAULT '0',
  `quantity` int DEFAULT '0',
  `price` decimal(65,2) DEFAULT '0.00',
  `status` varchar(20) DEFAULT 'active',
  `user_ip` varchar(50) DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_cart`
--

INSERT INTO `rb_cart` (`cartid`, `regid`, `refno`, `productid`, `variantid`, `quantity`, `price`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 'GM-C-62C9FDA00F', 1, 4, 6, '210.00', 'active', '182.77.124.199', '2020-10-19', '17:45:46', '15:36:31', '2020-10-19'),
(2, 1, 'GM-C-62C9FDA00F', 2, 3, 4, '70.00', 'active', '182.77.124.199', '2020-10-19', '17:45:46', '15:36:43', '2020-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `rb_categories`
--

CREATE TABLE `rb_categories` (
  `categoryid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `url` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `url_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '_self',
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `home_priority` int DEFAULT '0',
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_categories`
--

INSERT INTO `rb_categories` (`categoryid`, `userid`, `userid_updt`, `title`, `title_id`, `tagline`, `order_custom`, `url`, `url_target`, `meta_title`, `meta_keywords`, `meta_description`, `description`, `imgName`, `fileName`, `home_priority`, `priority`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 1, 'Dal', 'dal', '', 1, '', '_self', '', '', '', '', 'daals-category-banner_1.jpg', '', 1, 1, 'active', '223.233.106.37, 103.92.43.101', '2020-10-14', '15:20:24', '16:12:59', '2020-09-22'),
(2, 1, 1, 'Sugar/Salt Items', 'sugar-salt-items', '', 2, '', '_self', '', '', '', '', 'Why-No-Salt-or-Sugar-For-babies-below-one-year-2.jpg', '', 1, 0, 'active', '223.233.106.37', '2020-09-22', '17:31:54', '16:13:16', '2020-09-22'),
(3, 1, 1, 'Rice/Wheat Products', 'rice-wheat-products', '', 3, '', '_self', '', '', '', '', '', '', 0, 0, 'active', '223.233.106.37', '2020-09-22', '16:15:06', '16:13:26', '2020-09-22'),
(4, 1, 1, 'Ghee/Oil', 'ghee-oil', '', 4, '', '_self', '', '', '', '', 'ghee_625x350_61437044016.jpg', '', 1, 0, 'active', '223.233.106.37', '2020-09-22', '17:36:24', '16:13:35', '2020-09-22'),
(5, 1, 1, 'Dry Fruits', 'dry-fruits', '', 5, '', '_self', '', '', '', '', 'dry_fruit_898_1.jpg', '', 1, 0, 'active', '223.233.106.37', '2020-09-22', '17:40:08', '16:13:53', '2020-09-22'),
(6, 1, 0, 'Spices and Masala', 'spices-and-masala', '', 6, '', '_self', '', '', '', '', '', '', 0, 0, 'active', '223.233.106.37', NULL, NULL, '16:14:04', '2020-09-22'),
(7, 1, 1, 'Tea &amp; Coffee', 'tea-and-coffee', '', 7, '', '_self', '', '', '', '', '', '', 0, 1, 'active', '103.92.43.101, 103.92.42.18', '2020-10-20', '11:53:36', '15:21:32', '2020-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `rb_config`
--

CREATE TABLE `rb_config` (
  `configid` int NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `cms_title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `cms_url` text CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `site_url` text CHARACTER SET utf8 COLLATE utf8_bin,
  `site_url_extension` text CHARACTER SET utf8 COLLATE utf8_bin,
  `script` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `style` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `logo` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `favicon` text CHARACTER SET utf8 COLLATE utf8_bin,
  `timezone` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date_format` text CHARACTER SET utf8 COLLATE utf8_bin,
  `time_format` text CHARACTER SET utf8 COLLATE utf8_bin,
  `records_perpage` int DEFAULT '50',
  `google_indexing` int DEFAULT '0',
  `expected_delivery` text CHARACTER SET utf8 COLLATE utf8_bin,
  `minimum_cart` decimal(65,2) DEFAULT '0.00',
  `mail_server` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_port` int DEFAULT '0',
  `mail_encryption` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mail_password` text CHARACTER SET utf8 COLLATE utf8_bin,
  `thumb_width` int DEFAULT '0',
  `thumb_height` int DEFAULT '0',
  `thumb_ratio` text CHARACTER SET utf8 COLLATE utf8_bin,
  `large_width` int DEFAULT '0',
  `large_height` int DEFAULT '0',
  `large_ratio` text CHARACTER SET utf8 COLLATE utf8_bin,
  `image_maxsize` int DEFAULT '0',
  `file_maxsize` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_config`
--

INSERT INTO `rb_config` (`configid`, `userid`, `userid_updt`, `cms_title`, `cms_url`, `meta_title`, `meta_keywords`, `meta_description`, `site_url`, `site_url_extension`, `script`, `style`, `logo`, `favicon`, `timezone`, `date_format`, `time_format`, `records_perpage`, `google_indexing`, `expected_delivery`, `minimum_cart`, `mail_server`, `mail_port`, `mail_encryption`, `mail_name`, `mail_email`, `mail_password`, `thumb_width`, `thumb_height`, `thumb_ratio`, `large_width`, `large_height`, `large_ratio`, `image_maxsize`, `file_maxsize`, `status`, `user_ip`, `modifytime`, `modifydate`, `createtime`, `createdate`) VALUES
(1, 1, 1, 'CMS: Grocery Master', 'http://www.grocerymaster.in/demo/be/', 'Grocery Master', '', '', 'http://www.grocerymaster.in/demo/', '/', '', '', 'logo.png', 'favicon.ico', 'Asia/Kolkata', 'F d, Y', 'h:i a', 50, 0, 'Expected Delivery in 24 hours', '1500.00', 'smtp.hostinger.in', 587, 'tls', 'Grocery Master', 'no-reply@grocerymaster.in', 'Tech#90#90', 150, 150, 'true', 1600, 1600, 'true', 5242880, 10485760, 'active', '182.77.124.199', '15:36:02', '2020-10-19', '22:03:09', '2020-07-23');

-- --------------------------------------------------------

--
-- Table structure for table `rb_coupons`
--

CREATE TABLE `rb_coupons` (
  `couponid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `coupon_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `discount` int DEFAULT '0',
  `min_price` int DEFAULT '0',
  `max_discount` int DEFAULT '0',
  `expiry_date` date DEFAULT NULL,
  `currency_code` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `order_custom` int DEFAULT '0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_dynamic_pages`
--

CREATE TABLE `rb_dynamic_pages` (
  `pageid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `url` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `url_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '_self',
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_dynamic_pages`
--

INSERT INTO `rb_dynamic_pages` (`pageid`, `userid`, `userid_updt`, `title`, `title_id`, `tagline`, `order_custom`, `url`, `url_target`, `meta_title`, `meta_keywords`, `meta_description`, `description`, `imgName`, `fileName`, `priority`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 0, 'Blog', 'blog', '', 1, '', '_self', '', '', '', '', '', '', 0, 'active', '::1', NULL, NULL, '10:36:53', '2020-09-12'),
(2, 1, 0, 'Home Page Banners', 'home-page-banners', '', 2, '', '_self', '', '', '', '', '', '', 0, 'active', '::1', NULL, NULL, '12:24:40', '2020-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `rb_dynamic_records`
--

CREATE TABLE `rb_dynamic_records` (
  `recordid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `pageid` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `price` int DEFAULT '0',
  `order_custom` int DEFAULT '0',
  `url` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `url_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '_self',
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_enquiries`
--

CREATE TABLE `rb_enquiries` (
  `enquiryid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `first_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `last_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mobile` text CHARACTER SET utf8 COLLATE utf8_bin,
  `subject` text CHARACTER SET utf8 COLLATE utf8_bin,
  `message` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `remarks` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_faqs`
--

CREATE TABLE `rb_faqs` (
  `faqid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_logdetail`
--

CREATE TABLE `rb_logdetail` (
  `id` int NOT NULL,
  `userid` int DEFAULT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` text CHARACTER SET utf8 COLLATE utf8_bin,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_logdetail`
--

INSERT INTO `rb_logdetail` (`id`, `userid`, `username`, `status`, `user_ip`, `createtime`, `createdate`) VALUES
(1, 1, 'admin@grocerymaster', 'active', '223.179.128.8', '16:32:28', '2020-10-12'),
(2, 1, 'admin@grocerymaster', 'active', '223.179.128.8', '16:33:38', '2020-10-12'),
(3, 1, 'admin@grocerymaster', 'active', '223.179.128.8', '16:33:50', '2020-10-12'),
(4, 1, 'admin@grocerymaster', 'active', '223.190.67.59', '10:46:58', '2020-10-13'),
(5, 1, 'admin@grocerymaster', 'active', '223.190.67.59', '14:55:14', '2020-10-13'),
(6, 1, 'admin@grocerymaster', 'active', '223.190.93.32', '10:24:31', '2020-10-14'),
(7, 1, 'admin@grocerymaster', 'active', '103.92.43.101', '15:04:46', '2020-10-14'),
(8, 1, 'admin@grocerymaster', 'active', '223.190.93.32', '17:30:09', '2020-10-14'),
(9, 1, 'admin@grocerymaster', 'active', '182.77.124.199', '15:27:16', '2020-10-19'),
(10, 1, 'admin@grocerymaster', 'active', '103.92.42.18', '11:34:47', '2020-10-20'),
(11, 1, 'admin@grocerymaster', 'active', '106.201.10.87', '11:47:33', '2020-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `rb_logdetail_frontend`
--

CREATE TABLE `rb_logdetail_frontend` (
  `id` int NOT NULL,
  `regid` int DEFAULT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` text CHARACTER SET utf8 COLLATE utf8_bin,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_logdetail_frontend`
--

INSERT INTO `rb_logdetail_frontend` (`id`, `regid`, `username`, `email`, `status`, `user_ip`, `createtime`, `createdate`) VALUES
(1, 1, NULL, 'bialarajat@gmail.com', 'active', '182.77.124.199', '15:32:20', '2020-10-19'),
(2, 1, NULL, 'bialarajat@gmail.com', 'active', '182.77.124.199', '17:18:41', '2020-10-19'),
(3, 1, NULL, 'bialarajat@gmail.com', 'active', '182.77.124.199', '17:45:41', '2020-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `rb_media`
--

CREATE TABLE `rb_media` (
  `mediaid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_newsletters`
--

CREATE TABLE `rb_newsletters` (
  `newsletterid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `first_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `last_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `remarks` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_pages`
--

CREATE TABLE `rb_pages` (
  `pageid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `main_menu` int DEFAULT '0',
  `sub_menu` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `url` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `url_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '_self',
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_pages`
--

INSERT INTO `rb_pages` (`pageid`, `userid`, `userid_updt`, `main_menu`, `sub_menu`, `title`, `title_id`, `tagline`, `order_custom`, `url`, `url_target`, `meta_title`, `meta_keywords`, `meta_description`, `description`, `imgName`, `fileName`, `priority`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 1, 0, 0, 'Home', 'home', '', 1, 'http://www.grocerymaster.in/demo/', '_self', '', '', '', '', '', '', 0, 'active', '::1, 223.233.72.207', '2020-09-28', '12:22:16', '13:50:46', '2020-09-11'),
(2, 1, 1, 0, 0, 'About Us', 'about-us', '', 2, '', '_self', '', '', '', '<p><strong>Raashan Mangao, Rupaya Kamao, Ghar Baithe </strong></p>\r\n<p><br />Grocery master is not only a one-stop-shop for all your daily needs, but also provides you with an opportunity of earning while you shop.<br />It allows you to order grocery products across categories like Dry fruits,  Salt &amp; Sugar, Spices, Ghee &amp; Oil, Pulses, Tea &amp; Coffee, and many more Food &amp; FMCG related products. Our products are solely handpicked to provide you with the best quality at a minimum price. <br />Buy from a wide variety of grocery products that have been exclusively chosen to meet the customer\'s satisfaction.</p>\r\n<p>We offer you the convenience of ordering online and getting all your products delivered right at your doorstep and guarantees you a hassle-free shopping experience</p>', '', '', 0, 'active', '::1', '2020-10-10', '15:33:29', '13:50:57', '2020-09-11'),
(3, 1, 1, 0, 0, 'Our Products', 'our-products', '', 3, 'products/', '_self', '', '', '', '', '', '', 0, 'active', '::1', '2020-09-11', '16:14:49', '13:51:17', '2020-09-11'),
(4, 1, 1, 0, 0, 'Blog', 'blog', '', 4, 'section/blog/', '_self', '', '', '', '', '', '', 0, 'active', '::1', '2020-09-12', '11:48:19', '13:51:25', '2020-09-11'),
(5, 1, 1, 0, 0, 'Contact Us', 'contact', '', 5, 'contact/', '_self', '', '', '', '', '', '', 0, 'active', '::1', '2020-09-11', '16:20:42', '13:51:33', '2020-09-11'),
(6, 1, 1, 0, 0, 'Privacy Policy', 'privacy-policy', '', 0, '', '_self', '', '', '', '<p>At GroceryMaster, accessible from grocerymaster.in, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by GroceryMaster and how we use it.</p>\r\n<p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>\r\n<p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in GroceryMaster. This policy is not applicable to any information collected offline or via channels other than this website.</p>\r\n<p><strong>Consent</strong></p>\r\n<p>By using our website, you hereby consent to our Privacy Policy and agree to its terms. For our Terms and Conditions, please visit the <span><a href=\"https://www.privacypolicyonline.com/terms-conditions-generator/\">Terms &amp; Conditions Generator</a>.</span></p>\r\n<p><strong>Information we collect</strong></p>\r\n<p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>\r\n<p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>\r\n<p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>\r\n<p><strong>How we use your information</strong></p>\r\n<p>We use the information we collect in various ways, including to:</p>\r\n<ul>\r\n<li>Provide, operate, and maintain our webste</li>\r\n<li>Improve, personalize, and expand our webste</li>\r\n<li>Understand and analyze how you use our webste</li>\r\n<li>Develop new products, services, features, and functionality</li>\r\n<li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the webste, and for marketing and promotional purposes</li>\r\n<li>Send you emails</li>\r\n<li>Find and prevent fraud</li>\r\n</ul>\r\n<p><strong><br />Log Files</strong></p>\r\n<p>GroceryMaster follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services\' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</p>\r\n<p><strong>Cookies and Web Beacons</strong></p>\r\n<p>Like any other website, GroceryMaster uses \'cookies\'. These cookies are used to store information including visitors\' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users\' experience by customizing our web page content based on visitors\' browser type and/or other information.</p>\r\n<p>For more general information on cookies, please read <span><a href=\"https://www.cookieconsent.com/what-are-cookies/\">\"What Are Cookies\"</a>.</span></p>\r\n<p><strong>Advertising Partners Privacy Policies</strong></p>\r\n<p>You may consult this list to find the Privacy Policy for each of the advertising partners of GroceryMaster.</p>\r\n<p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on GroceryMaster, which are sent directly to users\' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>\r\n<p>Note that GroceryMaster has no access to or control over these cookies that are used by third- party advertisers.</p>\r\n<p><strong>Third-Party Privacy Policies</strong></p>\r\n<p>GroceryMaster\'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options.</p>\r\n<p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers\' respective websites.</p>\r\n<p><strong>CCPA Privacy Rights (Do Not Sell My Personal Information)</strong></p>\r\n<p>Under the CCPA, among other rights, California consumers have the right to:</p>\r\n<p>Request that a business that collects a consumer\'s personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p>\r\n<p>Request that a business delete any personal data about the consumer that a business has collected.</p>\r\n<p>Request that a business that sells a consumer\'s personal data, not sell the consumer\'s personal data.</p>\r\n<p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>\r\n<p><strong>GDPR Data Protection Rights</strong></p>\r\n<p>We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p>\r\n<p>The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</p>\r\n<p>The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p>\r\n<p>The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</p>\r\n<p>The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</p>\r\n<p>The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</p>\r\n<p>The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p>\r\n<p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>\r\n<p><strong>Children\'s Information</strong></p>\r\n<p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>\r\n<p>GroceryMaster does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>', '', '', 0, 'inactive', '::1', '2020-10-10', '15:39:15', '15:57:26', '2020-09-11'),
(7, 1, 1, 0, 0, 'Terms &amp; Conditions', 'terms-and-conditions', '', 0, '', '_self', '', '', '', '<p><strong><br />Introduction </strong></p>\r\n<p>These Website Standard Terms and Conditions written on this webpage shall manage your use of our website, GroceryMaster accessible at grocerymaster.in.</p>\r\n<p>These Terms will be applied fully and affect to your use of this Website. By using this Website, you agreed to accept all terms and conditions written in here. You must not use this Website if you disagree with any of these Website Standard Terms and Conditions.</p>\r\n<p><strong>Intellectual Property Rights </strong></p>\r\n<p>Other than the content you own, under these Terms, GroceryMaster and/or its licensors own all the intellectual property rights and materials contained in this Website.</p>\r\n<p>You are granted limited license only for purposes of viewing the material contained on this Website.</p>\r\n<p><strong>Restrictions </strong></p>\r\n<p>You are specifically restricted from all of the following:</p>\r\n<ul>\r\n<li>publishing any Website material in any other media;</li>\r\n<li>selling, sublicensing and/or otherwise commercializing any Website material;</li>\r\n<li>publicly performing and/or showing any Website material;</li>\r\n<li>using this Website in any way that is or may be damaging to this Website;</li>\r\n<li>using this Website in any way that impacts user access to this Website;</li>\r\n<li>using this Website contrary to applicable laws and regulations, or in any way may cause harm to the Website, or to any person or business entity;</li>\r\n<li>engaging in any data mining, data harvesting, data extracting or any other similar activity in relation to this Website;</li>\r\n<li>using this Website to engage in any advertising or marketing.</li>\r\n</ul>\r\n<p>Certain areas of this Website are restricted from being access by you and GroceryMaster may further restrict access by you to any areas of this Website, at any time, in absolute discretion. Any user ID and password you may have for this Website are confidential and you must maintain confidentiality as well.</p>\r\n<p><strong>Your Content </strong></p>\r\n<p>In these Website Standard Terms and Conditions, \"Your Content\" shall mean any audio, video text, images or other material you choose to display on this Website. By displaying Your Content, you grant GroceryMaster a non-exclusive, worldwide irrevocable, sub licensable license to use, reproduce, adapt, publish, translate and distribute it in any and all media.</p>\r\n<p>Your Content must be your own and must not be invading any third-party’s rights. GroceryMaster reserves the right to remove any of Your Content from this Website at any time without notice.</p>\r\n<p><strong>Your Privacy </strong></p>\r\n<p>Please read Privacy Policy.</p>\r\n<p><strong>No warranties </strong></p>\r\n<p>This Website is provided \"as is,\" with all faults, and GroceryMaster express no representations or warranties, of any kind related to this Website or the materials contained on this Website. Also, nothing contained on this Website shall be interpreted as advising you.</p>\r\n<p><strong>Limitation of liability </strong></p>\r\n<p>In no event shall GroceryMaster, nor any of its officers, directors and employees, shall be held liable for anything arising out of or in any way connected with your use of this Website whether such liability is under contract. GroceryMaster, including its officers, directors and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.</p>\r\n<p><strong>Indemnification </strong></p>\r\n<p>You hereby indemnify to the fullest extent GroceryMaster from and against any and/or all liabilities, costs, demands, causes of action, damages and expenses arising in any way related to your breach of any of the provisions of these Terms.</p>\r\n<p><strong>Severability </strong></p>\r\n<p>If any provision of these Terms is found to be invalid under any applicable law, such provisions shall be deleted without affecting the remaining provisions herein.</p>\r\n<p><strong>Variation of Terms </strong></p>\r\n<p>GroceryMaster is permitted to revise these Terms at any time as it sees fit, and by using this Website you are expected to review these Terms on a regular basis.</p>\r\n<p><strong>Assignment </strong></p>\r\n<p>The GroceryMaster is allowed to assign, transfer, and subcontract its rights and/or obligations under these Terms without any notification. However, you are not allowed to assign, transfer, or subcontract any of your rights and/or obligations under these Terms.</p>\r\n<p><strong>Entire Agreement </strong></p>\r\n<p>These Terms constitute the entire agreement between GroceryMaster and you in relation to your use of this Website, and supersede all prior agreements and understandings.</p>\r\n<p><strong>Governing Law &amp; Jurisdiction </strong></p>\r\n<p>These Terms will be governed by and interpreted in accordance with the laws of the State of in, and you submit to the non-exclusive jurisdiction of the state and federal courts located in in for the resolution of any disputes.</p>', '', '', 0, 'inactive', '::1', '2020-10-10', '15:43:44', '15:57:37', '2020-09-11'),
(8, 1, 1, 0, 0, 'Thank You', 'thank-you', '', 0, '', '_self', '', '', '', '<h3 style=\"text-align: center;\"><br />Your order has been successfully placed!<br /><br /></h3>\r\n<h5 style=\"text-align: center;\">You may check your order details for more information. </h5>', '', '', 0, 'inactive', '::1', '2020-09-14', '15:30:59', '16:05:29', '2020-09-11'),
(9, 1, 0, 0, 0, 'Login', 'login', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '13:51:42', '2020-09-14'),
(10, 1, 0, 0, 0, 'Register with Us', 'register', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '14:14:31', '2020-09-14'),
(11, 1, 0, 0, 0, 'User\'s Home', 'user-home', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '14:47:34', '2020-09-14'),
(12, 1, 0, 0, 0, 'Change Password', 'change-password', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '14:52:59', '2020-09-14'),
(13, 1, 0, 0, 0, 'Coupons', 'coupons', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '15:00:59', '2020-09-14'),
(14, 1, 0, 0, 0, 'Forgot Password ?', 'forgot-password', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '15:05:00', '2020-09-14'),
(15, 1, 0, 0, 0, 'Reset your Password', 'reset-your-password', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '15:09:59', '2020-09-14'),
(16, 1, 1, 0, 0, 'Your Orders', 'orders', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', '2020-09-14', '15:18:54', '15:18:43', '2020-09-14'),
(17, 1, 0, 0, 0, 'Order Detail', 'order-detail', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '15:21:49', '2020-09-14'),
(18, 1, 0, 0, 0, 'Track your Order', 'track-your-order', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '15:33:16', '2020-09-14'),
(19, 1, 0, 0, 0, 'Wishlist', 'wishlist', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '15:45:33', '2020-09-14'),
(20, 1, 0, 0, 0, 'Shopping Cart', 'cart', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '15:53:03', '2020-09-14'),
(21, 1, 0, 0, 0, 'Product Checkout', 'checkout', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '16:41:55', '2020-09-14'),
(22, 1, 0, 0, 0, 'Update your Profile', 'update-your-profile', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '10:49:43', '2020-09-15'),
(23, 1, 1, 0, 0, 'Payment Failed', 'payment-failed', '', 0, '', '_self', '', '', '', '<h4 style=\"text-align: center;\"><span><br />Your transaction has not been completed! You can again order from your </span><a href=\"https://demo.codiesoft.com/grocerymaster.in/cart/\">cart</a></h4>', '', '', 0, 'active', '::1, 223.233.72.207', '2020-09-22', '11:06:58', '11:14:37', '2020-09-15'),
(24, 1, 0, 0, 0, 'FAQs', 'faq', '', 0, '', '_self', '', '', '', '', '', '', 0, 'inactive', '::1', NULL, NULL, '13:07:22', '2020-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `rb_products`
--

CREATE TABLE `rb_products` (
  `productid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `categoryid` int DEFAULT '0',
  `subcategoryid` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `product_code` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `product_code_value` int DEFAULT '0',
  `currency_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `variant` text CHARACTER SET utf8 COLLATE utf8_bin,
  `sku` text CHARACTER SET utf8 COLLATE utf8_bin,
  `price` int DEFAULT '0',
  `mrp` int DEFAULT '0',
  `stock_quantity` int DEFAULT '0',
  `shipping` int DEFAULT '0',
  `tax_information` text CHARACTER SET utf8 COLLATE utf8_bin,
  `tax_type` text CHARACTER SET utf8 COLLATE utf8_bin,
  `tax` int DEFAULT '0',
  `cod` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `sale` int DEFAULT '0',
  `url` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `url_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '_self',
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `specification` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `views` int DEFAULT '0',
  `invoicedate` date DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_products`
--

INSERT INTO `rb_products` (`productid`, `userid`, `userid_updt`, `categoryid`, `subcategoryid`, `title`, `title_id`, `tagline`, `order_custom`, `product_code`, `product_code_value`, `currency_code`, `variant`, `sku`, `price`, `mrp`, `stock_quantity`, `shipping`, `tax_information`, `tax_type`, `tax`, `cod`, `sale`, `url`, `url_target`, `meta_title`, `meta_keywords`, `meta_description`, `description`, `specification`, `imgName`, `fileName`, `priority`, `views`, `invoicedate`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 1, 1, 0, 'Arhar Dal', 'arhar-dal', '', 1, 'PC-1', 1, 'INR', '1 kg', '', 110, 150, 2, 0, 'included', 'IGST', 18, 'yes', 0, '', '_self', '', '', '', '', '', '41gge5q5zJL.jpg', '', 1, 3, NULL, 'active', '223.233.106.37, 106.215.40.143, ::1', '2020-10-12', '14:40:46', '17:18:10', '2020-09-22'),
(2, 1, 1, 1, 0, 'Chana dal', 'chana-dal', '', 2, 'PC-2', 2, 'INR', '1 kg', '', 70, 90, 4, 0, 'included', 'IGST', 18, 'yes', 0, '', '_self', '', '', '', '', '', 'chana-dal-split-500x500.png', '', 1, 3, NULL, 'active', '223.233.106.37, ::1', '2020-10-12', '14:40:54', '17:24:10', '2020-09-22'),
(3, 1, 0, 7, 0, 'Jaina Tea', 'jaina-tea', 'the best tea', 3, 'PC-3', 3, 'INR', '250gm', '', 100, 150, 10, 0, 'included', 'CGST/SGST', 18, 'yes', 1, '', '_self', '', '', '', '<p>the best quality tea from Assam</p>', '', '', '', 1, 0, NULL, 'active', '103.92.42.18', NULL, NULL, '11:51:33', '2020-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `rb_products_reviews`
--

CREATE TABLE `rb_products_reviews` (
  `reviewid` int NOT NULL,
  `userid` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `productid` int DEFAULT '0',
  `name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `ratings` int DEFAULT '0',
  `message` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `read_check` int DEFAULT '0',
  `status` varchar(20) DEFAULT 'active',
  `user_ip` varchar(50) DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rb_products_variants`
--

CREATE TABLE `rb_products_variants` (
  `variantid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `productid` bigint NOT NULL,
  `variant` text CHARACTER SET utf8 COLLATE utf8_bin,
  `sku` text CHARACTER SET utf8 COLLATE utf8_bin,
  `price` int DEFAULT '0',
  `mrp` int DEFAULT '0',
  `stock_quantity` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_products_variants`
--

INSERT INTO `rb_products_variants` (`variantid`, `userid`, `userid_updt`, `productid`, `variant`, `sku`, `price`, `mrp`, `stock_quantity`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(3, 1, 1, 2, '1 kg', '', 70, 90, 4, 'active', '223.233.106.37, ::1', '2020-10-12', '14:40:54', '17:24:10', '2020-09-22'),
(2, 1, 1, 1, '1 kg', '', 110, 150, 6, 'active', '223.233.106.37, 106.215.40.143, ::1', '2020-10-12', '14:40:46', '17:18:10', '2020-09-22'),
(4, 1, 1, 1, '2 kg', '', 210, 300, 6, 'active', '223.233.106.37, 106.215.40.143, ::1', '2020-10-12', '14:40:46', '11:28:39', '2020-09-23'),
(5, 1, 0, 3, '250gm', '', 100, 150, 10, 'active', '103.92.42.18', NULL, NULL, '11:51:33', '2020-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `rb_products_views`
--

CREATE TABLE `rb_products_views` (
  `viewid` int NOT NULL,
  `regid` int DEFAULT '0',
  `productid` int DEFAULT '0',
  `status` varchar(20) DEFAULT 'active',
  `user_ip` varchar(50) DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rb_purchases`
--

CREATE TABLE `rb_purchases` (
  `purchaseid` int NOT NULL,
  `userid_updt` int DEFAULT '0',
  `regid` int DEFAULT '0',
  `refno` text CHARACTER SET utf8 COLLATE utf8_bin,
  `refno_value` int DEFAULT '0',
  `cart_refno` text,
  `razorpay_order_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `razorpay_payment_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `razorpay_signature` text CHARACTER SET utf8 COLLATE utf8_bin,
  `membership_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `sponsor_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_first_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_last_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_mobile` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_mobile_alter` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_address` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_landmark` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_city` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_state` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_country` text CHARACTER SET utf8 COLLATE utf8_bin,
  `billing_pin_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_box` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_first_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_last_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_mobile` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_mobile_alter` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_address` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_landmark` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_city` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_state` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_country` text CHARACTER SET utf8 COLLATE utf8_bin,
  `shipping_pin_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `note` text CHARACTER SET utf8 COLLATE utf8_bin,
  `payment_mode` text CHARACTER SET utf8 COLLATE utf8_bin,
  `productid` int DEFAULT '0',
  `variantid` int DEFAULT '0',
  `quantity` int DEFAULT '0',
  `product_price` decimal(65,2) DEFAULT '0.00',
  `product_imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `product_title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `product_currency_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `product_variant` text,
  `price` decimal(65,2) DEFAULT '0.00',
  `shipping` decimal(65,2) DEFAULT '0.00',
  `tax` decimal(65,2) DEFAULT '0.00',
  `taxamount` decimal(65,2) DEFAULT '0.00',
  `tax_information` text CHARACTER SET utf8 COLLATE utf8_bin,
  `tax_type` text CHARACTER SET utf8 COLLATE utf8_bin,
  `total_price` decimal(65,2) DEFAULT '0.00',
  `coupon_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `coupon_discount` decimal(65,2) DEFAULT '0.00',
  `coupon_discount_total` decimal(65,2) DEFAULT '0.00',
  `shipping_total` decimal(65,2) DEFAULT '0.00',
  `taxamount_total` decimal(65,2) DEFAULT '0.00',
  `final_price` decimal(65,2) DEFAULT '0.00',
  `invoicedate` date DEFAULT NULL,
  `tracking_status` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'ordered',
  `status` varchar(20) DEFAULT 'active',
  `user_ip` varchar(50) DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rb_purchases_temp`
--

CREATE TABLE `rb_purchases_temp` (
  `tempid` int NOT NULL,
  `regid` int DEFAULT '0',
  `refno` text CHARACTER SET utf8 COLLATE utf8_bin,
  `cartids` text CHARACTER SET utf8 COLLATE utf8_bin,
  `variantids` text,
  `productids` text CHARACTER SET utf8 COLLATE utf8_bin,
  `price_detail` text CHARACTER SET utf8 COLLATE utf8_bin,
  `total_price` decimal(65,2) DEFAULT '0.00',
  `coupon_code` text CHARACTER SET utf8 COLLATE utf8_bin,
  `coupon_discount` decimal(65,2) DEFAULT '0.00',
  `shipping_total` decimal(65,2) DEFAULT '0.00',
  `shipping_detail` text CHARACTER SET utf8 COLLATE utf8_bin,
  `taxamount_total` decimal(65,2) DEFAULT '0.00',
  `taxamount_detail` text CHARACTER SET utf8 COLLATE utf8_bin,
  `tax_detail` text CHARACTER SET utf8 COLLATE utf8_bin,
  `taxinformation_detail` text,
  `taxtype_detail` text,
  `final_price` decimal(65,2) DEFAULT '0.00',
  `status` varchar(20) DEFAULT 'active',
  `user_ip` varchar(50) DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_purchases_temp`
--

INSERT INTO `rb_purchases_temp` (`tempid`, `regid`, `refno`, `cartids`, `variantids`, `productids`, `price_detail`, `total_price`, `coupon_code`, `coupon_discount`, `shipping_total`, `shipping_detail`, `taxamount_total`, `taxamount_detail`, `tax_detail`, `taxinformation_detail`, `taxtype_detail`, `final_price`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 'GM-C-75D112E4F8', '2,1', '3,4', '2,1', '280,1260', '1540.00', '', '0.00', '0.00', '0,0', '0.00', '0,0', '18,18', 'included,included', 'IGST,IGST', '1540.00', 'active', '182.77.124.199', NULL, NULL, '15:36:47', '2020-10-19'),
(2, 1, 'GM-C-545F71FEF3', '2,1', '3,4', '2,1', '280,1260', '1540.00', '', '0.00', '0.00', '0,0', '0.00', '0,0', '18,18', 'included,included', 'IGST,IGST', '1540.00', 'active', '182.77.124.199', NULL, NULL, '16:50:03', '2020-10-19'),
(3, 1, 'GM-C-70E3DA32D1', '2,1', '3,4', '2,1', '280,1260', '1540.00', '', '0.00', '0.00', '0,0', '0.00', '0,0', '18,18', 'included,included', 'IGST,IGST', '1540.00', 'active', '182.77.124.199', NULL, NULL, '17:18:45', '2020-10-19'),
(4, 1, 'GM-C-62C9FDA00F', '2,1', '3,4', '2,1', '280,1260', '1540.00', '', '0.00', '0.00', '0,0', '0.00', '0,0', '18,18', 'included,included', 'IGST,IGST', '1540.00', 'active', '182.77.124.199', NULL, NULL, '17:45:46', '2020-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `rb_registrations`
--

CREATE TABLE `rb_registrations` (
  `regid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `regid_custom` text CHARACTER SET utf8 COLLATE utf8_bin,
  `first_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `last_name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `password` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mobile` text CHARACTER SET utf8 COLLATE utf8_bin,
  `mobile_alter` text CHARACTER SET utf8 COLLATE utf8_bin,
  `gender` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date_of_birth` date DEFAULT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_bin,
  `landmark` text CHARACTER SET utf8 COLLATE utf8_bin,
  `city` text CHARACTER SET utf8 COLLATE utf8_bin,
  `state` text CHARACTER SET utf8 COLLATE utf8_bin,
  `country` text CHARACTER SET utf8 COLLATE utf8_bin,
  `pin_code` int DEFAULT '0',
  `membership_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `sponsor_id` text CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `remarks` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `expirydatetime` datetime DEFAULT NULL,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_registrations`
--

INSERT INTO `rb_registrations` (`regid`, `userid`, `userid_updt`, `regid_custom`, `first_name`, `last_name`, `username`, `email`, `password`, `mobile`, `mobile_alter`, `gender`, `date_of_birth`, `address`, `landmark`, `city`, `state`, `country`, `pin_code`, `membership_id`, `sponsor_id`, `imgName`, `remarks`, `status`, `user_ip`, `expirydatetime`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 0, 0, 'BT2279B01A87', 'Rajat', 'Biala', NULL, 'bialarajat@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '7837815356', '', 'male', '1996-04-18', 'Laxmi Nagar, New Delhi, Delhi', 'Apollo Pharmacy', 'New Delhi', 'Delhi', 'India', 110092, 'GM001', '', NULL, NULL, 'active', '182.77.124.199', NULL, '2020-10-19', '15:36:15', '15:32:11', '2020-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `rb_sliders`
--

CREATE TABLE `rb_sliders` (
  `sliderid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `sale` int DEFAULT '0',
  `url` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `url_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '_self',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_sliders`
--

INSERT INTO `rb_sliders` (`sliderid`, `userid`, `userid_updt`, `title`, `title_id`, `tagline`, `order_custom`, `sale`, `url`, `url_target`, `description`, `imgName`, `priority`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 1, 1, 'Heading is coming soon...', 'slide1', '', 1, 0, '', '_self', '', 'slide1.png', 0, 'active', '::1', '2020-09-16', '15:16:53', '15:16:09', '2020-09-16'),
(2, 1, 1, 'Heading is coming soon...', 'slide2', '', 2, 0, '', '_self', '', 'slide2.png', 0, 'active', '::1', '2020-09-16', '15:16:50', '15:16:24', '2020-09-16');

-- --------------------------------------------------------

--
-- Table structure for table `rb_subcategories`
--

CREATE TABLE `rb_subcategories` (
  `subcategoryid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `categoryid` int DEFAULT '0',
  `title` text CHARACTER SET utf8 COLLATE utf8_bin,
  `title_id` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `tagline` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `url` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `url_target` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '_self',
  `meta_title` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_keywords` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `meta_description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_testimonials`
--

CREATE TABLE `rb_testimonials` (
  `testimonialid` bigint NOT NULL,
  `userid` int DEFAULT '0',
  `userid_updt` int DEFAULT '0',
  `name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `designation` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `order_custom` int DEFAULT '0',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `fileName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `priority` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rb_users`
--

CREATE TABLE `rb_users` (
  `userid` int NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `display_name` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `email` mediumtext CHARACTER SET utf8 COLLATE utf8_bin,
  `imgName` text CHARACTER SET utf8 COLLATE utf8_bin,
  `per_read` int DEFAULT '0',
  `per_write` int DEFAULT '0',
  `per_update` int DEFAULT '0',
  `per_delete` int DEFAULT '0',
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `modifydate` date DEFAULT NULL,
  `modifytime` time DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rb_users`
--

INSERT INTO `rb_users` (`userid`, `type`, `username`, `password`, `display_name`, `email`, `imgName`, `per_read`, `per_write`, `per_update`, `per_delete`, `status`, `user_ip`, `modifydate`, `modifytime`, `createtime`, `createdate`) VALUES
(1, 'admin', 'admin@grocerymaster', '8e1f0819029d610d350cd4ce7184c2fd05443b7a', 'Admin', '', '', 1, 1, 1, 1, 'active', '::1', '2020-09-11', '13:42:33', '01:12:15', '2020-09-11');

-- --------------------------------------------------------

--
-- Table structure for table `rb_views`
--

CREATE TABLE `rb_views` (
  `viewid` int NOT NULL,
  `regid` int DEFAULT '0',
  `status` varchar(20) DEFAULT 'active',
  `user_ip` varchar(50) DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_views`
--

INSERT INTO `rb_views` (`viewid`, `regid`, `status`, `user_ip`, `createtime`, `createdate`) VALUES
(1, 0, 'active', '171.61.139.26', '15:31:41', '2020-09-24'),
(2, 1, 'active', '117.97.247.209', '15:52:55', '2020-09-24'),
(3, 0, 'active', '106.215.29.97', '09:58:42', '2020-09-25'),
(4, 2, 'active', '106.215.29.97', '10:58:11', '2020-09-25'),
(5, 0, 'active', '146.196.32.102', '13:32:43', '2020-09-25'),
(6, 0, 'active', '103.92.42.240', '09:37:55', '2020-09-26'),
(7, 0, 'active', '103.92.42.240', '09:37:55', '2020-09-26'),
(8, 0, 'active', '103.211.15.138', '20:06:19', '2020-09-26'),
(9, 0, 'active', '103.211.15.174', '20:29:03', '2020-09-26'),
(10, 0, 'active', '47.30.175.8', '16:22:38', '2020-09-27'),
(11, 0, 'active', '::1', '12:19:22', '2020-09-28'),
(12, 0, 'active', '127.0.0.1', '11:55:57', '2020-10-06'),
(13, 0, 'active', '171.61.141.250', '17:49:03', '2020-10-10'),
(14, 0, 'active', '52.114.14.102', '17:49:58', '2020-10-10'),
(15, 0, 'active', '1.38.184.22', '18:15:31', '2020-10-10'),
(16, 0, 'active', '42.111.24.0', '19:29:58', '2020-10-10'),
(17, 0, 'active', '47.31.141.127', '20:07:01', '2020-10-10'),
(18, 0, 'active', '47.31.146.54', '20:07:26', '2020-10-10'),
(19, 0, 'active', '47.31.156.89', '20:07:53', '2020-10-10'),
(20, 0, 'active', '192.168.0.120', '17:50:40', '2020-10-11'),
(21, 0, 'active', '223.179.128.8', '12:17:24', '2020-10-12'),
(22, 0, 'active', '223.190.67.59', '10:46:08', '2020-10-13'),
(23, 0, 'active', '223.190.93.32', '10:20:40', '2020-10-14'),
(24, 0, 'active', '103.92.43.101', '15:03:54', '2020-10-14'),
(25, 0, 'active', '223.225.59.125', '17:08:26', '2020-10-18'),
(26, 0, 'active', '182.77.124.199', '10:34:39', '2020-10-19'),
(27, 0, 'active', '223.225.1.164', '20:01:52', '2020-10-19'),
(28, 0, 'active', '103.92.42.18', '11:34:22', '2020-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `rb_wishlist`
--

CREATE TABLE `rb_wishlist` (
  `wishlistid` int NOT NULL,
  `regid` int DEFAULT '0',
  `productid` int DEFAULT '0',
  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'active',
  `user_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `createdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mlm_challenges`
--
ALTER TABLE `mlm_challenges`
  ADD PRIMARY KEY (`challengeid`);

--
-- Indexes for table `mlm_challenges_history`
--
ALTER TABLE `mlm_challenges_history`
  ADD PRIMARY KEY (`historyid`),
  ADD UNIQUE KEY `refno` (`refno`);

--
-- Indexes for table `mlm_config`
--
ALTER TABLE `mlm_config`
  ADD PRIMARY KEY (`configid`);

--
-- Indexes for table `mlm_enquiries`
--
ALTER TABLE `mlm_enquiries`
  ADD PRIMARY KEY (`enquiryid`);

--
-- Indexes for table `mlm_enquiries_replies`
--
ALTER TABLE `mlm_enquiries_replies`
  ADD PRIMARY KEY (`replyid`);

--
-- Indexes for table `mlm_ewallet`
--
ALTER TABLE `mlm_ewallet`
  ADD PRIMARY KEY (`ewalletid`),
  ADD UNIQUE KEY `refno` (`refno`);

--
-- Indexes for table `mlm_logdetail`
--
ALTER TABLE `mlm_logdetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mlm_logdetail_frontend`
--
ALTER TABLE `mlm_logdetail_frontend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mlm_plans`
--
ALTER TABLE `mlm_plans`
  ADD PRIMARY KEY (`planid`);

--
-- Indexes for table `mlm_registrations`
--
ALTER TABLE `mlm_registrations`
  ADD PRIMARY KEY (`regid`),
  ADD UNIQUE KEY `regid_custom_value` (`membership_id_value`);

--
-- Indexes for table `mlm_registrations_history`
--
ALTER TABLE `mlm_registrations_history`
  ADD PRIMARY KEY (`historyid`);

--
-- Indexes for table `mlm_rewards`
--
ALTER TABLE `mlm_rewards`
  ADD PRIMARY KEY (`rewardid`);

--
-- Indexes for table `mlm_transactions`
--
ALTER TABLE `mlm_transactions`
  ADD PRIMARY KEY (`transactionid`),
  ADD UNIQUE KEY `refno` (`refno`);

--
-- Indexes for table `mlm_users`
--
ALTER TABLE `mlm_users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `rb_badlinks`
--
ALTER TABLE `rb_badlinks`
  ADD PRIMARY KEY (`badlinkid`);

--
-- Indexes for table `rb_cart`
--
ALTER TABLE `rb_cart`
  ADD PRIMARY KEY (`cartid`);

--
-- Indexes for table `rb_categories`
--
ALTER TABLE `rb_categories`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `rb_config`
--
ALTER TABLE `rb_config`
  ADD PRIMARY KEY (`configid`);

--
-- Indexes for table `rb_coupons`
--
ALTER TABLE `rb_coupons`
  ADD PRIMARY KEY (`couponid`);

--
-- Indexes for table `rb_dynamic_pages`
--
ALTER TABLE `rb_dynamic_pages`
  ADD PRIMARY KEY (`pageid`);

--
-- Indexes for table `rb_dynamic_records`
--
ALTER TABLE `rb_dynamic_records`
  ADD PRIMARY KEY (`recordid`);

--
-- Indexes for table `rb_enquiries`
--
ALTER TABLE `rb_enquiries`
  ADD PRIMARY KEY (`enquiryid`);

--
-- Indexes for table `rb_faqs`
--
ALTER TABLE `rb_faqs`
  ADD PRIMARY KEY (`faqid`);

--
-- Indexes for table `rb_logdetail`
--
ALTER TABLE `rb_logdetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rb_logdetail_frontend`
--
ALTER TABLE `rb_logdetail_frontend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rb_media`
--
ALTER TABLE `rb_media`
  ADD PRIMARY KEY (`mediaid`);

--
-- Indexes for table `rb_newsletters`
--
ALTER TABLE `rb_newsletters`
  ADD PRIMARY KEY (`newsletterid`);

--
-- Indexes for table `rb_pages`
--
ALTER TABLE `rb_pages`
  ADD PRIMARY KEY (`pageid`);

--
-- Indexes for table `rb_products`
--
ALTER TABLE `rb_products`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `rb_products_reviews`
--
ALTER TABLE `rb_products_reviews`
  ADD PRIMARY KEY (`reviewid`);

--
-- Indexes for table `rb_products_variants`
--
ALTER TABLE `rb_products_variants`
  ADD PRIMARY KEY (`variantid`);

--
-- Indexes for table `rb_products_views`
--
ALTER TABLE `rb_products_views`
  ADD PRIMARY KEY (`viewid`);

--
-- Indexes for table `rb_purchases`
--
ALTER TABLE `rb_purchases`
  ADD PRIMARY KEY (`purchaseid`),
  ADD UNIQUE KEY `refno_value` (`refno_value`);

--
-- Indexes for table `rb_purchases_temp`
--
ALTER TABLE `rb_purchases_temp`
  ADD PRIMARY KEY (`tempid`);

--
-- Indexes for table `rb_registrations`
--
ALTER TABLE `rb_registrations`
  ADD PRIMARY KEY (`regid`);

--
-- Indexes for table `rb_sliders`
--
ALTER TABLE `rb_sliders`
  ADD PRIMARY KEY (`sliderid`);

--
-- Indexes for table `rb_subcategories`
--
ALTER TABLE `rb_subcategories`
  ADD PRIMARY KEY (`subcategoryid`);

--
-- Indexes for table `rb_testimonials`
--
ALTER TABLE `rb_testimonials`
  ADD PRIMARY KEY (`testimonialid`);

--
-- Indexes for table `rb_users`
--
ALTER TABLE `rb_users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `rb_views`
--
ALTER TABLE `rb_views`
  ADD PRIMARY KEY (`viewid`);

--
-- Indexes for table `rb_wishlist`
--
ALTER TABLE `rb_wishlist`
  ADD PRIMARY KEY (`wishlistid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mlm_challenges`
--
ALTER TABLE `mlm_challenges`
  MODIFY `challengeid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_challenges_history`
--
ALTER TABLE `mlm_challenges_history`
  MODIFY `historyid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_config`
--
ALTER TABLE `mlm_config`
  MODIFY `configid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mlm_enquiries`
--
ALTER TABLE `mlm_enquiries`
  MODIFY `enquiryid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_enquiries_replies`
--
ALTER TABLE `mlm_enquiries_replies`
  MODIFY `replyid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_ewallet`
--
ALTER TABLE `mlm_ewallet`
  MODIFY `ewalletid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_logdetail`
--
ALTER TABLE `mlm_logdetail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mlm_logdetail_frontend`
--
ALTER TABLE `mlm_logdetail_frontend`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_plans`
--
ALTER TABLE `mlm_plans`
  MODIFY `planid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mlm_registrations`
--
ALTER TABLE `mlm_registrations`
  MODIFY `regid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mlm_registrations_history`
--
ALTER TABLE `mlm_registrations_history`
  MODIFY `historyid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_rewards`
--
ALTER TABLE `mlm_rewards`
  MODIFY `rewardid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mlm_transactions`
--
ALTER TABLE `mlm_transactions`
  MODIFY `transactionid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlm_users`
--
ALTER TABLE `mlm_users`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rb_badlinks`
--
ALTER TABLE `rb_badlinks`
  MODIFY `badlinkid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_cart`
--
ALTER TABLE `rb_cart`
  MODIFY `cartid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_categories`
--
ALTER TABLE `rb_categories`
  MODIFY `categoryid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rb_config`
--
ALTER TABLE `rb_config`
  MODIFY `configid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rb_coupons`
--
ALTER TABLE `rb_coupons`
  MODIFY `couponid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_dynamic_pages`
--
ALTER TABLE `rb_dynamic_pages`
  MODIFY `pageid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_dynamic_records`
--
ALTER TABLE `rb_dynamic_records`
  MODIFY `recordid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_enquiries`
--
ALTER TABLE `rb_enquiries`
  MODIFY `enquiryid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_faqs`
--
ALTER TABLE `rb_faqs`
  MODIFY `faqid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_logdetail`
--
ALTER TABLE `rb_logdetail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rb_logdetail_frontend`
--
ALTER TABLE `rb_logdetail_frontend`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rb_media`
--
ALTER TABLE `rb_media`
  MODIFY `mediaid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_newsletters`
--
ALTER TABLE `rb_newsletters`
  MODIFY `newsletterid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_pages`
--
ALTER TABLE `rb_pages`
  MODIFY `pageid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rb_products`
--
ALTER TABLE `rb_products`
  MODIFY `productid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rb_products_reviews`
--
ALTER TABLE `rb_products_reviews`
  MODIFY `reviewid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_products_variants`
--
ALTER TABLE `rb_products_variants`
  MODIFY `variantid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rb_products_views`
--
ALTER TABLE `rb_products_views`
  MODIFY `viewid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_purchases`
--
ALTER TABLE `rb_purchases`
  MODIFY `purchaseid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_purchases_temp`
--
ALTER TABLE `rb_purchases_temp`
  MODIFY `tempid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_registrations`
--
ALTER TABLE `rb_registrations`
  MODIFY `regid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rb_sliders`
--
ALTER TABLE `rb_sliders`
  MODIFY `sliderid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_subcategories`
--
ALTER TABLE `rb_subcategories`
  MODIFY `subcategoryid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_testimonials`
--
ALTER TABLE `rb_testimonials`
  MODIFY `testimonialid` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_users`
--
ALTER TABLE `rb_users`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rb_views`
--
ALTER TABLE `rb_views`
  MODIFY `viewid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rb_wishlist`
--
ALTER TABLE `rb_wishlist`
  MODIFY `wishlistid` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
