<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/tipos.php";

    $datosNombresTipos=Tipos::mostrarTipos();

    if(isset($_POST['eliminar'])){

        $resultado=Tipos::delTipo($_POST['tipos']); 
        header("Location:eliminarTiposController.php?resultado=$resultado");     
    }

    $ruta="indexController.php";

    $nombrePagina="DEL TYPE";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/eliminarTiposV.php";
    require_once "../view/templates/cierre.php";
?>