fetch("getsedi.php?limit=3").then(onResponse).then(onJsonSedi);
fetch("getservizi.php?limit=3").then(onResponse).then(onJsonServizi);
fetch("ultimiarrivi.php?tipo=cerchio").then(onResponse).then((json) => onJsonProdotto(json, "cerchi"));
fetch("ultimiarrivi.php?tipo=pneumatico").then(onResponse).then((json) => onJsonProdotto(json, "pneumatici"));

function onResponse(response) {
    return response.json();
}

function onJsonProdotto(json, tipo) {
    /*
    <div class="item">
                    <img src="img/pzero.jpg">
                    <h1>Pirelli PZERO</h1>
                    <div class="dettagli">
                        <div>R17</div>
                        <div>R18</div>
                        <div>R19</div>
                        <div>R21</div>
                    </div>
                </div>
    */
    //console.log(json);
    const container = document.querySelector("#" + tipo + " .container");
    for (prodotto of json) {
        //console.log(prodotto)

        const item = document.createElement("div");
        item.classList.add("item");
        const img = document.createElement("img");
        img.src = prodotto.img != "" ? prodotto.img : "img/immagine-non-disponibile.png";
        const titolo = document.createElement("h1");
        titolo.textContent = prodotto.marca + prodotto.modello;
        const dettagli = document.createElement("div");
        dettagli.classList.add("dettagli");

        for (diametro of prodotto.diametri) {
            //console.log(diametro);
            const div = document.createElement("div");
            div.textContent = "R" + diametro;
            dettagli.appendChild(div);
        }

        item.appendChild(img);
        item.appendChild(titolo);
        item.appendChild(dettagli);
        container.appendChild(item);
    }
}

function onJsonSedi(json) {
    /*
    <div class="container">
                <div class="item">
                    <img src="img/catania.jpg">
                    <h1>Catania</h1>
                </div>
                <div class="item">
                    <img src="img/palermo.jpg">
                    <h1>Palermo</h1>
                </div>
                <div class="item">
                    <img src="img/messina.jpg">
                    <h1>Messina</h1>
                </div>
            </div>
    */
    //console.log(json);
    const container = document.querySelector("#sedi .container");

    for (sede of json) {
        const item = document.createElement("div");
        item.classList.add("item");
        const img = document.createElement("img");
        img.src = "img/" + sede.Citta.toLowerCase() + ".jpg";
        const h1 = document.createElement("h1");
        h1.textContent = sede.Citta;
        item.appendChild(img);
        item.appendChild(h1);
        container.appendChild(item);
    }
}

function onJsonServizi(json) {
    const container = document.querySelector("#servizi .container");

    for (servizio of json) {
        const item = document.createElement("div");
        item.classList.add("item");
        const img = document.createElement("img");
        img.src = "img/" + servizio.Descrizione.toLowerCase() + ".jpg";
        const h1 = document.createElement("h1");
        h1.textContent = servizio.Descrizione;
        item.appendChild(img);
        item.appendChild(h1);
        container.appendChild(item);
    }
}