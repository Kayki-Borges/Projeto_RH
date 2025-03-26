<?php
session_start(); // Inicia a sessão

require_once('../conexao.php');

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtendo os dados do formulário
    $nome_empresa = $_POST['nome_empresa'] ?? '';
    $email_empresa = $_POST['email_empresa'] ?? '';
    $cnpj_empresa = $_POST['cnpj_empresa'] ?? '';
    $endereco_empresa = $_POST['endereco_empresa'] ?? '';
    $telefone_empresa = $_POST['telefone_empresa'] ?? '';
    $area_atuacao = $_POST['area_atuacao'] ?? '';
    $senha = $_POST['senha_empresa'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha_empresa'] ?? '';  // Adicionei a captura da variável confirmar_senha

    // Validação da senha
    if ($senha != $confirmar_senha) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Tipo de usuário (empresa)
    $tipo_usuario = 'empresa';

    // Inserção no banco de dados
    try {
        $sql = "INSERT INTO empresas (nome_empresa, email_empresa, cnpj_empresa, endereco_empresa, telefone_empresa, senha_empresa, tipo_usuario) 
        VALUES (?, ?, ?, ?, ?, ?, 'empresa')";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nome_empresa, $email_empresa, $cnpj_empresa, $endereco_empresa, $telefone_empresa, $senha_hash]);

        // Definir a variável de sessão para indicar sucesso no cadastro
        $_SESSION['cadastro_sucesso'] = true;

        // Redireciona para a página de confirmação
        header("Location:/Projeto_RH/login/login.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>
