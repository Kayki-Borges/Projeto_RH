<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Busca de Vagas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f5f5;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: #ffffff;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .search-bar {
      display: flex;
      gap: 10px;
      padding: 20px;
      background-color: white;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .search-bar input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .search-bar button {
      background-color: #0b57d0;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
    }
    .filters {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      padding: 10px 20px;
      background-color: white;
    }
    .filters button, .filters select {
      padding: 8px 12px;
      border: 1px solid #0b57d0;
      border-radius: 6px;
      background-color: white;
      color: #0b57d0;
      cursor: pointer;
    }
    .results-info {
      padding: 20px;
      font-size: 14px;
      color: #555;
    }
    .job-card {
      background-color: white;
      margin: 10px 20px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .job-card h2 {
      color: #0b57d0;
      margin: 0 0 10px;
    }
    .job-card small, .job-card p {
      color: #444;
    }
    .badge {
      color: #c71c56;
      font-weight: bold;
    }
    .read-more {
      color: #0b57d0;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <header>
    <div>Menu</div>
    <div>Ajuda</div>
  </header>

  <div class="search-bar">
    <input type="text" placeholder="Cargo ou palavra-chave">
    <input type="text" placeholder="Cidade, estado ou região">
    <button>Buscar</button>
  </div>

  <div class="filters">
    <select><option>Salário</option></select>
    <select><option>Distância (km)</option></select>
    <select><option>Modalidade</option></select>
    <select><option>Setor</option></select>
    <select><option>Data</option></select>
    <select><option>Contrato</option></select>
    <select><option>PCD</option></select>
    <button>Só Candidatura Fácil</button>
    <button>Limpar filtros</button>
  </div>

  <div class="results-info">
    <p>Vagas de emprego no Brasil</p>
    <p><strong>288.120 resultados</strong></p>
  </div>

  <div class="job-card">
    <span class="badge">CANDIDATURA FÁCIL</span>
    <h2>Gerente Comercial de Vendas</h2>
    <p><strong>CONFIDENCIAL</strong></p>
    <p><small>Vaga com recrutador muito ativo</small></p>
    <p>De R$ 15.001,00 a R$ 20.000,00</p>
    <p>1 vaga: Barueri - SP</p>
    <p>Publicada hoje</p>
    <p>
      • Prospecção, negociação e fechamento de contratos de frete internacional; <br>
      • Gestão de carteira de clientes e acompanhamento de operações logísticas; <br>
      • Elaboração de propostas...
    </p>
    <a href="#" class="read-more">continuar lendo</a>
  </div>
</body>
</html>
