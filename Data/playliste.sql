-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 18, 2020 at 07:42 PM
-- Server version: 8.0.21-0ubuntu0.20.04.4
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev-crown-api`
--

-- --------------------------------------------------------

--
-- Table structure for table `playliste`
--

CREATE TABLE IF NOT EXISTS `playliste` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playliste`
--

INSERT INTO `playliste` (`id`, `name`, `description`, `slug`) VALUES
(2, 'Symfony', 'Retrouvez ici toutes les vidéos Symfony de la chaîne YouTube !', 'symfony'),
(4, 'Tutoriel', 'Retrouver ici toutes les vidéo tuto de ma chaîne Youtube', 'tutoriel'),
(6, 'Présentation', 'Retrouvez ici toutes les vidéos présentations de la chaîne', 'presentation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `playliste`
--
ALTER TABLE `playliste`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `playliste`
--
ALTER TABLE `playliste`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
