-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 06:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pet`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_requests`
--

CREATE TABLE `adoption_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_requests`
--

INSERT INTO `adoption_requests` (`id`, `user_id`, `animal_id`, `firstname`, `lastname`, `email`, `contact_no`, `location`, `request_date`, `approval_status`) VALUES
(1, 0, 6, 'kazi zakiul', 'Chowdhury', 'dkakach@gmail.com', '01561', 'Jessore', '2024-12-07 15:13:08', 'approved'),
(2, 0, 8, 'asdsa', 'asdas', 'asdi@gmail.com', '5615', 'Jessore', '2024-12-07 15:18:12', 'pending'),
(3, 0, 6, 'asdasd', 'asdsa', 'dkakach@gmail.com', '0151656', 'Gazipur', '2024-12-07 15:18:57', 'pending'),
(4, 0, 13, 'nahid', 'Chowdhury', 'nahidhasantusher784@gmail.com', '0151656', 'Gazipur', '2024-12-07 15:19:46', 'pending'),
(5, 0, 8, 'kazi zakiul', 'abir', 'macalexis999@gmail.com', '01565', 'mirpur', '2024-12-07 15:42:10', 'approved'),
(6, 0, 9, 'adad', 'add', 'dkakach@gmail.com', '0151656', 'ad', '2024-12-13 10:46:02', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `animal_type` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `animal_type`, `location`, `contact_no`, `image`) VALUES
(6, 'Fein', 'dog', 'Gazipur', '01486546', 'https://images.pexels.com/photos/24233366/pexels-photo-24233366/free-photo-of-portrait-of-pitbull.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(7, 'Shipu', 'cat', 'keraniganj', '017654656', 'https://images.pexels.com/photos/104827/cat-pet-animal-domestic-104827.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(8, 'Luna', 'cat', 'Tangail', '012315646', 'https://images.pexels.com/photos/57416/cat-sweet-kitty-animals-57416.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(9, 'Max', 'cat', 'Jessore', '0154894655', 'https://images.pexels.com/photos/18325970/pexels-photo-18325970/free-photo-of-donskoy-cat-in-a-collar.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(10, 'Flocky', 'cat', 'Chattagram', '01164654', 'https://images.pexels.com/photos/1543793/pexels-photo-1543793.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(11, 'Real', 'dog', 'Joydebpur', '012148465', 'https://images.pexels.com/photos/220938/pexels-photo-220938.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(12, 'Speed', 'Dog', 'Comilla', '013654465', 'https://images.pexels.com/photos/551628/pexels-photo-551628.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(13, 'Madrid', 'dog', 'rangamati', '0124846565', 'https://images.pexels.com/photos/11006272/pexels-photo-11006272.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(16, 'tommy', 'dog', 'mirpur', '01164654', 'uploads/dog-8198719_1280.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(6) UNSIGNED NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `firstname`, `lastname`, `email`, `message`, `reg_date`) VALUES
(1, 'asdas', 'asdas', 'nahidhtusher784@gmail.com', 'asdasdas', '2024-11-28 21:52:31'),
(2, 'asdsa', 'asdsa', 'asdsad@gmail.com', 'asdas', '2024-11-28 22:20:55'),
(3, 'adas', 'adasd', 'asd@gmail.com', 'asdasasdgsfa', '2024-11-28 22:28:17'),
(4, 'adas', 'abir', 'adi@gmail.comadas', 'asdsad', '2024-11-28 22:29:27'),
(9, 'aa', 'aa', 'nahidhasantusher784@gmail.com', 'asds', '2024-11-29 16:48:54'),
(12, 'rahul', 'adsad', 'asd@gmail.com', 'asdasddsad', '2024-12-07 15:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `password`, `role`, `created_at`) VALUES
(7, 'admin', 'adi@gmail.com', '$2y$10$Eg7dvDcu2SjFXxFLHq0NzOhCm03VmzlgCoWujwEl64yjC7CObymJe', 'admin', '2024-12-06 09:59:56'),
(8, 'user', 'us@gmail.com', '$2y$10$pmD0jv0SDRevbPJBBr64I.sS5Xe5ZqDrQiUtdsFlBpL60Bdfd8VXC', 'user', '2024-12-06 10:00:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
