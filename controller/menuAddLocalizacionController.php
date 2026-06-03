<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    $ruta="indexController.php";
    
    $nombrePagina="MENU AÑADIR LOCALIZACIONES";
    require_once "../view/templates/declaracion.php";  
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/menuAddLocalizacionV.php";
    require_once "../view/templates/cierre.php";

?>