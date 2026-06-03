<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }
    
    if(isset($_POST['añadir'])){
        require_once  "../model/localizacion.php";
        require_once "../model/analizadorFormulario.php";

        $nombreLocalizacionNuevo = analizadorFormulario($_POST['localizacion']);

        // =================================================================
        // VALIDACIÓN CON EXPRESIÓN REGULAR ANTES DE TOCAR LA BASE DE DATOS
        // =================================================================
        // Los delimitadores '/' al principio y al final son obligatorios en PHP
        if (preg_match('/^[A-Z]{2}$/', $nombreLocalizacionNuevo)) {
            
            // Si cumple el formato, intentamos añadir a la base de datos
            $resultado = Localizacion::addLocalizacion($nombreLocalizacionNuevo); 
            
        } else {
            // Si no cumple el formato, devolvemos un error sin tocar el modelo
            $resultado = "ATENCIÓN: El código de localización debe estar formado exactamente por 2 letras mayúsculas.";
        }

    }

    $ruta="menuAddLocalizacionController.php";

    $nombrePagina="AÑADIR LOCALIZACION";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/addLocalizacionV.php";
    require_once "../view/templates/cierre.php";
?>
