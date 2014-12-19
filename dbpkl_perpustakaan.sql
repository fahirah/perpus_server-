-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 19. Desember 2014 jam 14:08
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tbl_aktivitas`
--

INSERT INTO `tbl_aktivitas` (`kode_aktivitas`, `id_anggota`, `kode_file`, `tgl_download`) VALUES
(1, 1, 2, '2014-12-01'),
(2, 2, 2, '2014-12-17');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nama_anggota`, `no_identitas`, `alamat_anggota`, `telp_anggota`, `jeniskelamin_anggota`, `status_anggota`, `kode_prodi`, `password_anggota`) VALUES
(1, 'dani', '1155201878', 'parteker', '0817508901', 'P', 'm', 1, '1155201878'),
(2, 'susi', '1155201854', 'palenga''an', '0817501245', 'P', 'm', 1, '1155201854'),
(3, 'iis', '1155201870', 'pasean', '081738391', 'P', 'm', 2, '1155201870'),
(4, 'nazir', '0011', 'bluto', '0879504948', 'L', 'd', 1, '0011');

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
  `stok_buku` int(11) NOT NULL,
  `sisa_stok_buku` int(11) NOT NULL,
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

INSERT INTO `tbl_buku` (`id_buku`, `kode_buku`, `isbn_buku`, `sampul_buku`, `judul_buku`, `pengarang_buku`, `stok_buku`, `sisa_stok_buku`, `macam_buku`, `bahasa_buku`, `no_penempatan`, `penerbit_buku`, `tahun_terbit_buku`) VALUES
(1, 'B001', '979-518-692-1', 'sampul/83631baa9ad7de2048ea52c2eae97de8.jpg', 'pendidikan agama islam I', 'amiruddin', 8, 6, 'U', 'Indonesia', '270/ami/p/', 'ghalia indonesia', 2002),
(2, 'B002', '979-518-661-1', 'sampul/a.jpg', 'basis data', 'janner simarmata', 10, 10, 'R', 'Indonesia', '270.70/sim/b/', 'andi', 2010),
(3, 'B003', '979-518-713-2', 'sampul/a.jpg', 'css3', 'burhanuddin salim', 5, 3, 'U', 'Indonesia', '260.1/bur/c', 'rineka cipta', 2010),
(4, 'B004', '12345', 'sampul/17a22b0f5adb0c70b7e50ed377ec8534.jpg', 'php dasar', 'imam', 8, 6, 'U', 'Indonesia', '230/ima/p', 'andi', 2011),
(7, 'B005', '970-09-20-1', 'sampul/sampul_buku.jpg', 'html 5', 'ipin', 5, 5, 'U', 'Indonesia', '290/ipi/h/', 'andi', 2011),
(8, 'B006', '789-08-801', 'sampul/sampul_buku.jpg', 'jQuery', 'muhammad', 5, 5, 'U', 'Indonesia', '701/muh/j/', 'andi', 2011);

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
  `kode_peminjaman` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `banyak_perpanjang` int(11) NOT NULL,
  PRIMARY KEY (`id_detail_peminjaman`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `tbl_detail_peminjaman`
--

INSERT INTO `tbl_detail_peminjaman` (`id_detail_peminjaman`, `kode_peminjaman`, `id_buku`, `tgl_pinjam`, `tgl_kembali`, `tgl_pengembalian`, `banyak_perpanjang`) VALUES
(1, 1, 1, '2014-12-17', '2014-12-31', '2014-12-18', 1),
(4, 2, 3, '2014-12-17', '2014-12-24', '0000-00-00', 0),
(7, 4, 3, '2014-12-17', '0000-00-00', '0000-00-00', 0),
(8, 5, 3, '2014-12-17', '0000-00-00', '2014-12-18', 0),
(9, 6, 1, '2014-12-17', '2014-12-24', '0000-00-00', 0),
(10, 7, 4, '2014-12-17', '2014-12-24', '0000-00-00', 0),
(11, 8, 4, '2014-12-17', '0000-00-00', '0000-00-00', 0),
(12, 9, 2, '2014-12-17', '2014-12-24', '0000-00-00', 0);

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
  `id_anggota` int(11) NOT NULL,
  PRIMARY KEY (`kode_file`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `tbl_file`
--

INSERT INTO `tbl_file` (`kode_file`, `nama_file`, `judul_file`, `pengarang_file`, `macam_file`, `bahasa_file`, `penerbit_file`, `tahun_terbit_file`, `ringkasan`, `tgl_upload`, `id_petugas`, `id_anggota`) VALUES
(2, 'berkas/07dbd3204b3a92738ad2c53f6f4b7892.docx', 'modul 1 algoritma pemrograman', 'badar said, s.kom', 'R', 'Indonesia', '', 2010, 'algoritma pemrograman. . .', '2014-12-16', 1, 0),
(3, 'berkas/a0da8852d53a2fa13f8c396237e5bd11.docx', 'rekayasa perangkat lunak', 'eka nurhayati, S.kom', 'U', 'Indonesia', '', 2011, 'rpl adalah. . .', '2014-12-16', 1, 0),
(4, 'berkas/fecc302417161ad316f8b274306cedf7.xlsx', 'modul simulasi', 'erwin prasetyowati', 'U', 'Indonesia', '', 2011, 'model simulasi. . .', '2014-12-19', 1, 0),
(5, 'berkas/f88794eedf3b2855e8fbf07d11662e0e.docx', 'jaringan saraf tiruan', 'anang hermansyah', 'R', 'Inggris', '', 2010, 'jst adalah. . .', '2014-12-19', 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_peminjaman_pengembalian`
--

CREATE TABLE IF NOT EXISTS `tbl_peminjaman_pengembalian` (
  `kode_peminjaman` int(11) NOT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `status_peminjaman` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`kode_peminjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_peminjaman_pengembalian`
--

INSERT INTO `tbl_peminjaman_pengembalian` (`kode_peminjaman`, `id_anggota`, `id_petugas`, `status_peminjaman`) VALUES
(1, 1, 1, 'kembali'),
(2, 2, 1, 'pinjam'),
(4, 4, 1, 'pinjam'),
(5, 4, 1, 'kembali'),
(6, 3, 1, 'pinjam'),
(7, 1, 1, 'pinjam'),
(8, 4, 1, 'pinjam'),
(9, 2, 1, 'pinjam');

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
  `password_petugas` varchar(15) NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tbl_petugas`
--

INSERT INTO `tbl_petugas` (`id_petugas`, `nama_petugas`, `jeniskelamin_petugas`, `telp_petugas`, `username`, `password_petugas`) VALUES
(1, 'fahirah', 'Perempuan', '081931635887', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_prodi`
--

CREATE TABLE IF NOT EXISTS `tbl_prodi` (
  `kode_prodi` int(11) NOT NULL,
  `nama_prodi` varchar(30) DEFAULT NULL,
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
