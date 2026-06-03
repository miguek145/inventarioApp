<?php
    require_once "../../model/conexionDB.php";
    require_once "../../model/analizadorFormulario.php";
    require_once "../../model/products.php";

    $idTipo= analizadorFormulario($_GET['idTipo']);
    
    // 1. Recogemos el offset que nos envía el AJAX (si no viene, por defecto será 0)
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

    $conexionDB = ConexionDB::conectar();

    // obtenemos los datos de los productos
    $resultadoTablaProductos = Productos::mostrarProductos($idTipo);

    // 2. Calculamos hasta dónde tiene que llegar el bucle (ej: del 10 al 20)
    $limite = $offset + 10;

    // 3. Modificamos el bucle. Ahora empieza en $offset y termina en $limite
    for ($i = $offset; $i < $limite; $i++) {
    
        // Si ya no hay más productos en el array, rompemos el bucle
        if (!isset($resultadoTablaProductos[$i])) {
            break;
        }

        // Extraemos el valor actual usando el índice numérico
        $valor = $resultadoTablaProductos[$i];

        echo "<div class='contenedorFilaProducto'>";
            // comprobamos si el stock está bien para añadirle un color de fondo
            if($valor['stockMinimo'] == $valor['stockActual']){
                // amarillo claro
                echo "<a class='contenido' style='background-color: #dbcb3c;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
            }else if($valor['stockMinimo'] < $valor['stockActual']){
                // verde claro
                echo "<a class='contenido' style='background-color: #75d169;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
            }else{
                // rojo claro
                echo "<a  class='contenido'style='background-color: #eb3c3c;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
            }
                    echo "<p>".$valor['nombreProducto']."</p>";
                    echo "<p>".$valor['fechaActualizacion']."</p>"; 
                    echo "<p>".$valor['nombreTipo']."</p>";
                    echo "<p>".$valor['stockMinimo']."</p>";
                    echo "<p>".$valor['stockActual']."</p>";
                    echo "<p>".$valor['nombreLocalizacion']."-".$valor['nombreAula']."</p>";
            echo "</a>"; 
            
            echo "<div class='contenedorBotonesTablaProductos'>" ;
                echo "<a href='./editProductoController.php?idProducto={$valor['idProducto']}'>EDIT</a>";
                // He borrado un } que tenías al final de esta línea que rompía el enlace:
                echo "<a href='./eliminarProductoController.php?idProducto={$valor['idProducto']}&idTipo={$idTipo}' >DELETE</a>";
            echo "</div>";
        echo "</div>";
    }
?>