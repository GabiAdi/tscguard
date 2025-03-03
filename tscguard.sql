-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 12:54 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tg_kategorije`
--

CREATE TABLE `tg_kategorije` (
  `ID` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tg_korisnik`
--

CREATE TABLE `tg_korisnik` (
  `ID` int(11) NOT NULL,
  `kime` varchar(20) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razinaID` int(11) NOT NULL,
  `aktivan` tinyint(1) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tg_prava`
--

CREATE TABLE `tg_prava` (
  `ID` int(11) NOT NULL,
  `pravoID` int(11) NOT NULL,
  `korisnikID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tg_pravo`
--

CREATE TABLE `tg_pravo` (
  `ID` int(11) NOT NULL,
  `opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tg_razine`
--

CREATE TABLE `tg_razine` (
  `ID` int(11) NOT NULL,
  `opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tg_kategorija`
--
ALTER TABLE `tg_kategorija`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_kategorije`
--
ALTER TABLE `tg_kategorije`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_korisnik`
--
ALTER TABLE `tg_korisnik`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_odgovori`
--
ALTER TABLE `tg_odgovori`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_pitanje`
--
ALTER TABLE `tg_pitanje`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_pitanjenatestu`
--
ALTER TABLE `tg_pitanjenatestu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tg_prava`
--
ALTER TABLE `tg_prava`
  ADD PRIMARY KEY (`ID`);

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
  ADD PRIMARY KEY (`ID`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
