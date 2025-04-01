//Função do menu Mobile
function mostrar() {
    let menuMobile = document.querySelector('.resp');
    if (menuMobile.classList.contains('abrir')) {
        menuMobile.classList.remove('abrir');
    } else {
        menuMobile.classList.add('abrir');
    }
}

//Função do Perfil
const but = document.querySelector('perfFoto');
const menu = document.querySelector('cont-list')

but.addEventListener('click', ()=>{
    menu.classList.toggle('apar');
})