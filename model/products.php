<?php

    require_once "conexionDB.php";

   class Productos{

        public static function mostrarProductos(int $idTipo){

            $conexionDB=ConexionDB::conectar();

            // 1. MODIFICACIÓN: El INNER JOIN ahora usa 'productoreserva' para encontrar el FK_tipo
            $consultaDatosProductos=$conexionDB->prepare("SELECT *
                                                        FROM productos p
                                                        INNER JOIN aulas a
                                                        ON p.FK_aula=a.idAula
                                                        INNER JOIN localizaciones l
                                                        ON a.FK_localizacion=l.idLocalizacion
                                                        INNER JOIN productoreserva pr 
                                                        ON p.FK_productoReserva=pr.idProductoReserva
                                                        INNER JOIN tipos t
                                                        ON t.idTipo=pr.FK_tipo 
                                                        WHERE pr.FK_tipo=?");
            // 2. Ejecutada con el dato
            $consultaDatosProductos->execute([$idTipo]);

            if($consultaDatosProductos->rowCount()>0){

                $arrayProductos=array();

                while($fila=$consultaDatosProductos->fetch(PDO::FETCH_ASSOC)){
                    array_push($arrayProductos,["idProducto"=>$fila['idProducto'],"nombreProducto"=>$fila['nombreProducto'],"fechaActualizacion"=>$fila['fechaActualizacion'],"stockMinimo"=>$fila['stockMinimo'],"stockActual"=>$fila['stockActual'],"nombreTipo"=>$fila['nombreTipo'],"nombreLocalizacion"=>$fila['nombreLocalizacion'],"nombreAula"=>$fila['nombreAula'],"idAula"=>$fila['idAula']]);
                }

                $conexionDB = null;
                return $arrayProductos;
            }else{
                $conexionDB = null;
                return "HAY 0 PRODUCTOS";
            }

        }

        public static function editarProducto(int $idProducto, int $stockMinNuevo, string $fechaActualNueva){

            $conexionDB=ConexionDB::conectar();
          
            // editamos el producto nuevo (Preparada)
            $sql = "UPDATE productos SET fechaActualizacion = ?, stockMinimo = ? WHERE idProducto = ?";
            
            $consultaUpdate = $conexionDB->prepare($sql);
            $consultaUpdate->execute([$fechaActualNueva, $stockMinNuevo,$idProducto]);

            $conexionDB = null;
            return "Producto modificado correctamente.";
            
        }
        
        public static function eliminarProducto(int $idProducto){
            try {
                $conexionDB = ConexionDB::conectar();
                
                // 1. Iniciamos la transacción
                $conexionDB->beginTransaction();

                // 2. Obtenemos el stock actual del producto en el aula y su relación con el almacén
                $consultaInfo = $conexionDB->prepare("SELECT stockActual, FK_productoReserva FROM productos WHERE idProducto = ?");
                $consultaInfo->execute([$idProducto]);
                $producto = $consultaInfo->fetch(PDO::FETCH_ASSOC);

                if (!$producto) {
                    $conexionDB->rollBack();
                    $conexionDB = null;
                    return "El producto no existe.";
                }

                $cantidadADevolver = (int)$producto['stockActual'];
                $idProductoReserva = $producto['FK_productoReserva'];

                // 3. Devolvemos el stock al almacén (si tiene stock y está asociado a una reserva)
                if ($cantidadADevolver > 0 && $idProductoReserva !== null) {
                    $updateAlmacen = $conexionDB->prepare("UPDATE productoreserva SET stockReserva = stockReserva + ? WHERE idProductoReserva = ?");
                    $updateAlmacen->execute([$cantidadADevolver, $idProductoReserva]);
                }

                // 4. Eliminamos el producto padre (MySQL borrará las unidades hijas automáticamente por el CASCADE)
                $consultaDeleteProducto = $conexionDB->prepare("DELETE FROM productos WHERE idProducto = ?");
                $consultaDeleteProducto->execute([$idProducto]);
            
                // Confirmamos los cambios
                $conexionDB->commit();
                $conexionDB = null;
                return "Producto eliminado y unidades devueltas al almacén correctamente.";

            } catch (PDOException $e) {
                if (isset($conexionDB) && $conexionDB->inTransaction()) {
                    $conexionDB->rollBack();
                }
                return "Error al eliminar el producto: " . $e->getMessage();
            }
        }

        public static function cargarInfoFormEditProducto(int $idProducto){

            $conexionDB = ConexionDB::conectar();

            // 2. MODIFICACIÓN: El INNER JOIN ahora usa 'productoreserva' para encontrar el FK_tipo
            $consultaDatosProducto=$conexionDB->prepare("SELECT *
                                                        FROM productos p
                                                        INNER JOIN aulas a
                                                        ON p.FK_aula=a.idAula
                                                        INNER JOIN localizaciones l
                                                        ON a.FK_localizacion=l.idLocalizacion
                                                        INNER JOIN productoreserva pr 
                                                        ON p.FK_productoReserva=pr.idProductoReserva
                                                        INNER JOIN tipos t
                                                        ON t.idTipo=pr.FK_tipo 
                                                        WHERE p.idProducto=?");
            
            $consultaDatosProducto->execute([$idProducto]);
        
            $arrayDatosProducto=$consultaDatosProducto->fetch(PDO::FETCH_ASSOC);
            
            $conexionDB = null;
            return  $arrayDatosProducto;
        }

        public static function comprobarProducto(string $nombreProducto, int $idAula){
            $conexionDB = ConexionDB::conectar();

            $consultaComprobacionProducto = $conexionDB->prepare("SELECT idProducto FROM productos WHERE FK_aula=? AND nombreProducto=?");
            $consultaComprobacionProducto->execute([$idAula, $nombreProducto]);
            
            $registro = $consultaComprobacionProducto->fetch(PDO::FETCH_ASSOC);

            if(!$registro){
                $conexionDB = null;
                return null;
            } else {
                $conexionDB = null;
                return $registro['idProducto'];
            }
        }

        /*Estas 2 ultimas funciones se han creado para el proceso de creación de un producto a partir de una reserva, ya que el proceso es algo más complejo que el de creación normal,
         porque hay que crear el producto padre y luego cada unidad individual del producto, dependiendo de la cantidad que se haya indicado en la reserva. Además, al ser un proceso específico para crear un producto a partir de una reserva,
        se ha decidido crear estas funciones dentro del modelo Productos, aunque también podrían haberse creado en un modelo específico para las reservas.*/
        
        // 3. MODIFICACIÓN: Borrado el parámetro $idTipo de los argumentos de la función
        public static function crearProductoDesdeReserva($conexionDB , string $nombreProducto, int $stockActual, int $stockMinimo, int $idAula, int $idProductoReserva){

            // 4. MODIFICACIÓN: Borrado FK_tipo y $idTipo de la sentencia INSERT
            $consultainsertar = $conexionDB->prepare("INSERT INTO productos (nombreProducto, stockActual, stockMinimo, FK_aula, FK_productoReserva, fechaActualizacion) VALUES (?, ?, ?, ?, ?, ?)");
            $consultainsertar->execute([$nombreProducto, $stockActual, $stockMinimo, $idAula, $idProductoReserva, date('Y-m-d')]);

            // Obtenemos el ID del producto recién creado
            $idProducto = $conexionDB->lastInsertId();

            // Guardamos una copia de la cantidad original para el bucle, ya que vamos a ir restando $stockActual
            $contadorIdentificadorProductoUnitario = 1;
            $fechaHoy = date('Y-m-d');

            // 2. Bucle para crear dinámicamente cada unidad individual
            while($stockActual > 0){
                // CORREGIDO: Tabla 'unidadproducto', columna 'numeroIdentificativo' y añadida 'fechaActualizacion'
                $consultainsertarProductosUnitarios = $conexionDB->prepare("INSERT INTO unidadproducto (FK_producto, numeroIdentificativo, fechaActualizacion) VALUES (?, ?, ?)");
                $consultainsertarProductosUnitarios->execute([$idProducto, $contadorIdentificadorProductoUnitario, $fechaHoy]);
                
                $contadorIdentificadorProductoUnitario++;
                $stockActual--;
            }

            return "Producto creado correctamente desde la reserva.";
        }

        public static function actualizarStockProducto($conexionDB, int $idProducto, int $cantidadAsignar){
                    
            // 1. Actualizamos el stock general del producto padre y su fecha de actualización
            $consultaActualizarStock = $conexionDB->prepare("UPDATE productos SET stockActual = stockActual + ?, fechaActualizacion = ? WHERE idProducto = ?");
            $consultaActualizarStock->execute([$cantidadAsignar, date('Y-m-d'), $idProducto]);

            // 2. Obtenemos el numeroIdentificativo más alto existente para este producto
            $consultaIdentificadorUnico = $conexionDB->prepare("SELECT MAX(numeroIdentificativo) AS maxIdentificador FROM unidadproducto WHERE FK_producto = ?");
            $consultaIdentificadorUnico->execute([$idProducto]);

            $registro = $consultaIdentificadorUnico->fetch(PDO::FETCH_ASSOC);
            
            // Si no encuentra nada (devuelve NULL), lo inicializamos en 0 para empezar desde el 1
            $identificadorUnico = $registro['maxIdentificador'] ? $registro['maxIdentificador'] : 0;
            
            $fechaHoy = date('Y-m-d');

            // 3. Bucle para insertar las nuevas unidades partiendo del último identificador
            while($cantidadAsignar > 0){
                $identificadorUnico++;
            
                // CORREGIDO: Añadido el campo obligatorio 'fechaActualizacion'
                $consultainsertarProductosUnitarios = $conexionDB->prepare("INSERT INTO unidadproducto (FK_producto, numeroIdentificativo, fechaActualizacion) VALUES (?, ?, ?)
                ");
                $consultainsertarProductosUnitarios->execute([$idProducto, $identificadorUnico, $fechaHoy]);
                
                $cantidadAsignar--;
            }
            
            return "Stock del producto actualizado correctamente.";
        }
    }
   