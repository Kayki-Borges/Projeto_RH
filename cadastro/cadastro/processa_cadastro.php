<?php
session_start(); // Inicia a sessão

require_once('../conexao.php');

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $formacao_academica = $_POST['formacao_academica'] ?? '';
    $experiencia_profissional = $_POST['experiencia_profissional'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    $area_interesse = $_POST['area_interesse'] ?? '';

    // Validação da senha
    if ($senha != $confirmar_senha) {
        $_SESSION['erro'] = "As senhas não coincidem!";
        header("Location: cadastro.php");
        exit();
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Tipo de usuário
    $tipo_usuario = 'candidato';

    // Verificar se o CPF já existe no banco de dados
    try {
        $sql = "SELECT COUNT(*) FROM candidatos WHERE cpf_candidato = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cpf]);
        $result = $stmt->fetchColumn();

        if ($result > 0) {
            $_SESSION['erro'] = "Já existe um cadastro com este CPF!";
            header("Location: cadastro.php");
            exit();
        }

        // Inserção no banco de dados
        $sql = "INSERT INTO candidatos (nome_candidato, email_candidato, cpf_candidato, endereco_candidato, telefone_candidato, formacao_academica, experiencia_profissional, senha_candidato, area_atuacao, tipo_usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $cpf, $endereco, $telefone, $formacao_academica, $experiencia_profissional, $senha_hash, $area_interesse, $tipo_usuario]);

        // Define sucesso no cadastro
        $_SESSION['cadastro_sucesso'] = true;

        // Redirecionar para a página de cadastro com o sucesso
        header("Location: cadastro.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro ao cadastrar: " . $e->getMessage();
        header("Location: cadastro.php");
        exit();
    }
}
