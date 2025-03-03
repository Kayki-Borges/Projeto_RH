<?php
$host = "localhost"; // ou IP do servidor
$dbname = "projeto_rh";
$user = "root"; // seu usuário de banco de dados
$pass = ""; // sua senha de banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
