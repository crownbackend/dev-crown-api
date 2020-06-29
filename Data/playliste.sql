-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 29 Juin 2020 à 13:18
-- Version du serveur :  5.7.30-0ubuntu0.18.04.1
-- Version de PHP :  7.3.19-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dev-crown-api`
--

-- --------------------------------------------------------

--
-- Structure de la table `playliste`
--

CREATE TABLE IF NOT EXISTS `playliste` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `playliste`
--

INSERT INTO `playliste` (`id`, `name`, `description`, `slug`) VALUES
(2, 'Symfony', 'Retrouvez ici toutes les vidéos Symfony de la chaîne YouTube !', 'symfony'),
(3, 'Présentation', 'Retrouver ici toutes les vidéos de présentation\r\n\r\nSite web, services, technologie etc...', 'presentation'),
(4, 'Tutoriel', 'Retrouver ici toutes les vidéo tuto de ma chaîne Youtube', 'tutoriel'),
(5, 'Javascripts', 'Retrouvez ici toutes les vidéos javascript, Vanilla js, ajax, typescript etc..', 'javascripts');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `playliste`
--
ALTER TABLE `playliste`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `playliste`
--
ALTER TABLE `playliste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
