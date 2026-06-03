<main>
    <?php
        if(isset($arrayNombreProductoAulaLocalizacion)){
            echo "<h2 class='tituloAlmacenar'>Almacenar " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreProducto']) . " del " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreLocalizacion']) . " - " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreAula']) . "</h2>";
        }else{
            echo "<h2 class='tituloAlmacenar'>Almacenar producto</h2>";
        }
    ?>
    <form action="" method="post" class="formularioAlmacenar">
        <?php if(isset($resultado)): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($resultado) ?>
            </div>
        <?php endif; ?>        
        <div class="contenedorSeleccionarTodos">
            <label for="checkTodos">
                <input type="checkbox" name="seleccionarTodosProductos" id="checkTodos" >
                Seleccionar todos
            </label>
        </div>
        
        <section class="contenedorAlmacenar">
            <div class="tablaProductosAlmacenar tablaProductoReLi">
                
                <div class="encabezadoTablaProductosAlmacenar">
                    <div class="columnasTablaAlmacenar">
                        <span class="espacioCheckbox"></span> 
                        <h3>Nº identificativo</h3>
                        <h3>Propietario</h3>
                        <h3>Fecha</h3>
                    </div>
                </div>
                
                <?php
                    if(is_array($arrayProductosUnitarios)) {
                        echo "<div id='listaProductosAlmacenar'class='cuerpoTablaReubicar'>"; 
                        foreach($arrayProductosUnitarios AS $valor) {
                            echo "<div class='filaProductoAlmacenar'>";
                                echo "<div class='columnasConCheckboxAlmacenar'>";
                                    echo "<input type='checkbox' name='productoUnitarioIds[]' value='{$valor['idProductoUnitario']}' class='checkboxProductoAlmacenar'>";
                                    echo "<div class='contenidoProductoAlmacenar'>";
                                        echo "<p>" . $valor['numeroIdentificativo'] . "</p>";
                                        echo "<p>" . $valor['propietarioProducto'] . "</p>";
                                        echo "<p>" . $valor['fechaActualizacion'] . "</p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p class='mensajeVacio'>" . $arrayProductosUnitarios . "</p>";
                    }
                ?>
            </div>
        </section>
        
        <input type="submit" name="almacenar" value="Almacenar" class="botonAlmacenar">
    </form>
</main>