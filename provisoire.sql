-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 04 mars 2025 à 15:37
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(10, 7, 14, 1, 14, '2025-03-04', 5000, '2025-03-04 10:24:52', '2025-03-04 10:24:52');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `categorie_id` int DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `reference` varchar(20) DEFAULT NULL,
  `imagep` varchar(200) DEFAULT NULL,
  `prix_unitaire` int NOT NULL,
  `prix_consignation` int DEFAULT NULL,
  `prix_conditionne` int DEFAULT NULL,
  `quantite` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `categorie_id`, `nom`, `reference`, `imagep`, `prix_unitaire`, `prix_consignation`, `prix_conditionne`, `quantite`, `created_at`, `updated_at`) VALUES
(1, 3, 'pilsener 65 cl', NULL, NULL, 1200, NULL, NULL, 10, '2025-03-02 11:02:32', '2025-03-02 11:02:32'),
(6, 1, 'PAS DE NOM', NULL, NULL, 2000, NULL, NULL, 2000, '2025-03-02 12:11:35', '2025-03-02 12:11:35'),
(7, 1, 'pilsener 33 cl', NULL, NULL, 1200, NULL, NULL, 300, '2025-03-04 02:37:04', '2025-03-04 02:37:04'),
(8, 3, 'gold  blanche', NULL, NULL, 2000, NULL, NULL, 2000, '2025-03-04 02:38:04', '2025-03-04 02:38:04'),
(9, 1, 'gold cannette 33 cl', NULL, NULL, 200, NULL, NULL, 15, '2025-03-04 02:39:03', '2025-03-04 02:39:03'),
(10, 6, 'queens 100 cl', NULL, NULL, 2300, NULL, NULL, 1500, '2025-03-04 02:50:31', '2025-03-04 02:50:31'),
(11, 6, 'queens 33 cl', NULL, NULL, 2000, NULL, NULL, 140, '2025-03-04 02:53:00', '2025-03-04 02:53:00'),
(12, 7, 'beau fort 33 cl', NULL, NULL, 2500, NULL, NULL, 6, '2025-03-04 02:54:05', '2025-03-04 02:54:05'),
(14, 2, 'fanta 100 cl', NULL, NULL, 3000, NULL, 20000, 145, '2025-03-04 04:37:41', '2025-03-04 04:37:41');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(20, 1, 1, NULL, '2025-03-04 15:08:18', '2025-03-04 15:08:18', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `consignations`
--

CREATE TABLE `consignations` (
  `id` int NOT NULL,
  `vente_achat_id` int NOT NULL,
  `prix` int NOT NULL,
  `etat` varchar(10) DEFAULT 'non rendu',
  `date_consignation` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
('rLO9n8tsAVHazaPy8BUuc11Ee5yHLVlfigFQ8nPS', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnE0cVpRR1pFUXZjWHQwdWhBMVBkR3oxZ1BCRDNCSWduaWxLNnh2diI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly9sb2NhbGhvc3QvcHJvdmlzb2lyZS9wdWJsaWMvYm9pc3NvbnMvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1741102626);

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
  `prix` int DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `article_id`, `commande_id`, `quantite`, `prix`, `date_sortie`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 200, 1200, '2025-03-12', '2025-03-02 12:13:25', '2025-03-02 12:13:25'),
(2, 6, 2, 600, 1500, '2025-03-12', '2025-04-01 12:13:53', '2025-03-02 12:13:53'),
(3, 12, 6, 17, 2000, '2025-03-04', '2025-03-04 08:08:32', '2025-03-04 08:08:32'),
(4, 10, 6, 25, 1000, '2025-03-04', '2025-03-04 08:08:32', '2025-03-04 08:08:32'),
(5, 10, 7, 28, 1000, '2025-03-04', '2025-03-04 08:09:53', '2025-03-04 08:09:53'),
(6, 12, 8, 15, 2000, '2025-03-04', '2025-03-04 08:11:12', '2025-03-04 08:11:12'),
(7, 14, 8, 36, 1500, '2025-03-04', '2025-03-04 08:11:12', '2025-03-04 08:11:12'),
(8, 1, 10, 14, 1200, '2025-03-04', '2025-03-04 08:13:47', '2025-03-04 08:13:47'),
(9, 8, 11, 12, 3000, '2025-03-04', '2025-03-04 10:13:45', '2025-03-04 10:13:45'),
(10, 8, 11, 5, 3000, '2025-03-04', '2025-03-04 10:13:45', '2025-03-04 10:13:45'),
(11, 10, 12, 5, 1000, '2025-03-04', '2025-03-04 10:14:18', '2025-03-04 10:14:18'),
(12, 8, 13, 1, 3000, '2025-03-04', '2025-03-04 10:19:32', '2025-03-04 10:19:32'),
(13, 14, 13, 14, 1500, '2025-03-04', '2025-03-04 10:19:32', '2025-03-04 10:19:32'),
(14, 7, 15, 8, 4000, '2025-03-04', '2025-03-04 10:25:12', '2025-03-04 10:25:12'),
(15, 1, 16, 17, 1200, '2025-03-04', '2025-03-04 10:26:18', '2025-03-04 10:26:18'),
(16, 11, 17, 17, 3200, '2025-03-04', '2025-03-04 10:33:18', '2025-03-04 10:33:18'),
(17, 7, 18, 7, 4000, '2025-03-04', '2025-03-04 10:51:55', '2025-03-04 10:51:55'),
(18, 9, 19, 90, 200, '2025-03-04', '2025-03-04 11:27:52', '2025-03-04 11:27:52'),
(19, 1, 20, 14, 1200, '2025-03-04', '2025-03-04 12:08:18', '2025-03-04 12:08:18');

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
  ADD KEY `vente_achat_id` (`vente_achat_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `consignations`
--
ALTER TABLE `consignations`
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `consignations_ibfk_1` FOREIGN KEY (`vente_achat_id`) REFERENCES `ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consignations_ibfk_2` FOREIGN KEY (`vente_achat_id`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
