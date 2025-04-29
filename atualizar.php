<?php
session_start();
require_once '../conexao.php'; // Incluindo a conexão com o banco


if (!isset($_SESSION['usuario'])) {
  header('Location:/projeto_rh/login/login.php');
  exit;
}

$usuario = $_SESSION['usuario'];
$tipo_usuario = $usuario['tipo_usuario'];
$id_usuario = $usuario['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $area_atuacao = $_POST['area_atuacao'];

    // Atualiza os dados na tabela correspondente (candidatos ou empresas)
    if ($tipo_usuario === 'candidato') {
        $sql = "UPDATE candidatos SET nome_candidato = ?, email_candidato = ?, telefone_candidato = ?, endereco_candidato = ?, area_atuacao = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $telefone, $endereco, $area_atuacao, $usuario['id']]);
    } elseif ($tipo_usuario === 'empresa') {
        $sql = "UPDATE empresas SET nome_empresa = ?, email_empresa = ?, telefone_empresa = ?, endereco_empresa = ?, area_atuacao = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $telefone, $endereco, $area_atuacao, $usuario['id']]);
    }

    // Redireciona para a página de perfil após salvar
    header('Location: perfil.php');
    exit();
}

// Preenche os dados do formulário com as informações do usuário logado
if ($tipo_usuario === 'candidato') {
    $sql = "SELECT * FROM candidatos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario['id']]);
    $dados = $stmt->fetch();
} elseif ($tipo_usuario === 'empresa') {
    $sql = "SELECT * FROM empresas WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario['id']]);
    $dados = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Dados</title>
</head>
<body>
    <h1>Atualizar Dados</h1>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($dados['nome_candidato'] ?? $dados['nome_empresa']); ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($dados['email_candidato'] ?? $dados['email_empresa']); ?>" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" value="<?php echo htmlspecialchars($dados['telefone_candidato'] ?? $dados['telefone_empresa']); ?>" required><br>

        <label for="endereco">Endereço:</label>
        <textarea name="endereco" id="endereco" required><?php echo htmlspecialchars($dados['endereco_candidato'] ?? $dados['endereco_empresa']); ?></textarea><br>

        <label for="area_atuacao">Área de Atuação:</label>
        <input type="text" name="area_atuacao" id="area_atuacao" value="<?php echo htmlspecialchars($dados['area_atuacao']); ?>" required><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
