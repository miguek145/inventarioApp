window.addEventListener("load", () => {

    fetch("../controller/ajax/obtenerTipos.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("contenedorTipos").innerHTML = data;
        })
        .catch(error => console.log("Error AJAX:", error));

});