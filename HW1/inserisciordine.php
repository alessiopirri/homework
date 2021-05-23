<?php
    require_once "dbconf.php";
    session_start();

    header('Content-Type: application/json');    

    if(isset($_SESSION["codice"])){
        $codicecliente = $_SESSION["codice"];
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $query ="CALL inserisciOrdine ('$codicecliente')";   
        $res = mysqli_query($conn, $query);
        
        echo json_encode($res ? false : mysqli_error($conn));
       // mysqli_free_result($res);
        mysqli_close($conn);        
    }
    else{
        echo json_encode("Utente non autenticato");
    } 


?>
