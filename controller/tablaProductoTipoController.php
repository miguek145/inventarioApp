<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

 
    require_once "../model/usuarios.php";
    require_once "../model/products.php";
    require_once "../model/localizacion.php";
    require_once "../model/analizadorFormulario.php";
    require_once "../model/tipos.php";

    $idTipo=analizadorFormulario($_GET['idTipo'] ?? '');

    if(empty($idTipo)){
        header("Location: indexController.php");
        exit;
    }

    //Nos traemos los nombres de los datos de las localizaciones
    $arraynombreLocalizaciones=Localizacion::cargarLocalizaciones();
    $resultadoTablaProductos=Productos::mostrarProductos($idTipo);
    $nombreTipo=Tipos::mostrarNombreTipo($idTipo);

    $ruta="indexController.php";

    $nombrePagina="PANEL INVENTARIO";
    require_once "../view/templates/declaracion.php";  
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/tablaProductoTipoV.php";
    require_once "../view/templates/cierre.php";
?>
    <script src="../view/js/buscadoresProducto.js"></script>
    <script src="../view/js/botonesVisualizarMasProductos.js"></script>  