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

        //eliminar datos producto unitario
        require_once "../model/analizadorFormulario.php";

        $tipos=analizadorFormulario($_POST['tipos']);

        $resultado=Tipos::delTipo($tipos); 
        header("Location:eliminarTipoController.php?resultado=$resultado");     
    }

    $ruta="indexController.php";

    $nombrePagina="ELIMINAR TIPOS";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/eliminarTipoV.php";
    require_once "../view/templates/cierre.php";
?>