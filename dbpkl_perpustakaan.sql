-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 03. Desember 2014 jam 15:43
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
  `kode_file` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `tgl_baca` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `password_anggota` varchar(15) NOT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nama_anggota`, `no_identitas`, `alamat_anggota`, `telp_anggota`, `jeniskelamin_anggota`, `status_anggota`, `kode_prodi`, `password_anggota`) VALUES
(2, 'iraa', '1155201855', 'bluto', '00000', 'P', 'm', 1, '1155201855'),
(3, 'nazir', '0909090', 'dirgahayu', '0000', 'L', 'd', 1, '0909090'),
(4, 'upin', '11552', 'bluto', '0000', 'L', 'm', 2, '11552'),
(6, 'arifin', '0909090', 'pmksn', '00000', 'P', 'm', 1, '0909090'),
(8, 'aliansyah', '1055201880', 'pamekasan', '081923222', 'L', 'm', 1, '1055201880'),
(9, 'hasbi', '201355201090', 'bugih', '08193245', 'L', 'm', 2, '201355201090');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_buku`
--

CREATE TABLE IF NOT EXISTS `tbl_buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(10) NOT NULL,
  `judul_buku` varchar(30) NOT NULL,
  `pengarang_buku` varchar(30) NOT NULL,
  `stok_buku` int(11) NOT NULL,
  `sisa_stok_buku` int(11) NOT NULL,
  `macam_buku` varchar(10) NOT NULL,
  `bahasa_buku` varchar(10) NOT NULL,
  `no_penempatan` varchar(10) NOT NULL,
  `penerbit_buku` varchar(20) NOT NULL,
  `tahun_terbit_buku` year(4) NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data untuk tabel `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `kode_buku`, `judul_buku`, `pengarang_buku`, `stok_buku`, `sisa_stok_buku`, `macam_buku`, `bahasa_buku`, `no_penempatan`, `penerbit_buku`, `tahun_terbit_buku`) VALUES
(1, 'B001', 'ayat-ayat cinta', 'fahirah', 10, 8, 'U', 'Indonesia', 'no 1', 'airlangga', 2010),
(2, 'B002', 'ketika cinta bertasbih', 'ipin', 10, 1, 'U', 'Indonesia', 'no 2', 'Yudistira', 2011),
(3, 'B003', 'php', 'andi', 10, 5, 'R', 'Indonesia', 'no 3', 'andi', 2010),
(4, 'B004', 'mysql dan php', 'upin', 5, 2, 'R', 'Inggris', 'no 4', 'andi', 2013),
(6, 'B005', 'teknologi informasi', 'internet saja', 2, 0, 'U', 'Indonesia', 'no 5', 'andi', 2010),
(7, 'B006', 'pemrograman visual', 'fahirah', 12, 10, 'R', 'Indonesia', 'no 6', 'yudistira', 2014),
(8, 'B007', 'cinta suci zahrana', 'afika', 5, 0, 'U', 'Indonesia', 'no 7', 'sinar dunia', 2010),
(9, 'B008', 'Netbeans', 'Nazir Arifin', 3, 0, 'U', 'Indonesia', 'no 8', 'airlangga', 2010),
(10, 'B009', 'tom n jerry', 'nazir', 2, 0, 'U', 'Indonesia', 'no 9', 'andi', 2010),
(11, 'B010', 'html dasar', 'iraa', 9, 0, 'U', 'Indonesia', 'iiiiiiii', 'andi', 2010),
(13, 'B012', 'css 3', 'ipin', 10, 0, 'U', '', '9ooooo', 'aaa', 0000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_peminjaman`
--

CREATE TABLE IF NOT EXISTS `tbl_detail_peminjaman` (
  `id_detail_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `kode_peminjaman` char(5) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `denda` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detail_peminjaman`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_detail_peminjaman`
--

INSERT INTO `tbl_detail_peminjaman` (`id_detail_peminjaman`, `kode_peminjaman`, `id_buku`, `tgl_pinjam`, `tgl_kembali`, `tgl_pengembalian`, `denda`) VALUES
(1, '1', 1, '2014-12-01', '2014-12-08', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_file`
--

CREATE TABLE IF NOT EXISTS `tbl_file` (
  `kode_file` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`kode_file`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `tbl_file`
--

INSERT INTO `tbl_file` (`kode_file`, `nama_file`, `judul_file`, `pengarang_file`, `macam_file`, `bahasa_file`, `penerbit_file`, `tahun_terbit_file`, `ringkasan`, `tgl_upload`, `id_petugas`) VALUES
(13, 'berkas/e9dd99093f80fbb0548dadb127b4ccf6.docx', 'php', 'upin', 'U', 'Indonesia', 'andi', 2010, 'abcdefghij', '2014-12-03', 1),
(14, 'berkas/a22ecacc4708fb7f01e52346074bcc11.docx', 'abcd', 'andi', 'U', 'Indonesia', 'andi', 2010, 'aaaaaaaaaaaaa', '2014-12-03', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_peminjaman_pengembalian`
--

CREATE TABLE IF NOT EXISTS `tbl_peminjaman_pengembalian` (
  `kode_peminjaman` char(5) NOT NULL,
  `id_anggota` char(5) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `status_peminjaman` char(10) DEFAULT NULL,
  PRIMARY KEY (`kode_peminjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_peminjaman_pengembalian`
--

INSERT INTO `tbl_peminjaman_pengembalian` (`kode_peminjaman`, `id_anggota`, `id_petugas`, `status_peminjaman`) VALUES
('1', '2', 1, 'pinjam');

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
  `password_petugas` varchar(15) NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tbl_petugas`
--

INSERT INTO `tbl_petugas` (`id_petugas`, `nama_petugas`, `jeniskelamin_petugas`, `telp_petugas`, `username`, `password_petugas`) VALUES
(1, 'ipin', 'Laki-Laki', '08190909091', 'admin', 'admin'),
(2, 'upin', 'Laki-Laki', '0819282982', 'upin', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_prodi`
--

CREATE TABLE IF NOT EXISTS `tbl_prodi` (
  `kode_prodi` int(11) NOT NULL,
  `nama_prodi` char(30) DEFAULT NULL,
  PRIMARY KEY (`kode_prodi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_prodi`
--

INSERT INTO `tbl_prodi` (`kode_prodi`, `nama_prodi`) VALUES
(1, 'Teknik Informatika'),
(2, 'Teknik Sipil');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
