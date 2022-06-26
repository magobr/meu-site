// Back to Top
const backToTopButton = document.querySelector(".back-to-top");

const goToTop = () => {
    window.scrollTo({
        top: 0, 
        behavior: "smooth"
    })
};

backToTopButton.addEventListener("click", goToTop);