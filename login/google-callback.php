<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

// Adicionando cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once "cadastro/conexao.php";  // Inclua o arquivo de conexão com o banco

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

// Verifica se o token foi recebido
if (!isset($_POST['token'])) {
    echo json_encode(["status" => "error", "message" => "Token não recebido"]);
    exit;
}

$token = $_POST['token'];
$dados = decodeGoogleToken($token);

if (!$dados || !isset($dados["email"])) {
    echo json_encode(["status" => "error", "message" => "Falha na autenticação"]);
    exit;
}

$email = $dados["email"];
$nome = $dados["name"];

// Verifica se o usuário já existe no banco de dados
$sql = "SELECT id, tipo_usuario FROM candidatos WHERE email_candidato = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    // Usuário novo, precisa completar o cadastro
    echo json_encode(["status" => "success", "redirect" => "/login/escolha_perfil.php"]);
    exit;
}

// Se o usuário existe, armazena os dados na sessão
$_SESSION["usuario"] = $usuario;

// Redireciona para o dashboard do tipo de usuário
if ($usuario['tipo_usuario'] === 'empresa') {
    echo json_encode(["status" => "success", "redirect" => "/login/dashboard_empresa.php"]);
} else {
    echo json_encode(["status" => "success", "redirect" => "/login/dashboard_usuario.php"]);
}
?>
