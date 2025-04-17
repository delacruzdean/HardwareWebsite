-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2025 at 06:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `time_in`, `time_out`) VALUES
(1, 1, '2024-05-01 08:00:00', '2024-05-01 17:00:00'),
(2, 2, '2024-05-01 09:00:00', '2024-05-01 18:00:00'),
(3, 3, '2024-05-01 08:30:00', '2024-05-01 17:30:00'),
(4, 1, '2024-05-02 08:00:00', '2024-05-02 17:00:00'),
(5, 2, '2024-05-02 09:00:00', '2024-05-02 18:00:00'),
(6, 3, '2024-05-02 08:30:00', '2024-05-02 17:30:00'),
(7, 1, '2024-05-03 08:00:00', '2024-05-03 17:00:00'),
(8, 2, '2024-05-03 09:00:00', '2024-05-03 18:00:00'),
(9, 3, '2024-05-03 08:30:00', '2024-05-03 17:30:00'),
(10, 1, '2024-05-04 08:00:00', '2024-05-04 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`) VALUES
(1, 'Ajay', 'ajay@gmail.com', 'qdeeas', 'dsgffhgjhmhjm'),
(2, 'kyle', 'kyl@gmail.com', 'panot ako', 'wahhh');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `date_added` date NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `description`, `quantity`, `price`, `category`, `supplier`, `date_added`, `last_updated`) VALUES
(1, 'Hammer', 'A sturdy hammer with a wooden handle', 66, 120.00, 'Tools', 'Tool Supplier Inc.', '2024-05-01', '2024-06-03 03:09:56'),
(2, 'Screwdriver Set', 'A set of 6 screwdrivers with magnetic tips', 30, 15.49, 'Tools', 'Tool Supplier Inc.', '2024-05-02', '2024-05-27 05:44:35'),
(3, 'Drill Machine', 'Electric drill machine with multiple drill bits', 20, 55.99, 'Power Tools', 'PowerTools Co.', '2024-05-03', '2024-05-16 14:35:27'),
(4, 'Wrench Set', 'A set of 10 wrenches in different sizes', 40, 25.75, 'Tools', 'Tool Supplier Inc.', '2024-05-04', '2024-05-16 14:35:27'),
(5, 'Pliers', 'A pair of heavy-duty pliers', 60, 12.89, 'Tools', 'Tool Supplier Inc.', '2024-05-05', '2024-05-16 14:35:27'),
(6, 'Measuring Tape', '25ft retractable measuring tape', 100, 5.49, 'Measuring Tools', 'MeasurePro LLC', '2024-05-06', '2024-05-16 14:35:27'),
(7, 'Ladder', '6ft aluminum ladder', 117, 75.00, 'Equipment', 'LadderWorks', '2024-05-07', '2024-05-29 11:16:09'),
(8, 'Nail Pack', 'A pack of 200 assorted nails', 194, 3.99, 'Supplies', 'Nail Master', '2024-05-08', '2024-06-03 03:04:39'),
(9, 'Circular Saw', 'Electric circular saw with blade', 37, 99.99, 'Power Tools', 'PowerTools Co.', '2024-05-09', '2024-06-03 03:15:58'),
(10, 'Workbench', 'Adjustable height workbench', 5, 125.50, 'Furniture', 'Workbench Warehouse', '2024-05-10', '2024-05-16 14:35:27'),
(15, 'Razer Mouse', 'maganda solid ginagamit ni tenz', 10, 4000.00, 'Electronics', 'Razer', '2024-05-22', '2024-05-22 18:51:12'),
(16, 'Welding Rod', 'joins stuff together', 16, 30.00, 'Tools', 'Random Guy', '2024-05-22', '2024-05-29 11:16:09'),
(19, 'Good Item', 'sheeeee', 41, 420.00, 'Drugs and Paraphernalia', 'secret', '2024-05-24', '2024-06-02 14:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_updates`
--

CREATE TABLE `inventory_updates` (
  `update_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `update_type` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_updates`
--

INSERT INTO `inventory_updates` (`update_id`, `item_id`, `item_name`, `update_type`, `quantity`, `update_date`) VALUES
(1, 13, 'Shabu', 'remove', 0, '2024-05-22 18:24:03'),
(2, 17, 'Bidet', 'remove', 0, '2024-05-22 18:48:12'),
(3, 18, 'Kyle', 'remove', 0, '2024-05-24 13:44:58'),
(4, 19, 'Good Item', 'add', 20, '2024-05-24 13:53:11'),
(5, 19, 'Good Item', 'update', 50, '2024-05-24 13:55:51'),
(6, 9, 'Circular Saw', 'update', 30, '2024-05-27 01:06:24'),
(7, 9, 'Circular Saw', 'update', 30, '2024-05-27 01:33:06'),
(8, 2, 'Screwdriver Set', 'update', 30, '2024-05-27 05:44:35'),
(9, 9, 'Circular Saw', 'update', 40, '2024-05-27 07:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `customer_id`, `item_id`, `item_name`, `quantity`, `total_price`, `transaction_date`) VALUES
(1, 0, 1, 'Hammer', 2, 19.98, '2024-05-22 12:34:44'),
(2, 0, 8, 'Nail Pack', 3, 11.97, '2024-05-22 13:32:04'),
(3, 0, 17, 'Bidet', 1, 60.00, '2024-05-22 18:35:33'),
(4, 0, 19, 'Good Item', 1, 420.00, '2024-05-24 13:57:47'),
(5, 0, 9, 'Circular Saw', 2, 199.98, '2024-05-24 13:57:47'),
(6, 0, 1, 'Hammer', 2, 240.00, '2024-05-27 01:05:03'),
(7, 0, 2, 'Screwdriver Set', 5, 77.45, '2024-05-27 01:07:09'),
(8, 0, 9, 'Circular Saw', 5, 499.95, '2024-05-27 01:07:54'),
(9, 0, 19, 'Good Item', 1, 420.00, '2024-05-27 02:02:16'),
(10, 0, 16, 'Welding Rod', 1, 30.00, '2024-05-27 02:02:16'),
(11, 0, 8, 'Nail Pack', 1, 3.99, '2024-05-27 02:02:53'),
(12, 0, 9, 'Circular Saw', 1, 99.99, '2024-05-27 02:02:53'),
(13, 0, 19, 'Good Item', 1, 420.00, '2024-05-27 02:38:47'),
(14, 0, 19, 'Good Item', 1, 420.00, '2024-05-29 10:40:49'),
(15, 0, 16, 'Welding Rod', 1, 30.00, '2024-05-29 10:40:49'),
(16, 0, 16, 'Welding Rod', 1, 30.00, '2024-05-29 10:54:53'),
(17, 0, 19, 'Good Item', 1, 420.00, '2024-05-29 10:54:53'),
(18, 0, 19, 'Good Item', 1, 420.00, '2024-05-29 11:09:56'),
(19, 0, 16, 'Welding Rod', 1, 30.00, '2024-05-29 11:16:09'),
(20, 0, 7, 'Ladder', 3, 225.00, '2024-05-29 11:16:09'),
(21, 0, 19, 'Good Item', 1, 420.00, '2024-05-29 11:26:40'),
(22, 0, 19, 'Good Item', 1, 420.00, '2024-05-29 15:55:09'),
(23, 0, 1, 'Hammer', 1, 120.00, '2024-06-01 16:32:33'),
(24, 1, 8, 'Nail Pack', 1, 3.99, '2024-06-02 14:48:43'),
(25, 1, 19, 'Good Item', 1, 420.00, '2024-06-02 14:48:43'),
(26, 1, 9, 'Circular Saw', 1, 99.99, '2024-06-03 03:04:39'),
(27, 1, 8, 'Nail Pack', 1, 3.99, '2024-06-03 03:04:39'),
(28, 13, 1, 'Hammer', 1, 120.00, '2024-06-03 03:09:56'),
(29, 17, 9, 'Circular Saw', 2, 199.98, '2024-06-03 03:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(1) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_type`, `name`) VALUES
(1, 'dean', 'dean@gmail.com', '$2y$10$1QFKcCBD37YCcXGw4XfA3OpDIq4VsR3rL/F1wsKK6mtebdaq9iJxu', 1, 'Dela Cruz, Dean'),
(2, 'hiyoshi', 'admin1@gmail.com', '$2y$10$Yvva7PkBkKqjHg1OFXvuWevl86FalU0Tc1vZmZ7XseK4uUFSVf3RG', 1, 'Dela Cruz, Dean'),
(3, 'jason', 'jason@gmail.com', 'jason\r\n', 0, ''),
(4, 'jason', 'jason1@gmail.com', 'jason', 0, ''),
(5, 'kyle', 'kyle@gmail.com', '$2y$10$WHtr2lbWr5NcnJmTkG7lI.pKneN9G9HYfFcJsvMGmcMQUld85.mMe', 1, 'Villa, kyle'),
(12, 'allen', 'allen@gmail.com', '$2y$10$cI33QZaa81YsQbnIj0ASmOiUdDlKPtYcHWReqQsh.BO4Zqdw1bHEG', 0, 'Pangilinan, Allen'),
(13, 'chok', 'chok@gmail.com', '$2y$10$FXzDGrJjcnWOmNVICIKDCOdXH5xNIovbumhj5v0O1H1Ip232puSSe', 0, 'Parungao, Jacob'),
(14, 'evan', 'evan@gmail.com', '$2y$10$YUFJk48sIY.Lum47JKRccuWfAFVHbtRS3R0kUu2XBHqqE3pt7YT.W', 0, 'De Asis, Evan'),
(15, 'FLiP', 'francine@gmail.com', '$2y$10$YFhQo.P6vDb8xl.BhiCJRuEhOpgvbXFZMBnKJaTCCNU28EwSuv4AC', 0, 'Francine Liane'),
(16, 'Celine', 'celine@gmail.com', '$2y$10$sciGGXP.9TMZ6jpdrWQJ.eaRsJWhQZh50z17V8Jfh/QxAYcYGUhpO', 0, 'Celine Dela Cruz'),
(17, 'alexis', 'alexis@gmail.com', '$2y$10$nXyzdTSj6ljxY8mMZRRfKekxA0vq0c31botlpwOeqk.6W/An53xNy', 0, 'Alexis Santos');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_updates`
--
ALTER TABLE `inventory_updates`
  ADD PRIMARY KEY (`update_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `inventory_updates`
--
ALTER TABLE `inventory_updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
