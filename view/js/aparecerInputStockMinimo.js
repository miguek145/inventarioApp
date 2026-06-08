var contenedorStockMinimo = document.getElementById("contenedorStockMinimo");
var inputOculto = document.getElementById("idProductoReservaJS");
var idProductoReserva = inputOculto ? inputOculto.value : null;

function comprobarExistenciaAula(idAula) {
    if (!idAula || !idProductoReserva) return;

    //Ruta absoluta desde la raíz del servidor
    fetch(`/inventarioApp/controller/ajax/comprobarParaAparecerInputStockMinimo.php?idProductoReserva=${idProductoReserva}&idAula=${idAula}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.text(); 
        })
        .then(html => {
            contenedorStockMinimo.innerHTML = html;
        })
        .catch(error => {
            console.error("Hubo un problema con la petición fetch:", error);
        });
}

// ÚNICO EVENTO: Solo reacciona al hacer 'change' en el selector de aulas
document.addEventListener("change", (evento) => {
    if (evento.target && evento.target.id === "idAula") {
        var idAula = evento.target.value;
        comprobarExistenciaAula(idAula);
    }
});