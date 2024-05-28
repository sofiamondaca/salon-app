let step = 1;
const initialStep = 1;
const finalStep = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora:'',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function () {
    startApp();
});

function startApp() {
    showSection();
    // Cambia la seccion cuando se presionen los tabs
    tabs();
    // agrega o quita los botones del paginador 
    paginationButtons();
    previousPage();
    nextPage();
    // Consulta API en el backend de PHP
    consultarAPI();

    idCliente();
    // Añade el nombre del cliente al objeto de cita
    nombreCliente();
    // Añade la fecha
    seleccionarFecha();
    // Añade la hora
    seleccionarHora();
    mostrarResumen();

}

function showSection() {
    // Ocultar la seccion que tenga la clase de mostrar
    const previousSection = document.querySelector('.show');
    const previousTab = document.querySelector('.current');
    if (previousSection) {
        previousSection.classList.remove('show');
    }
    if (previousTab) {
        previousTab.classList.remove('current');
    }
    // Seleccionar la seccion con el paso
    const section = document.querySelector(`#step-${step}`);
    section.classList.add('show');

    // Cambiar el color del tab actual
    const tab = document.querySelector(`[data-paso="${step}"]`);
    tab.classList.add('current');
}

function tabs() {
    const buttons = document.querySelectorAll('.tabs button');

    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            // Dataset se usa para acceder los atributos personalizados de un elemeto html
            step = parseInt(e.target.dataset.paso);
            showSection();
            paginationButtons();

            if (step === 3) {
                mostrarResumen();
            }
        })
    });

}

function paginationButtons() {
    const nextPage = document.querySelector('#next');
    const previousPage = document.querySelector('#previous');

    if (step === 1) {
        previousPage.classList.add('hide');
        nextPage.classList.remove('hide');
    } else if (step === 3) {
        nextPage.classList.add('hide');
        previousPage.classList.remove('hide');
        mostrarResumen(); 
    } else {
        nextPage.classList.remove('hide');
        previousPage.classList.remove('hide');
    }
    showSection();
}

function previousPage() {
    const previousPage = document.querySelector('#previous');
    previousPage.addEventListener('click', function () {
        if (step <= initialStep) return;
        step--;

        paginationButtons();
    });
}

function nextPage() {
    const nextPage = document.querySelector('#next');
    nextPage.addEventListener('click', function () {
        if (step >= finalStep) return;
        step++;

        paginationButtons();
    });
}

async function consultarAPI() {
    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio; 

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('service-name');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('service-price');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('service');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#services').appendChild(servicioDiv);
 
    })
}

function seleccionarServicio(servicio) {
    // Servicio en este contexto es la informacion del servicio como tal
    const { id } = servicio;
    // Servicios en este contexto es el objeto que tiene la informacion de la cita
    const { servicios } = cita;

    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado
    // SOME es uti para revisar si existe un objeto
    if (servicios.some(servicioAgregado => servicioAgregado.id === id)) {
        // Ya esta agregado, eliminalo
        cita.servicios = servicios.filter(servicioAgregado => servicioAgregado.id !== id);
        divServicio.classList.remove('selected');
    } else{
        // No esta agregado, agregalo
        // Tomo una copia de los servicios y le agrega uno nuevo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('selected');
    }
}

function idCliente() {
    // Lo que para HTML es un atributo, para JS es un objeto
    cita.id = document.querySelector('#id').value;
    
}

function nombreCliente() {
    // Lo que para HTML es un atributo, para JS es un objeto
    cita.nombre = document.querySelector('#nombre').value;
    
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {
        // El objeto Date de JS tiene un metodo .getUTCDay
        // Que regresa un numero de acuerdo al dia de la semana
        //  0 = Doming, 1 = lunes y asi
        const dia = new Date(e.target.value).getUTCDay();
        
        if ([6,0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('No se permiten citas los fines de semana', 'error', '.form');
        } else{
            cita.fecha = e.target.value;
        }
    })
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {
        const horaCita = e.target.value;
        // Selecciona solo la hora de 23:00, cualquier hora X
        const hora = horaCita.split(":")[0];
        if (hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora no valida', 'error', '.form');
        } else{
            cita.hora = e.target.value;
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    // Previene que se genere mas de una alerta
    const alertaPrevia = document.querySelector('.alert');
    if (alertaPrevia) {
        // Elimina la alerta previa
        alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alert');
    alerta.classList.add(tipo);
    
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
            // Eliminar la alerta luego de 3s
    setTimeout(() => {
        alerta.remove();
    }, 3000);
    }

}

function mostrarResumen() {
    const summary = document.querySelector('.summary-content');
    const {  nombre, fecha , hora, servicios} = cita;
    let abreviatura = '';

    // Mostrar contenido del resumen
    while (summary.firstChild) {
        summary.removeChild(summary.firstChild);
    }
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de servicios, fecha u hora', 'error', '.summary-content', false);
        return;
    } 

    // Heading para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de servicios';

    summary.appendChild(headingServicios);
    // Iternado y mostrando los servcios

    servicios.forEach( servicio => {
        const { id, precio , nombre} = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('service-container');

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;
        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span>$${precio}`;

        contenedorServicio.appendChild(nombreServicio);
        contenedorServicio.appendChild(precioServicio);

        summary.appendChild(contenedorServicio);
    }) 
    // Heading para cita
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';

    summary.appendChild(headingCita);
    // fORMATEAR EL DIV DEL RESUME
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;
    
    const fechaCita = document.createElement('P');
    // Formatear la fecha
    const fechaObj = new Date(fecha);
    // Separa todo
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);


    fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

    
    const horaCita = document.createElement('P');
    if (hora >= "12") {
        abreviatura = 'P.M';
    } else{
        abreviatura = "A.M";
    }
    horaCita.innerHTML = `<span>Hora: </span> ${hora} ${abreviatura}`;

    // Boton para cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('button');
    botonReservar.textContent = 'Reservar cita';
    botonReservar.onclick = reservarCita;
    
    summary.appendChild(nombreCliente);
    summary.appendChild(fechaCita);
    summary.appendChild(horaCita);
    summary.appendChild(botonReservar);
}

async function reservarCita() {
    const { nombre, fecha, hora, servicios, id} = cita;

    const idServicios = servicios.map( servicio => servicio.id);

    const datos = new FormData();

    const reservarButton = document.querySelector('.summary-content .button');
    reservarButton.disabled = true;

    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);

    try {
        // Peticion hacia la api
        const url = '/api/citas';

        // Voy a uasr un metodo POST a esta URL
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "Tu cita fue creada correctamente"
              }).then(() =>{
                setTimeout(() => {
                    window.location.reload();                    
                }, 300);
              })
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al guardar la cita"
          })
    }


}
