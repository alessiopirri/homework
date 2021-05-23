<?php
    $key= "609a3061e8a101bc83582d5798c203a2";
    
    header('Content-Type: application/json');

    if(isset($_GET["ip"])){
        $url = "http://api.ipstack.com/" .$_GET["ip"] ."?access_key=".$key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        echo $data; 
    } 
?>
