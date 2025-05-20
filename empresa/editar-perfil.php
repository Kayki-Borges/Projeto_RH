<?php
session_start();
require '../conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location:/projeto_rh/login/login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$tipo_usuario = $usuario['tipo_usuario'];
$id_usuario = $usuario['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($tipo_usuario == 'candidato') {
        $stmt = $pdo->prepare("UPDATE candidatos SET nome_candidato = :nome, email_candidato = :email, cpf_candidato = :cpf, endereco_candidato = :endereco, telefone_candidato = :telefone, formacao_academica = :formacao, experiencia_profissional = :experiencia, area_atuacao = :area WHERE id = :id");
        $stmt->execute([
            ':nome' => $_POST['nome_candidato'],
            ':email' => $_POST['email_candidato'],
            ':cpf' => $_POST['cpf_candidato'],
            ':endereco' => $_POST['endereco_candidato'],
            ':telefone' => $_POST['telefone_candidato'],
            ':formacao' => $_POST['formacao_academica'],
            ':experiencia' => $_POST['experiencia_profissional'],
            ':area' => $_POST['area_atuacao'],
            ':id' => $id_usuario
        ]);
    } elseif ($tipo_usuario == 'empresa') {
        $stmt = $pdo->prepare("UPDATE empresas SET nome_empresa = :nome, email_empresa = :email, cnpj_empresa = :cnpj, endereco_empresa = :endereco, telefone_empresa = :telefone, area_atuacao = :area WHERE id = :id");
        $stmt->execute([
            ':nome' => $_POST['nome_empresa'],
            ':email' => $_POST['email_empresa'],
            ':cnpj' => $_POST['cnpj_empresa'],
            ':endereco' => $_POST['endereco_empresa'],
            ':telefone' => $_POST['telefone_empresa'],
            ':area' => $_POST['area_atuacao'],
            ':id' => $id_usuario
        ]);
    }

    echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = '/projeto_rh/empresa/pagina-empresa log.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <script src="/projeto_rh/js/dark.js"></script>
<link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
</head>
<body>
    <button class="mud" id="MudarMod" onclick="mod()">Mudar modo!</button>
    <div class="container">
        <a class="back-button" href="/projeto_rh/empresa/pagina-empresa log.php"><i class="fas fa-arrow-left"></i> Voltar</a>
        <h2>Editar Perfil</h2>
        <form method="POST">
            <?php if ($tipo_usuario == 'candidato'): ?>
                <input type="text" name="nome_candidato" placeholder="Nome" value="<?= htmlspecialchars($usuario['nome_candidato']) ?>">
                <input type="email" name="email_candidato" placeholder="Email" value="<?= htmlspecialchars($usuario['email_candidato']) ?>">
                <input type="text" name="cpf_candidato" placeholder="CPF" value="<?= htmlspecialchars($usuario['cpf_candidato']) ?>">
                <input type="text" name="endereco_candidato" placeholder="Endereço" value="<?= htmlspecialchars($usuario['endereco_candidato']) ?>">
                <input type="text" name="telefone_candidato" placeholder="Telefone" value="<?= htmlspecialchars($usuario['telefone_candidato']) ?>">
                <input type="text" name="formacao_academica" placeholder="Formação Acadêmica" value="<?= htmlspecialchars($usuario['formacao_academica']) ?>">
                <textarea name="experiencia_profissional" placeholder="Experiência Profissional"><?= htmlspecialchars($usuario['experiencia_profissional']) ?></textarea>
                <input type="text" name="area_atuacao" placeholder="Área de Atuação" value="<?= htmlspecialchars($usuario['area_atuacao']) ?>">
            <?php else: ?>
                <input type="text" name="nome_empresa" placeholder="Nome da Empresa" value="<?= htmlspecialchars($usuario['nome_empresa']) ?>">
                <input type="email" name="email_empresa" placeholder="Email" value="<?= htmlspecialchars($usuario['email_empresa']) ?>">
                <input type="text" name="cnpj_empresa" placeholder="CNPJ" value="<?= htmlspecialchars($usuario['cnpj_empresa']) ?>">
                <input type="text" name="endereco_empresa" placeholder="Endereço" value="<?= htmlspecialchars($usuario['endereco_empresa']) ?>">
                <input type="text" name="telefone_empresa" placeholder="Telefone" value="<?= htmlspecialchars($usuario['telefone_empresa']) ?>">
                <input type="text" name="area_atuacao" placeholder="Área de Atuação" value="<?= htmlspecialchars($usuario['area_atuacao']) ?>">
            <?php endif; ?>
            <input type="submit" value="Salvar Alterações">
        </form>
    </div>
</body>
</html>
