<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <img src="logo.png" alt="Logo" class="logo">
            <h2>Fazer login</h2>
            <p class="subtitle">Use sua conta para acessar.</p>
            
            <div id="g_id_onload"
                data-client_id="543793793556-rlo97asgftgul1624uo3phbbi4rh4eqr.apps.googleusercontent.com"
                data-callback="handleCredentialResponse"
                data-auto_prompt="false">
            </div>
            <div class="g_id_signin" data-type="standard"></div>
        </div>
    </div>
    
    <script>
        function handleCredentialResponse(response) {
            const jwt = response.credential;
            fetch('localhost:8080/google-login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token: jwt })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "/completar-cadastro?user_id=" + data.user_id;
                } else {
                    alert("Erro ao autenticar com o Google.");
                }
            })
            .catch(error => console.error('Erro:', error));
        }
    </script>
</body>
</html>
