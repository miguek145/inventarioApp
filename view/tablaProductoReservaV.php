<h2 class="tituloTablaProductoReservas">TABLA PRODUCTOS RESERVA</h2>

<div class="toolbar-productos-reserva">
    <a class="btn-superior" href="./addProductoReservaController.php">
        + Add Producto Reserva
    </a>
    
    <div class="contenedor-buscador">
        <input type="text" id="inputBuscador" name="busquedaProductoReserva" placeholder="🔍 Buscar por nombre...">
    </div>
</div>

<section class="tablaProductosReserva">
    <div class="encabezadoTablaProductosReserva">
        <div>
            <h3>Nombre</h3>
            <h3>Tipo</h3> 
            <h3>Stock</h3>
        </div>
        <div>Acciones</div>
    </div>
    
    <div id="contenedorFilas">
        <?php
            if(is_array($arrayProductosReserva)) {
                foreach($arrayProductosReserva AS $valor) {
                    echo "<div class='filaProductoReserva'>";
                        echo "<div class='contenidoProductoReserva'>";
                            echo "<p><strong>" . htmlspecialchars($valor['nombreProductoReserva']) . "</strong></p>";
                            // AÑADIDO: Pintamos el nombre del Tipo que nos manda el Modelo
                            echo "<p>" . htmlspecialchars($valor['nombreTipo']) . "</p>";
                            echo "<p>" . htmlspecialchars($valor['stockReserva']) . "</p>";
                        echo "</div>";

                        echo "<div class='contenedorBotonesTablaProductosReserva'>";
                            echo "<a class='btn-tabla btn-asignar' href='./asignarProductoReservaController.php?idProductoReserva=".$valor['idProductoReserva']."'>Asignar</a>";
                            echo "<a class='btn-tabla btn-agregar' href='./agregarStockProductoReservaController.php?idProductoReserva=".$valor['idProductoReserva']."'>+ Stock</a>";
                            echo "<a class='btn-tabla btn-edit' href='./editProductoReservaController.php?idProductoReserva=".$valor['idProductoReserva']."'>Editar</a>";
                        echo "</div>";
                    echo "</div>";            
                }
            } else {
                echo "<div class='error-mensaje'>" . $arrayProductosReserva . "</div>";
            }
        ?>
    </div>
</section>

<?php
    if(isset($mensajeProductoEliminado)){
        echo "<div class='alerta-notificacion'>" . $mensajeProductoEliminado . "</div>";
    }
?>