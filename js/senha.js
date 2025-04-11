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

//Mostrar senha
function mostrarSenha(){
    var inputPass = document.getElementById('senha')
    var btnSenha = document.getElementById('SenhaIcon')
        
    if(inputPass.type === 'password'){
         inputPass.setAttribute('type','text')
         btnSenha.classList.replace('bi-eye-slash-fill','bi-eye-fill')
    }else{
        inputPass.setAttribute('type','password')
        btnSenha.classList.replace('bi-eye-fill','bi-eye-slash-fill')
    }
}

//Mostrar senha comfirmar
function mostrarSenhaDois(){
    var inputPassConfirm = document.getElementById('confirmar_senha')
    var btnSenhaConfirm = document.getElementById('confirmIcon')

    if(inputPassConfirm === 'password'){
        inputPassConfirm.setAttribute('type','text')
        btnSenhaConfirm.classList.replace('bi-eye-slash-fill','bi-eye-fill')
    }else{
        inputPassConfirm.setAttribute('type','password')
        btnSenhaConfirm.classList.replace('bi-eye-fill','bi-eye-slash-fill')
    }
}