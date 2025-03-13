<?php
include_once('conexao.php');

$email = $_POST['email'];
$senha = $_POST['password'];

// Sanitização do e-mail
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// Preparar a consulta para verificar o usuário
$sql = "SELECT * FROM candidatos WHERE email_candidato = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();

// Recuperar o usuário
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Verificar se a senha corresponde
    if (password_verify($senha, $user['senha_candidato'])) {
        // Usuário autenticado
        echo "success";
    } else {
        // Senha incorreta
        echo "senha_incorreta";
    }
} else {
    // Usuário não encontrado
    echo "usuario_nao_encontrado";
}

$stmt->closeCursor(); // Fechar o cursor da consulta
$pdo = null; // Fechar a conexão PDO
?>
