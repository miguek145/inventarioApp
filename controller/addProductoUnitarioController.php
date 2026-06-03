<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/productUnitario.php";
    require_once "../model/analizadorFormulario.php";

    //esta es la fecha en la que se creó ese nuevo elemento
    $fechaActualizacion = date('Y-m-d');
    
    // 1. FORZAMOS A (int) EL ID QUE VIENE POR GET
    $idProducto = (int) analizadorFormulario($_GET['idProducto']);

    if(isset($_POST['add'])) {
        $nombrePropietario = analizadorFormulario($_POST['nombrePropietario']);

        // =================================================================
        // VALIDACIÓN CON EXPRESIÓN REGULAR ANTES DE TOCAR LA BASE DE DATOS
        // =================================================================
        if (preg_match("/^[A-Za-z0-9ñÑ\s]{0,30}$/", $nombrePropietario)) {
            
            // Si cumple el formato, intentamos añadir a la base de datos
            $resultado = ProductoUnitario::addProductoUnitario($idProducto, $nombrePropietario, $fechaActualizacion);
            
        } else {
            
            // Si no cumple el formato, bloqueamos la acción y mostramos el error
            $resultado = "ATENCIÓN: El nombre del propietario solo puede contener letras, números y espacios, y debe tener un máximo de 30 caracteres.";
            
        }
    }

    // Definimos la ruta de vuelta una sola vez
    $ruta="tablaProductoUnitarioController.php?idProducto=$idProducto";

    $nombrePagina="AÑADIR PRODUCTO UNITARIO";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/addProductoUnitarioV.php";
    require_once "../view/templates/cierre.php";
?>