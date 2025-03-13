<?php 

session_start();
if ($_SESSION['usuario']['tipo_usuario'] !== 'empresa') {
    header("Location: acesso_negado.php"); // Ou outra página de erro
    exit;
}

?>