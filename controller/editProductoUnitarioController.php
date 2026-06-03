<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/productUnitario.php";
    require_once "../model/analizadorFormulario.php";

    $fechaActualizacion = date('Y-m-d');
    
    // 1. OBTENEMOS IDs SIEMPRE DISPONIBLES
    $idProducto = (int) analizadorFormulario($_GET['idProducto']);
    $idProductoUnitario = (int) analizadorFormulario($_GET['idProductoUnitario']);
    
    // 2. PEDIMOS LOS DATOS ORIGINALES DEL PRODUCTO
    $producto = ProductoUnitario::obtenerProductoUnitarioPorId($idProductoUnitario);

    // 3. PROCESAMIENTO DEL FORMULARIO
    if(isset($_POST['actualizar'])){

        $nuevoNombrePropietario = analizadorFormulario($_POST['nuevoNombrePropietario']);

        if (preg_match("/^[A-Za-z0-9ñÑ\s]{0,30}$/", $nuevoNombrePropietario)) {
            
            // Actualizamos la base de datos
            $resultado = ProductoUnitario::editarProductoUnitario($idProductoUnitario, $nuevoNombrePropietario, $fechaActualizacion);

            header("Location: editProductoUnitarioController.php?idProducto=$idProducto&idProductoUnitario=$idProductoUnitario&nombrePropietarioActualizado=" . urlencode($nuevoNombrePropietario) . "&resultado=" . urlencode($resultado));
            exit;
            
        } else {
            $resultado = "<h2>ATENCIÓN: El nombre del propietario solo puede contener letras, números y espacios, y debe tener un máximo de 30 caracteres.</h2>";
        }
    }

    // 4. RECUPERAMOS EL MENSAJE DE ÉXITO DE LA URL (Si venimos de la redirección)
    if(isset($_GET['resultado'])){
        $resultado = $_GET['resultado'];
    }

    $ruta="tablaProductoUnitarioController.php?idProducto=$idProducto";
    
    $nombrePagina="EDITAR PRODUCTO UNITARIO";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/editProductoUnitarioV.php";
    require_once "../view/templates/cierre.php";
?>