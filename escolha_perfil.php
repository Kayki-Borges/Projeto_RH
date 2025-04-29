<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Finalizar Cadastro</title>

  <style>
    /*Configurações básicas*/
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

.poppins-medium {
    font-family: "Poppins", sans-serif;
    font-weight: 500;
    font-style: normal;
}

    body {
      font-family: 'Poppins', sans-serif;
<<<<<<< HEAD
      background: linear-gradient(135deg, rgb(129, 59, 221), rgb(64, 136, 214));
=======
      background: linear-gradient(135deg,rgb(129, 59, 221),#4088d6);
>>>>>>> 85fa376ebcfc9138785d53bcf013acc6919e1562
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

    .choice-button:nth-child(3){
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      padding: 14px;
      margin-bottom: 20px;
      border: none;
      border-radius: 10px;
      background: #4088d6;
      color: white;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: .3s all ease-in-out;
      gap: 10px;
    }

    .choice-button:nth-child(4){
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
      transition: .3s all ease-in-out;
      gap: 10px;
    }


    .choice-button:hover {
      background: rgb(158, 62, 196);
      transform: scale(1.05);
    }
  .choice-button:nth-child(3):hover{
    background: #4088d6;
    transform: scale(1.1);
  }
    .choice-button:nth-child(4):hover {
      background: #9D61EA;
      transform: scale(1.1);

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
