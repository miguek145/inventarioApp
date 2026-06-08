<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once "../model/productUnitario.php";
    require_once "../model/analizadorFormulario.php";
    require_once "../model/productoReserva.php";
    require_once "../model/GeneradorQR.php";

    $idProducto = analizadorFormulario($_GET['idProducto']);

    $arrayProductosUnitarios = ProductoUnitario::cargarDatosProductosUnitarios($idProducto);

    require_once "../model/products.php";
    $arrayDatosProducto = Productos::cargarInfoFormEditProducto($idProducto);
    $idTipo = $arrayDatosProducto['idTipo'];
    $ruta = "tablaProductoUnitarioController.php?idProducto=$idProducto";

    // Variable para guardar los QRs generados (vacía por defecto)
    $arrayQRsGenerados = [];

    if(isset($_POST['imprimir'])){

        if (!isset($_POST['productoUnitarioIds']) || !is_array($_POST['productoUnitarioIds']) || count($_POST['productoUnitarioIds']) === 0) {
            $resultado = "<h3>ATENCIÓN: No has seleccionado ningún producto para imprimir</h3>";
        } else {
            $arrayIdProductosUnitarios = array();
       
            foreach($_POST['productoUnitarioIds'] as $valor){
                $valor = analizadorFormulario($valor);
                array_push($arrayIdProductosUnitarios, $valor);
            }

            // Generamos las imágenes y las guardamos en la variable.
            // NO HACEMOS REDIRECCIÓN. Dejamos que la página cargue para poder imprimir.
            $arrayQRsGenerados = GeneradorQR::generarCodigo($arrayIdProductosUnitarios);
        }
    }

    $nombrePagina = "IMPRIMIR QRs";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/imprimirQRsV.php"; // Aquí le pasamos el $arrayQRsGenerados
    require_once "../view/templates/cierre.php";
?>
<script src="../view/js/seleccionarTodos.js"></script>