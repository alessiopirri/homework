function onResponse(response) {
    return response.json();
}


let token;

fetch("https://api.ipify.org?format=json").then(onResponse).then(onJsonIP);

function onJsonIP(json) {
    fetch("ipinfo.php?ip=" + json.ip).then(onResponse).then(onJsonLuogo);
}

function onJsonLuogo(jsonluogo) {
    fetch("meteo.php").then(onResponse).then((json) => onJsonToken(json, jsonluogo.longitude, jsonluogo.latitude));
}

function onJsonToken(tokenjson, lon, lat) {
    token = tokenjson.access_token;
    fetch("https://pfa.foreca.com/api/v1/location/search/catania?token=" + token).then(onResponse).then(onJsonLocalita);
    fetch("https://pfa.foreca.com/api/v1/location/search/messina?token=" + token).then(onResponse).then(onJsonLocalita);
    fetch("https://pfa.foreca.com/api/v1/location/search/palermo?token=" + token).then(onResponse).then(onJsonLocalita);
    fetch("https://pfa.foreca.com/api/v1/location/" + lon + "," + lat + "&token=" + token).then(onResponse).then(onJsonInfo);
}

function onJsonInfo(jsoninfo) {
    fetch("https://pfa.foreca.com/api/v1/current/" + jsoninfo.id + "&token=" + token).then(onResponse).then((json) => onJson(json, jsoninfo.name));
}

function onJsonLocalita(jsonlocalita) {
    fetch("https://pfa.foreca.com/api/v1/current/" + jsonlocalita.locations[0].id + "&token=" + token).then(onResponse).then((json) => onJsonCitta(json, jsonlocalita.locations[0].name));
}

function onJsonCitta(json, citta) {
    const divcitta = document.querySelector("#meteo" + citta.toLowerCase() + " .temperatura");
    const temp = document.createElement("p");
    const icona = document.createElement("img");
    icona.src = "https://developer.foreca.com/static/images/symbols/" + json.current.symbol + ".png";
    temp.textContent = json.current.temperature + "° C";
    divcitta.appendChild(temp);
    divcitta.appendChild(icona);
}

function onJson(json, cittain) {
    const citta = document.querySelector("#nomeposizione");
    citta.textContent = cittain;
    const divcitta = document.querySelector("#meteoposizione .temperatura");
    const temp = document.createElement("p");
    temp.textContent = json.current.temperature + "° C";
    const icona = document.createElement("img");
    icona.src = "https://developer.foreca.com/static/images/symbols/" + json.current.symbol + ".png";
    divcitta.appendChild(temp);
    divcitta.appendChild(icona);
    const meteo = document.querySelector(".meteo");
    meteo.classList.remove("hidden");
}