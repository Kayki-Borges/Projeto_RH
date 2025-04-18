<?php
session_start();

if (!isset($_SESSION['usuario']['id'])) {
  echo "Usuário não autenticado!";
  exit;
}

$usuarioId = $_SESSION['usuario']['id']; // <-- Adicione isso

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="/projeto_rh/html/revelar.js" defer></script>
    <script src="/projeto_rh/html/toggle.js"></script>
    <script src="/projeto_rh/html/scroll-menu.js"></script>
    <link rel="stylesheet" href="/projeto_rh/html/Assets/pagina-usuario-body.css">
    <link rel="stylesheet" href="/projeto_rh/html/Assets/pagina-usuario-main.css">
    <link rel="icon" href="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Next | Conectando Talentos</title>
</head>
<body>

<header id="header">
  <nav class="menu">
    <div class="logo">
      <img src="/projeto_rh/html/Assets/IMG/Link_Next_Logo_sem_fundo.png" alt="Logo">
    </div>

    <div class="items">
      <ul>
        <li class="nav-item"><a href="#banner" class="link">Início</a></li>
        <li class="nav-item"><a href="../candidato/minhas_candidaturas.php" class="link">Buscar Vagas</a></li>
        <li class="nav-item"><a href="#" class="link">Sou Empresa</a></li>
      </ul>
    </div>

    <div class="perf">
      <img src="/projeto_rh/html/Assets/IMG/Foto model.jpg" alt="Foto de perfil" class="foto" onclick="apar()">
      <ul class="cont-list">
        <li><a href="">Editar Perfil</a></li>
        <li><a href="/projeto_rh/candidato/curriculo.php">Currículo</a></li>
        <li><a href="#">Candidaturas</a></li>
        <li><a href="#">Ajuda</a></li>
        <li><a href="/projeto_rh/cadastro/logout.php">Sair</a></li>
        <a href="#" class="term">Termos de uso | Link Next</a>
      </ul>
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
      <li class="nav-item"><a href="#" class="link">Início</a></li>
      <li class="nav-item"><a href="#" class="link">Buscar Vagas</a></li>
      <li class="nav-item"><a href="#" class="link">Sou Empresa</a></li>
    </ul>
    <div class="perf">
      <img src="/projeto_rh/html/Assets/IMG/Foto model.jpg" alt="Foto de perfil">
    </div>
  </div>
</header>

<section>
  <div class="banner" style="height: 600px;">
    <div class="efeito-text-topo">
      <h1>Impulsionando talentos,</h1>
      <h2>por meio de <span>Oportunidades</span>!</h2>
      <button><a href="#">Cargos mais procurados</a></button>
    </div>
  </div>
</section>

<section class="feature-box">
  <div class="box">
    <i class="material-icons">group</i>
    <h4>Vagas para Empresas</h4>
    <p>Anuncie suas vagas e encontre candidatos qualificados rapidamente.</p>
  </div>
  <div class="box">
    <i class="material-icons">work</i>
    <h4>Consultoria de RH</h4>
    <p>Receba suporte especializado para contratação de talentos.</p>
  </div>
  <div class="box">
    <i class="material-icons">search</i>
    <h4>Busca de Empregos</h4>
    <p>Encontre a vaga ideal de acordo com suas habilidades e interesses.</p>
  </div>
</section>

<section class="steps">
  <div class="step">
    <div class="circle efeito-circle">1</div>
    <h3 class="efeito-circle-2">Cadastre sua vaga</h3>
    <p class="efeito-circle">Preencha as informações da sua vaga e cadastre gratuitamente na plataforma.</p>
  </div>
  <div class="step">
    <div class="circle efeito-circle">2</div>
    <h3 class="efeito-circle-2">Receba candidatos</h3>
    <p class="efeito-circle-2">Receba candidaturas de profissionais qualificados no seu primeiro dia de anúncio.</p>
  </div>
  <div class="step">
    <div class="circle efeito-circle">3</div>
    <h3 class="efeito-circle-2">Realize a contratação</h3>
    <p class="efeito-circle-2">Entre em contato com os melhores candidatos e faça sua contratação com agilidade.</p>
  </div>
</section>

<footer>
  <div class="text-rod">
    <div class="inf">
      <h1>Institucional</h1>
      <a href="#">Sobre Nós</a>
      <a href="#">Ajuda</a>
      <a href="#">Contato</a>
    </div>
    <div class="inf">
      <h1>Para candidatos</h1>
      <a href="#">Cadastrar Currículo</a>
      <a href="#">Buscar Vagas</a>
      <a href="#">Modelos de Currículo</a>
    </div>
    <div class="inf">
      <h1>Para Empresas</h1>
      <a href="#">Cadastrar Empresa</a>
      <a href="#">Anunciar Vagas</a>
      <a href="#">Buscar por Candidatos</a>
    </div>
  </div>

  <div class="resp-inf">
    <div class="inf">
      <h1>Institucional</h1>
      <ul class="items-inf">
        <a href="#">Sobre Nós</a>
        <a href="#">Ajuda</a>
        <a href="#">Contato</a>
      </ul>
    </div>
    <div class="inf">
      <h1>Para candidatos</h1>
      <ul class="items-inf">
        <a href="#">Cadastrar Currículo</a>
        <a href="#">Buscar Vagas</a>
        <a href="#">Modelos de Currículo</a>
      </ul>
    </div>
    <div class="inf">
      <h1>Para Empresas</h1>
      <ul class="items-inf">
        <a href="#">Cadastrar Empresa</a>
        <a href="#">Anunciar Vagas</a>
        <a href="#">Buscar por Candidatos</a>
      </ul>
    </div>
  </div>

  <div class="infor">
    <p>Link Next</p>
    <a href="#">Termos e serviços</a>
    <a href="#">Política de privacidade</a>
  </div>
</footer>

</body>
</html>
