<?php
    if(isset($arrayNombreProductoAulaLocalizacion)){
        echo "<h2 class='tituloTablaProductosUnitarios'>Tabla de " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreProducto']) . " del " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreLocalizacion']) . " - " . htmlspecialchars($arrayNombreProductoAulaLocalizacion['nombreAula']) . "</h2>";
    }else{
        echo "<h2 class='tituloTablaProductosUnitarios'>Tabla de productos</h2>";
    }
?>
<div class="contenedor-acciones-superiores">
    <a class="btn-superior" href="./addProductoUnitarioController.php?idProducto=<?php echo $_GET['idProducto']; ?>">
        Add Producto
    </a>
    <a class="btn-superior" href="./reubicarProductoUnitarioController.php?idProducto=<?php echo $_GET['idProducto']; ?>">
        Reubicar
    </a>
    <a class="btn-superior btn-almacenar" href="almacenarProductoUnitarioController.php?idProducto=<?php echo $_GET['idProducto'];?>">
        Almacenar
    </a>
</div>

<section class="tablaProductosUnitarios">
    <div class="encabezadoTablaProductosUnitarios">
        <div>
            <h3>Nº identificativo</h3>
            <h3>Propietario</h3>
            <h3>Fecha</h3>
        </div>
        <div>Acciones</div>
    </div>
    
    <?php
        if(is_array($arrayProductosUnitarios)) {
            foreach($arrayProductosUnitarios AS $valor) {
                echo "<div class='filaProductoUnitario'>";
                    echo "<div class='contenidoProductoUnitario'>";
                        echo "<p><strong>" . $valor['numeroIdentificativo'] . "</strong></p>";
                        // Si el propietario viene como null o vacío, imprimimos un guion elegante
                        echo "<p>" . ($valor['propietarioProducto'] ? $valor['propietarioProducto'] : "<span class='sin-asignar'>— Sin asignar —</span>") . "</p>";
                        echo "<p>" . $valor['fechaActualizacion'] . "</p>";
                    echo "</div>";
                    echo "<div class='contenedorBotonesTablaProductosUnitarios'>";
                        echo "<a class='btn-tabla btn-edit' href='./editProductoUnitarioController.php?idProductoUnitario={$valor['idProductoUnitario']}&idProducto={$_GET['idProducto']}'>EDIT</a>";
                        echo "<a class='btn-tabla btn-delete' href='./eliminarProductoUnitarioController.php?idProductoUnitario={$valor['idProductoUnitario']}&idProducto={$_GET['idProducto']}'>ELIMINAR</a>";
                    echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='error-mensaje'>" . $arrayProductosUnitarios . "</div>";
        }
    ?>
</section>

<?php
    if(isset($mensajeProductoEliminado)){
        echo "<div class='alerta-notificacion'>" . $mensajeProductoEliminado . "</div>";
    }
?>