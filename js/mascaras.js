// Máscara para CPF
function mascaraCPF(cpf) {
    cpf = cpf.replace(/\D/g, ''); // Remove tudo o que não for número
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    return cpf;
}

// Máscara para Telefone
function mascaraTelefone(telefone) {
    telefone = telefone.replace(/\D/g, ''); // Remove tudo o que não for número
    telefone = telefone.replace(/^(\d{2})(\d)/g, "($1) $2");
    telefone = telefone.replace(/(\d)(\d{4})$/, "$1-$2");
    return telefone;
}

// Adicionar máscara ao digitar
document.addEventListener('input', function(e) {
    if (e.target.id === 'cpf') {
        e.target.value = mascaraCPF(e.target.value);
    } else if (e.target.id === 'telefone') {
        e.target.value = mascaraTelefone(e.target.value);
    }
});
