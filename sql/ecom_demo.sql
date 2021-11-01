-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2020 at 01:23 PM
-- Server version: 5.7.30-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `otp_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otp_expiry_time` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `app_id`, `role_id`, `first_name`, `last_name`, `email`, `mobile`, `password`, `otp_code`, `otp_expiry_time`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(1, NULL, 1, 'varun', 'raja', 'varun@lucsoninfotech.com', '9924400799', 'TVdlcTdLWGhRb01rTDVUZVF4NTQ5QT09', 'FQZNTAmMoaOeww6QL6EU', '2018-02-19 14:36:13', NULL, NULL, '2017-11-30 11:11:16', '2017-11-30 11:11:16', 1),
(2, 1, 2, 'Admin', 'A', 'admin@admin.com', '9773179968', 'TVdlcTdLWGhRb01rTDVUZVF4NTQ5QT09', NULL, NULL, 1, 1, '2018-02-23 15:01:26', '2018-02-23 15:01:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL,
  `sms_username` varchar(264) NOT NULL,
  `sms_password` varchar(264) NOT NULL,
  `sms_sender_id` varchar(264) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `sms_username`, `sms_password`, `sms_sender_id`, `updated_at`) VALUES
(1, 'varun', 'varun123', 'LIECOM', '2018-01-17 16:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `app_details`
--

CREATE TABLE `app_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(11) UNSIGNED NOT NULL,
  `app_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `app_tagline` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `logo_top` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `logo_center` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `logo_bottom` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `logo_favicon` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_1` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_2` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email_1` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `email_2` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `website_url` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `city_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `state_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `country_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `pincode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_url` text COLLATE utf8_unicode_ci NOT NULL,
  `twitter_url` text COLLATE utf8_unicode_ci NOT NULL,
  `google_plus` text COLLATE utf8_unicode_ci NOT NULL,
  `instagram_url` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '1 = Active, 0 = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_details`
--

INSERT INTO `app_details` (`id`, `app_id`, `app_name`, `app_tagline`, `logo_top`, `logo_center`, `logo_bottom`, `logo_favicon`, `mobile_1`, `mobile_2`, `email_1`, `email_2`, `website_url`, `address`, `city_id`, `city_name`, `state_id`, `state_name`, `country_id`, `country_name`, `pincode`, `facebook_url`, `twitter_url`, `google_plus`, `instagram_url`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 'Attitude Boutique', '', '', '', '', '', '8160016956', '', 'nyu212@yahoo.in', '', '', 'Jamnagar', 25, 'Jamnagar', 12, 'Gujarat', 99, 'India', '361001', '', '', '', '', '0000-00-00 00:00:00', '2018-02-24 11:11:42', 1),
(2, 1, 'Lucson eStore', '', '1580285459-1613.png', '1580285614-2490.png', '1580285620-5740.png', '1580203341-5599.png', '+91-9586097237', '08049672731', 'varun@lucsoninfotech.com', 'varun@lucsoninfotech.com', 'http://www.lucsoninfotech.co.in', '403, Cosmo Complex, Kalawad Road Near Under Bridge, Near Under Bridge, Dhebar Road, Rajkot, Gujarat, India - 360005', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', '360005', 'https://www.facebook.com', 'https://twitter.com', 'https://www.google.com', 'https://www.instagram.com', '0000-00-00 00:00:00', '2020-01-29 13:43:40', 1),
(3, 3, 'Davda Tradelink', '', '', '', '', '', '9426431305', '', '', '', '', 'Rajkot', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', '360001', '', '', '', '', '0000-00-00 00:00:00', '2018-02-28 17:06:10', 1),
(4, 4, 'Swastik & Solanki', '', '', '', '', '', '9879211948', '', '', '', '', 'Rajkot', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', '360001', '', '', '', '', '0000-00-00 00:00:00', '2018-02-28 17:13:57', 1),
(5, 5, 'Vinayak Jewellers', '', '', '', '', '', '9574109573', '', '', '', '', 'Rajkot', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', '360001', '', '', '', '', '0000-00-00 00:00:00', '2018-02-28 17:23:55', 1),
(6, 6, 'Gurukrupa Enterprise', '', '', '', '', '', '9310897108', '', '', '', '', 'Rajkot', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', '360001', '', '', '', '', '0000-00-00 00:00:00', '2018-02-28 17:24:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_display_options`
--

CREATE TABLE `app_display_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `categories_menu` varchar(264) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_display_options`
--

INSERT INTO `app_display_options` (`id`, `app_id`, `categories_menu`, `updated_at`) VALUES
(1, 1, '', '0000-00-00 00:00:00'),
(2, 2, '', '2018-02-24 11:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `app_info`
--

CREATE TABLE `app_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `about_us` text COLLATE utf8_unicode_ci NOT NULL,
  `privacy_policy` text COLLATE utf8_unicode_ci NOT NULL,
  `terms_conditions` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_info`
--

INSERT INTO `app_info` (`id`, `app_id`, `about_us`, `privacy_policy`, `terms_conditions`) VALUES
(1, 2, '<p><span style=\"text-align: center;\">We believe everyone deserves to have a website or online store. Innovation and simplicity makes us happy: our goal is to remove any technical or financial barriers that can prevent business owners from making their own website. We\'re excited to help you on your journey!</span><br></p>', '<p><span style=\"color: rgb(34, 34, 34); font-family: sans-serif; font-size: 14px;\">A&nbsp;</span><b style=\"color: rgb(34, 34, 34); font-family: sans-serif; font-size: 14px;\">privacy policy</b><span style=\"color: rgb(34, 34, 34); font-family: sans-serif; font-size: 14px;\">&nbsp;is a statement or a legal document (in&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Privacy_law\" title=\"Privacy law\" style=\"color: rgb(11, 0, 128); background: none rgb(255, 255, 255); font-family: sans-serif; font-size: 14px;\">privacy law</a><font color=\"#222222\" face=\"sans-serif\"><span style=\"font-size: 14px;\">) that discloses some or all of the ways a party gathers, uses, discloses, and manages a customer or client\'s data. It fulfils&nbsp;a legal requirement to protect a customer or client\'s&nbsp;</span></font><a href=\"https://en.wikipedia.org/wiki/Privacy\" title=\"Privacy\" style=\"color: rgb(11, 0, 128); background: none rgb(255, 255, 255); font-family: sans-serif; font-size: 14px;\">privacy</a><span style=\"color: rgb(34, 34, 34); font-family: sans-serif; font-size: 14px;\">.&nbsp;</span><a href=\"https://en.wikipedia.org/wiki/Personally_identifiable_information\" title=\"Personally identifiable information\" style=\"color: rgb(11, 0, 128); background: none rgb(255, 255, 255); font-family: sans-serif; font-size: 14px;\">Personal information</a><span style=\"color: rgb(34, 34, 34); font-family: sans-serif; font-size: 14px;\">&nbsp;can be anything that can be used to identify an individual, not limited to the person\'s name, address, date of birth, marital status, contact information, ID issue and expiry date, financial records, credit information, medical history, where one travels, and intentions to acquire goods and services.</span><br></p>', '<p><b style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 16px;\">Terms and Conditions</b><span style=\"color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 16px;\">&nbsp;are a set of rules and guidelines that a user must agree to in order to use your website or mobile app. It acts as a legal contract between you (the company) who has the website or mobile app and the user who access your website and mobile app.</span><br></p>'),
(2, 1, '<p><span style=\"font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br></p>', '<p><span style=\"font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br></p>', '<p><span style=\"font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br></p>'),
(3, 3, '<p>About Us</p>', '<p>Privacy Policy</p>', '<p>Terms &amp; Conditions</p>'),
(4, 4, '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">About Us</span><br></p>', '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Privacy Policy</span><br></p>', '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Terms &amp; Conditions</span><br></p>'),
(5, 5, '<p>About Us<br></p>', '<p>Privacy Policy<br></p>', '<p>Terms &amp; Conditions<br></p>'),
(6, 6, '<p><span style=\'color: rgb(0, 0, 0); font-family: \"Open Sans\", Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\'>About Us</span><b></b><i></i><u></u><sub></sub><sup></sup><strike></strike><br></p>', '<p><span style=\'color: rgb(0, 0, 0); font-family: \"Open Sans\", Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\'>Privacy Policy</span><b></b><i></i><u></u><sub></sub><sup></sup><strike></strike><br></p>', '<p><span style=\'color: rgb(0, 0, 0); font-family: \"Open Sans\", Helvetica, Arial, sans-serif; font-size: 13px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\'>Terms &amp; Conditions</span><b></b><i></i><u></u><sub></sub><sup></sup><strike></strike><br></p>');

-- --------------------------------------------------------

--
-- Table structure for table `app_maintenance`
--

CREATE TABLE `app_maintenance` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `website` tinyint(3) UNSIGNED NOT NULL,
  `web_updated_at` datetime DEFAULT NULL,
  `application` tinyint(3) UNSIGNED NOT NULL,
  `app_updated_at` datetime DEFAULT NULL,
  `admin_panel` tinyint(3) UNSIGNED NOT NULL,
  `admin_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_maintenance`
--

INSERT INTO `app_maintenance` (`id`, `app_id`, `website`, `web_updated_at`, `application`, `app_updated_at`, `admin_panel`, `admin_updated_at`) VALUES
(1, 2, 1, '2018-02-24 11:10:55', 1, '2018-02-24 11:10:55', 1, '2018-02-24 11:10:55'),
(2, 1, 1, '2018-02-24 11:20:04', 1, '2018-02-24 11:20:04', 1, '2018-02-24 11:20:04'),
(3, 3, 1, '2018-02-28 17:03:56', 1, '2018-02-28 17:03:56', 1, '2018-02-28 17:03:56'),
(4, 4, 1, '2018-02-28 17:04:02', 1, '2018-02-28 17:04:02', 1, '2018-02-28 17:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `customer_account_verification` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Disabled, 1 = Enabled',
  `order_tracking` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Disabled, 1 = Enabled',
  `inhouse_delivery_tracking` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Disabled, 1 = Enabled',
  `available_payment_mode` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '0 - Online Payment, 1 = Cash on delivery',
  `available_payment_sub` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payment Sub : Cash on delivery : 0 - By Cash, 1 = By Paytm, 2 = By Card swipe',
  `sms_username` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `sms_password` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `can_create_customer_backend` tinyint(1) NOT NULL DEFAULT '0',
  `premium_normal_customer` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = No, 1 = Prem/Normal Customer FIlter Applied',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `app_id`, `customer_account_verification`, `order_tracking`, `inhouse_delivery_tracking`, `available_payment_mode`, `available_payment_sub`, `sms_username`, `sms_password`, `can_create_customer_backend`, `premium_normal_customer`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '1', '0,1,2', '', '', 1, 1, '2018-03-12 15:01:55'),
(2, 2, 1, 1, 1, '1', '0,1,2', '', '', 1, 1, '2018-03-12 12:43:37'),
(3, 3, 1, 1, 1, '1', '0,1,2', '', '', 0, 0, '2018-02-28 16:41:27'),
(4, 4, 1, 1, 1, '1', '0,1,2', '', '', 0, 0, '2018-02-28 16:41:38'),
(5, 5, 1, 1, 1, '1', '0,1,2', '', '', 1, 0, '2018-03-06 17:56:01'),
(6, 6, 1, 1, 1, '1', '0,1,2', '', '', 0, 0, '2018-02-28 16:42:03');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `banner_name` varchar(264) NOT NULL,
  `file_name` varchar(264) NOT NULL,
  `display_order` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `app_id`, `banner_name`, `file_name`, `display_order`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 'Cosmetic Makeup', '1519450517-1465.jpg', 0, '2018-02-24 11:05:17', '2018-02-24 11:06:20', 1),
(2, 2, 'CosmeticCollection', '1519450552-1294.jpg', 0, '2018-02-24 11:05:52', '2018-02-24 11:05:52', 1),
(9, 3, '', '1519879932-8644.jpg', 0, '2018-03-01 10:22:12', '2018-03-01 10:22:12', 1),
(10, 3, '', '1519879947-9316.jpg', 0, '2018-03-01 10:22:27', '2018-03-01 10:22:27', 1),
(11, 3, '', '1519879950-3622.jpg', 0, '2018-03-01 10:22:30', '2018-03-01 10:22:30', 1),
(12, 4, '', '1519887277-9467.jpg', 0, '2018-03-01 12:24:37', '2018-03-01 12:24:37', 1),
(13, 4, '', '1519887284-2809.jpg', 0, '2018-03-01 12:24:44', '2018-03-01 12:24:44', 1),
(14, 4, '', '1519887290-2838.jpg', 0, '2018-03-01 12:24:50', '2018-03-01 12:24:50', 1),
(15, 4, '', '1519887297-1565.jpg', 0, '2018-03-01 12:24:57', '2018-03-01 12:24:57', 1),
(16, 5, '', '1519891614-9868.jpg', 0, '2018-03-01 13:36:54', '2018-03-01 13:36:54', 1),
(17, 5, '', '1519891624-1955.jpg', 0, '2018-03-01 13:37:04', '2018-03-01 13:37:04', 1),
(18, 5, '', '1519891634-7839.png', 0, '2018-03-01 13:37:14', '2018-03-01 13:37:14', 1),
(19, 6, '', '1519892812-8104.jpg', 0, '2018-03-01 13:56:52', '2018-03-01 13:56:52', 1),
(20, 6, '', '1519892825-2652.jpg', 0, '2018-03-01 13:57:05', '2018-03-01 13:57:05', 1),
(21, 6, '', '1519892834-5446.jpg', 0, '2018-03-01 13:57:14', '2018-03-01 13:57:14', 1),
(22, 4, 'test', '1520241128-8895.jpg', 0, '2018-03-05 14:42:08', '2018-03-05 14:42:08', 1),
(23, 1, 'Happy Clients', '1580286850-8425.jpg', 0, '2020-01-29 14:04:10', '2020-01-29 14:04:10', 1),
(24, 1, 'Lowest Price Ever', '1580286917-4979.jpg', 0, '2020-01-29 14:05:17', '2020-01-29 14:05:17', 1),
(25, 1, 'Premium', '1580286939-6404.png', 0, '2020-01-29 14:05:39', '2020-01-29 14:05:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(11) UNSIGNED NOT NULL,
  `brand_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `app_id`, `brand_name`, `file_name`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 'Huda', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(2, 2, 'Generic', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(3, 2, 'Swiss Beauty', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(4, 2, 'Arjun Cosmetic', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(5, 2, 'Maybelline', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(6, 2, 'Shoecom', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(7, 2, 'Swiss', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(8, 2, 'ADS', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(9, 2, 'Kylie Cosmetics', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(10, 2, 'Girraj Makeup World', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(11, 2, 'Fully', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(12, 2, 'SHOPEE', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(13, 2, 'Steel Paris', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(14, 2, 'Hilary Rhoda', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(15, 2, 'HR', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(16, 2, 'AV', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(17, 2, 'HUDA BEAUTY', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(18, 1, 'Highlander', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(19, 1, 'TSX', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(20, 1, 'Peter England', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(21, 1, 'Metronaut', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(22, 1, 'Uber Urban', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(23, 1, 'HalogenChinos', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(24, 1, 'Being Fab', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(25, 1, 'Urbano', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(26, 1, 'Attire4ever', '', '2018-02-24 17:12:30', '2018-02-24 17:12:30', 1),
(27, 1, 'Huda', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(28, 1, 'Generic', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(29, 1, 'Swiss Beauty', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(30, 1, 'Arjun Cosmetic', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(31, 1, 'Maybelline', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(32, 1, 'Shoecom', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(33, 1, 'Swiss', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(34, 1, 'ADS', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(35, 1, 'Kylie Cosmetics', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(36, 1, 'Girraj Makeup World', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(37, 1, 'Fully', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(38, 1, 'SHOPEE', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(39, 1, 'Steel Paris', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(40, 1, 'Hilary Rhoda', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(41, 1, 'HR', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(42, 1, 'AV', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(43, 1, 'HUDA BEAUTY', '', '2018-02-24 17:12:35', '2018-02-24 17:12:35', 1),
(44, 3, 'Brand One', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(45, 3, 'Brand Two', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(46, 3, 'Brand Three', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(47, 4, 'Brand One', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(48, 4, 'Brand Two', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(49, 4, 'Brand Three', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(50, 5, 'Brand One', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(51, 5, 'Brand Two', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(52, 5, 'Brand Three', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(53, 6, 'Brand One', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(54, 6, 'Brand Two', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(55, 6, 'Brand Three', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(56, 4, '-', '', '2018-03-05 20:54:55', '2018-03-05 20:54:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `category_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `app_id`, `parent_id`, `category_name`, `file_name`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 0, 'Makeup', '1519453613-5350.jpg', '2018-02-24 15:47:02', '2018-02-24 16:56:53', 1),
(3, 2, 1, 'LipSticks', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(4, 2, 1, 'Sponges & Blenders', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(5, 2, 1, 'Foundation', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(6, 2, 1, 'Primers', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(7, 2, 1, 'Blushes', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(8, 2, 1, 'Kajal & Kohls', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(9, 2, 1, 'Maskaras', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(10, 2, 1, 'Eye Shadow', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(12, 2, 1, 'SkinCare', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(13, 2, 1, 'Make-up Palettes', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(14, 2, 0, 'Hair Style', '1519454052-8202.jpg', '2018-02-24 15:47:02', '2018-02-24 17:04:12', 1),
(15, 2, 14, 'Hair Stylers', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(16, 2, 0, 'Nails', '1519453625-8228.jpg', '2018-02-24 15:47:02', '2018-02-24 16:57:05', 1),
(17, 2, 16, 'Paint Remover', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(18, 2, 1, 'Eyes Liners', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(19, 2, 1, 'Face', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(20, 2, 16, 'Nail Polish', '', '2018-02-24 15:47:02', '2018-02-24 15:47:02', 1),
(55, 3, NULL, 'One', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(56, 3, 55, 'Sub One', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(57, 3, 55, 'Sub Two', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(58, 3, NULL, 'Two', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(59, 3, 58, 'Sub Three', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(60, 3, NULL, 'Three', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(61, 3, 60, 'Sub Four', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(62, 3, NULL, 'Four', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(63, 3, 62, 'Sub Five', '', '2018-03-01 17:00:25', '2018-03-01 17:00:25', 1),
(64, 4, NULL, 'One', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(65, 4, 64, 'Sub One', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(66, 4, 64, 'Sub Two', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(67, 4, NULL, 'Two', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(68, 4, 67, 'Sub Three', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(69, 4, NULL, 'Three', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(70, 4, 69, 'Sub Four', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(71, 4, NULL, 'Four', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(72, 4, 71, 'Sub Five', '', '2018-03-01 17:25:52', '2018-03-01 17:25:52', 1),
(73, 5, NULL, 'One', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(74, 5, 73, 'Sub One', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(75, 5, 73, 'Sub Two', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(76, 5, NULL, 'Two', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(77, 5, 76, 'Sub Three', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(78, 5, NULL, 'Three', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(79, 5, 78, 'Sub Four', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(80, 5, NULL, 'Four', '', '2018-03-01 18:38:30', '2018-03-01 18:38:30', 1),
(81, 5, NULL, 'Sub Five', '', '2018-03-01 18:38:30', '2018-03-09 12:40:12', 1),
(82, 6, NULL, 'One', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(83, 6, 82, 'Sub One', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(84, 6, 82, 'Sub Two', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(85, 6, NULL, 'Two', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(86, 6, 85, 'Sub Three', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(87, 6, NULL, 'Three', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(88, 6, 87, 'Sub Four', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(89, 6, NULL, 'Four', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(90, 6, 89, 'Sub Five', '', '2018-03-01 18:57:51', '2018-03-01 18:57:51', 1),
(91, 4, NULL, 'RING', '', '2018-03-05 20:00:34', '2018-03-05 20:00:34', 1),
(92, 4, NULL, 'NECKLESS', '', '2018-03-05 20:50:32', '2018-03-05 20:50:32', 1),
(93, 1, NULL, 'Man', '1580288187-5721.jpg', '2020-01-29 14:19:26', '2020-01-29 14:26:27', 1),
(95, 1, NULL, 'Hand Bag', '1580289449-9136.jpg', '2020-01-29 14:29:59', '2020-01-29 14:47:29', 1),
(96, 1, NULL, 'Shoes', '1580289465-4553.jpg', '2020-01-29 14:30:41', '2020-01-29 14:47:45', 1),
(105, 1, NULL, 'Women', '1580295654-5341.jpg', '2020-01-29 16:30:54', '2020-01-29 16:30:54', 1),
(106, 1, 105, 'Top', '1580295672-4194.jpeg', '2020-01-29 16:31:12', '2020-01-29 16:31:12', 1),
(107, 1, 93, 'T-Shirt', '1580296244-3838.jpg', '2020-01-29 16:32:29', '2020-01-29 16:40:44', 1),
(108, 1, 93, 'Shirt', '1580296114-8647.jpg', '2020-01-29 16:34:11', '2020-01-29 16:38:34', 1),
(109, 1, 105, 'Kurti', '1580362605-4277.jpg', '2020-01-30 11:06:45', '2020-01-30 11:06:45', 1),
(110, 1, 105, 'Jeans', '1580363215-9826.jpg', '2020-01-30 11:16:55', '2020-01-30 11:16:55', 1),
(111, 1, 93, 'Jeans', '1580363727-9604.jpg', '2020-01-30 11:25:27', '2020-01-30 11:25:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `city_name` varchar(256) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `app_id`, `city_name`, `status`) VALUES
(1, 2, 'Jamnagar', 1),
(2, 1, 'Rajkot', 1),
(3, 3, 'Rajkot', 1),
(4, 6, 'Rajkot', 1),
(5, 5, 'Rajkot', 1),
(6, 4, 'Rajkot', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities_list`
--

CREATE TABLE `cities_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `city_name` varchar(264) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities_list`
--

INSERT INTO `cities_list` (`id`, `country_id`, `state_id`, `city_name`, `status`) VALUES
(1, 99, 12, 'Ahmadabad', 1),
(2, 99, 12, 'Amreli', 1),
(3, 99, 12, 'Anand', 1),
(4, 99, 12, 'Anjar', 1),
(5, 99, 12, 'Bardoli', 1),
(6, 99, 12, 'Bharuch', 1),
(7, 99, 12, 'Bhavnagar', 1),
(8, 99, 12, 'Bhuj', 1),
(9, 99, 12, 'Borsad', 1),
(10, 99, 12, 'Botad', 1),
(11, 99, 12, 'Chandkheda', 1),
(12, 99, 12, 'Chandlodiya', 1),
(13, 99, 12, 'Dabhoi', 1),
(14, 99, 12, 'Dahod', 1),
(15, 99, 12, 'Dholka', 1),
(16, 99, 12, 'Dhoraji', 1),
(17, 99, 12, 'Dhrangadhra', 1),
(18, 99, 12, 'Disa', 1),
(19, 99, 12, 'Gandhidham', 1),
(20, 99, 12, 'Gandhinagar', 1),
(21, 99, 12, 'Ghatlodiya', 1),
(22, 99, 12, 'Godhra', 1),
(23, 99, 12, 'Gondal', 1),
(24, 99, 12, 'Himatnagar', 1),
(25, 99, 12, 'Jamnagar', 1),
(26, 99, 12, 'Jamnagar', 1),
(27, 99, 12, 'Jetpur', 1),
(28, 99, 12, 'Junagadh', 1),
(29, 99, 12, 'Kalol', 1),
(30, 99, 12, 'Keshod', 1),
(31, 99, 12, 'Khambhat', 1),
(32, 99, 12, 'Kundla', 1),
(33, 99, 12, 'Mahuva', 1),
(34, 99, 12, 'Mangrol', 1),
(35, 99, 12, 'Modasa', 1),
(36, 99, 12, 'Morvi', 1),
(37, 99, 12, 'Nadiad', 1),
(38, 99, 12, 'Navagam Ghed', 1),
(39, 99, 12, 'Navsari', 1),
(40, 99, 12, 'Palitana', 1),
(41, 99, 12, 'Patan', 1),
(42, 99, 12, 'Porbandar', 1),
(43, 99, 12, 'Puna', 1),
(44, 99, 12, 'Rajkot', 1),
(45, 99, 12, 'Ramod', 1),
(46, 99, 12, 'Ranip', 1),
(47, 99, 12, 'Siddhapur', 1),
(48, 99, 12, 'Sihor', 1),
(49, 99, 12, 'Surat', 1),
(50, 99, 12, 'Surendranagar', 1),
(51, 99, 12, 'Thaltej', 1),
(52, 99, 12, 'Una', 1),
(53, 99, 12, 'Unjha', 1),
(54, 99, 12, 'Upleta', 1),
(55, 99, 12, 'Vadodara', 1),
(56, 99, 12, 'Valsad', 1),
(57, 99, 12, 'Vapi', 1),
(58, 99, 12, 'Vastral', 1),
(59, 99, 12, 'Vejalpur', 1),
(60, 99, 12, 'Veraval', 1),
(61, 99, 12, 'Vijalpor', 1),
(62, 99, 12, 'Visnagar', 1),
(63, 99, 12, 'Wadhwan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `country_name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso`, `country_name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `customer_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 - Normal User, 1 = Premium User',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(264) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = Not Added, 1 = Male, 2 = Female, 3 = Other',
  `fb_login` tinyint(4) NOT NULL DEFAULT '0',
  `google_login` tinyint(4) NOT NULL DEFAULT '0',
  `auth_token` varchar(264) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_verified` tinyint(4) DEFAULT NULL,
  `otp_code` varchar(264) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otp_expiry_time` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active, 2 = Blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `app_id`, `customer_type`, `user_name`, `first_name`, `last_name`, `email`, `mobile`, `password`, `file_name`, `gender`, `fb_login`, `google_login`, `auth_token`, `account_verified`, `otp_code`, `otp_expiry_time`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 0, '9924400799', 'Shirish', 'Makwana', 'shirishm.makwana@gmail.com', '9924400799', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, 'jX4RBQ0aD8Gx5flLUd0X', 1, NULL, NULL, '2018-02-24 11:25:18', '2018-02-24 11:25:42', 1),
(2, 1, 1, '9924400799', 'Shirish', 'Makwana', 'shirishm.makwana@gmail.com', '9924400799', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, '0zNDDm15v5b70F8n16wk', 1, '8470', '2018-03-12 14:16:06', '2018-02-24 13:52:34', '2018-03-12 12:16:06', 1),
(3, 1, 0, '9033782878', 'Amit', 'ParmaR', 'amitparmar111@gmail.com', '9033782878', 'SGdxZWgxcExyTTF2Wlc5WERlcUxmQT09', '', 0, 0, 0, 'fyB27FhqHYoz1gkZXeoP', 1, NULL, NULL, '2018-02-28 15:27:04', '2018-02-28 15:27:20', 1),
(4, 3, 0, '9924400799', 'Shirish', 'Makwana', 'shirishm.makwana@gmail.com', '9924400799', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, 'qTREHvfC3EDcaMMui7wu', 1, NULL, NULL, '2018-03-01 12:06:05', '2018-03-01 12:06:21', 1),
(5, 4, 0, '9924400799', 'Shirish', 'Makwana', 'shirish.makwana@gmail.com', '9924400799', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, 'CMNhNWx253MZnGmCABu3', 1, NULL, NULL, '2018-03-01 12:29:09', '2018-03-01 12:31:04', 1),
(6, 4, 0, 'bhaveshchouhan', 'Bhavesh', 'Chouhan', 'jalaramcwa@gmail.com', '', 'amRCLzI1ckJacXVWTEs1N29YMEhFQT09', '1519889234-8760.jpg', 1, 1, 1, '2Sr59smhOYmScmOLQ8f0', 1, '5961', '2018-03-01 18:28:32', '2018-03-01 12:39:46', '2018-03-06 11:24:24', 1),
(7, 4, 0, '9876543210', 'nja', 'poi', 'jj@gmail.com', '9876543210', 'V1RsMzNSdDg5Yy8xS0lIbWlkTjhRZz09', '', 0, 0, 0, 'wrOHyV5CDJ49XMRFlnRG', 1, NULL, NULL, '2018-03-01 12:41:22', '2018-03-01 12:43:13', 1),
(8, 5, 0, '9924400799', 'Shirish', 'Makwana', 'shirishm.makwana@gmail.com', '9924400799', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, '6xSkbo4LOul3e5kybm3M', 1, NULL, NULL, '2018-03-01 13:42:20', '2018-03-01 13:56:42', 1),
(10, 4, 0, '9033782878', 'Amit', 'Parmar', 'amitparmar111@gmail.com', '9033782878', 'SGdxZWgxcExyTTF2Wlc5WERlcUxmQT09', '', 0, 0, 0, 'GD3VJuKiGto08517s9Nz', 1, NULL, NULL, '2018-03-01 14:42:59', '2018-03-01 14:43:25', 1),
(11, 2, 0, '8140864643', 'Henna', 'Patodiya', 'hhina1990@gmail.com', '8140864643', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, 'gneN6mbQR0pJoVsKsXJP', 1, NULL, NULL, '2018-03-01 17:25:33', '2018-03-01 17:27:13', 1),
(12, 4, 0, 'PiyushSolanki', 'Piyush', 'Solanki', 'guddu_me2@yahoo.co.uk', '', 'YkpmeXovc3RCY1hmTTRKblRvdDlpQT09', '', 1, 1, 0, 'iWJBQrng3srZEOyfYHAA', 1, NULL, NULL, '2018-03-03 11:12:38', '2018-03-03 11:12:38', 1),
(13, 4, 0, 'DGVaghela', 'DG', 'Vaghela', 'dharamdevsinhvaghela7@yahoo.com', '', 'c1JXcDVpeVppUFpSb0F1Q2dXa1NwZz09', '', 1, 1, 0, 'TgxWhJvZkAATiEAgJFIT', 1, NULL, NULL, '2018-03-03 13:59:55', '2018-03-03 13:59:55', 1),
(14, 3, 0, '8140864643', 'Henna', 'Patodiya', 'hhina1990@gmail.com', '8140864643', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, 'TiRymHuNfJoR3XDXJkWT', 1, NULL, NULL, '2018-03-05 14:35:45', '2018-03-05 14:36:22', 1),
(15, 4, 0, '9979798198', 'test', 'test', 'dharamdevvaghela@gmail.com', '9979798198', 'cU1STWNuN0dCcmVRNlRvN2p1eGptUT09', '', 0, 0, 0, 'brpmBQs1AQ88cizHCH79', 1, NULL, NULL, '2018-03-05 14:52:29', '2018-03-05 14:53:15', 1),
(16, 4, 0, '9913648556', 'vaibhav', 'kapdi', 'vaibhavkapdi40@gmail.com', '9913648556', 'cU1STWNuN0dCcmVRNlRvN2p1eGptUT09', '', 0, 0, 0, 'TH5xWmvraNH292PI6i0a', 0, '8195', '2018-03-05 18:08:33', '2018-03-05 16:08:33', '2018-03-05 16:08:33', 1),
(17, 4, 0, '9924517114', 'harshad', 'patel', 'harshadpatel79@gmail.com', '9924517114', 'WnpkN3hveXpvMEdJdGd4SzI5QTByQT09', '', 0, 0, 0, 'a09bGeyxP44ZXHiVwrfC', 1, NULL, NULL, '2018-03-05 19:45:03', '2018-03-05 19:45:19', 1),
(18, 2, 0, 'BhaveshChouhan', 'Bhavesh', 'Chouhan', 'bhavesh.lucsoninfotech@gmail.com', '', 'd211NHJXQWpZMitZSmJBWlZ0bnNYdz09', '', 0, 1, 1, 'MrQNPqGigTmC5TxUPmnk', 1, NULL, NULL, '2018-03-06 11:04:22', '2018-03-06 11:05:02', 1),
(19, 2, 0, 'AmitParmar', 'Amit', 'Parmar', 'amitparmar111@gmail.com', '', 'N2Q4UkFJMnJVOTdBTGtIYzByVGN1UT09', '', 1, 1, 0, 'APirViIkEDLcg5Mx6Q7d', 1, NULL, NULL, '2018-03-06 12:01:57', '2018-03-06 12:01:57', 1),
(20, 2, 0, '9096164132', 'swap', 'king', 'swapnil.lucsoninfotech@gmail.com', '9096164132', 'UEozOVdSTk1kZXdaQU1sZXBWQ29ZUT09', '', 0, 0, 0, 'zyEjju3N12LXWhVyafxo', 0, NULL, NULL, '2018-03-06 13:40:16', '2018-03-06 13:52:44', 1),
(21, 2, 1, 'SwapnilKinage', 'Swapnil', 'Kinage', 'swapnilkinage@gmail.com', '1234567890', 'UWJ1eFhvdWtkMmU4M05HUVJCN0RLdz09', '', 1, 1, 0, 'bKIAuW2G1LZt3YW49Jcp', 1, NULL, NULL, '2018-03-06 13:45:07', '2018-03-12 14:10:38', 1),
(22, 5, 0, '9898989898', 'Henna', 'Patodiya', 'henna@gmail.com', '9898989898', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, 'bIlinh5wNadK4awn2Qdy', 1, '4323', '2018-03-06 17:15:56', '2018-03-06 15:15:56', '2018-03-06 15:15:56', 1),
(23, 2, 1, '1234567899', 'Viral', 'Gohel', 'viralgohel@gmail.com', '1234567899', 'WHhIdklmcEp4dDNhclpjR0JkMWVNQT09', '', 0, 0, 0, 'Ym4xEWV8jhj58O1akIBC', 1, '9983', '2018-03-12 14:47:39', '2018-03-12 12:47:39', '2018-03-12 12:47:39', 1),
(24, 1, 0, 'viralgohel', 'viral', 'gohel', 'viralgohel88@gmail.com', '2012673412', 'em5jK2xpdjhQOUxTbSs1dlV4RTkxQT09', NULL, 0, 0, 0, NULL, NULL, NULL, NULL, '2020-01-29 17:05:11', '2020-01-29 11:37:48', 1),
(25, 1, 0, 'Prembharai', 'Prem', 'Bharai', 'codermitali101@gmail.com', '8160390982', 'em5jK2xpdjhQOUxTbSs1dlV4RTkxQT09', '1580298177-5669.jpg', 1, 0, 0, NULL, NULL, NULL, NULL, '2020-01-29 17:08:19', '2020-01-29 17:13:55', 1),
(26, 1, 0, '9638181757', 'viral', 'gohel', 'viralgohel8@gmail.com', '9638181757', 'em5jK2xpdjhQOUxTbSs1dlV4RTkxQT09', '', 1, 0, 0, '1ZUR33M4tXydkVF3Fnwb', 1, NULL, NULL, '2020-02-08 12:04:54', '2020-02-08 12:23:56', 1),
(27, 1, 0, '09586097237', 'varun', 'raja', 'varun@lucsoninfotech.com', '09586097237', 'RFlRQ0ZTR0VWMzZsbWVCMFNzdmd5QT09', NULL, 0, 0, 0, 'lL2iAFUxNDa2pjgZKRm1', 1, '9969', '2020-02-17 13:22:02', '2020-02-17 11:22:02', '2020-02-17 11:22:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers_address`
--

CREATE TABLE `customers_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `address_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `city_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `state_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `country_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `landmark` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `pincode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double(10,2) DEFAULT NULL,
  `longitude` double(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers_address`
--

INSERT INTO `customers_address` (`id`, `app_id`, `customer_id`, `address_name`, `first_name`, `last_name`, `email`, `mobile`, `address`, `city_id`, `city_name`, `state_id`, `state_name`, `country_id`, `country_name`, `landmark`, `pincode`, `latitude`, `longitude`, `created_at`, `updated_date`, `status`) VALUES
(1, 1, 3, 'dhdh', 'dgdg', 'gfd', 'dhdh@gmail.com', '9876543210', 'egfhfbf', 3, 'Anand', 12, 'Gujarat', 99, 'India', 'dhdjjd', '45678', 0.00, 0.00, '2018-03-01 12:46:17', '2018-03-01 12:46:17', 1),
(3, 4, 10, 'office', 'amit', 'parmar', 'amit@gmail.com', '9033782878', 'aaaakaakakak', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', 'nfjfkdk', '362000', 0.00, 0.00, '2018-03-01 15:54:29', '2018-03-01 15:54:29', 1),
(4, 4, 15, 'bajrangwadi', 'dharamdev', 'vaghela', 'dharamdevvaghela@gmail.com', '9979798198', 'bajrabgwadi rajkot', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', 'pani ni taki', '360001', 0.00, 0.00, '2018-03-05 15:22:53', '2018-03-05 15:22:53', 1),
(5, 2, 11, 'Office', 'Henna', 'Patodiya', 'test@gmail.com', '1234567890', '338,\n3rd floor,\nRoyal complex,\nDebar road', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', 'Near bhutkhana chowk', '360001', 0.00, 0.00, '2018-03-05 15:51:21', '2018-03-05 15:51:21', 1),
(6, 3, 14, 'Office', 'Henna', 'Patodiya', 'teast@gmail.com', '1236547895', '\nRoyal complex,\nDebar Road', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', 'near bhutkhana chowk', '360001', 0.00, 0.00, '2018-03-05 15:56:05', '2018-03-05 15:56:05', 1),
(7, 1, 25, 'Prembharai', 'Prem', 'Bharai', 'codermitali101@gmail.com', '1234567981', '1108- Benz Square, Tripal Road Rajkot', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', 'Rajkot', '360004', NULL, NULL, '2020-01-29 17:15:39', '2020-01-29 17:24:09', 1),
(8, 1, 27, '338 Royal Complex', 'varun', 'raja', 'varun@lucsoninfotech.com', '9586097237', 'royal complex', 44, 'Rajkot', 12, 'Gujarat', 99, 'India', 'bhutkhana chowk', '360001', NULL, NULL, '2020-02-17 11:23:46', '2020-02-17 11:23:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers_cart`
--

CREATE TABLE `customers_cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers_cart`
--

INSERT INTO `customers_cart` (`id`, `app_id`, `customer_id`, `product_id`, `variant_id`, `quantity`, `created_at`) VALUES
(1, 1, 2, 84, 84, 1, '2018-02-24 14:04:15'),
(19, 1, 3, 84, 84, 1, '2018-03-01 10:53:41'),
(22, 3, 4, 111, 112, 1, '2018-03-01 13:35:08'),
(27, 3, 14, 111, 112, 1, '2018-03-05 14:36:37'),
(32, 2, 11, 10, 10, 1, '2018-03-05 18:45:40'),
(33, 4, 6, 126, 127, 1, '2018-03-06 12:54:30'),
(34, 1, 0, 165, 167, 10, '2020-01-29 16:59:33'),
(37, 1, 0, 164, 166, 2, '2020-01-29 18:49:37'),
(38, 1, 0, 163, 165, 2, '2020-01-30 09:53:32'),
(39, 1, 25, 163, 165, 1, '2020-01-30 09:53:59'),
(40, 1, 0, 169, 168, 1, '2020-01-30 13:01:17'),
(41, 1, 26, 171, 1, 10, '2020-02-08 12:38:40'),
(42, 1, 0, 171, 170, 1, '2020-02-17 11:21:19'),
(43, 1, 0, 170, 169, 3, '2020-05-28 12:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `customers_wishlist`
--

CREATE TABLE `customers_wishlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED NOT NULL,
  `offer_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers_wishlist`
--

INSERT INTO `customers_wishlist` (`id`, `app_id`, `customer_id`, `product_id`, `variant_id`, `offer_id`, `created_at`) VALUES
(1, 6, 9, 156, 157, NULL, '2018-03-01 14:48:36'),
(2, 3, 14, 108, 109, NULL, '2018-03-05 14:48:37'),
(3, 1, 0, 162, 164, NULL, '2020-01-29 15:07:59'),
(4, 1, 25, 165, 167, NULL, '2020-01-29 17:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_settings`
--

CREATE TABLE `dashboard_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `display_type` tinyint(3) UNSIGNED NOT NULL,
  `display_value` text COLLATE utf8_unicode_ci NOT NULL,
  `display_order` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dashboard_settings`
--

INSERT INTO `dashboard_settings` (`id`, `app_id`, `display_type`, `display_value`, `display_order`) VALUES
(1, 2, 1, '30,34,20', 0),
(2, 2, 3, '27,1,24,28', 0),
(13, 3, 1, '112,98,110', 0),
(14, 4, 1, '127,114,123,120', 0),
(15, 5, 1, '142,131,136,128', 0),
(16, 6, 1, '157,143,153,151', 0),
(19, 1, 1, '171,165', 0),
(20, 1, 3, '166,165,167,171', 0),
(21, 1, 2, '1581934543-5717.jpeg:169', 0),
(22, 1, 1, '169,163', 0),
(24, 1, 4, '1582258368-2588.png:107', 0);

-- --------------------------------------------------------

--
-- Table structure for table `devices_customer`
--

CREATE TABLE `devices_customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `device_id` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `notif_id` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `device_type` tinyint(3) UNSIGNED NOT NULL COMMENT '1 = iOs, 2 = Android',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gst_slabs`
--

CREATE TABLE `gst_slabs` (
  `id` int(10) UNSIGNED NOT NULL,
  `gst_percentage` double(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gst_slabs`
--

INSERT INTO `gst_slabs` (`id`, `gst_percentage`) VALUES
(1, 0.00),
(2, 5.00),
(3, 12.00),
(4, 18.00),
(5, 28.00);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Website, 1 = Application',
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(11) UNSIGNED NOT NULL,
  `email` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `order_from` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '0 = App, 1 = From Admin Panel',
  `customer_id` int(10) UNSIGNED NOT NULL,
  `order_number` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `payment_mode` tinyint(4) UNSIGNED NOT NULL COMMENT 'Payment Mode : 0 - Online Payment, 1 = Cash on delivery',
  `payment_sub` tinyint(4) UNSIGNED NOT NULL COMMENT 'Payment Sub : Cash on delivery : 0 - By Cash, 1 = By Paytm, 2 = By Card swipe',
  `address_id` int(10) UNSIGNED NOT NULL,
  `price_raw` double(10,2) DEFAULT NULL,
  `price_gst` double(10,2) DEFAULT NULL,
  `price_finale` double(10,2) DEFAULT NULL,
  `price_discounted` double(10,2) DEFAULT NULL COMMENT 'Sale price, Discounted price equal to price_finale, if discount available then calculate price (this include gst)',
  `price_delivery_charge` double(10,2) DEFAULT NULL,
  `price_total` double(10,2) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `transaction_id` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` tinyint(4) NOT NULL COMMENT '0 = Pending, 1 = Paid, 2 = Cancelled',
  `payment_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Pending, 1 = Completed, 2 = Cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `app_id`, `store_id`, `order_from`, `customer_id`, `order_number`, `payment_mode`, `payment_sub`, `address_id`, `price_raw`, `price_gst`, `price_finale`, `price_discounted`, `price_delivery_charge`, `price_total`, `latitude`, `longitude`, `transaction_id`, `payment_status`, `payment_date`, `created_at`, `status`) VALUES
(1, 4, 4, 0, 6, 'ORD-1519888624', 1, 0, 1, 200.00, 3800.00, 4000.00, 4000.00, 0.00, 4000.00, 0, 0, '0', 0, '0000-00-00 00:00:00', '2018-03-01 12:47:04', 0),
(3, 4, 4, 0, 10, 'ORD-1519899903', 1, 0, 3, 40.00, 760.00, 800.00, 800.00, 0.00, 800.00, 0, 0, '0', 0, '0000-00-00 00:00:00', '2018-03-01 15:55:03', 0),
(4, 4, 4, 0, 10, 'ORD-1519900009', 1, 0, 3, 40.00, 760.00, 800.00, 800.00, 0.00, 800.00, 0, 0, '0', 0, '0000-00-00 00:00:00', '2018-03-01 15:56:49', 0),
(5, 4, 4, 0, 15, 'ORD-1520243591', 1, 0, 4, 45.00, 0.00, 45.00, 45.00, 0.00, 45.00, 0, 0, '0', 0, '0000-00-00 00:00:00', '2018-03-05 15:23:11', 0),
(9, 1, 1, 1, 2, 'ORD-1521030521', 1, 0, 0, 199.00, 0.00, 199.00, 199.00, 0.00, 199.00, 0, 0, '', 1, '2018-03-14 17:58:41', '2018-03-14 17:58:41', 0),
(10, 1, 1, 1, 2, 'ORD-1521032372', 1, 0, 0, 199.00, 0.00, 199.00, 199.00, 0.00, 199.00, 0, 0, '', 1, '2018-03-14 18:29:32', '2018-03-14 18:29:32', 1),
(15, 1, 1, 0, 2, 'ORD-1521181724', 1, 0, 1, 199.00, 0.00, 199.00, 199.00, 50.00, 249.00, 22.2911109, 70.7998965, 'GSHDGSY1516943602', 0, '2018-01-27 12:00:11', '2018-03-16 11:58:44', 0),
(17, 1, 1, NULL, 25, 'ORD-1580304599', 1, 0, 7, 4494.00, 0.00, 4494.00, 4494.00, 0.00, 4494.00, 0, 0, '', 0, NULL, '2020-01-29 18:59:59', 1),
(20, 1, 1, NULL, 27, 'ORD-1581918848', 1, 0, 8, 499.00, 0.00, 499.00, 499.00, 0.00, 499.00, 0, 0, '', 0, NULL, '2020-02-17 11:24:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `offer_reference` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `price_raw` double(10,2) NOT NULL COMMENT 'Raw Price of product, If discount available then calculate this price',
  `price_gst` double(10,2) NOT NULL COMMENT 'Raw gst price of product, If discount available then calculate this price',
  `price_finale` double(10,2) NOT NULL COMMENT 'Original Price Without Discount and Including GST Percentage',
  `price_discounted` double(10,2) NOT NULL COMMENT 'Sale price, Discounted price equal to price_finale, if discount available then calculate price (this include gst)',
  `price_total` double(10,2) NOT NULL COMMENT 'price_discounted multiply quantity',
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = No issue, 1 = Out of stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `app_id`, `order_id`, `product_id`, `variant_id`, `quantity`, `offer_reference`, `price_raw`, `price_gst`, `price_finale`, `price_discounted`, `price_total`, `status`) VALUES
(1, 4, 1, 127, 128, 4, '0', 40.00, 760.00, 800.00, 800.00, 3200.00, 0),
(2, 4, 1, 126, 127, 1, '0', 40.00, 760.00, 800.00, 800.00, 800.00, 0),
(4, 4, 3, 113, 114, 1, '0', 40.00, 760.00, 800.00, 800.00, 800.00, 0),
(5, 4, 4, 126, 127, 1, '0', 40.00, 760.00, 800.00, 800.00, 800.00, 0),
(6, 4, 5, 159, 160, 1, '', 45.00, 0.00, 45.00, 45.00, 45.00, 0),
(7, 1, 9, 84, 84, 1, '', 199.00, 0.00, 199.00, 199.00, 199.00, 0),
(8, 1, 10, 84, 84, 1, '', 199.00, 0.00, 199.00, 199.00, 199.00, 0),
(13, 1, 15, 84, 84, 1, '', 199.00, 0.00, 199.00, 199.00, 199.00, 0),
(14, 1, 17, 165, 167, 5, ',', 799.00, 0.00, 799.00, 799.00, 3995.00, 0),
(15, 1, 17, 164, 166, 1, ',', 499.00, 0.00, 499.00, 499.00, 499.00, 0),
(16, 1, 20, 171, 170, 1, ',', 499.00, 0.00, 499.00, 499.00, 499.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `package_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `package_details` text COLLATE utf8_unicode_ci NOT NULL,
  `package_price_raw` double(10,2) UNSIGNED NOT NULL,
  `package_price_gst` double(10,2) UNSIGNED NOT NULL,
  `package_price` double(10,2) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `package_details`, `package_price_raw`, `package_price_gst`, `package_price`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Basic', 'Upto 30 Products\r\nUnlimited Categories\r\nUnlimited Users\r\nCustom Domain (If opted for website)\r\nWeb based Admin Panel\r\nCloud based server', 10000.00, 1800.00, 11800.00, '2017-12-19 00:00:00', '2020-02-21 09:27:28', 1),
(2, 'Premium', 'Upto 100 Products\r\nUnlimited Categories\r\nUnlimited Users\r\nCustom Domain (If opted for website)\r\nWeb based Admin Panel\r\nCloud based server', 17500.00, 3150.00, 20650.00, '2017-12-19 00:00:00', '2020-02-21 09:28:17', 1),
(3, 'Ultimate', 'Upto 250 Products\r\nUnlimited Categories\r\nUnlimited Users\r\nCustom Domain (If opted for website)\r\nWeb based Admin Panel\r\nCloud based server', 25000.00, 4500.00, 29500.00, '2017-12-19 14:53:43', '2020-02-21 09:28:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `privacy_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = All, 1 = Premium Customer Only',
  `sku_number` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `brand_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `offer_type` tinyint(4) DEFAULT NULL COMMENT '1 = Discount in Percentage (offer_value = % value), 2 = Free products (offer_value = product_id;variant_id)',
  `offer_value` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `total_star_count` int(10) UNSIGNED DEFAULT NULL,
  `total_star_customers` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `app_id`, `category_id`, `privacy_type`, `sku_number`, `product_name`, `brand_id`, `brand_name`, `product_description`, `file_name`, `offer_type`, `offer_value`, `expires_at`, `total_star_count`, `total_star_customers`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 10, 0, 'AB001', 'New Huda Beauty Obsessions Eyeshadow Palette - Mauve', 1, 'Huda', 'A collection of 6 pigmented mattes and 3 gorgeous shimmers in dusty rose and plummy hues create a soft, natural look to achieve a smokey, sultry effect. Each Huda Beauty Obsessions Eyeshadow Palette is packed with a selection of 9 highly pigmented mattes and striking shimmers to create versatile and timeless looks. Available in 4 colour themes - Warm Brown Obsessions, Mauve Obsessions, Smokey Obsessions, and Electric Obsessions - the palettes are super compact and lightweight, quickly earning a top spot in your makeup bag.', '1519449422-2643.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:56:32', 1),
(2, 2, 3, 0, 'AB002', 'Huda Beauty Set Of 16 Liquid Lipstick', 1, 'Huda', 'Long Lasting Lipstick\nMoisturizing Finish\nSoft and Smooth Texture', '1519449422-5602.png', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(3, 2, 10, 0, 'AB003', 'New Huda Beauty Obsessions Eyeshadow Palette - Electric', 1, 'Huda', 'New Huda Beauty Obsessions Eyeshadow Palette - Electric', '1519449422-6765.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:56:11', 1),
(4, 2, 4, 0, 'AB004', 'Beauty Blender Sponge', 1, 'Huda', 'Perfect for all age groups.\nWashable,Reusable,Recyclable\nMade with high quality material.', '1519449422-5201.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(5, 2, 3, 0, 'AB005', 'Generic Huda Beauty Red Edition Liquid Lipstick - Set Of 4', 2, 'Generic', '4 Different Shades\nBrand new & Imported\nMatte finish\nLong lasting', '1519449423-7724.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(6, 2, 5, 0, 'AB006', 'Huda Beauty Foundation', 1, 'Huda', 'Long Lasting Formula Matte Finish\nGives Instant Glow\nConceales and Even Outs Skin Tone\nMatte Finish', '1519449423-6353.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(7, 2, 3, 0, 'AB007', 'HUDA BEAUTY Liquid Matte Lip Color - Heart Breaker', 1, 'Huda', 'Comes in the shade heatbreaker\nIt is highly pigmented\nIt\'s got a smooth formula that sets within seconds of application', '1519449423-2035.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(8, 2, 6, 0, 'AB008', 'SWISS BEAUTY PEARL PRIMER PORES ZERO', 3, 'Swiss Beauty', 'FOR ALL SKIN TYPE\nLONG STAY 18 HOURS OIL FREE\nPEARL PRIMER\nPORES ZERO SILKY SMOOTH', '1519449423-1293.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(9, 2, 5, 0, 'AB009', 'Swiss Beauty Foundation', 3, 'Swiss Beauty', 'Material: Foam\nItem Size (LXBXH): 5.5 cms X 2.5 cms X 7.7\nPackage Contents: 1 Foundation\nCare Instruction: Keep this product away from Children\'s reach', '1519449423-1370.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(10, 2, 7, 0, 'AB010', 'Swiss Beauty Blusher & Highlighter', 3, 'Swiss Beauty', 'Ultra light weight, silky, blendable powders\nMeet the new blush on the block\nSo Silky and smooth, it blends flawlessly for the most natural finish\nSoft texture for a natural hue\nEasily blends with your skin color', '1519449423-2235.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(11, 2, 8, 0, 'AB011', 'Arjun Cosmetic Swiss Beauty Kajal - Black', 4, 'Arjun Cosmetic', 'Long Lasting\nSmudgefree and water proof\nSafe or sensitive eyes and opthalmologist-tested\nMost intense line for long lasting drama\nOil Free', '1519449423-8992.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(12, 2, 9, 0, 'AB012', 'Swiss Beauty Mascara, Black', 3, 'Swiss Beauty', 'Material: Foam\nItem Size (LXBXH): 3 cms X 2 cms X 13 cms\nColor: Black\nPackage Contents: 1 Mascara\nKeep this product away from Children\'s reach', '1519449423-4673.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(13, 2, 8, 0, 'AB013', 'Maybelline New York Colossal Kajal, Deep Black, 0.35g', 5, 'Maybelline', 'Maybelline New York Colossal Kajal, Deep Black, 0.35g', '', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(14, 2, 10, 0, 'AB014', 'SWISS BEAUTY ICONIC BAKED EYE SHADOW PALETTE', 3, 'Swiss Beauty', 'SWISS BEAUTY ICONIC BAKED EYE SHADOW PALETTE', '1519449423-9757.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:56:17', 1),
(15, 2, 0, 0, 'AB015', 'Swiss beauty Makeup Fixer Natural With Aloevera and vitamin E', 3, 'Swiss Beauty', 'If you like to grab attention with your head turning, red carpet style makeup then Swiss Beauty aloe vera Makeup Fixer spray is for you. Swiss beauty makeup fixer spray is a fashion inspired product that creates casual as well as classic glamorous glow. To keep the finish of applied makeup for a long time; mist evenly with Swiss beauty Makeup Fixer spray after makeup is applied.The lightweight and non sticky formula sets makeup for all day. The ultra fine mist is refreshing and dries quikly setting makeup to help you stay beautiful longer', '1519449423-5182.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:54:01', 1),
(16, 2, 12, 0, 'AB016', 'Swiss Beauty Makeup Remover (50ML)', 3, 'Swiss Beauty', 'Swiss Beauty Makeup Remover helps you to clean your skin with providing much-needed protection and nourishment\nNow removing make-up will not take long and in no time you get effective cleansing\nIt completely removes dirt, oil from the surface of your skin\nIt goes deeply into the pores and removes makeup completely\nAs a result, you get refreshed and clean feel', '1519449423-1938.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(17, 2, 3, 0, 'AB017', 'Shoecom Stain Matte Lipstick Ultra Smooth (3Pcs) Russian Red, Raspberry, Love Apricot', 6, 'Shoecom', 'Ultimate Gloss\nSuper Fine Quality\nUltimate response\nLong lasting 12 hours\nSpecial Colors', '1519449423-3068.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(18, 2, 3, 0, 'AB018', 'Swiss 3in1 Golden Stick (lipstick,eyeshadow,highlighter)', 7, 'Swiss', 'INTENSE GOLDEN COLOR', '1519449423-5705.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(19, 2, 10, 1, 'AB019', 'ADS Color Series Makeup Kit (8 Eyeshadow, 1 Power Cake, 8 Lip Color, 2 Blusher)', 8, 'ADS', 'A3746-2 Contains:- 8 Eyeshadow 1 Power Cake 8 Lip Color 2 Blusher Please Note :-Product colour may slightly vary due to photographic lighting sources or your monitor settings', '1519449423-3094.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-03-12 14:29:55', 1),
(20, 2, 3, 0, 'AB020', 'Kylie Cosmetics Vacation Series Send Me More Nudes - 4x3.0 Grams', 9, 'Kylie Cosmetics', 'Kylie\nKylie Jenner\nKylie Jenner Send Me More Nudes\nKylie Send Me More Nudes\nKylie Cosmetics', '1519449423-6859.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(21, 2, 3, 0, 'AB021', 'Girraj makeup world Kylie Jenner Ultra Matte Liquid Lipstick Set', 10, 'Girraj Makeup World', 'Kylie Cosmetics X Kim Kardashian KKW', '1519449423-6604.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(22, 2, 3, 0, 'AB022', 'KYLIE VACAATION EDITION LIPSTICK SET imported brand high quality product', 10, 'Girraj Makeup World', 'KYLIE VACAATION EDITION LIPSTICK SET imported brand high quality product', '1519449423-3505.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(23, 2, 3, 0, 'AB023', 'Kylie Cosmetics X Kim Kardashian KKW', 10, 'Girraj Makeup World', 'Four nude colored creamy liquid lipsticks offering sheer to medium coverage, which can be layered to build intensity.', '1519449423-9604.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(24, 2, 3, 0, 'AB024', 'Kylie Cosmetic Mini Kit Velvet Liquid Lipsticks', 10, 'Girraj Makeup World', 'LA (light nude peach), Party Girl (bright hot coral), Birthday Suit (nude warm beige), Sprinkle (vibrant plum), Commando (terracotta beige) And Commando Surprise Me (bright fuchsia)', '1519449423-6145.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(25, 2, 3, 0, 'AB025', 'Kylie KKW Creme Liquid Lipstick Set (KKW)\n', 9, 'Kylie Cosmetics', 'Kylie KKW Creme Liquid Lipstick Set (KKW)', '1519449423-2026.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(26, 2, 3, 0, 'AB026', 'Kylie Jenner Birthday Collection Kyliner Kit Dark Bronze', 9, 'Kylie Cosmetics', 'The #KylieCosmetics Kyliner Kit combines the perfect shades, textures and tools to create the most defined and sultry Kylie eye . Each Kyliner Kit comes a cr', '1519449423-5943.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(27, 2, 13, 0, 'AB027', 'Kylie the royal peach eyeshadow palette', 9, 'Kylie Cosmetics', 'good quality\npigmented\nthe images represent actual product though color of the image and product may slightly differ', '1519449423-2323.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(28, 2, 3, 0, 'AB028', 'Kylie Lipstick Set Of 12 Pc Long Last Finish', 9, 'Kylie Cosmetics', 'Color, Texture, and Protection to the lips, Pure pigments deliver intense color and provides hydration, Shades to suit all skin tones.', '1519449423-3486.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(29, 2, 3, 0, 'AB029', 'New Kylie Jenner Matte Liquid Lipstick Kollection', 9, 'Kylie Cosmetics', 'When it comes to scoring a Kylie Cosmetics launch, our only option was camping out on the KylieCosmetics.com homepage for hours before the launch, attempting to click \"complete purchase\" before thousands of other super-fans snagged the entire stock. But the day has finally come, Lip Kit collectors, because Kylie Cosmetics is officially launching at Topshop.\nLip Set #2 includes four Matte Liquid Lipsticks. \"Popular,\" is a deep plum, \"Sold Out,\" is a deep raspberry, \"Shop o Clock,\" is a peachy pink, and \"Buy Now Cry Later,\" is a vibrant berry. Keep scrolling to see all of the set\'s shades in their glory:', '1519449423-2635.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(30, 2, 15, 0, 'AB030', 'FULLY Professional Braids Tools / Hair Styling Kits For Women Set Of 5 Hair Accessories Set', 11, 'Fully', 'Item Type: Hair Styling Accessory\r\nMaterial:Plastic\r\nColor: BLACK\r\nQuantity: 1Set (Includes 5Pc)', '1519449652-7332.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:50:52', 1),
(31, 2, 3, 0, 'AB031', 'SHOPEE steel paris Women Makeup Jelly Lip Balm Magic Color Changing Lipstick', 12, 'SHOPEE', 'Quantity: 3.6gm x6pcs, Gloss, Shimmer Finish, Crayon Form, Non Organic Lipstick, Long Lasting', '1519449423-9907.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(32, 2, 8, 0, 'AB032', 'Steel PARIS Long Lasting Waterproof Good Choice Kajal-PGP', 13, 'Steel Paris', 'STEEL PARIS LONG LASTING WATERPROOF GOOD CHOICE KAJAL-PGP', '1519449601-6665.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:50:01', 1),
(33, 2, 17, 0, 'AB033', 'Nail Polish/Paint Remover Perfume 6 different flavours in one set', 13, 'Steel Paris', 'Nail Polish/Paint Remover Perfume 6 different flavours in one set', '1519449424-2122.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(34, 2, 7, 0, 'AB034', 'DETAK Steel Paris Brush 2Pcs', 13, 'Steel Paris', '100 Percent brand new and high quality\nEasy to carry, perfect for carrying while traveling', '1519449424-5510.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(35, 2, 18, 0, 'AB035', 'Hilary Rhoda Blackest Black Eyeliner Pen 1.2 G(Black)', 14, 'Hilary Rhoda', 'Blackest Black Eyeliner Pen\nNo Mess Liquid Liner\nFelt Tip For Precise Control,Long Lasting 12 Hours', '1519449424-1865.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(36, 2, 19, 0, 'AB036', 'HR Refreshing Facial Wipes - Lavender', 15, 'HR', 'CONTENT ALOE VERA EXTRACT\nMINT EXTRACT\nGENTLY CLEAN\nREMOVE IMPURITES', '1519449424-6323.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(37, 2, 20, 0, 'AB037', 'Generic Juice Matte Long Stay Nail Paint (Magic Mulberry)', 2, 'Generic', 'Generic Juice Matte Long Stay Nail Paint (Magic Mulberry)\n', '1519449424-3234.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(38, 2, 20, 0, 'AB038', 'JUICE Matte Nail Polish (Set of Four)', 16, 'AV', 'Water Proff\nLong Lasting\nMatte Look', '1519449424-7219.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(39, 2, 20, 0, 'AB039', 'Huda beauty Nude Edition Minis - Set Of 4 (1.9 MlX4)', 17, 'HUDA BEAUTY', 'Long Lasting Lipstick\nMoisturizing Finish\nSoft and Smooth Texture', '1519449424-7358.jpg', 0, '', NULL, 0, 0, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(98, 3, 56, 0, 'S001', 'Product One', 44, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-5640.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(99, 3, 56, 0, 'S002', 'Product Two', 45, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-5320.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(100, 3, 57, 0, 'S003', 'Product Three', 46, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-5328.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(101, 3, 57, 0, 'S004', 'Product Four', 44, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-1552.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(102, 3, 57, 0, 'S005', 'Product Five', 44, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-9733.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(103, 3, 59, 0, 'S006', 'Product Six', 44, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-3017.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(104, 3, 59, 0, 'S007', 'Product Seven', 45, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-9070.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(105, 3, 59, 0, 'P001', 'Product Eight', 45, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519886286-7862.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:08:06', 1),
(106, 3, 59, 0, 'P002', 'Product Nine', 45, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-8678.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(107, 3, 59, 0, 'P003', 'Product Ten', 45, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-5302.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(108, 3, 61, 0, 'P004', 'Product Eleven', 46, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-6110.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(109, 3, 61, 0, 'P005', 'Product Twelve', 46, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-4240.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(110, 3, 61, 0, 'P006', 'Product Thirteen', 46, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885825-8737.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(111, 3, 63, 0, 'K001', 'Product Fouteen', 45, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885826-2672.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(112, 3, 63, 0, 'K002', 'Product Fifteen', 46, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519885826-9349.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(113, 4, 65, 0, 'S001', 'Product One', 47, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-6231.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(114, 4, 65, 0, 'S002', 'Product Two', 48, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-8051.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(115, 4, 66, 0, 'S003', 'Product Three', 49, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-3116.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(116, 4, 66, 0, 'S004', 'Product Four', 47, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-5590.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(117, 4, 66, 0, 'S005', 'Product Five', 47, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-8770.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(118, 4, 68, 0, 'S006', 'Product Six', 47, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-4246.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(119, 4, 68, 0, 'S007', 'Product Seven', 48, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-9658.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(120, 4, 68, 0, 'P001', 'Product Eight', 48, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-2953.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(121, 4, 68, 0, 'P002', 'Product Nine', 48, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-2662.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(122, 4, 68, 0, 'P003', 'Product Ten', 48, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-9414.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(123, 4, 70, 0, 'P004', 'Product Eleven', 49, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-1172.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(124, 4, 70, 0, 'P005', 'Product Twelve', 49, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-8308.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(125, 4, 70, 0, 'P006', 'Product Thirteen', 49, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-5085.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(126, 4, 72, 0, 'K001', 'Product Fouteen', 48, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-6765.jpg', 0, '', NULL, 3, 1, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(127, 4, 72, 0, 'K002', 'Product Fifteen', 49, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519887352-8275.jpg', 0, '', NULL, 0, 0, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(128, 5, 74, 0, 'S001', 'Product One', 50, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-7098.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(129, 5, 74, 0, 'S002', 'Product Two', 51, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-1007.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(130, 5, 75, 0, 'S003', 'Product Three', 52, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-8966.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(131, 5, 75, 0, 'S004', 'Product Four', 50, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-1242.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(132, 5, 75, 0, 'S005', 'Product Five', 50, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-6112.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(133, 5, 77, 0, 'S006', 'Product Six', 50, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-7134.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(134, 5, 77, 0, 'S007', 'Product Seven', 51, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-5259.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(135, 5, 77, 0, 'P001', 'Product Eight', 51, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-2061.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(136, 5, 77, 0, 'P002', 'Product Nine', 51, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-5466.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(137, 5, 77, 0, 'P003', 'Product Ten', 51, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-6328.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(138, 5, 79, 0, 'P004', 'Product Eleven', 52, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891710-2560.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(139, 5, 79, 0, 'P005', 'Product Twelve', 52, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891711-4066.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(140, 5, 79, 0, 'P006', 'Product Thirteen', 52, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891711-5815.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(141, 5, 81, 0, 'K001', 'Product Fouteen', 51, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891711-8520.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(142, 5, 81, 0, 'K002', 'Product Fifteen', 52, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519891711-8263.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(143, 6, 83, 0, 'S001', 'Product One', 53, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894204-1238.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(144, 6, 83, 0, 'S002', 'Product Two', 54, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894206-4750.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(145, 6, 84, 0, 'S003', 'Product Three', 55, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894206-3149.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(146, 6, 84, 0, 'S004', 'Product Four', 53, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894207-2834.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(147, 6, 84, 0, 'S005', 'Product Five', 53, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894207-3614.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(148, 6, 86, 0, 'S006', 'Product Six', 53, 'Brand One', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894207-3523.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(149, 6, 86, 0, 'S007', 'Product Seven', 54, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894207-4296.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(150, 6, 86, 0, 'P001', 'Product Eight', 54, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894208-8946.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(151, 6, 86, 0, 'P002', 'Product Nine', 54, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894208-9375.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(152, 6, 86, 0, 'P003', 'Product Ten', 54, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894209-6997.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(153, 6, 88, 0, 'P004', 'Product Eleven', 55, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894209-2491.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(154, 6, 88, 0, 'P005', 'Product Twelve', 55, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894209-5143.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(155, 6, 88, 0, 'P006', 'Product Thirteen', 55, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894209-9139.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(156, 6, 90, 0, 'K001', 'Product Fouteen', 54, 'Brand Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894209-2350.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(157, 6, 90, 0, 'K002', 'Product Fifteen', 55, 'Brand Three', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519894210-6051.jpg', 0, '', NULL, 0, 0, '2018-03-01 13:57:51', '2018-03-01 14:20:04', 1),
(158, 4, 72, 0, '124', 'testm', 47, 'Brand One', 'testste', '1520241258-7357.jpg', 0, '', NULL, 0, 0, '2018-03-05 14:44:18', '2018-03-05 14:44:18', 1),
(159, 4, 91, 0, 'sp.2', 'ring sp.2', 47, 'Brand One', '60 pic\r\n\r\n\r\n\r\n', '1520242718-6006.JPG', 0, '', NULL, 0, 0, '2018-03-05 15:08:38', '2018-03-05 15:08:38', 1),
(160, 4, 0, 0, '', 'ANTIC', 56, '-', '12 PIC IN 1 BOX', '1520245495-7142.JPG', 0, '', NULL, 0, 0, '2018-03-05 15:54:55', '2018-03-05 15:54:55', 1);
INSERT INTO `products` (`id`, `app_id`, `category_id`, `privacy_type`, `sku_number`, `product_name`, `brand_id`, `brand_name`, `product_description`, `file_name`, `offer_type`, `offer_value`, `expires_at`, `total_star_count`, `total_star_customers`, `created_at`, `updated_at`, `status`) VALUES
(163, 1, 106, 0, 'SKU', 'Top', 56, '-', 'Fit Type: Regular Fit\r\nMaterials: 95% Polyester, 5% Spandex; The fabric is very stretchy\r\nBust-Size Wise Details: S - 34\", M- 36\" , L -38\", XL -40\",Product Length varies from 25 to 26.5 inches based on size available from S to XL\r\nFabric:Polyester, Sleeve Type: Long Sleeves, Neck Style: round neck, Fit Type:Regular Fit\r\nCare instruction-Regular Machine Wash And Hand Wash\r\nOccasion: Casual || Party || Beach || Formal || Meeting || Office wear', '1580296782-6537.jpeg,1580296782-5977.jpeg,1580296782-2627.jpeg,1580296782-1160.jpeg,1580296782-1372.jpeg,1580296782-4210.jpeg', NULL, NULL, NULL, NULL, NULL, '2020-01-29 16:49:42', '2020-01-29 16:50:33', 1),
(164, 1, 105, 0, 'SKU1', 'Top1', 56, '-', 'Fit Type: Regular Fit\r\nMaterials: 95% Polyester, 5% Spandex; The fabric is very stretchy\r\nBust-Size Wise Details: S - 34\", M- 36\" , L -38\", XL -40\",Product Length varies from 25 to 26.5 inches based on size available from S to XL\r\nFabric:Polyester, Sleeve Type: Long Sleeves, Neck Style: round neck, Fit Type:Regular Fit\r\nCare instruction-Regular Machine Wash And Hand Wash\r\nOccasion: Casual || Party || Beach || Formal || Meeting || Office wear', '1580297120-7856.jpeg,1580297120-7342.jpeg,1580297120-1438.jpeg,1580297120-6635.jpeg,1580297120-4054.jpeg,1580297120-9991.jpeg', NULL, NULL, NULL, 5, 1, '2020-01-29 16:55:20', '2020-01-29 16:55:20', 1),
(165, 1, 108, 0, 'SKU11', 'Shirt1', 56, '-', 'Measure Type', '1580297293-7850.jpg,1580297293-5445.jpg,1580297293-6971.jpg,1580297293-3711.jpg,1580297293-7534.jpg,1580297293-3357.jpg', NULL, NULL, NULL, NULL, NULL, '2020-01-29 16:58:13', '2020-01-29 16:58:13', 1),
(166, 1, 108, 0, 'SKU2', 'Shirt2', 56, '-', 'Fit Type: Regular Fit\r\n100% High-grade Cotton Fabrics: Good capability of tenderness, air permeability and moisture absorption feels soft and comfy.\r\nSuitable for: Sports, Casual, Business Work, Date, Party, Perfect gift for families, friends and boyfriend\r\nSlim Fit , Fabric: 100% Cotton , Full Sleeve ,Casual Shirts\r\nHigh Quality Fabric and Stitching\r\nWash Instruction: Hand-wash in cold water NO BLEACH, Low iron and tumble dry on low heat', '1580362306-8647.jpg,1580362306-8979.jpg,1580362306-4427.jpg,1580362306-8489.jpg,1580362306-9044.jpg,1580362306-8606.jpg', NULL, NULL, NULL, NULL, NULL, '2020-01-30 11:01:46', '2020-01-30 11:01:46', 1),
(167, 1, 107, 0, 'SKU3', 'Shirt3', 56, '-', 'Fit Type: Regular Fit\r\n100% High-grade Cotton Fabrics: Good capability of tenderness, air permeability and moisture absorption feels soft and comfy.\r\nSuitable for: Sports, Casual, Business Work, Date, Party, Perfect gift for families, friends and boyfriend\r\nSlim Fit , Fabric: 100% Cotton , Full Sleeve ,Casual Shirts\r\nHigh Quality Fabric and Stitching\r\nWash Instruction: Handwash in cold water NO BLEACH, Low iron and tumble dry on low heat', '1580362365-2725.jpg,1580362365-9153.jpg,1580362365-6131.jpg,1580362365-3469.jpg,1580362365-3233.jpg,1580362365-4869.jpg', NULL, NULL, NULL, NULL, NULL, '2020-01-30 11:02:45', '2020-01-30 11:02:45', 1),
(168, 1, 106, 0, 'SKU4', 'Top2', 56, '-', 'Fit Type: Regular Fit\r\n100% High-grade Cotton Fabrics: Good capability of tenderness, air permeability and moisture absorption feels soft and comfy.\r\nSuitable for: Sports, Casual, Business Work, Date, Party, Perfect gift for families, friends and boyfriend\r\nSlim Fit , Fabric: 100% Cotton , Full Sleeve ,Casual Shirts\r\nHigh Quality Fabric and Stitching\r\nWash Instruction: Handwash in cold water NO BLEACH, Low iron and tumble dry on low heat', '1580362473-7561.jpg,1580362473-8266.jpg,1580362473-4770.jpg,1580362473-3001.jpg,1580362473-8833.jpeg,1580362473-5584.jpeg', NULL, NULL, NULL, NULL, NULL, '2020-01-30 11:04:33', '2020-01-30 11:04:33', 1),
(169, 1, 110, 0, 'SKU123', 'Jeans1', 56, '-', 'it Type: Regular Fit\r\n100% High-grade Cotton Fabrics: Good capability of tenderness, air permeability and moisture absorption feels soft and comfy.\r\nSuitable for: Sports, Casual, Business Work, Date, Party, Perfect gift for families, friends and boyfriend\r\nSlim Fit , Fabric: 100% Cotton , Full Sleeve ,Casual Shirts\r\nHigh Quality Fabric and Stitching\r\nWash Instruction: Handwash in cold water NO BLEACH, Low iron and tumble dry on low heat\r\n', '1580363288-1941.jpg,1580363288-7420.jpg,1580363288-4646.jpg,1580363288-2344.jpg,1580363288-4288.jpg,1580363288-2566.jpg', NULL, NULL, NULL, NULL, NULL, '2020-01-30 11:18:08', '2020-01-30 11:18:08', 1),
(170, 1, 110, 0, 'SKU111', 'jeans2', 56, '-', 'Fit Type: Regular Fit\r\n100% High-grade Cotton Fabrics: Good capability of tenderness, air permeability and moisture absorption feels soft and comfy.\r\nSuitable for: Sports, Casual, Business Work, Date, Party, Perfect gift for families, friends and boyfriend\r\nSlim Fit , Fabric: 100% Cotton , Full Sleeve ,Casual Shirts\r\nHigh Quality Fabric and Stitching\r\nWash Instruction: Handwash in cold water NO BLEACH, Low iron and tumble dry on low heat\r\n', '1580363573-9917.jpg,1580363573-1729.jpg,1580363573-8736.jpg,1580363573-8107.jpg,1580363573-7311.jpg', NULL, NULL, NULL, NULL, NULL, '2020-01-30 11:22:53', '2020-01-30 11:22:53', 1),
(171, 1, 111, 0, 'SKU22', 'Jeans22', 56, '-', 'Fit Type: Regular Fit\r\n100% High-grade Cotton Fabrics: Good capability of tenderness, air permeability and moisture absorption feels soft and comfy.\r\nSuitable for: Sports, Casual, Business Work, Date, Party, Perfect gift for families, friends and boyfriend\r\nSlim Fit , Fabric: 100% Cotton , Full Sleeve ,Casual Shirts\r\nHigh Quality Fabric and Stitching\r\nWash Instruction: Handwash in cold water NO BLEACH, Low iron and tumble dry on low heat', '1580363804-5998.jpg,1580363804-6035.jpg,1580363804-7096.jpg,1580363804-9898.jpg,1580363804-4758.jpg,1580363804-7214.jpg', NULL, NULL, NULL, NULL, NULL, '2020-01-30 11:26:44', '2020-01-30 11:26:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_brands`
--

CREATE TABLE `products_brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `brand_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_photos`
--

CREATE TABLE `products_photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `file_name` varchar(256) NOT NULL,
  `added_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_photos`
--

INSERT INTO `products_photos` (`id`, `app_id`, `title`, `file_name`, `added_date`) VALUES
(1, 1, '450 (1).jpg', '450 (1).jpg', '2020-05-29 16:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `products_reviews`
--

CREATE TABLE `products_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `star_rating` tinyint(3) UNSIGNED NOT NULL,
  `comment_details` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_reviews`
--

INSERT INTO `products_reviews` (`id`, `app_id`, `customer_id`, `product_id`, `star_rating`, `comment_details`, `created_at`, `updated_at`) VALUES
(1, 4, 6, 126, 3, 'Hello', '2018-03-01 12:44:46', '2018-03-01 12:44:46'),
(2, 1, 25, 164, 5, 'very nice', '2020-01-29 17:43:26', '2020-01-29 17:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `products_variant`
--

CREATE TABLE `products_variant` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `measure_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `net_measure` mediumint(9) NOT NULL,
  `price_raw` double(10,2) NOT NULL,
  `gst_percentage` double(10,2) NOT NULL,
  `price_gst` double(10,2) NOT NULL,
  `price_finale` double(10,2) NOT NULL,
  `offer_type` tinyint(4) NOT NULL COMMENT '1 = Discount in Percentage (offer_value = % value), 2 = Free products (offer_value = product_id;variant_id)',
  `offer_value` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `offer_price` double(10,2) NOT NULL,
  `stock_amount` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_variant`
--

INSERT INTO `products_variant` (`id`, `app_id`, `product_id`, `measure_type`, `net_measure`, `price_raw`, `gst_percentage`, `price_gst`, `price_finale`, `offer_type`, `offer_value`, `expires_at`, `offer_price`, `stock_amount`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 1, 'Set', 1, 1149.00, 0.00, 0.00, 1149.00, 0, '0', NULL, 1149.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(2, 2, 2, 'Set', 1, 1080.00, 0.00, 0.00, 1080.00, 0, '0', NULL, 1080.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(3, 2, 3, 'Set', 1, 730.00, 0.00, 0.00, 730.00, 0, '0', NULL, 730.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(4, 2, 4, 'Set', 1, 129.00, 0.00, 0.00, 129.00, 0, '0', NULL, 129.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(5, 2, 5, 'Set', 1, 599.00, 0.00, 0.00, 599.00, 0, '0', NULL, 599.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(6, 2, 6, 'Set', 1, 299.00, 0.00, 0.00, 299.00, 0, '0', NULL, 299.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(7, 2, 7, 'Set', 1, 379.00, 0.00, 0.00, 379.00, 0, '0', NULL, 379.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(8, 2, 8, 'Set', 1, 599.00, 0.00, 0.00, 599.00, 0, '0', NULL, 599.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(9, 2, 9, 'Set', 1, 450.00, 0.00, 0.00, 450.00, 0, '0', NULL, 450.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(10, 2, 10, 'Set', 1, 350.00, 0.00, 0.00, 350.00, 0, '0', NULL, 350.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(11, 2, 11, 'Set', 1, 200.00, 0.00, 0.00, 200.00, 0, '0', NULL, 200.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(12, 2, 12, 'Set', 1, 245.00, 0.00, 0.00, 245.00, 0, '0', NULL, 245.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(13, 2, 13, 'Set', 1, 165.00, 0.00, 0.00, 165.00, 0, '0', NULL, 165.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(14, 2, 14, 'Set', 1, 608.00, 0.00, 0.00, 608.00, 0, '0', NULL, 608.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(15, 2, 15, 'Set', 1, 800.00, 0.00, 0.00, 800.00, 0, '0', NULL, 800.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(16, 2, 16, 'Set', 1, 700.00, 0.00, 0.00, 700.00, 0, '0', NULL, 700.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(17, 2, 17, 'Set', 1, 399.00, 0.00, 0.00, 399.00, 0, '0', NULL, 399.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(18, 2, 18, 'Set', 1, 375.00, 0.00, 0.00, 375.00, 0, '0', NULL, 375.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(19, 2, 19, 'Set', 1, 200.00, 0.00, 0.00, 200.00, 0, '0', NULL, 200.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(20, 2, 20, 'Set', 1, 449.00, 0.00, 0.00, 449.00, 0, '0', NULL, 449.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(21, 2, 21, 'Set', 1, 1392.00, 0.00, 0.00, 1392.00, 0, '0', NULL, 1392.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(22, 2, 22, 'Set', 1, 2560.00, 0.00, 0.00, 2560.00, 0, '0', NULL, 2560.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(23, 2, 23, 'Set', 1, 759.00, 0.00, 0.00, 759.00, 0, '0', NULL, 759.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(24, 2, 24, 'Set', 1, 640.00, 0.00, 0.00, 640.00, 0, '0', NULL, 640.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(25, 2, 25, 'Set', 1, 589.00, 0.00, 0.00, 589.00, 0, '0', NULL, 589.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(26, 2, 26, 'Set', 1, 12149.00, 0.00, 0.00, 12149.00, 0, '0', NULL, 12149.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(27, 2, 27, 'Set', 1, 650.00, 0.00, 0.00, 650.00, 0, '0', NULL, 650.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(28, 2, 28, 'Set', 1, 800.00, 0.00, 0.00, 800.00, 0, '0', NULL, 800.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(29, 2, 29, 'Set', 1, 2068.00, 0.00, 0.00, 2068.00, 0, '0', NULL, 2068.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(30, 2, 30, 'Set', 1, 199.00, 0.00, 0.00, 199.00, 0, '0', NULL, 199.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(31, 2, 31, 'Set', 1, 699.00, 0.00, 0.00, 699.00, 0, '0', NULL, 699.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(32, 2, 32, 'Set', 1, 199.00, 0.00, 0.00, 199.00, 0, '0', NULL, 199.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(33, 2, 33, 'Set', 1, 209.00, 0.00, 0.00, 209.00, 0, '0', NULL, 209.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(34, 2, 34, 'Set', 1, 345.00, 0.00, 0.00, 345.00, 0, '0', NULL, 345.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(35, 2, 35, 'Set', 1, 249.00, 0.00, 0.00, 249.00, 0, '0', NULL, 249.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(36, 2, 36, 'Set', 1, 210.00, 0.00, 0.00, 210.00, 0, '0', NULL, 210.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(37, 2, 37, 'Set', 1, 140.00, 0.00, 0.00, 140.00, 0, '0', NULL, 140.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(38, 2, 38, 'Set', 1, 479.00, 0.00, 0.00, 479.00, 0, '0', NULL, 479.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(39, 2, 39, 'Set', 1, 499.00, 0.00, 0.00, 499.00, 0, '0', NULL, 499.00, 50, '2018-02-24 10:47:02', '2018-02-24 10:47:02', 1),
(40, 1, 40, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(41, 1, 41, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(42, 1, 42, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(43, 1, 43, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(44, 1, 44, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(45, 1, 45, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(46, 1, 46, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(47, 1, 47, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(48, 1, 48, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(49, 1, 49, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(50, 1, 50, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(51, 1, 51, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(52, 1, 52, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(53, 1, 53, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(54, 1, 54, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-02-24 12:12:30', '2018-02-24 12:12:30', 1),
(55, 1, 55, 'Set', 1, 1149.00, 0.00, 0.00, 1149.00, 0, '0', NULL, 1149.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(56, 1, 56, 'Set', 1, 1080.00, 0.00, 0.00, 1080.00, 0, '0', NULL, 1080.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(57, 1, 57, 'Set', 1, 730.00, 0.00, 0.00, 730.00, 0, '0', NULL, 730.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(58, 1, 58, 'Set', 1, 129.00, 0.00, 0.00, 129.00, 0, '0', NULL, 129.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(59, 1, 59, 'Set', 1, 599.00, 0.00, 0.00, 599.00, 0, '0', NULL, 599.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(60, 1, 60, 'Set', 1, 299.00, 0.00, 0.00, 299.00, 0, '0', NULL, 299.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(61, 1, 61, 'Set', 1, 379.00, 0.00, 0.00, 379.00, 0, '0', NULL, 379.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(62, 1, 62, 'Set', 1, 599.00, 0.00, 0.00, 599.00, 0, '0', NULL, 599.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(63, 1, 63, 'Set', 1, 450.00, 0.00, 0.00, 450.00, 0, '0', NULL, 450.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(64, 1, 64, 'Set', 1, 350.00, 0.00, 0.00, 350.00, 0, '0', NULL, 350.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(65, 1, 65, 'Set', 1, 200.00, 0.00, 0.00, 200.00, 0, '0', NULL, 200.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(66, 1, 66, 'Set', 1, 245.00, 0.00, 0.00, 245.00, 0, '0', NULL, 245.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(67, 1, 67, 'Set', 1, 165.00, 0.00, 0.00, 165.00, 0, '0', NULL, 165.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(68, 1, 68, 'Set', 1, 608.00, 0.00, 0.00, 608.00, 0, '0', NULL, 608.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(69, 1, 69, 'Set', 1, 800.00, 0.00, 0.00, 800.00, 0, '0', NULL, 800.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(70, 1, 70, 'Set', 1, 700.00, 0.00, 0.00, 700.00, 0, '0', NULL, 700.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(71, 1, 71, 'Set', 1, 399.00, 0.00, 0.00, 399.00, 0, '0', NULL, 399.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(72, 1, 72, 'Set', 1, 375.00, 0.00, 0.00, 375.00, 0, '0', NULL, 375.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(73, 1, 73, 'Set', 1, 200.00, 0.00, 0.00, 200.00, 0, '0', NULL, 200.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(74, 1, 74, 'Set', 1, 449.00, 0.00, 0.00, 449.00, 0, '0', NULL, 449.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(75, 1, 75, 'Set', 1, 1392.00, 0.00, 0.00, 1392.00, 0, '0', NULL, 1392.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(76, 1, 76, 'Set', 1, 2560.00, 0.00, 0.00, 2560.00, 0, '0', NULL, 2560.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(77, 1, 77, 'Set', 1, 759.00, 0.00, 0.00, 759.00, 0, '0', NULL, 759.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(78, 1, 78, 'Set', 1, 640.00, 0.00, 0.00, 640.00, 0, '0', NULL, 640.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(79, 1, 79, 'Set', 1, 589.00, 0.00, 0.00, 589.00, 0, '0', NULL, 589.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(80, 1, 80, 'Set', 1, 12149.00, 0.00, 0.00, 12149.00, 0, '0', NULL, 12149.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(81, 1, 81, 'Set', 1, 650.00, 0.00, 0.00, 650.00, 0, '0', NULL, 650.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(82, 1, 82, 'Set', 1, 800.00, 0.00, 0.00, 800.00, 0, '0', NULL, 800.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(83, 1, 83, 'Set', 1, 2068.00, 0.00, 0.00, 2068.00, 0, '0', NULL, 2068.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(84, 1, 84, 'SET', 1, 199.00, 0.00, 0.00, 199.00, 0, '', '0000-00-00 00:00:00', 199.00, 50, '2018-02-24 12:12:35', '2018-03-13 16:49:31', 1),
(85, 1, 85, 'Set', 1, 699.00, 0.00, 0.00, 699.00, 0, '0', NULL, 699.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(86, 1, 86, 'Set', 1, 199.00, 0.00, 0.00, 199.00, 0, '0', NULL, 199.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(87, 1, 87, 'Set', 1, 209.00, 0.00, 0.00, 209.00, 0, '0', NULL, 209.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(88, 1, 88, 'Set', 1, 345.00, 0.00, 0.00, 345.00, 0, '0', NULL, 345.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(89, 1, 89, 'Set', 1, 249.00, 0.00, 0.00, 249.00, 0, '0', NULL, 249.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(90, 1, 90, 'Set', 1, 210.00, 0.00, 0.00, 210.00, 0, '0', NULL, 210.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(91, 1, 91, 'Set', 1, 140.00, 0.00, 0.00, 140.00, 0, '0', NULL, 140.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(92, 1, 92, 'Set', 1, 479.00, 0.00, 0.00, 479.00, 0, '0', NULL, 479.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(93, 1, 93, 'Set', 1, 499.00, 0.00, 0.00, 499.00, 0, '0', NULL, 499.00, 50, '2018-02-24 12:12:35', '2018-02-24 12:12:35', 1),
(94, 1, 94, 'Pc', 1, 1252.00, 5.00, 62.60, 1314.60, 0, ',', '2018-02-24 00:00:00', 1314.60, 23, '2018-02-24 15:33:56', '2018-02-24 15:33:56', 1),
(95, 1, 95, 'Pc', 1, 2365.00, 12.00, 283.80, 2648.80, 0, ',', NULL, 2648.80, 25, '2018-02-24 15:34:27', '2018-02-24 15:34:27', 1),
(96, 1, 96, 'Pc', 1, 1234.00, 5.00, 61.70, 1295.70, 0, ',', '2018-02-24 00:00:00', 1295.70, 15, '2018-02-24 15:35:45', '2018-02-24 15:35:45', 1),
(97, 1, 97, 'Pc', 1, 1489.00, 5.00, 74.45, 1563.45, 1, '5', '2018-03-31 00:00:00', 1485.28, 65, '2018-02-24 15:36:59', '2018-02-24 15:36:59', 1),
(98, 1, 97, 'Pc', 1, 1489.00, 5.00, 74.45, 1563.45, 1, '5', '2018-03-31 00:00:00', 1485.28, 65, '2018-02-24 15:37:03', '2018-02-24 15:37:03', 1),
(99, 3, 98, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(100, 3, 99, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(101, 3, 100, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(102, 3, 101, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(103, 3, 102, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(104, 3, 103, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(105, 3, 104, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(106, 3, 105, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(107, 3, 106, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(108, 3, 107, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(109, 3, 108, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(110, 3, 109, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(111, 3, 110, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(112, 3, 111, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(113, 3, 112, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:00:25', '2018-03-01 12:00:25', 1),
(114, 4, 113, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(115, 4, 114, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(116, 4, 115, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(117, 4, 116, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(118, 4, 117, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(119, 4, 118, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(120, 4, 119, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(121, 4, 120, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(122, 4, 121, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(123, 4, 122, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(124, 4, 123, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(125, 4, 124, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(126, 4, 125, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(127, 4, 126, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(128, 4, 127, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 12:25:52', '2018-03-01 12:25:52', 1),
(129, 5, 128, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(130, 5, 129, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(131, 5, 130, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(132, 5, 131, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(133, 5, 132, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(134, 5, 133, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(135, 5, 134, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(136, 5, 135, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(137, 5, 136, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(138, 5, 137, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(139, 5, 138, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(140, 5, 139, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(141, 5, 140, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(142, 5, 141, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(143, 5, 142, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:38:30', '2018-03-01 13:38:30', 1),
(144, 6, 143, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(145, 6, 144, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(146, 6, 145, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(147, 6, 146, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(148, 6, 147, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(149, 6, 148, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(150, 6, 149, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(151, 6, 150, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(152, 6, 151, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(153, 6, 152, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(154, 6, 153, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(155, 6, 154, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(156, 6, 155, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(157, 6, 156, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(158, 6, 157, 'pc', 1, 40.00, 5.00, 760.00, 800.00, 0, '0', NULL, 800.00, 100, '2018-03-01 13:57:51', '2018-03-01 13:57:51', 1),
(159, 4, 158, '', 0, 483.80, 18.00, 106.20, 590.00, 1, '5', '2018-03-28 00:00:00', 560.50, 100, '2018-03-05 14:45:56', '2018-03-05 14:45:56', 1),
(160, 4, 159, 'pics', 60, 45.00, 0.00, 0.00, 45.00, 0, '', '0000-00-00 00:00:00', 45.00, 32, '2018-03-05 15:09:35', '2018-03-05 15:17:33', 1),
(161, 4, 160, '', 0, 150.00, 0.00, 0.00, 150.00, 0, ',', NULL, 150.00, 12, '2018-03-05 15:57:01', '2018-03-05 15:57:01', 1),
(162, 1, 84, 'SET', 3, 500.00, 0.00, 0.00, 500.00, 1, '10', '2018-04-30 00:00:00', 450.00, 50, '2018-03-13 16:49:22', '2018-03-13 16:49:22', 1),
(163, 1, 84, 'SET', 10, 1000.00, 0.00, 0.00, 1000.00, 2, '73,73', '2018-04-30 00:00:00', 1000.00, 50, '2018-03-13 16:50:12', '2018-03-13 16:50:12', 1),
(164, 1, 162, '100', 101, 499.00, 0.00, 0.00, 499.00, 1, '10', '2020-01-29 00:00:00', 499.00, 1000, '2020-01-29 15:07:14', '2020-01-29 15:10:32', 1),
(165, 1, 163, 'Regular Fit', 50, 499.00, 0.00, 0.00, 499.00, 0, ',', NULL, 499.00, 1000, '2020-01-29 16:51:31', '2020-01-29 16:51:31', 1),
(166, 1, 164, 'Measure Type', 20, 499.00, 0.00, 0.00, 499.00, 0, ',', NULL, 499.00, 1000, '2020-01-29 16:56:18', '2020-01-29 16:56:18', 1),
(167, 1, 165, '142', 10, 799.00, 0.00, 0.00, 799.00, 0, ',', NULL, 799.00, 1000, '2020-01-29 16:59:15', '2020-01-29 16:59:15', 1),
(168, 1, 169, 'XL M S', 32, 999.00, 0.00, 0.00, 999.00, 0, ',', NULL, 999.00, 1000, '2020-01-30 11:27:53', '2020-01-30 11:27:53', 1),
(169, 1, 170, 'XL M S', 32, 499.00, 0.00, 0.00, 499.00, 0, ',', NULL, 499.00, 1000, '2020-01-30 11:28:29', '2020-01-30 11:28:29', 1),
(170, 1, 171, 'XL M S', 36, 499.00, 0.00, 0.00, 499.00, 0, ',', NULL, 499.00, 1000, '2020-01-30 11:30:09', '2020-01-30 11:30:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `push_notifications`
--

CREATE TABLE `push_notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `language` tinyint(4) NOT NULL COMMENT '0 = Eng, 1 = Arabic',
  `msg_head` varchar(264) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `msg_body` varchar(264) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notification_date` datetime NOT NULL,
  `notification_flag` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_executives`
--

CREATE TABLE `sales_executives` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `slider_name` varchar(264) NOT NULL,
  `file_name` varchar(264) NOT NULL,
  `display_order` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `app_id`, `slider_name`, `file_name`, `display_order`, `created_at`, `updated_at`, `status`) VALUES
(3, 1, 'Happy Clients', '1580287584-9046.jpg', 0, '2020-01-29 14:11:34', '2020-01-29 14:16:24', 1),
(4, 1, 'Lowest Price Ever', '1580287597-4792.jpg', 0, '2020-01-29 14:12:15', '2020-01-29 14:16:37', 1),
(6, 1, '4', '1580287623-7036.jpg', 0, '2020-01-29 14:17:03', '2020-01-29 14:17:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `state_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `state_name`) VALUES
(1, 99, 'Andaman and Nicobar Islands'),
(2, 99, 'Andhra Pradesh'),
(3, 99, 'Arunachal Pradesh'),
(4, 99, 'Assam'),
(5, 99, 'Bihar'),
(6, 99, 'Chandigarh'),
(7, 99, 'Chhattisgarh'),
(8, 99, 'Dadra and Nagar Haveli'),
(9, 99, 'Daman and Diu'),
(10, 99, 'Delhi'),
(11, 99, 'Goa'),
(12, 99, 'Gujarat'),
(13, 99, 'Haryana'),
(14, 99, 'Himachal Pradesh'),
(15, 99, 'Jammu and Kashmir'),
(16, 99, 'Jharkhand'),
(17, 99, 'Karnataka'),
(18, 99, 'Kerala'),
(19, 99, 'Lakshadweep'),
(20, 99, 'Madhya Pradesh'),
(21, 99, 'Maharashtra'),
(22, 99, 'Manipur'),
(23, 99, 'Meghalaya'),
(24, 99, 'Mizoram'),
(25, 99, 'Nagaland'),
(26, 99, 'Odisha'),
(27, 99, 'Pondicherry'),
(28, 99, 'Punjab'),
(29, 99, 'Rajasthan'),
(30, 99, 'Sikkim'),
(31, 99, 'Tamil Nadu'),
(32, 99, 'Telangana'),
(33, 99, 'Tripura'),
(34, 99, 'Uttar Pradesh'),
(35, 99, 'Uttarakhand'),
(36, 99, 'West Bengal');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `store_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_1` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_2` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double(10,2) DEFAULT NULL,
  `longitude` double(10,2) DEFAULT NULL,
  `address` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `city_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active, 3 = Blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `app_id`, `store_name`, `email`, `mobile_1`, `mobile_2`, `latitude`, `longitude`, `address`, `city_id`, `city_name`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'Lucson eStore', 'varun@lucsoninfotech.com', '', '', 0.00, 0.00, 'Rajkot', 2, '', '2018-02-24 11:23:09', '0000-00-00 00:00:00', 1),
(2, 2, 'Attitude Boutique', '', '', '', 0.00, 0.00, 'Jamnagar', 1, '', '2018-02-24 11:31:33', '0000-00-00 00:00:00', 1),
(3, 3, 'Davda Tradelink', '', '', '', 0.00, 0.00, 'Rajkot', 3, '', '2018-02-28 17:11:59', '0000-00-00 00:00:00', 1),
(4, 4, 'Swastik & Solanki', '', '9879211948', '', 0.00, 0.00, 'Rajkot', 6, '', '2018-02-28 17:14:37', '0000-00-00 00:00:00', 1),
(5, 5, 'Vinayak Jewellers', '', '9574109573', '', 0.00, 0.00, 'Rajkot', 5, '', '2018-02-28 17:16:50', '0000-00-00 00:00:00', 1),
(6, 6, 'Parivar Mart', '', '', '', 0.00, 0.00, 'Rajkot', 4, '', '2018-02-28 17:25:22', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stores_admin`
--

CREATE TABLE `stores_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores_cities`
--

CREATE TABLE `stores_cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `city_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores_localities`
--

CREATE TABLE `stores_localities` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `store_area` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_charge` double(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '0 = Inactive, 1 = Active, 3 = Blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stores_localities`
--

INSERT INTO `stores_localities` (`id`, `app_id`, `store_id`, `city_id`, `store_area`, `delivery_charge`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 2, 1, 'Bus Stand Area', 0.00, '2018-02-24 11:31:55', '2018-02-24 11:31:55', 1),
(2, 2, 2, 1, 'Murlidhar', 0.00, '2018-02-24 11:32:12', '2018-02-24 11:32:12', 1),
(3, 1, 1, 2, 'Bus Stand Area', 0.00, '2018-02-24 11:58:04', '2018-02-24 11:58:04', 1),
(4, 3, 3, 3, 'Rajkot', 0.00, '2018-02-28 17:12:18', '2018-02-28 17:12:18', 1),
(5, 4, 4, 6, 'Rajkot', 0.00, '2018-03-01 12:33:31', '2018-03-01 12:33:31', 1),
(6, 5, 5, 5, 'Rajkot', 0.00, '2018-03-01 12:36:05', '2018-03-01 12:36:05', 1),
(7, 6, 6, 4, 'Rajkot', 0.00, '2018-03-01 14:19:32', '2018-03-01 14:19:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_details`
--

CREATE TABLE `subscription_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `se_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Sales Executive Id',
  `package_id` int(10) UNSIGNED NOT NULL,
  `package_price_raw` double(10,2) UNSIGNED NOT NULL,
  `package_price_gst` double(10,2) UNSIGNED NOT NULL,
  `package_price` double(10,2) UNSIGNED NOT NULL,
  `starting_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '1 = Active, 2 = Inactive, 3 = Cancelled from our side, 4 = Cancelled from client side'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subscription_details`
--

INSERT INTO `subscription_details` (`id`, `app_id`, `se_id`, `package_id`, `package_price_raw`, `package_price_gst`, `package_price`, `starting_date`, `expiry_date`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-24 11:12:47', '2018-02-28 16:40:26', 1),
(2, 1, NULL, 3, 1000.00, 28.00, 1028.00, '2018-02-24', '2018-04-30', '2018-02-24 11:16:40', '2018-02-24 11:16:40', 1),
(3, 3, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:38:06', '2018-02-28 16:38:06', 1),
(4, 4, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:38:57', '2018-02-28 16:38:57', 1),
(5, 5, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:39:18', '2018-02-28 16:39:18', 1),
(6, 6, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:39:39', '2018-02-28 16:39:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_history`
--

CREATE TABLE `subscription_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `se_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Sales Executive Id',
  `package_id` int(10) UNSIGNED NOT NULL,
  `package_price_raw` double(10,2) UNSIGNED NOT NULL,
  `package_price_gst` double(10,2) UNSIGNED NOT NULL,
  `package_price` double(10,2) UNSIGNED NOT NULL,
  `starting_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL COMMENT '1 = Active, 2 = Inactive, 3 = Cancelled from our side, 4 = Cancelled from client side'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subscription_history`
--

INSERT INTO `subscription_history` (`id`, `app_id`, `se_id`, `package_id`, `package_price_raw`, `package_price_gst`, `package_price`, `starting_date`, `expiry_date`, `created_at`, `status`) VALUES
(1, 2, NULL, 2, 600.00, 28.00, 628.00, '2018-02-24', '2018-04-30', '2018-02-24 11:12:47', 1),
(2, 1, NULL, 3, 1000.00, 28.00, 1028.00, '2018-02-24', '2018-04-30', '2018-02-24 11:16:40', 1),
(3, 3, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:38:06', 1),
(4, 4, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:38:57', 1),
(5, 5, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:39:18', 1),
(6, 6, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:39:39', 1),
(7, 2, NULL, 2, 600.00, 28.00, 628.00, '2018-02-28', '2019-02-27', '2018-02-28 16:40:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(264) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `position`, `company`, `description`, `file_name`, `created_at`, `status`) VALUES
(1, 'Viral Gohel', 'Dev', 'Lucson Infotech', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519454213-9964.jpg', '2018-02-24 17:06:53', 1),
(2, 'Shirish Makwana', 'Dev', 'Lucson Infotech', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1519454228-6526.png', '2018-02-24 17:07:08', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_details`
--
ALTER TABLE `app_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_display_options`
--
ALTER TABLE `app_display_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_info`
--
ALTER TABLE `app_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_maintenance`
--
ALTER TABLE `app_maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities_list`
--
ALTER TABLE `cities_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_address`
--
ALTER TABLE `customers_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_cart`
--
ALTER TABLE `customers_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_wishlist`
--
ALTER TABLE `customers_wishlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_settings`
--
ALTER TABLE `dashboard_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices_customer`
--
ALTER TABLE `devices_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gst_slabs`
--
ALTER TABLE `gst_slabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_brands`
--
ALTER TABLE `products_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_photos`
--
ALTER TABLE `products_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_reviews`
--
ALTER TABLE `products_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_variant`
--
ALTER TABLE `products_variant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `push_notifications`
--
ALTER TABLE `push_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_executives`
--
ALTER TABLE `sales_executives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores_admin`
--
ALTER TABLE `stores_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores_cities`
--
ALTER TABLE `stores_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores_localities`
--
ALTER TABLE `stores_localities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_details`
--
ALTER TABLE `subscription_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_history`
--
ALTER TABLE `subscription_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `app_details`
--
ALTER TABLE `app_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `app_display_options`
--
ALTER TABLE `app_display_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `app_info`
--
ALTER TABLE `app_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `app_maintenance`
--
ALTER TABLE `app_maintenance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cities_list`
--
ALTER TABLE `cities_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `customers_address`
--
ALTER TABLE `customers_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `customers_cart`
--
ALTER TABLE `customers_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `customers_wishlist`
--
ALTER TABLE `customers_wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dashboard_settings`
--
ALTER TABLE `dashboard_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `devices_customer`
--
ALTER TABLE `devices_customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gst_slabs`
--
ALTER TABLE `gst_slabs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT for table `products_brands`
--
ALTER TABLE `products_brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products_photos`
--
ALTER TABLE `products_photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products_reviews`
--
ALTER TABLE `products_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `products_variant`
--
ALTER TABLE `products_variant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
--
-- AUTO_INCREMENT for table `push_notifications`
--
ALTER TABLE `push_notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_executives`
--
ALTER TABLE `sales_executives`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `stores_admin`
--
ALTER TABLE `stores_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores_cities`
--
ALTER TABLE `stores_cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stores_localities`
--
ALTER TABLE `stores_localities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `subscription_details`
--
ALTER TABLE `subscription_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subscription_history`
--
ALTER TABLE `subscription_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
