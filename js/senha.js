
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
function mostrarSenhaConfirm(){
    var inputPassConfirm = document.getElementById('confirmar_senha')
    var btnSenhaConfirm = document.getElementById('comfirmIcon')

    if(inputPassConfirm === 'password'){
        inputPassConfirm.setAttribute('type','text')
        btnSenhaConfirm.classList.replace('bi-eye-slash-fill','bi-eye-fill')
    }else{
        inputPassConfirm.setAttribute('type','password')
        btnSenhaConfirm.classList.replace('bi-eye-fill','bi-eye-slash-fill')
    }
}