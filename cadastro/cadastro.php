<?php
session_start();  // Certifique-se de que a sessão está iniciada
$cadastro_sucesso = isset($_SESSION['cadastro_sucesso']) && $_SESSION['cadastro_sucesso'] == true;
unset($_SESSION['cadastro_sucesso']); // Limpar a variável após exibição
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src="/Projeto_RH/js/senha.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/Projeto_RH/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <title>Cadastro de Usuário</title>

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
            color: #2196f3;
            margin-bottom: 20px;
        }

        .container-principal {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        @media screen and (max-width:400px) {
            .container-principal {
                margin-top: 80px;
            }
        }

        .lado-esquerdo {
            flex: 1;
            max-width: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .lado-esquerdo img {
            width: 560px;
            border-radius: 10px;
            margin-left: 80px;
            animation: fadeInImg 1s ease-in-out forwards;
        }

        @media screen and (max-width:400px) {

            .lado-esquerdo img {
                display: none;
            }
        }
        form {
            border: 0.1px solid #2196f3;
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
            border-color: #2196f3;
            outline: none;
            box-shadow: 0 0 4px #2196f3;
        }

        #senhaIcon{
            color: #2196f3;
            font-size: 25px;
            position: absolute;
            top: 20vh;
            left: 44vh;
            cursor: pointer;
        }

        #confirmIcon{
            color: #2196f3;
            font-size: 25px;
            position: absolute;
            top: 30.5vh;
            left: 44vh;
            cursor: pointer;
        }

        button {
            background-color: transparent;
            border: 1px solid #2196f3;
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
            background-color: #2196f3;
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
            background-color: #2196f3;
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

        .but-volt{
            position: absolute;
            width: 100px;
            top: 0;
            left: 10px;
            background: linear-gradient(to right, #488BE8,#9D61EA);
            color: white;
            cursor: pointer;
            transition:.5s all ease-in-out;
            border: none;
        }

        .but-volt a{
            text-decoration: none;
            color: #ffff;
            font-family: Poppins, sans-serif;
        }
    </style>
</head>
<body>
    <a href="/projeto_rh/html/pagina-usuario.html"><button class="but-volt">Voltar</button></a>
    <div class="container-principal">

        <form id="formCadastro" action="/Projeto_RH/cadastro/processa_cadastro.php" method="POST" aria-labelledby="formCadastro">
            <h1>Cadastro de Usuário</h1>

            <!-- Etapa 1 -->
            <div id="etapa1" class="etapa">
                <h2>Etapa 1: Dados Pessoais</h2>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" required maxlength="14">

                <label for="endereco">Endereço:</label>
                <textarea name="endereco" id="endereco" required></textarea>

                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" required maxlength="15">
            </div>

            <div id="etapa2" class="etapa" style="display: none;">
                <h2>Etapa 2: Formação e Experiência</h2>
                <label for="formacao_academica">Formação Acadêmica:</label>
                <select name="formacao_academica" id="formacao_academica" required>
                    <option value="Ensino Médio">Ensino Médio</option>
                    <option value="Graduação">Graduação</option>
                    <option value="Pós-Graduação">Pós-Graduação</option>
                    <option value="Mestrado">Mestrado</option>
                    <option value="Doutorado">Doutorado</option>
                </select>

                <label for="experiencia_profissional">Experiência Profissional:</label>
                <textarea name="experiencia_profissional" id="experiencia_profissional"></textarea>
            </div>

            <div id="etapa3" class="etapa" style="display: none;">
                <h2>Etapa 3: Senha e Área</h2>
                <label for="senha">Senha:</label>
                <i class="bi bi-eye-slash-fill" id="senhaIcon" onclick="mostrarSenha()"></i>
                <input type="password" name="senha" id="senha" required>

                <label for="confirmar_senha">Confirmar Senha:</label>
                <i class="bi bi-eye-slash-fill" id="confirmIcon" onclick="mostrarSenhaDois()"></i>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required>

                <label for="area_interesse">Área de Interesse:</label>
                <select name="area_interesse" id="area_interesse" required>
                    <option value="Tecnologia">Tecnologia</option>
                    <option value="Saúde">Saúde</option>
                    <option value="Administração">Administração</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Educação">Educação</option>
                </select>
            </div>

            <!-- Navegação -->
            <div id="navegacao">
                <button type="button" id="anterior" onclick="mudarEtapa('anterior')">Anterior</button>
                <button type="button" id="proximo" onclick="mudarEtapa('proximo')">Próximo</button>
                <button type="submit" id="finalizar" style="display: none;">Cadastrar</button>
            </div>
        </form>
        
        <div class="lado-esquerdo">
            <img src="img.png" alt="Imagem ilustrativa">
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <h2>Cadastro Concluído!</h2>
            <p>Seu cadastro foi realizado com sucesso. Você pode agora fazer login.</p>
            <button id="btnLogin">Ir para Login</button>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        let etapaAtual = 1;

        function mudarEtapa(acao) {
            const totalEtapas = 3;
            const etapas = [etapa1, etapa2, etapa3];
            etapas.forEach(e => e.style.display = "none");

            if (acao === "proximo" && etapaAtual < totalEtapas) etapaAtual++;
            if (acao === "anterior" && etapaAtual > 1) etapaAtual--;

            etapas[etapaAtual - 1].style.display = "block";
            proximo.style.display = etapaAtual < totalEtapas ? "inline-block" : "none";
            anterior.style.display = etapaAtual > 1 ? "inline-block" : "none";
            finalizar.style.display = etapaAtual === totalEtapas ? "inline-block" : "none";
        }

        window.onload = function () {
            mudarEtapa();

            // Exibe o modal de sucesso se a variável PHP for verdadeira
            <?php if ($cadastro_sucesso): ?>
                document.getElementById('myModal').style.display = 'flex';
            <?php endif; ?>

            document.getElementById('btnLogin').onclick = function () {
                window.location.href = "/Projeto_RH/login/login.php";
            };
        };

        // Máscara CPF
        document.getElementById('cpf').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        // Máscara Telefone
        document.getElementById('telefone').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.length <= 10
                ? value.replace(/(\d{2})(\d{4})(\d+)/, '($1) $2-$3')
                : value.replace(/(\d{2})(\d{5})(\d+)/, '($1) $2-$3');
            e.target.value = value;
        });
    </script>
</body>
</html>
