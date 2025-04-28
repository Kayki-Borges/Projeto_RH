
<?php
session_start();
require 'conexao.php'; // seu arquivo de conexão PDO

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redireciona se não estiver logado
    exit;
}

// Detectar se é candidato ou empresa
$usuario = $_SESSION['usuario'];
$tipo_usuario = $usuario['tipo_usuario']; // 'candidato' ou 'empresa'
$id_usuario = $usuario['id']; // id do candidato ou empresa

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($tipo_usuario == 'candidato') {
        // Dados do formulário do candidato
        $nome = $_POST['nome_candidato'];
        $email = $_POST['email_candidato'];
        $cpf = $_POST['cpf_candidato'];
        $endereco = $_POST['endereco_candidato'];
        $telefone = $_POST['telefone_candidato'];
        $formacao = $_POST['formacao_academica'];
        $experiencia = $_POST['experiencia_profissional'];
        $area = $_POST['area_atuacao'];

        // Atualizar no banco de dados
        $sql = "UPDATE candidatos SET 
                    nome_candidato = :nome, 
                    email_candidato = :email, 
                    cpf_candidato = :cpf,
                    endereco_candidato = :endereco,
                    telefone_candidato = :telefone,
                    formacao_academica = :formacao,
                    experiencia_profissional = :experiencia,
                    area_atuacao = :area
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':cpf' => $cpf,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':formacao' => $formacao,
            ':experiencia' => $experiencia,
            ':area' => $area,
            ':id' => $id_usuario
        ]);

        echo "Perfil de candidato atualizado com sucesso!";

    } elseif ($tipo_usuario == 'empresa') {
        // Dados do formulário da empresa
        $nome = $_POST['nome_empresa'];
        $email = $_POST['email_empresa'];
        $cnpj = $_POST['cnpj_empresa'];
        $endereco = $_POST['endereco_empresa'];
        $telefone = $_POST['telefone_empresa'];
        $area = $_POST['area_atuacao'];

        // Atualizar no banco de dados
        $sql = "UPDATE empresas SET 
                    nome_empresa = :nome, 
                    email_empresa = :email, 
                    cnpj_empresa = :cnpj,
                    endereco_empresa = :endereco,
                    telefone_empresa = :telefone,
                    area_atuacao = :area
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':cnpj' => $cnpj,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':area' => $area,
            ':id' => $id_usuario
        ]);

        echo "Perfil de empresa atualizado com sucesso!";
    }
}
?>

<!-- Formulário de edição -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
</head>
<body>

<h2>Editar Perfil</h2>

<form method="POST">
    <?php if ($tipo_usuario == 'candidato'): ?>
        Nome: <input type="text" name="nome_candidato" value="<?= htmlspecialchars($usuario['nome_candidato']) ?>"><br>
        Email: <input type="email" name="email_candidato" value="<?= htmlspecialchars($usuario['email_candidato']) ?>"><br>
        CPF: <input type="text" name="cpf_candidato" value="<?= htmlspecialchars($usuario['cpf_candidato']) ?>"><br>
        Endereço: <input type="text" name="endereco_candidato" value="<?= htmlspecialchars($usuario['endereco_candidato']) ?>"><br>
        Telefone: <input type="text" name="telefone_candidato" value="<?= htmlspecialchars($usuario['telefone_candidato']) ?>"><br>
        Formação Acadêmica: <input type="text" name="formacao_academica" value="<?= htmlspecialchars($usuario['formacao_academica']) ?>"><br>
        Experiência Profissional: <textarea name="experiencia_profissional"><?= htmlspecialchars($usuario['experiencia_profissional']) ?></textarea><br>
        Área de Atuação: <input type="text" name="area_atuacao" value="<?= htmlspecialchars($usuario['area_atuacao']) ?>"><br>
    <?php elseif ($tipo_usuario == 'empresa'): ?>
        Nome da Empresa: <input type="text" name="nome_empresa" value="<?= htmlspecialchars($usuario['nome_empresa']) ?>"><br>
        Email: <input type="email" name="email_empresa" value="<?= htmlspecialchars($usuario['email_empresa']) ?>"><br>
        CNPJ: <input type="text" name="cnpj_empresa" value="<?= htmlspecialchars($usuario['cnpj_empresa']) ?>"><br>
        Endereço: <input type="text" name="endereco_empresa" value="<?= htmlspecialchars($usuario['endereco_empresa']) ?>"><br>
        Telefone: <input type="text" name="telefone_empresa" value="<?= htmlspecialchars($usuario['telefone_empresa']) ?>"><br>
        Área de Atuação: <input type="text" name="area_atuacao" value="<?= htmlspecialchars($usuario['area_atuacao']) ?>"><br>
    <?php endif; ?>

    <br>
    <input type="submit" value="Salvar">
</form>

</body>
</html>
