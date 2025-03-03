<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form id="formCadastro" action="processa_cadastro.php" method="POST" aria-labelledby="formCadastro">
        <!-- Etapa 1: Dados Pessoais -->
        <div id="etapa1" class="etapa">
            <h2>Etapa 1: Dados Pessoais</h2>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required aria-describedby="nomeHelp">
            <div id="nomeHelp" class="error">Por favor, insira seu nome completo.</div>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required aria-describedby="emailHelp">
            <div id="emailHelp" class="error">Insira um email válido.</div>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" required aria-describedby="cpfHelp" maxlength="14">
            <div id="cpfHelp" class="error">Insira seu CPF corretamente.</div>

            <label for="endereco">Endereço:</label>
            <textarea name="endereco" id="endereco" required aria-describedby="enderecoHelp"></textarea>
            <div id="enderecoHelp" class="error">O endereço é obrigatório.</div>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" required aria-describedby="telefoneHelp" maxlength="15">
            <div id="telefoneHelp" class="error">Informe seu telefone de contato.</div>
        </div>
        <!-- Contêiner para os indicadores -->
<div class="step-indicator-container">
    <div class="step-indicator" id="step1-indicator">1</div>
    <div class="step-indicator" id="step2-indicator">2</div>
    <div class="step-indicator" id="step3-indicator">3</div>
</div>


        <!-- Etapa 2: Formação Acadêmica e Experiência -->
        <div id="etapa2" class="etapa" style="display: none;">
            <h2>Etapa 2: Formação Acadêmica e Experiência</h2>
            <label for="formacao_academica">Formação Acadêmica:</label>
            <select name="formacao_academica" id="formacao_academica" required aria-describedby="formacaoHelp">
                <option value="Ensino Médio">Ensino Médio</option>
                <option value="Graduação">Graduação</option>
                <option value="Pós-Graduação">Pós-Graduação</option>
                <option value="Mestrado">Mestrado</option>
                <option value="Doutorado">Doutorado</option>
            </select>
            <div id="formacaoHelp" class="error">Escolha sua formação acadêmica.</div>

            <label for="experiencia_profissional">Experiência Profissional:</label>
            <textarea name="experiencia_profissional" id="experiencia_profissional" aria-describedby="experienciaHelp"></textarea>
            <div id="experienciaHelp" class="error">Descreva sua experiência, se houver.</div>
        </div>
        

        <!-- Etapa 3: Senha e Confirmação -->
        <div id="etapa3" class="etapa" style="display: none;">
            <h2>Etapa 3: Senha e Confirmação</h2>
            <div class="password-container">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required aria-describedby="senhaHelp">
                <span id="toggleSenha">👁️</span>
            </div>
            
            <div id="senhaHelp" class="error">A senha deve ter pelo menos 8 caracteres.</div>

            <div class="password-container">
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required aria-describedby="confirmarSenhaHelp">
                <span id="toggleConfirmarSenha">👁️</span>
            </div>

            <label for="area_interesse">Área de atuação:</label>
            <select name="area_interesse" id="area_interesse" required aria-describedby="areaHelp">
                <option value="Tecnologia">Tecnologia</option>
                <option value="Saúde">Saúde</option>
                <option value="Administração">Administração</option>
                <option value="Marketing">Marketing</option>
                <option value="Educação">Educação</option>
            </select>
            <div id="areaHelp" class="error">Escolha sua área de interesse.</div>
        </div>

        <!-- Navegação -->
        <div id="navegacao">
            <button type="button" id="anterior" onclick="mudarEtapa('anterior')">Anterior</button>
            <button type="button" id="proximo" onclick="mudarEtapa('proximo')">Próximo</button>
            <button type="submit" id="finalizar" style="display: none;">Cadastrar</button>
        </div>
        
    </form>

    <!-- Código JavaScript para as máscaras -->
    <script src="js/mascaras.js"></script>
    <!-- Código JavaScript para alternar visibilidade da senha -->
    <script src="js/senha.js"></script>
    <!-- Código JavaScript para navegação entre etapas -->
    <script>
    let etapaAtual = 1;

function mudarEtapa(acao) {
    const totalEtapas = 3;
    const etapa1 = document.getElementById("etapa1");
    const etapa2 = document.getElementById("etapa2");
    const etapa3 = document.getElementById("etapa3");
    const proximoBtn = document.getElementById("proximo");
    const anteriorBtn = document.getElementById("anterior");
    const finalizarBtn = document.getElementById("finalizar");

    // Esconder todas as etapas
    etapa1.style.display = "none";
    etapa2.style.display = "none";
    etapa3.style.display = "none";

    // Remover a classe 'active' dos indicadores de passo
    document.querySelectorAll('.step-indicator').forEach(indicator => {
        indicator.classList.remove('active');
    });

    // Mover entre as etapas
    if (acao === "proximo" && etapaAtual < totalEtapas) {
        etapaAtual++;
    } else if (acao === "anterior" && etapaAtual > 1) {
        etapaAtual--;
    }

    // Exibir a etapa atual e marcar o indicador de passo como ativo
    if (etapaAtual === 1) {
        etapa1.style.display = "block";
        document.getElementById("step1-indicator").classList.add('active');
        proximoBtn.style.display = "inline-block";
        anteriorBtn.style.display = "none";
        finalizarBtn.style.display = "none";
    } else if (etapaAtual === 2) {
        etapa2.style.display = "block";
        document.getElementById("step2-indicator").classList.add('active');
        proximoBtn.style.display = "inline-block";
        anteriorBtn.style.display = "inline-block";
        finalizarBtn.style.display = "none";
    } else if (etapaAtual === 3) {
        etapa3.style.display = "block";
        document.getElementById("step3-indicator").classList.add('active');
        proximoBtn.style.display = "none";
        anteriorBtn.style.display = "inline-block";
        finalizarBtn.style.display = "inline-block";
    }
}

// Iniciar o formulário na primeira etapa
window.onload = function() {
    mudarEtapa();
};


    </script>
</body>
</html>
