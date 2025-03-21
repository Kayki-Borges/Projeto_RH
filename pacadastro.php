<?php
// Conexão com o banco de dados
$host = '127.0.0.1';
$user = 'root';
$password = ''; // Atualize com sua senha do banco
$dbname = 'projeto_rh';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Filtros iniciais
$empresa = $_GET['empresa'] ?? '';
$estado = $_GET['estado'] ?? '';
$cidade = $_GET['cidade'] ?? '';
$query = "SELECT vagas.id, vagas.descricao, vagas.requisitos, empresas.nome_empresa 
          FROM vagas 
          INNER JOIN empresas ON vagas.empresa_id = empresas.id 
          WHERE 1=1";

if ($empresa) {
    $query .= " AND empresas.nome_empresa LIKE '%$empresa%'";
}
if ($estado) {
    $query .= " AND empresas.endereco_empresa LIKE '%$estado%'";
}
if ($cidade) {
    $query .= " AND empresas.endereco_empresa LIKE '%$cidade%'";
}

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
        header h1 {
            font-size: 24px;
            margin: 0;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            display: flex;
            flex-direction: column;
        }
        .filter-section {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .filter-section input, .filter-section select {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex: 1;
            margin-bottom: 10px;
        }
        .filter-section button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .filter-section button:hover {
            background-color: #0056b3;
        }
        .tabs {
            display: flex;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .tabs button {
            padding: 10px 15px;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            font-size: 16px;
        }
        .tabs button.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
        }
        .vagas {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .vaga {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .vaga h3 {
            margin-top: 0;
        }
        .vaga p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Minhas Candidaturas</h1>
    </header>
    <div class="container">
        <form method="GET" class="filter-section">
            <input type="text" name="empresa" placeholder="Empresa" value="<?php echo htmlspecialchars($empresa); ?>">
            <input type="text" name="estado" placeholder="Estado" value="<?php echo htmlspecialchars($estado); ?>">
            <input type="text" name="cidade" placeholder="Cidade" value="<?php echo htmlspecialchars($cidade); ?>">
            <button type="submit">Filtrar</button>
        </form>

        <div class="tabs">
            <button class="active" onclick="showTab('andamento')">Em andamento</button>
            <button onclick="showTab('banco')">Em banco de talentos</button>
            <button onclick="showTab('finalizadas')">Finalizadas</button>
        </div>

        <div id="andamento" class="vagas">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="vaga">
                        <h3><?php echo htmlspecialchars($row['descricao']); ?></h3>
                        <p><strong>Empresa:</strong> <?php echo htmlspecialchars($row['nome_empresa']); ?></p>
                        <p><strong>Requisitos:</strong> <?php echo htmlspecialchars($row['requisitos']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhuma vaga encontrada.</p>
            <?php endif; ?>
        </div>

        <div id="banco" class="vagas" style="display:none;">
            <p>Em banco de talentos: Nenhuma vaga disponível.</p>
        </div>

        <div id="finalizadas" class="vagas" style="display:none;">
            <p>Finalizadas: Nenhuma vaga disponível.</p>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            document.querySelectorAll('.vagas').forEach(div => {
                div.style.display = 'none';
            });
            document.getElementById(tabId).style.display = 'block';

            document.querySelectorAll('.tabs button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[onclick="showTab('${tabId}')"]`).classList.add('active');
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
