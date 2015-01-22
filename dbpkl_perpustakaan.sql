-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 22. Januari 2015 jam 23:43
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `tbl_aktivitas`
--

INSERT INTO `tbl_aktivitas` (`kode_aktivitas`, `id_anggota`, `kode_file`, `tgl_download`) VALUES
(1, 2, 1, '2015-01-15'),
(2, 2, 3, '2015-01-15'),
(3, 2, 3, '2015-01-15'),
(4, 2, 3, '2015-01-15');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `kode_prodi`, `nama_anggota`, `no_identitas`, `alamat_anggota`, `telp_anggota`, `jeniskelamin_anggota`, `status_anggota`, `password_anggota`) VALUES
(1, 1, 'fahirah', '1155201855', 'Dirgahayu', '081931635887', 'P', 'm', '4d529b7205620948f7b1cdfb2b47464d'),
(2, 1, 'Muhammad', '07001', 'sumenep', '0878906520', 'L', 'd', 'a785de81f6d70e10f0c8fccc466afd3c'),
(3, 2, 'Dani', '1155201878', 'Parteker', '0876840481', 'P', 'm', '98b827ef43e156e04c262e24a86dfbee'),
(4, 2, 'Susi', '1155201854', 'Palenga''an', '0878503210', 'P', 'm', '220ee574c0b0075ac195b3b052abefe4'),
(5, 1, 'Nilam Ramadhani, S.Kom, M.Kom', '07002', 'Pamekasan', '0816430980', 'L', 'd', '0d8f46159d977540cc20b5fe7cf8ed01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_buku`
--

CREATE TABLE IF NOT EXISTS `tbl_buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `isbn_buku` varchar(30) DEFAULT NULL,
  `sampul_buku` varchar(60) DEFAULT NULL,
  `judul_buku` varchar(100) DEFAULT NULL,
  `pengarang_buku` varchar(60) DEFAULT NULL,
  `macam_buku` varchar(10) DEFAULT NULL,
  `bahasa_buku` varchar(10) DEFAULT NULL,
  `no_inventaris` varchar(20) NOT NULL,
  `no_penempatan` varchar(20) DEFAULT NULL,
  `kota_terbit_buku` varchar(30) NOT NULL,
  `penerbit_buku` varchar(20) DEFAULT NULL,
  `tahun_terbit_buku` varchar(4) DEFAULT NULL,
  `ringkasan_buku` text NOT NULL,
  `status_buku` varchar(20) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `tanggal_input` date NOT NULL,
  `id_devisi` int(11) NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data untuk tabel `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `isbn_buku`, `sampul_buku`, `judul_buku`, `pengarang_buku`, `macam_buku`, `bahasa_buku`, `no_inventaris`, `no_penempatan`, `kota_terbit_buku`, `penerbit_buku`, `tahun_terbit_buku`, `ringkasan_buku`, `status_buku`, `id_petugas`, `tanggal_input`, `id_devisi`) VALUES
(1, '979-80-7070-1', 'sampul/263f782b395519aedbb93d89f13cfc00.jpg', 'Digital Image Processing', 'Rafael Gonzaalez', 'R', 'Inggris', '1/PF/PB', '004/GON/D/C.1', 'USA', 'Copyright', '1993', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(2, '970-091-11-01', 'sampul/263f782b395519aedbb93d89f13cfc00.jpg', 'PHP', 'Sterling Hughes', 'U', 'Inggris', '2/PF/PB', '001.6/HUG/P/C.1', 'USA', 'Copyright', '2001', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(3, '978-080-190-1', 'sampul/db0b1c33c2588a896b0c2b4d11bea65b.jpg', 'Management Information Systems', 'James Brien', 'U', 'Inggris', '3/PF/PB', '650/BRI/M/C.1', 'USA', 'Copyright', '1994', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(4, '987-101-208-19', 'sampul/6bb2ffbea7d4d768210523fd9aca1dc6.jpg', 'Strategi Peningkatan Kualitas Pendidikan Tinggi I', 'M. Zainuddin', 'U', 'Indonesia', '4/PF/PB', '370.1/ZAI/S/C.1', 'Jakarta', 'PPAI-UT', '2001', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(5, '870-290-190-1', 'sampul/7ca056b31982c7c5ff10a26961a69f92.jpg', 'Aplikasi Logika Fuzzy', 'Sri Kusmadewi', 'U', 'Indonesia', '5/PF/PB', '005/KUS/A/C.1', 'Yogyakarta', 'Graha Ilmu', '2010', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(6, '870-60-1112', 'sampul/sampul_buku.jpg', 'Simulasi Teori dan Aplikasinya', 'Bonett Satya Lelonoo Ojati', 'U', 'Indonesia', '6/PF/PB', '003.3/OJA/S/C.1', 'Yogyakarta', 'Andi', '2007', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(7, '980-709-123-9', 'sampul/sampul_buku.jpg', 'Best Tools Hacking & Recovery', 'Jaja Jamaluddin Malik', 'U', 'Indonesia', '7/PF/PB', '001/MAL/B/C.1', 'Yogyakarta', 'andi', '2009', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(8, '890-1090-190-1', 'sampul/a32602fe6008a6dc66c6d9f67c7d8009.jpg', 'Pemrograman Flash', 'Amiruddin, ST', 'U', 'Indonesia', '8/PF/PB', '001/AMI/P/C.1', '', 'Graha Komputer', '2011', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(9, '890-1090-190-1', 'sampul/a32602fe6008a6dc66c6d9f67c7d8009.jpg', 'Pemrograman Flash', 'Amiruddin, ST', 'U', 'Indonesia', '9/PF/PB', '001/AMI/P/C.2', '', 'Graha Komputer', '2011', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(10, '870-70-109-1', 'sampul/ab1ed30a04396ca4fbde241d1ae5970c.jpg', 'HTML5 Programming', 'Muhammad, S,Kom', 'U', 'Indonesia', '10/PF/PB', '001.2/MUH/H/C.1', '', 'andi', '2011', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(11, '890-190-001-1', 'sampul/sampul_buku.jpg', 'Beton', 'Ir. Drajad Suryo', 'U', 'Indonesia', '11/PF/PB', '364-1/SUR/B/C.1', 'Surabaya', 'Gramedia', '2000', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(12, '9780-0919-1', 'sampul/98ba5f7d4e1ea0493f6a9f793a7a8ecc.jpg', 'php dasar', 'ipin', 'R', 'Indonesia', '12/PF/PB', '971/IPI/P/C.1', 'jakarta', 'andi', '2010', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(13, '978-90-1-111', 'sampul/2e416dd4df2fa240d1a4e4e485409e67.jpg', 'Bahasa Pascal', 'Andi Oktaviana', 'U', 'Indonesia', '13/PF/PB', '001.1/OKT/B/C.1', 'Solo', 'Yudistira', '2000', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(14, '980-19-909', 'sampul/sampul_buku.jpg', 'Rekayasa Perangkat Lunak', 'Muhammad', 'U', 'Indonesia', '14/PF/PB', '800/MUH/R/C.1', 'Yogyakarta', 'Andi', '2000', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(15, '980-19-909', 'sampul/sampul_buku.jpg', 'Rekayasa Perangkat Lunak', 'Muhammad', 'U', 'Indonesia', '15/PF/PB', '800/MUH/R/C.2', 'Yogyakarta', 'andi', '2000', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(16, '980-19-909', 'sampul/sampul_buku.jpg', 'Rekayasa Perangkat Lunak', 'Muhammad', 'U', 'Indonesia', '16/PF/PB', '800/MUH/R/C.3', 'Yogyakarta', 'Andi', '2000', 'abcdefghijklmn', 'L', 1, '2015-01-15', 3),
(17, '879-080-1901-1', 'sampul/sampul_buku.jpg', 'Etika Profesi', 'Nafisah, S.Kom', 'U', 'Indonesia', '17/PF/PB', '305/NAF/E/C.0', 'Pamekasan', 'Yudistira', '2011', 'etika profesi adalah. . .', 'L', 1, '2015-01-15', 3),
(18, '89793-91029', 'sampul/sampul_buku.jpg', 'css3', 'ira', 'U', 'Indonesia', '18/PF/PB', '001/IRA/C/C.1', 'pmk', 'andi', '2000', 'hhhhhhhhh', 'L', 1, '2015-01-15', 3),
(19, '12345', 'sampul/sampul_buku.jpg', 'jaringan komputer', 'muhammad', 'U', 'Indonesia', '19/PF/PB', '001/MUH/J/C.1', 'pmk', 'andi', '2010', 'bbbbbbbbbbb', 'L', 1, '2015-01-15', 3),
(20, '9879-193-193', 'sampul/sampul_buku.jpg', 'animasi dengan flash mx', 'hadi sutopo, ST', 'U', 'Indonesia', '20/PF/PB', '003/SUT/A/C.1', 'surabaya', 'graha ilmu', '2010', 'aaaaaaaaaa', 'L', 1, '2015-01-15', 3),
(21, '9879-193-193', 'sampul/sampul_buku.jpg', 'animasi dengan flash mx', 'hadi sutopo, ST', 'U', 'Indonesia', '21/PF/PB', '003/SUT/A/C.2', 'surabaya', 'graha ilmu', '2010', 'aaaaaaaaaa', 'L', 1, '2015-01-15', 3),
(22, '870-129-1901-1', 'sampul/9b406284578084e240ea6f008b264c1e.jpg', 'pemrograman web', 'Hariesto, S.Kom', 'U', 'Indonesia', '22/PF/PB', '007/HAR/P/C.1', 'solo', 'airlangga', '2010', 'abcdefghijklm. . .', 'L', 1, '2015-01-15', 3),
(23, '9879-193-193', 'sampul/sampul_buku.jpg', 'animasi dengan flash mx', 'hadi sutopo, ST', 'U', 'Indonesia', '23/PF/PB', '003/SUT/A/C.3', 'surabaya', 'graha ilmu', '2010', 'aaaaaaaaaa', 'L', 1, '2015-01-15', 3),
(24, '9879-193-193', 'sampul/sampul_buku.jpg', 'animasi dengan flash mx', 'hadi sutopo, ST', 'U', 'Indonesia', '24/PF/PB', '003/SUT/A/C.4', 'surabaya', 'graha ilmu', '2010', 'aaaaaaaaaa', 'L', 1, '2015-01-15', 3),
(25, '9879-193-193', 'sampul/sampul_buku.jpg', 'animasi dengan flash mx', 'hadi sutopo, ST', 'U', 'Indonesia', '25/PF/PB', '003/SUT/A/C.5', 'surabaya', 'graha ilmu', '2010', 'aaaaaaaaaa', 'L', 1, '2015-01-15', 3),
(27, '870-1-1', 'sampul/sampul_buku.jpg', 'multimedia', 'abdullah, S.Kom', 'U', 'Indonesia', '27/PF/PB', '002/ABD/M/C.1', 'solo', 'ghalia ilmu', '2011', 'multimedia. . .', 'L', 1, '2015-01-15', 3),
(28, '890-1901-1901', 'sampul/sampul_buku.jpg', 'Hukum Indonesia', 'Lia Rahmawati', 'U', 'Inggris', '28/PF/PB', '101/RAH/H/C.1', 'Solo', 'Ghalia', '2010', 'hukum adalah. . .', 'L', 1, '2015-01-15', 2),
(29, '900-00-1', 'sampul/sampul_buku.jpg', 'beton', 'hazin', 'U', 'Indonesia', '29/PF/PB', '009/HAZ/B/C.1', 'solo', 'andi', '2000', 'beton adalah', 'L', 1, '2015-01-15', 3),
(30, '8800', 'sampul/sampul_buku.jpg', 'Komputer Masyarakat', 'Sholeh Rachmatullah, S.Kom', 'U', 'Indonesia', '30/PF/PB', '001/RAC/K/C.0', 'pamekasan', 'andi', '2011', 'komas adalah, ,,', 'L', 1, '2015-01-15', 3),
(31, '90000', 'sampul/sampul_buku.jpg', 'Model Antrian', 'Shela', 'U', 'Indonesia', '31/PF/PB', '002/SHE/M/C.1', 'solo', 'andi', '2000', 'antrian adalah. . .', 'L', 1, '2015-01-15', 3),
(32, '900-10-101-13', 'sampul/99e68eed2c77f3bd583d5a510248b7ae.jpg', 'Tutorial PHP dan Ajax', 'Liza Nurika Rahman', 'U', 'Indonesia', '32/PF/PB', '001/RAH/T/C.1', 'Yogyakarta', 'Andi', '2013', 'PHP adalah. . .', 'L', 1, '2015-01-15', 1),
(33, '900-10-101-13', 'sampul/99e68eed2c77f3bd583d5a510248b7ae.jpg', 'Tutorial PHP dan Ajax', 'Liza Nurika Rahman', 'U', 'Indonesia', '33/PF/PB', '001/RAH/T/C.2', 'Yogyakarta', 'Andi', '2013', 'PHP adalah. . .', 'L', 1, '2015-01-15', 1),
(34, '08010-1819-1', 'sampul/fcc4f9a513c4692a49bacff41d1e0c8f.jpg', 'Pengantar Teknologi Informasi', 'Ahmad', 'U', 'Indonesia', '34/PF/PB', '002/AHM/P/C.0', 'Solo', 'Andi', '2010', 'PTI adalah. . .', 'L', 1, '2015-01-22', 3),
(35, '900-10-101-13', 'sampul/cbcd2d00e1caafb1e288e88455d63496.jpg', 'Tutorial PHP dan Ajax', 'Liza Nurika Rahman', 'U', 'Indonesia', '35/PF/PB', '001/RAH/T/C.3', 'Yogyakarta', 'Andi', '2013', 'PHP adalah. . .', 'L', 1, '2015-01-23', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_denda`
--

CREATE TABLE IF NOT EXISTS `tbl_denda` (
  `kode_denda` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_peminjaman` int(11) DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `denda` int(11) DEFAULT NULL,
  PRIMARY KEY (`kode_denda`),
  KEY `FK_TERLAMBAT` (`id_detail_peminjaman`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `tbl_denda`
--

INSERT INTO `tbl_denda` (`kode_denda`, `id_detail_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_bayar`, `denda`) VALUES
(1, 1, '2015-01-06', '2015-01-13', '2015-01-15', 1000),
(2, 5, '2015-01-07', '2015-01-14', '2015-01-15', 500),
(3, 7, '2015-01-07', '2015-01-14', '2015-01-15', 500),
(4, 14, '2015-01-16', '2015-01-23', '2015-01-26', 1500);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data untuk tabel `tbl_detail_peminjaman`
--

INSERT INTO `tbl_detail_peminjaman` (`id_detail_peminjaman`, `id_buku`, `id_petugas`, `id_anggota`, `tgl_pinjam`, `tgl_kembali`, `tgl_pengembalian`, `banyak_perpanjangan`) VALUES
(1, 1, 1, 1, '2015-01-06', '2015-01-13', '2015-01-15', 0),
(4, 2, 1, 2, '2015-01-06', '2015-01-13', '2015-01-15', 0),
(5, 3, 1, 3, '2015-01-07', '2015-01-14', '2015-01-15', 0),
(7, 5, 1, 1, '2015-01-07', '2015-01-14', '2015-01-15', 0),
(8, 5, 1, 1, '2015-01-15', '2015-01-22', '0000-00-00', 0),
(9, 6, 1, 1, '2015-01-15', '2015-01-22', '0000-00-00', 0),
(10, 1, 1, 1, '2015-01-15', '2015-01-22', '0000-00-00', 0),
(11, 7, 1, 2, '2015-01-15', '0000-00-00', '0000-00-00', 0),
(12, 8, 1, 3, '2015-01-07', '2015-01-14', '0000-00-00', 0),
(13, 2, 1, 2, '2015-01-16', '0000-00-00', '0000-00-00', 0),
(14, 9, 1, 3, '2015-01-16', '2015-01-23', '2015-01-26', 0),
(15, 25, 1, 2, '2015-01-18', '0000-00-00', '2015-01-19', 0),
(16, 27, 1, 2, '2015-01-19', '0000-00-00', '2015-01-21', 0),
(17, 27, 1, 2, '2015-01-21', '0000-00-00', '2015-01-21', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_devisi_ddc`
--

CREATE TABLE IF NOT EXISTS `tbl_devisi_ddc` (
  `id_devisi` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelasutama` int(11) NOT NULL,
  `kode_devisi` varchar(10) NOT NULL,
  `keterangan_devisi` varchar(100) NOT NULL,
  PRIMARY KEY (`id_devisi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `tbl_devisi_ddc`
--

INSERT INTO `tbl_devisi_ddc` (`id_devisi`, `id_kelasutama`, `kode_devisi`, `keterangan_devisi`) VALUES
(1, 1, '001', 'ilmu teknik'),
(2, 10, '101', 'Filsafat Hukum'),
(3, 1, '002', 'ilmu komputer'),
(6, 10, '102', 'Filsafat Hukum Islam');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `tbl_file`
--

INSERT INTO `tbl_file` (`kode_file`, `id_anggota`, `id_petugas`, `sampul_file`, `nama_file`, `judul_file`, `pengarang_file`, `ringkasan`, `tgl_upload`, `macam_file`, `bahasa_file`, `penerbit_file`, `tahun_terbit_file`) VALUES
(1, NULL, 1, 'sampul/b75c9066e7aae2a7fcd918890cadcb53.jpg', 'c453c83e46693a59a77d3725d8f6ecc4.docx', 'Modul Alpro II', 'Novi Rinawati, S.Kom', 'Modul Aplro II berisi materi tentang array dua dimensi dan array tiga dimensi. . .', '2015-01-15', 'U', 'Indonesia', '', '2010'),
(2, NULL, 1, 'sampul/ed86364cf943d6b874168ca2794e9b58.jpg', 'berkas/16e99e0b539dfd2a771903e448354f6e.pptx', 'E-Commerce', 'Nindi, S.Kom', 'Materi E-Commerce. . .', '2015-01-15', 'U', 'Indonesia', '', '2010'),
(3, NULL, 1, 'sampul/6941c893dc6a7e0b95866b900047d403.jpg', 'berkas/f214ab815d80b05f71dbaac76648ea3e.docx', 'Model Simulasi', 'Erwin Prasetyowati, ST', 'Model simulasi. . .', '2015-01-15', 'U', 'Indonesia', '', '2013'),
(5, 2, NULL, 'sampul/f6fcbbd57b3110012d00e74ec4cefcfc.jpg', 'berkas/be9470a4617070be77c82ff83a58aa06.pdf', 'sistem operasi', 'Abul Bahrie, S.Kom', 'sistem operasi', '2015-01-15', 'U', 'Indonesia', '', '2011'),
(6, NULL, 1, 'sampul/a62af9d12b34c2ddd6d07f235b74b9b4.jpg', 'berkas/7225a039c35373ea74bbf99bd0de93de.ppt', 'Materi 1 Komputer Masyarakat', 'Sholeh Rachmatullah, S.Kom', 'Materi 1 Komputer Masyarakat. . .', '2015-01-15', 'U', 'Indonesia', '', '2012');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kelasutama_ddc`
--

CREATE TABLE IF NOT EXISTS `tbl_kelasutama_ddc` (
  `id_kelasutama` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kelasutama` varchar(10) NOT NULL,
  `keterangan_kelasutama` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kelasutama`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `tbl_kelasutama_ddc`
--

INSERT INTO `tbl_kelasutama_ddc` (`id_kelasutama`, `kode_kelasutama`, `keterangan_kelasutama`) VALUES
(1, '000', 'Karya Umum'),
(10, '100', 'Filsafat');

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
(1, 'shofiah', 'P', '08785090871', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
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
