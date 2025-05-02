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
 

// Capturando os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_empresa'];
    $email = $_POST['email_empresa'];
    $cnpj = $_POST['cnpj_empresa'];
    $endereco = $_POST['endereco_empresa'];
    $telefone = $_POST['telefone_empresa'];
    $area_atuacao = $_POST['area_atuacao'];
    $senha = $_POST['senha_empresa'];

    // Atualizando os dados no banco de dados
    $sql = "UPDATE empresas SET nome = :nome, email = :email, cnpj = :cnpj, endereco = :endereco, telefone = :telefone, area_atuacao = :area_atuacao, senha = :senha WHERE id_empresa = :id_empresa";

    $stmt = $pdo->prepare($sql);

    // Bind dos parâmetros
    $stmt->bindParam(':nome_empresa', $nome);
    $stmt->bindParam(':email_empresa', $email);
    $stmt->bindParam(':cnpj_empresa', $cnpj);
    $stmt->bindParam(':endereco_empresa', $endereco);
    $stmt->bindParam(':telefone_empresa', $telefone);
    $stmt->bindParam(':area_atuacao', $area_atuacao);
    $stmt->bindParam(':senha_empresa', $senha);
    $stmt->bindParam(':id_empresa', $id_empresa); // Certifique-se de que você tem o ID correto

    // Executando a query
    if ($stmt->execute()) {
        echo "<p>Dados atualizados com sucesso!</p>";
    } else {
        echo "<p>Erro ao atualizar dados.</p>";
    }
}
?>
