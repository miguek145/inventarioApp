<?php
    function analizadorFormulario($caracter) {
        if ($caracter === null) {
            return '';
        }
        $caracter = trim($caracter); //quitar espacios primero
        $caracter = stripslashes($caracter); //quitar barras invertidas
        $caracter = htmlspecialchars($caracter); //convertir a entidades HTML
        return $caracter;
    }
?>