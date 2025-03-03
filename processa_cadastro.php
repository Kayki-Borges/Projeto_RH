<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $formacao_academica = $_POST['formacao_academica'];
    $experiencia_profissional = $_POST['experiencia_profissional'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $area_interesse = $_POST['area_interesse'];

    // Validação da senha
    if ($senha != $confirmar_senha) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserção no banco de dados
    try {
        $sql = "INSERT INTO candidatos (nome_candidato, email_candidato, cpf_candidato, endereco_candidato, telefone_candidato, formacao_academica, experiencia_profissional, senha_candidato, area_atuacao) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $cpf, $endereco, $telefone, $formacao_academica, $experiencia_profissional, $senha_hash, $area_interesse]);
        
        // Redireciona para a página de sucesso
        header("Location: login.php");
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>
