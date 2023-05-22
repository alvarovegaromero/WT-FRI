-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 06:39 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healthcare_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id_appointment` int(11) NOT NULL,
  `id_schedule` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id_appointment`, `id_schedule`, `id_patient`) VALUES
(5, 12, 1),
(8, 3, 1);

--
-- Triggers `appointments`
--
DELIMITER $$
CREATE TRIGGER `update_schedule_state` AFTER INSERT ON `appointments` FOR EACH ROW BEGIN
    UPDATE schedules
    SET state = 'Occupied'
    WHERE id_schedule = NEW.id_schedule;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_schedule_state2` AFTER DELETE ON `appointments` FOR EACH ROW BEGIN
    UPDATE schedules
    SET state = 'Available'
    WHERE id_schedule = OLD.id_schedule;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id_doctor` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `last_name` text NOT NULL,
  `id` text NOT NULL,
  `phone` text NOT NULL,
  `birthday` date NOT NULL,
  `speciality` enum('Cardiology','Neurology','Dermatology') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id_doctor`, `email`, `password`, `name`, `last_name`, `id`, `phone`, `birthday`, `speciality`) VALUES
(1, 'doctor@gmail.com', '$2y$10$xN1uPTNJ7qsRbPmjVzRKDeAOovNunT0g/S3ULRKltYizsz98vPlz.', 'Peter', 'Lim', '128127718P', '7127188291', '1984-01-11', 'Cardiology'),
(2, 'healthlaura@outlook.com', '$2y$10$xN1uPTNJ7qsRbPmjVzRKDeAOovNunT0g/S3ULRKltYizsz98vPlz.', 'Laura', 'Jovic', '12818192T', '182813273', '1999-06-30', 'Neurology'),
(3, 'popopo@gmail.com', '$2y$10$xN1uPTNJ7qsRbPmjVzRKDeAOovNunT0g/S3ULRKltYizsz98vPlz.', 'Popo', 'Rodriguez', '123412121T', '472838164', '1960-12-15', 'Cardiology');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id_patient` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `last_name` text NOT NULL,
  `id` text NOT NULL,
  `phone` text NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id_patient`, `email`, `password`, `name`, `last_name`, `id`, `phone`, `birthday`, `gender`) VALUES
(1, 'alvaro@gmail.com', '$2y$10$xN1uPTNJ7qsRbPmjVzRKDeAOovNunT0g/S3ULRKltYizsz98vPlz.', 'Alvaro', 'Vega', '77557871P', '684132336', '2001-08-29', 'Male'),
(2, 'pepe@gmail.com', '$2y$10$xN1uPTNJ7qsRbPmjVzRKDeAOovNunT0g/S3ULRKltYizsz98vPlz.', 'Pepe', 'Lopez', '71557871X', '684132336', '2004-07-29', 'Male'),
(3, 'patricia@outlook.com', '$2y$10$xN1uPTNJ7qsRbPmjVzRKDeAOovNunT0g/S3ULRKltYizsz98vPlz.', 'Patricia', 'Doncic', '19872663T', '661237431', '2013-02-13', 'Female'),
(4, 'djokovic@fri.si', '$2y$10$EEovtltd1/uGEnHKBdZOW.q3Nh1IotZ9IqFnReDiY/BJfPF7Zu/nG', 'David', 'Djokovic', '81282737E', '1928176461', '1987-03-21', 'Male'),
(6, 'vegaromeroalvaro@gmail.com', '$2y$10$07N./XD/kiyUHicQdhjg3.4ExF3.ayp/Br8ZAi8r1uC1fZpIh1vd6', 'Álvaro', 'Vega Romero', '1212121', '+34633307578', '2023-05-03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id_schedule` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `state` enum('Available','Occupied') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id_schedule`, `id_doctor`, `date`, `hour`, `state`) VALUES
(1, 1, '2023-06-01', '17:00:00', 'Available'),
(3, 1, '2023-06-03', '17:20:00', 'Occupied'),
(5, 1, '2023-06-01', '17:40:00', 'Available'),
(7, 1, '2023-06-02', '18:00:00', 'Available'),
(9, 2, '2023-06-01', '17:00:00', 'Available'),
(10, 2, '2023-06-01', '17:40:00', 'Available'),
(12, 3, '2023-06-01', '17:00:00', 'Occupied'),
(13, 3, '2023-06-02', '17:20:00', 'Available'),
(14, 3, '2023-06-01', '19:00:00', 'Available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id_appointment`),
  ADD UNIQUE KEY `use schedule only once` (`id_schedule`),
  ADD KEY `fk_id_patient` (`id_patient`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id_doctor`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id_patient`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id_schedule`),
  ADD UNIQUE KEY `unique date and time for a doctor` (`date`,`hour`,`id_doctor`) USING BTREE,
  ADD KEY `fk_id_doctor` (`id_doctor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id_appointment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id_doctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id_schedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_id_patient` FOREIGN KEY (`id_patient`) REFERENCES `patients` (`id_patient`),
  ADD CONSTRAINT `fk_id_schedule` FOREIGN KEY (`id_schedule`) REFERENCES `schedules` (`id_schedule`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `fk_id_doctor` FOREIGN KEY (`id_doctor`) REFERENCES `doctors` (`id_doctor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
