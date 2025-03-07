<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="/Projeto_RH/css/style.css">
    <style>
        /* Estilos do Modal */
        .modal {
            display: none; /* Oculta o modal por padrão */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Fundo mais escuro */
            backdrop-filter: blur(5px); /* Desfoque de fundo */
            animation: fadeInBackground 0.6s ease-out;
        }

        /* Janela do Modal */
        .modal-content {
            background-color: white; /* Fundo branco para a janela */
            color: #333; /* Cor do texto */
            border-radius: 8px;
            padding: 30px;
            width: 50%;
            margin: 10% auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            transform: scale(0.8);
            animation: slideIn 0.8s ease-out forwards; /* Animação de entrada mais suave */
        }

        /* Animação para o fundo */
        @keyframes fadeInBackground {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Animação de Slide In para o modal */
        @keyframes slideIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Estilos do título */
        .modal h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #4A148C; /* Roxo */
        }

        /* Estilos do conteúdo */
        .modal p {
            font-size: 18px;
            line-height: 1.5;
            color: #555;
        }

        /* Botões dentro do Modal */
        .modal button {
            background-color: #2979FF; /* Azul */
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .modal button:hover {
            background-color: #1C54B2; /* Azul mais escuro */
        }

        /* Animação para o botão */
        .modal button {
            transform: translateY(20px);
            animation: fadeInButton 1s ease-out forwards 0.3s; /* Suaviza a entrada do botão */
        }

        /* Animação para o botão */
        @keyframes fadeInButton {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Exemplo do Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <h2>Cadastro Concluído!</h2>
            <p>Seu cadastro foi realizado com sucesso. Você pode agora fazer login.</p>
            <button id="btnLogin">Ir para Login</button>
        </div>
    </div>

    <!-- Script para abrir o modal após o cadastro -->
    <script>
        // Função para mostrar o modal
        function showModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
        }

        // Funcionalidade do botão de redirecionamento
        document.getElementById("btnLogin").onclick = function() {
            window.location.href = "/Projeto_RH/login/login.php"; // Redireciona para a página de login
        }

        // Simula o cadastro e abre o modal
        // Aqui você pode adaptar para abrir o modal após o envio do formulário
        window.onload = function() {
            showModal();  // Simulando a exibição do modal após o cadastro
        }
    </script>
</body>
</html>
