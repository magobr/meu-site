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