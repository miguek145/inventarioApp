<main>
    <section class="centradoTabla">
        <div class="cuadroAdd">
            <h2>Elimina un tipo</h2>
            <form action="" method="post">
                <p>
                     <label for="">Tipos:</label>
                
                    <select class="selectorLocalizaciones" name="tipos" id="" autofocus required>
                        <?php
                            foreach ($datosNombresTipos as $valor) {
                                echo "<option value='" . $valor["idTipo"] . "'>" . $valor["nombreTipo"] . "</option>";
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <input type="submit" name="eliminar" value="eliminar" class="botonFormulario">
                </p>
            </form>
        </div>
    </section>
    <?php
        if(isset($_GET['resultado'])){
            echo $_GET['resultado'];
        }
    ?>
    
</main>
