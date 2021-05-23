<?php
    require_once 'dbconf.php';
    session_start();
    header('Content-Type: application/json');

    if(!isset($_SESSION["codice"]) || (!isset($_GET["p"]))){
        exit;
    } else{
        $codcliente=$_SESSION["codice"];
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $codprodotto = mysqli_real_escape_string($conn, $_GET["p"]);

        $query ="DELETE FROM carrello
                WHERE CodiceCliente = $codcliente AND CodiceProdotto = $codprodotto";

        $res = mysqli_query($conn, $query); 
        echo json_encode($res);   
        mysqli_close($conn);   
    }
?>