//Carico gli elementi dal file content.js
for (let cerchio of cerchi) {
    const container = document.querySelector("#container"); //Seleziono il container dove andranno gli elementi
    const div = document.createElement("div"); //Creo il contenitore e i vari pezzi dell'elemento
    const div1 = document.createElement("div");
    const titolo = document.createElement("h1");
    const prefe = document.createElement("img");
    const image = document.createElement("img");
    const descShow = document.createElement("p");
    const desc = document.createElement("p");
    titolo.textContent = cerchio.marca + " " + cerchio.modello; //Concateno marca e modello nella stringa titolo
    image.src = cerchio.immagine;
    image.classList.add("immagine");
    prefe.src = "img/aggiungipreferiti.png";
    prefe.classList.add("preferiti");
    prefe.addEventListener("click", aggiungiPreferiti);
    div1.classList.add("titolo");
    descShow.textContent = "Clicca per mostrare la descrizione";
    descShow.addEventListener("click", mostraDesc);
    desc.textContent = cerchio.descrizione;
    desc.classList.add("hidden");
    desc.classList.add("descrizione");
    div1.appendChild(titolo);
    div1.appendChild(prefe);
    div.appendChild(div1);
    div.appendChild(image);
    div.appendChild(descShow);
    div.appendChild(desc);
    div.classList.add("item");
    container.appendChild(div);
}

function mostraDesc(event) {
    const pulsante = event.currentTarget;
    const descrizione = pulsante.parentNode.querySelector(".descrizione");
    descrizione.classList.remove("hidden");
    pulsante.textContent = "Nascondi descrizione";
    pulsante.removeEventListener("click", mostraDesc);
    pulsante.addEventListener("click", nascondiDesc);
}

function nascondiDesc(event) {
    const pulsante = event.currentTarget;
    const descrizione = pulsante.parentNode.querySelector(".descrizione");
    descrizione.classList.add("hidden");
    pulsante.textContent = "Clicca per mostrare la descrizione";
    pulsante.removeEventListener("click", nascondiDesc);
    pulsante.addEventListener("click", mostraDesc);
}

function aggiungiPreferiti(event) {
    const sezionePreferiti = document.querySelector("#preferiti");
    const icona = event.currentTarget;
    const immagine = icona.parentNode.parentNode.querySelector(".immagine");
    const titolo = icona.parentNode;
    const div = document.createElement("div");
    icona.src = "img/rimuovipreferiti.png";
    div.classList.add("item");
    let newTitoloDiv = document.createElement("div");
    const newTitolo = document.createElement("h1");
    const newPrefe = document.createElement("img");
    newTitolo.textContent = titolo.querySelector("h1").textContent;
    newPrefe.src = titolo.querySelector("img").src;
    newPrefe.classList.add("preferiti");
    newTitoloDiv.appendChild(newTitolo);
    newTitoloDiv.appendChild(newPrefe);
    newTitoloDiv.classList.add("titolo");
    newTitoloDiv.querySelector("img").addEventListener("click", rimuoviPreferiti);
    let newImmagine = document.createElement("img");
    newImmagine.src = immagine.src;
    newImmagine.classList.add("immagine");
    sezionePreferiti.appendChild(div);
    div.appendChild(newTitoloDiv);
    div.appendChild(newImmagine);
    sezionePreferiti.parentNode.classList.remove("hidden");
    sezionePreferiti.classList.add("containerpreferiti");
    icona.removeEventListener("click", aggiungiPreferiti);
    icona.addEventListener("click", rimuoviDaiPreferiti);
}

//Funzione richiamata quando rimuovo un prefetito cliccando l'icona di un elemento direttamente dalla sezione dei preferiti
function rimuoviPreferiti(event) {
    const icona = event.currentTarget;
    const sezionePreferiti = document.querySelector("#preferiti");
    icona.src = "img/aggiungipreferiti.png";
    icona.removeEventListener("click", rimuoviPreferiti);
    icona.addEventListener("click", aggiungiPreferiti);
    icona.parentNode.parentNode.remove();
    if (sezionePreferiti.childNodes.length === 0) {
        sezionePreferiti.parentNode.classList.add("hidden");
    }
    let nodi = document.querySelectorAll("#container .item");
    for (let nodo of nodi) { //Cerco l'elemento tra tutti i cerchi per poter modificare l'icona e riassegnare il giusto listener
        if (nodo.querySelector(".item h1").textContent === icona.parentNode.querySelector("h1").textContent) {
            nodo.querySelector(".titolo img").src = "img/aggiungipreferiti.png";
            nodo.querySelector(".titolo img").removeEventListener("click", rimuoviDaiPreferiti);
            nodo.querySelector(".titolo img").addEventListener("click", aggiungiPreferiti);
        }
    }
}

//Funzione richiamata quando rimuovo un preferito cliccando l'icona di un elemento dalla sezione dove vi sono tutti i cerchi
function rimuoviDaiPreferiti(event) {
    const sezionePreferiti = document.querySelector("#preferiti");
    const icona = event.currentTarget;
    let nodi = document.querySelectorAll("#preferiti .item");
    for (let nodo of nodi) { //Cerco l'elemento da riuuovere dalla sezione dei preferiti
        if (nodo.querySelector(".titolo h1").textContent === icona.parentNode.querySelector("h1").textContent) {
            nodo.remove();
            icona.src = "img/aggiungipreferiti.png";
            icona.removeEventListener("click", rimuoviDaiPreferiti);
            icona.addEventListener("click", aggiungiPreferiti);
            if (sezionePreferiti.childNodes.length === 0)
                sezionePreferiti.parentNode.classList.add("hidden");
        }
    }
}

const barradiricerca = document.querySelector("#barradiricerca");
barradiricerca.addEventListener("keyup", aggiornaVisibili);

//Funzione che aggiorna la sezione contenente tutti i cerchi in funzione della barra di ricerca
function aggiornaVisibili(event) {
    const testo = event.currentTarget.value;
    const container = document.querySelector("#container");
    let elementi = document.querySelectorAll("#container .item");
    for (let elemento of elementi) {
        if (elemento.querySelector(".titolo").textContent.toLowerCase().search(testo.toLowerCase()) === -1) {
            console.log(elemento.querySelector(".titolo").textContent);
            elemento.classList.add("hidden");
        } else {
            elemento.classList.remove("hidden");
        }
    }
}