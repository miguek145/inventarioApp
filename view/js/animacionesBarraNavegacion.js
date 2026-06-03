var menuHamburguesa=document.getElementsByClassName("menuHamburguesa");
var arraySpan=document.querySelectorAll("span");
var header=document.querySelector("header");
var menuConSubmenu=document.getElementsByClassName("menuConSubmenu");

menuHamburguesa[0].addEventListener("click", (e) => {

    e.stopPropagation(); // Evita que el clic llegue al body/html
    arraySpan[0].classList.toggle("span1");
    arraySpan[1].classList.toggle("span2");
    arraySpan[2].classList.toggle("span3");

    header.classList.toggle("moverHeader");
});

document.addEventListener("click", (e) => {

    // Solo quitamos las clases si el menú está visible
    if (header.classList.contains("moverHeader")) {
        arraySpan[0].classList.remove("span1");
        arraySpan[1].classList.remove("span2");
        arraySpan[2].classList.remove("span3");
        header.classList.remove("moverHeader");
    }
});

for (let contador = 0; contador < menuConSubmenu.length; contador++) {
    menuConSubmenu[contador].addEventListener("click", (e) => {
        e.stopPropagation();

        // 1. Seleccionamos el submenú específico en el que acabas de hacer clic
        // (Usa el mismo querySelector que tenías antes, asumo que era algo como 'ul' o '.submenu')
        let submenuClicado = e.currentTarget.querySelector('ul'); 

        // 2. Seleccionamos TODOS los submenús que estén abiertos en toda la página
        let submenusAbiertos = document.querySelectorAll('.mostrarSubmenuMobile');

        // 3. Recorremos los que están abiertos y los cerramos, SALVO el que acabamos de clickar
        submenusAbiertos.forEach(abierto => {
            if (abierto !== submenuClicado) {
                abierto.classList.remove("mostrarSubmenuMobile");
            }
        });

        // 4. Finalmente, abrimos o cerramos el submenú sobre el que hicimos clic
        if (submenuClicado) {
            submenuClicado.classList.toggle("mostrarSubmenuMobile");
        }
    });
}