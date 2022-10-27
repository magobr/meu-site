const logout = document.getElementById("logout");

var consumeApi = async (url, body = null, method = "GET")=>{
    console.log(body);
    try {
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: method,
            body: JSON.stringify(body)
        })
        return response.json()
    } catch (error) {
        return error
    }
}