<?php
    include 'auth.php';
    if(checkAuth()){
        header("Location: index.php");
        exit;
    }
    if(!empty($_POST["nome"]) && !empty($_POST["cognome"]) && 
    !empty($_POST["email"]) && !empty($_POST["password"]) && 
    !empty($_POST["ripetipassword"]) && !empty($_POST["cf"])){
        
        $conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']) or die (mysqli_error($conn));

        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $ripetipassword = mysqli_real_escape_string($conn, $_POST['ripetipassword']);
        $cf = mysqli_real_escape_string($conn, $_POST['cf']);


        if(strlen($_POST["password"]) < 8) {
            $error[] = "Password troppo corta!";
        }

        if(strcmp($_POST["password"], $_POST["ripetipassword"]) !=0){
            $error[] = "Le password non coincidono";
        }

        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $error[] = "Email non valida";
        }
        else{
            $res = mysqli_query($conn, "SELECT email FROM Cliente WHERE email = '$email'");
            if(mysqli_num_rows($res) > 0){
                $error[] = "Email già in uso";               
            }
        }

        if(!isset($error)){
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO cliente (Nome, Cognome, Email, Password, CF) VALUES ('$nome', '$cognome', '$email', '$password', '$cf')";

            if(mysqli_query($conn, $query)){
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["nome"] = $_POST["nome"];
                mysqli_close($conn);
                header("Location: index.php");
                exit;
            }
            else{
                $error[] = "Errore di connessione al server"; 
            }
        }
        mysqli_close($conn);
    }else if(isset($_POST["email"])){
        $error[] = "Riempi tutti i campi";
    }
?>

<html>

    <head>
        <title>Pirripneus | Registrati</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/common.css">
        <link rel="stylesheet" href="style/login.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <script src="scripts/signup.js" defer></script>
    </head>


    <body>
        <article>
            <div id="formcontainer">
                <a href="index.php" id="logobanner"> Pirripneus</a>
                <form name="signup" method="POST">
                    <div id="containeroggetti">
                        <div id="accedi">
                            <p>Registrati</p>
                        </div>
                        <?php
                            if(isset($error)){
                                foreach($error as $errore){
                                    echo ("<p class=\"error\"> $errore</p>");
                                }                                
                            }
                        ?>
                        <p id="error" class="hidden">Riempi tutti i campi e/o verifica che non ci siano errori</p>
                        <div class="oggetto">
                            <p>Nome:</p>
                            <input type="text" name="nome" class="textbox" autocomplete="given-name" <?php if(isset($_POST["nome"])){echo "value=".$_POST["nome"];} ?>>
                            <p class="hidden" id="nome">Inserisci il nome</p>
                            <p class="hidden" id="nomelungo">Il nome può essere lungo al massimo 32 caratteri</p>
                        </div>
                        <div class="oggetto">
                            <p>Cognome:</p>
                            <input type="text" name="cognome" class="textbox" autocomplete="family-name" <?php if(isset($_POST["cognome"])){echo "value=".$_POST["cognome"];} ?>>
                            <p class="hidden" id="cognome">Inserisci il cognome</p>
                        </div>
                        <div class="oggetto">
                            <p>E-mail:</p>
                            <input type="email" name="email" class="textbox" autocomplete="email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                            <p class="hidden" id="emailvalid">Email non valida</p>
                            <p class="hidden" id="emailinuse">Email gia in uso</p>
                            <p class="hidden" id="email">Inserisci e-mail</p>
                        </div>
                        <div class="oggetto">
                            <p>Password:</p>
                            <input type="password" name="password" class="textbox" autocomplete="new-password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                            <p class="hidden" id="password">Inserisci una password</p>
                            <p class="hidden" id="passwordnotvalid">Password non valida, assicurati che la lunghezza sia compresa tra 8 e 15 caratteri e che contenga una maiuscola, un numero e un carattere speciale (! ? @ # $ % ^ & *)</p>
                        </div>
                        <div class="oggetto">
                            <p>Ripeti password:</p>
                            <input type="password" name="ripetipassword" class="textbox" autocomplete="new-password" <?php if(isset($_POST["ripetipassword"])){echo "value=".$_POST["ripetipassword"];} ?>>
                            <p class="hidden" id="repeatpassword">Reinserisci la password</p>
                            <p class="hidden" id="passwordmatch">Le password non coincidono</p>
                        </div>
                        <div class="oggetto">
                            <p>Codice fiscale:</p>
                            <input type="text" name="cf" class="textbox" <?php if(isset($_POST["cf"])){echo "value=".$_POST["cf"];} ?>>
                            <p class="hidden" id="cf">Inserisci il codice fiscale</p>
                            <p class="hidden" id="cferrato">Codice fiscale errato</p>
                        </div>
                        <input type="submit" name="submit" value="Registrati">
                        <div class="oggetto">
                            <p>Sei gia registrato?</p>
                            <a href="login.php" id="registrati"> Accedi </a>
                        </div>

                    </div>
                </form>
            </div>
        </article>
    </body>
</html>