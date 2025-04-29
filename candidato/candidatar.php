<?php
session_start();
require_once("../conexao.php");

// Verifica se a empresa está logada
if (!isset($_SESSION['usuario'])) {
    header("Location: /projeto_rh/login/login.php");
    exit;
}

$empresa_id = $_SESSION['usuario']['id'];

// POST: confirmar ou cancelar
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acao'], $_POST['candidato_vaga_id'])) {
    $acao = $_POST['acao'];
    $candidato_vaga_id = $_POST['candidato_vaga_id'];

    // Define status correto
    if ($acao === 'confirmar') {
        $novo_status = 'finalizada';
    } else {
        $novo_status = 'rejeitado';
    }

    // Atualiza no banco
    $sql = "UPDATE candidato_vaga SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if (! $stmt->execute([$novo_status, $candidato_vaga_id])) {
        echo "Erro ao atualizar o status da candidatura.";
        exit;
    }

    // Redireciona já com a aba correta
    header("Location: candidatar.php?status={$novo_status}");
    exit;
}

// Define filtro de status
$status_filtro = $_GET['status'] ?? 'em_andamento';

// Mapeia para as labels da navegação
$tabs = [
    'em_andamento' => 'Em Andamento',
    'finalizada'   => 'Finalizados',
    'rejeitado'    => 'Cancelados',
];

// Busca candidatos
$sql = "SELECT
            cv.id AS candidato_vaga_id,
            c.nome_candidato,
            c.email_candidato,
            c.telefone_candidato,
            c.foto_candidato,
            v.descricao,
            v.requisitos,
            cv.status
        FROM candidato_vaga cv
        JOIN candidatos c ON cv.candidato_id = c.id
        JOIN vagas v       ON cv.vaga_id = v.id
        WHERE v.empresa_id = ? AND cv.status = ?
        ORDER BY cv.data_inscricao DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$empresa_id, $status_filtro]);
$candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
  <meta charset="UTF-8">
  <title>Candidatos às Vagas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .nav-link{
      color: #9D61EA;
    }

    /* From Uiverse.io by cssbuttons-io */ 
.noselect {
 width: 150px;
 height: 50px;
 cursor: pointer;
 display: flex;
 align-items: center;
 background: red;
 border: none;
 border-radius: 5px;
 box-shadow: 1px 1px 3px rgba(0,0,0,0.15);
 background: #e62222;
}

.noselect, .noselect span {
 transition: 200ms;
}

.noselect .text {
 transform: translateX(35px);
 color: white;
 font-weight: bold;
}

.noselect .icon {
 position: absolute;
 border-left: 1px solid #c41b1b;
 transform: translateX(110px);
 height: 40px;
 width: 40px;
 display: flex;
 align-items: center;
 justify-content: center;
}

.noselect svg {
 width: 15px;
 fill: #eee;
}

.noselect:hover {
 background: #ff3636;
}

.noselect:hover .text {
 color: transparent;
}

.noselect:hover .icon {
 width: 150px;
 border-left: none;
 transform: translateX(0);
}

.noselect:focus {
 outline: none;
}

.noselect:active .icon svg {
 transform: scale(0.8);
}

/* From Uiverse.io by Gaurang7717 */ 
.noselecte {
  width: 150px;
  height: 50px;
  cursor: pointer;
  display: flex;
  align-items: center;
  background: Green;
  border: none;
  border-radius: 5px;
  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
  background: #00a600;
}

.noselecte,
.noselecte span {
  transition: 200ms;
}

.noselecte .text {
  transform: translateX(35px);
  color: white;
  font-weight: bold;
}

.noselecte .icon {
  position: absolute;
  border-left: 1px solid #006e00;
  transform: translateX(110px);
  height: 40px;
  width: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.noselecte svg {
  width: 20px;
  fill: #eee;
}

.noselecte:hover {
  background: ##00a600;
}

.noselecte:hover .text {
  color: transparent;
}

.noselecte:hover .icon {
  width: 150px;
  border-left: none;
  transform: translateX(0);
}

.noselecte:focus {
  outline: none;
}

.noselecte:active .icon svg {
  transform: scale(0.8);
}

  </style>
  <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Candidatos às Suas Vagas</h2>

    <ul class="nav nav-tabs">
      <?php foreach ($tabs as $status => $label): ?>
        <li class="nav-item">
          <a
            class="nav-link <?= $status_filtro === $status ? 'active' : '' ?>"
            href="?status=<?= $status ?>"
          >
            <?= $label ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php if ($candidatos): ?>
      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Vaga</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($candidatos as $cand): ?>
            <tr>
              <td>
                <?php if ($cand['foto_candidato']): ?>
                  <img src="<?= htmlspecialchars($cand['foto_candidato']) ?>"
                       width="50" height="50" class="rounded-circle">
                <?php else: ?>
                  <img src="/projeto_rh/html/Assets/IMG/default-avatar.png"
                       width="50" height="50" class="rounded-circle">
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($cand['nome_candidato']) ?></td>
              <td><?= htmlspecialchars($cand['email_candidato']) ?></td>
              <td><?= htmlspecialchars($cand['telefone_candidato']) ?></td>
              <td>
                <?= htmlspecialchars($cand['descricao']) ?><br>
                <small><i><?= htmlspecialchars($cand['requisitos']) ?></i></small>
              </td>
              <td><?= ucfirst(htmlspecialchars($cand['status'])) ?></td>
              <td>
                <?php if ($cand['status'] === 'em_andamento'): ?>
                  <form method="POST" style="display:inline-block">
                    <input type="hidden" name="candidato_vaga_id"
                           value="<?= $cand['candidato_vaga_id'] ?>">
<button type="submit" name="acao" value="confirmar" class="noselecte"><span class="text">Confirmar</span><span class="icon"><svg
      viewBox="0 0 24 24"
      height="24"
      width="24"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"
      ></path></svg></span>
</button>

                  </form>
                  <form method="POST" style="display:inline-block">
                    <input type="hidden" name="candidato_vaga_id"
                           value="<?= $cand['candidato_vaga_id'] ?>">
                    <button type="submit" name="acao" value="cancelar" class="noselect"><span class="text">Cancelar</span><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path></svg></span></button>
                  </form>
                <?php else: ?>
                  <span class="text-muted">Ação realizada</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-center mt-4">Nenhum candidato para este status.</p>
    <?php endif; ?>

    <a href="/projeto_rh/empresa/pagina-empresa log.php"
       class="btn btn-secondary mt-4">Voltar</a>
  </div>
</body>
</html>
