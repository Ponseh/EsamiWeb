-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 17, 2025 alle 12:38
-- Versione del server: 10.4.22-MariaDB
-- Versione PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_libreria`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE `libro` (
  `id` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `autore` varchar(255) NOT NULL,
  `isbn` char(13) NOT NULL,
  `data_pubblicazione` date NOT NULL,
  `genere` enum('Romanzo','Saggio','Manuale','Altro') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `libro`
--

INSERT INTO `libro` (`id`, `titolo`, `autore`, `isbn`, `data_pubblicazione`, `genere`) VALUES
(1, 'Il nome della rosa', 'Umberto Eco', '9788806134735', '1980-10-01', 'Romanzo'),
(2, 'La divina commedia', 'Dante Alighieri', '9788807900025', '1320-01-01', 'Romanzo'),
(3, 'Sapiens: Da animali a dèi', 'Yuval Noah Harari', '9780062316097', '2011-01-01', 'Saggio'),
(4, 'Manuale di diritto privato', 'Andrea Torrente', '9788828807862', '2017-03-01', 'Manuale'),
(5, 'Il piccolo principe', 'Antoine de Saint-Exupéry', '9780156012195', '1943-04-06', 'Romanzo'),
(6, 'Filosofia per tutti', 'Roger Scruton', '9788817016927', '2007-09-01', 'Saggio'),
(7, 'Programmazione in C', 'Brian W. Kernighan', '9780131103627', '1988-04-01', 'Manuale'),
(8, 'Enciclopedia universale', 'Autori Vari', '9788800000000', '2000-01-01', 'Altro');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
