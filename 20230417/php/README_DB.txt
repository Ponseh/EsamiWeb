Istruzioni per creare il database e la tabella

Andare in phpmyAdmin e andare nella voce di menu a tab "SQL".

1. Creare il DB

CREATE DATABASE db_esami;

2. Andare nel database appena creato e usate le seguenti istruzioni per creare e popolare la tabella 

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esami`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `harrypotter`
--

CREATE TABLE `harrypotter` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `species` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `house` varchar(50) NOT NULL,
  `dateOfBirth` varchar(10) NOT NULL,
  `yearOfBirth` int(11) NOT NULL,
  `ancestry` varchar(50) NOT NULL,
  `eyeColour` varchar(50) NOT NULL,
  `hairColour` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `harrypotter`
--

INSERT INTO `harrypotter` (`id`, `name`, `species`, `gender`, `house`, `dateOfBirth`, `yearOfBirth`, `ancestry`, `eyeColour`, `hairColour`) VALUES
(1, 'Harry Potter', 'human', 'male', 'Gryffindor', '31-07-1980', 1980, 'half-blood', 'green', 'black');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `harrypotter`
--
ALTER TABLE `harrypotter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `harrypotter`
--
ALTER TABLE `harrypotter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
