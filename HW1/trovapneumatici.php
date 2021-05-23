<?php
    require_once "dbconf.php";

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
    if(!isset($_GET["l"])){
        $query =   "SELECT Marca as marca, Modello as modello, Misura as descrizione, Prezzo as prezzo, img as immagine, codice as codice 
                    FROM pneumatico p 
                    JOIN prodotto pr on p.codice=pr.id
                    ORDER BY marca, modello";
    } else{
        $l = mysqli_real_escape_string($conn, $_GET["l"]);
        $a = mysqli_real_escape_string($conn, $_GET["a"]);
        $d = mysqli_real_escape_string($conn, $_GET["d"]);
        $c = mysqli_real_escape_string($conn, $_GET["c"]);
        $v = mysqli_real_escape_string($conn, $_GET["v"]);
        $query =   "SELECT marca, modello, Misura as descrizione, prezzo, img as immagine, codice 
                    FROM pneumatico p 
                    JOIN prodotto pr ON p.codice=pr.id
                    JOIN indicivelocita i ON i.IndiceVelocita = p.velocita
                    WHERE larghezza = '$l' 
                    AND altezza = '$a' 
                    AND diametro = '$d' 
                    AND (indicecarico >='$c' OR indicecarico = 0) 
                    AND (velocitanumerica >= (
                                                SELECT velocitanumerica
                                                FROM indicivelocita
                                                WHERE indicevelocita = '$v')
                        OR velocita= \"\"
                        )
                    ORDER BY marca, modello";
    }
    
    $res = mysqli_query($conn, $query);
    $risp = array();
    while($row = mysqli_fetch_object($res) ){
        $risp[] = $row;
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    echo json_encode($risp);
    
?>


