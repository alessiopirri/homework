
<!DOCTYPE html>
<html>

<head>
    <title>Pirripneus | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/common.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <script src="scripts/mobile.js" defer></script>
    <script src="scripts/meteo.js"></script>    
    <script src="scripts/ultimiarrivi.js"></script>
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
                    session_start();
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
                        echo ("<a href=\"login.php\" class=\"button\"> Accedi</a>");
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
                        echo ("<a href=\"login.php\" class=\"hamburgeritem\"> Accedi</a>");
                    }
                ?>
            <div>
        </nav>
        <h1>
            Benvenuto
        </h1>
        <div class="meteo hidden">
            <div class="cittameteo" id="meteocatania">
                <div>
                    Catania
                </div>
                <div class="temperatura">

                </div>
            </div>
            <div class="cittameteo" id="meteomessina">
                <div>
                    Messina
                </div>
                <div class="temperatura">

                </div>
            </div>
            <div class="cittameteo" id="meteopalermo">
                <div>
                    Palermo
                </div>
                <div class="temperatura">

                </div>
            </div>
            <div class="cittameteo" id="meteoposizione">
                <div id="nomeposizione">

                </div>
                <div class="temperatura">

                </div>
            </div>
        </div>
    </header>
    <article id="corpo">
        <h1>Pirripneus, leader nazionale nel settore degli pneumatici</h1>
        <p>Con migliaia di clienti che ogni giorno acquistano da Pirripneus siamo divendati leader del mercato disponendo di migliaia di pneumatici e offrendo diversi servizi
        </p>
        <section id="sedi">
            <strong>Le nostre sedi</strong>
            <div class="container">
                <!-- <div class="item">
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
                </div> -->
            </div>
            <a href="sedi.php" class="button">Visualizza tutte le sedi</a>
        </section>
        <section id="servizi">
            <strong>I nostri Servizi</strong>
            <div class="container">
                <!-- <div class="item">
                    <img src="img/equilibratura.jpg">
                    <h1>Equilibratura</h1>
                </div>
                <div class="item">
                    <img src="img/convergenza.jpg">
                    <h1>Convergenza</h1>
                </div>
                <div class="item">
                    <img src="img/installazione.jpg">
                    <h1>Installazione pneumatico</h1>
                </div> -->
            </div>
            <a href="servizi.php" class="button">Visualizza tutti i nostri servizi</a>
        </section>
        <section id="cerchi">
            <strong>Ultimi cerchi arrivati</strong>
            <div class="container">
            <!--    <div class="item">
                    <img src="img/revenge.png">
                    <h1>Momo Revenge</h1>
                    <div class="dettagli">
                        <div>15"</div>
                        <div>16"</div>
                        <div>17"</div>
                    </div>
                </div>
                <div class="item">
                    <img src="img/procorsa.jpg">
                    <h1>Sparco Pro Corsa</h1>
                    <div class="dettagli">
                        <div>17"</div>
                    </div>
                </div>
                <div class="item">
                    <img src="img/avenger.png">
                    <h1>Momo Avenger</h1>
                    <div class="dettagli">
                        <div>15"</div>
                        <div>16"</div>
                        <div>17"</div>
                        <div>18</div>
                        <div>19"</div>
                    </div>
                </div> -->
            </div>
            <a href="cerchi.php" class="button">Visualizza tutti i nostri cerchi</a>
        </section>
        <section id="pneumatici">
            <strong>Ultimi pneumatici arrivati</strong>
            <div class="container">
                <!-- <div class="item">
                    <img src="img/turanza.png">
                    <h1>Bridgestone Turanza</h1>
                    <div class="dettagli">
                        <div>R16</div>
                        <div>R17</div>
                    </div>
                </div>
                <div class="item">
                    <img src="img/energysaver+.png">
                    <h1>Michelin Energy Saver+</h1>
                    <div class="dettagli">
                        <div>R14</div>
                        <div>R16</div>
                    </div>
                </div>
                <div class="item">
                    <img src="img/pzero.jpg">
                    <h1>Pirelli PZERO</h1>
                    <div class="dettagli">
                        <div>R17</div>
                        <div>R18</div>
                        <div>R19</div>
                        <div>R21</div>
                    </div>
                </div> -->
            </div>
            <a href="pneumatici.php" class="button">Visualizza tutti i nostri pneumatici</a>
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