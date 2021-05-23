<?php
    require_once "dbconf.php";

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

    if(isset($_GET["code"])){
        $code = mysqli_real_escape_string($conn, $_GET["code"]);
        $query= "SELECT QuantitaEcommerce FROM prodotto WHERE ID = $code";

        $res = mysqli_query($conn, $query);

        echo json_encode(mysqli_fetch_assoc($res));
        mysqli_free_result($res);
        mysqli_close($conn);
    }
    

?>