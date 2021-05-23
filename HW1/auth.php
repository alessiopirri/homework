<?php
    require_once 'dbconf.php';
    session_start();

    function checkAuth() {
        // Se esiste già una sessione, ritorno l'email, altrimenti ritorno 0
        if(isset($_SESSION['email'])) {
            return $_SESSION['nome'];
        } else 
            return 0;
    }
?>