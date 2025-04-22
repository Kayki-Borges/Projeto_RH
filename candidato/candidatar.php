<?php
session_start();
require_once("../conexao.php");

// Verifica se a empresa está logada
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$empresa_id = $_SESSION['usuario']['id'];
// Resto do código da página candidatar.php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acao'], $_POST['candidato_vaga_id'])) {
    $acao = $_POST['acao'];
    $candidato_vaga_id = $_POST['candidato_vaga_id'];

    // Determina o novo status baseado na ação
    if ($acao === 'confirmar') {
        $novo_status = 'finalizado'; // Vaga vai para "Finalizado"
    } else {
        $novo_status = 'cancelado'; // Alterar para 'cancelado'
    }

    // Atualiza o status do candidato na tabela candidato_vaga
    $sql = "UPDATE candidato_vaga SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$novo_status, $candidato_vaga_id])) {
        // Após a alteração do status, redireciona para a página com o filtro adequado
        header("Location: candidatar.php?status=$novo_status");
        exit;
    } else {
        echo "Erro ao atualizar o status da candidatura.";
        exit;
    }
}

// Determina o filtro de status baseado na URL
$status_filtro = isset($_GET['status']) ? $_GET['status'] : 'em_andamento'; // Default: 'em_andamento'

// Busca candidatos para vagas da empresa com base no status
$sql = "SELECT 
            cv.id as candidato_vaga_id,
            c.nome_candidato,
            c.email_candidato,
            c.telefone_candidato,
            c.foto_candidato,  -- Adicionando a foto
            v.descricao,
            v.requisitos,
            cv.status
        FROM candidato_vaga cv
        JOIN candidatos c ON cv.candidato_id = c.id
        JOIN vagas v ON cv.vaga_id = v.id
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

    <!-- Navegação entre as abas -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= ($status_filtro === 'em_andamento') ? 'active' : '' ?>" href="?status=em_andamento" role="tab">Em Andamento</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= ($status_filtro === 'finalizado') ? 'active' : '' ?>" href="?status=finalizado" role="tab">Finalizados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= ($status_filtro === 'cancelado') ? 'active' : '' ?>" href="?status=cancelado" role="tab">Cancelados</a>
        </li>
    </ul>

    <?php if ($candidatos): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome do Candidato</th>
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
                        <?php if (!empty($cand['foto_candidato'])): ?>
                            <img src="<?= htmlspecialchars($cand['foto_candidato']) ?>" alt="Foto do candidato" width="50" height="50" class="img-fluid rounded-circle">
                        <?php else: ?>
                            <img src="path/to/default-image.jpg" alt="Foto não disponível" width="50" height="50" class="img-fluid rounded-circle">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($cand['nome_candidato']) ?></td>
                    <td><?= htmlspecialchars($cand['email_candidato']) ?></td>
                    <td><?= htmlspecialchars($cand['telefone_candidato']) ?></td>
                    <td>
                        <?= htmlspecialchars($cand['descricao']) ?><br>
                        <small><i><?= htmlspecialchars($cand['requisitos']) ?></i></small>
                    </td>
                    <td><?= ucfirst(htmlspecialchars($cand['status'])) ?: 'Não definido' ?></td>
                    <td>
                        <?php if ($cand['status'] === 'em_andamento'): ?>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="candidato_vaga_id" value="<?= $cand['candidato_vaga_id'] ?>">
                                <button type="submit" name="acao" value="confirmar" class="btn btn-success btn-sm">Confirmar</button>
                            </form>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="candidato_vaga_id" value="<?= $cand['candidato_vaga_id'] ?>">
                                <button type="submit" name="acao" value="cancelar" class="btn btn-danger btn-sm">Cancelar</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">Ação já realizada</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Nenhum candidato até o momento.</p>
    <?php endif; ?>

    <a href="/projeto_rh/empresa/pagina-empresa log.php" class="btn btn-secondary mt-4">Voltar</a>
</div>
</body>
</html>
