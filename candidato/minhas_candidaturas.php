<?php
session_start();
require '../conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario']['id'])) {
    echo "Usuário não autenticado!";
    exit;
}

$usuarioId = $_SESSION['usuario']['id'];
$aba = $_GET['aba'] ?? 'banco'; // Aba inicial padrão

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['candidatar'])) {
        // Candidatar-se à vaga
        $vagaId = $_POST['vaga_id'];

        // Verifica se já existe essa candidatura
        $checkStmt = $pdo->prepare("SELECT 1 FROM candidato_vaga WHERE candidato_id = :cid AND vaga_id = :vid");
        $checkStmt->execute(['cid' => $usuarioId, 'vid' => $vagaId]);

        if (!$checkStmt->fetch()) {
            $insertStmt = $pdo->prepare("INSERT INTO candidato_vaga (candidato_id, vaga_id, status) VALUES (:cid, :vid, 'em_andamento')");
            $insertStmt->execute(['cid' => $usuarioId, 'vid' => $vagaId]);
        }

        // Redireciona para a aba 'andamento'
        header("Location: minhas_candidaturas.php?aba=andamento");
        exit;
    }

    if (isset($_POST['cancelar_candidatura'])) {
      // Cancelar a candidatura
      $vagaId = $_POST['vaga_id'];
  
      // Verifica se a candidatura existe antes de tentar cancelá-la
      $deleteStmt = $pdo->prepare("DELETE FROM candidato_vaga WHERE candidato_id = :cid AND vaga_id = :vid");
      $deleteStmt->execute(['cid' => $usuarioId, 'vid' => $vagaId]);
  
      // Redireciona para a aba 'andamento' após a remoção
      header("Location: minhas_candidaturas.php?aba=andamento");
      exit;
  }
  
}

// Parâmetros de busca
$descricao = $_GET['descricao'] ?? '';
$empresa = $_GET['empresa'] ?? '';
$requisitos = $_GET['requisitos'] ?? '';

$where = [];
$params = [];

if (!empty($descricao)) {
    $where[] = 'v.descricao LIKE :descricao';
    $params['descricao'] = '%' . $descricao . '%';
}
if (!empty($empresa)) {
    $where[] = 'e.nome_empresa LIKE :empresa';
    $params['empresa'] = '%' . $empresa . '%';
}
if (!empty($requisitos)) {
    $where[] = 'v.requisitos LIKE :requisitos';
    $params['requisitos'] = '%' . $requisitos . '%';
}

// VAGAS COM CANDIDATURA
$sqlCandidaturas = "SELECT v.id, v.descricao, v.requisitos, v.data_postagem, e.nome_empresa, cv.status
    FROM vagas v
    JOIN empresas e ON v.empresa_id = e.id
    JOIN candidato_vaga cv ON v.id = cv.vaga_id
    WHERE cv.candidato_id = :usuario_id";

$paramsCandidatura = ['usuario_id' => $usuarioId];

if (!empty($where)) {
    $sqlCandidaturas .= ' AND ' . implode(' AND ', $where);
    $paramsCandidatura += $params;
}

$sqlCandidaturas .= ' ORDER BY v.data_postagem DESC';

$stmt = $pdo->prepare($sqlCandidaturas);
$stmt->execute($paramsCandidatura);
$vagasCandidatadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Separar por status
$vagasEmAndamento = array_filter($vagasCandidatadas, fn($v) => $v['status'] === 'em_andamento');
$vagasFinalizadas = array_filter($vagasCandidatadas, fn($v) => $v['status'] === 'finalizada');

// VAGAS NO BANCO DE TALENTOS
$sqlBanco = "SELECT v.id, v.descricao, v.requisitos, v.data_postagem, e.nome_empresa
    FROM vagas v
    JOIN empresas e ON v.empresa_id = e.id
    WHERE NOT EXISTS (
        SELECT 1 FROM candidato_vaga cv 
        WHERE cv.vaga_id = v.id AND cv.candidato_id = :usuario_id
    )";

if (!empty($where)) {
    $sqlBanco .= ' AND ' . implode(' AND ', $where);
}

$sqlBanco .= ' ORDER BY v.data_postagem DESC';

$stmtBanco = $pdo->prepare($sqlBanco);
$stmtBanco->execute(['usuario_id' => $usuarioId] + $params);
$vagasBancoTalentos = $stmtBanco->fetchAll(PDO::FETCH_ASSOC);

// DEFINE QUAL CONJUNTO USAR
switch ($aba) {
    case 'andamento':
        $vagas = $vagasEmAndamento;
        break;
    case 'banco':
        $vagas = $vagasBancoTalentos;
        break;
    case 'finalizadas':
    default:
        $vagas = $vagasFinalizadas;
        break;
}
if (isset($_POST['cancelar_candidatura'])) {
  // Cancelar a candidatura
  $vagaId = $_POST['vaga_id'];

  // Verifica se a candidatura existe antes de tentar cancelá-la
  $deleteStmt = $pdo->prepare("DELETE FROM candidato_vaga WHERE candidato_id = :cid AND vaga_id = :vid");
  $deleteStmt->execute(['cid' => $usuarioId, 'vid' => $vagaId]);

  // Agora, verifique se a candidatura foi removida
  $checkStmt = $pdo->prepare("SELECT 1 FROM candidato_vaga WHERE candidato_id = :cid AND vaga_id = :vid");
  $checkStmt->execute(['cid' => $usuarioId, 'vid' => $vagaId]);

  if (!$checkStmt->fetch()) {
      // Candidatura foi removida com sucesso, então redireciona
      header("Location: minhas_candidaturas.php?aba=andamento");
      exit;
  } else {
      echo "Erro ao cancelar candidatura.";
      exit;
  }
}

?>

<!-- O HTML do código permanece o mesmo -->






<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="/projeto_rh/html/revelar.js" defer></script>
    <script src="/projeto_rh/html/toggle.js"></script>
    <script src="/projeto_rh/html/scroll-menu.js"></script>
    <link rel="stylesheet" href="/projeto_rh/css/minhascandidaturas.css">
    <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas</title>
</head>
<body>
    <!-- Menu e Header -->
    <header>
    <nav class="menu">
        <!-- Conteúdo do Menu -->
         <div class="logo">
          <img src='/Projeto_RH/html/Assets/IMG/Link_Next_Logo_sem_fundo.png' alt='Logo Link Next'></img>
         </div>


         <div class="resp-but">
          <input type="checkbox" id="checkbox" onclick="mostrar()">
          <label for="checkbox" class="toggle">
              <div class="bars" id="bar1"></div>
              <div class="bars" id="bar2"></div>
              <div class="bars" id="bar3"></div>
          </label>
          </div>
    </nav>
    <div class="resp">
    <ul>
      <li class="nav-items"><a href="/projeto_rh/candidato/pagina-usuario log.php" class="link">Início</a></li>
      <li class="nav-items"><a href="#" class="link">Buscar Vagas</a></li>
      <li class="nav-items"><a href="#" class="link">Sou Empresa</a></li>
    </ul>
    <div class="perf">
      <img src="/projeto_rh/html/Assets/IMG/Foto model.jpg" alt="Foto de perfil">
    </div>
  </div>
    </header>
    <section class="hero">
        <h1>Minhas candidaturas</h1>
        <p>Acompanhe o andamento das vagas que você está participando.</p>
    </section>

    <!-- Formulário de Busca -->
    <form class="search-section" method="GET">
        <input type="text" name="descricao" placeholder="Buscar por vaga" value="<?= htmlspecialchars($_GET['descricao'] ?? '') ?>">
        <input type="text" name="empresa" placeholder="Buscar por empresa" value="<?= htmlspecialchars($_GET['empresa'] ?? '') ?>">
        <input type="text" name="requisitos" placeholder="Buscar por requisitos" value="<?= htmlspecialchars($_GET['requisitos'] ?? '') ?>">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabs -->
    <div class="tabs">
        <div class="<?= ($_GET['aba'] ?? '') === 'andamento' ? 'active' : '' ?>" onclick="mudarAba('andamento')">Em andamento</div>
        <div class="<?= ($_GET['aba'] ?? '') === 'banco' || !isset($_GET['aba']) ? 'active' : '' ?>" onclick="mudarAba('banco')">Em banco de talentos</div>
        <div class="<?= ($_GET['aba'] ?? '') === 'finalizadas' ? 'active' : '' ?>" onclick="mudarAba('finalizadas')">Finalizadas</div>
    </div>





    <?php if (count($vagas) > 0): ?>

<?php foreach ($vagas as $vaga): ?>
    <div class="vaga">
        <h2><?= htmlspecialchars($vaga['descricao']) ?></h2>
        <p><strong>Empresa:</strong> <?= htmlspecialchars($vaga['nome_empresa']) ?></p>
        <p><strong>Requisitos:</strong> <?= htmlspecialchars($vaga['requisitos']) ?></p>
        <small>Postada em: <?= date('d/m/Y H:i', strtotime($vaga['data_postagem'])) ?></small>

        <?php if ($aba === 'banco'): ?>
            <!-- Botão para se candidatar -->
            <form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="vaga_id" value="<?= $vaga['id'] ?>">
                <button type="submit" name="candidatar" id="button-vag" style="margin-top: 10px; background-color: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                    Candidatar
                </button>
            </form>
        <?php elseif ($aba === 'andamento'): ?>
            <!-- Botão para cancelar candidatura -->
            <form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="vaga_id" value="<?= $vaga['id'] ?>">
                <button type="submit" name="cancelar_candidatura" id="button-vag-canc" style="margin-top: 10px; background-color: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                    Cancelar Candidatura
                </button>
            </form>
        <?php endif; ?>
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
        function mudarAba(aba) {
            const url = new URL(window.location.href);
            url.searchParams.set('aba', aba);

            const descricao = document.querySelector('input[name="descricao"]').value;
            const empresa = document.querySelector('input[name="empresa"]').value;
            const requisitos = document.querySelector('input[name="requisitos"]').value;

            if (descricao) url.searchParams.set('descricao', descricao);
            else url.searchParams.delete('descricao');

            if (empresa) url.searchParams.set('empresa', empresa);
            else url.searchParams.delete('empresa');

            if (requisitos) url.searchParams.set('requisitos', requisitos);
            else url.searchParams.delete('requisitos');

            window.location.href = url.toString();
        }
    </script>
</body>
</html>




<style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #f2f3f7;
      color: #333;
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

    button[name="cancelar_candidatura"] {
    background-color: #e74c3c; /* Cor de fundo vermelha */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[name="cancelar_candidatura"]:hover {
    background-color: #c0392b; /* Cor de fundo mais escura quando o botão for hover */
}

    .filters {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      padding: 20px 30px;
      background-color: #fff;
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

