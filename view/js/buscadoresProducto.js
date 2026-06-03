var inputNombreProducto = document.getElementById("nombreProducto");
var selectorLocalizaciones = document.getElementById("selectorLocalizaciones");
var contenedorTablaProductos = document.getElementsByClassName("tablaProductos");
var botonBuscarProducto = document.getElementById("botonBuscarProducto");
var elementoTipo = document.getElementById("nombreTipoProductos");
var botonLimpiarBuscador = document.getElementById("botonLimpiarBuscadorProducto");

// ==========================================
// EVENTO: BUSCAR PRODUCTO
// ==========================================
botonBuscarProducto.addEventListener("click", (ev) => {
    
    ev.preventDefault(); 

    var valorNombre = inputNombreProducto.value;
    var valorLocalizacion = selectorLocalizaciones.value;
    var valorIdTipo = elementoTipo.classList[0];

    // Empaquetamos los parámetros GET de forma automática
    var parametros = new URLSearchParams({
        nombreProducto: valorNombre,
        idLocalizacion: valorLocalizacion,
        idTipo: valorIdTipo
    });

    // Petición Fetch (Reemplaza por completo a $.ajax)
    fetch(`../../controller/ajax/buscadorTablaProductos.php?${parametros.toString()}`)
        .then(response => {
            // Comprobamos si el servidor respondió correctamente (status 200)
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.text(); // Esperamos código HTML como respuesta
        })
        .then(response => {
            // Acción en caso de éxito (Equivalente al success de jQuery)
            contenedorTablaProductos[0].innerHTML = response;
        })
        .catch(error => {
            // Acción en caso de fallo (Equivalente al error de jQuery)
            console.error("Error Fetch:", error);
        });
});

// ==========================================
// EVENTO: LIMPIAR BUSCADOR
// ==========================================
botonLimpiarBuscador.addEventListener("click", (ev) => {
    ev.preventDefault();
    // Recarga la página para limpiar todos los inputs y selects
    window.location.reload();
});