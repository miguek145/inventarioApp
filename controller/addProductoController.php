<?php

    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }

    require_once  "../model/products.php";
    require_once  "../model/tipos.php";
    require_once  "../model/localizacion.php";
    require_once  "../model/aula.php";

    //obetnemos los nombre de los tipos
    $arrayTipos=Tipos::mostrarTipos();

    //obtenemos los nombres de las localizaciones
    $arrayNombresLocalizaciones=Localizacion::cargarLocalizaciones();

    //obtenemos los nombres de las aulas de la primera localizacion
    $arrayAulas=Aula::cargarAulasDeUnaLocalizacion($arrayNombresLocalizaciones[0]['idLocalizacion']);

    //esta es la fecha en la que se creó ese nuevo elemento
    $fechaActual = date('Y-m-d');
 
    if(isset($_POST['enviar'])){
        require_once "../model/analizadorFormulario.php";

        $nombreProducto=analizadorFormulario($_POST['nombreProducto']);
        $aula=analizadorFormulario($_POST['aula']);
        $stockMin=analizadorFormulario($_POST['stockMin']);
        $localizaciones=analizadorFormulario($_POST['localizaciones']);
        $tipo=analizadorFormulario($_POST['idTipo']);

        $objeto = new Productos($nombreProducto,$aula,$stockMin,$localizaciones,$fechaActual,$tipo);
        $resultado=$objeto->addProducto();
    }

    $ruta="indexController.php";

    $nombrePagina="ADD NEW LOCATION";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/addProductov.php";
    require_once "../view/templates/cierre.php";


?>
 <script src="../view/js/aparecerSelectorAulas.js"></script>