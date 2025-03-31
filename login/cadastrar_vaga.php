<?php
session_start();
require_once("../conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: pagina-empresa.html");
    exit;
}

// Dados da empresa logada
$empresa_nome = $_SESSION['usuario']['nome_empresa'];
$empresa_local = $_SESSION['usuario']['endereco_empresa'];
$empresa_id = $_SESSION['usuario']['id'];
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

        <form action="cadastrar_vaga.php" method="POST" class="my-4">
            <div class="mb-3">
                <label for="nome_empresa" class="form-label">Nome da Empresa</label>
                <input type="text" class="form-control" id="nome_empresa" name="nome_empresa" value="<?php echo $empresa_nome; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="local_empresa" class="form-label">Local da Empresa</label>
                <input type="text" class="form-control" id="local_empresa" name="local_empresa" value="<?php echo $empresa_local; ?>" readonly>
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

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Requisitos</th>
                    <th>Data de Postagem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM vagas WHERE empresa_id = :empresa_id ORDER BY data_postagem DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
                $stmt->execute();

                $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($vagas) {
                    foreach ($vagas as $vaga) {
                        echo "<tr>
                                <td>{$vaga['id']}</td>
                                <td>{$vaga['descricao']}</td>
                                <td>{$vaga['requisitos']}</td>
                                <td>{$vaga['data_postagem']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Nenhuma vaga cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
