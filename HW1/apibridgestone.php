<?php
    $key= "57ebcc8429af3f4edb921d0043069d7a";
    
    header('Content-Type: application/json');

    if(isset($_GET["year"])){
        if(isset($_GET["make"])){
            if(isset($_GET["model"])){
                if(isset($_GET["trim"])){
                    //misura
                    $url = "https://wl.tireconnect.ca/api/v2/vehicle/tireSizes?key=".$key ."&year=" .urlencode($_GET["year"]) ."&make=" .urlencode($_GET["make"]) ."&model=" .urlencode($_GET["model"]) ."&trim=" .urlencode($_GET["trim"]);
                } else {
                    //allestimenti
                    $url = "https://wl.tireconnect.ca/api/v2/vehicle/trims?key=".$key ."&year=" .urlencode($_GET["year"]) ."&make=" .urlencode($_GET["make"]) ."&model=" .urlencode($_GET["model"]);
                }
            } else {
                //modelli
                $url = "https://wl.tireconnect.ca/api/v2/vehicle/models?key=".$key ."&year=" .urlencode($_GET["year"]) ."&make=" .urlencode($_GET["make"]);
            }
        } else {
            //marche
            $url = "https://wl.tireconnect.ca/api/v2/vehicle/makes?key=".$key ."&year=" .urlencode($_GET["year"]);
        }
    }else{
        //anni
        $url = "https://wl.tireconnect.ca/api/v2/vehicle/years?key=".$key;
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    echo $data;

?>
