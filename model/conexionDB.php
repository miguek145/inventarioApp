<?php
        class ConexionDB{
            
            static public function conectar(){
                
                $pc = "127.0.0.1";
                $userName = "root";
                $password = "";
                $db = "inventarioapp";
            
                try {
                    //Nos conectamos a la base de datos
                    $conexionDB = new PDO("mysql:host=$pc;dbname=$db", $userName, $password);
   
                    // le aplicamos una excepción personalizada de PDO
                    $conexionDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    return $conexionDB;
                } catch (PDOException $error) {

                    echo "ERROR: No se ha podido realizar una conexión a la base de datos. ";
                    die ( $error->getMessage());
                }
            }
        }
       
?>