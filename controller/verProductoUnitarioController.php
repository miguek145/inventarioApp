<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    session_name("UsuarioLogoneado");
    session_start();

    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
    }

    require_once "../model/productUnitario.php";
    require_once "../model/analizadorFormulario.php";

    $idProductoUnitario = analizadorFormulario($_GET["idProductoUnitario"]);

    $datosProductoUnitario = ProductoUnitario:: cargarDatosProductosUnitarios($idProductoUnitario);

    $nombrePagina = "DATOS QR";

    $ruta = "mostrarQRController.php?idProductoUnitario=" . $idProductoUnitario;

    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/verProductoUnitarioV.php";
    require_once "../view/templates/cierre.php";

?>