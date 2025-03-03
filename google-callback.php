<?php
session_start();
require_once "conexao.php"; // Inclua sua conexão com o banco

// Função para decodificar o token JWT
function decodeGoogleToken($token) {
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $token;
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Verifica se o token foi enviado
if (!isset($_POST['token'])) {
    
// Ativar a exibição de erros para depuração
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Certifique-se de que você está retornando um JSON válido
header('Content-Type: application/json');

// Exemplo de resposta JSON
$response = array("status" => "success", "message" => "Login realizado com sucesso.");

// Envie a resposta JSON
echo json_encode($response);
exit; // Evita que qualquer outro conteúdo seja enviado


    echo json_encode(["status" => "error", "message" => "Token não recebido"]);
    exit;
}

$token = $_POST['token'];
$dados = decodeGoogleToken($token);

// Verifica se a resposta do Google está correta
if (!$dados || !isset($dados["email"])) {
    echo json_encode(["status" => "error", "message" => "Falha na autenticação"]);
    exit;
}

$email = $dados["email"];
$nome = $dados["name"];
$foto = $dados["picture"];  // Não é obrigatório salvar a foto

// Verificar se o usuário já existe
$sql = "SELECT id FROM candidatos WHERE email_candidato = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Usuário já existe, inicia sessão
    $_SESSION["usuario"] = $result->fetch_assoc();
    echo json_encode(["status" => "success", "redirect" => "dashboard.php"]);
} else {
    // Se o usuário não existe, cria um novo
    $sql = "INSERT INTO candidatos (nome_candidato, email_candidato) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $email);

    if ($stmt->execute()) {
        // Salva as informações do usuário na sessão
        $_SESSION["usuario"] = ["id" => $stmt->insert_id, "nome" => $nome, "email" => $email];
        echo json_encode(["status" => "success", "redirect" => "dashboard.php"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao cadastrar usuário"]);
    }
}
?>
