const logout = document.getElementById("logout");

var consumeApi = async (url, body = '', method = "GET")=>{
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