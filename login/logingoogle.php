

<?php
session_start();
require_once("../conexao.php");

// Supondo que o login já foi validado
$usuario = [
    "id" => 1, // ID da empresa ou candidato no banco
    "nome" => "Empresa X",
    "endereco" => "Rua das Flores, 123",
    "tipo_usuario" => "empresa" // ou "candidato"
];

// Armazena os dados do usuário na sessão
$_SESSION['usuario'] = $usuario;

// Redireciona com base no tipo de usuário
if ($usuario['tipo_usuario'] === 'empresa') {
    header("Location: cadastro_vaga.php");
} else {
    header("Location: dashboard_usuario.php");
}
exit;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Vagas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Cadastro de Vagas</h1>
        
        <!-- Formulário de cadastro de vagas -->
        <form action="cadastrar_vaga.php" method="POST" class="my-4">
            <div class="mb-3">
                <label for="nome_empresa" class="form-label">Nome da Empresa</label>
                <input type="text" class="form-control" id="nome_empresa" name="nome_empresa" value="<?php echo htmlspecialchars($nome_empresa); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="local_empresa" class="form-label">Local da Empresa</label>
                <input type="text" class="form-control" id="local_empresa" name="local_empresa" value="<?php echo htmlspecialchars($local_empresa); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição da Vaga</label>
                <select class="form-control" id="descricao" name="descricao" required>
                    <option value="">Selecione uma descrição</option>
                    <option value="Recepcionista">Recepcionista</option>
                    <option value="Analista de TI">Analista de TI</option>
                    <option value="Desenvolvedor">Desenvolvedor</option>
                    <option value="Gerente de Projetos">Gerente de Projetos</option>
                    <option value="Vendedor">Vendedor</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="requisitos" class="form-label">Requisitos</label>
                <textarea class="form-control" id="requisitos" name="requisitos" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Vaga</button>
        </form>

        <h2 class="mt-5">Vagas Cadastradas</h2>

        <!-- Listagem de vagas cadastradas -->
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>Local</th>
                    <th>Descrição</th>
                    <th>Requisitos</th>
                    <th>Data de Postagem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "cadastro/conexao.php";

                $empresa_id = $_SESSION['usuario']['id']; // ID da empresa logada

                $sql = "SELECT vagas.id, empresas.nome_empresa, empresas.endereco_empresa AS local_empresa, vagas.descricao, vagas.requisitos, vagas.data_postagem 
                        FROM vagas 
                        INNER JOIN empresas ON vagas.empresa_id = empresas.id 
                        WHERE vagas.empresa_id = :empresa_id 
                        ORDER BY vagas.data_postagem DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nome_empresa']}</td>
                                <td>{$row['local_empresa']}</td>
                                <td>{$row['descricao']}</td>
                                <td>{$row['requisitos']}</td>
                                <td>{$row['data_postagem']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Nenhuma vaga cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
