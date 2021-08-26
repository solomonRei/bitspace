-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 26. Aug 2021 um 14:05
-- Server-Version: 8.0.24
-- PHP-Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bitspace`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `about`
--

CREATE TABLE `about` (
  `id` int UNSIGNED NOT NULL,
  `lang_id` int UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `about`
--

INSERT INTO `about` (`id`, `lang_id`, `text`, `phone`, `address`, `link`) VALUES
(1, 1, 'test', NULL, '', NULL),
(2, 2, 'gggg', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blogs`
--

CREATE TABLE `blogs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `in_main` tinyint(1) NOT NULL DEFAULT '0',
  `hits` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blogs_photos_lists`
--

CREATE TABLE `blogs_photos_lists` (
  `id` int NOT NULL,
  `blog_id` int NOT NULL,
  `file_id` int NOT NULL,
  `hits` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blogs_strings`
--

CREATE TABLE `blogs_strings` (
  `id` int UNSIGNED NOT NULL,
  `blog_id` int NOT NULL,
  `lang_id` tinyint(1) NOT NULL,
  `title` varchar(256) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` tinyint NOT NULL,
  `order_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `order_id`) VALUES
(1, 1),
(2, 3),
(3, 1),
(4, 1),
(5, 1),
(127, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories_strings`
--

CREATE TABLE `categories_strings` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `lang_id` tinyint(1) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `categories_strings`
--

INSERT INTO `categories_strings` (`id`, `category_id`, `lang_id`, `name`) VALUES
(1, 1, 1, 'Спикеры'),
(2, 1, 2, 'Speakers'),
(3, 1, 3, 'Спикеры'),
(4, 2, 1, 'Коучеры'),
(5, 2, 2, 'Couchers'),
(6, 2, 3, 'Коучеры'),
(7, 127, 1, 'Все'),
(8, 127, 2, 'Все'),
(9, 127, 3, 'Все'),
(10, 4, 1, 'Психологи'),
(11, 4, 2, 'Психологи'),
(12, 5, 1, 'Учителя'),
(13, 5, 2, 'Teachers'),
(14, 5, 3, 'Учителя');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chats`
--

CREATE TABLE `chats` (
  `id` int UNSIGNED NOT NULL,
  `user_1_id` int NOT NULL,
  `user_2_id` int NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `file_id` int NOT NULL,
  `contact_1_id` int NOT NULL,
  `contact_2_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cities`
--

CREATE TABLE `cities` (
  `id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `cities`
--

INSERT INTO `cities` (`id`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cities_strings`
--

CREATE TABLE `cities_strings` (
  `id` int UNSIGNED NOT NULL,
  `lang_id` tinyint NOT NULL,
  `city_id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `cities_strings`
--

INSERT INTO `cities_strings` (`id`, `lang_id`, `city_id`, `name`) VALUES
(1, 1, 1, 'Москва'),
(2, 2, 1, 'Moskow'),
(3, 3, 1, 'Москва'),
(4, 1, 2, 'Алма-Ата'),
(5, 2, 2, 'Almaty'),
(6, 3, 2, 'Алматы');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `conferences`
--

CREATE TABLE `conferences` (
  `id` int UNSIGNED NOT NULL,
  `user_id_owner` int NOT NULL,
  `user_id` int NOT NULL,
  `date_of_lesson` datetime NOT NULL,
  `type` enum('meet','zoom') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'meet - Google meet',
  `link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `join_url` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `conferences`
--

INSERT INTO `conferences` (`id`, `user_id_owner`, `user_id`, `date_of_lesson`, `type`, `link`, `join_url`, `password`, `created_at`, `updated_at`) VALUES
(17, 1, 2, '2021-05-03 20:00:00', 'zoom', 'https://us04web.zoom.us/s/72896091919?zak=eyJ6bV9za20iOiJ6bV9vMm0iLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJjbGllbnQiLCJ1aWQiOiJxX2t4YzdvaFRyYUlIcFZxUGx4WXFBIiwiaXNzIjoid2ViIiwic3R5IjoxMDAsIndjZCI6InVzMDQiLCJjbHQiOjAsInN0ayI6InpZeWhwdVROSDZibUZxYmtlOGs1UWY2TEtmV1N6UW5ZVlEzeEh4cGFDUHMuQmdZc1RVTnVZVmh2YWtSdFlURnlkRXBDYlU5bGJqQXpRMW92TjNkeVVWRkROazF6UTB4d2JuQkZPRFJxVFQxQU5tVmxOelZrTlRBNE56YzRZekU1WlRjelptSmlOR1JpT1RVeE5UbG1ZV1UzTXpBME16QXhOR1prWm1FMU1EVXlOV1UzTVRFMU56UmlaalppTkRBMVpBQU1NME5DUVhWdmFWbFRNM005QUFSMWN6QTBBQUFCZVIxeXNzVUFFblVBQUFBIiwiZXhwIjoxNjE5NzAzOTI2LCJpYXQiOjE2MTk2OTY3MjYsImFpZCI6InlSMGlLd09mVHB1VWZiOG1YcEFJYWciLCJjaWQiOiIifQ.hiu-6U5bdfwqOTEotsnHYFJJyf5DRbb7G0rUOASm4rs', 'https://us04web.zoom.us/j/72896091919?pwd=Y0FBK2ZHWkpEeVl6akhKQVpCTTdJUT09', 'NlO3A5d6', '2021-04-29 08:45:27', '2021-04-29 08:45:27'),
(18, 1, 2, '2021-04-30 07:00:00', 'zoom', 'https://us04web.zoom.us/s/71452431096?zak=eyJ6bV9za20iOiJ6bV9vMm0iLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJjbGllbnQiLCJ1aWQiOiJxX2t4YzdvaFRyYUlIcFZxUGx4WXFBIiwiaXNzIjoid2ViIiwic3R5IjoxMDAsIndjZCI6InVzMDQiLCJjbHQiOjAsInN0ayI6ImFCaWRRaV9FVVhZaGNHOTM1UDRzS3dRYTdLeG5FVUJOakR5S2dLSE05REkuQmdZc1RVTnVZVmh2YWtSdFlURnlkRXBDYlU5bGJqQXpRMW92TjNkeVVWRkROazF6UTB4d2JuQkZPRFJxVFQxQU5tVmxOelZrTlRBNE56YzRZekU1WlRjelptSmlOR1JpT1RVeE5UbG1ZV1UzTXpBME16QXhOR1prWm1FMU1EVXlOV1UzTVRFMU56UmlaalppTkRBMVpBQU1NME5DUVhWdmFWbFRNM005QUFSMWN6QTBBQUFCZVIxemxyQUFFblVBQUFBIiwiZXhwIjoxNjE5NzAzOTg1LCJpYXQiOjE2MTk2OTY3ODUsImFpZCI6InlSMGlLd09mVHB1VWZiOG1YcEFJYWciLCJjaWQiOiIifQ.JylugA8Sz5VjkNxWd_0IffgwGMSR6q2Pral7TOfj8KI', 'https://us04web.zoom.us/j/71452431096?pwd=enZJT3lOZ2Qwakh3cmxhamhXTmNjUT09', 'rfsBayJG', '2021-04-29 08:46:25', '2021-04-29 08:46:25'),
(19, 1, 2, '2021-05-04 21:00:00', 'zoom', 'https://us04web.zoom.us/s/77795736334?zak=eyJ6bV9za20iOiJ6bV9vMm0iLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJjbGllbnQiLCJ1aWQiOiJxX2t4YzdvaFRyYUlIcFZxUGx4WXFBIiwiaXNzIjoid2ViIiwic3R5IjoxMDAsIndjZCI6InVzMDQiLCJjbHQiOjAsInN0ayI6ImJOTVNReGgtSGlkRVpzbzhFdER3R0czMF96Y3BHalZNZjFWLTlxRUZ0dE0uQmdZc1RVTnVZVmh2YWtSdFlURnlkRXBDYlU5bGJqQXpRMW92TjNkeVVWRkROazF6UTB4d2JuQkZPRFJxVFQxQU5tVmxOelZrTlRBNE56YzRZekU1WlRjelptSmlOR1JpT1RVeE5UbG1ZV1UzTXpBME16QXhOR1prWm1FMU1EVXlOV1UzTVRFMU56UmlaalppTkRBMVpBQU1NME5DUVhWdmFWbFRNM005QUFSMWN6QTBBQUFCZVIzSDNpd0FFblVBQUFBIiwiZXhwIjoxNjE5NzA5NTA4LCJpYXQiOjE2MTk3MDIzMDgsImFpZCI6InlSMGlLd09mVHB1VWZiOG1YcEFJYWciLCJjaWQiOiIifQ.NidieRVRiD5p8OJcC50NgyVd8ChgrmKNqKMTxmgMesQ', 'https://us04web.zoom.us/j/77795736334?pwd=WitrbUdEN0VLeGlyQ3diZlY5Zy93Zz09', 'JLXjLvB6', '2021-04-29 10:18:29', '2021-04-29 10:18:29'),
(20, 1, 2, '2021-05-05 21:00:00', 'zoom', 'https://us04web.zoom.us/s/74055786130?zak=eyJ6bV9za20iOiJ6bV9vMm0iLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJjbGllbnQiLCJ1aWQiOiJxX2t4YzdvaFRyYUlIcFZxUGx4WXFBIiwiaXNzIjoid2ViIiwic3R5IjoxMDAsIndjZCI6InVzMDQiLCJjbHQiOjAsInN0ayI6Im5JXzVManNuMnZDN3N5aFpVMkozQUMwRnZjMGNDaHhobzhDSUpveWthN1kuQmdZc1RVTnVZVmh2YWtSdFlURnlkRXBDYlU5bGJqQXpRMW92TjNkeVVWRkROazF6UTB4d2JuQkZPRFJxVFQxQU5tVmxOelZrTlRBNE56YzRZekU1WlRjelptSmlOR1JpT1RVeE5UbG1ZV1UzTXpBME16QXhOR1prWm1FMU1EVXlOV1UzTVRFMU56UmlaalppTkRBMVpBQU1NME5DUVhWdmFWbFRNM005QUFSMWN6QTBBQUFCZVNnNkJKMEFFblVBQUFBIiwiZXhwIjoxNjE5ODg0NzYxLCJpYXQiOjE2MTk4Nzc1NjEsImFpZCI6InlSMGlLd09mVHB1VWZiOG1YcEFJYWciLCJjaWQiOiIifQ.fmYPkdVYzlehdUqmCXMX3IC0tX3CVvXHURyksolVH4c', 'https://us04web.zoom.us/j/74055786130?pwd=c2NRdUFEQzE4VTZrb0dEb3BjY2dWQT09', 'DkTgnya6', '2021-05-01 10:59:22', '2021-05-01 10:59:22');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contacts`
--

CREATE TABLE `contacts` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `contact_id` int UNSIGNED NOT NULL,
  `count_messages` int NOT NULL DEFAULT '0',
  `count_not_read_messages` int NOT NULL DEFAULT '0',
  `last_at` timestamp NULL DEFAULT NULL,
  `last_message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `conference_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` enum('user','system') NOT NULL DEFAULT 'user',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `events`
--

INSERT INTO `events` (`id`, `user_id`, `conference_id`, `title`, `type`, `start`, `end`, `created_at`, `updated_at`) VALUES
(37, 1, 17, 'Запланирован урок', 'system', '2021-05-04 13:00:00', '2021-05-04 13:30:00', '2021-04-29 08:45:27', '2021-04-29 08:45:27'),
(38, 2, 17, 'Запланирован урок', 'system', '2021-05-04 13:00:00', '2021-05-04 13:30:00', '2021-04-29 08:45:27', '2021-04-29 08:45:27'),
(39, 1, 18, 'Запланирован урок', 'system', '2021-04-30 00:00:00', '2021-05-01 00:00:00', '2021-04-29 08:46:25', '2021-04-29 08:46:25'),
(40, 2, 18, 'Запланирован урок', 'system', '2021-04-30 00:00:00', '2021-05-01 00:00:00', '2021-04-29 08:46:26', '2021-04-29 08:46:26'),
(41, 1, NULL, 'поездку', 'user', '2021-05-01 10:30:00', '2021-05-01 11:00:00', '2021-04-29 10:16:40', '2021-04-29 10:16:40'),
(42, 1, 19, 'Запланирован урок', 'system', '2021-05-05 14:00:00', '2021-05-05 14:30:00', '2021-04-29 10:18:29', '2021-04-29 10:18:29'),
(43, 2, 19, 'Запланирован урок', 'system', '2021-05-05 14:00:00', '2021-05-05 14:30:00', '2021-04-29 10:18:29', '2021-04-29 10:18:29'),
(44, 1, 20, 'Запланирован урок', 'system', '2021-05-06 14:00:00', '2021-05-06 14:30:00', '2021-05-01 10:59:22', '2021-05-01 10:59:22'),
(45, 2, 20, 'Запланирован урок', 'system', '2021-05-06 14:00:00', '2021-05-06 14:30:00', '2021-05-01 10:59:22', '2021-05-01 10:59:22');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `files`
--

CREATE TABLE `files` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `filename` varchar(32) NOT NULL,
  `file_path` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `hits` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `files`
--

INSERT INTO `files` (`id`, `user_id`, `filename`, `file_path`, `type`, `visible`, `hits`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 1, '1618816092_hAEi4.jpeg', 'storage/user_1/files/1618816092_hAEi4.jpeg', 1, 1, 0, '2021-04-19 04:08:12', '2021-04-19 04:08:12', NULL),
(15, 1, '1618816093_o7yJ9.jpeg', 'storage/user_1/files/1618816093_o7yJ9.jpeg', 1, 1, 0, '2021-04-19 04:08:13', '2021-04-19 11:16:12', '2021-04-19 11:16:12'),
(16, 1, '1618818989_Segog.jpeg', 'storage/user_1/files/1618818989_Segog.jpeg', 1, 1, 0, '2021-04-19 04:56:29', '2021-04-19 11:15:14', '2021-04-19 11:15:14'),
(17, 1, '1618823941_nPzZ4.jpeg', 'storage/user_1/presentation/1618823941_nPzZ4.jpeg', 2, 1, 0, '2021-04-19 06:19:01', '2021-04-19 06:50:50', '2021-04-19 06:50:50'),
(18, 1, '1618824150_H2PgX.jpeg', 'storage/user_1/presentation/1618824150_H2PgX.jpeg', 2, 1, 0, '2021-04-19 06:22:30', '2021-04-19 06:50:50', '2021-04-19 06:50:50'),
(19, 1, '1618824316_LCfVI.jpeg', 'storage/user_1/presentation/1618824316_LCfVI.jpeg', 2, 1, 0, '2021-04-19 06:25:16', '2021-04-19 06:50:50', '2021-04-19 06:50:50'),
(20, 1, '1618824657_iztT1.jpeg', 'storage/user_1/presentation/1618824657_iztT1.jpeg', 2, 1, 0, '2021-04-19 06:30:57', '2021-04-19 06:50:50', '2021-04-19 06:50:50'),
(23, 1, '1618830813_V1Q8i.png', 'storage/user_1/presentation/1618830813_V1Q8i.png', 2, 1, 0, '2021-04-19 08:13:33', '2021-04-19 08:13:33', NULL),
(24, 1, '1618830902_GABU5.jpg', 'storage/user_1/presentation/1618830902_GABU5.jpg', 2, 1, 0, '2021-04-19 08:15:02', '2021-04-19 08:15:02', NULL),
(25, 1, '1618833509_Gbiju.jpg', 'storage/user_1/presentation/1618833509_Gbiju.jpg', 2, 1, 0, '2021-04-19 08:58:29', '2021-04-19 15:29:24', '2021-04-19 15:29:24'),
(26, 1, '1618841487_SpU8H.jpg', 'storage/user_1/files/1618841487_SpU8H.jpg', 1, 1, 0, '2021-04-19 11:11:27', '2021-04-19 11:17:52', '2021-04-19 11:17:52'),
(27, 1, '1618841879_rp9OT.jpg', 'storage/user_1/files/1618841879_rp9OT.jpg', 1, 1, 0, '2021-04-19 11:17:59', '2021-04-19 11:22:54', '2021-04-19 11:22:54'),
(28, 1, '1618842185_27K3T.jpg', 'storage/user_1/files/1618842185_27K3T.jpg', 1, 1, 0, '2021-04-19 11:23:05', '2021-04-19 11:23:05', NULL),
(29, 1, '1618842185_Q5Yc8.jpg', 'storage/user_1/files/1618842185_Q5Yc8.jpg', 1, 1, 0, '2021-04-19 11:23:05', '2021-04-29 10:13:01', '2021-04-29 10:13:01'),
(30, 1, '1618857022_lg5Wu.jpg', 'storage/user_1/presentation/1618857022_lg5Wu.jpg', 2, 1, 0, '2021-04-19 15:30:22', '2021-04-19 15:30:22', NULL),
(35, 1, '1619102764_0PK9W.jpg', 'storage/user_1/ava/1619102764_0PK9W.jpg', 3, 1, 0, '2021-04-22 11:46:04', '2021-04-22 11:46:04', NULL),
(36, 2, '1619442281_xmAg0.png', 'storage/user_2/ava/1619442281_xmAg0.png', 3, 1, 0, '2021-04-26 10:04:41', '2021-04-26 10:04:41', NULL),
(37, 1, '1619442462_WS4hn.png', 'storage/user_1/presentation/1619442462_WS4hn.png', 2, 1, 0, '2021-04-26 10:07:42', '2021-04-26 10:07:42', NULL),
(38, 1, '1619442531_x4WBj.jpg', 'storage/user_1/files/1619442531_x4WBj.jpg', 1, 1, 0, '2021-04-26 10:08:51', '2021-04-26 10:09:21', '2021-04-26 10:09:21'),
(39, 1, '1619442531_ygjj4.jpg', 'storage/user_1/files/1619442531_ygjj4.jpg', 1, 1, 0, '2021-04-26 10:08:51', '2021-04-26 10:09:29', '2021-04-26 10:09:29'),
(40, 1, '1619442532_PNp5f.jpg', 'storage/user_1/files/1619442532_PNp5f.jpg', 1, 1, 0, '2021-04-26 10:08:52', '2021-04-26 10:09:22', '2021-04-26 10:09:22'),
(41, 1, '1619442532_HD6Bw.png', 'storage/user_1/files/1619442532_HD6Bw.png', 1, 1, 0, '2021-04-26 10:08:52', '2021-04-26 10:09:20', '2021-04-26 10:09:20'),
(42, 1, '1619701902_yYCoA.jpg', 'storage/user_1/presentation/1619701902_yYCoA.jpg', 2, 1, 0, '2021-04-29 10:11:42', '2021-04-29 10:11:42', NULL),
(43, 1, '1619701968_B0lhc.jpg', 'storage/user_1/files/1619701968_B0lhc.jpg', 1, 1, 0, '2021-04-29 10:12:48', '2021-04-29 10:12:48', NULL),
(44, 1, '1619701968_tG1CV.jpg', 'storage/user_1/files/1619701968_tG1CV.jpg', 1, 1, 0, '2021-04-29 10:12:48', '2021-04-29 10:13:13', '2021-04-29 10:13:13'),
(45, 1, '1619701968_Ps75R.jpg', 'storage/user_1/files/1619701968_Ps75R.jpg', 1, 1, 0, '2021-04-29 10:12:48', '2021-04-29 10:12:48', NULL),
(46, 1, '1619701968_ywEWh.png', 'storage/user_1/files/1619701968_ywEWh.png', 1, 1, 0, '2021-04-29 10:12:48', '2021-04-29 10:12:48', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `files_strings`
--

CREATE TABLE `files_strings` (
  `id` int NOT NULL,
  `file_id` int NOT NULL,
  `lang_id` tinyint(1) NOT NULL,
  `filename` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `filename_full` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `desc` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `files_strings`
--

INSERT INTO `files_strings` (`id`, `file_id`, `lang_id`, `filename`, `filename_full`, `desc`) VALUES
(1, 19, 1, NULL, NULL, NULL),
(2, 20, 1, NULL, NULL, NULL),
(3, 21, 1, NULL, NULL, NULL),
(4, 22, 1, NULL, NULL, NULL),
(5, 23, 2, NULL, NULL, NULL),
(6, 24, 1, NULL, NULL, NULL),
(7, 25, 1, NULL, NULL, NULL),
(8, 30, 1, NULL, NULL, NULL),
(9, 37, 1, NULL, NULL, NULL),
(10, 42, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE `groups` (
  `id` int UNSIGNED NOT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `groups`
--

INSERT INTO `groups` (`id`, `is_hidden`) VALUES
(1, 0),
(2, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups_strings`
--

CREATE TABLE `groups_strings` (
  `id` int UNSIGNED NOT NULL,
  `group_id` int UNSIGNED NOT NULL,
  `lang_id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `groups_strings`
--

INSERT INTO `groups_strings` (`id`, `group_id`, `lang_id`, `name`) VALUES
(1, 1, 1, 'Взрослые'),
(2, 1, 2, 'adults'),
(3, 1, 3, 'ересектер'),
(4, 2, 1, 'До 30 лет'),
(5, 2, 2, 'Up to 30 years old'),
(6, 2, 3, '30 жасқа дейін');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `languages`
--

CREATE TABLE `languages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(3) NOT NULL,
  `text` varchar(50) NOT NULL,
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `languages`
--

INSERT INTO `languages` (`id`, `name`, `text`, `main`, `visible`) VALUES
(1, 'ru', 'Русский', 1, 1),
(2, 'en', 'English', 0, 1),
(3, 'kz', 'Қазақ', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_02_22_102425_menu', 1),
(5, '2021_03_30_140057_create_articles_table', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `notifications`
--

CREATE TABLE `notifications` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type` varchar(256) NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `notifications_strings`
--

CREATE TABLE `notifications_strings` (
  `id` int UNSIGNED NOT NULL,
  `notification_id` int UNSIGNED NOT NULL,
  `lang_id` int NOT NULL,
  `message` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reviews`
--

CREATE TABLE `reviews` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `name` varchar(256) NOT NULL,
  `comment` varchar(1024) NOT NULL,
  `stars` int NOT NULL DEFAULT '1',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_complaint` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `name`, `comment`, `stars`, `is_approved`, `is_complaint`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test Test', 'Все отлично', 5, 1, 0, '2021-04-05 10:58:23', '2021-04-05 10:58:23'),
(2, 2, 'Дмитрий Дмитрий', 'Все отлично', 4, 1, 0, '2021-04-26 06:51:51', '2021-04-26 06:51:51'),
(3, 1, 'Дмитрий Дмитрий 2', 'Ужасно', 3, 0, 0, '2021-04-26 06:51:51', '2021-04-26 06:51:51');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags_strings`
--

CREATE TABLE `tags_strings` (
  `id` int NOT NULL,
  `blog_id` int NOT NULL,
  `lang_id` int NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int UNSIGNED DEFAULT '1',
  `group_id` int DEFAULT '1',
  `city_id` int UNSIGNED DEFAULT '1',
  `login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ava` int DEFAULT NULL,
  `balance` float NOT NULL DEFAULT '0',
  `type` tinyint NOT NULL DEFAULT '0',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fa2` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `online_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `socket_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `notification` tinyint(1) NOT NULL DEFAULT '0',
  `is_promoted` tinyint(1) NOT NULL DEFAULT '0',
  `is_promoted_directory` tinyint(1) NOT NULL DEFAULT '0',
  `is_hided` tinyint(1) NOT NULL DEFAULT '0',
  `is_searched` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `category_id`, `group_id`, `city_id`, `login`, `name`, `ava`, `balance`, `type`, `email`, `email_verified_at`, `password`, `remember_token`, `fa2`, `phone`, `map_url`, `phone_verified_at`, `online_at`, `socket_key`, `banned`, `notification`, `is_promoted`, `is_promoted_directory`, `is_hided`, `is_searched`, `is_deleted`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 1, 'developer', 'Lou King', 35, 0, 0, 'smed.developer@gmail.com', '2021-02-23 07:55:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'VE3GKv5zCjxkRpefuk6y1CXha9bBxGQemiozjI76ziOA7qUCKMjG6HKppdty', 0, NULL, NULL, NULL, '2021-03-18 10:57:49', '', 0, 0, 0, 0, 0, 0, 0, '2021-02-15 12:35:10', '2021-04-22 11:46:05', NULL),
(2, 2, 1, 0, 'test', 'test', 36, 0, 1, 'test55@mail.ru', '2021-02-23 07:55:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '18nQzG8ok1GbD2Z4zLLHXd0r9ChgRyO7IWv8by861j0WGP3NPHPISbY1ZVYU', 0, NULL, NULL, NULL, '2021-04-04 20:55:07', '', 0, 0, 0, 0, 0, 0, 0, '2021-02-15 12:35:10', '2021-04-29 07:44:00', NULL),
(3, 1, 1, 1, NULL, 'dariaAdmin', NULL, 0, 3, 'admin@admin.com', NULL, '$2y$10$MZp1KsLt6/Nppx4.M5xyauiKjS2DiLeEHM5qYhjB1B6n6bJz.v02S', NULL, 0, NULL, NULL, NULL, '2021-04-19 20:41:27', NULL, 0, 0, 0, 0, 0, 0, 0, '2021-04-19 17:41:27', '2021-04-19 17:41:27', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_strings`
--

CREATE TABLE `users_strings` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `lang_id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `education` varchar(1024) DEFAULT NULL,
  `directions` json DEFAULT NULL,
  `about` mediumtext,
  `mediafiles_url` json DEFAULT NULL,
  `age` int DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `users_strings`
--

INSERT INTO `users_strings` (`id`, `user_id`, `lang_id`, `name`, `surname`, `education`, `directions`, `about`, `mediafiles_url`, `age`, `experience`) VALUES
(1, 1, 1, 'Эдуард', 'Test', 'ГОС', '{\"data\": [\"php\", \"informatic\"]}', 'Привет, меня зовут Эдуард. Я бэкэнд-разработчик с 5-летним опытом работы. Я считаю, что мои сильные стороны - это разработка Скриптов/Ботов и Поиск багов.\r\n\r\nТакже есть опыт в создании CRM систем и веб-сайтов. Самое главное для меня - это удовлетворение ваших потребностей и сроков.\r\nКогда я работаю над новым проектом, я предпочитаю говорить с клиентом, чтобы у меня было четкое понимание его/ее потребностей и видения задачи / проекта. Также мне очень удобно создавать / работать с приложениями RESTful и CRUD.\r\n\r\nЗаранее спасибо за ваше время и внимание. Было бы здорово, чтобы работать с вами в ближайшее время.\r\n\r\nНиже перечислены мой опыт и навыки:\r\n❗ Backend Разр: WP, PHP, Laravel, ООП, MVC, HMVC и другие шаблоны, AJAX\r\n❗ FrontEnd: HTML5 / CSS3 (LESS / SASS), JavaScript (Jquery, Vue), Materialize css, JSON\r\n❗ SQL: MySQL,PostgreSQL\r\n❗ Cache: Redis, Memcached', '{\"presentation\": {\"url\": \"https://www.youtube.com/watch?v=Awh38GkIbUg\", \"file_id\": 42}}', 21, '2 года'),
(2, 1, 2, 'Eduard', 'Test', 'GOS', '{\"data\": [\"php\", \"informatic\"]}', 'Backend developer', '{\"presentation\": {\"url\": \"https://www.youtube.com/watch?v=Awh38GkIbUg\", \"file_id\": 23}}', 21, NULL),
(3, 2, 1, 'Дмитрий', 'Виноградов', 'Гос', '{\"data\": [\"php\", \"informatic\"]}', 'Разработчик', '{\"presentation\": {\"url\": \"test\", \"file_id\": null}}', 21, NULL),
(7, 1, 3, 'Test', 'Test', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2, 2, 'Test', 'Test', NULL, NULL, 'Разработчик', NULL, NULL, NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `blogs_photos_lists`
--
ALTER TABLE `blogs_photos_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `blogs_strings`
--
ALTER TABLE `blogs_strings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `categories_strings`
--
ALTER TABLE `categories_strings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cities_strings`
--
ALTER TABLE `cities_strings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `conferences`
--
ALTER TABLE `conferences`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indizes für die Tabelle `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `files_strings`
--
ALTER TABLE `files_strings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `groups_strings`
--
ALTER TABLE `groups_strings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `notifications_strings`
--
ALTER TABLE `notifications_strings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indizes für die Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indizes für die Tabelle `users_strings`
--
ALTER TABLE `users_strings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `about`
--
ALTER TABLE `about`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `blogs_photos_lists`
--
ALTER TABLE `blogs_photos_lists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `blogs_strings`
--
ALTER TABLE `blogs_strings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT für Tabelle `categories_strings`
--
ALTER TABLE `categories_strings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `cities_strings`
--
ALTER TABLE `cities_strings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `conferences`
--
ALTER TABLE `conferences`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT für Tabelle `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT für Tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `files`
--
ALTER TABLE `files`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT für Tabelle `files_strings`
--
ALTER TABLE `files_strings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `groups_strings`
--
ALTER TABLE `groups_strings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `notifications_strings`
--
ALTER TABLE `notifications_strings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `users_strings`
--
ALTER TABLE `users_strings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
