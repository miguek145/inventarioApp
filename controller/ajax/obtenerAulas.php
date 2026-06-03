<?php

require_once "../../model/conexionDB.php";

$conexionDB = ConexionDB::conectar();

$consulta = $conexionDB->query("SELECT idAula, nombreAula FROM aulas");

echo "<label>Aula destino:</label>";
echo "<select name='idAula' required>";

while($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
    echo "<option value='".$fila['idAula']."'>"
        .$fila['nombreAula'].
    "</option>";
}

echo "</select>";

$conexionDB = null;
?>