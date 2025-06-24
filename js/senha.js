
//Mostrar senha
function mostrarSenha(){
    var inputPass = document.getElementById('senha')
        
    if(inputPass.type === 'password'){
         inputPass.setAttribute('type','text')
    }else{
        inputPass.setAttribute('type','password')
    }
}

//Mostrar senha comfirmar
function mostrarSenhaConfirm(){
    var inputPassConfirm = document.getElementById('confirmar_senha')

    if(inputPassConfirm === 'password'){
        inputPassConfirm.setAttribute('type','text')
    }else{
        inputPassConfirm.setAttribute('type','password')
    }
}