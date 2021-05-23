fetch("getdaticliente.php").then(onResponse).then(onJsonDati);

function onResponse(response) {
    return response.json();
}

function onJsonDati(json) {
    //console.log(json);
    if (json) {
        const article = document.querySelector("article");
        const datipersonali = document.createElement("section");
        datipersonali.id = "dati";

        const titolo = document.createElement("strong");

        titolo.textContent = "I tuoi dati personali";

        const nome = document.createElement("p");
        const cognome = document.createElement("p");
        const codicefiscale = document.createElement("p");
        const email = document.createElement("p");
        const totalespeso = document.createElement("p");

        nome.textContent = "Nome: " + json.nome;
        cognome.textContent = "Cognome: " + json.cognome;
        codicefiscale.textContent = "Codice fiscle: " + json.cf;
        email.textContent = "E-mail: " + json.email;
        totalespeso.textContent = "Totale speso: " + json.totalespeso;

        datipersonali.appendChild(titolo);
        datipersonali.appendChild(nome);
        datipersonali.appendChild(cognome);
        datipersonali.appendChild(codicefiscale);
        datipersonali.appendChild(email);
        datipersonali.appendChild(totalespeso);

        article.appendChild(datipersonali);
        fetch("getordini.php").then(onResponse).then(onJsonOrdini);
    }
}

function onJsonOrdini(json) {
    const article = document.querySelector("article");
    const ordini = document.createElement("section");
    ordini.id = "ordini";

    const divtabella = document.createElement("div");

    const titolo = document.createElement("strong");

    titolo.textContent = "I tuoi ordini";

    const tabella = document.createElement("table");

    const intestazionetabella = document.createElement("thead");
    const rigaintestazione = document.createElement("tr");
    const colSede = document.createElement("th");
    const colQuantita = document.createElement("th");
    const colData = document.createElement("th");
    const colImporto = document.createElement("th");
    const colProdotto = document.createElement("th");

    const tbody = document.createElement("tbody");

    colSede.textContent = "Sede";
    colData.textContent = "Data";
    colImporto.textContent = "Importo";
    colProdotto.textContent = "Prodotto";
    colQuantita.textContent = "Quantita";

    intestazionetabella.appendChild(rigaintestazione);

    rigaintestazione.appendChild(colProdotto);
    rigaintestazione.appendChild(colQuantita);
    rigaintestazione.appendChild(colData);
    rigaintestazione.appendChild(colSede);
    rigaintestazione.appendChild(colImporto);


    tabella.appendChild(intestazionetabella);
    tabella.appendChild(tbody);

    divtabella.appendChild(tabella);

    ordini.appendChild(titolo);
    ordini.appendChild(divtabella);
    article.appendChild(ordini);



    tabella.appendChild

    for (ordine of json) {

        const rigatabella = document.createElement("tr")

        const sede = document.createElement("td");
        const data = document.createElement("td");
        const importo = document.createElement("td");
        const prodotto = document.createElement("td");
        const quantita = document.createElement("td");

        sede.textContent = ordine.citta == "e-commerce" ? "on-line" : ordine.citta;
        data.textContent = ordine.data;
        importo.textContent = ordine.prezzo * ordine.quantita;
        prodotto.textContent = ordine.marca + " " + ordine.modello;
        quantita.textContent = ordine.quantita;

        rigatabella.appendChild(prodotto);
        rigatabella.appendChild(quantita);
        rigatabella.appendChild(data);
        rigatabella.appendChild(sede);
        rigatabella.appendChild(importo);


        tbody.appendChild(rigatabella);
    }
}