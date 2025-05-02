<?php
header('Content-Type: application/json');
// session_start();

// if (!isset($_SESSION['usuario'])) {
//   header('Location:/projeto_rh/login/login.php');
//   exit;
// }

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['tipo'])) {
    echo json_encode(['success' => false, 'message' => 'Tipo de usuário não enviado.']);
    exit;
}

// Simula sucesso sem verificar sessão
echo json_encode(['success' => true]);
exit;
