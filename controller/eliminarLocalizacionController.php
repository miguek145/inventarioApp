<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/localizacion.php";
    //mostramos las localizaciones
    $datosNombresLocalizaciones=Localizacion::cargarLocalizaciones();

    if(isset($_POST['eliminar'])){
        require_once "../model/analizadorFormulario.php";

        $localizaciones=analizadorFormulario($_POST['localizaciones']);

        $resultado=Localizacion::eliminarLocalizacion($localizaciones); 
        header("Location:eliminarLocalizacionController.php?resultado=$resultado");     
    }
    
    $ruta="menuEliminarLocalizacionController.php";
    
    $nombrePagina="ELIMINAR LOCALIZACION";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/eliminarLocalizacionV.php";
    require_once "../view/templates/cierre.php";
?>