window.addEventListener("load", () => {

    fetch("../controller/ajax/obtenerProductosReserva.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("contenedorProductosReserva").innerHTML = data;
        })
        .catch(error => console.log("Error AJAX:", error));

});