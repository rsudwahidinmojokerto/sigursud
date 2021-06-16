-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2021 at 09:28 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

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
-- Stand-in structure for view `detailbarang1`
-- (See below for the actual view)
--
CREATE TABLE `detailbarang1` (
`kd_barang` varchar(7)
,`nama_barang` varchar(40)
,`kd_jenisbarang` varchar(7)
,`kd_distributor` varchar(7)
,`tanggal_masuk` date
,`harga_barang` int(7)
,`stok_barang` int(4)
,`gambar` varchar(255)
,`keterangan` varchar(200)
,`jenis_barang` varchar(30)
,`foto_jenisbarang` varchar(50)
,`nama_distributor` varchar(40)
,`no_telp` varchar(13)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `detailtransaksi`
-- (See below for the actual view)
--
CREATE TABLE `detailtransaksi` (
`kd_pretransaksi` varchar(7)
,`kd_transaksi` varchar(7)
,`kd_barang` varchar(11)
,`jumlah` int(4)
,`sub_total` int(8)
,`nama_barang` varchar(40)
,`harga_barang` int(7)
,`jumlah_beli` int(4)
,`total_harga` int(8)
,`tanggal_beli` date
);

-- --------------------------------------------------------

--
-- Table structure for table `table_barang`
--

CREATE TABLE `table_barang` (
  `kd_barang` varchar(7) NOT NULL,
  `nama_barang` varchar(40) NOT NULL,
  `kd_jenisbarang` varchar(7) NOT NULL,
  `kd_distributor` varchar(7) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `harga_barang` int(7) NOT NULL,
  `stok_barang` int(4) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_barang`
--

INSERT INTO `table_barang` (`kd_barang`, `nama_barang`, `kd_jenisbarang`, `kd_distributor`, `tanggal_masuk`, `harga_barang`, `stok_barang`, `gambar`, `keterangan`) VALUES
('BR001', 'lampu neon 15 watt', 'JB002', 'DS002', '2021-06-11', 15000, 14, '1623373335609.png', 'pcs'),
('BR002', 'superpell', 'JB001', 'DS001', '2021-06-11', 20000, 50, '162337336731.jpg', 'pcs');

-- --------------------------------------------------------

--
-- Table structure for table `table_distributor`
--

CREATE TABLE `table_distributor` (
  `kd_distributor` varchar(7) NOT NULL,
  `nama_distributor` varchar(40) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_distributor`
--

INSERT INTO `table_distributor` (`kd_distributor`, `nama_distributor`, `alamat`, `no_telp`) VALUES
('DS001', 'nana', 'jl. raya', '085749168642'),
('DS002', 'mimin', 'jl. raya indah', '08677709999');

-- --------------------------------------------------------

--
-- Table structure for table `table_jenisbarang`
--

CREATE TABLE `table_jenisbarang` (
  `kd_jenisbarang` varchar(7) NOT NULL,
  `jenis_barang` varchar(30) NOT NULL,
  `foto_jenisbarang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_jenisbarang`
--

INSERT INTO `table_jenisbarang` (`kd_jenisbarang`, `jenis_barang`, `foto_jenisbarang`) VALUES
('JB001', 'Kebersihan', '1623049169258.png'),
('JB002', 'Listrik', '1623049182825.png'),
('JB003', 'ATK', '1623049675251.png');

-- --------------------------------------------------------

--
-- Table structure for table `table_merek`
--

CREATE TABLE `table_merek` (
  `kd_merek` varchar(7) NOT NULL,
  `merek` varchar(30) NOT NULL,
  `foto_merek` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `table_pretransaksi`
--

CREATE TABLE `table_pretransaksi` (
  `kd_pretransaksi` varchar(7) NOT NULL,
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_barang` varchar(11) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `sub_total` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_pretransaksi`
--

INSERT INTO `table_pretransaksi` (`kd_pretransaksi`, `kd_transaksi`, `kd_barang`, `jumlah`, `sub_total`) VALUES
('AN001', 'TR001', 'BR001', 5, 75000),
('AN002', 'TR002', 'BR001', 7, 105000),
('AN003', 'TR002', 'BR004', 7, 10500),
('AN004', 'TR003', 'BR001', 1, 15000),
('AN005', 'TR004', 'BR001', 5, 75000);

--
-- Triggers `table_pretransaksi`
--
DELIMITER $$
CREATE TRIGGER `batal_beli` AFTER DELETE ON `table_pretransaksi` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang + OLD.jumlah
WHERE kd_barang = OLD.kd_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transaksi` AFTER INSERT ON `table_pretransaksi` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang - new.jumlah
WHERE kd_barang = new.kd_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_beli` AFTER UPDATE ON `table_pretransaksi` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang + OLD.jumlah - NEW.jumlah
WHERE kd_barang = new.kd_barang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `table_ruangan`
--

CREATE TABLE `table_ruangan` (
  `kd_ruangan` varchar(7) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_ruangan`
--

INSERT INTO `table_ruangan` (`kd_ruangan`, `nama_ruangan`) VALUES
('RU001', 'keuangan'),
('RU002', 'yanmed');

-- --------------------------------------------------------

--
-- Table structure for table `table_transaksi`
--

CREATE TABLE `table_transaksi` (
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_user` varchar(7) NOT NULL,
  `jumlah_beli` int(4) NOT NULL,
  `total_harga` int(8) NOT NULL,
  `tanggal_beli` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_transaksi`
--

INSERT INTO `table_transaksi` (`kd_transaksi`, `kd_user`, `jumlah_beli`, `total_harga`, `tanggal_beli`) VALUES
('TR001', 'US003', 5, 75000, '2021-06-07'),
('TR002', 'US003', 14, 115500, '2021-06-08'),
('TR003', 'US003', 1, 15000, '2021-06-15'),
('TR004', 'US003', 5, 75000, '2021-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `kd_user` varchar(7) NOT NULL,
  `nama_user` varchar(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `foto_user` varchar(50) NOT NULL,
  `level` enum('Master','Admin','Kasir','Manager') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`kd_user`, `nama_user`, `username`, `password`, `foto_user`, `level`) VALUES
('US001', 'Sakuwan', 'manager', 'bWFuYWdlcjEyMw==', '1538303665653.png', 'Manager'),
('US002', 'Ony', 'admin123', 'YWRtaW4xMjM=', '153777087384.png', 'Admin'),
('US003', 'Puguh', 'kasir123', 'a2FzaXIxMjM=', '1537840377928.png', 'Kasir'),
('US004', 'IT', 'it', 'YWRtaW4xMjM=', '1537840377928.png', 'Master');

-- --------------------------------------------------------

--
-- Table structure for table `tm_barang_bhp`
--

CREATE TABLE `tm_barang_bhp` (
  `id_barang_bhp` varchar(15) NOT NULL,
  `id_kategori_bhp` int(15) NOT NULL,
  `nama_barang_bhp` varchar(80) NOT NULL,
  `harga` int(10) NOT NULL,
  `tanggal_update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_barang_bhp`
--

INSERT INTO `tm_barang_bhp` (`id_barang_bhp`, `id_kategori_bhp`, `nama_barang_bhp`, `harga`, `tanggal_update`) VALUES
('KB00001', 0, 'Kresek UK.15 Putih', 0, '0000-00-00'),
('KB00002', 0, 'Kresek Uk.15 Hitam', 0, '0000-00-00'),
('KB00003', 0, 'Kresek Uk.28 Putih', 0, '0000-00-00'),
('KB00004', 0, 'Kresek Uk.28 Kuning', 0, '0000-00-00'),
('KB00005', 0, 'Kresek Uk.40 Putih', 0, '0000-00-00'),
('KB00006', 0, 'Kantong Uk.60x80 Hitam', 0, '0000-00-00'),
('KB00007', 0, 'Kantong Uk.60x80 Kuning sablon', 0, '0000-00-00'),
('KB00008', 0, 'Kantong Uk.60x80 Unggu sablon', 0, '0000-00-00'),
('KB00009', 0, 'Kantong Uk.50x30 Biru ', 0, '0000-00-00'),
('KB00010', 0, 'Kantong Uk.20x30 Hitam', 0, '0000-00-00'),
('KB00011', 0, 'Plastik 1/2kg', 0, '0000-00-00'),
('KB00012', 0, 'Plastik 1kg', 0, '0000-00-00'),
('KB00013', 0, 'Plastik 2kg', 0, '0000-00-00'),
('KB00014', 0, 'Plastik 3kg', 0, '0000-00-00'),
('KB00015', 0, 'Plastik Klip 7x10', 0, '0000-00-00'),
('KB00016', 0, 'Plastik Klip 8x12', 0, '0000-00-00'),
('KB00017', 0, 'Plastik Kip 10x15', 0, '0000-00-00'),
('KB00018', 0, 'Plastik Klip 16x24', 0, '0000-00-00'),
('KB00019', 0, 'Plastik Klip 30x40', 0, '0000-00-00'),
('KB00020', 0, 'Plastik Opp 30x40', 0, '0000-00-00'),
('KB00021', 0, 'Kantong ROL 25 meter', 0, '0000-00-00'),
('KB00022', 0, 'Kantong Uk.80x100 Hitam', 0, '0000-00-00'),
('KB00023', 0, 'Kantong Uk.80x100 Kuning sablon', 0, '0000-00-00'),
('KB00024', 0, 'Poles', 0, '0000-00-00'),
('KB00025', 0, 'Soklin lantai', 0, '0000-00-00'),
('KB00026', 0, 'Detergen', 0, '0000-00-00'),
('KB00027', 0, 'Cling pembersih kaca', 0, '0000-00-00'),
('KB00028', 0, 'Edel', 0, '0000-00-00'),
('KB00029', 0, 'Bayclin', 0, '0000-00-00'),
('KB00030', 0, 'Sabun cuci tangan. @5 liter', 0, '0000-00-00'),
('KB00031', 0, 'Sabun batang Giv', 0, '0000-00-00'),
('KB00032', 0, 'Sabun cair Giv', 0, '0000-00-00'),
('KB00033', 0, 'Sabun cair anak', 0, '0000-00-00'),
('KB00034', 0, 'Sampo dewasa', 0, '0000-00-00'),
('KB00035', 0, 'Sampo anak', 0, '0000-00-00'),
('KB00036', 0, 'Baby Oil', 0, '0000-00-00'),
('KB00037', 0, 'Slek baby', 0, '0000-00-00'),
('KB00038', 0, 'Sabun Pumppyuri', 0, '0000-00-00'),
('KB00039', 0, 'Stela gantung', 0, '0000-00-00'),
('KB00040', 0, 'Stela Badroom', 0, '0000-00-00'),
('KB00041', 0, 'HIT/Baygon', 0, '0000-00-00'),
('KB00042', 0, 'Byfress', 0, '0000-00-00'),
('KB00043', 0, 'Obat rumput Roundap', 0, '0000-00-00'),
('KB00044', 0, 'Obat rumput DMA', 0, '0000-00-00'),
('KB00045', 0, 'Sapu lidi', 0, '0000-00-00'),
('KB00046', 0, 'Sapu lidi tangkai', 0, '0000-00-00'),
('KB00047', 0, 'Sapu lantai ', 0, '0000-00-00'),
('KB00048', 0, 'sapu + cikrak lantai', 0, '0000-00-00'),
('KB00049', 0, 'Cikrak', 0, '0000-00-00'),
('KB00050', 0, 'Sapu Lowo2 maspion', 0, '0000-00-00'),
('KB00051', 0, 'Sikat tangkai bulat', 0, '0000-00-00'),
('KB00052', 0, 'Sikat tangkai kotak', 0, '0000-00-00'),
('KB00053', 0, 'Tongkat kayu', 0, '0000-00-00'),
('KB00054', 0, 'Tongkat pel panjang', 0, '0000-00-00'),
('KB00055', 0, 'Tongkat pel sumbu', 0, '0000-00-00'),
('KB00056', 0, 'Sorok Air', 0, '0000-00-00'),
('KB00057', 0, 'Sorok kaca', 0, '0000-00-00'),
('KB00058', 0, 'Kasa Hijau', 0, '0000-00-00'),
('KB00059', 0, 'Kasa Spon', 0, '0000-00-00'),
('KB00060', 0, 'Kasa Kawat', 0, '0000-00-00'),
('KB00061', 0, 'Kain Lab kuning', 0, '0000-00-00'),
('KB00062', 0, 'Kain Lab dapur', 0, '0000-00-00'),
('KB00063', 0, 'Waslap', 0, '0000-00-00'),
('KB00064', 0, 'Kanebo', 0, '0000-00-00'),
('KB00065', 0, 'Kapur barus @.5', 0, '0000-00-00'),
('KB00066', 0, 'Kapur Barus 300grm', 0, '0000-00-00'),
('KB00067', 0, 'Wpc', 0, '0000-00-00'),
('KB00068', 0, 'Timba Tanggung', 0, '0000-00-00'),
('KB00069', 0, 'Timba Besar', 0, '0000-00-00'),
('KB00070', 0, 'Gayung', 0, '0000-00-00'),
('KB00071', 0, 'Minyak serimpi', 0, '0000-00-00'),
('KB00072', 0, 'Coutton Bud', 0, '0000-00-00'),
('KB00073', 0, 'Karung Baru', 0, '0000-00-00'),
('KB00074', 0, 'Karung Bekas', 0, '0000-00-00'),
('KB00075', 0, 'Cat Pilog', 0, '0000-00-00'),
('KB00076', 0, 'Tali Rafia', 0, '0000-00-00'),
('KB00077', 0, 'Jas hujan', 0, '0000-00-00'),
('KB00078', 0, 'Hcl', 0, '0000-00-00'),
('KB00079', 0, 'Soda api', 0, '0000-00-00'),
('KB00080', 0, 'Kop wc', 0, '0000-00-00'),
('KB00081', 0, 'Karet Pentil', 0, '0000-00-00'),
('KB00082', 0, 'Silet goal', 0, '0000-00-00'),
('KB00083', 0, 'Tisu See U', 0, '0000-00-00'),
('KB00084', 0, 'Tisu Paseo', 0, '0000-00-00'),
('KB00085', 0, 'Tisu Rol nice', 0, '0000-00-00'),
('KB00086', 0, 'Refil pel sumbu', 0, '0000-00-00'),
('KB00087', 0, 'Refil pel putih', 0, '0000-00-00'),
('KB00088', 0, 'Refil pel biru', 0, '0000-00-00'),
('KB00089', 0, 'Spayer kecil', 0, '0000-00-00'),
('KB00090', 0, 'Spayer besar', 0, '0000-00-00'),
('KB00091', 0, 'Slang Pompa ', 0, '0000-00-00'),
('KB00092', 0, 'Gantungan Baju kawat', 0, '0000-00-00'),
('KB00093', 0, 'Gantungan Baju tempel', 0, '0000-00-00'),
('KB00094', 0, 'Stik tempat sampah ', 0, '0000-00-00'),
('KB00095', 0, 'Onderdil tempat sampah', 0, '0000-00-00'),
('KB00096', 0, 'Kotak Box', 0, '0000-00-00'),
('KB00097', 0, 'Tong Tutup Residu', 0, '0000-00-00'),
('KB00098', 0, 'Keset handuk', 0, '0000-00-00'),
('KB00099', 0, 'Tempat sampah medis 36 + stiker ', 0, '0000-00-00'),
('KB00100', 0, 'Tempat sampah medis 50 + stiker', 0, '0000-00-00'),
('KB00101', 0, 'Tempat sampah non medis 36 + stiker', 0, '0000-00-00'),
('KB00102', 0, 'Tempat sampah non medis 50 + stiker', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tm_kategori_aset`
--

CREATE TABLE `tm_kategori_aset` (
  `id_kategori_aset` varchar(15) NOT NULL COMMENT 'ID Kategori Aset',
  `nama_kategori_aset` varchar(80) NOT NULL COMMENT 'Nama Kategori Aset'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_kategori_aset`
--

INSERT INTO `tm_kategori_aset` (`id_kategori_aset`, `nama_kategori_aset`) VALUES
('AS001', 'ALKES'),
('AS002', 'NON ALKES');

-- --------------------------------------------------------

--
-- Table structure for table `tm_kategori_bhp`
--

CREATE TABLE `tm_kategori_bhp` (
  `id_kategori_bhp` varchar(15) NOT NULL,
  `nama_kategori_bhp` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tm_kategori_bhp`
--

INSERT INTO `tm_kategori_bhp` (`id_kategori_bhp`, `nama_kategori_bhp`) VALUES
('KB001', 'Kebersihan'),
('KB002', 'Listrik'),
('KB003', 'ATK'),
('KB004', 'Cetak'),
('KB005', 'Pemeliharaan');

-- --------------------------------------------------------

--
-- Stand-in structure for view `transaksi`
-- (See below for the actual view)
--
CREATE TABLE `transaksi` (
`kd_pretransaksi` varchar(7)
,`kd_transaksi` varchar(7)
,`kd_barang` varchar(11)
,`jumlah` int(4)
,`sub_total` int(8)
,`nama_barang` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `transaksi_terbaru`
-- (See below for the actual view)
--
CREATE TABLE `transaksi_terbaru` (
`kd_transaksi` varchar(7)
,`kd_user` varchar(7)
,`jumlah_beli` int(4)
,`total_harga` int(8)
,`tanggal_beli` date
,`nama_user` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `tr_stok_barang_bhp`
--

CREATE TABLE `tr_stok_barang_bhp` (
  `id_trx_barang_bhp` varchar(30) NOT NULL,
  `id_barang_bhp` varchar(15) NOT NULL,
  `harga_lama` int(10) NOT NULL,
  `harga_baru` int(10) NOT NULL,
  `stok_lama` int(5) NOT NULL,
  `stok_baru` int(5) NOT NULL,
  `harga_rata` int(10) NOT NULL,
  `harga_total` int(20) NOT NULL,
  `operator` varchar(35) NOT NULL,
  `tanggal_trx` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure for view `detailbarang1`
--
DROP TABLE IF EXISTS `detailbarang1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detailbarang1`  AS  select `table_barang`.`kd_barang` AS `kd_barang`,`table_barang`.`nama_barang` AS `nama_barang`,`table_barang`.`kd_jenisbarang` AS `kd_jenisbarang`,`table_barang`.`kd_distributor` AS `kd_distributor`,`table_barang`.`tanggal_masuk` AS `tanggal_masuk`,`table_barang`.`harga_barang` AS `harga_barang`,`table_barang`.`stok_barang` AS `stok_barang`,`table_barang`.`gambar` AS `gambar`,`table_barang`.`keterangan` AS `keterangan`,`table_jenisbarang`.`jenis_barang` AS `jenis_barang`,`table_jenisbarang`.`foto_jenisbarang` AS `foto_jenisbarang`,`table_distributor`.`nama_distributor` AS `nama_distributor`,`table_distributor`.`no_telp` AS `no_telp` from ((`table_barang` join `table_jenisbarang` on(`table_barang`.`kd_jenisbarang` = `table_jenisbarang`.`kd_jenisbarang`)) join `table_distributor` on(`table_barang`.`kd_distributor` = `table_distributor`.`kd_distributor`)) ;

-- --------------------------------------------------------

--
-- Structure for view `detailtransaksi`
--
DROP TABLE IF EXISTS `detailtransaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detailtransaksi`  AS  select `table_pretransaksi`.`kd_pretransaksi` AS `kd_pretransaksi`,`table_pretransaksi`.`kd_transaksi` AS `kd_transaksi`,`table_pretransaksi`.`kd_barang` AS `kd_barang`,`table_pretransaksi`.`jumlah` AS `jumlah`,`table_pretransaksi`.`sub_total` AS `sub_total`,`table_barang`.`nama_barang` AS `nama_barang`,`table_barang`.`harga_barang` AS `harga_barang`,`table_transaksi`.`jumlah_beli` AS `jumlah_beli`,`table_transaksi`.`total_harga` AS `total_harga`,`table_transaksi`.`tanggal_beli` AS `tanggal_beli` from ((`table_pretransaksi` join `table_barang` on(`table_pretransaksi`.`kd_barang` = `table_barang`.`kd_barang`)) join `table_transaksi` on(`table_transaksi`.`kd_transaksi` = `table_pretransaksi`.`kd_transaksi`)) ;

-- --------------------------------------------------------

--
-- Structure for view `transaksi`
--
DROP TABLE IF EXISTS `transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi`  AS  select `table_pretransaksi`.`kd_pretransaksi` AS `kd_pretransaksi`,`table_pretransaksi`.`kd_transaksi` AS `kd_transaksi`,`table_pretransaksi`.`kd_barang` AS `kd_barang`,`table_pretransaksi`.`jumlah` AS `jumlah`,`table_pretransaksi`.`sub_total` AS `sub_total`,`table_barang`.`nama_barang` AS `nama_barang` from (`table_pretransaksi` join `table_barang` on(`table_pretransaksi`.`kd_barang` = `table_barang`.`kd_barang`)) ;

-- --------------------------------------------------------

--
-- Structure for view `transaksi_terbaru`
--
DROP TABLE IF EXISTS `transaksi_terbaru`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi_terbaru`  AS  select `table_transaksi`.`kd_transaksi` AS `kd_transaksi`,`table_transaksi`.`kd_user` AS `kd_user`,`table_transaksi`.`jumlah_beli` AS `jumlah_beli`,`table_transaksi`.`total_harga` AS `total_harga`,`table_transaksi`.`tanggal_beli` AS `tanggal_beli`,`table_user`.`nama_user` AS `nama_user` from (`table_transaksi` join `table_user` on(`table_transaksi`.`kd_user` = `table_user`.`kd_user`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_barang`
--
ALTER TABLE `table_barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD KEY `kd_distributor` (`kd_distributor`),
  ADD KEY `kd_merek` (`kd_jenisbarang`);

--
-- Indexes for table `table_distributor`
--
ALTER TABLE `table_distributor`
  ADD PRIMARY KEY (`kd_distributor`);

--
-- Indexes for table `table_jenisbarang`
--
ALTER TABLE `table_jenisbarang`
  ADD PRIMARY KEY (`kd_jenisbarang`);

--
-- Indexes for table `table_merek`
--
ALTER TABLE `table_merek`
  ADD PRIMARY KEY (`kd_merek`);

--
-- Indexes for table `table_pretransaksi`
--
ALTER TABLE `table_pretransaksi`
  ADD PRIMARY KEY (`kd_pretransaksi`);

--
-- Indexes for table `table_ruangan`
--
ALTER TABLE `table_ruangan`
  ADD PRIMARY KEY (`kd_ruangan`);

--
-- Indexes for table `table_transaksi`
--
ALTER TABLE `table_transaksi`
  ADD PRIMARY KEY (`kd_transaksi`),
  ADD KEY `kd_user` (`kd_user`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`kd_user`);

--
-- Indexes for table `tm_barang_bhp`
--
ALTER TABLE `tm_barang_bhp`
  ADD PRIMARY KEY (`id_barang_bhp`);

--
-- Indexes for table `tm_kategori_bhp`
--
ALTER TABLE `tm_kategori_bhp`
  ADD PRIMARY KEY (`id_kategori_bhp`);

--
-- Indexes for table `tr_stok_barang_bhp`
--
ALTER TABLE `tr_stok_barang_bhp`
  ADD PRIMARY KEY (`id_trx_barang_bhp`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_transaksi`
--
ALTER TABLE `table_transaksi`
  ADD CONSTRAINT `table_transaksi_ibfk_1` FOREIGN KEY (`kd_user`) REFERENCES `table_user` (`kd_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
