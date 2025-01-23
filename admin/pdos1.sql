-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 27, 2024 at 11:48 AM
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
(3, 'A1', 1, 'wewe', '2024-11-06 01:58:45');

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
(11, 2, 1, '2024-11-25 16:00:00');

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
(1, '2\' x 6\'', NULL, 6),
(2, '4\'x4\'', NULL, 496),
(3, '2.6\'x4\'', '0', 497),
(4, '2\'x2\'', '0', 502),
(5, '4\'x6\'', 'asd', 502);

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
(63, 'iandauz162@gmail.com', 'WYW3ZG', 256);

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
  `product_used` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `image_name_location`, `price`, `package_name`, `description`, `product_used`) VALUES
(1, 'images/package1.jpg', 300.00, 'Special Package\r\n\r\n', '1-2 PAX\r\n10 mins unlimited studio shoot\r\n1 background color\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos', '1/2/3'),
(2, 'images/package2.jpg', 350.00, 'Promo Package', '1-2 PAX\r\n15 mins unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos', '1/1/1/2'),
(3, 'images/package3.jpg', 400.00, 'Basic Package', '1-2 PAX\r\n30 mins unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos', '1/2/3/4/1/2/2/2'),
(4, 'images/package4.jpg', 450.00, 'Standard Package', '1-2 PAX\r\n30 mins unlimited studio shoot\r\nUnlimited background change\r\nSoft copy of ALL RAW photos\r\n15 mins photo selection\r\n2 strip prints\r\n2 4R prints', '1/1/1/1/2/2/2/2/3/3/3/3/4/4/5/5'),
(5, 'images/package5.jpg', 500.00, 'Premium Package', '1-5 PAX\r\n30 mins unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos\r\n15 mins photo selection\r\n5 strip prints\r\n5 4R prints', '1/1/1/1/2/2/2/2/3/3/3/3/4/4/5/5/2/2/2/4/5/5/5/5'),
(6, 'images/package6.jpg', 550.00, 'UNO Package', '1-2 PAX\r\n1 hour unlimited studio shoot\r\nUnlimited background change\r\nUnlimited use of props\r\nSoft copy of ALL RAW photos\r\n15 mins photo selection\r\n2 strip prints\r\n2 4R prints', '1/1/1/1/2/2/2/2/3/3/3/3/4/4/5/5/2/2/2/4/5/5/5/5/4');

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
  `action` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`queue_id`, `name`, `status`, `action`) VALUES
(1, 'Ivan Bautista', 'For-Checking', NULL),
(2, 'Ivan Bautista', 'Done', NULL),
(3, 'Ivan Bautista', 'On-Going', NULL),
(4, 'Ashley Sampaga', 'Done', NULL),
(5, 'Venize Bautista', 'Cancelled', NULL),
(6, 'Tine Dubouzet', 'Done', NULL),
(7, 'Tine Dubouzet', 'Done', NULL),
(8, 'Tine Dubouzet', 'Done', NULL),
(9, 'Tine Dubouzet', 'Done', NULL),
(10, 'Tine Dubouzet', 'Done', NULL),
(11, 'Tine Dubouzet', 'Cancelled', NULL),
(12, 'Tine Dubouzet', 'Done', NULL),
(13, 'Juan Bautista', 'Cancelled', NULL),
(14, 'Venize Dubouzet', 'Cancelled', NULL),
(15, 'Juan Dubouzet', 'Cancelled', NULL),
(16, 'Ashley Bautista', 'Cancelled', NULL),
(17, 'Ivan Sampaga', 'Done', NULL),
(18, 'Ivan Sampaga', 'Done', NULL),
(19, 'Tine Dubouzet', 'Queue', NULL),
(20, 'Venize Sampaga', 'Queue', NULL),
(21, 'Tine Bautista', 'Queue', NULL),
(22, 'Venize Dubouzet', 'Done', NULL),
(23, 'Venize Dubouzet', 'Queue', NULL),
(24, 'Venize Sampaga', 'Queue', NULL),
(25, 'Juan Sampaga', 'Queue', NULL),
(26, 'Venize Bautista', 'Queue', NULL),
(27, 'Ivan Sampaga', 'Queue', NULL),
(28, 'Juan Bautista', 'Queue', NULL),
(29, 'Venize Dubouzet', 'Queue', NULL),
(30, 'Venize Dubouzet', 'Queue', NULL),
(31, 'Venize Dubouzet', 'Queue', NULL),
(32, 'Ivan Bautista', 'Queue', NULL),
(33, 'Ivan Bautista', 'Queue', NULL),
(34, 'Ivan Bautista', 'Queue', NULL),
(35, 'Ivan Bautista', 'Queue', NULL),
(36, 'Ivan Bautista', 'Done', NULL),
(37, 'Ivan Bautista', 'Done', NULL),
(38, 'Eric Zaragoza', 'Done', NULL),
(39, 'Eric Zaragoza', 'Done', NULL),
(40, 'Ivan Dubouzet', 'Done', NULL),
(41, 'Ivan Dubouzet', 'Done', NULL),
(42, 'Ivan Dubouzet', 'Done', NULL),
(43, 'Ivan Dubouzet', 'Done', NULL),
(44, 'Ivan Dubouzet', 'Done', NULL),
(45, 'Ivan Dubouzet', 'Done', NULL),
(46, 'Ivan Bautista', 'Done', NULL),
(47, 'Ashley Sampaga', 'Done', NULL),
(48, 'Ivan Bautista', 'For-Checking', NULL),
(49, 'Ivan Dubouzet', 'Done', NULL),
(50, 'Venize Dubouzet', 'For-Checking', NULL),
(51, 'Big Black Cresendo', 'Done', NULL),
(52, 'Big Black Cresendo', 'For-Checking', NULL),
(53, 'Big Black Cresendo', 'Done', NULL),
(54, 'Ashley Cresendo', 'Done', NULL),
(55, 'Ashley Sampaga', '', NULL),
(56, 'Venize Bautista', 'Done', NULL),
(57, 'Eva Phillips', 'Done', NULL),
(58, 'Freddie Garcia', 'Done', NULL),
(59, 'Grace Bryant', 'Done', NULL),
(60, 'Henry Cooper', 'Done', NULL),
(61, 'Isla Richardson', 'Done', NULL),
(62, 'Jake Martinez', 'Done', NULL),
(63, 'Luna Ward', 'Done', NULL),
(64, 'Mila Evans', 'Done', NULL),
(65, 'Noah Walker', 'Done', NULL),
(66, 'Olivia Nelson', 'Done', NULL),
(67, 'Penny Carter', 'Done', NULL),
(68, 'Quinn Price', 'Done', NULL),
(69, 'Ryan Roberts', 'Done', NULL),
(70, 'Sophie Murphy', 'Done', NULL),
(71, 'Theo Simmons', 'Done', NULL),
(72, 'Ulysses Brooks', 'Done', NULL),
(73, 'Vera Foster', 'Done', NULL),
(74, 'Walter Green', 'Done', NULL),
(75, 'Xena Powell', 'Done', NULL),
(76, 'Yasmine Coleman', 'Done', NULL),
(77, 'Zara Jenkins', 'Done', NULL),
(78, 'Aaron Mitchell', 'Done', NULL),
(79, 'Bella Stevens', 'Done', NULL),
(80, 'Cameron Lee', 'Done', NULL),
(81, 'Dylan Perry', 'Done', NULL),
(82, 'Ella Knight', 'Done', NULL),
(83, 'Finn Clark', 'Done', NULL),
(84, 'Gina James', 'Done', NULL),
(85, 'Harry Ross', 'Done', NULL),
(86, 'Ivy Cook', 'Done', NULL),
(87, 'Jackie Walker', 'Done', NULL),
(88, 'Kyle Morgan', 'Done', NULL),
(89, 'Lily Carter', 'Done', NULL),
(90, 'Max Johnson', 'Done', NULL),
(91, 'Nina Wood', 'Done', NULL),
(92, 'Oscar Evans', 'Done', NULL),
(93, 'Paulina Ford', 'Done', NULL),
(94, 'Quentin Diaz', 'Done', NULL),
(95, 'Rachel Green', 'Done', NULL),
(96, 'Samuel Bell', 'Done', NULL),
(97, 'Tessa Scott', 'Done', NULL),
(98, 'Uriah Miller', 'Done', NULL),
(99, 'Vince Adams', 'Done', NULL),
(100, 'Wendy Price', 'Done', NULL),
(101, 'Xander Martin', 'Done', NULL),
(102, 'Yara Hughes', 'Done', NULL),
(103, 'Zane Harris', 'Done', NULL),
(104, 'John Doe', 'Done', NULL),
(105, 'Jane Smith', 'Done', NULL),
(106, 'Alice Johnson', 'Done', NULL),
(107, 'Bob Brown', 'Done', NULL),
(108, 'Charlie Davis', 'Done', NULL),
(109, 'David Wilson', 'Done', NULL),
(110, 'Eva Martinez', 'Done', NULL),
(111, 'Frank Lee', 'Done', NULL),
(112, 'Grace Miller', 'Done', NULL),
(113, 'Henry Clark', 'Done', NULL),
(114, 'Isabel Adams', 'Done', NULL),
(115, 'Jack Turner', 'Done', NULL),
(116, 'Kara Thomas', 'Done', NULL),
(117, 'Liam Walker', 'Done', NULL),
(118, 'Mia Lewis', 'Done', NULL),
(119, 'Nathan Harris', 'Done', NULL),
(120, 'Olivia Young', 'Done', NULL),
(121, 'Paul Scott', 'Done', NULL),
(122, 'Quinn Allen', 'Done', NULL),
(123, 'Rachel King', 'Done', NULL),
(124, 'Samuel Baker', 'Done', NULL),
(125, 'Tina Gonzalez', 'Done', NULL),
(126, 'Ursula Hall', 'Done', NULL),
(127, 'Victor Nelson', 'Done', NULL),
(128, 'Wendy Carter', 'Done', NULL),
(129, 'Xander Mitchell', 'Done', NULL),
(130, 'Yara Perez', 'Done', NULL),
(131, 'Zane Roberts', 'Done', NULL),
(132, 'Amelia Lee', 'Done', NULL),
(133, 'Benjamin Moore', 'Done', NULL),
(134, 'Catherine Lewis', 'Done', NULL),
(135, 'Daniel Rodriguez', 'Done', NULL),
(136, 'Eleanor Phillips', 'Done', NULL),
(137, 'Frederick Walker', 'Done', NULL),
(138, 'Gina Cooper', 'Done', NULL),
(139, 'Harry Perez', 'Done', NULL),
(140, 'Irene Davis', 'Done', NULL),
(141, 'Jackie Evans', 'Done', NULL),
(142, 'Kyle Martinez', 'Done', NULL),
(143, 'Lana Turner', 'Done', NULL),
(144, 'Mason Carter', 'Done', NULL),
(145, 'Nora Williams', 'Done', NULL),
(146, 'Oscar Moore', 'Done', NULL),
(147, 'Penny Mitchell', 'Done', NULL),
(148, 'Quincy Howard', 'Done', NULL),
(149, 'Rita Lee', 'Done', NULL),
(150, 'Steve Allen', 'Done', NULL),
(151, 'Terry Young', 'Done', NULL),
(152, 'Uma Johnson', 'Done', NULL),
(153, 'Vera Scott', 'Done', NULL),
(154, 'David Martinez', 'Done', NULL),
(155, 'Sophia Garcia', 'Done', NULL),
(156, 'Liam Anderson', 'Done', NULL),
(157, 'Olivia Taylor', 'Done', NULL),
(158, 'Noah White', 'Done', NULL),
(159, 'Emma Harris', 'Done', NULL),
(160, 'Lucas Clark', 'Done', NULL),
(161, 'Ava Lewis', 'Done', NULL),
(162, 'Mason Walker', 'Done', NULL),
(163, 'Isabella Hall', 'Done', NULL),
(164, 'Ethan Allen', 'Done', NULL),
(165, 'Mia Young', 'Done', NULL),
(166, 'James King', 'Done', NULL),
(167, 'Amelia Wright', 'Done', NULL),
(168, 'Alexander Scott', 'Done', NULL),
(169, 'Charlotte Green', 'Done', NULL),
(170, 'Benjamin Baker', 'Done', NULL),
(171, 'Abigail Adams', 'Done', NULL),
(172, 'Michael Hill', 'Done', NULL),
(173, 'Ella Nelson', 'Done', NULL),
(174, 'William Carter', 'Done', NULL),
(175, 'Grace Mitchell', 'Done', NULL),
(176, 'Daniel Perez', 'Done', NULL),
(177, 'Lily Roberts', 'Done', NULL),
(178, 'Matthew Turner', 'Done', NULL),
(179, 'Chloe Phillips', 'Done', NULL),
(180, 'Henry Campbell', 'Done', NULL),
(181, 'Victoria Parker', 'Done', NULL),
(182, 'Jackson Evans', 'Done', NULL),
(183, 'Scarlett Edwards', 'Done', NULL),
(184, 'Sebastian Collins', 'Done', NULL),
(185, 'Hannah Stewart', 'Done', NULL),
(186, 'Aiden Morris', 'Done', NULL),
(187, 'Aria Rogers', 'Done', NULL),
(188, 'Gabriel Reed', 'Done', NULL),
(189, 'Zoe Cook', 'Done', NULL),
(190, 'Carter Bell', 'Done', NULL),
(191, 'Penelope Rivera', 'Done', NULL),
(192, 'Owen Murphy', 'Done', NULL),
(193, 'Lillian Cooper', 'Done', NULL),
(194, 'Caleb Richardson', 'Done', NULL),
(195, 'Riley Bailey', 'Done', NULL),
(196, 'Elijah Sanders', 'Done', NULL),
(197, 'Samantha Morris', 'Done', NULL),
(198, 'Logan Ward', 'Done', NULL),
(199, 'Andrew Roberts', 'Done', NULL),
(200, 'Natalie Smith', 'Done', NULL),
(201, 'Evan Thompson', 'Done', NULL),
(202, 'Harper Wilson', 'Done', NULL),
(203, 'Jacob Adams', 'Done', NULL),
(204, 'Layla Foster', 'Done', NULL),
(205, 'Dylan Hayes', 'Done', NULL),
(206, 'Audrey Martinez', 'Done', NULL),
(207, 'Ryan Hughes', 'Done', NULL),
(208, 'Aurora Brooks', 'Done', NULL),
(209, 'Nathan Flores', 'Done', NULL),
(210, 'Paisley Price', 'Done', NULL),
(211, 'Julian Rivera', 'Done', NULL),
(212, 'Savannah Bell', 'Done', NULL),
(213, 'Isaac Barnes', 'Done', NULL),
(214, 'Brooklyn Perry', 'Done', NULL),
(215, 'Levi Russell', 'Done', NULL),
(216, 'Ellie Griffin', 'Done', NULL),
(217, 'Jason Morgan', 'Done', NULL),
(218, 'Avery Hughes', 'Done', NULL),
(219, 'Connor Scott', 'Done', NULL),
(220, 'Sophie Bailey', 'Done', NULL),
(221, 'Asher Edwards', 'Done', NULL),
(222, 'Madison Turner', 'Done', NULL),
(223, 'Hunter Ramirez', 'Done', NULL),
(224, 'Lucy Sanders', 'Done', NULL),
(225, 'Isaiah Bennett', 'Done', NULL),
(226, 'Victoria Flores', 'Done', NULL),
(227, 'Joseph Collins', 'Done', NULL),
(228, 'Maya Reed', 'Done', NULL),
(229, 'Tyler Ward', 'Done', NULL),
(230, 'Anna Cooper', 'Done', NULL),
(231, 'Eli Mitchell', 'Done', NULL),
(232, 'Claire Adams', 'Done', NULL),
(233, 'Brandon Bell', 'Done', NULL),
(234, 'Stella Brooks', 'Done', NULL),
(235, 'Parker Griffin', 'Done', NULL),
(236, 'Ruby Morris', 'Done', NULL),
(237, 'Cooper Walker', 'Done', NULL),
(238, 'Violet Perry', 'Done', NULL),
(239, 'Hudson Bennett', 'Done', NULL),
(240, 'Penelope Morgan', 'Done', NULL),
(241, 'Miles Hughes', 'Done', NULL),
(242, 'Hazel Scott', 'Done', NULL),
(243, 'Adam Bailey', 'Done', NULL),
(244, 'Elliana Turner', 'Done', NULL),
(245, 'Caleb Ramirez', 'Done', NULL),
(246, 'Eliza Sanders', 'Done', NULL),
(247, 'Easton Ward', 'Done', NULL),
(248, 'Sadie Cooper', 'Done', NULL),
(249, 'Landon Martinez', 'Done', NULL),
(250, 'Ian Dauz', '', NULL),
(251, 'Ian Dauz', '', NULL),
(252, 'Ian Dauz', 'Done', NULL),
(253, 'Ian Dauz', 'Done', NULL),
(254, 'Ian Dauz', '', NULL),
(255, 'Ian Dauz', '', NULL),
(256, 'Ian Dauz', '', NULL);

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
  `booking_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `queue_id`, `total_price`, `package_list`, `receipt_img_location`, `studio`, `booking_date`, `booking_time`) VALUES
(1, 7, 0.00, '', NULL, NULL, NULL, NULL),
(2, 8, 1050.00, '', NULL, NULL, NULL, NULL),
(3, 9, 650.00, '', NULL, NULL, NULL, NULL),
(4, 10, 950.00, '', NULL, NULL, NULL, NULL),
(5, 11, 700.00, '', NULL, NULL, NULL, NULL),
(6, 12, 650.00, '', NULL, NULL, NULL, NULL),
(7, 13, 700.00, '', NULL, NULL, NULL, NULL),
(8, 14, 700.00, 'Package 1 | Package 3', NULL, NULL, NULL, NULL),
(9, 15, 850.00, 'Package 1 | Package 6', NULL, NULL, NULL, NULL),
(10, 16, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(11, 17, 350.00, 'Package 2', NULL, NULL, NULL, NULL),
(12, 18, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(13, 19, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(14, 20, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(15, 21, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(16, 22, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(17, 23, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(18, 24, 700.00, 'Package 2', NULL, NULL, NULL, NULL),
(19, 25, 600.00, 'Package 1', NULL, NULL, NULL, NULL),
(20, 26, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(21, 27, 600.00, 'Package 1', NULL, NULL, NULL, NULL),
(22, 28, 600.00, 'Package 1', NULL, NULL, NULL, NULL),
(23, 29, 300.00, 'Package 1', NULL, NULL, NULL, NULL),
(24, 30, 1150.00, 'Package 1 | Package 6', NULL, NULL, '0000-00-00', 1),
(25, 31, 1150.00, 'Package 1 | Package 6', NULL, NULL, '0000-00-00', 2),
(26, 32, 300.00, 'Package 1', NULL, NULL, '2024-11-12', 4),
(27, 33, 300.00, 'Package 1', NULL, NULL, '0000-00-00', 2),
(28, 34, 300.00, 'Package 1', NULL, 2, '0000-00-00', 2),
(29, 35, 300.00, 'Package 1', NULL, 2, '2024-11-19', 2),
(30, 36, 850.00, 'Package 3 | Package 4', NULL, 1, '2024-11-13', 1),
(31, 37, 1350.00, 'Package 3 | Package 4 | Package 5', NULL, 1, '2024-11-13', 1),
(32, 38, 2000.00, 'Package 1 | Package 2 | Package 3 | Package 4 | Package 5', NULL, 2, '2024-11-13', 4),
(33, 39, 2000.00, 'Package 1 | Package 2 | Package 3 | Package 4 | Package 5', NULL, 2, '2024-11-28', 6),
(34, 40, 650.00, 'Package 1 | Package 2', NULL, 1, '2024-11-15', 4),
(40, 46, 700.00, 'Package 1 | Package 3', 'admin/receipts/receipt1_20241105.jpg', 2, '2024-11-29', 5),
(41, 47, 850.00, 'Package 1 | Package 6', 'admin/receipts/receipt1_20241105.png', 1, '2024-11-29', 6),
(42, 48, 850.00, 'Package 1 | Package 6', NULL, 2, '2024-11-30', 2),
(43, 49, 300.00, 'Package 1', NULL, 1, '2024-11-23', 4),
(44, 50, 600.00, 'Package 1', NULL, 1, '2024-11-28', 3),
(45, 51, 300.00, 'Package 1', NULL, 2, '2024-12-01', 2),
(46, 52, 600.00, 'Package 1', NULL, 2, '2024-12-01', 2),
(47, 53, 1050.00, 'Package 1 | Package 4', 'admin/receipts/dosreceipt_20241114.jpg', 2, '2024-12-01', 2),
(48, 54, 300.00, 'Package 1', 'admin/receipts/dosreceipt_20241114.png', 2, '2024-11-26', 1),
(49, 55, 600.00, 'Package 1', NULL, 1, '2024-12-02', 1),
(50, 56, 300.00, 'Package 1', 'admin/receipts/dosreceipt_20241114.jpg', 1, '2024-11-22', 4),
(51, 57, 2500.00, 'Package 4', 'location1.jpg', 1, '2023-01-01', 3),
(52, 58, 2800.00, 'Package 5', 'location2.jpg', 2, '2023-02-14', 2),
(53, 59, 1500.00, 'Package 3', 'location3.jpg', 1, '2023-02-25', 1),
(54, 60, 2200.00, 'Package 2', 'location4.jpg', 2, '2023-04-09', 4),
(55, 61, 1800.00, 'Package 1', 'location5.jpg', 1, '2023-05-01', 5),
(56, 62, 3200.00, 'Package 6', 'location6.jpg', 2, '2023-06-12', 6),
(57, 63, 2100.00, 'Package 4', 'location7.jpg', 1, '2023-08-01', 3),
(58, 64, 2600.00, 'Package 5', 'location8.jpg', 2, '2023-08-28', 2),
(59, 65, 2400.00, 'Package 3', 'location9.jpg', 1, '2023-10-03', 1),
(60, 66, 1900.00, 'Package 1', 'location10.jpg', 2, '2023-10-31', 4),
(61, 67, 2000.00, 'Package 2', 'location11.jpg', 1, '2023-11-01', 5),
(62, 68, 2200.00, 'Package 3', 'location12.jpg', 2, '2023-11-30', 6),
(63, 69, 2500.00, 'Package 4', 'location13.jpg', 1, '2023-12-25', 2),
(64, 70, 3500.00, 'Package 6', 'location14.jpg', 2, '2023-12-30', 3),
(65, 71, 3000.00, 'Package 5', 'location15.jpg', 1, '2023-07-10', 5),
(66, 72, 2100.00, 'Package 2', 'location16.jpg', 2, '2023-07-20', 1),
(67, 73, 1500.00, 'Package 1', 'location17.jpg', 1, '2023-08-05', 4),
(68, 74, 2200.00, 'Package 3', 'location18.jpg', 2, '2023-09-14', 6),
(69, 75, 2800.00, 'Package 5', 'location19.jpg', 1, '2023-09-19', 2),
(70, 76, 2500.00, 'Package 4', 'location20.jpg', 2, '2023-11-14', 3),
(71, 77, 2300.00, 'Package 2', 'location21.jpg', 1, '2023-12-01', 5),
(72, 78, 2700.00, 'Package 6', 'location22.jpg', 2, '2023-06-15', 4),
(73, 79, 2000.00, 'Package 3', 'location23.jpg', 1, '2023-07-25', 1),
(74, 80, 1900.00, 'Package 1', 'location24.jpg', 2, '2023-04-16', 2),
(75, 81, 2100.00, 'Package 4', 'location25.jpg', 1, '2023-03-01', 6),
(76, 82, 2400.00, 'Package 2', 'location26.jpg', 2, '2023-03-10', 4),
(77, 83, 2800.00, 'Package 5', 'location27.jpg', 1, '2023-05-25', 3),
(78, 84, 3000.00, 'Package 6', 'location28.jpg', 2, '2023-06-20', 2),
(79, 85, 3200.00, 'Package 6', 'location29.jpg', 1, '2023-08-12', 5),
(80, 86, 2200.00, 'Package 4', 'location30.jpg', 2, '2023-09-07', 6),
(81, 87, 2400.00, 'Package 3', 'location31.jpg', 1, '2023-10-10', 3),
(82, 88, 1800.00, 'Package 1', 'location32.jpg', 2, '2023-10-20', 1),
(83, 89, 1500.00, 'Package 2', 'location33.jpg', 1, '2023-11-05', 4),
(84, 90, 2500.00, 'Package 4', 'location34.jpg', 2, '2023-11-15', 2),
(85, 91, 2900.00, 'Package 5', 'location35.jpg', 1, '2023-12-05', 6),
(86, 92, 2700.00, 'Package 6', 'location36.jpg', 2, '2023-12-12', 3),
(87, 93, 3000.00, 'Package 5', 'location37.jpg', 1, '2023-02-10', 5),
(88, 94, 2200.00, 'Package 3', 'location38.jpg', 2, '2023-02-18', 4),
(89, 95, 2500.00, 'Package 4', 'location39.jpg', 1, '2023-03-20', 1),
(90, 96, 2300.00, 'Package 2', 'location40.jpg', 2, '2023-04-01', 6),
(91, 97, 2600.00, 'Package 6', 'location41.jpg', 1, '2023-05-15', 3),
(92, 98, 1900.00, 'Package 1', 'location42.jpg', 2, '2023-06-25', 5),
(93, 99, 2100.00, 'Package 2', 'location43.jpg', 1, '2023-07-30', 4),
(94, 100, 2800.00, 'Package 5', 'location44.jpg', 2, '2023-08-18', 2),
(95, 101, 3200.00, 'Package 6', 'location45.jpg', 1, '2023-09-09', 6),
(96, 102, 2500.00, 'Package 4', 'location46.jpg', 2, '2023-10-05', 3),
(97, 103, 2700.00, 'Package 5', 'location47.jpg', 1, '2023-11-01', 5),
(98, 104, 1500.00, 'Package 1', 'images/receipt_104.jpg', 1, '2023-12-01', 2),
(99, 105, 2000.00, 'Package 2', 'images/receipt_105.jpg', 2, '2023-12-02', 4),
(100, 106, 2500.00, 'Package 3', 'images/receipt_106.jpg', 1, '2023-12-03', 1),
(101, 107, 1800.00, 'Package 4', 'images/receipt_107.jpg', 2, '2023-12-04', 3),
(102, 108, 2200.00, 'Package 5', 'images/receipt_108.jpg', 1, '2023-12-18', 6),
(103, 109, 1300.00, 'Package 1', 'images/receipt_109.jpg', 2, '2023-12-06', 5),
(104, 110, 2700.00, 'Package 6', 'images/receipt_110.jpg', 1, '2023-12-07', 2),
(105, 111, 1900.00, 'Package 2', 'images/receipt_111.jpg', 2, '2023-12-08', 3),
(106, 112, 1600.00, 'Package 3', 'images/receipt_112.jpg', 1, '2023-12-09', 4),
(107, 113, 2100.00, 'Package 4', 'images/receipt_113.jpg', 2, '2023-12-18', 1),
(108, 114, 2200.00, 'Package 5', 'images/receipt_114.jpg', 1, '2023-12-16', 2),
(109, 115, 1800.00, 'Package 6', 'images/receipt_115.jpg', 2, '2023-12-16', 3),
(110, 116, 2500.00, 'Package 1', 'images/receipt_116.jpg', 1, '2023-12-16', 4),
(111, 117, 1600.00, 'Package 2', 'images/receipt_117.jpg', 2, '2023-12-14', 5),
(112, 118, 2000.00, 'Package 3', 'images/receipt_118.jpg', 1, '2023-12-15', 6),
(113, 119, 2300.00, 'Package 4', 'images/receipt_119.jpg', 2, '2023-12-24', 1),
(114, 120, 2400.00, 'Package 5', 'images/receipt_120.jpg', 1, '2023-12-24', 2),
(115, 121, 2500.00, 'Package 6', 'images/receipt_121.jpg', 2, '2023-12-24', 3),
(116, 122, 1800.00, 'Package 1', 'images/receipt_122.jpg', 1, '2023-12-24', 4),
(117, 123, 2100.00, 'Package 2', 'images/receipt_123.jpg', 2, '2023-12-24', 5),
(118, 124, 2200.00, 'Package 3', 'images/receipt_124.jpg', 1, '2023-12-24', 6),
(119, 125, 2000.00, 'Package 4', 'images/receipt_125.jpg', 2, '2023-12-24', 1),
(120, 126, 2700.00, 'Package 5', 'images/receipt_126.jpg', 1, '2023-12-24', 2),
(121, 127, 1600.00, 'Package 6', 'images/receipt_127.jpg', 2, '2023-12-24', 3),
(122, 128, 1500.00, 'Package 1', 'images/receipt_128.jpg', 1, '2023-12-25', 4),
(123, 129, 2100.00, 'Package 2', 'images/receipt_129.jpg', 2, '2023-12-26', 5),
(124, 130, 2200.00, 'Package 3', 'images/receipt_130.jpg', 1, '2023-12-24', 6),
(125, 131, 2300.00, 'Package 4', 'images/receipt_131.jpg', 2, '2023-12-28', 1),
(126, 132, 2000.00, 'Package 5', 'images/receipt_132.jpg', 1, '2023-12-29', 2),
(127, 133, 2500.00, 'Package 6', 'images/receipt_133.jpg', 2, '2023-12-30', 3),
(128, 134, 1800.00, 'Package 1', 'images/receipt_134.jpg', 1, '2023-12-31', 4),
(129, 135, 1700.00, 'Package 2', 'images/receipt_135.jpg', 2, '2023-12-16', 5),
(130, 136, 1900.00, 'Package 3', 'images/receipt_136.jpg', 1, '2023-12-16', 6),
(131, 137, 2100.00, 'Package 4', 'images/receipt_137.jpg', 2, '2023-12-18', 1),
(132, 138, 2200.00, 'Package 5', 'images/receipt_138.jpg', 1, '2023-12-04', 2),
(133, 139, 2500.00, 'Package 6', 'images/receipt_139.jpg', 2, '2023-12-18', 3),
(134, 140, 1600.00, 'Package 1', 'images/receipt_140.jpg', 1, '2023-12-06', 4),
(135, 141, 2000.00, 'Package 2', 'images/receipt_141.jpg', 2, '2023-12-07', 5),
(136, 142, 2400.00, 'Package 3', 'images/receipt_142.jpg', 1, '2023-12-08', 6),
(137, 143, 2200.00, 'Package 4', 'images/receipt_143.jpg', 2, '2023-12-09', 1),
(138, 144, 2700.00, 'Package 5', 'images/receipt_144.jpg', 1, '2023-12-10', 2),
(139, 145, 1600.00, 'Package 6', 'images/receipt_145.jpg', 2, '2023-12-11', 3),
(140, 146, 1800.00, 'Package 1', 'images/receipt_146.jpg', 1, '2023-12-12', 4),
(141, 147, 2100.00, 'Package 2', 'images/receipt_147.jpg', 2, '2023-12-13', 5),
(142, 148, 2200.00, 'Package 3', 'images/receipt_148.jpg', 1, '2023-12-14', 6),
(143, 149, 2300.00, 'Package 4', 'images/receipt_149.jpg', 2, '2023-12-18', 1),
(144, 150, 2400.00, 'Package 5', 'images/receipt_150.jpg', 1, '2023-12-16', 2),
(145, 151, 2500.00, 'Package 6', 'images/receipt_151.jpg', 2, '2023-12-17', 3),
(146, 152, 1500.00, 'Package 1', 'images/receipt_152.jpg', 1, '2023-12-18', 4),
(147, 153, 2200.00, 'Package 2', 'images/receipt_153.jpg', 2, '2023-12-19', 5),
(148, 154, 1500.00, 'Package 1', 'receipts/148.jpg', 1, '2022-12-01', 1),
(149, 155, 1800.00, 'Package 2', 'receipts/149.jpg', 2, '2022-12-01', 2),
(150, 156, 2000.00, 'Package 3', 'receipts/150.jpg', 1, '2022-12-02', 3),
(151, 157, 2500.00, 'Package 4', 'receipts/151.jpg', 2, '2022-12-02', 4),
(152, 158, 3000.00, 'Package 5', 'receipts/152.jpg', 1, '2022-12-03', 5),
(153, 159, 1200.00, 'Package 6', 'receipts/153.jpg', 2, '2022-12-04', 6),
(154, 160, 1500.00, 'Package 1', 'receipts/154.jpg', 1, '2022-12-18', 1),
(155, 161, 1800.00, 'Package 2', 'receipts/155.jpg', 2, '2022-12-04', 2),
(156, 162, 2000.00, 'Package 3', 'receipts/156.jpg', 1, '2022-12-04', 3),
(157, 163, 2500.00, 'Package 4', 'receipts/157.jpg', 2, '2022-12-04', 4),
(158, 164, 3000.00, 'Package 5', 'receipts/158.jpg', 1, '2022-12-04', 5),
(159, 165, 1200.00, 'Package 6', 'receipts/159.jpg', 2, '2022-12-06', 6),
(160, 166, 1500.00, 'Package 1', 'receipts/160.jpg', 1, '2022-12-07', 1),
(161, 167, 1800.00, 'Package 2', 'receipts/161.jpg', 2, '2022-12-07', 2),
(162, 168, 2000.00, 'Package 3', 'receipts/162.jpg', 1, '2022-12-18', 3),
(163, 169, 2500.00, 'Package 4', 'receipts/163.jpg', 2, '2022-12-18', 4),
(164, 170, 3000.00, 'Package 5', 'receipts/164.jpg', 1, '2022-12-09', 5),
(165, 171, 1200.00, 'Package 6', 'receipts/165.jpg', 2, '2022-12-09', 6),
(166, 172, 1500.00, 'Package 1', 'receipts/166.jpg', 1, '2022-12-10', 1),
(167, 173, 1800.00, 'Package 2', 'receipts/167.jpg', 2, '2022-12-10', 2),
(168, 174, 2000.00, 'Package 3', 'receipts/168.jpg', 1, '2022-12-11', 3),
(169, 175, 2500.00, 'Package 4', 'receipts/169.jpg', 2, '2022-12-11', 4),
(170, 176, 3000.00, 'Package 5', 'receipts/170.jpg', 1, '2022-12-12', 5),
(171, 177, 1200.00, 'Package 6', 'receipts/171.jpg', 2, '2022-12-12', 6),
(172, 178, 1500.00, 'Package 1', 'receipts/172.jpg', 1, '2022-12-13', 1),
(173, 179, 1800.00, 'Package 2', 'receipts/173.jpg', 2, '2022-12-13', 2),
(174, 180, 2000.00, 'Package 3', 'receipts/174.jpg', 1, '2022-12-14', 3),
(175, 181, 2500.00, 'Package 4', 'receipts/175.jpg', 2, '2022-12-14', 4),
(176, 182, 3000.00, 'Package 5', 'receipts/176.jpg', 1, '2022-12-15', 5),
(177, 183, 1200.00, 'Package 6', 'receipts/177.jpg', 2, '2022-12-15', 6),
(178, 184, 1500.00, 'Package 1', 'receipts/178.jpg', 1, '2022-12-16', 1),
(179, 185, 1800.00, 'Package 2', 'receipts/179.jpg', 2, '2022-12-16', 2),
(180, 186, 2000.00, 'Package 3', 'receipts/180.jpg', 1, '2022-12-17', 3),
(181, 187, 2500.00, 'Package 4', 'receipts/181.jpg', 2, '2022-12-17', 4),
(182, 188, 3000.00, 'Package 5', 'receipts/182.jpg', 1, '2022-12-18', 5),
(183, 189, 1200.00, 'Package 6', 'receipts/183.jpg', 2, '2022-12-18', 6),
(184, 190, 1500.00, 'Package 1', 'receipts/184.jpg', 1, '2022-12-20', 1),
(185, 191, 1800.00, 'Package 2', 'receipts/185.jpg', 2, '2022-12-20', 2),
(186, 192, 2000.00, 'Package 3', 'receipts/186.jpg', 1, '2022-12-20', 3),
(187, 193, 2500.00, 'Package 4', 'receipts/187.jpg', 2, '2022-12-20', 4),
(188, 194, 3000.00, 'Package 5', 'receipts/188.jpg', 1, '2022-12-24', 5),
(189, 195, 1200.00, 'Package 6', 'receipts/189.jpg', 2, '2022-12-24', 6),
(190, 196, 1500.00, 'Package 1', 'receipts/190.jpg', 1, '2022-12-24', 1),
(191, 197, 1800.00, 'Package 2', 'receipts/191.jpg', 2, '2022-12-24', 2),
(192, 198, 2000.00, 'Package 3', 'receipts/192.jpg', 1, '2022-12-24', 3),
(193, 199, 1500.00, 'Package 1', 'receipts/193.jpg', 1, '2024-09-01', 1),
(194, 200, 1800.00, 'Package 2', 'receipts/194.jpg', 2, '2024-09-02', 2),
(195, 201, 2000.00, 'Package 3', 'receipts/195.jpg', 1, '2024-09-03', 3),
(196, 202, 2500.00, 'Package 4', 'receipts/196.jpg', 2, '2024-09-04', 4),
(197, 203, 3000.00, 'Package 5', 'receipts/197.jpg', 1, '2024-09-05', 5),
(198, 204, 1200.00, 'Package 6', 'receipts/198.jpg', 2, '2024-09-06', 6),
(199, 205, 1500.00, 'Package 1', 'receipts/199.jpg', 1, '2024-09-07', 1),
(200, 206, 1800.00, 'Package 2', 'receipts/200.jpg', 2, '2024-09-08', 2),
(201, 207, 2000.00, 'Package 3', 'receipts/201.jpg', 1, '2024-09-09', 3),
(202, 208, 2500.00, 'Package 4', 'receipts/202.jpg', 2, '2024-09-10', 4),
(203, 209, 3000.00, 'Package 5', 'receipts/203.jpg', 1, '2024-09-11', 5),
(204, 210, 1200.00, 'Package 6', 'receipts/204.jpg', 2, '2024-09-12', 6),
(205, 211, 1500.00, 'Package 1', 'receipts/205.jpg', 1, '2024-09-13', 1),
(206, 212, 1800.00, 'Package 2', 'receipts/206.jpg', 2, '2024-09-14', 2),
(207, 213, 2000.00, 'Package 3', 'receipts/207.jpg', 1, '2024-09-15', 3),
(208, 214, 2500.00, 'Package 4', 'receipts/208.jpg', 2, '2024-09-16', 4),
(209, 215, 3000.00, 'Package 5', 'receipts/209.jpg', 1, '2024-09-17', 5),
(210, 216, 1200.00, 'Package 6', 'receipts/210.jpg', 2, '2024-09-18', 6),
(211, 217, 1500.00, 'Package 1', 'receipts/211.jpg', 1, '2024-09-19', 1),
(212, 218, 1800.00, 'Package 2', 'receipts/212.jpg', 2, '2024-09-20', 2),
(213, 219, 2000.00, 'Package 3', 'receipts/213.jpg', 1, '2024-09-21', 3),
(214, 220, 2500.00, 'Package 4', 'receipts/214.jpg', 2, '2024-09-22', 4),
(215, 221, 3000.00, 'Package 5', 'receipts/215.jpg', 1, '2024-09-23', 5),
(216, 222, 1200.00, 'Package 6', 'receipts/216.jpg', 2, '2024-09-24', 6),
(217, 223, 1500.00, 'Package 1', 'receipts/217.jpg', 1, '2024-09-25', 1),
(218, 224, 1800.00, 'Package 2', 'receipts/218.jpg', 2, '2024-09-26', 2),
(219, 225, 2000.00, 'Package 3', 'receipts/219.jpg', 1, '2024-09-27', 3),
(220, 226, 2500.00, 'Package 4', 'receipts/220.jpg', 2, '2024-09-28', 4),
(221, 227, 3000.00, 'Package 5', 'receipts/221.jpg', 1, '2024-09-29', 5),
(222, 228, 1200.00, 'Package 6', 'receipts/222.jpg', 2, '2024-09-30', 6),
(223, 229, 1500.00, 'Package 1', 'receipts/223.jpg', 1, '0000-00-00', 1),
(224, 230, 1800.00, 'Package 2', 'receipts/224.jpg', 2, '2024-10-01', 2),
(225, 231, 2000.00, 'Package 3', 'receipts/225.jpg', 1, '2024-10-02', 3),
(226, 232, 2500.00, 'Package 4', 'receipts/226.jpg', 2, '2024-10-03', 4),
(227, 233, 3000.00, 'Package 5', 'receipts/227.jpg', 1, '2024-10-04', 5),
(228, 234, 1200.00, 'Package 6', 'receipts/228.jpg', 2, '2024-10-05', 6),
(229, 235, 1500.00, 'Package 1', 'receipts/229.jpg', 1, '2024-10-06', 1),
(230, 236, 1800.00, 'Package 2', 'receipts/230.jpg', 2, '2024-10-07', 2),
(231, 237, 2000.00, 'Package 3', 'receipts/231.jpg', 1, '2024-10-08', 3),
(232, 238, 2500.00, 'Package 4', 'receipts/232.jpg', 2, '2024-10-09', 4),
(233, 239, 3000.00, 'Package 5', 'receipts/233.jpg', 1, '2024-10-10', 5),
(234, 240, 1200.00, 'Package 6', 'receipts/234.jpg', 2, '2024-10-11', 6),
(235, 241, 1500.00, 'Package 1', 'receipts/235.jpg', 1, '2024-10-12', 1),
(236, 242, 1800.00, 'Package 2', 'receipts/236.jpg', 2, '2024-10-13', 2),
(237, 243, 2000.00, 'Package 3', 'receipts/237.jpg', 1, '2024-10-14', 3),
(238, 244, 2500.00, 'Package 4', 'receipts/238.jpg', 2, '2024-10-15', 4),
(239, 245, 3000.00, 'Package 5', 'receipts/239.jpg', 1, '2024-10-16', 5),
(240, 246, 1200.00, 'Package 6', 'receipts/240.jpg', 2, '2024-10-17', 6),
(241, 247, 1500.00, 'Package 1', 'receipts/241.jpg', 1, '2024-10-18', 1),
(242, 248, 1800.00, 'Package 2', 'receipts/242.jpg', 2, '2024-10-19', 2),
(243, 249, 2000.00, 'Package 3', 'receipts/243.jpg', 1, '2024-10-20', 3),
(244, 250, 300.00, 'Package 1', NULL, 1, '2024-11-08', 1),
(245, 251, 300.00, 'Package 1', NULL, 1, '2024-11-08', 1),
(246, 252, 300.00, 'Package 1', 'admin/receipts/dosreceipt_20241126.jpg', 1, '2024-12-30', 2),
(247, 253, 350.00, 'Package 2', 'admin/receipts/dosreceipt_20241126.jpg', 1, '2024-12-05', 1),
(248, 254, 300.00, 'Package 1', NULL, 1, '2024-11-28', 1),
(249, 255, 400.00, 'Package 3', NULL, 2, '2024-11-28', 1);

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
(11, '4\'x6\'', 500, '2024-11-25', 2);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temporary_packages`
--

INSERT INTO `temporary_packages` (`id`, `image_name_location`, `price`, `package_name`, `description`, `product_used`, `start_date`, `end_date`, `created_at`) VALUES
(1, 'images/package1.png', 250.00, 'Couple Package', '1-2 PAX\n15 mins unlimited studio shoot\n1 background color\nUnlimited props (incl. exclusive props)\n1 strip print\n14R print', '1/2/3', '2024-02-04', '2024-02-16', '2024-11-27 09:57:20');

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
  ADD KEY `queue_id` (`queue_id`);

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
-- AUTO_INCREMENT for table `deduct`
--
ALTER TABLE `deduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `done_transaction`
--
ALTER TABLE `done_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
  MODIFY `queue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`queue_id`) REFERENCES `queue` (`queue_id`);

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
