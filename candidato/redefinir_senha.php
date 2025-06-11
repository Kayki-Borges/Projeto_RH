<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../conexao.php');

    $email = $_POST['email'] ?? '';
    $codigo = $_POST['codigo'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';

    // Buscar candidato pelo email
    $stmtUser = $pdo->prepare("SELECT id FROM candidatos WHERE email_candidato = :email");
    $stmtUser->execute(['email' => $email]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Email inválido.");
    }

    // Verificar código e validade (15 minutos)
    $stmtCode = $pdo->prepare("SELECT * FROM reset_senha_tokens WHERE email = :email AND token = :token AND expiracao > NOW()");
    $stmtCode->execute(['email' => $email, 'token' => $_GET['token']]);
    $rec = $stmtCode->fetch(PDO::FETCH_ASSOC);

    if ($rec) {
        // Validar nova senha
        if (strlen($novaSenha) < 8 || !preg_match('/[A-Za-z]/', $novaSenha) || !preg_match('/\d/', $novaSenha)) {
            die("A senha deve ter pelo menos 8 caracteres e incluir letras e números.");
        }

        // Atualizar senha com hash
        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmtUpd = $pdo->prepare("UPDATE candidatos SET senha_candidato = :senha WHERE id = :id");
        $stmtUpd->execute(['senha' => $hash, 'id' => $user['id']]);

        // Marcar código como usado
        $stmtUsed = $pdo->prepare("UPDATE reset_senha_tokens SET expiracao = NOW() WHERE id = :id");
        $stmtUsed->execute(['id' => $rec['id']]);

        // Redireciona para a página de sucesso ou de login
        header("Location: sucesso.php");
        exit();
    } else {
        echo "Código inválido ou expirado.";
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Seu email" required>
    <input type="text" name="codigo" placeholder="Código recebido" required>
    <input type="password" name="nova_senha" placeholder="Nova senha" required>
    <button type="submit">Redefinir senha</button>
</form>
