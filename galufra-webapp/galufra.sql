-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Ago 22, 2012 alle 20:49
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
(67, 224, 42.3525448, 13.402602099999967),
(67, 231, 42.4617902, 14.216089799999963);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=255 ;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`id_evento`, `nome`, `descrizione`, `data`, `n_visite`, `n_iscritti`, `lat`, `lon`, `id_gestore`, `consigliato`, `annuncio`) VALUES
(3, 'prova1', 'Prova :)\r\nQuesto evento si svolge a piazza Palazzo, 67100 L''Aquila.\r\nLorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2012-11-29 00:00:00', 0, 0, 42.3508415222168, 13.398554801940918, 1, 1, 0x676867320a),
(172, 'festa', 'kjljpoj!!!! tutti quiii!!!', '2012-08-25 00:00:00', 0, 0, 42.4199096, 14.290051800000015, 63, 0, NULL),
(224, 'prova 2', 'Arrosticini,Musica,Birra e tanto divertimento!!!!!', '2012-08-31 00:00:00', 0, 0, 42.3525448, 13.402602099999967, 67, 0, 0x76656e69746520696e2074616e7469212121),
(228, 'prova 3', 'serata latino americano. ingresso gratuito!', '2012-08-27 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, 0x272727272727272727272727),
(229, 'prova 4', 'cena sociale. SocietÃƒÂƒÃ?ÂƒÃƒ?Ã?Â  Regatti! 10 euro persona', '2012-08-27 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, 0x4c276576656e746f),
(230, 'febrwnbwy', 'nnoinnpnnpn', '2012-08-27 00:00:00', 0, 0, 42.3525448, 13.402602099999967, 68, 0, ''),
(231, '&Atilde;&sup2;tgmwbmw&Atilde;&', 'fnvoefvnvbne&Atilde;&sup2;bnb', '2012-08-27 00:00:00', 0, 0, 42.4617902, 14.216089799999963, 68, 0, 0x56656e697465),
(232, 'vrevqevtqb', 'vm m slkgr rslò lr', '2012-08-17 00:00:00', 0, 0, 42.4307526, 14.272266100000024, 68, 0, ''),
(233, 'rfvlnevq', 'nlfnvlanvlnvlnvlanvln', '2012-08-27 00:00:00', 0, 0, 42.4199096, 14.290051800000015, 67, 0, ''),
(234, 'festa ', 'tutti in strada!!! ', '2012-08-27 00:00:00', 0, 0, 42.46780220000001, 14.215347400000041, 69, 0, 0x4e657373756e20436f73746f204427696e67726573736f),
(235, 'prova 5', 'Serata al più spettacolare grattacielo di NYC. Contattare teo@teo.com', '2012-08-30 00:00:00', 0, 0, 40.7484395, -73.9856709, 67, 0, ''),
(236, 'prova 6', '\nprova ', '2012-08-30 00:00:00', 0, 0, 42.3487451, 13.401908700000035, 67, 0, ''),
(238, 'nlanflqnb', '&amp;Atilde;&Acirc;ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?knn&amp;Atilde;&Acirc;ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?n&amp;Atilde;&Acirc;ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?ÂƒÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?ÂƒÃƒÂƒ?Ãƒ?Ã?Âƒ?ÃƒÂƒÃ?ÂƒÃƒ?Ã?Âƒ?ÃƒÂƒÃ?Âƒ?ÃƒÂƒ?Ãƒ?Ã?Âƒ?', '2012-08-16 00:00:00', 0, 0, 42.4617902, 14.216089799999963, 67, 0, 0x27),
(239, 'nljblbljblb', 'mnòlnlnln', '2012-08-30 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, ''),
(240, 'prova 7', 'nflkqnwerfqrf', '2012-08-23 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 67, 0, ''),
(249, 'prova 8', 'prova prova prova prova prova prova prova prova ', '2012-08-18 00:00:00', 0, 0, 42.4199096, 14.290051800000015, 67, 0, ''),
(250, 'asdaa', 'fgavbgrabtBGABTATN', '2012-08-17 00:00:00', 0, 0, 40.7484395, -73.9856709, 67, 0, 0x6c2761696f),
(251, 'sarò party', 'ciaoooooo', '2012-08-31 00:00:00', 0, 0, 42.3527354, 13.401868899999954, 77, 0, ''),
(252, 'aaaaar', ' &quot;&quot; %$£; ', '2012-08-22 19:05:00', 0, 0, 42.3498479, 13.399509099999932, 67, 0, ''),
(253, 'ddddfsw', 'revfgeaqrqbq', '2012-10-22 23:22:00', 0, 0, 42.351636, 13.404050900000016, 77, 0, ''),
(254, 'Ciao L''''Aquila', 'una prova per vedere la data', '2012-12-22 20:44:00', 0, 0, 42.5074019, 14.161013599999933, 67, 0, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggio`
--

CREATE TABLE IF NOT EXISTS `messaggio` (
  `id_mess` int(11) NOT NULL AUTO_INCREMENT,
  `testo` text CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `data` datetime NOT NULL,
  `evento` int(11) NOT NULL,
  `utente` varchar(30) NOT NULL,
  PRIMARY KEY (`id_mess`),
  KEY `evento` (`evento`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Dump dei dati per la tabella `messaggio`
--

INSERT INTO `messaggio` (`id_mess`, `testo`, `data`, `evento`, `utente`) VALUES
(33, 0xc3a82066696e697461206c612070616363686961, '2012-08-09 00:00:00', 3, 'teo'),
(68, 0x34357433346733, '2012-08-12 00:00:00', 217, 'teo'),
(69, 0x746867747768, '2012-08-12 00:00:00', 218, 'teo'),
(70, 0x4520636f736120736920666172c3a03f3f, '2012-08-13 00:00:00', 234, 'teo'),
(71, 0x6568207369, '2012-08-13 00:00:00', 3, 'simo'),
(72, 0x6c27616d69636f, '2012-08-16 00:00:00', 229, 'teo'),
(73, 0x272727272727, '2012-08-17 00:00:00', 228, 'teo'),
(74, 0x27272727272727272727272727272727272727272727272727272727, '2012-08-17 00:00:00', 228, 'teo'),
(75, 0x2727, '2012-08-17 00:00:00', 228, 'teo'),
(76, 0x27, '2012-08-17 00:00:00', 228, 'teo'),
(77, 0x6369616f6f6f6f6f, '2012-08-17 00:00:00', 231, 'teo'),
(78, 0x6369616f, '2012-08-22 00:00:00', 3, 'teo'),
(79, 0x6369616f, '2012-08-22 00:00:00', 3, 'teo'),
(80, 0x64766361667661666562766561, '2012-08-22 00:00:00', 3, 'teo'),
(81, 0x6369616f616f, '2012-08-22 00:00:00', 3, 'teo'),
(82, 0x6c6f6c, '2012-08-22 17:31:30', 3, 'teo'),
(83, 0x2727, '2012-08-22 17:44:38', 3, 'teo'),
(84, 0x27, '2012-08-22 17:44:39', 3, 'teo'),
(85, 0x27272727272727, '2012-08-22 17:44:41', 3, 'teo'),
(86, 0x27272727, '2012-08-22 17:46:24', 3, 'teo'),
(87, 0x27, '2012-08-22 17:46:26', 3, 'teo'),
(88, 0x2727, '2012-08-22 17:46:28', 3, 'teo'),
(89, 0x27272727, '2012-08-22 17:47:49', 3, 'teo'),
(90, 0x27, '2012-08-22 17:47:51', 3, 'teo'),
(91, 0x2727, '2012-08-22 17:55:01', 3, 'teo'),
(92, 0x27272727, '2012-08-22 17:56:15', 3, 'teo'),
(93, 0x272727, '2012-08-22 17:57:45', 3, 'teo'),
(94, 0x2727, '2012-08-22 17:57:47', 3, 'teo'),
(95, 0x27, '2012-08-22 17:57:49', 3, 'teo'),
(96, 0xc3a0, '2012-08-22 18:03:47', 3, 'teo'),
(97, 0xc3a8, '2012-08-22 18:03:50', 3, 'teo'),
(98, 0x7468777468773468, '2012-08-22 18:09:30', 3, 'teo'),
(99, 0x6e6574796a65756a65, '2012-08-22 18:13:05', 238, 'teo'),
(100, 0x2727, '2012-08-22 18:53:18', 238, 'teo'),
(101, 0x27, '2012-08-22 18:53:20', 238, 'teo'),
(102, 0x27272727, '2012-08-22 19:32:41', 238, 'teo'),
(103, 0x27272727, '2012-08-22 19:50:29', 238, 'teo'),
(104, 0x2727, '2012-08-22 19:50:31', 238, 'teo'),
(106, 0x6c27616961, '2012-08-22 20:47:32', 250, 'teo');

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
(77, 231);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_utente`, `username`, `password`, `nome`, `cognome`, `email`, `citta`, `confirmed`, `date`, `confirm_id`, `sbloccato`, `admin`, `superuser`) VALUES
(1, 'dir31', 'f89c18242ab927d20216837b65935006', 'francesco', 'miscia', 'fra@fra.com', 'l''Aquila', 1, '0000-00-00 00:00:00', '0', 0, 0, 0),
(12, 'luca', '594f803b380a41396ed63dca39503542', 'luca', 'Di Stefano', 'fra.miscia@gmail.com', 'l''aquila', 1, '1334824341', '0', 1, 0, 0),
(67, 'teo', 'e827aa1ed78e96a113182dce12143f9f', 'Teodoro', 'Aloisi', 'teo@teo.it', 'l''Aquila', 1, '03/08/2012 - 17:41', 'e68b8f2dde309bb4d10ecbdc862ebab3', 0, 1, 1),
(68, 'simo', '1fe00ab7d8c361b801f7e1fc9d730048', '/', '/', 'simo@simo.com', 'L''Aquila', 1, '13/08/2012 - 12:42', '72ab5ccd2d12f6132d6ff6d2e582c026', 0, 1, 1),
(77, 'luke', 'ff377aff39a9345a9cca803fb5c5c081', 'Luca', 'Marchisi', 'luke@luke.com', 'pescara', 1, '1345141426', '66006486fc55692ff9e07e7a87cf0dea', 1, 0, 0);

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
