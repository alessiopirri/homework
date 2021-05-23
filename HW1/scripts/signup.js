const form = document.forms["signup"];
form.nome.addEventListener("blur", checkName);
form.cognome.addEventListener("blur", checkSurname);
form.email.addEventListener("blur", checkEmail);
form.password.addEventListener("blur", checkPassword);
form.password.addEventListener("blur", checkRepeatPassword);
form.ripetipassword.addEventListener("blur", checkRepeatPassword);
form.cf.addEventListener("blur", checkCF);
form.submit.addEventListener("click", checkErrors);

let errorn = 0;

function checkName(event) {
    const nome = form.nome;
    if (nome.value.length == 0) {
        document.querySelector("#nome").classList.remove("hidden");
        document.querySelector("#nome").classList.add("errore");
    } else {
        document.querySelector("#nome").classList.add("hidden");
        document.querySelector("#nome").classList.remove("errore");
        if (nome.value.length > 32) {
            document.querySelector("#nomelungo").classList.remove("hidden");
            document.querySelector("#nomelungo").classList.add("errore");
        } else {
            document.querySelector("#nomelungo").classList.add("hidden");
            document.querySelector("#nomelungo").classList.remove("errore");
        }
    }
}

function checkSurname(event) {
    const cognome = form.cognome;
    if (cognome.value.length == 0) {
        document.querySelector("#cognome").classList.remove("hidden");
        document.querySelector("#cognome").classList.add("errore");
    } else {
        document.querySelector("#cognome").classList.add("hidden");
        document.querySelector("#cognome").classList.remove("errore");
    }
}

function checkEmail(event) {
    const email = form.email;
    if (email.value.length == 0) {
        document.querySelector("#email").classList.remove("hidden");
        document.querySelector("#email").classList.add("errore");
    } else {
        document.querySelector("#email").classList.add("hidden");
        document.querySelector("#email").classList.remove("errore");
        if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(email.value).toLowerCase())) {
            document.querySelector("#emailvalid").classList.remove("hidden");
            document.querySelector("#emailvalid").classList.add("errore");
        } else {
            document.querySelector("#emailvalid").classList.add("hidden");
            document.querySelector("#emailvalid").classList.remove("errore");
            fetch("checkEmail.php?q=" + email.value).then(onResponse).then(onJsonEmail);
        }
    }
}

function checkPassword(event) {
    const password = form.password;
    if (password.value.length == 0) {
        document.querySelector("#password").classList.remove("hidden");
        document.querySelector("#password").classList.add("errore");
        document.querySelector("#passwordnotvalid").classList.add("hidden");
        document.querySelector("#passwordnotvalid").classList.remove("errore");
    } else {
        document.querySelector("#password").classList.add("hidden");
        document.querySelector("#password").classList.remove("errore");
        if (!/^(?=.*[0-9])(?=.*[!?@#$%^&*])(?=.*[A-Z])[a-zA-Z0-9!?@#$%^&*]{8,15}$/.test(String(password.value))) {
            document.querySelector("#passwordnotvalid").classList.remove("hidden");
            document.querySelector("#passwordnotvalid").classList.add("errore");
        } else {
            document.querySelector("#passwordnotvalid").classList.add("hidden");
            document.querySelector("#passwordnotvalid").classList.remove("errore");
        }
    }
}

function checkRepeatPassword(event) {
    const repeatpassword = form.ripetipassword;
    const password = form.password;
    if (repeatpassword.value.length == 0 && event.currentTarget == password) {
        return;
    } else if (repeatpassword.value.length == 0 && event.currentTarget == repeatpassword) {
        document.querySelector("#repeatpassword").classList.remove("hidden");
        document.querySelector("#repeatpassword").classList.add("errore");
    } else {
        document.querySelector("#repeatpassword").classList.add("hidden");
        document.querySelector("#repeatpassword").classList.remove("errore");
        if (repeatpassword.value != password.value) {
            document.querySelector("#passwordmatch").classList.remove("hidden");
            document.querySelector("#passwordmatch").classList.add("errore");
        } else {
            document.querySelector("#passwordmatch").classList.add("hidden");
            document.querySelector("#passwordmatch").classList.remove("errore");
        }
    }
}

function checkCF(event) {
    const cf = event.currentTarget;
    if (cf.value.length == 0) {
        document.querySelector("#cf").classList.remove("hidden");
        document.querySelector("#cf").classList.add("errore");
        document.querySelector("#cferrato").classList.add("hidden");
        document.querySelector("#cferrato").classList.remove("errore");
    } else {
        document.querySelector("#cf").classList.add("hidden");
        document.querySelector("#cf").classList.remove("errore");
        if (cf.value.length != 16) {
            document.querySelector("#cferrato").classList.remove("hidden");
            document.querySelector("#cferrato").classList.add("errore");
        } else {
            document.querySelector("#cferrato").classList.add("hidden");
            document.querySelector("#cferrato").classList.remove("errore");
        }
    }
}

function checkErrors(event) {
    if (document.querySelectorAll(".errore").length == 0 && form.nome.value.length != 0 && form.cognome.value.length != 0 && form.email.value.length != 0 && form.password.value.length != 0 && form.ripetipassword.value.length != 0 && form.cf.value.length != 0) {
        document.querySelectorAll("#error").classList.add("hidden");
    } else {
        event.preventDefault();
        document.querySelector("#error").classList.remove("hidden");

    }
}

function onResponse(response) {
    return response.json();
}

function onJsonEmail(json) {
    if (json.exists == true) {
        document.querySelector("#emailinuse").classList.remove("hidden");
        document.querySelector("#emailinuse").classList.add("errore");
    } else {
        document.querySelector("#emailinuse").classList.add("hidden");
        document.querySelector("#emailinuse").classList.remove("errore");
    }
}