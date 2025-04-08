<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minhas Candidaturas</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f6f8;
      color: #333;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 30px;
      background-color: #fff;
      box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    }
    header div {
      font-weight: bold;
      color: #0b57d0;
    }
    .search-bar {
      display: flex;
      gap: 10px;
      padding: 20px;
      background-color: #ffffff;
      border-bottom: 1px solid #eee;
    }
    .search-bar input {
      flex: 1;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 14px;
    }
    .search-bar button {
      background-color: #0b57d0;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
    }
    .filters {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      padding: 15px 20px;
      background-color: white;
      border-bottom: 1px solid #ddd;
    }
    .filters select, .filters button {
      padding: 10px 14px;
      border: 1px solid #0b57d0;
      border-radius: 8px;
      background-color: white;
      color: #0b57d0;
      cursor: pointer;
      font-size: 14px;
    }
    .results-info {
      padding: 20px;
      background-color: #fff;
      font-size: 15px;
      border-bottom: 1px solid #ddd;
    }
    .job-card {
      background-color: #ffffff;
      margin: 20px;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .job-card h2 {
      color: #0b57d0;
      margin-top: 10px;
    }
    .job-card p, .job-card small {
      margin: 5px 0;
    }
    .badge {
      color: #c71c56;
      font-weight: bold;
      font-size: 14px;
      background-color: #fde5ec;
      padding: 4px 8px;
      border-radius: 4px;
    }
    .read-more {
      color: #0b57d0;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <div>☰ Menu</div>
    <div>Ajuda</div>
  </header>

  <div class="search-bar">
    <input type="text" placeholder="Digite o nome da vaga ou empresa">
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

</body>
</html>
