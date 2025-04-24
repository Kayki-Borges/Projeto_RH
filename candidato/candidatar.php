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
  <meta charset="UTF-8">
  <title>Candidatos às Vagas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <button type="submit" name="acao" value="confirmar"
                            class="btn btn-success btn-sm">
                      Confirmar
                    </button>
                  </form>
                  <form method="POST" style="display:inline-block">
                    <input type="hidden" name="candidato_vaga_id"
                           value="<?= $cand['candidato_vaga_id'] ?>">
                    <button type="submit" name="acao" value="cancelar"
                            class="btn btn-danger btn-sm">
                      Cancelar
                    </button>
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
