<style>
    /* Reglas para la PANTALLA del ordenador (lo que ve el usuario) */
    @media screen {
        #zona-imprimir-qrs { 
            display: none; /* Ocultamos los QRs para mantener la interfaz limpia */
        } 
    }
    
    /* Reglas para la IMPRESORA (lo que sale en el papel) */
    @media print {
        body * { 
            visibility: hidden; /* Ocultamos la web entera (botones, menús, tablas...) */
        } 
        #zona-imprimir-qrs, #zona-imprimir-qrs * { 
            visibility: visible; /* Resucitamos única y exclusivamente la caja de QRs */
        } 
        #zona-imprimir-qrs {
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%;
            display: flex; /* Usamos Flexbox para poner las pegatinas en fila */
            flex-wrap: wrap; /* Si la fila se llena, bajan a la siguiente (como texto normal) */
            gap: 20px; /* Separación entre pegatinas para poder meter la tijera */
        }
        .etiqueta-qr {
            text-align: center; 
            border: 1px dashed #000; /* Borde punteado estilo "recorta por aquí" */
            padding: 15px; 
            width: 150px;
        }
        .etiqueta-qr img { 
            width: 100%; 
            height: auto; 
        }
    }
</style>

<main>
    
    <?php
        if(isset($arrayNombreProductoAulaLocalizacion)){
            echo "<h2 class='tituloAlmacenar'> Imprimir QRs de " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreProducto']) . " del " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreLocalizacion']) . " - " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreAula']) . "</h2>";
        }else{
            echo "<h2 class='tituloAlmacenar'> Imprimir QRs</h2>";
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
                    // Comprobamos que llegaron productos desde la base de datos
                    if(is_array($arrayProductosUnitarios)) {
                        echo "<div id='listaProductosAlmacenar'class='cuerpoTablaReubicar'>"; 
                        
                        foreach($arrayProductosUnitarios AS $valor) {
                            echo "<div class='filaProductoAlmacenar'>";
                                echo "<div class='columnasConCheckboxAlmacenar'>";
                                    // ¡Clave! El value del checkbox es el ID real del producto. 
                                    // Al ser name='productoUnitarioIds[]', PHP lo recibirá como un array en el POST
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
                        // Mensaje si el aula está vacía
                        echo "<p class='mensajeVacio'>" . $arrayProductosUnitarios . "</p>";
                    }
                ?>
            </div>
        </section>
        
        <input type="submit" name="imprimir" value="Imprimir QRs" class="botonAlmacenar">
    </form>

    <div id="zona-imprimir-qrs">
        <?php if(!empty($arrayQRsGenerados)): ?>
            <?php foreach($arrayQRsGenerados as $id => $imagenQR): ?>
                <div class="etiqueta-qr">
                    <strong>Nº ID: <?= htmlspecialchars($id) ?></strong>
                    <br>
                    <img src="<?= $imagenQR ?>" alt="QR Producto <?= htmlspecialchars($id) ?>">
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php if(!empty($arrayQRsGenerados)): ?>
    <script>
        // Le decimos al navegador: "Cuando hayas terminado de cargar todas las imágenes Base64, abre el menú de imprimir".
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
<?php endif; ?>