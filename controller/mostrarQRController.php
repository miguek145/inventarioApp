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
    require_once "../model/GeneradorQR.php";
    require_once "../model/analizadorFormulario.php";

    $idProductoUnitario = $_GET["idProductoUnitario"];
    
    $url = "http://localhost:3000/inventarioApp/controller/verProductoUnitarioController.php?idProductoUnitario="
     . urlencode($idProductoUnitario);

    $codigoQR = GeneradorQR::generarCodigo($url);

    $ruta = "tablaProductoUnitarioController.php?idProducto=" . $idProductoUnitario;


    $nombrePagina = "CÓDIGO QR DEL PRODUCTO";

    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/mostrarQRV.php";  
    require_once "../view/templates/cierre.php";

?>