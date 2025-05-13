<?php
session_start();
require_once('../conexao.php');

if (!isset($_SESSION['usuario']['id'])) {
    echo "Usuário não autenticado!";
    exit;
}

$candidato_id = $_SESSION['usuario']['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM candidatos WHERE id = ?");
    $stmt->execute([$candidato_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Candidato não encontrado no banco de dados.";
        exit();
    }
} catch (PDOException $e) {
    echo "Erro ao buscar candidato: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Candidato</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
</head>
<body>
<a href="/projeto_rh/candidato/pagina-usuario log.php"><button class="but-volt">Voltar</button></a>
<div class="container">
    <div class="profile">
        <div class="avatar">IL</div>
        <p><a href="#">Saiba porque não exibimos a foto de perfil</a></p>
    </div>
    <form action="/projeto_rh/candidato/salvar.php" method="POST" enctype="multipart/form-data">
        <label>Nome *</label>
        <input type="text" name="nome" value="<?php echo $row['nome_candidato']; ?>" disabled>

        <label>E-mail *</label>
        <input type="email" name="email" value="<?php echo $row['email_candidato']; ?>" disabled>

        <label>Telefone celular *</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $row['telefone_candidato']; ?>" disabled>

        <label>País de origem *</label>
        <select name="pais" disabled>
            <option selected>Brasil</option>
        </select>

        <label>CPF *</label>
        <input type="text" id="cpf" name="cpf" value="<?php echo $row['cpf_candidato']; ?>" disabled>

        <button type="button" disabled style="background-color: #ccc; cursor: not-allowed;">Trocar senha</button>

        <label>Foto do currículo</label>

        <?php if (!empty($row['foto_candidato'])): ?>
            <p>Imagem atual:</p>
            <a href="uploads/<?php echo htmlspecialchars($row['foto_candidato']); ?>" target="_blank">
                <img src="uploads/<?php echo htmlspecialchars($row['foto_candidato']); ?>" alt="Foto do Candidato"
                     style="width: 120px; border-radius: 8px; margin-bottom: 10px;">
            </a>
        <?php else: ?>
            <p style="color: #777;">Nenhuma imagem enviada ainda.</p>
        <?php endif; ?>

        <input type="file" name="foto_candidato" accept="image/*" required>

        <button type="submit">Salvar</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#cpf').inputmask("999.999.999-99");
        $('#telefone').inputmask("(99) 99999-9999");
    });
</script>
</body>
</html>

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
    /* Estilos globais */
body {
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Container principal do perfil */
.container {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    width: 400px;
    max-width: 100%;
    text-align: center;
}

/* Avatar do perfil */
.profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}

.avatar {
    width: 60px;
    height: 60px;
    background-color: #488BE8;
    color: white;
    font-size: 28px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-bottom: 10px;
}

.profile p {
    font-size: 14px;
    color: #555;
}

/* Formulário */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Estilos dos rótulos e entradas */
label {
    text-align: left;
    font-weight: bold;
    color: #333;
}

input, select, button {
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 100%;
    box-sizing: border-box;
    font-size: 14px;
    color: #333;
}

input:focus, select:focus, button:focus {
    outline: none;
    border-color: #488BE8;
}

/* Botão de enviar */
button {
    background-color: #488BE8;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #488BE8;
}

/* Botões para selecionar idiomas */
.languages {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.languages button {
    flex: 1;
    padding: 8px;
    background-color: #ddd;
    border: none;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.languages button:hover {
    background-color: #488BE8;
    color: white;
}

.languages .selected {
    background-color: #488BE8;
    color: white;
}

/* Input mascarado (CPF, telefone, etc.) */
input[type="text"], input[type="email"] {
    font-size: 16px;
    color: #333;
}

/* Estilo de mensagens de erro */
.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}
.but-volt{
            position: fixed;
            width: 100px;
            top: 10px;
            left: 10px;
            background: linear-gradient(to right, #488BE8,#9D61EA);
            color: white;
            cursor: pointer;
            transition:.5s all ease-in-out;
            border: none;
        }

        .but-volt a{
            text-decoration: none;
            color: #ffff;
            font-family: Poppins, sans-serif;
        }
</style>