const headerMenu = document.querySelector('header .header__menu');
const menuIcon = document.querySelector('#menu-icon');
const closeMenuIcon = document.querySelector('#close-menu-icon');

menuIcon.addEventListener('click', ()=>{
    headerMenu.classList.add('open');
})

closeMenuIcon.addEventListener('click', ()=>{
    headerMenu.classList.remove('open');
})


// Back to Top
const backToTopButton = document.querySelector(".back-to-top");

if (backToTopButton != undefined) {

    const goToTop = () => {
        window.scrollTo({
            top: 0, 
            behavior: "smooth"
        })
    };
    
    backToTopButton.addEventListener("click", goToTop);    
}