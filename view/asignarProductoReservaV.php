<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        
        <h2>Asignar <?= htmlspecialchars($nombreProductoReserva) ?> a un aula.</h2>
        
        <h2>Stock en almacén: <?= htmlspecialchars($cantidadProductoReserva) ?></h2>
        
        <?php if(isset($_GET['resultado'])): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($_GET['resultado']) ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
            
            <input type="hidden" id="idProductoReservaJS" value="<?= htmlspecialchars($idProductoReserva) ?>">
            
            <div class="input-group">
                <label for="inputCantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="inputCantidad" min="1" required placeholder="Ej: 5" autofocus>
            </div>

            <div class="input-group">
                <label for="localizaciones">Localización:</label>
                <select name="idLocalizacion" id="localizaciones" class="selectorLocalizaciones" required>
                    <?php foreach ($arrayLocalizaciones as $localizacion): ?>
                        <option value="<?= htmlspecialchars($localizacion['idLocalizacion']) ?>">
                            <?= htmlspecialchars($localizacion['nombreLocalizacion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="input-group" id="contenedorAulas">
                <label for="idAula">Aula:</label>
                <select name="idAula" id="idAula" required>
                    <?php foreach ($arrayAulas as $aula): ?>
                        <option value="<?= htmlspecialchars($aula['idAula']) ?>">
                            <?= htmlspecialchars($aula['nombreAula']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group" id="contenedorStockMinimo"></div>
            
            <div class="botonesForm">
                <input type="submit" name="asignar" value="Asignar">
            </div>
            
        </form>
    </div>
</section>
</main>
