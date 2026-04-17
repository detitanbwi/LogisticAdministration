-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2026 at 02:11 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u815717682_invoicing`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_rekenings`
--

CREATE TABLE `bank_rekenings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bank` varchar(255) NOT NULL,
  `no_rekening` varchar(255) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `saldo` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_rekenings`
--

INSERT INTO `bank_rekenings` (`id`, `nama_bank`, `no_rekening`, `nama_pemilik`, `saldo`, `created_at`, `updated_at`) VALUES
(1, 'Bank Central Asia', '0000000000', 'Perusahaan', 147111387, '2026-02-28 08:21:35', '2026-04-15 08:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('invoice-kapal-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:88:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"view.dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:9:\"view.role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"create.role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"edit.role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"delete.role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"export.role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"import.role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:10:\"print.role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:9:\"view.user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:11:\"create.user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:9:\"edit.user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:11:\"delete.user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"export.user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:11:\"import.user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:10:\"print.user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:13:\"view.customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:15:\"create.customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:13:\"edit.customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:15:\"delete.customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:15:\"export.customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"import.customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:14:\"print.customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"view.container\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:16:\"create.container\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"edit.container\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:16:\"delete.container\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:16:\"export.container\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:16:\"import.container\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:15:\"print.container\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:10:\"view.kapal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:12:\"create.kapal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:10:\"edit.kapal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"delete.kapal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:12:\"export.kapal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"import.kapal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:11:\"print.kapal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:11:\"view.tujuan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:13:\"create.tujuan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:11:\"edit.tujuan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:13:\"delete.tujuan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:13:\"export.tujuan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:13:\"import.tujuan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:12:\"print.tujuan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:12:\"view.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:14:\"create.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:12:\"edit.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:14:\"delete.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:14:\"export.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:14:\"import.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:13:\"print.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:25:\"print_per_invoice.invoice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:12:\"view.finance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:12:\"edit.finance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:22:\"view.kategori_keuangan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:24:\"create.kategori_keuangan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:22:\"edit.kategori_keuangan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:24:\"delete.kategori_keuangan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:24:\"export.kategori_keuangan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:24:\"import.kategori_keuangan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:23:\"print.kategori_keuangan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:18:\"view.rekening_bank\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:20:\"create.rekening_bank\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:18:\"edit.rekening_bank\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:20:\"delete.rekening_bank\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:20:\"export.rekening_bank\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:20:\"import.rekening_bank\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:19:\"print.rekening_bank\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:14:\"view.transaksi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:16:\"create.transaksi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:14:\"edit.transaksi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:16:\"delete.transaksi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:16:\"export.transaksi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:16:\"import.transaksi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:15:\"print.transaksi\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:11:\"view.hutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:13:\"create.hutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:11:\"edit.hutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:13:\"delete.hutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:13:\"export.hutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:13:\"import.hutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:12:\"print.hutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:12:\"view.piutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:14:\"create.piutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:12:\"edit.piutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:14:\"delete.piutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:14:\"export.piutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:14:\"import.piutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:13:\"print.piutang\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"Invoice\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:8:\"Direktur\";s:1:\"c\";s:3:\"web\";}}}', 1776426532);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `container`
--

CREATE TABLE `container` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_container` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kapal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `asal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tujuan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `etd` date DEFAULT NULL,
  `eta` date DEFAULT NULL,
  `tipe_kontainer` enum('20FT','40FT','40HC','45HC') DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `catatan_invoicing` text DEFAULT NULL,
  `catatan_finance` text DEFAULT NULL,
  `total_pembayaran_manual` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `container`
--

INSERT INTO `container` (`id`, `nomor_container`, `created_at`, `updated_at`, `kapal_id`, `asal_id`, `tujuan_id`, `etd`, `eta`, `tipe_kontainer`, `catatan`, `catatan_invoicing`, `catatan_finance`, `total_pembayaran_manual`) VALUES
(12, 'TAKU. 607121-8/P. 214268', '2026-03-26 07:14:41', '2026-04-04 02:22:50', 4, 11, 9, '2026-03-31', '2026-04-10', '40HC', NULL, NULL, NULL, 0.00),
(13, 'TAKU. 230633-5/P. 216541', '2026-03-30 02:28:36', '2026-03-30 02:28:36', 4, NULL, NULL, '2026-03-31', '2026-04-10', '20FT', NULL, NULL, NULL, 0.00),
(14, 'ICBU. 604716-8/P. 216761', '2026-03-30 08:10:08', '2026-04-04 03:16:47', 4, 11, 9, '2026-03-31', '2026-04-10', '40FT', NULL, NULL, NULL, 0.00),
(15, 'TAKU 606052-7/P.089602', '2026-03-30 10:42:29', '2026-04-04 09:24:42', 6, 11, 9, '2026-01-04', '2026-01-14', '40FT', NULL, NULL, NULL, 0.00),
(16, 'TAKU. 235233-0/P. 215186', '2026-04-02 03:56:02', '2026-04-04 03:24:10', 7, 11, 19, '2026-03-31', '2026-04-04', '20FT', NULL, NULL, NULL, 0.00),
(17, 'TAKU. 604368-5/P. 215075', '2026-04-02 09:34:15', '2026-04-04 03:03:54', 7, 11, 19, '2026-03-31', '2026-04-04', '40FT', NULL, NULL, NULL, 0.00),
(18, 'TAKU. 605889-6/P. 215602', '2026-04-06 03:35:07', '2026-04-08 04:29:52', 10, 11, 9, '2026-04-06', '2026-04-16', '40FT', NULL, NULL, NULL, 0.00),
(19, 'TAKU. 234098-3/P. 205554', '2026-04-06 04:46:19', '2026-04-06 04:46:19', 9, 11, 19, '2026-04-06', '2026-04-10', '20FT', NULL, NULL, NULL, 0.00),
(20, 'TAKU. 604016-1/P. 205076', '2026-04-07 04:25:22', '2026-04-08 04:30:23', 10, 11, 9, '2026-04-06', '2026-04-16', '40FT', NULL, NULL, NULL, 0.00),
(24, '-', '2026-04-10 07:13:21', '2026-04-10 07:13:21', 13, 11, 22, '2026-04-09', '2026-04-18', '20FT', NULL, NULL, NULL, 0.00),
(25, 'TAKU. 601133-2/P. 205555', '2026-04-10 10:04:23', '2026-04-13 02:54:23', 14, 11, 19, '2026-04-09', '2026-04-13', '40FT', NULL, NULL, NULL, 0.00),
(26, 'TAKU 246754-0', '2026-04-13 08:09:04', '2026-04-13 08:09:04', 17, 11, 20, '2026-04-15', '2026-04-19', '20FT', NULL, NULL, NULL, 0.00),
(28, 'TAKU 608371-2/ P.098959', '2026-04-13 09:15:44', '2026-04-13 09:15:44', 18, 11, 9, '2026-01-07', '2026-01-17', '40FT', NULL, NULL, NULL, 0.00),
(29, 'ICBU. 604998-3/P. 228234', '2026-04-14 05:05:43', '2026-04-14 05:05:43', 8, 11, 9, '2026-04-10', '2026-04-20', '40FT', NULL, NULL, NULL, 0.00),
(30, '0', '2026-04-14 05:40:01', '2026-04-14 05:40:01', 20, 11, 9, '2026-04-15', '2026-04-25', '40FT', NULL, NULL, NULL, 0.00),
(31, 'TAKU. 602204-4/P. 217145', '2026-04-14 07:19:09', '2026-04-14 07:19:09', 8, 11, 9, '2026-04-10', '2026-04-20', '40FT', NULL, NULL, NULL, 0.00),
(32, 'TAKU. 601356-7/P. 228237', '2026-04-14 11:34:43', '2026-04-14 11:34:43', 8, 11, 9, '2026-04-10', '2026-04-20', '40FT', NULL, NULL, NULL, 0.00),
(33, 'TAKU 601207-2/ P.232496', '2026-04-16 02:47:19', '2026-04-16 02:47:19', 20, 11, 9, '2026-04-15', '2026-04-25', '40FT', NULL, NULL, NULL, 0.00),
(34, 'TAKU 603639-3/ P.239321', '2026-04-16 04:00:46', '2026-04-16 06:29:44', 22, 11, 19, '2026-04-14', '2026-04-18', '40FT', 'DISINI ADA MUNTAHAN IMEXINDO 6801 = 18.083', 'DISINI ADA MUNTAHAN IMEXINDO 6801\r\n54 KOLI = 18.083', NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `container_operational_costs`
--

CREATE TABLE `container_operational_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `container_id` bigint(20) UNSIGNED NOT NULL,
  `komponen` varchar(255) DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_transfer` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `jabatan_pic` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `nama`, `no_hp`, `npwp`, `pic`, `jabatan_pic`, `alamat`, `catatan`, `created_at`, `updated_at`) VALUES
(23, 'PENCE', '082197717010', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-27 03:00:16', '2026-03-27 03:00:16'),
(31, 'PT.SAMUDRA MANDIRI SENTOSA/TUTI', '0811439952', NULL, NULL, NULL, 'BITUNG', NULL, '2026-03-27 04:41:16', '2026-03-27 04:41:16'),
(35, 'BUDI AFRIANSYAH', '087713650795', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-27 08:09:21', '2026-03-27 08:09:21'),
(36, 'OM FAHRI', '081219395673', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-27 08:10:10', '2026-03-27 08:10:10'),
(39, 'CATELYA EXPRESS ABADI', '085894316894', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-27 09:25:06', '2026-03-27 09:25:06'),
(40, 'CATELYA EXPRESS ABADI', '081356044999', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-27 10:03:22', '2026-03-27 10:03:22'),
(41, 'PT.LINTAS MEGANTARA', '08124876654', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 02:35:02', '2026-03-28 02:35:02'),
(44, 'PENCE', '082197717010', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 04:26:09', '2026-03-28 04:26:09'),
(45, 'PENCE', '082197717010', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 04:26:53', '2026-03-28 04:26:53'),
(46, 'KAMIL LOGISTIK', '083807331695', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 05:07:06', '2026-03-28 05:07:06'),
(47, 'KAMIL LOGISTIK', '082332603240', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 05:08:19', '2026-03-28 05:08:19'),
(48, 'PT.SAMUDRA MANDIRI SENTOSA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 06:51:08', '2026-03-28 06:51:08'),
(49, 'JAYA HARAPAN LESTARI', '081311303001', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 06:58:13', '2026-03-28 06:58:13'),
(50, 'PT.SEDERHANA KARYA JAYA', '082140451403', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 07:03:53', '2026-03-28 07:03:53'),
(51, 'BPK.RONNY', '081380828448', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 07:46:49', '2026-03-28 07:46:49'),
(52, 'SWISS BELL MANADO', '085340214890', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 07:48:12', '2026-03-28 07:48:12'),
(53, 'BPK.ELLIYAS', '081316464530', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 07:58:32', '2026-03-28 07:58:32'),
(54, 'ROSALIN PALAKO', '085399561605', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 08:00:06', '2026-03-28 08:00:06'),
(55, 'PT.INGGO MULTI NIAGA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 08:37:37', '2026-04-14 15:42:05'),
(56, 'PT.DWIPA MEGAH LESTARI', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 08:41:35', '2026-04-14 15:42:26'),
(57, 'PT.PACIFIK TUNA MANDIRI', '082188255331', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 08:51:43', '2026-03-28 08:51:43'),
(58, 'MUNGIL BARU', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 09:23:04', '2026-03-28 09:23:04'),
(59, 'KO.AKIONG', '081356536308', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 09:26:02', '2026-03-28 09:26:02'),
(60, 'PT.KREASI JAYA NUGRAHA', '08118122252', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-28 09:40:41', '2026-03-28 09:40:41'),
(61, 'PT.GALA JAYA MANDIRI', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-28 11:06:16', '2026-03-28 11:06:16'),
(62, 'PT.INGGO MULTI NIAGA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 02:00:48', '2026-03-30 02:00:48'),
(63, 'PT.LINTAS MEGANTARA', '08124876654', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 02:01:40', '2026-03-30 02:01:40'),
(64, 'KRISTIAN STANLEY', '082292150608', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 02:12:30', '2026-03-30 02:12:30'),
(65, 'PT.GALA JAYA MANDIRI', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 02:13:18', '2026-03-30 02:13:18'),
(66, 'YURIS', '087844513341', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 02:35:56', '2026-03-30 02:35:56'),
(67, 'TIFA TRANS', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 02:41:11', '2026-03-30 02:41:11'),
(68, 'HENRY', '081808959799', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 02:58:00', '2026-03-30 02:58:00'),
(69, 'HENRY', '081808959799', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 03:12:51', '2026-03-30 03:12:51'),
(70, 'PT.PORIS CIPTA INDONESIA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 04:13:31', '2026-03-30 04:13:31'),
(71, 'PT.SAMUDRA MANDIRI SENTOSA', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 04:20:06', '2026-03-30 04:20:06'),
(72, 'REIN RAAF', '0895806323201', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 04:28:28', '2026-03-30 04:28:28'),
(73, 'REIN RAAF', '0895806323201', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 04:35:58', '2026-03-30 04:35:58'),
(74, 'IBU KIKY', '0881017716414', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 05:25:15', '2026-03-30 05:25:15'),
(75, 'PAK.FAHRI', '081219395673', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 05:29:29', '2026-03-30 05:29:29'),
(76, 'PT.INDESSO NIAGATAMA', '02138639745', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 05:52:42', '2026-03-30 05:52:42'),
(77, 'TRANS JASA BARU EXPRESS', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 06:02:09', '2026-03-30 06:02:09'),
(78, 'BPK.ENAL', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 06:02:28', '2026-03-30 06:02:28'),
(79, 'PAK.NIRWAN', '081310840146', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 07:56:13', '2026-03-30 07:56:13'),
(80, 'MEILAND', '082298888829', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 08:00:11', '2026-03-30 08:00:11'),
(81, 'PT.IMEXINDO INTINIAGA', '087780011787', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 08:13:25', '2026-03-30 08:13:25'),
(82, 'HENDRA', '081318093844', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 08:16:09', '2026-03-30 08:16:09'),
(83, 'HENDRA', '081318093844', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 08:17:09', '2026-03-30 08:17:09'),
(84, 'GIANT LOGISTIK', '082112313396', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 08:33:06', '2026-03-30 08:33:06'),
(85, 'GCX.JOLLY', '081293771166', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 08:34:49', '2026-03-30 08:34:49'),
(86, 'CV.CIPTA GEMILANG TEKNIK', '08128108605', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 08:58:11', '2026-03-30 08:58:11'),
(87, 'TM.TRANSPORT/IBRAHIM', '081311446884', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 09:06:29', '2026-03-30 09:06:29'),
(88, 'PELNI SERVICE', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 09:08:05', '2026-03-30 09:08:05'),
(89, 'IBU LULU', '085242296412', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 09:15:42', '2026-03-30 09:15:42'),
(90, 'IBU LULU', '085242296412', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 09:16:29', '2026-03-30 09:16:29'),
(91, 'GILANG/BME', '089603794570', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 10:05:57', '2026-03-30 10:05:57'),
(92, 'PT.TELKOM AKSES', '085298359175', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 10:07:49', '2026-03-30 10:07:49'),
(93, 'BPK ACO', '081213120641', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 10:30:20', '2026-03-30 10:30:20'),
(94, 'BPK SUMARDIN', '085295610137', NULL, NULL, NULL, 'BITUNG', NULL, '2026-03-30 10:31:30', '2026-03-30 10:31:30'),
(95, 'PT. GLOBAL PAKETAMA EXPRESS', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-03-30 10:51:12', '2026-03-30 10:51:12'),
(96, 'INDOMARCO MANADO BARU', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-03-30 10:54:04', '2026-03-30 10:54:04'),
(97, 'H.INDRA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-02 08:46:32', '2026-04-02 08:46:32'),
(98, 'KOLONEL ROBINSON TALLUPADANG', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-02 08:48:27', '2026-04-02 08:48:27'),
(99, 'PT.LINTAS MEGANTARA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-02 09:08:17', '2026-04-02 09:08:17'),
(100, 'PT.LINTAS MEGANTARA', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-02 09:09:24', '2026-04-02 09:09:24'),
(101, 'CV.UNI SARANA MANDIRI', '081250254857', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-02 09:23:51', '2026-04-02 09:23:51'),
(102, 'PT.SION LOGISTIK', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-02 09:58:50', '2026-04-02 09:58:50'),
(103, 'PT.SION LOGISTIK', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-02 09:59:23', '2026-04-02 09:59:23'),
(104, 'PT.HUTAMA KARYA', '081289196523', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-02 10:06:21', '2026-04-02 10:06:21'),
(105, 'BPK.ANDIKA', '081355560199', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-02 10:07:27', '2026-04-02 10:07:27'),
(106, 'PT.PANCA BINA PERSADA', '082113747489', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-02 10:19:07', '2026-04-02 10:19:07'),
(107, 'PLTD TELLO/ROBI', '081318445294', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-02 10:19:52', '2026-04-02 10:19:52'),
(108, 'CV.CAHAYA BUANA NUSANTARA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-02 10:43:42', '2026-04-02 10:43:42'),
(109, 'CV.CAHAYA BUANA NUSANTARA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-03 10:03:19', '2026-04-03 10:03:19'),
(110, 'PT.PANCA AGRO NIAGA LESTARI', '08119629082', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:05:12', '2026-04-03 10:05:12'),
(111, 'PT.MULKY AGRO INDOTANI', '089654363174', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:13:04', '2026-04-03 10:13:04'),
(112, 'PT.WAHAS', '081314102548', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-03 10:19:27', '2026-04-03 10:19:27'),
(113, 'IBU MISDHA/MIRA', '082343973240', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:20:27', '2026-04-03 10:20:27'),
(114, 'BPK.EKO', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-03 10:32:27', '2026-04-03 10:32:27'),
(115, 'BPK.SUDIRMAN', '08114440788', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:33:10', '2026-04-03 10:33:10'),
(116, 'CV.MITRA NUSANTARA LOGISTIK', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-03 10:41:16', '2026-04-03 10:41:16'),
(117, 'PT.BUANA SUKSES SEJATI', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:42:33', '2026-04-03 10:42:33'),
(118, 'PT.BUANA SUKSES SEJATI', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:42:33', '2026-04-03 10:42:33'),
(119, 'PT.BUANA SUKSES SEJATI', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:42:33', '2026-04-03 10:42:33'),
(120, 'PT.BUANA SUKSES SEJATI', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:42:33', '2026-04-03 10:42:33'),
(121, 'PT.BUANA SUKSES SEJATI', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:42:33', '2026-04-03 10:42:33'),
(122, 'PT.INTI NIAGA UTAMA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-03 10:55:53', '2026-04-03 10:55:53'),
(123, 'PT.INDOMARCO PRISMATAMA', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 10:57:09', '2026-04-03 10:57:09'),
(124, 'PT.OGNESIA MULTI TANI', '085213281592', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-03 11:07:37', '2026-04-03 11:07:37'),
(125, 'FAHMI', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-04 02:52:01', '2026-04-04 02:52:01'),
(126, 'BAPENDA KOTA PALU', '085218257622', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-04 02:53:15', '2026-04-04 02:53:15'),
(127, 'PT.LINTAS NIAGA MANDIRI', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-04 03:10:38', '2026-04-04 03:10:38'),
(128, 'IMIP', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-04 03:11:23', '2026-04-04 03:11:23'),
(129, 'PT.LINTAS LOGISTIK CARGO', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-04 03:42:54', '2026-04-04 03:42:54'),
(130, 'PT.BERKAT ABADI', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-04 03:50:50', '2026-04-04 03:50:50'),
(131, 'PT.PRIMA LINTAS ABADI', '08111832917', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-04 04:02:41', '2026-04-04 04:02:41'),
(132, 'BPK.SAM', '081355934798', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-04 04:03:24', '2026-04-04 04:03:24'),
(133, 'BPK.ASRUDIN', '082394182322', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-04 04:09:38', '2026-04-04 04:09:38'),
(134, 'BPK.OBED SIKATTA RAMBA', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-04 04:22:59', '2026-04-04 04:22:59'),
(135, 'PT.KEMBAR JAYA ANUGRAH', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-04 05:29:44', '2026-04-04 05:29:44'),
(136, 'PT.KEMBAR JAYA ANUGRAH', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-04 05:30:24', '2026-04-04 05:30:24'),
(137, 'BPK.IVAN', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-06 03:37:35', '2026-04-06 03:37:35'),
(138, 'ARINI', '085240697406', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-06 03:38:42', '2026-04-06 03:38:42'),
(139, 'PT.GLOBAL PAKETAMA EXPRESS', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-06 05:06:32', '2026-04-06 05:06:32'),
(140, 'HWG ELIT MAKASSAR', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-06 05:07:31', '2026-04-06 05:07:31'),
(141, 'CV.HARAPAN AGRO MANDIRI', '081314565595', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-06 05:13:27', '2026-04-06 05:13:27'),
(142, 'BPK.ONAN', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-06 05:21:09', '2026-04-06 05:21:09'),
(143, 'PT.INDOMARCO PRISMATAMA', '0', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-07 03:06:41', '2026-04-07 03:06:41'),
(144, 'IQBAL HARUN DAULAY', '085368192433', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 03:35:46', '2026-04-07 03:35:46'),
(145, 'FIREPROTECT', '085176967040', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 03:42:35', '2026-04-07 03:42:35'),
(146, 'PT.ARSVENTRA MINING', '085216160607', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 03:44:08', '2026-04-07 03:44:08'),
(147, 'PT.ENTALPIA EROPA INDONESIA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 03:57:59', '2026-04-07 03:57:59'),
(148, 'CV.DAYA INTI KINERJA/HENRY', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 03:59:34', '2026-04-07 03:59:34'),
(149, 'SAJ/SYANE DIYEN', '0216284377', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 04:07:13', '2026-04-07 04:07:13'),
(150, 'AIRLINDO', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 04:07:42', '2026-04-07 04:07:42'),
(151, 'TIFA TRANS', '02143901808', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 04:17:02', '2026-04-07 04:17:02'),
(152, 'DEWA PUTU WIADNIYANA', '085298359175', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 04:18:07', '2026-04-07 04:18:07'),
(153, 'SIMRAN GORDYN', '085138748457', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 04:27:27', '2026-04-07 04:27:27'),
(154, 'HARAPAN BARU', '0811434305', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 04:28:39', '2026-04-07 04:28:39'),
(155, 'PERUMDA AIR MINUM DUA SAUDARA', '085216940244', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 04:33:13', '2026-04-07 04:33:13'),
(156, 'PT.STEFANY JAYA SENTOSA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 04:42:42', '2026-04-07 04:42:42'),
(157, 'PT.SETIA THENOCH', '0431862936', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 04:44:09', '2026-04-07 04:44:09'),
(158, 'ARIS/CNE', '081284977782', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 04:53:32', '2026-04-07 04:53:32'),
(159, 'IMRAN', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 04:53:57', '2026-04-07 04:53:57'),
(160, 'JUNINDO KARYA LOGISTIK', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 05:19:20', '2026-04-07 05:19:20'),
(161, 'PT.MEDCO POWER INDONESIA', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 05:21:17', '2026-04-07 05:21:17'),
(162, 'IBU SISKA', '08159133495', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 05:38:56', '2026-04-07 05:38:56'),
(163, 'PT.INDUSTRI KAPAL INDONESIA', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 05:40:05', '2026-04-07 05:40:05'),
(164, 'CV.PRIMA JAYA LESTARI', '081346218746', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 08:29:13', '2026-04-07 08:29:13'),
(165, 'PT.NIAGA RAYA TRANS BAHARI', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 09:39:14', '2026-04-07 09:39:14'),
(166, 'PT.UNITEDA ARKATO', '085817620040', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 09:40:58', '2026-04-07 09:40:58'),
(167, 'IBU ECHA TARA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-07 10:37:47', '2026-04-07 10:37:47'),
(168, 'IBU ECHA TARA', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 10:38:15', '2026-04-07 10:38:15'),
(169, 'KRISTIAN STANLEY', '082292150608', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-07 11:00:25', '2026-04-07 11:00:25'),
(170, 'PT.PANCA AGRO NIAGA LESTARI', '08119629082', NULL, NULL, NULL, 'KENDARI', NULL, '2026-04-08 04:16:19', '2026-04-08 04:16:19'),
(171, 'CV.HARAPAN AGRO MANDIRI', '081314565595', NULL, NULL, NULL, 'KENDARI', NULL, '2026-04-08 04:21:19', '2026-04-08 04:21:19'),
(172, 'PT.INDOMARCO PRISMATAMA', '0', NULL, NULL, NULL, 'TERNATE', NULL, '2026-04-08 04:35:37', '2026-04-08 04:35:37'),
(173, 'PT.INDOMARCO PRISMATAMA', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-08 04:38:56', '2026-04-08 04:38:56'),
(174, 'ARINI', '085240697406', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-08 04:42:45', '2026-04-08 04:42:45'),
(175, 'IBU LULU', '085242296412', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 04:45:24', '2026-04-08 04:45:24'),
(176, 'REIN RAAF', '0895806323201', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 04:48:02', '2026-04-08 04:48:02'),
(177, 'KO.AKIONG', '081356536308', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 04:52:10', '2026-04-08 04:52:10'),
(178, 'CV.DAYA INTI KINERJA/HENRY', '0', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 04:53:58', '2026-04-08 04:53:58'),
(179, 'KAPTEN INF A ROZAK', '081243112056', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 05:01:10', '2026-04-08 05:01:10'),
(180, 'PERUMDA AIR MINUM DUASAUDARA', '085216940244', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 05:08:54', '2026-04-08 05:08:54'),
(181, 'IMRAN', '0', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 05:11:51', '2026-04-08 05:11:51'),
(182, 'PT.MEDCO POWER INDONESIA', '0', NULL, NULL, NULL, 'BOLAANG, MONGONDOW', NULL, '2026-04-08 05:14:31', '2026-04-08 05:14:31'),
(183, 'PT.INDUSTRI KAPAL INDONESIA', '0', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 05:17:14', '2026-04-08 05:17:14'),
(184, 'CV.PRIMA JAYA LESTARI', '081346218746', NULL, NULL, NULL, 'GORONTALO', NULL, '2026-04-08 05:20:02', '2026-04-08 05:20:02'),
(185, 'KRISTIAN STANLEY', '082292150608', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 05:28:17', '2026-04-08 05:28:17'),
(186, 'PT.SUMBER KARUNIA SEJAHTERA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-08 06:35:00', '2026-04-08 06:35:00'),
(187, 'PT.SUMBER KARUNIA SEJAHTERA', '082193647175', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-08 06:36:10', '2026-04-08 06:36:10'),
(188, 'IBU MARGARETHA TAPELU', '081340348411', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-08 06:42:08', '2026-04-08 06:42:08'),
(189, 'ANSELMUS TAPELU', '081245739784', NULL, NULL, NULL, 'MINAHASA UTARA', NULL, '2026-04-08 06:43:08', '2026-04-08 06:43:08'),
(190, 'PAK.NANANG', '085283121457', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-08 06:47:32', '2026-04-08 06:47:32'),
(191, 'PAK.FANDI', '085215927770', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-08 06:48:16', '2026-04-08 06:48:16'),
(192, 'PT. BINTANG MARAGA', '085260266027', NULL, NULL, NULL, 'BEKASI', NULL, '2026-04-08 08:53:47', '2026-04-08 08:53:47'),
(193, 'ARYA SAPUTRA', '088246256609', NULL, NULL, NULL, 'BANJARMASIN', NULL, '2026-04-08 08:54:21', '2026-04-08 08:54:21'),
(194, 'MANDIRI JAYA TRANS', '081398384445', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-08 09:15:38', '2026-04-08 09:15:38'),
(195, 'PT. MIDI UTAMA INDONESIA', '\'082298803737', NULL, NULL, NULL, 'BANJARMASIN', NULL, '2026-04-08 09:16:18', '2026-04-08 09:16:18'),
(196, 'PT. BUKIT BIMA BATARA', '085260266027', NULL, NULL, NULL, 'DEPOK', NULL, '2026-04-08 09:21:41', '2026-04-08 09:21:41'),
(197, 'DYAS', '082151520166', NULL, NULL, NULL, 'BANJARBARU', NULL, '2026-04-08 09:22:04', '2026-04-08 09:22:04'),
(198, 'MAWALI', '081298159288', NULL, NULL, NULL, 'AMBON', NULL, '2026-04-08 09:35:48', '2026-04-08 09:35:48'),
(199, 'AIP / KO AKIONG', '081356536308', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-08 09:37:35', '2026-04-08 09:37:35'),
(200, 'PT. MITRA BORNEO/ EVI', '08115016178', NULL, NULL, NULL, 'BANJARBARU', NULL, '2026-04-08 09:47:40', '2026-04-08 09:47:40'),
(201, 'IBRAHIM', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-09 04:20:23', '2026-04-09 04:20:23'),
(202, 'IBRAHIM', '0', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-09 04:21:09', '2026-04-09 04:21:09'),
(203, 'PT.GENTAYU GEMA ABADI/PEGGY.W', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-09 04:52:39', '2026-04-09 04:52:39'),
(204, 'PT.GENTAYU GEMA ABADI/PEGGY.W', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-09 04:53:57', '2026-04-09 04:53:57'),
(205, 'PT.KEMBAR JAYA ANUGRAH', '0', NULL, NULL, NULL, 'GOWA', NULL, '2026-04-10 10:48:04', '2026-04-10 10:48:04'),
(206, 'PT. CHOKO ABADI', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-11 11:10:21', '2026-04-11 11:10:21'),
(207, 'BPK ANDRIAN', '085262569596', NULL, NULL, NULL, 'AMBON', NULL, '2026-04-11 11:10:49', '2026-04-11 11:10:49'),
(208, 'PT.ADRIAN TERMANU SEJAHTERA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 01:56:33', '2026-04-13 01:56:33'),
(209, 'BPK.KAMAL', '08118585967', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-13 01:57:10', '2026-04-13 01:57:10'),
(210, 'PT.BINTANG PASIFIK TEKNIK', '082112527333', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 02:00:49', '2026-04-13 02:00:49'),
(211, 'PT.SUKANDA DJAYA', '085341651265', NULL, NULL, NULL, 'MARUSU MAROS', NULL, '2026-04-13 02:01:54', '2026-04-13 02:01:54'),
(212, 'PT.BPK.GUNUNG MULIA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 02:05:56', '2026-04-13 02:05:56'),
(213, 'BPK.MUL', '081354811148', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-13 02:06:44', '2026-04-13 02:06:44'),
(214, 'CV.PUTRI ALAM JAYA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 02:16:07', '2026-04-13 02:16:07'),
(215, 'PT.SUMBER ALFARIA TRIJAYA', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-13 02:17:03', '2026-04-13 02:17:03'),
(216, 'BPK.FAHRUL', '085255257403', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-13 02:20:09', '2026-04-13 02:20:09'),
(217, 'INDOGROSIR KENDARI', '0', NULL, NULL, NULL, 'KENDARI', NULL, '2026-04-13 02:23:11', '2026-04-13 02:23:11'),
(218, 'INDOGROSIR MAKASSAR', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-13 02:33:51', '2026-04-13 02:33:51'),
(219, 'PT.PLN BONTOBAHARI', '0', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-13 02:41:22', '2026-04-13 02:41:22'),
(220, 'CV.UNI SARANA MANDIRI', '085333356925', NULL, NULL, NULL, 'PALOPO', NULL, '2026-04-13 02:46:43', '2026-04-13 02:46:43'),
(221, 'BPK DIMAS', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 02:51:40', '2026-04-13 02:51:40'),
(222, 'BPK DIMAS', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 02:51:40', '2026-04-13 02:51:40'),
(223, 'BPK DIMAS', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 02:51:40', '2026-04-13 02:51:40'),
(224, 'PT. DUNIA GORDEN', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 03:23:58', '2026-04-13 03:23:58'),
(225, 'HARAPAN BARU', '0431863757', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 03:25:16', '2026-04-13 03:25:16'),
(226, 'MANDIRI JAYA TRANS', '081398384445', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 03:33:38', '2026-04-13 03:33:38'),
(227, 'PT. ARMADA JAYA', '0', NULL, NULL, NULL, 'JAKARTA PUSAT', NULL, '2026-04-13 05:04:36', '2026-04-13 05:04:36'),
(228, 'GRAND KAWANUA INTERNASIONAL', '082227351465', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 05:05:31', '2026-04-13 05:05:31'),
(229, 'CALVIN', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 05:14:49', '2026-04-13 05:14:49'),
(230, 'CALVIN', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 05:15:06', '2026-04-13 05:15:06'),
(231, 'DAVID SOPUTAN', '082196334039', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 05:18:11', '2026-04-13 05:18:11'),
(232, 'DAVID SOPUTAN', '082196334039', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 05:18:37', '2026-04-13 05:18:37'),
(233, 'MATAHARI TRADE CENTER', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 05:21:38', '2026-04-13 05:21:38'),
(234, 'PT. MIDI UTAMA INDONESIA', '0', NULL, NULL, NULL, 'AMBON', NULL, '2026-04-13 07:38:23', '2026-04-13 07:38:23'),
(235, 'KAMIL LOGISTIK', '082312394088', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 08:42:20', '2026-04-13 08:42:20'),
(236, 'PT. DOVEN', '-', NULL, NULL, NULL, 'GORONTALO', NULL, '2026-04-13 09:04:46', '2026-04-13 09:04:46'),
(237, 'BPK.SIGIT', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 09:22:56', '2026-04-13 09:22:56'),
(238, 'BPK.SIGIT', '0', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-13 09:23:38', '2026-04-13 09:23:38'),
(239, 'CV. PUTRI ALAM JAYA', '081398384445', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 09:25:55', '2026-04-13 09:25:55'),
(240, 'WIN CARGO', '081285538955', NULL, NULL, NULL, 'BEKASI', NULL, '2026-04-13 09:29:39', '2026-04-13 09:29:39'),
(241, 'MEGA MAS MANADO', '0431879434', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-13 09:30:16', '2026-04-13 09:30:16'),
(242, 'PT.KIRIMAN LOGISTIK INDONESIA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-13 10:52:58', '2026-04-13 10:52:58'),
(243, 'PT.KIRIMAN LOGISTIK INDONESIA', '-', NULL, NULL, NULL, 'GORONTALO', NULL, '2026-04-13 10:53:55', '2026-04-13 10:53:55'),
(244, 'AIP', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 05:22:21', '2026-04-14 05:22:21'),
(245, 'KETY', '082114346335', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 05:24:52', '2026-04-14 05:24:52'),
(246, 'JUNIAR', '081287786684', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 05:25:38', '2026-04-14 05:25:38'),
(247, 'BPK.RAHMAN', '087788751911', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 05:31:27', '2026-04-14 05:31:27'),
(248, 'PT.GEOPERSADA MULIA ABADI', '082193999824', NULL, NULL, NULL, 'MINAHASA UTARA', NULL, '2026-04-14 05:33:00', '2026-04-14 05:33:00'),
(249, 'SJM', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 05:44:26', '2026-04-14 05:44:26'),
(250, 'AYUB TOBER TATULIANG', '085240468827', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 05:45:54', '2026-04-14 05:45:54'),
(251, 'PT.JAYA SENTOSA BERSAMA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 05:53:02', '2026-04-14 05:53:02'),
(252, 'BPK.DANNY MISSY', '082227279900', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 05:53:59', '2026-04-14 05:53:59'),
(253, 'PT.NIAGA RAYA TRANS BAHARI', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 06:01:55', '2026-04-14 06:01:55'),
(254, 'SEMANGAT BARU JAYA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 06:05:27', '2026-04-14 06:05:27'),
(255, 'KAMIL LOGISTIK', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 06:08:46', '2026-04-14 06:08:46'),
(256, 'KAMIL LOGISTIK', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 06:09:14', '2026-04-14 06:09:14'),
(257, 'SLN LOGISTIK', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 06:18:03', '2026-04-14 06:18:03'),
(258, 'SLN LOGISTIK', '012581581', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 06:18:53', '2026-04-14 06:18:53'),
(259, 'SLN LOGISTIK', '012581581', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 06:19:25', '2026-04-14 06:19:25'),
(260, 'PT.SUMBER ALFARIA TRIJAYA', '0', NULL, NULL, NULL, 'GORONTALO', NULL, '2026-04-14 06:28:59', '2026-04-14 06:28:59'),
(261, 'CV.GEMILANG TEKNIK', '08128108605', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 06:56:57', '2026-04-14 06:56:57'),
(262, 'BPK.YONGKI', '081211742848', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 07:30:41', '2026-04-14 07:30:41'),
(263, 'BPK.YONGKI', '081211742848', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 07:31:19', '2026-04-14 07:31:19'),
(264, 'SRYVINNI', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 07:42:22', '2026-04-14 07:42:22'),
(265, 'APIADI', '081315508886', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 07:47:52', '2026-04-14 07:47:52'),
(266, 'PT.BMB', '082188334122', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-14 07:48:26', '2026-04-14 07:48:26'),
(267, 'PT.BAHTERA LINTAS PERKASA', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 08:54:53', '2026-04-14 08:54:53'),
(268, 'BP.BAHRONI', '081374954235', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-14 08:55:47', '2026-04-14 08:55:47'),
(269, 'NYU LOGISTIK CARGO', '0', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 09:05:28', '2026-04-14 09:05:28'),
(270, 'BPK.IWAN', '0', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 09:06:32', '2026-04-14 09:06:32'),
(271, 'HENRY', '081808959799', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-14 09:41:18', '2026-04-14 09:41:18'),
(272, 'CV.BERKAH KAWAT', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 09:44:37', '2026-04-14 09:44:37'),
(273, 'BPK.DAVID LAMIA', '081340443218', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 09:45:36', '2026-04-14 09:45:36'),
(274, 'SKG/RUDI', '081380341554', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 09:53:25', '2026-04-14 09:53:25'),
(275, 'PT.INTI IDOLA ANUGERAH', '089695631153', NULL, NULL, NULL, 'MINAHASA UTARA', NULL, '2026-04-14 09:55:33', '2026-04-14 09:55:33'),
(276, 'PT.BAROKAH JAYA LOGISTIK', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 10:17:23', '2026-04-14 10:17:23'),
(277, 'PT.SUMBER ALFARIA TRIJAYA', '-', NULL, NULL, NULL, 'MINAHASA UTARA', NULL, '2026-04-14 10:18:38', '2026-04-14 10:18:38'),
(278, 'IBU ECHA TARA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 10:24:51', '2026-04-14 10:24:51'),
(279, 'IBU ECHA TARA', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 10:25:31', '2026-04-14 10:25:31'),
(280, 'AIRLINDO', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 11:14:03', '2026-04-14 11:14:03'),
(281, 'PT.BERKAT KIMIA MATERIAL', '081284977782', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 11:41:10', '2026-04-14 11:41:10'),
(282, 'BPK.MULIA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 11:47:16', '2026-04-14 11:47:16'),
(283, 'PAK.SONI', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 11:58:17', '2026-04-14 11:58:17'),
(284, 'PAK.SONI', '-', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-14 11:58:39', '2026-04-14 11:58:39'),
(285, 'KRAKATAU BAN CIKOKOL', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 12:03:48', '2026-04-14 12:03:48'),
(286, 'ISKANDAR MOJO', '081340019494', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-14 12:08:55', '2026-04-14 12:08:55'),
(287, 'ISKANDAR MOJO', '081340019494', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-14 12:09:36', '2026-04-14 12:09:36'),
(288, 'YOSEPA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 01:40:34', '2026-04-15 01:40:34'),
(289, 'BPK.HERIANTO', '0895406029954', NULL, NULL, NULL, 'GORONTALO', NULL, '2026-04-15 01:41:37', '2026-04-15 01:41:37'),
(290, 'KO.AKIONG', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 01:59:10', '2026-04-15 01:59:10'),
(291, 'IMRAN', '-', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-15 10:04:53', '2026-04-15 10:04:53'),
(292, 'AIP', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:08:08', '2026-04-15 10:08:08'),
(293, 'PT.SAMUDRA MANDIRI SENTOSA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:23:59', '2026-04-15 10:23:59'),
(294, 'SJM', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:25:55', '2026-04-15 10:25:55'),
(295, 'PT.JAYA SENTOSA BERSAMA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:33:41', '2026-04-15 10:33:41'),
(296, 'MUNGIL BARU', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:36:33', '2026-04-15 10:36:33'),
(297, 'PT.NIAGA RAYA TRANS BAHARI', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:39:01', '2026-04-15 10:39:01'),
(298, 'PT.NIAGA RAYA TRANS BAHARI', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-15 10:39:39', '2026-04-15 10:39:39'),
(299, 'SEMANGAT BARU JAYA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:41:21', '2026-04-15 10:41:21'),
(300, 'KAMIL LOGISTIK', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:42:59', '2026-04-15 10:42:59'),
(301, 'KAMIL LOGISTIK', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-15 10:43:23', '2026-04-15 10:43:23'),
(302, 'TRANS JASA BARU EXPRESS', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:44:54', '2026-04-15 10:44:54'),
(303, 'BPK.ENAL', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-15 10:45:36', '2026-04-15 10:45:36'),
(304, 'CV.PUTRI ALAM JAYA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 10:56:37', '2026-04-15 10:56:37'),
(305, 'PT.SUMBER ALFARIA TRIJAYA', '-', NULL, NULL, NULL, 'GORONTALO', NULL, '2026-04-15 10:57:58', '2026-04-15 10:57:58'),
(306, 'PT.INTI NIAGA UTAMA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 11:00:00', '2026-04-15 11:00:00'),
(307, 'INDOMARCO MANADO BARU', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-15 11:00:58', '2026-04-15 11:00:58'),
(308, 'SRYVINNI', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 11:10:12', '2026-04-15 11:10:12'),
(309, 'PT.BAHTERA LINTAS PERKASA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 11:13:23', '2026-04-15 11:13:23'),
(310, 'NYU LOGISTIK CARGO', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 11:16:02', '2026-04-15 11:16:02'),
(311, 'BPK.IWAN', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-15 11:16:26', '2026-04-15 11:16:26'),
(312, 'PT.GLOBAL PAKETAMA EXPRESS', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 11:19:54', '2026-04-15 11:19:54'),
(313, 'YOSEPA/BRAM LOGISTIK', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 13:08:00', '2026-04-15 13:08:00'),
(314, 'KOLONEL TEK SUFRON', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-15 13:14:56', '2026-04-15 13:14:56'),
(315, 'FAISAL T. SOEROTINOJO', '-', NULL, NULL, NULL, 'MANADO', NULL, '2026-04-15 13:16:14', '2026-04-15 13:16:14'),
(316, 'PT. ADIMAS ISOLASITAMA', '0216257888', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-16 02:49:09', '2026-04-16 02:49:09'),
(317, 'BPK JONLY', '082151138337', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-16 03:07:44', '2026-04-16 03:10:23'),
(318, 'BPK JONLY', '082151138337', NULL, NULL, NULL, 'TONDANO', NULL, '2026-04-16 03:11:06', '2026-04-16 03:11:06'),
(319, 'PRASUYA JAYA MANDIRI', '081360360667', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-16 04:01:36', '2026-04-16 04:01:36'),
(320, 'PRASUYA JAYA MANDIRI', '-', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-16 04:02:10', '2026-04-16 04:02:10'),
(321, 'SAE LOGISTIK / YOSEPA', '-', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-16 04:25:30', '2026-04-16 04:25:30'),
(322, 'PAK MADE', '0895426782572', NULL, NULL, NULL, 'KENDARI', NULL, '2026-04-16 04:26:57', '2026-04-16 04:26:57'),
(323, 'PAK DAVID', '0811453537', NULL, NULL, NULL, 'PALU SELATAN', NULL, '2026-04-16 05:40:59', '2026-04-16 05:40:59'),
(324, 'PAK DAUD', '0811453537', NULL, NULL, NULL, 'PALU SELATAN', NULL, '2026-04-16 05:46:46', '2026-04-16 06:03:37'),
(325, 'PENCE', '081289187708', NULL, NULL, NULL, 'KENDARI', NULL, '2026-04-16 05:51:04', '2026-04-16 05:51:04'),
(326, 'HELENS MAKASSAR', '082290738024', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-16 06:07:08', '2026-04-16 06:07:08'),
(327, 'PT. PERMATA ALAM SULAWESI', '082347877948', NULL, NULL, NULL, 'MAKASSAR', NULL, '2026-04-16 06:13:14', '2026-04-16 06:13:14'),
(328, 'GALAXY MULTI TRANS', '085215369993', NULL, NULL, NULL, 'JAKARTA', NULL, '2026-04-16 07:19:17', '2026-04-16 07:19:17'),
(329, 'GALAXY MULTI TRANS', '-', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-16 07:20:22', '2026-04-16 07:20:22'),
(330, 'PT. ASDP INDONESIA FERRY PERSERO', '082114777726', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-16 07:35:09', '2026-04-16 07:35:09'),
(331, 'PT. PUTRA DELIMA MANDIRI', '-', NULL, NULL, NULL, 'TANGERANG', NULL, '2026-04-16 07:39:29', '2026-04-16 07:39:29'),
(332, 'SMA TARUNA LANGOWAN', '087770437771', NULL, NULL, NULL, 'BITUNG', NULL, '2026-04-16 07:44:18', '2026-04-16 07:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

CREATE TABLE `finance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `total_tagihan` decimal(15,2) NOT NULL,
  `ditagih_ke` enum('Pengirim','Penerima') NOT NULL,
  `status_tagihan` enum('Sudah ditagih','Belum') NOT NULL DEFAULT 'Belum',
  `tanggal_tagih` date DEFAULT NULL,
  `tgl_transfer` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bap_balik` varchar(255) DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance`
--

INSERT INTO `finance` (`id`, `invoice_id`, `total_tagihan`, `ditagih_ke`, `status_tagihan`, `tanggal_tagih`, `tgl_transfer`, `catatan`, `created_at`, `updated_at`, `bap_balik`) VALUES
(20, 20, 2339049.60, 'Penerima', 'Sudah ditagih', '2026-04-04', '2026-04-13', NULL, '2026-03-27 08:20:48', '2026-04-14 09:27:07', 'Belum'),
(21, 21, 12475335.60, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-27 10:05:49', '2026-04-04 01:53:26', 'Belum'),
(22, 22, 3708297.45, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-27 10:11:27', '2026-04-04 01:53:57', 'Belum'),
(23, 23, 9807963.75, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-27 10:31:20', '2026-04-04 01:54:17', 'Belum'),
(25, 25, 157817.10, 'Penerima', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-28 04:36:15', '2026-04-04 01:56:28', 'Belum'),
(26, 26, 1295091.00, 'Penerima', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-28 04:41:24', '2026-04-04 01:57:00', 'Belum'),
(27, 27, 707700.00, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-28 05:13:12', '2026-04-04 01:57:47', 'Belum'),
(28, 28, 27300.00, 'Penerima', 'Sudah ditagih', '2026-04-03', NULL, NULL, '2026-03-28 06:53:38', '2026-04-04 01:59:20', 'Belum'),
(29, 29, 707700.00, 'Penerima', 'Sudah ditagih', '2026-04-04', '2026-04-14', NULL, '2026-03-28 07:28:36', '2026-04-14 02:19:49', 'Belum'),
(30, 30, 10413097.80, 'Pengirim', 'Sudah ditagih', '2026-04-04', '2026-04-14', NULL, '2026-03-28 07:53:17', '2026-04-14 09:45:33', 'Belum'),
(31, 31, 832609.05, 'Penerima', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-28 08:53:38', '2026-04-04 01:59:49', 'Belum'),
(32, 32, 456062.10, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-03-28 09:34:12', '2026-04-04 02:26:49', 'Belum'),
(33, 33, 505753.00, 'Penerima', 'Sudah ditagih', '2026-04-14', '2026-04-14', NULL, '2026-03-28 09:46:36', '2026-04-14 02:25:14', 'Belum'),
(34, 34, 1617600.00, 'Pengirim', 'Sudah ditagih', '2026-03-17', '2026-03-17', NULL, '2026-03-28 10:30:42', '2026-04-04 09:09:20', 'Belum'),
(35, 35, 3538.50, 'Penerima', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 02:08:15', '2026-04-04 02:00:34', 'Belum'),
(36, 36, 4090101.60, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 02:16:59', '2026-04-04 02:01:06', 'Belum'),
(37, 37, 750162.00, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 02:42:36', '2026-04-04 02:07:06', 'Belum'),
(38, 38, 328575.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-03-30 03:00:27', '2026-03-30 03:00:27', 'Belum'),
(39, 39, 510605.55, 'Penerima', 'Sudah ditagih', '2026-04-03', NULL, NULL, '2026-03-30 04:24:10', '2026-04-04 02:04:54', 'Belum'),
(40, 40, 10844289.30, 'Penerima', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 05:00:13', '2026-04-04 02:07:55', 'Belum'),
(41, 41, 6706872.90, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 05:49:36', '2026-04-04 02:08:41', 'Belum'),
(42, 42, 118944.15, 'Penerima', 'Sudah ditagih', '2026-04-03', NULL, NULL, '2026-03-30 05:56:53', '2026-04-04 02:09:24', 'Belum'),
(43, 43, 730093.65, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 06:06:23', '2026-04-04 02:10:23', 'Belum'),
(44, 44, 707700.00, 'Penerima', 'Sudah ditagih', '2026-04-06', '2026-04-13', NULL, '2026-03-30 06:16:43', '2026-04-14 09:27:39', 'Belum'),
(45, 45, 1961744.40, 'Penerima', 'Sudah ditagih', '2026-04-04', '2026-04-13', NULL, '2026-03-30 08:07:02', '2026-04-14 09:29:34', 'Belum'),
(46, 46, 3012678.90, 'Pengirim', 'Sudah ditagih', '2026-04-04', '2026-04-06', NULL, '2026-03-30 08:28:43', '2026-04-14 09:44:31', 'Belum'),
(47, 47, 1961744.40, 'Penerima', 'Sudah ditagih', '2026-04-04', '2026-04-13', NULL, '2026-03-30 08:31:08', '2026-04-14 09:28:58', 'Belum'),
(48, 48, 1394169.00, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 08:36:55', '2026-04-04 02:18:08', 'Belum'),
(49, 49, 1961036.70, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 08:40:54', '2026-04-04 09:06:18', 'Belum'),
(50, 50, 3141884.70, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 09:05:07', '2026-04-04 09:20:35', 'Belum'),
(51, 51, 4285123.50, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 09:14:46', '2026-04-04 09:23:34', 'Belum'),
(52, 52, 15872700.00, 'Pengirim', 'Sudah ditagih', '2026-04-04', NULL, NULL, '2026-03-30 09:42:31', '2026-04-04 09:22:34', 'Belum'),
(53, 53, 5305626.90, 'Pengirim', 'Sudah ditagih', '2026-04-04', '2026-04-13', NULL, '2026-03-30 10:16:46', '2026-04-14 09:28:09', 'Belum'),
(54, 54, 1845277.20, 'Pengirim', 'Sudah ditagih', '2026-01-07', '2026-01-13', NULL, '2026-03-30 10:49:52', '2026-04-06 05:29:59', 'Sudah'),
(55, 55, 1206000.00, 'Pengirim', 'Sudah ditagih', '2026-01-11', '2026-02-10', NULL, '2026-03-30 10:56:17', '2026-04-07 05:42:28', 'Belum'),
(56, 56, 8571865.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-07', NULL, '2026-04-02 08:59:26', '2026-04-07 05:36:48', 'Belum'),
(58, 58, 1485867.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-02 09:28:20', '2026-04-07 05:44:14', 'Belum'),
(59, 59, 2784546.75, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-02 09:55:00', '2026-04-07 05:44:36', 'Belum'),
(60, 60, 3847663.80, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-02 10:02:11', '2026-04-07 05:48:03', 'Belum'),
(61, 61, 3999314.00, 'Penerima', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-02 10:10:40', '2026-04-07 05:45:42', 'Belum'),
(62, 62, 6066000.00, 'Penerima', 'Sudah ditagih', '2026-03-03', '2026-03-30', NULL, '2026-04-02 10:30:56', '2026-04-06 07:18:41', 'Belum'),
(63, 63, 2573197.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-03 10:11:32', '2026-04-08 04:19:21', 'Belum'),
(64, 64, 1286598.60, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-03 10:16:05', '2026-04-07 05:50:36', 'Belum'),
(65, 65, 2437369.35, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-07', NULL, '2026-04-03 10:28:03', '2026-04-14 09:43:54', 'Belum'),
(66, 66, 3807075.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-07', NULL, '2026-04-03 10:39:17', '2026-04-14 09:42:50', 'Belum'),
(67, 67, 581325.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-07', NULL, '2026-04-03 10:45:44', '2026-04-07 05:48:42', 'Belum'),
(68, 68, 1604962.50, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-03 11:01:32', '2026-04-03 11:01:32', 'Belum'),
(69, 69, 2771201.55, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-03 11:09:21', '2026-04-07 05:51:14', 'Belum'),
(70, 70, 1195507.50, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-04 02:43:16', '2026-04-04 02:43:16', 'Belum'),
(71, 71, 1314300.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-14', NULL, '2026-04-04 02:57:15', '2026-04-14 08:53:11', 'Belum'),
(72, 72, 556252.20, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-04 03:07:25', '2026-04-07 05:49:39', 'Belum'),
(73, 73, 2269998.30, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-04 03:15:07', '2026-04-07 05:58:38', 'Belum'),
(74, 74, 181980.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-04 03:41:15', '2026-04-07 11:32:27', 'Belum'),
(75, 75, 550995.00, 'Penerima', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-04 03:45:38', '2026-04-07 06:12:33', 'Belum'),
(76, 76, 1404987.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-04 03:55:20', '2026-04-07 05:52:42', 'Belum'),
(77, 77, 4222125.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-09', NULL, '2026-04-04 04:06:03', '2026-04-14 09:36:45', 'Belum'),
(78, 78, 11956550.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-09', NULL, '2026-04-04 04:13:13', '2026-04-14 09:36:11', 'Belum'),
(79, 79, 1564421.40, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-07', NULL, '2026-04-04 04:24:53', '2026-04-07 05:37:30', 'Belum'),
(80, 80, 4435800.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', NULL, NULL, '2026-04-04 05:35:34', '2026-04-07 06:08:01', 'Belum'),
(81, 81, 6919550.00, 'Pengirim', 'Sudah ditagih', '2026-04-07', '2026-04-14', NULL, '2026-04-06 05:05:05', '2026-04-14 02:17:55', 'Belum'),
(82, 82, 287500.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-06 05:11:19', '2026-04-06 09:55:53', 'Belum'),
(83, 83, 3718458.00, 'Pengirim', 'Sudah ditagih', '2026-04-08', NULL, NULL, '2026-04-06 05:16:10', '2026-04-08 10:45:35', 'Belum'),
(84, 84, 1842851.00, 'Pengirim', 'Sudah ditagih', '2026-04-08', NULL, NULL, '2026-04-06 05:19:35', '2026-04-08 10:46:04', 'Belum'),
(85, 85, 2300000.00, 'Pengirim', 'Sudah ditagih', '2026-04-08', '2026-04-14', NULL, '2026-04-06 05:23:47', '2026-04-14 08:59:12', 'Belum'),
(86, 86, 186226.00, 'Penerima', 'Sudah ditagih', '2026-04-08', NULL, NULL, '2026-04-06 05:29:13', '2026-04-08 10:49:49', 'Belum'),
(87, 87, 1289025.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 03:08:18', '2026-04-07 03:08:18', 'Belum'),
(88, 88, 1228365.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 03:15:11', '2026-04-07 03:15:11', 'Belum'),
(89, 89, 15274000.00, 'Pengirim', 'Sudah ditagih', '2026-04-06', '2026-04-06', NULL, '2026-04-07 03:25:57', '2026-04-08 10:47:46', 'Belum'),
(90, 90, 1642976.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 03:33:53', '2026-04-15 05:31:32', 'Belum'),
(91, 91, 2214596.00, 'Penerima', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 03:40:37', '2026-04-15 05:32:12', 'Belum'),
(92, 92, 252750.00, 'Penerima', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 03:49:41', '2026-04-15 05:32:51', 'Belum'),
(93, 93, 925747.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 03:55:45', '2026-04-10 08:05:49', 'Belum'),
(94, 94, 908181.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 04:01:25', '2026-04-10 08:08:53', 'Belum'),
(95, 95, 3524295.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 04:06:14', '2026-04-10 08:03:44', 'Belum'),
(96, 96, 452220.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 04:11:53', '2026-04-15 05:33:45', 'Belum'),
(97, 97, 6673611.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 04:22:08', '2026-04-15 05:34:34', 'Belum'),
(98, 98, 1619875.00, 'Penerima', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-07 04:31:22', '2026-04-15 05:35:12', 'Belum'),
(99, 99, 758250.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 04:40:12', '2026-04-15 05:35:52', 'Belum'),
(100, 100, 1123221.00, 'Pengirim', 'Sudah ditagih', '2026-04-15', NULL, NULL, '2026-04-07 04:51:43', '2026-04-15 05:41:47', 'Belum'),
(102, 102, 3480400.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', '2026-04-13', NULL, '2026-04-07 05:29:52', '2026-04-14 09:30:31', 'Belum'),
(103, 103, 707700.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 05:42:57', '2026-04-15 05:42:18', 'Belum'),
(104, 104, 11111901.00, 'Penerima', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-07 05:47:40', '2026-04-15 05:37:10', 'Belum'),
(105, 105, 2472350.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 09:16:37', '2026-04-15 05:42:50', 'Belum'),
(106, 106, 4010536.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 09:35:54', '2026-04-15 05:43:23', 'Belum'),
(107, 107, 6824250.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 10:08:09', '2026-04-11 10:59:32', 'Belum'),
(109, 109, 101100.00, 'Penerima', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 10:48:16', '2026-04-15 05:44:11', 'Belum'),
(110, 110, 707700.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-07 11:01:31', '2026-04-15 05:44:52', 'Belum'),
(111, 111, 8993755.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 11:05:52', '2026-04-07 11:05:52', 'Belum'),
(112, 112, 190574.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-07 11:12:34', '2026-04-08 05:30:53', 'Belum'),
(113, 113, 10733100.00, 'Penerima', 'Sudah ditagih', '2026-04-13', '2026-04-14', NULL, '2026-04-08 05:05:38', '2026-04-14 08:58:44', 'Belum'),
(114, 114, 2349564.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-08 06:39:54', '2026-04-15 05:45:47', 'Belum'),
(115, 115, 707700.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-08 06:46:11', '2026-04-15 05:48:48', 'Belum'),
(116, 116, 12658731.00, 'Penerima', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-08 06:50:50', '2026-04-15 08:26:56', 'Belum'),
(117, 117, 859350.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-08 09:11:33', '2026-04-15 05:50:27', 'Belum'),
(118, 118, 6153805.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-08 09:19:14', '2026-04-10 07:26:18', 'Belum'),
(119, 119, 2760030.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-08 09:26:23', '2026-04-15 05:52:44', 'Belum'),
(121, 121, 1824451.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-08 10:00:28', '2026-04-15 05:58:13', 'Belum'),
(122, 122, 4237101.00, 'Pengirim', 'Sudah ditagih', '2026-04-13', NULL, NULL, '2026-04-09 04:41:25', '2026-04-15 05:58:48', 'Belum'),
(123, 123, 875273.00, 'Pengirim', 'Sudah ditagih', '2026-04-11', '2026-04-11', NULL, '2026-04-09 05:32:04', '2026-04-14 09:31:20', 'Belum'),
(124, 124, 10927800.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-10 10:34:02', '2026-04-15 06:19:57', 'Belum'),
(125, 125, 446205.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-10 10:37:25', '2026-04-15 05:49:43', 'Belum'),
(126, 126, 4395125.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-10 10:56:20', '2026-04-15 07:21:41', 'Belum'),
(127, 127, 1603446.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 01:59:34', '2026-04-15 07:23:55', 'Belum'),
(128, 128, 1011000.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 02:04:33', '2026-04-15 07:22:20', 'Belum'),
(129, 129, 830031.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 02:08:39', '2026-04-15 07:25:23', 'Belum'),
(130, 130, 3203600.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 02:12:59', '2026-04-15 06:13:49', 'Belum'),
(131, 131, 834075.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-13 02:18:34', '2026-04-13 02:18:34', 'Belum'),
(132, 132, 9131099.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 02:21:37', '2026-04-15 07:22:49', 'Belum'),
(133, 133, 1314300.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-13 02:32:27', '2026-04-14 04:23:00', 'Belum'),
(134, 134, 682425.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-13 02:36:51', '2026-04-14 04:18:56', 'Belum'),
(135, 135, 308861.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 02:43:41', '2026-04-15 07:23:15', 'Belum'),
(136, 136, 45651705.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 02:49:25', '2026-04-15 07:24:45', 'Belum'),
(137, 137, 2515500.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-13 02:52:45', '2026-04-13 02:52:45', 'Belum'),
(139, 139, 11560987.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-13 03:21:06', '2026-04-13 03:21:06', 'Belum'),
(140, 140, 695922.00, 'Pengirim', 'Sudah ditagih', '2026-01-14', '2026-01-14', NULL, '2026-04-13 03:23:07', '2026-04-15 07:26:56', 'Belum'),
(141, 141, 2082000.00, 'Penerima', 'Sudah ditagih', '2026-01-20', '2026-01-20', NULL, '2026-04-13 03:27:30', '2026-04-15 07:28:28', NULL),
(142, 142, 1213200.00, 'Pengirim', 'Sudah ditagih', '2026-02-11', '2026-02-11', NULL, '2026-04-13 03:30:10', '2026-04-15 07:33:06', 'Belum'),
(143, 143, 3898871.00, 'Pengirim', 'Sudah ditagih', '2026-02-11', '2026-02-11', NULL, '2026-04-13 03:33:59', '2026-04-15 07:29:24', 'Belum'),
(144, 144, 4697510.00, 'Penerima', 'Sudah ditagih', '2026-04-15', '2026-04-15', NULL, '2026-04-13 04:59:31', '2026-04-15 07:30:08', 'Belum'),
(145, 145, 729437.00, 'Pengirim', 'Sudah ditagih', '2026-01-26', '2026-01-26', NULL, '2026-04-13 05:03:26', '2026-04-15 07:31:12', 'Belum'),
(146, 146, 1061171.00, 'Pengirim', 'Sudah ditagih', '2026-02-14', '2026-02-14', NULL, '2026-04-13 05:07:31', '2026-04-15 07:35:01', 'Belum'),
(147, 147, 726050.00, 'Pengirim', 'Sudah ditagih', '2026-01-22', '2026-01-22', NULL, '2026-04-13 05:10:48', '2026-04-15 07:36:00', 'Belum'),
(148, 148, 11876015.00, 'Pengirim', 'Sudah ditagih', '2026-01-15', '2026-01-15', NULL, '2026-04-13 05:13:04', '2026-04-15 07:44:07', 'Belum'),
(149, 149, 965353.00, 'Pengirim', 'Sudah ditagih', '2026-01-20', '2026-01-20', NULL, '2026-04-13 05:17:10', '2026-04-15 07:48:05', 'Belum'),
(150, 150, 1707933.00, 'Pengirim', 'Sudah ditagih', '2026-01-13', '2026-01-13', NULL, '2026-04-13 05:20:31', '2026-04-15 07:49:33', 'Belum'),
(151, 151, 594064.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-13 05:23:38', '2026-04-13 05:23:38', 'Belum'),
(152, 152, 5614690.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-13 08:11:52', '2026-04-13 08:11:52', 'Belum'),
(153, 153, 2982450.00, 'Pengirim', 'Sudah ditagih', '2026-04-14', NULL, NULL, '2026-04-13 08:15:40', '2026-04-15 08:03:07', 'Belum'),
(155, 155, 1583732.00, 'Pengirim', 'Sudah ditagih', '2026-02-11', '2026-02-11', NULL, '2026-04-13 09:17:38', '2026-04-15 07:50:56', 'Belum'),
(156, 156, 2001780.00, 'Pengirim', 'Sudah ditagih', '2026-01-17', '2026-01-17', NULL, '2026-04-13 09:27:40', '2026-04-15 07:32:12', 'Belum'),
(157, 157, 650000.00, 'Pengirim', 'Sudah ditagih', '2026-01-31', '2026-01-31', NULL, '2026-04-13 09:32:28', '2026-04-15 07:55:26', 'Belum'),
(158, 158, 522600.00, 'Pengirim', 'Sudah ditagih', '2026-02-10', '2026-02-10', NULL, '2026-04-13 10:47:05', '2026-04-15 07:57:43', 'Belum'),
(159, 159, 412488.00, 'Penerima', 'Sudah ditagih', '2026-01-31', '2026-01-31', NULL, '2026-04-13 10:51:35', '2026-04-15 07:56:24', 'Belum'),
(160, 160, 600000.00, 'Pengirim', 'Sudah ditagih', '2026-01-24', '2026-01-24', NULL, '2026-04-13 10:55:22', '2026-04-15 08:02:17', 'Belum'),
(161, 161, 4541412.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 05:19:50', '2026-04-15 10:14:33', 'Belum'),
(162, 162, 7079073.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 05:27:47', '2026-04-15 10:15:54', 'Belum'),
(163, 163, 4774448.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 05:37:00', '2026-04-15 11:40:30', 'Belum'),
(164, 164, 749250.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 05:41:36', '2026-04-15 10:24:51', 'Belum'),
(165, 165, 5055000.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 05:51:11', '2026-04-15 10:32:51', 'Belum'),
(166, 166, 2153430.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 05:55:21', '2026-04-15 10:35:35', 'Belum'),
(167, 167, 513083.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 05:58:02', '2026-04-14 05:58:02', 'Belum'),
(168, 168, 10936240.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:03:53', '2026-04-15 10:40:25', 'Belum'),
(169, 169, 438319.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:07:07', '2026-04-14 06:07:07', 'Belum'),
(170, 170, 758250.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:11:02', '2026-04-15 10:44:12', 'Belum'),
(171, 171, 1027429.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:15:49', '2026-04-15 10:46:48', 'Belum'),
(172, 172, 758250.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:17:15', '2026-04-14 06:17:15', 'Belum'),
(173, 173, 4024791.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:21:50', '2026-04-15 10:48:33', 'Belum'),
(174, 174, 2875284.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:45:58', '2026-04-15 10:59:16', 'Belum'),
(175, 175, 783525.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:51:27', '2026-04-14 06:51:27', 'Belum'),
(176, 176, 72034.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:54:10', '2026-04-15 11:03:09', 'Belum'),
(177, 177, 5749506.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 06:58:44', '2026-04-14 06:58:44', 'Belum'),
(179, 179, 1516500.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 07:33:35', '2026-04-14 07:33:35', 'Belum'),
(180, 180, 1425510.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 07:40:01', '2026-04-15 11:09:37', 'Belum'),
(181, 181, 1782000.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 07:44:52', '2026-04-15 11:10:56', 'Belum'),
(182, 182, 375334.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 07:50:29', '2026-04-15 11:12:10', 'Belum'),
(185, 185, 3772500.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 08:58:26', '2026-04-15 11:14:13', 'Belum'),
(186, 186, 11964275.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:02:47', '2026-04-14 09:02:47', 'Belum'),
(187, 187, 3766986.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:19:09', '2026-04-15 11:17:29', 'Belum'),
(188, 188, 2161771.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:25:05', '2026-04-15 11:19:17', 'Belum'),
(189, 189, 3883000.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:28:17', '2026-04-14 09:28:17', 'Belum'),
(190, 190, 9324959.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:31:20', '2026-04-14 09:31:20', 'Belum'),
(191, 191, 310048.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:34:29', '2026-04-14 09:34:29', 'Belum'),
(192, 192, 379125.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:41:49', '2026-04-15 11:24:36', 'Belum'),
(193, 193, 13676555.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 09:49:48', '2026-04-15 11:27:20', 'Belum'),
(194, 194, 2176936.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 10:10:26', '2026-04-15 11:28:58', 'Belum'),
(195, 195, 98573.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 10:13:51', '2026-04-15 11:43:14', 'Belum'),
(196, 196, 1205618.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 10:22:30', '2026-04-15 11:45:03', 'Belum'),
(197, 197, 31088.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 10:27:25', '2026-04-15 12:23:34', 'Belum'),
(198, 198, 306333.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 11:05:55', '2026-04-15 12:25:20', 'Belum'),
(199, 199, 951604.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 11:27:13', '2026-04-15 12:26:36', 'Belum'),
(200, 200, 1216991.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 11:44:36', '2026-04-15 12:58:02', 'Belum'),
(201, 201, 2942010.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 11:50:17', '2026-04-15 12:59:46', 'Belum'),
(202, 202, 2251244.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 11:53:31', '2026-04-15 13:01:09', 'Belum'),
(203, 203, 5380542.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 12:02:14', '2026-04-15 13:02:34', 'Belum'),
(204, 204, 201695.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 12:06:28', '2026-04-15 13:03:56', 'Belum'),
(205, 205, 12132000.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 12:14:39', '2026-04-14 12:14:39', 'Belum'),
(206, 206, 6561643.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-14 12:20:19', '2026-04-14 12:20:19', 'Belum'),
(207, 207, 5322915.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-15 01:52:04', '2026-04-15 01:52:04', 'Belum'),
(208, 208, 4752610.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-15 02:00:32', '2026-04-15 02:00:32', 'Belum'),
(213, 213, 9930194.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-15 12:19:38', '2026-04-15 12:19:38', 'Belum'),
(214, 214, 758250.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-15 13:20:01', '2026-04-15 13:20:01', 'Belum'),
(215, 215, 1889609.55, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 02:55:11', '2026-04-16 02:55:11', 'Belum'),
(216, 216, 2532656.10, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 03:04:28', '2026-04-16 07:33:22', 'Belum'),
(217, 217, 6860999.85, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 04:17:32', '2026-04-16 06:20:59', 'Belum'),
(218, 218, 5183017.88, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 04:22:19', '2026-04-16 04:22:19', 'Belum'),
(219, 219, 2388462.23, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 04:40:31', '2026-04-16 04:40:31', 'Belum'),
(220, 220, 3429817.50, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 05:49:51', '2026-04-16 05:49:51', 'Belum'),
(221, 221, 695062.50, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 06:03:07', '2026-04-16 06:03:07', 'Belum'),
(222, 222, 325000.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 06:11:48', '2026-04-16 06:11:48', 'Belum'),
(223, 223, 775000.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 06:16:32', '2026-04-16 06:16:32', 'Belum'),
(224, 224, 5076483.75, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 06:19:48', '2026-04-16 06:19:48', 'Belum'),
(225, 225, 20220000.00, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 07:16:41', '2026-04-16 07:16:41', 'Belum'),
(226, 226, 14908711.50, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 07:31:31', '2026-04-16 07:31:31', 'Belum'),
(227, 227, 509291.25, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 07:38:38', '2026-04-16 07:38:38', 'Belum'),
(228, 228, 4275367.35, 'Penerima', 'Belum', NULL, NULL, NULL, '2026-04-16 07:51:50', '2026-04-16 07:51:50', 'Belum');

-- --------------------------------------------------------

--
-- Table structure for table `hutang_piutang`
--

CREATE TABLE `hutang_piutang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `jenis` enum('Hutang','Piutang') NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `nominal` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_invoice` varchar(255) NOT NULL,
  `pengirim_id` bigint(20) UNSIGNED NOT NULL,
  `penerima_id` bigint(20) UNSIGNED NOT NULL,
  `up` varchar(255) DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `container_id` bigint(20) UNSIGNED DEFAULT NULL,
  `layanan` enum('Door to Door','CY to CY','CY to Door','Door to CY','Port to Port') NOT NULL,
  `tujuan_daerah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_pembayaran` enum('Serahkan','Tahan') NOT NULL DEFAULT 'Tahan',
  `catatan_muntahan` text DEFAULT NULL,
  `tanda_terima` enum('SCJ','Pengirim') NOT NULL DEFAULT 'SCJ',
  `show_stamp` tinyint(1) NOT NULL DEFAULT 1,
  `pkp_status` enum('PKP','Non PKP') NOT NULL,
  `terima_barang` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `metode` enum('FCL','LCL','Break Bulk') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `no_invoice`, `pengirim_id`, `penerima_id`, `up`, `tgl_masuk`, `container_id`, `layanan`, `tujuan_daerah_id`, `status_pembayaran`, `catatan_muntahan`, `tanda_terima`, `show_stamp`, `pkp_status`, `terima_barang`, `created_at`, `updated_at`, `metode`) VALUES
(20, '06648', 35, 36, '36', '2026-03-14', 12, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-27 08:20:48', '2026-04-14 09:27:07', 'LCL'),
(21, '06647', 39, 40, '39', '2026-03-14', 12, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-27 10:05:49', '2026-04-04 01:53:26', 'LCL'),
(22, '06666', 39, 40, '39', '2026-03-18', 12, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-27 10:11:27', '2026-04-04 01:53:57', 'LCL'),
(23, '06667', 39, 40, '39', '2026-03-18', 12, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-27 10:31:20', '2026-04-04 01:54:17', 'LCL'),
(25, '06654', 44, 23, '23', '2026-03-16', 12, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 04:36:15', '2026-04-04 01:56:28', 'LCL'),
(26, '06665', 44, 23, '23', '2026-03-17', 12, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 04:41:24', '2026-04-04 01:57:00', 'LCL'),
(27, '06664', 46, 47, '46', '2026-03-17', 12, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 05:13:12', '2026-04-04 01:57:47', 'LCL'),
(28, '06663', 237, 238, '237', '2026-03-17', 12, 'CY to Door', 4, 'Serahkan', NULL, 'SCJ', 1, 'Non PKP', NULL, '2026-03-28 06:53:38', '2026-04-13 09:30:38', 'LCL'),
(29, '06660', 49, 50, '50', '2026-03-17', 12, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 07:28:36', '2026-04-14 02:19:49', 'LCL'),
(30, '06662', 51, 52, '51', '2026-03-17', 12, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 07:53:17', '2026-04-14 09:45:33', 'LCL'),
(31, '06655', 56, 57, '57', '2026-03-16', 12, 'CY to Door', 4, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 08:53:38', '2026-04-04 01:59:49', 'LCL'),
(32, '06658', 58, 59, '59', '2026-03-16', 12, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 09:34:12', '2026-03-31 10:26:44', 'LCL'),
(33, '06659', 60, 59, '59', '2026-03-17', 12, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 09:46:36', '2026-04-14 02:22:31', 'LCL'),
(34, '06657', 53, 54, '53', '2026-03-16', 12, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-28 10:30:42', '2026-04-04 09:09:20', 'LCL'),
(35, '06650', 55, 41, '41', '2026-03-14', 12, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 02:08:15', '2026-04-04 02:00:34', 'LCL'),
(36, '06656', 64, 61, '64', '2026-03-16', 12, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 02:16:59', '2026-03-30 03:09:01', 'LCL'),
(37, '06694', 67, 66, '67', '2026-03-28', 13, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-03-30 02:42:36', '2026-04-04 02:07:06', 'LCL'),
(38, '06695', 68, 69, '68', '2026-03-28', 13, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 03:00:27', '2026-03-30 03:13:34', 'LCL'),
(39, '06668', 70, 71, '71', '2026-03-18', 13, 'CY to Door', 4, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 04:24:10', '2026-04-04 02:04:54', 'LCL'),
(40, '06671', 72, 73, '73', '2026-03-26', 13, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 05:00:13', '2026-03-30 05:00:13', 'LCL'),
(41, '06676', 39, 40, '39', '2026-03-26', 13, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 05:49:36', '2026-04-04 02:08:41', 'LCL'),
(42, '06681', 76, 71, '48', '2026-03-27', 13, 'CY to Door', 4, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 05:56:53', '2026-04-04 02:09:24', 'LCL'),
(43, '06685', 77, 78, '77', '2026-03-27', 13, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-03-30 06:06:23', '2026-03-30 06:06:23', 'LCL'),
(44, '06674', 74, 75, '74', '2026-03-28', 13, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 06:16:43', '2026-04-14 09:27:39', 'LCL'),
(45, '06688', 79, 80, '80', '2026-03-28', 13, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 08:07:02', '2026-04-14 09:29:34', 'LCL'),
(46, '06669', 82, 83, '82', '2026-03-26', 14, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 08:28:43', '2026-04-14 09:44:31', 'LCL'),
(47, '06673', 79, 80, '80', '2026-03-26', 14, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 08:31:08', '2026-04-14 09:28:58', 'LCL'),
(48, '06678', 84, 85, '84', '2026-03-26', 14, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-03-30 08:36:55', '2026-04-04 02:18:08', 'LCL'),
(49, '06679', 84, 85, '84', '2026-03-26', 14, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-03-30 08:40:54', '2026-04-04 09:06:18', 'LCL'),
(50, '06683', 81, 86, '81', '2026-03-27', 14, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 09:05:07', '2026-04-04 09:20:35', 'LCL'),
(51, '06684', 87, 88, '87', '2026-03-27', 14, 'CY to Door', 4, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-03-30 09:14:46', '2026-04-04 09:23:34', 'LCL'),
(52, '06692', 89, 90, '89', '2026-03-26', 14, 'Door to CY', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-03-30 09:42:31', '2026-03-30 09:42:31', 'LCL'),
(53, '06697', 91, 92, '91', '2026-03-26', 14, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-03-30 10:16:46', '2026-04-14 09:28:09', 'LCL'),
(54, '05874', 93, 94, '93', '2025-12-29', 15, 'CY to Door', 4, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', '2026-01-13', '2026-03-30 10:49:52', '2026-04-06 05:29:59', 'LCL'),
(55, '05875', 95, 96, '95', '2025-12-31', 15, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-03-30 10:56:17', '2026-04-07 05:42:28', 'LCL'),
(56, '06649', 97, 98, '97', '2026-03-14', 16, 'CY to Door', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-02 08:59:26', '2026-04-07 05:36:48', 'LCL'),
(58, '06670', 81, 101, '81', '2026-03-26', 16, 'CY to Door', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-02 09:28:20', '2026-04-07 05:44:14', 'LCL'),
(59, '06661', 81, 101, '81', '2026-03-17', 17, 'CY to Door', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-02 09:55:00', '2026-04-07 05:44:36', 'LCL'),
(60, '06672', 102, 103, '103', '2026-03-26', 17, 'CY to CY', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-02 10:02:11', '2026-04-07 05:48:03', 'LCL'),
(61, '06675', 104, 105, '105', '2026-03-26', 17, 'CY to CY', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-02 10:10:40', '2026-04-07 05:45:42', 'LCL'),
(62, '06689', 106, 107, '106', '2026-03-28', 17, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-02 10:30:56', '2026-04-06 07:15:35', 'LCL'),
(63, '06690', 108, 170, '108', '2026-03-28', 17, 'CY to Door', 7, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-03 10:11:32', '2026-04-08 04:19:21', 'LCL'),
(64, '06691', 108, 111, '108', '2026-03-28', 17, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-03 10:16:05', '2026-04-07 05:50:36', 'LCL'),
(65, '06680', 112, 113, '112', '2026-03-27', 17, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-03 10:28:03', '2026-04-14 09:43:54', 'LCL'),
(66, '06696', 114, 115, '114', '2026-03-28', 17, 'CY to CY', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-03 10:39:17', '2026-04-14 09:42:50', 'LCL'),
(67, '06699', 116, 120, '116', '2026-03-30', 17, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-03 10:45:44', '2026-04-07 05:48:42', 'LCL'),
(68, '06701', 122, 123, '122', '2026-03-30', 17, 'CY to Door', 3, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-03 11:01:32', '2026-04-03 11:01:32', 'LCL'),
(69, '06707', 87, 124, '87', '2026-03-31', 17, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-03 11:09:21', '2026-04-07 05:51:14', 'LCL'),
(70, '06700', 122, 123, '122', '2026-03-30', 17, 'CY to Door', 8, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-04 02:43:16', '2026-04-04 02:43:16', 'LCL'),
(71, '06709', 125, 126, '125', '2026-03-31', 17, 'CY to Door', 9, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', '2026-04-14', '2026-04-04 02:57:15', '2026-04-14 08:53:11', 'LCL'),
(72, '06712', 102, 103, '102', '2026-03-31', 17, 'CY to CY', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-04 03:07:25', '2026-04-07 05:49:39', 'LCL'),
(73, '06719', 127, 128, '127', '2026-04-01', 17, 'CY to Door', 10, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-04 03:15:07', '2026-04-07 05:58:38', 'LCL'),
(74, '06651', 99, 100, '99', '2026-03-15', 16, 'CY to Door', 11, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-04 03:41:15', '2026-04-07 11:32:27', 'LCL'),
(75, '06717', 129, 100, '100', '2026-04-01', 17, 'CY to Door', 11, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-04 03:45:38', '2026-04-07 06:12:33', 'LCL'),
(76, '06653', 44, 130, '45', '2026-03-16', 16, 'CY to Door', 7, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-04 03:55:20', '2026-04-07 05:52:42', 'LCL'),
(77, '06714', 131, 132, '131', '2026-03-31', 16, 'CY to CY', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-04 04:06:03', '2026-04-14 09:35:38', 'LCL'),
(78, '06687', 131, 133, '131', '2026-03-27', 17, 'CY to CY', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-04 04:13:13', '2026-04-14 09:34:54', 'LCL'),
(79, '06693', 97, 134, '97', '2026-03-27', 17, 'CY to Door', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-04 04:24:53', '2026-04-07 05:37:30', 'LCL'),
(80, '06706', 135, 136, '135', '2026-03-26', 16, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-04 05:35:34', '2026-04-07 06:08:01', 'LCL'),
(81, '06721', 131, 132, '131', '2026-04-01', 19, 'CY to CY', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-06 05:05:05', '2026-04-14 02:17:55', 'LCL'),
(82, '06730', 95, 140, '95', '2026-04-02', 19, 'CY to Door', 3, 'Tahan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-06 05:11:19', '2026-04-06 05:11:19', 'LCL'),
(83, '06734', 108, 171, '108', '2026-04-02', 19, 'CY to Door', 7, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-06 05:16:10', '2026-04-08 10:45:35', 'LCL'),
(84, '06735', 108, 111, '108', '2026-04-02', 19, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-06 05:19:35', '2026-04-08 10:46:04', 'LCL'),
(85, '06744', 114, 142, '114', '2026-04-02', 19, 'CY to CY', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-06 05:23:47', '2026-04-14 08:59:12', 'LCL'),
(86, '06751', 99, 100, '99', '2026-04-02', 19, 'CY to Door', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-06 05:29:13', '2026-04-08 10:49:49', 'LCL'),
(87, '06702', 122, 172, '122', '2026-03-30', 18, 'CY to Door', 12, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 03:08:18', '2026-04-08 04:36:29', 'LCL'),
(88, '06703', 122, 173, '122', '2026-03-30', 18, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 03:15:11', '2026-04-08 04:39:58', 'LCL'),
(89, '06705', 137, 174, '137', '2026-03-30', 18, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-07 03:25:57', '2026-04-08 10:47:46', 'LCL'),
(90, '06708', 89, 175, '89', '2026-03-31', 18, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 03:33:53', '2026-04-10 03:32:04', 'LCL'),
(91, '06723', 144, 176, '72', '2026-04-01', 18, 'CY to CY', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 03:40:37', '2026-04-08 04:48:49', 'LCL'),
(92, '06724', 145, 146, '146', '2026-04-01', 18, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 03:49:41', '2026-04-15 05:32:51', 'LCL'),
(93, '06727', 58, 177, '59', '2026-04-01', 18, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 03:55:45', '2026-04-08 04:52:44', 'LCL'),
(94, '06728', 147, 178, '148', '2026-04-02', 18, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 04:01:25', '2026-04-08 04:54:31', 'LCL'),
(95, '06729', 39, 40, '39', '2026-04-02', 18, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 04:06:14', '2026-04-07 04:06:14', 'LCL'),
(96, '06731', 149, 150, '149', '2026-04-02', 18, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 04:11:53', '2026-04-15 05:33:45', 'FCL'),
(97, '06733', 151, 152, '151', '2026-04-02', 18, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-07 04:22:08', '2026-04-15 05:34:34', 'LCL'),
(98, '06698', 153, 154, '154', '2026-03-30', 20, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 04:31:22', '2026-04-15 05:35:12', 'LCL'),
(99, '06710', 125, 180, '125', '2026-03-31', 20, 'CY to Door', 4, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-07 04:40:12', '2026-04-15 05:35:52', 'LCL'),
(100, '06711', 156, 157, '156', '2026-03-31', 20, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-07 04:51:43', '2026-04-15 05:41:47', 'LCL'),
(102, '06715', 160, 182, '160', '2026-03-31', 20, 'CY to Door', 13, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-07 05:29:52', '2026-04-14 09:30:31', 'LCL'),
(103, '06716', 162, 183, '162', '2026-04-01', 20, 'CY to Door', 4, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 05:42:57', '2026-04-15 05:42:18', 'LCL'),
(104, '06720', 153, 154, '154', '2026-04-01', 20, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 05:47:40', '2026-04-15 05:37:10', 'LCL'),
(105, '06722', 81, 184, '81', '2026-04-01', 20, 'CY to Door', 14, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 09:16:37', '2026-04-15 05:42:50', 'LCL'),
(106, '06725', 84, 85, '84', '2026-04-01', 20, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-07 09:35:54', '2026-04-15 05:43:23', 'LCL'),
(107, '06726', 165, 166, '165', '2026-04-01', 20, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-07 10:08:09', '2026-04-07 10:08:09', 'LCL'),
(109, '06738', 167, 168, '167', '2026-04-02', 20, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', '2026-04-13', '2026-04-07 10:48:16', '2026-04-15 05:44:11', 'LCL'),
(110, '06739', 64, 185, '64', '2026-04-02', 20, 'CY to CY', 4, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 11:01:31', '2026-04-15 05:44:52', 'LCL'),
(111, '06740', 39, 40, '39', '2026-04-02', 20, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 11:05:52', '2026-04-07 11:05:52', 'LCL'),
(112, '06741', 68, 69, '68', '2026-04-02', 20, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-07 11:12:34', '2026-04-07 11:12:34', 'LCL'),
(113, '06732', 114, 179, '114', '2026-04-02', 18, 'CY to Door', 4, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-08 05:05:38', '2026-04-14 08:58:16', 'LCL'),
(114, '06704', 186, 187, '186', '2026-03-30', 18, 'CY to Door', 4, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-08 06:39:54', '2026-04-15 05:45:47', 'LCL'),
(115, '06718', 188, 189, '188', '2026-04-01', 18, 'CY to Door', 15, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-08 06:46:11', '2026-04-15 05:48:48', 'LCL'),
(116, '06742', 190, 191, '191', '2026-04-03', 20, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-08 06:50:50', '2026-04-15 05:49:17', 'LCL'),
(117, '06785', 192, 193, '192', '2026-04-07', 24, 'CY to Door', 16, 'Serahkan', NULL, 'SCJ', 0, 'PKP', NULL, '2026-04-08 09:11:33', '2026-04-15 05:50:27', 'LCL'),
(118, '06787', 194, 195, '194', '2026-04-07', 24, 'CY to Door', 16, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-08 09:19:14', '2026-04-10 07:26:18', 'LCL'),
(119, '06786', 196, 197, '196', '2026-04-07', 24, 'CY to Door', 17, 'Serahkan', NULL, 'SCJ', 0, 'PKP', NULL, '2026-04-08 09:26:23', '2026-04-15 05:52:44', 'LCL'),
(121, '06736', 108, 200, '108', '2026-04-02', 24, 'CY to Door', 17, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-08 10:00:28', '2026-04-15 05:58:13', 'LCL'),
(122, '06753', 201, 202, '201', '2026-04-05', 20, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-09 04:41:25', '2026-04-09 04:41:25', 'LCL'),
(123, '06748', 203, 204, '203', '2026-04-04', 20, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-09 05:32:04', '2026-04-14 09:31:20', 'LCL'),
(124, '06746', 135, 136, '136', '2026-04-04', 25, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-10 10:34:02', '2026-04-15 06:19:57', 'LCL'),
(125, '06757', 102, 103, '103', '2026-04-06', 25, 'CY to CY', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-10 10:37:25', '2026-04-15 05:49:43', 'LCL'),
(126, '06774', 135, 205, '135', '2026-04-07', 25, 'CY to Door', 19, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-10 10:56:20', '2026-04-15 07:21:41', 'LCL'),
(127, '06775', 208, 209, '208', '2026-04-07', 25, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 01:59:34', '2026-04-15 07:23:55', 'LCL'),
(128, '06776', 210, 211, '210', '2026-04-07', 25, 'CY to Door', 11, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 02:04:33', '2026-04-13 02:04:33', 'LCL'),
(129, '06779', 212, 213, '212', '2026-04-07', 25, 'CY to Door', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 02:08:39', '2026-04-15 07:25:23', 'LCL'),
(130, '06780', 135, 136, '135', '2026-04-07', 25, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-13 02:12:59', '2026-04-15 06:13:49', 'LCL'),
(131, '06783', 214, 215, '214', '2026-04-07', 25, 'CY to Door', 3, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 02:18:34', '2026-04-13 02:18:34', 'LCL'),
(132, '06790', 208, 216, '208', '2026-04-07', 25, 'CY to Door', 3, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 02:21:37', '2026-04-15 07:22:49', 'LCL'),
(133, '06791', 122, 217, '122', '2026-04-08', 25, 'CY to Door', 7, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 02:32:27', '2026-04-13 02:32:27', 'LCL'),
(134, '06793', 122, 218, '122', '2026-04-08', 25, 'CY to Door', 3, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 02:36:51', '2026-04-13 02:36:51', 'LCL'),
(135, '06796', 102, 219, '102', '2026-04-08', 25, 'CY to CY', 3, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 02:43:41', '2026-04-15 07:23:15', 'LCL'),
(136, '06801', 81, 220, '81', '2026-04-07', 25, 'CY to Door', 8, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 02:49:25', '2026-04-15 07:24:45', 'LCL'),
(137, '06805', 95, 215, '95', '2026-04-08', 25, 'CY to Door', 3, 'Tahan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-13 02:52:45', '2026-04-13 02:52:45', 'LCL'),
(139, '05876', 165, 221, '165', '2025-12-31', 15, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 03:21:06', '2026-04-13 09:23:12', 'LCL'),
(140, '05845', 149, 150, '149', '2025-12-26', 15, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 03:23:07', '2026-04-15 07:26:56', 'LCL'),
(141, '05846', 224, 225, '225', '2025-12-26', 15, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 0, 'Non PKP', '2026-04-20', '2026-04-13 03:27:30', '2026-04-15 07:28:28', 'LCL'),
(142, '05850', 194, 226, '194', '2025-12-26', 15, 'CY to Door', 14, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 03:30:10', '2026-04-15 07:33:06', 'LCL'),
(143, '05852, 05853', 194, 226, '194', '2025-12-26', 15, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 03:33:59', '2026-04-15 07:29:24', 'LCL'),
(144, '05857', 199, 177, NULL, '2025-12-27', 15, 'CY to Door', 4, 'Serahkan', NULL, 'SCJ', 0, 'PKP', NULL, '2026-04-13 04:59:31', '2026-04-15 07:30:08', 'LCL'),
(145, '05860', 67, 67, '67', '2025-12-27', 15, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 05:03:26', '2026-04-15 07:31:12', 'LCL'),
(146, '05861', 227, 228, '227', '2025-12-29', 15, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 05:07:31', '2026-04-15 07:35:01', 'FCL'),
(147, '05866', 203, 204, '203', '2025-12-29', 15, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'Non PKP', NULL, '2026-04-13 05:10:48', '2026-04-15 07:36:00', 'LCL'),
(148, '05871', 39, 40, '39', '2025-12-30', 15, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 05:13:04', '2026-04-15 07:44:07', 'LCL'),
(149, '05872, 05839', 229, 230, '229', '2025-12-30', 15, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 05:17:10', '2026-04-15 07:48:05', 'LCL'),
(150, '05873', 231, 232, '231', '2025-12-30', 15, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 05:20:31', '2026-04-15 07:49:33', 'LCL'),
(151, '05859', 165, 233, '165', '2025-12-27', 15, 'CY to Door', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 05:23:38', '2026-04-13 09:18:56', 'LCL'),
(152, '06750', 199, 198, '199', '2026-04-04', 26, 'CY to Door', 20, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 08:11:52', '2026-04-13 08:11:52', 'LCL'),
(153, '06838', 206, 207, '206', '2026-04-10', 26, 'CY to Door', 21, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 08:15:40', '2026-04-13 08:15:40', 'LCL'),
(155, '05878', 235, 47, '235', '2026-01-02', 28, 'CY to CY', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 09:17:38', '2026-04-15 07:50:56', 'LCL'),
(156, '05882', 239, 236, '239', '2026-01-02', 28, 'CY to Door', 14, 'Serahkan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-13 09:27:40', '2026-04-15 07:32:12', 'LCL'),
(157, '05929', 240, 241, '240', '2026-01-07', 28, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-13 09:32:28', '2026-04-15 07:55:26', 'LCL'),
(158, '05931', 95, 139, '95', '2026-01-07', 28, 'CY to Door', 6, 'Serahkan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-13 10:47:05', '2026-04-15 07:57:43', 'LCL'),
(159, '05935', 60, 177, '177', '2026-01-08', 28, 'CY to Door', 6, 'Serahkan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-13 10:51:35', '2026-04-15 07:56:24', 'LCL'),
(160, '05941', 242, 243, '242', '2026-01-08', 28, 'CY to Door', 14, 'Serahkan', NULL, 'SCJ', 1, 'Non PKP', NULL, '2026-04-13 10:55:22', '2026-04-15 08:02:17', 'LCL'),
(161, '06713', 158, 291, '158', '2026-03-31', 29, 'CY to CY', 4, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 05:19:50', '2026-04-15 10:06:26', 'LCL'),
(162, '06747', 292, 177, '59', '2026-04-04', 29, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 05:27:47', '2026-04-15 10:09:39', 'LCL'),
(163, '06749', 247, 248, '247', '2026-04-04', 29, 'CY to CY', 23, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 05:37:00', '2026-04-15 11:40:30', 'LCL'),
(164, '06755', 293, 31, '31', '2026-04-06', 29, 'CY to Door', 24, 'Tahan', NULL, 'SCJ', 1, 'Non PKP', NULL, '2026-04-14 05:41:36', '2026-04-15 10:24:51', 'LCL'),
(165, '06759', 294, 250, '294', '2026-04-06', 29, 'CY to Door', 25, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 05:51:11', '2026-04-15 10:32:51', 'LCL'),
(166, '06765', 295, 252, '295', '2026-04-06', 29, 'CY to Door', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 05:55:21', '2026-04-15 10:35:35', 'LCL'),
(167, '06767', 296, 154, '225', '2026-04-06', 29, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 05:58:02', '2026-04-15 10:37:15', 'LCL'),
(168, '06769', 297, 298, '297', '2026-04-06', 29, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 06:03:53', '2026-04-15 10:40:25', 'LCL'),
(169, '06770', 299, 154, '225', '2026-04-06', 29, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 06:07:07', '2026-04-15 10:42:22', 'LCL'),
(170, '06771', 300, 301, '300', '2026-04-06', 29, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 06:11:02', '2026-04-15 10:44:12', 'LCL'),
(171, '06777', 302, 303, '302', '2026-04-07', 29, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 06:15:49', '2026-04-15 10:46:48', 'LCL'),
(172, '06961', 246, 245, '246', '2026-04-14', 30, 'CY to Door', 22, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 06:17:15', '2026-04-14 06:17:15', 'LCL'),
(173, '06782', 258, 259, '258', '2026-04-07', 29, 'CY to Door', 26, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 06:21:50', '2026-04-14 06:21:50', 'LCL'),
(174, '06784', 304, 305, '304', '2026-04-07', 29, 'CY to Door', 14, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 06:45:58', '2026-04-15 10:59:16', 'LCL'),
(175, '06794', 306, 307, '306', '2026-04-08', 29, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 06:51:27', '2026-04-15 11:01:35', 'LCL'),
(176, '06797', 302, 303, '302', '2026-04-08', 29, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 06:54:10', '2026-04-15 11:03:09', 'LCL'),
(177, '06798', 81, 86, '81', '2026-04-08', 29, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 06:58:44', '2026-04-14 06:58:44', 'LCL'),
(179, '06745', 262, 263, '262', '2026-04-04', 31, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 07:33:35', '2026-04-14 07:33:35', 'LCL'),
(180, '06761', 64, 185, '64', '2026-04-06', 31, 'CY to CY', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 07:40:01', '2026-04-14 07:40:01', 'LCL'),
(181, '06778', 308, 31, '31', '2026-04-06', 31, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'Non PKP', NULL, '2026-04-14 07:44:52', '2026-04-15 11:10:56', 'LCL'),
(182, '06781', 265, 266, '266', '2026-04-07', 31, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 07:50:29', '2026-04-14 07:50:29', 'LCL'),
(185, '06788', 309, 268, '309', '2026-04-07', 31, 'CY to CY', 4, 'Tahan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-14 08:58:26', '2026-04-15 11:14:13', 'LCL'),
(186, '06800', 81, 184, '81', '2026-04-07', 31, 'CY to Door', 14, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 09:02:47', '2026-04-14 09:02:47', 'LCL'),
(187, '06802', 310, 311, '310', '2026-04-08', 31, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 09:19:09', '2026-04-15 11:17:29', 'LCL'),
(188, '06803', 295, 252, '295', '2026-04-08', 31, 'CY to Door', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 09:25:05', '2026-04-15 11:19:17', 'LCL'),
(189, '06804', 312, 260, '312', '2026-04-08', 31, 'CY to Door', 14, 'Tahan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-14 09:28:17', '2026-04-15 11:20:41', 'LCL'),
(190, '06806', 39, 40, '39', '2026-04-08', 31, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 09:31:20', '2026-04-14 09:31:20', 'LCL'),
(191, '06807', 296, 154, '154', '2026-04-08', 31, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 09:34:29', '2026-04-15 11:22:37', 'LCL'),
(192, '06809', 68, 271, '68', '2026-04-08', 31, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 09:41:49', '2026-04-14 09:41:49', 'LCL'),
(193, '06810', 272, 273, '272', '2026-04-07', 31, 'CY to CY', 27, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 09:49:48', '2026-04-14 09:49:48', 'LCL'),
(194, '06815', 274, 275, '274', '2026-04-09', 31, 'CY to Door', 28, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 10:10:26', '2026-04-14 10:10:26', 'LCL'),
(195, '06822', 302, 303, '302', '2026-04-09', 31, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 10:13:51', '2026-04-15 11:43:14', 'LCL'),
(196, '06823', 276, 277, '276', '2026-04-09', 31, 'CY to Door', 29, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 10:22:30', '2026-04-14 10:22:30', 'LCL'),
(197, '06824', 278, 279, '278', '2026-04-07', 31, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 10:27:25', '2026-04-14 10:27:25', 'LCL'),
(198, '06825', 302, 303, '302', '2026-04-09', 31, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 11:05:55', '2026-04-15 12:25:20', 'LCL'),
(199, '06829', 149, 280, '149', '2026-04-09', 31, 'CY to Door', 30, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 11:27:13', '2026-04-14 11:27:13', 'LCL'),
(200, '06789', 158, 281, '158', '2026-04-07', 32, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 11:44:36', '2026-04-14 11:44:36', 'LCL'),
(201, '06795', 282, 266, '266', '2026-04-08', 32, 'CY to Door', 31, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 11:50:17', '2026-04-14 11:50:17', 'LCL'),
(202, '06808', 158, 281, '158', '2026-04-08', 32, 'CY to CY', 6, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-14 11:53:31', '2026-04-14 11:53:31', 'LCL'),
(203, '06812', 283, 284, '283', '2026-04-09', 32, 'CY to CY', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 12:02:14', '2026-04-14 12:02:14', 'LCL'),
(204, '06813', 285, 63, '41', '2026-04-09', 32, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 12:06:28', '2026-04-14 12:06:28', 'LCL'),
(205, '06820', 286, 287, '286', '2026-04-09', 32, 'CY to Door', 32, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 12:14:39', '2026-04-14 12:14:39', 'LCL'),
(206, '06828', 39, 40, '39', '2026-04-09', 32, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-14 12:20:19', '2026-04-14 12:20:19', 'LCL'),
(207, '06831', 313, 289, '313', '2026-04-09', 32, 'CY to Door', 14, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-15 01:52:04', '2026-04-15 13:09:07', 'LCL'),
(208, '06833', 290, 59, '59', '2026-04-09', 32, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-15 02:00:32', '2026-04-15 02:00:32', 'LCL'),
(213, '06737', 39, 40, '39', '2026-04-02', 29, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-15 12:19:38', '2026-04-15 12:19:38', 'LCL'),
(214, 'O6752', 314, 315, '314', '2026-04-04', 29, 'CY to Door', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-15 13:20:01', '2026-04-15 13:20:01', 'LCL'),
(215, '06959', 316, 69, '69', '2026-04-14', 33, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-16 02:55:11', '2026-04-16 02:55:11', 'LCL'),
(216, '06964', 39, 40, '39', '2026-04-14', 33, 'CY to CY', 6, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-16 03:04:27', '2026-04-16 03:04:27', 'LCL'),
(217, '06811', 319, 320, '319', '2026-04-09', 34, 'CY to CY', 3, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-16 04:17:32', '2026-04-16 04:17:32', 'LCL'),
(218, '06814', 81, 101, '81', '2026-04-09', 34, 'CY to Door', 34, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-16 04:22:19', '2026-04-16 04:22:19', 'LCL'),
(219, '06826', 321, 322, '321', '2026-04-09', 34, 'CY to Door', 7, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-16 04:40:31', '2026-04-16 04:40:31', 'LCL'),
(220, '06827', 321, 324, '321', '2026-04-09', 34, 'CY to Door', 9, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-16 05:49:51', '2026-04-16 05:49:51', 'FCL'),
(221, '06844', 44, 325, '23', '2026-04-11', 34, 'CY to Door', 7, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-16 06:03:07', '2026-04-16 06:03:07', 'LCL'),
(222, '06845', 312, 326, '312', '2026-04-11', 34, 'CY to Door', 35, 'Tahan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-16 06:11:48', '2026-04-16 06:11:48', 'LCL'),
(223, '06952', 160, 327, '160', '2026-04-13', 34, 'CY to Door', 36, 'Tahan', NULL, 'Pengirim', 1, 'Non PKP', NULL, '2026-04-16 06:16:32', '2026-04-16 06:16:32', 'LCL'),
(224, '06962', 81, 220, '81', '2026-04-14', 34, 'CY to Door', 8, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-16 06:19:48', '2026-04-16 06:19:48', 'LCL'),
(225, '06965', 317, 318, '317', '2026-04-14', 33, 'CY to Door', 37, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-16 07:16:41', '2026-04-16 07:16:41', 'LCL'),
(226, '06968', 328, 329, '328', '2026-04-14', 33, 'CY to Door', 4, 'Tahan', NULL, 'SCJ', 1, 'PKP', NULL, '2026-04-16 07:31:31', '2026-04-16 07:31:31', 'LCL'),
(227, '06969', 67, 330, '67', '2026-04-14', 33, 'CY to Door', 38, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-16 07:38:38', '2026-04-16 07:38:38', 'LCL'),
(228, '06960', 331, 332, '331', '2026-04-14', 33, 'CY to Door', 39, 'Tahan', NULL, 'Pengirim', 1, 'PKP', NULL, '2026-04-16 07:51:50', '2026-04-16 07:51:50', 'LCL');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_additional_fees`
--

CREATE TABLE `invoice_additional_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_additional_fees`
--

INSERT INTO `invoice_additional_fees` (`id`, `invoice_id`, `nama`, `harga`) VALUES
(7, 52, 'Jasa Jemput', 3000000),
(8, 20, 'Jasa Forklift', 250000),
(9, 36, 'Jasa Forklift', 400000),
(10, 68, 'Jasa Bongkar', 150000),
(11, 73, 'Jasa Forklift', 250000),
(12, 75, 'Jasa Door Ke Maros', 125000),
(33, 102, 'Jasa Forklift', 250000),
(34, 102, 'Jasa Door', 1500000),
(39, 123, 'Jasa Forklift', 100000),
(40, 107, 'Jasa Forklift', 250000),
(43, 90, 'Jasa Forklift', 300000),
(44, 90, 'Jasa Jemput', 350000),
(45, 131, 'Jasa Bongkar', 150000),
(47, 139, 'BIAYA FROKLIFT', 250000),
(48, 130, 'Jasa Forklift', 250000),
(51, 77, 'Jasa Forklift', 200000),
(53, 161, 'Jasa Forklift', 250000),
(56, 163, 'Jasa Forklift', 350000),
(57, 217, 'BIAYA FROKLIFT', 300000),
(58, 225, 'BIAYA DOOR KE TONDANO', 3000000),
(59, 228, 'BIAYA FROKLIFT', 250000);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_barang` varchar(255) NOT NULL,
  `koli` int(11) NOT NULL,
  `p` decimal(12,2) DEFAULT NULL,
  `l` decimal(12,2) DEFAULT NULL,
  `t` decimal(12,2) DEFAULT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `satuan` enum('M3','Kg','Unit') NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `jenis_barang`, `koli`, `p`, `l`, `t`, `jumlah`, `satuan`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(53, 26, 'Dus, Meja Kuning, Plastik Hijau', 9, NULL, NULL, NULL, 1.830, 'M3', 700000.00, 1281000.00, '2026-03-30 03:03:38', '2026-03-30 03:03:38'),
(54, 27, 'Dus', 3, NULL, NULL, NULL, 1.000, 'M3', 700000.00, 700000.00, '2026-03-30 03:04:06', '2026-03-30 03:04:06'),
(56, 29, 'Booller Conveyor (karungan)', 18, NULL, NULL, NULL, 1.000, 'M3', 700000.00, 700000.00, '2026-03-30 03:05:01', '2026-03-30 03:05:01'),
(64, 37, 'Dus & Koper', 17, NULL, NULL, NULL, 1.060, 'M3', 700000.00, 742000.00, '2026-03-30 03:09:37', '2026-03-30 03:09:37'),
(65, 38, 'Paketan', 8, NULL, NULL, NULL, 0.500, 'M3', 650000.00, 325000.00, '2026-03-30 03:13:34', '2026-03-30 03:13:34'),
(68, 39, 'Dus Lapban', 20, NULL, NULL, NULL, 0.780, 'M3', 650000.00, 505050.00, '2026-03-30 04:24:10', '2026-03-30 04:24:10'),
(69, 40, 'Tray Plate Food, Food Tray Cover', 106, NULL, NULL, NULL, 16.500, 'M3', 650000.00, 10726300.00, '2026-03-30 05:00:13', '2026-03-30 05:00:13'),
(70, 41, 'Campuran', 593, NULL, NULL, NULL, 10.210, 'M3', 650000.00, 6633900.00, '2026-03-30 05:49:36', '2026-03-30 05:49:36'),
(72, 43, 'Peti', 4, NULL, NULL, NULL, 1.110, 'M3', 650000.00, 722150.00, '2026-03-30 06:06:23', '2026-03-30 06:06:23'),
(74, 45, 'Kursi Susun Warna Merah', 10, NULL, NULL, NULL, 2.770, 'M3', 700000.00, 1940400.00, '2026-03-30 08:07:02', '2026-03-30 08:07:02'),
(75, 46, 'Barang Pindahan', 18, NULL, NULL, NULL, 4.260, 'M3', 700000.00, 2979900.00, '2026-03-30 08:28:43', '2026-03-30 08:28:43'),
(76, 47, 'Kursi Susun Warna Merah', 10, NULL, NULL, NULL, 2.770, 'M3', 700000.00, 1940400.00, '2026-03-30 08:31:08', '2026-03-30 08:31:08'),
(77, 48, 'Kosmetik', 16, NULL, NULL, NULL, 1.970, 'M3', 700000.00, 1379000.00, '2026-03-30 08:36:55', '2026-03-30 08:36:55'),
(78, 49, 'kosmetik', 21, NULL, NULL, NULL, 2.770, 'M3', 700000.00, 1939700.00, '2026-03-30 08:40:54', '2026-03-30 08:40:54'),
(79, 50, 'Ac Out In Door', 21, NULL, NULL, NULL, 4.600, 'M3', 675000.00, 3107700.00, '2026-03-30 09:05:07', '2026-03-30 09:05:07'),
(80, 51, 'Dus Bumbu', 350, NULL, NULL, NULL, 6.060, 'M3', 700000.00, 4238500.00, '2026-03-30 09:14:46', '2026-03-30 09:14:46'),
(81, 52, 'Mobil Nissan March Z 1327 GE', 1, NULL, NULL, NULL, 1.000, 'Unit', 12000000.00, 12000000.00, '2026-03-30 09:42:31', '2026-03-30 09:42:31'),
(82, 52, 'Dus', 11, NULL, NULL, NULL, 1.000, 'M3', 700000.00, 700000.00, '2026-03-30 09:42:31', '2026-03-30 09:42:31'),
(84, 54, 'GENSET', 2, NULL, NULL, NULL, 2.810, 'M3', 650000.00, 1825200.00, '2026-03-30 10:49:52', '2026-03-30 10:49:52'),
(85, 55, 'ALAT TEKNIK', 45, NULL, NULL, NULL, 1.800, 'M3', 670000.00, 1206000.00, '2026-03-30 10:56:17', '2026-03-30 10:56:17'),
(93, 34, 'Motor Aerox B 4797 Sqq', 1, NULL, NULL, NULL, 1.000, 'Unit', 1600000.00, 1600000.00, '2026-03-31 10:35:38', '2026-03-31 10:35:38'),
(94, 42, 'Jerigen', 5, NULL, NULL, NULL, 0.180, 'M3', 650000.00, 117650.00, '2026-04-01 03:35:17', '2026-04-01 03:35:17'),
(95, 23, 'Dus', 1530, NULL, NULL, NULL, 14.930, 'M3', 650000.00, 9701250.00, '2026-04-01 04:05:14', '2026-04-01 04:05:14'),
(96, 22, 'Dus & Pipa Knalpot', 73, NULL, NULL, NULL, 5.640, 'M3', 650000.00, 3667950.00, '2026-04-01 05:11:09', '2026-04-01 05:11:09'),
(97, 21, 'Dus, Peti, Ban Luar, Besi Per & Knalpot, Drigen', 607, NULL, NULL, NULL, 18.980, 'M3', 650000.00, 12339600.00, '2026-04-01 05:17:46', '2026-04-01 05:17:46'),
(98, 20, 'P.kayu, Panel, Solar', 1, NULL, NULL, NULL, 2.950, 'M3', 700000.00, 2063600.00, '2026-04-01 05:23:04', '2026-04-01 05:23:04'),
(99, 35, 'Paketan', 1, NULL, NULL, NULL, 0.010, 'M3', 700000.00, 3500.00, '2026-04-01 05:30:31', '2026-04-01 05:30:31'),
(101, 31, 'Plastik Pakum', 16, NULL, NULL, NULL, 1.270, 'M3', 650000.00, 823550.00, '2026-04-01 07:43:05', '2026-04-01 07:43:05'),
(102, 36, 'Track Link Assy', 2, NULL, NULL, NULL, 5.210, 'M3', 700000.00, 3645600.00, '2026-04-01 07:48:27', '2026-04-01 07:48:27'),
(104, 30, 'Campuran', 61, NULL, NULL, NULL, 14.710, 'M3', 700000.00, 10299800.00, '2026-04-01 08:05:46', '2026-04-01 08:05:46'),
(106, 25, 'Dus & Peti Kecil', 2, NULL, NULL, NULL, 0.220, 'M3', 700000.00, 156100.00, '2026-04-01 10:23:06', '2026-04-01 10:23:06'),
(110, 59, 'AC OUT IN DOOR & ACCESSORIES', 27, NULL, NULL, NULL, 4.790, 'M3', 575000.00, 2754250.00, '2026-04-02 09:55:00', '2026-04-02 09:55:00'),
(111, 60, 'MESIN & PERLENGKAPAN KAPAL', 3, NULL, NULL, NULL, 6.340, 'M3', 600000.00, 3805800.00, '2026-04-02 10:02:11', '2026-04-02 10:02:11'),
(113, 62, 'PALET MESIN & PETI', 2, NULL, NULL, NULL, 1500.000, 'Kg', 4000.00, 6000000.00, '2026-04-02 10:30:56', '2026-04-02 10:30:56'),
(114, 44, 'Batrai', 7, NULL, NULL, NULL, 1.000, 'M3', 700000.00, 700000.00, '2026-04-03 09:23:36', '2026-04-03 09:23:36'),
(116, 64, 'DUS PESTISIDA', 39, NULL, NULL, NULL, 2.120, 'M3', 600000.00, 1272600.00, '2026-04-03 10:16:05', '2026-04-03 10:16:05'),
(117, 65, 'KARUNG BENIH', 48, NULL, NULL, NULL, 3.710, 'M3', 650000.00, 2410850.00, '2026-04-03 10:28:03', '2026-04-03 10:28:03'),
(118, 66, 'DUS, EMBER, BLEK', 205, NULL, NULL, NULL, 6.620, 'M3', 575000.00, 3807075.00, '2026-04-03 10:39:17', '2026-04-03 10:39:17'),
(119, 67, 'KARUNGAN', 20, NULL, NULL, NULL, 1.000, 'M3', 575000.00, 575000.00, '2026-04-03 10:45:44', '2026-04-03 10:45:44'),
(120, 68, 'DUS', 59, NULL, NULL, NULL, 2.500, 'M3', 575000.00, 1437500.00, '2026-04-03 11:01:32', '2026-04-03 11:01:32'),
(121, 69, 'DUS PUPUK MERK KENZO', 114, NULL, NULL, NULL, 4.220, 'M3', 650000.00, 2741050.00, '2026-04-03 11:09:21', '2026-04-03 11:09:21'),
(122, 32, 'Ball Karungan', 2, NULL, NULL, NULL, 0.690, 'M3', 650000.00, 451100.00, '2026-04-04 02:26:49', '2026-04-04 02:26:49'),
(124, 70, 'DUS', 25, NULL, NULL, NULL, 1.100, 'M3', 1075000.00, 1182500.00, '2026-04-04 02:43:16', '2026-04-04 02:43:16'),
(126, 72, 'DUS', 6, NULL, NULL, NULL, 0.920, 'M3', 600000.00, 550200.00, '2026-04-04 03:07:25', '2026-04-04 03:07:25'),
(127, 71, 'DUS ALAT PDAM', 37, NULL, NULL, NULL, 1.000, 'M3', 1300000.00, 1300000.00, '2026-04-04 03:08:44', '2026-04-04 03:08:44'),
(128, 73, 'PALET RAPING HITAM', 2, NULL, NULL, NULL, 1.480, 'M3', 1350000.00, 1995300.00, '2026-04-04 03:15:07', '2026-04-04 03:15:07'),
(129, 53, 'Dusan', 100, NULL, NULL, NULL, 7.500, 'M3', 700000.00, 5247900.00, '2026-04-04 03:21:05', '2026-04-04 03:21:05'),
(130, 74, 'PAKETAN', 1, NULL, NULL, NULL, 0.300, 'M3', 600000.00, 180000.00, '2026-04-04 03:41:15', '2026-04-04 03:41:15'),
(131, 75, 'P.KAYU & PAKETAN', 4, NULL, NULL, NULL, 0.700, 'M3', 600000.00, 420000.00, '2026-04-04 03:45:38', '2026-04-04 03:45:38'),
(135, 79, 'DUS FOOD TRAY', 60, NULL, NULL, NULL, 2.580, 'M3', 600000.00, 1547400.00, '2026-04-04 04:24:53', '2026-04-04 04:24:53'),
(137, 80, 'PAIL, DUS, BLEK, LEM', 354, NULL, NULL, NULL, 7.390, 'M3', 600000.00, 4435800.00, '2026-04-04 09:11:40', '2026-04-04 09:11:40'),
(148, 85, 'SET TOWER & ACCESSORIES', 1, NULL, NULL, NULL, 4.000, 'M3', 575000.00, 2300000.00, '2026-04-06 05:23:47', '2026-04-06 05:23:47'),
(152, 61, 'DUSAN', 41, NULL, NULL, NULL, 6.593, 'M3', 600000.00, 3955800.00, '2026-04-06 09:39:25', '2026-04-06 09:39:25'),
(153, 56, 'PETI, DUS & KERANJANG RAPINGAN', 15, NULL, NULL, NULL, 14.131, 'M3', 600000.00, 8478600.00, '2026-04-06 09:40:39', '2026-04-06 09:40:39'),
(155, 58, 'AC OUT IN DOOR', 14, NULL, NULL, NULL, 2.556, 'M3', 575000.00, 1469700.00, '2026-04-06 09:47:51', '2026-04-06 09:47:51'),
(156, 76, 'DUS & P.KAYU', 4, NULL, NULL, NULL, 1.069, 'M3', 1300000.00, 1389700.00, '2026-04-06 09:50:09', '2026-04-06 09:50:09'),
(158, 84, 'DUS PESTISIDA', 120, NULL, NULL, NULL, 3.038, 'M3', 600000.00, 1822800.00, '2026-04-06 09:53:56', '2026-04-06 09:53:56'),
(159, 82, 'DUS RAPING HITAM (SIRUP)', 6, NULL, NULL, NULL, 0.500, 'M3', 575000.00, 287500.00, '2026-04-06 09:55:53', '2026-04-06 09:55:53'),
(160, 86, 'PAKET (BAN)', 2, NULL, NULL, NULL, 0.307, 'M3', 600000.00, 184200.00, '2026-04-06 09:56:41', '2026-04-06 09:56:41'),
(190, 63, 'DUS PUPUK PESTISIDA', 39, NULL, NULL, NULL, 2.121, 'M3', 1200000.00, 2545200.00, '2026-04-08 04:19:21', '2026-04-08 04:19:21'),
(191, 83, 'DUS PESTISIDA', 110, NULL, NULL, NULL, 3.065, 'M3', 1200000.00, 3678000.00, '2026-04-08 04:23:50', '2026-04-08 04:23:50'),
(192, 87, 'DUS', 19, NULL, NULL, NULL, 1.000, 'M3', 1275000.00, 1275000.00, '2026-04-08 04:36:29', '2026-04-08 04:36:29'),
(193, 88, 'DUS', 37, NULL, NULL, NULL, 1.800, 'M3', 675000.00, 1215000.00, '2026-04-08 04:39:58', '2026-04-08 04:39:58'),
(194, 89, 'GENSET', 4, NULL, NULL, NULL, 21.820, 'M3', 700000.00, 15274000.00, '2026-04-08 04:43:25', '2026-04-08 04:43:25'),
(196, 91, 'PENGERING, FOOD TRAY, OVEN', 32, NULL, NULL, NULL, 3.370, 'M3', 650000.00, 2190500.00, '2026-04-08 04:48:49', '2026-04-08 04:48:49'),
(202, 113, 'DUS (MERK MENTERI PERTAHANAN)', 246, NULL, NULL, NULL, 15.333, 'M3', 700000.00, 10733100.00, '2026-04-08 05:05:38', '2026-04-08 05:05:38'),
(203, 97, 'PIPA HDPE TELKOM', 13, NULL, NULL, NULL, 9.430, 'M3', 700000.00, 6601000.00, '2026-04-08 05:06:25', '2026-04-08 05:06:25'),
(204, 98, 'DUS & KAIN ROLL', 105, NULL, NULL, NULL, 2.210, 'M3', 725000.00, 1602250.00, '2026-04-08 05:07:19', '2026-04-08 05:07:19'),
(206, 100, 'P.KAYU RAPINGAN', 3, NULL, NULL, NULL, 101.000, 'Kg', 11000.00, 1111000.00, '2026-04-08 05:10:38', '2026-04-08 05:10:38'),
(209, 103, 'KARUNGAN', 8, NULL, NULL, NULL, 1.000, 'M3', 700000.00, 700000.00, '2026-04-08 05:17:47', '2026-04-08 05:17:47'),
(210, 104, 'KAIN ROLL (KARUNGAN)', 96, NULL, NULL, NULL, 15.160, 'M3', 725000.00, 10991000.00, '2026-04-08 05:18:36', '2026-04-08 05:18:36'),
(216, 110, 'PAKET', 5, NULL, NULL, NULL, 1.000, 'M3', 700000.00, 700000.00, '2026-04-08 05:28:46', '2026-04-08 05:28:46'),
(217, 111, 'DUS', 1204, NULL, NULL, NULL, 13.686, 'M3', 650000.00, 8895900.00, '2026-04-08 05:30:04', '2026-04-08 05:30:04'),
(218, 112, 'PAKET', 6, NULL, NULL, NULL, 0.290, 'M3', 650000.00, 188500.00, '2026-04-08 05:30:53', '2026-04-08 05:30:53'),
(220, 115, 'DUS', 6, NULL, NULL, NULL, 1.000, 'M3', 700000.00, 700000.00, '2026-04-08 06:46:11', '2026-04-08 06:46:11'),
(238, 114, 'DUS & DRIGEN', 104, NULL, NULL, NULL, 3.320, 'M3', 700000.00, 2324000.00, '2026-04-10 03:49:16', '2026-04-10 03:49:16'),
(242, 118, 'DUS & KARUNG', 48, NULL, NULL, NULL, 7.161, 'M3', 850000.00, 6086850.00, '2026-04-10 07:26:18', '2026-04-10 07:26:18'),
(244, 102, 'PETI', 2, NULL, NULL, NULL, 2.472, 'M3', 700000.00, 1730400.00, '2026-04-10 07:32:06', '2026-04-10 07:32:06'),
(245, 105, 'PIPA REFRIGRANT', 5, NULL, NULL, NULL, 1.918, 'M3', 1275000.00, 2445450.00, '2026-04-10 07:37:25', '2026-04-10 07:37:25'),
(246, 121, 'DUS PESTISIDA', 101, NULL, NULL, NULL, 2.578, 'M3', 700000.00, 1804600.00, '2026-04-10 07:37:35', '2026-04-10 07:37:35'),
(248, 106, 'P.KAYU', 49, NULL, NULL, NULL, 5.667, 'M3', 700000.00, 3966900.00, '2026-04-10 07:43:07', '2026-04-10 07:43:07'),
(252, 95, 'PALET, KARET KAPAL', 3, NULL, NULL, NULL, 5.363, 'M3', 650000.00, 3485950.00, '2026-04-10 08:03:44', '2026-04-10 08:03:44'),
(253, 93, 'BALL KARUNG', 4, NULL, NULL, NULL, 1.263, 'M3', 725000.00, 915675.00, '2026-04-10 08:05:49', '2026-04-10 08:05:49'),
(254, 94, 'DUS', 58, NULL, NULL, NULL, 1.382, 'M3', 650000.00, 898300.00, '2026-04-10 08:08:53', '2026-04-10 08:08:53'),
(255, 96, 'DUS KARUNGAN', 6, NULL, NULL, NULL, 0.639, 'M3', 700000.00, 447300.00, '2026-04-10 08:12:18', '2026-04-10 08:12:18'),
(258, 126, 'DRUM WARNA BIRU', 15, NULL, NULL, NULL, 5.023, 'M3', 875000.00, 4395125.00, '2026-04-10 10:56:20', '2026-04-10 10:56:20'),
(259, 123, 'HASBEL, KABEL, CAMPURAN', 7, NULL, NULL, NULL, 1.021, 'M3', 750000.00, 765750.00, '2026-04-11 10:04:16', '2026-04-11 10:04:16'),
(260, 107, 'SPARE PART/BESI PLAT', 26, NULL, NULL, NULL, 10.000, 'M3', 650000.00, 6500000.00, '2026-04-11 10:59:32', '2026-04-11 10:59:32'),
(261, 109, 'PAKET', 1, NULL, NULL, NULL, 1.000, 'M3', 100000.00, 100000.00, '2026-04-11 11:00:36', '2026-04-11 11:00:36'),
(262, 122, 'DUS & P.KAYU', 84, NULL, NULL, NULL, 5.588, 'M3', 750000.00, 4191000.00, '2026-04-11 11:01:26', '2026-04-11 11:01:26'),
(265, 90, 'PETI', 3, NULL, NULL, NULL, 1.393, 'M3', 700000.00, 975100.00, '2026-04-11 11:07:45', '2026-04-11 11:07:45'),
(266, 99, 'ALAT PDAM', 4, NULL, NULL, NULL, 1.000, 'M3', 750000.00, 750000.00, '2026-04-11 11:09:04', '2026-04-11 11:09:04'),
(269, 129, 'BUKU', 8, NULL, NULL, NULL, 164.200, 'Kg', 5000.00, 821000.00, '2026-04-13 02:08:39', '2026-04-13 02:08:39'),
(271, 131, 'DUS', 57, NULL, NULL, NULL, 1.000, 'M3', 675000.00, 675000.00, '2026-04-13 02:18:34', '2026-04-13 02:18:34'),
(277, 137, 'DUS', 45, NULL, NULL, NULL, 3.870, 'M3', 650000.00, 2515500.00, '2026-04-13 02:52:45', '2026-04-13 02:52:45'),
(280, 140, 'DUS KARUNGAN', 9, NULL, NULL, NULL, 1.059, 'M3', 650000.00, 688350.00, '2026-04-13 03:23:07', '2026-04-13 03:23:07'),
(281, 141, 'KAIN ROLL', 34, NULL, NULL, NULL, 3.470, 'M3', 600000.00, 2082000.00, '2026-04-13 03:27:30', '2026-04-13 03:27:30'),
(286, 128, 'DRUM WARNA HITAM', 2, NULL, NULL, NULL, 1.000, 'M3', 1000000.00, 1000000.00, '2026-04-13 04:56:25', '2026-04-13 04:56:25'),
(287, 144, 'PLASTIK', 178, NULL, NULL, NULL, 7.744, 'M3', 600000.00, 4646400.00, '2026-04-13 04:59:31', '2026-04-13 04:59:31'),
(290, 147, 'DUS & KARUNG MERK R2M', 17, NULL, NULL, NULL, 1.117, 'M3', 650000.00, 726050.00, '2026-04-13 05:10:48', '2026-04-13 05:10:48'),
(291, 148, 'DUS', 1713, NULL, NULL, NULL, 18.072, 'M3', 650000.00, 11746800.00, '2026-04-13 05:13:04', '2026-04-13 05:13:04'),
(292, 149, 'PAKETAN', 11, NULL, NULL, NULL, 0.878, 'M3', 650000.00, 570700.00, '2026-04-13 05:17:10', '2026-04-13 05:17:10'),
(293, 149, 'PAKETAN', 5, NULL, NULL, NULL, 0.591, 'M3', 650000.00, 384150.00, '2026-04-13 05:17:10', '2026-04-13 05:17:10'),
(294, 150, 'DUS FURNITURE', 38, NULL, NULL, NULL, 2.599, 'M3', 650000.00, 1689350.00, '2026-04-13 05:20:31', '2026-04-13 05:20:31'),
(296, 152, 'KARUNG PLASTIK', 86, NULL, NULL, NULL, 4.272, 'M3', 1300000.00, 5553600.00, '2026-04-13 08:11:52', '2026-04-13 08:11:52'),
(297, 153, 'LAMPU SOROT, HOIST', 18, NULL, NULL, NULL, 295.000, 'Kg', 10000.00, 2950000.00, '2026-04-13 08:15:40', '2026-04-13 08:15:40'),
(298, 92, 'DUS RAPING HITAM', 3, NULL, NULL, NULL, 50.000, 'Kg', 5000.00, 250000.00, '2026-04-13 08:52:34', '2026-04-13 08:52:34'),
(300, 155, 'DUS', 197, NULL, NULL, NULL, 2.410, 'M3', 650000.00, 1566500.00, '2026-04-13 09:17:38', '2026-04-13 09:17:38'),
(301, 151, 'DUS KARUNGAN', 3, NULL, NULL, NULL, 0.904, 'M3', 650000.00, 587600.00, '2026-04-13 09:18:56', '2026-04-13 09:18:56'),
(302, 143, 'DUS & KARUNG', 97, NULL, NULL, NULL, 4.933, 'M3', 650000.00, 3206450.00, '2026-04-13 09:20:21', '2026-04-13 09:20:21'),
(303, 143, 'DUS', 1, NULL, NULL, NULL, 1.000, 'M3', 650000.00, 650000.00, '2026-04-13 09:20:21', '2026-04-13 09:20:21'),
(304, 142, 'DUS', 18, NULL, NULL, NULL, 1.000, 'M3', 1200000.00, 1200000.00, '2026-04-13 09:20:43', '2026-04-13 09:20:43'),
(305, 145, 'DUS', 20, NULL, NULL, NULL, 1.110, 'M3', 650000.00, 721500.00, '2026-04-13 09:21:19', '2026-04-13 09:21:19'),
(306, 146, 'DUS PLASTIK/ PLAFON', 32, NULL, NULL, NULL, 1.555, 'M3', 675000.00, 1049625.00, '2026-04-13 09:21:48', '2026-04-13 09:21:48'),
(307, 139, 'SPARE PART', 69, NULL, NULL, NULL, 18.642, 'M3', 600000.00, 11185200.00, '2026-04-13 09:23:12', '2026-04-13 09:23:12'),
(308, 156, 'DUS & KARUNG', 14, NULL, NULL, NULL, 1.650, 'M3', 1200000.00, 1980000.00, '2026-04-13 09:27:40', '2026-04-13 09:27:40'),
(309, 28, 'Peti Kecil & Plastik Merah', 2, NULL, NULL, NULL, 0.042, 'M3', 650000.00, 27300.00, '2026-04-13 09:30:38', '2026-04-13 09:30:38'),
(310, 157, 'DUS', 20, NULL, NULL, NULL, 1.000, 'M3', 650000.00, 650000.00, '2026-04-13 09:32:28', '2026-04-13 09:32:28'),
(312, 158, 'DUS NISUMA', 13, NULL, NULL, NULL, 0.780, 'M3', 670000.00, 522600.00, '2026-04-13 10:47:05', '2026-04-13 10:47:05'),
(313, 159, 'DUS', 10, NULL, NULL, NULL, 0.680, 'M3', 600000.00, 408000.00, '2026-04-13 10:51:35', '2026-04-13 10:51:35'),
(314, 160, 'P.KAYU', 2, NULL, NULL, NULL, 0.500, 'M3', 1200000.00, 600000.00, '2026-04-13 10:55:22', '2026-04-13 10:55:22'),
(316, 81, 'PLAT GORONG-GORONG & DRUM KECIL', 10, NULL, NULL, NULL, 12.034, 'M3', 575000.00, 6919550.00, '2026-04-14 02:18:36', '2026-04-14 02:18:36'),
(317, 33, 'Dus', 10, NULL, NULL, NULL, 0.690, 'M3', 725000.00, 500250.00, '2026-04-14 02:22:03', '2026-04-14 02:22:03'),
(318, 124, 'PAIL, DUS, BLEK', 693, NULL, NULL, NULL, 16.812, 'M3', 650000.00, 10927800.00, '2026-04-14 04:02:36', '2026-04-14 04:02:36'),
(319, 125, 'DUS & CAT', 16, NULL, NULL, NULL, 0.679, 'M3', 650000.00, 441350.00, '2026-04-14 04:05:19', '2026-04-14 04:05:19'),
(320, 135, 'TERPAL', 4, NULL, NULL, NULL, 0.470, 'M3', 650000.00, 305500.00, '2026-04-14 04:06:23', '2026-04-14 04:06:23'),
(321, 127, 'ROLING DOOR', 18, NULL, NULL, NULL, 2.440, 'M3', 650000.00, 1586000.00, '2026-04-14 04:11:26', '2026-04-14 04:11:26'),
(322, 130, 'BESI CRUP CNP', 3, NULL, NULL, NULL, 4.544, 'M3', 650000.00, 2953600.00, '2026-04-14 04:13:31', '2026-04-14 04:13:31'),
(323, 132, 'ROLING DOOR & CAT', 90, NULL, NULL, NULL, 13.895, 'M3', 650000.00, 9031750.00, '2026-04-14 04:15:30', '2026-04-14 04:15:30'),
(324, 134, 'DUS', 16, NULL, NULL, NULL, 1.000, 'M3', 675000.00, 675000.00, '2026-04-14 04:18:56', '2026-04-14 04:18:56'),
(325, 136, 'AC OUT IN DOOR', 174, NULL, NULL, NULL, 36.124, 'M3', 1250000.00, 45155000.00, '2026-04-14 04:21:37', '2026-04-14 04:21:37'),
(326, 133, 'JUNGLE STORYEGG, TOOTH PICK, SCOURING PAD, STAINLESS STEEL SCRUB', 13, NULL, NULL, NULL, 1.000, 'M3', 1300000.00, 1300000.00, '2026-04-14 04:23:00', '2026-04-14 04:23:00'),
(327, 119, 'ALAT-ALAT AKSESORIS', 33, NULL, NULL, NULL, 2.184, 'M3', 1250000.00, 2730000.00, '2026-04-14 05:13:06', '2026-04-14 05:13:06'),
(329, 117, 'AKSESORIS INTERNET', 9, NULL, NULL, NULL, 1.000, 'M3', 850000.00, 850000.00, '2026-04-14 05:24:02', '2026-04-14 05:24:02'),
(340, 172, 'DUS', 9, NULL, NULL, NULL, 1.000, 'M3', 750000.00, 750000.00, '2026-04-14 06:17:15', '2026-04-14 06:17:15'),
(360, 78, 'ALAT KONTRUKSI, BESI, CEROBONG UAP', 65, NULL, NULL, NULL, 20.794, 'M3', 575000.00, 11956550.00, '2026-04-14 09:34:54', '2026-04-14 09:34:54'),
(361, 77, 'PLAT GORONG-GORONG & DRUM KECIL', 6, NULL, NULL, NULL, 6.995, 'M3', 575000.00, 4022125.00, '2026-04-14 09:35:38', '2026-04-14 09:35:38'),
(382, 116, 'ALAT-ALAT MBG', 86, NULL, NULL, NULL, 13.180, 'M3', 950000.00, 12521000.00, '2026-04-15 08:26:56', '2026-04-15 08:26:56'),
(387, 161, 'KARUNG PASIR & ROLL ORANGE MERK CNE', 45, NULL, NULL, NULL, 5.656, 'M3', 750000.00, 4242000.00, '2026-04-15 10:14:33', '2026-04-15 10:14:33'),
(388, 162, 'KARUNG PLASTIK', 198, NULL, NULL, NULL, 9.658, 'M3', 725000.00, 7002050.00, '2026-04-15 10:15:54', '2026-04-15 10:15:54'),
(391, 164, 'HAND PALLET', 1, NULL, NULL, NULL, 0.999, 'M3', 750000.00, 749250.00, '2026-04-15 10:24:51', '2026-04-15 10:24:51'),
(392, 165, 'X EXCA MINI, KUNCI & PERALATAN EXCA', 1, NULL, NULL, NULL, 0.000, 'Unit', 5000000.00, 5000000.00, '2026-04-15 10:32:51', '2026-04-15 10:32:51'),
(393, 166, 'DUS', 70, NULL, NULL, NULL, 2.840, 'M3', 750000.00, 2130000.00, '2026-04-15 10:35:35', '2026-04-15 10:35:35'),
(394, 167, 'KAIN KRAS', 5, NULL, NULL, NULL, 0.700, 'M3', 725000.00, 507500.00, '2026-04-15 10:37:15', '2026-04-15 10:37:15'),
(395, 168, 'ALAT-ALAT PDAM', 251, NULL, NULL, NULL, 14.423, 'M3', 750000.00, 10817250.00, '2026-04-15 10:40:25', '2026-04-15 10:40:25'),
(396, 169, 'TEXTIL', 1, NULL, NULL, NULL, 0.598, 'M3', 725000.00, 433550.00, '2026-04-15 10:42:22', '2026-04-15 10:42:22'),
(397, 170, 'DUS', 15, NULL, NULL, NULL, 1.000, 'M3', 750000.00, 750000.00, '2026-04-15 10:44:12', '2026-04-15 10:44:12'),
(398, 171, 'DUS & PETI', 42, NULL, NULL, NULL, 1.355, 'M3', 750000.00, 1016250.00, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(399, 173, 'PALET & PETI', 4, NULL, NULL, NULL, 5.308, 'M3', 750000.00, 3981000.00, '2026-04-15 10:48:33', '2026-04-15 10:48:33'),
(400, 174, 'DUS', 29, NULL, NULL, NULL, 2.370, 'M3', 1200000.00, 2844000.00, '2026-04-15 10:59:16', '2026-04-15 10:59:16'),
(401, 175, 'DUS', 8, NULL, NULL, NULL, 1.000, 'M3', 775000.00, 775000.00, '2026-04-15 11:01:35', '2026-04-15 11:01:35'),
(402, 176, 'PETI & DUS', 2, NULL, NULL, NULL, 0.095, 'M3', 750000.00, 71250.00, '2026-04-15 11:03:09', '2026-04-15 11:03:09'),
(403, 177, 'AC OUT IN DOOR', 41, NULL, NULL, NULL, 7.338, 'M3', 775000.00, 5686950.00, '2026-04-15 11:05:17', '2026-04-15 11:05:17'),
(405, 179, 'MOTOR KAWASAKI NINJA WARNA BIRU', 1, NULL, NULL, NULL, 0.000, 'Unit', 1500000.00, 1500000.00, '2026-04-15 11:08:36', '2026-04-15 11:08:36'),
(406, 180, 'BESI & PETI', 2, NULL, NULL, NULL, 1.880, 'M3', 750000.00, 1410000.00, '2026-04-15 11:09:37', '2026-04-15 11:09:37'),
(407, 181, 'DRIGEN', 90, NULL, NULL, NULL, 2.376, 'M3', 750000.00, 1782000.00, '2026-04-15 11:10:56', '2026-04-15 11:10:56'),
(408, 182, 'SPARE PART', 1, NULL, NULL, NULL, 0.495, 'M3', 750000.00, 371250.00, '2026-04-15 11:12:10', '2026-04-15 11:12:10'),
(409, 185, 'ROL KABEL & PALET SIKA', 13, NULL, NULL, NULL, 5.030, 'M3', 750000.00, 3772500.00, '2026-04-15 11:14:13', '2026-04-15 11:14:13'),
(410, 186, 'AC OUT IN DOOR', 48, NULL, NULL, NULL, 8.766, 'M3', 1350000.00, 11834100.00, '2026-04-15 11:15:28', '2026-04-15 11:15:28'),
(411, 187, 'DUS', 97, NULL, NULL, NULL, 4.968, 'M3', 750000.00, 3726000.00, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(412, 188, 'FOOD TRAY', 70, NULL, NULL, NULL, 2.851, 'M3', 750000.00, 2138250.00, '2026-04-15 11:19:17', '2026-04-15 11:19:17'),
(413, 189, 'DUS', 41, NULL, NULL, NULL, 3.530, 'M3', 1100000.00, 3883000.00, '2026-04-15 11:20:41', '2026-04-15 11:20:41'),
(414, 190, 'DUS CAMPURAN', 621, NULL, NULL, NULL, 14.190, 'M3', 650000.00, 9223500.00, '2026-04-15 11:21:24', '2026-04-15 11:21:24'),
(415, 191, 'KAIN KRAS', 20, NULL, NULL, NULL, 0.423, 'M3', 725000.00, 306675.00, '2026-04-15 11:22:37', '2026-04-15 11:22:37'),
(416, 192, 'PAKET', 6, NULL, NULL, NULL, 0.500, 'M3', 750000.00, 375000.00, '2026-04-15 11:24:36', '2026-04-15 11:24:36'),
(417, 193, 'KANDANG BEBEK', 402, NULL, NULL, NULL, 18.037, 'M3', 750000.00, 13527750.00, '2026-04-15 11:27:20', '2026-04-15 11:27:20'),
(418, 194, 'DUS', 49, NULL, NULL, NULL, 2.871, 'M3', 750000.00, 2153250.00, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(419, 163, 'PALET, DUS RAPING HITAM, P.KAYU', 26, NULL, NULL, NULL, 5.830, 'M3', 750000.00, 4372500.00, '2026-04-15 11:40:30', '2026-04-15 11:40:30'),
(420, 195, 'PETI', 1, NULL, NULL, NULL, 0.130, 'M3', 750000.00, 97500.00, '2026-04-15 11:43:14', '2026-04-15 11:43:14'),
(421, 196, 'DUS', 23, NULL, NULL, NULL, 1.590, 'M3', 750000.00, 1192500.00, '2026-04-15 11:45:03', '2026-04-15 11:45:03'),
(422, 213, 'DUS', 1253, NULL, NULL, NULL, 15.111, 'M3', 650000.00, 9822150.00, '2026-04-15 12:19:38', '2026-04-15 12:19:38'),
(423, 197, 'PAKET', 1, NULL, NULL, NULL, 0.041, 'M3', 750000.00, 30750.00, '2026-04-15 12:23:34', '2026-04-15 12:23:34'),
(424, 198, 'DUS', 2, NULL, NULL, NULL, 0.404, 'M3', 750000.00, 303000.00, '2026-04-15 12:25:20', '2026-04-15 12:25:20'),
(425, 199, 'PETI & KARUNG PUTIH', 13, NULL, NULL, NULL, 1.255, 'M3', 750000.00, 941250.00, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(426, 200, 'PETI', 1, NULL, NULL, NULL, 1.605, 'M3', 750000.00, 1203750.00, '2026-04-15 12:58:02', '2026-04-15 12:58:02'),
(427, 201, 'KABEL', 2, NULL, NULL, NULL, 3.880, 'M3', 750000.00, 2910000.00, '2026-04-15 12:59:46', '2026-04-15 12:59:46'),
(428, 202, 'PETI', 2, NULL, NULL, NULL, 2.969, 'M3', 750000.00, 2226750.00, '2026-04-15 13:01:09', '2026-04-15 13:01:09'),
(429, 203, 'BESI TIANG', 70, NULL, NULL, NULL, 7.096, 'M3', 750000.00, 5322000.00, '2026-04-15 13:02:34', '2026-04-15 13:02:34'),
(430, 204, 'BAN', 2, NULL, NULL, NULL, 0.266, 'M3', 750000.00, 199500.00, '2026-04-15 13:03:56', '2026-04-15 13:03:56'),
(431, 205, 'MOBIL HONDA CITY B. 1599 KBJ & RAPINGAN', 1, NULL, NULL, NULL, 0.000, 'Unit', 12000000.00, 12000000.00, '2026-04-15 13:04:57', '2026-04-15 13:04:57'),
(432, 206, 'DUS CAMPURAN', 283, NULL, NULL, NULL, 9.985, 'M3', 650000.00, 6490250.00, '2026-04-15 13:07:05', '2026-04-15 13:07:05'),
(433, 207, 'PETI KOSMETIK', 83, NULL, NULL, NULL, 3.900, 'M3', 1350000.00, 5265000.00, '2026-04-15 13:09:07', '2026-04-15 13:09:07'),
(434, 208, 'KARUNG PUTIH, LOYANG BESI', 95, NULL, NULL, NULL, 6.484, 'M3', 725000.00, 4700900.00, '2026-04-15 13:10:05', '2026-04-15 13:10:05'),
(435, 214, 'DUS RAPING HITAM & P.KAYU', 11, NULL, NULL, NULL, 1.000, 'M3', 750000.00, 750000.00, '2026-04-15 13:20:01', '2026-04-15 13:20:01'),
(437, 215, 'ROLL, DUS', 16, NULL, NULL, NULL, 2.578, 'M3', 725000.00, 1869050.00, '2026-04-16 03:00:41', '2026-04-16 03:00:41'),
(440, 218, 'AC OUT DOOR & IN DOOR', 42, NULL, NULL, NULL, 7.595, 'M3', 675000.00, 5126625.00, '2026-04-16 04:22:19', '2026-04-16 04:22:19'),
(441, 219, 'PETI KOSMETIK', 23, NULL, NULL, NULL, 1.783, 'M3', 1325000.00, 2362475.00, '2026-04-16 04:40:31', '2026-04-16 04:40:31'),
(443, 221, 'DUS, KALENG CAT', 8, NULL, NULL, NULL, 0.500, 'M3', 1375000.00, 687500.00, '2026-04-16 06:03:07', '2026-04-16 06:03:07'),
(444, 222, 'KARUNG', 2, NULL, NULL, NULL, 0.500, 'M3', 650000.00, 325000.00, '2026-04-16 06:11:48', '2026-04-16 06:11:48'),
(445, 223, 'PETI', 1, NULL, NULL, NULL, 1.000, 'M3', 775000.00, 775000.00, '2026-04-16 06:16:32', '2026-04-16 06:16:32'),
(446, 224, 'AC OUT DOOR & IN DOOR', 22, NULL, NULL, NULL, 4.017, 'M3', 1250000.00, 5021250.00, '2026-04-16 06:19:48', '2026-04-16 06:19:48'),
(447, 217, 'PETI, PALET', 3, NULL, NULL, NULL, 9.979, 'M3', 650000.00, 6486350.00, '2026-04-16 06:20:59', '2026-04-16 06:20:59'),
(448, 220, 'PETI KOSMETIK', 34, NULL, NULL, NULL, 2.714, 'M3', 1250000.00, 3392500.00, '2026-04-16 06:32:19', '2026-04-16 06:32:19'),
(449, 225, 'EXCAVATOR & PERALATAN EXCA', 1, NULL, NULL, NULL, 0.000, 'Unit', 17000000.00, 17000000.00, '2026-04-16 07:16:41', '2026-04-16 07:16:41'),
(450, 226, 'TANGKI BBM 10.000 LITER, TANGGA', 2, NULL, NULL, NULL, 19.662, 'M3', 750000.00, 14746500.00, '2026-04-16 07:31:31', '2026-04-16 07:31:31'),
(451, 216, 'DUS', 196, NULL, NULL, NULL, 3.854, 'M3', 650000.00, 2505100.00, '2026-04-16 07:33:22', '2026-04-16 07:33:22'),
(452, 227, 'DUS S.PART', 7, NULL, NULL, NULL, 0.650, 'M3', 775000.00, 503750.00, '2026-04-16 07:38:38', '2026-04-16 07:38:38'),
(453, 228, 'PALLET, RAPPING HITAM, KABEL AWG', 7, NULL, NULL, NULL, 5.134, 'M3', 775000.00, 3978850.00, '2026-04-16 07:51:50', '2026-04-16 07:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item_details`
--

CREATE TABLE `invoice_item_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_item_id` bigint(20) UNSIGNED NOT NULL,
  `p` decimal(12,2) DEFAULT NULL,
  `l` decimal(12,2) DEFAULT NULL,
  `t` decimal(12,2) DEFAULT NULL,
  `koli` int(11) DEFAULT NULL,
  `jumlah` decimal(12,3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_item_details`
--

INSERT INTO `invoice_item_details` (`id`, `invoice_item_id`, `p`, `l`, `t`, `koli`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 259, 0.00, 0.00, 0.00, 7, 0.000, '2026-04-11 10:04:16', '2026-04-11 10:04:16'),
(2, 260, 0.00, 0.00, 0.00, 26, 0.000, '2026-04-11 10:59:32', '2026-04-11 10:59:32'),
(3, 261, 0.00, 0.00, 0.00, 1, 0.000, '2026-04-11 11:00:36', '2026-04-11 11:00:36'),
(4, 262, 0.00, 0.00, 0.00, 84, 0.000, '2026-04-11 11:01:26', '2026-04-11 11:01:26'),
(7, 265, 0.00, 0.00, 0.00, 3, 0.000, '2026-04-11 11:07:45', '2026-04-11 11:07:45'),
(8, 266, 0.00, 0.00, 0.00, 4, 0.000, '2026-04-11 11:09:04', '2026-04-11 11:09:04'),
(11, 269, 0.00, 0.00, 0.00, 8, 0.000, '2026-04-13 02:08:39', '2026-04-13 02:08:39'),
(13, 271, 0.00, 0.00, 0.00, 57, 0.000, '2026-04-13 02:18:34', '2026-04-13 02:18:34'),
(19, 277, 0.00, 0.00, 0.00, 45, 0.000, '2026-04-13 02:52:45', '2026-04-13 02:52:45'),
(22, 280, 0.00, 0.00, 0.00, 9, 0.000, '2026-04-13 03:23:07', '2026-04-13 03:23:07'),
(23, 281, 0.00, 0.00, 0.00, 34, 0.000, '2026-04-13 03:27:30', '2026-04-13 03:27:30'),
(28, 286, 0.00, 0.00, 0.00, 2, 0.000, '2026-04-13 04:56:25', '2026-04-13 04:56:25'),
(29, 287, 0.00, 0.00, 0.00, 178, 0.000, '2026-04-13 04:59:31', '2026-04-13 04:59:31'),
(32, 290, 0.00, 0.00, 0.00, 17, 0.000, '2026-04-13 05:10:48', '2026-04-13 05:10:48'),
(33, 291, 0.00, 0.00, 0.00, 1713, 0.000, '2026-04-13 05:13:04', '2026-04-13 05:13:04'),
(34, 292, 0.00, 0.00, 0.00, 11, 0.000, '2026-04-13 05:17:10', '2026-04-13 05:17:10'),
(35, 293, 0.00, 0.00, 0.00, 5, 0.000, '2026-04-13 05:17:10', '2026-04-13 05:17:10'),
(36, 294, 0.00, 0.00, 0.00, 38, 0.000, '2026-04-13 05:20:31', '2026-04-13 05:20:31'),
(38, 296, 0.00, 0.00, 0.00, 86, 0.000, '2026-04-13 08:11:52', '2026-04-13 08:11:52'),
(39, 297, 0.00, 0.00, 0.00, 18, 0.000, '2026-04-13 08:15:40', '2026-04-13 08:15:40'),
(40, 298, 0.00, 0.00, 0.00, 3, 0.000, '2026-04-13 08:52:34', '2026-04-13 08:52:34'),
(42, 300, 0.00, 0.00, 0.00, 197, 0.000, '2026-04-13 09:17:38', '2026-04-13 09:17:38'),
(43, 301, 0.00, 0.00, 0.00, 3, 0.000, '2026-04-13 09:18:56', '2026-04-13 09:18:56'),
(44, 302, 0.00, 0.00, 0.00, 97, 0.000, '2026-04-13 09:20:21', '2026-04-13 09:20:21'),
(45, 303, 0.00, 0.00, 0.00, 1, 0.000, '2026-04-13 09:20:21', '2026-04-13 09:20:21'),
(46, 304, 0.00, 0.00, 0.00, 0, 0.000, '2026-04-13 09:20:43', '2026-04-13 09:20:43'),
(47, 305, 0.00, 0.00, 0.00, 20, 0.000, '2026-04-13 09:21:19', '2026-04-13 09:21:19'),
(48, 306, 0.00, 0.00, 0.00, 32, 0.000, '2026-04-13 09:21:48', '2026-04-13 09:21:48'),
(49, 307, 0.00, 0.00, 0.00, 69, 0.000, '2026-04-13 09:23:12', '2026-04-13 09:23:12'),
(50, 308, 0.00, 0.00, 0.00, 14, 0.000, '2026-04-13 09:27:40', '2026-04-13 09:27:40'),
(51, 309, 0.00, 0.00, 0.00, 2, 0.000, '2026-04-13 09:30:38', '2026-04-13 09:30:38'),
(52, 310, 0.00, 0.00, 0.00, 20, 0.000, '2026-04-13 09:32:28', '2026-04-13 09:32:28'),
(54, 312, 0.00, 0.00, 0.00, 0, 0.000, '2026-04-13 10:47:05', '2026-04-13 10:47:05'),
(55, 313, 0.00, 0.00, 0.00, 10, 0.000, '2026-04-13 10:51:35', '2026-04-13 10:51:35'),
(56, 314, 0.00, 0.00, 0.00, 2, 0.000, '2026-04-13 10:55:22', '2026-04-13 10:55:22'),
(58, 316, 0.00, 0.00, 0.00, 10, 0.000, '2026-04-14 02:18:36', '2026-04-14 02:18:36'),
(59, 317, 0.00, 0.00, 0.00, 10, 0.000, '2026-04-14 02:22:03', '2026-04-14 02:22:03'),
(60, 318, 0.00, 0.00, 0.00, 693, 0.000, '2026-04-14 04:02:36', '2026-04-14 04:02:36'),
(61, 319, 0.00, 0.00, 0.00, 16, 0.000, '2026-04-14 04:05:19', '2026-04-14 04:05:19'),
(62, 320, 0.00, 0.00, 0.00, 4, 0.000, '2026-04-14 04:06:23', '2026-04-14 04:06:23'),
(63, 321, 0.00, 0.00, 0.00, 18, 0.000, '2026-04-14 04:11:26', '2026-04-14 04:11:26'),
(64, 322, 0.00, 0.00, 0.00, 3, 0.000, '2026-04-14 04:13:31', '2026-04-14 04:13:31'),
(65, 323, 0.00, 0.00, 0.00, 90, 0.000, '2026-04-14 04:15:30', '2026-04-14 04:15:30'),
(66, 324, 0.00, 0.00, 0.00, 16, 0.000, '2026-04-14 04:18:56', '2026-04-14 04:18:56'),
(67, 325, 0.00, 0.00, 0.00, 174, 0.000, '2026-04-14 04:21:37', '2026-04-14 04:21:37'),
(68, 326, 0.00, 0.00, 0.00, 13, 0.000, '2026-04-14 04:23:00', '2026-04-14 04:23:00'),
(69, 327, 0.00, 0.00, 0.00, 33, 0.000, '2026-04-14 05:13:06', '2026-04-14 05:13:06'),
(73, 329, 0.00, 0.00, 0.00, 9, 0.000, '2026-04-14 05:24:02', '2026-04-14 05:24:02'),
(97, 340, 0.00, 0.00, 0.00, 9, 0.000, '2026-04-14 06:17:15', '2026-04-14 06:17:15'),
(135, 360, 0.00, 0.00, 0.00, 65, 0.000, '2026-04-14 09:34:54', '2026-04-14 09:34:54'),
(136, 361, 0.00, 0.00, 0.00, 6, 0.000, '2026-04-14 09:35:38', '2026-04-14 09:35:38'),
(193, 382, 0.00, 0.00, 0.00, 86, 0.000, '2026-04-15 08:26:56', '2026-04-15 08:26:56'),
(206, 387, 49.00, 49.00, 215.00, 1, 0.516, '2026-04-15 10:14:33', '2026-04-15 10:14:33'),
(207, 387, 422.00, 44.00, 44.00, 4, 3.268, '2026-04-15 10:14:33', '2026-04-15 10:14:33'),
(208, 387, 60.00, 52.00, 15.00, 40, 1.872, '2026-04-15 10:14:33', '2026-04-15 10:14:33'),
(209, 388, 76.00, 44.00, 10.00, 39, 1.304, '2026-04-15 10:15:54', '2026-04-15 10:15:54'),
(210, 388, 26.00, 40.00, 18.00, 1, 0.019, '2026-04-15 10:15:54', '2026-04-15 10:15:54'),
(211, 388, 57.00, 36.00, 20.00, 54, 2.216, '2026-04-15 10:15:54', '2026-04-15 10:15:54'),
(212, 388, 74.00, 47.00, 22.00, 23, 1.760, '2026-04-15 10:15:54', '2026-04-15 10:15:54'),
(213, 388, 65.00, 46.00, 18.00, 81, 4.359, '2026-04-15 10:15:54', '2026-04-15 10:15:54'),
(224, 391, 155.00, 52.00, 124.00, 1, 0.999, '2026-04-15 10:24:51', '2026-04-15 10:24:51'),
(225, 393, 0.00, 0.00, 0.00, 70, 0.000, '2026-04-15 10:35:35', '2026-04-15 10:35:35'),
(226, 394, 40.00, 34.00, 103.00, 5, 0.700, '2026-04-15 10:37:15', '2026-04-15 10:37:15'),
(227, 395, 0.00, 0.00, 0.00, 251, 0.000, '2026-04-15 10:40:25', '2026-04-15 10:40:25'),
(228, 396, 96.00, 82.00, 76.00, 1, 0.598, '2026-04-15 10:42:22', '2026-04-15 10:42:22'),
(229, 397, 0.00, 0.00, 0.00, 15, 0.000, '2026-04-15 10:44:12', '2026-04-15 10:44:12'),
(230, 398, 31.00, 31.00, 31.00, 36, 1.072, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(231, 398, 63.00, 35.00, 31.00, 1, 0.068, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(232, 398, 50.00, 31.00, 23.00, 1, 0.036, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(233, 398, 29.00, 39.00, 22.00, 1, 0.025, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(234, 398, 36.00, 18.00, 25.00, 1, 0.016, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(235, 398, 68.00, 19.00, 23.00, 1, 0.030, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(236, 398, 73.00, 39.00, 38.00, 1, 0.108, '2026-04-15 10:46:48', '2026-04-15 10:46:48'),
(237, 399, 110.00, 110.00, 130.00, 1, 1.573, '2026-04-15 10:48:33', '2026-04-15 10:48:33'),
(238, 399, 110.00, 110.00, 120.00, 1, 1.452, '2026-04-15 10:48:33', '2026-04-15 10:48:33'),
(239, 399, 110.00, 120.00, 95.00, 1, 1.254, '2026-04-15 10:48:33', '2026-04-15 10:48:33'),
(240, 399, 130.00, 107.00, 74.00, 1, 1.029, '2026-04-15 10:48:33', '2026-04-15 10:48:33'),
(241, 400, 18.00, 35.00, 12.00, 5, 0.038, '2026-04-15 10:59:16', '2026-04-15 10:59:16'),
(242, 400, 52.00, 62.00, 40.00, 11, 1.419, '2026-04-15 10:59:16', '2026-04-15 10:59:16'),
(243, 400, 56.00, 47.00, 40.00, 5, 0.526, '2026-04-15 10:59:16', '2026-04-15 10:59:16'),
(244, 400, 34.00, 49.00, 29.00, 8, 0.387, '2026-04-15 10:59:16', '2026-04-15 10:59:16'),
(245, 401, 0.00, 0.00, 0.00, 8, 0.000, '2026-04-15 11:01:35', '2026-04-15 11:01:35'),
(246, 402, 61.00, 31.00, 36.00, 1, 0.068, '2026-04-15 11:03:09', '2026-04-15 11:03:09'),
(247, 402, 28.00, 31.00, 31.00, 1, 0.027, '2026-04-15 11:03:09', '2026-04-15 11:03:09'),
(248, 403, 0.00, 0.00, 0.00, 41, 0.000, '2026-04-15 11:05:17', '2026-04-15 11:05:17'),
(250, 406, 98.00, 79.00, 68.00, 1, 0.526, '2026-04-15 11:09:37', '2026-04-15 11:09:37'),
(251, 406, 119.00, 91.00, 125.00, 1, 1.354, '2026-04-15 11:09:37', '2026-04-15 11:09:37'),
(252, 407, 22.00, 30.00, 40.00, 90, 2.376, '2026-04-15 11:10:56', '2026-04-15 11:10:56'),
(253, 408, 101.00, 70.00, 70.00, 1, 0.495, '2026-04-15 11:12:10', '2026-04-15 11:12:10'),
(254, 409, 37.00, 37.00, 24.00, 7, 0.230, '2026-04-15 11:14:13', '2026-04-15 11:14:13'),
(255, 409, 100.00, 100.00, 80.00, 6, 4.800, '2026-04-15 11:14:13', '2026-04-15 11:14:13'),
(256, 410, 0.00, 0.00, 0.00, 48, 0.000, '2026-04-15 11:15:28', '2026-04-15 11:15:28'),
(257, 411, 100.00, 30.00, 48.00, 10, 1.440, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(258, 411, 85.00, 60.00, 17.00, 10, 0.867, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(259, 411, 40.00, 53.00, 45.00, 1, 0.095, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(260, 411, 70.00, 20.00, 65.00, 1, 0.091, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(261, 411, 39.00, 46.00, 58.00, 7, 0.728, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(262, 411, 39.00, 12.00, 54.00, 1, 0.025, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(263, 411, 36.00, 62.00, 50.00, 8, 0.893, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(264, 411, 25.00, 47.00, 46.00, 5, 0.270, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(265, 411, 26.00, 37.00, 46.00, 1, 0.044, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(266, 411, 52.00, 32.00, 40.00, 1, 0.067, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(267, 411, 28.00, 49.00, 33.00, 2, 0.091, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(268, 411, 35.00, 17.00, 12.00, 50, 0.357, '2026-04-15 11:17:29', '2026-04-15 11:17:29'),
(269, 412, 46.00, 29.00, 23.00, 35, 1.074, '2026-04-15 11:19:17', '2026-04-15 11:19:17'),
(270, 412, 47.00, 36.00, 30.00, 35, 1.777, '2026-04-15 11:19:17', '2026-04-15 11:19:17'),
(271, 413, 0.00, 0.00, 0.00, 41, 0.000, '2026-04-15 11:20:41', '2026-04-15 11:20:41'),
(272, 414, 0.00, 0.00, 0.00, 621, 0.000, '2026-04-15 11:21:24', '2026-04-15 11:21:24'),
(273, 415, 15.00, 15.00, 94.00, 20, 0.423, '2026-04-15 11:22:37', '2026-04-15 11:22:37'),
(274, 416, 37.00, 29.00, 1.00, 1, 0.001, '2026-04-15 11:24:36', '2026-04-15 11:24:36'),
(275, 416, 27.00, 17.00, 16.00, 1, 0.007, '2026-04-15 11:24:36', '2026-04-15 11:24:36'),
(276, 416, 45.00, 28.00, 36.00, 1, 0.045, '2026-04-15 11:24:36', '2026-04-15 11:24:36'),
(277, 416, 66.00, 37.00, 33.00, 1, 0.081, '2026-04-15 11:24:36', '2026-04-15 11:24:36'),
(278, 416, 32.00, 27.00, 17.00, 1, 0.015, '2026-04-15 11:24:36', '2026-04-15 11:24:36'),
(279, 416, 37.00, 33.00, 14.00, 1, 0.017, '2026-04-15 11:24:36', '2026-04-15 11:24:36'),
(280, 417, 0.00, 0.00, 0.00, 402, 0.000, '2026-04-15 11:27:20', '2026-04-15 11:27:20'),
(281, 418, 54.00, 46.00, 26.00, 15, 0.969, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(282, 418, 55.00, 37.00, 26.00, 14, 0.741, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(283, 418, 46.00, 46.00, 38.00, 1, 0.080, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(284, 418, 37.00, 37.00, 34.00, 1, 0.047, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(285, 418, 47.00, 39.00, 32.00, 2, 0.117, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(286, 418, 49.00, 45.00, 38.00, 1, 0.084, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(287, 418, 45.00, 32.00, 32.00, 1, 0.046, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(288, 418, 52.00, 40.00, 32.00, 1, 0.067, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(289, 418, 48.00, 43.00, 32.00, 3, 0.198, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(290, 418, 41.00, 25.00, 20.00, 1, 0.021, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(291, 418, 30.00, 30.00, 17.00, 1, 0.015, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(292, 418, 36.00, 27.00, 27.00, 1, 0.026, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(293, 418, 50.00, 43.00, 34.00, 1, 0.073, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(294, 418, 59.00, 50.00, 47.00, 1, 0.139, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(295, 418, 33.00, 28.00, 15.00, 1, 0.014, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(296, 418, 28.00, 23.00, 23.00, 1, 0.015, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(297, 418, 50.00, 43.00, 34.00, 3, 0.219, '2026-04-15 11:28:58', '2026-04-15 11:28:58'),
(298, 419, 57.00, 34.00, 85.00, 1, 0.165, '2026-04-15 11:40:30', '2026-04-15 11:40:30'),
(299, 419, 51.00, 41.00, 57.00, 5, 0.596, '2026-04-15 11:40:30', '2026-04-15 11:40:30'),
(300, 419, 66.00, 41.00, 62.00, 18, 3.020, '2026-04-15 11:40:30', '2026-04-15 11:40:30'),
(301, 419, 82.00, 100.00, 118.00, 1, 0.968, '2026-04-15 11:40:30', '2026-04-15 11:40:30'),
(302, 419, 86.00, 114.00, 110.00, 1, 1.078, '2026-04-15 11:40:30', '2026-04-15 11:40:30'),
(303, 420, 66.00, 34.00, 58.00, 1, 0.130, '2026-04-15 11:43:14', '2026-04-15 11:43:14'),
(304, 421, 48.00, 30.00, 57.00, 14, 1.149, '2026-04-15 11:45:03', '2026-04-15 11:45:03'),
(305, 421, 32.00, 51.00, 30.00, 9, 0.441, '2026-04-15 11:45:03', '2026-04-15 11:45:03'),
(306, 422, 0.00, 0.00, 0.00, 1253, 0.000, '2026-04-15 12:19:38', '2026-04-15 12:19:38'),
(307, 423, 38.00, 33.00, 33.00, 1, 0.041, '2026-04-15 12:23:34', '2026-04-15 12:23:34'),
(308, 424, 68.00, 53.00, 56.00, 2, 0.404, '2026-04-15 12:25:20', '2026-04-15 12:25:20'),
(309, 425, 52.00, 33.00, 45.00, 1, 0.077, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(310, 425, 52.00, 33.00, 44.00, 1, 0.076, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(311, 425, 54.00, 41.00, 32.00, 1, 0.071, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(312, 425, 54.00, 48.00, 43.00, 1, 0.111, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(313, 425, 55.00, 42.00, 44.00, 1, 0.102, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(314, 425, 55.00, 40.00, 44.00, 1, 0.097, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(315, 425, 55.00, 41.00, 45.00, 1, 0.101, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(316, 425, 55.00, 40.00, 44.00, 1, 0.097, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(317, 425, 55.00, 40.00, 44.00, 1, 0.097, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(318, 425, 29.00, 49.00, 85.00, 1, 0.121, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(319, 425, 29.00, 49.00, 85.00, 1, 0.121, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(320, 425, 29.00, 49.00, 65.00, 1, 0.092, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(321, 425, 29.00, 49.00, 65.00, 1, 0.092, '2026-04-15 12:26:36', '2026-04-15 12:26:36'),
(322, 426, 128.00, 95.00, 132.00, 1, 1.605, '2026-04-15 12:58:02', '2026-04-15 12:58:02'),
(323, 427, 113.00, 140.00, 140.00, 1, 2.215, '2026-04-15 12:59:46', '2026-04-15 12:59:46'),
(324, 427, 74.00, 150.00, 150.00, 1, 1.665, '2026-04-15 12:59:46', '2026-04-15 12:59:46'),
(325, 428, 95.00, 124.00, 126.00, 2, 2.969, '2026-04-15 13:01:09', '2026-04-15 13:01:09'),
(326, 429, 12.00, 12.00, 704.00, 70, 7.096, '2026-04-15 13:02:34', '2026-04-15 13:02:34'),
(327, 430, 23.00, 76.00, 76.00, 2, 0.266, '2026-04-15 13:03:56', '2026-04-15 13:03:56'),
(328, 432, 0.00, 0.00, 0.00, 283, 0.000, '2026-04-15 13:07:05', '2026-04-15 13:07:05'),
(329, 433, 0.00, 0.00, 0.00, 83, 0.000, '2026-04-15 13:09:07', '2026-04-15 13:09:07'),
(330, 434, 46.00, 33.00, 31.00, 75, 3.529, '2026-04-15 13:10:05', '2026-04-15 13:10:05'),
(331, 434, 57.00, 96.00, 27.00, 20, 2.955, '2026-04-15 13:10:05', '2026-04-15 13:10:05'),
(332, 435, 0.00, 0.00, 0.00, 11, 0.000, '2026-04-15 13:20:01', '2026-04-15 13:20:01'),
(337, 437, 0.00, 0.00, 0.00, 16, 0.000, '2026-04-16 03:00:41', '2026-04-16 03:00:41'),
(342, 440, 0.00, 0.00, 0.00, 42, 0.000, '2026-04-16 04:22:19', '2026-04-16 04:22:19'),
(343, 441, 0.00, 0.00, 0.00, 23, 0.000, '2026-04-16 04:40:31', '2026-04-16 04:40:31'),
(345, 443, 0.00, 0.00, 0.00, 8, 0.000, '2026-04-16 06:03:07', '2026-04-16 06:03:07'),
(346, 444, 0.00, 0.00, 0.00, 2, 0.000, '2026-04-16 06:11:48', '2026-04-16 06:11:48'),
(347, 445, 0.00, 0.00, 0.00, 1, 0.000, '2026-04-16 06:16:32', '2026-04-16 06:16:32'),
(348, 446, 0.00, 0.00, 0.00, 22, 0.000, '2026-04-16 06:19:48', '2026-04-16 06:19:48'),
(349, 447, 214.00, 114.00, 122.00, 1, 2.976, '2026-04-16 06:20:59', '2026-04-16 06:20:59'),
(350, 447, 120.00, 105.00, 151.00, 1, 1.902, '2026-04-16 06:20:59', '2026-04-16 06:20:59'),
(351, 447, 227.00, 107.00, 210.00, 1, 5.100, '2026-04-16 06:20:59', '2026-04-16 06:20:59'),
(352, 448, 0.00, 0.00, 0.00, 34, 0.000, '2026-04-16 06:32:19', '2026-04-16 06:32:19'),
(353, 449, 0.00, 0.00, 0.00, 0, 0.000, '2026-04-16 07:16:41', '2026-04-16 07:16:41'),
(354, 450, 241.00, 410.00, 194.00, 1, 19.169, '2026-04-16 07:31:31', '2026-04-16 07:31:31'),
(355, 450, 42.00, 47.00, 250.00, 1, 0.493, '2026-04-16 07:31:31', '2026-04-16 07:31:31'),
(356, 451, 0.00, 0.00, 0.00, 196, 0.000, '2026-04-16 07:33:22', '2026-04-16 07:33:22'),
(357, 452, 0.00, 0.00, 0.00, 7, 0.000, '2026-04-16 07:38:38', '2026-04-16 07:38:38'),
(358, 453, 37.00, 62.00, 37.00, 1, 0.084, '2026-04-16 07:51:50', '2026-04-16 07:51:50'),
(359, 453, 37.00, 37.00, 41.00, 1, 0.056, '2026-04-16 07:51:50', '2026-04-16 07:51:50'),
(360, 453, 122.00, 102.00, 80.00, 1, 0.995, '2026-04-16 07:51:50', '2026-04-16 07:51:50'),
(361, 453, 102.00, 100.00, 98.00, 4, 3.998, '2026-04-16 07:51:50', '2026-04-16 07:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `judul_prints`
--

CREATE TABLE `judul_prints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `judul_prints`
--

INSERT INTO `judul_prints` (`id`, `nama`) VALUES
(1, 'Laporan pembayaran PT Anugrah'),
(2, 'laporan belum di bayar'),
(3, 'laporan Umum'),
(4, 'Laporan Utang'),
(5, 'Laporan pembayaran catelya');

-- --------------------------------------------------------

--
-- Table structure for table `kapal`
--

CREATE TABLE `kapal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kapal` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kapal`
--

INSERT INTO `kapal` (`id`, `nama_kapal`, `created_at`, `updated_at`) VALUES
(4, 'T.TANGGUH V.246', '2026-03-03 14:28:33', '2026-03-26 06:54:07'),
(6, 'T.SALAM V.155', '2026-03-30 10:33:47', '2026-03-30 10:33:47'),
(7, 'T.TENANG V.276', '2026-04-02 03:48:33', '2026-04-02 03:48:33'),
(8, 'T.SALAM V.159', '2026-04-06 03:32:35', '2026-04-06 03:32:35'),
(9, 'T.CAHAYA V.381', '2026-04-06 04:44:38', '2026-04-06 04:44:38'),
(10, 'T.CAHAYA V.382', '2026-04-08 04:28:40', '2026-04-08 04:28:40'),
(13, 'T. KASIH V.300', '2026-04-10 07:08:46', '2026-04-10 07:08:46'),
(14, 'T.TERANG V.293', '2026-04-10 09:37:51', '2026-04-10 09:37:51'),
(15, 'T. SEMANGAT V.275', '2026-04-13 07:39:13', '2026-04-13 07:39:13'),
(17, 'T.LESTARI V.332', '2026-04-13 08:00:41', '2026-04-13 08:00:41'),
(18, 'T.SEJAHTERA V.149', '2026-04-13 09:11:36', '2026-04-13 09:11:36'),
(19, 'T.SALAM', '2026-04-14 05:01:44', '2026-04-14 05:01:44'),
(20, 'T.SEJAHTERA V.153', '2026-04-14 05:32:19', '2026-04-14 05:32:19'),
(22, 'T.TENANG V.277', '2026-04-16 03:56:32', '2026-04-16 03:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_19_021557_create_media_table', 1),
(5, '2026_02_19_021646_create_permission_tables', 1),
(6, '2026_02_19_073010_create_kapal_table', 1),
(7, '2026_02_19_073011_create_tujuan_table', 1),
(8, '2026_02_19_073012_create_customer_table', 1),
(9, '2026_02_19_073014_create_invoice_table', 1),
(10, '2026_02_19_073016_create_finance_table', 1),
(11, '2026_02_19_073017_create_invoice_items_table', 1),
(12, '2026_02_20_172851_add_asal_to_invoice_table', 1),
(13, '2026_02_22_055413_move_bap_balik_to_finance_table', 1),
(14, '2026_02_22_065742_create_transaksi_kategoris_table', 1),
(15, '2026_02_22_065850_create_bank_rekenings_table', 1),
(16, '2026_02_22_073832_create_transaksis_table', 1),
(17, '2026_02_22_123407_add_catatan_muntahan_to_invoice_table', 1),
(18, '2026_02_22_131635_add_up_to_invoice_table', 1),
(19, '2026_02_22_144734_create_containers_table', 1),
(20, '2026_02_22_145310_change_contr_seal_in_invoice_table', 1),
(21, '2026_02_22_151346_create_hutang_piutangs_table', 1),
(22, '2026_02_24_184804_add_voyage_details_to_container_table', 2),
(23, '2026_02_24_184806_remove_voyage_details_from_invoice_table', 2),
(24, '2026_02_24_191312_move_metode_pengiriman_to_invoice_table', 3),
(25, '2026_02_27_061721_add_photo_to_users_table', 4),
(26, '2026_02_28_083014_add_tanda_terima_to_invoice_table', 5),
(27, '2026_02_28_092348_add_catatan_to_container_table', 5),
(28, '2026_03_01_220000_create_tujuan_daerah_table', 6),
(29, '2026_03_01_235000_add_tanggal_tagih_to_finance_table', 6),
(30, '2026_03_04_185237_move_tujuan_daerah_from_container_to_invoice', 7),
(31, '2026_03_07_162807_create_invoice_additional_fees_table', 8),
(32, '2026_03_07_162844_create_judul_prints_table', 8),
(33, '2026_03_15_124754_add_details_to_customer_table', 9),
(34, '2026_03_18_032836_create_container_operational_costs_table', 9),
(35, '2026_03_18_032859_add_total_pembayaran_manual_to_container_table', 9),
(36, '2026_04_03_053700_add_plt_and_show_stamp_to_invoices_table', 10),
(37, '2026_04_03_055332_update_invoice_items_decimals_and_migrate_data', 10),
(38, '2026_04_08_124201_create_invoice_item_details_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view.dashboard', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(2, 'view.role', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(3, 'create.role', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(4, 'edit.role', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(5, 'delete.role', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(6, 'export.role', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(7, 'import.role', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(8, 'print.role', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(9, 'view.user', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(10, 'create.user', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(11, 'edit.user', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(12, 'delete.user', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(13, 'export.user', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(14, 'import.user', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(15, 'print.user', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(16, 'view.customer', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(17, 'create.customer', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(18, 'edit.customer', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(19, 'delete.customer', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(20, 'export.customer', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(21, 'import.customer', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(22, 'print.customer', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(23, 'view.container', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(24, 'create.container', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(25, 'edit.container', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(26, 'delete.container', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(27, 'export.container', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(28, 'import.container', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(29, 'print.container', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(30, 'view.kapal', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(31, 'create.kapal', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(32, 'edit.kapal', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(33, 'delete.kapal', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(34, 'export.kapal', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(35, 'import.kapal', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(36, 'print.kapal', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(37, 'view.tujuan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(38, 'create.tujuan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(39, 'edit.tujuan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(40, 'delete.tujuan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(41, 'export.tujuan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(42, 'import.tujuan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(43, 'print.tujuan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(44, 'view.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(45, 'create.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(46, 'edit.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(47, 'delete.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(48, 'export.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(49, 'import.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(50, 'print.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(51, 'print_per_invoice.invoice', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(52, 'view.finance', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(53, 'edit.finance', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(54, 'view.kategori_keuangan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(55, 'create.kategori_keuangan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(56, 'edit.kategori_keuangan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(57, 'delete.kategori_keuangan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(58, 'export.kategori_keuangan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(59, 'import.kategori_keuangan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(60, 'print.kategori_keuangan', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(61, 'view.rekening_bank', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(62, 'create.rekening_bank', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(63, 'edit.rekening_bank', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(64, 'delete.rekening_bank', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(65, 'export.rekening_bank', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(66, 'import.rekening_bank', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(67, 'print.rekening_bank', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(68, 'view.transaksi', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(69, 'create.transaksi', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(70, 'edit.transaksi', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(71, 'delete.transaksi', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(72, 'export.transaksi', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(73, 'import.transaksi', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(74, 'print.transaksi', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(75, 'view.hutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(76, 'create.hutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(77, 'edit.hutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(78, 'delete.hutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(79, 'export.hutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(80, 'import.hutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(81, 'print.hutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(82, 'view.piutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(83, 'create.piutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(84, 'edit.piutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(85, 'delete.piutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(86, 'export.piutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(87, 'import.piutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(88, 'print.piutang', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-02-24 08:52:00', '2026-02-24 08:52:00'),
(2, 'Invoice', 'web', '2026-02-25 21:26:55', '2026-02-25 21:26:55'),
(3, 'Direktur', 'web', '2026-03-30 08:08:15', '2026-03-30 08:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(1, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(1, 3),
(2, 3),
(8, 3),
(9, 3),
(15, 3),
(16, 3),
(22, 3),
(23, 3),
(29, 3),
(30, 3),
(36, 3),
(37, 3),
(43, 3),
(44, 3),
(50, 3),
(51, 3),
(52, 3),
(54, 3),
(60, 3),
(61, 3),
(67, 3),
(68, 3),
(74, 3),
(75, 3),
(81, 3),
(82, 3),
(88, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1BX8SZfsatYxwMwZZ4LBdBzu6J5ECwb13mA1Szr6', NULL, '5.133.192.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Viewer/99.9.8853.8', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieUV1S3IzWHdnVU1yOHdoc0hKYmpCdUFmZTR2Tk95OW4yWXpxSGdSeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776382781),
('42NjxAHQjn0foaOodVHoecWsxXtA6h7M5dwOaMZr', 1, '182.10.130.99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSm0zTHh5YTBxaDhjYW94b2dqanNkTUFMV1BwdnU2dG83SFdZZnEyQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vdHJhbnNha3NpIjtzOjU6InJvdXRlIjtzOjIxOiJhZG1pbi50cmFuc2Frc2kuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1776340598),
('7d9I6EetuM3NgrqtLk2rfd4TesKlft7FO1P8AYxb', NULL, '2600:1900:0:4005::1c00', 'Python/3.11 aiohttp/3.13.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlJNbTBoSFJBaHhleldRZHhLbG93SlhWR1ZITFBicVBmVU5XWDRNcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776382117),
('7HUG8tgib78kqQ62a1gGFExZkoHIij36teqNyaI7', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoib3dHQmhMRm9sVDk5cm5nNG5DWmJXaDdUVzk0blRJdHRkeUtYRkJ6eiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776349387),
('7wKMNqb7KqCissuztXBaS4sbdGgtilE1BYL8SoPA', NULL, '136.114.243.84', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMU5GNUdJTnZFaXhkWjhvbVgwTVdUejVjY0xHUTFGb3RYMTBkYWZMOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776351037),
('a32ACO8CRJnmk71GcUuwc7zzJLJ8n7r8kM2IkR6J', 1, '182.10.131.186', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWpmWHFKVzBtamRMNk9UYkJQZGw3TFVFVURveDF3alZDbjJYek15ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vaW52b2ljZS8yMjgvcHJpbnQiO3M6NToicm91dGUiO3M6MTk6ImFkbWluLmludm9pY2UucHJpbnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1776382970),
('AofVbboDmKRBFgKwQFcsY3P5luliiwPkk5QUkxKn', NULL, '80.248.225.154', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Viewer/99.9.8853.8', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVNVWVRDaW4zZEhua3VLRkY3M2hEVzJabm5xb0ZzTk1tTjNIWTJKYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776382781),
('b3HJ6ENHWVRaZfBMbo3OULaR9sp1BVzRJiiinczj', NULL, '34.27.61.10', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieUo1c0dsTE5HblVQdnBXOFJPUFlDYWdzWXVjcHdlSnNTT2tzNnZLMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776351153),
('ciW9izPWtgATmfRhWXDlL92aJmuX2GFNfRYHEVRh', NULL, '2001:bc8:17c0:422:da5e:d3ff:fe49:a450', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUdkTTNzMzM1QU1kYmhzWXNsMTVZODlhV0w5Z0RVeGk0ZUlqSEhEUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776364400),
('eeXxC604dczLguOg0OQVp9D3Ol9ZtXpeUlYh1iXX', NULL, '43.164.193.149', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3.1 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRzFOWkthQ1RNeVViMHJ5Y1NaUFlJOWU4UXRUYmE4QnNWSFRzMWhHUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODE6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvaW5kZXgucGhwP19maWVsZHM9Y29udGVudCZyZXN0X3JvdXRlPSUyRndwJTJGdjIlMkZwYWdlcyI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776352266),
('ehjIzwF4N74230o78F3UY24ZqUce6TYXN8hvz9xT', NULL, '136.114.243.84', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnprUVlWVnNrQTEwamhwMWVRSzJpY0hpZHYySjRZdUZJUmU2UEhXUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776351037),
('Ev1Ns4VKmRB2bW0rpmJCtHVg3cwf0UaMOQQtuvqI', NULL, '128.90.157.5', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkJBQW1iMDE0Q2lqU25FeDZHUjFXMEliMWpCYzhUY1RMdFFvOUQyeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776367113),
('fCZChs3pibNFOOpv5qYrMeh9qi8Qvfx34FslT1J9', NULL, '185.61.218.43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36/Nutch-1.21-SNAPSHOT', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVp3Rktnczl2c1VoRUJDZ2x5V050bG1TblpNeUpDRHdvNWhwR3hDYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776348645),
('gHaJQO7zTHxen2nuMTwF6mWjA7W4msxDp11R71pi', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiamlpek1tNDJLQWY2dEZGdW5hWUFTbG1rS1V5WWFIVnBGblNPWk56eiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776349387),
('h1WeKXqGadXYEO6VbJqz03VVwBZEUpYMcfb3CFNf', NULL, '51.68.107.156', 'Mozilla/5.0 (compatible; MJ12bot/v2.0.5; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidUF0V3pSejZjUlAzSTJOck9BaXJESmVvNDM0RFFIUXNIekNJa291YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776347985),
('inmiyWToiXtElP7zCLPGcbTuJpZnaMHIp50jiI3M', NULL, '2602:80d:1008::88', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS1NsMEE5QXpNVzFNbnc5YWRHWjBKMXJFdXo3ZG1TMVFHUjJUejAzaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776363929),
('KgrprRD0phoOdvaSn6dEBU3YQFdDdor3yXqdETvp', NULL, '52.167.144.25', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFNId1JJbk90WGRLdTVlaGkwTkVtQ2VGNTBoVW1FaWZnQnJ3M3YzRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776356924),
('oiB8kzP4wBiCE9JLgCyKSaJdCbbx6uGJdCPkWExV', NULL, '128.90.157.5', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGdzM3Mxa1FiZHRJVHN2cEFRbmdYcUZpdHh0eDZTMGRBV3FuYVhYTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776367113),
('QDACdmN38ik9NjhpyfA6017kVFrzPJBSq7HY2aFZ', NULL, '51.68.107.156', 'Mozilla/5.0 (compatible; MJ12bot/v2.0.5; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicVQ2VDhUMUR2N2J4Y2R0R1NNcGc5UFB2dnZJclFRZUN2Z3ZVb2tHMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776347986),
('uUoTrSrz17fM0CdlAhAltDo9ewXgiChY6sButR8N', NULL, '2602:80d:1008::88', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUFFVWW9XUW9mc1dTaDVtZEFqdTBoZWk2TGZpdFEwWEdSRVEyRUkyTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776363926),
('VaDvQYntboUx2Y2Fgkj1hR0oJiLN5I88t9nUna3P', NULL, '34.27.61.10', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnFaZjVReDV1MkRZQmF0aTB3UHZkZlRnN3NoOHdTZ3JNaUsybHoxOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MTE6ImFkbWluLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776351153),
('xzk52A5ESG8OMLR8i7etBlhXtioYdhZdYyxQYRHb', 1, '182.10.130.99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieVQ5RzAyWEhvUHhWTHRlaUxlN25xOEUxelNtWjlZTXF0ZnNRTm9LciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vcmVwb3J0LXNjai5vbmxpbmUvYWRtaW4vaW52b2ljZS9jcmVhdGUiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLmludm9pY2UuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1776349097);

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('pemasukan','pengeluaran') NOT NULL,
  `transaksi_kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nominal` bigint(20) NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `bank_rekening_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `tanggal`, `jenis`, `transaksi_kategori_id`, `nominal`, `keterangan`, `bank_rekening_id`, `created_at`, `updated_at`) VALUES
(4, '2026-03-17', 'pemasukan', 2, 1617600, 'Pembayaran Invoice 06657', 1, '2026-04-04 09:09:20', '2026-04-04 09:09:20'),
(5, '2026-01-13', 'pemasukan', 2, 1845277, 'Pembayaran Invoice 05874', 1, '2026-04-06 05:29:59', '2026-04-06 05:29:59'),
(6, '2026-03-30', 'pemasukan', 2, 6066000, 'Pembayaran Invoice 06689', 1, '2026-04-06 07:15:35', '2026-04-06 07:18:41'),
(7, '2026-04-07', 'pemasukan', 2, 8571865, 'Pembayaran Invoice 06649', 1, '2026-04-07 05:36:48', '2026-04-07 05:36:48'),
(8, '2026-04-07', 'pemasukan', 2, 1564421, 'Pembayaran Invoice 06693', 1, '2026-04-07 05:37:30', '2026-04-07 05:37:30'),
(9, '2026-02-10', 'pemasukan', 2, 1206000, 'Pembayaran Invoice 05875', 1, '2026-04-07 05:42:28', '2026-04-07 05:42:28'),
(10, '2026-04-07', 'pemasukan', 2, 581325, 'Pembayaran Invoice 06699', 1, '2026-04-07 05:48:42', '2026-04-07 05:48:42'),
(11, '2026-04-06', 'pemasukan', 2, 15274000, 'Pembayaran Invoice 06705', 1, '2026-04-08 10:47:46', '2026-04-08 10:47:46'),
(12, '2026-04-14', 'pemasukan', 2, 6919550, 'Pembayaran Invoice 06721', 1, '2026-04-14 02:17:55', '2026-04-14 02:17:55'),
(13, '2026-04-14', 'pemasukan', 2, 707700, 'Pembayaran Invoice 06660', 1, '2026-04-14 02:19:49', '2026-04-14 02:19:49'),
(14, '2026-04-14', 'pemasukan', 2, 505753, 'Pembayaran Invoice 06659', 1, '2026-04-14 02:22:31', '2026-04-14 02:25:14'),
(15, '2026-04-14', 'pemasukan', 2, 1314300, 'Pembayaran Invoice 06709', 1, '2026-04-14 08:53:11', '2026-04-14 08:53:11'),
(16, '2026-04-14', 'pemasukan', 2, 10733100, 'Pembayaran Invoice 06732', 1, '2026-04-14 08:58:16', '2026-04-14 08:58:44'),
(17, '2026-04-14', 'pemasukan', 2, 2300000, 'Pembayaran Invoice 06744', 1, '2026-04-14 08:59:12', '2026-04-14 08:59:12'),
(18, '2026-04-13', 'pemasukan', 2, 2339050, 'Pembayaran Invoice 06648', 1, '2026-04-14 09:27:07', '2026-04-14 09:27:07'),
(19, '2026-04-13', 'pemasukan', 2, 707700, 'Pembayaran Invoice 06674', 1, '2026-04-14 09:27:39', '2026-04-14 09:27:39'),
(20, '2026-04-13', 'pemasukan', 2, 5305627, 'Pembayaran Invoice 06697', 1, '2026-04-14 09:28:09', '2026-04-14 09:28:09'),
(21, '2026-04-13', 'pemasukan', 2, 1961744, 'Pembayaran Invoice 06673', 1, '2026-04-14 09:28:58', '2026-04-14 09:28:58'),
(22, '2026-04-13', 'pemasukan', 2, 1961744, 'Pembayaran Invoice 06688', 1, '2026-04-14 09:29:34', '2026-04-14 09:29:34'),
(23, '2026-04-13', 'pemasukan', 2, 3480400, 'Pembayaran Invoice 06715', 1, '2026-04-14 09:30:31', '2026-04-14 09:30:31'),
(24, '2026-04-11', 'pemasukan', 2, 875273, 'Pembayaran Invoice 06748', 1, '2026-04-14 09:31:20', '2026-04-14 09:31:20'),
(25, '2026-04-09', 'pemasukan', 2, 11956550, 'Pembayaran Invoice 06687', 1, '2026-04-14 09:36:11', '2026-04-14 09:36:11'),
(26, '2026-04-09', 'pemasukan', 2, 4222125, 'Pembayaran Invoice 06714', 1, '2026-04-14 09:36:45', '2026-04-14 09:36:45'),
(27, '2026-04-07', 'pemasukan', 2, 3807075, 'Pembayaran Invoice 06696', 1, '2026-04-14 09:42:50', '2026-04-14 09:42:50'),
(28, '2026-04-07', 'pemasukan', 2, 2437369, 'Pembayaran Invoice 06680', 1, '2026-04-14 09:43:54', '2026-04-14 09:43:54'),
(29, '2026-04-06', 'pemasukan', 2, 3012679, 'Pembayaran Invoice 06669', 1, '2026-04-14 09:44:31', '2026-04-14 09:44:31'),
(30, '2026-04-14', 'pemasukan', 2, 10413098, 'Pembayaran Invoice 06662', 1, '2026-04-14 09:45:33', '2026-04-14 09:45:33'),
(31, '2026-01-14', 'pemasukan', 2, 695922, 'Pembayaran Invoice 05845', 1, '2026-04-15 07:26:56', '2026-04-15 07:26:56'),
(32, '2026-01-20', 'pemasukan', 2, 2082000, 'Pembayaran Invoice 05846', 1, '2026-04-15 07:28:28', '2026-04-15 07:28:28'),
(33, '2026-02-11', 'pemasukan', 2, 3898871, 'Pembayaran Invoice 05852, 05853', 1, '2026-04-15 07:29:24', '2026-04-15 07:29:24'),
(34, '2026-04-15', 'pemasukan', 2, 4697510, 'Pembayaran Invoice 05857', 1, '2026-04-15 07:30:08', '2026-04-15 07:30:08'),
(35, '2026-01-26', 'pemasukan', 2, 729437, 'Pembayaran Invoice 05860', 1, '2026-04-15 07:31:12', '2026-04-15 07:31:12'),
(36, '2026-01-17', 'pemasukan', 2, 2001780, 'Pembayaran Invoice 05882', 1, '2026-04-15 07:32:12', '2026-04-15 07:32:12'),
(37, '2026-02-11', 'pemasukan', 2, 1213200, 'Pembayaran Invoice 05850', 1, '2026-04-15 07:33:06', '2026-04-15 07:33:06'),
(38, '2026-02-14', 'pemasukan', 2, 1061171, 'Pembayaran Invoice 05861', 1, '2026-04-15 07:35:01', '2026-04-15 07:35:01'),
(39, '2026-01-22', 'pemasukan', 2, 726050, 'Pembayaran Invoice 05866', 1, '2026-04-15 07:36:00', '2026-04-15 07:36:00'),
(40, '2026-01-15', 'pemasukan', 2, 11876015, 'Pembayaran Invoice 05871', 1, '2026-04-15 07:44:07', '2026-04-15 07:44:07'),
(41, '2026-01-20', 'pemasukan', 2, 965353, 'Pembayaran Invoice 05872, 05839', 1, '2026-04-15 07:48:05', '2026-04-15 07:48:05'),
(42, '2026-01-13', 'pemasukan', 2, 1707933, 'Pembayaran Invoice 05873', 1, '2026-04-15 07:49:33', '2026-04-15 07:49:33'),
(43, '2026-02-11', 'pemasukan', 2, 1583732, 'Pembayaran Invoice 05878', 1, '2026-04-15 07:50:56', '2026-04-15 07:50:56'),
(44, '2026-01-31', 'pemasukan', 2, 650000, 'Pembayaran Invoice 05929', 1, '2026-04-15 07:55:26', '2026-04-15 07:55:26'),
(45, '2026-01-31', 'pemasukan', 2, 412488, 'Pembayaran Invoice 05935', 1, '2026-04-15 07:56:24', '2026-04-15 07:56:24'),
(46, '2026-02-10', 'pemasukan', 2, 522600, 'Pembayaran Invoice 05931', 1, '2026-04-15 07:57:43', '2026-04-15 07:57:43'),
(47, '2026-01-24', 'pemasukan', 2, 600000, 'Pembayaran Invoice 05941', 1, '2026-04-15 08:02:17', '2026-04-15 08:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_kategoris`
--

CREATE TABLE `transaksi_kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` enum('pemasukan','pengeluaran') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_kategoris`
--

INSERT INTO `transaksi_kategoris` (`id`, `nama`, `kategori`, `created_at`, `updated_at`) VALUES
(1, 'Gaji Karywan', 'pengeluaran', '2026-02-27 07:43:33', '2026-02-27 07:43:33'),
(2, 'Pemasukan Invoice', 'pemasukan', '2026-02-28 08:21:35', '2026-02-28 08:21:35'),
(3, 'Bayar Utilitas', 'pengeluaran', '2026-03-02 04:33:32', '2026-03-02 04:33:32'),
(4, 'bulanan istri muda', 'pengeluaran', '2026-03-06 09:54:57', '2026-03-06 09:54:57'),
(5, 'kasbon', 'pengeluaran', '2026-03-06 09:56:30', '2026-03-06 09:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `tujuan`
--

CREATE TABLE `tujuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_tujuan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tujuan`
--

INSERT INTO `tujuan` (`id`, `nama_tujuan`, `created_at`, `updated_at`) VALUES
(9, 'BITUNG', '2026-04-02 08:50:19', '2026-04-02 08:50:19'),
(10, 'MANADO', '2026-04-02 08:50:31', '2026-04-02 08:50:31'),
(11, 'JAKARTA', '2026-04-02 08:50:43', '2026-04-02 08:50:43'),
(13, 'GORONTALO', '2026-04-02 09:14:52', '2026-04-02 09:14:52'),
(14, 'TERNATE', '2026-04-02 09:15:04', '2026-04-02 09:15:04'),
(17, 'KENDARI', '2026-04-02 11:00:09', '2026-04-02 11:00:09'),
(18, 'PALOPO', '2026-04-03 10:49:48', '2026-04-03 10:49:48'),
(19, 'MAKASSAR', '2026-04-04 03:03:24', '2026-04-04 03:03:24'),
(20, 'AMBON', '2026-04-10 06:57:20', '2026-04-10 06:57:20'),
(21, 'BANJARBARU', '2026-04-10 07:06:09', '2026-04-10 07:06:09'),
(22, 'BANJARMASIN', '2026-04-10 07:06:35', '2026-04-10 07:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `tujuan_daerah`
--

CREATE TABLE `tujuan_daerah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tujuan_daerah`
--

INSERT INTO `tujuan_daerah` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Kolaka', '2026-03-04 20:41:08', '2026-03-04 20:41:08'),
(2, 'jombang', '2026-03-06 08:58:48', '2026-03-06 08:58:48'),
(3, 'Makassar', '2026-03-06 09:50:36', '2026-03-06 09:50:36'),
(4, 'Bitung', '2026-03-06 09:51:30', '2026-03-06 09:51:30'),
(5, 'ujung pandang', '2026-03-10 08:18:33', '2026-03-10 08:18:33'),
(6, 'Manado', '2026-03-26 07:31:00', '2026-03-26 07:31:00'),
(7, 'KENDARI', '2026-04-02 11:50:36', '2026-04-02 11:50:36'),
(8, 'PALOPO', '2026-04-03 11:20:13', '2026-04-03 11:20:13'),
(9, 'PALU', '2026-04-04 02:45:57', '2026-04-04 02:45:57'),
(10, 'MOROWALI', '2026-04-04 03:12:27', '2026-04-04 03:12:27'),
(11, 'MARUSU - MAROS', '2026-04-04 03:34:00', '2026-04-04 03:34:00'),
(12, 'TERNATE', '2026-04-07 02:59:54', '2026-04-07 02:59:54'),
(13, 'BOLAANG, MONGONDOW', '2026-04-07 05:22:45', '2026-04-07 05:22:45'),
(14, 'GORONTALO', '2026-04-07 05:49:14', '2026-04-07 05:49:14'),
(15, 'MINAHASA UTARA', '2026-04-08 06:40:56', '2026-04-08 06:40:56'),
(16, 'BANJARMASIN', '2026-04-08 08:57:04', '2026-04-08 08:57:04'),
(17, 'BANJARBARU', '2026-04-08 09:24:58', '2026-04-08 09:24:58'),
(18, 'AMBON', '2026-04-08 09:38:28', '2026-04-08 09:38:28'),
(19, 'GOWA', '2026-04-10 10:47:17', '2026-04-10 10:47:17'),
(20, 'SIRIMAU', '2026-04-13 07:46:01', '2026-04-13 07:46:01'),
(21, 'BAGUALA', '2026-04-13 08:14:27', '2026-04-13 08:14:27'),
(22, 'KALAWAT', '2026-04-14 05:25:03', '2026-04-14 05:25:03'),
(23, 'LIKUPANG TIMUR, MINAHASA UTARA', '2026-04-14 05:30:38', '2026-04-14 05:30:38'),
(24, 'MADIDIR, BITUNG', '2026-04-14 05:38:01', '2026-04-14 05:38:01'),
(25, 'MAPANGET, MANADO', '2026-04-14 05:43:28', '2026-04-14 05:43:28'),
(26, 'WANEA, MANADO', '2026-04-14 06:17:42', '2026-04-14 06:17:42'),
(27, 'AIRMADIDI, MANADO', '2026-04-14 09:43:56', '2026-04-14 09:43:56'),
(28, 'AIRMADIDI,MINAHASA UTARA', '2026-04-14 09:57:04', '2026-04-14 09:57:04'),
(29, 'KAUDITAN, MINAHASA UTARA', '2026-04-14 10:16:48', '2026-04-14 10:16:48'),
(30, 'MALALAYANG, MANADO', '2026-04-14 11:13:18', '2026-04-14 11:13:18'),
(31, 'AERTEMBAGA, BITUNG', '2026-04-14 11:46:16', '2026-04-14 11:46:16'),
(32, 'WENANG, MANADO', '2026-04-14 12:08:09', '2026-04-14 12:08:09'),
(33, 'BIRINGKANAYA, MAKASSAR', '2026-04-16 04:20:25', '2026-04-16 04:20:25'),
(34, 'BIRINGKANAYA', '2026-04-16 04:21:54', '2026-04-16 04:21:54'),
(35, 'TAMALATE', '2026-04-16 06:09:14', '2026-04-16 06:09:14'),
(36, 'TAMALANREA', '2026-04-16 06:16:01', '2026-04-16 06:16:01'),
(37, 'TONDANO', '2026-04-16 07:15:38', '2026-04-16 07:15:38'),
(38, 'AERTEMBAGA', '2026-04-16 07:38:07', '2026-04-16 07:38:07'),
(39, 'LANGOWAN BARAT', '2026-04-16 07:49:22', '2026-04-16 07:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'avatars/69a1923c37f5a.jpeg', NULL, '$2y$12$zDBwuDfLcccw6Ci1sYsL0OTF8Q.z/MBtAoH8YcIq7qeHY8e1Xkp3i', '3EK9bnn6Hrt5yaJxXRuuukK2zVThot1hEFcdmZguESFYmcCjBIa35mlBmpLr', '2026-02-24 08:52:01', '2026-02-27 12:46:52'),
(2, 'Suci', 'suci@gmail.com', 'avatars/69c4acdb80a8d.jpeg', NULL, '$2y$12$HKFPAtNna3uzHgmHTU/kMuI2P4UiCWGzDW9b1OAf3nO0xRc0kaKmS', 'ghB9cOBy4ISkaZMSm7micpIMlzCcuXUx5oKvyDlOuAvAyYjRSBUVOuVCRz7a', '2026-02-26 06:19:00', '2026-03-26 03:49:47'),
(3, 'Haudi', 'haudi@gmail.com', 'avatars/69c4ac78c5b3f.jpeg', NULL, '$2y$12$Hk4kAkxc.uW9rnTbDGP8c.u9jMd5y1sX1xpRSLqEyKRbjkqlejuSC', 'qDhqzNqKSoHhkQ6XMmtwLJURtzyiHMmEPaTqj8mELAvOkavEaOwlrjysu1eO', '2026-03-26 03:24:27', '2026-03-26 03:48:08'),
(4, 'Direktur', 'Direktur@gmail.com', NULL, NULL, '$2y$12$lhhiJi3KE.ohPzXcRX/H9eDNdGemP593v3lip8iXysxKeGzBlAd8a', 'IhBGeavzavWArkadQbpmjnhVBdZ0n6F3YxQmLrvgNFn2qBP1HHDO06BVUnLE', '2026-03-26 03:25:22', '2026-03-26 03:25:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_rekenings`
--
ALTER TABLE `bank_rekenings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `container`
--
ALTER TABLE `container`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `container_nomor_container_unique` (`nomor_container`),
  ADD KEY `container_kapal_id_foreign` (`kapal_id`),
  ADD KEY `container_asal_id_foreign` (`asal_id`),
  ADD KEY `container_tujuan_id_foreign` (`tujuan_id`);

--
-- Indexes for table `container_operational_costs`
--
ALTER TABLE `container_operational_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `container_operational_costs_container_id_foreign` (`container_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `finance`
--
ALTER TABLE `finance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `finance_invoice_id_unique` (`invoice_id`);

--
-- Indexes for table `hutang_piutang`
--
ALTER TABLE `hutang_piutang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hutang_piutang_kode_unique` (`kode`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no_invoice_unique` (`no_invoice`),
  ADD KEY `invoice_pengirim_id_foreign` (`pengirim_id`),
  ADD KEY `invoice_penerima_id_foreign` (`penerima_id`),
  ADD KEY `invoice_container_id_foreign` (`container_id`),
  ADD KEY `invoice_tujuan_daerah_id_foreign` (`tujuan_daerah_id`);

--
-- Indexes for table `invoice_additional_fees`
--
ALTER TABLE `invoice_additional_fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_additional_fees_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `invoice_item_details`
--
ALTER TABLE `invoice_item_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_item_details_invoice_item_id_foreign` (`invoice_item_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `judul_prints`
--
ALTER TABLE `judul_prints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kapal`
--
ALTER TABLE `kapal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_transaksi_kategori_id_foreign` (`transaksi_kategori_id`),
  ADD KEY `transaksis_bank_rekening_id_foreign` (`bank_rekening_id`);

--
-- Indexes for table `transaksi_kategoris`
--
ALTER TABLE `transaksi_kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tujuan`
--
ALTER TABLE `tujuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tujuan_daerah`
--
ALTER TABLE `tujuan_daerah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_rekenings`
--
ALTER TABLE `bank_rekenings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `container`
--
ALTER TABLE `container`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `container_operational_costs`
--
ALTER TABLE `container_operational_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance`
--
ALTER TABLE `finance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `hutang_piutang`
--
ALTER TABLE `hutang_piutang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `invoice_additional_fees`
--
ALTER TABLE `invoice_additional_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=454;

--
-- AUTO_INCREMENT for table `invoice_item_details`
--
ALTER TABLE `invoice_item_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `judul_prints`
--
ALTER TABLE `judul_prints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kapal`
--
ALTER TABLE `kapal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `transaksi_kategoris`
--
ALTER TABLE `transaksi_kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tujuan`
--
ALTER TABLE `tujuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tujuan_daerah`
--
ALTER TABLE `tujuan_daerah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `container`
--
ALTER TABLE `container`
  ADD CONSTRAINT `container_asal_id_foreign` FOREIGN KEY (`asal_id`) REFERENCES `tujuan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `container_kapal_id_foreign` FOREIGN KEY (`kapal_id`) REFERENCES `kapal` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `container_tujuan_id_foreign` FOREIGN KEY (`tujuan_id`) REFERENCES `tujuan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `container_operational_costs`
--
ALTER TABLE `container_operational_costs`
  ADD CONSTRAINT `container_operational_costs_container_id_foreign` FOREIGN KEY (`container_id`) REFERENCES `container` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `finance`
--
ALTER TABLE `finance`
  ADD CONSTRAINT `finance_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_container_id_foreign` FOREIGN KEY (`container_id`) REFERENCES `container` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoice_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_pengirim_id_foreign` FOREIGN KEY (`pengirim_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_tujuan_daerah_id_foreign` FOREIGN KEY (`tujuan_daerah_id`) REFERENCES `tujuan_daerah` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoice_additional_fees`
--
ALTER TABLE `invoice_additional_fees`
  ADD CONSTRAINT `invoice_additional_fees_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_item_details`
--
ALTER TABLE `invoice_item_details`
  ADD CONSTRAINT `invoice_item_details_invoice_item_id_foreign` FOREIGN KEY (`invoice_item_id`) REFERENCES `invoice_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_bank_rekening_id_foreign` FOREIGN KEY (`bank_rekening_id`) REFERENCES `bank_rekenings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_transaksi_kategori_id_foreign` FOREIGN KEY (`transaksi_kategori_id`) REFERENCES `transaksi_kategoris` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
