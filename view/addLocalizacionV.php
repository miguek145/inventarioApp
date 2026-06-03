<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Añadir Nueva Localización</h2>
        <?php if(isset($resultado)): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($resultado) ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            
            <div class="input-group">
                <label for="localizacion">Localización:</label>
                <input type="text" name="localizacion" id="localizacion" autofocus required placeholder="Ej: PM, EM" pattern="^[A-Z]{2}$" title="La localización debe consistir en exactamente dos letras mayúsculas. Ejemplo: PM, EM">
            </div>
            
            <div class="botonesForm">
                <input type="submit" name="añadir" value="Añadir">
            </div>
            
        </form>
    </div>
</section>
</main>

