<?php
    require_once "dbconf.php";
    session_start();

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
    if(isset($_GET["code"])){
        if(isset($_SESSION["codice"])){
            $codicecliente = $_SESSION["codice"];
            $codiceprodotto = mysqli_real_escape_string($conn, $_GET["code"]);
            $query="SELECT Quantita as quantita FROM carrello                   
                    WHERE CodiceCliente = '$codicecliente'
                    AND CodiceProdotto = '$codiceprodotto'";
            $res = mysqli_query($conn, $query);
            
            $risp = mysqli_fetch_object($res);
            echo json_encode($risp ? $risp : ["quantita" => "0"]);
            mysqli_close($conn);
        }
        else{
            echo json_encode(["quantita" => "0"]);
        } 
    } 


?>
