<?php
    session_name("UsuarioLogoneado");
    session_start();
    
    if(!isset($_SESSION['usuario'])){
        header("Location:loginController.php");
        die();
    }
    
    if(isset($_POST['añadir'])){
        require_once  "../model/tipos.php";
        require_once "../model/analizadorFormulario.php";

        $nombreTipo = analizadorFormulario($_POST['nombreTipo']);

        // =================================================================
        // VALIDACIÓN CON EXPRESIÓN REGULAR ANTES DE TOCAR LA BASE DE DATOS
        // =================================================================
        // Añadimos los delimitadores '/' a la expresión regular
        if (preg_match('/^[a-zA-ZñÑ]{1,15}$/', $nombreTipo)) {
            
            // Si cumple el formato, intentamos añadir a la base de datos
            $resultado = Tipos::addTipo($nombreTipo);
            
        } else {
            
            // Si no cumple, bloqueamos y avisamos al usuario
            $resultado = "ATENCIÓN: El nombre del tipo solo puede contener letras (sin espacios ni números) y debe tener entre 1 y 15 caracteres.";
            
        }
    }

    $ruta="indexController.php";

    $nombrePagina="AÑADIR TIPO";
    require_once "../view/templates/declaracion.php";
    require_once "../view/templates/barraNavegacion.php";
    require_once "../view/addTipoV.php";
    require_once "../view/templates/cierre.php";
?>