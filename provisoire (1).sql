-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 07 mars 2025 à 13:33
-- Version du serveur : 8.0.34
-- Version de PHP : 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `provisoire`
--

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

CREATE TABLE `achats` (
  `id` int NOT NULL,
  `article_id` int NOT NULL,
  `commande_id` int NOT NULL,
  `fournisseur_id` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `date_entre` date DEFAULT NULL,
  `prix` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `achats`
--

INSERT INTO `achats` (`id`, `article_id`, `commande_id`, `fournisseur_id`, `quantite`, `date_entre`, `prix`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 2000, '2025-03-04', 1200, '2025-03-02 12:12:54', '2025-03-02 12:12:54'),
(2, 6, 1, 3, 1500, NULL, 2000, '2025-03-02 14:01:00', '2025-03-02 14:01:00'),
(3, 9, 3, 3, 40, '2025-03-04', 1400, '2025-03-04 05:11:12', '2025-03-04 05:11:12'),
(4, 1, 3, 3, 60, '2025-03-04', 2000, '2025-03-04 05:11:12', '2025-03-04 05:11:12'),
(5, 8, 4, 1, 25, '2025-03-04', 4000, '2025-03-04 05:11:42', '2025-03-04 05:11:42'),
(6, 10, 5, 1, 47, '2025-03-04', 3500, '2025-03-04 05:13:42', '2025-03-04 05:13:42'),
(7, 12, 5, 1, 100, '2025-03-04', 3200, '2025-03-04 05:13:42', '2025-03-04 05:13:42'),
(8, 9, 9, 1, 9, '2025-03-04', 1500, '2025-03-04 08:12:43', '2025-03-04 08:12:43'),
(9, 11, 9, 1, 23, '2025-03-04', 1000, '2025-03-04 08:12:43', '2025-03-04 08:12:43'),
(10, 7, 14, 1, 14, '2025-03-04', 5000, '2025-03-04 10:24:52', '2025-03-04 10:24:52'),
(11, 1, 21, 1, 40, '2025-03-04', 1000, '2025-03-04 12:38:54', '2025-03-04 12:38:54'),
(12, 11, 22, 1, 14, '2025-03-04', 1400, '2025-03-04 13:16:52', '2025-03-04 13:16:52'),
(13, 14, 22, 1, 36, '2025-03-04', 4700, '2025-03-04 13:16:52', '2025-03-04 13:16:52'),
(14, 12, 28, 1, 12, '2025-03-06', 3000, '2025-03-06 10:58:50', '2025-03-06 10:58:50'),
(15, 15, 29, 1, 12, '2025-03-06', 2000, '2025-03-06 11:00:18', '2025-03-06 11:00:18'),
(16, 1, 32, NULL, 1, '2025-03-06', 1200, '2025-03-06 11:34:37', '2025-03-06 11:34:37'),
(17, 12, 33, NULL, 1, '2025-03-06', 2500, '2025-03-06 11:36:17', '2025-03-06 11:36:17'),
(18, 12, 34, NULL, 1, '2025-03-06', 2500, '2025-03-06 11:36:41', '2025-03-06 11:36:41'),
(19, 16, 35, 1, 10, '2025-03-06', 4000, '2025-03-06 11:38:36', '2025-03-06 11:38:36'),
(20, 6, 37, NULL, 1, '2025-03-06', 2000, '2025-03-06 12:00:56', '2025-03-06 12:00:56'),
(21, 11, 37, NULL, 1, '2025-03-06', 2500, '2025-03-06 12:00:56', '2025-03-06 12:00:56'),
(22, 9, 84, NULL, 47, '2025-03-07', 1500, '2025-03-07 06:10:06', '2025-03-07 06:10:06'),
(23, 11, 85, 2, 4, '2025-03-07', 2500, '2025-03-07 06:17:11', '2025-03-07 06:17:11'),
(24, 7, 85, 2, 6, '2025-03-07', 1200, '2025-03-07 06:17:11', '2025-03-07 06:17:11'),
(25, 1, 85, 2, 2, '2025-03-07', 4000, '2025-03-07 06:17:11', '2025-03-07 06:17:11'),
(26, 18, 95, NULL, 12, '2025-03-07', 3948, '2025-03-07 07:25:18', '2025-03-07 07:25:18'),
(27, 17, 106, 4, 3, '2025-03-07', 3400, '2025-03-07 09:22:53', '2025-03-07 09:22:53');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `categorie_id` int DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `reference` varchar(20) DEFAULT NULL,
  `conditionnement` int DEFAULT NULL,
  `imagep` varchar(200) DEFAULT NULL,
  `prix_unitaire` int NOT NULL,
  `prix_consignation` int DEFAULT NULL,
  `prix_vente` int DEFAULT NULL,
  `prix_conditionne` int DEFAULT NULL,
  `quantite` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `categorie_id`, `nom`, `reference`, `conditionnement`, `imagep`, `prix_unitaire`, `prix_consignation`, `prix_vente`, `prix_conditionne`, `quantite`, `created_at`, `updated_at`) VALUES
(1, 3, 'pilsener 65 cl', NULL, 24, NULL, 4000, 700, NULL, NULL, 4665, '2025-03-02 11:02:32', '2025-03-07 09:28:02'),
(6, 1, 'PAS DE NOM', NULL, 20, NULL, 2000, 700, NULL, NULL, 2000, '2025-03-02 12:11:35', '2025-03-06 13:11:37'),
(7, 1, 'pilsener 33 cl', NULL, 20, NULL, 1200, 700, NULL, NULL, 27, '2025-03-04 02:37:04', '2025-03-07 10:18:54'),
(8, 3, 'gold  blanche', NULL, 24, NULL, 2000, 700, NULL, NULL, 1103, '2025-03-04 02:38:04', '2025-03-07 08:35:41'),
(9, 1, 'gold cannette 33 cl', NULL, 20, NULL, 1500, 700, NULL, NULL, 864, '2025-03-04 02:39:03', '2025-03-07 10:18:54'),
(10, 6, 'queens 100 cl', NULL, 24, NULL, 2300, 700, NULL, NULL, 1106, '2025-03-04 02:50:31', '2025-03-07 09:28:02'),
(11, 6, 'queens 33 cl', NULL, 24, NULL, 2500, 700, NULL, NULL, 112, '2025-03-04 02:53:00', '2025-03-07 07:20:14'),
(12, 7, 'beau fort 33 cl', NULL, 20, NULL, 2500, 700, NULL, NULL, 244, '2025-03-04 02:54:05', '2025-03-07 07:04:20'),
(14, 2, 'fanta 100 cl', NULL, 20, NULL, 3000, 700, NULL, 20000, 65, '2025-03-04 04:37:41', '2025-03-07 08:39:11'),
(15, 2, 'Limonade', NULL, 24, NULL, 1500, 700, NULL, NULL, 1444, '2025-03-04 13:16:10', '2025-03-07 10:18:54'),
(16, 7, 'petit test', NULL, 20, NULL, 4000, 700, NULL, 70000, 200, '2025-03-06 09:59:48', '2025-03-06 11:38:36'),
(17, 3, 'GOLD Masters', NULL, 20, NULL, 3400, 800, 0, NULL, 60, '2025-03-07 06:30:47', '2025-03-07 09:22:53'),
(18, 8, 'Booster 50 cl', NULL, 20, NULL, 3948, 700, 4000, 79000, 200, '2025-03-07 07:24:17', '2025-03-07 07:29:42');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admins@gmail.com|127.0.0.1', 'i:1;', 1739268983),
('admins@gmail.com|127.0.0.1:timer', 'i:1739268983;', 1739268983),
('chams@gmail.com|::1', 'i:2;', 1740897694),
('chams@gmail.com|::1:timer', 'i:1740897694;', 1740897694),
('chams@gmail.com|127.0.0.1', 'i:1;', 1739268911),
('chams@gmail.com|127.0.0.1:timer', 'i:1739268911;', 1739268911);

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `reference` varchar(20) DEFAULT NULL,
  `imagep` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `reference`, `imagep`, `created_at`, `updated_at`) VALUES
(1, 'THB', NULL, NULL, '2025-03-02 10:09:38', '2025-03-02 10:09:38'),
(2, 'BOISSON GAZEUSE', NULL, NULL, '2025-03-02 10:09:57', '2025-03-02 10:09:57'),
(3, 'GOLD', NULL, NULL, '2025-03-02 10:09:57', '2025-03-02 10:09:57'),
(5, 'XXL', NULL, NULL, '2025-03-04 02:43:57', '2025-03-04 02:43:57'),
(6, 'QUEENS', NULL, NULL, '2025-03-04 02:47:21', '2025-03-04 02:47:21'),
(7, 'BEAU FORT', NULL, NULL, '2025-03-04 02:48:58', '2025-03-04 02:48:58'),
(8, 'ALCOOL  MIX', NULL, NULL, '2025-03-04 03:07:52', '2025-03-04 03:07:52');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `reference` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `numero`, `reference`, `created_at`, `updated_at`) VALUES
(1, 'MRANA', NULL, NULL, '2025-03-04 06:00:26', '2025-03-04 06:00:26'),
(2, 'JAVER', NULL, NULL, '2025-03-04 06:00:26', '2025-03-04 06:00:26'),
(3, 'PAPAYA', NULL, NULL, '2025-03-04 06:00:26', '2025-03-04 06:00:26'),
(4, 'LORIE', NULL, NULL, '2025-03-04 06:00:26', '2025-03-04 06:00:26'),
(5, 'patron', '0325514521', NULL, '2025-03-04 06:07:16', '2025-03-04 06:07:16');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int NOT NULL,
  `client_id` int DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date_commande` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fournisseur_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `client_id`, `user_id`, `date_commande`, `created_at`, `updated_at`, `fournisseur_id`) VALUES
(1, 2, 1, '2025-03-12', '2025-03-02 12:01:53', '2025-03-02 12:01:53', 0),
(2, 3, 1, '2025-03-06', '2025-03-02 12:02:06', '2025-03-02 12:02:06', 0),
(3, NULL, 1, NULL, '2025-03-04 08:11:12', '2025-03-04 08:11:12', NULL),
(4, NULL, 1, NULL, '2025-03-04 08:11:42', '2025-03-04 08:11:42', NULL),
(5, NULL, 1, NULL, '2025-03-04 08:13:42', '2025-03-04 08:13:42', NULL),
(6, 1, 1, NULL, '2025-03-04 11:08:32', '2025-03-04 11:08:32', NULL),
(7, 4, 1, NULL, '2025-03-04 11:09:53', '2025-03-04 11:09:53', NULL),
(8, 4, 1, NULL, '2025-03-04 11:11:12', '2025-03-04 11:11:12', NULL),
(9, NULL, 1, NULL, '2025-03-04 11:12:43', '2025-03-04 11:12:43', NULL),
(10, 1, 1, NULL, '2025-03-04 11:13:47', '2025-03-04 11:13:47', NULL),
(11, 1, 1, NULL, '2025-03-04 13:13:45', '2025-03-04 13:13:45', NULL),
(12, 1, 1, NULL, '2025-03-04 13:14:18', '2025-03-04 13:14:18', NULL),
(13, 1, 1, NULL, '2025-03-04 13:19:31', '2025-03-04 13:19:31', NULL),
(14, NULL, 1, NULL, '2025-03-04 13:24:52', '2025-03-04 13:24:52', NULL),
(15, 1, 1, NULL, '2025-03-04 13:25:12', '2025-03-04 13:25:12', NULL),
(16, 1, 1, NULL, '2025-03-04 13:26:18', '2025-03-04 13:26:18', NULL),
(17, 3, 1, NULL, '2025-03-04 13:33:18', '2025-03-04 13:33:18', NULL),
(18, 3, 1, NULL, '2025-03-04 13:51:55', '2025-03-04 13:51:55', NULL),
(19, 5, 1, NULL, '2025-03-04 14:27:52', '2025-03-04 14:27:52', NULL),
(20, 1, 1, NULL, '2025-03-04 15:08:18', '2025-03-04 15:08:18', NULL),
(21, NULL, 1, NULL, '2025-03-04 15:38:54', '2025-03-04 15:38:54', NULL),
(22, NULL, 1, NULL, '2025-03-04 16:16:52', '2025-03-04 16:16:52', NULL),
(23, 1, 1, NULL, '2025-03-04 16:17:37', '2025-03-04 16:17:37', NULL),
(24, 3, 1, NULL, '2025-03-06 13:39:32', '2025-03-06 13:39:32', NULL),
(25, 1, 1, NULL, '2025-03-06 13:40:48', '2025-03-06 13:40:48', NULL),
(26, 1, 1, NULL, '2025-03-06 13:46:04', '2025-03-06 13:46:04', NULL),
(27, 3, 1, NULL, '2025-03-06 13:49:40', '2025-03-06 13:49:40', NULL),
(28, NULL, 1, NULL, '2025-03-06 13:58:50', '2025-03-06 13:58:50', NULL),
(29, NULL, 1, NULL, '2025-03-06 14:00:18', '2025-03-06 14:00:18', NULL),
(30, NULL, 1, NULL, '2025-03-06 14:26:12', '2025-03-06 14:26:12', NULL),
(31, NULL, 1, NULL, '2025-03-06 14:30:41', '2025-03-06 14:30:41', NULL),
(32, NULL, 1, NULL, '2025-03-06 14:34:37', '2025-03-06 14:34:37', NULL),
(33, NULL, 1, NULL, '2025-03-06 14:36:17', '2025-03-06 14:36:17', NULL),
(34, NULL, 1, NULL, '2025-03-06 14:36:41', '2025-03-06 14:36:41', NULL),
(35, NULL, 1, NULL, '2025-03-06 14:38:36', '2025-03-06 14:38:36', NULL),
(36, NULL, 1, NULL, '2025-03-06 14:44:57', '2025-03-06 14:44:57', NULL),
(37, NULL, 1, NULL, '2025-03-06 15:00:56', '2025-03-06 15:00:56', NULL),
(38, NULL, 1, NULL, '2025-03-06 16:11:37', '2025-03-06 16:11:37', NULL),
(39, NULL, 1, NULL, '2025-03-06 17:04:53', '2025-03-06 17:04:53', NULL),
(40, NULL, 1, NULL, '2025-03-06 17:07:16', '2025-03-06 17:07:16', NULL),
(41, NULL, 1, NULL, '2025-03-06 17:07:42', '2025-03-06 17:07:42', NULL),
(42, NULL, 1, NULL, '2025-03-06 17:09:38', '2025-03-06 17:09:38', NULL),
(43, NULL, 1, NULL, '2025-03-06 17:15:11', '2025-03-06 17:15:11', NULL),
(44, NULL, 1, NULL, '2025-03-06 17:15:32', '2025-03-06 17:15:32', NULL),
(45, NULL, 1, NULL, '2025-03-06 17:15:59', '2025-03-06 17:15:59', NULL),
(46, 1, 1, NULL, '2025-03-06 17:16:57', '2025-03-06 17:16:57', NULL),
(47, NULL, 1, NULL, '2025-03-06 17:17:54', '2025-03-06 17:17:54', NULL),
(48, NULL, 1, NULL, '2025-03-06 17:18:16', '2025-03-06 17:18:16', NULL),
(49, 3, 1, NULL, '2025-03-06 17:20:22', '2025-03-06 17:20:22', NULL),
(50, 4, 1, NULL, '2025-03-06 17:21:27', '2025-03-06 17:21:27', NULL),
(51, NULL, 1, NULL, '2025-03-06 19:10:44', '2025-03-06 19:10:44', NULL),
(52, NULL, 1, NULL, '2025-03-06 20:11:02', '2025-03-06 20:11:02', NULL),
(53, NULL, 1, NULL, '2025-03-07 04:46:58', '2025-03-07 04:46:58', NULL),
(54, NULL, 1, NULL, '2025-03-07 05:53:26', '2025-03-07 05:53:26', NULL),
(55, NULL, 1, NULL, '2025-03-07 05:53:41', '2025-03-07 05:53:41', NULL),
(56, NULL, 1, NULL, '2025-03-07 05:54:02', '2025-03-07 05:54:02', NULL),
(57, NULL, 1, NULL, '2025-03-07 05:57:26', '2025-03-07 05:57:26', NULL),
(58, NULL, 1, NULL, '2025-03-07 06:03:00', '2025-03-07 06:03:00', NULL),
(59, NULL, 1, NULL, '2025-03-07 06:08:45', '2025-03-07 06:08:45', NULL),
(60, NULL, 1, NULL, '2025-03-07 07:21:45', '2025-03-07 07:21:45', NULL),
(61, 3, 1, NULL, '2025-03-07 07:23:43', '2025-03-07 07:23:43', NULL),
(62, NULL, 1, NULL, '2025-03-07 07:27:27', '2025-03-07 07:27:27', NULL),
(63, NULL, 1, NULL, '2025-03-07 07:31:36', '2025-03-07 07:31:36', NULL),
(64, NULL, 1, NULL, '2025-03-07 07:35:35', '2025-03-07 07:35:35', NULL),
(65, NULL, 1, NULL, '2025-03-07 07:36:52', '2025-03-07 07:36:52', NULL),
(66, NULL, 1, NULL, '2025-03-07 07:37:25', '2025-03-07 07:37:25', NULL),
(67, NULL, 1, NULL, '2025-03-07 07:40:38', '2025-03-07 07:40:38', NULL),
(68, NULL, 1, NULL, '2025-03-07 07:42:40', '2025-03-07 07:42:40', NULL),
(69, NULL, 1, NULL, '2025-03-07 07:44:53', '2025-03-07 07:44:53', NULL),
(70, NULL, 1, NULL, '2025-03-07 07:45:20', '2025-03-07 07:45:20', NULL),
(71, NULL, 1, NULL, '2025-03-07 07:45:53', '2025-03-07 07:45:53', NULL),
(72, NULL, 1, NULL, '2025-03-07 07:47:54', '2025-03-07 07:47:54', NULL),
(73, NULL, 1, NULL, '2025-03-07 07:49:39', '2025-03-07 07:49:39', NULL),
(74, NULL, 1, NULL, '2025-03-07 07:51:19', '2025-03-07 07:51:19', NULL),
(75, NULL, 1, NULL, '2025-03-07 07:51:50', '2025-03-07 07:51:50', NULL),
(76, NULL, 1, NULL, '2025-03-07 07:54:34', '2025-03-07 07:54:34', NULL),
(77, NULL, 1, NULL, '2025-03-07 07:57:22', '2025-03-07 07:57:22', NULL),
(78, NULL, 1, NULL, '2025-03-07 08:06:08', '2025-03-07 08:06:08', NULL),
(79, NULL, 1, NULL, '2025-03-07 08:08:12', '2025-03-07 08:08:12', NULL),
(80, NULL, 1, NULL, '2025-03-07 08:28:12', '2025-03-07 08:28:12', NULL),
(81, NULL, 1, NULL, '2025-03-07 08:29:06', '2025-03-07 08:29:06', NULL),
(82, 4, 1, NULL, '2025-03-07 08:38:17', '2025-03-07 08:38:17', NULL),
(83, NULL, 1, NULL, '2025-03-07 09:08:43', '2025-03-07 09:08:43', NULL),
(84, NULL, 1, NULL, '2025-03-07 09:10:06', '2025-03-07 09:10:06', NULL),
(85, NULL, 1, NULL, '2025-03-07 09:17:11', '2025-03-07 09:17:11', NULL),
(86, NULL, 1, NULL, '2025-03-07 09:43:45', '2025-03-07 09:43:45', NULL),
(87, NULL, 1, NULL, '2025-03-07 09:47:10', '2025-03-07 09:47:10', NULL),
(88, NULL, 1, NULL, '2025-03-07 09:52:00', '2025-03-07 09:52:00', NULL),
(89, NULL, 1, NULL, '2025-03-07 09:58:02', '2025-03-07 09:58:02', NULL),
(90, NULL, 1, NULL, '2025-03-07 09:58:24', '2025-03-07 09:58:24', NULL),
(91, NULL, 1, NULL, '2025-03-07 09:59:44', '2025-03-07 09:59:44', NULL),
(92, NULL, 1, NULL, '2025-03-07 10:04:20', '2025-03-07 10:04:20', NULL),
(93, NULL, 1, NULL, '2025-03-07 10:06:06', '2025-03-07 10:06:06', NULL),
(94, NULL, 1, NULL, '2025-03-07 10:20:14', '2025-03-07 10:20:14', NULL),
(95, NULL, 1, NULL, '2025-03-07 10:25:18', '2025-03-07 10:25:18', NULL),
(96, NULL, 1, NULL, '2025-03-07 10:29:42', '2025-03-07 10:29:42', NULL),
(97, NULL, 1, NULL, '2025-03-07 11:15:04', '2025-03-07 11:15:04', NULL),
(98, NULL, 1, NULL, '2025-03-07 11:17:05', '2025-03-07 11:17:05', NULL),
(99, NULL, 1, NULL, '2025-03-07 11:35:41', '2025-03-07 11:35:41', NULL),
(100, NULL, 1, NULL, '2025-03-07 11:39:11', '2025-03-07 11:39:11', NULL),
(101, NULL, 1, NULL, '2025-03-07 11:40:04', '2025-03-07 11:40:04', NULL),
(102, NULL, 1, NULL, '2025-03-07 12:11:43', '2025-03-07 12:11:43', NULL),
(103, NULL, 1, NULL, '2025-03-07 12:12:09', '2025-03-07 12:12:09', NULL),
(104, NULL, 1, NULL, '2025-03-07 12:12:59', '2025-03-07 12:12:59', NULL),
(105, 2, 1, NULL, '2025-03-07 12:19:57', '2025-03-07 12:19:57', NULL),
(106, NULL, 1, NULL, '2025-03-07 12:22:53', '2025-03-07 12:22:53', NULL),
(107, NULL, 1, NULL, '2025-03-07 12:28:02', '2025-03-07 12:28:02', NULL),
(108, NULL, 1, NULL, '2025-03-07 13:18:54', '2025-03-07 13:18:54', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `consignations`
--

CREATE TABLE `consignations` (
  `id` int NOT NULL,
  `vente_id` int NOT NULL,
  `prix` int NOT NULL,
  `type_consignation` tinyint(1) DEFAULT '0',
  `etat` varchar(10) DEFAULT 'non rendu',
  `date_consignation` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consignations`
--

INSERT INTO `consignations` (`id`, `vente_id`, `prix`, `type_consignation`, `etat`, `date_consignation`, `created_at`) VALUES
(27, 78, 5600, 0, 'non rendu', '2025-03-07', '2025-03-07 07:44:53'),
(28, 79, 4200, 0, 'non rendu', '2025-03-07', '2025-03-07 07:45:20'),
(29, 80, 3500, 0, 'non rendu', '2025-03-07', '2025-03-07 07:45:53'),
(30, 81, 134400, 0, 'non rendu', '2025-03-07', '2025-03-07 07:47:54'),
(31, 82, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 07:49:39'),
(32, 83, 33600, 0, 'non rendu', '2025-03-07', '2025-03-07 07:51:19'),
(33, 84, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 07:51:50'),
(34, 85, 28000, 0, 'non rendu', '2025-03-07', '2025-03-07 07:54:34'),
(35, 86, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 07:54:34'),
(36, 87, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 07:57:22'),
(37, 88, 67200, 0, 'non rendu', '2025-03-07', '2025-03-07 08:06:08'),
(38, 89, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 08:08:12'),
(39, 90, 1400, 0, 'non rendu', '2025-03-07', '2025-03-07 08:28:12'),
(40, 91, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 08:29:06'),
(41, 92, 28000, 0, 'non rendu', '2025-03-07', '2025-03-07 08:38:17'),
(42, 93, 14000, 0, 'non rendu', '2025-03-07', '2025-03-07 09:08:43'),
(43, 94, 67200, 0, 'non rendu', '2025-03-07', '2025-03-07 09:43:46'),
(44, 95, 50400, 0, 'non rendu', '2025-03-07', '2025-03-07 09:47:10'),
(45, 96, 2800, 0, 'non rendu', '2025-03-07', '2025-03-07 09:47:10'),
(46, 97, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 09:52:00'),
(47, 99, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 09:58:24'),
(48, 100, 9800, 0, 'non rendu', '2025-03-07', '2025-03-07 09:59:44'),
(49, 101, 2800, 0, 'non rendu', '2025-03-07', '2025-03-07 10:04:20'),
(50, 102, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 10:06:06'),
(51, 103, 11900, 0, 'non rendu', '2025-03-07', '2025-03-07 10:06:06'),
(52, 105, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 10:20:14'),
(53, 107, 14000, 0, 'non rendu', '2025-03-07', '2025-03-07 10:29:42'),
(54, 109, 14000, 0, 'non rendu', '2025-03-07', '2025-03-07 11:15:04'),
(55, 111, 9800, 0, 'non rendu', '2025-03-07', '2025-03-07 11:17:05'),
(56, 113, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 11:35:41'),
(57, 119, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 11:40:04'),
(58, 125, 16800, 0, 'non rendu', '2025-03-07', '2025-03-07 12:28:02'),
(59, 126, 4200, 0, 'non rendu', '2025-03-07', '2025-03-07 12:28:02'),
(60, 127, 56000, 0, 'non rendu', '2025-03-07', '2025-03-07 13:18:54'),
(61, 128, 9800, 0, 'non rendu', '2025-03-07', '2025-03-07 13:18:54');

-- --------------------------------------------------------

--
-- Structure de la table `consignation_achats`
--

CREATE TABLE `consignation_achats` (
  `id` int NOT NULL,
  `achat_id` int NOT NULL,
  `prix` int DEFAULT NULL,
  `etat` varchar(10) DEFAULT 'non rendu',
  `date_consignation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `reference` varchar(10) DEFAULT NULL,
  `date_entre` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `numero`, `reference`, `date_entre`) VALUES
(1, 'MARIO', NULL, NULL, '2025-03-02 11:55:08'),
(2, 'GEORGE', NULL, NULL, '2025-03-02 11:55:08'),
(3, 'FRANCIS', NULL, NULL, '2025-03-02 11:55:37'),
(4, 'MOURAD', NULL, NULL, '2025-03-02 11:55:37'),
(5, 'mufasa', '0325514521', NULL, '2025-03-04 06:04:41'),
(6, 'Néolin', '5000', NULL, '2025-03-04 06:06:50');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payements`
--

CREATE TABLE `payements` (
  `id` int NOT NULL,
  `commande_id` int NOT NULL,
  `mode_paye` varchar(20) DEFAULT 'espèce',
  `somme` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `payements`
--

INSERT INTO `payements` (`id`, `commande_id`, `mode_paye`, `somme`, `created_at`, `updated_at`) VALUES
(1, 1, 'espèce', 15000, '2025-03-02 12:15:30', '2025-03-02 12:15:30'),
(2, 2, 'espèce', 8000, '2025-03-02 12:15:30', '2025-03-02 12:15:30');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('OWUTNN16AKWwmfQVDGeLpWV7tQdZGnPUylaBfDKd', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMEN1SjZxVjl0UGEzd1JFZ0RFQ1FqNWw4THhNWWJORnRCVFNpN29oeiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUwOiJodHRwOi8vbG9jYWxob3N0L3Byb3Zpc29pcmUvcHVibGljL2JvaXNzb25zL3ZlbnRlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1741354235);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mourad', 'admin@gmail.com', NULL, '$2y$12$O28DQMr.VrGR4GGwJuCaO.qhzp20moOy/70loiOLvvTE6p6PkOa46', NULL, '2025-02-11 05:21:30', '2025-02-11 05:21:30');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int NOT NULL,
  `article_id` int NOT NULL,
  `commande_id` int NOT NULL,
  `quantite` int NOT NULL,
  `btl` tinyint(1) DEFAULT NULL,
  `cgt` int DEFAULT NULL,
  `type_achat` varchar(10) DEFAULT NULL,
  `prix` int DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `article_id`, `commande_id`, `quantite`, `btl`, `cgt`, `type_achat`, `prix`, `date_sortie`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 200, 1, NULL, 'cageot', 1200, '2025-03-12', '2025-03-02 12:13:25', '2025-03-02 12:13:25'),
(2, 6, 2, 600, 1, NULL, 'cageot', 1500, '2025-03-12', '2025-04-01 12:13:53', '2025-03-02 12:13:53'),
(3, 12, 6, 17, 1, NULL, 'cageot', 2000, '2025-03-04', '2025-03-04 08:08:32', '2025-03-04 08:08:32'),
(4, 10, 6, 25, 1, NULL, 'cageot', 1000, '2025-03-04', '2025-03-04 08:08:32', '2025-03-04 08:08:32'),
(5, 10, 7, 28, 0, NULL, 'cageot', 1000, '2025-03-04', '2025-03-04 08:09:53', '2025-03-04 08:09:53'),
(6, 12, 8, 15, 1, NULL, 'cageot', 2000, '2025-03-04', '2025-03-04 08:11:12', '2025-03-04 08:11:12'),
(7, 14, 8, 36, 1, NULL, 'bouteille', 1500, '2025-03-04', '2025-03-04 08:11:12', '2025-03-04 08:11:12'),
(8, 1, 10, 14, 0, NULL, 'cageot', 1200, '2025-03-04', '2025-03-04 08:13:47', '2025-03-04 08:13:47'),
(9, 8, 11, 12, 1, NULL, 'bouteille', 3000, '2025-03-04', '2025-03-04 10:13:45', '2025-03-04 10:13:45'),
(10, 8, 11, 5, 1, NULL, 'cageot', 3000, '2025-03-04', '2025-03-04 10:13:45', '2025-03-04 10:13:45'),
(11, 10, 12, 5, 1, NULL, 'cageot', 1000, '2025-03-04', '2025-03-04 10:14:18', '2025-03-04 10:14:18'),
(12, 8, 13, 1, 1, NULL, 'cageot', 3000, '2025-03-04', '2025-03-04 10:19:32', '2025-03-04 10:19:32'),
(13, 14, 13, 14, 1, NULL, 'cageot', 1500, '2025-03-04', '2025-03-04 10:19:32', '2025-03-04 10:19:32'),
(14, 7, 15, 8, 1, NULL, 'cageot', 4000, '2025-03-04', '2025-03-04 10:25:12', '2025-03-04 10:25:12'),
(15, 1, 16, 17, 1, NULL, 'bouteille', 1200, '2025-03-04', '2025-03-04 10:26:18', '2025-03-04 10:26:18'),
(16, 11, 17, 17, 1, NULL, 'cageot', 3200, '2025-03-04', '2025-03-04 10:33:18', '2025-03-04 10:33:18'),
(17, 7, 18, 7, 1, NULL, 'cageot', 4000, '2025-03-04', '2025-03-04 10:51:55', '2025-03-04 10:51:55'),
(18, 9, 19, 90, 1, NULL, 'cageot', 200, '2025-03-04', '2025-03-04 11:27:52', '2025-03-04 11:27:52'),
(19, 1, 20, 14, 1, NULL, 'cageot', 1200, '2025-03-04', '2025-03-04 12:08:18', '2025-03-04 12:08:18'),
(20, 8, 23, 14, 1, NULL, 'cageot', 2000, '2025-03-04', '2025-03-04 13:17:37', '2025-03-04 13:17:37'),
(21, 10, 23, 17, 1, NULL, 'cageot', 2300, '2025-03-04', '2025-03-04 13:17:37', '2025-03-04 13:17:37'),
(22, 8, 26, 12, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 10:46:04', '2025-03-06 10:46:04'),
(23, 10, 26, 1, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 10:46:04', '2025-03-06 10:46:04'),
(24, 15, 27, 4, 1, NULL, 'bouteile', 1500, '2025-03-06', '2025-03-06 10:49:40', '2025-03-06 10:49:40'),
(25, 12, 27, 2, 1, NULL, 'bouteille', 2500, '2025-03-06', '2025-03-06 10:49:40', '2025-03-06 10:49:40'),
(26, 1, 36, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 11:44:57', '2025-03-06 11:44:57'),
(27, 8, 36, 2, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 11:44:57', '2025-03-06 11:44:57'),
(28, 12, 36, 12, 1, NULL, 'cageot', 2500, '2025-03-06', '2025-03-06 11:44:57', '2025-03-06 11:44:57'),
(29, 10, 38, 1, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 13:11:37', '2025-03-06 13:11:37'),
(30, 12, 38, 1, 1, NULL, 'bouteille', 2500, '2025-03-06', '2025-03-06 13:11:37', '2025-03-06 13:11:37'),
(31, 6, 38, 1, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 13:11:37', '2025-03-06 13:11:37'),
(32, 7, 39, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:04:53', '2025-03-06 14:04:53'),
(33, 8, 39, 2, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:04:53', '2025-03-06 14:04:53'),
(34, 7, 40, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:07:16', '2025-03-06 14:07:16'),
(35, 8, 40, 2, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:07:16', '2025-03-06 14:07:16'),
(36, 7, 41, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:07:42', '2025-03-06 14:07:42'),
(37, 8, 41, 2, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:07:42', '2025-03-06 14:07:42'),
(38, 7, 42, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:09:38', '2025-03-06 14:09:38'),
(39, 8, 42, 2, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:09:38', '2025-03-06 14:09:38'),
(40, 7, 43, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:15:11', '2025-03-06 14:15:11'),
(41, 8, 43, 2, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:15:11', '2025-03-06 14:15:11'),
(42, 7, 44, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:15:32', '2025-03-06 14:15:32'),
(43, 8, 44, 2, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:15:32', '2025-03-06 14:15:32'),
(44, 8, 45, 1, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:15:59', '2025-03-06 14:15:59'),
(45, 10, 45, 1, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 14:15:59', '2025-03-06 14:15:59'),
(46, 7, 46, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:16:57', '2025-03-06 14:16:57'),
(47, 10, 46, 1, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 14:16:57', '2025-03-06 14:16:57'),
(48, 8, 47, 1, 1, NULL, 'cageot', 2000, '2025-03-06', '2025-03-06 14:17:54', '2025-03-06 14:17:54'),
(49, 1, 48, 1, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 14:18:16', '2025-03-06 14:18:16'),
(50, 10, 49, 1, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 14:20:22', '2025-03-06 14:20:22'),
(51, 14, 49, 1, 1, NULL, 'cageot', 3000, '2025-03-06', '2025-03-06 14:20:22', '2025-03-06 14:20:22'),
(52, 9, 50, 11, 1, NULL, 'bouteille', 1500, '2025-03-06', '2025-03-06 14:21:27', '2025-03-06 14:21:27'),
(53, 11, 51, 2, 1, NULL, 'cageot', 2500, '2025-03-06', '2025-03-06 16:10:44', '2025-03-06 16:10:44'),
(54, 10, 52, 1, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 17:11:02', '2025-03-06 17:11:02'),
(55, 10, 52, 2, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 17:11:02', '2025-03-06 17:11:02'),
(56, 10, 52, 2, 1, NULL, 'cageot', 2300, '2025-03-06', '2025-03-06 17:11:02', '2025-03-06 17:11:02'),
(57, 7, 52, 2, 1, NULL, 'cageot', 1200, '2025-03-06', '2025-03-06 17:11:02', '2025-03-06 17:11:02'),
(58, 12, 52, 3, 1, NULL, 'bouteille', 2500, '2025-03-06', '2025-03-06 17:11:02', '2025-03-06 17:11:02'),
(59, 14, 53, 2, 1, NULL, 'cageot', 3000, '2025-03-07', '2025-03-07 01:46:58', '2025-03-07 01:46:58'),
(60, 1, 54, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 02:53:26', '2025-03-07 02:53:26'),
(61, 1, 55, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 02:53:41', '2025-03-07 02:53:41'),
(62, 8, 56, 1, 1, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 02:54:02', '2025-03-07 02:54:02'),
(63, 15, 56, 1, 1, NULL, 'cageot', 1500, '2025-03-07', '2025-03-07 02:54:02', '2025-03-07 02:54:02'),
(64, 11, 57, 1, 1, NULL, 'cageot', 2500, '2025-03-07', '2025-03-07 02:57:26', '2025-03-07 02:57:26'),
(65, 11, 57, 14, 1, NULL, 'bouteille', 2500, '2025-03-07', '2025-03-07 02:57:26', '2025-03-07 02:57:26'),
(66, 1, 58, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 03:03:00', '2025-03-07 03:03:00'),
(67, 1, 59, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 03:08:45', '2025-03-07 03:08:45'),
(68, 11, 60, 1, 1, NULL, 'cageot', 2500, '2025-03-07', '2025-03-07 04:21:45', '2025-03-07 04:21:45'),
(69, 15, 61, 6, 1, NULL, 'cageot', 1500, '2025-03-07', '2025-03-07 04:23:43', '2025-03-07 04:23:43'),
(70, 11, 61, 14, 1, NULL, 'bouteille', 2500, '2025-03-07', '2025-03-07 04:23:43', '2025-03-07 04:23:43'),
(71, 8, 62, 1, 1, NULL, 'bouteille', 2000, '2025-03-07', '2025-03-07 04:27:27', '2025-03-07 04:27:27'),
(72, 1, 63, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 04:31:36', '2025-03-07 04:31:36'),
(73, 1, 64, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 04:35:35', '2025-03-07 04:35:35'),
(74, 1, 65, 12, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:36:52', '2025-03-07 04:36:52'),
(75, 1, 66, 5, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:37:25', '2025-03-07 04:37:25'),
(76, 10, 67, 1, 1, NULL, 'cageot', 2300, '2025-03-07', '2025-03-07 04:40:38', '2025-03-07 04:40:38'),
(77, 1, 68, 8, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:42:40', '2025-03-07 04:42:40'),
(78, 1, 69, 8, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:44:53', '2025-03-07 04:44:53'),
(79, 1, 70, 6, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:45:20', '2025-03-07 04:45:20'),
(80, 1, 71, 5, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:45:53', '2025-03-07 04:45:53'),
(81, 1, 72, 8, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:47:54', '2025-03-07 04:47:54'),
(82, 1, 73, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 04:49:39', '2025-03-07 04:49:39'),
(83, 8, 74, 2, 1, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 04:51:19', '2025-03-07 04:51:19'),
(84, 1, 75, 1, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:51:50', '2025-03-07 04:51:50'),
(85, 7, 76, 2, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 04:54:34', '2025-03-07 04:54:34'),
(86, 1, 76, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 04:54:34', '2025-03-07 04:54:34'),
(87, 1, 77, 1, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 04:57:22', '2025-03-07 04:57:22'),
(88, 8, 78, 4, 1, NULL, 'bouteille', 2000, '2025-03-07', '2025-03-07 05:06:08', '2025-03-07 05:06:08'),
(89, 1, 79, 1, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 05:08:12', '2025-03-07 05:08:12'),
(90, 1, 80, 2, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 05:28:12', '2025-03-07 05:28:12'),
(91, 1, 81, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 05:29:06', '2025-03-07 05:29:06'),
(92, 9, 82, 2, 1, NULL, 'cageot', 1500, '2025-03-07', '2025-03-07 05:38:17', '2025-03-07 05:38:17'),
(93, 7, 83, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 06:08:43', '2025-03-07 06:08:43'),
(94, 1, 86, 4, 1, NULL, 'cageot', 4000, '2025-03-07', '2025-03-07 06:43:45', '2025-03-07 06:43:45'),
(95, 10, 87, 3, 1, NULL, 'cageot', 2300, '2025-03-07', '2025-03-07 06:47:10', '2025-03-07 06:47:10'),
(96, 10, 87, 4, 1, NULL, 'bouteille', 2300, '2025-03-07', '2025-03-07 06:47:10', '2025-03-07 06:47:10'),
(97, 1, 88, 1, 1, NULL, 'cageot', 4000, '2025-03-07', '2025-03-07 06:52:00', '2025-03-07 06:52:00'),
(98, 8, 89, 1, 1, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 06:58:02', '2025-03-07 06:58:02'),
(99, 8, 90, 1, 1, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 06:58:24', '2025-03-07 06:58:24'),
(100, 7, 91, 14, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 06:59:44', '2025-03-07 06:59:44'),
(101, 12, 92, 4, 0, NULL, 'bouteille', 2500, '2025-03-07', '2025-03-07 07:04:20', '2025-03-07 07:04:20'),
(102, 15, 93, 1, 1, NULL, 'cageot', 1500, '2025-03-07', '2025-03-07 07:06:06', '2025-03-07 07:06:06'),
(103, 7, 93, 17, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 07:06:06', '2025-03-07 07:06:06'),
(104, 10, 93, 2, 1, NULL, 'cageot', 2300, '2025-03-07', '2025-03-07 07:06:06', '2025-03-07 07:06:06'),
(105, 8, 94, 1, 0, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 07:20:14', '2025-03-07 07:20:14'),
(106, 11, 94, 1, 1, NULL, 'cageot', 2500, '2025-03-07', '2025-03-07 07:20:14', '2025-03-07 07:20:14'),
(107, 18, 96, 1, 0, NULL, 'cageot', 3948, '2025-03-07', '2025-03-07 07:29:42', '2025-03-07 07:29:42'),
(108, 18, 96, 1, 1, NULL, 'cageot', 3948, '2025-03-07', '2025-03-07 07:29:42', '2025-03-07 07:29:42'),
(109, 7, 97, 1, 0, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 08:15:04', '2025-03-07 08:15:04'),
(110, 7, 97, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 08:15:04', '2025-03-07 08:15:04'),
(111, 7, 98, 14, 0, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 08:17:05', '2025-03-07 08:17:05'),
(112, 7, 98, 14, 1, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 08:17:05', '2025-03-07 08:17:05'),
(113, 8, 99, 1, 0, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 08:35:41', '2025-03-07 08:35:41'),
(114, 8, 99, 1, 1, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 08:35:41', '2025-03-07 08:35:41'),
(115, 8, 99, 1, 0, NULL, 'cageot', 2000, '2025-03-07', '2025-03-07 08:35:41', '2025-03-07 08:35:41'),
(116, 8, 99, 2, 1, NULL, 'bouteille', 2000, '2025-03-07', '2025-03-07 08:35:41', '2025-03-07 08:35:41'),
(117, 8, 99, 2, 0, NULL, 'bouteille', 2000, '2025-03-07', '2025-03-07 08:35:41', '2025-03-07 08:35:41'),
(118, 14, 100, 1, 1, NULL, 'cageot', 3000, '2025-03-07', '2025-03-07 08:39:11', '2025-03-07 08:39:11'),
(119, 1, 101, 1, 0, NULL, 'cageot', 4000, '2025-03-07', '2025-03-07 08:40:04', '2025-03-07 08:40:04'),
(120, 1, 102, 1, 1, NULL, 'cageot', 4000, '2025-03-07', '2025-03-07 09:11:43', '2025-03-07 09:11:43'),
(121, 1, 103, 1, 0, NULL, 'cageot', 4000, '2025-03-07', '2025-03-07 09:12:09', '2025-03-07 09:12:09'),
(122, 1, 104, 14, 1, NULL, 'bouteille', 4000, '2025-03-07', '2025-03-07 09:12:59', '2025-03-07 09:12:59'),
(123, 7, 105, 1, 0, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 09:19:57', '2025-03-07 09:19:57'),
(124, 7, 105, 1, 1, NULL, 'cageot', 1200, '2025-03-07', '2025-03-07 09:19:57', '2025-03-07 09:19:57'),
(125, 1, 107, 1, 0, NULL, 'cageot', 4000, '2025-03-07', '2025-03-07 09:28:02', '2025-03-07 09:28:02'),
(126, 10, 107, 6, 0, NULL, 'bouteille', 2300, '2025-03-07', '2025-03-07 09:28:02', '2025-03-07 09:28:02'),
(127, 9, 108, 4, 0, NULL, 'cageot', 1500, '2025-03-07', '2025-03-07 10:18:54', '2025-03-07 10:18:54'),
(128, 7, 108, 14, 0, NULL, 'bouteille', 1200, '2025-03-07', '2025-03-07 10:18:54', '2025-03-07 10:18:54'),
(129, 15, 108, 2, 0, NULL, 'cageot', 1500, '2025-03-07', '2025-03-07 10:18:54', '2025-03-07 10:18:54');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achats`
--
ALTER TABLE `achats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `fournisseur_id` (`fournisseur_id`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `commandes_ibfk_2` (`user_id`);

--
-- Index pour la table `consignations`
--
ALTER TABLE `consignations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vente_achat_id` (`vente_id`);

--
-- Index pour la table `consignation_achats`
--
ALTER TABLE `consignation_achats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achat_id` (`achat_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `payements`
--
ALTER TABLE `payements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `article_id` (`article_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achats`
--
ALTER TABLE `achats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT pour la table `consignations`
--
ALTER TABLE `consignations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `consignation_achats`
--
ALTER TABLE `consignation_achats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `payements`
--
ALTER TABLE `payements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achats`
--
ALTER TABLE `achats`
  ADD CONSTRAINT `achats_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `achats_ibfk_2` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `achats_ibfk_3` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `consignations`
--
ALTER TABLE `consignations`
  ADD CONSTRAINT `consignations_ibfk_1` FOREIGN KEY (`vente_id`) REFERENCES `ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `consignation_achats`
--
ALTER TABLE `consignation_achats`
  ADD CONSTRAINT `consignation_achats_ibfk_1` FOREIGN KEY (`achat_id`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `payements`
--
ALTER TABLE `payements`
  ADD CONSTRAINT `payements_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `ventes_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventes_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
