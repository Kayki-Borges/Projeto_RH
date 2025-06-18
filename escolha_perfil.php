<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Finalizar Cadastro</title>

  <!-- Fonte Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f7f8fc;
      color: #333;
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    .container {
      display: flex;
      width: 90%;
      max-width: 1000px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      border-radius: 15px;
      overflow: hidden;
      background-color: white;
      animation: slideIn 0.5s ease-in-out;
    }

    /* Lado esquerdo */
    .left {
      flex: 1;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      opacity: 0;
      animation: fadeLeft 0.8s ease-out forwards;
    }

    @keyframes fadeLeft {
      0% { opacity: 0; transform: translateX(-50px); }
      100% { opacity: 1; transform: translateX(0); }
    }

    .left h1 {
      font-size: 36px;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }

    .left p {
      font-size: 16px;
      max-width: 280px;
      text-align: center;
      opacity: 0.8;
    }

    /* Lado direito */
    .right {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      opacity: 0;
      animation: fadeRight 0.8s ease-out 0.3s forwards;
    }

    @keyframes fadeRight {
      0% { opacity: 0; transform: translateX(50px); }
      100% { opacity: 1; transform: translateX(0); }
    }

    .right h2 {
      font-size: 28px;
      font-weight: 600;
      color: #333;
      margin-bottom: 20px;
    }

    .right p {
      font-size: 16px;
      color: #555;
      text-align: center;
      margin-bottom: 40px;
    }

    /* Botões */
    .btn {
      width: 100%;
      max-width: 300px;
      padding: 14px 0;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      text-align: center;
      cursor: pointer;
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
      background-color: #A3C6FF; /* Cor suave */
      color: #333;
      border: 2px solid transparent;
      transition: all 0.4s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
      background-color: #4a90e2;
      color: white;
      transform: scale(1.05);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      border-color: #4a90e2;
    }

    .btn.empresa {
      background-color:rgb(168, 114, 226);; /* Cor suave para empresa */
    }

    .btn.empresa:hover {
      background-color: #9b4de5;
    }

    .btn i {
      font-size: 20px;
    }

    /* Efeito de hover para a seção esquerda */
    .left:hover {
      transform: scale(1.02);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Responsividade */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        max-width: 90%;
      }

      .left, .right {
        width: 100%;
        padding: 30px;
      }

      .left h1 {
        font-size: 28px;
      }

      .right h2 {
        font-size: 24px;
      }

      .btn {
        width: 90%;
      }
    }

  </style>
</head>
<body>

  <div class="container">
    <!-- Lado Esquerdo -->
    <div class="left">
      <h1>Finalizar Cadastro</h1>
      <p>Escolha o tipo de conta para completar seu perfil.</p>
    </div>

    <!-- Lado Direito -->
    <div class="right">
      <h2>Selecione seu perfil</h2>
      <p>Escolha se você deseja finalizar seu cadastro como <strong>candidato</strong> ou <strong>empresa</strong>.</p>

      <!-- Botão para Candidato -->
      <button class="btn candidato" onclick="completeRegistration('candidato')">
        <i class="fas fa-user"></i> Sou Candidato
      </button>

      <!-- Botão para Empresa -->
      <button class="btn empresa" onclick="completeRegistration('empresa')">
        <i class="fas fa-building"></i> Sou Empresa
      </button>
    </div>
  </div>

  <script>
    async function completeRegistration(type) {
      try {
        const response = await fetch('/projeto_rh/salvar_tipo_usuario.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ tipo: type }),
  credentials: 'include' // <- Adicionado aqui!
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
