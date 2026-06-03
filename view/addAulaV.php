<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Añadir Nueva Aula</h2>
        
        <?php if(isset($resultado)): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 12px; border-radius: 8px; margin-bottom: 20px; margin-top: 10px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($resultado) ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
            
            <div class="input-group">
                <label for="localizaciones">Localizaciones:</label>
                <select class="selectorLocalizaciones" name="localizaciones" id="localizaciones" autofocus required>
                    <?php foreach ($arrayNombresLocalizaciones as $valor): ?>
                        
                        <option value="<?= htmlspecialchars($valor['idLocalizacion']) ?>" 
                            <?php if(isset($ultimaLocalizacion) && $valor['idLocalizacion'] == $ultimaLocalizacion) echo 'selected'; ?>>
                            
                            <?= htmlspecialchars($valor['nombreLocalizacion']) ?>
                        </option>
                        
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="input-group">
                <label for="nombreAula">Aula:</label>
                <input type="text" name="nombreAula" id="nombreAula" required placeholder="Ej: Aula 1, Oficina" title="El nombre del aula solo puede contener letras, números y espacios, y debe tener un máximo de 30 caracteres." pattern="^[A-ZÑ][a-zñ]{1,15}(\s?\d{0,2})?$">
            </div>
            
            <div class="botonesForm">
                <input type="submit" name="añadir" value="Añadir">
            </div>
            
        </form>
    </div>
</section>
</main>