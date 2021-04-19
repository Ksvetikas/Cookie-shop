-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2021 at 12:22 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parduotuve`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_userid`
--

CREATE TABLE `cart_userid` (
  `uzsakymai_id` int(11) DEFAULT NULL,
  `prekes_id` int(11) DEFAULT NULL,
  `kiekis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prekes`
--

CREATE TABLE `prekes` (
  `prekes_id` int(11) NOT NULL,
  `pavadinimas` varchar(100) NOT NULL,
  `paskirtis` varchar(100) NOT NULL,
  `ypatybe` varchar(100) DEFAULT NULL,
  `kiekis` int(11) NOT NULL,
  `kaina` decimal(65,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prekes`
--

INSERT INTO `prekes` (`prekes_id`, `pavadinimas`, `paskirtis`, `ypatybe`, `kiekis`, `kaina`) VALUES
(1, 'palapine', 'laisvalaikio', NULL, 20, '45.00'),
(2, 'krepsinio_kamuolys', 'laisvalaikio', NULL, 20, '18.55'),
(3, 'atsuktuvas', 'statybine', NULL, 20, '3.50'),
(4, 'sriegiklis', 'statybine', NULL, 15, '16.30'),
(5, 'bandele_su_avietemis', 'maisto', 'sviezia', 15, '0.38'),
(6, 'saliamio_desra', 'maisto', 'sviezia', 16, '9.84'),
(7, 'koldunai', 'maisto', 'saldyta', 16, '2.84'),
(8, 'darzoves', 'maisto', 'saldyta', 30, '2.34');

-- --------------------------------------------------------

--
-- Table structure for table `uzsakymai`
--

CREATE TABLE `uzsakymai` (
  `uzsakymo_id` int(11) NOT NULL,
  `vartotojai_id` varchar(60) DEFAULT NULL,
  `uzsakymo_data` date DEFAULT NULL,
  `uzsakymo_suma` decimal(65,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uzsakymo_prekes`
--

CREATE TABLE `uzsakymo_prekes` (
  `uzsakymai_id` int(11) DEFAULT NULL,
  `prekes_id` int(11) DEFAULT NULL,
  `kiekis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vartotojai`
--

CREATE TABLE `vartotojai` (
  `vartotojo_id` varchar(60) NOT NULL,
  `vardas` varchar(60) NOT NULL,
  `pavarde` varchar(60) NOT NULL,
  `slaptazodis` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vartotojai`
--

INSERT INTO `vartotojai` (`vartotojo_id`, `vardas`, `pavarde`, `slaptazodis`) VALUES
('adolfukas12', 'Adolfas', 'Smuklevicius', 'adolfukas12'),
('jonmil', 'Jonas', 'Milijonas', 'Jonmil12'),
('vartotojelis', 'Liudas', 'Inkaras', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `vertinimas`
--

CREATE TABLE `vertinimas` (
  `eil_nr` int(11) NOT NULL,
  `vartotojo_id` varchar(60) DEFAULT NULL,
  `vertinimo_vidurkis` decimal(3,2) DEFAULT NULL,
  `vertinimo_data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_userid`
--
ALTER TABLE `cart_userid`
  ADD KEY `prekes_id` (`prekes_id`),
  ADD KEY `uzsakymai_id` (`uzsakymai_id`);

--
-- Indexes for table `prekes`
--
ALTER TABLE `prekes`
  ADD PRIMARY KEY (`prekes_id`);

--
-- Indexes for table `uzsakymai`
--
ALTER TABLE `uzsakymai`
  ADD PRIMARY KEY (`uzsakymo_id`),
  ADD KEY `vartotojai_id` (`vartotojai_id`);

--
-- Indexes for table `uzsakymo_prekes`
--
ALTER TABLE `uzsakymo_prekes`
  ADD KEY `uzsakymai_id` (`uzsakymai_id`),
  ADD KEY `prekes_id` (`prekes_id`);

--
-- Indexes for table `vartotojai`
--
ALTER TABLE `vartotojai`
  ADD PRIMARY KEY (`vartotojo_id`);

--
-- Indexes for table `vertinimas`
--
ALTER TABLE `vertinimas`
  ADD PRIMARY KEY (`eil_nr`),
  ADD KEY `vartotojo_id` (`vartotojo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prekes`
--
ALTER TABLE `prekes`
  MODIFY `prekes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uzsakymai`
--
ALTER TABLE `uzsakymai`
  MODIFY `uzsakymo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `vertinimas`
--
ALTER TABLE `vertinimas`
  MODIFY `eil_nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_userid`
--
ALTER TABLE `cart_userid`
  ADD CONSTRAINT `cart_userid_ibfk_1` FOREIGN KEY (`prekes_id`) REFERENCES `prekes` (`prekes_id`),
  ADD CONSTRAINT `cart_userid_ibfk_2` FOREIGN KEY (`uzsakymai_id`) REFERENCES `uzsakymai` (`uzsakymo_id`);

--
-- Constraints for table `uzsakymai`
--
ALTER TABLE `uzsakymai`
  ADD CONSTRAINT `uzsakymai_ibfk_1` FOREIGN KEY (`vartotojai_id`) REFERENCES `vartotojai` (`vartotojo_id`);

--
-- Constraints for table `uzsakymo_prekes`
--
ALTER TABLE `uzsakymo_prekes`
  ADD CONSTRAINT `uzsakymo_prekes_ibfk_1` FOREIGN KEY (`uzsakymai_id`) REFERENCES `uzsakymai` (`uzsakymo_id`),
  ADD CONSTRAINT `uzsakymo_prekes_ibfk_2` FOREIGN KEY (`prekes_id`) REFERENCES `prekes` (`prekes_id`);

--
-- Constraints for table `vertinimas`
--
ALTER TABLE `vertinimas`
  ADD CONSTRAINT `vertinimas_ibfk_1` FOREIGN KEY (`vartotojo_id`) REFERENCES `vartotojai` (`vartotojo_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
