
var selectorLocalizaciones = document.getElementById("localizaciones");
var contenedorAulas = document.getElementById("contenedorAulas");

selectorLocalizaciones.addEventListener("change", () => {
    var idLocalizacion = selectorLocalizaciones.value;
    
    fetch(`../../controller/ajax/obtenerDatosSelectorAulas.php?idLocalizacion=${idLocalizacion}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.text(); 
        })
        .then(html => {
            // Inyectamos el nuevo HTML dentro del contenedor
            contenedorAulas.innerHTML = html;
        })
        .catch(error => {
            console.error("Hubo un problema con la petición fetch:", error);
        });
});