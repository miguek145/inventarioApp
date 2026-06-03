<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }
    require_once  "../model/products.php";
    require_once "../model/analizadorFormulario.php";

    //eliminar datos
    $idProducto=analizadorFormulario($_GET['idProducto']);
    $idTipo=analizadorFormulario($_GET['idTipo']);

    $mensajeProductoEliminado=Productos::eliminarProducto($idProducto);

    header("Location: tablaProductoTipoController.php?mensajeEliminado=$mensajeProductoEliminado&idTipo=$idTipo");

?>