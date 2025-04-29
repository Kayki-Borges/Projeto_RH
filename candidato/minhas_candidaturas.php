<?php
session_start();
require '../conexao.php';

// --- Autenticação ---
if (!isset($_SESSION['usuario']['id'])) {
    echo "Usuário não autenticado!";
    exit;
}

$usuarioId = $_SESSION['usuario']['id'];
$aba       = $_GET['aba'] ?? 'banco';  // aba padrão = banco de talentos

// --- Tratamento de POST (candidato) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Candidato se candidata
    if (isset($_POST['candidatar'])) {
        $vagaId = $_POST['vaga_id'];

        $check = $pdo->prepare("
            SELECT id, status 
              FROM candidato_vaga 
             WHERE candidato_id = :cid 
               AND vaga_id      = :vid
        ");
        $check->execute(['cid' => $usuarioId, 'vid' => $vagaId]);
        $row = $check->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            // nunca candidatou: insere
            $ins = $pdo->prepare("
                INSERT INTO candidato_vaga 
                  (candidato_id, vaga_id, status, data_inscricao) 
                VALUES 
                  (:cid,         :vid,     'em_andamento', NOW())
            ");
            $ins->execute(['cid' => $usuarioId, 'vid' => $vagaId]);
        } elseif ($row['status'] === 'rejeitado') {
            // reativa uma rejeição anterior
            $upd = $pdo->prepare("
                UPDATE candidato_vaga 
                   SET status = 'em_andamento', data_inscricao = NOW() 
                 WHERE id = :id
            ");
            $upd->execute(['id' => $row['id']]);
        }

        header("Location: minhas_candidaturas.php?aba=andamento");
        exit;
    }

    // Candidato cancela sua própria candidatura
    if (isset($_POST['cancelar_candidatura'])) {
        $vagaId = $_POST['vaga_id'];

        $del = $pdo->prepare("
            DELETE 
              FROM candidato_vaga 
             WHERE candidato_id = :cid 
               AND vaga_id      = :vid
        ");
        $del->execute(['cid' => $usuarioId, 'vid' => $vagaId]);

        header("Location: minhas_candidaturas.php?aba=andamento");
        exit;
    }
}

// --- Filtros de busca ---
$descricao  = $_GET['descricao']  ?? '';
$empresa    = $_GET['empresa']    ?? '';
$requisitos = $_GET['requisitos'] ?? '';

$where  = [];
$params = [];
if ($descricao)  { $where[] = 'v.descricao LIKE :descricao';   $params['descricao']  = "%$descricao%";   }
if ($empresa)    { $where[] = 'e.nome_empresa LIKE :empresa';  $params['empresa']    = "%$empresa%";     }
if ($requisitos) { $where[] = 'v.requisitos LIKE :requisitos'; $params['requisitos'] = "%$requisitos%";  }
$clause = $where ? ' AND '.implode(' AND ', $where) : '';

// --- 1) Vagas EM ANDAMENTO e FINALIZADAS do candidato ---
$sqlC = "
    SELECT 
      v.id,
      v.descricao,
      v.requisitos,
      v.data_postagem,
      e.nome_empresa,
      cv.status
    FROM vagas v
    JOIN empresas e       ON v.empresa_id      = e.id
    JOIN candidato_vaga cv ON v.id              = cv.vaga_id
   WHERE cv.candidato_id = :usuario_id
     $clause
ORDER BY v.data_postagem DESC
";
$stmtC = $pdo->prepare($sqlC);
$stmtC->execute(array_merge(['usuario_id' => $usuarioId], $params));
$vagasC = $stmtC->fetchAll(PDO::FETCH_ASSOC);

$vagasEmAndamento = array_filter($vagasC, fn($v) => $v['status'] === 'em_andamento');
$vagasFinalizadas = array_filter($vagasC, fn($v) => $v['status'] === 'finalizada');

// --- 2) Vagas NO BANCO DE TALENTOS (inclui rejeitadas) ---
$sqlB = "
    SELECT 
      v.id,
      v.descricao,
      v.requisitos,
      v.data_postagem,
      e.nome_empresa
    FROM vagas v
    JOIN empresas e ON v.empresa_id = e.id
   WHERE NOT EXISTS (
           SELECT 1 
             FROM candidato_vaga cv
            WHERE cv.vaga_id      = v.id
              AND cv.candidato_id = :usuario_id
              AND cv.status IN ('em_andamento','finalizada')
         )
     $clause
ORDER BY v.data_postagem DESC
";
$stmtBanco = $pdo->prepare($sqlB);
$stmtBanco->execute(array_merge(['usuario_id' => $usuarioId], $params));

// **CORREÇÃO AQUI**: usar $stmtBanco, não $stmtB
$vagasBancoTalentos = $stmtBanco->fetchAll(PDO::FETCH_ASSOC);

// --- Escolhe qual conjunto exibir ---
switch ($aba) {
    case 'andamento':   $vagas = $vagasEmAndamento;   break;
    case 'finalizadas': $vagas = $vagasFinalizadas;   break;
    case 'banco':
    default:            $vagas = $vagasBancoTalentos; break;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
  <script src="/Projeto_RH/html/toggle.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Minhas Candidaturas</title>
  <link rel="stylesheet" href="/projeto_rh/css/minhascandidaturas.css">
</head>
<body>
  <header>
    <div class="logo">
    <img src="/Projeto_RH/html/Assets/IMG/Link_Next_Logo_sem_fundo.png" alt="">
    </div>

  <div class="resp-but">
      <input type="checkbox" id="checkbox" onclick="mostrar()">
      <label for="checkbox" class="toggle">
        <div class="bars" id="bar1"></div>
        <div class="bars" id="bar2"></div>
        <div class="bars" id="bar3"></div>
      </label>
    </div>

    <div class="resp">
    <ul>
      <li class="nav-items"><a href="/Projeto_RH/candidato/pagina-usuario log.php" class="link">Início</a></li>
      <li class="nav-items"><a href="#" class="link">Buscar Vagas</a></li>
      <li class="nav-items"><a href="/Projeto_RH/html/pagina-empresa.html" class="link">Sou Empresa</a></li>
    </ul>
    <div class="perf">
      <img src="/projeto_rh/html/Assets/IMG/Foto model.jpg" alt="Foto de perfil">
    </div>
  </div>
  </header>
  <!-- cabeçalho/menu omitidos por brevidade -->
  <section class="hero">
    <h1>Minhas Candidaturas</h1>
    <p>Acompanhe o andamento das vagas que você está participando.</p>
  </section>

  <form method="GET" class="search-section">
    <input name="descricao"  placeholder="Buscar vaga"    value="<?=htmlspecialchars($descricao)?>">
    <input name="empresa"    placeholder="Buscar empresa"  value="<?=htmlspecialchars($empresa)?>">
    <input name="requisitos" placeholder="Buscar requisitos" value="<?=htmlspecialchars($requisitos)?>">
    <button type="submit">Buscar</button>
  </form>

  <div class="tabs">
    <div class="<?=$aba==='andamento'?'active':''?>"    onclick="mudarAba('andamento')">Em andamento</div>
    <div class="<?=$aba==='banco'?'active':''?>"         onclick="mudarAba('banco')">Banco de talentos</div>
    <div class="<?=$aba==='finalizadas'?'active':''?>"   onclick="mudarAba('finalizadas')">Finalizadas</div>
  </div>

  <?php if(count($vagas)>0): ?>
    <?php foreach($vagas as $vaga): ?>
      <div class="vaga">
        <h2><?=htmlspecialchars($vaga['descricao'])?></h2>
        <p><strong>Empresa:</strong> <?=htmlspecialchars($vaga['nome_empresa'])?></p>
        <p><strong>Requisitos:</strong> <?=htmlspecialchars($vaga['requisitos'])?></p>
        <small>Postada em <?=date('d/m/Y H:i',strtotime($vaga['data_postagem']))?></small>

        <?php if($aba==='banco'): ?>
          <form method="POST">
            <input type="hidden" name="vaga_id" value="<?=$vaga['id']?>">
            <button name="candidatar">Candidatar-se</button>
          </form>
        <?php elseif($aba==='andamento'): ?>
          <form method="POST">
            <input type="hidden" name="vaga_id" value="<?=$vaga['id']?>">
            <button name="cancelar_candidatura">Cancelar Candidatura</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="empty-state">
      <p>Nenhuma vaga encontrada nesta aba.</p>
    </div>
  <?php endif; ?>

  <script>
    function mudarAba(aba) {
      const url = new URL(window.location);
      url.searchParams.set('aba', aba);
      window.location = url;
    }
  </script>
</body>
</html>

<style>

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
    transition: .3s all ease-in-out;
}
/* Estilo para o botão “Candidatar-se” */
button[name="candidatar"] {
  background-color: #2ecc71;      /* verde vibrante */
  color: #fff;                    /* texto branco */
  padding: 10px 20px;             /* espaço interno */
  border: none;                   /* sem borda padrão */
  border-radius: 5px;             /* cantos arredondados */
  font-size: 1rem;                /* tamanho de fonte agradável */
  font-weight: 600;               /* texto levemente mais grosso */
  cursor: pointer;                /* cursor de mãozinha */
  box-shadow: 0 2px 6px rgba(0,0,0,0.15); /* sombra sutil */
  transition: .3s all ease-in-out;
}

button[name="candidatar"]:hover {
  background-color: #27ae60;      /* verde escuro ao passar o mouse */
  transform: scale(1.1);    /* leve elevação */
}

button[name="candidatar"]:active {
  transform: translateY(0);       /* volta ao lugar quando clicado */
  box-shadow: 0 1px 4px rgba(0,0,0,0.2);
}

button[name="cancelar_candidatura"]:hover {
    background-color: #c0392b; /* Cor de fundo mais escura quando o botão for hover */
    transform: scale(1.1);    /* leve elevação */
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

