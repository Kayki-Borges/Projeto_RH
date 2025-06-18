
<?php
session_start();
require_once("../conexao.php");

// Verifica se os dados da empresa existem na sessão
if (isset($_SESSION['usuario'])) {
    $empresa_nome = isset($_SESSION['usuario']['nome_empresa']) ? $_SESSION['usuario']['nome_empresa'] : 'Nome não disponível';
    $empresa_local = isset($_SESSION['usuario']['endereco_empresa']) ? $_SESSION['usuario']['endereco_empresa'] : 'Endereço não disponível';
    $empresa_id = isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;
} else {
    // Redireciona para a página de login caso a sessão não tenha os dados do usuário
    header("Location: /projeto_rh/login/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
    $requisitos = $_POST['requisitos'];

    $sql = "INSERT INTO vagas (descricao, requisitos, empresa_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$descricao, $requisitos, $empresa_id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['delete_id'])) {
    $vaga_id = $_GET['delete_id'];

    $sql = "DELETE FROM vagas WHERE id = ? AND empresa_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$vaga_id, $empresa_id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$sql = "SELECT * FROM vagas WHERE empresa_id = :empresa_id ORDER BY data_postagem DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
$stmt->execute();

$vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src="/projeto_rh/js/dark.js"></script>
    <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Vagas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /*Configurações básicas*/
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

.poppins-medium {
    font-family: "Poppins", sans-serif;
    font-weight: 500;
    font-style: normal;
}
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
            background: linear-gradient(to right, #488BE8,#9D61EA);
            padding: 10px 20px;
            transition: .3s all ease-in-out;
            border:none;
        }

        .btn-back:hover{
            background: linear-gradient(to right, #9D61EA, #488BE8);
            transform: scale(1.1);
        }

        .btn-primary{
            background-color: #9D61EA;
            border:none;
            transition: .3s all ease-in-out;
        }

        .btn-primary:hover{
            transform: scale(1.1);
            background-color: #9D61EA;
        }

        .btn.btn-danger{
            transition: .3s all ease-in-out;
        }

        .btn.btn-danger:hover{
            transform:scale(1.1);
            background-color: #dc3545;
        }

        #MudarMod {
        background: linear-gradient(to right, #ffbb52, white);
        position: fixed;
        z-index: 99999999;
        cursor: pointer;
        top: 95vh;
        left: 188vh;
        border-radius: 5px;
        border: none;
        width: 100px;
        height: 30px;
        transition: .3s all ease-in-out;
      }

      #MudarMod:hover {
        transform: scale(1.1);
      }

       body.dark-mode{
        background-color: #252525;
      }

      body.dark-mode .text-center{
        color:white;
      }
      body.dark-mode .my-4 {
        color: white;
      }

      body.dark-mode .mt-5 {
        color: white;
      }

      body.dark-mode .text-center{
        color: black;
      }

      body.dark-mode tbody .text-center{
        color: black;
               background-color: #252525;
      }

      body.dark-mode .mt-5 .text-center{
        color: white;
      }

            .switch {
  display: block;
  --width-of-switch: 3.5em;
  --height-of-switch: 2em;
  /* size of sliding icon -- sun and moon */
  --size-of-icon: 1.4em;
  /* it is like a inline-padding of switch */
  --slider-offset: 0.3em;
  position: fixed;
  top: 93vh;
  left: 190vh;
  z-index: 9999999;
  width: var(--width-of-switch);
  height: var(--height-of-switch);
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
  border: 2px solid #252525;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cfdcff;
  transition: .4s;
  border-radius: 30px;
}

.slider:before {
  position: absolute;
  content: "";
  height: var(--size-of-icon,1.4em);
  width: var(--size-of-icon,1.4em);
  border-radius: 20px;
  left: var(--slider-offset,0.3em);
  top: 50%;
  transform: translateY(-50%);
  background: linear-gradient(40deg,#ff0080,#ff8c00 70%);
  ;
 transition: .4s;
}

input:checked + .slider {
  background-color: #303136;
}

input:checked + .slider:before {
  left: calc(100% - (var(--size-of-icon,1.4em) + var(--slider-offset,0.3em)));
  background: #303136;
  /* change the value of second inset in box-shadow to change the angle and direction of the moon  */
  box-shadow: inset -3px -2px 5px -2px #8983f7, inset -10px -4px 0 0 #a3dafb;
}
    </style>
</head>
<body>
      <label class="switch">
    <input type="checkbox" onclick="mod()">
    <span class="slider"></span>
</label>
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
