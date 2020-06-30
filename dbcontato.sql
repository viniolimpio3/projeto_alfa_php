-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 04-Out-2019 às 21:07
-- Versão do servidor: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcontato`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_faleconosco`
--

DROP TABLE IF EXISTS `tb_faleconosco`;
CREATE TABLE IF NOT EXISTS `tb_faleconosco` (
  `ID_CONTATO` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_CONTATO` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FONE_CONTATO` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EMAIL_CONTATO` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ASSUNTO_CONTATO` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MSG_CONTATO` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `RESP_CONTATO` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`ID_CONTATO`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_faleconosco`
--

INSERT INTO `tb_faleconosco` (`ID_CONTATO`, `NOME_CONTATO`, `FONE_CONTATO`, `EMAIL_CONTATO`, `ASSUNTO_CONTATO`, `MSG_CONTATO`, `RESP_CONTATO`) VALUES
(1, 'Cleiton', '(11)9-8087-8956', 'cleiton.patricio@etec.sp.gov.br', 'Tudo Bem', 'Sugestões', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
