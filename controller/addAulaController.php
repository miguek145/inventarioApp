<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }
 
    require_once "../model/localizacion.php";
    require_once "../model/analizadorFormulario.php";

    $arrayNombresLocalizaciones = Localizacion::cargarLocalizaciones();
    
    // AÑADIDO: Variable para recordar la selección. Por defecto es null.
    $ultimaLocalizacion = null;

    if(isset($_POST['añadir'])){

        require_once "../model/aula.php";

        $localizaciones = analizadorFormulario($_POST['localizaciones']);
        $nombreAulaNueva = analizadorFormulario($_POST['nombreAula']);
        
        // Guardamos la localización que acaba de usar el usuario
        $ultimaLocalizacion = $localizaciones;

        if (preg_match('/^[A-ZÑ][a-zñ]{1,15}(\s?\d{0,2})?$/', $nombreAulaNueva)) {
            $resultado = Aula::addAula($localizaciones, $nombreAulaNueva);
        } else {
            $resultado = "ATENCIÓN: El nombre del aula debe empezar por mayúscula, continuar con minúsculas y puede terminar con hasta dos números (Ej: 'Aula 5' o 'Taller').";
        }
    }

    $ruta = "menuAddLocalizacionController.php";

    $nombrePagina = "AÑADIR AULA";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/addAulaV.php";
    require_once "../view/templates/cierre.php";
?>

<script src="../view/js/aparecerSelectorAulas.js"></script>