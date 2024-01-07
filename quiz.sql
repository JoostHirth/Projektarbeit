-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Jan 2024 um 15:25
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
(5, 'qwer', '$2y$10$aDYFlv9c4CTiYOggtAkkL.ywaOS0KIgTz6.eVp.6FSoMoPMFAU3j.'),
(8, 'ghjkl', '$2y$10$xIQarNWQ628A1PNq4275CuPYHzavsDqWWAXo5GCbkks9L/8STXd4i'),
(9, 'asdf', '$2y$10$w77T.Hl0qVvIfnYWNnAeROcAzTh/tgPrHo/51O8g9yhcwDkXSc9.a');

--
-- Indizes der exportierten Tabellen
--

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `quiz_antwort`
--
ALTER TABLE `quiz_antwort`
  ADD CONSTRAINT `quiz_antwort_ibfk_1` FOREIGN KEY (`frage_id`) REFERENCES `quiz_frage` (`frage_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
