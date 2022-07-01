const sectionContainer = document.querySelector("section .container");
const sectionContainerPost = document.querySelector("section .container .content__posts");
const divComentarios = document.querySelector('#disqus_thread');

const consumeApi = async (body=null, endPoint, method="POST", mode="") =>{
    var dataForm = new FormData();
    dataForm.append("json", JSON.stringify(body));

    var headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }

    if (mode == "no-cors")
        headers["mode"] = "no-cors";

    var response = "";
    try {
        var responseApi = await fetch(endPoint, {
            method: method,
            headers: headers,
            body: (body !== null ? JSON.stringify(body) : body)
        });
        
        response = responseApi.json();
    } catch (error) {
        response = error;
    }

    return response;
    
}

const componentAllPosts = (content, newPost) => {
    if (newPost) {
        return `<div class="post__item" id="${content.id}">
                    <div class="post__item_new"><span>New Post!</span></div>
                    <div class="post__item__titulo"><h1>${content.titulo}</h1></div>
                    <div class="post__item__autor info">${content.user_post}</div>
                    <div class="post__item__data info">${content.created_at}</div>
                </div>`;    
    }
    return `<div class="post__item" id="${content.id}">
                <div class="post__item__titulo"><h1>${content.titulo}</h1></div>
                <div class="post__item__autor info">${content.user_post}</div>
                <div class="post__item__data info">${content.created_at}</div>
            </div>`;
}

const componentPost = (content) => {
    return `<div id="${content.id}" class="content__posts__item">
                <button id="back_post">Voltar</button>
                <div class="posts__item">
                    <div class="posts__item__titulo"><h1>${content.titulo}</h1></div>
                    <div class="posts__item__info">
                        <div class="posts__item__data">${content.created_at}</div>
                        <div class="posts__item__user">${content.user_post}</div>
                    </div>
                    <div class="posts__item__content">${content.conteudo}</div>
                </div>
            </div>`;
}

async function load() {
    let res = await consumeApi(null, "/blog/posts", "GET");
    if (res.data.length !== 0) {
        res.data.forEach((element, index) => {
            if (index === 0) {
                sectionContainerPost.innerHTML += componentAllPosts(element, true);  
            } else {
                sectionContainerPost.innerHTML += componentAllPosts(element, false);
            }
        });
        return
    }
    sectionContainer.innerHTML += "<h3 style='padding: 30px;'>Sem Postagens por enquanto, aguarde!</h3>";
}

async function loadAllPosts(){
    await load();
    for (let i = 0; i <  sectionContainerPost.children.length; i++) {
        sectionContainerPost.children[i].addEventListener("click", async ()=>{
            let res = await consumeApi(null, `/blog/posts/${sectionContainerPost.children[i].id}`, "GET");
            sectionContainerPost.remove();

            sectionContainer.innerHTML = componentPost(res.data[0])
            divComentarios.classList.remove('d-none');

            var disqus_config = function () {
                this.page.url = window.location;
                this.page.identifier = data[0].id; 
            };
            
            let btnBack = document.getElementById("back_post");
            btnBack.addEventListener("click", async ()=>{
                window.location.reload();
            })
        })
    }
    
}

async function start() {
    loadAllPosts();
}

(async ()=>{
    await start();
})()   

