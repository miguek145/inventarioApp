<main>
<section class="centradoTabla">


        <div class="cuadroAdd">
            <h2>Editar Producto Reserva</h2>
            <?php if(isset($resultado)): ?>
                <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                    <?= htmlspecialchars($resultado) ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">

                <input type="hidden" name="idProductoReserva" value="<?= htmlspecialchars($producto['idProductoReserva']) ?>">
                
                <div class="input-group">
                    <label for="nombreProductoReserva">Nombre del producto:</label>
                    <input type="text" name="nombreProductoReserva" id="nombreProductoReserva" 
                           pattern="^[A-Za-z0-9ñÑ\s]{0,30}$" 
                           title="Máximo 30 caracteres." 
                           value="<?= htmlspecialchars($producto['nombreProductoReserva']) ?>" required>
                </div>

                <div class="input-group">
                    <label for="idTipo">Tipo de producto:</label>
                    <select name="idTipo" id="idTipo" required>
                        <?php foreach ($arrayTipos as $tipo): ?>
                            <option value="<?= htmlspecialchars($tipo['idTipo']) ?>" 
                                <?= (isset($producto['FK_Tipo']) && $producto['FK_Tipo'] == $tipo['idTipo']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tipo['nombreTipo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label for="stockReserva">Stock:</label>
                    <input type="number" name="stockReserva" id="stockReserva" min="1" value="<?= htmlspecialchars($producto['stockReserva']) ?>" required>
                </div>
                
                <div class="botonesForm">
                    <input type="submit" name="actualizar" value="Actualizar">
                </div>
            </form>
        </div>
    </section>
</main>