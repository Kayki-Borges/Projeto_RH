<?php
session_start();
require '../conexao.php';

// Usar email fixo conforme solicitado:
$email_usuario = "wwwisaque18@gmail.com";

// Busca o tipo do usuário pelo email no banco (tentei inferir, pois a sessão não está sendo usada)
$tipo_usuario = null;

// Tenta encontrar o usuário na tabela candidatos
$stmt = $pdo->prepare("SELECT * FROM candidatos WHERE email_candidato = :email");
$stmt->bindParam(':email', $email_usuario);
$stmt->execute();
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if ($dados) {
    $tipo_usuario = 'candidato';
} else {
    // Se não encontrou em candidatos, tenta em empresas
    $stmt = $pdo->prepare("SELECT * FROM empresas WHERE email_empresa = :email");
    $stmt->bindParam(':email', $email_usuario);
    $stmt->execute();
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados) {
        $tipo_usuario = 'empresa';
    }
}

if (!$tipo_usuario) {
    echo "Usuário não encontrado com o email: $email_usuario";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do formulário
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $cnpj = $_POST['cnpj'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';

    if ($tipo_usuario === 'candidato') {
        $query = "UPDATE candidatos SET nome_candidato = :nome, cpf_candidato = :cpf, telefone_candidato = :telefone, endereco_candidato = :endereco WHERE email_candidato = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cpf', $cpf);
    } else { // empresa
        $query = "UPDATE empresas SET nome_empresa = :nome, cnpj_empresa = :cnpj, telefone_empresa = :telefone, endereco_empresa = :endereco WHERE email_empresa = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cnpj', $cnpj);
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':email', $email_usuario);

    if ($stmt->execute()) {
        if ($tipo_usuario === 'candidato') {
            $redirect = '/projeto_rh/candidato/pagina-candidato.php';
        } else {
            $redirect = '/projeto_rh/empresa/pagina-empresa log.php';
        }
        echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = '$redirect';</script>";
        exit;
    } else {
        echo "Erro ao atualizar perfil.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="/projeto_rh/css/style.css" />
    <script src="/projeto_rh/js/dark.js"></script>
</head>
<body>
    <main>
        <div class="container">
            <h1>Editar Perfil</h1>

            <form method="POST" action="">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required
                    value="<?= htmlspecialchars($dados[$tipo_usuario === 'candidato' ? 'nome_candidato' : 'nome_empresa'] ?? '') ?>" />

                <?php if ($tipo_usuario === 'candidato'): ?>
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($dados['cpf_candidato'] ?? '') ?>" />
                <?php else: ?>
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" value="<?= htmlspecialchars($dados['cnpj_empresa'] ?? '') ?>" />
                <?php endif; ?>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone"
                    value="<?= htmlspecialchars($dados[$tipo_usuario === 'candidato' ? 'telefone_candidato' : 'telefone_empresa'] ?? '') ?>" />

                <label for="endereco">Endereço:</label>
                <textarea id="endereco" name="endereco"><?= htmlspecialchars($dados[$tipo_usuario === 'candidato' ? 'endereco_candidato' : 'endereco_empresa'] ?? '') ?></textarea>

                <button type="submit">Atualizar Perfil</button>
            </form>
        </div>
    </main>
</body>
</html>

<style>
/* Seu CSS (copiado do código que enviou) */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}
/* ... resto do CSS ... */
body {
    background: linear-gradient(135deg, #488BE8, #9D61EA);
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    animation: fadeBackground 10s infinite alternate;
}
button[type="submit"] {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    border: none;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 12px 25px;
    border-radius: 30px;
    cursor: pointer;
    box-shadow: 0 6px 15px rgba(101, 52, 255, 0.5);
    transition: all 0.3s ease;
    letter-spacing: 0.05em;
}

button[type="submit"]:hover {
    background: linear-gradient(135deg, #2575fc, #6a11cb);
    box-shadow: 0 8px 20px rgba(101, 52, 255, 0.8);
    transform: translateY(-3px);
}

button[type="submit"]:active {
    transform: translateY(0);
    box-shadow: 0 4px 10px rgba(101, 52, 255, 0.4);
}

</style>

    <style>

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

        .switch {
  display: block;
  --width-of-switch: 3.5em;
  --height-of-switch: 2em;
  /* size of sliding icon -- sun and moon */
  --size-of-icon: 1.4em;
  /* it is like a inline-padding of switch */
  --slider-offset: 0.3em;
  position: fixed;
  top: 93vh;
  left: 190vh;
  z-index: 9999999;
  width: var(--width-of-switch);
  height: var(--height-of-switch);
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
  border: 2px solid #252525;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cfdcff;
  transition: .4s;
  border-radius: 30px;
}

.slider:before {
  position: absolute;
  content: "";
  height: var(--size-of-icon,1.4em);
  width: var(--size-of-icon,1.4em);
  border-radius: 20px;
  left: var(--slider-offset,0.3em);
  top: 50%;
  transform: translateY(-50%);
  background: linear-gradient(40deg,#ff0080,#ff8c00 70%);
  ;
 transition: .4s;
}

input:checked + .slider {
  background-color: #303136;
}

input:checked + .slider:before {
  left: calc(100% - (var(--size-of-icon,1.4em) + var(--slider-offset,0.3em)));
  background: #303136;
  /* change the value of second inset in box-shadow to change the angle and direction of the moon  */
  box-shadow: inset -3px -2px 5px -2px #8983f7, inset -10px -4px 0 0 #a3dafb;
}

        body {
            background: linear-gradient(135deg, #488BE8, #9D61EA);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            animation: fadeBackground 10s infinite alternate;
        }

        @keyframes fadeBackground {
            from { background-position: left; }
            to { background-position: right; }
        }

        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            animation: fadeInUp 0.8s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #9D61EA;
            margin-bottom: 25px;
            font-size: 30px;
        }

        form input, form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            transition: 0.3s;
        }

        form input:focus, form textarea:focus {
            border-color:#9D61EA;
            box-shadow: 0 0 5px rgba(0, 119, 182, 0.4);
            outline: none;
        }

        form input[type="submit"] {
            background-color: #9D61EA;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s all ease-in-out;
        }

        form input[type="submit"]:hover {
            background-color: #9D61EA;
            transform:scale(1.1);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            background-color: #f0f0f0;
            padding: 10px 15px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .back-button i {
            margin-right: 8px;
            transition: .3s all ease-in-out;
        }

        .back-button:hover {
            transform: scale(1.1);
            color: white;
            background: linear-gradient(to right, #488BE8,#9D61EA);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }

        #MudarMod {
        background: linear-gradient(to right, #ffbb52, white);
        position: fixed;
        z-index: 99999999;
        cursor: pointer;
        top: 95vh;
        left: 188vh;
        border-radius: 5px;
        border: none;
        width: 100px;
        height: 30px;
        transition: .3s all ease-in-out;
      }

      #MudarMod:hover {
        transform: scale(1.1);
      }

       body.dark-mode{
        background-color: #252525;
      }

      body.dark-mode .container{
        background-color: #252525;
      }

      body.dark-mode .back-button {
        background-color:rgb(90, 90, 90);
        color: white;
      }
    </style>

