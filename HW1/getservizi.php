<?php
    require_once "dbconf.php";

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
    if(isset($_GET["limit"])){
        $query =   "SELECT Descrizione 
                    FROM servizio
                    ORDER BY Codice
                    LIMIT ".$_GET["limit"];
    }
    else 
        $query =   "SELECT Descrizione 
                    FROM servizio
                    ORDER BY Codice";   
    $res = mysqli_query($conn, $query);
    $risp = array();
    while($row = mysqli_fetch_assoc($res) ){
        $risp[] = $row;
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    echo json_encode($risp);    
?>