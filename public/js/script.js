document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var horasLibres = [];  // Almacena las horas libres deshabilitadas

  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek',
      locale: 'es',
      businessHours: [
          {
              daysOfWeek: [1, 2, 3, 4, 5],
              startTime: '08:00',
              endTime: '12:59',
          },
          {
              daysOfWeek: [1, 2, 3, 4, 5],
              startTime: '14:01',
              endTime: '18:00',
          },
          {
              daysOfWeek: [6],
              startTime: '09:00',
              endTime: '13:00',
          }
      ],
      slotMinTime: "08:00:00",
      slotMaxTime: "18:00:00",

      slotLabelFormat: {
          hour: 'numeric',
          minute: '2-digit',
          omitZeroMinute: false,
          meridiem: 'short'
      },

      slotDuration: '01:00:00',
      slotLabelInterval: '01:00:00',
      snapDuration: '01:00:00',

      dateClick: function(info) {
          var fechaSeleccionada = info.dateStr.split('T')[0];  // Obtener solo la fecha
          var horaCompleta = info.dateStr.split('T')[1];       // Obtener la hora completa con segundos
          var horaSeleccionada = horaCompleta.split(':')[0] + ':' + horaCompleta.split(':')[1];  // Formato HH:MM

          // Verificar si la hora seleccionada está en las horas libres
          var horaLibreEncontrada = horasLibres.some(function(horaLibre) {
              var horaLibreFormateada = horaLibre.hora.split(':')[0] + ':' + horaLibre.hora.split(':')[1]; // Formatear la hora de la hora libre a HH:MM
              return horaLibre.fecha === fechaSeleccionada && horaLibreFormateada === horaSeleccionada;
          });
          cargarPersonalModal();

          if (horaLibreEncontrada) {
              // Mostrar el mensaje si la hora está bloqueada
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
              return; // Salir de la función
          }

          // Obtener la fecha y hora actual
          var ahora = new Date();
          var fechaActual = ahora.toISOString().split('T')[0];
          var horaActual = ahora.getHours();
          var minutosActuales = ahora.getMinutes();

          if (fechaSeleccionada < fechaActual || (fechaSeleccionada === fechaActual && 
            (horaSeleccionada < horaActual || (horaSeleccionada == horaActual && minutosActuales < minutosActuales)))) {
              Swal.fire({
                  title: 'No se puede agendar en una fecha u hora anterior a la actual.',
                  icon: 'error',
                  confirmButtonText: 'Aceptar'
              });
              return; 
          }

          // Verificar si la hora está dentro de las horas laborales
          if (
              (info.date.getDay() >= 1 && info.date.getDay() <= 5 && ((horaSeleccionada >= '08:00' && horaSeleccionada < '12:59') || (horaSeleccionada >= '14:01' && horaSeleccionada <= '18:00'))) ||
              (info.date.getDay() === 6 && (horaSeleccionada >= '09:00' && horaSeleccionada < '13:00'))
          ) {
              document.getElementById('txt_fecha_cita').value = fechaSeleccionada;
              document.getElementById('txt_hora_cita').value = horaSeleccionada;
              $('#citaModal').modal('show');
          } else {
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

      scrollTime: '13:00:00',

      events: {
          url: '../../app/controllers/citas/cargar_citas.php',
          method: 'GET',
          failure: function () {
              alert('Error al cargar eventos');
          }
      },

      eventColor: '#a5dbdd',

      // Cargar los días libres y desactivarlos en el calendario
      eventSources: [
          {
              url: '../../app/controllers/horarios/cargar_dias_libres.php',
              method: 'GET',
              failure: function() {
                  console.error('Error al cargar los días libres');
              },
              success: function(data) {
                  let diasLibres = data;
                  
                  // Guardar las horas libres en el array horasLibres
                  diasLibres.forEach(dia => {
                      horasLibres.push({
                          fecha: dia.fecha,
                          hora: dia.hora
                      });

                      calendar.addEventSource({
                          events: [
                              {
                                  start: dia.fecha + 'T' + dia.hora,
                                  allDay: false,
                                  display: 'background',
                                  overlap: false,
                                  backgroundColor: '#dee2e6',
                                  rendering: 'background'
                              }
                          ]
                      });
                  });

              }
          }
      ]
  });
  calendar.render();
});





document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendario-admin');
  var horasLibres = [];  // Array para almacenar las horas libres

  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',  // Vista inicial
      locale: 'es',
      headerToolbar: {
          center: 'timeGridDay,timeGridWeek,dayGridMonth,listYear' // botones para cambiar entre vistas
      },
      businessHours: [
          {
              daysOfWeek: [1, 2, 3, 4, 5], // Días laborables
              startTime: '08:00',
              endTime: '12:59',
          },
          {
              daysOfWeek: [1, 2, 3, 4, 5],
              startTime: '14:01',
              endTime: '18:00',
          },
          {
              daysOfWeek: [6],
              startTime: '09:00',
              endTime: '13:00',
          }
      ],
      slotMinTime: "08:00:00",
      slotMaxTime: "18:00:00",

      slotLabelFormat: {
          hour: 'numeric',
          minute: '2-digit',
          omitZeroMinute: false,
          meridiem: 'short'
      },

      slotDuration: '01:00:00',
      slotLabelInterval: '01:00:00',
      snapDuration: '01:00:00',

      // Evento de clic en un día u hora del calendario
      dateClick: function(info) {
          var fechaSeleccionada = info.dateStr.split('T')[0];  // Obtener la fecha seleccionada

          // Verificar si la vista actual es mensual
          if (calendar.view.type === 'dayGridMonth') {
              // Mostrar alerta para marcar todo el día como no laborable
              Swal.fire({
                  title: '¿Estás seguro?',
                  text: `Estás a punto de marcar todo el día ${fechaSeleccionada} como no laborable. No se podrán agendar citas.`,
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Sí, marcar todo el día',
                  cancelButtonText: 'Cancelar'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Llamar a la función para marcar todo el día como no laborable
                      marcarDiaCompletoNoLaborable(fechaSeleccionada);
                  }
              });
          } else {
              // Si no es la vista mensual, seguimos permitiendo la selección por hora
              var horaCompleta = info.dateStr.split('T')[1];       // Obtener la hora completa
              var horaSeleccionada = horaCompleta.split(':')[0] + ':' + horaCompleta.split(':')[1];  // Formato HH:MM

              console.log("Fecha seleccionada: ", fechaSeleccionada);
              console.log("Hora seleccionada: ", horaSeleccionada);

              // Verificar si la hora seleccionada está en las horas libres
              var horaLibreEncontrada = horasLibres.some(function(horaLibre) {
                  var horaLibreFormateada = horaLibre.hora.split(':')[0] + ':' + horaLibre.hora.split(':')[1]; // Formato HH:MM
                  return horaLibre.fecha === fechaSeleccionada && horaLibreFormateada === horaSeleccionada;
              });

              if (horaLibreEncontrada) {
                  // Mostrar mensaje si es una hora libre
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
                  return; // Salir de la función
              }

              // Verificar si está dentro de las horas laborales
              if (
                  (info.date.getDay() >= 1 && info.date.getDay() <= 5 && ((horaSeleccionada >= '08:00' && horaSeleccionada < '13:00') || (horaSeleccionada >= '14:01' && horaSeleccionada <= '18:00'))) ||
                  (info.date.getDay() === 6 && (horaSeleccionada >= '09:00' && horaSeleccionada < '13:00'))
              ) {
                  // Asignar valores a los campos de texto y abrir el modal
                  document.getElementById('txt_fecha_cita').value = fechaSeleccionada;
                  document.getElementById('txt_hora_cita').value = horaSeleccionada;
                  cargarPacientesModal();
                  $('#citaModal').modal('show');
              } else {
                  // Mostrar mensaje si está fuera de las horas laborales
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
                  });
              }
          }
      },

      // Evento para manejar clic en citas
      eventClick: function(info) {
          var idCita = info.event.extendedProps.cita_id;

          // Verificar si el evento tiene un cita_id válido (es una cita agendada)
          if (idCita !== undefined) {
              desplegarPanel(idCita);  // Función para cargar el panel lateral
              document.getElementById('cita_id_txt').value = idCita;
          } else {
              // Si no tiene cita_id, mostrar que es un día libre
              Swal.fire({
                  title: 'Este es un día libre, no hay datos de citas.',
                  icon: 'info',
                  confirmButtonText: 'Aceptar'
              });
          }
      },

      scrollTime: '13:00:00',

      events: {
          url: '../../app/controllers/citas/cargar_citas.php', // Ruta al archivo PHP que obtiene las citas
          method: 'GET',
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
          info.el.style.backgroundColor = coloresPorEstado[estadoCita];
      },

      // Cargar los días libres y desactivarlos en el calendario
      eventSources: [
          {
              url: '../../app/controllers/horarios/cargar_dias_libres.php', // Ruta para cargar los días libres
              method: 'GET',
              failure: function() {
                  console.error('Error al cargar los días libres');
              },
              success: function(data) {
                  console.log(data);
                  let diasLibres = data;
                  
                  // Guardar las horas libres en el array horasLibres
                  diasLibres.forEach(dia => {
                      horasLibres.push({
                          fecha: dia.fecha,
                          hora: dia.hora
                      });

                      calendar.addEventSource({
                          events: [
                              {
                                  start: dia.fecha + 'T' + dia.hora,
                                  allDay: false,
                                  display: 'background',
                                  overlap: false,
                                  backgroundColor: '#dee2e6',
                                  rendering: 'background'
                              }
                          ]
                      });
                  });

                  console.log("Horas libres cargadas: ", horasLibres);
              }
          }
      ]
  });

  calendar.render();
});

// Función para marcar todo un día como no laborable
function marcarDiaCompletoNoLaborable(fecha) {
  var horasLaborables = [];

  // Definir las horas laborables de lunes a viernes
  for (var i = 8; i <= 18; i++) {
      if (i !== 13) { // Excluir la hora de almuerzo si corresponde
          horasLaborables.push((i < 10 ? '0' + i : i) + ':00:00');
      }
  }

  // Si es sábado, definir el rango de horas para sábado
  var dayOfWeek = new Date(fecha).getDay();
  if (dayOfWeek === 6) {
      horasLaborables = [];
      for (var i = 9; i < 13; i++) {
          horasLaborables.push(i + ':00:00');
      }
  }

  // Enviar múltiples solicitudes AJAX para cada hora del día
  horasLaborables.forEach(function(hora) {
      $.ajax({
          url: '../controllers/citas/marcar_no_laborable.php',
          type: 'POST',
          data: {
              txt_fecha_cita: fecha,
              txt_hora_cita: hora
          },
          success: function(response) {
              console.log(`Hora ${hora} marcada como no laborable`);
          },
          error: function() {
              console.log(`Error al marcar la hora ${hora} como no laborable`);
          }
      });
  });

  // Mostrar mensaje de éxito al final
  Swal.fire({
      title: 'Éxito',
      text: `Todas las horas del día ${fecha} han sido marcadas como no laborables.`,
      icon: 'success',
      confirmButtonText: 'Aceptar'
  }).then(function() {
      location.reload(); // Recargar la página después de marcar las horas
  });
}

// Función para marcar todo un día como no laborable
function marcarDiaCompletoNoLaborable(fecha) {
  var horasLaborables = [];

  // Definir las horas laborables de lunes a viernes
  for (var i = 8; i <= 18; i++) {
      if (i !== 13) { // Excluir la hora de almuerzo si corresponde
          horasLaborables.push((i < 10 ? '0' + i : i) + ':00:00');
      }
  }

  // Si es sábado, definir el rango de horas para sábado
  var dayOfWeek = new Date(fecha).getDay();
  if (dayOfWeek === 6) {
      horasLaborables = [];
      for (var i = 9; i < 13; i++) {
          horasLaborables.push(i + ':00:00');
      }
  }

  // Enviar múltiples solicitudes AJAX para cada hora del día
  horasLaborables.forEach(function(hora) {
      $.ajax({
          url: '../../app/controllers/horarios/marcar_no_laborable.php',
          type: 'POST',
          data: {
              txt_fecha_cita: fecha,
              txt_hora_cita: hora
          },
          success: function(response) {
              console.log(`Hora ${hora} marcada como no laborable`);
          },
          error: function() {
              console.log(`Error al marcar la hora ${hora} como no laborable`);
          }
      });
  });

  // Mostrar mensaje de éxito al final
  Swal.fire({
      title: 'Éxito',
      text: `Todas las horas del día ${fecha} han sido marcadas como no laborables.`,
      icon: 'success',
      confirmButtonText: 'Aceptar'
  }).then(function() {
      location.reload(); // Recargar la página después de marcar las horas
  });
}



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
          if (data.trim() === 'Correo enviado') {
            Swal.fire({
              title: 'Cita cancelada y correo enviado al paciente',
              width: 600,
              padding: '3em',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500,
            }).then(() => {
              window.location.href = '../../app/views/citas_admin.php';
            });
          } else {
            Swal.fire({
              title: 'Cita cancelada, pero no se pudo enviar el correo',
              width: 600,
              padding: '3em',
              icon: 'warning',
              showConfirmButton: false,
              timer: 1500,
            }).then(() => {
              /* window.location.href = '../../app/views/citas_admin.php'; */
            });
          }
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

function buscarTabla() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("buscarInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabla");
    tr = table.getElementsByTagName("tr");

    // Recorre todas las filas de la tabla y oculta las que no coincidan con el filtro
    for (i = 1; i < tr.length; i++) { // Empieza en 1 para omitir la fila de encabezado
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}

$(document).on('submit', '#asignamientoProfesionalModal', function(e) {
    e.preventDefault(); // Evitar el comportamiento por defecto del formulario

    var formData = $(this).serialize(); // Obtener los datos del formulario

    $.ajax({
        url: '../../app/controllers/citas/confirmar_cita.php',
        type: 'POST',
        data: {
            cita_id_txt: $('#cita_id_txt').val(),  // ID de la cita
            txt_profesional: $('#txt_profesional').val()  // ID del profesional
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Cita confirmada',
                    text: 'Cita confirmada correctamente, se ha asignado un profesional.',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error',
                text: 'Error al confirmar la cita.',
                icon: 'error'
            });
        }
    });
});

