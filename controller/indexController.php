<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once "../model/usuarios.php";
    require_once "../model/tipos.php";


    $arrayTiposProductos=Tipos::mostrarTipos();
    
    $ruta="indexController.php";
    
    $nombrePagina="PAGINA PRINCIPAL";
    require_once "../view/templates/declaracion.php";  
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/indexV.php";
    require_once "../view/templates/cierre.php";

?>