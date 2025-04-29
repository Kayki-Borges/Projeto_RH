<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location:/projeto_rh/login/login.php');
  exit;
}

$usuario = $_SESSION['usuario'];
$tipo_usuario = $usuario['tipo_usuario'];
$id_usuario = $usuario['id'];

// Inicia a sessão, se ainda não tiver sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lê os dados JSON do corpo da requisição
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verifica se o tipo foi enviado corretamente
if (!isset($data['tipo'])) {
    echo json_encode(['success' => false, 'message' => 'Tipo de usuário não enviado.']);
    exit;
}

// Salva na sessão (ou você pode salvar no banco de dados aqui)
$_SESSION['tipo_usuario'] = $data['tipo'];

// Retorna sucesso
echo json_encode(['success' => true]);
exit;
