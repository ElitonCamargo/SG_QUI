-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 14/04/2024 às 19:47
-- Versão do servidor: 8.0.30
-- Versão do PHP: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sg_qui`
--

DELIMITER $$
--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getIdElementoBySimb` (`simbolo` VARCHAR(5)) RETURNS TINYINT UNSIGNED NO SQL RETURN (SELECT elemento.id FROM elemento WHERE elemento.simbolo = simbolo)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int UNSIGNED NOT NULL,
  `cnpj_cpf` bigint DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` json DEFAULT NULL,
  `telefone` json DEFAULT NULL,
  `endereco` json DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `tipo_cliente` varchar(20) DEFAULT NULL,
  `status_cliente` varchar(20) DEFAULT NULL,
  `observacoes` text,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `composto_elemento`
--

CREATE TABLE `composto_elemento` (
  `composto` int UNSIGNED NOT NULL,
  `elemento` tinyint UNSIGNED NOT NULL,
  `quant` int UNSIGNED DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `composto_elemento`
--

INSERT INTO `composto_elemento` (`composto`, `elemento`, `quant`, `createdAt`, `updatedAt`) VALUES
(30, 1, 20, '2024-04-11 20:23:40', '2024-04-14 16:37:23'),
(30, 6, 17, '2024-04-11 20:23:40', '2024-04-11 20:23:40'),
(30, 7, 1, '2024-04-11 20:23:40', '2024-04-11 20:23:40'),
(30, 8, 2, '2024-04-11 20:23:40', '2024-04-11 20:23:40'),
(30, 26, 3, '2024-04-11 20:23:40', '2024-04-11 20:23:40'),
(31, 1, 27, '2024-04-11 20:26:12', '2024-04-11 20:26:12'),
(31, 6, 17, '2024-04-11 20:26:12', '2024-04-11 20:26:12'),
(31, 7, 1, '2024-04-11 20:26:12', '2024-04-11 20:26:12'),
(31, 8, 2, '2024-04-11 20:26:12', '2024-04-11 20:26:12'),
(32, 1, 2, '2024-04-12 14:43:35', '2024-04-12 14:43:35'),
(32, 8, 1, '2024-04-12 14:43:35', '2024-04-12 14:43:35'),
(32, 26, 3, '2024-04-12 14:43:35', '2024-04-12 14:43:35'),
(35, 1, 2, '2024-04-14 12:48:59', '2024-04-14 12:48:59'),
(35, 6, 1, '2024-04-14 12:48:59', '2024-04-14 12:48:59'),
(35, 8, 3, '2024-04-14 12:48:59', '2024-04-14 12:48:59'),
(35, 10, 4, '2024-04-14 12:48:59', '2024-04-14 12:48:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `composto_qui`
--

CREATE TABLE `composto_qui` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `formula` varchar(50) DEFAULT NULL,
  `cas_number` varchar(50) DEFAULT NULL,
  `densidade` double(10,4) DEFAULT NULL,
  `fusao` double(10,4) DEFAULT NULL,
  `ebulicao` double(10,4) DEFAULT NULL,
  `massa_molar` double(10,4) DEFAULT NULL,
  `estrutura_molecular` varchar(50) DEFAULT NULL,
  `classificacao` varchar(50) DEFAULT NULL,
  `descricao` text,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `composto_qui`
--

INSERT INTO `composto_qui` (`id`, `nome`, `formula`, `cas_number`, `densidade`, `fusao`, `ebulicao`, `massa_molar`, `estrutura_molecular`, `classificacao`, `descricao`, `createdAt`, `updatedAt`) VALUES
(1, 'Pentóxido de Fósforo', 'P2O5', '1314-56-3', 2.3900, 340.4000, 360.1000, 141.9400, ' P(=O)OP(=O)O', 'Óxido', 'O pentóxido de fósforo é um composto químico sólido branco, altamente higroscópico e solúvel em água, formando ácido fosfórico. É utilizado principalmente como agente desidratante e agente de condensação em síntese orgânica. Também é um constituinte importante de fertilizantes e outros produtos químicos.', '2024-04-01 18:41:42', '2024-04-01 18:41:42'),
(15, '15', '16', '15', 16.0000, 19.0000, 17.0000, 15.0000, '15', '15', '15', '2024-04-10 20:11:43', '2024-04-10 23:39:32'),
(30, '4', 'C17H27NO2Fe3', '2', 2.0000, 2.0000, 2.0000, 2.0000, '2', '2', '2', '2024-04-11 20:23:40', '2024-04-11 20:23:40'),
(31, '3', 'C17H27NO2', '24', 2.0000, 2.0000, 2.0000, 2.0000, '2', '2', '2', '2024-04-11 20:26:12', '2024-04-11 20:26:12'),
(32, '36', 'H2O1Fe3', '246', 2.0000, 2.0000, 2.0000, 2.0000, '2', '2', '2', '2024-04-12 14:43:35', '2024-04-12 14:43:35'),
(33, 'Ácido metanoico Tec', 'CH2O3Ne3', '24644', 2.0000, 2.0000, 2.0000, 2.0000, '2', '2', '2', '2024-04-14 12:47:31', '2024-04-14 12:47:31'),
(35, 'Ácido metanoico Tec2', 'CH2O3Ne4', '246442', 2.0000, 2.0000, 2.0000, 2.0000, '2', '2', '2', '2024-04-14 12:48:59', '2024-04-14 12:48:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracao`
--

CREATE TABLE `configuracao` (
  `projeto_status` json DEFAULT NULL,
  `materiaP_grupos` json DEFAULT NULL,
  `cliente_status` json DEFAULT NULL,
  `cliente_tipo` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `elemento`
--

CREATE TABLE `elemento` (
  `id` tinyint UNSIGNED NOT NULL,
  `simbolo` char(3) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `numero_atomico` int DEFAULT NULL,
  `massa_atomica` decimal(10,6) DEFAULT NULL,
  `grupo` int UNSIGNED DEFAULT NULL,
  `periodo` int UNSIGNED DEFAULT NULL,
  `ponto_de_fusao` decimal(10,6) DEFAULT NULL,
  `ponto_de_ebulicao` decimal(10,6) DEFAULT NULL,
  `densidade` decimal(10,8) DEFAULT NULL,
  `estado_padrao` varchar(20) DEFAULT NULL,
  `configuracao_eletronica` varchar(50) DEFAULT NULL,
  `propriedades` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `elemento`
--

INSERT INTO `elemento` (`id`, `simbolo`, `nome`, `numero_atomico`, `massa_atomica`, `grupo`, `periodo`, `ponto_de_fusao`, `ponto_de_ebulicao`, `densidade`, `estado_padrao`, `configuracao_eletronica`, `propriedades`) VALUES
(1, 'H', 'Hidrogênio', 1, 1.008000, 1, 1, -259.140000, -252.870000, 0.08990000, 'Gasoso', '1s¹', 'Não metal'),
(2, 'He', 'Hélio', 2, 4.002600, 18, 1, -272.200000, -268.930000, 0.17860000, 'Gasoso', '1s²', 'Gás nobre'),
(3, 'Li', 'Lítio', 3, 6.940000, 1, 2, 180.540000, 1342.000000, 0.53000000, 'Sólido', '[He] 2s¹', 'Metal alcalino'),
(4, 'Be', 'Berílio', 4, 9.012200, 2, 2, 1278.000000, 2970.000000, 1.85000000, 'Sólido', '[He] 2s²', 'Metal alcalino-terroso'),
(5, 'B', 'Boro', 5, 10.810000, 13, 2, 2076.000000, 3927.000000, 2.34000000, 'Sólido', '[He] 2s² 2p¹', 'Semimetal'),
(6, 'C', 'Carbono', 6, 12.011000, 14, 2, 3550.000000, 4827.000000, 2.26700000, 'Sólido', '[He] 2s² 2p²', 'Não metal'),
(7, 'N', 'Nitrogênio', 7, 14.007000, 15, 2, -209.860000, -195.790000, 0.00125000, 'Gasoso', '[He] 2s² 2p³', 'Não metal'),
(8, 'O', 'Oxigênio', 8, 15.999000, 16, 2, -218.790000, -182.960000, 0.00143000, 'Gasoso', '[He] 2s² 2p⁴', 'Não metal'),
(9, 'F', 'Flúor', 9, 18.998000, 17, 2, -219.670000, -188.120000, 0.00170000, 'Gasoso', '[He] 2s² 2p⁵', 'Halogênio'),
(10, 'Ne', 'Neônio', 10, 20.180000, 18, 2, -248.590000, -246.080000, 0.00090000, 'Gasoso', '[He] 2s² 2p⁶', 'Gás nobre'),
(11, 'Na', 'Sódio', 11, 22.990000, 1, 3, 97.720000, 883.000000, 0.97000000, 'Sólido', '[Ne] 3s¹', 'Metal alcalino'),
(12, 'Mg', 'Magnésio', 12, 24.305000, 2, 3, 650.000000, 1090.000000, 1.74000000, 'Sólido', '[Ne] 3s²', 'Metal alcalino-terroso'),
(13, 'Al', 'Alumínio', 13, 26.982000, 13, 3, 660.320000, 2519.000000, 2.70000000, 'Sólido', '[Ne] 3s² 3p¹', 'Metal'),
(14, 'Si', 'Silício', 14, 28.085000, 14, 3, 1414.000000, 3265.000000, 2.33000000, 'Sólido', '[Ne] 3s² 3p²', 'Semimetal'),
(15, 'P', 'Fósforo', 15, 30.974000, 15, 3, 44.150000, 280.500000, 1.82300000, 'Sólido', '[Ne] 3s² 3p³', 'Não metal'),
(16, 'S', 'Enxofre', 16, 32.060000, 16, 3, 115.210000, 444.720000, 2.06700000, 'Sólido', '[Ne] 3s² 3p⁴', 'Não metal'),
(17, 'Cl', 'Cloro', 17, 35.450000, 17, 3, -100.980000, -34.600000, 0.00320000, 'Gasoso', '[Ne] 3s² 3p⁵', 'Halogênio'),
(18, 'Ar', 'Argônio', 18, 39.948000, 18, 3, -189.360000, -185.860000, 0.00170000, 'Gasoso', '[Ne] 3s² 3p⁶', 'Gás nobre'),
(19, 'K', 'Potássio', 19, 39.098000, 1, 4, 63.380000, 759.900000, 0.89000000, 'Sólido', '[Ar] 4s¹', 'Metal alcalino'),
(20, 'Ca', 'Cálcio', 20, 40.078000, 2, 4, 839.000000, 1484.000000, 1.55000000, 'Sólido', '[Ar] 4s²', 'Metal alcalino-terroso'),
(21, 'Sc', 'Escândio', 21, 44.956000, 3, 4, 1539.000000, 2832.000000, 2.99000000, 'Sólido', '[Ar] 3d¹ 4s²', 'Metal de transição'),
(22, 'Ti', 'Titânio', 22, 47.867000, 4, 4, 1668.000000, 3287.000000, 4.50700000, 'Sólido', '[Ar] 3d² 4s²', 'Metal de transição'),
(23, 'V', 'Vanádio', 23, 50.942000, 5, 4, 1910.000000, 3407.000000, 6.11000000, 'Sólido', '[Ar] 3d³ 4s²', 'Metal de transição'),
(24, 'Cr', 'Cromo', 24, 51.996000, 6, 4, 1907.000000, 2672.000000, 7.15000000, 'Sólido', '[Ar] 3d⁵ 4s¹', 'Metal de transição'),
(25, 'Mn', 'Manganês', 25, 54.938000, 7, 4, 1246.000000, 2061.000000, 7.44000000, 'Sólido', '[Ar] 3d⁵ 4s²', 'Metal de transição'),
(26, 'Fe', 'Ferro', 26, 55.845000, 8, 4, 1538.000000, 2862.000000, 7.87000000, 'Sólido', '[Ar] 3d⁶ 4s²', 'Metal de transição'),
(27, 'Co', 'Cobalto', 27, 58.933000, 9, 4, 1495.000000, 2927.000000, 8.90000000, 'Sólido', '[Ar] 3d⁷ 4s²', 'Metal de transição'),
(28, 'Ni', 'Níquel', 28, 58.693000, 10, 4, 1455.000000, 2913.000000, 8.90000000, 'Sólido', '[Ar] 3d⁸ 4s²', 'Metal de transição'),
(29, 'Cu', 'Cobre', 29, 63.546000, 11, 4, 1084.620000, 2562.000000, 8.96000000, 'Sólido', '[Ar] 3d¹⁰ 4s¹', 'Metal de transição'),
(30, 'Zn', 'Zinco', 30, 65.380000, 12, 4, 419.530000, 907.000000, 7.14000000, 'Sólido', '[Ar] 3d¹⁰ 4s²', 'Metal de transição'),
(31, 'Ga', 'Gálio', 31, 69.723000, 13, 4, 29.760000, 2204.000000, 5.91000000, 'Sólido', '[Ar] 3d¹⁰ 4s² 4p¹', 'Metal'),
(32, 'Ge', 'Germanio', 32, 72.630000, 14, 4, 938.250000, 2830.000000, 5.32000000, 'Sólido', '[Ar] 3d¹⁰ 4s² 4p²', 'Semimetal'),
(33, 'As', 'Arsênio', 33, 74.922000, 15, 4, 817.000000, 613.000000, 5.73000000, 'Sólido', '[Ar] 3d¹⁰ 4s² 4p³', 'Semimetal'),
(34, 'Se', 'Selênio', 34, 78.971000, 16, 4, 221.000000, 685.000000, 4.81000000, 'Sólido', '[Ar] 3d¹⁰ 4s² 4p⁴', 'Não metal'),
(35, 'Br', 'Bromo', 35, 79.904000, 17, 4, -7.200000, 58.780000, 3.12000000, 'Líquido', '[Ar] 3d¹⁰ 4s² 4p⁵', 'Halogênio'),
(36, 'Kr', 'Criptônio', 36, 83.798000, 18, 4, -157.370000, -153.220000, 0.00375000, 'Gasoso', '[Ar] 3d¹⁰ 4s² 4p⁶', 'Gás nobre'),
(37, 'Rb', 'Rubídio', 37, 85.468000, 1, 5, 38.890000, 688.000000, 1.53200000, 'Sólido', '[Kr] 5s¹', 'Metal alcalino'),
(38, 'Sr', 'Estrôncio', 38, 87.620000, 2, 5, 769.000000, 1384.000000, 2.64000000, 'Sólido', '[Kr] 5s²', 'Metal alcalino-terroso'),
(39, 'Y', 'Ítrio', 39, 88.906000, 3, 5, 1522.000000, 3345.000000, 4.47000000, 'Sólido', '[Kr] 4d¹ 5s²', 'Metal de transição'),
(40, 'Zr', 'Zircônio', 40, 91.224000, 4, 5, 1852.000000, 4377.000000, 6.52000000, 'Sólido', '[Kr] 4d² 5s²', 'Metal de transição'),
(41, 'Nb', 'Nióbio', 41, 92.906000, 5, 5, 2477.000000, 4744.000000, 8.57000000, 'Sólido', '[Kr] 4d⁴ 5s¹', 'Metal de transição'),
(42, 'Mo', 'Molibdênio', 42, 95.950000, 6, 5, 2623.000000, 4639.000000, 10.22000000, 'Sólido', '[Kr] 4d⁵ 5s¹', 'Metal de transição'),
(43, 'Tc', 'Tecnécio', 43, 98.000000, 7, 5, 2157.000000, 4265.000000, 11.00000000, 'Sólido', '[Kr] 4d⁵ 5s²', 'Metal de transição'),
(44, 'Ru', 'Rutênio', 44, 101.070000, 8, 5, 2334.000000, 4150.000000, 12.41000000, 'Sólido', '[Kr] 4d⁷ 5s¹', 'Metal de transição'),
(45, 'Rh', 'Ródio', 45, 102.910000, 9, 5, 1964.000000, 3695.000000, 12.41000000, 'Sólido', '[Kr] 4d⁸ 5s¹', 'Metal de transição'),
(46, 'Pd', 'Paládio', 46, 106.420000, 10, 5, 1552.000000, 2927.000000, 12.02000000, 'Sólido', '[Kr] 4d¹⁰', 'Metal de transição'),
(47, 'Ag', 'Prata', 47, 107.870000, 11, 5, 961.780000, 2162.000000, 10.49000000, 'Sólido', '[Kr] 4d¹⁰ 5s¹', 'Metal de transição'),
(48, 'Cd', 'Cádmio', 48, 112.410000, 12, 5, 321.070000, 767.000000, 8.65000000, 'Sólido', '[Kr] 4d¹⁰ 5s²', 'Metal de transição'),
(49, 'In', 'Índio', 49, 114.820000, 13, 5, 156.600000, 2072.000000, 7.31000000, 'Sólido', '[Kr] 4d¹⁰ 5s² 5p¹', 'Metal'),
(50, 'Sn', 'Estanho', 50, 118.710000, 14, 5, 231.930000, 2602.000000, 7.31000000, 'Sólido', '[Kr] 4d¹⁰ 5s² 5p²', 'Metal'),
(51, 'Sb', 'Antimônio', 51, 121.760000, 15, 5, 630.630000, 1587.000000, 6.68000000, 'Sólido', '[Kr] 4d¹⁰ 5s² 5p³', 'Semimetal'),
(52, 'Te', 'Telúrio', 52, 127.600000, 16, 5, 449.510000, 988.000000, 6.24000000, 'Sólido', '[Kr] 4d¹⁰ 5s² 5p⁴', 'Semimetal'),
(53, 'I', 'Iodo', 53, 126.900000, 17, 5, 113.700000, 184.400000, 4.93000000, 'Sólido', '[Kr] 4d¹⁰ 5s² 5p⁵', 'Halogênio'),
(54, 'Xe', 'Xenônio', 54, 131.290000, 18, 5, -111.790000, -108.120000, 0.00590000, 'Gasoso', '[Kr] 4d¹⁰ 5s² 5p⁶', 'Gás nobre'),
(55, 'Cs', 'Césio', 55, 132.910000, 1, 6, 28.440000, 671.000000, 1.87300000, 'Sólido', '[Xe] 6s¹', 'Metal alcalino'),
(56, 'Ba', 'Bário', 56, 137.330000, 2, 6, 727.000000, 1870.000000, 3.51000000, 'Sólido', '[Xe] 6s²', 'Metal alcalino-terroso'),
(57, 'Ce', 'Cério', 58, 140.120000, 3, 6, 795.000000, 3443.000000, 6.77000000, 'Sólido', '[Xe] 4f¹ 5d¹ 6s²', 'Lantanídeo'),
(58, 'La', 'Lantânio', 57, 138.910000, 3, 6, 920.000000, 3464.000000, 6.15000000, 'Sólido', '[Xe] 5d¹ 6s²', 'Lantanídeo'),
(59, 'Pm', 'Promécio', 61, 145.000000, 3, 6, 1042.000000, 3000.000000, 7.26000000, 'Sólido', '[Xe] 4f⁵ 6s²', 'Lantanídeo'),
(60, 'Hf', 'Háfnio', 72, 178.490000, 4, 6, 2233.000000, 4603.000000, 13.31000000, 'Sólido', '[Xe] 4f¹⁴ 5d² 6s²', 'Metal de transição'),
(61, 'Pr', 'Praseodímio', 59, 140.910000, 3, 6, 931.000000, 3290.000000, 6.77000000, 'Sólido', '[Xe] 4f³ 6s²', 'Lantanídeo'),
(62, 'Nd', 'Neodímio', 60, 144.240000, 3, 6, 1021.000000, 3068.000000, 7.01000000, 'Sólido', '[Xe] 4f⁴ 6s²', 'Lantanídeo'),
(63, 'Ta', 'Tântalo', 73, 180.950000, 5, 6, 3017.000000, 5458.000000, 16.65000000, 'Sólido', '[Xe] 4f¹⁴ 5d³ 6s²', 'Metal de transição'),
(64, 'W', 'Tungstênio', 74, 183.840000, 6, 6, 3422.000000, 5555.000000, 19.25000000, 'Sólido', '[Xe] 4f¹⁴ 5d⁴ 6s²', 'Metal de transição'),
(65, 'Re', 'Rênio', 75, 186.210000, 7, 6, 3186.000000, 5627.000000, 21.02000000, 'Sólido', '[Xe] 4f¹⁴ 5d⁵ 6s²', 'Metal de transição'),
(66, 'Sm', 'Samário', 62, 150.360000, 3, 6, 1072.000000, 1794.000000, 7.52000000, 'Sólido', '[Xe] 4f⁶ 6s²', 'Lantanídeo'),
(67, 'Eu', 'Európio', 63, 151.960000, 3, 6, 822.000000, 1597.000000, 5.24000000, 'Sólido', '[Xe] 4f⁷ 6s²', 'Lantanídeo'),
(68, 'Os', 'Ósmio', 76, 190.230000, 8, 6, 3033.000000, 5012.000000, 22.59000000, 'Sólido', '[Xe] 4f¹⁴ 5d⁶ 6s²', 'Metal de transição'),
(69, 'Gd', 'Gadolínio', 64, 157.250000, 3, 6, 1311.000000, 3233.000000, 7.90000000, 'Sólido', '[Xe] 4f⁷ 5d¹ 6s²', 'Lantanídeo'),
(70, 'Ir', 'Irídio', 77, 192.220000, 9, 6, 2739.000000, 4701.000000, 22.65000000, 'Sólido', '[Xe] 4f¹⁴ 5d⁷ 6s²', 'Metal de transição'),
(71, 'Pt', 'Platina', 78, 195.080000, 10, 6, 2041.400000, 4098.000000, 21.45000000, 'Sólido', '[Xe] 4f¹⁴ 5d⁹ 6s¹', 'Metal de transição'),
(72, 'Tb', 'Térbio', 65, 158.930000, 3, 6, 1356.000000, 3123.000000, 8.23000000, 'Sólido', '[Xe] 4f⁹ 6s²', 'Lantanídeo'),
(73, 'Au', 'Ouro', 79, 196.970000, 11, 6, 1064.180000, 2856.000000, 19.32000000, 'Sólido', '[Xe] 4f¹⁴ 5d¹⁰ 6s¹', 'Metal de transição'),
(74, 'Dy', 'Disprósio', 66, 162.500000, 3, 6, 1412.000000, 2567.000000, 8.55000000, 'Sólido', '[Xe] 4f¹⁰ 6s²', 'Lantanídeo'),
(75, 'Hg', 'Mercúrio', 80, 200.590000, 12, 6, -38.830000, 356.730000, 13.53000000, 'Líquido', '[Xe] 4f¹⁴ 5d¹⁰ 6s²', 'Metal de transição'),
(76, 'Ho', 'Hólmio', 67, 164.930000, 3, 6, 1474.000000, 2720.000000, 8.79000000, 'Sólido', '[Xe] 4f¹¹ 6s²', 'Lantanídeo'),
(77, 'Er', 'Érbio', 68, 167.260000, 3, 6, 1522.000000, 2510.000000, 9.07000000, 'Sólido', '[Xe] 4f¹² 6s²', 'Lantanídeo'),
(78, 'Tl', 'Tálio', 81, 204.380000, 13, 6, 304.000000, 1473.000000, 11.85000000, 'Sólido', '[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p¹', 'Metal'),
(79, 'Pb', 'Chumbo', 82, 207.200000, 14, 6, 327.500000, 1749.000000, 11.34000000, 'Sólido', '[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p²', 'Metal'),
(80, 'Tm', 'Túlio', 69, 168.930000, 3, 6, 1545.000000, 1727.000000, 9.32000000, 'Sólido', '[Xe] 4f¹³ 6s²', 'Lantanídeo'),
(81, 'Bi', 'Bismuto', 83, 208.980000, 15, 6, 271.300000, 1564.000000, 9.78000000, 'Sólido', '[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p³', 'Metal'),
(82, 'Yb', 'Itérbio', 70, 173.050000, 3, 6, 819.000000, 1196.000000, 6.90000000, 'Sólido', '[Xe] 4f¹⁴ 6s²', 'Lantanídeo'),
(83, 'Lu', 'Lutécio', 71, 174.970000, 3, 6, 1663.000000, 3402.000000, 9.84000000, 'Sólido', '[Xe] 4f¹⁴ 5d¹ 6s²', 'Lantanídeo'),
(84, 'Po', 'Polônio', 84, 209.000000, 16, 6, 254.000000, 962.000000, 9.20000000, 'Sólido', '[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p⁴', 'Semimetal'),
(85, 'At', 'Ástato', 85, 210.000000, 17, 6, 302.000000, 337.000000, 7.00000000, 'Sólido', '[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p⁵', 'Halogênio'),
(86, 'Rn', 'Radônio', 86, 222.000000, 18, 6, -71.000000, -61.700000, 0.00973000, 'Gasoso', '[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p⁶', 'Gás nobre'),
(87, 'Fr', 'Frâncio', 87, 223.000000, 1, 7, 27.000000, 677.000000, 1.87000000, 'Sólido', '[Rn] 7s¹', 'Metal alcalino'),
(88, 'Ra', 'Rádio', 88, 226.000000, 2, 7, 700.000000, 1737.000000, 5.00000000, 'Sólido', '[Rn] 7s²', 'Metal alcalino-terroso'),
(89, 'Ac', 'Actínio', 89, 227.000000, 3, 7, 1050.000000, 3200.000000, 10.07000000, 'Sólido', '[Rn] 6d¹ 7s²', 'Actinídeo'),
(90, 'Am', 'Amerício', 95, 243.000000, 13, 7, 1176.000000, 2011.000000, 13.67000000, 'Sólido', '[Rn] 5f⁷ 7s²', 'Actinídeo'),
(91, 'Bk', 'Berquélio', 97, 247.000000, NULL, 7, 1323.000000, 2627.000000, 14.78000000, 'Sólido', '[Rn] 5f⁹ 7s²', 'Actinídeo'),
(92, 'Cf', 'Califórnio', 98, 251.000000, NULL, 7, 1173.000000, NULL, 15.10000000, 'Sólido', '[Rn] 5f¹⁰ 7s²', 'Actinídeo'),
(93, 'Cm', 'Cúrio', 96, 247.000000, NULL, 7, 1345.000000, NULL, 13.51000000, 'Sólido', '[Rn] 5f⁸ 7s²', 'Actinídeo'),
(94, 'Es', 'Einstênio', 99, 252.000000, NULL, 7, 883.000000, NULL, 8.84000000, 'Sólido', '[Rn] 5f¹¹ 7s²', 'Actinídeo'),
(95, 'Fm', 'Férmio', 100, 257.000000, NULL, 7, 1527.000000, NULL, NULL, 'Sólido', '[Rn] 5f¹² 7s²', 'Actinídeo'),
(96, 'Lr', 'Laurêncio', 103, 266.000000, NULL, 7, 1627.000000, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 7s²', 'Actinídeo'),
(97, 'Md', 'Mendelévio', 101, 258.000000, NULL, 7, 1100.000000, NULL, NULL, 'Sólido', '[Rn] 5f¹³ 7s²', 'Actinídeo'),
(98, 'No', 'Nobélio', 102, 259.000000, NULL, 7, 827.000000, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 7s² 7p¹', 'Actinídeo'),
(99, 'Np', 'Neptúnio', 93, 237.000000, NULL, 7, 640.000000, 3900.000000, 20.45000000, 'Sólido', '[Rn] 5f⁴ 6d¹ 7s²', 'Actinídeo'),
(100, 'Pa', 'Protactínio', 91, 231.036000, NULL, 7, 1841.000000, 4300.000000, 15.37000000, 'Sólido', '[Rn] 5f² 6d¹ 7s²', 'Actinídeo'),
(101, 'Pu', 'Plutônio', 94, 244.000000, NULL, 7, 640.000000, 3235.000000, 19.86000000, 'Sólido', '[Rn] 5f⁶ 7s²', 'Actinídeo'),
(102, 'Th', 'Tório', 90, 232.038000, NULL, 7, 1750.000000, 4820.000000, 11.72000000, 'Sólido', '[Rn] 6d² 7s²', 'Actinídeo'),
(103, 'U', 'Urânio', 92, 238.029000, NULL, 7, 1132.200000, 4131.000000, 19.05000000, 'Sólido', '[Rn] 5f³ 6d¹ 7s²', 'Actinídeo'),
(104, 'Rf', 'Rutherfórdio', 104, 267.000000, 4, 7, 2100.000000, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d² 7s²', 'Metal de transição'),
(105, 'Db', 'Dúbnio', 105, 268.000000, 5, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d³ 7s²', 'Metal de transição'),
(106, 'Sg', 'Seabórgio', 106, 269.000000, 6, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d⁴ 7s²', 'Metal de transição'),
(107, 'Bh', 'Bório', 107, 270.000000, 7, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d⁵ 7s²', 'Metal de transição'),
(108, 'Hs', 'Hássio', 108, 277.000000, 8, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d⁶ 7s²', 'Metal de transição'),
(109, 'Mt', 'Meitnério', 109, 278.000000, 9, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d⁷ 7s²', 'Metal de transição'),
(110, 'Ds', 'Darmstádio', 110, 281.000000, 10, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d⁹ 7s²', 'Metal de transição'),
(111, 'Rg', 'Roentgênio', 111, 282.000000, 11, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s²', 'Metal de transição'),
(112, 'Cn', 'Copernício', 112, 285.000000, 12, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p¹', 'Metal de transição'),
(113, 'Nh', 'Nihônio', 113, 286.000000, 13, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p²', 'Metal de transição'),
(114, 'Fl', 'Fleróvio', 114, 289.000000, 14, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p³', 'Metal de transição'),
(115, 'Mc', 'Moscóvio', 115, 290.000000, 15, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p⁴', 'Metal de transição'),
(116, 'Lv', 'Livermório', 116, 293.000000, 16, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p⁵', 'Metal de transição'),
(117, 'Ts', 'Tenessino', 117, 294.000000, 17, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p⁶', 'Metal de transição'),
(118, 'Og', 'Oganessônio', 118, 294.000000, 18, 7, NULL, NULL, NULL, 'Sólido', '[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p⁶', 'Desconhecido');

-- --------------------------------------------------------

--
-- Estrutura para tabela `garantia`
--

CREATE TABLE `garantia` (
  `id` int UNSIGNED NOT NULL,
  `fk_Materia_prima_id` int UNSIGNED DEFAULT NULL,
  `fk_Composto_QUI_id` int UNSIGNED DEFAULT NULL,
  `percentual` decimal(10,4) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materia_prima`
--

CREATE TABLE `materia_prima` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `densidade` double(10,5) DEFAULT NULL,
  `descricao` text,
  `grupo` varchar(50) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto`
--

CREATE TABLE `projeto` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `descricao` text,
  `data_inicio` date DEFAULT NULL,
  `data_termino` date DEFAULT NULL,
  `status` json DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto_materia_p`
--

CREATE TABLE `projeto_materia_p` (
  `id` int UNSIGNED NOT NULL,
  `fk_Projeto_id` int UNSIGNED DEFAULT NULL,
  `fk_Materia_prima_id` int UNSIGNED DEFAULT NULL,
  `ordem` tinyint DEFAULT NULL,
  `percentual` double(10,5) DEFAULT NULL,
  `tempo_agitacao` int DEFAULT NULL,
  `obs` text,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `permissao` tinyint DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `permissao`, `avatar`, `status`, `createdAt`, `updatedAt`) VALUES
(3, 'Eliton Camargo de Oliveira', 'camargoliveira@gmail.com', '$2y$12$agy8ZOa9TkrhSa1Thpd5A.zajqvtMe75EE7mKwqHjrG1hTrGr6NU2', 0, 'https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png', 1, '2024-04-03 13:08:34', '2024-04-03 13:08:34'),
(5, 'Eliton Camargo de Oliveira', 'camargoliveaira@gmail.com', '$2y$12$FD2tA.18AujxASp3Wwnb5.EkUHcDn9f9Y4Z9BUzZ4AGE93gpkzaey', 0, 'https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png', 1, '2024-04-03 13:13:41', '2024-04-03 13:13:41');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj_cpf` (`cnpj_cpf`);

--
-- Índices de tabela `composto_elemento`
--
ALTER TABLE `composto_elemento`
  ADD PRIMARY KEY (`composto`,`elemento`),
  ADD KEY `elemento` (`elemento`),
  ADD KEY `elemento_2` (`elemento`),
  ADD KEY `composto` (`composto`,`elemento`),
  ADD KEY `composto_2` (`composto`,`elemento`);

--
-- Índices de tabela `composto_qui`
--
ALTER TABLE `composto_qui`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `formula` (`formula`,`cas_number`);

--
-- Índices de tabela `elemento`
--
ALTER TABLE `elemento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `simbolo` (`simbolo`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `garantia`
--
ALTER TABLE `garantia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Garantia_2` (`fk_Materia_prima_id`),
  ADD KEY `FK_Garantia_3` (`fk_Composto_QUI_id`);

--
-- Índices de tabela `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `projeto_materia_p`
--
ALTER TABLE `projeto_materia_p`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_Projeto_id` (`fk_Projeto_id`,`fk_Materia_prima_id`),
  ADD KEY `FK_Projeto_materia_p_5` (`fk_Materia_prima_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `composto_qui`
--
ALTER TABLE `composto_qui`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `elemento`
--
ALTER TABLE `elemento`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de tabela `garantia`
--
ALTER TABLE `garantia`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `projeto_materia_p`
--
ALTER TABLE `projeto_materia_p`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `composto_elemento`
--
ALTER TABLE `composto_elemento`
  ADD CONSTRAINT `composto_elemento_ibfk_1` FOREIGN KEY (`elemento`) REFERENCES `elemento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `composto_elemento_ibfk_2` FOREIGN KEY (`composto`) REFERENCES `composto_qui` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `garantia`
--
ALTER TABLE `garantia`
  ADD CONSTRAINT `FK_Garantia_2` FOREIGN KEY (`fk_Materia_prima_id`) REFERENCES `materia_prima` (`id`),
  ADD CONSTRAINT `FK_Garantia_3` FOREIGN KEY (`fk_Composto_QUI_id`) REFERENCES `composto_qui` (`id`);

--
-- Restrições para tabelas `projeto_materia_p`
--
ALTER TABLE `projeto_materia_p`
  ADD CONSTRAINT `FK_Projeto_materia_p_1` FOREIGN KEY (`fk_Projeto_id`) REFERENCES `projeto` (`id`),
  ADD CONSTRAINT `FK_Projeto_materia_p_5` FOREIGN KEY (`fk_Materia_prima_id`) REFERENCES `materia_prima` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
