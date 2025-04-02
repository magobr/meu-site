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

const modalElementInit = (elements) => {
    let images = [];
    elements.forEach(element => {
        images.push(`<img class="element-modal element" id="${element.id}" src="${element.image}" alt="image" width="300">`);
    });

    document.body.insertAdjacentHTML("beforeend",
        `
        <div class="modal modal_hide" id="modal_elements">
            <div class="modal__container">
                <div class="modal_content">
                    <div class="modal_content-text">
                    ${images.join('')}
                    </div>
                    <div class="modal_content-buttons">
                        <button id="element_submit_ok" class="input__form_field input__form_btn btn-green">OK</button>
                        <button id="element_submit_cancel" class="input__form_field input__form_btn btn-red">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    `);
}

var elementSelected = null;

function getElementSelected(){
    return elementSelected;
}

const setSelectElement = () => {
    const elementsModal = document.querySelectorAll('.element-modal');
    elementsModal.forEach(element => {
        element.addEventListener('click', (e) => {
            elementSelected = {
                id: element.id,
                image: element.src
            };
            element.classList.add("element-selected");
            element.classList.remove("element");

            var elementsSelecteds = document.querySelectorAll('.element-selected');
            elementsSelecteds.forEach(element => {
                if(element.id != elementSelected.id){
                    element.classList.remove("element-selected");
                    element.classList.add("element");
                }
            });
        });
    });
};



const modalElementsFunction = async () =>{

    return new Promise((resolve)=>{
        let modalElement = document.querySelector(`#modal_elements`);
        modalElement.classList.remove("modal_hide");

        setSelectElement();

        const submitElemet = document.querySelector(`#element_submit_ok`);
        const cancelElemet = document.querySelector(`#element_submit_cancel`);

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