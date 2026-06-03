<main>
    <section class="centradoTabla">
        <div class="cuadroAdd">
            <h2>Editar Producto (Pertenece a: <?= htmlspecialchars($arrayDatosProducto['nombreLocalizacion'] . " - " . $arrayDatosProducto['nombreAula']) ?>)</h2>
            
            <?php if(isset($_GET['resultado'])): ?>
                <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                    <?= htmlspecialchars($_GET['resultado']) ?>
                </div>
            <?php endif; ?>    
            
            <form action="" method="post">
    
                <div class="input-group">
                    <label for="stockMin">Stock mínimo:</label>
                    <input type="number" id="stockMin" name="stockMin" min="1" value="<?= htmlspecialchars($arrayDatosProducto['stockMinimo'])  ?>" required>
                </div>
    
                <div class="botonesForm">
                    <input type="submit" name="actualizar" value="Actualizar">
                </div>
    
            </form>
        </div>
    </section>
</main>