<main>
<?php
    if(isset($arrayNombreProductoAulaLocalizacion)){
        echo "<h2 class='tituloTablaReubicarProductos'>Reubicar " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreProducto']) . " del " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreLocalizacion']) . " - " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreAula']) . "</h2>";
    }else{
        echo "<h2 class='tituloTablaReubicarProductos'>Reubicar producto</h2>";
    }
?>

<form action="" method="post" id="formularioReubicar">
    <section class="contenedorReubicar">
        
        <div class="panelTablaReubicar">
            
            <div class="contenedorSeleccionarTodos">
                <label>
                    <input type="checkbox" name="seleccionarTodosProductos" id="checkTodos">
                    <span>Seleccionar todos</span>
                </label>
            </div>

            <div class="tablaProductosReubicar">
                <div class="encabezadoTablaProductosReubicar">
                    <div class="columnsWithCheckbox">
                        <div></div> <div class="titulosEncabezado">
                            <h3>Nº Identificativo</h3>
                            <h3>Propietario</h3>
                            <h3>Fecha</h3>
                        </div>
                    </div>
                </div>
                
                <div class="cuerpoTablaReubicar">
                <?php
                    if (is_array($arrayProductosUnitarios)) {
                        foreach ($arrayProductosUnitarios as $valor) {
                            echo "<div class='filaProductoReubicar'>";
                                echo "<div class='columnsWithCheckbox'>";
                                    echo "<input type='checkbox' name='productoUnitarioIds[]' value='{$valor['idProductoUnitario']}' class='checkboxProducto'>";
                                    echo "<div class='contenidoProductoReubicar'>";
                                        echo "<p><strong>" . htmlspecialchars($valor['numeroIdentificativo']) . "</strong></p>";
                                        echo "<p>" . ($valor['propietarioProducto'] ? htmlspecialchars($valor['propietarioProducto']) : "<span class='sin-asignar'>— Sin asignar —</span>") . "</p>";
                                        echo "<p>" . htmlspecialchars($valor['fechaActualizacion']) . "</p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='error-mensaje'>" . $arrayProductosUnitarios . "</div>";
                    }
                ?>
                </div>
            </div>
        </div>

        <div class="panelControlesReubicar">
            <div class="cabeceraControles">
                <h3>Destino</h3>
            </div>
            
            <div class="selectoresReubicar">
                <div class="grupoSelector">
                    <label for="localizaciones">Localización:</label>
                    <select id="localizaciones" class="selectorLocalizaciones" name="localizacion" required>
                        <?php
                            foreach ($arrayNombresLocalizaciones as $valor) {
                                $selected = ($arrayDatosProducto['idLocalizacion'] == $valor['idLocalizacion']) ? 'selected' : '';
                                echo "<option value='" . $valor["idLocalizacion"] . "' $selected>" . htmlspecialchars($valor["nombreLocalizacion"]) . "</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <div class="grupoSelector" id="contenedorAulas">
                    <label for="selectAula">Aula:</label>
                    <select id="selectAula" name="idAula" required>
                        <?php
                            foreach ($arrayAulas as $valor) {
                                $selected = ($arrayDatosProducto['idAula'] == $valor['idAula']) ? 'selected' : '';
                                echo "<option value='" . $valor["idAula"] . "' $selected>" . htmlspecialchars($valor["nombreAula"]) . "</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <button type="submit" name="reubicar" class="btnReubicarProductos">
                    Reubicar Seleccionados
                </button>
            </div>
        </div>
        
    </section>
</form>

<?php
    if (isset($resultado)) {
        echo "<div class='alerta-notificacion'>" . $resultado . "</div>";
    }       
?>
</main>