-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 04:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antriyuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_user`
--

CREATE TABLE `data_user` (
  `id` int(11) NOT NULL,
  `no_antri` int(11) NOT NULL,
  `no_stnk` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `keperluan` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `waktu_antrian` datetime NOT NULL,
  `sisa_waktu` varchar(255) NOT NULL,
  `nomor` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_user`
--

INSERT INTO `data_user` (`id`, `no_antri`, `no_stnk`, `nama`, `keperluan`, `tanggal`, `waktu_antrian`, `sisa_waktu`, `nomor`) VALUES
(134, 1, '1234123412341234', 'fairus', 'Buat SIM', '2023-12-28 20:59:00', '2023-12-28 21:29:00', 'timeout', '085327919191'),
(136, 2, '1234123412341234', '+62 812-7088-4178', 'Buat SIM', '2023-12-28 21:13:00', '2023-12-28 21:59:00', 'timeout', '1234'),
(138, 3, '1234123412341234', 'fairus', 'Perpanjang STNK', '2023-12-28 22:09:00', '2023-12-28 22:27:00', '00:20:00', '085327919191');

--
-- Triggers `data_user`
--
DELIMITER $$
CREATE TRIGGER `tambah_waktu_antrian` BEFORE INSERT ON `data_user` FOR EACH ROW BEGIN
    DECLARE last_waktu_antrian DATETIME;

    -- Ambil waktu_antrian dari data_user terakhir dengan tanggal yang sama
    SELECT MAX(waktu_antrian) INTO last_waktu_antrian
    FROM antriyuk.data_user
    WHERE DATE(tanggal) = DATE(NEW.tanggal);

    IF last_waktu_antrian IS NULL THEN
        -- Jika tidak ada record sebelumnya, gunakan tanggal langsung
        SET NEW.waktu_antrian = NEW.tanggal + INTERVAL 30 MINUTE;
    ELSE
        -- Jika tanggal sama dan jam input lebih besar dari jam terakhir, tambahkan 30 menit
        IF NEW.tanggal > last_waktu_antrian THEN
            SET NEW.waktu_antrian = NEW.tanggal + INTERVAL 30 MINUTE;
        ELSE
            SET NEW.waktu_antrian = last_waktu_antrian + INTERVAL 30 MINUTE;
        END IF;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
