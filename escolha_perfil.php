<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Finalizar Cadastro</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, rgb(129, 59, 221), rgb(64, 136, 214));
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
      background: #9D61EA;
      color: white;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      gap: 10px;
    }

    .choice-button:hover {
      background: rgb(158, 62, 196);
      transform: scale(1.05);
    }

    .choice-button i {
      font-size: 20px;
    }
  </style>

  <!-- Ícones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <div class="container">
    <h2>Finalizar Cadastro</h2>
    <p>Escolha seu tipo de conta para completar seu perfil:</p>

    <button onclick="completeRegistration('candidato')" class="choice-button">
      <i class="fas fa-user"></i> Sou Candidato
    </button>

    <button onclick="completeRegistration('empresa')" class="choice-button">
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

        if (data.success) {
          alert("Cadastro finalizado com sucesso!");
          if (type === 'candidato') {
            window.location.href = "/projeto_rh/editar-perfil-candidato.php";
          } else if (type === 'empresa') {
            window.location.href = "/projeto_rh/editar-perfil.php";
          }
        } else {
          alert("Erro ao finalizar cadastro: " + data.message);
        }
      } catch (error) {
        console.error('Erro:', error);
        alert("Erro inesperado ao tentar salvar o cadastro.");
      }
    }
  </script>

</body>
</html>
