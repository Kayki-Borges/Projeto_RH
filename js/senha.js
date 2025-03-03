 // Função para alternar entre mostrar e esconder a senha
 document.getElementById("toggleSenha").addEventListener("click", function() {
    var senhaInput = document.getElementById("senha");
    
    // Alterna o tipo entre 'password' e 'text' para mostrar ou esconder a senha
    if (senhaInput.type === "password") {
        senhaInput.type = "text";  // Mostra a senha
    } else {
        senhaInput.type = "password";  // Esconde a senha
    }
});

// Função para alternar entre mostrar e esconder a confirmação da senha
document.getElementById("toggleConfirmarSenha").addEventListener("click", function() {
    var confirmarSenhaInput = document.getElementById("confirmar_senha");

    // Alterna o tipo entre 'password' e 'text' para mostrar ou esconder a confirmação
    if (confirmarSenhaInput.type === "password") {
        confirmarSenhaInput.type = "text";  // Mostra a confirmação da senha
    } else {
        confirmarSenhaInput.type = "password";  // Esconde a confirmação
    }
});