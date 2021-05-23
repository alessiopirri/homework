<?php
    require_once "dbconf.php";

    if(!isset($_GET["q"])){
        echo "Non hai accesso a questa pagina!";
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

    $email = mysqli_real_escape_string($conn, $_GET["q"]);

    $res = mysqli_query($conn, "SELECT email FROM cliente WHERE email = '$email'");

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    mysqli_free_result($res);
    mysqli_close($conn);
?>