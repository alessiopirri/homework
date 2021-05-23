<?php

    header('Content-Type: application/json');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://pfa.foreca.com/authorize/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"user\": \"alessio-pirri99\", \"password\": \"ATz0ObWsZSnw\"}");
    

    echo curl_exec($ch)

   
?>