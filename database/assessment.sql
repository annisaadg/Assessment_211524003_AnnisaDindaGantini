-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 28 Nov 2023 pada 16.27
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assessment`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_tenant` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `code`, `name`, `unit`, `price`, `stock`, `id_tenant`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'GPB-01', 'Ayam Geprek Bebas Sambal Matah', 'bungkus', '25000', 100, 1, 1, 0, '2023-11-28 02:18:58', '2023-11-28 08:20:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kasir`
--

CREATE TABLE `kasir` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kasir`
--

INSERT INTO `kasir` (`id`, `code`, `username`, `password`, `fullname`, `phone_number`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '1', 'kasir1', '$2y$10$4bXo4FCe07SM530k6JGo8eq3U.VrMZRiEJSl/gQOXPPOM3uzK62bG', 'Kasir 1', '0895392054983', 1, 0, '2023-11-28 08:34:05', '2023-11-28 03:00:24'),
(2, '2', 'kasir2', '$2y$10$nyWxWLef2hDljlS.M5C.s.YUAjjyovAjtwzBQIXVylqbiG9Ftgfw2', 'Kasir 2', '085156398529', 1, 0, '2023-11-28 03:02:36', '2023-11-28 03:02:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `id_kasir` int(11) NOT NULL,
  `grand_total` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order`
--

INSERT INTO `order` (`id`, `transaction_id`, `id_kasir`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, 'TR-1701182488', 1, '100000', '2023-11-28 07:41:28', '2023-11-28 07:41:28'),
(2, 'TR-1701184912', 1, '250000', '2023-11-28 08:21:52', '2023-11-28 08:21:52'),
(3, 'TR-1701184955', 1, '375000', '2023-11-28 08:22:35', '2023-11-28 08:22:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` varchar(100) NOT NULL,
  `id_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_detail`
--

INSERT INTO `order_detail` (`id`, `id_barang`, `qty`, `id_order`, `created_at`, `updated_at`) VALUES
(1, 1, '10', 1, '2023-11-28 07:41:28', '2023-11-28 07:41:28'),
(2, 1, '10', 2, '2023-11-28 08:21:52', '2023-11-28 08:21:52'),
(3, 1, '5', 3, '2023-11-28 08:22:35', '2023-11-28 08:22:35'),
(4, 1, '10', 3, '2023-11-28 08:22:35', '2023-11-28 08:22:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tenant`
--

CREATE TABLE `tenant` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tenant`
--

INSERT INTO `tenant` (`id`, `name`, `code`, `phone_number`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Ayam Geprek Bebas', 'GPB', '0895392054983', 1, 0, '2023-11-28 02:43:15', '2023-11-28 08:19:22'),
(2, 'Ayam KQ5', 'KQ5', '0895392054983', 1, 0, '2023-11-28 08:21:24', '2023-11-28 08:21:24');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_FK` (`id_tenant`);

--
-- Indeks untuk tabel `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_FK` (`id_kasir`);

--
-- Indeks untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_detail_FK` (`id_order`),
  ADD KEY `order_detail_FK_1` (`id_barang`);

--
-- Indeks untuk tabel `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tenant`
--
ALTER TABLE `tenant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_FK` FOREIGN KEY (`id_tenant`) REFERENCES `tenant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_FK` FOREIGN KEY (`id_kasir`) REFERENCES `kasir` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_FK` FOREIGN KEY (`id_order`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_FK_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
