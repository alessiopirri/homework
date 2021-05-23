fetch("getSession.php").then(onResponse).then(onJsonSession);

let session; //boolean sessione attiva o meno
function onJsonSession(json) {
    session = json; //true o false
    fetch("trovapneumatici.php").then(onResponse).then(onJson);
}

function onResponse(response) {
    return response.json();
}

function onJson(json) {
    console.log(json);
    const container = document.querySelector("#container"); //Seleziono il container dove andranno gli elementi
    for (let pneumatico of json) {
        const div = document.createElement("div"); //Creo il contenitore e i vari pezzi dell'elemento
        const div1 = document.createElement("div");
        const titolo = document.createElement("h1");
        const image = document.createElement("img");
        const descShow = document.createElement("p");
        //const carrello = document.createElement("img");
        const prezzo = document.createElement("p");
        const desc = document.createElement("p");
        titolo.textContent = pneumatico.marca + " " + pneumatico.modello; //Concateno marca e modello nella stringa titolo
        image.src = pneumatico.immagine != "" ? pneumatico.immagine : "img/immagine-non-disponibile.png";
        image.classList.add("immagine");
        /*carrello.src = "img/carrello.png";
        carrello.classList.add("carrello");
        carrello.addEventListener("click", session ? aggiungiCarrello : login);*/
        prezzo.textContent = "€" + pneumatico.prezzo;
        div1.classList.add("titolo");
        descShow.textContent = "Clicca per mostrare la descrizione";
        descShow.addEventListener("click", mostraDesc);
        desc.textContent = pneumatico.descrizione != "" ? pneumatico.descrizione : "Descrizione non disponibile";
        desc.classList.add("hidden");
        desc.classList.add("descrizione");
        div1.appendChild(titolo);
        //div1.appendChild(carrello);
        div.appendChild(div1);
        div.appendChild(image);
        div.appendChild(prezzo);
        div.appendChild(descShow);
        div.appendChild(desc);
        div.classList.add("item");
        div.dataset.codice = pneumatico.codice;
        div.addEventListener("click", apriProdotto);
        container.appendChild(div);
    }
    if (json.length == 0) {
        //console.log("Non ci sono prodotti corrispondenti alla tua ricerca");
        const na = document.createElement("p");
        na.textContent = "Non ci sono prodotti corrispondenti alla tua ricerca";
        na.id = "noproduct";
        document.querySelector("#container").appendChild(na);
    }
    // container.scrollIntoView();
}

function mostraDesc(event) {
    event.stopPropagation();
    const pulsante = event.currentTarget;
    const descrizione = pulsante.parentNode.querySelector(".descrizione");
    descrizione.classList.remove("hidden");
    pulsante.textContent = "Nascondi descrizione";
    pulsante.removeEventListener("click", mostraDesc);
    pulsante.addEventListener("click", nascondiDesc);
}

function nascondiDesc(event) {
    event.stopPropagation();
    const pulsante = event.currentTarget;
    const descrizione = pulsante.parentNode.querySelector(".descrizione");
    descrizione.classList.add("hidden");
    pulsante.textContent = "Clicca per mostrare la descrizione";
    pulsante.removeEventListener("click", nascondiDesc);
    pulsante.addEventListener("click", mostraDesc);
}
/*
function aggiungiCarrello(event) {
    console.log(event.currentTarget.parentNode.parentNode.dataset["codice"]);
    event.stopPropagation();
    fetch("inseriscicarrello.php?p=" + event.currentTarget.parentNode.parentNode.dataset["codice"] + "&q=1");
    /*
    event.stopPropagation();
    const modal = document.querySelector("#modal-add-cart");
    modal.style.top = window.pageYOffset + "px";
    modal.classList.remove("hidden");
    document.body.classList.add("no-scroll");
    modal.addEventListener("click", chiudiModaleCarrello);
    console.log(event.currentTarget.parentNode.parentNode);
    const elemento = event.currentTarget.parentNode.parentNode;
    const img = document.createElement("img");
    const titolo = document.createElement("p");

    img.src = elemento.childNodes.img.src;
    modal.appendChild(img);
    
}
*/
/*
function login(event) {
    console.log("accedi");
    const modal = document.querySelector("#modal-view");
    modal.style.top = window.pageYOffset + "px";
    modal.classList.remove("hidden");
    document.body.classList.add("no-scroll");
    modal.addEventListener("click", chiudiModale);
    event.stopPropagation();
}

function chiudiModale(event) {
    document.querySelector("#modal-view").classList.add("hidden");
    document.body.classList.remove("no-scroll");
}
*/
function apriProdotto(event) {
    console.log(event.currentTarget);
    window.location.assign("paginaprodotto.php?type=p&code=" + event.currentTarget.dataset["codice"]);
}