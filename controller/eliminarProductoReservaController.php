<?php

    session_name("UsuarioLogoneado");
    session_start();

    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once "../model/productoReserva.php";
    require_once "../model/analizadorFormulario.php";

    $idProductoReserva = analizadorFormulario($_GET['idProductoReserva']);

    $mensajeProductoEliminado = ProductoReserva::eliminarProductoReserva($idProductoReserva);

    header("Location: tablaProductoReservaController.php?resultado=" . urlencode($mensajeProductoEliminado));
    exit;
?>