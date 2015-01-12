-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 12. Januari 2015 jam 16:08
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
(1, 1, 7, '2014-12-30');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nama_anggota`, `no_identitas`, `alamat_anggota`, `telp_anggota`, `jeniskelamin_anggota`, `status_anggota`, `kode_prodi`, `password_anggota`) VALUES
(1, 'fahirah', '1155201855', 'dirgahayu', '081931635887', 'P', 'm', 1, '4d529b7205620948f7b1cdfb2b47464d'),
(2, 'susi', '1155201854', 'palenga''an', '08785089010', 'P', 'm', 1, '220ee574c0b0075ac195b3b052abefe4'),
(3, 'ayu', '20125520101', 'pamekasan', '0879504930', 'L', 'm', 1, 'ab8bb22c2665a9c9cd82bcdd1f47a18c');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `kode_buku`, `isbn_buku`, `sampul_buku`, `judul_buku`, `pengarang_buku`, `macam_buku`, `bahasa_buku`, `no_penempatan`, `penerbit_buku`, `tahun_terbit_buku`) VALUES
(1, 'B0001', '979-763-309-7', 'sampul/424a965da2cdd805f5febd76c589e16b.jpg', 'Pascal', 'Hadi', 'U', 'Indonesia', '005.1/HAD/P/C.1', 'graha ilmu', 2000),
(2, 'B0002', '979-700-801-8', 'sampul/fe0ed310ae65453fec51b3f9a4e9cbc7.jpg', 'php', 'sutopo', 'U', 'Indonesia', '005.3/SUT/P/C.1', 'andi', 2013),
(3, 'B0003', '979-087-700-1', 'sampul/b0c31c86915ae970ec89b35b75019d66.jpg', 'HTML 5 Programming', 'Muhammad', 'U', 'Indonesia', '005.5/MUH/H/C.1', 'ghalia indonesia', 2012),
(4, 'B0004', '9000000000000', 'sampul/sampul_buku.jpg', 'html', 'ipin', 'U', '', '009/IPI/H/C.1', 'andi', 2010),
(5, 'B0005', '9000000000000', 'sampul/sampul_buku.jpg', 'html', 'ipin', 'U', '', '009/IPI/H/C.2', 'andi', 2010);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_denda`
--

CREATE TABLE IF NOT EXISTS `tbl_denda` (
  `kode_denda` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_peminjaman` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `denda` int(11) NOT NULL,
  PRIMARY KEY (`kode_denda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `tbl_denda`
--

INSERT INTO `tbl_denda` (`kode_denda`, `id_detail_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_bayar`, `denda`) VALUES
(1, 1, '2014-12-24', '2014-12-30', '2014-12-31', 500),
(2, 2, '2014-12-24', '2014-12-30', '2015-01-01', 1000),
(3, 3, '2014-12-24', '2014-12-30', '2015-01-01', 1000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `tbl_detail_peminjaman`
--

INSERT INTO `tbl_detail_peminjaman` (`id_detail_peminjaman`, `id_anggota`, `id_petugas`, `id_buku`, `tgl_pinjam`, `tgl_kembali`, `tgl_pengembalian`, `banyak_perpanjang`) VALUES
(1, 1, 1, 1, '2014-12-24', '2014-12-30', '2014-12-31', 0),
(2, 1, 1, 3, '2014-12-24', '2014-12-30', '2015-01-01', 0),
(3, 1, 1, 1, '2014-12-24', '2014-12-31', '0000-00-00', 1),
(4, 1, 1, 2, '2014-12-25', '2015-01-01', '0000-00-00', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `tbl_file`
--

INSERT INTO `tbl_file` (`kode_file`, `sampul_file`, `nama_file`, `judul_file`, `pengarang_file`, `macam_file`, `bahasa_file`, `penerbit_file`, `tahun_terbit_file`, `ringkasan`, `tgl_upload`, `id_petugas`, `id_anggota`) VALUES
(6, 'sampul/c65d8e384afe37af1653e814d361abbf.jpg', 'berkas/e62d212944c98a81ad01904a1a4d16f5.pdf', 'E-Commerce', 'Syahroni, S.Kom', 'U', 'Indonesia', '', 2012, 'E-commerce adalah. . .', '2014-12-29', 1, 0),
(7, 'sampul/sampul_file.jpg', 'berkas/3697551a221e3a1c588e8b3724e8f87b.xlsx', 'model simulasi', 'erwin prasetyowati, ST', 'R', 'Indonesia', '', 2011, 'model  simulasi. . .', '2014-12-30', 1, 0),
(8, 'sampul/cf22c1d1587ba504af57cf8ee5124316.jpg', 'berkas/9df6f7e30e7d1f836f283a30d5728195.docx', 'pdm', 'muhammad', 'U', 'Indonesia', '', 2011, 'pdm adalah', '2014-12-30', 1, 0),
(9, 'sampul/e2865b0e9f817071c4096fa2d80c3734.png', 'berkas/4f147bbdc64b7f47910fdbc964ae71aa.pdf', 'Domain dan Hosting', 'Ninda', 'U', 'Indonesia', '', 2013, 'domian adalah. . .', '2015-01-01', 1, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `tbl_petugas`
--

INSERT INTO `tbl_petugas` (`id_petugas`, `nama_petugas`, `jeniskelamin_petugas`, `telp_petugas`, `username`, `password_petugas`) VALUES
(1, 'sofi', 'P', '0878509010', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(10, 'sugik', 'L', '087685050', 'sugik', '1432cb2ac95751dce43c94c304dbbd3d');

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
