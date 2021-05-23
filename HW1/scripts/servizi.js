fetch("getservizi.php").then(onResponse).then(onJsonServizi);

function onResponse(response) {
    return response.json();
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