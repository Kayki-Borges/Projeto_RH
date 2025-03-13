<?php

// Adicionando os cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// O restante do código...
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
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
            background: #28a745;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #218838;
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
            <form id="loginForm">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>
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
 fetch('google-callback.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'token=' + encodeURIComponent(token)
})
.then(response => response.text())  // Use .text() para depurar a resposta
.then(data => {
    console.log(data); // Verifique o conteúdo da resposta
    try {
        let jsonData = JSON.parse(data);  // Tente converter a resposta em JSON
        // Agora você pode manipular jsonData
    } catch (e) {
        console.error('Erro ao processar JSON:', e);
    }
})
.catch(error => console.error('Erro:', error));


</script>

</body>
</html>
