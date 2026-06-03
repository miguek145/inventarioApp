<?php

session_name("UsuarioLogoneado");
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:loginController.php");
    die();
}

require_once "../model/productoReserva.php";
require_once "../model/tipos.php"; // AÑADIDO: Para cargar el listado de tipos
require_once "../model/analizadorFormulario.php";

// 1. FORZAMOS A (int) EL ID QUE VIENE POR URL PARA EVITAR TYPEERRORS
$idProducto = (int) analizadorFormulario($_GET['idProductoReserva']);

$producto = ProductoReserva::obtenerInfoProductoReserva($idProducto);

// AÑADIDO: Obtenemos todos los tipos para rellenar el <select>
$arrayTipos = Tipos::mostrarTipos(); 

$ruta = "tablaProductoReservaController.php";

if(isset($_POST['actualizar'])){

    // 2. FORZAMOS A (int) LOS NÚMEROS DEL FORMULARIO PARA RESPETAR TU TIPADO ESTRICTO
    $idProductoActualizar = (int) analizadorFormulario($_POST['idProductoReserva']);
    $nombreProductoReserva = analizadorFormulario($_POST['nombreProductoReserva']);
    $stockReserva = (int) analizadorFormulario($_POST['stockReserva']);
    $idTipo = (int) analizadorFormulario($_POST['idTipo']); 

    // =================================================================
    // VALIDACIÓN CON EXPRESIÓN REGULAR ANTES DE TOCAR LA BASE DE DATOS
    // =================================================================
    // Comprobamos que sean letras, números o espacios (máx 20 caracteres)
    if (preg_match('/^[A-Za-z0-9ñÑ\s]{1,20}$/', $nombreProductoReserva)) {
        
        // AÑADIDO: Pasamos el $idTipo a la función
        $resultado = ProductoReserva::editarProductoReserva($idProductoActualizar, $nombreProductoReserva, $stockReserva, $idTipo);
        
    } else {
        
        $resultado = "<h2>ATENCIÓN: El nombre del producto solo puede contener letras, números y espacios, con un máximo de 20 caracteres.</h2>";
        
    }

    // Tu urlencode() ya estaba perfecto aquí
    header("Location: tablaProductoReservaController.php?resultado=" . urlencode($resultado));
    exit;
}

$nombrePagina = "EDITAR PRODUCTO RESERVA";

require_once "../view/templates/declaracion.php";
require_once "../view/templates/barraNavegacion.php";
require_once "../view/editarProductoReservaV.php";
require_once "../view/templates/cierre.php";
?>