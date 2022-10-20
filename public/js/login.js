const inputs = document.querySelectorAll("input");
const formLogin = document.querySelector("#form_login");

const formValidate = function (input) {
    if (input.value == "" || input.type == "submit") {
        return false
    }
    return true
}

const formValue = function (inputs) {
    let res = {
        user: {}
    };
    for(itemInput of inputs){
        var inputValid = formValidate(itemInput);
        if(inputValid){
            res.user[itemInput.name] = itemInput.value
        }
    }
    return res;
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

formLogin.addEventListener("submit", async (e)=>{
    e.preventDefault();
    var values = formValue(inputs);
    var response = await apiConsume("/user/login", values);
    var cookies = getCookie("USER_TOKEN");
    console.log(response)
    if (!response.error) {
        window.location.reload;
    }
    
})