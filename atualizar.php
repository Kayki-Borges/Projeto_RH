
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script>
        function aplicarMascaraCNPJ(cnpj) {
            cnpj = cnpj.replace(/\D/g, "");
            if (cnpj.length <= 14) {
                cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
                cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
                cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
                cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");
            }
            return cnpj;
        }

        function aplicarMascaraTelefone(telefone) {
            telefone = telefone.replace(/\D/g, "");
            if (telefone.length === 11) {
                telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
            } else if (telefone.length === 10) {
                telefone = telefone.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
            }
            return telefone;
        }

        function mascararCNPJ(input) {
            input.value = aplicarMascaraCNPJ(input.value);
        }

        function mascararTelefone(input) {
            input.value = aplicarMascaraTelefone(input.value);
        }
    </script>

    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 80px;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Atualizar Dados</h1>
        <form action="/projeto_rh/seu_arquivo.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome_empresa" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email_empresa" required>

            <label for="cnpj">CNPJ:</label>
            <input type="text" id="cnpj" name="cnpj_empresa" oninput="mascararCNPJ(this)" required>

            <label for="endereco">Endereço:</label>
            <textarea id="endereco" name="endereco_empresa" required></textarea>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone_empresa" oninput="mascararTelefone(this)" required>

            <label for="area_atuacao">Área de Atuação:</label>
            <input type="text" id="area_atuacao" name="area_atuacao" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha_empresa" required>

            <button type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>
