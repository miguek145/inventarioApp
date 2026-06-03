<main>
    <h3 class="indicadorUsuarioLogoneado">Nombre usuario: <?php echo $_SESSION['usuario'] ?></h3>

    <h2 class="encabezadoTablaTiposProductos">Selecciona el tipo de producto</h2>

    <section class="contenedorTablaTipos">
        <?php
            foreach ($arrayTiposProductos as $valor) {
                echo "<a class='tarjeta-tipo' href='./tablaProductoTipoController.php?idTipo=" . $valor['idTipo'] . "'>";
                echo "<span>" . mb_strtoupper($valor['nombreTipo']) . "</span>"; // mb_strtoupper los pone estéticos en mayúsculas
                echo "</a>";
            }
        ?>
    </section>
</main>