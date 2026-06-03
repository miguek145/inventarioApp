<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/products.php";
    require_once "../model/analizadorFormulario.php";

    $idProducto=analizadorFormulario($_GET['idProducto']);

    //nos traemos los datos del producto para rellenar los inputs del formulario
    $arrayDatosProducto=Productos::cargarInfoFormEditProducto($idProducto);

    //esta es la fecha es para la modificación del producto seleccionado
    $fechaActual = date('Y-m-d');

    if(isset($_POST['actualizar'])){

        $stockMin=analizadorFormulario($_POST['stockMin']);

        $resultado=Productos::editarProducto($idProducto,$stockMin,$fechaActual);
        header("Location: editProductoController.php?idProducto=" . urlencode($_GET['idProducto']) . "&resultado=" . urlencode($resultado));
        exit;
    }

    $ruta="tablaProductoTipoController.php?idTipo=" . $arrayDatosProducto['idTipo'];

    $nombrePagina="EDITAR PRODUCTO";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/editProductov.php";
    require_once "../view/templates/cierre.php";
?>

