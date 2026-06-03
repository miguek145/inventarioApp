<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Eliminar Tipo</h2>
        <?php if(isset($_GET['resultado'])): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($_GET['resultado']) ?>
            </div>
        <?php endif; ?>        
        <form action="" method="post">
            
            <div class="input-group">
                <label for="tipos">Tipos:</label>
                <select class="selectorLocalizaciones" name="tipos" id="tipos" autofocus required>
                    <?php foreach ($datosNombresTipos as $valor): ?>
                        <option value="<?= htmlspecialchars($valor['idTipo']) ?>">
                            <?= htmlspecialchars($valor['nombreTipo']) ?>
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
