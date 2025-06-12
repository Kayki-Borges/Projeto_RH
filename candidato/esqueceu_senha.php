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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #3a7bd5, #00d2ff);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            max-width: 400px;
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
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.5s ease;
        }

        .modal-content {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            animation: slideDown 0.5s ease;
        }

        .modal-content p {
            font-size: 1.1em;
            color: #444;
        }

        .success-icon {
            background-color: #28a745;
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 30px;
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
    </style>
</head>
<body>

<?php if (!$showModal): ?>
    <form method="POST">
        <h2>Recuperar Senha</h2>
        <input type="email" name="email" placeholder="Seu email" required>
        <button type="submit">Enviar código</button>
    </form>
<?php else: ?>
    <div class="modal" id="modal" style="display: flex;">
        <div class="modal-content">
            <div class="success-icon">✔</div>
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
