const btn = document.querySelector('.conta')
const menu = document.querySelector('.menu-2')

btn.addEventListener('click', ()=> {
    menu.classList.toggle('active')
    btn.classList.toggle('active-2')
})