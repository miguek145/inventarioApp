<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Eliminar Localización</h2>
         <?php if(isset($resultado)): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($resultado) ?>
            </div>
        <?php endif; ?>       
        <form action="" method="post">
            
            <div class="input-group">
                <label for="localizaciones">Localizaciones:</label>
                <select class="selectorLocalizaciones" name="localizaciones" id="localizaciones" autofocus required>
                    <?php foreach ($datosNombresLocalizaciones as $valor): ?>
                        <option value="<?= htmlspecialchars($valor['idLocalizacion']) ?>">
                            <?= htmlspecialchars($valor['nombreLocalizacion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="botonesForm">
                <input type="submit" name="eliminar" value="Eliminar">
            </div>
            
        </form>
    </div>
</section>
</main>
