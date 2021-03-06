-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 18, 2020 at 07:41 PM
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
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int NOT NULL,
  `technology_id` int DEFAULT NULL,
  `playliste_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `published_at` datetime NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_file_video` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_video` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `technology_id`, `playliste_id`, `title`, `description`, `video_url`, `created_at`, `published_at`, `slug`, `image_file`, `name_file_video`, `type_video`) VALUES
(5, 4, 2, 'Symfony - Présentation du framework', '<p>Bonjour &agrave; tous, aujourd&#39;hui je vous pr&eacute;sente le framework symfony, bonne vid&eacute;o &agrave; tous. Soutenir la cha&icirc;ne : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/F3XDARhq4NA\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-18 20:52:21', '2020-02-23 10:00:00', 'symfony-presentation-du-framework', 'symfony5nouveautes-5ef9c4665b533.png', 'symfony_presentation', 1),
(6, 4, 2, 'Symfony 5 - installation du projet', '<p>Bonjour tout le monde dans cette vid&eacute;o nous allons voir les mani&egrave;res d&#39;installer le framework Symfony. symfony installer : https://symfony.com/download composer : https://getcomposer.org/download/ site web https://dev-crown.com/</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/I4-tmozaybc\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-19 18:32:28', '2020-02-24 10:00:00', 'symfony-5-installation-du-projet', 'symfony5install-5ef9c4968e010.png', 'symfony_installation', 1),
(7, 4, 2, 'Symfony 5 - Structure du projet', '<p>Bonjour &agrave; tous dans cette vid&eacute;o nous allons voir ce que contient un projet symfony. Bonne vid&eacute;o ! site web : https://dev-crown.com/ Soutenir la cha&icirc;ne : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/4lUaKpbMp_g\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-19 18:37:15', '2020-02-24 10:00:00', 'symfony-5-structure-du-projet', 'symfony5strucutre-5ef9c4821cf5b.png', 'symfony_structure_projet', 1),
(8, 4, 2, 'Symfony 5 - Controller, response et affichage', '<p>Bonjour &agrave; tous dans cette vid&eacute;o nous allons voir comment afficher une r&eacute;ponse dans notre navigateur. Bonne vid&eacute;o ! site web : https://dev-crown.com/ Soutenir la cha&icirc;ne : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/PkDEKJSFwBE\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-19 19:34:33', '2020-02-25 10:00:00', 'symfony-5-controller-response-et-affichage', 'symfony5conres-5ef9c4c2a2b85.png', 'symfony_controller_response_affichage', 1),
(9, 4, 2, 'Symfony 5 - Route dynamique', '<p>Bonjour dans cette vid&eacute;o nous allons voir comment rendre notre route dynamique. Bonne vid&eacute;o ! Site web : https://dev-crown.com/ Pour soutenir la cha&icirc;ne : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/619u9Li9P5w\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-19 19:38:24', '2020-02-25 10:00:00', 'symfony-5-route-dynamique', 'symfony5routedynamcique-5ef9c4a65e17a.png', 'symfony_route_dynamique', 1),
(10, 4, 2, 'Symfony 5 - Page HTML et variable', '<p>Bonjour &agrave; tous dans cette vid&eacute;o nous allons voir comment afficher une page html, lui affecte du css et du js et envoyer une variable depuis le controller. Bonne vid&eacute;o ! Site web : https://dev-crown.com/ Soutenir la cha&icirc;ne : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/7mlAz7MZtl8\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-19 19:42:36', '2020-02-26 10:00:00', 'symfony-5-page-html-et-variable', 'symfony5htmlvar-5ef9c4f8295cb.png', 'symfony_page_html_variable', 1),
(11, 4, 2, 'Symfony 5 -  Boucle et condition', '<p>Bonjour &agrave; tous dans cette vid&eacute;o on continue notre exploration de twig Bonne vid&eacute;o SIte web : https://dev-crown.com/ Soutenir la cha&icirc;ne : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/tjitvDhsKDo\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-19 19:44:53', '2020-02-26 10:00:00', 'symfony-5-boucle-et-condition', 'symfony5boucle-5ef9c4ed7ad26.png', 'symfony_boucle_condition', 1),
(12, 4, 2, 'Symfony 5 - Base de donnée première parti', '<p>Bonjour &agrave; tous aujourd&#39;hui on va attaquer la partie base de donn&eacute;e ce ci est la premi&egrave;re parti. Site web : https://dev-crown.com/ Soutenir la chaine : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/bCS77rG4DZ4\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-19 19:51:37', '2020-03-05 10:00:00', 'symfony-5-base-de-donnee-premiere-parti', 'symfony5bdd1-5ef9c508cfa0f.png', 'symfony_bdd_first_part', 1),
(13, 4, 2, 'Symfony 5 - Formulaire et base de donnée', '<p>Bonjour &agrave; tous dans cette vid&eacute;o nous allons voir comment utiliser les formulaires avec doctrine !</p>\r\n\r\n<p>Site web : <a href=\"https://dev-crown.com/\" target=\"_blank\">https://dev-crown.com/ </a></p>\r\n\r\n<p>Soutenir la cha&icirc;ne : <a href=\"https://utip.io/devcrown\" target=\"_blank\">https://utip.io/devcrown</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/PZJhSqPe5UE\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-20 19:06:31', '2020-03-13 10:00:00', 'symfony-5-formulaire-et-base-de-donnee', 'sf5bddform-5f7e0a8a8b55c.jpeg', 'symfony_formulaire_bdd.mp4', 2),
(16, NULL, 6, 'Présentation de la chaîne (Tutoriel sur le développement web)', '<p>Bonjour tout le monde et bienvenue sur ma cha&icirc;ne, aujourd&#39;hui je vous pr&eacute;sente un peu le bute de ma cha&icirc;ne youtube , bon visionnage et &agrave; bient&ocirc;t site web : https://dev-crown.com/ (ouvrira tr&egrave;s proochainement) Soutenir la cha&icirc;ne : https://utip.io/devcrown</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/SET7C-eG0ps\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-20 19:20:32', '2020-02-22 10:00:00', 'presentation-de-la-chaine-tutoriel-sur-le-developpement-web', 'skullwithcrown29686141-5ef9c42c10702.png', 'presentation_chaine_youtube.ogv', 1),
(17, 6, 4, 'Installer wordpress en local', '<p>Bonjour tout le monde aujourd&#39;hui je vais vous montr&eacute; comment installer wordpress sur wamp en localhost wordpress: https://fr.wordpress.org/telechargement/ lien wamp: http://www.wampserver.com/ mamp: https://www.mamp.info/en/ xampp: https://www.apachefriends.org/fr/index.html n&#39;h&eacute;sitez pas a me demander de l&#39;aide en commentaire je vous r&eacute;pond tr&egrave;s rapidement ! https://dev-crown.com/</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/bcAPFVBXG4g\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-20 19:33:22', '2018-02-21 10:00:00', 'installer-wordpress-en-local', 'wordpress-5ef9c3ef51558.gif', 'installer_wordpress_local.mp4', 2),
(18, NULL, 6, 'Présentation Eprojet.fr', '<p>Salut tout le monde c&#39;est crownbackend aujourd&#39;hui je vais vous pr&eacute;senter un petit site sympa qui vous permet de d&eacute;buter la programmation web et d&#39;apprendre les fondamentaux https://www.eprojet.fr/cours/index.php site web https://dev-crown.com/</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/x8IoKcXnmGs\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-20 19:36:11', '2018-02-15 10:00:00', 'presentation-eprojet-fr', 'eprojet-5ef9c3d32f939.png', 'presentation_eprojet_fr.mp4', 2),
(19, NULL, 6, 'Hébergement Web one.com', '<p>Bonjour a tous aujourd&#39;hui je vais vous pr&eacute;senter One.com un site h&eacute;bergement qui vous permet de mettre en ligne votre site avec un nom de domaine One.com : https://www.one.com/fr/ Site web : https://dev-crown.com/</p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Qtjk0hhHLf0\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-20 19:39:13', '2018-02-03 10:00:00', 'hebergement-web-one-com', 'onecom-5ef9c3c81e05b.jpeg', 'hebergement_web_onecom.mp4', 2),
(20, NULL, 6, 'Présentations du site Openclassrooms.com', '<p>Bonjour dans cette vid&eacute;o je vous explique en quoi consiste le site <a href=\"https://openclassrooms.com/\">https://openclassrooms.com/ </a></p>\r\n\r\n<p>Bonne vid&eacute;o lacher un pouce bleu et abonnez vous &ccedil;a fait plairais.</p>\r\n\r\n<p>Mon site web(Toujours en constructions ) : <a href=\"https://dev-crown.com/\">https://dev-crown.com/</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/U02SdaUd2Yc\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-03-20 19:43:45', '2018-01-07 10:00:00', 'presentations-du-site-openclassrooms-com', 'opencla-5ef9c3b5de2df.png', 'presentations_site_openclassroomscom.mp4', 2),
(22, 4, 2, 'Symfony 5 - Afficher un article (détail de l\'article)', '<p>Bonjour tout le monde aujourd&#39;hui dans cette vid&eacute;o, nous allons voir comment afficher un seul article et afficher tout les d&eacute;tails de l&#39;article en question bonne vid&eacute;o !</p>\r\n\r\n<p>Github du projet : <a href=\"https://github.com/crownbackend/dev-crown-symfony\">https://github.com/crownbackend/dev-crown-symfony</a><a href=\"https://github.com/crownbackend/dev-crown-symfony\" target=\"_blank\"> </a></p>\r\n\r\n<p>Soutenir la chaine : <a href=\"https://utip.io/devcrown\" target=\"_blank\">https://utip.io/devcrown</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/QPAVumwR9s8\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-04-15 20:41:32', '2020-04-14 10:00:00', 'symfony-5-afficher-un-article-detail-de-l-article', 'symfony5showarticle-5ef9c54d8f257.png', 'symfony_afficher_article.mp4', 2),
(23, 4, 2, 'Symfony 5 - Mettre à jour notre application', '<p>Bonjour tout le monde aujourd&#39;hui dans cette vid&eacute;o nous allons voir comment faire pour mettre &agrave; jour notre application symfony !</p>\r\n\r\n<p>Oublier pas de corriger les d&eacute;pr&eacute;ciations et bug avant de mettre &agrave; jours !</p>\r\n\r\n<p>Github du projet : <a href=\"https://github.com/crownbackend/dev-crown-symfony\" target=\"_blank\">https://github.com/crownbackend/dev-crown-symfony</a></p>\r\n\r\n<p>Soutenir la chaine : <a href=\"https://utip.io/devcrown\" target=\"_blank\">https://utip.io/devcrown</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/DXIEb-qUxvs\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-04-15 20:59:10', '2020-04-16 10:00:00', 'symfony-5-mettre-a-jour-notre-application', 'symfony5updated-5ef9c5611c2c7.png', 'symfony_mettre_a_jours_application.mp4', 2),
(24, NULL, NULL, 'Github - Repository dev-crown', '<p>Bonjour tout le monde petit vid&eacute;o pour vous informez, chaque projet de vid&eacute;o aura son propre github donc je vous met le lien de mon github et sur chaque vid&eacute;o il y aura le gtihub du projet en question bonne vid&eacute;o !</p>\r\n\r\n<p>Github : <a href=\"https://github.com/crownbackend\" target=\"_blank\">https://github.com/crownbackend</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/N21_9fcBbKw\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-04-15 21:03:30', '2020-04-16 10:00:00', 'github-repository-dev-crown', 'basedeconnaissancesgithub1-5ef9c558950ca.png', 'github_repository.mp4', 2),
(29, 4, 2, 'Symfony 5 - MYSQL WORKBENCH Schématiser notre base de donnée', '<p>Bonjour, apr&egrave;s une petite absence de ma part ! on reprend les vid&eacute;os ! dans cette vid&eacute;o on va voir comment sch&eacute;matiser notre base de donn&eacute;e gr&acirc;ce au logiciel MySQL Workbench. Bonne vid&eacute;o !</p>\r\n\r\n<p>MySQL Workbench : <a href=\"https://dev.mysql.com/downloads/workbench/\" target=\"_blank\">https://dev.mysql.com/downloads/workbench/ </a></p>\r\n\r\n<p>Github du projet : <a href=\"https://github.com/crownbackend/dev-crown-symfony\" target=\"_blank\">https://github.com/crownbackend/dev-crown-symfony</a></p>\r\n\r\n<p>Soutenir la chaine : <a href=\"https://utip.io/devcrown\" target=\"_blank\">https://utip.io/devcrown</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/u3Isux3aecA\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-10-17 13:02:22', '2020-09-29 10:00:00', 'symfony-5-mysql-workbench-schematiser-notre-base-de-donnee', 'sql1024x576-5f8acf3ecdac1.jpeg', 'symfony_mysql_workbench.mp4', 2),
(30, 4, 2, 'Symfony 5 - Création de nos entités', '<p>Bonjour, dans cette vid&eacute;o nous allons cr&eacute;er les entit&eacute;s de notre blog. Bonne vid&eacute;o !</p>\r\n\r\n<p>Github du projet : <a href=\"https://github.com/crownbackend/dev-crown-symfony\" target=\"_blank\">https://github.com/crownbackend/dev-crown-symfony</a></p>\r\n\r\n<p>Soutenir la chaine : <a href=\"https://utip.io/devcrown\" target=\"_blank\">https://utip.io/devcrown</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/qIhbFloxQ1A\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-10-17 13:07:34', '2020-09-30 10:00:00', 'symfony-5-creation-de-nos-entites', 'sfentitycreate-5f8ad07682a0f.jpeg', 'symfony_create_entity.mp4', 2),
(31, 4, 2, 'Symfony 5 - Intégration de Template html css js', '<p>Bonjour &agrave; tous, dans cette vid&eacute;o nous allons voir comment int&eacute;grer un Template sur Symfony pour notre blog !</p>\r\n\r\n<p>Github du projet : <a href=\"https://github.com/crownbackend/dev-crown-symfony\" target=\"_blank\">https://github.com/crownbackend/dev-crown-symfony</a></p>\r\n\r\n<p>Soutenir la chaine : <a href=\"https://utip.io/devcrown\" target=\"_blank\">https://utip.io/devcrown</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/v-oDlosfdPA\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-10-18 17:40:12', '2020-10-02 10:00:00', 'symfony-5-integration-de-template-html-css-js', 'symfony5integratetmp-5f8c61dd45475.jpeg', 'symfony_integrate_template.mp4', 2),
(32, 4, 2, 'Symfony 5 - Formulaire de connexion', '<p>Bonjour &agrave; tous et aujourd&#39;hui dans cette vid&eacute;o on voir comment impl&eacute;menter un formulaire de connexion pour permettre au utilisateurs de ce connect&eacute; et pouvoir ajouter un commentaires !</p>\r\n\r\n<p>Github du projet : <a href=\"https://github.com/crownbackend/dev-crown-symfony\" target=\"_blank\">https://github.com/crownbackend/dev-crown-symfony</a></p>\r\n\r\n<p>Soutenir la chaine : <a href=\"https://utip.io/devcrown\" target=\"_blank\">https://utip.io/devcrown</a></p>', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Pg3gUlM3Bo0\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2020-10-18 17:47:44', '2020-10-15 10:00:00', 'symfony-5-formulaire-de-connexion', 'symfony5formlogin-5f8c63a07eddf.jpeg', 'login_form_symfony.mp4', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CC7DA2C4235D463` (`technology_id`),
  ADD KEY `IDX_7CC7DA2CEA02C715` (`playliste_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2C4235D463` FOREIGN KEY (`technology_id`) REFERENCES `technology` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_7CC7DA2CEA02C715` FOREIGN KEY (`playliste_id`) REFERENCES `playliste` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
