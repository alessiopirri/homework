<?php
    require_once "dbconf.php";

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

    $query = "SELECT Marca as marca, Modello as modello, Prezzo as prezzo, Descrizione as descrizione, Diametro as diametro, img as immagine, codice 
            FROM CERCHIO C JOIN PRODOTTO P ON P.ID=C.CODICE ";
    $res = mysqli_query($conn, $query);
    $risp = array();
    while($row = mysqli_fetch_object($res) ){
        $risp[] = $row;
    }
    echo json_encode($risp);
    mysqli_free_result($res);
    mysqli_close($conn);
?>