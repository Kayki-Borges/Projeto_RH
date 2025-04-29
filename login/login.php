<?php
session_start();
require_once("../conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Primeiro, tenta encontrar o usuário como empresa
    $sql_empresa = "SELECT * FROM empresas WHERE email_empresa = ?";
    $stmt_empresa = $pdo->prepare($sql_empresa);
    $stmt_empresa->execute([$email]);
    $empresa = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

    if ($empresa) {
        if (password_verify($senha, $empresa['senha_empresa'])) {
            $_SESSION['usuario'] = $empresa;
            $_SESSION['tipo'] = 'empresa';
            header("Location: /projeto_rh/empresa/pagina-empresa log.php");
            exit;
        } else {
            echo "Senha incorreta para empresa!";
            exit;
        }
    }

    // Se não for empresa, tenta como candidato
    $sql_candidato = "SELECT * FROM candidatos WHERE email_candidato = ?";
    $stmt_candidato = $pdo->prepare($sql_candidato);
    $stmt_candidato->execute([$email]);
    $candidato = $stmt_candidato->fetch(PDO::FETCH_ASSOC);

    if ($candidato) {
        if (password_verify($senha, $candidato['senha_candidato'])) {
            $_SESSION['usuario'] = $candidato;
            $_SESSION['tipo'] = 'candidato';
            
            header("Location:  /projeto_rh/candidato/pagina-usuario log.php");
            exit;
        } else {
            echo "Senha incorreta para candidato!";
            exit;
        }
    }

    // Se não encontrar em nenhuma das tabelas
    echo "Usuário não encontrado!";
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <link rel="stylesheet" href="/Projeto_RH/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('/Projeto_RH/images/background.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1, h2 {
            color: #333;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        input {
            background: #f7f7f7;
        }

        button {
            background: linear-gradient(to right, #488BE8,#9D61EA);
            color: white;
            cursor: pointer;
            transition:.5s all ease-in-out;
        }

        button:hover {
            background: linear-gradient(to right, #9D61EA, #488BE8);
            transform: scale(1.1);
        }

        .modal {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .modal button {
            margin-top: 10px;
            background: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <div id="login-container">
            <h2>Entre na sua conta</h2>
            <form id="loginForm" method="POST" action="login.php">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>
            
            <!-- Google Login -->
            <div id="g_id_onload"
                data-client_id="543793793556-rlo97asgftgul1624uo3phbbi4rh4eqr.apps.googleusercontent.com"
                data-callback="handleCredentialResponse">
            </div>
            <div class="g_id_signin" data-type="standard"></div>
        </div>
    </div>

    <div id="successModal" class="modal">
        <p>Login realizado com sucesso!</p>
        <button onclick="fecharModal()">Fechar</button>
    </div>

 <script>
    // Callback para o login do Google
    function handleCredentialResponse(response) {
        const token = response.credential;

        fetch('google-callback.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'token=' + encodeURIComponent(token)
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Para depuração
            if (data.status === "success" && data.redirect) {
                window.location.href = data.redirect; // Redireciona para a URL recebida do backend
            } else {
                alert("Erro no login: " + (data.message || "Tente novamente."));
            }
        })
        .catch(error => console.error('Erro:', error));
    }
</script>

</body>
</html>
