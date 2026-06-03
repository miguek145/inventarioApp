
<div class=centradoTabla>
<section class=cuadroAdd>
<h2 id=tituloAdd>ADD new Product</h2>

<form action="" method="post">
    <p>
        <label for="">Producto:</label>
        <input type="text" name="nombreProducto" id="" autofocus required placeholder="Ej: Ratón" pattern="^[A-ZÑ][a-zñ]{0,14}$">
    </p>
    <p>
        <label for="">Stock mínimo:</label>
        <input type="number" name="stockMin" min="1" id="" required>
    </p>
    <p>
        <label for="">Tipo:</label>
          <select name="idTipo" id="" required>
                <?php
                    foreach ($arrayTipos as $valor) {
                        echo "<option value='" . $valor['idTipo'] . "'>" . $valor['nombreTipo'] . "</option>";
                    }
                ?>
        </select>
    </p>
    <p>
        <label for="">Localización:</label>
            <select class="selectorLocalizaciones" name="localizaciones" id="" required>
                <?php
                    foreach ($arrayNombresLocalizaciones as $valor) {
                        echo "<option value='" . $valor["idLocalizacion"] . "'>" . $valor["nombreLocalizacion"] . "</option>";
                    }
                ?>
            </select>
    </p>
    <p class="parrafoSelectorAulas">
        <label for="">Aula:</label>
        <select name="aula" required>
            <?php
                foreach ($arrayAulas as $valor) {
                    echo "<option value='".$valor["idAula"]."'>".$valor["nombreAula"]."</option>";
                }
            ?>
        </select>
    </p> 
    <p>
        <input type="submit" name="enviar" value="Enviar">
        <input type="reset" value="Reset">
    </p> 
</form>
    <?php
        if(isset($resultado)){
            echo $resultado;
        }
    ?>
</section>
</div>

