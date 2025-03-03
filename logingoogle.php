

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login com Google</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        #login-container {
            margin: 50px;
        }
    </style>
</head>
<body>

    <div id="login-container">
        <h1>Login com Google</h1>
        <div id="g_id_onload"
            data-client_id="543793793556-rlo97asgftgul1624uo3phbbi4rh4eqr.apps.googleusercontent.com"
            data-callback="handleCredentialResponse"
            data-auto_prompt="false">
        </div>
        <div class="g_id_signin" data-type="standard"></div>
    </div>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleCredentialResponse(response) {
            // Enviar o token para o PHP
            fetch('google-callback.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'token=' + response.credential
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = "candidato.php"; // Página do candidato
                } else {
                    alert("Erro ao fazer login.");
                }
            })
            .catch(error => console.error("Erro:", error));
        }
    </script>
</body>
</html>




