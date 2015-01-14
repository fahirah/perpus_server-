-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 14. Januari 2015 jam 06:43
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
  `id_anggota` int(11) DEFAULT NULL,
  `kode_file` int(11) DEFAULT NULL,
  `tgl_download` date DEFAULT NULL,
  PRIMARY KEY (`kode_aktivitas`),
  KEY `FK_DIBACA` (`kode_file`),
  KEY `FK_MEMBACA` (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_aktivitas`
--

INSERT INTO `tbl_aktivitas` (`kode_aktivitas`, `id_anggota`, `kode_file`, `tgl_download`) VALUES
(1, 2, 27, '2015-01-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_anggota`
--

CREATE TABLE IF NOT EXISTS `tbl_anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `kode_prodi` int(11) DEFAULT NULL,
  `nama_anggota` varchar(30) DEFAULT NULL,
  `no_identitas` varchar(15) DEFAULT NULL,
  `alamat_anggota` varchar(30) DEFAULT NULL,
  `telp_anggota` varchar(15) DEFAULT NULL,
  `jeniskelamin_anggota` varchar(15) DEFAULT NULL,
  `status_anggota` varchar(10) DEFAULT NULL,
  `password_anggota` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `FK_MEMPUNYAI` (`kode_prodi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `kode_prodi`, `nama_anggota`, `no_identitas`, `alamat_anggota`, `telp_anggota`, `jeniskelamin_anggota`, `status_anggota`, `password_anggota`) VALUES
(1, 1, 'fahirah', '1155201855', 'dirgahayu', '081931635887', 'P', 'm', '4d529b7205620948f7b1cdfb2b47464d'),
(2, 1, 'Muhammad', '07001', 'sumenep', '087890651', 'L', 'd', 'a785de81f6d70e10f0c8fccc466afd3c');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_buku`
--

CREATE TABLE IF NOT EXISTS `tbl_buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(20) DEFAULT NULL,
  `isbn_buku` varchar(30) DEFAULT NULL,
  `sampul_buku` varchar(60) DEFAULT NULL,
  `judul_buku` varchar(60) DEFAULT NULL,
  `pengarang_buku` varchar(30) DEFAULT NULL,
  `macam_buku` varchar(10) DEFAULT NULL,
  `bahasa_buku` varchar(10) DEFAULT NULL,
  `no_penempatan` varchar(20) DEFAULT NULL,
  `penerbit_buku` varchar(20) DEFAULT NULL,
  `tahun_terbit_buku` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `kode_buku`, `isbn_buku`, `sampul_buku`, `judul_buku`, `pengarang_buku`, `macam_buku`, `bahasa_buku`, `no_penempatan`, `penerbit_buku`, `tahun_terbit_buku`) VALUES
(1, 'B0001', '979-80-7070-1', 'sampul/263f782b395519aedbb93d89f13cfc00.jpg', 'css 3', 'andi', 'R', 'Indonesia', '001/AND/C/C.1', 'andi', '2010'),
(2, 'B0002', '970-091-11-01', 'sampul/263f782b395519aedbb93d89f13cfc00.jpg', 'HTML 5', 'Amiruddin, S.Kom', 'U', 'Indonesia', '001/AMI/H/C.1', 'Andi', '2010');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_denda`
--

CREATE TABLE IF NOT EXISTS `tbl_denda` (
  `kode_denda` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_peminjaman` int(11) DEFAULT NULL,
  `denda` int(11) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  PRIMARY KEY (`kode_denda`),
  KEY `FK_TERLAMBAT` (`id_detail_peminjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_peminjaman`
--

CREATE TABLE IF NOT EXISTS `tbl_detail_peminjaman` (
  `id_detail_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_buku` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `banyak_perpanjangan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detail_peminjaman`),
  KEY `FK_ADA` (`id_buku`),
  KEY `FK_MEMINJAM` (`id_anggota`),
  KEY `FK_MENANGANI` (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_detail_peminjaman`
--

INSERT INTO `tbl_detail_peminjaman` (`id_detail_peminjaman`, `id_buku`, `id_petugas`, `id_anggota`, `tgl_pinjam`, `tgl_kembali`, `tgl_pengembalian`, `banyak_perpanjangan`) VALUES
(1, 1, 1, 1, '2015-01-13', '2015-01-20', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_file`
--

CREATE TABLE IF NOT EXISTS `tbl_file` (
  `kode_file` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `sampul_file` varchar(60) DEFAULT NULL,
  `nama_file` varchar(60) DEFAULT NULL,
  `judul_file` varchar(30) DEFAULT NULL,
  `pengarang_file` varchar(30) DEFAULT NULL,
  `ringkasan` text,
  `tgl_upload` date DEFAULT NULL,
  `macam_file` varchar(10) DEFAULT NULL,
  `bahasa_file` varchar(10) DEFAULT NULL,
  `penerbit_file` varchar(20) DEFAULT NULL,
  `tahun_terbit_file` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`kode_file`),
  KEY `FK_MENGELOLA` (`id_petugas`),
  KEY `FK_MENGUPLOAD` (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data untuk tabel `tbl_file`
--

INSERT INTO `tbl_file` (`kode_file`, `id_anggota`, `id_petugas`, `sampul_file`, `nama_file`, `judul_file`, `pengarang_file`, `ringkasan`, `tgl_upload`, `macam_file`, `bahasa_file`, `penerbit_file`, `tahun_terbit_file`) VALUES
(27, NULL, 1, 'sampul/263f782b395519aedbb93d89f13cfc00.jpg', 'berkas/b93a6c06d45646b5a5fe41f35b3be829.docx', 'Modul Alpro II', 'Novi', 'array. . .', '2015-01-13', 'R', 'Indonesia', '', '2011'),
(28, 2, NULL, 'sampul/sampul_file.jpg', 'berkas/b6b3eccb0e658323d9e131433dd2c85c.docx', 'simbada', 'Abul bahri', 'simbada. . .', '2015-01-13', 'R', 'Indonesia', '', '2010');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengaturan`
--

CREATE TABLE IF NOT EXISTS `tbl_pengaturan` (
  `kode_pengaturan` int(11) NOT NULL AUTO_INCREMENT,
  `bayar_denda` int(11) DEFAULT NULL,
  `jumlah_buku` int(11) DEFAULT NULL,
  `lama_pinjam` int(11) DEFAULT NULL,
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
  `nama_petugas` varchar(30) DEFAULT NULL,
  `jeniskelamin_petugas` varchar(15) DEFAULT NULL,
  `telp_petugas` varchar(15) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password_petugas` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tbl_petugas`
--

INSERT INTO `tbl_petugas` (`id_petugas`, `nama_petugas`, `jeniskelamin_petugas`, `telp_petugas`, `username`, `password_petugas`) VALUES
(1, 'shofiah', 'P', '08785090870', 'admin', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'sugik', 'L', '0879908808', 'sugik', '1432cb2ac95751dce43c94c304dbbd3d');

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

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_aktivitas`
--
ALTER TABLE `tbl_aktivitas`
  ADD CONSTRAINT `FK_DIBACA` FOREIGN KEY (`kode_file`) REFERENCES `tbl_file` (`kode_file`),
  ADD CONSTRAINT `FK_MEMBACA` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id_anggota`);

--
-- Ketidakleluasaan untuk tabel `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD CONSTRAINT `FK_MEMPUNYAI` FOREIGN KEY (`kode_prodi`) REFERENCES `tbl_prodi` (`kode_prodi`);

--
-- Ketidakleluasaan untuk tabel `tbl_denda`
--
ALTER TABLE `tbl_denda`
  ADD CONSTRAINT `FK_TERLAMBAT` FOREIGN KEY (`id_detail_peminjaman`) REFERENCES `tbl_detail_peminjaman` (`id_detail_peminjaman`);

--
-- Ketidakleluasaan untuk tabel `tbl_detail_peminjaman`
--
ALTER TABLE `tbl_detail_peminjaman`
  ADD CONSTRAINT `FK_ADA` FOREIGN KEY (`id_buku`) REFERENCES `tbl_buku` (`id_buku`),
  ADD CONSTRAINT `FK_MEMINJAM` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id_anggota`),
  ADD CONSTRAINT `FK_MENANGANI` FOREIGN KEY (`id_petugas`) REFERENCES `tbl_petugas` (`id_petugas`);

--
-- Ketidakleluasaan untuk tabel `tbl_file`
--
ALTER TABLE `tbl_file`
  ADD CONSTRAINT `FK_MENGELOLA` FOREIGN KEY (`id_petugas`) REFERENCES `tbl_petugas` (`id_petugas`),
  ADD CONSTRAINT `FK_MENGUPLOAD` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id_anggota`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
