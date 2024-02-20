-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Feb 2024 um 18:15
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
  `benutzername` varchar(50) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_id` int(11) NOT NULL,
  `korrekt` tinyint(1) NOT NULL,
  `antwort_zeit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_antwort`
--

CREATE TABLE `quiz_antwort` (
  `antwort_id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_antwort`
--

INSERT INTO `quiz_antwort` (`antwort_id`, `frage_id`, `antwort_text`) VALUES
(1, 1, 'Ja'),
(2, 1, 'Nein');

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
(1, 'Ist die Erde rund?');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userdaten`
--

CREATE TABLE `userdaten` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwort` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `userdaten`
--

INSERT INTO `userdaten` (`ID`, `username`, `passwort`) VALUES
(10, 'asdf', '$2y$10$nK/9aXSetRS6xEurC/kBseD/V5mFHe4G1wIQoL9FMgPR/gwgwCmw2');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ergebnisse`
--
ALTER TABLE `ergebnisse`
  ADD PRIMARY KEY (`ergebnis_id`),
  ADD KEY `benutzername` (`benutzername`),
  ADD KEY `frage_id` (`frage_id`),
  ADD KEY `antwort_id` (`antwort_id`);

--
-- Indizes für die Tabelle `quiz_antwort`
--
ALTER TABLE `quiz_antwort`
  ADD PRIMARY KEY (`antwort_id`),
  ADD KEY `frage_id` (`frage_id`),
  ADD KEY `idx_antwort_id` (`antwort_id`);

--
-- Indizes für die Tabelle `quiz_frage`
--
ALTER TABLE `quiz_frage`
  ADD PRIMARY KEY (`frage_id`),
  ADD KEY `idx_frage_id` (`frage_id`);

--
-- Indizes für die Tabelle `userdaten`
--
ALTER TABLE `userdaten`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ergebnisse`
--
ALTER TABLE `ergebnisse`
  MODIFY `ergebnis_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `quiz_antwort`
--
ALTER TABLE `quiz_antwort`
  MODIFY `antwort_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `quiz_frage`
--
ALTER TABLE `quiz_frage`
  MODIFY `frage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `userdaten`
--
ALTER TABLE `userdaten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ergebnisse`
--
ALTER TABLE `ergebnisse`
  ADD CONSTRAINT `ergebnisse_ibfk_1` FOREIGN KEY (`benutzername`) REFERENCES `userdaten` (`username`),
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
