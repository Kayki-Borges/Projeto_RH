<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../conexao.php');

    $email = $_POST['email'] ?? '';
    $codigo = $_POST['codigo'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';

    // Buscar candidato pelo email
    $stmtUser = $pdo->prepare("SELECT id, 'candidato' as tipo FROM candidatos WHERE LOWER(email_candidato) = LOWER(:email)");
    $stmtUser->execute(['email' => $email]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    // Se não encontrou em candidatos, tentar empresas
    if (!$user) {
        $stmtUser = $pdo->prepare("SELECT id, 'empresa' as tipo FROM empresas WHERE LOWER(email_empresa) = LOWER(:email)");
        $stmtUser->execute(['email' => $email]);
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
    }

    if (!$user) {
        die("Email inválido.");
    }

    // Verificar código e validade (expiração)
    $stmtCode = $pdo->prepare("SELECT * FROM reset_senha_tokens WHERE email = :email AND token = :token AND expiracao > NOW()");
    $stmtCode->execute(['email' => $email, 'token' => $codigo]);
    $rec = $stmtCode->fetch(PDO::FETCH_ASSOC);

    if ($rec) {
        // Validar nova senha
        if (strlen($novaSenha) < 8 || !preg_match('/[A-Za-z]/', $novaSenha) || !preg_match('/\d/', $novaSenha)) {
            die("A senha deve ter pelo menos 8 caracteres e incluir letras e números.");
        }

        // Atualizar senha com hash
        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);

        if ($user['tipo'] === 'candidato') {
            $stmtUpd = $pdo->prepare("UPDATE candidatos SET senha_candidato = :senha WHERE id = :id");
        } else {
            $stmtUpd = $pdo->prepare("UPDATE empresas SET senha_empresa = :senha WHERE id = :id");
        }
        $stmtUpd->execute(['senha' => $hash, 'id' => $user['id']]);

        // Marcar código como usado (expirando ele)
        $stmtUsed = $pdo->prepare("UPDATE reset_senha_tokens SET expiracao = NOW() WHERE id = :id");
        $stmtUsed->execute(['id' => $rec['id']]);

        // Redireciona para a página de sucesso ou de login
        header("Location: /projeto_rh/candidato/sucesso_senha.php");
        exit();
    } else {
        echo "Código inválido ou expirado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #141e30, #243b55);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background: #fff;
            padding: 35px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            max-width: 420px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Redefinir Senha</h2>
    <input type="email" name="email" placeholder="Seu email" required>
    <input type="text" name="codigo" placeholder="Código recebido por e-mail" required>
    <input type="password" name="nova_senha" placeholder="Nova senha (mín. 8 caracteres)" required>
    <button type="submit">Redefinir senha</button>
</form>

</body>
</html>
