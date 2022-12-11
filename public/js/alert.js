const alertSuccessInit = (text) => {
    document.body.insertAdjacentHTML("beforeend",
        `
        <div class="alert_success alert_hide" id="alert_element">
            <div id="line_time" class="line_time"></div>
            <div class="alert_content">
                <div class="alert_content-text">
                    ${text}
                </div>
                <div class="alert_content-buttons">
                    <button id="alert_close" class="alert_close">x</button>
                </div>
            </div>
        </div>
    
    `);
}

const alertErrorInit = (text) => {
    document.body.insertAdjacentHTML("beforeend",
        `
        <div class="alert_error alert_hide-error" id="alert_element-error">
            <div id="line_time-error" class="line_time"></div>
            <div class="alert_content">
                <div class="alert_content-text">
                    ${text}
                </div>
                <div class="alert_content-buttons">
                    <button id="alert_close-error" class="alert_close-error">x</button>
                </div>
            </div>
        </div>
    
    `);
}

var idInterval;
const startTimer = (lineTimeBar) => {
    var lineBarSize = lineTimeBar.offsetWidth;
    return new Promise((resolve)=>{
        idInterval = setInterval(function () {
            lineTimeBar.style.width = `${lineBarSize}px`;
            if (--lineBarSize < 0) {
                lineBarSize = 0;
                return resolve(true) 
            }
        }, 50);
    })
}

const alertSuccessFunction = async () =>{
    let alertElement = document.querySelector(`#alert_element`);
    alertElement.classList.remove("alert_hide");

    const alertClose = document.querySelector(`#alert_close`);

    alertClose.addEventListener("click", (e)=>{
        alertElement.classList.add("alert_hide");
    });

    var display = document.querySelector('#line_time');
    var resTimer = await startTimer(display);
    if (resTimer) {
        alertElement.classList.add("alert_hide");
        clearInterval(idInterval);
        display.style.width = "100%"
    }
};

const alertErrorFunction = async () =>{
    let alertElement = document.querySelector(`#alert_element-error`);
    alertElement.classList.remove("alert_hide-error");

    const alertClose = document.querySelector(`#alert_close-error`);

    alertClose.addEventListener("click", (e)=>{
        alertElement.classList.add("alert_hide-error");
    });

    var display = document.querySelector('#line_time-error');
    var resTimer = await startTimer(display);
    if (resTimer) {
        alertElement.classList.add("alert_hide-error");
        clearInterval(idInterval);
        display.style.width = "100%"
    }
};