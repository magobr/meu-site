// Back to Top
const backToTopButtonItem = `
    <button class="back-to-top" title="back To Up" onclick="goToTop()">
        <svg xmlns="http://www.w3.org/2000/svg" class="back-to-top-icon" viewBox="0 0 512 512"><title>Caret Up</title><path d="M414 321.94L274.22 158.82a24 24 0 00-36.44 0L98 321.94c-13.34 15.57-2.28 39.62 18.22 39.62h279.6c20.5 0 31.56-24.05 18.18-39.62z"/></svg>
    </button>
`

const goToTop = () => {
    window.scrollTo({
        top: 0, 
        behavior: "smooth"
    })
};

window.addEventListener("scroll", (e) => {
    if(window.scrollY > 100 && !document.querySelector(".back-to-top")) {
        document.body.insertAdjacentHTML('beforeend', backToTopButtonItem)
    }

    if(window.scrollY <= 100 && document.querySelector(".back-to-top")) {
        document.querySelector(".back-to-top")?.remove();
    }
});