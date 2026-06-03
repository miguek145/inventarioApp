<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Editar Localización</h2>
        
        <?php if(isset($_GET['resultado'])): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 12px; border-radius: 8px; margin-bottom: 20px; margin-top: 10px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($_GET['resultado']) ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
            
            <div class="input-group">
                <label for="localizaciones">Localizaciones:</label>
                <select class="selectorLocalizaciones" name="localizaciones" id="localizaciones" autofocus required>
                    <?php foreach ($datosNombresLocalizaciones as $valor): ?>
                        
                        <option value="<?= htmlspecialchars($valor['idLocalizacion']) ?>"
                            <?php if(isset($ultimaLocalizacion) && $valor['idLocalizacion'] == $ultimaLocalizacion) echo 'selected'; ?>>
                            <?= htmlspecialchars($valor['nombreLocalizacion']) ?>
                        </option>
                        
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="input-group">
                <label for="nombreLocalizacionNuevo">Nuevo nombre localización:</label>
                <input type="text" name="nombreLocalizacionNuevo" id="nombreLocalizacionNuevo" required placeholder="Ej: PM, ES" pattern="^[A-Z]{2}$" title="La localización debe consistir en exactamente dos letras mayúsculas. Ejemplo: PM, EM">
            </div>
            
            <div class="botonesForm">
                <input type="submit" name="editar" value="Editar">
            </div>
            
        </form>
    </div>
</section>
</main>