function onResponse(response) {
    return response.json();
}

const keyweather = "b2e8936fa50abcade76d72cff3423f3c";

fetch("https://api.ipify.org?format=json").then(onResponse).then(onJsonIP);

function onJsonIP(json) {
    fetch("http://api.ipstack.com/" + json.ip + "?access_key=609a3061e8a101bc83582d5798c203a2").then(onResponse).then(onJsonLuogo);
}

function onJsonLuogo(json) {
    fetch("http://api.weatherstack.com/current?access_key=" + keyweather + "&query=Catania").then(onResponse).then(onJsonCitta);
    fetch("http://api.weatherstack.com/current?access_key=" + keyweather + "&query=Messina").then(onResponse).then(onJsonCitta);
    fetch("http://api.weatherstack.com/current?access_key=" + keyweather + "&query=Palermo").then(onResponse).then(onJsonCitta);
    fetch("http://api.weatherstack.com/current?access_key=" + keyweather + "&query=" + json.latitude + " " + json.longitude).then(onResponse).then(onJson);
}

function onJsonCitta(json) {
    const citta = json.location.name.toLowerCase();
    const divcitta = document.querySelector("#meteo" + citta + " .temperatura");
    const temp = document.createElement("p");
    const icona = document.createElement("img");
    icona.src = json.current.weather_icons[0];
    temp.textContent = json.current.temperature + "° C";
    divcitta.appendChild(temp);
    divcitta.appendChild(icona);
}

function onJson(json) {
    console.log(json);
    const citta = document.querySelector("#nomeposizione");
    citta.textContent = json.location.name;
    const divcitta = document.querySelector("#meteoposizione .temperatura");
    const temp = document.createElement("p");
    temp.textContent = json.current.temperature + "° C";
    const icona = document.createElement("img");
    icona.src = json.current.weather_icons[0];
    divcitta.appendChild(temp);
    divcitta.appendChild(icona);
    const meteo = document.querySelector(".meteo");
    meteo.classList.remove("hidden");
}