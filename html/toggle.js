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
const but = document.querySelector('.foto');
const menu = document.querySelector('.cont-list')

function apar() {
    let but = document.querySelector('.foto');
    let menu = document.querySelector('.cont-list')
    if (but.classList.contains('apar')) {
        but.classList.remove('apar')
        menu.classList.add('most')
    } else {
        menu.classList.remove('most')
        but.classList.add('apar')
    }
}
