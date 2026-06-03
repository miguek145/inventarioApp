<div class="menuHamburguesa">
    <span></span>
    <span></span>
    <span></span>
</div>

<header>
    <h2>InventarioECOS</h2>
    <nav>
        <ul>
            <li><a href="indexController.php">PAG PRINCIPAL</a></li>
            <li><a href="tablaProductoReservaController.php">GESTION RESERVAS</a></li>
            <li class="menuConSubmenu"><a >MENU LOCALIZACION</a>
                <ul>
                    <li><a href="menuAddLocalizacionController.php">AÑADIR LOCALIZACION</a></li>
                    <li><a href="menuEliminarLocalizacionController.php">ELIMINAR LOCALIZACION</a></li>
                    <li><a href="menuEditLocalizacionController.php">EDITAR LOCALIZACION</a></li>
                </ul>
            </li>
            <li class="menuConSubmenu"><a >GESTION TIPOS</a>
                <ul>
                    <li><a href="addTipoController.php">AÑADIR TIPO</a></li>
                    <li><a href="eliminarTipoController.php">ELIMINAR TIPO</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<a href="<?= $ruta ?? '#' ?>" class="botonVolver">Volver</a>
<script src="../view/js/animacionesBarraNavegacion.js"></script>