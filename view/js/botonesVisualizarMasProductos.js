var contenedorBotonesSiguienteAnterior = document.getElementById("contenedorBotonesSiguienteAnterior");
var botonPagSiguiente = document.getElementById("botonPagSiguiente");
var botonPagAnterior = document.getElementById("botonPagAnterior");
var elementoTipo = document.getElementById("nombreTipoProductos");

// Empezamos en 10 porque al cargar la página ya hay 10 mostrados.
var offsetProductos = 10; 

//  Ruta absoluta desde la raíz del servidor
const urlAjax = '/inventarioApp/controller/ajax/botonesMoverVisualziarProductosTabla.php';

// ==========================================
// BOTÓN SIGUIENTE
// ==========================================
botonPagSiguiente.addEventListener("click", (ev) => {
    
    var valorIdTipo = elementoTipo.classList[0];
    ev.preventDefault();

    // Creamos de forma automática la Query String (?idTipo=...&offset=...)
    var parametros = new URLSearchParams({
        idTipo: valorIdTipo,
        offset: offsetProductos
    });

    // Petición Fetch
    fetch(`${urlAjax}?${parametros.toString()}`)
        .then(response => {
            if (!response.ok) throw new Error("Error en la respuesta del servidor");
            return response.text();
        })
        .then(response => {
            if (response.trim() === "") {
                botonPagSiguiente.style.display = "none";
                return; 
            }

            // 1. EL FRANCOTIRADOR: Buscamos todas las filas antiguas y las borramos
            var filasViejas = document.querySelectorAll('.contenedorFilaProducto');
            filasViejas.forEach(fila => fila.remove());

            // 2. Insertamos las nuevas filas justo en el hueco antes de los botones
            contenedorBotonesSiguienteAnterior.insertAdjacentHTML('beforebegin', response);
            
            offsetProductos += 10; 
        })
        .catch(error => {
            console.error("Error Fetch:", error);
        });
});

// ==========================================
// BOTÓN ANTERIOR
// ==========================================
botonPagAnterior.addEventListener("click", (ev) => {
    
    ev.preventDefault();

    if (offsetProductos <= 10) {
        return; 
    }

    var valorIdTipo = elementoTipo.classList[0];
    var nuevoOffset = offsetProductos - 20;

    // Creamos de forma automática la Query String para la página anterior
    var parametros = new URLSearchParams({
        idTipo: valorIdTipo,
        offset: nuevoOffset
    });

    // Petición Fetch
    fetch(`${urlAjax}?${parametros.toString()}`)
        .then(response => {
            if (!response.ok) throw new Error("Error en la respuesta del servidor");
            return response.text();
        })
        .then(response => {
            botonPagSiguiente.style.display = "inline-block"; 

            // 1. EL FRANCOTIRADOR: Buscamos todas las filas actuales y las borramos
            var filasViejas = document.querySelectorAll('.contenedorFilaProducto');
            filasViejas.forEach(fila => fila.remove());

            // 2. Insertamos las filas de la página anterior
            contenedorBotonesSiguienteAnterior.insertAdjacentHTML('beforebegin', response);
            
            offsetProductos = nuevoOffset + 10; 
        })
        .catch(error => {
            console.error("Error Fetch:", error);
        });
});