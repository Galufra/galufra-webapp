-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Ago 21, 2012 alle 17:48
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
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  PRIMARY KEY (`utente`,`evento`),
  KEY `evento` (`evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `consiglia`
--

INSERT INTO `consiglia` (`utente`, `evento`, `lat`, `lon`) VALUES
(67, 3, 42.3508415222168, 13.398554801940918),
(67, 224, 42.3525448, 13.402602099999967);

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
  `annuncio` text CHARACTER SET latin1 COLLATE latin1_bin,
  PRIMARY KEY (`id_evento`),
  UNIQUE KEY `nome` (`nome`,`data`),
  KEY `id_gestore` (`id_gestore`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=237 ;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`id_evento`, `nome`, `descrizione`, `data`, `n_visite`, `n_iscritti`, `lat`, `lon`, `id_gestore`, `consigliato`, `annuncio`) VALUES
(3, 'prova1', 'Prova :)\r\nQuesto evento si svolge a piazza Palazzo, 67100 L''Aquila.\r\nLorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2012-11-29 00:00:00', 0, 0, 42.3508415222168, 13.398554801940918, 1, 1, NULL),
(172, 'festa', 'kjljpoj!!!! tutti quiii!!!', '2012-08-25 00:00:00', 0, 0, 42.4199096, 14.290051800000015, 63, 0, NULL),
(224, 'prova 2', 'Arrosticini,Musica,Birra e tanto divertimento!!!!!', '2012-08-31 00:00:00', 0, 0, 42.3525448, 13.402602099999967, 67, 0, 0x76656e69746520696e2074616e7469212121),
(228, 'prova 3', 'serata latino americano. ingresso gratuito!', '2012-08-27 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, ''),
(229, 'prova 4', 'cena sociale. Società Regatti! 10 euro persona', '2012-08-27 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, ''),
(230, 'febrwnbwy', 'nnoinnpnnpn', '2012-08-27 00:00:00', 0, 0, 42.3525448, 13.402602099999967, 68, 0, ''),
(231, 'òtgmwbmwàb', 'fnvoefvnvbneòbnb', '2012-08-27 00:00:00', 0, 0, 42.4617902, 14.216089799999963, 68, 0, ''),
(232, 'vrevqevtqb', 'vm m slkgr rslò lr', '2012-08-17 00:00:00', 0, 0, 42.4307526, 14.272266100000024, 68, 0, ''),
(233, 'rfvlnevq', 'nlfnvlanvlnvlnvlanvln', '2012-08-27 00:00:00', 0, 0, 42.4199096, 14.290051800000015, 67, 0, ''),
(234, 'festa ', 'tutti in strada!!! ', '2012-08-27 00:00:00', 0, 0, 42.46780220000001, 14.215347400000041, 69, 0, 0x4e657373756e20436f73746f204427696e67726573736f),
(235, 'Prova', 'Prova Lou', '2012-11-27 00:00:00', 0, 0, 42.45109799999999, 13.280823000000055, 12, 0, ''),
(236, 'Subsonica', 'Prova', '2012-08-23 21:30:00', 0, 0, 42.3427972, 13.404649999999947, 67, 0, 0x6369616f);

-- --------------------------------------------------------

--
-- Struttura della tabella `gestisce`
--

CREATE TABLE IF NOT EXISTS `gestisce` (
  `id_user` int(10) NOT NULL,
  `id_evento` int(10) NOT NULL,
  PRIMARY KEY (`id_user`,`id_evento`),
  KEY `id_evento` (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `gestore`
--

CREATE TABLE IF NOT EXISTS `gestore` (
  `id_gestore` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_gestore`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `iscrizioni`
--

CREATE TABLE IF NOT EXISTS `iscrizioni` (
  `utente` int(11) NOT NULL,
  `evento` int(11) NOT NULL,
  PRIMARY KEY (`utente`,`evento`),
  KEY `evento` (`evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `locale`
--

CREATE TABLE IF NOT EXISTS `locale` (
  `id_locale` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(32) NOT NULL,
  `latitudine` varchar(30) DEFAULT NULL,
  `longitudine` varchar(30) DEFAULT NULL,
  `via` varchar(30) NOT NULL,
  `n_civico` int(11) DEFAULT NULL,
  `citta` varchar(30) NOT NULL,
  `CAP` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_locale`),
  UNIQUE KEY `via` (`via`,`citta`,`CAP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggio`
--

CREATE TABLE IF NOT EXISTS `messaggio` (
  `id_mess` int(11) NOT NULL AUTO_INCREMENT,
  `testo` text CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `data` date NOT NULL,
  `evento` int(11) NOT NULL,
  `utente` varchar(30) NOT NULL,
  PRIMARY KEY (`id_mess`),
  KEY `evento` (`evento`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dump dei dati per la tabella `messaggio`
--

INSERT INTO `messaggio` (`id_mess`, `testo`, `data`, `evento`, `utente`) VALUES
(33, 0xc383c2a82066696e697461206c612070616363686961, '2012-08-09', 3, 'teo'),
(68, 0x34357433346733, '2012-08-12', 217, 'teo'),
(69, 0x746867747768, '2012-08-12', 218, 'teo'),
(70, 0x4520636f736120736920666172c383c2a03f3f, '2012-08-13', 234, 'teo'),
(71, 0x6568207369, '2012-08-13', 3, 'simo'),
(72, 0x70726f7661, '2012-08-20', 229, 'luca'),
(73, 0x70726f76610a6466616466736466646173, '2012-08-20', 229, 'luca'),
(74, 0x70726f7661, '2012-08-20', 229, 'luca'),
(75, 0x70726f7661, '2012-08-20', 229, 'luca'),
(76, 0x70726f76610a6466616466736466646173, '2012-08-20', 229, 'luca'),
(77, 0x70726f7661, '2012-08-20', 229, 'luca'),
(78, 0x70726f7661, '2012-08-20', 229, 'luca'),
(79, 0x6369616f, '2012-08-20', 229, 'luca'),
(80, 0x4369616f, '2012-08-20', 230, 'luca'),
(81, 0x50726f7661, '2012-08-20', 230, 'luca');

-- --------------------------------------------------------

--
-- Struttura della tabella `permessi`
--

CREATE TABLE IF NOT EXISTS `permessi` (
  `id` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL,
  `descrizione` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `permessi`
--

INSERT INTO `permessi` (`id`, `nome`, `descrizione`) VALUES
(0, 'amministratore', 'permessi globali'),
(1, 'utente', 'utente semplice. Senza permessi di creare eventi pubblici'),
(10, 'gestore', 'gestore di locali. Possibilità di creare eventi pubblici.');

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
(67, 231),
(67, 236);

-- --------------------------------------------------------

--
-- Struttura della tabella `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `uid` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `citta` varchar(100) NOT NULL DEFAULT 'no-location',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `date` varchar(32) NOT NULL,
  `confirm_id` varchar(32) NOT NULL,
  `sbloccato` tinyint(1) NOT NULL DEFAULT '1',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `superuser` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_utente`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mail` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_utente`, `username`, `password`, `nome`, `cognome`, `email`, `citta`, `confirmed`, `date`, `confirm_id`, `sbloccato`, `admin`, `superuser`) VALUES
(1, 'dir31', 'f89c18242ab927d20216837b65935006', 'francesco', 'miscia', 'fra@fra.com', 'l''Aquila', 1, '0000-00-00 00:00:00', '0', 0, 0, 0),
(12, 'luca', '5f4dcc3b5aa765d61d8327deb882cf99', 'luca', 'Di Stefano', 'fra.miscia@gmail.com', 'l''aquila', 1, '1334824341', '0', 1, 0, 0),
(67, 'teo', 'e827aa1ed78e96a113182dce12143f9f', 'Teodoro', '', 'teo@teo.it', 'l''Aquila', 1, '03/08/2012 - 17:41', 'e68b8f2dde309bb4d10ecbdc862ebab3', 0, 1, 1),
(68, 'simo', '1fe00ab7d8c361b801f7e1fc9d730048', '/', '/', 'simo@simo.com', 'L''Aquila', 1, '13/08/2012 - 12:42', '72ab5ccd2d12f6132d6ff6d2e582c026', 0, 1, 1);

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
-- Limiti per la tabella `gestisce`
--
ALTER TABLE `gestisce`
  ADD CONSTRAINT `gestisce_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utente` (`id_utente`),
  ADD CONSTRAINT `gestisce_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`);

--
-- Limiti per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  ADD CONSTRAINT `messaggio_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `preferisce`
--
ALTER TABLE `preferisce`
  ADD CONSTRAINT `preferisce_ibfk_3` FOREIGN KEY (`utente`) REFERENCES `utente` (`id_utente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `preferisce_ibfk_4` FOREIGN KEY (`evento`) REFERENCES `evento` (`id_evento`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
