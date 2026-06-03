<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }
 
    require_once  "../model/localizacion.php";
    require_once  "../model/aula.php";

    // Variables para recordar las últimas selecciones del usuario
    $ultimaLocalizacion = null;
    $ultimaAula = null;

    if(isset($_POST['editar'])){
        require_once "../model/analizadorFormulario.php";

        $localizaciones = analizadorFormulario($_POST['localizaciones']);
        $aula = analizadorFormulario($_POST['idAula']);
        $nombreAulaNueva = analizadorFormulario($_POST['nombreAulaNuevo']);

        // Guardamos las selecciones para usarlas luego
        $ultimaLocalizacion = $localizaciones;
        $ultimaAula = $aula;

        if (preg_match('/^[A-ZÑ][a-zñ]{1,15}(\s?\d{0,2})?$/', $nombreAulaNueva)) {
            $resultado = Aula::editarAula($localizaciones, $aula, $nombreAulaNueva);
        } else {
            // Le he quitado los <h2> para que no salga el texto gigante dentro de la caja de error
            $resultado = "ATENCIÓN: El nombre del aula debe empezar por mayúscula, continuar con minúsculas y puede terminar con hasta dos números (Ej: 'Aula 5' o 'Taller').";
        }

        // Pasamos el resultado y las últimas selecciones por la URL para que no se pierdan al recargar
        header("Location: editAulaController.php?resultado=" . urlencode($resultado) . "&loc=" . urlencode($ultimaLocalizacion) . "&aul=" . urlencode($ultimaAula));
        exit;
    }

    // Comprobamos si venimos de una recarga y recuperamos las selecciones de la URL
    if (isset($_GET['loc'])) {
        $ultimaLocalizacion = $_GET['loc'];
    }
    if (isset($_GET['aul'])) {
        $ultimaAula = $_GET['aul'];
    }

    // Visualizar opciones de los selects
    $datosNombresLocalizaciones = Localizacion::cargarLocalizaciones();

    // Si tenemos una localización guardada, cargamos sus aulas. Si no, cargamos las de la primera.
    $idLocalizacionCargar = $ultimaLocalizacion ? $ultimaLocalizacion : $datosNombresLocalizaciones[0]['idLocalizacion'];
    $arrayAulas = Aula::cargarAulasDeUnaLocalizacion($idLocalizacionCargar);

    $ruta = "menuEditLocalizacionController.php";
    $nombrePagina = "EDITAR AULA"; 
    
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/editAulaV.php";
    require_once "../view/templates/cierre.php";

?>
<script src="../view/js/aparecerSelectorAulas.js"></script>