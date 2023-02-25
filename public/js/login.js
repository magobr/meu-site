const inputs = document.querySelectorAll("input");
const formLogin = document.querySelector("#form_login");

const formValidate = function (input) {
    if (input.value == "" && input.type != "submit") {
        return false
    }
    return true
}

const formValue = function (inputs) {
    let res = {
        user: {}
    };

    let retorno = true;
    let errorMessage = [];
    
    for(itemInput of inputs){

        if(!formValidate(itemInput)){
            setErrorInputs(itemInput);
            errorMessage.push(`Preencha o campo ${itemInput.name}`);
            retorno = false;
        }

        if (retorno) {
            setSuccessInputs(itemInput);
        }

        res.user[itemInput.name] = itemInput.value;
    }

    if(!retorno){
        alertErrorInit(messageFilter(errorMessage));
        alertErrorFunction();
        return retorno;
    }

    return res;
}

const setErrorInputs = (input)=>{
    input.classList.add("form__error");    
}

const setSuccessInputs = (input)=>{
    input.classList.remove("form__error");    
}

const apiConsume = async function (url, body) {
    var data = JSON.stringify(body);
    var options = {
        method: 'POST',
        body: data
    }
    try {
        const response = await fetch(url, options);
        return await response.json();
    } catch (error) {
        return error.json();
    }
}

const getCookie = function (cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return false;
}

const messageFilter = (arrStr)=>{
    if (!Array.isArray(arrStr)) {
        return arrStr;
    }
    
    let messages = "";
    arrStr.map((message)=>{
        messages += `<p>${message}</p>`;
    });
    return messages;
}

formLogin.addEventListener("submit", async (e)=>{
    e.preventDefault();
    var values = formValue(inputs);

    if (!values)
        return false;

    var response = await apiConsume("/user/login", values);        
    var cookies = getCookie("USER_TOKEN");

    if (response.error === false) {
        alertSuccessInit(response.message);
        const alertResponse = await alertSuccessFunction();

        if(alertResponse){
            window.location.reload();
        }

        return;
    }

    let messageField = messageFilter(response.message);

    alertErrorInit(messageField);
    alertErrorFunction();
});