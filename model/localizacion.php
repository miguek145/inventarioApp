<?php

    require_once "conexionDB.php";
    
    class Localizacion{

        public static function addLocalizacion(string $nombreLocalizacion){

            $conexionDB=ConexionDB::conectar();

            //comprobamos si existe la localización (Consulta preparada)
            $consultaLocalizacion=$conexionDB->prepare("SELECT * FROM localizaciones WHERE nombreLocalizacion = ?");
            $consultaLocalizacion->execute([$nombreLocalizacion]);

            if($consultaLocalizacion->rowCount()>0){
                $conexionDB = null;
                return "ATENCIÓN: no se puede añadir la nueva localización porque ya existe.";
            }else{
                // Inserción (Consulta preparada)
                 $consultaInsert = $conexionDB->prepare("INSERT INTO localizaciones (nombreLocalizacion) VALUES (?)");
                 $consultaInsert->execute([$nombreLocalizacion]);
                 
                 $conexionDB = null;
                 return "La nueva localización ha sido registrada.";
            }
        }

        public static function eliminarLocalizacion(int $idLocalizacion){
            
            $conexionDB=ConexionDB::conectar();

            //comprobamos si existe la localización (Consulta preparada)
            $consultaLocalizacion=$conexionDB->prepare("SELECT * FROM localizaciones WHERE idLocalizacion=?");
            $consultaLocalizacion->execute([$idLocalizacion]);

            if($consultaLocalizacion->rowCount()>0){
                // Eliminación (Consulta preparada)
                $consultaDelete = $conexionDB->prepare("DELETE FROM localizaciones WHERE idLocalizacion=?");
                $consultaDelete->execute([$idLocalizacion]);
                
                $conexionDB = null;
                return "La localización ha sido eliminada.";
            }else{
                $conexionDB = null;
                return "ATENCIÓN: no se ha podido eliminar porque no existe en la base de datos.";
            }
        }

        public static function cargarLocalizaciones(){

            $conexionDB = ConexionDB::conectar();

            // Esta consulta no recibe variables del usuario, por lo que query() es totalmente seguro
            $consultaLocalizaciones=$conexionDB->query("SELECT * FROM localizaciones");
        
            $arrayLocalizaciones=array();

            while($fila=$consultaLocalizaciones->fetch(PDO::FETCH_ASSOC)){
                array_push($arrayLocalizaciones,["idLocalizacion"=>$fila['idLocalizacion'],'nombreLocalizacion'=>$fila['nombreLocalizacion']]);
            }

            $conexionDB = null;
            return $arrayLocalizaciones;
        }   

        public static function editarLocalizacion(int $idLocalizacion, string $nombreLocalizacionNuevo){

            $conexionDB=ConexionDB::conectar();

            // Comprobamos si YA EXISTE otra localización con ese mismo nombre
            $consultaLocalizacion=$conexionDB->prepare("SELECT nombreLocalizacion FROM localizaciones WHERE nombreLocalizacion=? AND idLocalizacion !=?");
            $consultaLocalizacion->execute([$nombreLocalizacionNuevo, $idLocalizacion]);

            if($consultaLocalizacion->rowCount()>0){
                
                $conexionDB = null;
                // MENSAJE CORREGIDO: Avisamos de que el nombre ya está en uso
                return "ATENCIÓN: No se ha podido modificar porque ya existe otra localización con ese mismo nombre.";

            }else{
                // Modificación (Consulta preparada)
                $consultaUpdate = $conexionDB->prepare("UPDATE localizaciones SET nombreLocalizacion=? WHERE idLocalizacion=?");
                $consultaUpdate->execute([$nombreLocalizacionNuevo, $idLocalizacion]);
                
                $conexionDB = null;
                return "La localización ha sido modificada.";
            }
        }
    }

?>