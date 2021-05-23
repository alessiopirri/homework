<?php
    session_start();
    if(!isset($_SESSION["codicefiscale"])){
        header("Location: loginriservata.php");
        exit;
    }
?>


<html>
    <head>
        <title>Pirripneus | Area riservata </title>
        <link rel="stylesheet" href="style/areariservata.css">
        <script src="scripts/operazioni.js" defer></script>
    </head>
    <body>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>

        <section id="operazionisection" >
            <div id="operazione1" class="operazioni">
                <p><strong>Visualizzare il numero di cerchi con diametro maggiore di 16’’ per ogni marca. visualizzare tale numero solo se superiore a "num" </strong></p>
                <label>Num: <input type="text" name="num"></label>
                <button type="button"> Esegui operazione 1 </button>
            </div>
            <div id="operazione2" class="operazioni">
                <p><strong>Visualizzare le sedi nelle città che cominciano con "una data stringa" in cui lavorano o hanno lavorato delle persone per cui esiste almeno un altro dipendente nato nello stesso giorno dell’anno all’interno della stessa sede</strong></p>
                <label>Stringa: <input type="text" name="str"></label>
                <button type="button"> Esegui operazione 2 </button>
            </div>
            <div id="operazione3" class="operazioni"> 
                <p><strong>Inserire un nuovo impiegato ed assegnarlo alla sede di catania (via etnea, 254) se l’anno di nascita è multiplo di 2, a quella di palermo (viale della regione siciliana, 48) se multiplo di 3, a quella di messina (via acireale, 15) se multiplo di entrambi e a quella di agrigento (corso sicilia, 102) se non è multiplo di nessuno dei due</strong></p>
                <label>Codice fiscale: <input type="text" name="cf"></label>
                <label>Nome: <input type="text" name="nome"></label>
                <label>Cognome: <input type="text" name="cognome"></label>
                <label>Data nascita: <input type="date" name="datanascita"></label>
                <button type="button"> Esegui operazione 3 </button>

            </div>
            <div id="operazione4" class="operazioni">
                <p><strong>Leggere tutti i dati di clienti che nel 2020 hanno acquistato sia uno pneumatico che un cerchio</strong></p>
                <button type="button"> Esegui operazione 4 </button>

            </div>
        </section>
        <section id="result">
            <input type="textarea" id="arearisultato" disabled></input>
        </section>

    </body>
    
</html>