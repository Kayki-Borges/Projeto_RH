<?php
session_start();
session_destroy();
header("Location: /Projeto_RH/login/login.php");
exit();
?>
