-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 18, 2024 at 07:22 AM
-- Server version: 10.11.11-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u568030064_launcherr`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `heading`, `content`, `url`, `created_at`, `updated_at`) VALUES
(2, 'Your Passport To Seamless Travel', 'Get ready to launch your travel adventures with Launcherr! We\'re your ultimate travel companion, dedicated to making your journeys exciting, affordable, and filled with unforgettable experiences.\n\nJoin us at Launcherr and transform every trip into an epic tale. Whether you\'re chasing sunsets, conquering peaks, or uncovering hidden gems, we\'re here for every step of your\njourney. Your next great adventure starts now! 🌍✈️', 'https://drive.google.com/file/d/1cZljZgF3dZ_sla21hTAWU4dWI0oAEBSQ/view?usp=drive_link', '2024-06-29 10:34:19', '2024-07-12 05:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `banner_news`
--

CREATE TABLE `banner_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Banner_No` varchar(255) NOT NULL,
  `Banner_button_text` varchar(255) DEFAULT NULL,
  `Banner_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Banner_heading` varchar(255) NOT NULL,
  `Banner_sub_heading` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_news`
--

INSERT INTO `banner_news` (`id`, `Banner_No`, `Banner_button_text`, `Banner_image`, `created_at`, `updated_at`, `Banner_heading`, `Banner_sub_heading`) VALUES
(6, '1', 'Explore Now!', 'https://res.cloudinary.com/douuxmaix/image/upload/v1722080969/eabvcbenbcjgil1ponyc.png', '2024-07-27 11:49:30', '2024-07-27 11:49:30', '', NULL),
(7, '2', 'Find Gigs!', 'https://res.cloudinary.com/douuxmaix/image/upload/v1722081008/agm2a9zr2ksrzhcxevyl.png', '2024-07-27 11:50:08', '2024-07-27 11:50:08', '', NULL),
(8, '3', 'Shop Now!', 'https://res.cloudinary.com/douuxmaix/image/upload/v1722081652/v49wcusygeyhdudkhblw.png', '2024-07-27 12:00:52', '2024-07-27 12:00:52', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Andaman & Nicobar Islands', 'Nicobar', NULL, NULL),
(2, 'Andaman & Nicobar Islands', 'North & Middle Andaman', NULL, NULL),
(3, 'Andaman & Nicobar Islands', 'South Andaman', NULL, NULL),
(4, 'Andhra Pradesh', 'Adilabad', NULL, NULL),
(5, 'Andhra Pradesh', 'Anantapur', NULL, NULL),
(6, 'Andhra Pradesh', 'Chittoor', NULL, NULL),
(7, 'Andhra Pradesh', 'Cuddapah', NULL, NULL),
(8, 'Andhra Pradesh', 'East Godavari', NULL, NULL),
(9, 'Andhra Pradesh', 'Guntur', NULL, NULL),
(10, 'Andhra Pradesh', 'Hyderabad', NULL, NULL),
(11, 'Andhra Pradesh', 'Karimnagar', NULL, NULL),
(12, 'Andhra Pradesh', 'Khammam', NULL, NULL),
(13, 'Andhra Pradesh', 'Krishna', NULL, NULL),
(14, 'Andhra Pradesh', 'Kurnool', NULL, NULL),
(15, 'Andhra Pradesh', 'Mahbubnagar', NULL, NULL),
(16, 'Andhra Pradesh', 'Medak', NULL, NULL),
(17, 'Andhra Pradesh', 'Nalgonda', NULL, NULL),
(18, 'Andhra Pradesh', 'Nellore', NULL, NULL),
(19, 'Andhra Pradesh', 'Nizamabad', NULL, NULL),
(20, 'Andhra Pradesh', 'Prakasam', NULL, NULL),
(21, 'Andhra Pradesh', 'Rangareddy', NULL, NULL),
(22, 'Andhra Pradesh', 'Srikakulam', NULL, NULL),
(23, 'Andhra Pradesh', 'Visakhapatnam', NULL, NULL),
(24, 'Andhra Pradesh', 'Vizianagaram', NULL, NULL),
(25, 'Andhra Pradesh', 'Warangal', NULL, NULL),
(26, 'Andhra Pradesh', 'West Godavari', NULL, NULL),
(27, 'Arunachal Pradesh', 'Anjaw', NULL, NULL),
(28, 'Arunachal Pradesh', 'Changlang', NULL, NULL),
(29, 'Arunachal Pradesh', 'Dibang Valley', NULL, NULL),
(30, 'Arunachal Pradesh', 'East Kameng', NULL, NULL),
(31, 'Arunachal Pradesh', 'East Siang', NULL, NULL),
(32, 'Arunachal Pradesh', 'Kurung Kumey', NULL, NULL),
(33, 'Arunachal Pradesh', 'Lohit', NULL, NULL),
(34, 'Arunachal Pradesh', 'Lower Dibang Valley', NULL, NULL),
(35, 'Arunachal Pradesh', 'Lower Subansiri', NULL, NULL),
(36, 'Arunachal Pradesh', 'Papum Pare', NULL, NULL),
(37, 'Arunachal Pradesh', 'Tawang', NULL, NULL),
(38, 'Arunachal Pradesh', 'Tirap', NULL, NULL),
(39, 'Arunachal Pradesh', 'Upper Siang', NULL, NULL),
(40, 'Arunachal Pradesh', 'Upper Subansiri', NULL, NULL),
(41, 'Arunachal Pradesh', 'West Kameng', NULL, NULL),
(42, 'Arunachal Pradesh', 'West Siang', NULL, NULL),
(43, 'Assam', 'Baksa', NULL, NULL),
(44, 'Assam', 'Barpeta', NULL, NULL),
(45, 'Assam', 'Bongaigaon', NULL, NULL),
(46, 'Assam', 'Cachar', NULL, NULL),
(47, 'Assam', 'Chirang', NULL, NULL),
(48, 'Assam', 'Darrang', NULL, NULL),
(49, 'Assam', 'Dhemaji', NULL, NULL),
(50, 'Assam', 'Dhubri', NULL, NULL),
(51, 'Assam', 'Dibrugarh', NULL, NULL),
(52, 'Assam', 'Dima Hasao', NULL, NULL),
(53, 'Assam', 'Goalpara', NULL, NULL),
(54, 'Assam', 'Golaghat', NULL, NULL),
(55, 'Assam', 'Hailakandi', NULL, NULL),
(56, 'Assam', 'Jorhat', NULL, NULL),
(57, 'Assam', 'Kamrup', NULL, NULL),
(58, 'Assam', 'Kamrup Metropolitan', NULL, NULL),
(59, 'Assam', 'Karbi Anglong', NULL, NULL),
(60, 'Assam', 'Karimganj', NULL, NULL),
(61, 'Assam', 'Kokrajhar', NULL, NULL),
(62, 'Assam', 'Lakhimpur', NULL, NULL),
(63, 'Assam', 'Morigaon', NULL, NULL),
(64, 'Assam', 'Nagaon', NULL, NULL),
(65, 'Assam', 'Nalbari', NULL, NULL),
(66, 'Assam', 'Sivasagar', NULL, NULL),
(67, 'Assam', 'Sonitpur', NULL, NULL),
(68, 'Assam', 'Tinsukia', NULL, NULL),
(69, 'Assam', 'Udalguri', NULL, NULL),
(70, 'Bihar', 'Araria', NULL, NULL),
(71, 'Bihar', 'Arwal', NULL, NULL),
(72, 'Bihar', 'Aurangabad', NULL, NULL),
(73, 'Bihar', 'Banka', NULL, NULL),
(74, 'Bihar', 'Begusarai', NULL, NULL),
(75, 'Bihar', 'Bhagalpur', NULL, NULL),
(76, 'Bihar', 'Bhojpur', NULL, NULL),
(77, 'Bihar', 'Buxar', NULL, NULL),
(78, 'Bihar', 'Darbhanga', NULL, NULL),
(79, 'Bihar', 'Gaya', NULL, NULL),
(80, 'Bihar', 'Gopalganj', NULL, NULL),
(81, 'Bihar', 'Jamui', NULL, NULL),
(82, 'Bihar', 'Jehanabad', NULL, NULL),
(83, 'Bihar', 'Kaimur (Bhabua)', NULL, NULL),
(84, 'Bihar', 'Katihar', NULL, NULL),
(85, 'Bihar', 'Khagaria', NULL, NULL),
(86, 'Bihar', 'Kishanganj', NULL, NULL),
(87, 'Bihar', 'Lakhisarai', NULL, NULL),
(88, 'Bihar', 'Madhepura', NULL, NULL),
(89, 'Bihar', 'Madhubani', NULL, NULL),
(90, 'Bihar', 'Munger', NULL, NULL),
(91, 'Bihar', 'Muzaffarpur', NULL, NULL),
(92, 'Bihar', 'Nalanda', NULL, NULL),
(93, 'Bihar', 'Nawada', NULL, NULL),
(94, 'Bihar', 'Pashchim Champaran', NULL, NULL),
(95, 'Bihar', 'Patna', NULL, NULL),
(96, 'Bihar', 'Purba Champaran', NULL, NULL),
(97, 'Bihar', 'Purnia', NULL, NULL),
(98, 'Bihar', 'Rohtas', NULL, NULL),
(99, 'Bihar', 'Saharsa', NULL, NULL),
(100, 'Bihar', '', NULL, NULL),
(101, 'Bihar', 'Saran', NULL, NULL),
(102, 'Bihar', 'Sheikhpura', NULL, NULL),
(103, 'Bihar', 'Sheohar', NULL, NULL),
(104, 'Bihar', 'Sitamarhi', NULL, NULL),
(105, 'Bihar', 'Siwan', NULL, NULL),
(106, 'Bihar', 'Supaul', NULL, NULL),
(107, 'Bihar', 'Vaishali', NULL, NULL),
(108, 'Chandigarh', 'Chandigarh', NULL, NULL),
(109, 'Chhattisgarh', 'Bastar', NULL, NULL),
(110, 'Chhattisgarh', 'Bijapur', NULL, NULL),
(111, 'Chhattisgarh', 'Bilaspur', NULL, NULL),
(112, 'Chhattisgarh', 'Dakshin Bastar Dantewada', NULL, NULL),
(113, 'Chhattisgarh', 'Dhamtari', NULL, NULL),
(114, 'Chhattisgarh', 'Durg', NULL, NULL),
(115, 'Chhattisgarh', 'Janjgir-Champa', NULL, NULL),
(116, 'Chhattisgarh', 'Jashpur', NULL, NULL),
(117, 'Chhattisgarh', 'Kabirdham', NULL, NULL),
(118, 'Chhattisgarh', 'Korba', NULL, NULL),
(119, 'Chhattisgarh', 'Koriya', NULL, NULL),
(120, 'Chhattisgarh', 'Mahasamund', NULL, NULL),
(121, 'Chhattisgarh', 'Narayanpur', NULL, NULL),
(122, 'Chhattisgarh', 'Raigarh', NULL, NULL),
(123, 'Chhattisgarh', 'Raipur', NULL, NULL),
(124, 'Chhattisgarh', 'Rajnandgaon', NULL, NULL),
(125, 'Chhattisgarh', 'Surguja', NULL, NULL),
(126, 'Chhattisgarh', 'Uttar Bastar Kanker', NULL, NULL),
(127, 'Dadra and Nagar Haveli', 'Dadra and Nagar Haveli', NULL, NULL),
(128, 'Daman & Diu', 'Daman', NULL, NULL),
(129, 'Daman & Diu', 'Diu', NULL, NULL),
(130, 'Delhi', 'Central', NULL, NULL),
(131, 'Delhi', 'East', NULL, NULL),
(132, 'Delhi', 'New Delhi', NULL, NULL),
(133, 'Delhi', 'North', NULL, NULL),
(134, 'Delhi', 'North East', NULL, NULL),
(135, 'Delhi', 'North West', NULL, NULL),
(136, 'Delhi', 'South', NULL, NULL),
(137, 'Delhi', 'South West', NULL, NULL),
(138, 'Delhi', 'West', NULL, NULL),
(139, 'Goa', 'North Goa', NULL, NULL),
(140, 'Goa', 'South Goa', NULL, NULL),
(141, 'Gujarat', 'Ahmedabad', NULL, NULL),
(142, 'Gujarat', 'Amreli', NULL, NULL),
(143, 'Gujarat', 'Anand', NULL, NULL),
(144, 'Gujarat', 'Banaskantha', NULL, NULL),
(145, 'Gujarat', 'Bharuch', NULL, NULL),
(146, 'Gujarat', 'Bhavnagar', NULL, NULL),
(147, 'Gujarat', 'Dahod', NULL, NULL),
(148, 'Gujarat', 'Gandhinagar', NULL, NULL),
(149, 'Gujarat', 'Jamnagar', NULL, NULL),
(150, 'Gujarat', 'Junagadh', NULL, NULL),
(151, 'Gujarat', 'Kheda', NULL, NULL),
(152, 'Gujarat', 'Kutch', NULL, NULL),
(153, 'Gujarat', 'Mehsana', NULL, NULL),
(154, 'Gujarat', 'Narmada', NULL, NULL),
(155, 'Gujarat', 'Navsari', NULL, NULL),
(156, 'Gujarat', 'Panchmahal', NULL, NULL),
(157, 'Gujarat', 'Patan', NULL, NULL),
(158, 'Gujarat', 'Porbandar', NULL, NULL),
(159, 'Gujarat', 'Rajkot', NULL, NULL),
(160, 'Gujarat', 'Sabarkantha', NULL, NULL),
(161, 'Gujarat', 'Surat', NULL, NULL),
(162, 'Gujarat', 'Surendranagar', NULL, NULL),
(163, 'Gujarat', 'Tapi', NULL, NULL),
(164, 'Gujarat', 'The Dangs', NULL, NULL),
(165, 'Gujarat', 'Vadodara', NULL, NULL),
(166, 'Gujarat', 'Valsad', NULL, NULL),
(167, 'Haryana', 'Ambala', NULL, NULL),
(168, 'Haryana', 'Bhiwani', NULL, NULL),
(169, 'Haryana', 'Faridabad', NULL, NULL),
(170, 'Haryana', 'Fatehabad', NULL, NULL),
(171, 'Haryana', 'Gurgaon', NULL, NULL),
(172, 'Haryana', 'Hisar', NULL, NULL),
(173, 'Haryana', 'Jhajjar', NULL, NULL),
(174, 'Haryana', 'Jind', NULL, NULL),
(175, 'Haryana', 'Kaithal', NULL, NULL),
(176, 'Haryana', 'Karnal', NULL, NULL),
(177, 'Haryana', 'Kurukshetra', NULL, NULL),
(178, 'Haryana', 'Mahendragarh', NULL, NULL),
(179, 'Haryana', 'Mewat', NULL, NULL),
(180, 'Haryana', 'Palwal', NULL, NULL),
(181, 'Haryana', 'Panchkula', NULL, NULL),
(182, 'Haryana', 'Panipat', NULL, NULL),
(183, 'Haryana', 'Rewari', NULL, NULL),
(184, 'Haryana', 'Rohtak', NULL, NULL),
(185, 'Haryana', 'Sirsa', NULL, NULL),
(186, 'Haryana', 'Sonipat', NULL, NULL),
(187, 'Haryana', 'Yamunanagar', NULL, NULL),
(188, 'Himachal Pradesh', 'Bilaspur', NULL, NULL),
(189, 'Himachal Pradesh', 'Chamba', NULL, NULL),
(190, 'Himachal Pradesh', 'Hamirpur', NULL, NULL),
(191, 'Himachal Pradesh', 'Kangra', NULL, NULL),
(192, 'Himachal Pradesh', 'Kinnaur', NULL, NULL),
(193, 'Himachal Pradesh', 'Kullu', NULL, NULL),
(194, 'Himachal Pradesh', 'Lahul & Spiti', NULL, NULL),
(195, 'Himachal Pradesh', 'Mandi', NULL, NULL),
(196, 'Himachal Pradesh', 'Shimla', NULL, NULL),
(197, 'Himachal Pradesh', 'Sirmaur', NULL, NULL),
(198, 'Himachal Pradesh', 'Solan', NULL, NULL),
(199, 'Himachal Pradesh', 'Una', NULL, NULL),
(200, 'Jammu & Kashmir', 'Anantnag', NULL, NULL),
(201, 'Jammu & Kashmir', 'Bandipore', NULL, NULL),
(202, 'Jammu & Kashmir', 'Baramula', NULL, NULL),
(203, 'Jammu & Kashmir', 'Budgam', NULL, NULL),
(204, 'Jammu & Kashmir', 'Doda', NULL, NULL),
(205, 'Jammu & Kashmir', 'Ganderbal', NULL, NULL),
(206, 'Jammu & Kashmir', 'Jammu', NULL, NULL),
(207, 'Jammu & Kashmir', 'Kargil', NULL, NULL),
(208, 'Jammu & Kashmir', 'Kathua', NULL, NULL),
(209, 'Jammu & Kashmir', 'Kishtwar', NULL, NULL),
(210, 'Jammu & Kashmir', 'Kulgam', NULL, NULL),
(211, 'Jammu & Kashmir', 'Kupwara', NULL, NULL),
(212, 'Jammu & Kashmir', 'Leh (Ladakh)', NULL, NULL),
(213, 'Jammu & Kashmir', 'Pulwama', NULL, NULL),
(214, 'Jammu & Kashmir', 'Punch', NULL, NULL),
(215, 'Jammu & Kashmir', 'Rajauri', NULL, NULL),
(216, 'Jammu & Kashmir', 'Ramban', NULL, NULL),
(217, 'Jammu & Kashmir', 'Reasi', NULL, NULL),
(218, 'Jammu & Kashmir', 'Samba', NULL, NULL),
(219, 'Jammu & Kashmir', 'Shupiyan', NULL, NULL),
(220, 'Jammu & Kashmir', 'Srinagar', NULL, NULL),
(221, 'Jammu & Kashmir', 'Udhampur', NULL, NULL),
(222, 'Jharkhand', 'Bokaro Steel City', NULL, NULL),
(223, 'Jharkhand', 'Chatra', NULL, NULL),
(224, 'Jharkhand', 'Deoghar', NULL, NULL),
(225, 'Jharkhand', 'Dhanbad', NULL, NULL),
(226, 'Jharkhand', 'Dumka', NULL, NULL),
(227, 'Jharkhand', 'Garhwa', NULL, NULL),
(228, 'Jharkhand', 'Giridih', NULL, NULL),
(229, 'Jharkhand', 'Godda', NULL, NULL),
(230, 'Jharkhand', 'Gumla', NULL, NULL),
(231, 'Jharkhand', 'Hazaribagh', NULL, NULL),
(232, 'Jharkhand', 'Jamtara', NULL, NULL),
(233, 'Jharkhand', 'Khunti', NULL, NULL),
(234, 'Jharkhand', 'Kodarma', NULL, NULL),
(235, 'Jharkhand', 'Latehar', NULL, NULL),
(236, 'Jharkhand', 'Lohardaga', NULL, NULL),
(237, 'Jharkhand', 'Pakur', NULL, NULL),
(238, 'Jharkhand', 'Palamu', NULL, NULL),
(239, 'Jharkhand', 'Pashchimi Singhbhum', NULL, NULL),
(240, 'Jharkhand', 'Purbi Singhbhum', NULL, NULL),
(241, 'Jharkhand', 'Ramgarh', NULL, NULL),
(242, 'Jharkhand', 'Ranchi', NULL, NULL),
(243, 'Jharkhand', 'Sahibganj', NULL, NULL),
(244, 'Jharkhand', 'Saraikela-Kharsawan', NULL, NULL),
(245, 'Jharkhand', 'Simdega', NULL, NULL),
(246, 'Karnataka', 'Bagalkot', NULL, NULL),
(247, 'Karnataka', 'Ballari', NULL, NULL),
(248, 'Karnataka', 'Belagavi', NULL, NULL),
(249, 'Karnataka', 'Bengaluru', NULL, NULL),
(250, 'Karnataka', 'Bengaluru Rural', NULL, NULL),
(251, 'Karnataka', 'Bidar', NULL, NULL),
(252, 'Karnataka', 'Chamarajanagar', NULL, NULL),
(253, 'Karnataka', 'Chikkaballapura', NULL, NULL),
(254, 'Karnataka', 'Chikkamagaluru', NULL, NULL),
(255, 'Karnataka', 'Chitradurga', NULL, NULL),
(256, 'Karnataka', 'Dakshina Kannada', NULL, NULL),
(257, 'Karnataka', 'Davanagere', NULL, NULL),
(258, 'Karnataka', 'Dharwad', NULL, NULL),
(259, 'Karnataka', 'Gadag', NULL, NULL),
(260, 'Karnataka', 'Hassan', NULL, NULL),
(261, 'Karnataka', 'Haveri', NULL, NULL),
(262, 'Karnataka', 'Kalaburagi', NULL, NULL),
(263, 'Karnataka', 'Kodagu', NULL, NULL),
(264, 'Karnataka', 'Kolar', NULL, NULL),
(265, 'Karnataka', 'Koppal', NULL, NULL),
(266, 'Karnataka', 'Mandya', NULL, NULL),
(267, 'Karnataka', 'Mysuru', NULL, NULL),
(268, 'Karnataka', 'Raichur', NULL, NULL),
(269, 'Karnataka', 'Ramanagara', NULL, NULL),
(270, 'Karnataka', 'Shivamogga', NULL, NULL),
(271, 'Karnataka', 'Tumakuru', NULL, NULL),
(272, 'Karnataka', 'Udupi', NULL, NULL),
(273, 'Karnataka', 'Uttara Kannada', NULL, NULL),
(274, 'Karnataka', 'Vijayapura', NULL, NULL),
(275, 'Karnataka', 'Yadgir', NULL, NULL),
(276, 'Kerala', 'Alappuzha', NULL, NULL),
(277, 'Kerala', 'Ernakulam', NULL, NULL),
(278, 'Kerala', 'Idukki', NULL, NULL),
(279, 'Kerala', 'Kannur', NULL, NULL),
(280, 'Kerala', 'Kasaragod', NULL, NULL),
(281, 'Kerala', 'Kollam', NULL, NULL),
(282, 'Kerala', 'Kottayam', NULL, NULL),
(283, 'Kerala', 'Kozhikode', NULL, NULL),
(284, 'Kerala', 'Malappuram', NULL, NULL),
(285, 'Kerala', 'Palakkad', NULL, NULL),
(286, 'Kerala', 'Pathanamthitta', NULL, NULL),
(287, 'Kerala', 'Thiruvananthapuram', NULL, NULL),
(288, 'Kerala', 'Thrissur', NULL, NULL),
(289, 'Kerala', 'Wayanad', NULL, NULL),
(290, 'Lakshadweep', 'Lakshadweep', NULL, NULL),
(291, 'Madhya Pradesh', 'Agar Malwa', NULL, NULL),
(292, 'Madhya Pradesh', 'Alirajpur', NULL, NULL),
(293, 'Madhya Pradesh', 'Anuppur', NULL, NULL),
(294, 'Madhya Pradesh', 'Ashoknagar', NULL, NULL),
(295, 'Madhya Pradesh', 'Balaghat', NULL, NULL),
(296, 'Madhya Pradesh', 'Barwani', NULL, NULL),
(297, 'Madhya Pradesh', 'Betul', NULL, NULL),
(298, 'Madhya Pradesh', 'Bhind', NULL, NULL),
(299, 'Madhya Pradesh', 'Bhopal', NULL, NULL),
(300, 'Madhya Pradesh', 'Burhanpur', NULL, NULL),
(301, 'Madhya Pradesh', 'Chhatarpur', NULL, NULL),
(302, 'Madhya Pradesh', 'Chhindwara', NULL, NULL),
(303, 'Madhya Pradesh', 'Damoh', NULL, NULL),
(304, 'Madhya Pradesh', 'Datia', NULL, NULL),
(305, 'Madhya Pradesh', 'Dewas', NULL, NULL),
(306, 'Madhya Pradesh', 'Dhar', NULL, NULL),
(307, 'Madhya Pradesh', 'Dindori', NULL, NULL),
(308, 'Madhya Pradesh', 'East Nimar', NULL, NULL),
(309, 'Madhya Pradesh', 'Guna', NULL, NULL),
(310, 'Madhya Pradesh', 'Gwalior', NULL, NULL),
(311, 'Madhya Pradesh', 'Harda', NULL, NULL),
(312, 'Madhya Pradesh', 'Hoshangabad', NULL, NULL),
(313, 'Madhya Pradesh', 'Indore', NULL, NULL),
(314, 'Madhya Pradesh', 'Jabalpur', NULL, NULL),
(315, 'Madhya Pradesh', 'Jhabua', NULL, NULL),
(316, 'Madhya Pradesh', 'Katni', NULL, NULL),
(317, 'Madhya Pradesh', 'Mandla', NULL, NULL),
(318, 'Madhya Pradesh', 'Mandsaur', NULL, NULL),
(319, 'Madhya Pradesh', 'Morena', NULL, NULL),
(320, 'Madhya Pradesh', 'Narsimhapur', NULL, NULL),
(321, 'Madhya Pradesh', 'Neemuch', NULL, NULL),
(322, 'Madhya Pradesh', 'Panna', NULL, NULL),
(323, 'Madhya Pradesh', 'Raisen', NULL, NULL),
(324, 'Madhya Pradesh', 'Rajgarh', NULL, NULL),
(325, 'Madhya Pradesh', 'Ratlam', NULL, NULL),
(326, 'Madhya Pradesh', 'Rewa', NULL, NULL),
(327, 'Madhya Pradesh', 'Sagar', NULL, NULL),
(328, 'Madhya Pradesh', 'Satna', NULL, NULL),
(329, 'Madhya Pradesh', 'Sehore', NULL, NULL),
(330, 'Madhya Pradesh', 'Seoni', NULL, NULL),
(331, 'Madhya Pradesh', 'Shahdol', NULL, NULL),
(332, 'Madhya Pradesh', 'Shajapur', NULL, NULL),
(333, 'Madhya Pradesh', 'Sheopur', NULL, NULL),
(334, 'Madhya Pradesh', 'Shivpuri', NULL, NULL),
(335, 'Madhya Pradesh', 'Sidhi', NULL, NULL),
(336, 'Madhya Pradesh', 'Singrauli', NULL, NULL),
(337, 'Madhya Pradesh', 'Tikamgarh', NULL, NULL),
(338, 'Madhya Pradesh', 'Ujjain', NULL, NULL),
(339, 'Madhya Pradesh', 'Umaria', NULL, NULL),
(340, 'Madhya Pradesh', 'Vidisha', NULL, NULL),
(341, 'Madhya Pradesh', 'West Nimar', NULL, NULL),
(342, 'Maharashtra', 'Ahmednagar', NULL, NULL),
(343, 'Maharashtra', 'Akola', NULL, NULL),
(344, 'Maharashtra', 'Amravati', NULL, NULL),
(345, 'Maharashtra', 'Aurangabad', NULL, NULL),
(346, 'Maharashtra', 'Beed', NULL, NULL),
(347, 'Maharashtra', 'Bhandara', NULL, NULL),
(348, 'Maharashtra', 'Buldana', NULL, NULL),
(349, 'Maharashtra', 'Chandrapur', NULL, NULL),
(350, 'Maharashtra', 'Dhule', NULL, NULL),
(351, 'Maharashtra', 'Gadchiroli', NULL, NULL),
(352, 'Maharashtra', 'Gondia', NULL, NULL),
(353, 'Maharashtra', 'Hingoli', NULL, NULL),
(354, 'Maharashtra', 'Jalgaon', NULL, NULL),
(355, 'Maharashtra', 'Jalna', NULL, NULL),
(356, 'Maharashtra', 'Kolhapur', NULL, NULL),
(357, 'Maharashtra', 'Latur', NULL, NULL),
(358, 'Maharashtra', 'Mumbai', NULL, NULL),
(359, 'Maharashtra', 'Mumbai Suburban', NULL, NULL),
(360, 'Maharashtra', 'Nagpur', NULL, NULL),
(361, 'Maharashtra', 'Nanded', NULL, NULL),
(362, 'Maharashtra', 'Nandurbar', NULL, NULL),
(363, 'Maharashtra', 'Nashik', NULL, NULL),
(364, 'Maharashtra', 'Osmanabad', NULL, NULL),
(365, 'Maharashtra', 'Parbhani', NULL, NULL),
(366, 'Maharashtra', 'Pune', NULL, NULL),
(367, 'Maharashtra', 'Raigarh', NULL, NULL),
(368, 'Maharashtra', 'Ratnagiri', NULL, NULL),
(369, 'Maharashtra', 'Sangli', NULL, NULL),
(370, 'Maharashtra', 'Satara', NULL, NULL),
(371, 'Maharashtra', 'Sindhudurg', NULL, NULL),
(372, 'Maharashtra', 'Solapur', NULL, NULL),
(373, 'Maharashtra', 'Thane', NULL, NULL),
(374, 'Maharashtra', 'Wardha', NULL, NULL),
(375, 'Maharashtra', 'Washim', NULL, NULL),
(376, 'Maharashtra', 'Yavatmal', NULL, NULL),
(377, 'Manipur', 'Bishnupur', NULL, NULL),
(378, 'Manipur', 'Chandel', NULL, NULL),
(379, 'Manipur', 'Churachandpur', NULL, NULL),
(380, 'Manipur', 'Imphal East', NULL, NULL),
(381, 'Manipur', 'Imphal West', NULL, NULL),
(382, 'Manipur', 'Senapati', NULL, NULL),
(383, 'Manipur', 'Tamenglong', NULL, NULL),
(384, 'Manipur', 'Thoubal', NULL, NULL),
(385, 'Manipur', 'Ukhrul', NULL, NULL),
(386, 'Meghalaya', 'East Garo Hills', NULL, NULL),
(387, 'Meghalaya', 'East Khasi Hills', NULL, NULL),
(388, 'Meghalaya', 'Ribhoi', NULL, NULL),
(389, 'Meghalaya', 'South Garo Hills', NULL, NULL),
(390, 'Meghalaya', 'West Garo Hills', NULL, NULL),
(391, 'Meghalaya', 'West Jaintia Hills', NULL, NULL),
(392, 'Meghalaya', 'West Khasi Hills', NULL, NULL),
(393, 'Mizoram', 'Aizawl', NULL, NULL),
(394, 'Mizoram', 'Champhai', NULL, NULL),
(395, 'Mizoram', 'Kolasib', NULL, NULL),
(396, 'Mizoram', 'Lawngtlai', NULL, NULL),
(397, 'Mizoram', 'Lunglei', NULL, NULL),
(398, 'Mizoram', 'Mamit', NULL, NULL),
(399, 'Mizoram', 'Saiha', NULL, NULL),
(400, 'Mizoram', 'Serchhip', NULL, NULL),
(401, 'Nagaland', 'Dimapur', NULL, NULL),
(402, 'Nagaland', 'Kiphire', NULL, NULL),
(403, 'Nagaland', 'Kohima', NULL, NULL),
(404, 'Nagaland', 'Longleng', NULL, NULL),
(405, 'Nagaland', 'Mokokchung', NULL, NULL),
(406, 'Nagaland', 'Mon', NULL, NULL),
(407, 'Nagaland', 'Peren', NULL, NULL),
(408, 'Nagaland', 'Phek', NULL, NULL),
(409, 'Nagaland', 'Tuensang', NULL, NULL),
(410, 'Nagaland', 'Wokha', NULL, NULL),
(411, 'Nagaland', 'Zunheboto', NULL, NULL),
(412, 'Odisha', 'Anugul', NULL, NULL),
(413, 'Odisha', 'Balangir', NULL, NULL),
(414, 'Odisha', 'Baleshwar', NULL, NULL),
(415, 'Odisha', 'Bargarh', NULL, NULL),
(416, 'Odisha', 'Baudh', NULL, NULL),
(417, 'Odisha', 'Bhadrak', NULL, NULL),
(418, 'Odisha', 'Cuttack', NULL, NULL),
(419, 'Odisha', 'Debagarh', NULL, NULL),
(420, 'Odisha', 'Dhenkanal', NULL, NULL),
(421, 'Odisha', 'Gajapati', NULL, NULL),
(422, 'Odisha', 'Ganjam', NULL, NULL),
(423, 'Odisha', 'Jagatsinghapur', NULL, NULL),
(424, 'Odisha', 'Jajapur', NULL, NULL),
(425, 'Odisha', 'Jharsuguda', NULL, NULL),
(426, 'Odisha', 'Kalahandi', NULL, NULL),
(427, 'Odisha', 'Kandhamal', NULL, NULL),
(428, 'Odisha', 'Kendrapara', NULL, NULL),
(429, 'Odisha', 'Kendujhar', NULL, NULL),
(430, 'Odisha', 'Khordha', NULL, NULL),
(431, 'Odisha', 'Koraput', NULL, NULL),
(432, 'Odisha', 'Malkangiri', NULL, NULL),
(433, 'Odisha', 'Mayurbhanj', NULL, NULL),
(434, 'Odisha', 'Nabarangapur', NULL, NULL),
(435, 'Odisha', 'Nayagarh', NULL, NULL),
(436, 'Odisha', 'Nuapada', NULL, NULL),
(437, 'Odisha', 'Puri', NULL, NULL),
(438, 'Odisha', 'Rayagada', NULL, NULL),
(439, 'Odisha', 'Sambalpur', NULL, NULL),
(440, 'Odisha', 'Subarnapur', NULL, NULL),
(441, 'Odisha', 'Sundargarh', NULL, NULL),
(442, 'Puducherry', 'Karaikal', NULL, NULL),
(443, 'Puducherry', 'Mahe', NULL, NULL),
(444, 'Puducherry', 'Puducherry', NULL, NULL),
(445, 'Puducherry', 'Yanam', NULL, NULL),
(446, 'Punjab', 'Amritsar', NULL, NULL),
(447, 'Punjab', 'Barnala', NULL, NULL),
(448, 'Punjab', 'Bathinda', NULL, NULL),
(449, 'Punjab', 'Faridkot', NULL, NULL),
(450, 'Punjab', 'Fatehgarh Sahib', NULL, NULL),
(451, 'Punjab', 'Firozpur', NULL, NULL),
(452, 'Punjab', 'Gurdaspur', NULL, NULL),
(453, 'Punjab', 'Hoshiarpur', NULL, NULL),
(454, 'Punjab', 'Jalandhar', NULL, NULL),
(455, 'Punjab', 'Kapurthala', NULL, NULL),
(456, 'Punjab', 'Ludhiana', NULL, NULL),
(457, 'Punjab', 'Mansa', NULL, NULL),
(458, 'Punjab', 'Moga', NULL, NULL),
(459, 'Punjab', 'Muktsar', NULL, NULL),
(460, 'Punjab', 'Patiala', NULL, NULL),
(461, 'Punjab', 'Rupnagar', NULL, NULL),
(462, 'Punjab', 'Sahibzada Ajit Singh Nagar', NULL, NULL),
(463, 'Punjab', 'Sangrur', NULL, NULL),
(464, 'Punjab', 'Shahid Bhagat Singh Nagar', NULL, NULL),
(465, 'Punjab', 'Tarun Taran', NULL, NULL),
(466, 'Rajasthan', 'Ajmer', NULL, NULL),
(467, 'Rajasthan', 'Alwar', NULL, NULL),
(468, 'Rajasthan', 'Banswara', NULL, NULL),
(469, 'Rajasthan', 'Baran', NULL, NULL),
(470, 'Rajasthan', 'Barmer', NULL, NULL),
(471, 'Rajasthan', 'Bharatpur', NULL, NULL),
(472, 'Rajasthan', 'Bhilwara', NULL, NULL),
(473, 'Rajasthan', 'Bikaner', NULL, NULL),
(474, 'Rajasthan', 'Bundi', NULL, NULL),
(475, 'Rajasthan', 'Chittaurgarh', NULL, NULL),
(476, 'Rajasthan', 'Churu', NULL, NULL),
(477, 'Rajasthan', 'Dausa', NULL, NULL),
(478, 'Rajasthan', 'Dhaulpur', NULL, NULL),
(479, 'Rajasthan', 'Dungarpur', NULL, NULL),
(480, 'Rajasthan', 'Hanumangarh', NULL, NULL),
(481, 'Rajasthan', 'Jaipur', NULL, NULL),
(482, 'Rajasthan', 'Jaisalmer', NULL, NULL),
(483, 'Rajasthan', 'Jalor', NULL, NULL),
(484, 'Rajasthan', 'Jhalawar', NULL, NULL),
(485, 'Rajasthan', 'Jhunjhunu', NULL, NULL),
(486, 'Rajasthan', 'Jodhpur', NULL, NULL),
(487, 'Rajasthan', 'Karauli', NULL, NULL),
(488, 'Rajasthan', 'Kota', NULL, NULL),
(489, 'Rajasthan', 'Nagaur', NULL, NULL),
(490, 'Rajasthan', 'Pali', NULL, NULL),
(491, 'Rajasthan', 'Pratapgarh', NULL, NULL),
(492, 'Rajasthan', 'Rajsamand', NULL, NULL),
(493, 'Rajasthan', 'Sawai Madhopur', NULL, NULL),
(494, 'Rajasthan', 'Sikar', NULL, NULL),
(495, 'Rajasthan', 'Sirohi', NULL, NULL),
(496, 'Rajasthan', 'Sriganganagar', NULL, NULL),
(497, 'Rajasthan', 'Tonk', NULL, NULL),
(498, 'Rajasthan', 'Udaipur', NULL, NULL),
(499, 'Sikkim', 'East District', NULL, NULL),
(500, 'Sikkim', 'North District', NULL, NULL),
(501, 'Sikkim', 'South District', NULL, NULL),
(502, 'Sikkim', 'West District', NULL, NULL),
(503, 'Tamil Nadu', 'Ariyalur', NULL, NULL),
(504, 'Tamil Nadu', 'Chennai', NULL, NULL),
(505, 'Tamil Nadu', 'Coimbatore', NULL, NULL),
(506, 'Tamil Nadu', 'Cuddalore', NULL, NULL),
(507, 'Tamil Nadu', 'Dharmapuri', NULL, NULL),
(508, 'Tamil Nadu', 'Dindigul', NULL, NULL),
(509, 'Tamil Nadu', 'Erode', NULL, NULL),
(510, 'Tamil Nadu', 'Kancheepuram', NULL, NULL),
(511, 'Tamil Nadu', 'Kanniyakumari', NULL, NULL),
(512, 'Tamil Nadu', 'Karur', NULL, NULL),
(513, 'Tamil Nadu', 'Krishnagiri', NULL, NULL),
(514, 'Tamil Nadu', 'Madurai', NULL, NULL),
(515, 'Tamil Nadu', 'Nagapattinam', NULL, NULL),
(516, 'Tamil Nadu', 'Namakkal', NULL, NULL),
(517, 'Tamil Nadu', 'Perambalur', NULL, NULL),
(518, 'Tamil Nadu', 'Pudukkottai', NULL, NULL),
(519, 'Tamil Nadu', 'Ramanathapuram', NULL, NULL),
(520, 'Tamil Nadu', 'Salem', NULL, NULL),
(521, 'Tamil Nadu', 'Sivaganga', NULL, NULL),
(522, 'Tamil Nadu', 'Thanjavur', NULL, NULL),
(523, 'Tamil Nadu', 'The Nilgiris', NULL, NULL),
(524, 'Tamil Nadu', 'Theni', NULL, NULL),
(525, 'Tamil Nadu', 'Thiruvallur', NULL, NULL),
(526, 'Tamil Nadu', 'Thiruvarur', NULL, NULL),
(527, 'Tamil Nadu', 'Thoothukkudi', NULL, NULL),
(528, 'Tamil Nadu', 'Tiruchirappalli', NULL, NULL),
(529, 'Tamil Nadu', 'Tirunelveli', NULL, NULL),
(530, 'Tamil Nadu', 'Tiruppur', NULL, NULL),
(531, 'Tamil Nadu', 'Tiruvannamalai', NULL, NULL),
(532, 'Tamil Nadu', 'Vellore', NULL, NULL),
(533, 'Tamil Nadu', 'Viluppuram', NULL, NULL),
(534, 'Tamil Nadu', 'Virudhunagar', NULL, NULL),
(535, 'Tripura', 'Dhalai', NULL, NULL),
(536, 'Tripura', 'North Tripura', NULL, NULL),
(537, 'Tripura', 'South Tripura', NULL, NULL),
(538, 'Tripura', 'West Tripura', NULL, NULL),
(539, 'Uttar Pradesh', 'Agra', NULL, NULL),
(540, 'Uttar Pradesh', 'Aligarh', NULL, NULL),
(541, 'Uttar Pradesh', 'Allahabad', NULL, NULL),
(542, 'Uttar Pradesh', 'Ambedkar Nagar', NULL, NULL),
(543, 'Uttar Pradesh', 'Auraiya', NULL, NULL),
(544, 'Uttar Pradesh', 'Azamgarh', NULL, NULL),
(545, 'Uttar Pradesh', 'Baghpat', NULL, NULL),
(546, 'Uttar Pradesh', 'Bahraich', NULL, NULL),
(547, 'Uttar Pradesh', 'Ballia', NULL, NULL),
(548, 'Uttar Pradesh', 'Balrampur', NULL, NULL),
(549, 'Uttar Pradesh', 'Banda', NULL, NULL),
(550, 'Uttar Pradesh', 'Barabanki', NULL, NULL),
(551, 'Uttar Pradesh', 'Bareilly', NULL, NULL),
(552, 'Uttar Pradesh', 'Basti', NULL, NULL),
(553, 'Uttar Pradesh', 'Bijnor', NULL, NULL),
(554, 'Uttar Pradesh', 'Budaun', NULL, NULL),
(555, 'Uttar Pradesh', 'Bulandshahar', NULL, NULL),
(556, 'Uttar Pradesh', 'Chandauli', NULL, NULL),
(557, 'Uttar Pradesh', 'Chitrakoot', NULL, NULL),
(558, 'Uttar Pradesh', 'Deoria', NULL, NULL),
(559, 'Uttar Pradesh', 'Etah', NULL, NULL),
(560, 'Uttar Pradesh', 'Etawah', NULL, NULL),
(561, 'Uttar Pradesh', 'Faizabad', NULL, NULL),
(562, 'Uttar Pradesh', 'Farrukhabad', NULL, NULL),
(563, 'Uttar Pradesh', 'Fatehpur', NULL, NULL),
(564, 'Uttar Pradesh', 'Firozabad', NULL, NULL),
(565, 'Uttar Pradesh', 'Gautam Buddha Nagar', NULL, NULL),
(566, 'Uttar Pradesh', 'Ghaziabad', NULL, NULL),
(567, 'Uttar Pradesh', 'Ghazipur', NULL, NULL),
(568, 'Uttar Pradesh', 'Gonda', NULL, NULL),
(569, 'Uttar Pradesh', 'Gorakhpur', NULL, NULL),
(570, 'Uttar Pradesh', 'Hamirpur', NULL, NULL),
(571, 'Uttar Pradesh', 'Hardoi', NULL, NULL),
(572, 'Uttar Pradesh', 'Hathras', NULL, NULL),
(573, 'Uttar Pradesh', 'Jalaun', NULL, NULL),
(574, 'Uttar Pradesh', 'Jaunpur', NULL, NULL),
(575, 'Uttar Pradesh', 'Jhansi', NULL, NULL),
(576, 'Uttar Pradesh', 'Jyotiba Phule Nagar', NULL, NULL),
(577, 'Uttar Pradesh', 'Kannauj', NULL, NULL),
(578, 'Uttar Pradesh', 'Kanpur Dehat', NULL, NULL),
(579, 'Uttar Pradesh', 'Kanpur Nagar', NULL, NULL),
(580, 'Uttar Pradesh', 'Kanshiram Nagar', NULL, NULL),
(581, 'Uttar Pradesh', 'Kaushambi', NULL, NULL),
(582, 'Uttar Pradesh', 'Kheri', NULL, NULL),
(583, 'Uttar Pradesh', 'Kushinagar', NULL, NULL),
(584, 'Uttar Pradesh', 'Lalitpur', NULL, NULL),
(585, 'Uttar Pradesh', 'Lucknow', NULL, NULL),
(586, 'Uttar Pradesh', 'Mahoba', NULL, NULL),
(587, 'Uttar Pradesh', 'Mahrajganj', NULL, NULL),
(588, 'Uttar Pradesh', 'Mainpuri', NULL, NULL),
(589, 'Uttar Pradesh', 'Mathura', NULL, NULL),
(590, 'Uttar Pradesh', 'Maunath Bhanjan', NULL, NULL),
(591, 'Uttar Pradesh', 'Meerut', NULL, NULL),
(592, 'Uttar Pradesh', 'Mirzapur', NULL, NULL),
(593, 'Uttar Pradesh', 'Moradabad', NULL, NULL),
(594, 'Uttar Pradesh', 'Muzaffarnagar', NULL, NULL),
(595, 'Uttar Pradesh', 'Pilibhit', NULL, NULL),
(596, 'Uttar Pradesh', 'Pratapgarh', NULL, NULL),
(597, 'Uttar Pradesh', 'Rae Bareli', NULL, NULL),
(598, 'Uttar Pradesh', 'Rampur', NULL, NULL),
(599, 'Uttar Pradesh', 'Saharanpur', NULL, NULL),
(600, 'Uttar Pradesh', 'Sant Kabir Nagar', NULL, NULL),
(601, 'Uttar Pradesh', 'Sant Ravidas Nagar (Bhadohi)', NULL, NULL),
(602, 'Uttar Pradesh', 'Shahjahanpur', NULL, NULL),
(603, 'Uttar Pradesh', 'Shrawasti', NULL, NULL),
(604, 'Uttar Pradesh', 'Siddharthnagar', NULL, NULL),
(605, 'Uttar Pradesh', 'Sitapur', NULL, NULL),
(606, 'Uttar Pradesh', 'Sonbhadra', NULL, NULL),
(607, 'Uttar Pradesh', 'Sultanpur', NULL, NULL),
(608, 'Uttar Pradesh', 'Unnao', NULL, NULL),
(609, 'Uttar Pradesh', 'Varanasi', NULL, NULL),
(610, 'Uttarakhand', 'Almora', NULL, NULL),
(611, 'Uttarakhand', 'Bageshwar', NULL, NULL),
(612, 'Uttarakhand', 'Chamoli', NULL, NULL),
(613, 'Uttarakhand', 'Champawat', NULL, NULL),
(614, 'Uttarakhand', 'Dehradun', NULL, NULL),
(615, 'Uttarakhand', 'Haridwar', NULL, NULL),
(616, 'Uttarakhand', 'Nainital', NULL, NULL),
(617, 'Uttarakhand', 'Pauri Garhwal', NULL, NULL),
(618, 'Uttarakhand', 'Pithoragarh', NULL, NULL),
(619, 'Uttarakhand', 'Rudraprayag', NULL, NULL),
(620, 'Uttarakhand', 'Tehri Garhwal', NULL, NULL),
(621, 'Uttarakhand', 'Udham Singh Nagar', NULL, NULL),
(622, 'Uttarakhand', 'Uttarkashi', NULL, NULL),
(623, 'West Bengal', 'Bankura', NULL, NULL),
(624, 'West Bengal', 'Barddhaman', NULL, NULL),
(625, 'West Bengal', 'Birbhum', NULL, NULL),
(626, 'West Bengal', 'Dakshin Dinajpur', NULL, NULL),
(627, 'West Bengal', 'Darjiling', NULL, NULL),
(628, 'West Bengal', 'Haora', NULL, NULL),
(629, 'West Bengal', 'Hooghly', NULL, NULL),
(630, 'West Bengal', 'Jalpaiguri', NULL, NULL),
(631, 'West Bengal', 'Koch Bihar', NULL, NULL),
(632, 'West Bengal', 'Kolkata', NULL, NULL),
(633, 'West Bengal', 'Maldah', NULL, NULL),
(634, 'West Bengal', 'Murshidabad', NULL, NULL),
(635, 'West Bengal', 'Nadia', NULL, NULL),
(636, 'West Bengal', 'North Twenty Four Parganas', NULL, NULL),
(637, 'West Bengal', 'Paschim Medinipur', NULL, NULL),
(638, 'West Bengal', 'Purba Medinipur', NULL, NULL),
(639, 'West Bengal', 'Puruliya', NULL, NULL),
(640, 'West Bengal', 'South Twenty Four Parganas', NULL, NULL),
(641, 'West Bengal', 'Uttar Dinajpur', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_infos`
--

CREATE TABLE `client_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_infos`
--

INSERT INTO `client_infos` (`id`, `url`, `image`, `created_at`, `updated_at`) VALUES
(15, 'null', 'https://res.cloudinary.com/douuxmaix/image/upload/v1720452028/emafisg2wvs5silkygsv.jpg', '2024-07-08 15:20:29', '2024-07-08 15:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE `company_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_contact` varchar(255) NOT NULL,
  `company_timing` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `company_name`, `company_address`, `company_email`, `company_contact`, `company_timing`, `created_at`, `updated_at`) VALUES
(2, 'Travelauncher Solutions Private Limited', 'Sector 104, Noida, Uttar Pradesh 201304', 'info@launcherr.co', '', '10:00 AM to 5:00 PM IST', '2024-06-29 10:45:01', '2024-07-12 17:59:18');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_places` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`coupon_places`)),
  `discount` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `coupon_places`, `discount`, `created_at`, `updated_at`) VALUES
(11, 'LAUNCHERRSVX10', '\"[\\\"products\\\"]\"', 10.00, '2024-07-14 01:50:40', '2024-07-14 01:50:40'),
(12, 'n0in4fon0idwnc213', '\"[\\\"Travel\\\",\\\"Shoping\\\",\\\"Food\\\"]\"', 100.00, '2024-07-14 12:46:33', '2024-07-14 12:46:33'),
(13, 'n0in4fon0idwnc000', '\"[\\\"Travel\\\",\\\"Shoping\\\",\\\"Food\\\"]\"', 100.00, '2024-07-14 16:10:25', '2024-07-14 16:10:25'),
(14, 'n0in4fon0idwnc001', '\"[\\\"Travel\\\",\\\"Shoping\\\",\\\"Food\\\"]\"', 100.00, '2024-07-14 16:27:38', '2024-07-14 16:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `employer_profiles`
--

CREATE TABLE `employer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_profiles`
--

INSERT INTO `employer_profiles` (`id`, `user_id`, `company_name`, `company_website`, `address`, `about`, `city`, `state`, `country`, `created_at`, `updated_at`) VALUES
(1, 2, 'zarina infotech', 'http://launncherr.co', 'Ayodhya', 'ggggggggg', 'Ayodhya', 'up', 'uuuuu', '2024-06-28 14:49:07', '2024-08-05 07:33:53'),
(2, 4, 'MMR', 'https://www.google.co.uk/', 'Secret', 'I\'m Working for MMR', 'faridabad', 'Haryana', 'India', '2024-06-28 21:12:49', '2024-06-28 21:12:49'),
(3, 9, 'The Dhaba', 'https://www.dhaba.co', 'Something', 'I run a Dhaba', 'Delhi', 'Delhi', 'India', '2024-06-29 17:05:44', '2024-06-29 17:05:44'),
(6, 87, 'Sudama Private Limited', 'https://gigs.launcherr.co/', 'Plot Plot Plot 1122', 'Sudama good good great', 'Pratapgadh', 'Uttar Pradesh', 'India', '2024-11-19 17:19:40', '2024-11-19 17:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_posting`
--

CREATE TABLE `job_posting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_posting`
--

INSERT INTO `job_posting` (`id`, `user_id`, `title`, `description`, `short_description`, `duration`, `active`, `verified`, `created_at`, `updated_at`, `location`) VALUES
(44, 15, 'Photographer', 'As a Travel Destination Photographer, you will be responsible for capturing the essence and beauty of various travel destinations. Your role is crucial in showcasing the unique culture, landscapes, and experiences that each destination has to offer. This position requires a passion for travel, an eye for detail, and the ability to capture compelling visual narratives that resonate with our audience.\n\nResponsibilities:\n\nPhotography Sessions: Conduct photo shoots at designated travel destinations, ensuring high-quality images that highlight the destination\'s attractions and atmosphere.\n\nCreative Direction: Collaborate with our travel team to conceptualize and plan photo shoots that align with our brand and client expectations.\n\nPhoto Editing: Edit and retouch photos to enhance visual appeal while maintaining authenticity and integrity.\n\nContent Creation: Create engaging and visually compelling content for our website, social media platforms, marketing materials, and client presentations.\n\nResearch and Exploration: Stay updated on travel trends and destination insights to provide fresh perspectives and innovative photographic approaches.\n\nPerks:\nOpportunity to travel to exciting destinations and immerse yourself in different cultures.\n\nCompensation- ₹2000', 'As a Travel Destination Photographer, you will be responsible for capturing the essence and beauty of various travel destinations.', 10, 1, 1, '2024-07-14 00:42:31', '2024-07-24 20:54:39', 'North Goa'),
(47, 2, 'Model', 'Modelling Test Extensive test', 'This is also new new', 5, 0, 0, '2024-08-05 07:31:06', '2024-11-25 02:51:05', 'New Delhi'),
(49, 2, 'Test Job', 'Test Test Job Job', 'Test Job', 2, 0, 0, '2024-08-05 08:03:57', '2024-08-12 10:59:03', 'New Delhi'),
(50, 82, 'Photographer', 'Nature Photo Click', 'Nice Clicker', 5, 0, 0, '2024-11-15 10:58:18', '2024-11-25 02:51:23', 'New Delhi'),
(51, 87, 'Coder', 'Hackathon of Coders Gaming for coders to be held', 'Hackathon of Coders', 2, 0, 0, '2024-11-19 07:51:18', '2024-11-25 02:52:25', 'Gwalior');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_18_114119_create_permission_tables', 1),
(5, '2024_06_21_103919_jobs_table', 1),
(6, '2024_06_27_131144_add_verified_to_job_postings_table', 1),
(7, '2024_06_27_155415_add_user_id_to_job_posting_table', 2),
(8, '2024_06_28_115303_create_employer_profiles_table', 2),
(9, '2024_06_28_121215_add_user_id_to_employer_profiles_table', 2),
(11, '2024_06_28_221945_create_user_profiles_table', 4),
(12, '2024_06_28_225949_user_profile', 5),
(18, '2024_07_04_171050_add_location_to_job_posting', 11),
(19, '2024_07_04_174608_create_cities_table', 11),
(24, '2024_07_09_152637_increase_sub_heading_length_in_sections_table', 16),
(30, '2024_07_10_194029_create_subscription_cards_table', 22),
(50, '2024_11_08_173832_create_travel_histories_table', 42),
(53, '2024_11_14_083606_add_is_profile_to_user_profiles_table', 45);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 14),
(1, 'App\\Models\\User', 15),
(1, 'App\\Models\\User', 16),
(1, 'App\\Models\\User', 18),
(1, 'App\\Models\\User', 39),
(1, 'App\\Models\\User', 73),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 31),
(3, 'App\\Models\\User', 34),
(3, 'App\\Models\\User', 35),
(3, 'App\\Models\\User', 53),
(3, 'App\\Models\\User', 54),
(3, 'App\\Models\\User', 82),
(3, 'App\\Models\\User', 86),
(3, 'App\\Models\\User', 87),
(3, 'App\\Models\\User', 89),
(3, 'App\\Models\\User', 90),
(3, 'App\\Models\\User', 91),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25),
(4, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 27),
(4, 'App\\Models\\User', 28),
(4, 'App\\Models\\User', 29),
(4, 'App\\Models\\User', 30),
(4, 'App\\Models\\User', 32),
(4, 'App\\Models\\User', 33),
(4, 'App\\Models\\User', 36),
(4, 'App\\Models\\User', 37),
(4, 'App\\Models\\User', 38),
(4, 'App\\Models\\User', 40),
(4, 'App\\Models\\User', 41),
(4, 'App\\Models\\User', 42),
(4, 'App\\Models\\User', 43),
(4, 'App\\Models\\User', 44),
(4, 'App\\Models\\User', 45),
(4, 'App\\Models\\User', 46),
(4, 'App\\Models\\User', 47),
(4, 'App\\Models\\User', 48),
(4, 'App\\Models\\User', 49),
(4, 'App\\Models\\User', 50),
(4, 'App\\Models\\User', 51),
(4, 'App\\Models\\User', 52),
(4, 'App\\Models\\User', 55),
(4, 'App\\Models\\User', 56),
(4, 'App\\Models\\User', 57),
(4, 'App\\Models\\User', 58),
(4, 'App\\Models\\User', 59),
(4, 'App\\Models\\User', 60),
(4, 'App\\Models\\User', 61),
(4, 'App\\Models\\User', 62),
(4, 'App\\Models\\User', 63),
(4, 'App\\Models\\User', 64),
(4, 'App\\Models\\User', 65),
(4, 'App\\Models\\User', 66),
(4, 'App\\Models\\User', 67),
(4, 'App\\Models\\User', 68),
(4, 'App\\Models\\User', 69),
(4, 'App\\Models\\User', 70),
(4, 'App\\Models\\User', 71),
(4, 'App\\Models\\User', 72),
(4, 'App\\Models\\User', 74),
(4, 'App\\Models\\User', 75),
(4, 'App\\Models\\User', 76),
(4, 'App\\Models\\User', 77),
(4, 'App\\Models\\User', 78),
(4, 'App\\Models\\User', 79),
(4, 'App\\Models\\User', 80),
(4, 'App\\Models\\User', 81),
(4, 'App\\Models\\User', 83),
(4, 'App\\Models\\User', 84),
(4, 'App\\Models\\User', 85),
(4, 'App\\Models\\User', 88),
(4, 'App\\Models\\User', 92),
(4, 'App\\Models\\User', 93),
(4, 'App\\Models\\User', 94),
(4, 'App\\Models\\User', 95),
(4, 'App\\Models\\User', 96),
(4, 'App\\Models\\User', 97),
(4, 'App\\Models\\User', 98),
(4, 'App\\Models\\User', 99),
(4, 'App\\Models\\User', 100),
(4, 'App\\Models\\User', 101),
(4, 'App\\Models\\User', 102),
(4, 'App\\Models\\User', 103),
(4, 'App\\Models\\User', 104),
(4, 'App\\Models\\User', 105),
(4, 'App\\Models\\User', 106),
(4, 'App\\Models\\User', 107),
(4, 'App\\Models\\User', 108),
(4, 'App\\Models\\User', 109);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'delete user', 'web', '2024-06-27 13:53:06', '2024-06-27 13:53:06'),
(2, 'view payment', 'web', '2024-06-27 13:53:06', '2024-06-27 13:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `que_and_ans`
--

CREATE TABLE `que_and_ans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Question` text NOT NULL,
  `Answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `que_and_ans`
--

INSERT INTO `que_and_ans` (`id`, `Question`, `Answer`, `created_at`, `updated_at`) VALUES
(31, 'What services does Launcherr offer?', 'At Launcherr, we take travel seriously. We understand the costs involved and do the groundwork to bring you the best deals on flights, buses, accommodations, and rentals. But that\'s just the beginning! We\'re also about turning your travels into opportunities. Whether you\'re capturing moments, indulging in local flavors, or exploring exotic locales through house-sitting gigs, we\'ve got options to help fund your adventures. Additionally, we offer a handpicked selection of travel essentials—from tech gadgets to cozy must-haves—carefully curated by seasoned travelers who know what you need on the road.', '2024-07-14 00:06:28', '2024-07-14 00:06:28'),
(32, 'How can I contact Launcherr?', 'You can contact Launcherr via email at info@launcherr.co. Our customer support team is available from 10:00 AM to 5:00 PM IST. For queries regarding specific services, please use the following emails: ● For Gigs: gigssupport@launcherr.co ● For Products: productsupport@launcherr.co', '2024-07-14 01:20:45', '2024-07-14 01:20:45'),
(33, 'Can Launcherr help with visa and passport requirements?', 'Currently, we do not directly handle visa and passport applications. We recommend contacting the respective consulate or embassy for detailed guidance.', '2024-07-14 01:21:27', '2024-07-14 01:21:27'),
(34, 'Can I make changes or cancel my travel booking through Launcherr?', 'Yes, you can manage your bookings online through our website. Depending on the travel provider\'s policies, you may be able to make changes or cancel your booking directly through our platform.', '2024-07-14 01:22:04', '2024-07-14 01:22:04'),
(35, 'Is it safe to shop on Launcherr?', 'Yes, Launcherr prioritizes the security of your personal information and transactions. We use secure payment gateways and encryption technology to protect your data.', '2024-07-14 01:22:37', '2024-07-14 03:55:02'),
(36, 'How can I track my product order on Launcherr?', 'Once your order is confirmed, you will receive a confirmation email with tracking information. You can also log in to your Launcherr account to track the status of your order in real-time.', '2024-07-14 03:54:10', '2024-07-14 03:54:10'),
(37, 'Can I return or exchange products purchased on Launcherr?', 'Yes, Launcherr has a return and refund policy that allows you to return eligible products within a specified period. Please refer to our Return/Refund page or contact customer support for details.', '2024-07-14 03:56:07', '2024-07-14 03:56:07'),
(38, 'Does Launcherr offer international shipping?', 'No, currently we do not offer international shipping. We only offer domestic shipping within India.', '2024-07-14 04:00:22', '2024-07-14 04:00:22'),
(39, 'How do I subscribe to Launcherr’s subscription service?', 'You can subscribe to Launcherr\'s subscription service by visiting our website and selecting the subscription plan that best suits your needs. Follow the prompts to create an account and enter your payment information.', '2024-07-14 04:00:58', '2024-07-14 04:00:58'),
(40, 'How often will I be billed for my subscription?', 'Billing frequency varies depending on the subscription plan you choose. Typically, subscriptions are billed monthly, annually, or as specified in the subscription terms.', '2024-07-14 04:01:29', '2024-07-14 04:01:29'),
(41, 'Can I cancel my subscription?', 'Yes, you can cancel your subscription at any time. Visit your account settings on our website or contact customer support to manage your subscription preferences. Please note any cancellation policies or fees that may apply.', '2024-07-14 04:01:55', '2024-07-14 04:01:55'),
(42, 'Is there a trial period for Launcherr’s subscription service?', 'Some subscription plans may offer a trial period or introductory offer. Details about trial periods, if available, will be specified on our website or during the subscription sign-up process.', '2024-07-14 04:02:40', '2024-07-14 04:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'api', '2024-06-27 13:52:01', '2024-06-27 13:52:01'),
(2, 'manager', 'web', '2024-06-27 13:52:01', '2024-06-27 13:52:01'),
(3, 'employer', 'web', '2024-06-27 13:52:01', '2024-06-27 13:52:01'),
(4, 'user', 'api', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub-heading` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section`, `heading`, `created_at`, `updated_at`, `sub-heading`) VALUES
(10, 'Products', 'Tiny Treasures For Big Adventures', '2024-07-04 19:56:05', '2024-07-10 11:04:01', NULL),
(11, 'Deals', 'Fly High with our Sky-High Deals!', '2024-07-04 19:56:39', '2024-07-10 11:02:41', NULL),
(12, 'Subscription', 'Subscriptions', '2024-07-04 19:57:37', '2024-08-20 09:54:47', NULL),
(13, 'Gigs', 'Turn your wanderlust into cash!', '2024-07-04 19:57:57', '2024-07-10 11:06:28', NULL),
(14, 'Destination', 'Escape the Ordinary', '2024-07-04 19:58:54', '2024-07-10 10:50:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1ddBfHYQ4Lpe5sKlflzbEXyeXB0T5UL2IrVOIjBy', NULL, '143.198.46.93', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOEpmNm5sbVhwQ3c3NUY1SzlaRWgyMzhjWUNwNGhOaDZIWUN6cTBlRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733795472),
('3kWZINeCH5gfrREEAdSl1lB9bTitmKvM45Jia6as', NULL, '91.84.87.137', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaTBTTGh3M2JFY2ltYmIyS0lnV3M4REVIT09oMmNQUTlUVE1DUXI4cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734141858),
('4emCyATB5BGIUbtk8mkEm9peDAxkPU8EDXf4oYAe', NULL, '192.99.37.132', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzZuMGdPb0pPNjgyUjQ3b2txVjljMjZtQWxoSTZlTFJ5dHlFQkpuOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734336453),
('6goMaX0pOYZ1dZoACGMMEZPX3caRysMJh8x2Nqyi', NULL, '205.210.31.223', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNEU1cDFjaUZ5WEhmZzFSUzB0clhTaXB5aHY2aW1LVXBRMHBWQVZkQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733887161),
('7OBYi0WL4rXpY2k30DY9YXE3LC4xEyqiUtKMbknz', NULL, '205.210.31.183', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidVYyMDVFZmxZcmh4UWVGSzVDMmx5NXdoMGJSellhZmRINU1oWDNNbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734033111),
('7tBjZoJKtCzonG4zeplc9e76PMQhWstiPaC3gJ1w', NULL, '167.94.146.55', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNDloam53bFE0aGdySEk5eEU4MnhWYnNkeHBNS2E4dEx2NGN3SzhBZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733706513),
('9nXGWmDLkYfDbyQc0sN2orltUMIR4T5nG2PoBwlo', NULL, '167.94.146.51', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHNXemxyOGZ0SVY3N2VXbnBYaHVaaVZNWlNOWnd2bGRCcmtZd3FneiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733703292),
('9P28NbQk42daVWwcyYkrEyEws8zHhJJZ5MyDBGtZ', NULL, '198.235.24.219', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFhaTGpPeGlsa1g2cm1IWDA0V1Q1cjZJUDdIZ0Jxc2pTUVZwVkplbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734459920),
('C964zUcIXRVU75NpvlVBYXZsRvq0KaAGq1giSGl3', NULL, '164.90.197.156', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTAyR1dmNktNQXJ1ZXpEVUplQkxUR29BUEdwcnRtbWloV0gxOHJ4byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733625312),
('CgBbd2778A0g4ok6jnIipqW3V518d9HasQoqAC6m', NULL, '34.41.63.187', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVNVWlQ3YlFTSXFuZGJtM0x0RU5QblI0Y1cydXFsRkR4YVQ5Z0MxRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734152229),
('EJQeikvDTzLM9MZKIfNV2j2KQAdjrgi6oVjklmPU', NULL, '35.92.148.115', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1N2M1NKRm80OUd3THQwZFRYQ3pOcWxSWXVrQ2F4S3duR2JnbFF5aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733711743),
('Fmfuuk93Vu3r7lN92rwl2omFXJdBx0VLvXT9rBMY', NULL, '54.88.179.33', 'Mozilla/5.0 \\(Windows NT 10.0\\; Win64\\; x64\\) AppleWebKit/537.36 \\(KHTML, like Gecko\\) Chrome/100.0.4896.60 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWNrdFFDODVZSzNiVkRCTmxaOW1QRkJ0Q1dhWnJ4YkZIN3RxdmM3aCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733793772),
('g5MMs3IhVAUH6Ef74M7oLvXtkMUAsGOfRLykXzKY', NULL, '99.255.100.228', 'Mozilla/5.0 (compatible; Domains Project/1.3.7; +https://domainsproject.org)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNFJNNTZaUjJxY3N1em92d2ZJR1RLdndZOWE3Tmwwdm05UEpSRHIzSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28vc2lnbnVwIjt9fQ==', 1733962340),
('glh5U67LgOoqMtn7Wi2iSUUBRfYXWVAA9NqpIF9g', NULL, '44.244.221.149', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTGVQUzVBZnp3aHA0R1hwMGNLWTR0eVRmVFRRbGFUb3BUVFE3S3JnRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733732214),
('i7KssQ2alSAowdMyJT6rQPJMoatsfFcRjfRXL1zG', NULL, '192.99.15.17', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEpXQTFMaUllQjZYdDdxbDBEdVRYVUllVjBoaWxaU29XUjFjMEVMTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28vc2lnbnVwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1734383144),
('n85xVFP0c3D7KQfhCf1A9HnCNgAt3gphDgsb8sNV', NULL, '206.168.34.40', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaUlvRkFzeFFFSUs2SEVBRHFTaFRzczljblNPN0Yyb0lFaWVwd3BJciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733776466),
('QgWyBZhLu18ai13MSJVPrXl9UOX4eYMPdTG76xvV', NULL, '198.235.24.161', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiem9wVkdpV1Fab2pHNUVTVjdnU1dHWTZmWWp6NXpQa1VZV1dZdmlzbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734136161),
('Rr69mWm0DK8GJCp0q0mBxNEDPG0IB8E6OeDg3neW', NULL, '152.58.129.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmpoUVFneWVmNUxpaEpLeEFKZzhBWFBXUmh0ZEJuZ3pHelRHblltcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733716571),
('tZwF9t4g3Mx09x0iIiL6x8My6F2qwvcH6QYTjm07', NULL, '198.235.24.139', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2l1TmxBV0hFNFJvdnhlMjk4a29kemh0VVlPZFRqYzBtNjRTZTlhRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734200387),
('uAKjdQmnxL8u79xVflyeXqyqvOKa6mZBrW1yefm7', NULL, '35.91.85.225', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEJOQ1VKNVVHMWNBMGZCRWxXM2tNR05aSld5WGlXVm5ydjZHTWhUayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733712043),
('uoNq8M53WEr7FqBBsQCRw6J3PlssXeYONVObeAlH', NULL, '199.45.154.118', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid043UkQxV0xZbjBLRnhzODYyRDFiVU1TNE1PeW9XYm8zRk54dnRKWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733777646),
('W25M7uBBCjLm5xmyzPwQZNoSxbsC6BGbJ8OsOarb', NULL, '54.88.179.33', 'Mozilla/5.0 \\(Windows NT 10.0\\; Win64\\; x64\\) AppleWebKit/537.36 \\(KHTML, like Gecko\\) Chrome/100.0.4896.60 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmpSUFBVRmdWVlVVYnRrZWFUTjFyT2FuRjhncjNzSkFUS080NVVONyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733793769),
('zawsLlGsNNEtB8gAr6dF1rODNQaGNJdXbRX8Xf6I', NULL, '34.41.63.187', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib24xNmViMFlNbE9JTGY2d2xsZGlFMG1GRE5YQXYyOXpRdklBa0ZMZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZ2lncy5sYXVuY2hlcnIuY28iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1734152225);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_cards`
--

CREATE TABLE `subscription_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `card_no` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `price_2` varchar(255) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`features`)),
  `buttonLabel` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_cards`
--

INSERT INTO `subscription_cards` (`id`, `card_no`, `title`, `price`, `price_2`, `features`, `buttonLabel`, `created_at`, `updated_at`) VALUES
(1, '1', 'Free', '0', NULL, '[\"Free Gigs, Free Booking, Free Coupons\"]', 'Choose Plan', '2024-07-11 02:14:04', '2024-07-14 09:02:11'),
(2, '2', 'Pro', '129', '0', '[null]', 'Choose Plan', '2024-07-11 02:17:26', '2024-08-26 08:39:54'),
(3, '3', 'Enterprise', 'Let\'s Talk', NULL, '[\"All pro features\",\"Dedicated environment\",\"Enterprise account administration\",\"Premium support and services\"]', 'Choose Plan', '2024-07-11 02:18:34', '2024-07-11 02:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `terms_conditions`
--

CREATE TABLE `terms_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_conditions`
--

INSERT INTO `terms_conditions` (`id`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Terms', '2024-06-29 10:13:37', '2024-07-04 19:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `isProfile` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `isProfile`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 0, 'Shubhang Verma', 'shubhang554@gmail.com', NULL, '$2y$12$Kvt/Gk/ctI0NQMW1TEpqEu7hvuXsXQzxYtKBCGZ06UHS0c4pVWGZm', NULL, '2024-06-27 13:54:11', '2024-06-27 13:54:11'),
(4, 0, 'Employer', 'launcher@Employer.co', NULL, '$2y$12$A7NByXdU/SBLonSqIKyr8uA1QZX7KxhFkCR6dBOkdWxuUfL5tISby', NULL, '2024-06-27 14:27:31', '2024-06-27 14:27:31'),
(6, 0, 'Jagdish', 'jagdish@Employer.co', NULL, '$2y$12$isfWo6q68PZcvAWeknEyz.JhQpWanH8A//PxGUoZj91tcCQKfASoi', NULL, '2024-06-28 15:01:21', '2024-06-28 15:01:21'),
(9, 0, 'Jassi', 'employer@Jassi.co', NULL, '$2y$12$aBa0g7V8l14bhTAFnB0j1e25Joo62dr/a4rA.zgAIqLK5iQDDv0Yq', NULL, '2024-06-29 17:03:39', '2024-06-29 17:03:39'),
(15, 0, 'Launcherr Admin', 'info@launcherr.co', NULL, '$2y$12$zHNOtdnjQZnDQHXvRgyMtO6BSLIAbjicVvBqrr6AJe14S9237jymW', NULL, '2024-06-30 16:51:40', '2024-06-30 16:51:40'),
(22, 0, 'Akash', 'akash@gmail.com', NULL, '$2y$12$P5fMFqA7EID7Vbto/udqQ.B5aewfGWRVyN7Ty3x8OiLw5UgiKxgFu', NULL, '2024-07-01 22:58:59', '2024-07-02 02:12:29'),
(23, 0, 'Akash Shrestha', 'akash2@gmail.com', NULL, '$2y$12$P8FiPtJkJVClFCELjIkNhOsmhpA4GPi0skJ5VQauOC.IvGnEzEFOW', NULL, '2024-07-01 23:16:51', '2024-07-01 23:16:51'),
(31, 0, 'Sarthak Gupta', 'sarthakg@launcherr.co', NULL, '$2y$12$HllYFyHC2qtZzsMKnNfQl.43r/bYEAe7y.H8biXGhcFLwWRdc.4w2', NULL, '2024-07-02 12:45:53', '2024-07-02 12:45:53'),
(37, 0, 'phunsuk  jatav', 'phunsukj@gmail.com', NULL, '$2y$12$JPxgikteHUQ4wPvOCD1tw.ATbIHphyWy7MVmICEIKqa88gjWXz8.O', NULL, '2024-07-04 18:24:22', '2024-07-04 18:24:22'),
(40, 0, 'Manas', 'manas@gmail.com', NULL, '$2y$12$TE9NkFpO1otEZKsFmt1ELeFOWiftpfEbpJ8vTCfNP02VcQCLvarwq', NULL, '2024-07-14 20:24:46', '2024-07-14 20:24:46'),
(51, 0, 'Akash Shrestha', 'akashshrestha0399@gmail.com', NULL, '$2y$12$G0D649xf8mG22bxleGX2wemYiMgCkGVDWaf2JVKr1/5rIadibZcBq', NULL, '2024-07-15 17:17:08', '2024-07-15 17:17:08'),
(52, 1, 'Jagdish', 'adhikarijagdish@gmail.com', NULL, '$2y$12$qiVafoeY6PXlZWTPLMAVv.5vZfqAZaZX9xU9B02Lcsiu.armMgBL.', NULL, '2024-07-15 17:32:41', '2024-11-13 08:24:05'),
(55, 0, 'shubhang v', 'test@phonepe.com', NULL, '$2y$12$Mc5orxpw3GCbEZn1FvDbi.yGJ.2jHDNDkKoyNVnrqVVN4smyVqzRO', NULL, '2024-07-18 05:28:39', '2024-07-18 05:28:39'),
(59, 0, 'maya', 'maya@gmail.com', NULL, '$2y$12$gUC3KwQiqBTgy711CJywBON9eHs8u8XXToJqVarQdyP2bWgKVxsQS', NULL, '2024-08-01 07:30:32', '2024-08-01 07:30:32'),
(60, 0, 'Saikat Das', 'saiki.das@gmail.com', NULL, '$2y$12$rvpGuF73hJOgY4d1wPHvR.7PDc37zlJUUJ7rm0dR9dpySn7g3rMoq', NULL, '2024-08-01 12:07:46', '2024-08-01 12:07:46'),
(67, 0, 'Nitin Saini', 'nitinsaini@launcherr.co', NULL, '$2y$12$oVpvoANnImz6lmaGPOT.UeBBiOAI9jc2WZ2mQuuofjXpt6aiVaPi6', NULL, '2024-08-02 11:41:06', '2024-08-02 11:41:06'),
(69, 0, 'Rahul Singh', 'rahul.rajawat@niyoin.com', NULL, '$2y$12$vxFZmeEYvFU.FLD73ous5Oh.zCUbHoPa4DTQQE/INcqw.ajy3nVxO', NULL, '2024-08-06 14:31:19', '2024-08-06 14:31:19'),
(72, 0, 'Nitin Saini', 'nitinsaini.275@gmail.com', NULL, '$2y$12$vg/LZ7W84uHw93ivF8105efbW/tOTtpjmDbikpupwRrwFHnCKiBKS', NULL, '2024-10-29 04:46:31', '2024-10-29 04:46:31'),
(73, 0, 'Admin', 'Admin@Launcherr.co', NULL, '$2y$12$nz.iMAt/pzLv00Jm2TgAS.uLVNsb0l2Sva3yokF/8wwwCSS/1BDLu', NULL, '2024-11-11 06:25:39', '2024-11-11 06:25:39'),
(77, 0, 'nitin', 'nitinkumar@yopmail.com', NULL, '$2y$12$4pRQPoYoJi2viyEIJ3wFauI6iH9jvSdZrJm.yvph0deHLNvprWRDK', NULL, '2024-11-14 08:15:56', '2024-11-14 10:03:34'),
(80, 1, 'Dipankar', 'dipankar.skypoint@gmail.com', NULL, '$2y$12$ztMkfWuyWHl7vGkb3UME3O0fHpN5T9Cdr272fqYuLWL0VjHIG1GUK', NULL, '2024-11-14 13:34:46', '2024-11-14 13:37:08'),
(81, 1, 'ashok', 'bhat.ashok@gmail.com', NULL, '$2y$12$gdSCPCPOEzqf813I4Lo7zO7colkzlukuA0JaA8rMB31w9Q.7reF5O', NULL, '2024-11-14 15:28:13', '2024-11-14 15:29:24'),
(82, 0, 'Sarthak Gupta', 'sarthakguptask.ai@gmail.com', NULL, '$2y$12$ooQmKyR8yQXOSF2RB8hFy.8FpCkwQl1vcfGhDKGf3GzKPR9bZYf46', NULL, '2024-11-15 10:51:58', '2024-11-15 10:51:58'),
(83, 1, 'MMR', 'devmmr069@gmail.com', NULL, '$2y$12$DFpKAXduQ/eYRy8IlRV0ZuIBGih9PhforspcirwvkHS2eXke699au', NULL, '2024-11-15 11:32:29', '2024-11-15 11:38:35'),
(85, 1, 'Nitin', 'nitinsaini8030@gmail.com', NULL, '$2y$12$fTwHuoPVrg3uEiZr0.SEdeZKrs57fOt7c3O50E.0hj7a6274dbpVK', NULL, '2024-11-15 13:43:13', '2024-11-19 11:17:51'),
(86, 0, 'MMR Solutions', 'akash03299@gmail.com', NULL, '$2y$12$wYOex5fdGeDZudeFTNwO7.nflbh/eGJVnBfykMDYqur8fJrzfEUAu', NULL, '2024-11-19 07:47:09', '2024-11-19 07:47:09'),
(87, 0, 'MMR Solutions', 'devmmr079@gmail.com', NULL, '$2y$12$edyRu4wgrWw5RyqpVOXsGufiwVruJnwSW7/HHiWe9gvNi6YKJwJ66', NULL, '2024-11-19 07:47:49', '2024-11-19 07:47:49'),
(89, 0, 'Shubhang Verma', 'sss@dd.co', NULL, '$2y$12$Mo3FC1dH//VhUwS7cm0lGuQG/CzXXGE1tnH/vWxPyvnflx9PbeZru', NULL, '2024-11-19 10:32:13', '2024-11-19 10:32:13'),
(92, 1, 'Qwerty', 'shubhang9verma@gmail.com', NULL, '$2y$12$snvzwq4nN7xLguwwbiu.HeQhywp8VrGAzGEWg3QTfuL7mSP7gkZGi', NULL, '2024-11-19 14:10:42', '2024-11-19 14:14:42'),
(93, 1, 'LALIT', 'lalit@dotmik.com', NULL, '$2y$12$EamT0z.CfTjqWvW8Uyw1nuE.eb88FYhV65Qx3CW28nI9Uq2EH0T9a', NULL, '2024-11-22 14:00:55', '2024-11-22 14:02:26'),
(97, 1, 'Aman', 'amank6209@gmail.com', NULL, '$2y$12$U9SHKZ0WBrAuS0y2InBn0OHhkZd2cvi7bQ2uHg9chSOPVHaDXJFse', NULL, '2024-12-09 03:59:37', '2024-12-09 10:55:22'),
(101, 0, 'Nitin', 'nitinsaini8274@gmail.com', NULL, '$2y$12$/P4qWBdD.qOOrVOmzF6/LuZQgFmjLKvHUl3p6GzfZlGjuiF3v2SHO', NULL, '2024-12-09 07:13:30', '2024-12-09 07:13:30'),
(104, 0, 'nitin', 'nitin121@yopmail.com', NULL, '$2y$12$y3aWrqW.6hN8XzYnYK49WuV6GrQvW1WuffcAvAGCymEA4wNZkg2ya', NULL, '2024-12-09 11:06:20', '2024-12-09 11:06:20'),
(105, 0, 'Sarthak', 'Sarthakg+customer@launcherr.co', NULL, '$2y$12$DL1tVVgVfWYD0OaxL7shEuAj0121s4wy/3QzcGnBhA2CMyCZ7vNw2', NULL, '2024-12-10 11:28:20', '2024-12-10 11:28:20'),
(108, 1, 'Jagdish', 'adhikarijagdish3@gmail.com', NULL, '$2y$12$XA11qrBkvKQiMAh2LxJWEuRHE/MZLxRCUhi00cKDxCw64FdjYaKkm', NULL, '2024-12-16 06:25:42', '2024-12-16 06:27:18'),
(109, 1, 'Aman', 'amankumar@launcherr.co', NULL, '$2y$12$aIDwNkJHh2SnT0Pv.T8.AOJWPF4xcqsWQQUpvr0XNNh4Q/vsgWuLe', NULL, '2024-12-16 07:10:41', '2024-12-16 07:12:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_Number` bigint(20) UNSIGNED DEFAULT NULL,
  `user_Address` varchar(255) NOT NULL,
  `user_City` varchar(255) NOT NULL,
  `user_State` varchar(255) NOT NULL,
  `user_Country` varchar(255) NOT NULL,
  `user_PinCode` varchar(255) NOT NULL,
  `user_AboutMe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `user_Number`, `user_Address`, `user_City`, `user_State`, `user_Country`, `user_PinCode`, `user_AboutMe`, `created_at`, `updated_at`) VALUES
(8, 22, 987654321, 'Gali No. 91, Manas ke ghar ke paas', 'Delhi', 'New Delhi', 'India', '110014', 'Developer bna do bhai', '2024-07-02 15:02:01', '2024-07-02 15:02:01'),
(9, 52, 9910179390, 'Faridabad', 'faridabad', 'haryana', 'india', '121013', 'hello i am jagdish', '2024-08-05 08:34:29', '2024-11-25 09:54:57'),
(11, 37, 8700125888, '210, Bhikhapur Ayodhya', 'Ayodhya', 'Uttar Pradesh', 'India', '201507', 'We are phunsuk', '2024-08-26 10:12:39', '2024-11-15 01:09:40'),
(17, 80, 7003824164, 'Airport', 'Kolkata', 'WB', 'India', '700059', 'Thanks', '2024-11-14 13:37:07', '2024-11-14 13:37:07'),
(18, 81, 9890535045, 'plot no.8, mig-enclave, new cidco', 'nashhik', 'maharashtra', 'india', '422009', 'Interested in OTA', '2024-11-14 15:29:23', '2024-11-14 15:29:23'),
(19, 83, 9161760876, '210, Bhikhapur Ayodhya', 'Ayodhya', 'Uttar Pradesh', 'India', '201509', 'NS', '2024-11-15 11:38:34', '2024-11-24 17:17:57'),
(22, 85, 9560767761, 'B-192Arjun Nagar Green Park Main', 'Delhi', 'Delhi', 'India', '110029', 'sahflsdjglad', '2024-11-19 11:17:50', '2024-11-19 11:17:50'),
(23, 92, 9161760877, 'Ggggh', 'faizabad', 'Up', 'india', '224001', 'Yhgghgghg', '2024-11-19 14:14:41', '2024-11-19 14:14:41'),
(24, 93, 9910586457, 'najafgarh', 'NEW DELHI', 'DELHI', 'INDIA', '110043', 'BOOKING', '2024-11-22 14:02:25', '2024-11-22 14:02:25'),
(32, 108, 9910179300, 'surya nagar phase 1 sector 91', 'faridabad', 'Haryana', 'India', '121013', 'Nothing', '2024-12-16 06:27:17', '2024-12-16 06:27:17'),
(33, 109, 8853309666, 'koilikhal', 'gorakhpur', 'uttar pradesh', 'India', '273412', 'abc', '2024-12-16 07:12:48', '2024-12-16 07:12:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_news`
--
ALTER TABLE `banner_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_infos`
--
ALTER TABLE `client_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_coupon_code_unique` (`coupon_code`);

--
-- Indexes for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_posting_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `que_and_ans`
--
ALTER TABLE `que_and_ans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscription_cards`
--
ALTER TABLE `subscription_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_profiles_user_number_unique` (`user_Number`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner_news`
--
ALTER TABLE `banner_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=642;

--
-- AUTO_INCREMENT for table `client_infos`
--
ALTER TABLE `client_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_posting`
--
ALTER TABLE `job_posting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `que_and_ans`
--
ALTER TABLE `que_and_ans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subscription_cards`
--
ALTER TABLE `subscription_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  ADD CONSTRAINT `employer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD CONSTRAINT `job_posting_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
