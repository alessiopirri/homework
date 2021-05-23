const hamburger = document.querySelector("#hamburger");
const imgchiudi = document.querySelector("#chiudimenu");

hamburger.addEventListener("click", aprimenu);
imgchiudi.addEventListener("click", chiudimenu);

function aprimenu() {
    const hamburgermenu = document.querySelector("#hamburgermenu");
    hamburgermenu.classList.remove("hidden");
    document.body.classList.add("no-scroll");
}

function chiudimenu() {
    const hamburgermenu = document.querySelector("#hamburgermenu");
    hamburgermenu.classList.add("hidden");
    document.body.classList.remove("no-scroll");
}