<?php
session_start();
require_once('../conexao.php');


if (!isset( $_SESSION['usuario']['id'])) {
    echo "Usuário não autenticado!";
    exit;
}


$candidato_id = $_SESSION['usuario']['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];


// Upload da foto
$foto_nome = null;

if (isset($_FILES['foto_candidato']) && $_FILES['foto_candidato']['error'] === UPLOAD_ERR_OK) {
    $extensao = pathinfo($_FILES['foto_candidato']['name'], PATHINFO_EXTENSION);
    $foto_nome = uniqid() . '.' . $extensao;
    move_uploaded_file($_FILES['foto_candidato']['tmp_name'], 'uploads/' . $foto_nome);
}

// Atualiza o banco
try {
    $sql = "UPDATE candidatos SET 
                nome_candidato = ?, 
                email_candidato = ?, 
                cpf_candidato = ?, 
                telefone_candidato = ?"; 
                

    $params = [$nome, $email, $cpf, $telefone];

    if ($foto_nome !== null) {
        $sql .= ", foto_candidato = ?";
        $params[] = $foto_nome;
    }

    $sql .= " WHERE id = ?";
    $params[] = $candidato_id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo "Dados atualizados com sucesso!";
    // Redireciona ou exibe uma mensagem
    header("Location:/projeto_rh/candidato/curriculo.php");
    exit;
} catch (PDOException $e) {
    echo "Erro ao salvar dados: " . $e->getMessage();
    exit;
}
?>
