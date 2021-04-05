-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jul 08, 2015 as 12:16 AM
-- Versão do Servidor: 5.1.53
-- Versão do PHP: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `financeiro_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos_tb`
--

CREATE TABLE IF NOT EXISTS `enderecos_tb` (
  `end_id` int(10) NOT NULL AUTO_INCREMENT,
  `end_usu_id` int(10) NOT NULL,
  `end_descricao` varchar(50) NOT NULL,
  `end_endereco` varchar(50) DEFAULT NULL,
  `end_numero` varchar(10) DEFAULT NULL,
  `end_complemento` varchar(50) DEFAULT NULL,
  `end_bairro` varchar(50) DEFAULT NULL,
  `end_cidade` varchar(50) NOT NULL,
  `end_estado` char(2) NOT NULL,
  `end_cep` int(8) DEFAULT NULL,
  `end_pais` varchar(20) DEFAULT NULL,
  `end_padrao` char(1) DEFAULT NULL,
  `end_ativo` char(1) NOT NULL,
  PRIMARY KEY (`end_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `enderecos_tb`
--

INSERT INTO `enderecos_tb` (`end_id`, `end_usu_id`, `end_descricao`, `end_endereco`, `end_numero`, `end_complemento`, `end_bairro`, `end_cidade`, `end_estado`, `end_cep`, `end_pais`, `end_padrao`, `end_ativo`) VALUES
(1, 1, 'Minha casa padrão', 'Rua qualquer', '100', 'Casa ao lado', 'Jardins', 'Piracicaba', 'SP', 13400853, 'Brasil', 'S', 'S'),
(2, 1, 'Trabalho', 'Aquela rua', '400 fundo', 'Esquina', 'São João', 'São Paulo', 'MG', 12412552, 'EUA', 'S', 'S'),
(3, 1, 'Disney', 'Exterior', '', '', '', 'Orlando', 'FL', 0, 'EUA', 'S', 'S'),
(4, 1, 'Europa', '', '', '', '', 'Diversas Européias', 'EX', 0, '', 'N', 'S'),
(5, 3, 'Minha casa padrão', '', '', '', '', 'Madri', 'EX', 0, 'Espanha', 'S', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais_tb`
--

CREATE TABLE IF NOT EXISTS `locais_tb` (
  `loc_id` int(10) NOT NULL AUTO_INCREMENT,
  `loc_usu_id` int(10) NOT NULL,
  `loc_end_usu` int(10) NOT NULL,
  `loc_descricao` varchar(50) NOT NULL,
  `loc_observacao` varchar(250) DEFAULT NULL,
  `loc_ativo` char(1) NOT NULL,
  `loc_banco` char(1) NOT NULL,
  `loc_universal` char(1) NOT NULL,
  PRIMARY KEY (`loc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `locais_tb`
--

INSERT INTO `locais_tb` (`loc_id`, `loc_usu_id`, `loc_end_usu`, `loc_descricao`, `loc_observacao`, `loc_ativo`, `loc_banco`, `loc_universal`) VALUES
(1, 1, 2, 'Padaria', 'Gastos diários com coisas simples', 'S', 'N', 'N'),
(2, 1, 2, 'Bar', 'Bebidas em geral', 'S', 'N', 'S'),
(3, 1, 1, 'Restaurantes', 'Refeições diárias', 'S', 'N', 'S'),
(4, 1, 1, 'Padaria Jacareí', 'Café da manhã, pães, bolos e doces', 'S', 'N', 'N'),
(5, 1, 1, 'Carteira', 'Dinheiro em mãos', 'S', 'S', 'S'),
(6, 1, 1, 'Conta Poupança 1045 CEF', 'Conta onde cai o salário mensal', 'S', 'S', 'S'),
(7, 1, 1, 'Bradesco 234 online', 'Banco de acesso online', 'S', 'S', ''),
(8, 1, 3, 'Lojas em Orlando/EUA', 'Exterior', 'S', 'N', ''),
(9, 1, 3, 'Restaurante - EUA', 'Alimentação - Exterior', 'S', 'N', ''),
(10, 1, 2, 'Loja Informática', 'Produtos em geral', 'S', 'N', ''),
(11, 3, 5, 'Em mãos', 'Dinheiro na carteira', 'S', 'S', ''),
(12, 3, 5, 'Loja de roupas', 'No shopping', 'S', 'N', ''),
(13, 3, 5, 'Itaú - C/C 020100', 'Conta corrente', 'S', 'S', ''),
(14, 3, 5, 'Kabum', 'Loja online', 'S', 'N', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentos_tb`
--

CREATE TABLE IF NOT EXISTS `movimentos_tb` (
  `mov_id` int(10) NOT NULL AUTO_INCREMENT,
  `mov_usu_id` int(10) NOT NULL,
  `mov_end_usu` int(10) NOT NULL,
  `mov_valor_credito` decimal(8,2) DEFAULT NULL,
  `mov_valor_debito` decimal(8,2) DEFAULT NULL,
  `mov_local_credito` int(10) DEFAULT NULL,
  `mov_local_debito` int(10) DEFAULT NULL,
  `mov_data_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mov_descricao` varchar(200) NOT NULL,
  `mov_tipo` varchar(15) NOT NULL,
  PRIMARY KEY (`mov_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Extraindo dados da tabela `movimentos_tb`
--

INSERT INTO `movimentos_tb` (`mov_id`, `mov_usu_id`, `mov_end_usu`, `mov_valor_credito`, `mov_valor_debito`, `mov_local_credito`, `mov_local_debito`, `mov_data_hora`, `mov_descricao`, `mov_tipo`) VALUES
(1, 1, 1, '500.00', '0.00', 5, 0, '2015-05-05 20:32:21', 'Salário Abril/2015', 'entrada'),
(2, 1, 1, '0.00', '23.00', 0, 5, '2015-05-05 22:14:33', 'Tarifa bancária', 'saida'),
(3, 1, 1, '15.00', '15.00', 3, 5, '2015-05-06 21:18:08', 'Almoço', 'compra'),
(4, 1, 1, '0.00', '1.52', 0, 5, '2015-05-06 21:23:33', 'Tarifa administrativa', 'saida'),
(5, 1, 1, '100.00', '100.00', 6, 5, '2015-05-07 19:40:22', 'Depósito para abatimento de tarifas', 'transferencia'),
(6, 1, 1, '5.25', '5.25', 4, 5, '2015-05-21 20:58:27', 'Pães', 'compra'),
(7, 1, 1, '30.00', '0.00', 6, 0, '2015-05-21 20:59:28', 'Jogo de PS2', 'venda'),
(8, 1, 1, '0.00', '25.50', 0, 6, '2015-05-21 21:00:09', 'Tarifa Bancária', 'saida'),
(9, 1, 1, '144.23', '144.23', 7, 5, '2015-05-27 20:20:43', 'Transferência', 'transferencia'),
(10, 1, 1, '200.00', '0.00', 7, 0, '2015-07-02 19:59:11', '15 CD´s oroginais de música', 'venda'),
(11, 1, 1, '200.00', '200.00', 6, 7, '2015-07-02 19:59:59', 'Simples transferência', 'transferencia'),
(12, 1, 2, '15.00', '15.00', 3, 5, '2015-07-06 19:40:29', 'Almoço', 'compra'),
(13, 1, 3, '20.00', '20.00', 8, 5, '2015-07-07 19:59:24', 'Lembranças', 'compra'),
(14, 1, 3, '25.00', '25.00', 9, 5, '2015-07-07 20:15:45', 'Almoço', 'compra'),
(15, 1, 2, '30.00', '30.00', 1, 6, '2015-07-07 20:20:03', 'CD - POD Sattelite', 'compra'),
(16, 1, 2, '1.00', '0.00', 7, 0, '2015-07-07 20:29:28', 'Salário Julho/2015', 'entrada'),
(17, 1, 2, '1.00', '0.00', 7, 0, '2015-07-07 20:34:32', 'Salário Julho/2015', 'entrada'),
(18, 1, 2, '1000.00', '0.00', 7, 0, '2015-07-07 20:41:08', 'Salário Julho/2015', 'entrada'),
(19, 1, 2, '800.00', '800.00', 10, 7, '2015-07-07 20:42:32', 'Notebook Usado DELL', 'compra'),
(20, 3, 5, '5123.21', '0.00', 11, 0, '2015-07-07 21:12:24', 'Achei na rua', 'entrada'),
(21, 3, 5, '5000.00', '5000.00', 13, 11, '2015-07-07 21:13:41', 'Depósito', 'transferencia'),
(22, 3, 5, '2000.00', '2000.00', 14, 13, '2015-07-07 21:14:24', 'Iphone 6', 'compra');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_tb`
--

CREATE TABLE IF NOT EXISTS `usuarios_tb` (
  `usu_id` int(10) NOT NULL AUTO_INCREMENT,
  `usu_nome` varchar(80) NOT NULL,
  `usu_login` varchar(20) NOT NULL,
  `usu_senha` varchar(40) NOT NULL,
  `usu_email` varchar(80) NOT NULL,
  `usu_flag` char(1) DEFAULT NULL,
  PRIMARY KEY (`usu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `usuarios_tb`
--

INSERT INTO `usuarios_tb` (`usu_id`, `usu_nome`, `usu_login`, `usu_senha`, `usu_email`, `usu_flag`) VALUES
(1, 'Rodrigo Tognin', 'rotognin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rotog@teste.com', 'S'),
(2, 'Administrador', 'administrador', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rotog@outlook.com', 'A'),
(3, 'Tatiane da Silva', 'tatianesilva', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'teste@teste.com', 'S'),
(5, 'Comp-3 Sistemas', 'comp3sis', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'teste1@teste.com', 'N');
