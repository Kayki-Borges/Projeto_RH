<?php
session_start();
require '../conexao.php';

$termoBusca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

if (!empty($termoBusca)) {
  $sql = "SELECT vagas.id, vagas.descricao, vagas.requisitos, vagas.data_postagem, empresas.nome_empresa 
          FROM vagas 
          JOIN empresas ON vagas.empresa_id = empresas.id 
          WHERE vagas.descricao LIKE :busca 
             OR empresas.nome_empresa LIKE :busca
             OR vagas.requisitos LIKE :busca
          ORDER BY vagas.data_postagem DESC";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(['busca' => '%' . $termoBusca . '%']);
} else {
  $sql = "SELECT vagas.id, vagas.descricao, vagas.requisitos, vagas.data_postagem, empresas.nome_empresa 
          FROM vagas 
          JOIN empresas ON vagas.empresa_id = empresas.id 
          ORDER BY vagas.data_postagem DESC";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
}

$vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minhas Candidaturas</title>
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #f2f3f7;
      color: #333;
    }

    header {
      background-color: #004aad;
      color: white;
      padding: 20px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    header div {
      font-size: 18px;
      font-weight: bold;
    }

    .hero {
      padding: 40px 30px 20px;
      background: linear-gradient(90deg, #004aad 0%, #3e7bfa 100%);
      color: white;
    }

    .hero h1 {
      margin: 0;
      font-size: 32px;
    }

    .hero p {
      margin-top: 8px;
      font-size: 16px;
      opacity: 0.9;
    }

    .search-section {
      background-color: white;
      padding: 20px 30px;
      display: flex;
      gap: 12px;
      border-bottom: 1px solid #ddd;
    }

    .search-section input {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      flex: 1;
    }

    .search-section button {
      background-color: #004aad;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
    }

    .tabs {
      display: flex;
      justify-content: center;
      gap: 30px;
      padding: 20px;
      background: #fff;
    }

    .tabs div {
      padding: 10px 20px;
      cursor: pointer;
      font-weight: 500;
      border-bottom: 3px solid transparent;
    }

    .tabs .active {
      border-color: #004aad;
      color: #004aad;
    }

    .empty-state {
      text-align: center;
      padding: 50px 30px;
    }

    .empty-state img {
      width: 140px;
      margin-bottom: 20px;
    }

    .empty-state p {
      margin-bottom: 20px;
      font-size: 16px;
    }

    .empty-state button {
      background-color: transparent;
      color: #e74c3c;
      border: 2px solid #e74c3c;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
    }

    .empty-state button:hover {
      background-color: #fceeee;
    }

    .vaga {
      background-color: #fff;
      margin: 20px 30px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .vaga h2 {
      margin: 0 0 10px;
    }

    .vaga p {
      margin: 5px 0;
    }

    .vaga small {
      color: #777;
    }
  </style>
</head>
<body>
  <header>
    <div>☰ Menu</div>
    <div>Ajuda</div>
  </header>

  <section class="hero">
    <h1>Minhas candidaturas</h1>
    <p>Acompanhe o andamento das vagas que você está participando.</p>
  </section>

  <!-- Formulário com campo de busca -->
  <form class="search-section" method="GET">
    <input type="text" name="busca" placeholder="Buscar por vaga, empresa ou requisito" value="<?= htmlspecialchars($termoBusca) ?>">
    <button type="submit">Buscar</button>
  </form>

  <div class="tabs">
    <div>Em andamento</div>
    <div>Em banco de talentos</div>
    <div class="active">Finalizadas</div>
  </div>

  <?php if (count($vagas) > 0): ?>
    <?php foreach ($vagas as $vaga): ?>
      <div class="vaga">
        <h2><?= htmlspecialchars($vaga['descricao']) ?></h2>
        <p><strong>Empresa:</strong> <?= htmlspecialchars($vaga['nome_empresa']) ?></p>
        <p><strong>Requisitos:</strong> <?= htmlspecialchars($vaga['requisitos']) ?></p>
        <small>Postada em: <?= date('d/m/Y H:i', strtotime($vaga['data_postagem'])) ?></small>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="empty-state">
      <img src="https://cdn-icons-png.flaticon.com/512/875/875610.png" alt="Documento">
      <p>Você ainda não possui candidaturas.</p>
      <button>Buscar Oportunidades</button>
    </div>
  <?php endif; ?>

  <script>
    const tabs = document.querySelectorAll('.tabs div');
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
      });
    });

    const buscarBtn = document.querySelector('.empty-state button');
    if (buscarBtn) {
      buscarBtn.addEventListener('click', () => {
        window.location.href = 'buscar-oportunidades.html';
      });
    }
  </script>
</body>
</html>
