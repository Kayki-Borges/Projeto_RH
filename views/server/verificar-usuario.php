<?php
// Habilita o CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Código do seu script verificar-usuario.php
?>
<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto_rh";

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificação de erro na conexão
if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

// Obter o e-mail enviado pela requisição
$email = $_GET['email'];

// Verificar se o e-mail está registrado na tabela de candidatos ou empresas
$sql = "SELECT * FROM candidatos WHERE email_candidato = ? UNION SELECT * FROM empresas WHERE email_empresa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $email);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se encontrou o usuário
if ($result->num_rows > 0) {
    // Se encontrado, retornar as informações do usuário
    $user = $result->fetch_assoc();
    echo json_encode(["found" => true, "user" => $user]);
} else {
    // Caso contrário, informar que o usuário não foi encontrado
    echo json_encode(["found" => false]);
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
