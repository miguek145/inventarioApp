var inputBuscador = document.getElementById("inputBuscador");
var contenedorFilas = document.getElementById("contenedorFilas");

inputBuscador.addEventListener("input", (ev) => {
    
    ev.preventDefault(); 

    var valorBusqueda = inputBuscador.value;

    // Empaquetamos el parámetro GET de forma automática como tu modelo
    var parametros = new URLSearchParams({
        buscar: valorBusqueda
    });

    // Ruta absoluta desde la raíz del servidor
    // Petición Fetch idéntica a tu modelo (espera código HTML)
    fetch(`/inventarioApp/controller/ajax/buscadorProductoReserva.php?${parametros.toString()}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.text(); // Esperamos código HTML como respuesta
        })
        .then(response => {
            // Inyectamos el HTML directamente en tu contenedor
            contenedorFilas.innerHTML = response;
        })
        .catch(error => {
            console.error("Error Fetch:", error);
        });
});