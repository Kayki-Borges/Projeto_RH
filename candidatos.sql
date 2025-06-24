-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/06/2025 às 21:32
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_rh`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidatos`
--

CREATE TABLE `candidatos` (
  `id` int(11) NOT NULL,
  `nome_candidato` varchar(255) NOT NULL,
  `email_candidato` varchar(255) NOT NULL,
  `cpf_candidato` varchar(14) NOT NULL,
  `endereco_candidato` text NOT NULL,
  `telefone_candidato` varchar(15) NOT NULL,
  `formacao_academica` varchar(255) DEFAULT NULL,
  `experiencia_profissional` text DEFAULT NULL,
  `area_atuacao` varchar(100) NOT NULL,
  `senha_candidato` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_usuario` enum('candidato','empresa') NOT NULL DEFAULT 'candidato',
  `foto_candidato` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `candidatos`
--

INSERT INTO `candidatos` (`id`, `nome_candidato`, `email_candidato`, `cpf_candidato`, `endereco_candidato`, `telefone_candidato`, `formacao_academica`, `experiencia_profissional`, `area_atuacao`, `senha_candidato`, `created_at`, `tipo_usuario`, `foto_candidato`, `google_id`) VALUES
(4, 'candidato2', 'candidato2@gmail.com', '123.112.323-41', '123131', '(12) 12331-2313', 'Ensino Médio', '1235', 'Educação', '$2y$10$O3jL62d8Ngv.1IHVZBtwXuhHOCtddZmVZ69kgmIWwysjhSGEPd7uC', '2025-03-13 15:33:55', 'candidato', '6848432fce7db.avif', NULL),
(6, 'jonatas', 'pereirajonatas@gmail.com', '123.123.123-12', 'Rua nenhum lugar', '(12) 31223-1231', 'Graduação', 'nenhuma', 'Tecnologia', '$2y$10$KquWsGBhb6mmN2PQfUqezOJptsNgA9R7LNu3Qc4vhOT/UVhpkdLMG', '2025-06-24 16:59:43', 'candidato', '685afd0cd1560.zip', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `candidatos`
--
ALTER TABLE `candidatos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_candidato` (`cpf_candidato`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `candidatos`
--
ALTER TABLE `candidatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
