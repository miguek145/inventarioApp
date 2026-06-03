<?php
    require_once "../../model/conexionDB.php";

    $idProductoReserva = isset($_GET['idProductoReserva']) ? (int)$_GET['idProductoReserva'] : 0;
    $idAula = isset($_GET['idAula']) ? (int)$_GET['idAula'] : 0;

    // Si hay un error, devolvemos vacío para no romper nada
    if ($idProductoReserva <= 0 || $idAula <= 0) {
        echo ""; 
        exit;
    }

    $conexionDB = ConexionDB::conectar();

    $consulta = $conexionDB->prepare("SELECT idProducto FROM productos WHERE FK_productoReserva = ? AND FK_aula = ?");
    $consulta->execute([$idProductoReserva, $idAula]);

    if ($consulta->rowCount() > 0) {
        // ✅ EL PRODUCTO YA EXISTE: Devolvemos un string vacío
        echo "";
    } else {
        // ❌ EL PRODUCTO ES NUEVO: Le inyectamos el HTML con el input (y le ponemos el 'required' directamente aquí)
        echo '<label for="stockMinimo">Stock Mínimo (Nuevo en aula):</label>';
        echo '<input type="number" name="stockMinimo" id="stockMinimo" min="1" required placeholder="Ej: 1">';
    }

    $conexionDB = null;
?>