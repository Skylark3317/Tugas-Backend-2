-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Sep 2025 pada 16.02
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_ella`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) UNSIGNED NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `fitur` varchar(50) NOT NULL,
  `password_input` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `deskripsi`, `kategori`, `harga`, `stok`, `status`, `fitur`, `password_input`) VALUES
(1, 'Kipas Angin', 'ya kipas angin', 'alatpendingin', 80000.00, 10, 'aktif', 'ewallet', 'qwerty'),
(2, 'Kabel', 'ya kabel', 'kelistrikan', 80000.00, 10, 'aktif', 'promo', '$2y$10$E8YiSx1snvkiadVAa8'),
(3, 'Blender', 'ya blender', 'elektronikdapur', 80000.00, 10, 'aktif', 'promo', '$2y$10$RRH5Gn2HjJn4CdRSmZ');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
