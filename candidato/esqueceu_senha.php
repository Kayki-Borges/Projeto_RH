<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/Exception.php';
require '../src/PHPMailer.php';
require '../src/SMTP.php';

$showModal = false;
$mensagemPadrao = 'Se o email estiver cadastrado, enviaremos um código de recuperação.';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../conexao.php';

    $email = trim($_POST['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagemPadrao = 'Email inválido.';
        $showModal = true;
    } else {
        $stmt = $pdo->prepare("SELECT * FROM candidatos WHERE email_candidato = ?");
        $stmt->execute([$email]);
        $candidato = $stmt->fetch();

        if (!$candidato) {
            $stmt = $pdo->prepare("SELECT * FROM empresas WHERE email_empresa = ?");
            $stmt->execute([$email]);
            $empresa = $stmt->fetch();
        }

        if (!$candidato && !$empresa) {
            $showModal = true;
        } else {
            $emailParaRecuperacao = $candidato ? $candidato['email_candidato'] : $empresa['email_empresa'];
            $token = bin2hex(random_bytes(16));
            $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $stmt = $pdo->prepare("INSERT INTO reset_senha_tokens (email, token, expiracao) VALUES (?, ?, ?)");
            $stmt->execute([$emailParaRecuperacao, $token, $expiracao]);

            $link = "http://localhost/projeto_rh/candidato/redefinir_senha.php?token=$token";

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'wwwisaque18@gmail.com';
                $mail->Password = 'anuz efgw hvtg yzsb';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('wwwisaque18@gmail.com', 'RH - Projeto de Recrutamento');
                $mail->addAddress($emailParaRecuperacao);
                $mail->isHTML(true);
                $mail->Subject = 'Recuperação de senha';
                $mail->Body = "
                    <p>Olá,</p>
                    <p>Seu código para redefinir a senha é:</p>
                    <h2>$token</h2>
                    <p>Ou clique no link abaixo para redefinir diretamente:</p>
                    <p><a href='$link'>$link</a></p>
                    <p>Este código expira em 1 hora.</p>
                ";

                $mail->send();
                $showModal = true;
            } catch (Exception $e) {
                $mensagemPadrao = "Erro ao enviar e-mail: " . $mail->ErrorInfo;
                $showModal = true;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Senha</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
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
      background: #fff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      max-width: 420px;
      width: 100%;
      text-align: center;
      animation: fadeIn 0.5s ease;
    }

    .form-container h2 {
      font-size: 24px;
      color: #333;
      margin-bottom: 20px;
    }

    .form-container input {
      width: 100%;
      padding: 12px 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      font-size: 15px;
    }

    .form-container button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: white;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .form-container button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Modal */
    .modal {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.6);
      display: flex;
      justify-content: center;
      align-items: center;
      animation: fadeIn 0.5s ease;
    }

    .modal-content {
      background: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      animation: slideDown 0.5s ease;
    }

    .modal-content p {
      font-size: 1.05em;
      color: #444;
      margin-top: 10px;
    }

    .success-icon {
      background-color: #28a745;
      width: 60px;
      height: 60px;
      margin: 0 auto 15px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      font-size: 28px;
      animation: pop 0.4s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideDown {
      from { transform: translateY(-20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes pop {
      0% { transform: scale(0.7); }
      100% { transform: scale(1); }
    }

    @media (max-width: 480px) {
      .form-container {
        padding: 30px 20px;
      }

      .modal-content {
        padding: 25px 20px;
      }
    }
  </style>
</head>
<body>

<?php if (!$showModal): ?>
  <div class="form-container">
    <h2>Recuperar Senha</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Digite seu e-mail" required>
      <button type="submit"><i class="fas fa-paper-plane"></i> Enviar Código</button>
    </form>
  </div>
<?php else: ?>
  <div class="modal">
    <div class="modal-content">
      <div class="success-icon"><i class="fas fa-check"></i></div>
      <p><strong><?= htmlspecialchars($mensagemPadrao) ?></strong></p>
      <p>Você será redirecionado em instantes...</p>
    </div>
  </div>
  <script>
    setTimeout(() => {
      window.location.href = 'redefinir_senha.php';
    }, 4000);
  </script>
<?php endif; ?>

</body>
</html>
