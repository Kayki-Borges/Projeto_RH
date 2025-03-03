-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/02/2025 às 00:12
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `candidatos`
--

INSERT INTO `candidatos` (`id`, `nome_candidato`, `email_candidato`, `cpf_candidato`, `endereco_candidato`, `telefone_candidato`, `formacao_academica`, `experiencia_profissional`, `area_atuacao`, `senha_candidato`, `created_at`) VALUES
(1, 'isaque', 'wwwisaque18@gmail.com', '123.525.226-26', '123asdfadas', '(12) 31231-2312', 'Ensino Médio', 'asdasd', 'Tecnologia', '$2y$10$ABzhXcIYuragvXxrcYtOCOJlBeTiQp0pt77J.auJsAhWH4PWgMNcm', '2025-02-27 23:11:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidato_vaga`
--

CREATE TABLE `candidato_vaga` (
  `id` int(11) NOT NULL,
  `candidato_id` int(11) NOT NULL,
  `vaga_id` int(11) NOT NULL,
  `data_inscricao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nome_empresa` varchar(255) NOT NULL,
  `email_empresa` varchar(255) NOT NULL,
  `cnpj_empresa` varchar(18) NOT NULL,
  `endereco_empresa` text NOT NULL,
  `telefone_empresa` varchar(15) NOT NULL,
  `area_atuacao` varchar(100) NOT NULL,
  `senha_empresa` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vagas`
--

CREATE TABLE `vagas` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `requisitos` text DEFAULT NULL,
  `data_postagem` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Índices de tabela `candidato_vaga`
--
ALTER TABLE `candidato_vaga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidato_id` (`candidato_id`),
  ADD KEY `vaga_id` (`vaga_id`);

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj_empresa` (`cnpj_empresa`);

--
-- Índices de tabela `vagas`
--
ALTER TABLE `vagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `candidatos`
--
ALTER TABLE `candidatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `candidato_vaga`
--
ALTER TABLE `candidato_vaga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `candidato_vaga`
--
ALTER TABLE `candidato_vaga`
  ADD CONSTRAINT `candidato_vaga_ibfk_1` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`),
  ADD CONSTRAINT `candidato_vaga_ibfk_2` FOREIGN KEY (`vaga_id`) REFERENCES `vagas` (`id`);

--
-- Restrições para tabelas `vagas`
--
ALTER TABLE `vagas`
  ADD CONSTRAINT `vagas_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
