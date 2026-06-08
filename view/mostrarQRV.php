<main>
    <div class="contenedorqr">
        <h2>Código QR del Producto</h2>
        <?php if(isset($codigoQR)): ?>
            <div id="zona-imprimir">
            <img src="<?php echo $codigoQR; ?>" alt="QR del Producto">
            </div>
        <?php endif; ?>
        <a class="btn-imprimir" onclick="window.print()">Imprimir Código</a>
    </div>
</main>