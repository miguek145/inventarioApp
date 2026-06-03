<?php

    require_once "conexionDB.php";

    class Tipos{

        public static function mostrarTipos(){

            $conexionDB=ConexionDB::conectar();

            // Consulta estática, no necesita preparación
            $consultaDatosTipos=$conexionDB->query("SELECT * FROM tipos");

            if($consultaDatosTipos->rowCount()>0){

                $arrayTipos=array();

                while($fila=$consultaDatosTipos->fetch(PDO::FETCH_ASSOC)){
                    array_push($arrayTipos,["idTipo"=>$fila['idTipo'],"nombreTipo"=>$fila['nombreTipo']]);
                }

                $conexionDB = null;
                return $arrayTipos;
            }else{
                $conexionDB = null;
                return "HAY 0 TIPOS";
            }
        }

        public static function addTipo(string $nombreTipo) {
            $conexionDB = ConexionDB::conectar();

            // comprobar duplicado tipo (Consulta preparada)
            $consulta = $conexionDB->prepare("SELECT idTipo FROM tipos WHERE nombreTipo=?");
            $consulta->execute([$nombreTipo]);

            if ($consulta->rowCount() > 0) {
                $conexionDB = null;
                return "EL TIPO YA EXISTE";
            } else {
                // Este INSERT ya lo tenías preparado con bindParam, lo dejamos intacto. ¡Muy bien!
                $insertarTipo = $conexionDB->prepare("INSERT INTO tipos (nombreTipo) VALUES (:nombreTipo)");
                $insertarTipo->bindParam(':nombreTipo', $nombreTipo);
                $insertarTipo->execute();
                
                $conexionDB = null;
                return "TIPO AÑADIDO CORRECTAMENTE";
            }
        }

        public static function delTipo(int $idTipo) {

            $conexionDB = ConexionDB::conectar();

                // Eliminamos el tipo de forma segura
                $consultaDelete = $conexionDB->prepare("DELETE FROM tipos WHERE idTipo=?");
                $consultaDelete->execute([$idTipo]);
                
                $conexionDB = null;
                return "El tipo ha sido eliminado correctamente.";
      
        }

        public static function mostrarNombreTipo(int $idTipo){

            $conexionDB = ConexionDB::conectar();

            // Consulta preparada para comprobar existencia del tipo
            $consultaTipo = $conexionDB->prepare("SELECT nombreTipo FROM tipos WHERE idTipo=?");
            $consultaTipo->execute([$idTipo]);

            // Corregido "fecth" a "fetch" y quitados los paréntesis dobles
            $arrayNombreTipo = $consultaTipo->fetch(PDO::FETCH_ASSOC);

            return $arrayNombreTipo['nombreTipo'];
        }
    }
?>