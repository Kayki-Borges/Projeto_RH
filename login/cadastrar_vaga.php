<?php
session_start();
require_once("../conexao.php");



// Dados da empresa logada
$empresa_nome = $_SESSION['usuario']['nome_empresa'];
$empresa_local = $_SESSION['usuario']['endereco_empresa'];
$empresa_id = $_SESSION['usuario']['id'];

// Verifica se o formulário foi enviado e cadastra a vaga
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
    $requisitos = $_POST['requisitos'];

    // Inserir nova vaga no banco de dados
    $sql = "INSERT INTO vagas (descricao, requisitos, empresa_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$descricao, $requisitos, $empresa_id]);

    // Redireciona para a mesma página para evitar reenvio do formulário ao atualizar
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Deletar vaga
if (isset($_GET['delete_id'])) {
    $vaga_id = $_GET['delete_id'];

    // Deletar vaga do banco de dados
    $sql = "DELETE FROM vagas WHERE id = ? AND empresa_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vaga_id, $empresa_id]);

    // Redireciona para a página atual
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Buscar todas as vagas cadastradas para a empresa logada
$sql = "SELECT * FROM vagas WHERE empresa_id = :empresa_id ORDER BY data_postagem DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
$stmt->execute();

$vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Vagas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #requisitos {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        #tagsContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .tag {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            font-size: 14px;
            cursor: pointer;
        }

        .tag .close {
            margin-left: 8px;
            cursor: pointer;
            font-weight: bold;
            color: white;
        }

        .tag:hover {
            background-color: #0056b3;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn-back {
            text-decoration: none;
            color: white;
            background-color: #6c757d;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center">Cadastro de Vagas</h1>

        <form action="" method="POST" class="my-4">
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
                <textarea class="form-control" id="requisitos" name="requisitos" rows="3" oninput="updateWords()"></textarea>
                <div id="tagsContainer"></div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Cadastrar Vaga</button>
                <a href="/projeto_rh/empresa/pagina-empresa log.php" class="btn btn-secondary btn-back">Voltar</a>
            </div>
        </form>

        <h2 class="mt-5">Vagas Cadastradas</h2>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Requisitos</th>
                    <th>Data de Postagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($vagas) {
                    foreach ($vagas as $vaga) {
                        echo "<tr>
                                <td>{$vaga['id']}</td>
                                <td>{$vaga['descricao']}</td>
                                <td>{$vaga['requisitos']}</td>
                                <td>{$vaga['data_postagem']}</td>
                                <td>
                                    <a href=\"?delete_id={$vaga['id']}\" class=\"btn btn-danger\">Deletar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Nenhuma vaga cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function updateWords() {
            const input = document.getElementById("requisitos").value;
            const tagsContainer = document.getElementById("tagsContainer");

            // Limpar tags antigas
            tagsContainer.innerHTML = '';

            // Se houver texto, cria as tags
            if (input.trim()) {
                // Divide o texto em palavras
                const words = input.split(/\s+/);

                words.forEach(word => {
                    if (word) {
                        // Criar um novo elemento de tag
                        const tag = document.createElement("div");
                        tag.classList.add("tag");

                        // Texto da palavra
                        tag.innerHTML = `${word}<span class="close" onclick="removeTag(this)">x</span>`;

                        // Adicionar a tag ao contêiner
                        tagsContainer.appendChild(tag);
                    }
                });
            }
        }

        function removeTag(element) {
            // Remove o elemento tag
            const wordToRemove = element.parentElement.textContent.trim().slice(0, -1); // Remove o 'x'
            const textarea = document.getElementById("requisitos");

            // Remover a palavra da textarea
            let currentText = textarea.value;
            currentText = currentText.replace(new RegExp(`\\b${wordToRemove}\\b`, 'g'), '').trim();

            // Atualizar o valor do textarea
            textarea.value = currentText;

            // Remover a tag da tela
            element.parentElement.remove();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
