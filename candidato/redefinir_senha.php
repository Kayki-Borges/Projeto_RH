<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../conexao.php');

    $email = $_POST['email'] ?? '';
    $codigo = $_POST['codigo'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';

    $stmtUser = $pdo->prepare("SELECT id, 'candidato' as tipo FROM candidatos WHERE LOWER(email_candidato) = LOWER(:email)");
    $stmtUser->execute(['email' => $email]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $stmtUser = $pdo->prepare("SELECT id, 'empresa' as tipo FROM empresas WHERE LOWER(email_empresa) = LOWER(:email)");
        $stmtUser->execute(['email' => $email]);
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
    }

    if (!$user) {
        die("Email inválido.");
    }

    $stmtCode = $pdo->prepare("SELECT * FROM reset_senha_tokens WHERE email = :email AND token = :token AND expiracao > NOW()");
    $stmtCode->execute(['email' => $email, 'token' => $codigo]);
    $rec = $stmtCode->fetch(PDO::FETCH_ASSOC);

    if ($rec) {
        if (strlen($novaSenha) < 8 || !preg_match('/[A-Za-z]/', $novaSenha) || !preg_match('/\d/', $novaSenha)) {
            die("A senha deve ter pelo menos 8 caracteres e incluir letras e números.");
        }

        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);

        if ($user['tipo'] === 'candidato') {
            $stmtUpd = $pdo->prepare("UPDATE candidatos SET senha_candidato = :senha WHERE id = :id");
        } else {
            $stmtUpd = $pdo->prepare("UPDATE empresas SET senha_empresa = :senha WHERE id = :id");
        }
        $stmtUpd->execute(['senha' => $hash, 'id' => $user['id']]);

        $stmtUsed = $pdo->prepare("UPDATE reset_senha_tokens SET expiracao = NOW() WHERE id = :id");
        $stmtUsed->execute(['id' => $rec['id']]);

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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Redefinir Senha</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .form-container {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      max-width: 420px;
      width: 100%;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-container h2 {
      text-align: center;
      font-size: 26px;
      color: #333;
      margin-bottom: 20px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group i {
      position: absolute;
      top: 12px;
      left: 12px;
      color: #999;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px 12px 40px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.3s ease;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .msg {
      padding: 12px;
      border-radius: 6px;
      text-align: center;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 20px;
    }

    .msg.erro {
      background-color: #fdecea;
      color: #b71c1c;
      border: 1px solid #f5c6cb;
    }

    .msg.sucesso {
      background-color: #e6f4ea;
      color: #256029;
      border: 1px solid #c3e6cb;
    }

    @media (max-width: 480px) {
      .form-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Redefinir Senha</h2>

  <?php if (!empty($erro)): ?>
    <div class="msg erro"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <?php if (!empty($sucesso)): ?>
    <div class="msg sucesso"><?= htmlspecialchars($sucesso) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="input-group">
      <i class="fas fa-envelope"></i>
      <input type="email" name="email" placeholder="Seu e-mail" required>
    </div>

    <div class="input-group">
      <i class="fas fa-key"></i>
      <input type="text" name="codigo" placeholder="Código do e-mail" required>
    </div>

    <div class="input-group">
      <i class="fas fa-lock"></i>
      <input type="password" name="nova_senha" placeholder="Nova senha (mín. 8 caracteres)" required>
    </div>

    <button type="submit">Redefinir senha</button>
  </form>
</div>

</body>
</html>
