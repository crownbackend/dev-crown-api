-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 29 Juin 2020 à 13:19
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
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_token_created_at` datetime DEFAULT NULL,
  `token_password_created_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `email`, `confirmation_token`, `token_password`, `confirmation_token_created_at`, `token_password_created_at`, `created_at`, `enabled`, `last_login`, `avatar`) VALUES
(1, 'crownbackend', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$zDb+Wd7EBBdMRtUlAkrsAw$KceDZ9W86NYMwEut3dNB2uoPg8N+Y4SPGGcJH/66o5w', 'crownbackend@gmail.com', NULL, NULL, NULL, NULL, '2020-03-16 19:40:45', 1, NULL, 'js-5ef9cc607fa8b.png'),
(2, 'Nabile', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$MVJryAiG55OEZAgUcZXeJQ$3ZzBGcXBZhseL1L/ON/wyrw3bq9hrsNUrsKZwQC37IM', 'nabile333@live.fr', NULL, NULL, NULL, NULL, '2020-03-26 00:16:03', 1, NULL, '3240x2400-5eeec74115015.jpeg');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
