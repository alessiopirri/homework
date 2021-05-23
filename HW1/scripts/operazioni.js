const op1 = document.querySelector("#operazione1 button");
const op2 = document.querySelector("#operazione2 button");
const op3 = document.querySelector("#operazione3 button");
const op4 = document.querySelector("#operazione4 button");


op1.addEventListener("click", operzione1);
op2.addEventListener("click", operzione2);
op3.addEventListener("click", operzione3);
op4.addEventListener("click", operzione4);


function onResponse(response) {
    return response.json();
}

function operzione1(event) {
    const parametro = document.querySelector("#operazione1 input[name=\"num\"]");
    if (parametro.value) {
        fetch("operazioni.php?operazione=1&num=" + parametro.value).then(onResponse).then(onJsonOp);
    }
}

function operzione2(event) {
    const parametro = document.querySelector("#operazione2 input[name=\"str\"]");
    if (parametro.value) {
        fetch("operazioni.php?operazione=2&str=" + parametro.value).then(onResponse).then(onJsonOp);
    }
}

function operzione3(event) {
    const nome = document.querySelector("#operazione3 input[name=\"nome\"]");
    const cognome = document.querySelector("#operazione3 input[name=\"cognome\"]");
    const cf = document.querySelector("#operazione3 input[name=\"cf\"]");
    const datanascita = document.querySelector("#operazione3 input[name=\"datanascita\"]");
    if (nome.value && cognome.value && cf.value && datanascita.value) {
        fetch("operazioni.php?operazione=3&cf=" + cf.value + "&nome=" + nome.value + "&cognome=" + cognome.value + "&datanascita=" + datanascita.value).then(onResponse).then(onJsonOp);
    }
}

function operzione4(event) {
    fetch("operazioni.php?operazione=4").then(onResponse).then(onJsonOp);

}



function onJsonOp(json) {
    console.log(json);
    const risposta = document.querySelector("#arearisultato");
    risposta.value = JSON.stringify(json);
}