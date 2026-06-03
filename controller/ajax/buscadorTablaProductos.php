<?php

    require_once "../../model/conexionDB.php";
    require_once "../../model/analizadorFormulario.php";

    //evitamos ataques XSS
    $nombreProducto=analizadorFormulario($_GET['nombreProducto']);
    $idLocalizacion=analizadorFormulario($_GET['idLocalizacion']);
    $idTipo=analizadorFormulario($_GET['idTipo']);

    $conexionDB=ConexionDB::conectar();

    // MODIFICADO: Añadido el INNER JOIN con productoreserva y actualizado p.FK_tipo a pr.FK_tipo
    $consultaTablaProductos=$conexionDB->query("SELECT *
                                                FROM productos p
                                                INNER JOIN aulas a ON p.FK_aula = a.idAula
                                                INNER JOIN localizaciones l ON a.FK_localizacion = l.idLocalizacion
                                                INNER JOIN productoreserva pr ON p.FK_productoReserva = pr.idProductoReserva
                                                INNER JOIN tipos t ON t.idTipo = pr.FK_tipo 
                                                WHERE pr.FK_tipo = $idTipo 
                                                AND p.nombreProducto LIKE'%$nombreProducto%'
                                                AND a.FK_localizacion=$idLocalizacion");

    if($consultaTablaProductos->rowCount()>0){

        $arrayTablaProductos=array();
        while($fila=$consultaTablaProductos->fetch(PDO::FETCH_ASSOC)){
            array_push($arrayTablaProductos,["idProducto"=>$fila['idProducto'],"nombreProducto"=>$fila['nombreProducto'],"fechaActualizacion"=>$fila['fechaActualizacion'],"stockMinimo"=>$fila['stockMinimo'],"stockActual"=>$fila['stockActual'],"nombreTipo"=>$fila['nombreTipo'],"nombreLocalizacion"=>$fila['nombreLocalizacion'],"nombreAula"=>$fila['nombreAula']]);
        }
        echo '<div class="encabezadoTablaProductos">';
            echo '    <div>';
            echo '        <h3>Nombre</h3>';
            echo '        <h3>Fecha</h3>';
            echo '        <h3>Tipo</h3>';
            echo '        <h3>Stock mín</h3>';
            echo '        <h3>Stock actual</h3>';
            echo '        <h3>Localización</h3>';
            echo '    </div>';
            echo '    <div></div>';
        echo '</div>';
        foreach($arrayTablaProductos AS $valor){

            echo "<div class='contenedorFilaProducto'>";
                //comprobamos si el stock está bien para añadirle un color de fondo
                if($valor['stockMinimo'] == $valor['stockActual']){
                    // amarillo pastel suave
                    echo "<a class='contenido' style='background-color: #FFF9C4; color: #F57F17;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                }else if($valor['stockMinimo'] < $valor['stockActual']){
                    // verde pastel suave
                echo "<a class='contenido' style='background-color: #C8E6C9; color: #2E7D32;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                }else{
                    // rojo pastel suave
                    echo "<a  class='contenido'style='background-color:  #FFCDD2; color: #C62828;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                }
                                echo "<p>".$valor['nombreProducto']."</p>";
                                echo "<p>".$valor['fechaActualizacion']."</p>"; 
                                echo "<p>".$valor['nombreTipo']."</p>";
                                echo "<p>".$valor['stockMinimo']."</p>";
                                echo "<p>".$valor['stockActual']."</p>";
                                echo "<p>".$valor['nombreLocalizacion']."-".$valor['nombreAula']."</p>";
                    echo "</a>"; 
                    echo "<div class='contenedorBotonesTablaProductos'>" ;
                        echo "<a class='btn-tabla btn-edit' href='./editProductoController.php?idProducto={$valor['idProducto']}'>EDIT</a>";
                            echo "<a class='btn-tabla btn-delete' href='./eliminarProductoController.php?idProducto={$valor['idProducto']}&idTipo={$_GET['idTipo']}'>ELIMINAR</a>";
                    echo "</div>";
            echo "</div>";
        }

    }else{
         echo "<h2>HAY 0 PRODUCTOS</h2>";
    }
    $conexionDB = null;
?>