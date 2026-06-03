<main>
<section class="centradoTabla">
    <div class="cuadroAdd">
        <h2>Añadir Nuevo Tipo</h2>
        <?php if(isset($resultado)): ?>
            <div style="background-color: rgba(0, 0, 0, 0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                <?= htmlspecialchars($resultado) ?>
            </div>
        <?php endif; ?>        
        <form action="" method="post">
            
            <div class="input-group">
                <label for="nombreTipo">Tipo:</label>
                <input type="text" name="nombreTipo" id="nombreTipo" autofocus required placeholder="Ej: informatica" pattern="^[a-zA-ZñÑ]{1,15}$" title="El nombre del tipo solo puede contener letras y debe tener un máximo de 15 caracteres.">
            </div>
            
            <div class="botonesForm">
                <input type="submit" name="añadir" value="Añadir">
            </div>
            
        </form>
    </div>
</section>
</main>