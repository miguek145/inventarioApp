<?php

require_once "../../model/conexionDB.php";

$conexionDB = ConexionDB::conectar();

$consulta = $conexionDB->query("SELECT idProductoReserva, nombreProductoReserva FROM productoreserva");

if($consulta->rowCount() > 0){

    echo "<label>Producto de reserva:</label>";
    echo "<select name='idProductoReserva' required>";

    while($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='".$fila['idProductoReserva']."'>"
            .$fila['nombreProductoReserva'].
        "</option>";
    }

    echo "</select>";

} else {
    echo "<p>No hay productos de reserva</p>";
}

$conexionDB = null;
?>