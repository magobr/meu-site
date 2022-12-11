const modalInit = (text) => {
    document.body.insertAdjacentHTML("beforeend",
        `
        <div class="modal modal_hide" id="modal">
            <div class="modal__container">
                <div class="modal_content">
                    <div class="modal_content-text">
                        ${text}
                    </div>
                    <div class="modal_content-buttons">
                        <button id="submit_ok" class="input__form_field input__form_btn btn-green">OK</button>
                        <button id="submit_cancel" class="input__form_field input__form_btn btn-red">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    `);
}

const modalFunction = async () =>{

    return new Promise((resolve)=>{
        let modalElement = document.querySelector(`#modal`);
        modalElement.classList.remove("modal_hide");

        const submitElemet = document.querySelector(`#submit_ok`);
        const cancelElemet = document.querySelector(`#submit_cancel`);

        submitElemet.addEventListener("click", (e)=>{
            modalElement.classList.add("modal_hide");
            resolve(true);
        });
    
        cancelElemet.addEventListener("click", (e)=>{
            modalElement.classList.add("modal_hide");
            resolve(false);
        });
        
    });
};