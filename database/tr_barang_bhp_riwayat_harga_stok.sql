-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2021 pada 17.26
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_bhp_riwayat_harga_stok`
--

CREATE TABLE `tr_barang_bhp_riwayat_harga_stok` (
  `id_riwayat_bhp` varchar(15) NOT NULL,
  `id_barang_bhp` varchar(7) NOT NULL,
  `harga` int(10) NOT NULL,
  `stok` int(5) NOT NULL,
  `status` enum('lama','baru','-') NOT NULL,
  `tanggal_update` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_barang_bhp_riwayat_harga_stok`
--

INSERT INTO `tr_barang_bhp_riwayat_harga_stok` (`id_riwayat_bhp`, `id_barang_bhp`, `harga`, `stok`, `status`, `tanggal_update`) VALUES
('RB0000000000001', 'KB00001', 10000, 50, 'lama', '2021-06-29 21:58:57'),
('RB0000000000002', 'KB00001', 15000, 40, 'baru', '2021-06-29 22:05:36');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tr_barang_bhp_riwayat_harga_stok`
--
ALTER TABLE `tr_barang_bhp_riwayat_harga_stok`
  ADD PRIMARY KEY (`id_riwayat_bhp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
