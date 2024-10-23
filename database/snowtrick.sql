-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 23 oct. 2024 à 00:50
-- Version du serveur : 11.2.2-MariaDB
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtrick`
--

-- --------------------------------------------------------

--
-- Structure de la table `chat_room_comment`
--

DROP TABLE IF EXISTS `chat_room_comment`;
CREATE TABLE IF NOT EXISTS `chat_room_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_86BD870DA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chat_room_comment`
--

INSERT INTO `chat_room_comment` (`id`, `user_id`, `content`, `created_at`) VALUES
(113, 114, 'Eos natus ut quae rem. Quidem ipsum aut et est qui. Aut tempore et doloremque culpa necessitatibus. Consectetur blanditiis ut eveniet maiores in quaerat quaerat. Eaque quasi ipsam at cumque voluptate ipsam voluptatibus animi. Fuga sed aut sed assumenda. Et esse cupiditate eum. Ducimus est commodi libero explicabo eligendi consequatur a aut.', '1983-03-10 15:28:24'),
(114, 115, 'Officia omnis adipisci dolor voluptas deserunt. Ipsa ut et similique reiciendis est accusantium blanditiis. Eos ea repudiandae aperiam maiores sit voluptatem recusandae. Ipsum ut minima aliquid sit sit. Recusandae corrupti non ipsam saepe quaerat non. Rem neque repellendus quas et et ullam voluptates voluptatem. Qui quas dolorem laudantium.', '2000-06-19 06:53:48'),
(115, 116, 'Praesentium et veniam quia totam officiis repellendus. Qui ratione vitae omnis commodi. Nemo voluptatem et laborum. Ducimus sed illum qui quia tenetur. Inventore omnis pariatur commodi commodi autem nesciunt quod. Porro fugiat itaque autem ea illum. Suscipit aut doloremque quidem nisi. Possimus molestias rerum vitae. Voluptas dolor repellat doloribus sit hic et.', '1983-12-20 21:53:57'),
(116, 117, 'Molestiae omnis libero fuga qui reiciendis voluptatem. Eos ut aut aut possimus aut fugiat. Dolores iste excepturi cum sed. Qui labore debitis labore rerum recusandae. Nobis esse ipsam maiores facere fuga omnis numquam. Cum sequi odit ullam. Ea quia quis non et et magni ex.', '1990-08-30 04:28:30'),
(117, 118, 'Aperiam non saepe aut. Assumenda temporibus eaque et officia. Consectetur aut ad doloremque necessitatibus in consequatur ratione. Similique sint rem sed magnam assumenda. Recusandae animi quia esse debitis. Dignissimos vel et numquam. Tempore labore dolores ratione quo natus quidem.', '2008-06-03 18:19:25'),
(118, 119, 'Vel voluptatum quo soluta est vitae qui ullam. Perspiciatis voluptas aut et facere. Corporis labore qui molestiae qui aut sint. Ut animi laboriosam fugit aut debitis id ut ut. Magni eos sint voluptate minus nam. Omnis quas omnis sit voluptatibus vero quis. Quia est ratione in. Dolor quod id sed nihil iste dolore consequuntur.', '1986-07-01 13:33:49'),
(119, 120, 'Cum molestiae quo minima est. Nihil praesentium omnis in dolorum amet. Quia consequatur aut asperiores rerum sunt. Sed est aut rerum cupiditate labore numquam animi. Consequatur quaerat sed ad vitae natus adipisci. In ut error suscipit quia officia nisi. Vel quia ea non corrupti aspernatur.', '1998-10-09 16:23:46'),
(120, 121, 'Sint odio autem incidunt voluptas veritatis repellat. Non necessitatibus rem ut ut laboriosam possimus eos. Fugiat enim quia est sed aut iure hic libero. Id quos consequatur et exercitationem aut. Alias dolor ab sint officia repellat accusamus. Ducimus tempora voluptates aliquam dignissimos molestiae velit corporis. Voluptates est blanditiis optio dolor ea sint quia veniam.', '1986-04-26 20:21:22');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D8F0A91E5E237E06` (`name`),
  KEY `IDX_D8F0A91E9B875DF8` (`trick_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `trick_group_id`, `name`, `description`, `created_at`, `updated_at`, `slug`) VALUES
(141, 85, 'Stalefish', 'Explicabo perspiciatis quisquam soluta sunt atque. Ut fugit id et temporibus quia itaque. Exercitationem nihil aperiam illo mollitia assumenda.', '2021-02-22 12:24:30', '2021-03-22 12:24:30', 'stalefish'),
(142, 85, 'Truck driver', 'Est nisi qui consequatur. Et labore ut aut et magnam qui vitae tempora. Dolor sed et pariatur. Dicta ipsum omnis ipsum dolores quod.', '2016-03-02 01:41:29', NULL, 'truck-driver'),
(143, 86, '360', 'Eum laboriosam enim doloribus labore ullam fuga at. Vitae iusto assumenda impedit atque et et aut optio.', '2011-11-08 15:09:11', NULL, '360'),
(144, 86, '720', 'Deleniti porro molestias praesentium. Voluptatem expedita nemo enim culpa voluptates totam rerum quod.', '2001-05-02 10:12:35', NULL, '720'),
(145, 87, 'Front flips', 'Minima et quidem modi amet. Nam voluptatem ullam ex excepturi aliquam. Ut quas quo explicabo. Commodi voluptas corporis qui dolores aut sunt aut.', '1993-06-22 10:46:25', NULL, 'front-flips'),
(146, 87, 'Back flips', 'Et eveniet ad vel architecto aut nemo. Dicta tenetur adipisci vel eaque assumenda. Aut hic autem nesciunt inventore.', '2009-08-22 22:20:29', NULL, 'back-flips'),
(147, 88, 'Tail slide', 'Nostrum est nemo corporis velit. Non aut similique optio perferendis in ut. Illum quia voluptas facilis tenetur inventore aliquam adipisci praesentium. Minus iste libero eligendi laudantium quis et.', '2022-01-19 16:27:19', NULL, 'tail-slide'),
(148, 90, 'Japan air', 'Consequatur fugit consequatur aut ad rerum. Quam dolor tenetur consectetur omnis assumenda quae velit sunt. Ea nostrum sequi quis sit. Ut ad quod sapiente exercitationem ut ducimus.', '1986-11-24 19:02:56', NULL, 'japan-air'),
(149, 90, 'Rocket air', 'Vero non eos assumenda rerum vel eius. Eligendi dolorem laboriosam quis aut qui occaecati. Sed est illo dolore voluptatibus id sit culpa. Nostrum nobis similique beatae et.', '1978-12-31 04:42:10', NULL, 'rocket-air'),
(150, 90, 'Backside Air', 'Dolor ea sapiente quas nostrum quia. Aspernatur dignissimos doloremque saepe. Similique corrupti eos rerum dignissimos quis porro. Sint consequatur eos quas asperiores.', '1974-06-05 08:43:45', NULL, 'backside-air');

-- --------------------------------------------------------

--
-- Structure de la table `trick_comment`
--

DROP TABLE IF EXISTS `trick_comment`;
CREATE TABLE IF NOT EXISTS `trick_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_F7292B34B281BE2E` (`trick_id`),
  KEY `IDX_F7292B34A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_comment`
--

INSERT INTO `trick_comment` (`id`, `trick_id`, `user_id`, `content`, `created_at`) VALUES
(211, 142, 115, 'Vero architecto eum ex et vero.', '1984-09-07 18:02:20'),
(212, 149, 120, 'Culpa est inventore asperiores.', '1978-06-24 14:18:12'),
(213, 146, 114, 'Aut eius consectetur quae necessitatibus totam et. Dolor eum excepturi nam dicta mollitia. Perferendis et impedit earum culpa pariatur vitae. Omnis qui molestiae et veritatis rem odio.', '1981-08-20 10:52:41'),
(214, 146, 118, 'Consequatur natus soluta dolor est tempore. Quos tenetur neque ut nemo quibusdam a. Corporis laborum sint optio expedita hic. Culpa laborum vel sed tenetur a est nihil.', '2006-12-16 16:12:06'),
(215, 142, 117, 'Accusantium maiores maxime accusantium doloribus officiis illo est aliquam. Rem totam harum dolorem nesciunt. Accusantium totam aperiam voluptatum a nesciunt.', '1989-06-30 02:15:58'),
(216, 146, 116, 'Minus aperiam autem qui quis et.', '2014-05-14 22:30:58'),
(217, 141, 114, 'Voluptas quis autem unde officiis nemo est. Illo qui ea rerum odio laborum quos odio.', '1991-01-03 20:32:31'),
(218, 142, 116, 'In placeat ut ut aliquam quibusdam maxime. Temporibus excepturi consequuntur aut excepturi aut fugit. Harum autem expedita delectus. Et eaque sit eos voluptatum et velit omnis. Voluptatum doloribus voluptatum et fugiat.', '2017-11-06 14:59:00'),
(219, 141, 115, 'Aliquid alias non occaecati aut. Delectus laudantium enim velit ipsum et. A animi quasi pariatur consequatur error et laborum incidunt.', '2013-02-02 05:17:09'),
(220, 143, 118, 'Totam officiis sapiente et totam reprehenderit. Est eum et debitis eos sit. Voluptatem sit libero voluptatum aut. Consequatur qui eaque velit.', '2016-11-27 00:39:39'),
(221, 141, 114, 'Sed odio labore debitis nisi ab. Enim porro sint quia vero porro quo quas odio. Earum ducimus ipsum distinctio et voluptas. Sed minima recusandae qui quis voluptatibus assumenda qui.', '1980-01-19 23:10:02'),
(222, 144, 120, 'Culpa officiis in voluptates nisi ratione rem. Ratione saepe ea non et ab eveniet numquam.', '1985-03-08 19:40:23'),
(223, 146, 116, 'Et vel ipsam sapiente alias et nisi. Nesciunt et ea doloribus odio placeat necessitatibus. Dolorum est vel aperiam odio repudiandae.', '1998-04-13 00:13:56'),
(224, 149, 114, 'Eos rerum natus alias rerum. Fugit numquam id unde sit similique.', '1999-10-19 22:31:36'),
(225, 143, 119, 'Ipsum eligendi est rerum quos perspiciatis. Itaque tempora ab maxime dolores et nisi illo. Vel nihil ut atque sunt ducimus ut ducimus. Id itaque incidunt est commodi.', '2020-12-22 05:23:20'),
(226, 149, 118, 'Aut aspernatur accusantium dolorum sed.', '1995-08-16 09:01:59'),
(227, 144, 118, 'Est sequi temporibus iste voluptatem.', '1987-01-27 10:39:47'),
(228, 145, 117, 'Aliquid itaque veritatis enim est rerum. Reiciendis suscipit vero atque et natus. Voluptates nesciunt porro tempore ipsum cupiditate.', '2007-12-18 10:36:46'),
(229, 142, 117, 'Dicta delectus id alias quo porro maxime et.', '2014-10-08 09:38:27'),
(230, 143, 119, 'Quo qui dicta minima. Qui in asperiores hic quisquam quibusdam. Minus perspiciatis laudantium quod asperiores. Quia mollitia excepturi rerum consequatur id dolor sed.', '1988-12-22 11:11:17'),
(231, 141, 118, 'Omnis et in eius quia quia tempore ipsam. Ab at deleniti possimus sint quod. Velit dolor blanditiis ipsa dolorum quia exercitationem quas aut. Voluptatem numquam aut facere sapiente beatae facilis soluta rerum. Aut repudiandae amet voluptas provident. Totam provident qui est saepe impedit laboriosam ut quo.', '2020-03-18 11:38:58'),
(232, 141, 118, 'Aliquam reprehenderit occaecati corrupti eius eligendi nemo. Voluptas natus quam deserunt illo modi molestias id sit. Quia dolor ipsa omnis nostrum quis aut ut. Ut repudiandae et voluptatem aspernatur eveniet alias exercitationem.', '1979-09-10 14:22:52'),
(233, 141, 118, 'Atque rem qui esse aut enim. Ea minus provident praesentium sunt enim expedita beatae. Laborum molestiae eos praesentium ut qui cumque. Dolores ut ex excepturi ut error impedit.', '2003-10-03 02:09:16'),
(234, 141, 118, 'Deleniti sint ipsam.', '1975-05-07 17:09:31'),
(235, 141, 118, 'Soluta vero sapiente et maiores cumque voluptas.', '1997-12-25 12:59:45'),
(236, 141, 118, 'Quam ut ipsam et illo commodi. Est dolorem hic nihil officiis. Dolorem aspernatur sed animi ipsa est cupiditate ex. Ipsam assumenda amet nostrum aliquam commodi asperiores.', '1975-01-22 01:19:51'),
(237, 141, 118, 'Incidunt suscipit iste ut neque. Qui cupiditate numquam quos voluptatem eos repudiandae. Enim magnam maiores cum dolor.', '1979-08-30 17:14:15'),
(238, 141, 118, 'Ea qui quam quia.', '2016-04-20 02:44:21'),
(239, 141, 118, 'Impedit et blanditiis explicabo.', '1982-04-18 00:27:41'),
(240, 141, 118, 'Similique dicta libero corporis. Quisquam unde eos laborum laudantium. Facere voluptatibus doloribus tempora nihil. Odit ut nobis blanditiis nisi reiciendis et quod impedit. Autem soluta quaerat deserunt accusantium aut.', '1996-07-21 05:57:05'),
(241, 141, 118, 'Accusamus placeat animi doloribus.', '1988-02-15 04:39:09'),
(242, 141, 118, 'Dolores qui molestias aperiam eius nulla distinctio eligendi.', '2000-11-17 07:34:20'),
(243, 141, 118, 'Hic aut accusamus minima expedita ipsam porro. Velit earum officia est eius. Facilis saepe quae exercitationem ducimus magnam.', '2006-01-08 09:49:23'),
(244, 141, 118, 'Delectus sint repellat dolorum in minima. Aut sed quia consequuntur alias quia itaque debitis aut.', '1980-08-06 15:29:13'),
(245, 141, 118, 'Sit nisi quod ipsa sapiente ab. Reprehenderit nam beatae libero nulla velit atque ratione. Quibusdam quia praesentium similique dolorum et eius.', '2002-09-19 11:03:24');

-- --------------------------------------------------------

--
-- Structure de la table `trick_group`
--

DROP TABLE IF EXISTS `trick_group`;
CREATE TABLE IF NOT EXISTS `trick_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_group`
--

INSERT INTO `trick_group` (`id`, `name`) VALUES
(85, 'Grabs'),
(86, 'Rotations'),
(87, 'Flips'),
(88, 'Slides'),
(89, 'One foot'),
(90, 'Old school');

-- --------------------------------------------------------

--
-- Structure de la table `trick_picture`
--

DROP TABLE IF EXISTS `trick_picture`;
CREATE TABLE IF NOT EXISTS `trick_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `url` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_homepage` tinyint(1) DEFAULT NULL,
  `is_main_picture` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_758636D1B281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_picture`
--

INSERT INTO `trick_picture` (`id`, `trick_id`, `url`, `created_at`, `is_homepage`, `is_main_picture`) VALUES
(121, 141, '1-4.jpg', '2003-03-08 23:25:01', 1, NULL),
(122, 142, '27SF-animation-figure-snowboard-freestyle-v.jpg', '2019-01-10 03:15:37', NULL, NULL),
(123, 143, '27SF-animation-figure-snowboard-freestyle.jpg', '2020-04-30 14:15:12', NULL, NULL),
(124, 144, '27SF-spectacle-snowboard-freestyle.jpg', '1987-08-05 12:34:24', NULL, NULL),
(125, 145, '3beb00f9f125f042c71af780d5b2fc2e.jpg', '1975-01-15 18:19:22', NULL, NULL),
(126, 146, 'Figure-snow-LA-PIERRE-SAINT-MARTIN-©PAUL-QUINTANA-640x480-crop-1662475374.jpeg', '2016-09-09 19:25:55', NULL, NULL),
(127, 147, 'figure-snowboard.jpg', '1982-06-02 16:29:28', NULL, NULL),
(128, 148, 'homepage-hero.jpg', '1993-05-20 05:42:11', NULL, NULL),
(129, 149, 'image.jpg', '1985-05-19 23:05:46', NULL, NULL),
(130, 150, 'inzell-snowboardcamp-bayern-alpen.jpg', '2022-02-13 23:53:48', NULL, NULL),
(131, 141, 'KellyClark_TrickTips_Blotto_9.2e16d0ba.fill-1200x630-c75.jpg', '2020-11-25 13:19:47', NULL, NULL),
(132, 142, 'Ollie_2.max-836x555.jpg', '1988-09-17 13:33:37', NULL, NULL),
(133, 143, 'OTHB-SNOBOARD-640x320.jpg', '1992-02-29 08:40:00', NULL, NULL),
(134, 144, 'protection3.jpg', '2000-11-01 22:41:13', NULL, NULL),
(135, 145, 'snowtrick1.jpg', '1983-01-11 09:14:24', NULL, NULL),
(136, 146, 'snowtrick2.jpg', '1991-10-15 07:34:23', NULL, NULL),
(137, 147, 'snowtrick3.jpg', '2012-06-03 23:11:57', NULL, NULL),
(138, 148, 'snowtrick5.jpg', '1993-09-11 09:56:32', NULL, NULL),
(139, 149, 'snowtrick5.jpg', '1986-07-03 20:35:14', NULL, NULL),
(140, 150, 'sticker-auto-figure-de-snowboard.jpg', '1990-02-25 02:54:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `trick_video`
--

DROP TABLE IF EXISTS `trick_video`;
CREATE TABLE IF NOT EXISTS `trick_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_external_url` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_video`
--

INSERT INTO `trick_video` (`id`, `url`, `created_at`, `is_external_url`) VALUES
(11, 'video_671500092e6611.42602429.mp4', '2001-03-10 12:29:46', 0);

-- --------------------------------------------------------

--
-- Structure de la table `trick_video_trick`
--

DROP TABLE IF EXISTS `trick_video_trick`;
CREATE TABLE IF NOT EXISTS `trick_video_trick` (
  `trick_video_id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  PRIMARY KEY (`trick_video_id`,`trick_id`),
  KEY `IDX_D9A5C7D54C1284F1` (`trick_video_id`),
  KEY `IDX_D9A5C7D5B281BE2E` (`trick_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_video_trick`
--

INSERT INTO `trick_video_trick` (`trick_video_id`, `trick_id`) VALUES
(11, 141);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` longtext NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` longtext DEFAULT NULL,
  `logo` longtext DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `token`, `logo`, `roles`) VALUES
(114, 'John', 'k3=zq*GAXqp', 'John@example.com', NULL, 'https://picsum.photos/200', '[\"ROLE_ADMIN\"]'),
(115, 'Pierre', '/!}bccC$a!', 'Pierre@example.com', NULL, 'https://picsum.photos/200', '[\"ROLE_USER\"]'),
(116, 'Marcel', 'YsCN1Y?o4RQAi&l', 'Marcel@example.com', NULL, NULL, '[\"ROLE_USER\"]'),
(117, 'Hugo', 'N}=U/pd8QzyVIiK', 'Hugo@example.com', NULL, 'https://picsum.photos/200', '[\"ROLE_USER\"]'),
(118, 'Nicolas', 'tov2mc=O8UO8gq$', 'Nicolas@example.com', NULL, NULL, '[\"ROLE_USER\"]'),
(119, 'Frédéric', '<mwt~\'o&,]V:H`R', 'Frédéric@example.com', NULL, NULL, '[\"ROLE_USER\"]'),
(120, 'Emmanuel', 'ChE\'*k)~tk3vw.Gd0#ht', 'Emmanuel@example.com', NULL, NULL, '[\"ROLE_USER\"]'),
(121, 'Valentin', 'A.iwsVM{e50l34^3', 'Valentin@example.com', NULL, NULL, '[\"ROLE_USER\"]');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chat_room_comment`
--
ALTER TABLE `chat_room_comment`
  ADD CONSTRAINT `FK_86BD870DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E9B875DF8` FOREIGN KEY (`trick_group_id`) REFERENCES `trick_group` (`id`);

--
-- Contraintes pour la table `trick_comment`
--
ALTER TABLE `trick_comment`
  ADD CONSTRAINT `FK_F7292B34A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F7292B34B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick_picture`
--
ALTER TABLE `trick_picture`
  ADD CONSTRAINT `FK_758636D1B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick_video_trick`
--
ALTER TABLE `trick_video_trick`
  ADD CONSTRAINT `FK_D9A5C7D54C1284F1` FOREIGN KEY (`trick_video_id`) REFERENCES `trick_video` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D9A5C7D5B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
