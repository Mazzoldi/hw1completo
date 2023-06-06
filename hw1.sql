-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Giu 06, 2023 alle 18:26
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hw1`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bets`
--

CREATE TABLE `bets` (
  `bet_id` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  `win` decimal(10,2) NOT NULL,
  `date_bet` date NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `bets`
--

INSERT INTO `bets` (`bet_id`, `user_id`, `win`, `date_bet`, `details`) VALUES
(37, 100000003, '4239.25', '2023-06-06', '[\r\n  {\r\n    \"home_team\": \"Sassuolo\",\r\n    \"away_team\": \"Fiorentina\",\r\n    \"bet\": \"2\",\r\n    \"odd\": \"2.42\"\r\n  },\r\n  {\r\n    \"home_team\": \"Torino\",\r\n    \"away_team\": \"Inter\",\r\n    \"bet\": \"2\",\r\n    \"odd\": \"2.23\"\r\n  },\r\n  {\r\n    \"home_team\": \"Cremonese\",\r\n    \"away_team\": \"Salernitana\",\r\n    \"bet\": \"1\",\r\n    \"odd\": \"2.65\"\r\n  },\r\n  {\r\n    \"home_team\": \"Empoli\",\r\n    \"away_team\": \"Lazio\",\r\n    \"bet\": \"2\",\r\n    \"odd\": \"1.91\"\r\n  },\r\n  {\r\n    \"home_team\": \"Napoli\",\r\n    \"away_team\": \"Sampdoria\",\r\n    \"bet\": \"1\",\r\n    \"odd\": \"1.23\"\r\n  },\r\n  {\r\n    \"home_team\": \"Udinese\",\r\n    \"away_team\": \"Juventus\",\r\n    \"bet\": \"2\",\r\n    \"odd\": \"1.88\"\r\n  },\r\n  {\r\n    \"home_team\": \"Lecce\",\r\n    \"away_team\": \"Bologna\",\r\n    \"bet\": \"2\",\r\n    \"odd\": \"2.67\"\r\n  },\r\n  {\r\n    \"home_team\": \"Roma\",\r\n    \"away_team\": \"Spezia Calcio\",\r\n    \"bet\": \"1\",\r\n    \"odd\": \"1.89\"\r\n  },\r\n  {\r\n    \"home_team\": \"Atalanta\",\r\n    \"away_team\": \"Monza\",\r\n    \"bet\": \"1\",\r\n    \"odd\": \"1.52\"\r\n  },\r\n  {\r\n    \"home_team\": \"Milan\",\r\n    \"away_team\": \"Verona\",\r\n    \"bet\": \"1\",\r\n    \"odd\": \"1.75\"\r\n  },\r\n  {\r\n    \"puntata\": \"5\"\r\n  }\r\n]');

-- --------------------------------------------------------

--
-- Struttura della tabella `favourites`
--

CREATE TABLE `favourites` (
  `id` int(8) NOT NULL,
  `user_id` int(9) NOT NULL,
  `team_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `favourites`
--

INSERT INTO `favourites` (`id`, `user_id`, `team_id`) VALUES
(10000124, 100000001, 457),
(10000001, 100000002, 108),
(10000173, 100000003, 108),
(10000142, 100000006, 100);

-- --------------------------------------------------------

--
-- Struttura della tabella `teams`
--

CREATE TABLE `teams` (
  `team_id` int(8) NOT NULL,
  `name` varchar(32) NOT NULL,
  `short_name` varchar(3) NOT NULL,
  `logo_filepath` varchar(128) NOT NULL,
  `competition_code` varchar(4) NOT NULL,
  `competition_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `teams`
--

INSERT INTO `teams` (`team_id`, `name`, `short_name`, `logo_filepath`, `competition_code`, `competition_name`) VALUES
(1, 'FC Köln', 'KOE', 'https://crests.football-data.org/1.png', 'BL1', 'Bundesliga'),
(2, 'Hoffenheim', 'TSG', 'https://crests.football-data.org/2.png', 'BL1', 'Bundesliga'),
(3, 'Leverkusen', 'B04', 'https://crests.football-data.org/3.png', 'BL1', 'Bundesliga'),
(4, 'Dortmund', 'BVB', 'https://crests.football-data.org/4.png', 'BL1', 'Bundesliga'),
(5, 'Bayern', 'FCB', 'https://crests.football-data.org/5.svg', 'BL1', 'Bundesliga'),
(6, 'Schalke', 'S04', 'https://crests.football-data.org/6.png', 'BL1', 'Bundesliga'),
(9, 'Hertha BSC', 'BSC', 'https://crests.football-data.org/9.png', 'BL1', 'Bundesliga'),
(10, 'Stuttgart', 'VFB', 'https://crests.football-data.org/10.png', 'BL1', 'Bundesliga'),
(11, 'Wolfsburg', 'WOB', 'https://crests.football-data.org/11.svg', 'BL1', 'Bundesliga'),
(12, 'Bremen', 'SVW', 'https://crests.football-data.org/12.svg', 'BL1', 'Bundesliga'),
(15, 'Mainz', 'M05', 'https://crests.football-data.org/15.png', 'BL1', 'Bundesliga'),
(16, 'Augsburg', 'FCA', 'https://crests.football-data.org/16.png', 'BL1', 'Bundesliga'),
(17, 'Freiburg', 'SCF', 'https://crests.football-data.org/17.svg', 'BL1', 'Bundesliga'),
(18, 'M\'gladbach', 'BMG', 'https://crests.football-data.org/18.png', 'BL1', 'Bundesliga'),
(19, 'Frankfurt', 'SGE', 'https://crests.football-data.org/19.svg', 'BL1', 'Bundesliga'),
(28, 'Union Berlin', 'UNB', 'https://crests.football-data.org/28.svg', 'BL1', 'Bundesliga'),
(36, 'Bochum', 'BOC', 'https://crests.football-data.org/36.png', 'BL1', 'Bundesliga'),
(57, 'Arsenal', 'ARS', 'https://crests.football-data.org/57.png', 'PL', 'Premier League'),
(58, 'Aston Villa', 'AVL', 'https://crests.football-data.org/58.png', 'PL', 'Premier League'),
(61, 'Chelsea', 'CHE', 'https://crests.football-data.org/61.png', 'PL', 'Premier League'),
(62, 'Everton', 'EVE', 'https://crests.football-data.org/62.png', 'PL', 'Premier League'),
(63, 'Fulham', 'FUL', 'https://crests.football-data.org/63.svg', 'PL', 'Premier League'),
(64, 'Liverpool', 'LIV', 'https://crests.football-data.org/64.png', 'PL', 'Premier League'),
(65, 'Man City', 'MCI', 'https://crests.football-data.org/65.png', 'PL', 'Premier League'),
(66, 'Man United', 'MUN', 'https://crests.football-data.org/66.png', 'PL', 'Premier League'),
(67, 'Newcastle', 'NEW', 'https://crests.football-data.org/67.png', 'PL', 'Premier League'),
(73, 'Tottenham', 'TOT', 'https://crests.football-data.org/73.svg', 'PL', 'Premier League'),
(76, 'Wolverhampton', 'WOL', 'https://crests.football-data.org/76.svg', 'PL', 'Premier League'),
(77, 'Athletic', 'ATH', 'https://crests.football-data.org/77.png', 'PD', 'Primera Division'),
(78, 'Atleti', 'ATL', 'https://crests.football-data.org/78.svg', 'PD', 'Primera Division'),
(79, 'Osasuna', 'OSA', 'https://crests.football-data.org/79.svg', 'PD', 'Primera Division'),
(80, 'Espanyol', 'ESP', 'https://crests.football-data.org/80.svg', 'PD', 'Primera Division'),
(81, 'Barça', 'FCB', 'https://crests.football-data.org/81.svg', 'PD', 'Primera Division'),
(82, 'Getafe', 'GET', 'https://crests.football-data.org/82.png', 'PD', 'Primera Division'),
(86, 'Real Madrid', 'RMA', 'https://crests.football-data.org/86.png', 'PD', 'Primera Division'),
(87, 'Rayo Vallecano', 'RAY', 'https://crests.football-data.org/87.svg', 'PD', 'Primera Division'),
(89, 'Mallorca', 'MAL', 'https://crests.football-data.org/89.png', 'PD', 'Primera Division'),
(90, 'Real Betis', 'BET', 'https://crests.football-data.org/90.png', 'PD', 'Primera Division'),
(92, 'Real Sociedad', 'RSO', 'https://crests.football-data.org/92.svg', 'PD', 'Primera Division'),
(94, 'Villarreal', 'VIL', 'https://crests.football-data.org/94.png', 'PD', 'Primera Division'),
(95, 'Valencia', 'VAL', 'https://crests.football-data.org/95.svg', 'PD', 'Primera Division'),
(98, 'Milan', 'MIL', 'https://crests.football-data.org/98.svg', 'SA', 'Serie A'),
(99, 'Fiorentina', 'FIO', 'https://crests.football-data.org/99.svg', 'SA', 'Serie A'),
(100, 'Roma', 'ROM', 'https://crests.football-data.org/100.svg', 'SA', 'Serie A'),
(102, 'Atalanta', 'ATA', 'https://crests.football-data.org/102.svg', 'SA', 'Serie A'),
(103, 'Bologna', 'BOL', 'https://crests.football-data.org/103.svg', 'SA', 'Serie A'),
(108, 'Inter', 'INT', 'https://crests.football-data.org/108.png', 'SA', 'Serie A'),
(109, 'Juventus', 'JUV', 'https://crests.football-data.org/109.svg', 'SA', 'Serie A'),
(110, 'Lazio', 'LAZ', 'https://crests.football-data.org/110.svg', 'SA', 'Serie A'),
(113, 'Napoli', 'NAP', 'https://crests.football-data.org/113.svg', 'SA', 'Serie A'),
(115, 'Udinese', 'UDI', 'https://crests.football-data.org/115.png', 'SA', 'Serie A'),
(250, 'Valladolid', 'VDD', 'https://crests.football-data.org/250.png', 'PD', 'Primera Division'),
(264, 'Cádiz CF', 'CAD', 'https://crests.football-data.org/264.png', 'PD', 'Primera Division'),
(267, 'Almería', 'ALM', 'https://crests.football-data.org/267.png', 'PD', 'Primera Division'),
(285, 'Elche', 'ELC', 'https://crests.football-data.org/285.png', 'PD', 'Primera Division'),
(298, 'Girona', 'GIR', 'https://crests.football-data.org/298.png', 'PD', 'Primera Division'),
(338, 'Leicester City', 'LEI', 'https://crests.football-data.org/338.png', 'PL', 'Premier League'),
(340, 'Southampton', 'SOU', 'https://crests.football-data.org/340.png', 'PL', 'Premier League'),
(341, 'Leeds United', 'LEE', 'https://crests.football-data.org/341.png', 'PL', 'Premier League'),
(351, 'Nottingham', 'NOT', 'https://crests.football-data.org/351.png', 'PL', 'Premier League'),
(354, 'Crystal Palace', 'CRY', 'https://crests.football-data.org/354.png', 'PL', 'Premier League'),
(397, 'Brighton Hove', 'BHA', 'https://crests.football-data.org/397.svg', 'PL', 'Premier League'),
(402, 'Brentford', 'BRE', 'https://crests.football-data.org/402.png', 'PL', 'Premier League'),
(445, 'Empoli', 'EMP', 'https://crests.football-data.org/445.png', 'SA', 'Serie A'),
(450, 'Verona', 'HVE', 'https://crests.football-data.org/450.png', 'SA', 'Serie A'),
(455, 'Salernitana', 'SAL', 'https://crests.football-data.org/455.png', 'SA', 'Serie A'),
(457, 'Cremonese', 'CRE', 'https://crests.football-data.org/457.png', 'SA', 'Serie A'),
(471, 'Sassuolo', 'SAS', 'https://crests.football-data.org/471.svg', 'SA', 'Serie A'),
(488, 'Spezia Calcio', 'SPE', 'https://crests.football-data.org/488.svg', 'SA', 'Serie A'),
(510, 'AC Ajaccio', 'ACA', 'https://crests.football-data.org/510.png', 'FL1', 'Ligue 1'),
(511, 'Toulouse', 'TOU', 'https://crests.football-data.org/511.png', 'FL1', 'Ligue 1'),
(512, 'Brest', 'BRE', 'https://crests.football-data.org/512.png', 'FL1', 'Ligue 1'),
(516, 'Marseille', 'MAR', 'https://crests.football-data.org/516.png', 'FL1', 'Ligue 1'),
(518, 'Montpellier', 'MON', 'https://crests.football-data.org/518.png', 'FL1', 'Ligue 1'),
(519, 'Auxerre', 'AJA', 'https://crests.football-data.org/519.png', 'FL1', 'Ligue 1'),
(521, 'Lille', 'LIL', 'https://crests.football-data.org/521.svg', 'FL1', 'Ligue 1'),
(522, 'Nice', 'NIC', 'https://crests.football-data.org/522.png', 'FL1', 'Ligue 1'),
(523, 'Olympique Lyon', 'LYO', 'https://crests.football-data.org/523.svg', 'FL1', 'Ligue 1'),
(524, 'PSG', 'PSG', 'https://crests.football-data.org/524.png', 'FL1', 'Ligue 1'),
(525, 'Lorient', 'FCL', 'https://crests.football-data.org/525.png', 'FL1', 'Ligue 1'),
(529, 'Stade Rennais', 'REN', 'https://crests.football-data.org/529.png', 'FL1', 'Ligue 1'),
(531, 'Troyes', 'ETR', 'https://crests.football-data.org/531.svg', 'FL1', 'Ligue 1'),
(532, 'Angers SCO', 'ANG', 'https://crests.football-data.org/532.svg', 'FL1', 'Ligue 1'),
(541, 'Clermont Foot', 'CLF', 'https://crests.football-data.org/541.svg', 'FL1', 'Ligue 1'),
(543, 'Nantes', 'NAN', 'https://crests.football-data.org/543.svg', 'FL1', 'Ligue 1'),
(546, 'RC Lens', 'RCL', 'https://crests.football-data.org/546.png', 'FL1', 'Ligue 1'),
(547, 'Stade de Reims', 'SDR', 'https://crests.football-data.org/547.png', 'FL1', 'Ligue 1'),
(548, 'Monaco', 'ASM', 'https://crests.football-data.org/548.png', 'FL1', 'Ligue 1'),
(558, 'Celta', 'CEL', 'https://crests.football-data.org/558.svg', 'PD', 'Primera Division'),
(559, 'Sevilla FC', 'SEV', 'https://crests.football-data.org/559.svg', 'PD', 'Primera Division'),
(563, 'West Ham', 'WHU', 'https://crests.football-data.org/563.png', 'PL', 'Premier League'),
(576, 'Strasbourg', 'RC ', 'https://crests.football-data.org/576.png', 'FL1', 'Ligue 1'),
(584, 'Sampdoria', 'SAM', 'https://crests.football-data.org/584.svg', 'SA', 'Serie A'),
(586, 'Torino', 'TOR', 'https://crests.football-data.org/586.svg', 'SA', 'Serie A'),
(666, 'Twente', 'TWE', 'https://crests.football-data.org/666.png', 'DED', 'Eredivisie'),
(670, 'Excelsior', 'EXC', 'https://crests.football-data.org/670.png', 'DED', 'Eredivisie'),
(673, 'Heerenveen', 'HEE', 'https://crests.football-data.org/673.png', 'DED', 'Eredivisie'),
(674, 'PSV', 'PSV', 'https://crests.football-data.org/674.png', 'DED', 'Eredivisie'),
(675, 'Feyenoord', 'FEY', 'https://crests.football-data.org/675.png', 'DED', 'Eredivisie'),
(676, 'Utrecht', 'UTR', 'https://crests.football-data.org/676.png', 'DED', 'Eredivisie'),
(677, 'Groningen', 'GRO', 'https://crests.football-data.org/677.png', 'DED', 'Eredivisie'),
(678, 'Ajax', 'AJA', 'https://crests.football-data.org/678.png', 'DED', 'Eredivisie'),
(679, 'Vitesse', 'VIT', 'https://crests.football-data.org/679.png', 'DED', 'Eredivisie'),
(682, 'AZ', 'AZ', 'https://crests.football-data.org/682.png', 'DED', 'Eredivisie'),
(683, 'RKC', 'RKC', 'https://crests.football-data.org/683.png', 'DED', 'Eredivisie'),
(718, 'Go Ahead', 'GOA', 'https://crests.football-data.org/718.png', 'DED', 'Eredivisie'),
(721, 'RB Leipzig', 'RBL', 'https://crests.football-data.org/721.png', 'BL1', 'Bundesliga'),
(1044, 'Bournemouth', 'BOU', 'https://crests.football-data.org/1044.png', 'PL', 'Premier League'),
(1909, 'Cambuur', 'CAM', 'https://crests.football-data.org/1909.png', 'DED', 'Eredivisie'),
(1914, 'Emmen', 'EMM', 'https://crests.football-data.org/1914.png', 'DED', 'Eredivisie'),
(1915, 'NEC', 'NEC', 'https://crests.football-data.org/1915.png', 'DED', 'Eredivisie'),
(1919, 'Volendam', 'VOL', 'https://crests.football-data.org/1919.png', 'DED', 'Eredivisie'),
(1920, 'Sittard', 'SIT', 'https://crests.football-data.org/1920.png', 'DED', 'Eredivisie'),
(5890, 'Lecce', 'USL', 'https://crests.football-data.org/5890.png', 'SA', 'Serie A'),
(5911, 'Monza', 'MON', 'https://crests.football-data.org/5911.png', 'SA', 'Serie A'),
(6806, 'Sparta', 'SPA', 'https://crests.football-data.org/6806.png', 'DED', 'Eredivisie');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `user_id` int(9) NOT NULL,
  `username` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `email` varchar(64) NOT NULL,
  `birthday` date NOT NULL,
  `file_path` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `surname`, `password`, `email`, `birthday`, `file_path`) VALUES
(100000000, 'Mazz', 'Nicolo', 'Mazzola', '$2y$10$X8Ffwzlzieo28RcEvg/0MOixneHw5rwPph2zhp1HTysYq85Ryi5Li', 'nico@gmail.com', '2012-09-12', 'assets/default_avatar.png'),
(100000001, 'Mazzo', 'Nicolo', 'Mazzola', '$2y$10$nM.twUXhnMkDYptXfnHh7erHSKLT2EFoO7f4lso03NyVCgVs7MI76', 'nicolo@gmail.com', '2008-09-06', 'assets/6474cb7ea4a866.37403824.jpg'),
(100000002, 'Mazzold', 'Nicolo', 'Mazzola', '$2y$10$aff49iiL5NQcBB6lWPshxOHdpR9HZ1mO2c5B62wVR1Bippmhay2oC', 'nicolomazzola@gmail.com', '2014-10-15', 'assets/64736559eb3206.63162308.jpg'),
(100000003, 'Mazzoldi', 'Nicolo', 'Mazzola', '$2y$10$fFea1dZSVsh5CZ.saIqXq.C1Ya/V.mTRjoC4e8RYQvawLlHkfWMgS', 'nicolomazzola02@gmail.com', '2002-09-12', 'assets/647237a98277a1.92246124.jpg'),
(100000004, 'Mazzoldian', 'Nicolo', 'Mazzola', '$2y$10$P2NzTOLe8h2HV7w76J5lkehr6yGlFm9Wl8vrkTlb18mT4G.7yf9Jq', 'nicolomaz@gmail.com', '2009-10-11', 'assets/646c8f2a4719d1.24802661.jpg'),
(100000005, '3qwert', 'Danilo', 'Sotera', '$2y$10$snsLeRbD2MtbbmPVetIUNu3RftVJTAzNBbDulibEjmGdWb.hUsfWW', 'ragusasert46@gmail.com', '2001-06-13', 'assets/6474c1f82ee815.65696971.jpg'),
(100000006, 'skasico', 'Daniele', 'Riccobene', '$2y$10$Iyee7HMPMBbs3YzsBnYdDeerSpZWfD0qHURJIUuBgteuxJV7CMc6G', 'daniele@email.it', '2001-12-31', 'assets/6474d6657ab1e9.53796745.jpg'),
(100000007, 'Mizzoldi', 'Mizzoldi', 'Mizzoldi', '$2y$10$qOApX.RGjQF4641jjr9J9uJLRwtjJPSZZetoxsN6vODy5AghWiHbe', 'mizzoldi@news.it', '2016-06-06', 'assets/647f08c6486d43.81114515.jpg');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`bet_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`details`) USING HASH,
  ADD KEY `User_ID` (`user_id`);

--
-- Indici per le tabelle `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indici per le tabelle `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `bets`
--
ALTER TABLE `bets`
  MODIFY `bet_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT per la tabella `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000174;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000008;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `bets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Limiti per la tabella `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`Team_ID`) REFERENCES `teams` (`team_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `favourites_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_4` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
