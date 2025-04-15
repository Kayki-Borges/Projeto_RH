<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa</title>
    <link rel="icon" href="/Projeto_RH/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <link rel="stylesheet" href="/Projeto_RH/css/cadastro.css">
    <script src="/Projeto_RH/js/senha.js"></script>
</head>
<body>
    <div class="container-principal">
    <form id="formCadastroEmpresa" action="/Projeto_RH/cadastro/processa_cadastro_empresa.php" method="POST">
    <h1>Cadastro de Empresa</h1>

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
            <select class="form-control" id="descricao" name="descricao" required>
                <option value="">Selecione uma descrição</option>
                <option value="Recepcionista">Recepcionista</option>
                <option value="Analista de TI">Analista de TI</option>
                <option value="Desenvolvedor">Desenvolvedor</option>
                <option value="Gerente de Projetos">Gerente de Projetos</option>
                <option value="Vendedor">Vendedor</option>
            </select>
        </div>

        <!-- Etapa 3: Senha e Confirmação -->
        <div id="etapa3" class="etapa" style="display: none;">
            <h2>Etapa 3: Senha e Confirmação</h2>
            <div class="password-container">
                <label for="senha_empresa">Senha:</label>
                <input type="password" name="senha_empresa" id="senha" onclick="mostrarSenha()" required>
                <i class="bi bi-eye-slash-fill" id="senhaIcon" onclick="mostrarSenha()"></i>
            </div>

            <div class="password-container">
                <label for="confirmar_senha_empresa">Confirmar Senha:</label>
                <input type="password" name="confirmar_senha_empresa" id="confirmar_senha" required>
                <i class="bi bi-eye-slash-fill" id="comfirmIcon" onclick="mostrarSenhaDois()"></i>
            </div>
        </div>

        <!-- Navegação -->
        <div id="navegacao">
            <button type="button" id="anterior" onclick="mudarEtapa('anterior')" style="display: none;">Anterior</button>
            <button type="button" id="proximo" onclick="mudarEtapa('proximo')">Próximo</button>
            <button type="submit" id="finalizar" style="display: none;">Cadastrar Empresa</button>
        </div>
    </form>

    </div>
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

        // Máscara para CNPJ
        document.getElementById('cnpj_empresa').addEventListener('input', function (e) {
            let cnpj = e.target.value;
            cnpj = cnpj.replace(/\D/g, ''); // Remove tudo que não for número
            cnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3.$4-$5');
            e.target.value = cnpj;
        });

        // Máscara para Telefone
        document.getElementById('telefone_empresa').addEventListener('input', function (e) {
            let telefone = e.target.value;
            telefone = telefone.replace(/\D/g, ''); // Remove tudo que não for número
            telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            e.target.value = telefone;
        });

        // Inicializar corretamente na etapa 1
        mudarEtapa();
    </script>
</body>
</html>

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

        body {
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #9D61EA;
            margin-bottom: 20px;
        }

        .container-principal {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .lado-esquerdo {
            flex: 1;
            max-width: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .lado-esquerdo img {
            width: 500px;
            position: absolute;
            left: 95vh;
            animation: fadeInImg 1s ease-in-out forwards;
        }

        form {
            border: 0.1px solid #9D61EA;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            max-width: 400px;
            animation: fadeInUp 1s ease-in-out forwards;
        }

        @keyframes fadeInUp {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInImg {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
        }

        input{
            height: 40px;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #9D61EA;
            outline: none;
            box-shadow: 0 0 4px #9D61EA;
        }

        #senhaIcon{
            color: #9D61EA;
            font-size: 25px;
            position: absolute;
            top: 4.5vh;
            left: 42vh;
            cursor: pointer;
        }

        #comfirmIcon{
            color: #9D61EA;
            font-size: 25px;
            position: absolute;
            top: 4.5vh;
            left: 42vh;
            cursor: pointer;
        }

        button {
            background-color: transparent;
            border: 1px solid #9D61EA;
            color: black;
            padding: 12px 20px;
            margin-top: 30px;
            margin-bottom:5px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s all ease-in-out;
        }

        button:hover {
            background-color: #9D61EA;
            transform: scale(1.1);
            color: #f4f4f9;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
        }

        .step {
            display: none;
            flex-direction: column;
            gap: 15px;
        }

        .step.active {
            display: flex;
        }

        #navegacao #proximo{
            margin-left: 20px;
        }

        #finalizar {
            background-color: #9D61EA;
            color: white;
            margin-left: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 1000;
        }

        .modal-content {
            margin: 0;
        }

        @media (max-width: 768px) {
            .container-principal {
                flex-direction: column;
                align-items: center;
            }

            .lado-esquerdo,
            form {
                max-width: 90%;
            }

            button {
                width: 100%;
            }
        }
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
