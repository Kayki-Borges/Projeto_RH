<?php
session_start();
require '../conexao.php';

$usuarioId = $_SESSION['id']; // pegue o ID do usuário logado
$vagaId = $_POST['id'] ?? null;

if ($usuarioId && $vagaId) {
    $stmt = $pdo->prepare("INSERT INTO candidaturas (id, id, status) VALUES (:id, :id, 'em_andamento')");
    $stmt->execute([
        'id' => $usuarioId,
        'id' => $vagaId
    ]);

    header("Location: minhas_candidaturas.php");
    exit;
} else {
    echo "Erro ao se candidatar.";
}
