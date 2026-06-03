<?php

    require_once "conexionDB.php";

    class Aula{

        static public function addAula(int $idLocalizacion, string $nombreAula){

            $conexionDB=ConexionDB::conectar();

            //comprobamos si existe ya el aula (Consulta preparada)
            $consultaExistenciaAula=$conexionDB->prepare("SELECT * FROM aulas WHERE nombreAula=? AND FK_localizacion=?");
            $consultaExistenciaAula->execute([$nombreAula, $idLocalizacion]);
            
            if($consultaExistenciaAula->rowCount()>0){
                $conexionDB = null;
                return "No se puede añadir el aula porque ya existe.";
            }else{
                // Inserción (Consulta preparada)
                $consultaInsert = $conexionDB->prepare("INSERT INTO aulas (nombreAula,FK_localizacion) VALUES (?,?)");
                $consultaInsert->execute([$nombreAula, $idLocalizacion]);
                
                $conexionDB = null;
                return "Se ha añadido el aula nueva";
            }
        }

        static public function eliminarAula(int $idLocalizacion, int $idAula){

            $conexionDB=ConexionDB::conectar();

            //comprobamos si existe ya el aula (Consulta preparada)
            $consultaExistenciaAula=$conexionDB->prepare("SELECT * FROM aulas WHERE idAula=? AND FK_localizacion=?");
            $consultaExistenciaAula->execute([$idAula, $idLocalizacion]);
            
            if($consultaExistenciaAula->rowCount()>0){
                // Eliminación (Consulta preparada)
                $consultaDelete = $conexionDB->prepare("DELETE FROM aulas WHERE idAula=? AND FK_localizacion=?");
                $consultaDelete->execute([$idAula, $idLocalizacion]);
                
                $conexionDB = null;
                return "El aula ha sido eliminada correctamente.";
            }else{
                $conexionDB = null;
                return "ATENCIÓN: no se ha podido eliminar porque no existe en la base de datos.";
            }
        }

        static public function editarAula(int $idLocalizacion, int $idAulAntigua, string $nombreAulaNuevo){

            $conexionDB=ConexionDB::conectar();

            //comprobamos si existe el aula (Consulta preparada)
            $consultaComprobarNombreAula=$conexionDB->prepare("SELECT * FROM aulas WHERE nombreAula =? AND FK_localizacion=? AND idAula!=?");
            $consultaComprobarNombreAula->execute([$nombreAulaNuevo, $idLocalizacion, $idAulAntigua]);

            if($consultaComprobarNombreAula->rowCount()==0){

                //modificamos el nombre del aula (Consulta preparada)
                $consultaUpdate = $conexionDB->prepare("UPDATE aulas SET nombreAula =? WHERE idAula =? AND FK_localizacion =?");
                $consultaUpdate->execute([$nombreAulaNuevo, $idAulAntigua, $idLocalizacion]);
                
                $conexionDB = null;
                return "El nombre del aula ha sido modificada";
            }else{
                 $conexionDB = null;
                 return "ATENCIÓN: no se ha podido modificar porque no existe en la base de datos.";
            }
        }

        static public function cargarAulasDeUnaLocalizacion(int $idLocalizacion){

            $conexionDB=ConexionDB::conectar();

            //obtenemos todas las aulas de la localización (Consulta preparada)
            $consultaAulas=$conexionDB->prepare("SELECT * FROM aulas WHERE FK_localizacion=?");
            $consultaAulas->execute([$idLocalizacion]);

            $arrayAulas=array();

            while($fila=$consultaAulas->fetch(PDO::FETCH_ASSOC)){
                array_push($arrayAulas,["idAula"=>$fila['idAula'],"nombreAula"=>$fila['nombreAula']]);
            }

            $conexionDB = null;
            return $arrayAulas;
        }

        static public function cargarAulas(){

            $conexionDB=ConexionDB::conectar();

            //obtenemos todas las aulas (Consulta preparada)
            $consultaAulas=$conexionDB->prepare("SELECT idAula, nombreAula, FK_localizacion FROM aulas");
            $consultaAulas->execute();

            $arrayAulas=array();

            while($fila=$consultaAulas->fetch(PDO::FETCH_ASSOC)){
                array_push($arrayAulas,["idAula"=>$fila['idAula'],"nombreAula"=>$fila['nombreAula'],"FK_localizacion"=>$fila['FK_localizacion']]);
            }

            $conexionDB = null;
            return $arrayAulas;
        }
    }    
?>

