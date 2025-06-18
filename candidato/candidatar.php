
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
  <script src="/projeto_rh/html/toggle.js"></script>
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
 
header {
  background: linear-gradient(90deg, #9D61EA 0%,#653e97 50%,#52337a 100%);
  width: 100%;
  height: 80px;
  display: flex;
}

.resp-but{
  margin-top: 20px;
  margin-left: 1400px;
}

@media screen and (max-width:768px) {
  
  .resp-but {
    margin-left: 590px;
  }
  
}

.menu{
  display: flex;
  align-items: center;
  justify-content: center;
}

.menu ul{
  list-style: none;
  display: flex;
  gap: 20px;
  margin-left: 600px;
  margin-right: 600px;
}

.logo img{
  height: 70px;
  width: 100px;
  margin-left: 10px;
}

.perf img{
  height: 60px;
  width: 60px;
  border-radius: 100%;
}

.resp{
  display: none;
}

.resp.abrir{
  display: block;
  background-color: #9D61EA;
  padding: 20px;
  border-radius: 20px;
  position: absolute;
  left: 175vh;
  top: 83px;
}

@media screen and (max-width:768px) {
  
  .resp.abrir {
    left: 57vh;
  }

}

.resp.abrir ul{
  list-style: none;
  margin-right: 20px;
}

.resp.abrir .nav-items a{
  text-decoration: none;
  display: flex;
  flex-direction: column;
  color: #e4e4e4;
  padding: 10px;
  align-items: center;
  transition: .2s all ease-in-out;
}

.resp.abrir .nav-items a:hover{
  background-color:rgb(90, 56, 136);
  border-radius: 10px;
  transform: scale(1.1);
}

.resp.abrir .perf{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 10px;
}

/*Botão menu*/
#checkbox {
  display: none;
}

.toggle {
  position: relative;
  width: 40px;
  height: 40px;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition-duration: .3s;
}

.bars {
  width: 100%;
  height: 4px;
  background-color: #e4e4e4;
  border-radius: 5px;
  transition-duration: .3s;
}

#checkbox:checked + .toggle .bars {
  margin-left: 13px;
}

#checkbox:checked + .toggle #bar2 {
  transform: rotate(135deg);
  margin-left: 0;
  transform-origin: center;
  transition-duration: .3s;
}

#checkbox:checked + .toggle #bar1 {
  transform: rotate(45deg);
  transition-duration: .3s;
  transform-origin: left center;
}

#checkbox:checked + .toggle #bar3 {
  transform: rotate(-45deg);
  transition-duration: .3s;
  transform-origin: left center;
}

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

.btn.btn-secondary.mt-4{
  background: linear-gradient(to right, #488BE8, #9D61EA);
  transition: .3s all ease-in-out;
  border: none;
}

.btn.btn-secondary.mt-4:hover{
  background: linear-gradient(to right, #9D61EA, #488BE8);
  transform: scale(1.1);
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

      body.dark-mode{
        background-color: #252525;
      }

      body.dark-mode .mt-4{
        color: white;
      }

      body.dark-mode .mb-4{
        color: white;
      }

      body.dark-mode .active{
        background-color: #252525;
      }
</style>
<script src="/projeto_rh/js/dark.js"></script>
<link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
</head>
<body>
<label class="switch">
    <input type="checkbox" onclick="mod()">
    <span class="slider"></span>
</label>
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
      <li class="nav-items" style=" text-align: center;"><a href="#" class="link">Buscar Candidatos</a></li>
      <li class="nav-items" style=" text-align: center;"><a href="../login/cadastrar_vaga.php" class="link">Cadastrar Vagas</a></li>
      <li class="nav-items"><a href="/Projeto_RH/html/pagina-empresa.html" class="link">Sou Empresa</a></li>
      <li class="nav-items"><a href="/projeto_rh/cadastro/logout.php" class="link">Sair</a></li>
    </ul>
    <div class="perf">
      <img src="/projeto_rh/html/Assets/IMG/Foto model.jpg" alt="Foto de perfil">
    </div>
  </div>
  </header>
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
            <th>Foto do curriculo</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>

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
             
  <?php if ($cand['foto_candidato']): ?>
    <!-- Imagem clicável -->  
     <td>
    <img src="/projeto_rh/candidato/uploads/<?= htmlspecialchars($cand['foto_candidato']) ?>"
         width="50" height="50" class="rounded-circle"
         data-bs-toggle="modal"
         data-bs-target="#modalFoto<?= $cand['candidato_vaga_id'] ?>"
         style="cursor:pointer;" alt="Foto do Candidato">
</td>
    <!-- Modal -->
    <div class="modal fade" id="modalFoto<?= $cand['candidato_vaga_id'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Foto do Currículo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body text-center">
            <img src="/projeto_rh/candidato/uploads/<?= htmlspecialchars($cand['foto_candidato']) ?>" class="img-fluid" alt="Foto Ampliada">
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <img src="/projeto_rh/html/Assets/IMG/default-avatar.png"
         width="50" height="50" class="rounded-circle" alt="Foto padrão">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>