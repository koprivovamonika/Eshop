-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 29. lis 2020, 13:05
-- Verze serveru: 5.7.14
-- Verze PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `eshop`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `dokoncene_objednavky`
--

CREATE TABLE `dokoncene_objednavky` (
  `id` int(11) NOT NULL,
  `id_uzivatel` int(11) NOT NULL,
  `id_produkt` int(11) NOT NULL,
  `pocet` int(11) NOT NULL,
  `cena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `dokoncene_objednavky`
--

INSERT INTO `dokoncene_objednavky` (`id`, `id_uzivatel`, `id_produkt`, `pocet`, `cena`) VALUES
(1, 2, 1, 1, 29),
(2, 2, 2, 1, 39),
(3, 2, 3, 1, 59),
(4, 2, 4, 1, 19),
(5, 2, 3, 5, 59),
(6, 2, 1, 3, 29),
(7, 2, 3, 1, 59),
(8, 2, 4, 1, 19),
(9, 2, 2, 6, 39),
(10, 2, 3, 6, 59);

-- --------------------------------------------------------

--
-- Struktura tabulky `kosik`
--

CREATE TABLE `kosik` (
  `id` int(11) NOT NULL,
  `id_uzivatel` int(11) NOT NULL,
  `id_produkt` int(11) NOT NULL,
  `pocet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `kosik`
--

INSERT INTO `kosik` (`id`, `id_uzivatel`, `id_produkt`, `pocet`) VALUES
(21, 2, 4, 3),
(22, 2, 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `obrazek` varchar(500) COLLATE utf8mb4_czech_ci NOT NULL,
  `jmeno` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `cena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `produkty`
--

INSERT INTO `produkty` (`id`, `obrazek`, `jmeno`, `cena`) VALUES
(1, '&#127820', 'banana', 29),
(2, '&#127823', 'apple', 39),
(3, '&#127817', 'watermelon', 59),
(4, '&#129364', 'potato', 19);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE `uzivatele` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `prijmeni` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `heslo` varchar(500) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id`, `jmeno`, `prijmeni`, `heslo`, `email`) VALUES
(1, 'Monika', 'Kopřivová', '$2y$10$bzcdw/pcHVmIhA13H2nX8uAARl/5hYGfsgyMkUlaV0Ssq6Wihhppe', 'monika@seznam.cz'),
(2, 'Monika', 'Kopřivová', '$2y$10$2PWhNAQDDHEUgtDwV6/TLu/16giOBMeq0QRijpiu9UfS9JFmnG5Rm', 'm@m');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `dokoncene_objednavky`
--
ALTER TABLE `dokoncene_objednavky`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzivatel` (`id_uzivatel`),
  ADD KEY `id_produkt` (`id_produkt`);

--
-- Klíče pro tabulku `kosik`
--
ALTER TABLE `kosik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzivatel` (`id_uzivatel`,`id_produkt`),
  ADD KEY `produkt` (`id_produkt`);

--
-- Klíče pro tabulku `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `dokoncene_objednavky`
--
ALTER TABLE `dokoncene_objednavky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pro tabulku `kosik`
--
ALTER TABLE `kosik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pro tabulku `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `dokoncene_objednavky`
--
ALTER TABLE `dokoncene_objednavky`
  ADD CONSTRAINT `produkt1` FOREIGN KEY (`id_produkt`) REFERENCES `produkty` (`id`),
  ADD CONSTRAINT `uzivatel1` FOREIGN KEY (`id_uzivatel`) REFERENCES `uzivatele` (`id`);

--
-- Omezení pro tabulku `kosik`
--
ALTER TABLE `kosik`
  ADD CONSTRAINT `produkt` FOREIGN KEY (`id_produkt`) REFERENCES `produkty` (`id`),
  ADD CONSTRAINT `uzivatel` FOREIGN KEY (`id_uzivatel`) REFERENCES `uzivatele` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
