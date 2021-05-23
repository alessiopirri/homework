<?php
    require_once "dbconf.php";
    session_start();

    header('Content-Type: application/json');

    $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

    if(isset($_SESSION["codicefiscale"])){
        if (isset($_GET["operazione"])){
            $operazione = mysqli_real_escape_string($conn, $_GET["operazione"]);
            switch ($operazione){
                case 1:
                    if(isset($_GET["num"])){
                        $num = mysqli_real_escape_string($conn, $_GET["num"]);
                        if(is_numeric($num)){
                            $query = "CALL OP1($num)";
                            $res = mysqli_query($conn, $query);
                            $query= "SELECT * FROM TEMP"; 
                            $res = mysqli_query($conn, $query);
                            $risp = array();
                            while($row = mysqli_fetch_assoc($res) ){
                                $risp[] = $row;
                            }
                            echo json_encode($risp);
                            mysqli_free_result($res);
                            mysqli_close($conn);
                            exit;
                        } else {
                            echo json_encode("Il parametro inserito non è un numero");
                        }                        
                    } else{
                        echo json_encode("Non è stato impostato il parametro num");
                    }                    
                    break;
                case 2:
                    if(isset($_GET["str"])){
                        $str = mysqli_real_escape_string($conn, $_GET["str"]);
                        
                        $query = "CALL OP2('$str')";
                        $res = mysqli_query($conn, $query);
                        $query= "SELECT * FROM TEMP"; 
                        $res = mysqli_query($conn, $query);
                        $risp = array();
                        while($row = mysqli_fetch_assoc($res) ){
                            $risp[] = $row;
                        }
                        echo json_encode($risp);
                        mysqli_free_result($res);
                        mysqli_close($conn);
                        exit;                      
                    } else{
                        echo json_encode("Non è stato impostato il parametro \"Stringa\"");
                    }                    
                    break;
                case 3:
                    if(isset($_GET["cf"]) && isset($_GET["nome"]) && isset($_GET["cognome"]) && isset($_GET["datanascita"]) ){
                        $cf = mysqli_real_escape_string($conn, $_GET["cf"]);
                        $nome = mysqli_real_escape_string($conn, $_GET["nome"]);
                        $cognome = mysqli_real_escape_string($conn, $_GET["cognome"]);
                        $datanascita = mysqli_real_escape_string($conn, $_GET["datanascita"]);

                        $query = "CALL OP3('$cf', '$nome', '$cognome', '$datanascita')";
                        $res = mysqli_query($conn, $query);
                        
                        echo json_encode($res ? "Inserimento andato a buon fine" : "Inserimento non andato a buon fine");
                        mysqli_close($conn);
                        exit;                   
                    } else{
                        echo json_encode("Uno dei parametri non è stato inviato");
                    }          
                    break;
                case 4:
                    $query = "CALL OP4()"; 
                    $res = mysqli_query($conn, $query);
                    $query= "SELECT * FROM TEMP"; 
                    $res = mysqli_query($conn, $query);
                    $risp = array();
                    while($row = mysqli_fetch_assoc($res) ){
                        $risp[] = $row;
                    }
                    echo json_encode($risp);
                    mysqli_free_result($res);
                    break;
            }
        }
        mysqli_close($conn);
    }
?>
