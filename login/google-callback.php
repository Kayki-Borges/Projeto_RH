<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once("../conexao.php");

function decodeGoogleToken($token) {
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

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

// Verifica se é candidato
$sql_candidato = "SELECT id, tipo_usuario FROM candidatos WHERE email_candidato = :email";
$stmt = $pdo->prepare($sql_candidato);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não é candidato, verifica se é empresa
if (!$usuario) {
    $sql_empresa = "SELECT id, tipo_usuario FROM empresas WHERE email_empresa = :email";
    $stmt = $pdo->prepare($sql_empresa);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$usuario) {
    // Usuário novo, precisa completar cadastro
    // Você pode guardar nome/email temporariamente na sessão ou banco para pré-cadastro
    $_SESSION['usuario_google'] = [
        'nome' => $nome,
        'email' => $email,
        'id_google' => $dados['sub']
    ];

    echo json_encode(["status" => "success", "redirect" => "/projeto_rh/escolha_perfil.php"]);
    exit;
}

// Usuário existe, salva na sessão (padronizando nomes)
$_SESSION['usuario'] = $usuario;
$_SESSION['tipo'] = $usuario['tipo_usuario'];

// Se o perfil não foi escolhido
if ($usuario['tipo_usuario'] == null) {
    echo json_encode(["status" => "success", "redirect" => "/projeto_rh/escolha_perfil.php"]);
    exit;
}

// Redireciona conforme tipo
if ($usuario['tipo_usuario'] === 'empresa') {
    echo json_encode(["status" => "success", "redirect" => "/projeto_rh/empresa/pagina-empresa log.php"]);
} else {
    echo json_encode(["status" => "success", "redirect" => "/projeto_rh/candidato/pagina-usuario log.php"]);
}

exit;
?>
