-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 01:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rposystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `rpos_admin`
--

CREATE TABLE `rpos_admin` (
  `admin_id` varchar(200) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_admin`
--

INSERT INTO `rpos_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
('10e0b6dc958adfb5b094d8935a13aeadbe783c25', 'Admin', 'admin@mail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_customers`
--

CREATE TABLE `rpos_customers` (
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phoneno` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_customers`
--

INSERT INTO `rpos_customers` (`customer_id`, `customer_name`, `customer_phoneno`, `customer_email`, `created_at`) VALUES
('06549ea58afd', 'Ana J. Browne', '4589698780', 'anaj@mail.com', '2022-09-03 12:39:48.523820'),
('1da1f018cec0', 'Anjor', '7049242133', '', '2024-06-17 07:49:03.912129'),
('1fc1f694985d', 'Jane Doe', '2145896547', 'janed@mail.com', '2022-09-03 13:39:13.076592'),
('27e4a5bc74c2', 'Tammy R. Polley', '4589654780', 'tammy@mail.com', '2022-09-03 12:37:47.049438'),
('29c759d624f9', 'Trina L. Crowder', '5896321002', 'trina@mail.com', '2022-09-03 13:16:18.927595'),
('35135b319ce3', 'Christine Moore', '7412569698', 'customer@mail.com', '2022-09-12 10:14:03.079533'),
('3859d26cd9a5', 'Louise R. Holloman', '7856321000', 'holloman@mail.com', '2022-09-03 12:38:12.149280'),
('3df17d13c4ac', 'Akhilesh Bhosale', '8847727212', '', '2024-06-18 07:18:26.410837'),
('57b7541814ed', 'Howard W. Anderson', '8745554589', 'howard@mail.com', '2022-09-03 08:35:10.959590'),
('7c8f2100d552', 'Melody E. Hance', '3210145550', 'melody@mail.com', '2022-09-03 13:16:23.996068'),
('9c7fcc067bda', 'Delbert G. Campbell', '7850001256', 'delbert@mail.com', '2022-09-03 12:38:56.944364'),
('9e5e95a9010c', 'Akhilesh Bhosale', '9732873282', 'akki@gmail.com', '2024-06-14 18:27:57.569953'),
('9f6378b79283', 'William C. Gallup', '7145665870', 'william@mail.com', '2022-09-03 12:39:26.507932'),
('cc3140873376', 'nita', '213213213', '', '2024-06-17 18:30:40.086033'),
('d0ba61555aee', 'Jamie R. Barnes', '4125556587', 'jamie@mail.com', '2022-09-03 12:36:59.643216'),
('d7c2db8f6cbf', 'Victor A. Pierson', '1458887896', 'victor@mail.com', '2022-09-03 12:37:21.568155'),
('e711dcc579d9', 'Julie R. Martin', '3245557896', 'julie@mail.com', '2022-09-03 12:38:33.397498'),
('fe6bb69bdd29', 'Brian S. Boucher', '1020302055', 'brians@mail.com', '2022-09-03 13:16:29.591980');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_orders`
--

CREATE TABLE `rpos_orders` (
  `order_id` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `prod_qty` varchar(200) NOT NULL,
  `order_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_orders`
--

INSERT INTO `rpos_orders` (`order_id`, `order_code`, `customer_id`, `customer_name`, `prod_id`, `prod_name`, `prod_price`, `prod_qty`, `order_status`, `created_at`) VALUES
('019661e097', 'AEHM-0653', '06549ea58afd', 'Ana J. Browne', 'bd200ef837', 'Turkish Coffee', '8', '1', 'Paid', '2022-09-03 13:26:00.389027'),
('140d08d7b3', 'OSQR-5218', '1fc1f694985d', 'Jane Doe', '8e23aebda6', 'Whole Wheat Bread', '10', '1', '', '2024-06-19 09:10:44.382968'),
('7d711cfefe', 'PFCO-8640', '1da1f018cec0', 'Anjor', '005018bc24', 'Chicken Loaded Nachos', '110', '1', 'paid', '2024-06-19 10:42:36.964796'),
('dea4df8be8', 'PFCO-8640', '1da1f018cec0', 'Anjor', '25dfa8d3ee', 'Classic Nachos', '60', '2', 'paid', '2024-06-19 10:42:36.964796');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_pass_resets`
--

CREATE TABLE `rpos_pass_resets` (
  `reset_id` int(20) NOT NULL,
  `reset_code` varchar(200) NOT NULL,
  `reset_token` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_pass_resets`
--

INSERT INTO `rpos_pass_resets` (`reset_id`, `reset_code`, `reset_token`, `reset_email`, `reset_status`, `created_at`) VALUES
(1, '63KU9QDGSO', '4ac4cee0a94e82a2aedc311617aa437e218bdf68', 'sysadmin@icofee.org', 'Pending', '2020-08-17 15:20:14.318643');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_payments`
--

CREATE TABLE `rpos_payments` (
  `pay_id` varchar(200) NOT NULL,
  `pay_code` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `pay_amt` varchar(200) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_payments`
--

INSERT INTO `rpos_payments` (`pay_id`, `pay_code`, `order_code`, `customer_id`, `pay_amt`, `pay_method`, `created_at`) VALUES
('0bf592', '9UMWLG4BF8', 'EJKA-4501', '35135b319ce3', '8', 'Cash', '2022-09-04 16:31:54.525284'),
('146931', '8MWHINOC24', 'LTUR-9341', '06549ea58afd', '115', 'Online', '2024-06-17 06:27:50.620732'),
('14d4b7', 'BWTYANDJOF', 'LEQG-3654', '<br />\n<b>Warning</b>:  Undefined variable $customer_id in <b>C:\\xampp\\htdocs\\POS-YellowOwls\\pos\\admin\\pay_order.php</b> on line <b>115</b><br />\n', '173', 'Paypal', '2024-06-13 08:05:02.205523'),
('264db4', 'HJRIZCEX5F', 'GLBF-0243', 'e711dcc579d9', '43', 'Cash', '2024-06-14 18:32:31.296953'),
('31e0dc', 'MVRYETUO23', 'JGUZ-3065', '06549ea58afd', '30', 'Online', '2024-06-18 07:21:28.900294'),
('359100', '2OE1J9SFXU', 'AGON-0465', '9c7fcc067bda', '92', 'Cash', '2024-06-13 08:28:59.428542'),
('3751f7', '9XRLTYAQG5', 'GALR-5108', '<br />\r\n<b>Warning</b>:  Undefined property: stdClass::$customer_id in <b>C:\\xampp\\htdocs\\POS-YellowOwls\\pos\\admin\\payments.php</b> on line <b>83</b><br />\r\n', '15', 'Cash', '2024-06-11 07:04:22.505573'),
('411e8c', '1N7K9EX8Q5', 'OYTS-1870', '1fc1f694985d', '158', 'Paypal', '2024-06-13 08:45:03.232947'),
('4423d7', 'QWERT0YUZ1', 'JFMB-0731', '35135b319ce3', '11', 'Cash', '2022-09-04 16:37:03.655834'),
('442865', '146XLFSC9V', 'INHG-0875', '9c7fcc067bda', '10', 'Paypal', '2022-09-04 16:35:22.470600'),
('4bec61', 'CMWHAIYEVO', 'XCSO-7528', '47cfca085c88', '168', 'Online', '2024-06-18 06:48:39.228607'),
('53ba66', '4WR9GOND5A', 'AGON-0465', '9c7fcc067bda', '92', 'Cash', '2024-06-13 08:30:18.855196'),
('58ac51', '2HJSOT3CMG', 'TQDE-6512', 'd0ba61555aee', '8', 'Cash', '2024-06-08 13:12:26.187231'),
('5da940', 'KRAIMNYOLJ', 'FYLH-0493', '9e5e95a9010c', '470', 'Online', '2024-06-19 03:38:13.726288'),
('5f38d6', 'JYB2DF7U58', 'JEAT-7583', '1fc1f694985d', '6', 'Cash', '2024-05-02 13:56:29.161741'),
('65891b', 'MF2TVJA1PY', 'ZPXD-6951', 'e711dcc579d9', '16', 'Cash', '2022-09-03 13:12:46.959558'),
('6d68b0', '93QDBAFK26', 'BVDN-4671', '35135b319ce3', '15', 'Cash', '2024-06-11 06:48:15.746602'),
('6f4157', 'W3G278JOKI', 'AGON-0465', '9c7fcc067bda', '92', 'Cash', '2024-06-13 08:34:50.529915'),
('72891c', '237P8CIF6W', 'AMNR-6584', '27e4a5bc74c2', '240', 'Cash', '2024-06-19 09:11:48.372492'),
('75ae21', '1QIKVO69SA', 'IUSP-9453', 'fe6bb69bdd29', '10', 'Cash', '2022-09-03 11:50:40.496625'),
('7e1989', 'KLTF3YZHJP', 'QOEH-8613', '29c759d624f9', '9', 'Cash', '2022-09-03 12:02:32.926529'),
('968488', '5E31DQ2NCG', 'COXP-6018', '7c8f2100d552', '22', 'Cash', '2022-09-03 12:17:44.639979'),
('984539', 'LSBNK1WRFU', 'FNAB-9142', '35135b319ce3', '18', 'Paypal', '2022-09-04 16:32:14.852482'),
('9e09a1', 'BZAPSFTJLG', 'VELA-4862', '57b7541814ed', '42', 'Cash', '2024-06-08 14:32:18.705911'),
('9fcee7', 'AZSUNOKEI7', 'OTEV-8532', '3859d26cd9a5', '15', 'Cash', '2022-09-03 13:13:38.855058'),
('adab70', 'K3W87SCJZE', 'QFKM-1926', '29c759d624f9', '252', 'Paypal', '2024-06-14 14:26:03.566188'),
('b780bf', 'V4K3COEBYT', 'YLND-4069', '9e5e95a9010c', '402', 'Paypal', '2024-06-14 20:20:38.759233'),
('c81d2e', 'WERGFCXZSR', 'AEHM-0653', '06549ea58afd', '8', 'Cash', '2022-09-03 13:26:00.331494'),
('cf9e07', 'AD6BEYJMOR', 'DEYN-0935', 'fe6bb69bdd29', '176', 'Paypal', '2024-06-14 18:15:58.187105'),
('e46e29', 'QMCGSNER3T', 'ONSY-2465', '57b7541814ed', '12', 'Cash', '2022-09-03 08:35:50.172062'),
('e57390', 'TDYWH3FGBV', 'UYLG-1036', '29c759d624f9', '7', 'Paypal', '2024-06-11 06:45:23.329101'),
('ec7e0d', 'OL5WMGR9H2', 'PFCO-8640', '1da1f018cec0', '230', 'Online', '2024-06-19 10:42:36.963008');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_products`
--

CREATE TABLE `rpos_products` (
  `prod_id` varchar(200) NOT NULL,
  `prod_code` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_category` varchar(200) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `prod_desc` longtext NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `prod_ing` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_products`
--

INSERT INTO `rpos_products` (`prod_id`, `prod_code`, `prod_name`, `prod_category`, `prod_img`, `prod_desc`, `prod_price`, `created_at`, `prod_ing`) VALUES
('005018bc24', 'PFGL-5697', 'Chicken Loaded Nachos', 'Nachos', '', 'CLN', '110', '2024-06-19 10:00:49.424913', ''),
('02d03f9580', 'XURN-5129', 'Veg Club Grilled', 'Sandwiches', '', 'VCG', '110', '2024-06-19 10:28:45.533625', ''),
('04ead60fa7', 'KUZI-1423', 'Pomegranate Iced Tea', 'Tea', '', 'PIT', '70', '2024-06-19 09:43:46.839992', ''),
('05a92503aa', 'BFMK-0583', 'Cheesy Fries', 'Fries', '', 'CF', '80', '2024-06-19 10:03:41.471923', ''),
('06f49aeb71', 'LYJU-4053', 'Veg Bombay Masala Grilled', 'Sandwiches', '', 'VBMG', '70', '2024-06-19 10:25:48.040173', ''),
('12bef6ac32', 'YQXE-5148', 'Veg PB&J Grilled Sandwich', 'Sandwiches', '', 'VPB&JGS', '70', '2024-06-19 10:29:35.847147', ''),
('158a5a0783', 'DGCA-4216', 'chicken club griled sandwitch', 'Sandwiches', '', '.', '120', '2024-06-19 11:28:02.631399', ''),
('189c49a603', 'PLGY-3287', 'Fresh Lime Soda', 'Something Lemony', '', 'FLS', '45', '2024-06-19 09:45:29.721896', ''),
('1ff98d661a', 'JLUB-0972', 'Veg Coleslaw Cold Sandwich', 'Sandwiches', '', 'VCC', '50', '2024-06-19 10:15:19.690707', ''),
('21ca6a714b', 'BPTV-7349', 'Veg Club Cold Sandwich', 'Sandwiches', '', 'VCCS', '100', '2024-06-19 10:28:00.950468', ''),
('22e6674c16', 'MRHS-5390', 'Nonveg Chicken & Mayo Cold Sandwich', 'Sandwiches', '', 'NC&MCS', '70', '2024-06-19 10:32:57.749088', ''),
('25dfa8d3ee', 'PCXY-5347', 'Classic Nachos', 'Nachos', '', 'CN', '60', '2024-06-19 09:55:54.260426', ''),
('32d4f07ce3', 'VXYJ-4815', 'Veg Chocolate Grilled Sandwich', 'Sandwiches', '', 'VCGS', '60', '2024-06-19 10:23:22.130249', ''),
('33c163da19', 'SFDP-5964', 'Cheese', 'Maggie', '', '.', '60', '2024-06-19 11:29:48.932451', ''),
('34b13720b0', 'JZBV-0218', 'chicken & mayo grilled sandwitch', 'Sandwiches', '', '.', '80', '2024-06-19 11:26:44.297954', ''),
('353f7db856', 'AQUB-9106', 'Jam & Butter Toast', 'Toasts', '', 'JBT', '50', '2024-06-19 09:48:17.848101', ''),
('35c0032458', 'HLBD-9054', 'non-veg egg & mayo grilled sandwitch', 'Sandwiches', '', '.', '75', '2024-06-19 11:25:25.135777', ''),
('44175408e7', 'ZOAL-4629', 'Vegetable', 'Maggie', '', '.', '60', '2024-06-19 11:29:09.848098', ''),
('4472fa7c96', 'NJAV-5092', 'Veg PB&J Cold Sandwich', 'Sandwiches', '', 'VPB&JCS', '60', '2024-06-19 10:25:13.154121', ''),
('4facdcb4f9', 'QOIW-4507', 'Nonveg Chicken Coleslaw Cold Sandwich', 'Sandwiches', '', 'NCCCS', '70', '2024-06-19 10:31:14.159427', ''),
('53295cdef0', 'FCVX-5708', 'chicken club cold sandwitch', 'Sandwiches', '', '.', '110', '2024-06-19 11:27:22.003337', ''),
('54ee11d447', 'TLFR-5184', 'Nonveg Egg & Mayo Cold Sandwich', 'Sandwiches', '', 'NE&MC', '65', '2024-06-19 10:31:37.198674', ''),
('54f250b673', 'MOFL-4178', 'Cheese & Corn Nuggets', 'Nuggets', '', 'C&CN', '80', '2024-06-19 10:05:51.795765', ''),
('5ce2842fc9', 'TMCP-3415', 'Fresh Lime Water', 'Something Lemony', '', 'FLW', '35', '2024-06-19 09:44:35.108846', ''),
('5edac27e35', 'ATSG-5198', 'Egg (scrambled/fried)', 'Maggie', '', '.', '70', '2024-06-19 11:30:43.234092', ''),
('6723953c79', 'HAIW-9750', 'Chilli cheese ', 'Garlic Bread', '', '.', '65', '2024-06-19 11:32:17.280799', ''),
('69a44e44bd', 'IGTM-2401', 'Chicken Fingers Nuggets', 'Nuggets', '', 'CFN', '100', '2024-06-19 10:06:57.428464', ''),
('6ac2446c8b', 'GVNL-8423', 'Peri Peri Fries', 'Fries', '', 'PPF', '70', '2024-06-19 10:03:03.414631', ''),
('6b83601144', 'YKLQ-8540', 'Veg Garlic Cheese Grilled Sandwich', 'Sandwiches', '', 'VGC', '70', '2024-06-19 10:26:34.115475', ''),
('6bdb9e7492', 'TZVQ-7930', 'Lemon Iced Tea', 'Tea', '', 'Lemon Iced Tea', '70', '2024-06-19 09:42:46.882831', ''),
('6f3c36a563', 'CWHO-1462', 'Chicken Nuggets', 'Nuggets', '', 'CN', '90', '2024-06-19 10:06:17.855502', ''),
('74aaf05ff8', 'TPXZ-4739', 'Lemonade', 'Something Lemony', '', 'l', '40', '2024-06-19 09:44:58.499589', ''),
('77cd2246f9', 'OBSY-9387', 'Veg Chilli Cheese Grilled', 'Sandwiches', '', 'VCCG', '60', '2024-06-19 10:24:12.831814', ''),
('79624ac5a9', 'LPXT-5864', 'Spicy Cheese Nachos', 'Nachos', '', 'SCN', '75', '2024-06-19 09:59:44.604029', ''),
('7af9a58d44', 'MVGB-4769', 'Non-veg Cajun chicken grilled sandwitch', 'Sandwiches', '', '.', '90', '2024-06-19 11:24:27.853545', ''),
('829d1b0900', 'UMOK-0196', 'Chicken Loaded Fries', 'Fries', '', 'CLF', '110', '2024-06-19 10:05:08.364447', ''),
('8e23aebda6', 'DJHA-4259', 'Whole Wheat Bread', 'Add-ons', '', 'wheat Bread', '10', '2024-06-18 05:05:18.941820', ''),
('8edbb205e4', 'SZIC-8269', 'Veg Classic Cold Sandwich', 'Sandwiches', '', 'VCC', '50', '2024-06-19 10:15:42.196029', ''),
('9599a2c620', 'PIHV-8423', 'cheesy Nachos', 'Nachos', '', 'CCN', '70', '2024-06-19 09:56:21.181687', ''),
('9c70bd1680', 'AGKJ-2810', 'Classic', 'Maggie', '', '.', '50', '2024-06-19 11:28:44.465035', ''),
('9db276b248', 'XRCU-3597', 'Fish Fingers Nuggets', 'Nuggets', '', 'FFN', '110', '2024-06-19 10:07:36.012196', ''),
('a13517006a', 'ANCG-2157', 'Vegetable cheese', 'Maggie', '', '.', '65', '2024-06-19 11:30:13.108097', ''),
('a485cb09c0', 'PMXW-5012', 'Butter Toast', 'Toasts', '', 'BT', '40', '2024-06-19 09:47:51.239613', ''),
('b827459346', 'KYWQ-4569', 'Veg Loaded Fries', 'Fries', '', 'VLF', '90', '2024-06-19 10:04:40.920079', ''),
('bd200ef837', 'HEIY-6034', 'Turkish Coffee', '', 'turkshcoffee.jpg', 'Turkish coffee is a style of coffee prepared in a cezve using very finely ground coffee beans without filtering.', '8', '2022-09-03 13:09:50.234898', ''),
('be085c83d7', 'MFEH-6397', 'Veg Classic Grilled Sandwich', 'Sandwiches', '', 'VCG', '60', '2024-06-19 10:15:59.223548', ''),
('c3e9fb8807', 'UITK-0718', 'Spicy Cheese Fries', 'Fries', '', 'SCF', '90', '2024-06-19 10:04:12.930626', ''),
('cc9a85c5b6', 'PXHB-8902', 'Veg Coleslaw Grilled Sandwich', 'Sandwiches', '', 'NCG', '60', '2024-06-19 10:16:12.285233', ''),
('ccd76234b7', 'PNTR-1328', 'Veg Chocolate Cold Sandwich', 'Sandwiches', '', 'VCC', '50', '2024-06-19 10:16:24.771342', ''),
('cea98599bc', 'VPOX-4956', 'Classic Fries', 'Fries', '', 'CF', '60', '2024-06-19 10:02:00.260776', ''),
('cf658d541e', 'YUGO-8279', 'Peach Iced Tea', 'Tea', '', 'Peach Iced Tea', '70', '2024-06-19 09:43:14.700312', ''),
('d1c85b8fe0', 'SYJA-2859', 'chicken colslaw grilled sandwitch', 'Sandwiches', '', '.', '80', '2024-06-19 11:26:04.951674', ''),
('dd48b08854', 'VDBC-9850', 'Vanilla milk Shake', 'Milk Shakes', '', 'VMS', '110', '2024-06-19 09:46:16.229179', ''),
('ddcf1a051e', 'MERG-5017', 'Veg Loaded Nachos', 'Nachos', '', 'VLN', '90', '2024-06-19 10:00:18.467032', ''),
('e3e8cfe291', 'EYJF-4065', 'Chocolate milk shake', 'Milk Shakes', '', 'CMS', '110', '2024-06-19 09:46:48.903280', ''),
('e792e14c0d', 'UFAL-4651', 'Cheese', 'Garlic Bread', '', 'Cheese Garlic Bread', '60', '2024-06-18 04:50:58.795775', ''),
('ebba70fe28', 'CRAL-5702', 'Non-veg Cajun chicken cold sandwitch', 'Sandwiches', '', '.', '80', '2024-06-19 11:23:58.862929', ''),
('ee63695abf', 'ECQF-5029', 'Veg Cheese Spinach & Corn Grilled Sandwich', 'Sandwiches', '', 'VCS&CGS', '80', '2024-06-19 10:27:20.371682', ''),
('f59dbf4e31', 'SZFW-3604', 'Classic', 'Garlic Bread', '', 'Classic Garlic Bread', '50', '2024-06-18 04:47:02.046304', ''),
('f9c2770a32', 'YXLA-2603', 'Whipped Milk Shake', 'Beverages', '', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,', '8', '2024-06-13 06:49:38.945728', ''),
('fe64b29c08', 'RGAO-0286', 'PB&J Toast', 'Toasts', '', 'PB&J', '60', '2024-06-19 10:35:44.841236', '');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_staff`
--

CREATE TABLE `rpos_staff` (
  `staff_id` int(20) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `staff_email` varchar(200) NOT NULL,
  `staff_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_staff`
--

INSERT INTO `rpos_staff` (`staff_id`, `staff_name`, `staff_number`, `staff_email`, `staff_password`, `created_at`) VALUES
(2, 'Cashier James', 'QEUY-9042', 'cashier@mail.com', '1f82ea75c5cc526729e2d581aeb3aeccfef4407e', '2024-06-18 05:09:04.072664');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rpos_admin`
--
ALTER TABLE `rpos_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `rpos_customers`
--
ALTER TABLE `rpos_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `CustomerOrder` (`customer_id`),
  ADD KEY `ProductOrder` (`prod_id`);

--
-- Indexes for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `rpos_payments`
--
ALTER TABLE `rpos_payments`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `order` (`order_code`);

--
-- Indexes for table `rpos_products`
--
ALTER TABLE `rpos_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  MODIFY `reset_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD CONSTRAINT `CustomerOrder` FOREIGN KEY (`customer_id`) REFERENCES `rpos_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductOrder` FOREIGN KEY (`prod_id`) REFERENCES `rpos_products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
