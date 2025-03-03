 // Função para alternar entre mostrar e esconder a senha
 document.getElementById("toggleSenha").addEventListener("click", function() {
    var senhaInput = document.getElementById("senha_empresa");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";  // Mostra a senha
    } else {
        senhaInput.type = "password";  // Esconde a senha
    }
});

// Função para alternar entre mostrar e esconder a confirmação da senha
document.getElementById("toggleConfirmarSenha").addEventListener("click", function() {
    var confirmarSenhaInput = document.getElementById("confirmar_senha_empresa");
    if (confirmarSenhaInput.type === "password") {
        confirmarSenhaInput.type = "text";  // Mostra a confirmação da senha
    } else {
        confirmarSenhaInput.type = "password";  // Esconde a confirmação
    }
});

// Validação de senhas coincidentes
document.getElementById("formCadastro").addEventListener("submit", function(e) {
    var senha = document.getElementById("senha_empresa").value;
    var confirmarSenha = document.getElementById("confirmar_senha_empresa").value;
    if (senha !== confirmarSenha) {
        e.preventDefault();  // Impede o envio do formulário
        document.getElementById("errorSenha").style.display = "block";
    } else {
        document.getElementById("errorSenha").style.display = "none";
    }
});

// Máscara para CNPJ
function mascaraCNPJ(input) {
    input.value = input.value.replace(/\D/g, ''); // remove tudo o que não for número
    if (input.value.length > 14) input.value = input.value.slice(0, 14);
    input.value = input.value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
}

// Máscara para Telefone
function mascaraTelefone(input) {
    input.value = input.value.replace(/\D/g, ''); // remove tudo o que não for número
    if (input.value.length > 11) input.value = input.value.slice(0, 11);
    input.value = input.value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
}