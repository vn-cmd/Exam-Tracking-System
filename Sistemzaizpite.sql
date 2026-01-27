SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Zbirka podatkov: `sistemzaizpite`
--

-- --------------------------------------------------------

--
-- Struktura tabele `administrator`
--

CREATE TABLE `administrator` (
  `ID` int(10) NOT NULL,
  `IME` varchar(255) NOT NULL,
  `E-NASLOV` varchar(255) NOT NULL,
  `GESLO` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- podatke za tabelo `administrator`
--

INSERT INTO `administrator` (`ID`, `IME`, `E-NASLOV`, `GESLO`) VALUES
(1, 'admin1', 'admin1@gmail.com', 'admin1'),
(2, 'admin2', 'admin2@gmail.com', 'admin2');

-- --------------------------------------------------------

--
-- Struktura tabele `comment`
--

CREATE TABLE `comment` (
  `cid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `fid` int(10) NOT NULL,
  `date_f` datetime(6) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--  podatke za tabelo `comment`
--

INSERT INTO `comment` (`cid`, `uid`, `fid`, `date_f`, `message`) VALUES
(5, 15, 14, '2019-01-13 09:17:31.000000', 'dljkwlakdjaw\r\n\r\ndwa;dkwa;\r\ndwa;kdw\r\nd;awkw\r\n'),
(6, 17, 14, '2019-01-13 09:19:00.000000', 'dlajwkdaw'),
(7, 17, 14, '2019-01-13 09:19:04.000000', 'adw;ka'),
(8, 15, 15, '2019-01-13 09:22:22.000000', 'dalnwkdjalwk');

-- --------------------------------------------------------

--
-- Struktura tabele `izpit`
--

CREATE TABLE `izpit` (
  `ID` int(50) NOT NULL,
  `IME` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `CENA` int(120) NOT NULL,
  `IZVAJALEC` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PROSTORIJA` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DATUM` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--  podatke za tabelo `izpit`
--

INSERT INTO `izpit` (`ID`, `IME`, `CENA`, `IZVAJALEC`, `PROSTORIJA`, `DATUM`) VALUES
(01, 'Matematika I',  0, 'IztokPeterin','G2-P03', '2021-01-18'),
(02, 'Objektno Programiranje v Java', 0, 'MarjanHericko', 'G2-P1 ALFA', '2021-01-22'),
(03, 'Diskretne strukture', 65, 'IztokPeterin', 'G2-P04', '2021-02-03');

-- --------------------------------------------------------

--
-- Struktura tabele `zaporeden_pristop`
--

CREATE TABLE `zaporeden_pristop` (
  `id` int(10) NOT NULL,
  `izpit` int(10) NOT NULL,
  `pristop` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--  podatke za tabelo `zaporeden_pristop`
--

INSERT INTO `zaporeden_pristop` (`id`, `izpit`, `pristop`, `user_id`) VALUES
(11, 01, 1, 100243),
(12, 02, 01, 100243),
(13, 03, 4, 100243);

-- --------------------------------------------------------

--
-- Struktura tabele `prijava`
--

CREATE TABLE `prijava` (
  `id` int(10) NOT NULL,
  `idIzpit` int(10) NOT NULL,
  `idUporabnik` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--  podatke za tabelo `prijava`
--

INSERT INTO `prijava` (`id`, `idIzpit`, `idUporabnik`) VALUES
(2, 14, 100243),
(3, 15, 100243),
(4, 15, 100243);

-- --------------------------------------------------------

--
-- Struktura tabele `prostorija`
--

CREATE TABLE `prostorija` (
  `ID_prostorija` int(10) NOT NULL,
  `Stevilo_mest` int(10) NOT NULL,
  `Oznaka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--  podatke za tabelo `prostorija`
--

INSERT INTO `prostorija` (`ID_prostorija`, `Stevilo_mest`, `Oznaka`) VALUES
(1,  100, 'G2-P01'),
(2,  110, 'G2-P01 ALFA'),
(3,  100, 'G2-P01 BETA'),
(4,  120, 'G2-P02'),
(5,  130, 'G2-P03'),
(6,  140, 'G2-P04'),
(7,  110, 'G2-P04 GAMA'),
(8,  100, 'G2-P04 DELTA'),

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--  podatke za tabelo `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(100243, 'ViktorNankovski', 'viktor.nankovski@gmail.com', '12345678'),
(101432, 'StefanStefanov', 'stefan@gmail.com', '12345678'),
(101433, 'TanjaPetrova', 'tanja@gmail.com', '12345678'),
(100233, 'FilipJovanov', 'filipj@gmail.com', '12345678');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksi tabele `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `comment_ibfk_1` (`uid`),
  ADD KEY `comment_ibfk_2` (`fid`);

--
-- Indeksi tabele `izpit`
--
ALTER TABLE `izpit`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksi tabele `zaporeden_pristop`
--
ALTER TABLE `zaporeden_pristop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `izpit` (`izpit`),
  ADD KEY `user` (`user_id`);

--
-- Indeksi tabele `prijava`
--

ALTER TABLE `prijava`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prijava_ibfk_1` (`idIzpit`),
  ADD KEY `idUporabnik` (`idUporabnik`);

--
-- Indeksi tabele `prostorija`
--
ALTER TABLE `prostorija`
  ADD PRIMARY KEY (`ID_prostorija`);

--
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `administrator`
--
ALTER TABLE `administrator`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabele `comment`
--
ALTER TABLE `comment`
  MODIFY `cid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT tabele `izpit`
--
ALTER TABLE `izpit`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT tabele `zaporeden_pristop`
--
ALTER TABLE `zaporeden_pristop`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT tabele `prijava`
--
ALTER TABLE `prijava`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Omejitve za tabelo `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`fid`) REFERENCES `izpit` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omejitve za tabelo `zaporeden_pristop`
--
ALTER TABLE `zaporeden_pristop`
  ADD CONSTRAINT `zaporeden_pristop_ibfk_1` FOREIGN KEY (`izpit`) REFERENCES `izpit` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zaporeden_pristop_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omejitve za tabelo `prijava`
--

ALTER TABLE `prijava`
  ADD CONSTRAINT `prijava_ibfk_1` FOREIGN KEY (`idIzpit`) REFERENCES `izpit` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prijava_ibfk_2` FOREIGN KEY (`idUporabnik`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;*/
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
