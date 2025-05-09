<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa</title>
    <link rel="icon" href="/Projeto_RH/html/Assets/IMG/Link_Next_Logo_sem_fundo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/Projeto_RH/css/cadastro.css">
    <script src="/Projeto_RH/js/senha.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
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

        form {
            border: 0.1px solid #9D61EA;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input {
            height: 40px;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #9D61EA;
            outline: none;
            box-shadow: 0 0 4px #9D61EA;
        }

        button {
            background-color: transparent;
            border: 1px solid #9D61EA;
            color: black;
            padding: 12px 20px;
            margin-top: 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s all ease-in-out;
        }

        button:hover {
            background-color: #9D61EA;
            color: white;
            transform: scale(1.05);
        }

        #finalizar {
            background-color: #9D61EA;
            color: white;
            margin-left: 20px;
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            padding-right: 40px;
        }

        #senhaIcon, #comfirmIcon {
            color: #9D61EA;
            font-size: 25px;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Estilos do Modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
            z-index: 1000;
            color: #333;
        }

        .modal-content {
            font-size: 18px;
            margin: 10px 0;
            color: #4CAF50; /* Cor verde para sucesso */
        }

        .modal i {
            font-size: 50px;
            color: #4CAF50; /* Ícone verde */
        }

        .but-volt {
            position: absolute;
            width: 100px;
            top: 10px;
            left: 10px;
            background: linear-gradient(to right, #488BE8, #9D61EA);
            color: white;
            border: none;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container-principal {
                flex-direction: column;
                margin-top: 80px;
            }

            form {
                max-width: 90%;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<a href="/projeto_rh/html/pagina-empresa.html"><button class="but-volt">Voltar</button></a>

<div class="container-principal">
    <form id="formCadastroEmpresa" action="/Projeto_RH/cadastro/processa_cadastro_empresa.php" method="POST">
        <h1>Cadastro de Empresa</h1>

        <!-- Etapa 1 -->
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

        <!-- Etapa 2 -->
        <div id="etapa2" class="etapa" style="display: none;">
            <h2>Etapa 2: Área de Atuação</h2>
            <label for="area_atuacao">Área de Atuação:</label>
            <select id="descricao" name="descricao" required>
                <option value="">Selecione uma descrição</option>
                <option value="Recepcionista">Recepcionista</option>
                <option value="Analista de TI">Analista de TI</option>
                <option value="Desenvolvedor">Desenvolvedor</option>
                <option value="Gerente de Projetos">Gerente de Projetos</option>
                <option value="Vendedor">Vendedor</option>
            </select>
        </div>

        <!-- Etapa 3 -->
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
                <i class="bi bi-eye-slash-fill" id="comfirmIcon" onclick="mostrarSenhaConfirm()"></i>
            </div>
        </div>

    
        <div id="navegacao">
            <button type="button" id="anterior" onclick="mudarEtapa('anterior')" style="display: none;">Anterior</button>
            <button type="button" id="proximo" onclick="mudarEtapa('proximo')">Próximo</button>
            <button type="submit" id="finalizar" style="display: none;">Cadastrar Empresa</button>
        </div>
    </form>

    
    <div id="meuModal" class="modal">
        <i class="bi bi-check-circle-fill"></i>
        <p class="modal-content">Cadastro realizado com sucesso!</p>
    </div>
</div>

<script>
    let etapaAtual = 1;

    function mudarEtapa(acao) {
        const totalEtapas = 3;
        const etapas = document.querySelectorAll(".etapa");
        const proximoBtn = document.getElementById("proximo");
        const anteriorBtn = document.getElementById("anterior");
        const finalizarBtn = document.getElementById("finalizar");

        etapas.forEach(etapa => etapa.style.display = "none");

        if (acao === "proximo" && etapaAtual < totalEtapas) {
            etapaAtual++;
        } else if (acao === "anterior" && etapaAtual > 1) {
            etapaAtual--;
        }

        etapas[etapaAtual - 1].style.display = "block";
        anteriorBtn.style.display = etapaAtual === 1 ? "none" : "inline-block";
        proximoBtn.style.display = etapaAtual === totalEtapas ? "none" : "inline-block";
        finalizarBtn.style.display = etapaAtual === totalEtapas ? "inline-block" : "none";
    }

    document.getElementById('cnpj_empresa').addEventListener('input', function (e) {
        let cnpj = e.target.value.replace(/\D/g, '').slice(0, 14);
        cnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, '$1.$2.$3/$4-$5');
        e.target.value = cnpj;
    });

    document.getElementById('telefone_empresa').addEventListener('input', function (e) {
        let tel = e.target.value.replace(/\D/g, '').slice(0, 11);
        tel = tel.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        e.target.value = tel;
    });

    function mostrarSenha() {
        const senha = document.getElementById("senha");
        senha.type = senha.type === "password" ? "text" : "password";
    }

    function mostrarSenhaConfirm() {
        const senha = document.getElementById("confirmar_senha");
        senha.type = senha.type === "password" ? "text" : "password";
    }

    function mostrarModalERedirecionar() {
        const modal = document.getElementById("meuModal");
        modal.style.display = "flex";

        setTimeout(() => {
            modal.style.display = "none";
            window.location.href = "/projeto_rh/login/login.php";
        }, 3000);
    }

    // ✅ Envio com fetch
    document.getElementById("formCadastroEmpresa").addEventListener("submit", function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro na resposta do servidor.");
            }
            return response.text(); // ou response.json() se PHP retornar JSON
        })
        .then(data => {
            // Sucesso!
            mostrarModalERedirecionar();
        })
        .catch(error => {
            console.error("Erro ao cadastrar:", error);
            alert("Ocorreu um erro ao tentar cadastrar. Tente novamente.");
        });
    });

    mudarEtapa();
</script>


</body>
</html>
