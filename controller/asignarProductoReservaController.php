<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    session_name("UsuarioLogoneado");
    session_start();

    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once "../model/productoReserva.php";
    require_once "../model/aula.php";
    require_once "../model/localizacion.php";
    require_once "../model/analizadorFormulario.php";

    if(empty($_GET['idProductoReserva'])) {
        header("Location: tablaProductoReservaController.php");
        exit;
    }

    $idProductoReserva = analizadorFormulario($_GET['idProductoReserva']);

    $infoProductoReserva = ProductoReserva::obtenerInfoProductoReserva($idProductoReserva);
    $nombreProductoReserva = $infoProductoReserva['nombreProductoReserva'] ?? 'Desconocido';
    $cantidadProductoReserva = $infoProductoReserva['stockReserva'] ?? 0;

    $arrayLocalizaciones = Localizacion::cargarLocalizaciones();
    $arrayAulas = Aula::cargarAulasDeUnaLocalizacion($arrayLocalizaciones[0]['idLocalizacion']);  
    
    if(isset($_POST['asignar'])){

        $cantidad = analizadorFormulario($_POST['cantidad']);
        $idAula = analizadorFormulario($_POST['idAula']);
        
        // Recogemos el stock mínimo. Si viene vacío (porque estaba oculto), le ponemos 1 por defecto.
        $stockMinimo = !empty($_POST['stockMinimo']) ? (int)analizadorFormulario($_POST['stockMinimo']) : 1;
        
        // Pasamos el stock mínimo como 4º parámetro
        $resultado = ProductoReserva::asignarProductoReserva($idProductoReserva, $cantidad, $idAula, $stockMinimo);

        header("Location: asignarProductoReservaController.php?resultado=" . urlencode($resultado) . "&idProductoReserva=" . urlencode($idProductoReserva));
        exit;
    }

    $datosProductosReserva = ProductoReserva::cargarTablaProductosReserva();

    $nombrePagina = "ASIGNAR PRODUCTO RESERVA";
    $ruta = "tablaProductoReservaController.php";

    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/asignarProductoReservaV.php";
    require_once "../view/templates/cierre.php";
?>
<script src="../view/js/aparecerSelectorAulas.js"></script>
<script src="../view/js/aparecerInputStockMinimo.js"></script>