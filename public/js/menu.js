const header__menu = document.querySelector('.header__menu');
const menuIcon = document.querySelector('#menu-icon');
const closeMenuIcon = document.querySelector('#close-menu-icon');

menuIcon.addEventListener('click', ()=>{
    header__menu.classList.add('open');
})

closeMenuIcon.addEventListener('click', ()=>{
    header__menu.classList.remove('open');
})

document.addEventListener('scroll', (e)=>{
    if(window.scrollY > 10){
        header__menu.classList.add('background_menu');
    } else {
        header__menu.classList.remove('background_menu');
    }
})