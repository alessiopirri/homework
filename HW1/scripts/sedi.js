fetch("getsedi.php").then(onResponse).then(onJsonSedi);

function onResponse(response) {
    return response.json();
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
    console.log(json);
    const container = document.querySelector("#sedi .container");

    for (sede of json) {
        const item = document.createElement("div");
        item.classList.add("item");
        const divimmagine = document.createElement("div");
        divimmagine.classList.add("immagine");
        const img = document.createElement("img");
        img.src = "img/" + sede.Citta.toLowerCase() + ".jpg";
        const h1 = document.createElement("h1");
        h1.textContent = sede.Citta;
        const p = document.createElement("p");
        p.textContent = sede.indirizzo
        divimmagine.appendChild(img);
        divimmagine.appendChild(h1);
        item.appendChild(divimmagine);
        item.appendChild(p);
        container.appendChild(item);
    }
}