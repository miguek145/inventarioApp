<?php

require_once "../../model/conexionDB.php";

$conexionDB = ConexionDB::conectar();

$consulta = $conexionDB->query("SELECT idTipo, nombreTipo FROM tipos");

if($consulta->rowCount() > 0){

    echo "<label>Tipo de producto:</label>";
    echo "<select name='idTipo' required>";

    while($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='".$fila['idTipo']."'>"
            .$fila['nombreTipo'].
        "</option>";
    }

    echo "</select>";

} else {
    echo "<p>No hay tipos registrados</p>";
}

$conexionDB = null;
?>