<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once "../model/productoReserva.php";
    require_once "../model/tipos.php"; // AÑADIDO: Cargamos el modelo de tipos
    require_once "../model/analizadorFormulario.php";

    $ruta = "tablaProductoReservaController.php";
    
    // AÑADIDO: Recordar el último tipo seleccionado
    $ultimoTipo = null;

    if(isset($_POST['add'])) {
        $nombreProductoReserva = analizadorFormulario($_POST['nombreProductoReserva']);
        $stockReserva = analizadorFormulario($_POST['stockReserva']);
        $idTipo = analizadorFormulario($_POST['idTipo']); // Capturamos el tipo
        
        $ultimoTipo = $idTipo;

        if (preg_match('/^[A-Za-z0-9ñÑ\s]{1,20}$/', $nombreProductoReserva)) {
            // Pasamos el $idTipo a la función
            $resultado = ProductoReserva::addProductoReserva($nombreProductoReserva, $stockReserva, $idTipo);
        } else {
            $resultado = "ATENCIÓN: El nombre del producto solo puede contener letras, números y espacios, con un máximo de 20 caracteres.";
        }
        
        // Redirección para evitar reenvío de formulario y pasar los datos
        header("Location: addProductoReservaController.php?resultado=" . urlencode($resultado) . "&tipo=" . urlencode($ultimoTipo));
        exit;
    }

    // Si venimos de redirección, recuperamos el último tipo
    if(isset($_GET['tipo'])){
        $ultimoTipo = $_GET['tipo'];
    }

    // AÑADIDO: Cargamos la lista de tipos para el desplegable
    $arrayTipos = Tipos::mostrarTipos();

    $nombrePagina = "AÑADIR PRODUCTO RESERVA";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/addProductoReservaV.php";
    require_once "../view/templates/cierre.php";
?>