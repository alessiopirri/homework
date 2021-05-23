<?php
    require_once "dbconf.php";

    header('Content-Type: application/json');

    if(isset($_GET["type"])){
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $codice = mysqli_real_escape_string($conn, $_GET["code"]);
        $type = mysqli_real_escape_string($conn, $_GET["type"]);
        if ($type == "p"){
            $query = ("SELECT * FROM pneumatico p JOIN prodotto pr ON P.Codice = Pr.ID WHERE Codice = '$codice'");
            $res = mysqli_query($conn, $query);
            echo json_encode(mysqli_fetch_object($res));
        }
        if ($type == "c"){
            $query = ("SELECT * FROM cerchio c JOIN prodotto p ON c.Codice = p.ID WHERE Codice = '$codice'");
            $res = mysqli_query($conn, $query);
            echo json_encode(mysqli_fetch_object($res));
            
        }
    }

?>