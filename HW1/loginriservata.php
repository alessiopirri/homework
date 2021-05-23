<?php
    include "dbconf.php";
    session_start();
    if(isset($_SESSION["codicefiscale"])){
        header("Location: areariservata.php");
        exit;
    }
    //Se email e password non sono vuoti
    if(!empty($_POST["cf"]) && !empty($_POST["password"])){
        //Connessione database
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

        $cf = mysqli_real_escape_string($conn, $_POST['cf']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT password FROM impiegato WHERE cf = '$cf'";

        $res = mysqli_query($conn, $query) or die (mysqli_error($conn));
        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            if(md5($password) == $row['password']){
                session_destroy();  //Per chiudere un eventuale sessione di un utente "normale"
                session_start();                
                $_SESSION["codicefiscale"] = $_POST["cf"];
                header("Location: areariservata.php");        
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
            else{
                $error = "Codice fiscale o password errati";
            }
        } else {
            $error = "Codice fiscale errato";
        }
    }
    else if(!empty($_POST["cf"]) || !empty($_POST["password"])){
        $error = "Inserisci codice fiscale e password";
    }

?>

<html>
    <head>
        <title>Pirripneus | Accedi area riservata</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/common.css">
        <link rel="stylesheet" href="style/login.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/favicon.png" />
    </head>

    <body>
        <article>
            <div id="formcontainer">
                <a href="index.php" id="logobanner"> Pirripneus</a>
                <form name="login" method="POST">
                    <div id="containeroggetti">
                        <div id="accedi">
                            <p>Accedi all'area riservata</p>                          
                        </div>
                        <?php
                            if(isset($error)){
                                echo "<p id=\"error\"> $error </p>";
                            }
                        ?>
                        
                        <div class="oggetto">
                            <p>Codice fiscale:</p>
                            <input type="cf" name='cf' class="textbox" autocomplete="cf" <?php if(isset($_POST["cf"])){echo "value=".$_POST["cf"];} ?>>
                        </div>
                        <div class="oggetto">
                            <p>Password:</p>
                            <input type="password" name='password' class="textbox" autocomplete="current-password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                        </div>
                        <input type="submit" value="Accedi">
                    </div>
                </form>
            </div>
        </article>
    </body>

</html>