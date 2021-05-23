<?php
    require_once "auth.php";
    if(!checkAuth()){
        header("Location: login.php?ritorno=carrello.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pirripneus | Carrello</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/common.css">
    <link rel="stylesheet" href="style/carrello.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="scripts/carrello.js" defer></script>
    <script src="scripts/mobile.js" defer></script>
</head>

<body>
    <header>
        <nav>
            <a href="index.php" id="logo">Pirripneus</a>
            <div id="collegamenti">
                <a href="sedi.php">Sedi</a>
                <a href="servizi.php">Servizi</a>
                <span class="prodotti">
                    Prodotti
                    <div>
                        <a href="cerchi.php">Cerchi</a>
                        <a href="pneumatici.php">Pneumatici</a>
                    </div>
                </span>
                <?php
                    
                    if(isset($_SESSION["email"])){
                        $nome = $_SESSION["nome"];
                        echo ("<span class=\"prodotti button\" >
                                    $nome
                                    <div>
                                        <a href=\"profilo.php\" class=\"profilo\"> Profilo </a>
                                        <a href=\"carrello.php\" class=\"profilo\"> Carrello </a>
                                        <a href=\"logout.php\" class=\"profilo\"> Logout </a>
                                    </div>
                                </span>");
                    }
                    else{
                        echo ("<a href=\"login.php?ritorno=carrello.php\" class=\"button\"> Accedi</a>");
                    }
                ?>
            </div>
            <div id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div id="hamburgermenu" class = "hidden">
                <img src="img/rimuovi.svg" id="chiudimenu">
                <a href="sedi.php" class="hamburgeritem"> Sedi </a>
                <a href="servizi.php" class="hamburgeritem"> Servizi </a>
                <strong class="hamburgeritem"> Prodotti </strong>
                <a href="cerchi.php" class="hamburgeritem"> Cerchi </a>
                <a href="pneumatici.php" class="hamburgeritem"> Pneumatici </a>
                <?php
                    if(isset($_SESSION["email"])){
                        $nome = $_SESSION["nome"];
                        echo ("<strong class=\"hamburgeritem\">$nome </strong>
                            <a href=\"profilo.php\" class=\"hamburgeritem\"> Profilo </a>
                            <a href=\"carrello.php\" class=\"hamburgeritem\"> Carrello </a>
                            <a href=\"logout.php\" class=\"hamburgeritem\"> Logout </a> ");
                    }
                    else{
                        echo ("<a href=\"login.php?ritorno=carrello.php\" class=\"hamburgeritem\"> Accedi</a>");
                    }
                ?>
            <div>
        </nav>
        <h1>
            Carrello
        </h1>
    </header>

    <article>
        <section id="carrello">
    </section>
    </article>
    
    <footer>
        <div id="colonne">
            <div class="colonna">
                <strong>Ordini</strong>
                <a>Metodi di pagamento</a>
                <a>Spedizione</a>
                <a>Tracking</a>
            </div>
            <div class="colonna">
                <strong>Servizio clienti</strong>
                <a>Contatti</a>
                <a>Newsletter</a>
                <a>Guida sigle pneumatici</a>
            </div>
            <div class="colonna">
                <strong>Sede legale</strong>
                <span>Via Etnea, 254</span>
                <span>Catania</span>
                <strong> Area riservata </strong>
                <a href="areariservata.php">Accedi</a>
            </div>
        </div>
        <div id="nomematricola">Alessio Pirri O46002008</div>
    </footer>
</body>

</html> 