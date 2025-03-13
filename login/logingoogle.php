<?php
session_start();
header('Content-Type: application/json');


// Adicionando os cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// O restante do código...

require_once "../cadastro/conexao.php"; // Caminho para sua conexão com o banco de dados

// Verifica o domínio do e-mail (exemplo para google.com)
if (strpos($dados['email'], '@google.com') === false) {
    echo json_encode(["status" => "error", "message" => "Email não permitido"]);
    exit;
}

// Função para decodificar o token do Google
function decodeGoogleToken($token) {
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Verifica se o token foi enviado
if (!isset($_POST['token'])) {
    echo json_encode(["status" => "error", "message" => "Token não recebido"]);
    exit;
}

$token = $_POST['token'];
$dados = decodeGoogleToken($token);

// Verifica a validade do token
if (!$dados || !isset($dados["email"])) {
    echo json_encode(["status" => "error", "message" => "Falha na autenticação"]);
    exit;
}

$email = $dados["email"];
$nome = $dados["name"];

// Consulta para verificar se o usuário já está no banco
$sql = "SELECT id, tipo_usuario FROM candidatos WHERE email_candidato = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário existe
if ($result) {
    $usuario = $result;
    $_SESSION["usuario"] = $usuario;  // Armazena os dados do usuário na sessão

    // Redireciona com base no tipo de usuário
    if ($usuario['tipo_usuario'] == 'empresa') {
        echo json_encode(["status" => "success", "redirect" => "dashboard_empresa.php"]);
    } else {
        echo json_encode(["status" => "success", "redirect" => "dashboard_usuario.php"]);
    }
} else {
    // Processo de cadastro de um novo usuário
    $sql = "INSERT INTO candidatos (nome_candidato, email_candidato, tipo_usuario) VALUES (:nome, :email, 'candidato')";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION["usuario"] = ["id" => $pdo->lastInsertId(), "nome" => $nome, "email" => $email, "tipo_usuario" => 'candidato'];

        echo json_encode(["status" => "success", "redirect" => "dashboard_usuario.php"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao cadastrar usuário"]);
    }
}
?>
