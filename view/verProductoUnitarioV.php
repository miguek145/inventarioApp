<main>
    <div class="contenedorDatosQR">
        <h2>Datos del Producto</h2>
        <p><?php echo "Nombre: " . $datosProductoUnitario["nombreProducto"]?></p>
        <p><?php echo "Aula: " . $datosProductoUnitario["nombreAula"]?></p>
        <p><?php echo "Localización: " . $datosProductoUnitario["nombreLocalizacion"]?></p>
        <p><?php echo "Propietario: " . ($datosProductoUnitario["propietarioProducto"] ? $datosProductoUnitario["propietarioProducto"] : "— Sin asignar —")?></p>
    </div>
</main>