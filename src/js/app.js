let paso = 1;
let pasoInicial = 1;
let pasoFinal = 3;

const cita = {
    id:'',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}
document.addEventListener('DOMContentLoaded', function () {
    iniciarAPP();
});

function iniciarAPP() {
    mostrarSeccion();//Mostrar y ocultar secciones
    tabs();//Cambiar la seccion cuando se presionen los tabs
    botonesPaginador();//agrega o quita 
    paginaSiguiente();
    paginaAnterior();
    consultarAPI();//consulta la API en el backend de php
    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();
    mostrarResumen();

}

function mostrarSeccion() {
    //Ocultar la sección que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');

    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //quitar la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //resaltar el tap 
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {

    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        
        });
    });
}

function botonesPaginador() {
    //capatamos los elementos 
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    // Verificamos el valor de la variable 'paso
    if (paso === 1) {
        // Si el paso es 1, ocultamos el botón de página anterior y mostramos el de página siguiente
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');

        // Si el paso es 3, mostramos el botón de página anterior y ocultamos el de página siguiente
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
        // Para cualquier otro paso, mostramos los dos botones de paginación
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}
function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    })
}
function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;
        
        botonesPaginador();
    })
}
//// Función asincrónica para consultar la API y mostrar servicios en el DOM
async function consultarAPI() {
    try {
        // URL de la API
        const url = '/api/servicios';
        // Realizar la solicitud a la API
        const resultado = await fetch(url);
        // Obtener los datos de la respuesta en formato JSON
        const servicios = await resultado.json();

        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    // Iterar sobre cada servicio en la lista
    servicios.forEach(servicio => {

        // Desestructurar los atributos del servicio
        const { id, nombre, precio, descripcion } = servicio;

        // Crear elementos de párrafo
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `${precio}.00€`;

        // Crear un contenedor div para cada servicio
        const mostrarDescripcion = document.createElement('P');
        mostrarDescripcion.classList.add('descripcion');
        mostrarDescripcion.textContent = descripcion;

        // Crear un contenedor div para cada servicio
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        // Asignar una función al evento click del contenedor div
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }
        // Adjuntar los elementos de párrafo al contenedor div
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        servicioDiv.appendChild(mostrarDescripcion);

        // Adjuntar el contenedor div al contenedor con el id 'servicios' en el DOM
        document.querySelector('#servicios').appendChild(servicioDiv);


    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    //identifica a el elemento que clickamos
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
   
 //comprobar si el servicio ya está seleccionado
    if (servicios.some(agregado => agregado.id === servicio.id)) {
        cita.servicios = servicios.filter( agregado=> agregado.id !== id);
        divServicio.classList.remove('seleccionado');

    } else {
     cita.servicios = [...servicios, servicio];
    divServicio.classList.add('seleccionado');
    }
    //console.log(cita);
}
function idCliente(){
    cita.id =  document.querySelector('#id').value;
}
function nombreCliente(){
    cita.nombre =  document.querySelector('#nombre').value;
}
function seleccionarFecha(){
    const inputFecha =  document.querySelector('#fecha');

    inputFecha.addEventListener('input', function(e) {

        const dia = new Date(e.target.value).getUTCDay();

    if( [6, 0].includes(dia) ){
        e.target.value = '';
        mostrarAlerta('Fines de semañana y cerrados','error','.formulario');
    }else{
        cita.fecha = e.target.value;
    }
});
}
function seleccionarHora(){
        const inputHora = document.querySelector('#hora');
        inputHora.addEventListener('input', function (e){
            const horaCita = e.target.value;
            const hora = horaCita.split(":")[0];
            if(hora < 9|| hora > 20){
                e.target.value = '';
                mostrarAlerta('El horario la clínica es de 09:00de la mañana a 20:00 de la tarde','error','.formulario');
            }else{
                cita.hora= e.target.value;
            }
            //console.log(cita);
        })
    }

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
         alertaPrevia.remove();
    }
    // Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const formulario = document.querySelector(elemento);
    formulario.appendChild(alerta);

    if(desaparece){
        setTimeout( ()=>{
            alerta.remove();
        }, 3000);
    }
}
function mostrarResumen(){

    const resumen =  document.querySelector('.contenido-resumen');

    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos o servicios', 'error', '.contenido-resumen', false);

        return;

    }

    //formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;

    const encabezadoDatos = document.createElement('H3');
    encabezadoDatos.innerHTML = ('Resumen de cita');

    const nombreCli = document.createElement('P');
    nombreCli.innerHTML = `<span>Nombre:</span>${nombre}`;

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span>${fecha}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span>${hora}`;

    const encabezadoServicios = document.createElement('H3');
    encabezadoServicios.innerHTML = ('Resumen de los servicios');

    resumen.append(encabezadoDatos);
    resumen.appendChild(nombreCli);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.append(encabezadoServicios);

    servicios.forEach(servicio => {
        const { id, precio, nombre, descripcion } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;
        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span>${precio}€`;

        

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        resumen.appendChild(contenedorServicio);

    });

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;
    resumen.appendChild(botonReservar);
}
async function reservarCita() {
    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map(servicio => servicio.id);
    //console.log(idServicios);

    const datos = new FormData();

    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    try {
        const url = '/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        console.log(resultado.resultado);

        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita Reservada",
                text:'Tu cita ha sido creada con exito',
                button: 'OK'
            }).then(() => {
                window.location.reload();
            })
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Fail",
            text: 'Hubo un error al guardar tu cita'
        })

    }

}
