<?php
    require_once "dbconf.php";
    session_start();

    header('Content-Type: application/json');    

    if(isset($_SESSION["codice"])){
        $codicecliente = $_SESSION["codice"];
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $query ="   SELECT data, quantita, citta, marca, modello, prezzo 
                    FROM operazione o JOIN sede s ON o.CodiceSede = s.Codice
                    JOIN (   (SELECT marca, modello, codice FROM pneumatico)
                                UNION
                            (SELECT marca, modello, codice FROM cerchio)
                        ) pro ON o.codiceprodotto = pro.codice
                    JOIN prodotto p ON p.ID = o.CodiceProdotto
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
    else{
        echo json_encode(false);
    } 


?>
