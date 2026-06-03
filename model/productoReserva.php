<?php
    require_once "conexionDB.php";
    require_once "products.php";

   class ProductoReserva {

       public static function cargarTablaProductosReserva() {

            $conexionDB = ConexionDB::conectar();
            
            // MODIFICADO: Añadimos un JOIN para traernos también el nombreTipo
            $consultaTablaProductosReserva = $conexionDB->prepare("
                SELECT pr.idProductoReserva, pr.nombreProductoReserva, pr.stockReserva, t.nombreTipo 
                FROM productoreserva pr
                LEFT JOIN tipos t ON pr.FK_tipo = t.idTipo
            ");
            $consultaTablaProductosReserva->execute();

            if($consultaTablaProductosReserva->rowCount() > 0) {

                $arrayConsultaTablaProductosReserva = array();

                while ($fila = $consultaTablaProductosReserva->fetch(PDO::FETCH_ASSOC)) {
                    array_push($arrayConsultaTablaProductosReserva, [
                        "nombreProductoReserva" => $fila['nombreProductoReserva'],
                        "stockReserva" => $fila['stockReserva'],
                        "idProductoReserva" => $fila['idProductoReserva'],
                        // AÑADIDO: Guardamos el nombre del tipo en el array (con un salvavidas por si hay alguno antiguo sin tipo)
                        "nombreTipo" => $fila['nombreTipo'] ?? 'Sin asignar' 
                    ]);            
                }

                $conexionDB = null;
                return $arrayConsultaTablaProductosReserva;

            } else {
                $conexionDB = null;
                return "HAY 0 PRODUCTOS DE RESERVA REGISTRADOS";
            }
       }

        public static function addProductoReserva(string $nombreProductoReserva, int $stockReserva, int $idTipo) {

            $conexionDB = ConexionDB::conectar(); 

            $consultaComprobacionExistenciaProductoReserva = $conexionDB->prepare("SELECT * FROM productoreserva WHERE nombreProductoReserva=?");
            $consultaComprobacionExistenciaProductoReserva->execute([$nombreProductoReserva]);
            
            if($consultaComprobacionExistenciaProductoReserva->rowCount() > 0) {
                $conexionDB = null;
                return "NO SE HA PODIDO AÑADIR PORQUE YA EXISTE UN PRODUCTO DE RESERVA CON ESE NOMBRE EN LA BASE DE DATOS.";
            } else {

                $consultaInsert = $conexionDB->prepare("INSERT INTO productoreserva(nombreProductoReserva, stockReserva, FK_tipo) VALUES (?, ?, ?)");
                $consultaInsert->execute([$nombreProductoReserva, $stockReserva, $idTipo]);

                $conexionDB = null;
                return "SE HA AÑADIDO EL PRODUCTO DE RESERVA.";
            }
        }

        public static function editarProductoReserva(int $idProductoReserva, string $nombreProductoReserva, int $stockReserva, int $idTipo) {

            $conexionDB = ConexionDB::conectar();

            $consultaObtenerIdProducto = $conexionDB->prepare("SELECT idProductoReserva FROM productoreserva WHERE idProductoReserva=?");
            $consultaObtenerIdProducto->execute([$idProductoReserva]);
            
            $arrayIdProducto = $consultaObtenerIdProducto->fetch(PDO::FETCH_ASSOC);

            if (!$arrayIdProducto) {
                $conexionDB = null;
                return "El producto de reserva no existe";
            }   

            $consultaComprobacionExistenciaProductoReserva = $conexionDB->prepare("SELECT * FROM productoreserva WHERE nombreProductoReserva=? AND idProductoReserva!=?");
            $consultaComprobacionExistenciaProductoReserva->execute([$nombreProductoReserva, $idProductoReserva]);

            if($consultaComprobacionExistenciaProductoReserva->rowCount() > 0) {

                $conexionDB = null;
                return "NO SE HA PODIDO MODIFICAR PORQUE YA EXISTE UN PRODUCTO DE RESERVA CON ESE NOMBRE EN LA BASE DE DATOS.";

            } else {
                
                // ====================================================================
                // TRANSACCIÓN AÑADIDA: Hacemos 2 UPDATE en distintas tablas
                // ====================================================================
                try {
                    $conexionDB->beginTransaction();

                    // MODIFICADO: Añadido FK_tipo=? a la actualización
                    $consultaUpdate = $conexionDB->prepare("UPDATE productoreserva SET nombreProductoReserva=?, stockReserva=?, FK_tipo=? WHERE idProductoReserva=?");
                    $consultaUpdate->execute([$nombreProductoReserva, $stockReserva, $idTipo, $idProductoReserva]);

                    // Se queda igual: Solo actualizamos el nombre en los productos asignados a las aulas
                    $consultaUpdateProductos = $conexionDB->prepare("UPDATE productos SET nombreProducto=? WHERE FK_productoReserva=?");
                    $consultaUpdateProductos->execute([$nombreProductoReserva, $idProductoReserva]);
                    
                    $conexionDB->commit();
                    $conexionDB = null;
                    return "Producto de reserva modificado";

                } catch (PDOException $e) {
                    $conexionDB->rollBack();
                    $conexionDB = null;
                    return "Error al modificar: " . $e->getMessage() . "";
                }
            }
        }

        public static function obtenerInfoProductoReserva(int $idProductoReserva) {

            $conexionDB = ConexionDB::conectar();

            // El SELECT * garantiza que nos traemos todas las columnas, incluyendo el nuevo FK_tipo
            $consultaObtenerInfo = $conexionDB->prepare("SELECT * FROM productoreserva WHERE idProductoReserva=?");
            $consultaObtenerInfo->execute([$idProductoReserva]);

            $registro = $consultaObtenerInfo->fetch(PDO::FETCH_ASSOC);

            if (!$registro) {
                $conexionDB = null;
                return null;
            }

            $conexionDB = null;
            return $registro;
        }

public static function asignarProductoReserva(int $idProductoReserva, int $cantidadAsignar, int $idAula, int $stockMinimo = 1){
        try {
            $conexionDB = ConexionDB::conectar(); 
            $conexionDB->beginTransaction();

            $consultaProductoReserva = $conexionDB->prepare("SELECT * FROM productoreserva WHERE idProductoReserva=?");
            $consultaProductoReserva->execute([$idProductoReserva]);
            $registroProductoReserva = $consultaProductoReserva->fetch(PDO::FETCH_ASSOC);

            if(!$registroProductoReserva){
                $conexionDB->rollBack(); 
                $conexionDB = null;
                return "El producto de reserva no existe";
            }
            
            if($registroProductoReserva['stockReserva'] < $cantidadAsignar){ 
                $conexionDB->rollBack(); 
                $conexionDB = null;
                return "No hay stock suficiente en almacén";
            }

            // Restamos el stock del almacén
            $registroProductoReserva['stockReserva'] -= $cantidadAsignar;
            $nuevoStock = $registroProductoReserva['stockReserva'];

            $updateStock = $conexionDB->prepare("UPDATE productoreserva SET stockReserva=? WHERE idProductoReserva=?");
            $updateStock->execute([$nuevoStock, $idProductoReserva]);

            // Comprobamos si el producto ya existe en ese aula
            $consultaProducto = $conexionDB->prepare("SELECT * FROM productos WHERE FK_productoReserva=? AND FK_aula=?");
            $consultaProducto->execute([$idProductoReserva, $idAula]);
            
            $registroProducto = $consultaProducto->fetch(PDO::FETCH_ASSOC);

            if($registroProducto){
                // 🚨 SI YA EXISTE: Sumamos el stock (ignoramos el stock mínimo)
                Productos::actualizarStockProducto($conexionDB, $registroProducto['idProducto'], $cantidadAsignar);
                
                $conexionDB->commit();
                $conexionDB = null;
                return "Producto asignado y stock actualizado correctamente";
            }
            else{
                // 🚨 SI ES NUEVO: Creamos el producto pasándole el $stockMinimo recogido del formulario
                $nombreProductoOriginal = $registroProductoReserva['nombreProductoReserva'];

                Productos::crearProductoDesdeReserva($conexionDB, $nombreProductoOriginal, $cantidadAsignar, $stockMinimo, $idAula, $idProductoReserva);

                $conexionDB->commit();
                $conexionDB = null;
                return "Producto creado y asignado de forma correcta";
            }

        } catch (Exception $e) {
            if (isset($conexionDB) && $conexionDB->inTransaction()) {
                $conexionDB->rollBack();
            }
            return "Error en la asignación: " . $e->getMessage();
        }
    }

        public static function agregarStockProductoReserva(int $idProductoReserva, int $cantidadAgregar){

            $conexionDB = ConexionDB::conectar();

            $consultaProductoReserva = $conexionDB->prepare("SELECT * FROM productoreserva WHERE idProductoReserva=?");
            $consultaProductoReserva->execute([$idProductoReserva]);
            $registroProductoReserva = $consultaProductoReserva->fetch(PDO::FETCH_ASSOC);
            
            if(!$registroProductoReserva){
                $conexionDB = null;
                return "El producto de reserva no existe";
            }
            else{
                $stockActual = $registroProductoReserva['stockReserva'];
                $nuevoStock = $stockActual + $cantidadAgregar;    
                $actualizarStock = $conexionDB->prepare("UPDATE productoreserva SET stockReserva=? WHERE idProductoReserva=?");
                $actualizarStock->execute([$nuevoStock, $idProductoReserva]);

                $conexionDB = null;
                return " Stock actualizado correctamente";
            }
        }

        public static function liberarProductoReserva(array $arrayIdProductosUnitarios){

            try {
                $conexionDB = ConexionDB::conectar();
                
                // ====================================================================
                // TRANSACCIÓN AÑADIDA AL BUCLE: Fundamental para proteger cambios masivos
                // ====================================================================
                $conexionDB->beginTransaction();

                foreach($arrayIdProductosUnitarios as $idProductoUnitario){
                    
                    $consulta = $conexionDB->prepare("SELECT * FROM unidadproducto WHERE idProductoUnitario=?");
                    $consulta->execute([$idProductoUnitario]);
                    $registro = $consulta->fetch(PDO::FETCH_ASSOC);

                    if(!$registro){
                        continue; 
                    }

                    $idProducto = $registro['FK_producto'];
                    $consultaProducto = $conexionDB->prepare("SELECT * FROM productos WHERE idProducto=?");
                    $consultaProducto->execute([$idProducto]);
                    $registroProducto = $consultaProducto->fetch(PDO::FETCH_ASSOC);

                    if(!$registroProducto){
                        continue; 
                    }

                    $nombreProducto = $registroProducto['nombreProducto'];

                    $updateStockAula = $conexionDB->prepare("UPDATE productos SET stockActual = stockActual - 1, fechaActualizacion = ? WHERE idProducto = ?");
                    $updateStockAula->execute([date("Y-m-d"), $idProducto]);

                    $updateReserva = $conexionDB->prepare("UPDATE productoreserva SET stockReserva = stockReserva + 1 WHERE nombreProductoReserva = ?");
                    $updateReserva->execute([$nombreProducto]);

                    $deleteUnitario = $conexionDB->prepare("DELETE FROM unidadproducto WHERE idProductoUnitario=?");
                    $deleteUnitario->execute([$idProductoUnitario]);
                }

                // Si todo el bucle termina sin errores, guardamos los cambios de golpe
                $conexionDB->commit();
                $conexionDB = null;
                return "Productos liberados correctamente";

            } catch (PDOException $e) {
                // Si salta un error a medio bucle, deshacemos todo
                if (isset($conexionDB) && $conexionDB->inTransaction()) {
                    $conexionDB->rollBack();
                }
                return "Error al liberar productos: " . $e->getMessage() . "";
            }
        }
    }
?>