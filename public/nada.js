const express = require('express');
const mysql = require('mysql2');
const jwt_decode = require('jwt-decode');
const app = express();
const port = 3000;

// Configuração de conexão com o banco de dados MySQL
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '', // Coloque sua senha de MySQL, se houver
    database: 'projeto_rh'
});

db.connect(err => {
    if (err) {
        console.log('Erro ao conectar com o banco de dados:', err);
    } else {
        console.log('Conectado ao banco de dados');
    }
});

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// Página inicial com o botão de login do Google
app.get('/', (req, res) => {
    res.send('<h1>Bem-vindo ao Sistema de Login!</h1><a href="/login">Login com Google</a>');
});

// Rota para login com Google e redirecionamento
app.get('/login', (req, res) => {
    res.send(`
        <html>
            <body>
                <button id="googleLoginBtn">Logar com Google</button>
                <script src="https://accounts.google.com/gsi/client" async></script>
                <script>
                    window.onload = function () {
                        google.accounts.id.initialize({
                            client_id: "SEU_CLIENT_ID_AQUI", // Substitua pelo seu Client ID
                            callback: handleCredentialResponse
                        });
                        google.accounts.id.renderButton(
                            document.getElementById("googleLoginBtn"),
                            { theme: "outline", size: "large" }
                        );
                        google.accounts.id.prompt();
                    }

                    function handleCredentialResponse(response) {
                        const decodedToken = jwt_decode(response.credential);
                        const email = decodedToken.email;
                        const nome = decodedToken.given_name;

                        // Enviar para o servidor para verificar se o usuário já existe no banco
                        fetch('/verificar-usuario', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ email: email, nome: nome })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.existe) {
                                // Verifica se é candidato ou empresa
                                if (data.tipo === 'candidato') {
                                    window.location.href = "/dashboard/candidato";
                                } else if (data.tipo === 'empresa') {
                                    window.location.href = "/dashboard/empresa";
                                }
                            } else {
                                // Redireciona para a página de completar cadastro
                                window.location.href = "/completar-cadastro?email=" + email + "&nome=" + nome;
                            }
                        });
                    }
                </script>
            </body>
        </html>
    `);
});

// Verificar se o usuário já existe no banco
app.post('/verificar-usuario', (req, res) => {
    const { email, nome } = req.body;

    // Verifica se o usuário é Candidato
    db.query('SELECT * FROM candidatos WHERE email_candidato = ?', [email], (err, candidatoResults) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao verificar o usuário' });
        }

        if (candidatoResults.length > 0) {
            // O usuário é um Candidato
            return res.json({ existe: true, tipo: 'candidato' });
        } else {
            // Verifica se o usuário é Empresa
            db.query('SELECT * FROM empresas WHERE email_empresa = ?', [email], (err, empresaResults) => {
                if (err) {
                    return res.status(500).json({ error: 'Erro ao verificar o usuário' });
                }

                if (empresaResults.length > 0) {
                    // O usuário é uma Empresa
                    return res.json({ existe: true, tipo: 'empresa' });
                } else {
                    // O usuário não existe nem como Candidato nem como Empresa
                    return res.json({ existe: false });
                }
            });
        }
    });
});

// Página de completar cadastro
app.get('/completar-cadastro', (req, res) => {
    const { email, nome } = req.query;
    res.send(`
        <h1>Complete seu cadastro, ${nome}</h1>
        <form action="/finalizar-cadastro" method="POST">
            <input type="hidden" name="email" value="${email}">
            <input type="text" name="cpf" placeholder="CPF" required><br>
            <input type="text" name="telefone" placeholder="Telefone" required><br>
            <input type="text" name="endereco" placeholder="Endereço" required><br>
            <button type="submit">Finalizar Cadastro</button>
        </form>
    `);
});

// Finalizar cadastro e salvar no banco
app.post('/finalizar-cadastro', (req, res) => {
    const { email, cpf, telefone, endereco } = req.body;

    // Insira os dados na tabela candidatos
    db.query('INSERT INTO candidatos (nome_candidato, email_candidato, cpf_candidato, telefone_candidato, endereco_candidato) VALUES (?, ?, ?, ?, ?)', 
    [req.body.nome, email, cpf, telefone, endereco], (err, results) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao salvar o cadastro' });
        }
        res.send(`<h1>Cadastro concluído com sucesso!</h1>`);
    });
});

// Página do Candidato
app.get('/dashboard/candidato', (req, res) => {
    res.send('<h1>Bem-vindo à sua área de Candidato!</h1>');
});

// Página da Empresa
app.get('/dashboard/empresa', (req, res) => {
    res.send('<h1>Bem-vindo à sua área de Empresa!</h1>');
});

app.listen(port, () => {
    console.log(`Servidor rodando na porta ${port}`);
});
