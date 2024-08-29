document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek',
      locale: 'es',
      businessHours: [
          {
              daysOfWeek: [1, 2, 3, 4, 5], // Días laborables
              startTime: '08:00', // Hora de inicio
              endTime: '12:59',   // Hora de finalización antes del descanso
          },
          {
              daysOfWeek: [1, 2, 3, 4, 5], // Días laborables
              startTime: '14:01', // Hora de inicio después del descanso
              endTime: '18:00',   // Hora de finalización
          },
          {
              daysOfWeek: [6], // Días laborables
              startTime: '09:00', // Hora de inicio después del descanso
              endTime: '13:00',   // Hora de finalización
          }
      ],
      slotMinTime: "08:00:00",
      slotMaxTime: "18:00:00",

      slotLabelFormat: {
          hour: 'numeric',
          minute: '2-digit',
          omitZeroMinute: false, // Esto evita que las etiquetas omitan los minutos en 0
          meridiem: 'short' // Agrega "am" o "pm" después de la hora
      },

      slotDuration: '01:00:00', // Establece la duración de la ranura en 1 hora
      slotLabelInterval: '01:00:00', // Establece el intervalo de las etiquetas de ranura en 1 hora
      snapDuration: '01:00:00', // Establece la duración del "acoplamiento" en 1 hora para evitar intervalos de media hora      

      dateClick: function(info) {
          var diaSemana = info.date.getDay();

          // Dividir la fecha y la hora
          var fechaSeleccionada = info.dateStr.split('T')[0]; // Obtener la parte de la fecha
          var horaCompleta = info.dateStr.split('T')[1]; // Obtener la parte de la hora completa (con zona horaria)
          var horaSeleccionada = horaCompleta.split(':')[0]; // Obtener la hora
          var minutosSeleccionados = horaCompleta.split(':')[1]; // Obtener los minutos

          // Obtener la fecha y hora actual
          var ahora = new Date();
          var fechaActual = ahora.toISOString().split('T')[0]; // Obtener la fecha actual
          var horaActual = ahora.getHours(); // Obtener la hora actual
          var minutosActuales = ahora.getMinutes(); // Obtener los minutos actuales

          // Comparar la fecha y hora seleccionadas con la actual
          if (fechaSeleccionada < fechaActual || (fechaSeleccionada === fechaActual && (horaSeleccionada < horaActual || (horaSeleccionada == horaActual && minutosSeleccionados < minutosActuales)))) {
              Swal.fire({
                  title: 'No se puede agendar en una fecha u hora anterior a la actual.',
                  icon: 'error',
                  confirmButtonText: 'Aceptar'
              });
              return; // Salir de la función si la fecha u hora es anterior
          }

          // Verificar si la hora seleccionada está dentro de las horas laborables
          if (
              (diaSemana >= 1 && diaSemana <= 5 && ((horaSeleccionada >= '08' && horaSeleccionada < '13') || (horaSeleccionada >= '14' && horaSeleccionada <= '18'))) ||
              (diaSemana === 6 && horaSeleccionada >= '09' && horaSeleccionada < '13')
          ) {
              // Formatear la hora y los minutos
              var horaFormateada = horaSeleccionada + ':' + minutosSeleccionados;

              // Asignar valores a los campos de texto
              document.getElementById('txt_fecha_cita').value = fechaSeleccionada;
              document.getElementById('txt_hora_cita').value = horaFormateada;

              // Mostrar el modal
              $('#citaModal').modal('show');
          } else {
              // Fuera de las horas laborables, mostrar un mensaje de error
              Swal.fire({
                  title: 'Esta hora no está disponible para citas.',
                  width: 600,
                  padding: '3em',
                  color: '#716add',
                  background: '#fff',
                  backdrop: `
                      rgba(0,0,123,0.4)
                      url("../../public/img/giphy.gif")
                      left top
                      no-repeat
                  `
              });
          }
      },

      scrollTime: '13:00:00', // Establece el inicio del scroll a la hora de inicio laborable

      events: {
          url: '../../app/controllers/citas/cargar_citas.php', // Ruta al archivo PHP que obtiene las citas
          method: 'GET', // Método HTTP para la solicitud
          failure: function () {
              alert('Error al cargar eventos');
          }
      },

      eventColor: '#a5dbdd',

  });
  calendar.render();
});





  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendario-admin');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: {
        center: 'timeGridDay,timeGridWeek,dayGridMonth,listYear' // buttons for switching between views
      },
      businessHours: [
        {
            daysOfWeek: [1, 2, 3, 4, 5], // Días laborables
            startTime: '08:00', // Hora de inicio
            endTime: '12:59',   // Hora de finalización antes del descanso
        },
        {
            daysOfWeek: [1, 2, 3, 4, 5], // Días laborables
            startTime: '14:01', // Hora de inicio después del descanso
            endTime: '18:00',   // Hora de finalización
        },
        {
            daysOfWeek: [6], // Días laborables
            startTime: '09:00', // Hora de inicio después del descanso
            endTime: '13:00',   // Hora de finalización
        }
    ],
      slotMinTime: "08:00:00",
      slotMaxTime: "18:00:00",

      slotLabelFormat: {
        hour: 'numeric',
        minute: '2-digit',
        omitZeroMinute: false, // Esto evita que las etiquetas omitan los minutos en 0
        meridiem: 'short' // Agrega "am" o "pm" después de la hora
        },

        slotDuration: '01:00:00', // Establece la duración de la ranura en 1 hora
        slotLabelInterval: '01:00:00', // Establece el intervalo de las etiquetas de ranura en 1 hora
        snapDuration: '01:00:00', // Establece la duración del "acoplamiento" en 1 hora para evitar intervalos de media hora      
      
        eventClick: function(info) {

          var idCita = info.event.extendedProps.cita_id;          
          desplegarPanel(idCita);
          document.getElementById('cita_id_txt').value = idCita;
         },

         dateClick: function(info) {
          var diaSemana = info.date.getDay();
      
          // Dividir la fecha y la hora
          var fechaSeleccionada = info.dateStr.split('T')[0]; // Obtener la parte de la fecha
          var horaCompleta = info.dateStr.split('T')[1]; // Obtener la parte de la hora completa (con zona horaria)
          var horaSeleccionada = horaCompleta.split(':')[0]; // Obtener la hora
          var minutosSeleccionados = horaCompleta.split(':')[1]; // Obtener los minutos
    
          // Verificar si la hora seleccionada está dentro de las horas laborables
          if (
            (diaSemana >= 1 && diaSemana <= 5 && ((horaSeleccionada >= '08' && horaSeleccionada < '13') || (horaSeleccionada >= '14' && horaSeleccionada <= '18'))) ||
            (diaSemana === 6 && horaSeleccionada >= '09' && horaSeleccionada < '13')
          ) {
            // Formatear la hora y los minutos
            var horaFormateada = horaSeleccionada + ':' + minutosSeleccionados;
    
            // Asignar valores a los campos de texto
            document.getElementById('txt_fecha_cita').value = fechaSeleccionada;
            document.getElementById('txt_hora_cita').value = horaFormateada;

            cargarPacientesModal();
            // Mostrar el modal
            $('#citaModal').modal('show');
          } else {
            // Fuera de las horas laborables, no hacer nada o mostrar un mensaje de error
            // Por ejemplo, puedes mostrar una alerta
            //Swal.fire('Horario no disponible', 'Esta hora no está disponible para citas.', 'error');
            Swal.fire({
              title:'Esta hora no está disponible para citas.',
              width: 600,
              padding: '3em',
              color: '#716add',
              background: '#fff',
              backdrop: `
                rgba(0,0,123,0.4)
                url("../../public/img/giphy.gif")
                left top
                no-repeat
              `
            })
            
          }
        },
        
    scrollTime: '13:00:00', // Establece el inicio del scroll a la hora de inicio laborable

      events: {
        url: '../../app/controllers/citas/cargar_citas.php', // Ruta al archivo PHP que obtiene las citas
        method: 'GET', // Método HTTP para la solicitud
        failure: function () {
            alert('Error al cargar eventos');
        }
    },

    eventDidMount: function(info) {
      var estadoCita = info.event.extendedProps.estado;

      // Definir colores según los estados de la cita
      var coloresPorEstado = {
          'En espera de confirmación': 'blue',
          'Confirmada': 'green',
          'Cancelada': 'red',
          'Cumplida': 'gray',
          'Incumplida': '#EEB100'
      };

      // Establecer el color del evento según el estado
      info.el.style.backgroundColor = coloresPorEstado[estadoCita] || 'pink';
  },


    });
    calendar.render();
  });




  function cargarCitasPaciente(id) {
    var fd= new FormData();
    fd.append('paciente_id', id);
    $.ajax({
        type:'POST',
        url: '../../app/controllers/citas/cargar_citas_paciente.php',
        data: fd,
        cache: false,
        contentType:false,
        processData:false
    })
    .done(function(data){   
      $("#cards-citas").html(data);
    })
    .fail(function()
    {
        alert("Error al procesar la información");
    });
    return false;
}

function cancelarCitaPaciente(idCita, idPaciente) {
  Swal.fire({
    title: '¿Está seguro que desea cancelar esta cita?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, cancelar',
    cancelButtonText: 'No, mantener cita',
  }).then((result) => {
    if (result.isConfirmed) {
      var fd = new FormData();
      fd.append('id', idCita);
      $.ajax({
        type: 'POST',
        url: '../../app/controllers/citas/cancelar_cita.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
      })
        .done(function (data) {
          cargarCitasPaciente(idPaciente);
        })
        .fail(function () {
          Swal.fire({
            title: 'Error al procesar la información',
            icon: 'error',
          });
        });
    }
  });
  return false;
}

function cancelarCitaAdmin(idCita) {
  Swal.fire({
    title: '¿Está seguro que desea cancelar esta cita?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, cancelar',
    cancelButtonText: 'No, mantener cita',
  }).then((result) => {
    if (result.isConfirmed) {
      var fd = new FormData();
      fd.append('id', idCita);
      $.ajax({
        type: 'POST',
        url: '../../app/controllers/citas/cancelar_cita.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
      })
        .done(function (data) {
          Swal.fire({
            title: 'Cita cancelada',
            width: 600,
            padding: '3em',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            window.location.href = '../../app/views/citas_admin.php';
          });
        })
        .fail(function () {
          Swal.fire({
            title: 'Error al procesar la información',
            icon: 'error',
          });
        });
    }
  });
  return false;
}

function cerrarSesion() {
  window.location.href = '../../app/controllers/cerrar_sesion.php';
}

function desplegarPanel(id) {
  var fd= new FormData();
  fd.append('cita_id', id);
  $.ajax({
      type:'POST',
      url: '../../app/controllers/citas/panel_por_cita.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#formulario-admin").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function cargarPacientesModal() {
  var fd= new FormData();
  $.ajax({
      type:'POST',
      url: '../../app/controllers/citas/cargar_pacientes.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#txt_paciente_id").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function cargarPersonalModal() {
  var fd= new FormData();
  $.ajax({
      type:'POST',
      url: '../../app/controllers/citas/cargar_personal_modal.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#txt_profesional").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function citaCumplida(idCita) {
  Swal.fire({
    title: '¿Esta cita se ha cumplido?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, cumplida',
    cancelButtonText: 'No, incumplida',
  }).then((result) => {
    if (result.isConfirmed) {
      var parametro = 'Cumplida';
      enviarCitaCumplida(idCita, parametro);
    } else {
      var parametro = 'Incumplida';
      enviarCitaCumplida(idCita, parametro);
    }
  });
}

function enviarCitaCumplida(idCita, parametro) {
  var fd = new FormData();
  fd.append('id', idCita);
  fd.append('parametro', parametro);
  $.ajax({
    type: 'POST',
    url: '../../app/controllers/citas/cumplimiento_cita.php',
    data: fd,
    cache: false,
    contentType: false,
    processData: false,
  })
    .done(function (data) {
      location.href="../views/citas_admin.php";
    })
    .fail(function () {
      alert("Error al procesar la información");
    });
  return false;
}


let selectedMenuItem = null;

  function selectMenuItem(menuItem) {
    if (selectedMenuItem) {
      selectedMenuItem.classList.remove("selected");
    }
  menuItem.classList.add("selected");
  selectedMenuItem = menuItem;
}

function desplegarPanelCorreo() {
  var fd= new FormData();
  $.ajax({
      type:'POST',
      url: '../../app/controllers/correos/panel_correo.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#form-correo-admin").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function desplegarPanelPaciente() {
  var fd= new FormData();
  $.ajax({
      type:'POST',
      url: '../../app/controllers/pacientes/panel_paciente.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#form-correo-admin").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function agregarNuevoEjercicio()
{
var imagen = document.getElementById('imagen').files[0];
var nombre = document.getElementById('nombre').value;
var descripcion = document.getElementById('descripcion').value;
var contraindicacion = document.getElementById('contraindicacion').value;
var id_usuario = document.getElementById('id_usuario').value;

var formData = new FormData();
formData.append('imagen', imagen); 
formData.append('nombre', nombre); 
formData.append('descripcion', descripcion); 
formData.append('contraindicacion', contraindicacion); 
formData.append('id_usuario', id_usuario); 
$.ajax({
    url: '../../app/controllers/ejercicios/agregar_ejercicio.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
   })
   .done(function(data){   
    if (data == 1) {
      Swal.fire({
        title: "Ejercicio Guardado",
        text: "El ejercicio se agregó con éxito",
        type: "success",
        confirmButtonText: "Aceptar"
      }).then(function() {
        // Redireccionar después de hacer clic en Aceptar
        location.href = "../views/ejercicios.php";
      });
        } else {
            Swal.fire("Error al guardar", "No se agregó el ejercicio", "error");
        }   
    })
    .fail(function()
    {
        alert("Error al procesar la información");
    });

}

function mostrarImagenSeleccionada() {
  var input = document.getElementById('imagen');
  var label = document.getElementById('imagen-label');
  
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
          label.style.backgroundImage = 'url(' + e.target.result + ')';
          label.style.backgroundSize = 'cover';
      };
      
      reader.readAsDataURL(input.files[0]);
  } else {
      label.style.backgroundImage = 'none'; // Elimina el fondo de imagen
  }
}

function cargarTodosEjercicios(parametro) {
  var fd= new FormData();
  fd.append('parametro', parametro);
  $.ajax({
      type:'POST',
      url: '../../app/controllers/ejercicios/cargar_ejercicios.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#contenedor-ejercicios").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function cargarTablaPacientes() {
  var fd= new FormData();
  $.ajax({
      type:'POST',
      url: '../../app/controllers/pacientes/cargar_pacientes.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#form-correo-admin").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function cargarTablaHistorial(idPaciente) {
  var fd= new FormData();
  fd.append('idPaciente', idPaciente);
  $.ajax({
      type:'POST',
      url: '../../app/controllers/pacientes/historial_pacientes.php',
      data: fd,
      cache: false,
      contentType:false,
      processData:false
  })
  .done(function(data){   
    $("#form-correo-admin").html(data);
  })
  .fail(function()
  {
      alert("Error al procesar la información");
  });
  return false;
}

function idPacienteHistorial(idPaciente) {
 
    $("#paciente_id").val(idPaciente);

}

