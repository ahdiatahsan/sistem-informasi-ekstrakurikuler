-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2021 at 12:24 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ekstrakurikuler`
--

-- --------------------------------------------------------

--
-- Table structure for table `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pembimbing` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `hari` varchar(100) NOT NULL,
  `jam` time NOT NULL,
  `deskripsi` text NOT NULL,
  `path_artwork` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `tpt_lahir` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `kelas` varchar(5) DEFAULT NULL,
  `jurusan_id` int(5) DEFAULT NULL,
  `no_hp` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` enum('superadmin','admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nis`, `nama`, `tpt_lahir`, `tgl_lahir`, `alamat`, `kelas`, `jurusan_id`, `no_hp`, `username`, `password`, `level`) VALUES
(1, NULL, 'Superadmin', NULL, NULL, NULL, NULL, NULL, '085212341234', 'superadmin', '4297f44b13955235245b2497399d7a93', 'superadmin'),
(2, NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, '0852123123', 'admin', '4297f44b13955235245b2497399d7a93', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_ekstrakurikuler`
--

CREATE TABLE `user_ekstrakurikuler` (
  `id` int(11) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_ekstra` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indexes for table `user_ekstrakurikuler`
--
ALTER TABLE `user_ekstrakurikuler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ekstra` (`id_ekstra`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_ekstrakurikuler`
--
ALTER TABLE `user_ekstrakurikuler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `user_ekstrakurikuler`
--
ALTER TABLE `user_ekstrakurikuler`
  ADD CONSTRAINT `user_ekstrakurikuler_ibfk_1` FOREIGN KEY (`id_ekstra`) REFERENCES `ekstrakurikuler` (`id`),
  ADD CONSTRAINT `user_ekstrakurikuler_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
