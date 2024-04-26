-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Apr 2024 um 10:39
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_antwort2`
--

CREATE TABLE `quiz_antwort2` (
  `antwort_id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_text` varchar(255) NOT NULL,
  `korrekt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_antwort2`
--

INSERT INTO `quiz_antwort2` (`antwort_id`, `frage_id`, `antwort_text`, `korrekt`) VALUES
(1, 1, 'create_circle', 0),
(2, 1, 'create_oval', 1),
(3, 1, 'draw_circle', 0),
(1, 4, 'Integer', 0),
(2, 4, 'Float', 0),
(3, 4, 'String', 1),
(1, 2, 'Typecasting', 1),
(2, 2, 'Datentypwandelprozess', 0),
(3, 2, 'Casttyping', 0),
(1, 3, 'Zeichenraum', 0),
(2, 3, 'Canvas', 1),
(3, 3, 'Cannix', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_antwort3`
--

CREATE TABLE `quiz_antwort3` (
  `antwort_id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_text` varchar(255) NOT NULL,
  `korrekt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_antwort3`
--

INSERT INTO `quiz_antwort3` (`antwort_id`, `frage_id`, `antwort_text`, `korrekt`) VALUES
(1, 1, 'RS-Flip-Flop', 0),
(2, 1, 'D-Flip-Flop', 0),
(3, 1, 'SR-Flip-Flop', 1),
(1, 2, 'Transistor', 0),
(2, 2, 'Flip-Flop', 1),
(3, 2, 'Kondensator', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_antwort4`
--

CREATE TABLE `quiz_antwort4` (
  `antwort_id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_text` varchar(255) NOT NULL,
  `korrekt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_antwort4`
--

INSERT INTO `quiz_antwort4` (`antwort_id`, `frage_id`, `antwort_text`, `korrekt`) VALUES
(1, 1, 'Kupfer', 0),
(2, 1, 'Aluminium', 0),
(3, 1, 'Kunststoff ', 1),
(1, 2, 'Spannung', 0),
(2, 2, 'Widerstand', 0),
(3, 2, 'Stromstärke ', 1),
(1, 3, 'Ohmsches Gesetz', 1),
(2, 3, 'Kirchhoffsches Gesetz', 0),
(3, 3, ' Faradaysches Gesetz', 0);

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
(1, 'Welches Kommunikationsprotokoll wird typischerweise für den Versand von E-Mails verwendet?'),
(2, 'Welche Art von Kabel wird häufig für die Verbindung von Computern mit einem Netzwerk verwendet?'),
(3, 'Welche Technologie wird verwendet, um drahtlose Kommunikation zwischen mobilen Geräten zu ermöglichen?');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_frage2`
--

CREATE TABLE `quiz_frage2` (
  `frage_id` int(11) NOT NULL,
  `frage_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_frage2`
--

INSERT INTO `quiz_frage2` (`frage_id`, `frage_text`) VALUES
(1, 'Wie lautet der Befehl, um einen Kreis in tkinter in Python zu zeichnen?\r\n'),
(2, 'Wie nennt man das Umwandeln von Datentypen in Python?\r\n'),
(3, 'Was muss erstellt werden, bevor in tkinter gezeichnet werden kann?\r\n'),
(4, 'In welchem Datentyp werden Zeichenketten gespeichert?\r\n');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_frage3`
--

CREATE TABLE `quiz_frage3` (
  `frage_id` int(11) NOT NULL,
  `frage_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_frage3`
--

INSERT INTO `quiz_frage3` (`frage_id`, `frage_text`) VALUES
(1, 'Welche Art von Flip-Flop speichert einen einzelnen Bitzustand und kann zwischen zwei stabilen Zuständen wechseln?'),
(2, 'Welche Art von Speicherbauelement wird typischerweise verwendet, um Daten in digitalen Schaltkreisen zu speichern und zu verarbeiten?');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz_frage4`
--

CREATE TABLE `quiz_frage4` (
  `frage_id` int(11) NOT NULL,
  `frage_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `quiz_frage4`
--

INSERT INTO `quiz_frage4` (`frage_id`, `frage_text`) VALUES
(1, 'Welches Material wird typischerweise als Isolator in elektrischen Leitungen verwendet?'),
(2, 'Welcher Parameter misst die Stärke eines elektrischen Stroms?'),
(3, 'Welches Gesetz beschreibt das Verhältnis zwischen Spannung, Stromstärke und Widerstand in einem elektrischen Stromkreis?');

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
(7, 'Axel', '$2y$10$w1yFnQV5GGAwFH0Vb/Vh9eXpOByJg.ggfVJ5mWU5d0pdfDSd3bqla', 0, 0, 0),
(8, 'marko', '$2y$10$mE/RnkTwsMhdHLNNdicWSuIQShjcE8LU1oDhiEmDx/QflxV1uOdMa', 0, 0, 0),
(9, 'Max Verstappen', '$2y$10$Jcp0l5EFhZ8tWH5LW3Nz9OUesTI7rMdg75L0nMzd4ZcPr0kRLHzfa', 4857, 5, 5),
(10, 'elias', '$2y$10$gVsV5xRonES81N0c3fzI8OFP0rm3BnurjkFk.EmuXeeE.qWrJitsS', 1077, 2, 4),
(11, 'Peter', '$2y$10$7XlXe6iXN4xXMEzCPW1DAOiQw8TIfhMAcaE.yKI8ftzVO9uUr0iTa', 1987, 2, 3),
(12, 'Joost', '$2y$10$OMMYUTqZdKXYd6Nx2Q5qAePkd4Fx3lEKOzgipkMiMoe4KQKFoYXHK', 9990, 11, 17);

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
  ADD PRIMARY KEY (`antwort_id`,`frage_id`);

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
-- AUTO_INCREMENT für Tabelle `quiz_frage`
--
ALTER TABLE `quiz_frage`
  MODIFY `frage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `userdaten`
--
ALTER TABLE `userdaten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
