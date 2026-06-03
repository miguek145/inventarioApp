<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        
        <h2>Añadir Nuevo Producto</h2>       
        
        <?php if(isset($_GET['resultado'])): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($_GET['resultado']) ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="POST">
            
            <div class="input-group">
                <label for="nombreProductoReserva">Nombre del producto:</label>
                <input type="text" id="nombreProductoReserva" name="nombreProductoReserva" autofocus placeholder="Ej: Portátil" pattern="^[A-Za-z0-9ñÑ\s]{1,20}$" required>
            </div>
            
            <div class="input-group">
                <label for="idTipo">Tipo de producto:</label>
                <select name="idTipo" id="idTipo" required>
                    <?php foreach ($arrayTipos as $tipo): ?>
                        <option value="<?= htmlspecialchars($tipo['idTipo']) ?>"
                            <?php if(isset($ultimoTipo) && $tipo['idTipo'] == $ultimoTipo) echo 'selected'; ?>>
                            <?= htmlspecialchars($tipo['nombreTipo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="input-group">
                <label for="stockReserva">Stock:</label>
                <input type="number" id="stockReserva" name="stockReserva" placeholder="Ej: 5" min="1" required>
            </div>
            
            <div class="botonesForm">
                <input type="submit" value="Agregar" name="add">
            </div>        
        </form>
    </div>
</section>
</main>