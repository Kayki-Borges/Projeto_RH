<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  echo json_encode(['success' => false, 'message' => 'Sessão expirada.']);
  exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['tipo'])) {
    echo json_encode(['success' => false, 'message' => 'Tipo de usuário não enviado.']);
    exit;
}

// Simula sucesso
echo json_encode(['success' => true]);
exit;
