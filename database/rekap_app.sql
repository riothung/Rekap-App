-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 04:35 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekap_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `kecamatan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `kecamatan`) VALUES
(4, 'Amfoangs'),
(5, 'Amabi Oefetoa');

-- --------------------------------------------------------

--
-- Table structure for table `pemilih`
--

CREATE TABLE `pemilih` (
  `id` int(11) NOT NULL,
  `no_kk` varchar(200) NOT NULL,
  `nik` varchar(200) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `tempat_lahir` varchar(200) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(200) NOT NULL,
  `pekerjaan` varchar(200) NOT NULL,
  `status_perkawinan` varchar(200) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `kelurahan` varchar(200) NOT NULL,
  `kecamatan` varchar(200) NOT NULL,
  `kota` varchar(200) NOT NULL,
  `status_pemilih` varchar(200) NOT NULL,
  `tanggal_pindah_memilih` date NOT NULL,
  `tps_asal` int(200) NOT NULL,
  `tps_tujuan_pindah` int(200) NOT NULL,
  `alasan` varchar(200) NOT NULL,
  `id_kecamatan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemilih`
--

INSERT INTO `pemilih` (`id`, `no_kk`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `pekerjaan`, `status_perkawinan`, `alamat`, `kelurahan`, `kecamatan`, `kota`, `status_pemilih`, `tanggal_pindah_memilih`, `tps_asal`, `tps_tujuan_pindah`, `alasan`, `id_kecamatan`) VALUES
(1, '7698798797', '9879879879', 'Testing', 'Kupang', '1965-12-05', 'Perempuan', 'TNI', 'Belum Menikah', 'Jln Semangka', 'Kayu Putih', '4', 'Soe', 'Khusus', '0000-00-00', 3, 0, '', ''),
(5, '686897632487346', '87687686876', 'Stevanus Vinus', 'Kupang', '1997-11-29', 'Laki-Laki', 'PNS', 'Menikah', 'Jln Manga', 'Kayu Putih', '4', 'Kupang', 'Pindah Domisili', '0000-00-00', 3, 2, '', ''),
(6, '324759834797', '9798709798798', 'Silvia Saliv', 'Sabu', '2023-12-06', 'Perempuan', 'TNI', 'Belum Menikah', 'Jln Nanas', 'Kayu Putih', '4', 'Atambua', 'Pindah Karena Sakit', '2023-12-12', 2, 3, 'Hamil', ''),
(7, '76876986786', '768689687', 'Serverus Snape', 'Hutan', '1787-12-06', 'Laki-Laki', 'PNS', 'Menikah', 'Jln Sedang', 'Kayu Putih', '4', 'Soe', 'Khusus', '0000-00-00', 2, 0, '', ''),
(8, '45647357547', '5474574734', 'Naibila Nibala', 'Jakarta', '1999-12-21', 'Perempuan', 'PNS', 'Belum Menikah', 'Jln Sedang', 'Kayu Manis', '5', 'Atambua', 'Khusus', '0000-00-00', 0, 0, '', ''),
(9, '24534534534', '53453453453', 'AGUS SAGU', 'Jakarta', '2023-12-08', 'Laki-Laki', 'PNS', 'Belum Menikah', 'Jln Semangka', 'Kayu Putih', '5', 'Soe', 'Pindah Tugas', '2023-12-01', 3, 3, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tps`
--

CREATE TABLE `tps` (
  `id` int(11) NOT NULL,
  `no_tps` varchar(200) NOT NULL,
  `kelurahan` varchar(200) NOT NULL,
  `kecamatan` int(11) NOT NULL,
  `kota` varchar(200) NOT NULL,
  `provinsi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tps`
--

INSERT INTO `tps` (`id`, `no_tps`, `kelurahan`, `kecamatan`, `kota`, `provinsi`) VALUES
(2, '20', 'Kayu Putih', 4, 'Kupang', 'Nusa Tenggara Timur'),
(3, '31', 'Fatululi', 5, 'Kupang', 'Nusa Tenggara Timur');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `jabatan` varchar(200) NOT NULL,
  `administrator` tinyint(1) NOT NULL,
  `no_hp` varchar(200) NOT NULL,
  `kota` varchar(200) NOT NULL,
  `provinsi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `email`, `jabatan`, `administrator`, `no_hp`, `kota`, `provinsi`) VALUES
(1, 'Rio', 'admin', 'admin', 'rio@gmail.com', '', 1, '', '', ''),
(3, 'Pengawas 1', 'user', 'user', 'pengawass@email.com', '', 0, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemilih`
--
ALTER TABLE `pemilih`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tps`
--
ALTER TABLE `tps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pemilih`
--
ALTER TABLE `pemilih`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tps`
--
ALTER TABLE `tps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
