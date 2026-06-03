<?php
    require_once "conexionDB.php";

   class ProductoUnitario{

        public static function cargarTablaProductosUnitarios(int $idProducto) {

            $conexionDB=ConexionDB::conectar();
            
            //Consulta preparada para obtener toda la tabla de productos unitarios
            $consultaTablaProductosUnitarios=$conexionDB->prepare("SELECT * FROM unidadProducto WHERE FK_producto=?");
            $consultaTablaProductosUnitarios->execute([$idProducto]);

            //Comprobación si hay productos en ese aula
            if($consultaTablaProductosUnitarios->rowCount()>0) {

                $arrayConsultaTablaProductosUnitaros=array();

                while ($fila=$consultaTablaProductosUnitarios->fetch(PDO::FETCH_ASSOC)) {
                    
                    array_push($arrayConsultaTablaProductosUnitaros, ["propietarioProducto" => $fila['propietarioProducto'],"fechaActualizacion" => $fila['fechaActualizacion'],"numeroIdentificativo" => $fila['numeroIdentificativo'],"idProductoUnitario"=>$fila['idProductoUnitario']]);            
            
                }

                $conexionDB = null;
                return $arrayConsultaTablaProductosUnitaros;
        
            }else {
                $conexionDB = null;
                return "HAY 0 PRODUCTOS REGISTRADOS EN ESTA AULA";
            }
        }

        public static function addProductoUnitario(int $idProducto, ?string $nombrePropietario, string $fechaActualizacion) {

            // =========================================================================
            // FILTRO DE SEGURIDAD: Si llega un texto vacío o puros espacios, lo pasamos a null
            // =========================================================================
            if (trim((string)$nombrePropietario) === "") {
                $nombrePropietario = null;
            }

            try {
                $conexionDB = ConexionDB::conectar(); 
                
                // 1. Iniciamos la transacción (si algo falla, no se guarda nada a medias)
                $conexionDB->beginTransaction();

                // 2. COMPROBACIÓN DE DUPLICADOS (Solo si el nombre NO es nulo)
                if ($nombrePropietario !== null) {
                    $consultaComprobacionExistencial = $conexionDB->prepare("SELECT idProductoUnitario FROM unidadproducto WHERE FK_producto=? AND propietarioProducto=?");
                    $consultaComprobacionExistencial->execute([$idProducto, $nombrePropietario]);
                    
                    if($consultaComprobacionExistencial->rowCount() > 0) {
                        // Si es duplicado, revertimos y avisamos
                        $conexionDB->rollBack();
                        $conexionDB = null;
                        return "NO SE HA PODIDO AÑADIR PORQUE YA EXISTE UN PROPIETARIO CON EL MISMO PRODUCTO EN LA BASE DE DATOS.";
                    }
                }

                // 3. OBTENEMOS EL NÚMERO MÁXIMO IDENTIFICATIVO
                // Nota: SELECT MAX siempre devuelve 1 fila, usamos el operador ternario
                $consultaContarNumero = $conexionDB->prepare("SELECT MAX(numeroIdentificativo) AS maximo FROM unidadproducto WHERE FK_producto=?");
                $consultaContarNumero->execute([$idProducto]);
                
                $arrayNumeroProductoMayor = $consultaContarNumero->fetch(PDO::FETCH_ASSOC);
                $numeroIdentificadorProductoUnitario = ($arrayNumeroProductoMayor['maximo'] ? $arrayNumeroProductoMayor['maximo'] : 0) + 1;

                // 4. ACTUALIZAMOS EL STOCK DEL PRODUCTO PADRE
                $consultaStockActual = $conexionDB->prepare("SELECT stockActual FROM productos WHERE idProducto = ?");
                $consultaStockActual->execute([$idProducto]);
                $arrayStock = $consultaStockActual->fetch(PDO::FETCH_ASSOC);

                $stockActualActualizado = $arrayStock['stockActual'] + 1;
                
                $consultaModificarStockActual = $conexionDB->prepare("UPDATE productos SET stockActual=? WHERE idProducto = ?");
                $consultaModificarStockActual->execute([$stockActualActualizado, $idProducto]);

                // 5. INSERTAMOS EL PRODUCTO UNITARIO
                // Al pasarle $nombrePropietario (que ahora es null seguro), PDO insertará un auténtico NULL en MySQL
                $consultaInsert = $conexionDB->prepare("INSERT INTO unidadproducto (numeroIdentificativo, propietarioProducto, fechaActualizacion, FK_producto) VALUES (?, ?, ?, ?)");
                $consultaInsert->execute([$numeroIdentificadorProductoUnitario, $nombrePropietario, $fechaActualizacion, $idProducto]);

                // 6. Si todo ha ido bien, confirmamos los cambios en la BD
                $conexionDB->commit();
                $conexionDB = null;
                
                return "SE HA AÑADIDO EL PRODUCTO UNITARIO CORRECTAMENTE.";

            } catch (PDOException $e) {
                // Si hay algún fallo de SQL, revertimos
                if (isset($conexionDB)) {
                    $conexionDB->rollBack();
                }
                return "Error en la base de datos al añadir: " . $e->getMessage() . "";
            }
        }

        public static function eliminarProductoUnitario(int $idProductoUnitario){
                    
            $conexionDB = ConexionDB::conectar(); 

            // 1. CORRECCIÓN: Cambiamos productoUnitario por unidadproducto
            $consulta = $conexionDB->prepare("SELECT idProductoUnitario, FK_producto FROM unidadproducto WHERE idProductoUnitario = ?");
            $consulta->execute([$idProductoUnitario]);

            $registro = $consulta->fetch(PDO::FETCH_ASSOC);

            if (!$registro) {
                $conexionDB = null;
                return "El producto unitario no existe";
            }

            // Consulta para obtener el stock actual del producto general
            $consultaStockActual = $conexionDB->prepare("SELECT stockActual FROM productos WHERE idProducto = ?");
            $consultaStockActual->execute([$registro['FK_producto']]);
            
            $arrayStock = $consultaStockActual->fetch(PDO::FETCH_ASSOC);

            // Verificamos que el stock sea mayor a 0
            if($arrayStock['stockActual'] > 0){
                
                $stockActualActualizado = $arrayStock['stockActual'] - 1;
                
                $consultaModificarSotckActual = $conexionDB->prepare("UPDATE productos SET stockActual=? WHERE idProducto = ?");
                $consultaModificarSotckActual->execute([$stockActualActualizado, $registro['FK_producto']]);

            }

            // 2. CORRECCIÓN: Cambiamos productoUnitario por unidadproducto
            $consultaDelete = $conexionDB->prepare("DELETE FROM unidadproducto WHERE idProductoUnitario=?");
            $consultaDelete->execute([$idProductoUnitario]);

            $conexionDB = null;
            return "El producto unitario ha sido eliminado";
        }

        public static function editarProductoUnitario(int $idProductoUnitario, ?string $nombrePropietario, string $fechaActualizacion) {

            // =========================================================================
            // FILTRO DE SEGURIDAD: Si llega vacío o puros espacios, lo convertimos a null
            // =========================================================================
            if (trim((string)$nombrePropietario) === "") {
                $nombrePropietario = null;
            }

            try {
                $conexionDB = ConexionDB::conectar();

                // 1. Obtenemos el id del producto padre (FK_producto) usando 'unidadproducto'
                $consultaObtenerIdProducto = $conexionDB->prepare("SELECT FK_producto FROM unidadproducto WHERE idProductoUnitario = ?");
                $consultaObtenerIdProducto->execute([$idProductoUnitario]);
                
                $arrayIdProducto = $consultaObtenerIdProducto->fetch(PDO::FETCH_ASSOC);

                if (!$arrayIdProducto) {
                    $conexionDB = null;
                    return "El producto unitario no existe.";
                }   

                $idProducto = $arrayIdProducto['FK_producto'];
                
                // 2. COMPROBACIÓN DE DUPLICADOS (Solo se hace si el propietario NO es nulo)
                if ($nombrePropietario !== null) {
                    $consultaComprobacionExistencial = $conexionDB->prepare("SELECT idProductoUnitario FROM unidadproducto WHERE FK_producto = ? AND propietarioProducto = ? AND idProductoUnitario != ?");
                    $consultaComprobacionExistencial->execute([$idProducto, $nombrePropietario, $idProductoUnitario]);

                    if ($consultaComprobacionExistencial->rowCount() > 0) {
                        $conexionDB = null;
                        return "NO SE HA PODIDO MODIFICAR PORQUE YA EXISTE UN PROPIETARIO CON EL MISMO PRODUCTO EN LA BASE DE DATOS.";
                    }
                }

                // 3. ACTUALIZACIÓN (Si pasó los filtros o es NULL, actualiza los datos)
                $consultaUpdate = $conexionDB->prepare("UPDATE unidadproducto SET propietarioProducto = ?, fechaActualizacion = ? WHERE idProductoUnitario = ?");
                $consultaUpdate->execute([$nombrePropietario, $fechaActualizacion, $idProductoUnitario]);

                $conexionDB = null;
                return "Producto unitario modificado correctamente.";

            } catch (PDOException $e) {
                if (isset($conexionDB)) {
                    $conexionDB = null;
                }
                return "Error en la base de datos al editar: " . $e->getMessage() . "";
            }
        }
        
        public static function reubicarProductoUnitario(array $arrayIdProductosUnitarios, int $idAula) {
                        
            try {
                $conexionDB = ConexionDB::conectar();

                // Inicio de la transacción por seguridad (si falla uno, no se mueve ninguno a medias)
                $conexionDB->beginTransaction();

                foreach($arrayIdProductosUnitarios as $valor) {

                    // 1. MODIFICADO: Borrada la selección de p.FK_tipo
                    $consultaDatosAnteriores = $conexionDB->prepare("SELECT p.nombreProducto, p.idProducto AS idProductoAntiguo, p.stockActual AS stockAntiguo, 
                                                                        p.FK_aula, p.stockMinimo, p.FK_productoReserva 
                                                                    FROM unidadproducto up 
                                                                    JOIN productos p ON up.FK_producto = p.idProducto 
                                                                    WHERE up.idProductoUnitario = ?
                    ");
                    $consultaDatosAnteriores->execute([$valor]);
                    $registroAntiguo = $consultaDatosAnteriores->fetch(PDO::FETCH_ASSOC);

                    // SEGURIDAD 1 y 2: Si no existe o ya está en esa aula, lo saltamos
                    if (!$registroAntiguo || $registroAntiguo['FK_aula'] == $idAula) {
                        continue; 
                    }

                    // Guardamos los datos extraídos
                    $nombreProducto = $registroAntiguo['nombreProducto'];
                    $idProductoAnterior = $registroAntiguo['idProductoAntiguo'];
                    $stockActualAnterior = $registroAntiguo['stockAntiguo'];
                    
                    // 2. MODIFICADO: Eliminada la lectura de $fkTipo
                    
                    $stockMinimo = $registroAntiguo['stockMinimo'];
                    $fkProductoReserva = $registroAntiguo['FK_productoReserva'];
                    
                    // CORREGIDO: Formato "Y-m-d" porque en tu base de datos el campo es 'date', no 'datetime'
                    $nuevaFechaModificacion = date("Y-m-d"); 

                    // 2. COMPROBAMOS SI EL PRODUCTO YA EXISTE EN LA NUEVA AULA
                    $consultaExistenciaNuevaAula = $conexionDB->prepare("SELECT idProducto, stockActual FROM productos WHERE nombreProducto = ? AND FK_aula = ?");
                    $consultaExistenciaNuevaAula->execute([$nombreProducto, $idAula]);

                    if ($consultaExistenciaNuevaAula->rowCount() > 0) {
                        
                        // EL PRODUCTO YA EXISTE EN LA NUEVA AULA
                        $registroNuevo = $consultaExistenciaNuevaAula->fetch(PDO::FETCH_ASSOC);
                        $idProductoNuevo = $registroNuevo['idProducto'];
                        $stockActualNuevo = $registroNuevo['stockActual'];

                        // 1) Subimos stock en el aula nueva
                        $consultaSubirStock = $conexionDB->prepare("UPDATE productos SET stockActual = ?, fechaActualizacion = ? WHERE idProducto = ?");
                        $consultaSubirStock->execute([$stockActualNuevo + 1, $nuevaFechaModificacion, $idProductoNuevo]);

                        // 2) Bajamos stock en el aula antigua
                        $consultaBajarStock = $conexionDB->prepare("UPDATE productos SET stockActual = ?, fechaActualizacion = ? WHERE idProducto = ?");
                        $consultaBajarStock->execute([$stockActualAnterior - 1, $nuevaFechaModificacion, $idProductoAnterior]);

                        // 3) Calculamos nuevo identificador (con seguro anti-nulos)
                        $consultaMaxNum = $conexionDB->prepare("SELECT MAX(numeroIdentificativo) AS maximo FROM unidadproducto WHERE FK_producto = ?");
                        $consultaMaxNum->execute([$idProductoNuevo]);
                        $resultadoMax = $consultaMaxNum->fetch(PDO::FETCH_ASSOC);
                        
                        // Si maximo es null (tabla vacía), empezamos en 0 + 1
                        $nuevoNumeroIdentificativo = ($resultadoMax['maximo'] ? $resultadoMax['maximo'] : 0) + 1;

                        // 4) Movemos el producto unitario
                        $consultaMover = $conexionDB->prepare("UPDATE unidadproducto SET numeroIdentificativo = ?, FK_producto = ? WHERE idProductoUnitario = ?");
                        $consultaMover->execute([$nuevoNumeroIdentificativo, $idProductoNuevo, $valor]);

                    } else {
                        
                        // EL PRODUCTO NO EXISTE EN LA NUEVA AULA

                        // 3. MODIFICADO: Borrado el FK_tipo de la consulta de inserción
                        $consultaInsertProducto = $conexionDB->prepare("INSERT INTO productos (nombreProducto, stockActual, stockMinimo, FK_aula, FK_productoReserva, fechaActualizacion) 
                            VALUES (?, 1, ?, ?, ?, ?)
                        ");
                        $consultaInsertProducto->execute([$nombreProducto, $stockMinimo, $idAula, $fkProductoReserva, $nuevaFechaModificacion]);
                        
                        $idProductoNuevo = $conexionDB->lastInsertId();

                        // 2) Bajamos stock en el aula antigua
                        $consultaBajarStock = $conexionDB->prepare("UPDATE productos SET stockActual = ?, fechaActualizacion = ? WHERE idProducto = ?");
                        $consultaBajarStock->execute([$stockActualAnterior - 1, $nuevaFechaModificacion, $idProductoAnterior]);

                        // 3) Movemos el producto unitario viejo al nuevo producto y reiniciamos su número a 1
                        $consultaMover = $conexionDB->prepare("UPDATE unidadproducto SET numeroIdentificativo = 1, FK_producto = ? WHERE idProductoUnitario = ?");
                        $consultaMover->execute([$idProductoNuevo, $valor]);
                    }
                }

                // Si todo el bucle ha ido bien, guardamos los cambios en la BD
                $conexionDB->commit();
                $conexionDB = null;
                return "Productos reubicados correctamente";

            } catch (PDOException $e) {
                // Si hay algún fallo, revertimos la base de datos para no dejar inventarios a medias
                if (isset($conexionDB)) {
                    $conexionDB->rollBack();
                }
                return "Error en la base de datos al reubicar: " . $e->getMessage() . "";
            }
        }

       public static function obtenerProductoUnitarioPorId(int $idProductoUnitario) {
            $conexionDB = ConexionDB::conectar();

            $consulta = $conexionDB->prepare("SELECT * FROM unidadproducto WHERE idProductoUnitario = ?");
            $consulta->execute([$idProductoUnitario]);

            // fetch() devolverá el array asociativo si lo encuentra, o 'false' si no hay coincidencias
            $productoUnitario = $consulta->fetch(PDO::FETCH_ASSOC);
            
            $conexionDB = null;
            
            return $productoUnitario; 
        }

        public static function cargarNombreProductoAulaLocalizacion(array $productoUnitario) {
            $conexionDB = ConexionDB::conectar();

            // Consulta preparada corregida: tablas 'aulas' y 'localizaciones' en plural
            $consulta = $conexionDB->prepare("SELECT p.nombreProducto, a.nombreAula, l.nombreLocalizacion 
                                                FROM unidadproducto up 
                                                JOIN productos p ON up.FK_producto = p.idProducto 
                                                JOIN aulas a ON p.FK_aula = a.idAula 
                                                JOIN localizaciones l ON a.FK_localizacion = l.idLocalizacion 
                                                WHERE up.idProductoUnitario = ?");
                                                
            $consulta->execute([$productoUnitario['idProductoUnitario']]);

            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

            $conexionDB = null;

            return $resultado; // Devuelve un array con 'nombreProducto', 'nombreAula' y 'nombreLocalizacion'
        }
   }


?>