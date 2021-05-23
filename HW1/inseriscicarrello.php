<?php
    require_once 'dbconf.php';
    session_start();
    header('Content-Type: application/json');

    if(!isset($_SESSION["codice"]) || (!isset($_GET["p"])) || (!isset($_GET["q"]))){
        exit;
    } else{
        $codcliente=$_SESSION["codice"];
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $codprodotto = mysqli_real_escape_string($conn, $_GET["p"]);
        $quantita = mysqli_real_escape_string($conn, $_GET["q"]);

        $query ="INSERT INTO carrello (CodiceCliente, CodiceProdotto, Quantita)
                VALUES ('$codcliente', '$codprodotto', '$quantita')
                ON DUPLICATE KEY 
                UPDATE Quantita = VALUES(Quantita)";

        $res = mysqli_query($conn, $query); 
        echo json_encode($res);   
        
    }
    //mysqli_free_result($res);
    mysqli_close($conn);   
?>