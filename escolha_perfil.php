

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Finalizar Cadastro</title>

  <!-- Fonte Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

  <!-- Ícones Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: linear-gradient(135deg, rgb(129, 59, 221), #4088d6);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .container {
      background: #fff;
      padding: 50px 40px;
      width: 90%;
      max-width: 400px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      text-align: center;
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .container h2 {
      margin-bottom: 15px;
      font-size: 30px;
      color: #333;
    }

    .container p {
      margin-bottom: 30px;
      font-size: 16px;
      color: #777;
    }

    .choice-button {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      padding: 14px;
      margin-bottom: 20px;
      border: none;
      border-radius: 10px;
      color: white;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s all ease-in-out;
      gap: 10px;
    }

    .choice-button.candidato {
      background: #4088d6;
    }

    .choice-button.empresa {
      background: #9D61EA;
    }

    .choice-button.candidato:hover {
      background: #326fb1;
      transform: scale(1.1);
    }

    .choice-button.empresa:hover {
      background: #7b45cc;
      transform: scale(1.1);
    }

    .choice-button i {
      font-size: 20px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Finalizar Cadastro</h2>
    <p>Escolha seu tipo de conta para completar seu perfil:</p>

    <button onclick="completeRegistration('candidato')" class="choice-button candidato">
      <i class="fas fa-user"></i> Sou Candidato
    </button>

    <button onclick="completeRegistration('empresa')" class="choice-button empresa">
      <i class="fas fa-building"></i> Sou Empresa
    </button>
  </div>

  <script>
  async function completeRegistration(type) {
  try {
    const response = await fetch('/projeto_rh/salvar_tipo_usuario.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ tipo: type })
    });

    const data = await response.json();
    console.log(data); // Para debug

    if (data.success) {
      alert("Cadastro finalizado com sucesso!");
      if (type === 'candidato') {
        window.location.href = "/projeto_rh/candidato/pagina-usuario log.php";
      } else if (type === 'empresa') {
        window.location.href = "/projeto_rh/empresa/pagina-empresa log.php";
      }
    } else {
      // Se sessão expirar ou houver outro erro
      alert("Erro ao finalizar cadastro: " + data.message);
      if (data.message.includes('Sessão expirada')) {
        window.location.href = "/projeto_rh/login/login.php";
      }
    }
  } catch (error) {
    console.error('Erro:', error);
    alert("Erro inesperado ao tentar salvar o cadastro.");
  }
}

  </script>

</body>
</html>
