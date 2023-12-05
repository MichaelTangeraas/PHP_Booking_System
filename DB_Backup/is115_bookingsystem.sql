-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05. Des, 2023 17:30 PM
-- Tjener-versjon: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `is115_bookingsystem`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `booking_users`
--

CREATE TABLE `booking_users` (
  `userID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('la','student') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dataark for tabell `booking_users`
--

INSERT INTO `booking_users` (`userID`, `fname`, `lname`, `email`, `password`, `role`) VALUES
(1, 'Ola', 'Nordmann', 'la@test.no', '$2y$10$CuYwXzCnrVJg6CbyHuYt/e5d26ThoMeh2XaPRDFZjfXE2QOWy1mFe', 'la'),
(2, 'Kari', 'Skog', 'student@test.no', '$2y$10$WOS11ldkekEE04iELRj/ke21odAAfyXROnE0OWDIihvu965AYxVz.', 'student'),
(3, 'Michael', 'Tangeraas', 'mt@test.no', '$2y$10$.lmjxc72oKkuOOSMWSNSM.C2cpkdFiigce6lO55MEnStgs3RRIDeS', 'student'),
(4, 'Hans Christian', 'Morka', 'hc@test.no', '$2y$10$phZi7vVWGxsC1zUfdGtJYugZmZ.n4EC6M4D1ZlfKvFaz/w2gnZXzO', 'student');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `weekdays`
--

CREATE TABLE `weekdays` (
  `primary_key` int(11) NOT NULL,
  `week` int(2) DEFAULT 50,
  `timeDate` varchar(255) DEFAULT NULL,
  `bookingInfo` varchar(255) DEFAULT 'Ledig time',
  `bookingDescription` varchar(255) DEFAULT 'Ingen beskrivelse',
  `userID` int(11) DEFAULT NULL,
  `la` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dataark for tabell `weekdays`
--

INSERT INTO `weekdays` (`primary_key`, `week`, `timeDate`, `bookingInfo`, `bookingDescription`, `userID`, `la`) VALUES
(1, 50, 'monday8', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(2, 50, 'monday9', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(3, 50, 'monday10', 'Godkjenning #5', 'Kan noen godkjenne modul 5 for meg?', 3, NULL),
(4, 50, 'monday11', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(5, 50, 'monday12', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(6, 50, 'monday13', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(7, 50, 'monday14', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(8, 50, 'monday15', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(9, 50, 'monday16', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(10, 50, 'monday17', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(11, 50, 'tuesday8', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(12, 50, 'tuesday9', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(13, 50, 'tuesday10', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(14, 50, 'tuesday11', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(15, 50, 'tuesday12', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(16, 50, 'tuesday13', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(17, 50, 'tuesday14', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(18, 50, 'tuesday15', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(19, 50, 'tuesday16', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(20, 50, 'tuesday17', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(21, 50, 'wednesday8', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(22, 50, 'wednesday9', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(23, 50, 'wednesday10', 'Gruppe 9', 'Vi trenger hjelp til oppgave 3', 4, NULL),
(24, 50, 'wednesday11', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(25, 50, 'wednesday12', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(26, 50, 'wednesday13', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(27, 50, 'wednesday14', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(28, 50, 'wednesday15', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(29, 50, 'wednesday16', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(30, 50, 'wednesday17', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(31, 50, 'thursday8', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(32, 50, 'thursday9', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(33, 50, 'thursday10', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(34, 50, 'thursday11', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(35, 50, 'thursday12', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(36, 50, 'thursday13', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(37, 50, 'thursday14', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(38, 50, 'thursday15', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(39, 50, 'thursday16', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(40, 50, 'thursday17', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(41, 50, 'friday8', 'Ledig time', 'Ingen beskrivelse', NULL, '1'),
(42, 50, 'friday9', 'Modul 5', 'Jeg forstår ikke modul 5. Spesielt oppgave 1 og 4 er vanskelige å forstå.', 4, '1'),
(43, 50, 'friday10', 'Ledig time', 'Ingen beskrivelse', NULL, '1'),
(44, 50, 'friday11', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(45, 50, 'friday12', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(46, 50, 'friday13', 'Ledig time', 'Ingen beskrivelse', NULL, NULL),
(47, 50, 'friday14', 'XAMPP hjelp!', 'Xampp funker ikke lenger! Kjører på Mac', 2, '1'),
(48, 50, 'friday15', 'Ledig time', 'Ingen beskrivelse', NULL, '1'),
(49, 50, 'friday16', 'Ledig time', 'Ingen beskrivelse', NULL, '1'),
(50, 50, 'friday17', 'Ledig time', 'Ingen beskrivelse', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_users`
--
ALTER TABLE `booking_users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `weekdays`
--
ALTER TABLE `weekdays`
  ADD PRIMARY KEY (`primary_key`),
  ADD KEY `fk_userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_users`
--
ALTER TABLE `booking_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `weekdays`
--
ALTER TABLE `weekdays`
  MODIFY `primary_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `weekdays`
--
ALTER TABLE `weekdays`
  ADD CONSTRAINT `fk_userID` FOREIGN KEY (`userID`) REFERENCES `booking_users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
