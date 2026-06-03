    
    <main>
        <section class="contenedorLogin">
            <div>
                <h1>LOGIN</h1>
                <form class="formularioInicial" action="" method="post">
                    <label for="nombreUsuario">Usuario:</label>
                    <input type="text" name="usuario" id="usuario" required pattern="^[a-zA-Z]+" autocomplete="off" >
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" name="contraseña" id="contraseña" required  autocomplete="off">
                    <input type="submit" value="LOGIN" name="submitLogin">
                </form>
            </div>
            <div>
                <img class="logoInicioRegister" src="../view/assets/img/logoEcos.png" alt="logo">
            </div>
        </section>

               <?php
               
                //aqui te mostrará el resultado final después de pulsar el botón login
                    if(isset($resultadoLogin)){
                        echo $resultadoLogin;
                    }
               ?>
    </main>
