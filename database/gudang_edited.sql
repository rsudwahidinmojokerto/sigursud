-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jun 2021 pada 17.58
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
-- Struktur dari tabel `tm_level_user`
--

CREATE TABLE `tm_level_user` (
  `id_level_user` varchar(7) NOT NULL,
  `nama_level_user` varchar(10) NOT NULL,
  `akses` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tm_level_user`
--

INSERT INTO `tm_level_user` (`id_level_user`, `nama_level_user`, `akses`) VALUES
('LV001', 'Master', ''),
('LV002', 'Manager', ''),
('LV003', 'Admin', ''),
('LV004', 'Kasir', ''),
('LV005', 'Umum', '');

-- --------------------------------------------------------

--
-- Dumping data untuk tabel `tm_user`
--

INSERT INTO `tm_user` (`id_user`, `id_ruangan`, `nama_user`, `username`, `password`, `foto_user`, `level`) VALUES
('US00001', 'RU001', 'IT', 'it', 'YWRtaW4xMjM=', 'man03.jpg', 'Master'),
('US00002', 'RU002', 'Sakuwan', 'manager', 'bWFuYWdlcjEyMw==', 'man01.jpg', 'Manager'),
('US00003', 'RU002', 'Ony', 'admin123', 'YWRtaW4xMjM=', 'man02.jpg', 'Admin'),
('US00004', 'RU002', 'Puguh', 'kasir123', 'a2FzaXIxMjM=', 'man04.jpg', 'Kasir');

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
