const header__menu = document.querySelector('.header__menu');

document.addEventListener('scroll', (e)=>{
    if(window.scrollY > 10){
        header__menu.classList.add('background_menu');
    } else {
        header__menu.classList.remove('background_menu');
    }
})