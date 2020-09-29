<?php
    require "../vendor/autoload.php";
    require "../config.php";

    if(isset($_SESSION["login"])){
        include('dashboard.php');
    }else{
        include('login.php');
    }