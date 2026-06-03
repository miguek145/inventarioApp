<?php

    require_once "conexionDB.php";


    class Usuarios{

        public string $usuario;
        public string $contraseña;


        public function __construct($usuario,$contraseña){
            $this->usuario=$usuario;
            $this->contraseña=$contraseña;
        }

        public function login(){

            $conexionDB=ConexionDB::conectar();

            // comprobamos la contraseña (Consulta preparada usando la propiedad $this->usuario)
            $consultaComprobarContraseña=$conexionDB->prepare("SELECT pasword FROM usuarios WHERE nombreUsuario=?");
            $consultaComprobarContraseña->execute([$this->usuario]);
            
            $conexionDB=null;

            //desemcriptamos la contraseña para comprobar de que está bien
            $arrayConsultaContraseña=$consultaComprobarContraseña->fetch(PDO::FETCH_ASSOC);

            // para que no dé error en pantalla si el usuario escrito no existe en la base de datos
            if($arrayConsultaContraseña && password_verify($this->contraseña,$arrayConsultaContraseña['pasword'])){

                //creamos la sesión
                session_name("UsuarioLogoneado");
                session_start();
                $_SESSION['usuario']="ECOS";
                header('Location:indexController.php');

            }else{
                    return "<h5 style='text-align: center;'>ERROR: El nombre de usuario o la contraseña no coinciden</h5>";
            }
        }
    }

?>