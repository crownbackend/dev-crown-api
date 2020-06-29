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
-- Structure de la table `technology`
--

CREATE TABLE IF NOT EXISTS `technology` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `technology`
--

INSERT INTO `technology` (`id`, `name`, `description`, `image_file`, `slug`) VALUES
(4, 'Symfony', 'Symfony est un ensemble de composants PHP ainsi qu\'un framework MVC libre écrit en PHP. Il fournit des fonctionnalités modulables et adaptables qui permettent de faciliter et d’accélérer le développement d\'un site web.', '1_oy6kbvywqicn6wavhuh4hw-5ef9c5eb20e6d.png', 'symfony'),
(5, 'Javascript', 'JavaScript est un langage de programmation de scripts principalement employé dans les pages web interactives mais aussi pour les serveurs avec l\'utilisation de Node.js.', 'js-5ef9c593545d9.png', 'javascript'),
(6, 'Wordpress', 'WordPress est un système de gestion de contenu (SGC ou content management system (CMS) en anglais) gratuit, libre et open-source. Ce logiciel écrit en PHP repose sur une base de données MySQL et est distribué par l\'entreprise américaine Automattic.', 'wordpress-5ef9c5b4d4ee6.gif', 'wordpress'),
(8, 'Jquery', 'jQuery est une bibliothèque JavaScript libre et multiplateforme créée pour faciliter l\'écriture de scripts côté client dans le code HTML des pages web. La première version est lancée en janvier 2006 par John Resig.', 'jquerylogo-5ef9c59985f25.png', 'jquery');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `technology`
--
ALTER TABLE `technology`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `technology`
--
ALTER TABLE `technology`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
