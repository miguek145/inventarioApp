<?php

require_once "../../model/conexionDB.php";

$conexionDB = ConexionDB::conectar();

$consulta = $conexionDB->query("SELECT idLocalizacion, nombreLocalizacion FROM localizaciones");

if($consulta->rowCount() > 0){
    echo "<label>Localización:</label>";
    echo "<select name='localizacion' required>";

    while($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='" .$fila['idLocalizacion']."'>"
            .$fila['nombreLocalizacion'].
            "</option>";
    }

    echo "</select>";
} else {
    echo "<p>No hay localizaciones registradas</p>";
}

$conexionDB = null;
?>