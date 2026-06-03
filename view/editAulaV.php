<script src="../view/js/aparecerSelectorAulas.js"></script>  
<main>
<section class="centradoTabla">
        <div class="cuadroAdd">
            <h2>Editar Aula</h2>
            
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
                    <label for="idAula">Aula actual:</label>
                    <select name="idAula" id="idAula" required>
                        <?php foreach ($arrayAulas as $valor): ?>
                            
                            <option value="<?= htmlspecialchars($valor['idAula']) ?>"
                                <?php if(isset($ultimaAula) && $valor['idAula'] == $ultimaAula) echo 'selected'; ?>>
                                <?= htmlspecialchars($valor['nombreAula']) ?>
                            </option>
                            
                        <?php endforeach; ?>
                    </select>
                </div> 
                
                <div class="input-group">
                    <label for="nombreAulaNuevo">Nombre aula nueva:</label>
                    <input type="text" name="nombreAulaNuevo" id="nombreAulaNuevo" placeholder="Ej: Aula 1, Oficina" required pattern="^[A-ZÑ][a-zñ]{1,15}(\s?\d{0,2})?$" title="El nombre del aula solo puede contener letras, números y espacios, y debe tener un máximo de 30 caracteres.">
                </div>
                
                <div class="botonesForm">
                    <input type="submit" name="editar" value="Editar">
                </div>
                
            </form>
        </div>
    </section>
</main>