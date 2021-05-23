<?php
    require_once "dbconf.php";
    session_start();

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

    if(isset($_SESSION["codice"])){
        $codicecliente = $_SESSION["codice"];
          
        $query = "SELECT id, img, pro.marca, pro.modello, prezzo, quantita, IF (pn.Codice IS NULL, 'c', 'p') as type 
                FROM prodotto p JOIN 
                        (   (SELECT marca, modello, codice FROM pneumatico)
                            UNION
                            (SELECT marca, modello, codice FROM cerchio)
                        ) pro ON p.id = pro.codice
                        JOIN carrello ca ON p.id = ca.CodiceProdotto
                        LEFT JOIN pneumatico pn on p.ID = pn.Codice
                        WHERE codiceCliente = $codicecliente";   
        $res = mysqli_query($conn, $query);
        $risp = array();
        while($row = mysqli_fetch_assoc($res) ){
            $risp[] = $row;
        }
        echo json_encode($risp);
        mysqli_free_result($res);
        mysqli_close($conn);
    }


?>
