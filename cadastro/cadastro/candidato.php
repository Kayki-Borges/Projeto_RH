<?php
session_start();

if ($_SESSION['usuario']['tipo_usuario'] !== 'candidato') {
    header("Location: erro.php"); // Ou qualquer outra página de erro
    exit;
}

// Verificar se os dados da sessão estão definidos
if (!isset($_SESSION['nome']) || !isset($_SESSION['email']) || !isset($_SESSION['cpf'])) {
    // Se os dados não estiverem na sessão, redirecionar para o formulário
    header("Location: /Projeto_RH/login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Cadastro</title>
    <link rel="stylesheet" href="/Projeto_RH/css/style.css">
</head>
<body>
    <h1>Confirmação de Cadastro</h1>

    <p>Confira as informações abaixo antes de finalizar o seu cadastro:</p>

    <table>
        <tr>
            <th>Nome:</th>
            <td><?php echo htmlspecialchars($_SESSION['nome']); ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo htmlspecialchars($_SESSION['email']); ?></td>
        </tr>
        <tr>
            <th>CPF:</th>
            <td><?php echo htmlspecialchars($_SESSION['cpf']); ?></td>
        </tr>
        <tr>
            <th>Endereço:</th>
            <td><?php echo nl2br(htmlspecialchars($_SESSION['endereco'])); ?></td>
        </tr>
        <tr>
            <th>Telefone:</th>
            <td><?php echo htmlspecialchars($_SESSION['telefone']); ?></td>
        </tr>
        <tr>
            <th>Formação Acadêmica:</th>
            <td><?php echo htmlspecialchars($_SESSION['formacao_academica']); ?></td>
        </tr>
        <tr>
            <th>Experiência Profissional:</th>
            <td><?php echo nl2br(htmlspecialchars($_SESSION['experiencia_profissional'])); ?></td>
        </tr>
        <tr>
            <th>Área de Interesse:</th>
            <td><?php echo htmlspecialchars($_SESSION['area_interesse']); ?></td>
        </tr>
    </table>

    <p>Se tudo estiver correto, clique em "Confirmar Cadastro". Caso deseje editar alguma informação, clique em "Editar Cadastro".</p>

    <form action="finaliza_cadastro.php" method="POST">
        <button type="submit">Confirmar Cadastro</button>
    </form>

    <form action="index.php" method="GET">
        <button type="submit">Editar Cadastro</button>
    </form>

</body>
</html>
