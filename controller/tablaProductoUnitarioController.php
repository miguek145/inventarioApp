<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/productUnitario.php";
    require_once "../model/analizadorFormulario.php";


    $idProducto=analizadorFormulario($_GET['idProducto']);

    //Obtenemos los datos de la tabla producto unitario
    $arrayProductosUnitarios=ProductoUnitario::cargarDatosProductosUnitarios($idProducto);
    
    //Obtenemos el idTipo del producto para la ruta del botón volver
    require_once "../model/products.php";
    $datosProducto=Productos::cargarInfoFormEditProducto($idProducto);
    $idTipo=$datosProducto['idTipo'];
    
    $ruta="tablaProductoTipoController.php?idTipo=$idTipo";

    $nombrePagina="PAGINA PRODUCTOS DE UN AULA";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/tablaProductoUnitarioV.php";
    require_once "../view/templates/cierre.php";
?>