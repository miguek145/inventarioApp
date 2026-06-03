
<?php

        $pc = "localhost";
        $userName = "root";
        $password = "";
        $db = "inventarioapp";
        
         
        //Nos conectamos a la base de datos
        $conexionDB = new PDO("mysql:host=$pc;dbname=$db", $userName, $password);


        $contraseña="Ecos173.#";
        $contraseñaEncriptada=password_hash($contraseña,PASSWORD_DEFAULT);

        $conexionDB->query("INSERT INTO usuarios (nombreUsuario,pasword) VALUES ('ECOS','$contraseñaEncriptada')");


        $conexionDB=null;
?>