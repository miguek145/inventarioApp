<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/productoReserva.php";
    require_once "../model/analizadorFormulario.php";

    // Obtenemos los datos de la tabla producto de reserva
    $arrayProductosReserva = ProductoReserva::cargarTablaProductosReserva();
    
    // DEFINIMOS LA RUTA PARA EL BOTÓN VOLVER
    $ruta = "indexController.php";

    $nombrePagina = "TABLA PRODUCTOS RESERVA";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/tablaProductoReservaV.php";
    require_once "../view/templates/cierre.php";
?>
<script src="../view/js/buscadorProductoReserva.js"></script>