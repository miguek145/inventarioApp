<?php

    require_once "../../model/conexionDB.php";
    require_once "../../model/analizadorFormulario.php";

    // Evitamos ataques XSS con tu función
    $buscar = analizadorFormulario($_GET['buscar']);

    $conexionDB = ConexionDB::conectar();

    // MODIFICADO: Añadimos el LEFT JOIN para obtener el nombre del tipo en la búsqueda
    $consultaTablaProductosReserva = $conexionDB->query("
        SELECT pr.*, t.nombreTipo 
        FROM productoreserva pr
        LEFT JOIN tipos t ON pr.FK_tipo = t.idTipo
        WHERE pr.nombreProductoReserva LIKE '%$buscar%'
    ");

    if($consultaTablaProductosReserva->rowCount() > 0){

        $arrayProductosReserva = array();
        
        while($fila = $consultaTablaProductosReserva->fetch(PDO::FETCH_ASSOC)){
            array_push($arrayProductosReserva, [
                "idProductoReserva" => $fila['idProductoReserva'],
                "nombreProductoReserva" => $fila['nombreProductoReserva'],
                "stockReserva" => $fila['stockReserva'],
                // AÑADIDO: Recogemos el tipo de la base de datos
                "nombreTipo" => $fila['nombreTipo'] ?? 'Sin asignar'
            ]);
        }

        // Pintamos las filas directamente con echo para que Fetch las reciba
        foreach($arrayProductosReserva AS $valor){
            echo "<div class='filaProductoReserva'>";
                echo "<div class='contenidoProductoReserva'>";
                    echo "<p><strong>" . $valor['nombreProductoReserva'] . "</strong></p>";
                    // AÑADIDO: Imprimimos el tipo para que ocupe la columna central del CSS
                    echo "<p>" . $valor['nombreTipo'] . "</p>";
                    echo "<p>" . $valor['stockReserva'] . "</p>";
                echo "</div>";

                echo "<div class='contenedorBotonesTablaProductosReserva'>";
                    echo "<a class='btn-tabla btn-asignar' href='./asignarProductoReservaController.php?idProductoReserva=".$valor['idProductoReserva']."'>Asignar</a>";
                    echo "<a class='btn-tabla btn-agregar' href='./agregarStockProductoReservaController.php?idProductoReserva=".$valor['idProductoReserva']."'>+ Stock</a>";
                    echo "<a class='btn-tabla btn-edit' href='./editProductoReservaController.php?idProductoReserva=".$valor['idProductoReserva']."'>Editar</a>";
                echo "</div>";
            echo "</div>";
        }

    } else {
         echo "<div class='error-mensaje'>No se encontraron productos con ese nombre.</div>";
    }

    $conexionDB = null;
?>