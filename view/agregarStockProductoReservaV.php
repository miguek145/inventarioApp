<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Agregar Stock a <?= htmlspecialchars($nombreProductoReserva ?? '') ?></h2>
        <h2>Stock Actual: <?= htmlspecialchars($stockActual ?? 0) ?></h2>
        <?php if(isset($_GET['resultado'])): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($_GET['resultado']) ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
             
            <div class="input-group">
                <label for="stockReserva">Cantidad a agregar:</label>
                <input type="number" id="stockReserva" name="stockReserva" min="1" required placeholder="Introduce un número" autofocus>
            </div>

            <div class="botonesForm">
                <input type="submit" name="agregarStock" value="Agregar Stock">
            </div>
        </form>
    </div>
</section>
</main>