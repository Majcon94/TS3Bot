-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Cze 2019, 01:44
-- Wersja serwera: 10.1.38-MariaDB
-- Wersja PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ts3bot`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `banhistory`
--

CREATE TABLE `banhistory` (
  `id` int(255) NOT NULL,
  `banid` int(255) NOT NULL DEFAULT '0',
  `ip` varchar(100) NOT NULL DEFAULT '',
  `uid` varchar(30) NOT NULL DEFAULT '',
  `cldbid` int(255) NOT NULL DEFAULT '0',
  `lastnickname` varchar(50) NOT NULL DEFAULT '',
  `created` int(100) NOT NULL DEFAULT '0',
  `duration` int(100) NOT NULL DEFAULT '0',
  `invokername` varchar(50) NOT NULL DEFAULT '',
  `invokercldbid` int(255) NOT NULL DEFAULT '0',
  `invokeruid` varchar(100) NOT NULL DEFAULT '',
  `reason` varchar(5000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `channel`
--

CREATE TABLE `channel` (
  `id` int(255) NOT NULL,
  `cldbid` int(255) NOT NULL DEFAULT '0',
  `cid` int(255) NOT NULL DEFAULT '0',
  `connection_client_ip` varchar(255) NOT NULL DEFAULT '',
  `pin` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `command`
--

CREATE TABLE `command` (
  `id` int(255) NOT NULL,
  `cmd` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(100) NOT NULL DEFAULT '',
  `staff` int(10) NOT NULL DEFAULT '0',
  `group` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(5000) NOT NULL DEFAULT '',
  `syntax` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `command`
--

INSERT INTO `command` (`id`, `cmd`, `alias`, `staff`, `group`, `description`, `syntax`) VALUES
(1, 'help', '', 0, '', 'Wyświetla listę dostępnych komend.', '!help'),
(2, 'groupcmd', '', 10, '', 'Ustawia grupy wymagane do użycia komendy.', '!groupcmd komenda grupy_po_przecinku'),
(3, 'staffcmd', '', 10, '', 'Ustawia staff wymagany do użycia komendy.', '!staffcmd komenda staff'),
(4, 'poke', '', 10, '', 'Puka wszystkich użytkowników lub tych z podanej grupy.', '!poke all/id_grup | Wiadomość'),
(5, 'staff', '', 10, '', 'Nadaje dostęp do komend bota.', '!staff unique_identifier staff'),
(6, 'userinfo', 'ui', 10, '', 'Podaje informacje o użytkowniku', '!userinfo cdbid/cuid'),
(7, 'stats', '', 10, '', 'Wyświetla statystki.', '!stats dbid/cuid'),
(8, 'channelpin', 'cp', 10, '', 'Podaje informacje o kanale.', '!channelpin pin'),
(9, 'channelowner', 'co', 10, '', 'Utawia właściciela kanału prywatnego', '!channelowner cid cdbid/cuid'),
(10, 'addcmd', 'ac', 10, '', 'Komenda dodaje komendy tekstowe do bota', '!addcmd komenda treść'),
(11, 'givegroup', 'gg', 0, '', 'Nadaje podaną grupę.', '!givegroup id_grup'),
(12, 'delgroup', 'dg', 0, '', 'Usuwa podaną grupe.', '!delgroup id_grup'),
(13, 'adminlog', 'ac', 10, '', 'Komenda wyświetla logi administratora', '!adminlog cdbid/cuid data'),
(14, 'banhistory', 'bh', 10, '', 'Komenda wyświetla historię banów', '!banhistory ip/uid/cldbid'),
(15, 'gamble', 'gb', 0, '', 'Komenda pozwala obstawić punkty', '!gamble ilość_pkt|all'),
(16, 'punkty', 'pkt', 0, '', 'Komenda pozwala sprawdzić ilość punktów', '!punkty');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `command_txt`
--

CREATE TABLE `command_txt` (
  `id` int(255) NOT NULL,
  `cmd` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(100) NOT NULL DEFAULT '',
  `text` varchar(5000) NOT NULL DEFAULT '',
  `staff` int(10) NOT NULL DEFAULT '0',
  `group` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(5000) NOT NULL DEFAULT '',
  `syntax` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ip`
--

CREATE TABLE `ip` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL DEFAULT '',
  `proxy` int(1) NOT NULL DEFAULT '0',
  `time` int(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ip`
--

INSERT INTO `ip` (`id`, `ip`, `proxy`, `time`) VALUES
(1, '127.0.0.1', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `cldbid` int(255) NOT NULL DEFAULT '0',
  `client_nickname` varchar(255) NOT NULL DEFAULT '',
  `cui` varchar(255) NOT NULL DEFAULT '',
  `longest_connection` int(255) NOT NULL DEFAULT '0',
  `connections` int(255) NOT NULL DEFAULT '0',
  `time_activity` int(255) NOT NULL DEFAULT '0',
  `last_activity` int(255) NOT NULL DEFAULT '0',
  `lvl` int(10) NOT NULL DEFAULT '1',
  `exp` float NOT NULL DEFAULT '0',
  `pkt` int(255) NOT NULL DEFAULT '0',
  `regdate` int(25) NOT NULL DEFAULT '0',
  `gid` varchar(255) NOT NULL DEFAULT '',
  `staff` int(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `cldbid`, `client_nickname`, `cui`, `longest_connection`, `connections`, `time_activity`, `last_activity`, `lvl`, `exp`, `pkt`, `regdate`, `gid`, `staff`) VALUES
(1, 1, 'serveradmin', 'serveradmin', 0, 0, 0, 0, 1, 0, 0, 0, '1', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `banhistory`
--
ALTER TABLE `banhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `command_txt`
--
ALTER TABLE `command_txt`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ip`
--
ALTER TABLE `ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index_ip` (`ip`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index_cui` (`cui`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `channel`
--
ALTER TABLE `channel`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `command`
--
ALTER TABLE `command`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `command_txt`
--
ALTER TABLE `command_txt`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `ip`
--
ALTER TABLE `ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
