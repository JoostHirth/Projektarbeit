-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 14. Apr 2024 um 15:42
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `quiz`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ergebnisse`
--

CREATE TABLE `ergebnisse` (
  `ergebnis_id` int(11) NOT NULL,
  `benutzer_id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_id` int(11) NOT NULL,
  `antwort_zeit` timestamp NOT NULL DEFAULT current_timestamp(),
  `beantwortete_fragen` int(11) DEFAULT 0,
  `richtig_beantwortete_fragen` int(11) DEFAULT 0,
  `korrekt` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `ergebnisse`
--

INSERT INTO `ergebnisse` (`ergebnis_id`, `benutzer_id`, `frage_id`, `antwort_id`, `antwort_zeit`, `beantwortete_fragen`, `richtig_beantwortete_fragen`, `korrekt`) VALUES
(1, 1, 1, 3, '2024-04-03 15:00:54', 2, 1, 1),
(2, 1, 1, 3, '2024-04-03 15:00:59', 2, 1, 1),
(3, 1, 1, 1, '2024-04-03 15:01:43', 2, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_antwort`
--

CREATE TABLE `quiz_antwort` (
  `antwort_id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_text` varchar(255) NOT NULL,
  `korrekt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_antwort`
--

INSERT INTO `quiz_antwort` (`antwort_id`, `frage_id`, `antwort_text`, `korrekt`) VALUES
(1, 1, 'Berlin', 0),
(2, 1, 'London', 0),
(3, 1, 'Paris', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_antworten1`
--

CREATE TABLE `quiz_antworten1` (
  `antwort_id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_text` varchar(255) NOT NULL,
  `korrekt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_frage`
--

CREATE TABLE `quiz_frage` (
  `frage_id` int(11) NOT NULL,
  `frage_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_frage`
--

INSERT INTO `quiz_frage` (`frage_id`, `frage_text`) VALUES
(1, 'Was ist die Hauptstadt von Frankreich?');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_fragen1`
--

CREATE TABLE `quiz_fragen1` (
  `frage_id` int(11) NOT NULL,
  `frage_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userdaten`
--

CREATE TABLE `userdaten` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwort` varchar(100) NOT NULL,
  `gesamt_punkte` int(11) NOT NULL DEFAULT 0,
  `richtig_beantwortet` int(11) NOT NULL DEFAULT 0,
  `gesamt_fragen` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `userdaten`
--

INSERT INTO `userdaten` (`ID`, `username`, `passwort`, `gesamt_punkte`, `richtig_beantwortet`, `gesamt_fragen`) VALUES
(1, 'ghjkl', '$2y$10$Y4A5fcdLb2c9hbYyygX7guZCs21pKx2/XspCxjj0hmlxVKrif2HKe', 3927, 1, 2),
(3, 'qwer', '$2y$10$ZLsoa98D6lFNo/0Htv.cL.SsPr9tyCApU2naZcifcdu1wGHtWHWZe', 7924, 8, 10);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ergebnisse`
--
ALTER TABLE `ergebnisse`
  ADD PRIMARY KEY (`ergebnis_id`),
  ADD KEY `benutzer_id` (`benutzer_id`),
  ADD KEY `frage_id` (`frage_id`),
  ADD KEY `antwort_id` (`antwort_id`);

--
-- Indizes für die Tabelle `quiz_antwort`
--
ALTER TABLE `quiz_antwort`
  ADD PRIMARY KEY (`antwort_id`),
  ADD KEY `frage_id` (`frage_id`);

--
-- Indizes für die Tabelle `quiz_frage`
--
ALTER TABLE `quiz_frage`
  ADD PRIMARY KEY (`frage_id`);

--
-- Indizes für die Tabelle `userdaten`
--
ALTER TABLE `userdaten`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ergebnisse`
--
ALTER TABLE `ergebnisse`
  MODIFY `ergebnis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `quiz_antwort`
--
ALTER TABLE `quiz_antwort`
  MODIFY `antwort_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `quiz_frage`
--
ALTER TABLE `quiz_frage`
  MODIFY `frage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `userdaten`
--
ALTER TABLE `userdaten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ergebnisse`
--
ALTER TABLE `ergebnisse`
  ADD CONSTRAINT `ergebnisse_ibfk_1` FOREIGN KEY (`benutzer_id`) REFERENCES `userdaten` (`ID`),
  ADD CONSTRAINT `ergebnisse_ibfk_2` FOREIGN KEY (`frage_id`) REFERENCES `quiz_frage` (`frage_id`),
  ADD CONSTRAINT `ergebnisse_ibfk_3` FOREIGN KEY (`antwort_id`) REFERENCES `quiz_antwort` (`antwort_id`);

--
-- Constraints der Tabelle `quiz_antwort`
--
ALTER TABLE `quiz_antwort`
  ADD CONSTRAINT `quiz_antwort_ibfk_1` FOREIGN KEY (`frage_id`) REFERENCES `quiz_frage` (`frage_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
