<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa</title>
    <link rel="stylesheet" href="/Projeto_RH/css/cadastro.css">
</head>
<body>
    <h1>Cadastro de Empresa</h1>
    <form id="formCadastroEmpresa" action="/Projeto_RH/cadastro/processa_cadastro_empresa.php" method="POST">
        
        <!-- Etapa 1: Dados da Empresa -->
        <div id="etapa1" class="etapa">
            <h2>Etapa 1: Dados da Empresa</h2>
            <label for="nome_empresa">Nome da Empresa:</label>
            <input type="text" name="nome_empresa" id="nome_empresa" required>

            <label for="email_empresa">Email:</label>
            <input type="email" name="email_empresa" id="email_empresa" required>

            <label for="cnpj_empresa">CNPJ:</label>
            <input type="text" name="cnpj_empresa" id="cnpj_empresa" required maxlength="18">

            <label for="endereco_empresa">Endereço:</label>
            <textarea name="endereco_empresa" id="endereco_empresa" required></textarea>

            <label for="telefone_empresa">Telefone:</label>
            <input type="text" name="telefone_empresa" id="telefone_empresa" required maxlength="15">
        </div>

        <!-- Etapa 2: Área de Atuação -->
        <div id="etapa2" class="etapa" style="display: none;">
            <h2>Etapa 2: Área de Atuação</h2>
            <label for="area_atuacao">Área de Atuação:</label>
            <input type="text" name="area_atuacao" id="area_atuacao" required>
        </div>

        <!-- Etapa 3: Senha e Confirmação -->
        <div id="etapa3" class="etapa" style="display: none;">
            <h2>Etapa 3: Senha e Confirmação</h2>
            <div class="password-container">
                <label for="senha_empresa">Senha:</label>
                <input type="password" name="senha_empresa" id="senha_empresa" required>
                <span id="toggleSenhaEmpresa">👁️</span>
            </div>

            <div class="password-container">
                <label for="confirmar_senha_empresa">Confirmar Senha:</label>
                <input type="password" name="confirmar_senha_empresa" id="confirmar_senha_empresa" required>
                <span id="toggleConfirmarSenhaEmpresa">👁️</span>
            </div>
        </div>

        <!-- Navegação -->
        <div id="navegacao">
            <button type="button" id="anterior" onclick="mudarEtapa('anterior')" style="display: none;">Anterior</button>
            <button type="button" id="proximo" onclick="mudarEtapa('proximo')">Próximo</button>
            <button type="submit" id="finalizar" style="display: none;">Cadastrar Empresa</button>
        </div>
    </form>

    <!-- JavaScript para Navegação e Senhas -->
    <script>
        let etapaAtual = 1;

function mudarEtapa(acao) {
    const totalEtapas = 3;
    const etapas = document.querySelectorAll(".etapa");
    const proximoBtn = document.getElementById("proximo");
    const anteriorBtn = document.getElementById("anterior");
    const finalizarBtn = document.getElementById("finalizar");

    // Esconder todas as etapas
    etapas.forEach(etapa => etapa.style.display = "none");

    // Lógica de mudança de etapa
    if (acao === "proximo" && etapaAtual < totalEtapas) {
        etapaAtual++;
    } else if (acao === "anterior" && etapaAtual > 1) {
        etapaAtual--;
    }

    // Exibir etapa atual
    etapas[etapaAtual - 1].style.display = "block";

    // Controle de visibilidade dos botões
    anteriorBtn.style.display = etapaAtual === 1 ? "none" : "inline-block";
    proximoBtn.style.display = etapaAtual === totalEtapas ? "none" : "inline-block";
    finalizarBtn.style.display = etapaAtual === totalEtapas ? "inline-block" : "none";
}

// Inicializar corretamente na etapa 1
mudarEtapa();
    </script>

    <!-- Máscaras para CNPJ e Telefone -->
    <script src="/Projeto_RH/js/mascaras.js"></script>

</body>
</html>

<style>
    .password-container {
        position: relative;
        width: 100%;
    }

    .password-container input {
        width: 100%;
        padding: 10px;
        padding-right: 40px; /* Espaço para o ícone */
        font-size: 16px;
    }

    #toggleSenhaEmpresa, #toggleConfirmarSenhaEmpresa {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5em;
        cursor: pointer;
    }
</style>
