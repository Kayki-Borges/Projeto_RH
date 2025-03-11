const but = document.getElementById('but')
const body = document.querySelector('body')

but.addEventListener('click', ()=>{
    body.classList.toggle('dark')
})