-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 23, 2023 at 07:10 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `des_cryptography`
--

-- --------------------------------------------------------

--
-- Table structure for table `mailables`
--

CREATE TABLE `mailables` (
  `id` int(11) NOT NULL,
  `sender_name` varchar(150) DEFAULT NULL,
  `sender_email` varchar(150) NOT NULL,
  `receiver_email` varchar(150) DEFAULT NULL,
  `reciever_email` varchar(150) NOT NULL,
  `operational_log_id` int(11) NOT NULL,
  `mailed_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `operational_logs`
--

CREATE TABLE `operational_logs` (
  `id` int(11) NOT NULL,
  `uuid` varchar(250) NOT NULL,
  `user_agent` varchar(250) NOT NULL,
  `des_operation` enum('','encryption','decryption') NOT NULL,
  `des_text` longtext NOT NULL,
  `des_key` text NOT NULL,
  `des_result` longblob NOT NULL,
  `performed_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mailables`
--
ALTER TABLE `mailables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mailable_operational_log_constraint` (`operational_log_id`);

--
-- Indexes for table `operational_logs`
--
ALTER TABLE `operational_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mailables`
--
ALTER TABLE `mailables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `operational_logs`
--
ALTER TABLE `operational_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mailables`
--
ALTER TABLE `mailables`
  ADD CONSTRAINT `mailable_operational_log_constraint` FOREIGN KEY (`operational_log_id`) REFERENCES `operational_logs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
