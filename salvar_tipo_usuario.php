<?php
// salvar_tipo_usuario.php
header('Content-Type: application/json');
include('../conexao.php'); 

$data = json_decode(file_get_contents('php://input'), true);

// A chave correta para o 'user_id'
$user_id = $data['543793793556-rlo97asgftgul1624uo3phbbi4rh4eqr.apps.googleusercontent.com'];
$tipo = $data['tipo'];
$token = $data['token']; 

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
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar no banco: ' . $stmt->error]);
}
?>
