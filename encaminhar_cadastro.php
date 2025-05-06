<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Escolher Perfil</title>

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
      height: 100vh;
      display: flex;
      overflow: hidden;
    }

    .left, .right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.4s ease;
    }

    .left {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: white;
      flex-direction: column;
      padding: 40px;
      text-align: center;
    }

    .left h1 {
      font-size: 36px;
      margin-bottom: 15px;
    }

    .left p {
      font-size: 16px;
      max-width: 320px;
      line-height: 1.5;
      opacity: 0.9;
    }

    .right {
      background-color: #f5f7fa;
      flex-direction: column;
      padding: 40px;
      animation: slideIn 0.6s ease;
      text-align: center;
    }

    .right h2 {
      font-size: 26px;
      color: #333;
      margin-bottom: 10px;
    }

    .right p {
      color: #666;
      font-size: 14px;
      margin-bottom: 30px;
    }

    .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      background-color: #2575fc;
      color: white;
      padding: 14px 20px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 20px;
      cursor: pointer;
      width: 240px;
      transition: all 0.3s ease;
    }

    .btn.empresa {
      background-color: #6a11cb;
    }

    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn i {
      font-size: 18px;
    }

    @keyframes slideIn {
      from {
        transform: translateX(50px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .left, .right {
        flex: none;
        width: 100%;
        height: 50vh;
      }

      .btn {
        width: 90%;
      }

      .left h1 {
        font-size: 28px;
      }

      .right h2 {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>

  <div class="left">
    <h1>Bem-vindo!</h1>
    <p>Vamos criar sua conta. Escolha abaixo como deseja se cadastrar.</p>
  </div>

  <div class="right">
    <h2>Selecione seu perfil</h2>
    <p>Escolha se você deseja se cadastrar como <strong>candidato</strong> ou <strong>empresa</strong>.</p>

    <button class="btn candidato" onclick="redirectToCadastro('candidato')">
      <i class="fas fa-user"></i> Cadastrar como Candidato
    </button>

    <button class="btn empresa" onclick="redirectToCadastro('empresa')">
      <i class="fas fa-building"></i> Cadastrar como Empresa
    </button>
  </div>

  <script>
    function redirectToCadastro(tipo) {
      if (tipo === 'candidato') {
        window.location.href = "/projeto_rh/cadastro/cadastro.php";
      } else if (tipo === 'empresa') {
        window.location.href = "/projeto_rh/cadastro/cadastro_empresa.php";
      }
    }
  </script>

</body>
</html>
