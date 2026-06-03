<?php

session_name("UsuarioLogoneado");
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:loginController.php");
    die();
}

require_once "../model/productoReserva.php";
require_once "../model/analizadorFormulario.php";

$idProductoReserva=analizadorFormulario($_GET['idProductoReserva']);
$infoProductoReserva = ProductoReserva::obtenerInfoProductoReserva($idProductoReserva);
$nombreProductoReserva = $infoProductoReserva['nombreProductoReserva'] ?? '';
$stockActual = $infoProductoReserva['stockReserva'] ?? 0;
$ruta = "tablaProductoReservaController.php";
if(isset($_POST['agregarStock'])){
    $stockReserva = analizadorFormulario($_POST['stockReserva']);
    $resultado = ProductoReserva::agregarStockProductoReserva($idProductoReserva,$stockReserva);

    header("Location:agregarStockProductoReservaController.php?resultado=" . urlencode($resultado) . "&idProductoReserva=" . urlencode($_GET['idProductoReserva']));
    exit;
}

$nombrePagina = "AGREGAR STOCK PRODUCTO RESERVA";
require_once "../view/templates/barraNavegacion.php";
require_once "../view/templates/declaracion.php";
require_once "../view/agregarStockProductoReservaV.php";
require_once "../view/templates/cierre.php";

?>