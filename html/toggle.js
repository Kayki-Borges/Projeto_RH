function mostrar() {
    let menuMobile = document.querySelector('.resp');
    if (menuMobile.classList.contains('abrir')) {
        menuMobile.classList.remove('abrir');
    } else {
        menuMobile.classList.add('abrir');
    }
}