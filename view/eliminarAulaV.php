<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Eliminar Aula</h2>
        
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
            
            <div class="input-group" id="contenedorAulas">
                <label for="idAula">Aula:</label>
                <select name="idAula" id="idAula" required>
                    <?php foreach ($arrayAulas as $valor): ?>
                        <option value="<?= htmlspecialchars($valor['idAula']) ?>">
                            <?= htmlspecialchars($valor['nombreAula']) ?>
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