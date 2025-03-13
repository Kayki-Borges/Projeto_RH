<?php
session_start();
require_once "cadastro/conexao.php";

if (!isset($_SESSION["usuario"])) {
    echo "Usuário não autenticado!";
    exit;
}

$usuario = $_SESSION["usuario"];
$perfil = $_POST['perfil'];

// Atualiza o tipo de usuário no banco de dados
$sql = "UPDATE candidatos SET tipo_usuario = :perfil WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':perfil', $perfil, PDO::PARAM_STR);
$stmt->bindParam(':id', $usuario['id'], PDO::PARAM_INT);

if ($stmt->execute()) {
    // Atualiza o tipo de usuário na sessão
    $_SESSION["usuario"]["tipo_usuario"] = $perfil;

    // Redireciona para o dashboard adequado
    if ($perfil === 'empresa') {
        header("Location: /login/dashboard_empresa.php");
    } else {
        header("Location: /login/dashboard_usuario.php");
    }
} else {
    echo "Erro ao atualizar perfil.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Escolha seu perfil</title>
</head>
<body>
    <h1>Escolha seu perfil</h1>
    <form action="processa_perfil.php" method="POST">
        <label for="perfil">Selecione seu tipo de usuário:</label>
        <select name="perfil" id="perfil">
            <option value="candidato">Candidato</option>
            <option value="empresa">Empresa</option>
        </select>
        <button type="submit">Finalizar Cadastro</button>
    </form>
</body>
</html>
