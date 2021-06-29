-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2021 pada 16.35
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
-- Struktur dari tabel `detailtransaksi`
--

CREATE TABLE `detailtransaksi` (
  `kd_pretransaksi` varchar(7) DEFAULT NULL,
  `kd_transaksi` varchar(7) DEFAULT NULL,
  `kd_barang` varchar(11) DEFAULT NULL,
  `jumlah` int(4) DEFAULT NULL,
  `sub_total` int(8) DEFAULT NULL,
  `nama_barang` varchar(40) DEFAULT NULL,
  `harga_barang` int(7) DEFAULT NULL,
  `jumlah_beli` int(4) DEFAULT NULL,
  `total_harga` int(8) DEFAULT NULL,
  `tanggal_beli` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` varchar(15) NOT NULL,
  `id_user` varchar(7) NOT NULL,
  `id_objek` varchar(15) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `id_user`, `id_objek`, `keterangan`, `tanggal`) VALUES
('TMP2106250001', 'US00006', 'US00007', 'Tambah User Catur Hidayatulloh', '2021-06-25 23:04:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_barang`
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
-- Dumping data untuk tabel `table_barang`
--

INSERT INTO `table_barang` (`kd_barang`, `nama_barang`, `kd_jenisbarang`, `kd_distributor`, `tanggal_masuk`, `harga_barang`, `stok_barang`, `gambar`, `keterangan`) VALUES
('BR001', 'lampu neon 15 watt', 'JB002', 'DS002', '2021-06-11', 15000, 11, '1623373335609.png', 'pcs'),
('BR002', 'superpell', 'JB001', 'DS001', '2021-06-11', 20000, 48, '162337336731.jpg', 'pcs');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_jenisbarang`
--

CREATE TABLE `table_jenisbarang` (
  `kd_jenisbarang` varchar(7) NOT NULL,
  `jenis_barang` varchar(30) NOT NULL,
  `foto_jenisbarang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `table_jenisbarang`
--

INSERT INTO `table_jenisbarang` (`kd_jenisbarang`, `jenis_barang`, `foto_jenisbarang`) VALUES
('JB001', 'Kebersihan', '1623049169258.png'),
('JB002', 'Listrik', '1623049182825.png'),
('JB003', 'ATK', '1623049675251.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_merek`
--

CREATE TABLE `table_merek` (
  `kd_merek` varchar(7) NOT NULL,
  `merek` varchar(30) NOT NULL,
  `foto_merek` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_pretransaksi`
--

CREATE TABLE `table_pretransaksi` (
  `kd_pretransaksi` varchar(7) NOT NULL,
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_barang` varchar(11) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `sub_total` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `table_pretransaksi`
--

INSERT INTO `table_pretransaksi` (`kd_pretransaksi`, `kd_transaksi`, `kd_barang`, `jumlah`, `sub_total`) VALUES
('AN001', 'TR001', 'BR001', 5, 75000),
('AN002', 'TR002', 'BR001', 7, 105000),
('AN003', 'TR002', 'BR004', 7, 10500),
('AN004', 'TR003', 'BR001', 1, 15000),
('AN005', 'TR004', 'BR001', 5, 75000),
('AN006', 'TR005', 'BR001', 3, 45000),
('AN007', 'TR005', 'BR002', 2, 40000);

--
-- Trigger `table_pretransaksi`
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
-- Struktur dari tabel `table_transaksi`
--

CREATE TABLE `table_transaksi` (
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_user` varchar(7) NOT NULL,
  `jumlah_beli` int(4) NOT NULL,
  `total_harga` int(8) NOT NULL,
  `tanggal_beli` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `table_transaksi`
--

INSERT INTO `table_transaksi` (`kd_transaksi`, `kd_user`, `jumlah_beli`, `total_harga`, `tanggal_beli`) VALUES
('TR001', 'US003', 5, 75000, '2021-06-07'),
('TR002', 'US003', 14, 115500, '2021-06-08'),
('TR003', 'US003', 1, 15000, '2021-06-15'),
('TR004', 'US003', 5, 75000, '2021-06-15'),
('TR005', 'US003', 5, 85000, '2021-06-17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tm_barang_bhp`
--

CREATE TABLE `tm_barang_bhp` (
  `id_barang_bhp` varchar(15) NOT NULL,
  `id_kategori_bhp` varchar(15) NOT NULL,
  `nama_barang_bhp` varchar(80) NOT NULL,
  `tanggal_update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tm_barang_bhp`
--

INSERT INTO `tm_barang_bhp` (`id_barang_bhp`, `id_kategori_bhp`, `nama_barang_bhp`, `tanggal_update`) VALUES
('KB00001', 'HP001', 'Kresek UK.15 Putih', '0000-00-00'),
('KB00002', 'HP001', 'Kresek Uk.15 Hitam', '0000-00-00'),
('KB00003', 'HP001', 'Kresek Uk.28 Putih', '0000-00-00'),
('KB00004', 'HP001', 'Kresek Uk.28 Kuning', '0000-00-00'),
('KB00005', 'HP001', 'Kresek Uk.40 Putih', '0000-00-00'),
('KB00006', 'HP001', 'Kantong Uk.60x80 Hitam', '0000-00-00'),
('KB00007', 'HP001', 'Kantong Uk.60x80 Kuning sablon', '0000-00-00'),
('KB00008', 'HP001', 'Kantong Uk.60x80 Unggu sablon', '0000-00-00'),
('KB00009', 'HP001', 'Kantong Uk.50x30 Biru ', '0000-00-00'),
('KB00010', 'HP001', 'Kantong Uk.20x30 Hitam', '0000-00-00'),
('KB00011', 'HP001', 'Plastik 1/2kg', '0000-00-00'),
('KB00012', 'HP001', 'Plastik 1kg', '0000-00-00'),
('KB00013', 'HP001', 'Plastik 2kg', '0000-00-00'),
('KB00014', 'HP001', 'Plastik 3kg', '0000-00-00'),
('KB00015', 'HP001', 'Plastik Klip 7x10', '0000-00-00'),
('KB00016', 'HP001', 'Plastik Klip 8x12', '0000-00-00'),
('KB00017', 'HP001', 'Plastik Kip 10x15', '0000-00-00'),
('KB00018', 'HP001', 'Plastik Klip 16x24', '0000-00-00'),
('KB00019', 'HP001', 'Plastik Klip 30x40', '0000-00-00'),
('KB00020', 'HP001', 'Plastik Opp 30x40', '0000-00-00'),
('KB00021', 'HP001', 'Kantong ROL 25 meter', '0000-00-00'),
('KB00022', 'HP001', 'Kantong Uk.80x100 Hitam', '0000-00-00'),
('KB00023', 'HP001', 'Kantong Uk.80x100 Kuning sablon', '0000-00-00'),
('KB00024', 'HP001', 'Poles', '0000-00-00'),
('KB00025', 'HP001', 'Soklin lantai', '0000-00-00'),
('KB00026', 'HP001', 'Detergen', '0000-00-00'),
('KB00027', 'HP001', 'Cling pembersih kaca', '0000-00-00'),
('KB00028', 'HP001', 'Edel', '0000-00-00'),
('KB00029', 'HP001', 'Bayclin', '0000-00-00'),
('KB00030', 'HP001', 'Sabun cuci tangan. @5 liter', '0000-00-00'),
('KB00031', 'HP001', 'Sabun batang Giv', '0000-00-00'),
('KB00032', 'HP001', 'Sabun cair Giv', '0000-00-00'),
('KB00033', 'HP001', 'Sabun cair anak', '0000-00-00'),
('KB00034', 'HP001', 'Sampo dewasa', '0000-00-00'),
('KB00035', 'HP001', 'Sampo anak', '0000-00-00'),
('KB00036', 'HP001', 'Baby Oil', '0000-00-00'),
('KB00037', 'HP001', 'Slek baby', '0000-00-00'),
('KB00038', 'HP001', 'Sabun Pumppyuri', '0000-00-00'),
('KB00039', 'HP001', 'Stela gantung', '0000-00-00'),
('KB00040', 'HP001', 'Stela Badroom', '0000-00-00'),
('KB00041', 'HP001', 'HIT/Baygon', '0000-00-00'),
('KB00042', 'HP001', 'Byfress', '0000-00-00'),
('KB00043', 'HP001', 'Obat rumput Roundap', '0000-00-00'),
('KB00044', 'HP001', 'Obat rumput DMA', '0000-00-00'),
('KB00045', 'HP001', 'Sapu lidi', '0000-00-00'),
('KB00046', 'HP001', 'Sapu lidi tangkai', '0000-00-00'),
('KB00047', 'HP001', 'Sapu lantai ', '0000-00-00'),
('KB00048', 'HP001', 'sapu + cikrak lantai', '0000-00-00'),
('KB00049', 'HP001', 'Cikrak', '0000-00-00'),
('KB00050', 'HP001', 'Sapu Lowo2 maspion', '0000-00-00'),
('KB00051', 'HP001', 'Sikat tangkai bulat', '0000-00-00'),
('KB00052', 'HP001', 'Sikat tangkai kotak', '0000-00-00'),
('KB00053', 'HP001', 'Tongkat kayu', '0000-00-00'),
('KB00054', 'HP001', 'Tongkat pel panjang', '0000-00-00'),
('KB00055', 'HP001', 'Tongkat pel sumbu', '0000-00-00'),
('KB00056', 'HP001', 'Sorok Air', '0000-00-00'),
('KB00057', 'HP001', 'Sorok kaca', '0000-00-00'),
('KB00058', 'HP001', 'Kasa Hijau', '0000-00-00'),
('KB00059', 'HP001', 'Kasa Spon', '0000-00-00'),
('KB00060', 'HP001', 'Kasa Kawat', '0000-00-00'),
('KB00061', 'HP001', 'Kain Lab kuning', '0000-00-00'),
('KB00062', 'HP001', 'Kain Lab dapur', '0000-00-00'),
('KB00063', 'HP001', 'Waslap', '0000-00-00'),
('KB00064', 'HP001', 'Kanebo', '0000-00-00'),
('KB00065', 'HP001', 'Kapur barus @.5', '0000-00-00'),
('KB00066', 'HP001', 'Kapur Barus 300grm', '0000-00-00'),
('KB00067', 'HP001', 'Wpc', '0000-00-00'),
('KB00068', 'HP001', 'Timba Tanggung', '0000-00-00'),
('KB00069', 'HP001', 'Timba Besar', '0000-00-00'),
('KB00070', 'HP001', 'Gayung', '0000-00-00'),
('KB00071', 'HP001', 'Minyak serimpi', '0000-00-00'),
('KB00072', 'HP001', 'Coutton Bud', '0000-00-00'),
('KB00073', 'HP001', 'Karung Baru', '0000-00-00'),
('KB00074', 'HP001', 'Karung Bekas', '0000-00-00'),
('KB00075', 'HP001', 'Cat Pilog', '0000-00-00'),
('KB00076', 'HP001', 'Tali Rafia', '0000-00-00'),
('KB00077', 'HP001', 'Jas hujan', '0000-00-00'),
('KB00078', 'HP001', 'Hcl', '0000-00-00'),
('KB00079', 'HP001', 'Soda api', '0000-00-00'),
('KB00080', 'HP001', 'Kop wc', '0000-00-00'),
('KB00081', 'HP001', 'Karet Pentil', '0000-00-00'),
('KB00082', 'HP001', 'Silet goal', '0000-00-00'),
('KB00083', 'HP001', 'Tisu See U', '0000-00-00'),
('KB00084', 'HP001', 'Tisu Paseo', '0000-00-00'),
('KB00085', 'HP001', 'Tisu Rol nice', '0000-00-00'),
('KB00086', 'HP001', 'Refil pel sumbu', '0000-00-00'),
('KB00087', 'HP001', 'Refil pel putih', '0000-00-00'),
('KB00088', 'HP001', 'Refil pel biru', '0000-00-00'),
('KB00089', 'HP001', 'Spayer kecil', '0000-00-00'),
('KB00090', 'HP001', 'Spayer besar', '0000-00-00'),
('KB00091', 'HP001', 'Slang Pompa ', '0000-00-00'),
('KB00092', 'HP001', 'Gantungan Baju kawat', '0000-00-00'),
('KB00093', 'HP001', 'Gantungan Baju tempel', '0000-00-00'),
('KB00094', 'HP001', 'Stik tempat sampah ', '0000-00-00'),
('KB00095', 'HP001', 'Onderdil tempat sampah', '0000-00-00'),
('KB00096', 'HP001', 'Kotak Box', '0000-00-00'),
('KB00097', 'HP001', 'Tong Tutup Residu', '0000-00-00'),
('KB00098', 'HP001', 'Keset handuk', '0000-00-00'),
('KB00099', 'HP001', 'Tempat sampah medis 36 + stiker ', '0000-00-00'),
('KB00100', 'HP001', 'Tempat sampah medis 50 + stiker', '0000-00-00'),
('KB00101', 'HP001', 'Tempat sampah non medis 36 + stiker', '0000-00-00'),
('KB00102', 'HP001', 'Tempat sampah non medis 50 + stiker', '0000-00-00'),
('KB00103', 'HP001', 'plastik merah besar', '2021-06-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tm_distributor`
--

CREATE TABLE `tm_distributor` (
  `id_distributor` varchar(7) NOT NULL,
  `nama_distributor` varchar(40) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tm_distributor`
--

INSERT INTO `tm_distributor` (`id_distributor`, `nama_distributor`, `alamat`, `telp`) VALUES
('DS00001', 'PT. Maju Mundur', 'Jalan Mawar RT. 02 RW. 04, Ds. Claket, Kec. Pacet, Kab. Mojokerto', '085749168642'),
('DS00002', 'PT. Cahya Kinasih', 'jl. raya indah', '08677709999');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tm_kategori_aset`
--

CREATE TABLE `tm_kategori_aset` (
  `id_kategori_aset` varchar(15) NOT NULL COMMENT 'ID Kategori Aset',
  `nama_kategori_aset` varchar(80) NOT NULL COMMENT 'Nama Kategori Aset'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tm_kategori_aset`
--

INSERT INTO `tm_kategori_aset` (`id_kategori_aset`, `nama_kategori_aset`) VALUES
('AS001', 'MEDIS'),
('AS002', 'NON MEDIS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tm_kategori_bhp`
--

CREATE TABLE `tm_kategori_bhp` (
  `id_kategori_bhp` varchar(15) NOT NULL,
  `nama_kategori_bhp` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tm_kategori_bhp`
--

INSERT INTO `tm_kategori_bhp` (`id_kategori_bhp`, `nama_kategori_bhp`) VALUES
('HP001', 'Kebersihan'),
('HP002', 'Listrik'),
('HP003', 'ATK'),
('HP004', 'Cetak'),
('HP005', 'Pemeliharaan');

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
-- Struktur dari tabel `tm_ruangan`
--

CREATE TABLE `tm_ruangan` (
  `id_ruangan` varchar(7) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tm_ruangan`
--

INSERT INTO `tm_ruangan` (`id_ruangan`, `nama_ruangan`) VALUES
('RU001', 'Ruang IT/Server'),
('RU002', 'Gudang'),
('RU003', 'Ruang Kencono Wungu'),
('RU004', 'Ruang Kertabhumi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tm_satuan`
--

CREATE TABLE `tm_satuan` (
  `id_satuan` varchar(7) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL,
  `jumlah_satuan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tm_satuan`
--

INSERT INTO `tm_satuan` (`id_satuan`, `nama_satuan`, `jumlah_satuan`) VALUES
('ST001', 'box', 1),
('ST002', 'unit', 1),
('ST003', 'pcs', 1),
('ST004', 'pacs', 1),
('ST005', 'lusin', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tm_user`
--

CREATE TABLE `tm_user` (
  `id_user` varchar(7) NOT NULL,
  `id_ruangan` varchar(7) NOT NULL,
  `id_level_user` varchar(7) NOT NULL,
  `nama_user` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `foto_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tm_user`
--

INSERT INTO `tm_user` (`id_user`, `id_ruangan`, `id_level_user`, `nama_user`, `username`, `password`, `foto_user`) VALUES
('US00001', 'RU001', 'LV001', 'IT', 'it', 'YWRtaW4xMjM=', 'man03.jpg'),
('US00002', 'RU002', 'LV002', 'Sakuwan', 'manager', 'bWFuYWdlcjEyMw==', 'man01.jpg'),
('US00003', 'RU002', 'LV003', 'Ony', 'admin123', 'YWRtaW4xMjM=', 'man02.jpg'),
('US00004', 'RU002', 'LV004', 'Puguh', 'kasir123', 'a2FzaXIxMjM=', 'man04.jpg'),
('US00006', 'RU001', 'LV001', 'Andrean Bagus Mahend', 'hendrait', 'MTIz', '1624638417248.jpg'),
('US00007', 'RU001', 'LV001', 'Amir Khan', 'amirit', 'MTIz', '1624638456795.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `kd_pretransaksi` varchar(7) DEFAULT NULL,
  `kd_transaksi` varchar(7) DEFAULT NULL,
  `kd_barang` varchar(11) DEFAULT NULL,
  `jumlah` int(4) DEFAULT NULL,
  `sub_total` int(8) DEFAULT NULL,
  `nama_barang` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_bhp`
--

CREATE TABLE `tr_barang_bhp` (
  `id_transaksi` varchar(15) NOT NULL,
  `harga_total` int(10) NOT NULL,
  `status` enum('masuk','keluar') NOT NULL,
  `tanggal_transaksi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_bhp_keluar_detail`
--

CREATE TABLE `tr_barang_bhp_keluar_detail` (
  `id_bhp_keluar` varchar(15) NOT NULL,
  `id_transaksi` varchar(15) NOT NULL,
  `id_barang_bhp` varchar(7) NOT NULL,
  `id_ruangan` varchar(7) NOT NULL,
  `harga` int(10) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tanggal_keluar` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_bhp_masuk_detail`
--

CREATE TABLE `tr_barang_bhp_masuk_detail` (
  `id_bhp_masuk` varchar(15) NOT NULL,
  `id_transaksi` varchar(15) NOT NULL,
  `id_barang_bhp` varchar(7) NOT NULL,
  `id_distributor` varchar(7) NOT NULL,
  `harga` int(10) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tanggal_masuk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_pretransaksi_stok_masuk`
--

CREATE TABLE `tr_pretransaksi_stok_masuk` (
  `id_pretransaksi_stok_masuk` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_stok_barang_bhp`
--

CREATE TABLE `tr_stok_barang_bhp` (
  `id_trx_barang_bhp` varchar(30) NOT NULL,
  `id_barang_bhp` varchar(15) NOT NULL,
  `harga_baru` int(10) NOT NULL,
  `stok_baru` int(5) NOT NULL,
  `harga_rata` int(10) NOT NULL,
  `operator` varchar(35) NOT NULL,
  `tanggal_trx` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_transaksi_stok_masuk`
--

CREATE TABLE `tr_transaksi_stok_masuk` (
  `id_transaksi_stok_masuk` varchar(11) NOT NULL,
  `id_user` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indeks untuk tabel `table_barang`
--
ALTER TABLE `table_barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD KEY `kd_distributor` (`kd_distributor`),
  ADD KEY `kd_merek` (`kd_jenisbarang`);

--
-- Indeks untuk tabel `table_jenisbarang`
--
ALTER TABLE `table_jenisbarang`
  ADD PRIMARY KEY (`kd_jenisbarang`);

--
-- Indeks untuk tabel `table_merek`
--
ALTER TABLE `table_merek`
  ADD PRIMARY KEY (`kd_merek`);

--
-- Indeks untuk tabel `table_pretransaksi`
--
ALTER TABLE `table_pretransaksi`
  ADD PRIMARY KEY (`kd_pretransaksi`);

--
-- Indeks untuk tabel `table_transaksi`
--
ALTER TABLE `table_transaksi`
  ADD PRIMARY KEY (`kd_transaksi`),
  ADD KEY `kd_user` (`kd_user`);

--
-- Indeks untuk tabel `tm_barang_bhp`
--
ALTER TABLE `tm_barang_bhp`
  ADD PRIMARY KEY (`id_barang_bhp`),
  ADD KEY `id_kategori_bhp` (`id_kategori_bhp`);

--
-- Indeks untuk tabel `tm_distributor`
--
ALTER TABLE `tm_distributor`
  ADD PRIMARY KEY (`id_distributor`);

--
-- Indeks untuk tabel `tm_kategori_aset`
--
ALTER TABLE `tm_kategori_aset`
  ADD PRIMARY KEY (`id_kategori_aset`);

--
-- Indeks untuk tabel `tm_kategori_bhp`
--
ALTER TABLE `tm_kategori_bhp`
  ADD PRIMARY KEY (`id_kategori_bhp`);

--
-- Indeks untuk tabel `tm_level_user`
--
ALTER TABLE `tm_level_user`
  ADD PRIMARY KEY (`id_level_user`);

--
-- Indeks untuk tabel `tm_ruangan`
--
ALTER TABLE `tm_ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indeks untuk tabel `tm_user`
--
ALTER TABLE `tm_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indeks untuk tabel `tr_barang_bhp`
--
ALTER TABLE `tr_barang_bhp`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `tr_barang_bhp_keluar_detail`
--
ALTER TABLE `tr_barang_bhp_keluar_detail`
  ADD PRIMARY KEY (`id_bhp_keluar`);

--
-- Indeks untuk tabel `tr_barang_bhp_masuk_detail`
--
ALTER TABLE `tr_barang_bhp_masuk_detail`
  ADD PRIMARY KEY (`id_bhp_masuk`);

--
-- Indeks untuk tabel `tr_barang_bhp_riwayat_harga_stok`
--
ALTER TABLE `tr_barang_bhp_riwayat_harga_stok`
  ADD PRIMARY KEY (`id_riwayat_bhp`);

--
-- Indeks untuk tabel `tr_stok_barang_bhp`
--
ALTER TABLE `tr_stok_barang_bhp`
  ADD PRIMARY KEY (`id_trx_barang_bhp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
