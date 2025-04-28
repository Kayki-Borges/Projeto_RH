<?php
// salvar_tipo_usuario.php
header('Content-Type: application/json');
include('../conexao.php'); // seu arquivo de conexão com o banco

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$tipo = $data['tipo'];
$token = $data['token']; // se precisar validar o token, faça aqui

if (!$user_id || !$tipo) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
    exit;
}

// Exemplo de update no banco
$sql = "UPDATE usuarios SET tipo_usuario = ?, token_google = ? WHERE id_google = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $tipo, $token, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar no banco']);
}
?>
