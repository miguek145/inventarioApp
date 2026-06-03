<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Añadir Producto Unitario</h2>
        <?php if(isset($resultado)): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($resultado) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            
            <div class="input-group">
                <label for="nombrePropietario">Nombre del propietario (opcional):</label>
                <input type="text" id="nombrePropietario" name="nombrePropietario" autofocus placeholder="Ej: Juan123" title="Máximo 30 caracteres, solo letras y números." pattern="^[A-Za-z0-9ñÑ\s]{0,30}$">
            </div>
            
            <div class="botonesForm">
                <input type="submit" value="Añadir" name="add">
            </div>
            
        </form>
    </div>
</section>
</main>