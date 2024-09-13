-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 07:50 AM
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
-- Database: `fastwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `status` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` longtext NOT NULL,
  `bib` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `description`, `purchase_date`, `status`, `created_at`, `image`, `bib`) VALUES
(1, 'โต็ะทำงาน', 'โต็ะทำงานห้องธุรการตัวที่ 1 ', '2024-09-13', 1, '2024-09-13 03:12:11', 'โต็ะทำงาน.jpg', '87524'),
(2, 'เก้าอี้สำนักงาน', 'เก้าอี้สำนักงานห้องธุรการ', '2024-09-13', 1, '2024-09-13 03:19:21', '66e3af390f605.jpg', '63809'),
(4, 'โปรเจคเตอร์', 'โปรเจคเตอร์ห้องประชุม', '2024-09-13', 1, '2024-09-13 04:31:28', '66e3c0202d01d.jpg', '15342');

-- --------------------------------------------------------

--
-- Table structure for table `repair_history`
--

CREATE TABLE `repair_history` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `repair_date` date NOT NULL,
  `completed_date` date DEFAULT NULL,
  `details` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repair_requests`
--

CREATE TABLE `repair_requests` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `request_date` date DEFAULT curdate(),
  `description` text DEFAULT NULL,
  `status_rr` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repair_schedule`
--

CREATE TABLE `repair_schedule` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `repair_date` date NOT NULL,
  `status_rs` int(5) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `repair_schedule`
--

INSERT INTO `repair_schedule` (`id`, `equipment_id`, `repair_date`, `status_rs`, `updated_at`) VALUES
(1, 2, '2024-09-14', 2, '2024-09-13 05:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `status_equipment`
--

CREATE TABLE `status_equipment` (
  `id_e` int(11) NOT NULL,
  `name_e` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `status_equipment`
--

INSERT INTO `status_equipment` (`id_e`, `name_e`) VALUES
(1, 'ใช้งานอยู่'),
(2, 'ส่งซ่อม'),
(3, 'ปลดระวาง');

-- --------------------------------------------------------

--
-- Table structure for table `status_repair_requests`
--

CREATE TABLE `status_repair_requests` (
  `id_rr` int(11) NOT NULL,
  `name_rr` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `status_repair_requests`
--

INSERT INTO `status_repair_requests` (`id_rr`, `name_rr`) VALUES
(1, 'รออนุมัติ'),
(2, 'อนุมัติ'),
(3, 'ปฏิเสธ');

-- --------------------------------------------------------

--
-- Table structure for table `status_repair_schedule`
--

CREATE TABLE `status_repair_schedule` (
  `id_rs` int(11) NOT NULL,
  `name_rs` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `status_repair_schedule`
--

INSERT INTO `status_repair_schedule` (`id_rs`, `name_rs`) VALUES
(1, 'รอดำเนินการ'),
(2, 'กำลังดำเนินการ'),
(3, 'ดำเนินการเสร็จสิ้น');

-- --------------------------------------------------------

--
-- Table structure for table `urole`
--

CREATE TABLE `urole` (
  `id_urole` int(5) NOT NULL,
  `name_urole` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `urole`
--

INSERT INTO `urole` (`id_urole`, `name_urole`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(5) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `urole` int(5) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `fname`, `lname`, `urole`, `create_at`) VALUES
(2, 'komchan.p', '$2y$10$84eCE3YICD857/MyGWJJHeBtd/O9Cwz7GNkR275vjrM92bvI0jBfq', 'komchan.p@rmutsvmail.com', 'คมชาญ', 'พงศาการ', 1, '2024-09-13 01:31:05'),
(4, 'admin', '$2y$10$Ou.zaVCvnihGzSY32murNuWHkhcIFQ9vJLEWxUtPwOjmBKgWedDzq', 'admin@gmail.com', 'admin', 'admin', 2, '2024-09-13 02:03:13'),
(5, 'natthavut.t', '$2y$10$jkaC04MGAGpPHh6OMFilIu/.4C1FZVRsJ8Rcw8tyS8zn1AiIkiBoC', 'natthavut.t@rmutsvmail.com', 'ณัฐวุฒิ', 'ทองสุภา', 1, '2024-09-13 02:24:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `repair_history`
--
ALTER TABLE `repair_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repair_requests`
--
ALTER TABLE `repair_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `equipment_id` (`equipment_id`),
  ADD KEY `status_rr` (`status_rr`);

--
-- Indexes for table `repair_schedule`
--
ALTER TABLE `repair_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_equipment`
--
ALTER TABLE `status_equipment`
  ADD PRIMARY KEY (`id_e`);

--
-- Indexes for table `status_repair_requests`
--
ALTER TABLE `status_repair_requests`
  ADD PRIMARY KEY (`id_rr`);

--
-- Indexes for table `status_repair_schedule`
--
ALTER TABLE `status_repair_schedule`
  ADD PRIMARY KEY (`id_rs`);

--
-- Indexes for table `urole`
--
ALTER TABLE `urole`
  ADD PRIMARY KEY (`id_urole`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `urole` (`urole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `repair_history`
--
ALTER TABLE `repair_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repair_requests`
--
ALTER TABLE `repair_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repair_schedule`
--
ALTER TABLE `repair_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_equipment`
--
ALTER TABLE `status_equipment`
  MODIFY `id_e` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_repair_requests`
--
ALTER TABLE `status_repair_requests`
  MODIFY `id_rr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_repair_schedule`
--
ALTER TABLE `status_repair_schedule`
  MODIFY `id_rs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status_equipment` (`id_e`);

--
-- Constraints for table `repair_requests`
--
ALTER TABLE `repair_requests`
  ADD CONSTRAINT `repair_requests_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `repair_requests_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`),
  ADD CONSTRAINT `repair_requests_ibfk_3` FOREIGN KEY (`status_rr`) REFERENCES `status_repair_requests` (`id_rr`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`urole`) REFERENCES `urole` (`id_urole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
