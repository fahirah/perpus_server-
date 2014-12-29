-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 29. Desember 2014 jam 16:00
-- Versi Server: 5.5.16
-- Versi PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbpkl_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_aktivitas`
--

CREATE TABLE IF NOT EXISTS `tbl_aktivitas` (
  `kode_aktivitas` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) NOT NULL,
  `kode_file` int(11) NOT NULL,
  `tgl_download` date NOT NULL,
  PRIMARY KEY (`kode_aktivitas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_aktivitas`
--

INSERT INTO `tbl_aktivitas` (`kode_aktivitas`, `id_anggota`, `kode_file`, `tgl_download`) VALUES
(1, 1, 1, '2014-12-29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_anggota`
--

CREATE TABLE IF NOT EXISTS `tbl_anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `nama_anggota` varchar(30) NOT NULL,
  `no_identitas` varchar(15) NOT NULL,
  `alamat_anggota` varchar(30) NOT NULL,
  `telp_anggota` varchar(15) NOT NULL,
  `jeniskelamin_anggota` varchar(15) NOT NULL,
  `status_anggota` varchar(10) NOT NULL,
  `kode_prodi` int(11) NOT NULL,
  `password_anggota` varchar(50) NOT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nama_anggota`, `no_identitas`, `alamat_anggota`, `telp_anggota`, `jeniskelamin_anggota`, `status_anggota`, `kode_prodi`, `password_anggota`) VALUES
(1, 'dani cita', '1155201878', 'parteker', '08175089011', 'P', 'm', 1, '827ccb0eea8a706c4c34a16891f84e7b'),
(2, 'susi', '1155201854', 'palenga''an', '0817501245', 'P', 'm', 1, '220ee574c0b0075ac195b3b052abefe4'),
(3, 'iis', '1155201870', 'pasean', '081738391', 'P', 'm', 2, '2fb902020ccae5312653ede8e580f373'),
(4, 'nazir', '00011', 'bluto sumenep', '0879504948', 'L', 'd', 1, '85cf77b36c41e3f038dd4883f71bca2f'),
(5, 'arifin', '00012', 'pamekasan', '087648392', 'L', 'd', 2, 'c11e93d2f88e9e393d5008f1e313a974'),
(6, 'wahyu', '0955201701', 'ghazali', '081791719', 'L', 'm', 2, '09ca228e29d4fb9b291ee8f28d6b8908');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_buku`
--

CREATE TABLE IF NOT EXISTS `tbl_buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(20) NOT NULL,
  `isbn_buku` varchar(30) NOT NULL,
  `sampul_buku` varchar(60) NOT NULL,
  `judul_buku` varchar(60) NOT NULL,
  `pengarang_buku` varchar(30) NOT NULL,
  `macam_buku` varchar(10) NOT NULL,
  `bahasa_buku` varchar(10) NOT NULL,
  `no_penempatan` varchar(20) NOT NULL,
  `penerbit_buku` varchar(20) NOT NULL,
  `tahun_terbit_buku` year(4) NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data untuk tabel `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `kode_buku`, `isbn_buku`, `sampul_buku`, `judul_buku`, `pengarang_buku`, `macam_buku`, `bahasa_buku`, `no_penempatan`, `penerbit_buku`, `tahun_terbit_buku`) VALUES
(1, 'B0001', '979-230-79', 'sampul/5343480f8271297844220ed5b1bd99e5.jpg', 'pendidikan agama islam I', 'aminuddin, dkk', 'U', 'Indonesia', '299.77/AMI/P/C.1', 'ghalia indonesia', 2010),
(3, 'B0003', '987-090-10', 'sampul/93e0c0f0dd62dfddca0cac9fc0ecc7af.jpg', 'php dasar', 'rokhim, S.kom', 'U', 'Indonesia', '201/ROK/P/C.1', 'andi', 2011),
(4, 'B0004', '970-45-091', 'sampul/sampul_buku.jpg', 'aaaaa', 'bbbbb', 'U', 'Indonesia', '230/BBB/A/C.1', 'andi', 2010),
(5, 'B0005', '970-45-091', 'sampul/sampul_buku.jpg', 'aaaaa', 'bbbbb', 'U', 'Indonesia', '230/BBB/A/C.2', 'andi', 2010),
(6, 'B0006', '9870-189-192', 'sampul/3836871b580e64c7930aa2299d798319.jpg', 'bbbbbb', 'cccccccccccc', 'U', 'Indonesia', '800/CCC/B/C.1', 'ghalia', 2000),
(7, 'B0007', '9870-189-192', 'sampul/3836871b580e64c7930aa2299d798319.jpg', 'bbbbbb', 'cccccccccccc', 'U', 'Indonesia', '800/CCC/B/C.2', 'ghalia', 2000),
(8, 'B0008', '9870-189-192', 'sampul/3836871b580e64c7930aa2299d798319.jpg', 'bbbbbb', 'cccccccccccc', 'U', 'Indonesia', '800/CCC/B/C.3', 'ghalia', 2000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_denda`
--

CREATE TABLE IF NOT EXISTS `tbl_denda` (
  `kode_denda` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_peminjaman` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `denda` int(11) NOT NULL,
  PRIMARY KEY (`kode_denda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_peminjaman`
--

CREATE TABLE IF NOT EXISTS `tbl_detail_peminjaman` (
  `id_detail_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `banyak_perpanjang` int(11) NOT NULL,
  PRIMARY KEY (`id_detail_peminjaman`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data untuk tabel `tbl_detail_peminjaman`
--

INSERT INTO `tbl_detail_peminjaman` (`id_detail_peminjaman`, `id_anggota`, `id_petugas`, `id_buku`, `tgl_pinjam`, `tgl_kembali`, `tgl_pengembalian`, `banyak_perpanjang`) VALUES
(1, 1, 1, 1, '2014-12-29', '2015-01-05', '0000-00-00', 0),
(2, 1, 1, 3, '2014-12-29', '2015-01-05', '2014-12-29', 0),
(3, 1, 1, 4, '2014-12-29', '2015-01-05', '0000-00-00', 0),
(4, 3, 1, 1, '2014-12-29', '2015-01-05', '0000-00-00', 0),
(5, 4, 1, 3, '2014-12-29', '0000-00-00', '0000-00-00', 0),
(6, 4, 1, 4, '2014-12-29', '0000-00-00', '0000-00-00', 0),
(7, 4, 1, 5, '2014-12-29', '0000-00-00', '0000-00-00', 0),
(8, 3, 1, 7, '2014-12-29', '2015-01-05', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_file`
--

CREATE TABLE IF NOT EXISTS `tbl_file` (
  `kode_file` int(11) NOT NULL AUTO_INCREMENT,
  `sampul_file` varchar(60) NOT NULL,
  `nama_file` varchar(60) NOT NULL,
  `judul_file` varchar(30) NOT NULL,
  `pengarang_file` varchar(30) NOT NULL,
  `macam_file` varchar(10) NOT NULL,
  `bahasa_file` varchar(10) NOT NULL,
  `penerbit_file` varchar(20) NOT NULL,
  `tahun_terbit_file` year(4) NOT NULL,
  `ringkasan` text NOT NULL,
  `tgl_upload` date NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  PRIMARY KEY (`kode_file`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `tbl_file`
--

INSERT INTO `tbl_file` (`kode_file`, `sampul_file`, `nama_file`, `judul_file`, `pengarang_file`, `macam_file`, `bahasa_file`, `penerbit_file`, `tahun_terbit_file`, `ringkasan`, `tgl_upload`, `id_petugas`, `id_anggota`) VALUES
(1, 'sampul/9c85c789b8f34d938c9c9d0e13c10a25.jpg', 'berkas/a3b1f00c708d2832741fb327b829b62f.docx', 'Modul alpro II', 'badar said, S.Kom', 'U', 'Indonesia', '', 2011, 'alpro. . .', '2014-12-29', 1, 0),
(2, 'sampul/a3e4b88a4fdddef28e63220d0e92b250.jpg', 'berkas/d48f3e0e3183540beab64fe1aafb74e2.ppt', 'Konsep RPL', 'Sholeh Rachmatullah', 'U', 'Indonesia', '', 2013, 'konsep RPL. . .', '2014-12-29', 1, 0),
(3, 'sampul/631a49058180ef1a876d8c2b9a1ac636.jpg', 'berkas/684ea61db701b9442296a83dc7b75f1d.ppt', 'Metode RPL', 'Sholeh Rachmatullah', 'U', 'Indonesia', '', 2013, 'Metode RPL. . .', '2014-12-29', 1, 0),
(4, 'sampul/50e63754a821b504e14fb8c6dd5aae4a.jpg', 'berkas/a5bcd0e2136cbf6b40da0f99828a49d4.ppt', 'Proses Perancangan RPL', 'Sholeh Rachmatullah', 'U', 'Indonesia', '', 2013, 'Proses Perancangan RPL. . .', '2014-12-29', 1, 0),
(5, 'sampul/2ffcee84425cf3aa2970c94764748ca1.jpg', 'berkas/9606d887a49d465e4685a0370e227faf.ppt', 'ERD', 'Sholeh Rachmatullah', 'U', 'Indonesia', '', 2013, 'ERD adalah. . .', '2014-12-29', 1, 0),
(6, 'sampul/c65d8e384afe37af1653e814d361abbf.jpg', 'berkas/e62d212944c98a81ad01904a1a4d16f5.pdf', 'E-Commerce', 'Syahroni', 'U', 'Indonesia', '', 2012, 'E-commerce adalah. . .', '2014-12-29', 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengaturan`
--

CREATE TABLE IF NOT EXISTS `tbl_pengaturan` (
  `kode_pengaturan` int(11) NOT NULL AUTO_INCREMENT,
  `bayar_denda` int(11) NOT NULL,
  `jumlah_buku` int(11) NOT NULL,
  `lama_pinjam` int(11) NOT NULL,
  PRIMARY KEY (`kode_pengaturan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_pengaturan`
--

INSERT INTO `tbl_pengaturan` (`kode_pengaturan`, `bayar_denda`, `jumlah_buku`, `lama_pinjam`) VALUES
(1, 500, 3, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_petugas`
--

CREATE TABLE IF NOT EXISTS `tbl_petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(30) NOT NULL,
  `jeniskelamin_petugas` varchar(15) NOT NULL,
  `telp_petugas` varchar(15) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password_petugas` varchar(50) NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `tbl_petugas`
--

INSERT INTO `tbl_petugas` (`id_petugas`, `nama_petugas`, `jeniskelamin_petugas`, `telp_petugas`, `username`, `password_petugas`) VALUES
(1, 'fahirah', 'P', '081931635887', 'admin', '827ccb0eea8a706c4c34a16891f84e7b'),
(9, 'ipin', 'L', '0819346171', 'upin', '1098546859b56f5297205943b5a0469e');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_prodi`
--

CREATE TABLE IF NOT EXISTS `tbl_prodi` (
  `kode_prodi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`kode_prodi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tbl_prodi`
--

INSERT INTO `tbl_prodi` (`kode_prodi`, `nama_prodi`) VALUES
(1, 'Teknik Informatika'),
(2, 'Teknik Sipil');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
