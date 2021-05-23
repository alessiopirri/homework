<?php
    require_once "dbconf.php";
    header('Content-Type: application/json');
    if(isset($_GET["tipo"])){
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $tipo = mysqli_real_escape_string($conn, $_GET["tipo"]);
        
        if($tipo == "pneumatico" || $tipo == "cerchio"){
            $query = "  SELECT marca, modello, img
                        FROM prodotto p JOIN $tipo t ON p.ID = t.Codice
                        GROUP BY marca, modello
                        ORDER BY codice DESC
                        LIMIT 3";
        } else{
            mysqli_close($conn);
            exit;
        }
        

        $res = mysqli_query($conn, $query);
        $risp = array();
        while($row = mysqli_fetch_object($res) ){
            $risp[] = $row;
        }
        //echo json_encode($risp);
        foreach ($risp as $prodotto){
            $query ="   SELECT diametro
                        FROM prodotto p JOIN $tipo t ON p.ID = t.Codice
                        WHERE Marca = '$prodotto->marca' 
                        AND Modello = '$prodotto->modello'";
            $res = mysqli_query($conn, $query);
            $diam = array();
            while($row = mysqli_fetch_row($res) ){
                $diam[] = $row;
            }
            $prodotto->diametri = $diam;            
        }
        mysqli_close($conn);
        mysqli_free_result($res);
        echo json_encode($risp);

    }