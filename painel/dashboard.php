<?php 
    require_once "../config.php";
    require_once "../vendor/autoload.php";

    if(isset($_SESSION["login"])){
        if(!Admin::verificarToken($_SESSION["email"],$_SESSION["token_session"])){
            header('Location: '.PATH_PAINEL);
        }else{

        }
    }else{
        header('Location: '.PATH_PAINEL);
    }
?>
 dashboard