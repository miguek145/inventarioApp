<main>    
    <h2>PANEL INVENTARIO</h2>
    <h3 id="nombreTipoProductos" class="<?php echo $idTipo; ?>"><?php echo mb_strtoupper($nombreTipo); ?></h3>

    <div class="contenedorPadreBuscadores">
        <h3>Buscador</h3>
        <section class="contenedorBuscadores">
            <div>
                <label for="nombreProducto">Nombre:</label>
                <input id="nombreProducto" type="text" name="nombreProducto" autofocus>
            </div>
            <div>
                <label for="selectorLocalizaciones">Localizaciones:</label>
                <select id="selectorLocalizaciones" name="localizacion">
                <?php
                    foreach($arraynombreLocalizaciones as $valor){
                        echo "<option value='{$valor['idLocalizacion']}'>{$valor['nombreLocalizacion']}</option>";
                    }
                ?>
                </select>
            </div>
            <div class="bloque-botones-buscar">
                <button id="botonBuscarProducto">Buscar</button>
                <button id="botonLimpiarBuscadorProducto">Limpiar</button>
            </div>
        </section>
    </div>

    <?php
        if(isset($_GET["mensajeEliminado"])){
            echo "<div style='background-color: #FFCDD2; color: #C62828; padding: 10px; border: 1px solid #FFB7B6;'>";
            echo $_GET["mensajeEliminado"];
            echo "</div>";
        }
    ?>

    <section class="tablaProductos">
        <div class="encabezadoTablaProductos">
            <div>
                <h3>Nombre</h3>
                <h3>Fecha</h3>
                <h3>Tipo</h3>
                <h3>Stock mín</h3>
                <h3>Stock actual</h3>
                <h3>Localización</h3>
            </div>
            <div>Acciones</div>
        </div>
        
        <?php                
            if(is_array($resultadoTablaProductos)){
                for ($i = 0; $i < 10; $i++) {

                    if (!isset($resultadoTablaProductos[$i])) {
                        break;
                    }

                    $valor = $resultadoTablaProductos[$i];

                    echo "<div class='contenedorFilaProducto'>";
                        // Cambiamos los colores en línea por tonos pastel elegantes y quitamos el subrayado
                        if($valor['stockMinimo'] == $valor['stockActual']){
                            // Amarillo Pastel suave
                            echo "<a class='contenido' style='background-color: #FFF9C4; color: #F57F17;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                        }else if($valor['stockMinimo'] < $valor['stockActual']){
                            // Verde Pastel suave
                            echo "<a class='contenido' style='background-color: #C8E6C9; color: #2E7D32;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                        }else{
                            // Rojo Pastel suave (Alerta de rotura de stock)
                            echo "<a class='contenido' style='background-color: #FFCDD2; color: #C62828;' href='./tablaProductoUnitarioController.php?idProducto={$valor['idProducto']}'>";
                        }
                            echo "<p><strong>".$valor['nombreProducto']."</strong></p>";
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
            } else {
                echo "<div class='error-mensaje'>" . $resultadoTablaProductos . "</div>";
            }
        ?>
        
        <div id="contenedorBotonesSiguienteAnterior">
            <button id="botonPagAnterior">Pág anterior</button>
            <button id="botonPagSiguiente">Pág siguiente</button>
        </div>
    </section>
</main>