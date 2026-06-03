<?php
    require_once "../../model/conexionDB.php";
    require_once "../../model/analizadorFormulario.php";
    require_once "../../model/products.php";

    $idTipo = analizadorFormulario($_GET['idTipo']);
    
    // 1. Recogemos el offset que nos envía el AJAX (si no viene, por defecto será 0)
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

    $conexionDB = ConexionDB::conectar();

    // obtenemos los datos de los productos
    $resultadoTablaProductos = Productos::mostrarProductos($idTipo);

    // 2. Calculamos hasta dónde tiene que llegar el bucle (ej: del 10 al 20)
    $limite = $offset + 10;

    // 3. Modificamos el bucle. Ahora empieza en $offset y termina en $limite
    if (is_array($resultadoTablaProductos)) {
        for ($i = $offset; $i < $limite; $i++) {
        
            // Si ya no hay más productos en el array, rompemos el bucle
            if (!isset($resultadoTablaProductos[$i])) {
                break;
            }

            // Extraemos el valor actual usando el índice numérico
            $valor = $resultadoTablaProductos[$i];

            echo "<div class='contenedorFilaProducto'>";
                // ACTUALIZADO: Colores en tonos pastel y estilos idénticos al nuevo panel principal
                if($valor['stockMinimo'] == $valor['stockActual']){
                    // Amarillo Pastel suave
                    echo "<a class='contenido' style='background-color: #FFF9C4; color: #F57F17;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                }else if($valor['stockMinimo'] < $valor['stockActual']){
                    // Verde Pastel suave
                    echo "<a class='contenido' style='background-color: #C8E6C9; color: #2E7D32;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                }else{
                    // Rojo Pastel suave
                    echo "<a class='contenido' style='background-color: #FFCDD2; color: #C62828;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                }
                    echo "<p><strong>".$valor['nombreProducto']."</strong></p>";
                    echo "<p>".$valor['fechaActualizacion']."</p>"; 
                    echo "<p>".$valor['nombreTipo']."</p>";
                    echo "<p>".$valor['stockMinimo']."</p>";
                    echo "<p>".$valor['stockActual']."</p>";
                    echo "<p>".$valor['nombreLocalizacion']."-".$valor['nombreAula']."</p>";
                echo "</a>"; 
                
                // ACTUALIZADO: Botones con el nuevo set de clases limpias sin bordes toscos
                echo "<div class='contenedorBotonesTablaProductos'>" ;
                    echo "<a class='btn-tabla btn-edit' href='./editProductoController.php?idProducto={$valor['idProducto']}'>EDIT</a>";
                    echo "<a class='btn-tabla btn-delete' href='./eliminarProductoController.php?idProducto={$valor['idProducto']}&idTipo={$idTipo}'>ELIMINAR</a>";
                echo "</div>";
            echo "</div>";
        }
    }
?>