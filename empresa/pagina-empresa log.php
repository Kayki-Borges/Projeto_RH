<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location:/projeto_rh/login/login.php');
  exit;
}

$usuario = $_SESSION['usuario'];
$tipo_usuario = $usuario['tipo_usuario'];
$id_usuario = $usuario['id'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="/Projeto_RH/html/revelar.js" defer></script>
    <script src="/Projeto_RH/html/toggle.js"></script>
    <script src="/Projeto_RH/html/scroll-menu.js"></script>
    <link rel="stylesheet" href="/Projeto_RH/html/Assets/pagina-empresa-body.css">
    <link rel="stylesheet" href="/Projeto_RH/html/Assets/pagina-empresa-main.css">
    <link rel="icon" href="/Projeto_RH/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Next|Conectando Talentos</title>
<body>
    <header id="header">
      <nav class="menu">

        <div class="logo">
          <img src="/Projeto_RH/html/Assets/IMG/Link_Next_Logo_sem_fundo.png" alt="Logo">
        </div>

        <div class="items">
          <ul>
          <li class="nav-item"><a href="#banner" class="link">inicio</a></li>
          <li class="nav-item"><a href="/projeto_rh/candidato/candidatar.php" class="link">Buscar Candidatos</a></li>
          <li class="nav-item"><a href="../login/cadastrar_vaga.php" class="link">Cadastrar Vagas</a></li>
          <li class="nav-item"><a href="/Projeto_RH/html/pagina-usuario.html" class="link">Sou Candidato</a></li>
          </ul>
        </div>

        <div class="perf">
          <img src="/Projeto_RH/html/Assets/IMG/Foto model.jpg" alt="Foto de perfil" class="foto" onclick="apar()">
          <ul class="cont-list">
            <li><a href="editar-perfil.php">Editar Perfil</a></li>
            <li><a href="/projeto_rh/candidato/candidatar.php">Buscar Candidatos</a></li>
            <li><a href="../login/cadastrar_vaga.php">Cadastrar Vagas</a></li>
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
          <li class="nav-item"><a href="#" class="link">inicio</a></li>
          <li class="nav-item"><a href="/projeto_rh/candidato/candidatar.php" class="link">Buscar Candidatos</a></li>
          <li class="nav-item"><a href="../login/cadastrar_vaga.php" class="link">Cadastrar Vagas</a></li>
          <li class="nav-item"><a href="../html/pagina-usuario.html" class="link">Sou Candidato</a></li>
          <li class="nav-item"><a href="/projeto_rh/cadastro/logout.php" class="link">Sair</a></li>
        </ul>
        <div class="perf">
          <img src="/Projeto_RH/html/Assets/IMG/Foto model.jpg" alt="Foto de perfil" id="perfFoto">
        </div>
      </div>

    </header>

    <section>

    <div class="banner" id="banner"   style="height: 600px;">
      <div class="efeito-text-topo">
      <h1>Seja bem vindo(a)!</h1>
      <h2>Aqui você buscará <span>candidatos</span></h2>
      <h2>necessários para sua empresa!</h2>
      <button><a href="/projeto_rh/candidato/candidatar.php">Buscar Candidatos</a></button>
      </div>
    </div>
  </section>

  <section class="feature-box">
    <div class="box">
        <i class="material-icons">group</i>
        <h4>Anuncio de Vagas</h4>
        <p>Anuncie suas vagas e encontre candidatos qualificados rapidamente.</p>
    </div>
    <div class="box">
        <i class="material-icons">work</i>
        <h4>Consultoria de RH</h4>
        <p>Receba suporte especializado para contratação de talentos.</p>
    </div>
    <div class="box">
        <i class="material-icons">search</i>
        <h4>Busca de Candidatos</h4>
        <p>Encontre o candidato ideal de acordo com suas habilidades e interesses.</p>
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
</html><style>
  
</style>