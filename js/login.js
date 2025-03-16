// Função para tratar a resposta do Google
function handleCredentialResponse(response) {
    // Usando a biblioteca jwt-decode para decodificar o token
    const data = jwt_decode(response.credential);
    console.log(data); // Exibe os dados decodificados

    // Enviar email para verificar no banco de dados
    const email = data.email;

    // Chamada para verificar se o usuário existe
    fetch(`http://localhost/projeto_rh/views/server/verificar-usuario.php?email=${email}`)
        .then(response => response.json())  // Espera a resposta JSON
        .then(data => {
            if (data.status === 'found') {
                // Redireciona para a página do candidato ou empresa, dependendo do tipo
                if (data.user.tipo === 'candidato') {
                    window.location.href = '/pagina-candidato.php';
                } else if (data.user.tipo === 'empresa') {
                    window.location.href = '/pagina-empresa.php';
                }
            } else {
                // Redireciona para a página de cadastro
                window.location.href = '/pagina-cadastro.php';
            }
        })
        .catch(error => {
            console.error('Erro ao verificar usuário:', error);
        });
}
