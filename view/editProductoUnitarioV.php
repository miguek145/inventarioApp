<main>
    <section class="centradoTabla">
        <div class="cuadroAdd">
            <h2>Editar Producto Unitario:</h2>
            <?php if(isset($resultado)): ?>
                <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                    <?= htmlspecialchars($resultado) ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <p><label for="nuevoNombrePropietario">Nuevo nombre propietario:</label></p>
                <p>
                    <input 
                        type="text" 
                        name="nuevoNombrePropietario" 
                        id="nuevoNombrePropietario" 
                        autofocus 
                        placeholder="Ej: Juan Perez (Opcional)"  
                        pattern="^[A-Za-z0-9ñÑ\s]{0,30}$" 
                        title="El nombre del propietario solo puede contener letras, números y espacios, y debe tener un máximo de 30 caracteres." 
                        value="<?= htmlspecialchars($_GET['nombrePropietarioActualizado'] ?? $producto['propietarioProducto'] ?? '') ?>"
                    >
                </p>
                <p>
                    <input type="submit" value="actualizar" name="actualizar">
                </p>
            </form>
        </div>
    </section>
</main>