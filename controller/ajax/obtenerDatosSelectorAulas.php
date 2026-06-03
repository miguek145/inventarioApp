<?php

    require_once "../../model/analizadorFormulario.php";
    require_once "../../model/conexionDB.php";

    $idLocalizacion=analizadorFormulario($_GET['idLocalizacion']);
    $conexionDB=ConexionDB::conectar();

    $consultaNombresAulas=$conexionDB->query("SELECT idAula,nombreAula FROM aulas WHERE FK_localizacion='$idLocalizacion'");

    if($consultaNombresAulas->rowCount()>0){
        echo "<label for=''>Aula:</label> ";
        echo "<select id='idAula' name='idAula' required>";
            while ($fila = $consultaNombresAulas->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$fila['idAula']."'>".$fila['nombreAula']."</option>";
            }
        echo "</select>";
       
    }else{
        echo "no hay aulas registradas";
    }
   $conexionDB = null;
?>