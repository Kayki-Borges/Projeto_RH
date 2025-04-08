-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/04/2025 às 18:58
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
  `tipo_usuario` enum('candidato','empresa') NOT NULL DEFAULT 'candidato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `candidatos`
--

INSERT INTO `candidatos` (`id`, `nome_candidato`, `email_candidato`, `cpf_candidato`, `endereco_candidato`, `telefone_candidato`, `formacao_academica`, `experiencia_profissional`, `area_atuacao`, `senha_candidato`, `created_at`, `tipo_usuario`) VALUES
(1, 'isaque', 'wwwisaque18@gmail.com', '123.525.226-26', '123asdfadas', '(12) 31231-2312', 'Ensino Médio', 'asdasd', 'Tecnologia', '$2y$10$ABzhXcIYuragvXxrcYtOCOJlBeTiQp0pt77J.auJsAhWH4PWgMNcm', '2025-02-27 23:11:11', 'candidato'),
(2, 'lucas', 'wwwisaue18@gmail.com', '123.131.231-23', '12345', '(13) 12312-3131', 'Ensino Médio', '12345', 'Tecnologia', '$2y$10$cVToLXiQabpzgrO0Ab0bme2p747fOdyX9rKaqtUU40nH43RlpkIxa', '2025-03-11 16:19:18', 'candidato'),
(3, 'lucas', 'wwwisa12313122ue18@gmail.com', '123.545.123-13', 'rua agu9ia', '(11) 12313-1235', 'Ensino Médio', '1234', 'Tecnologia', '$2y$10$bI3i36nxQyy9VJDca5yVwuIjNs9VjgJVKV7FUtfPpAAvH0vNTZneO', '2025-03-11 16:24:31', 'candidato'),
(4, 'carlos', 'wwwisaqu123418@gmail.com', '123.112.323-41', '123131', '(12) 12331-2313', 'Ensino Médio', '1235', 'Educação', '$2y$10$O3jL62d8Ngv.1IHVZBtwXuhHOCtddZmVZ69kgmIWwysjhSGEPd7uC', '2025-03-13 15:33:55', 'candidato');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_usuario` enum('candidato','empresa') NOT NULL DEFAULT 'empresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `nome_empresa`, `email_empresa`, `cnpj_empresa`, `endereco_empresa`, `telefone_empresa`, `area_atuacao`, `senha_empresa`, `created_at`, `tipo_usuario`) VALUES
(1, 'alguma ', '1234@gmail.com', '123123', 'nada', '1223123', '', '$2y$10$66tJE.1KZ3sUxjp92w4qJ.VQjGZKLE8soGsHQrQpSaUuqMl4yxaCm', '2025-03-26 15:44:05', 'empresa'),
(2, 'alguma 1', '12345@gmail.com', '1231235', 'nada', '122312312414141', '', '$2y$10$UfctXv/xvNP9OctPgA.ZROg/nexNx2oEo1jlcWSJpqXPWU2P0xGDC', '2025-03-26 15:45:40', 'empresa'),
(4, 'alguma 1', '12345@gmail.com', '123123578', 'nada', '122312312414141', '', '$2y$10$6nFr41WIF7PR8fYQBLrK7OKYXvjk5uDQmAC/2wv4nZFS6n14lUKgG', '2025-03-26 15:46:19', 'empresa'),
(5, 'alguma ', '12345@gmail.com', '123123515', '1ada', '1223123', '', '$2y$10$nRi1iXfoo4qM0sHW01etuuNRmlA9/1hLFg4fHbJz3/guLBwK6qkmi', '2025-03-26 15:49:33', 'empresa'),
(6, 'alguma ', '12345@gmail.com', '1231235156736', '1ada', '1223123', '', '$2y$10$0Tbs0eqpKqSb5g8wixNKEueUP3riDIFxc8NfVqdjJ7US3MVoA/mE.', '2025-03-26 15:54:46', 'empresa'),
(7, 'alguma2', '12345@gmail.com', '123123141115151512', 'asa3rqaa', '122312312414141', '', '$2y$10$u/ua/C94.Hz8gjtK.LatFuc00bwnnbRtI8G5LhJ6QvACqRzDtT83S', '2025-04-01 17:09:44', 'empresa');

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
-- Despejando dados para a tabela `vagas`
--

INSERT INTO `vagas` (`id`, `empresa_id`, `descricao`, `requisitos`, `data_postagem`) VALUES
(7, 2, 'Desenvolvedor', 'alguma ', '2025-04-03 16:09:35'),
(8, 1, 'Recepcionista', 'nenhum', '2025-04-08 16:23:56');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `candidato_vaga`
--
ALTER TABLE `candidato_vaga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
