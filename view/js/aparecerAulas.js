window.addEventListener("load", () => {

    fetch("../controller/ajax/obtenerAulas.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("contenedorAulas").innerHTML = data;
        })
        .catch(error => console.log(error));

});