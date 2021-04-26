// Chiave per il servizio di Bridgestone
const keyBridgestone = "57ebcc8429af3f4edb921d0043069d7a";

function onResponse(response) {
    return response.json();
}

// Funzione per creare un elemento option con testo "-"
function creaOption() {
    const disabled = document.createElement("option");
    disabled.textContent = '-';
    disabled.classList.add("disabilitato");
    return disabled;
}

// Fetch per richiedere gli anni
fetch("https://wl.tireconnect.ca/api/v2/vehicle/years?key=" + keyBridgestone).then(onResponse).then(onJsonAnno);


//                          RICERCA NEL DOM

// Cerco nel DOM il menù a tendina che mi consente di selezionare l'anno
const tendinaAnno = document.querySelector("#anno");

// Cerco nel DOM il menù a tendina che mi consente di selezionare la marca
const tendinaMarca = document.querySelector("#marca");

// Cerco nel DOM il menù a tendina che mi consente di selezionare il modello
const tendinaModello = document.querySelector("#modello");

// Cerco nel DOM il menù a tendina che mi consente di selezionare l'allestimento
const tendinaAllestimento = document.querySelector("#allestimento");

// Cerco nel DOM il menù a tendina che mi consente di selezionare la misura
const tendinaMisura = document.querySelector("#misura");

//                          EVENT LISTENER

// Aggiungo un event listener sensibile al cambio di selezione dell'anno, per poter ricercare le marche di automobili prodotte in quell'anno
tendinaAnno.addEventListener("change", cercaMarche);

// Aggiungo un event listener sensibile al cambio di selezione della marca, per poter ricercare i modelli di automobili prodotte in da quella marca in quell'anno
tendinaMarca.addEventListener("change", cercaModelli);

// Aggiungo un event listener sensibile al cambio di selezione del modello, per poter ricercare gli allestimenti
tendinaModello.addEventListener("change", cercaAllestimenti);

// Aggiungo un event listener sensibile al cambio di selezione dell'allestimento, per poter ricercare la misura dello pneumatico
tendinaAllestimento.addEventListener("change", cercaMisura);

//                          FUNZIONI LISTENER

// Funzione per cercare le marche
function cercaMarche(event) {
    const endpoint = "https://wl.tireconnect.ca/api/v2/vehicle/makes";
    const annoSelezionato = event.currentTarget.value;
    fetch(endpoint + "?key=" + keyBridgestone + "&year=" + annoSelezionato).then(onResponse).then(onJsonMarche);
}

// Funzione per cercare i modelli 
function cercaModelli(event) {
    const endpoint = "https://wl.tireconnect.ca/api/v2/vehicle/models";
    const annoSelezionato = tendinaAnno.value;
    const marcaSelezionata = event.currentTarget.value;
    fetch(endpoint + "?key=" + keyBridgestone + "&year=" + annoSelezionato + "&make=" + marcaSelezionata).then(onResponse).then(onJsonModelli);
}

// Funzione per cercare gli allestimenti 
function cercaAllestimenti(event) {
    const endpoint = "https://wl.tireconnect.ca/api/v2/vehicle/trims";
    const annoSelezionato = tendinaAnno.value;
    const marcaSelezionata = tendinaMarca.value;
    const modelloSelezionato = event.currentTarget.value;
    fetch(endpoint + "?key=" + keyBridgestone + "&year=" + annoSelezionato + "&make=" + marcaSelezionata + "&model=" + modelloSelezionato).then(onResponse).then(onJsonAllestimenti);
}

// Funzione per cercare la misura 
function cercaMisura(event) {
    const endpoint = "https://wl.tireconnect.ca/api/v2/vehicle/tireSizes";
    const annoSelezionato = tendinaAnno.value;
    const marcaSelezionata = tendinaMarca.value;
    const modelloSelezionato = tendinaModello.value;
    const allestimentoSelezionato = event.currentTarget.value;
    fetch(endpoint + "?key=" + keyBridgestone + "&year=" + annoSelezionato + "&make=" + marcaSelezionata + "&model=" + modelloSelezionato + "&trim=" + allestimentoSelezionato).then(onResponse).then(onJsonMisure);
}

//                          FUNZIONI ON JSON

// Funzione per aggingere gli anni alla tendina
function onJsonAnno(json) {
    tendinaAnno.appendChild(creaOption());
    // Scorro il vettore ritornato dalla fetch
    for (anno of json.data.values) {
        // Creo e appendo i vari elementi option riguardanti gli anni
        const option = document.createElement("option");
        option.value = anno;
        option.textContent = anno;
        tendinaAnno.appendChild(option);
    }
    const disabilitati = document.querySelectorAll(".disabilitato");
    for (dis of disabilitati) {
        dis.disabled = true;
    }
}

// Funzione per aggiungere le marche alla tendina
function onJsonMarche(json) {
    // Cancello le eventuali opzioni gia presenti
    tendinaMarca.innerHTML = '';
    tendinaModello.innerHTML = '';
    tendinaAllestimento.innerHTML = '';
    tendinaMisura.innerHTML = '';
    tendinaMarca.appendChild(creaOption());
    tendinaModello.appendChild(creaOption());
    tendinaAllestimento.appendChild(creaOption());
    tendinaMisura.appendChild(creaOption());
    // Scorro il vettore ritornato dalla fetch
    for (marca of json.data.values) {
        // Creo e appendo i vari elementi option riguardanti gli anni
        const option = document.createElement("option");
        option.value = marca;
        option.textContent = marca;
        tendinaMarca.appendChild(option);
    }
    const disabilitati = document.querySelectorAll(".disabilitato");
    for (dis of disabilitati) {
        dis.disabled = true;
    }
    tendinaMarca.parentNode.classList.remove("hidden");
    tendinaModello.parentNode.classList.add("hidden");
    tendinaAllestimento.parentNode.classList.add("hidden");
    tendinaMisura.parentNode.classList.add("hidden");
}

// Funzione per aggiungere i modelli alla tendina
function onJsonModelli(json) {
    // Cancello le eventuali opzioni gia presenti
    tendinaModello.innerHTML = '';
    tendinaAllestimento.innerHTML = '';
    tendinaMisura.innerHTML = '';
    tendinaModello.appendChild(creaOption());
    tendinaAllestimento.appendChild(creaOption());
    tendinaMisura.appendChild(creaOption());
    // Scorro il vettore ritornato dalla fetch
    for (modello of json.data.values) {
        // Creo e appendo i vari elementi option riguardanti i modelli
        const option = document.createElement("option");
        option.value = modello;
        option.textContent = modello;
        tendinaModello.appendChild(option);
    }
    const disabilitati = document.querySelectorAll(".disabilitato");
    for (dis of disabilitati) {
        dis.disabled = true;
    }
    tendinaModello.parentNode.classList.remove("hidden");
    tendinaAllestimento.parentNode.classList.add("hidden");
    tendinaMisura.parentNode.classList.add("hidden");
}

// Funzione per aggiungere gli allestimenti alla tendina
function onJsonAllestimenti(json) {
    // Cancello le eventuali opzioni gia presenti
    tendinaAllestimento.innerHTML = '';
    tendinaMisura.innerHTML = '';
    tendinaAllestimento.appendChild(creaOption());
    tendinaMisura.appendChild(creaOption());
    // Scorro il vettore ritornato dalla fetch
    for (allestimento of json.data.values) {
        // Creo e appendo i vari elementi option riguardanti gli allestimenti
        const option = document.createElement("option");
        option.value = allestimento;
        option.textContent = allestimento;
        tendinaAllestimento.appendChild(option);
    }
    const disabilitati = document.querySelectorAll(".disabilitato");
    for (dis of disabilitati) {
        dis.disabled = true;
    }
    tendinaAllestimento.parentNode.classList.remove("hidden");
    tendinaMisura.parentNode.classList.add("hidden");
}

// Funzione per aggiungere le misure alla tendina
function onJsonMisure(json) {
    // Cancello le eventuali opzioni gia presenti
    tendinaMisura.innerHTML = '';
    tendinaMisura.appendChild(creaOption());
    // Scorro il vettore ritornato dalla fetch
    for (misura of json.data.values) {
        // Creo e appendo i vari elementi option riguardanti le misure
        const option = document.createElement("option");
        option.value = misura.size_description;
        option.textContent = misura.size_description;
        tendinaMisura.appendChild(option);
    }
    const disabilitati = document.querySelectorAll(".disabilitato");
    for (dis of disabilitati) {
        dis.disabled = true;
    }
    tendinaMisura.parentNode.classList.remove("hidden");
}