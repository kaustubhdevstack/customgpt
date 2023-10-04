-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2023 at 01:38 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customgpt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cgpt_history`
--

CREATE TABLE `cgpt_history` (
  `id` bigint(20) NOT NULL,
  `tool` varchar(120) NOT NULL,
  `prompt` longtext NOT NULL,
  `result` longtext NOT NULL,
  `uid` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cgpt_users`
--

CREATE TABLE `cgpt_users` (
  `id` bigint(20) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `user_pic` varchar(130) NOT NULL,
  `fname` varchar(80) NOT NULL,
  `lname` varchar(80) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `passwd` varchar(120) NOT NULL,
  `user_desg` varchar(50) NOT NULL,
  `usr_type` varchar(50) NOT NULL,
  `ac_status` varchar(30) NOT NULL,
  `em_status` varchar(30) NOT NULL,
  `email_confirm` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `date` datetime NOT NULL,
  `on_status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cgpt_history`
--
ALTER TABLE `cgpt_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cgpt_users`
--
ALTER TABLE `cgpt_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cgpt_history`
--
ALTER TABLE `cgpt_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cgpt_users`
--
ALTER TABLE `cgpt_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
