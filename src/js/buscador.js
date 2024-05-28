document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    buscarPorFecha();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function (e) {
        const fechaSeleccionada = e.target.value;
        // Esto se añade al url actual y se redirecciona
        window.location = `?fecha=${fechaSeleccionada}`;
    })
}