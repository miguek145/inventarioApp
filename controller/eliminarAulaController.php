<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once "../model/localizacion.php";
    require_once "../model/aula.php";
    require_once "../model/analizadorFormulario.php";

    // Variable para recordar la última localización seleccionada
    $ultimaLocalizacion = null;

    if(isset($_POST['eliminar'])){
        $localizaciones = analizadorFormulario($_POST['localizaciones']);
        $aula = analizadorFormulario($_POST['idAula']);

        // Recordamos la localización que se acaba de usar
        $ultimaLocalizacion = $localizaciones;

        $resultado = Aula::eliminarAula($localizaciones, $aula); 
        
        // CORRECCIÓN: Mandamos el resultado y también la localización usada para no perder el contexto
        header("Location: eliminarAulaController.php?resultado=" . urlencode($resultado) . "&loc=" . urlencode($ultimaLocalizacion));
        exit;
    }
    
    // Si venimos de una redirección post-borrado, recuperamos la localización de la URL
    if (isset($_GET['loc'])) {
        $ultimaLocalizacion = $_GET['loc'];
    }

    // Obtenemos los nombres de las localizaciones
    $datosNombresLocalizaciones = Localizacion::cargarLocalizaciones();

    // Si tenemos una localización previa en memoria, cargamos sus aulas actuales; si no, de la primera por defecto
    $idLocalizacionCargar = $ultimaLocalizacion ? $ultimaLocalizacion : $datosNombresLocalizaciones[0]['idLocalizacion'];
    $arrayAulas = Aula::cargarAulasDeUnaLocalizacion($idLocalizacionCargar);
    
    $ruta = "menuEliminarLocalizacionController.php";
    $nombrePagina = "ELIMINAR AULA";
    
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/eliminarAulaV.php";
    require_once "../view/templates/cierre.php";
?>
<script src="../view/js/aparecerSelectorAulas.js"></script>