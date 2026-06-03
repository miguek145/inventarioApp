<?php

    require_once "../model/usuarios.php";

    //comprobamos si se ha pulsado el botón de enviar
    if(isset($_POST['submitLogin'])){

        //comprobar valores vacios
        if (empty($_POST['usuario']) || empty($_POST['contraseña'])) {

            $error="ERROR: Los valores no pueden estar vacíos.";
            echo $error;

        }else{
            require_once "../model/analizadorFormulario.php";

            $nombreUsuarioAsegurado=analizadorFormulario($_POST['usuario']);
            $contraseñaAsegurada=analizadorFormulario($_POST['contraseña']);

            $objeto=new Usuarios($nombreUsuarioAsegurado,$contraseñaAsegurada);
            $resultadoLogin=$objeto->login();
           
        }   
    }

    $nombrePagina="LOGIN";
    require_once "../view/templates/declaracion.php";
    require_once "../view/loginv.php";
    require_once "../view/templates/cierre.php";

?>