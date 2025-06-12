-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/06/2025 às 17:27
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
(4, 'candidato2', 'candidato2@gmail.com', '123.112.323-41', '123131', '(12) 12331-2313', 'Ensino Médio', '1235', 'Educação', '$2y$10$O3jL62d8Ngv.1IHVZBtwXuhHOCtddZmVZ69kgmIWwysjhSGEPd7uC', '2025-03-13 15:33:55', 'candidato', '6848432fce7db.avif', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `candidato_vaga`
--

CREATE TABLE `candidato_vaga` (
  `id` int(11) NOT NULL,
  `candidato_id` int(11) NOT NULL,
  `vaga_id` int(11) NOT NULL,
  `data_inscricao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('em_andamento','finalizada','rejeitado') DEFAULT 'em_andamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `candidato_vaga`
--

INSERT INTO `candidato_vaga` (`id`, `candidato_id`, `vaga_id`, `data_inscricao`, `status`) VALUES
(71, 4, 22, '2025-06-10 14:14:37', 'finalizada'),
(73, 4, 23, '2025-06-10 14:37:16', 'em_andamento');

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
  `tipo_usuario` enum('candidato','empresa') NOT NULL DEFAULT 'empresa',
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `nome_empresa`, `email_empresa`, `cnpj_empresa`, `endereco_empresa`, `telefone_empresa`, `area_atuacao`, `senha_empresa`, `created_at`, `tipo_usuario`, `google_id`) VALUES
(1, 'empresa2', 'empresa2@gmail.com', '123123', 'nada', '1223123', 'nenhuma', '$2y$10$66tJE.1KZ3sUxjp92w4qJ.VQjGZKLE8soGsHQrQpSaUuqMl4yxaCm', '2025-03-26 15:44:05', 'empresa', NULL),
(4, 'empresa1', 'empresa1@gmail.com', '123123578', 'nada', '(12) 23123-1245', '', '$2y$10$6nFr41WIF7PR8fYQBLrK7OKYXvjk5uDQmAC/2wv4nZFS6n14lUKgG', '2025-03-26 15:46:19', 'empresa', NULL),
(8, 'empresa3', 'empresa3@gmail.com', '12.312.414/1241-23', 'nenhum', '(46) 16846-4186', '', '$2y$10$NvhKTu9o4PQuIpOZPTYHluV3595aLtlLZSPmIjfDcuvMtM3Uaa0hq', '2025-05-13 17:14:48', 'empresa', NULL),
(9, 'CMD', 'wwwisaque18@gmail.com', '54.861.351/8486-31', 'Rua santo expedido', '(86) 46486-4684', '', '$2y$10$SBSxqLBUSOBcweLYsL3oeeHduW1FoSjjqdOJFCf3R4ZFJ4abkV0sy', '2025-06-11 16:34:39', 'empresa', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `recuperacao_senha`
--

CREATE TABLE `recuperacao_senha` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `usado` tinyint(1) DEFAULT 0,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reset_senha_tokens`
--

CREATE TABLE `reset_senha_tokens` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiracao` datetime NOT NULL,
  `usado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reset_senha_tokens`
--

INSERT INTO `reset_senha_tokens` (`id`, `email`, `token`, `expiracao`, `usado`) VALUES
(1, 'candidato2@gmail.com', '86924b0a98a381d97e6f02286c3a80ef', '2025-06-10 20:34:11', 0),
(2, 'candidato2@gmail.com', 'b811a4d44f64158b11a20ef8ab8bebbb', '2025-06-10 20:42:19', 0),
(3, 'candidato2@gmail.com', '956a8a77acf70c86fafd9c80c5547375', '2025-06-10 20:42:28', 0),
(4, 'candidato2@gmail.com', 'c5594ab47c64d5fe3d9a7a0b73d67ee9', '2025-06-10 20:49:10', 0),
(5, 'wwwisaque18@gmail.com', '80f3b3e286946cadd8152f6586546722', '2025-06-11 19:43:49', 0),
(6, 'wwwisaque18@gmail.com', 'fd672615425cbba531ea5b0ea5b39e19', '2025-06-11 19:43:57', 0),
(7, 'wwwisaque18@gmail.com', 'b54e6f47ff8efc12eb2e848a565e73f1', '2025-06-11 19:47:26', 0),
(8, 'wwwisaque18@gmail.com', '8d3f3ce109b0ced564f2aef5688a57f2', '2025-06-11 19:47:34', 0),
(9, 'wwwisaque18@gmail.com', '702507e13fe7181deb4209109c0d376b', '2025-06-11 19:49:48', 0),
(10, 'wwwisaque18@gmail.com', '0b30eb1d43212882b7686e7d0a745901', '2025-06-11 19:50:52', 0),
(11, 'wwwisaque18@gmail.com', '2777b6dab61c84a9a32a7a517c28efee', '2025-06-11 19:51:42', 0),
(12, 'wwwisaque18@gmail.com', 'b40aa2a4db0cdb59764f36e11a4b38d4', '2025-06-11 19:51:48', 0),
(13, 'wwwisaque18@gmail.com', '9eba0f468352818843c34a7e8d15b22b', '2025-06-11 19:52:13', 0),
(14, 'wwwisaque18@gmail.com', 'be8c2cc0e9002ed77c06e9ecbae963ca', '2025-06-11 19:52:31', 0),
(15, 'wwwisaque18@gmail.com', '960092b822dca72b16d3299927634e80', '2025-06-11 19:52:55', 0),
(16, 'wwwisaque18@gmail.com', '876420058560f35f2be19cd5f3f662ae', '2025-06-11 19:57:35', 0),
(17, 'wwwisaque18@gmail.com', 'd41456205416712d5b32ca455cc26012', '2025-06-11 20:01:06', 0),
(18, 'wwwisaque18@gmail.com', '7b647126000d0603bbfacd47cb7669ee', '2025-06-11 20:04:25', 0);

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
(22, 4, 'Recepcionista', 'teste1', '2025-05-13 16:35:46'),
(23, 4, 'Desenvolvedor', 'teste2', '2025-05-13 16:35:51');

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
-- Índices de tabela `recuperacao_senha`
--
ALTER TABLE `recuperacao_senha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `reset_senha_tokens`
--
ALTER TABLE `reset_senha_tokens`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `candidato_vaga`
--
ALTER TABLE `candidato_vaga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `recuperacao_senha`
--
ALTER TABLE `recuperacao_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reset_senha_tokens`
--
ALTER TABLE `reset_senha_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `candidato_vaga`
--
ALTER TABLE `candidato_vaga`
  ADD CONSTRAINT `candidato_vaga_ibfk_1` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`),
  ADD CONSTRAINT `candidato_vaga_ibfk_2` FOREIGN KEY (`vaga_id`) REFERENCES `vagas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `recuperacao_senha`
--
ALTER TABLE `recuperacao_senha`
  ADD CONSTRAINT `recuperacao_senha_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `candidatos` (`id`);

--
-- Restrições para tabelas `vagas`
--
ALTER TABLE `vagas`
  ADD CONSTRAINT `vagas_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
