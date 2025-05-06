<?php
require './conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_empresa'] ?? '';
    $email = $_POST['email_empresa'] ?? '';
    $cnpj = $_POST['cnpj_empresa'] ?? '';
    $endereco = $_POST['endereco_empresa'] ?? '';
    $telefone = $_POST['telefone_empresa'] ?? '';
    $area_atuacao = $_POST['area_atuacao'] ?? '';
    $senha = $_POST['senha_empresa'] ?? '';
    $id_empresa = $_SESSION['id_empresa'] ?? null; // ou $_POST['id_empresa']

    if ($id_empresa) {
        $sql = "UPDATE empresas 
                SET nome_empresa = :nome_empresa, 
                    email_empresa = :email_empresa, 
                    cnpj_empresa = :cnpj_empresa, 
                    endereco_empresa = :endereco_empresa, 
                    telefone_empresa = :telefone_empresa, 
                    area_atuacao = :area_atuacao, 
                    senha_empresa = :senha_empresa 
                WHERE id = :id_empresa";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome_empresa', $nome);
        $stmt->bindParam(':email_empresa', $email);
        $stmt->bindParam(':cnpj_empresa', $cnpj);
        $stmt->bindParam(':endereco_empresa', $endereco);
        $stmt->bindParam(':telefone_empresa', $telefone);
        $stmt->bindParam(':area_atuacao', $area_atuacao);
        $stmt->bindParam(':senha_empresa', $senha);
        $stmt->bindParam(':id_empresa', $id_empresa);

        if ($stmt->execute()) {
            echo "<p>Dados atualizados com sucesso!</p>";
        } else {
            echo "<p>Erro ao atualizar dados.</p>";
        }
    } else {
        echo "<p>ID da empresa não encontrado.</p>";
    }
}
?>
