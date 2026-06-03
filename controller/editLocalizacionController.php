<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/localizacion.php";

    // AÑADIDO: Variable para recordar la selección
    $ultimaLocalizacion = null;

    if(isset($_POST['editar'])){
        require_once "../model/analizadorFormulario.php";

        $localizaciones = analizadorFormulario($_POST['localizaciones']);
        $nombreLocalizacionNuevo = analizadorFormulario($_POST['nombreLocalizacionNuevo']);

        // Guardamos la selección
        $ultimaLocalizacion = $localizaciones;

        if (preg_match('/^[A-Z]{2}$/', $nombreLocalizacionNuevo)) {
            $resultado = Localizacion::editarLocalizacion($localizaciones, $nombreLocalizacionNuevo);
        } else {
            // Eliminado el <h2> para que encaje perfecto en tu caja oscura
            $resultado = "ATENCIÓN: El código de localización debe estar formado exactamente por 2 letras mayúsculas.";
        }

        // CORRECCIÓN: Pasamos el resultado y la localización por la URL
        header("Location: editLocalizacionController.php?resultado=" . urlencode($resultado) . "&loc=" . urlencode($ultimaLocalizacion));
        exit;
    }

    // Si venimos de una redirección, recuperamos la localización de la URL
    if (isset($_GET['loc'])) {
        $ultimaLocalizacion = $_GET['loc'];
    }

    // Cargamos los datos para el select
    $datosNombresLocalizaciones = Localizacion::cargarLocalizaciones();  

    $ruta = "menuEditLocalizacionController.php";
    $nombrePagina = "EDITAR LOCALIZACION";
    
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/editLocalizacionV.php";
    require_once "../view/templates/cierre.php";

?>