-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 10:19 AM
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
-- Database: `academia`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `grade` int(1) NOT NULL,
  `section` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `grade`, `section`) VALUES
(1, 1, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `grade` int(1) NOT NULL,
  `section` varchar(3) NOT NULL,
  `type` enum('Image','YouTube','PDF','Audio') NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification` text NOT NULL,
  `grade` varchar(3) NOT NULL,
  `section` varchar(3) NOT NULL,
  `creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `due` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification`, `grade`, `section`, `creation`, `due`) VALUES
(1, 'أهلا وسهلا يا شباب\r\nكسمكم جميعا', '1', 'a', '2024-07-31 18:52:18', 1723538294),
(2, 'Hello everyone, kosom elga miee', 'all', 'all', '2024-07-31 18:53:16', 1722538294),
(3, 'HEHEEHEH', '1', 'all', '2024-07-31 18:53:37', 1722538294),
(4, 'late', '1', 'a', '2024-07-31 18:54:02', 1722451894),
(10, 'test', '1', 'a', '2024-08-02 08:36:28', 1722674188),
(11, 'test', '1', 'a', '2024-08-02 08:38:24', 1722674304),
(12, 'test', '1', 'a', '2024-08-02 08:38:29', 1723674309),
(13, 'يا شباب حياكم الله', '1', 'a', '2024-08-02 08:38:41', 1722674321),
(14, 'هلا يا شباب \r\nحياكم الله يا خولات', '1', 'a', '2024-08-02 08:50:00', 1722675000),
(15, 'Hello,\r\nKosom elsisi', '1', 'a', '2024-08-02 08:50:43', 1723675043);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `grade` int(1) NOT NULL,
  `section` varchar(1) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start` varchar(5) NOT NULL,
  `end` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `grade`, `section`, `day`, `start`, `end`) VALUES
(3, 1, 'a', 'Sunday', '4:00', '6:00'),
(4, 1, 'a', 'Monday', '7:00', '7:30');

-- --------------------------------------------------------

--
-- Table structure for table `stdata`
--

CREATE TABLE `stdata` (
  `id` int(11) NOT NULL,
  `user_id` varchar(40) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `grade` int(1) NOT NULL,
  `section` varchar(1) NOT NULL,
  `status` varchar(10) NOT NULL,
  `marks` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stdata`
--

INSERT INTO `stdata` (`id`, `user_id`, `student_name`, `username`, `password`, `grade`, `section`, `status`, `marks`) VALUES
(11, 'asdgfsfdgdfg', 'Seif Eldeen Sameh', 'seif_sameh', '$2y$10$561s.qdBHuD0nf3O0cyLbe70yljuEo.gHsf0wt9sMG1H7Y/I4ygkO', 1, 'a', 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stdssn`
--

CREATE TABLE `stdssn` (
  `id` int(11) NOT NULL,
  `user_id` varchar(40) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stdssn`
--

INSERT INTO `stdssn` (`id`, `user_id`, `session_id`) VALUES
(2, 'asdgfsfdgdfg', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade` (`grade`),
  ADD KEY `section` (`section`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `grade` (`grade`),
  ADD KEY `section` (`section`),
  ADD KEY `creation` (`creation`),
  ADD KEY `due` (`due`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `grade` (`grade`),
  ADD KEY `section` (`section`),
  ADD KEY `day` (`day`),
  ADD KEY `start` (`start`),
  ADD KEY `end` (`end`);

--
-- Indexes for table `stdata`
--
ALTER TABLE `stdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `name` (`student_name`),
  ADD KEY `password` (`password`),
  ADD KEY `grade` (`grade`),
  ADD KEY `section` (`section`),
  ADD KEY `status` (`status`),
  ADD KEY `marks` (`marks`);

--
-- Indexes for table `stdssn`
--
ALTER TABLE `stdssn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stdata`
--
ALTER TABLE `stdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stdssn`
--
ALTER TABLE `stdssn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
