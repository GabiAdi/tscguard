-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2025 at 07:08 PM
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
-- Database: `tscguard`
--

-- --------------------------------------------------------

--
-- Table structure for table `tg_kategorija`
--

CREATE TABLE `tg_kategorija` (
  `ID` int(11) NOT NULL,
  `kategorijaID` int(11) NOT NULL,
  `pitanjeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_kategorije`
--

CREATE TABLE `tg_kategorije` (
  `ID` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_korisnik`
--

CREATE TABLE `tg_korisnik` (
  `ID` int(11) NOT NULL,
  `kime` varchar(20) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razinaID` int(11) NOT NULL,
  `aktivan` tinyint(1) NOT NULL DEFAULT 1,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_odgovori`
--

CREATE TABLE `tg_odgovori` (
  `ID` int(11) NOT NULL,
  `tekst` varchar(1023) NOT NULL,
  `pitanjeID` int(11) NOT NULL,
  `tocno` tinyint(1) NOT NULL,
  `opisNetocnog` varchar(1023) NOT NULL,
  `autorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_pitanje`
--

CREATE TABLE `tg_pitanje` (
  `ID` int(11) NOT NULL,
  `tekstPitanje` varchar(1023) NOT NULL,
  `korisnikID` int(11) NOT NULL,
  `brojBodova` int(11) NOT NULL,
  `hint` varchar(1023) NOT NULL,
  `brojPonudenih` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_pitanjenatestu`
--

CREATE TABLE `tg_pitanjenatestu` (
  `ID` int(11) NOT NULL,
  `tekstID` int(11) NOT NULL,
  `pitanjeID` int(11) NOT NULL,
  `odgovorID` int(11) NOT NULL,
  `odabarano` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_prava`
--

CREATE TABLE `tg_prava` (
  `ID` int(11) NOT NULL,
  `pravoID` int(11) NOT NULL,
  `korisnikID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_pravo`
--

CREATE TABLE `tg_pravo` (
  `ID` int(11) NOT NULL,
  `opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_razine`
--

CREATE TABLE `tg_razine` (
  `ID` int(11) NOT NULL,
  `opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tg_tekst`
--

CREATE TABLE `tg_tekst` (
  `ID` int(11) NOT NULL,
  `korisnikID` int(11) NOT NULL,
  `vrijemePocetka` timestamp NOT NULL DEFAULT current_timestamp(),
  `vremenskoOgranicenje` timestamp NOT NULL DEFAULT current_timestamp(),
  `vrijemeKraja` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tg_kategorija`
--
ALTER TABLE `tg_kategorija`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `kategorijaID` (`kategorijaID`),
  ADD KEY `pitanjeID` (`pitanjeID`);

--
-- Indexes for table `tg_kategorije`
--
ALTER TABLE `tg_kategorije`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_korisnik`
--
ALTER TABLE `tg_korisnik`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `razinaID` (`razinaID`);

--
-- Indexes for table `tg_odgovori`
--
ALTER TABLE `tg_odgovori`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `pitanjeID` (`pitanjeID`) USING BTREE,
  ADD KEY `autorID` (`autorID`);

--
-- Indexes for table `tg_pitanje`
--
ALTER TABLE `tg_pitanje`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `korisnikID` (`korisnikID`);

--
-- Indexes for table `tg_pitanjenatestu`
--
ALTER TABLE `tg_pitanjenatestu`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `tekstID` (`tekstID`),
  ADD KEY `pitanjeID` (`pitanjeID`),
  ADD KEY `odgovorID` (`odgovorID`);

--
-- Indexes for table `tg_prava`
--
ALTER TABLE `tg_prava`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `pravoID` (`pravoID`),
  ADD KEY `korisnikID` (`korisnikID`);

--
-- Indexes for table `tg_pravo`
--
ALTER TABLE `tg_pravo`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_razine`
--
ALTER TABLE `tg_razine`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_tekst`
--
ALTER TABLE `tg_tekst`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `korisnikID` (`korisnikID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tg_kategorija`
--
ALTER TABLE `tg_kategorija`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_kategorije`
--
ALTER TABLE `tg_kategorije`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_korisnik`
--
ALTER TABLE `tg_korisnik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_odgovori`
--
ALTER TABLE `tg_odgovori`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_pitanje`
--
ALTER TABLE `tg_pitanje`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_pitanjenatestu`
--
ALTER TABLE `tg_pitanjenatestu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_prava`
--
ALTER TABLE `tg_prava`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_pravo`
--
ALTER TABLE `tg_pravo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_razine`
--
ALTER TABLE `tg_razine`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tg_tekst`
--
ALTER TABLE `tg_tekst`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tg_kategorija`
--
ALTER TABLE `tg_kategorija`
  ADD CONSTRAINT `tg_kategorija_ibfk_1` FOREIGN KEY (`kategorijaID`) REFERENCES `tg_kategorije` (`ID`),
  ADD CONSTRAINT `tg_kategorija_ibfk_2` FOREIGN KEY (`pitanjeID`) REFERENCES `tg_pitanje` (`ID`);

--
-- Constraints for table `tg_korisnik`
--
ALTER TABLE `tg_korisnik`
  ADD CONSTRAINT `tg_korisnik_ibfk_1` FOREIGN KEY (`razinaID`) REFERENCES `tg_razine` (`ID`);

--
-- Constraints for table `tg_odgovori`
--
ALTER TABLE `tg_odgovori`
  ADD CONSTRAINT `tg_odgovori_ibfk_1` FOREIGN KEY (`pitanjeID`) REFERENCES `tg_pitanje` (`ID`),
  ADD CONSTRAINT `tg_odgovori_ibfk_2` FOREIGN KEY (`autorID`) REFERENCES `tg_korisnik` (`ID`);

--
-- Constraints for table `tg_pitanje`
--
ALTER TABLE `tg_pitanje`
  ADD CONSTRAINT `tg_pitanje_ibfk_1` FOREIGN KEY (`korisnikID`) REFERENCES `tg_korisnik` (`ID`);

--
-- Constraints for table `tg_pitanjenatestu`
--
ALTER TABLE `tg_pitanjenatestu`
  ADD CONSTRAINT `tg_pitanjenatestu_ibfk_1` FOREIGN KEY (`pitanjeID`) REFERENCES `tg_pitanje` (`ID`),
  ADD CONSTRAINT `tg_pitanjenatestu_ibfk_2` FOREIGN KEY (`tekstID`) REFERENCES `tg_tekst` (`ID`),
  ADD CONSTRAINT `tg_pitanjenatestu_ibfk_3` FOREIGN KEY (`odgovorID`) REFERENCES `tg_odgovori` (`ID`);

--
-- Constraints for table `tg_prava`
--
ALTER TABLE `tg_prava`
  ADD CONSTRAINT `tg_prava_ibfk_1` FOREIGN KEY (`korisnikID`) REFERENCES `tg_korisnik` (`ID`),
  ADD CONSTRAINT `tg_prava_ibfk_2` FOREIGN KEY (`pravoID`) REFERENCES `tg_pravo` (`ID`);

--
-- Constraints for table `tg_tekst`
--
ALTER TABLE `tg_tekst`
  ADD CONSTRAINT `tg_tekst_ibfk_1` FOREIGN KEY (`korisnikID`) REFERENCES `tg_korisnik` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
