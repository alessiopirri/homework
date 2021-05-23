<?php
    require_once "dbconf.php";
    session_start();

    header('Content-Type: application/json');    

    if(isset($_SESSION["codice"])){
        $codicecliente = $_SESSION["codice"];
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $query ="   SELECT cf, nome, cognome, email, totalespeso 
                    FROM cliente
                    WHERE codice = $codicecliente";   
        $res = mysqli_query($conn, $query);
    
        echo json_encode(mysqli_fetch_assoc($res));
        mysqli_free_result($res);
        
    }
    else{
        echo json_encode(false);
    } 


?>
