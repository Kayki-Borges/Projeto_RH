<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['usuario'])) {
    echo "Usuário não autenticado!";
    exit;
}
$candidato_id = $_SESSION['usuario']['id']; // ou ['id_candidato'] se o nome da coluna for assim



try {
    // Busca os dados do candidato logado
    $stmt = $pdo->prepare("SELECT * FROM candidatos WHERE id = ?");
    $stmt->execute([$candidato_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se não encontrar, mostra mensagem de erro
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Candidato</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <style>
        /* Estilos já fornecidos */
    </style>
</head>
<body>
    <div class="container">
        <div class="profile">
            <div class="avatar">IL</div>
            <p><a href="#">Saiba porque não exibimos a foto de perfil</a></p>
        </div>
        <form action="salvar.php" method="POST" enctype="multipart/form-data">
    <label>Nome *</label>
    <input type="text" name="nome" value="<?php echo $row['nome_candidato']; ?>" required>

    <label>E-mail *</label>
    <input type="email" name="email" value="<?php echo $row['email_candidato']; ?>" required>

    <label>Telefone celular *</label>
    <input type="text" id="telefone" name="telefone" value="<?php echo $row['telefone_candidato']; ?>" required>

    <label>País de origem *</label>
    <select name="pais">
        <option selected>Brasil</option>
    </select>

    <label>CPF *</label>
    <input type="text" id="cpf" name="cpf" value="<?php echo $row['cpf_candidato']; ?>" required>

    <button type="button">Trocar senha</button>

    <!-- Upload de Foto do Currículo -->
    <label>Foto do currículo</label>

    <?php if (!empty($row['foto_candidato'])): ?>
        <img src="uploads/<?php echo $row['foto_candidato']; ?>" alt="Foto do Candidato" style="width: 120px; border-radius: 8px; margin-bottom: 10px;">
    <?php endif; ?>

    <input type="file" name="foto_candidato" accept="image/*">

    <label>Idioma</label>
    <div class="languages">
        <button type="button" class="selected">Português</button>
        <button type="button">English</button>
        <button type="button">Español</button>
    </div>

    <button type="submit">Salvar</button>
</form>

    </div>
    
    <script>
        $(document).ready(function(){
            $('#cpf').inputmask("999.999.999-99");
            $('#telefone').inputmask("(99) 99999-9999");
            $('#telefone_fixo').inputmask("(99) 9999-9999");
            $('#data_nascimento').inputmask("99/99/9999");
        });
    </script>
</body>
</html>
<style>
    /* Estilos globais */
body {
    font-family: Arial, sans-serif;
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
    background-color: #007bff;
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
    border-color: #007bff;
}

/* Botão de enviar */
button {
    background-color: #007bff;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
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
    background-color: #007bff;
    color: white;
}

.languages .selected {
    background-color: #007bff;
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

</style>

