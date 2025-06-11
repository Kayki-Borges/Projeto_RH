<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/Exception.php';
require '../src/PHPMailer.php';
require '../src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../conexao.php';

    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        exit('Email obrigatório.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('Email inválido.');
    }

    // Verifica se o email existe na tabela candidatos
    $stmt = $pdo->prepare("SELECT * FROM candidatos WHERE email_candidato = ?");
    $stmt->execute([$email]);
    $candidato = $stmt->fetch();

    // Verifica se o email existe na tabela empresas
    if (!$candidato) {
        $stmt = $pdo->prepare("SELECT * FROM empresas WHERE email_empresa = ?");
        $stmt->execute([$email]);
        $empresa = $stmt->fetch();
    }

    // Mensagem genérica por segurança (evita revelar se o email existe ou não)
    $mensagemPadrao = 'Se o email estiver cadastrado, enviaremos um link de recuperação.';

    // Se o email não foi encontrado em nenhuma das tabelas, exibe a mensagem e encerra
    if (!$candidato && !$empresa) {
        exit($mensagemPadrao);
    }

    // Define o email que será utilizado para recuperação (pode ser do candidato ou da empresa)
    $emailParaRecuperacao = $candidato ? $candidato['email_candidato'] : $empresa['email_empresa'];

    // Gera token e define expiração (1 hora)
    $token = bin2hex(random_bytes(16));
    $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Salva o token no banco (em uma tabela específica para tokens de recuperação de senha)
    $stmt = $pdo->prepare("INSERT INTO reset_senha_tokens (email, token, expiracao) VALUES (?, ?, ?)");
    $stmt->execute([$emailParaRecuperacao, $token, $expiracao]);

    // Verifique se o token foi salvo corretamente
    if ($stmt->rowCount() === 0) {
        exit('Erro ao salvar o token no banco de dados.');
    }

    // Envio do email com PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações SMTP (Gmail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'wwwisaque18@gmail.com';  // Seu Gmail
        $mail->Password   = 'anuz efgw hvtg yzsb';    // Senha de app
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Remetente e destinatário
        $mail->setFrom('wwwisaque18@gmail.com', 'RH - Projeto de Recrutamento');
        $mail->addAddress($emailParaRecuperacao);

        // Conteúdo do e-mail
        $mail->isHTML(false);
        $mail->Subject = 'Recuperação de senha';
        $link = "http://localhost/projeto_rh/candidato/redefinir_senha.php?token=$token";
       $mail->Body = "Olá,\n\nPara redefinir sua senha, clique no link abaixo:\n\n$link\n\nEste link expira em 1 hora.\n\nSe você não solicitou a recuperação de senha, desconsidere este e-mail.";


        // Envia o e-mail
        $mail->send();

        // Mensagem que será exibida após o envio bem-sucedido
        echo $mensagemPadrao;

        // Redireciona para a página de redefinir senha após o envio do e-mail
        header("Location: http://localhost/projeto_rh/candidato/redefinir_senha.php?token=$token"); // Passa o token no link de redirecionamento
        exit(); // Impede a execução do código abaixo
    } catch (Exception $e) {
        // Exibe detalhes do erro no envio do e-mail
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }
} else {
    // Formulário simples para solicitar recuperação
    echo '<form method="POST">
        <input type="email" name="email" placeholder="Seu email" required>
        <button type="submit">Enviar código</button>
    </form>';
}
?>
