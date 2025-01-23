-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Dec 13, 2024 at 09:05 AM
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
-- Database: `dos`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`id`, `product_type`, `quantity`) VALUES
(1, '2', 5);

-- --------------------------------------------------------

--
-- Table structure for table `deduct`
--

CREATE TABLE `deduct` (
  `id` int(11) NOT NULL,
  `product_type` varchar(55) DEFAULT NULL,
  `deduction_count` int(11) DEFAULT NULL,
  `deduction_reason` varchar(255) DEFAULT NULL,
  `deduction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deduct`
--

INSERT INTO `deduct` (`id`, `product_type`, `deduction_count`, `deduction_reason`, `deduction_date`) VALUES
(1, 'a', 1, 'a', '2024-11-06 00:57:27'),
(2, 'A1', 1, 'a', '2024-11-06 01:12:05'),
(3, 'A1', 1, 'wewe', '2024-11-06 01:58:45'),
(4, '1', 5, 'sad', '2024-12-11 05:06:39'),
(5, '1', 5, 'sad', '2024-12-11 17:06:13'),
(6, '2\' x 6\'', 1, 'sad', '2024-12-11 17:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `done_transaction`
--

CREATE TABLE `done_transaction` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `done_transaction`
--

INSERT INTO `done_transaction` (`id`, `product_id`, `quantity`, `transaction_date`) VALUES
(1, 1, 1, '2024-11-17 16:00:00'),
(2, 2, 1, '2024-11-17 16:00:00'),
(3, 3, 1, '2024-11-17 16:00:00'),
(4, 1, 1, '2024-11-17 16:00:00'),
(5, 2, 1, '2024-11-17 16:00:00'),
(6, 3, 1, '2024-11-17 16:00:00'),
(7, 1, 1, '2024-11-25 16:00:00'),
(8, 2, 1, '2024-11-25 16:00:00'),
(9, 3, 1, '2024-11-25 16:00:00'),
(10, 1, 3, '2024-11-25 16:00:00'),
(11, 2, 1, '2024-11-25 16:00:00'),
(12, 1, 1, '2024-11-30 05:40:21'),
(13, 2, 1, '2024-11-30 05:40:21'),
(14, 3, 1, '2024-11-30 05:40:21'),
(15, 1, 1, '2024-11-30 05:47:10'),
(16, 2, 1, '2024-11-30 05:47:10'),
(17, 3, 1, '2024-11-30 05:47:10'),
(20, 1, 4, '2024-12-08 12:05:47'),
(21, 2, 7, '2024-12-08 12:05:47'),
(22, 3, 4, '2024-12-08 12:05:47'),
(23, 4, 4, '2024-12-08 12:05:47'),
(24, 5, 6, '2024-12-08 12:05:47'),
(25, 1, 4, '2024-12-08 17:13:30'),
(26, 2, 7, '2024-12-08 17:13:30'),
(27, 3, 4, '2024-12-08 17:13:30'),
(28, 4, 4, '2024-12-08 17:13:30'),
(29, 5, 6, '2024-12-08 17:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_type` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `stock_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_type`, `description`, `stock_count`) VALUES
(1, '2\' x 6\'', NULL, 100),
(2, '4\'x4\'', NULL, 475),
(3, '2.6\'x4\'', '0', 487),
(4, '2\'x2\'', '0', 494),
(5, '4\'x6\'', 'asd', 490);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `name`, `date_updated`) VALUES
(1, '4pcs Double A', '2024-11-18'),
(2, '8pcs Triple A', '2024-11-18'),
(3, 'Button cell Battery', '2024-11-18'),
(4, 'Camera remote', '2024-12-06'),
(5, 'Light bulb', '2024-11-18'),
(6, 'Ink (printing)', '2024-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `queue_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `email`, `otp`, `queue_id`) VALUES
(1, 'vincentbhw@gmail.com', 'asd', 0),
(2, 'vincentbhw@gmail.com', 'asd', 0),
(3, 'vincentbhw@gmail.com', 'asd', 0),
(4, 'vincentthroneofliberty@gmail.com', 'asdf', 0),
(5, 'asdf@gmail.com', 'asdfasdf', 0),
(6, 'tine@gmail.com', '', 0),
(7, 'tine@gmail.com', '', 0),
(8, 'tine@gmail.com', '', 0),
(9, 'tine@gmail.com', '', 0),
(10, 'tine@gmail.com', '', 0),
(11, 'tine@gmail.com', '', 0),
(12, 'tine@gmail.com', '', 0),
(13, 'Juan@gmail.com', '', 0),
(14, 'vincentbhw@gmail.com', '', 0),
(15, 'vincentbhw@gmail.com', '', 0),
(16, 'asdf@gmail.com', '', 0),
(17, 'vincentbhw@gmail.com', '', 0),
(18, 'vincentbhw@gmail.com', '', 0),
(19, 'asdf@gmail.com', '', 0),
(20, 'vincentbhw@gmail.com', '', 0),
(21, 'vincentbhw@gmail.com', '', 0),
(22, 'tine@gmail.com', '', 0),
(23, 'vincentthroneofliberty@gmail.com', '', 0),
(24, 'ivan@gmail.com', '', 0),
(25, 'ivan@gmail.com', '', 0),
(26, 'tine@gmail.com', '', 0),
(27, 'ivan@gmail.com', '', 0),
(28, 'vincentbhw@gmail.com', '', 0),
(29, 'vincentthroneofliberty@gmail.com', '', 0),
(30, 'vincentthroneofliberty@gmail.com', '', 0),
(31, 'vincentthroneofliberty@gmail.com', '', 0),
(32, 'ivan@gmail.com', '', 0),
(33, 'Juan@gmail.com', '', 0),
(34, 'Juan@gmail.com', '', 0),
(35, 'Juan@gmail.com', '', 0),
(36, 'vincentbhw@gmail.com', '', 0),
(37, 'vincentbhw@gmail.com', '', 0),
(38, 'EricZarg@gmail.com', '', 0),
(39, 'tine@gmail.com', '', 0),
(40, 'EricZarg@gmail.com', '', 0),
(41, 'EricZarg@gmail.com', '', 0),
(42, 'EricZarg@gmail.com', '', 0),
(43, 'EricZarg@gmail.com', '', 0),
(44, 'EricZarg@gmail.com', '', 0),
(45, 'EricZarg@gmail.com', '', 0),
(46, 'tine@gmail.com', '', 0),
(47, 'Juan@gmail.com', '', 0),
(48, 'vincentbhw@gmail.com', '', 0),
(49, 'bautista.vi.bscs@gmail.com', NULL, 0),
(50, 'bautista.vi.bscs@gmail.com', NULL, 0),
(51, 'vincentbhw@gmail.com', NULL, 0),
(52, 'vincentbhw@gmail.com', 'UWUZFI', 52),
(53, 'vincentbhw@gmail.com', '5BULUY', 53),
(54, 'bautista.vi.bscs@gmail.com', 'BERM85', 54),
(55, 'vincentbhw@gmail.com', 'DQQTDN', 55),
(56, 'vincentbhw@gmail.com', '6EETG1', 56),
(57, 'iandauz162@gmail.com', '0NBN62', 250),
(58, 'iandauz162@gmail.com', '8SX8LI', 251),
(59, 'iandauz162@gmail.com', '1PQ36L', 252),
(60, 'iandauz162@gmail.com', 'VV08AS', 253),
(61, 'iandauz162@gmail.com', 'S0FSDK', 254),
(62, 'iandauz162@gmail.com', 'PJRHHQ', 255),
(63, 'iandauz162@gmail.com', 'WYW3ZG', 256),
(64, 'iandauz162@gmail.com', 'R9OC7Y', 257),
(65, 'iandauz162@gmail.com', 'LV9J13', 258),
(66, 'iandauz162@gmail.com', '5VVUGS', 259),
(67, 'iandauz162@gmail.com', '06GHCR', 260),
(68, 'iandauz162@gmail.com', 'ZCFRR5', 261),
(69, 'iandauz162@gmail.com', '2BLVSG', 262),
(70, 'iandauz162@gmail.com', 'Z5P4M7', 263),
(71, 'iandauz162@gmail.com', 'ZRNF18', 264),
(72, 'iandauz162@gmail.com', 'VRYDQ1', 265),
(73, 'iandauz162@gmail.com', '9V5CEO', 266),
(74, 'iandauz162@gmail.com', 'TPXKB2', 267),
(75, 'iandauz162@gmail.com', 'J2ITFQ', 268),
(76, 'iandauz162@gmail.com', '2S4LEA', 269),
(77, 'iandauz162@gmail.com', '7Z9OLH', 270),
(78, 'iandauz162@gmail.com', 'IRFZNR', 271),
(79, 'iandauz162@gmail.com', 'A26DL4', 272),
(80, 'iandauz162@gmail.com', 'ZHZPAP', 273),
(81, 'iandauz162@gmail.com', '9REIY8', 274),
(82, 'iandauz162@gmail.com', 'PLKGHB', 275),
(83, 'iandauz162@gmail.com', 'IE1VJ8', 276),
(84, 'iandauz162@gmail.com', '10B4C2', 277),
(85, 'iandauz162@gmail.com', 'V8FRZF', 278),
(86, 'iandauz162@gmail.com', '5IN78W', 279),
(87, 'iandauz162@gmail.com', 'IRGUDL', 280),
(88, 'iandauz162@gmail.com', 'O5LL49', 281),
(89, 'iandauz162@gmail.com', 'PWVTMR', 282),
(90, 'iandauz162@gmail.com', '4HV9CI', 283),
(91, 'iandauz162@gmail.com', '4G7TXN', 284),
(92, 'iandauz162@gmail.com', 'TO9WLD', 285),
(93, 'iandauz162@gmail.com', '6YCALM', 286),
(94, 'iandauz162@gmail.com', 'IS00FL', 287),
(95, 'iandauz162@gmail.com', 'OF5HDV', 288),
(96, 'iandauz162@gmail.com', 'MF73YL', 289),
(97, 'iandauz162@gmail.com', 'JNSU5I', 290),
(98, 'iandauz162@gmail.com', 'KES7YJ', 291),
(99, 'iandauz162@gmail.com', 'LDKK7X', 292),
(100, 'iandauz162@gmail.com', 'L8Y8J9', 293),
(101, 'iandauz162@gmail.com', 'ZVSQE5', 294),
(102, 'iandauz162@gmail.com', 'AAG0LO', 295),
(103, 'iandauz162@gmail.com', '8V30P8', 296),
(104, 'iandauz162@gmail.com', 'C05K0K', 297),
(105, 'iandauz162@gmail.com', 'DRANGW', 298),
(106, 'iandauz162@gmail.com', 'FG2EZZ', 299),
(107, 'iandauz162@gmail.com', 'MI5DMJ', 300),
(108, 'iandauz162@gmail.com', 'QCVGEP', 301),
(109, 'iandauz162@gmail.com', '76L7MB', 302),
(110, 'iandauz162@gmail.com', 'YTD16V', 303),
(111, 'iandauz162@gmail.com', 'ODMAUR', 304),
(112, 'iandauz162@gmail.com', 'PI853M', 305),
(113, 'iandauz162@gmail.com', '4NWTP9', 306),
(114, 'iandauz162@gmail.com', 'MMEJSF', 307),
(115, 'iandauz162@gmail.com', 'VILYWQ', 308),
(116, 'iandauz162@gmail.com', 'WA3OS4', 309),
(117, 'iandauz162@gmail.com', 'CE0BZ8', 310),
(118, 'iandauz162@gmail.com', 'LFT1J2', 311),
(119, 'iandauz162@gmail.com', '34RM5V', 312),
(120, 'iandauz162@gmail.com', 'D23ELM', 313),
(121, 'iandauz162@gmail.com', 'RARUEC', 314),
(122, 'iandauz162@gmail.com', 'HXBI7D', 315),
(123, 'iandauz162@gmail.com', 'XG8NCU', 316),
(124, 'iandauz162@gmail.com', '4U1ARF', 317),
(125, 'iandauz162@gmail.com', 'OM8YP0', 318),
(126, 'iandauz162@gmail.com', 'CVGA3R', 319),
(127, 'iandauz162@gmail.com', 'H64I3W', 320),
(128, 'iandauz162@gmail.com', '2FD06G', 321),
(129, 'iandauz162@gmail.com', '53C3SY', 322),
(130, 'iandauz162@gmail.com', 'SO3B0S', 323),
(131, 'iandauz162@gmail.com', 'AT7Z94', 324),
(132, 'iandauz162@gmail.com', 'VNQLWK', 325),
(133, 'iandauz162@gmail.com', 'AS93TI', 326),
(134, 'iandauz162@gmail.com', 'DU3X1V', 327),
(135, 'iandauz162@gmail.com', 'GST9SI', 328),
(136, 'iandauz162@gmail.com', 'O8PAOG', 329),
(137, 'iandauz162@gmail.com', '3E4N3E', 330),
(138, 'iandauz162@gmail.com', 'RT5Z8P', 331),
(139, 'iandauz162@gmail.com', 'LKZMNB', 332),
(140, 'iandauz162@gmail.com', 'H1NIE2', 333),
(141, 'iandauz162@gmail.com', 'DJTK3Z', 334),
(142, 'iandauz162@gmail.com', 'TRCTWS', 335),
(143, 'iandauz162@gmail.com', '95MKKQ', 336),
(144, 'iandauz162@gmail.com', '93CZQ8', 337),
(145, 'iandauz162@gmail.com', '71HFED', 338),
(146, 'iandauz162@gmail.com', 'OAX2JH', 339),
(147, 'iandauz162@gmail.com', 'HUDOPC', 340),
(148, 'iandauz162@gmail.com', 'DS3YDI', 341),
(149, 'iandauz162@gmail.com', '0IA5DS', 342),
(150, 'iandauz162@gmail.com', 'O5UPR8', 343),
(151, 'iandauz162@gmail.com', '3JNAU6', 344),
(152, 'iandauz162@gmail.com', '6V1NCW', 345),
(153, 'iandauz162@gmail.com', 'TUUSHD', 346),
(154, 'iandauz162@gmail.com', 'H2JG4N', 347),
(155, 'iandauz162@gmail.com', 'N1PDU0', 348),
(156, 'iandauz162@gmail.com', 'W904TG', 349),
(157, 'iandauz162@gmail.com', '9GSJ9U', 350),
(158, 'iandauz162@gmail.com', 'GRAC2I', 351),
(159, 'iandauz162@gmail.com', 'GHK9GO', 352),
(160, 'iandauz162@gmail.com', 'OMB60C', 353),
(161, 'iandauz162@gmail.com', '5VIQO3', 354),
(162, 'iandauz162@gmail.com', 'PWADLO', 355);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `image_name_location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `product_used` varchar(50) DEFAULT NULL,
  `duration` int(11) DEFAULT 15 COMMENT 'Duration in minutes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `image_name_location`, `price`, `package_name`, `description`, `product_used`, `duration`) VALUES
(1, 'images/package1.jpg', 300.00, 'Special Package', '1-2 PAX\r\n10 mins unlimited studio shoot\r\n1 background color\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos', '1/2/3', 10),
(2, 'images/package2.jpg', 350.00, 'Promo Package', '1-2 PAX\r\n15 mins unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos', '1/1/1/2', 15),
(3, 'images/package3.jpg', 400.00, 'Basic Package', '1-2 PAX\r\n30 mins unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos', '1/2/3/4/1/2/2/2', 30),
(4, 'images/package4.jpg', 450.00, 'Standard Package', '1-2 PAX\r\n30 mins unlimited studio shoot\r\nUnlimited background change\r\nSoft copy of ALL RAW photos\r\n15 mins photo selection\r\n2 strip prints\r\n2 4R prints', '1/1/1/1/2/2/2/2/3/3/3/3/4/4/5/5', 30),
(5, 'images/package5.jpg', 500.00, 'Premium Package', '1-5 PAX\r\n30 mins unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos\r\n15 mins photo selection\r\n5 strip prints\r\n5 4R prints', '1/1/1/1/2/2/2/2/3/3/3/3/4/4/5/5/2/2/2/4/5/5/5/5', 30),
(6, 'images/package6.jpg', 550.00, 'UNO Package', '1-2 PAX\r\n1 hour unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos\r\n15 mins photo selection\r\n2 strip prints\r\n2 4R prints', '1/1/1/1/2/2/2/2/3/3/3/3/4/4/5/5/2/2/2/4/5/5/5/5/4', 60);

-- --------------------------------------------------------

--
-- Table structure for table `package_images`
--

CREATE TABLE `package_images` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_images`
--

INSERT INTO `package_images` (`id`, `package_id`, `image_path`) VALUES
(2, 1, 'images/img1.jpg'),
(3, 1, 'images/img2.jpg'),
(4, 1, 'images/img3.jpg'),
(5, 2, 'images/img4.jpg'),
(6, 2, 'images/img5.jpg'),
(7, 2, 'images/img6.jpg'),
(8, 3, 'images/img7.jpg'),
(9, 3, 'images/img8.jpg'),
(10, 3, 'images/img9.jpg'),
(11, 4, 'images/img10.jpg'),
(12, 4, 'images/img11.jpg'),
(13, 4, 'images/img12.jpg'),
(14, 5, 'images/img13.jpg'),
(15, 5, 'images/img14.jpg'),
(16, 5, 'images/img15.jpg'),
(17, 6, 'images/img16.jpg'),
(18, 6, 'images/img17.jpg'),
(19, 6, 'images/img18.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `package_products`
--

CREATE TABLE `package_products` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_needed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `queue_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('Done','Queue','Cancelled','On-Going','For-Checking') NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `notification_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`queue_id`, `name`, `status`, `action`, `notification_read`, `created_at`) VALUES
(1, 'Ivan Bautista', 'Queue', NULL, 1, '2024-12-11 11:29:06'),
(2, 'Ivan Bautista', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(4, 'Ashley Sampaga', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(5, 'Venize Bautista', 'Cancelled', NULL, 0, '2024-12-11 11:29:06'),
(6, 'Tine Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(7, 'Tine Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(8, 'Tine Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(9, 'Tine Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(10, 'Tine Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(11, 'Tine Dubouzet', 'Cancelled', NULL, 0, '2024-12-11 11:29:06'),
(12, 'Tine Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(13, 'Juan Bautista', 'Cancelled', NULL, 0, '2024-12-11 11:29:06'),
(14, 'Venize Dubouzet', 'Cancelled', NULL, 0, '2024-12-11 11:29:06'),
(15, 'Juan Dubouzet', 'Cancelled', NULL, 0, '2024-12-11 11:29:06'),
(16, 'Ashley Bautista', 'Cancelled', NULL, 0, '2024-12-11 11:29:06'),
(17, 'Ivan Sampaga', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(18, 'Ivan Sampaga', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(19, 'Tine Dubouzet', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(20, 'Venize Sampaga', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(21, 'Tine Bautista', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(22, 'Venize Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(23, 'Venize Dubouzet', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(24, 'Venize Sampaga', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(25, 'Juan Sampaga', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(26, 'Venize Bautista', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(27, 'Ivan Sampaga', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(28, 'Juan Bautista', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(29, 'Venize Dubouzet', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(30, 'Venize Dubouzet', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(31, 'Venize Dubouzet', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(32, 'Ivan Bautista', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(33, 'Ivan Bautista', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(34, 'Ivan Bautista', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(35, 'Ivan Bautista', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(36, 'Ivan Bautista', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(37, 'Ivan Bautista', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(38, 'Eric Zaragoza', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(39, 'Eric Zaragoza', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(40, 'Ivan Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(41, 'Ivan Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(42, 'Ivan Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(43, 'Ivan Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(44, 'Ivan Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(45, 'Ivan Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(46, 'Ivan Bautista', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(47, 'Ashley Sampaga', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(48, 'Ivan Bautista', 'Queue', NULL, 1, '2024-12-11 11:29:06'),
(49, 'Ivan Dubouzet', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(50, 'Venize Dubouzet', 'Queue', NULL, 1, '2024-12-11 11:29:06'),
(51, 'Big Black Cresendo', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(52, 'Big Black Cresendo', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(53, 'Big Black Cresendo', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(54, 'Ashley Cresendo', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(55, 'Ashley Sampaga', '', NULL, 0, '2024-12-11 11:29:06'),
(56, 'Venize Bautista', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(57, 'Eva Phillips', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(58, 'Freddie Garcia', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(59, 'Grace Bryant', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(60, 'Henry Cooper', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(61, 'Isla Richardson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(62, 'Jake Martinez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(63, 'Luna Ward', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(64, 'Mila Evans', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(65, 'Noah Walker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(66, 'Olivia Nelson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(67, 'Penny Carter', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(68, 'Quinn Price', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(69, 'Ryan Roberts', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(70, 'Sophie Murphy', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(71, 'Theo Simmons', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(72, 'Ulysses Brooks', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(73, 'Vera Foster', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(74, 'Walter Green', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(75, 'Xena Powell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(76, 'Yasmine Coleman', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(77, 'Zara Jenkins', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(78, 'Aaron Mitchell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(79, 'Bella Stevens', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(80, 'Cameron Lee', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(81, 'Dylan Perry', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(82, 'Ella Knight', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(83, 'Finn Clark', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(84, 'Gina James', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(85, 'Harry Ross', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(86, 'Ivy Cook', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(87, 'Jackie Walker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(88, 'Kyle Morgan', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(89, 'Lily Carter', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(90, 'Max Johnson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(91, 'Nina Wood', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(92, 'Oscar Evans', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(93, 'Paulina Ford', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(94, 'Quentin Diaz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(95, 'Rachel Green', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(96, 'Samuel Bell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(97, 'Tessa Scott', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(98, 'Uriah Miller', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(99, 'Vince Adams', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(100, 'Wendy Price', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(101, 'Xander Martin', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(102, 'Yara Hughes', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(103, 'Zane Harris', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(104, 'John Doe', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(105, 'Jane Smith', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(106, 'Alice Johnson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(107, 'Bob Brown', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(108, 'Charlie Davis', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(109, 'David Wilson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(110, 'Eva Martinez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(111, 'Frank Lee', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(112, 'Grace Miller', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(113, 'Henry Clark', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(114, 'Isabel Adams', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(115, 'Jack Turner', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(116, 'Kara Thomas', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(117, 'Liam Walker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(118, 'Mia Lewis', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(119, 'Nathan Harris', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(120, 'Olivia Young', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(121, 'Paul Scott', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(122, 'Quinn Allen', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(123, 'Rachel King', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(124, 'Samuel Baker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(125, 'Tina Gonzalez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(126, 'Ursula Hall', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(127, 'Victor Nelson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(128, 'Wendy Carter', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(129, 'Xander Mitchell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(130, 'Yara Perez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(131, 'Zane Roberts', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(132, 'Amelia Lee', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(133, 'Benjamin Moore', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(134, 'Catherine Lewis', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(135, 'Daniel Rodriguez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(136, 'Eleanor Phillips', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(137, 'Frederick Walker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(138, 'Gina Cooper', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(139, 'Harry Perez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(140, 'Irene Davis', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(141, 'Jackie Evans', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(142, 'Kyle Martinez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(143, 'Lana Turner', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(144, 'Mason Carter', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(145, 'Nora Williams', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(146, 'Oscar Moore', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(147, 'Penny Mitchell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(148, 'Quincy Howard', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(149, 'Rita Lee', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(150, 'Steve Allen', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(151, 'Terry Young', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(152, 'Uma Johnson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(153, 'Vera Scott', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(154, 'David Martinez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(155, 'Sophia Garcia', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(156, 'Liam Anderson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(157, 'Olivia Taylor', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(158, 'Noah White', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(159, 'Emma Harris', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(160, 'Lucas Clark', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(161, 'Ava Lewis', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(162, 'Mason Walker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(163, 'Isabella Hall', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(164, 'Ethan Allen', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(165, 'Mia Young', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(166, 'James King', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(167, 'Amelia Wright', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(168, 'Alexander Scott', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(169, 'Charlotte Green', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(170, 'Benjamin Baker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(171, 'Abigail Adams', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(172, 'Michael Hill', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(173, 'Ella Nelson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(174, 'William Carter', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(175, 'Grace Mitchell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(176, 'Daniel Perez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(177, 'Lily Roberts', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(178, 'Matthew Turner', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(179, 'Chloe Phillips', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(180, 'Henry Campbell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(181, 'Victoria Parker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(182, 'Jackson Evans', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(183, 'Scarlett Edwards', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(184, 'Sebastian Collins', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(185, 'Hannah Stewart', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(186, 'Aiden Morris', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(187, 'Aria Rogers', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(188, 'Gabriel Reed', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(189, 'Zoe Cook', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(190, 'Carter Bell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(191, 'Penelope Rivera', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(192, 'Owen Murphy', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(193, 'Lillian Cooper', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(194, 'Caleb Richardson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(195, 'Riley Bailey', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(196, 'Elijah Sanders', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(197, 'Samantha Morris', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(198, 'Logan Ward', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(199, 'Andrew Roberts', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(200, 'Natalie Smith', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(201, 'Evan Thompson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(202, 'Harper Wilson', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(203, 'Jacob Adams', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(204, 'Layla Foster', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(205, 'Dylan Hayes', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(206, 'Audrey Martinez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(207, 'Ryan Hughes', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(208, 'Aurora Brooks', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(209, 'Nathan Flores', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(210, 'Paisley Price', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(211, 'Julian Rivera', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(212, 'Savannah Bell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(213, 'Isaac Barnes', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(214, 'Brooklyn Perry', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(215, 'Levi Russell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(216, 'Ellie Griffin', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(217, 'Jason Morgan', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(218, 'Avery Hughes', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(219, 'Connor Scott', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(220, 'Sophie Bailey', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(221, 'Asher Edwards', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(222, 'Madison Turner', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(223, 'Hunter Ramirez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(224, 'Lucy Sanders', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(225, 'Isaiah Bennett', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(226, 'Victoria Flores', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(227, 'Joseph Collins', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(228, 'Maya Reed', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(229, 'Tyler Ward', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(230, 'Anna Cooper', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(231, 'Eli Mitchell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(232, 'Claire Adams', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(233, 'Brandon Bell', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(234, 'Stella Brooks', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(235, 'Parker Griffin', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(236, 'Ruby Morris', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(237, 'Cooper Walker', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(238, 'Violet Perry', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(239, 'Hudson Bennett', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(240, 'Penelope Morgan', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(241, 'Miles Hughes', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(242, 'Hazel Scott', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(243, 'Adam Bailey', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(244, 'Elliana Turner', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(245, 'Caleb Ramirez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(246, 'Eliza Sanders', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(247, 'Easton Ward', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(248, 'Sadie Cooper', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(249, 'Landon Martinez', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(250, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(251, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(252, 'Ian Dauz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(253, 'Ian Dauz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(254, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(255, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(256, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(257, 'Ian Dauz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(258, 'Ian Dauz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(259, 'Ian Dauz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(260, 'Ian Dauz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(261, 'Ian Dauz', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(262, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(263, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(264, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(265, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(266, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(267, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(268, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(269, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(270, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(271, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(272, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(273, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(274, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(275, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(276, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(277, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(278, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(279, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(280, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(281, 'Ian Dauz', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(282, 'Ian Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(283, 'Ian Dauz', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(284, 'Ian Dauz', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(285, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(286, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(287, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(288, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(289, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(290, 'Ian Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(291, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(292, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(293, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(294, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(295, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(296, 'Nai Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(297, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(298, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(299, 'Ian Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(300, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(301, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(303, 'Nai Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(304, 'Nai Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(305, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(306, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(307, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(308, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(309, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(310, 'Ian Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(311, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(312, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(313, 'Nai Dauz', '', NULL, 0, '2024-12-11 11:29:06'),
(314, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(322, 'Nai Zuad', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(323, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(324, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(325, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(326, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(327, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(328, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(329, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(330, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(331, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(332, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(333, 'Nai Zuad', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(334, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(335, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(336, 'Nai Zuad', '', NULL, 0, '2024-12-11 11:29:06'),
(337, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(338, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(339, 'Nai Zuad', 'For-Checking', NULL, 1, '2024-12-11 11:29:06'),
(340, 'Nai Zuad', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(341, 'Nai Zuad', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(342, 'Nai Zuad', 'Done', NULL, 0, '2024-12-11 11:29:06'),
(343, 'Nai Zuad', 'Cancelled', NULL, 0, '2024-12-11 11:29:06'),
(344, 'Nai Zuad', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(345, 'Nai Zuad', 'Queue', NULL, 0, '2024-12-11 11:29:06'),
(349, 'Nai Zuad', 'Queue', NULL, 1, '2024-12-11 11:29:06'),
(350, 'Nai Zuad', 'Queue', NULL, 1, '2024-12-11 11:29:06'),
(351, 'Nai Zuad', 'Queue', NULL, 1, '2024-12-11 11:29:06'),
(352, 'Nai Zuad', 'On-Going', NULL, 1, '2024-12-11 11:29:06'),
(353, 'Ian Dauz', 'Queue', NULL, 1, '2024-12-11 11:29:06'),
(354, 'Ian Dauz', 'Queue', NULL, 1, '2024-12-11 11:38:14'),
(355, 'Nai Zuad', 'Queue', NULL, 0, '2024-12-13 07:44:19');

--
-- Triggers `queue`
--
DELIMITER $$
CREATE TRIGGER `after_queue_update` AFTER UPDATE ON `queue` FOR EACH ROW BEGIN
    IF NEW.status = 'done' THEN
        INSERT INTO done_transaction (product_id, quantity, transaction_date)
        SELECT pp.product_id, pp.quantity_needed, NOW()
        FROM package_products pp
        WHERE pp.package_id = NEW.queue_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `queue_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `package_list` varchar(250) NOT NULL,
  `receipt_img_location` varchar(255) DEFAULT NULL,
  `studio` int(25) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` int(11) DEFAULT NULL,
  `time_range` varchar(50) DEFAULT NULL,
  `duration` int(11) DEFAULT 15,
  `users` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `queue_id`, `total_price`, `package_list`, `receipt_img_location`, `studio`, `booking_date`, `booking_time`, `time_range`, `duration`, `users`) VALUES
(12, 18, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(13, 19, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(14, 20, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(15, 21, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(16, 22, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(17, 23, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(18, 24, 700.00, 'Package 2', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(19, 25, 600.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(20, 26, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(21, 27, 600.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(22, 28, 600.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(23, 29, 300.00, 'Package 1', NULL, NULL, NULL, NULL, NULL, 15, NULL),
(24, 30, 1150.00, 'Package 1 | Package 6', NULL, NULL, '0000-00-00', 1, NULL, 15, NULL),
(25, 31, 1150.00, 'Package 1 | Package 6', NULL, NULL, '0000-00-00', 2, NULL, 15, NULL),
(26, 32, 300.00, 'Package 1', NULL, NULL, '2024-11-12', 4, NULL, 15, NULL),
(27, 33, 300.00, 'Package 1', NULL, NULL, '0000-00-00', 2, NULL, 15, NULL),
(28, 34, 300.00, 'Package 1', NULL, 2, '0000-00-00', 2, NULL, 15, NULL),
(29, 35, 300.00, 'Package 1', NULL, 2, '2024-11-19', 2, NULL, 15, NULL),
(30, 36, 850.00, 'Package 3 | Package 4', NULL, 1, '2024-11-13', 1, NULL, 15, NULL),
(31, 37, 1350.00, 'Package 3 | Package 4 | Package 5', NULL, 1, '2024-11-13', 1, NULL, 15, NULL),
(32, 38, 2000.00, 'Package 1 | Package 2 | Package 3 | Package 4 | Package 5', NULL, 2, '2024-11-13', 4, NULL, 15, NULL),
(33, 39, 2000.00, 'Package 1 | Package 2 | Package 3 | Package 4 | Package 5', NULL, 2, '2024-11-28', 6, NULL, 15, NULL),
(34, 40, 650.00, 'Package 1 | Package 2', NULL, 1, '2024-11-15', 4, NULL, 15, NULL),
(40, 46, 700.00, 'Package 1 | Package 3', 'admin/receipts/receipt1_20241105.jpg', 2, '2024-11-29', 5, NULL, 15, NULL),
(41, 47, 850.00, 'Package 1 | Package 6', 'admin/receipts/receipt1_20241105.png', 1, '2024-11-29', 6, NULL, 15, NULL),
(42, 48, 850.00, 'Package 1 | Package 6', NULL, 2, '2024-11-30', 2, NULL, 15, NULL),
(43, 49, 300.00, 'Package 1', NULL, 1, '2024-11-23', 4, NULL, 15, NULL),
(44, 50, 600.00, 'Package 1', NULL, 1, '2024-11-28', 3, NULL, 15, NULL),
(45, 51, 300.00, 'Package 1', NULL, 2, '2024-12-01', 2, NULL, 15, NULL),
(46, 52, 600.00, 'Package 1', NULL, 2, '2024-12-01', 2, NULL, 15, NULL),
(47, 53, 1050.00, 'Package 1 | Package 4', 'admin/receipts/dosreceipt_20241114.jpg', 2, '2024-12-01', 2, NULL, 15, NULL),
(48, 54, 300.00, 'Package 1', 'admin/receipts/dosreceipt_20241114.png', 2, '2024-11-26', 1, NULL, 15, NULL),
(49, 55, 600.00, 'Package 1', NULL, 1, '2024-12-02', 1, NULL, 15, NULL),
(50, 56, 300.00, 'Package 1', 'admin/receipts/dosreceipt_20241114.jpg', 1, '2024-11-22', 4, NULL, 15, NULL),
(51, 57, 2500.00, 'Package 4', 'location1.jpg', 1, '2023-01-01', 3, NULL, 15, NULL),
(52, 58, 2800.00, 'Package 5', 'location2.jpg', 2, '2023-02-14', 2, NULL, 15, NULL),
(53, 59, 1500.00, 'Package 3', 'location3.jpg', 1, '2023-02-25', 1, NULL, 15, NULL),
(54, 60, 2200.00, 'Package 2', 'location4.jpg', 2, '2023-04-09', 4, NULL, 15, NULL),
(55, 61, 1800.00, 'Package 1', 'location5.jpg', 1, '2023-05-01', 5, NULL, 15, NULL),
(56, 62, 3200.00, 'Package 6', 'location6.jpg', 2, '2023-06-12', 6, NULL, 15, NULL),
(57, 63, 2100.00, 'Package 4', 'location7.jpg', 1, '2023-08-01', 3, NULL, 15, NULL),
(58, 64, 2600.00, 'Package 5', 'location8.jpg', 2, '2023-08-28', 2, NULL, 15, NULL),
(59, 65, 2400.00, 'Package 3', 'location9.jpg', 1, '2023-10-03', 1, NULL, 15, NULL),
(60, 66, 1900.00, 'Package 1', 'location10.jpg', 2, '2023-10-31', 4, NULL, 15, NULL),
(61, 67, 2000.00, 'Package 2', 'location11.jpg', 1, '2023-11-01', 5, NULL, 15, NULL),
(62, 68, 2200.00, 'Package 3', 'location12.jpg', 2, '2023-11-30', 6, NULL, 15, NULL),
(63, 69, 2500.00, 'Package 4', 'location13.jpg', 1, '2023-12-25', 2, NULL, 15, NULL),
(64, 70, 3500.00, 'Package 6', 'location14.jpg', 2, '2023-12-30', 3, NULL, 15, NULL),
(65, 71, 3000.00, 'Package 5', 'location15.jpg', 1, '2023-07-10', 5, NULL, 15, NULL),
(66, 72, 2100.00, 'Package 2', 'location16.jpg', 2, '2023-07-20', 1, NULL, 15, NULL),
(67, 73, 1500.00, 'Package 1', 'location17.jpg', 1, '2023-08-05', 4, NULL, 15, NULL),
(68, 74, 2200.00, 'Package 3', 'location18.jpg', 2, '2023-09-14', 6, NULL, 15, NULL),
(69, 75, 2800.00, 'Package 5', 'location19.jpg', 1, '2023-09-19', 2, NULL, 15, NULL),
(70, 76, 2500.00, 'Package 4', 'location20.jpg', 2, '2023-11-14', 3, NULL, 15, NULL),
(71, 77, 2300.00, 'Package 2', 'location21.jpg', 1, '2023-12-01', 5, NULL, 15, NULL),
(72, 78, 2700.00, 'Package 6', 'location22.jpg', 2, '2023-06-15', 4, NULL, 15, NULL),
(73, 79, 2000.00, 'Package 3', 'location23.jpg', 1, '2023-07-25', 1, NULL, 15, NULL),
(74, 80, 1900.00, 'Package 1', 'location24.jpg', 2, '2023-04-16', 2, NULL, 15, NULL),
(75, 81, 2100.00, 'Package 4', 'location25.jpg', 1, '2023-03-01', 6, NULL, 15, NULL),
(76, 82, 2400.00, 'Package 2', 'location26.jpg', 2, '2023-03-10', 4, NULL, 15, NULL),
(77, 83, 2800.00, 'Package 5', 'location27.jpg', 1, '2023-05-25', 3, NULL, 15, NULL),
(78, 84, 3000.00, 'Package 6', 'location28.jpg', 2, '2023-06-20', 2, NULL, 15, NULL),
(79, 85, 3200.00, 'Package 6', 'location29.jpg', 1, '2023-08-12', 5, NULL, 15, NULL),
(80, 86, 2200.00, 'Package 4', 'location30.jpg', 2, '2023-09-07', 6, NULL, 15, NULL),
(81, 87, 2400.00, 'Package 3', 'location31.jpg', 1, '2023-10-10', 3, NULL, 15, NULL),
(82, 88, 1800.00, 'Package 1', 'location32.jpg', 2, '2023-10-20', 1, NULL, 15, NULL),
(83, 89, 1500.00, 'Package 2', 'location33.jpg', 1, '2023-11-05', 4, NULL, 15, NULL),
(84, 90, 2500.00, 'Package 4', 'location34.jpg', 2, '2023-11-15', 2, NULL, 15, NULL),
(85, 91, 2900.00, 'Package 5', 'location35.jpg', 1, '2023-12-05', 6, NULL, 15, NULL),
(86, 92, 2700.00, 'Package 6', 'location36.jpg', 2, '2023-12-12', 3, NULL, 15, NULL),
(87, 93, 3000.00, 'Package 5', 'location37.jpg', 1, '2023-02-10', 5, NULL, 15, NULL),
(88, 94, 2200.00, 'Package 3', 'location38.jpg', 2, '2023-02-18', 4, NULL, 15, NULL),
(89, 95, 2500.00, 'Package 4', 'location39.jpg', 1, '2023-03-20', 1, NULL, 15, NULL),
(90, 96, 2300.00, 'Package 2', 'location40.jpg', 2, '2023-04-01', 6, NULL, 15, NULL),
(91, 97, 2600.00, 'Package 6', 'location41.jpg', 1, '2023-05-15', 3, NULL, 15, NULL),
(92, 98, 1900.00, 'Package 1', 'location42.jpg', 2, '2023-06-25', 5, NULL, 15, NULL),
(93, 99, 2100.00, 'Package 2', 'location43.jpg', 1, '2023-07-30', 4, NULL, 15, NULL),
(94, 100, 2800.00, 'Package 5', 'location44.jpg', 2, '2023-08-18', 2, NULL, 15, NULL),
(95, 101, 3200.00, 'Package 6', 'location45.jpg', 1, '2023-09-09', 6, NULL, 15, NULL),
(96, 102, 2500.00, 'Package 4', 'location46.jpg', 2, '2023-10-05', 3, NULL, 15, NULL),
(97, 103, 2700.00, 'Package 5', 'location47.jpg', 1, '2023-11-01', 5, NULL, 15, NULL),
(98, 104, 1500.00, 'Package 1', 'images/receipt_104.jpg', 1, '2023-12-01', 2, NULL, 15, NULL),
(99, 105, 2000.00, 'Package 2', 'images/receipt_105.jpg', 2, '2023-12-02', 4, NULL, 15, NULL),
(100, 106, 2500.00, 'Package 3', 'images/receipt_106.jpg', 1, '2023-12-03', 1, NULL, 15, NULL),
(101, 107, 1800.00, 'Package 4', 'images/receipt_107.jpg', 2, '2023-12-04', 3, NULL, 15, NULL),
(102, 108, 2200.00, 'Package 5', 'images/receipt_108.jpg', 1, '2023-12-18', 6, NULL, 15, NULL),
(103, 109, 1300.00, 'Package 1', 'images/receipt_109.jpg', 2, '2023-12-06', 5, NULL, 15, NULL),
(104, 110, 2700.00, 'Package 6', 'images/receipt_110.jpg', 1, '2023-12-07', 2, NULL, 15, NULL),
(105, 111, 1900.00, 'Package 2', 'images/receipt_111.jpg', 2, '2023-12-08', 3, NULL, 15, NULL),
(106, 112, 1600.00, 'Package 3', 'images/receipt_112.jpg', 1, '2023-12-09', 4, NULL, 15, NULL),
(107, 113, 2100.00, 'Package 4', 'images/receipt_113.jpg', 2, '2023-12-18', 1, NULL, 15, NULL),
(108, 114, 2200.00, 'Package 5', 'images/receipt_114.jpg', 1, '2023-12-16', 2, NULL, 15, NULL),
(109, 115, 1800.00, 'Package 6', 'images/receipt_115.jpg', 2, '2023-12-16', 3, NULL, 15, NULL),
(110, 116, 2500.00, 'Package 1', 'images/receipt_116.jpg', 1, '2023-12-16', 4, NULL, 15, NULL),
(111, 117, 1600.00, 'Package 2', 'images/receipt_117.jpg', 2, '2023-12-14', 5, NULL, 15, NULL),
(112, 118, 2000.00, 'Package 3', 'images/receipt_118.jpg', 1, '2023-12-15', 6, NULL, 15, NULL),
(113, 119, 2300.00, 'Package 4', 'images/receipt_119.jpg', 2, '2023-12-24', 1, NULL, 15, NULL),
(114, 120, 2400.00, 'Package 5', 'images/receipt_120.jpg', 1, '2023-12-24', 2, NULL, 15, NULL),
(115, 121, 2500.00, 'Package 6', 'images/receipt_121.jpg', 2, '2023-12-24', 3, NULL, 15, NULL),
(116, 122, 1800.00, 'Package 1', 'images/receipt_122.jpg', 1, '2023-12-24', 4, NULL, 15, NULL),
(117, 123, 2100.00, 'Package 2', 'images/receipt_123.jpg', 2, '2023-12-24', 5, NULL, 15, NULL),
(118, 124, 2200.00, 'Package 3', 'images/receipt_124.jpg', 1, '2023-12-24', 6, NULL, 15, NULL),
(119, 125, 2000.00, 'Package 4', 'images/receipt_125.jpg', 2, '2023-12-24', 1, NULL, 15, NULL),
(120, 126, 2700.00, 'Package 5', 'images/receipt_126.jpg', 1, '2023-12-24', 2, NULL, 15, NULL),
(121, 127, 1600.00, 'Package 6', 'images/receipt_127.jpg', 2, '2023-12-24', 3, NULL, 15, NULL),
(122, 128, 1500.00, 'Package 1', 'images/receipt_128.jpg', 1, '2023-12-25', 4, NULL, 15, NULL),
(123, 129, 2100.00, 'Package 2', 'images/receipt_129.jpg', 2, '2023-12-26', 5, NULL, 15, NULL),
(124, 130, 2200.00, 'Package 3', 'images/receipt_130.jpg', 1, '2023-12-24', 6, NULL, 15, NULL),
(125, 131, 2300.00, 'Package 4', 'images/receipt_131.jpg', 2, '2023-12-28', 1, NULL, 15, NULL),
(126, 132, 2000.00, 'Package 5', 'images/receipt_132.jpg', 1, '2023-12-29', 2, NULL, 15, NULL),
(127, 133, 2500.00, 'Package 6', 'images/receipt_133.jpg', 2, '2023-12-30', 3, NULL, 15, NULL),
(128, 134, 1800.00, 'Package 1', 'images/receipt_134.jpg', 1, '2023-12-31', 4, NULL, 15, NULL),
(129, 135, 1700.00, 'Package 2', 'images/receipt_135.jpg', 2, '2023-12-16', 5, NULL, 15, NULL),
(130, 136, 1900.00, 'Package 3', 'images/receipt_136.jpg', 1, '2023-12-16', 6, NULL, 15, NULL),
(131, 137, 2100.00, 'Package 4', 'images/receipt_137.jpg', 2, '2023-12-18', 1, NULL, 15, NULL),
(132, 138, 2200.00, 'Package 5', 'images/receipt_138.jpg', 1, '2023-12-04', 2, NULL, 15, NULL),
(133, 139, 2500.00, 'Package 6', 'images/receipt_139.jpg', 2, '2023-12-18', 3, NULL, 15, NULL),
(134, 140, 1600.00, 'Package 1', 'images/receipt_140.jpg', 1, '2023-12-06', 4, NULL, 15, NULL),
(135, 141, 2000.00, 'Package 2', 'images/receipt_141.jpg', 2, '2023-12-07', 5, NULL, 15, NULL),
(136, 142, 2400.00, 'Package 3', 'images/receipt_142.jpg', 1, '2023-12-08', 6, NULL, 15, NULL),
(137, 143, 2200.00, 'Package 4', 'images/receipt_143.jpg', 2, '2023-12-09', 1, NULL, 15, NULL),
(138, 144, 2700.00, 'Package 5', 'images/receipt_144.jpg', 1, '2023-12-10', 2, NULL, 15, NULL),
(139, 145, 1600.00, 'Package 6', 'images/receipt_145.jpg', 2, '2023-12-11', 3, NULL, 15, NULL),
(140, 146, 1800.00, 'Package 1', 'images/receipt_146.jpg', 1, '2023-12-12', 4, NULL, 15, NULL),
(141, 147, 2100.00, 'Package 2', 'images/receipt_147.jpg', 2, '2023-12-13', 5, NULL, 15, NULL),
(142, 148, 2200.00, 'Package 3', 'images/receipt_148.jpg', 1, '2023-12-14', 6, NULL, 15, NULL),
(143, 149, 2300.00, 'Package 4', 'images/receipt_149.jpg', 2, '2023-12-18', 1, NULL, 15, NULL),
(144, 150, 2400.00, 'Package 5', 'images/receipt_150.jpg', 1, '2023-12-16', 2, NULL, 15, NULL),
(145, 151, 2500.00, 'Package 6', 'images/receipt_151.jpg', 2, '2023-12-17', 3, NULL, 15, NULL),
(146, 152, 1500.00, 'Package 1', 'images/receipt_152.jpg', 1, '2023-12-18', 4, NULL, 15, NULL),
(147, 153, 2200.00, 'Package 2', 'images/receipt_153.jpg', 2, '2023-12-19', 5, NULL, 15, NULL),
(148, 154, 1500.00, 'Package 1', 'receipts/148.jpg', 1, '2022-12-01', 1, NULL, 15, NULL),
(149, 155, 1800.00, 'Package 2', 'receipts/149.jpg', 2, '2022-12-01', 2, NULL, 15, NULL),
(150, 156, 2000.00, 'Package 3', 'receipts/150.jpg', 1, '2022-12-02', 3, NULL, 15, NULL),
(151, 157, 2500.00, 'Package 4', 'receipts/151.jpg', 2, '2022-12-02', 4, NULL, 15, NULL),
(152, 158, 3000.00, 'Package 5', 'receipts/152.jpg', 1, '2022-12-03', 5, NULL, 15, NULL),
(153, 159, 1200.00, 'Package 6', 'receipts/153.jpg', 2, '2022-12-04', 6, NULL, 15, NULL),
(154, 160, 1500.00, 'Package 1', 'receipts/154.jpg', 1, '2022-12-18', 1, NULL, 15, NULL),
(155, 161, 1800.00, 'Package 2', 'receipts/155.jpg', 2, '2022-12-04', 2, NULL, 15, NULL),
(156, 162, 2000.00, 'Package 3', 'receipts/156.jpg', 1, '2022-12-04', 3, NULL, 15, NULL),
(157, 163, 2500.00, 'Package 4', 'receipts/157.jpg', 2, '2022-12-04', 4, NULL, 15, NULL),
(158, 164, 3000.00, 'Package 5', 'receipts/158.jpg', 1, '2022-12-04', 5, NULL, 15, NULL),
(159, 165, 1200.00, 'Package 6', 'receipts/159.jpg', 2, '2022-12-06', 6, NULL, 15, NULL),
(160, 166, 1500.00, 'Package 1', 'receipts/160.jpg', 1, '2022-12-07', 1, NULL, 15, NULL),
(161, 167, 1800.00, 'Package 2', 'receipts/161.jpg', 2, '2022-12-07', 2, NULL, 15, NULL),
(162, 168, 2000.00, 'Package 3', 'receipts/162.jpg', 1, '2022-12-18', 3, NULL, 15, NULL),
(163, 169, 2500.00, 'Package 4', 'receipts/163.jpg', 2, '2022-12-18', 4, NULL, 15, NULL),
(164, 170, 3000.00, 'Package 5', 'receipts/164.jpg', 1, '2022-12-09', 5, NULL, 15, NULL),
(165, 171, 1200.00, 'Package 6', 'receipts/165.jpg', 2, '2022-12-09', 6, NULL, 15, NULL),
(166, 172, 1500.00, 'Package 1', 'receipts/166.jpg', 1, '2022-12-10', 1, NULL, 15, NULL),
(167, 173, 1800.00, 'Package 2', 'receipts/167.jpg', 2, '2022-12-10', 2, NULL, 15, NULL),
(168, 174, 2000.00, 'Package 3', 'receipts/168.jpg', 1, '2022-12-11', 3, NULL, 15, NULL),
(169, 175, 2500.00, 'Package 4', 'receipts/169.jpg', 2, '2022-12-11', 4, NULL, 15, NULL),
(170, 176, 3000.00, 'Package 5', 'receipts/170.jpg', 1, '2022-12-12', 5, NULL, 15, NULL),
(171, 177, 1200.00, 'Package 6', 'receipts/171.jpg', 2, '2022-12-12', 6, NULL, 15, NULL),
(172, 178, 1500.00, 'Package 1', 'receipts/172.jpg', 1, '2022-12-13', 1, NULL, 15, NULL),
(173, 179, 1800.00, 'Package 2', 'receipts/173.jpg', 2, '2022-12-13', 2, NULL, 15, NULL),
(174, 180, 2000.00, 'Package 3', 'receipts/174.jpg', 1, '2022-12-14', 3, NULL, 15, NULL),
(175, 181, 2500.00, 'Package 4', 'receipts/175.jpg', 2, '2022-12-14', 4, NULL, 15, NULL),
(176, 182, 3000.00, 'Package 5', 'receipts/176.jpg', 1, '2022-12-15', 5, NULL, 15, NULL),
(177, 183, 1200.00, 'Package 6', 'receipts/177.jpg', 2, '2022-12-15', 6, NULL, 15, NULL),
(178, 184, 1500.00, 'Package 1', 'receipts/178.jpg', 1, '2022-12-16', 1, NULL, 15, NULL),
(179, 185, 1800.00, 'Package 2', 'receipts/179.jpg', 2, '2022-12-16', 2, NULL, 15, NULL),
(180, 186, 2000.00, 'Package 3', 'receipts/180.jpg', 1, '2022-12-17', 3, NULL, 15, NULL),
(181, 187, 2500.00, 'Package 4', 'receipts/181.jpg', 2, '2022-12-17', 4, NULL, 15, NULL),
(182, 188, 3000.00, 'Package 5', 'receipts/182.jpg', 1, '2022-12-18', 5, NULL, 15, NULL),
(183, 189, 1200.00, 'Package 6', 'receipts/183.jpg', 2, '2022-12-18', 6, NULL, 15, NULL),
(184, 190, 1500.00, 'Package 1', 'receipts/184.jpg', 1, '2022-12-20', 1, NULL, 15, NULL),
(185, 191, 1800.00, 'Package 2', 'receipts/185.jpg', 2, '2022-12-20', 2, NULL, 15, NULL),
(186, 192, 2000.00, 'Package 3', 'receipts/186.jpg', 1, '2022-12-20', 3, NULL, 15, NULL),
(187, 193, 2500.00, 'Package 4', 'receipts/187.jpg', 2, '2022-12-20', 4, NULL, 15, NULL),
(188, 194, 3000.00, 'Package 5', 'receipts/188.jpg', 1, '2022-12-24', 5, NULL, 15, NULL),
(189, 195, 1200.00, 'Package 6', 'receipts/189.jpg', 2, '2022-12-24', 6, NULL, 15, NULL),
(190, 196, 1500.00, 'Package 1', 'receipts/190.jpg', 1, '2022-12-24', 1, NULL, 15, NULL),
(191, 197, 1800.00, 'Package 2', 'receipts/191.jpg', 2, '2022-12-24', 2, NULL, 15, NULL),
(192, 198, 2000.00, 'Package 3', 'receipts/192.jpg', 1, '2022-12-24', 3, NULL, 15, NULL),
(193, 199, 1500.00, 'Package 1', 'receipts/193.jpg', 1, '2024-09-01', 1, NULL, 15, NULL),
(194, 200, 1800.00, 'Package 2', 'receipts/194.jpg', 2, '2024-09-02', 2, NULL, 15, NULL),
(195, 201, 2000.00, 'Package 3', 'receipts/195.jpg', 1, '2024-09-03', 3, NULL, 15, NULL),
(196, 202, 2500.00, 'Package 4', 'receipts/196.jpg', 2, '2024-09-04', 4, NULL, 15, NULL),
(199, 205, 1500.00, 'Package 1', 'receipts/199.jpg', 1, '2024-09-07', 1, NULL, 15, NULL),
(200, 206, 1800.00, 'Package 2', 'receipts/200.jpg', 2, '2024-09-08', 2, NULL, 15, NULL),
(201, 207, 2000.00, 'Package 3', 'receipts/201.jpg', 1, '2024-09-09', 3, NULL, 15, NULL),
(202, 208, 2500.00, 'Package 4', 'receipts/202.jpg', 2, '2024-09-10', 4, NULL, 15, NULL),
(203, 209, 3000.00, 'Package 5', 'receipts/203.jpg', 1, '2024-09-11', 5, NULL, 15, NULL),
(204, 210, 1200.00, 'Package 6', 'receipts/204.jpg', 2, '2024-09-12', 6, NULL, 15, NULL),
(205, 211, 1500.00, 'Package 1', 'receipts/205.jpg', 1, '2024-09-13', 1, NULL, 15, NULL),
(206, 212, 1800.00, 'Package 2', 'receipts/206.jpg', 2, '2024-09-14', 2, NULL, 15, NULL),
(207, 213, 2000.00, 'Package 3', 'receipts/207.jpg', 1, '2024-09-15', 3, NULL, 15, NULL),
(208, 214, 2500.00, 'Package 4', 'receipts/208.jpg', 2, '2024-09-16', 4, NULL, 15, NULL),
(209, 215, 3000.00, 'Package 5', 'receipts/209.jpg', 1, '2024-09-17', 5, NULL, 15, NULL),
(210, 216, 1200.00, 'Package 6', 'receipts/210.jpg', 2, '2024-09-18', 6, NULL, 15, NULL),
(211, 217, 1500.00, 'Package 1', 'receipts/211.jpg', 1, '2024-09-19', 1, NULL, 15, NULL),
(212, 218, 1800.00, 'Package 2', 'receipts/212.jpg', 2, '2024-09-20', 2, NULL, 15, NULL),
(213, 219, 2000.00, 'Package 3', 'receipts/213.jpg', 1, '2024-09-21', 3, NULL, 15, NULL),
(214, 220, 2500.00, 'Package 4', 'receipts/214.jpg', 2, '2024-09-22', 4, NULL, 15, NULL),
(215, 221, 3000.00, 'Package 5', 'receipts/215.jpg', 1, '2024-09-23', 5, NULL, 15, NULL),
(216, 222, 1200.00, 'Package 6', 'receipts/216.jpg', 2, '2024-09-24', 6, NULL, 15, NULL),
(217, 223, 1500.00, 'Package 1', 'receipts/217.jpg', 1, '2024-09-25', 1, NULL, 15, NULL),
(218, 224, 1800.00, 'Package 2', 'receipts/218.jpg', 2, '2024-09-26', 2, NULL, 15, NULL),
(219, 225, 2000.00, 'Package 3', 'receipts/219.jpg', 1, '2024-09-27', 3, NULL, 15, NULL),
(220, 226, 2500.00, 'Package 4', 'receipts/220.jpg', 2, '2024-09-28', 4, NULL, 15, NULL),
(221, 227, 3000.00, 'Package 5', 'receipts/221.jpg', 1, '2024-09-29', 5, NULL, 15, NULL),
(222, 228, 1200.00, 'Package 6', 'receipts/222.jpg', 2, '2024-09-30', 6, NULL, 15, NULL),
(223, 229, 1500.00, 'Package 1', 'receipts/223.jpg', 1, '0000-00-00', 1, NULL, 15, NULL),
(224, 230, 1800.00, 'Package 2', 'receipts/224.jpg', 2, '2024-10-01', 2, NULL, 15, NULL),
(225, 231, 2000.00, 'Package 3', 'receipts/225.jpg', 1, '2024-10-02', 3, NULL, 15, NULL),
(226, 232, 2500.00, 'Package 4', 'receipts/226.jpg', 2, '2024-10-03', 4, NULL, 15, NULL),
(227, 233, 3000.00, 'Package 5', 'receipts/227.jpg', 1, '2024-10-04', 5, NULL, 15, NULL),
(228, 234, 1200.00, 'Package 6', 'receipts/228.jpg', 2, '2024-10-05', 6, NULL, 15, NULL),
(229, 235, 1500.00, 'Package 1', 'receipts/229.jpg', 1, '2024-10-06', 1, NULL, 15, NULL),
(230, 236, 1800.00, 'Package 2', 'receipts/230.jpg', 2, '2024-10-07', 2, NULL, 15, NULL),
(231, 237, 2000.00, 'Package 3', 'receipts/231.jpg', 1, '2024-10-08', 3, NULL, 15, NULL),
(232, 238, 2500.00, 'Package 4', 'receipts/232.jpg', 2, '2024-10-09', 4, NULL, 15, NULL),
(233, 239, 3000.00, 'Package 5', 'receipts/233.jpg', 1, '2024-10-10', 5, NULL, 15, NULL),
(234, 240, 1200.00, 'Package 6', 'receipts/234.jpg', 2, '2024-10-11', 6, NULL, 15, NULL),
(235, 241, 1500.00, 'Package 1', 'receipts/235.jpg', 1, '2024-10-12', 1, NULL, 15, NULL),
(236, 242, 1800.00, 'Package 2', 'receipts/236.jpg', 2, '2024-10-13', 2, NULL, 15, NULL),
(237, 243, 2000.00, 'Package 3', 'receipts/237.jpg', 1, '2024-10-14', 3, NULL, 15, NULL),
(238, 244, 2500.00, 'Package 4', 'receipts/238.jpg', 2, '2024-10-15', 4, NULL, 15, NULL),
(239, 245, 3000.00, 'Package 5', 'receipts/239.jpg', 1, '2024-10-16', 5, NULL, 15, NULL),
(240, 246, 1200.00, 'Package 6', 'receipts/240.jpg', 2, '2024-10-17', 6, NULL, 15, NULL),
(241, 247, 1500.00, 'Package 1', 'receipts/241.jpg', 1, '2024-10-18', 1, NULL, 15, NULL),
(242, 248, 1800.00, 'Package 2', 'receipts/242.jpg', 2, '2024-10-19', 2, NULL, 15, NULL),
(243, 249, 2000.00, 'Package 3', 'receipts/243.jpg', 1, '2024-10-20', 3, NULL, 15, NULL),
(244, 250, 300.00, 'Package 1', NULL, 1, '2024-11-08', 1, NULL, 15, NULL),
(247, 253, 350.00, 'Package 2', 'admin/receipts/dosreceipt_20241126.jpg', 1, '2024-12-05', 1, NULL, 15, NULL),
(248, 254, 300.00, 'Package 1', NULL, 1, '2024-11-28', 1, NULL, 15, NULL),
(249, 255, 400.00, 'Package 3', NULL, 2, '2024-11-28', 1, NULL, 15, NULL),
(250, 260, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241130.jpg', 1, '2024-12-01', 1, NULL, 15, NULL),
(251, 261, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241130.jpg', 1, '2024-11-30', 4, NULL, 15, NULL),
(252, 262, 300.00, 'Special Package', NULL, 2, '2024-12-01', 1, NULL, 15, NULL),
(253, 263, 300.00, 'Special Package', NULL, 1, '2024-12-01', 2, NULL, 15, NULL),
(254, 264, 300.00, 'Special Package', NULL, 2, '2024-12-02', 1, NULL, 15, NULL),
(255, 265, 300.00, 'Special Package', NULL, 2, '2024-12-02', 1, NULL, 15, NULL),
(256, 266, 300.00, 'Special Package', NULL, 2, '2024-12-02', 1, NULL, 15, NULL),
(257, 274, 300.00, 'Special Package', NULL, 1, '2024-12-03', 1, NULL, 15, NULL),
(258, 279, 300.00, 'Special Package', NULL, 2, '2024-12-03', 9, NULL, 15, NULL),
(259, 280, 400.00, 'Basic Package', NULL, 1, '2024-12-03', 11, NULL, 15, NULL),
(260, 281, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241130.jpg', 1, '2024-12-03', 6, NULL, 15, NULL),
(277, 322, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241201.png', 1, '2024-12-05', 2, NULL, 10, NULL),
(278, 323, 550.00, 'UNO Package', 'admin/receipts/dosreceipt_20241201.png', 1, '2025-01-06', 1, NULL, 60, NULL),
(282, 339, 550.00, 'UNO Package', 'admin/receipts/dosreceipt_20241201.jpg', 1, '2024-12-05', 1, '10:35am - 11:35am', 60, NULL),
(283, 340, 450.00, 'Standard Package', 'admin/receipts/dosreceipt_20241201.jpg', 2, '2024-12-05', 1, '10:05am - 10:35am', 30, NULL),
(284, 341, 550.00, 'UNO Package', 'admin/receipts/dosreceipt_20241201.jpg', 1, '2024-12-05', 2, '12:45pm - 01:45pm', 60, NULL),
(285, 342, 550.00, 'UNO Package', 'admin/receipts/dosreceipt_20241208.jpg', 1, '2024-12-10', 0, '10:00am - 11:00am', 60, NULL),
(286, 343, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241208.png', 1, '2024-12-11', 0, '10:00am - 10:10am', 10, NULL),
(287, 344, 550.00, 'UNO Package', 'admin/receipts/dosreceipt_20241209.png', 1, '2024-12-10', 0, '11:00am - 12:00pm', 60, NULL),
(288, 345, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241209.png', 1, '2024-12-10', 0, '12:00pm - 12:10pm', 10, NULL),
(292, 349, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241211.jpg', 1, '2024-12-27', 0, '10:00am - 10:10am', 10, NULL),
(293, 350, 350.00, 'Promo Package', 'admin/receipts/dosreceipt_20241211.jpg', 1, '2024-12-28', 0, '10:00am - 10:15am', 15, NULL),
(294, 351, 400.00, 'Basic Package', 'admin/receipts/dosreceipt_20241211_113708_351.png', 1, '2024-12-29', 0, '10:00am - 10:30am', 30, NULL),
(295, 352, 450.00, 'Standard Package', 'admin/receipts/dosreceipt_20241211_113758_352.jpg', 1, '2024-12-30', 0, '10:00am - 10:30am', 30, NULL),
(296, 353, 500.00, 'Premium Package', 'admin/receipts/dosreceipt_20241211_122301_353.png', 1, '2024-12-19', 0, '10:00am - 10:30am', 30, NULL),
(297, 354, 300.00, 'Special Package', 'admin/receipts/dosreceipt_20241211_123840_354.png', 1, '2024-12-20', 0, '10:00am - 10:10am', 10, NULL),
(298, 355, 450.00, 'Standard Package', 'admin/receipts/dosreceipt_20241213_084438_355.png', 1, '2024-12-13', 1, '04:00pm - 04:30pm', 30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `stocks_added` int(11) DEFAULT NULL,
  `transaction_date` date NOT NULL DEFAULT curdate(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_type`, `stocks_added`, `transaction_date`, `user`) VALUES
(1, 'A1', 1, '2024-11-06', 0),
(2, 'A1', 1, '2024-11-06', 2),
(3, '2', 10, '2024-11-20', 2),
(4, '2', 100, '2024-11-25', 2),
(5, '2\' x 6\'', 100, '2024-11-25', 2),
(6, '2\' x 6\'', 200, '2024-11-25', 2),
(7, '2\' x 6\'', 100, '2024-11-25', 2),
(8, '4\'x4\'', 500, '2024-11-25', 2),
(9, '2.6\'x4\'', 500, '2024-11-25', 2),
(10, '2\'x2\'', 500, '2024-11-25', 2),
(11, '4\'x6\'', 500, '2024-11-25', 2),
(12, '2', 5, '2024-12-08', 2),
(13, '2', 5, '2024-12-08', 2),
(14, '2\' x 6\'', 5, '2024-12-08', 2),
(15, '2', 5, '2024-12-08', 2),
(16, '2', 5, '2024-12-08', 2),
(17, '2\' x 6\'', 5, '2024-12-08', 2),
(18, '2\' x 6\'', 5, '2024-12-08', 2),
(19, '2\' x 6\'', 100, '2024-12-09', 2);

-- --------------------------------------------------------

--
-- Table structure for table `temporary_packages`
--

CREATE TABLE `temporary_packages` (
  `id` int(11) NOT NULL,
  `image_name_location` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `product_used` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `duration` int(11) DEFAULT 15 COMMENT 'Duration in minutes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temporary_packages`
--

INSERT INTO `temporary_packages` (`id`, `image_name_location`, `price`, `package_name`, `description`, `product_used`, `start_date`, `end_date`, `created_at`, `duration`) VALUES
(1, 'images/package1.png', 250.00, 'Couple Package', '1-2 PAX\n15 mins unlimited studio shoot\n1 background color\nUnlimited props (incl. exclusive props)\n1 strip print\n14R print', '1/2/3', '2024-02-04', '2024-02-16', '2024-11-27 09:57:20', 15);

-- --------------------------------------------------------

--
-- Table structure for table `temporary_packages_images`
--

CREATE TABLE `temporary_packages_images` (
  `id` int(11) NOT NULL,
  `temp_package_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temporary_packages_images`
--

INSERT INTO `temporary_packages_images` (`id`, `temp_package_id`, `image_path`) VALUES
(1, 1, 'images/img5.png');

-- --------------------------------------------------------

--
-- Table structure for table `time_records`
--

CREATE TABLE `time_records` (
  `id` int(11) NOT NULL,
  `user_id` int(6) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT NULL,
  `status` enum('on-time','late','absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_records`
--

INSERT INTO `time_records` (`id`, `user_id`, `date`, `time_in`, `time_out`, `total_hours`, `status`) VALUES
(1, 8, '2024-11-14', '22:36:38', '22:36:42', 0.00, 'late');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `fullname` varchar(250) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`) VALUES
(1, 'Ivan', 'ivan', '$2y$10$cIYL3VB.jVH2ISFs12bfju87nm2dzc6oxpP2PEA4f5gQF/ZK2Ifpa'),
(2, 'Ashley', 'ashley', '$2y$10$cIYL3VB.jVH2ISFs12bfju87nm2dzc6oxpP2PEA4f5gQF/ZK2Ifpa'),
(5, 'thaddeus', 'tjhotdog', '$2y$10$gE6LRhS4y9uPWkj24hwUI.BMgGmHdctH91CTRUkdjuLAjxrizUMg6'),
(6, 'adrian', 'adi', '$2y$10$bJIHL9ZdCDtqMle7P8VDd.a1g3Q6MXgSZOSIdo8KDgkRhDNCWloPq'),
(7, 'Christian', 'clarize', '$2y$10$aniNGBqT2xFjkNBxe0Rb4.EmaEXIvFU67J1kvoVX8NxixUpLfhjQO'),
(8, 'Ian', 'Ian123', '$2y$10$QvjsRC/4dW40eAjGAs4SD.aplTsBA8V9tymYAYfHxUk4JGLZ7/mom'),
(9, 'Eric', 'ericdos', '$2y$10$V7tJTaDeUzrciANI9fB.dOyGF9nmb2rFH7A5uiWLmbUJxO8DzZGE2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduct`
--
ALTER TABLE `deduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `done_transaction`
--
ALTER TABLE `done_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_images`
--
ALTER TABLE `package_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `package_products`
--
ALTER TABLE `package_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`queue_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `queue_id` (`queue_id`),
  ADD KEY `users` (`users`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temporary_packages`
--
ALTER TABLE `temporary_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temporary_packages_images`
--
ALTER TABLE `temporary_packages_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temp_package_id` (`temp_package_id`);

--
-- Indexes for table `time_records`
--
ALTER TABLE `time_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deduct`
--
ALTER TABLE `deduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `done_transaction`
--
ALTER TABLE `done_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `package_images`
--
ALTER TABLE `package_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `package_products`
--
ALTER TABLE `package_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `queue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `temporary_packages`
--
ALTER TABLE `temporary_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temporary_packages_images`
--
ALTER TABLE `temporary_packages_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `done_transaction`
--
ALTER TABLE `done_transaction`
  ADD CONSTRAINT `done_transaction_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `inventory` (`id`);

--
-- Constraints for table `package_images`
--
ALTER TABLE `package_images`
  ADD CONSTRAINT `package_images_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `package_products`
--
ALTER TABLE `package_products`
  ADD CONSTRAINT `package_products_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`),
  ADD CONSTRAINT `package_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `inventory` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`queue_id`) REFERENCES `queue` (`queue_id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`users`) REFERENCES `users` (`id`);

--
-- Constraints for table `temporary_packages_images`
--
ALTER TABLE `temporary_packages_images`
  ADD CONSTRAINT `temporary_packages_images_ibfk_1` FOREIGN KEY (`temp_package_id`) REFERENCES `temporary_packages` (`id`);

--
-- Constraints for table `time_records`
--
ALTER TABLE `time_records`
  ADD CONSTRAINT `time_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
