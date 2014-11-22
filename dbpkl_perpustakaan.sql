-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 18. Nopember 2014 jam 05:48
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
-- Struktur dari tabel `tbl_anggota`
--

CREATE TABLE IF NOT EXISTS `tbl_anggota` (
  `id_anggota` varchar(5) NOT NULL,
  `nama_anggota` varchar(30) NOT NULL,
  `no_identitas` varchar(15) NOT NULL,
  `password_anggota` varchar(15) NOT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nama_anggota`, `no_identitas`, `password_anggota`) VALUES
('A001', 'ira', '1155201855', '123');

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
  `macam_buku` varchar(10) NOT NULL,
  `bahasa_buku` varchar(10) NOT NULL,
  `no_penempatan` varchar(10) NOT NULL,
  `penerbit_buku` varchar(20) NOT NULL,
  `tahun_terbit_buku` year(4) NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `kode_buku`, `judul_buku`, `pengarang_buku`, `stok_buku`, `macam_buku`, `bahasa_buku`, `no_penempatan`, `penerbit_buku`, `tahun_terbit_buku`) VALUES
(1, 'B001', 'ayat-ayat cinta', 'fahirah', 10, 'Umum', 'Indonesia', 'no 1', 'airlangga', 2010);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_file`
--

CREATE TABLE IF NOT EXISTS `tbl_file` (
  `kode_file` varchar(5) NOT NULL,
  `nama_file` varchar(30) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_file`
--

INSERT INTO `tbl_file` (`kode_file`, `nama_file`, `judul_file`, `pengarang_file`, `macam_file`, `bahasa_file`, `penerbit_file`, `tahun_terbit_file`, `ringkasan`, `tgl_upload`, `id_petugas`) VALUES
('F001', 'web.docx', 'Modul 1 Pemrograman Web', 'Nazir Arifin', 'Regional', 'Inggris', 'nyaroan', 2014, 'web adalah. . .', '2014-11-15', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_petugas`
--

INSERT INTO `tbl_petugas` (`id_petugas`, `nama_petugas`, `jeniskelamin_petugas`, `telp_petugas`, `username`, `password_petugas`) VALUES
(1, 'ipin', 'Laki-Laki', '08190909091', 'admin', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
