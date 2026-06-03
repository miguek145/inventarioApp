<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/productUnitario.php";
    require_once "../model/analizadorFormulario.php";
    require_once "../model/productoReserva.php";

    $idProducto=analizadorFormulario($_GET['idProducto']);

    //Obtenemos los datos de la tabla producto unitario
    $arrayProductosUnitarios=ProductoUnitario::cargarTablaProductosUnitarios($idProducto);
    
    if(is_array($arrayProductosUnitarios)){
        //Obtenemos el nombre del producto, aula y localización para mostrarlo en el título de la página
        $arrayNombreProductoAulaLocalizacion=ProductoUnitario::cargarNombreProductoAulaLocalizacion($arrayProductosUnitarios[0]);
    }
 

    //Obtenemos el idTipo del producto para la ruta del botón volver
    require_once "../model/products.php";
    $arrayDatosProducto=Productos::cargarInfoFormEditProducto($idProducto);
    $idTipo=$arrayDatosProducto['idTipo'];
    
    $ruta="tablaProductoUnitarioController.php?idProducto=$idProducto";

if(isset($_POST['almacenar'])){

    // 1. Comprobamos si el POST existe, si es un array y si tiene al menos 1 elemento
    if (!isset($_POST['productoUnitarioIds']) || !is_array($_POST['productoUnitarioIds']) || count($_POST['productoUnitarioIds']) === 0) {
        
        $resultado = "<h3>ATENCIÓN: No has seleccionado ningún producto para liberar</h3>";
        
    } else {
        
        $idAula = analizadorFormulario($_POST['aula']);
        
        $arrayIdProductosUnitarios = array();
   
        foreach($_POST['productoUnitarioIds'] as $valor){
            $valor = analizadorFormulario($valor);
            array_push($arrayIdProductosUnitarios, $valor);
        }

        // 2. Le pasamos a la función el array que acabamos de rellenar y limpiar arriba
        $resultado = ProductoReserva::liberarProductoReserva($arrayIdProductosUnitarios);

        header("Location: almacenarProductoUnitarioController.php?idTipo=$idTipo&idProducto=$idProducto&resultado=$resultado");
        exit();
    }
}

    $nombrePagina="ALMACENAR PRODUCTOS";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/almacenarProductoUnitarioV.php";
    require_once "../view/templates/cierre.php";
?>
<script src="../view/js/seleccionarTodos.js"></script>