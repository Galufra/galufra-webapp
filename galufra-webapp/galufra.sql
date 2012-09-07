-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Set 06, 2012 alle 15:44
-- Versione del server: 5.5.16
-- Versione PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `galufra`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `consiglia`
--

CREATE TABLE IF NOT EXISTS `consiglia` (
  `utente` int(11) NOT NULL,
  `evento` int(11) NOT NULL,
  PRIMARY KEY (`utente`,`evento`),
  KEY `evento` (`evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `consiglia`
--

INSERT INTO `consiglia` (`utente`, `evento`) VALUES
(68, 229),
(12, 230),
(68, 230),
(12, 235),
(67, 235),
(68, 235),
(12, 236),
(67, 236),
(68, 236),
(12, 257),
(67, 257),
(68, 257);

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) CHARACTER SET hp8 NOT NULL,
  `descrizione` text CHARACTER SET hp8 NOT NULL,
  `data` datetime NOT NULL,
  `n_visite` int(11) NOT NULL DEFAULT '0',
  `n_iscritti` int(11) NOT NULL DEFAULT '0',
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `id_gestore` int(11) NOT NULL,
  `consigliato` tinyint(1) NOT NULL DEFAULT '0',
  `annuncio` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  PRIMARY KEY (`id_evento`),
  UNIQUE KEY `nome` (`nome`,`data`),
  KEY `id_gestore` (`id_gestore`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=261 ;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`id_evento`, `nome`, `descrizione`, `data`, `n_visite`, `n_iscritti`, `lat`, `lon`, `id_gestore`, `consigliato`, `annuncio`) VALUES
(3, 'prova1', 'Prova :)\r\nQuesto evento si svolge a piazza Palazzo, 67100 L''Aquila.\r\nLorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2012-11-29 00:00:00', 0, 0, 42.3508415222168, 13.398554801940918, 1, 1, 'ghg2\n'),
(172, 'festa', 'Festa in maschera! ingresso libero', '2012-09-25 00:00:00', 0, 0, 42.4199096, 14.290051800000015, 63, 0, NULL),
(228, 'prova 3', 'serata latino americano. ingresso gratuito!', '2012-09-27 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, ''''''''''''''''''''''''''),
(229, 'prova 4', 'cena sociale. Azienda Regatti! 10 euro/persona', '2012-09-16 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, 'L''evento'),
(230, 'Arte contemporanea', 'ingresso 5 euro', '2012-09-27 00:00:00', 0, 0, 42.3525448, 13.402602099999967, 68, 0, ''),
(231, 'Evento di prova', 'Ecco un altro evento', '2012-09-28 00:00:00', 0, 0, 42.4617902, 14.216089799999963, 68, 0, 'Annuncio'),
(234, 'festa ', 'tutti in strada!!! ', '2012-09-17 00:00:00', 0, 0, 42.46780220000001, 14.215347400000041, 69, 0, 'Nessun Costo D''ingresso'),
(235, 'prova 5', 'Serata allo spettacolare grattacielo di NYC. Contattare teo@teo.com', '2012-09-30 00:00:00', 0, 0, 40.7484395, -73.9856709, 67, 0, ''),
(236, 'prova 6', 'prova ', '2012-09-30 00:00:00', 0, 0, 42.3487451, 13.401908700000035, 67, 0, ''),
(254, 'Ciao L''''Aquila', 'una prova per vedere la data', '2012-12-22 20:44:00', 0, 0, 42.5074019, 14.161013599999933, 67, 0, ''),
(257, 'programmazione web', 'Presentazione e discussione progetto galufra web-app', '2012-09-14 10:00:00', 0, 0, 42.35219, 13.39671999999996, 67, 0, ''),
(260, 'Party di fine estate', 'Festa di fine estate, organizziamo hall di musica di vario genere. Ingresso gratuito!', '2012-09-17 22:00:00', 0, 0, 42.354581, 13.391628399999945, 106, 0, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggio`
--

CREATE TABLE IF NOT EXISTS `messaggio` (
  `id_mess` int(11) NOT NULL AUTO_INCREMENT,
  `testo` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `data` datetime NOT NULL,
  `evento` int(11) NOT NULL,
  `utente` varchar(30) NOT NULL,
  PRIMARY KEY (`id_mess`),
  KEY `evento` (`evento`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Dump dei dati per la tabella `messaggio`
--

INSERT INTO `messaggio` (`id_mess`, `testo`, `data`, `evento`, `utente`) VALUES
(33, 'Ãˆ finita la pacchia', '2012-08-09 00:00:00', 3, 'teo'),
(68, '45t34g3', '2012-08-12 00:00:00', 234, 'teo'),
(69, 'thgtwh', '2012-08-12 00:00:00', 234, 'teo'),
(70, 'E cosa si farÃ Â ??', '2012-08-13 00:00:00', 234, 'teo'),
(71, 'eh si', '2012-08-13 00:00:00', 3, 'simo'),
(72, 'l''amico', '2012-08-16 00:00:00', 229, 'teo'),
(73, '''''''''''''', '2012-08-17 00:00:00', 228, 'teo'),
(74, '''''''''''''''''''''''''''''''''''''''''''''''''''''''''', '2012-08-17 00:00:00', 228, 'teo'),
(75, '''''', '2012-08-17 00:00:00', 228, 'teo'),
(76, '''', '2012-08-17 00:00:00', 228, 'teo'),
(77, 'ciaooooo', '2012-08-17 00:00:00', 231, 'teo'),
(78, 'ciao', '2012-08-22 00:00:00', 3, 'teo'),
(79, 'ciao', '2012-08-22 00:00:00', 3, 'teo'),
(80, 'dvcafvafebvea', '2012-08-22 00:00:00', 3, 'teo'),
(81, 'ciaoao', '2012-08-22 00:00:00', 3, 'teo'),
(82, 'lol', '2012-08-22 17:31:30', 3, 'teo'),
(83, '''''', '2012-08-22 17:44:38', 3, 'teo'),
(84, '''', '2012-08-22 17:44:39', 3, 'teo'),
(85, '''''''''''''''', '2012-08-22 17:44:41', 3, 'teo'),
(86, '''''''''', '2012-08-22 17:46:24', 3, 'teo'),
(87, '''', '2012-08-22 17:46:26', 3, 'teo'),
(88, '''''', '2012-08-22 17:46:28', 3, 'teo'),
(89, '''''''''', '2012-08-22 17:47:49', 3, 'teo'),
(90, '''', '2012-08-22 17:47:51', 3, 'teo'),
(91, '''''', '2012-08-22 17:55:01', 3, 'teo'),
(92, '''''''''', '2012-08-22 17:56:15', 3, 'teo'),
(93, '''''''', '2012-08-22 17:57:45', 3, 'teo'),
(94, '''''', '2012-08-22 17:57:47', 3, 'teo'),
(95, '''', '2012-08-22 17:57:49', 3, 'teo'),
(96, 'Ã Ã Ã ', '2012-08-22 18:03:47', 3, 'teo'),
(100, '''''', '2012-08-22 18:53:18', 236, 'teo'),
(102, '''''''''', '2012-08-22 19:32:41', 236, 'teo'),
(106, 'l''aia', '2012-08-22 20:47:32', 254, 'teo'),
(107, 'Questo Ã¨ un commento di prova', '2012-08-24 19:37:15', 234, 'luke');

-- --------------------------------------------------------

--
-- Struttura della tabella `preferisce`
--

CREATE TABLE IF NOT EXISTS `preferisce` (
  `utente` int(11) NOT NULL,
  `evento` int(11) NOT NULL,
  PRIMARY KEY (`utente`,`evento`),
  KEY `locale` (`evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `preferisce`
--

INSERT INTO `preferisce` (`utente`, `evento`) VALUES
(1, 3),
(67, 3),
(68, 3),
(67, 229),
(67, 230),
(77, 231),
(12, 257),
(77, 257);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE IF NOT EXISTS `utente` (
  `id_utente` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `citta` varchar(100) NOT NULL DEFAULT 'L''Aquila',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `date` varchar(32) NOT NULL,
  `confirm_id` varchar(32) NOT NULL,
  `sbloccato` tinyint(1) NOT NULL DEFAULT '1',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `superuser` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_utente`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mail` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_utente`, `username`, `password`, `nome`, `cognome`, `email`, `citta`, `confirmed`, `date`, `confirm_id`, `sbloccato`, `admin`, `superuser`) VALUES
(1, 'dir31', 'f89c18242ab927d20216837b65935006', 'francesco', 'miscia', 'fra@fra.com', 'l''Aquila', 1, '0000-00-00 00:00:00', '0', 0, 0, 0),
(12, 'luca', 'ff377aff39a9345a9cca803fb5c5c081', 'luca', 'Di Stefano', 'fra.miscia@gmail.com', 'l''aquila', 1, '1334824341', '0', 1, 0, 0),
(67, 'teo', 'e827aa1ed78e96a113182dce12143f9f', 'Teodoro', 'Aloisi', 'teo@teo.it', 'l''Aquila', 1, '03/08/2012 - 17:41', 'e68b8f2dde309bb4d10ecbdc862ebab3', 0, 1, 1),
(68, 'simo', '43bd48ade3219a1931115a1dabbe1a7f', '', '', 'simo@simo.com', 'L''Aquila', 1, '13/08/2012 - 12:42', '72ab5ccd2d12f6132d6ff6d2e582c026', 0, 1, 1),
(77, 'luke', '46ecbec5ec7951ce102670dbd0b2def5', 'Luca', 'Marchisi', 'luke@luke.com', 'pescara', 1, '1345141426', '66006486fc55692ff9e07e7a87cf0dea', 1, 0, 0);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `consiglia`
--
ALTER TABLE `consiglia`
  ADD CONSTRAINT `consiglia_ibfk_3` FOREIGN KEY (`utente`) REFERENCES `utente` (`id_utente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consiglia_ibfk_4` FOREIGN KEY (`evento`) REFERENCES `evento` (`id_evento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  ADD CONSTRAINT `messaggio_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messaggio_ibfk_2` FOREIGN KEY (`evento`) REFERENCES `evento` (`id_evento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `preferisce`
--
ALTER TABLE `preferisce`
  ADD CONSTRAINT `preferisce_ibfk_3` FOREIGN KEY (`utente`) REFERENCES `utente` (`id_utente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `preferisce_ibfk_4` FOREIGN KEY (`evento`) REFERENCES `evento` (`id_evento`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
