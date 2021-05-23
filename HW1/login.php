<?php
    include 'auth.php';
    if(checkAuth()){
        header("Location: index.php");
        exit;
    }
    if(isset($_GET["ritorno"])){
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));
        $ritorno = mysqli_real_escape_string($conn, $_GET["ritorno"]);
    }
    //Se email e password non sono vuoti
    if(!empty($_POST["email"]) && !empty($_POST["password"])){
        //Connessione database
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT password, nome, codice FROM Cliente WHERE email = '$email'";

        $res = mysqli_query($conn, $query) or die (mysqli_error($conn));
        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            if(password_verify($_POST['password'], $row['password'])){
                session_destroy(); //Per chiudere un eventuale sessione di un utente nell'area riservata
                session_start();
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["nome"] = $row['nome'];
                $_SESSION["codice"] = $row['codice'];
                if(isset($ritorno)){
                    header("Location: $ritorno");
                } else{
                    header("Location: index.php");
                }                
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
            else{
                $error = "E-mail o password errati";
            }
        } else{
            $error = "Utente non registrato";
        }
    }
    else if(!empty($_POST["email"]) || !empty($_POST["password"])){
        $error = "Inserisci email e password";
    }

?>

<html>
    <head>
        <title>Pirripneus | Accedi</title>
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
                            <p>Accedi</p>                          
                        </div>
                        <?php
                            if(isset($error)){
                                echo "<p id=\"error\"> $error </p>";
                            }
                        ?>
                        
                        <div class="oggetto">
                            <p>E-mail:</p>
                            <input type="email" name='email' class="textbox" autocomplete="email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                        </div>
                        <div class="oggetto">
                            <p>Password:</p>
                            <input type="password" name='password' class="textbox" autocomplete="current-password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                        </div>
                        <input type="submit" value="Accedi">
                        <div class="oggetto">
                            <p>Non sei registrato?</p>
                            <a href="registrazione.php" id="registrati"> Registrati </a>
                        </div>
                    </div>
                </form>
            </div>
        </article>
    </body>

</html>