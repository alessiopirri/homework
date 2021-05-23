const url = new URL(window.location.href);

const code = url.searchParams.get("code");
const type = url.searchParams.get("type");

fetch("getSession.php").then(onResponse).then(onJsonSession);

function onResponse(response) {
    return response.json();
}

let session; //boolean sessione attiva o meno

function onJsonSession(json) {
    session = json; //true o false
    fetch("prodotto.php?type=" + type + "&code=" + code).then(onResponse).then(onJsonProdotto);
}

function onJsonProdotto(json) {
    //console.log(json);
    const titolo = document.querySelector("header h1");
    titolo.textContent = json.Marca + " " + json.Modello;

    const containerprodotto = document.querySelector("#containerprodotto");

    const img = document.createElement("img");
    const div = document.createElement("div");
    const prezzo = document.createElement("p");
    const misura = document.createElement("p");
    const select = document.createElement("select");
    const aggiungi = document.createElement("button");
    const messaggio = document.createElement("p");

    img.src = json.Img != "" ? json.Img : "img/immagine-non-disponibile.png";
    prezzo.textContent = "€" + json.Prezzo;
    misura.textContent = type == "p" ? "Misura: " + json.Misura : "Diametro: " + json.Diametro;
    //aggiungi.type = "button"
    aggiungi.textContent = "Aggiungi al carrello";

    prezzo.classList.add("grassetto");
    img.classList.add("img");
    div.classList.add("dettagli");
    messaggio.classList.add("messaggio");

    aggiungi.addEventListener("click", session ? aggiungiCarrello : login);

    containerprodotto.appendChild(img);
    containerprodotto.appendChild(div);
    div.appendChild(misura);
    div.appendChild(prezzo);
    div.appendChild(select);
    div.appendChild(aggiungi);
    div.appendChild(messaggio);
    fetch("getquantitacarrello.php?code=" + code).then(onResponse).then(onJsonQuantitaCarrello);

}

function onJsonQuantitaCarrello(jsonquantita) {
    //console.log(jsonquantita);
    fetch("disponibilita.php?code=" + code).then(onResponse).then((json) => onJsonDisponibilita(json, jsonquantita.quantita));
}

function onJsonDisponibilita(json, quantita) {
    //console.log(json);
    //console.log(quantita);
    const select = document.querySelector("#containerprodotto select");
    for (let i = 0; i <= json.QuantitaEcommerce; i++) {
        const option = document.createElement("option");
        option.textContent = i;
        option.value = i;
        option.selected = i == quantita ? true : false;
        select.appendChild(option);
    }
}

function aggiungiCarrello(event) {
    const messaggio = document.querySelector(".messaggio");
    messaggio.textContent = "";
    const q = document.querySelector("select").value;
    if (q > 0) {
        fetch("inseriscicarrello.php?p=" + code + "&q=" + q).then(onResponse).then(onJsonCarrello);
    } else {
        fetch("rimuovicarrello.php?p=" + code).then(onResponse).then(onJsonRimuovi);
    }

}

function onJsonCarrello(json) {
    const messaggio = document.querySelector(".messaggio");
    //p.textContent = json
    //console.log(json);
    messaggio.textContent = json ? "Prodotto aggiunto correttamente al carrello" : "Errore durante l'aggiunta al carrello";
}

function login(event) {
    const modal = document.querySelector("#modal-view");
    //const url = window.location;
    //console.log(url);
    document.querySelector("#modal-view a").href = 'login.php?ritorno=paginaprodotto.php?type=' + type + encodeURIComponent("&") + 'code=' + code;
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

function onJsonRimuovi(json) {
    const messaggio = document.querySelector(".messaggio");
    //p.textContent = json
    console.log(json);
    messaggio.textContent = json ? "Prodotto rimosso correttamente dal carrello" : "Errore durante la rimozione dal carrello";
}