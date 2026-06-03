<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }
    require_once  "../model/productUnitario.php";

    
    //eliminar datos producto unitario
    require_once "../model/analizadorFormulario.php";

    $idProductoUnitario=analizadorFormulario($_GET['idProductoUnitario']);
    $idProducto=analizadorFormulario($_GET['idProducto']);
    $mensajeProductoEliminado=ProductoUnitario::eliminarProductoUnitario($idProductoUnitario);
    header("Location: tablaProductoUnitarioController.php?mensajeEliminado=$mensajeProductoEliminado&idProducto=$idProducto");

?>