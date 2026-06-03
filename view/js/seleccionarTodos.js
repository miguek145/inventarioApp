var selectorSeleccionarTodos = document.getElementById("checkTodos");

var checkboxes = document.querySelectorAll(".cuerpoTablaReubicar input[type='checkbox']");

selectorSeleccionarTodos.addEventListener("change", function() {

    if (this.checked) {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
    } else {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        }); 
    }
});
