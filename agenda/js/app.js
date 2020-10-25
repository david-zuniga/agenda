const formularioContactos = document.querySelector('#contacto'),
    listadoContactos = document.querySelector('.listado-contactos tbody');

eventListeners();

function eventListeners() {
    //CUando el formulario de crear o editar se ejecuta

    formularioContactos.addEventListener('submit', leerFormulario);

    //Listener para eliminar el boton
    if (listadoContactos)
        listadoContactos.addEventListener('click', eliminarContacto);

    function leerFormulario(e) {
        e.preventDefault();

        //Leer los datos de los imputs
        const nombre = document.querySelector('#nombre').value,
            empresa = document.querySelector('#empresa').value,
            telefono = document.querySelector('#telefono').value,
            accion = document.querySelector('#accion').value;

        if (!nombre || !empresa || !telefono)
        //dos parametros, texto y clase
            monstrarNotificacion('Todos los campos son obligatorios', 'error');
        else {
            //Pasa la validacion, crear llamado a AJAX
            const infoContacto = new FormData();
            infoContacto.append('nombre', nombre)
            infoContacto.append('empresa', empresa)
            infoContacto.append('telefono', telefono)
            infoContacto.append('accion', accion)

            console.log(...infoContacto);

            if (accion === 'crear') {
                //Crearemos un nuevo contacto
                insertarDB(infoContacto);
            } else {
                //Editar contacto
            }
        }
    }
}

/** Inserta en la base de datos via AJAX**/
function insertarDB(datos) {
    //LLamado AJAX

    //Crear objeto
    const xhr = new XMLHttpRequest();

    //Abrir la conexion
    xhr.open('POST', 'includes/modelos/modelo-contactos.php', true);

    //Pasar Datos
    xhr.onload = function() {
        if (this.status === 200) {
            console.log(JSON.parse(xhr.responseText));
            //leer respuesta de PHP
            const respuesta = JSON.parse(xhr.responseText);

            //Inserta un nuevo elemento a la tabla
            const nuevoContacto = document.createElement('tr');
            nuevoContacto.innerHTML = `
                <td>${respuesta.datos.nombre}</td>
                <td>${respuesta.datos.empresa}</td>
                <td>${respuesta.datos.telefono}</td>
                `;

            //Crear contenedor para los botones
            const contenedorAcciones = document.createElement('td');

            //Crear el icono de editar
            const iconoEditar = document.createElement('i');
            iconoEditar.classList.add('fas', 'fa-pen-square');

            //Crea el enlace para editar
            const btnEditar = document.createElement('a');
            btnEditar.appendChild(iconoEditar);
            btnEditar.href = `editar.php?id=${respuesta.datos.id_insertado}`;
            btnEditar.classList.add('btn', 'btn-editar');

            //agregarlo al padre
            contenedorAcciones.appendChild(btnEditar);

            //Crear el icono de eliminar
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('fas', 'fa-trash-alt');

            //Crea el boton para editar
            const btnEliminar = document.createElement('button');
            btnEliminar.appendChild(iconoEliminar);
            btnEliminar.setAttribute('data-id', respuesta.datos.id_insertado);
            btnEliminar.classList.add('btn', 'btn-borrar');

            //agregarlo al padre
            contenedorAcciones.appendChild(btnEliminar);

            //gregarlo al tr
            nuevoContacto.appendChild(contenedorAcciones);

            //Agregarlo con los contactos
            listadoContactos.appendChild(nuevoContacto);

            //Reseter el formulario
            document.querySelector('form').reset();

            //Mostrar notificacion
            monstrarNotificacion('Contacto creado correctamente', 'correcto')
        }
    }

    //Enviar datos
    xhr.send(datos);
}

//Eliminar Contacto
function eliminarContacto(e) {
    if (e.target.parentElement.classList.contains('btn-borrar')) {
        //Tomar el ID
        const id = e.target.parentElement.getAttribute('data-id');

        //preguntar al usuario
        const respuesta = confirm('Estás seguro (a)?');

        if (respuesta) {
            //LLamado AJAX
            //Crear objeto
            const xhr = new XMLHttpRequest();

            //Abrir la conexion
            xhr.open('GET', `includes/modelos/modelo-contactos.php?id=${id}&accion=borrar`, true);

            //Leer la respuesta
            xhr.onload = function() {
                if (this.status === 200) {
                    const resultado = JSON.parse(xhr.responseText);
                    if (resultado.respuesta === 'correcto') {
                        //Eliminar el regitro del DOM
                        e.target.parentElement.parentElement.parentElement.remove();

                        //Mostrar notificacion
                        monstrarNotificacion('Contacto eliminado', 'correcto');
                    } else {
                        //Mostramos una notificacion
                        monstrarNotificacion('Hubo un error...', 'error');
                    }

                }
            }

            //Enviar peticion
            xhr.send();

        } else
            console.log('Dejme pensarlo más');
    }
}

//Notificación en pantalla

function monstrarNotificacion(mensaje, clase) {
    const notificacion = document.createElement('div');
    notificacion.classList.add(clase, 'notificacion', 'sombra');
    notificacion.textContent = mensaje;

    //formulario
    formularioContactos.insertBefore(notificacion, document.querySelector('form legend'));

    //Ocultar y Mostrar la notificación
    setTimeout(() => {
        notificacion.classList.add('visible');

        setTimeout(() => {
            notificacion.classList.remove('visible');
            setTimeout(() => {
                notificacion.remove();
            }, 500);
        }, 3000)
    }, 100)
}