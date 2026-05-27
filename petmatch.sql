-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Tempo de geração: 28/05/2026 às 01:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `petmatch`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adotantes`
--

CREATE TABLE `adotantes` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `data_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `adotantes`
--

INSERT INTO `adotantes` (`id`, `nome`, `cpf`, `email`, `telefone`, `endereco`, `data_cadastro`) VALUES
(1, 'Sara Martins', '111.111.111-11', 'sara@email.com', '(61)99999-9999', 'Brasília - DF', '2026-05-27'),
(2, 'João Pedro', '222.222.222-22', 'joao@email.com', '(61)98888-8888', 'Ceilândia - DF', '2026-05-27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `animais`
--

CREATE TABLE `animais` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `especie_id` int(11) NOT NULL,
  `idade_categoria` varchar(20) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `status_vacinacao` varchar(50) DEFAULT NULL,
  `status_adocao` varchar(20) NOT NULL DEFAULT 'Disponivel',
  `descricao` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `data_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `animais`
--

INSERT INTO `animais` (`id`, `nome`, `especie_id`, `idade_categoria`, `sexo`, `cor`, `status_vacinacao`, `status_adocao`, `descricao`, `foto`, `data_cadastro`) VALUES
(1, 'Thor', 1, 'Adulto', 'Macho', 'Caramelo', 'Completa', 'Disponivel', 'Muito dócil e brincalhão', 'thor.jpg', '2026-05-27'),
(2, 'Luna', 3, 'Jovem', 'Femea', 'Branca', 'Pendente', 'Em processo', 'Calma e carinhosa', 'luna.jpg', '2026-05-27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `doacoes`
--

CREATE TABLE `doacoes` (
  `id` int(11) NOT NULL,
  `adotante_id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_doacao` date NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `doacoes`
--

INSERT INTO `doacoes` (`id`, `adotante_id`, `valor`, `data_doacao`, `tipo`, `descricao`) VALUES
(1, 1, 150.00, '2026-05-27', 'PIX', 'Ajuda para vacinação'),
(2, 2, 300.00, '2026-05-27', 'Transferencia', 'Compra de ração');

-- --------------------------------------------------------

--
-- Estrutura para tabela `especies_racas`
--

CREATE TABLE `especies_racas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `porte` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `especies_racas`
--

INSERT INTO `especies_racas` (`id`, `nome`, `tipo`, `porte`) VALUES
(1, 'Labrador', 'Cachorro', 'Grande'),
(2, 'Pinscher', 'Cachorro', 'Pequeno'),
(3, 'Persa', 'Gato', 'Medio'),
(4, 'Siamês', 'Gato', 'Pequeno');

-- --------------------------------------------------------

--
-- Estrutura para tabela `processos_adocao`
--

CREATE TABLE `processos_adocao` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `adotante_id` int(11) NOT NULL,
  `voluntario_id` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pendente',
  `data_abertura` date NOT NULL,
  `data_conclusao` date DEFAULT NULL,
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `processos_adocao`
--

INSERT INTO `processos_adocao` (`id`, `animal_id`, `adotante_id`, `voluntario_id`, `status`, `data_abertura`, `data_conclusao`, `observacoes`) VALUES
(1, 2, 1, 1, 'Pendente', '2026-05-27', NULL, 'Aguardando visita técnica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` enum('Administrador','Voluntario','Recepcionista') NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo_usuario`, `data_criacao`) VALUES
(1, 'Administrador', 'admin@petmatch.com', '123456', 'Administrador', '2026-05-27 03:38:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `voluntarios`
--

CREATE TABLE `voluntarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `area_atuacao` varchar(100) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `voluntarios`
--

INSERT INTO `voluntarios` (`id`, `nome`, `cpf`, `email`, `telefone`, `area_atuacao`, `ativo`) VALUES
(1, 'Camila Souza', '333.333.333-33', 'camila@email.com', '(61)97777-7777', 'Veterinaria', 1),
(2, 'Lucas Lima', '444.444.444-44', 'lucas@email.com', '(61)96666-6666', 'Administrativo', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adotantes`
--
ALTER TABLE `adotantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `animais`
--
ALTER TABLE `animais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_animais_especie` (`especie_id`);

--
-- Índices de tabela `doacoes`
--
ALTER TABLE `doacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doacao_adotante` (`adotante_id`);

--
-- Índices de tabela `especies_racas`
--
ALTER TABLE `especies_racas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `processos_adocao`
--
ALTER TABLE `processos_adocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_processo_animal` (`animal_id`),
  ADD KEY `fk_processo_adotante` (`adotante_id`),
  ADD KEY `fk_processo_voluntario` (`voluntario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `voluntarios`
--
ALTER TABLE `voluntarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adotantes`
--
ALTER TABLE `adotantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `animais`
--
ALTER TABLE `animais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `doacoes`
--
ALTER TABLE `doacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `especies_racas`
--
ALTER TABLE `especies_racas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `processos_adocao`
--
ALTER TABLE `processos_adocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `voluntarios`
--
ALTER TABLE `voluntarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `animais`
--
ALTER TABLE `animais`
  ADD CONSTRAINT `fk_animais_especie` FOREIGN KEY (`especie_id`) REFERENCES `especies_racas` (`id`);

--
-- Restrições para tabelas `doacoes`
--
ALTER TABLE `doacoes`
  ADD CONSTRAINT `fk_doacao_adotante` FOREIGN KEY (`adotante_id`) REFERENCES `adotantes` (`id`);

--
-- Restrições para tabelas `processos_adocao`
--
ALTER TABLE `processos_adocao`
  ADD CONSTRAINT `fk_processo_adotante` FOREIGN KEY (`adotante_id`) REFERENCES `adotantes` (`id`),
  ADD CONSTRAINT `fk_processo_animal` FOREIGN KEY (`animal_id`) REFERENCES `animais` (`id`),
  ADD CONSTRAINT `fk_processo_voluntario` FOREIGN KEY (`voluntario_id`) REFERENCES `voluntarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
