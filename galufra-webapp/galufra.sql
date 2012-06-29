-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Giu 29, 2012 alle 17:41
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
-- Struttura della tabella `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) CHARACTER SET hp8 NOT NULL,
  `descrizione` text CHARACTER SET hp8 NOT NULL,
  `data` date NOT NULL,
  `n_visite` int(11) NOT NULL DEFAULT '0',
  `n_iscritti` int(11) NOT NULL DEFAULT '0',
  `gestore` int(11) NOT NULL,
  `locale` int(11) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  PRIMARY KEY (`id_evento`),
  UNIQUE KEY `nome` (`nome`,`data`),
  KEY `gestore` (`gestore`),
  KEY `locale` (`locale`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`id_evento`, `nome`, `descrizione`, `data`, `n_visite`, `n_iscritti`, `gestore`, `locale`, `lat`, `lon`) VALUES
(3, 'prova1', 'Prova :)\r\nQuesto evento si svolge a piazza Palazzo, 67100 L''Aquila.\r\nLorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2012-06-29', 0, 0, 1, 1, 42.3508415222168, 13.398554801940918),
(5, 'prova 2', 'ciao', '2012-06-30', 0, 0, 1, 1, 42.34904861450195, 13.398882865905762);

-- --------------------------------------------------------

--
-- Struttura della tabella `gestore`
--

CREATE TABLE IF NOT EXISTS `gestore` (
  `id_gestore` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_gestore`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `gestore`
--

INSERT INTO `gestore` (`id_gestore`) VALUES
(1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `locale`
--

INSERT INTO `locale` (`id_locale`, `nome`, `latitudine`, `longitudine`, `via`, `n_civico`, `citta`, `CAP`) VALUES
(1, 'The Example', NULL, NULL, 'Via Fasulla', NULL, 'L''Aquila', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggio`
--

CREATE TABLE IF NOT EXISTS `messaggio` (
  `id_mess` int(11) NOT NULL AUTO_INCREMENT,
  `testo` text NOT NULL,
  `data` date NOT NULL,
  `evento` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  PRIMARY KEY (`id_mess`),
  KEY `evento` (`evento`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(12, 5);

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
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `date` varchar(32) NOT NULL,
  `permessi` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_utente`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mail` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_utente`, `username`, `password`, `nome`, `cognome`, `email`, `citta`, `confirmed`, `date`, `permessi`) VALUES
(1, 'dir31', 'f89c18242ab927d20216837b65935006', 'francesco', 'miscia', 'fra@fra.com', 'no-location', 1, '0000-00-00 00:00:00', 1),
(12, 'luca', '594f803b380a41396ed63dca39503542', 'luca', 'Di Stefano', 'fra.miscia@gmail.com', 'l''aquila', 1, '1334824341', 1);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`gestore`) REFERENCES `gestore` (`id_gestore`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`locale`) REFERENCES `locale` (`id_locale`);

--
-- Limiti per la tabella `preferisce`
--
ALTER TABLE `preferisce`
  ADD CONSTRAINT `preferisce_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`id_utente`),
  ADD CONSTRAINT `preferisce_ibfk_2` FOREIGN KEY (`evento`) REFERENCES `evento` (`id_evento`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
