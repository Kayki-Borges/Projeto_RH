fetch("/Projeto_RH/login/google-callback.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "token=" + response.credential
})
.then(response => {
    // Verifica se a resposta é do tipo JSON antes de tentar fazer o parse
    return response.json(); // Tentando fazer o parse da resposta como JSON
})
.then(data => {
    // Verifique se o status é "success"
    if (data.status === "success") {
        window.location.href = "dashboard.php"; // Redireciona para o dashboard
    } else {
        alert("Erro ao fazer login: " + data.message);
    }
})
.catch(error => {
    // Lidar com erros de rede ou de resposta
    console.error("Erro ao fazer login:", error);
});
