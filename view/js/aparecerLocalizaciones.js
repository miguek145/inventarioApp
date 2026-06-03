window.addEventListener("load", () => {

    
    fetch("./ajax/obtenerLocalizaciones.php")
        .then(r => r.text())
        .then(html => {
            document.getElementById("contenedorLocalizaciones").innerHTML = html;

            
            document.addEventListener("change", (e) => {

                if (e.target.name === "localizacion") {

                    const id = e.target.value;

                    fetch("./ajax/obtenerAulas.php?idLocalizacion=" + id)
                        .then(r => r.text())
                        .then(htmlAulas => {
                            document.getElementById("contenedorAulas").innerHTML = htmlAulas;
                        });
                }
            });

        });

    
    fetch("./ajax/obtenerAulas.php?idLocalizacion=0")
        .then(r => r.text())
        .then(html => {
            document.getElementById("contenedorAulas").innerHTML = html;
        });

});