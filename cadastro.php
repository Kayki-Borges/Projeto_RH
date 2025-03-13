<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once('conexao.php');
    
    // Sanitize e-mail
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Criptografando a senha
    
    // Verificar se o usuário já existe
    $sql = "SELECT * FROM candidatos WHERE email_candidato = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "Usuário já existe.";
    } else {
        // Inserir o novo usuário no banco
        $sql = "INSERT INTO candidatos (email_candidato, senha_candidato) VALUES (:email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        $stmt->execute();

        echo "Cadastro realizado com sucesso!";
    }

    $stmt->closeCursor();
    $pdo = null; // Fechar a conexão PDO
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        /* Estilos semelhantes ao login, ajustados para o cadastro */
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro</h2>
    <form method="POST" action="cadastro.php">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="E-mail" required>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" placeholder="Senha" required>

        <button type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>
