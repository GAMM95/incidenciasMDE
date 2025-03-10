$(document).ready(function () {
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true,
    "timeOut": "2000"
  };
});

// Generación del PDF al hacer clic en el botón "Usuario"
$('#reporteEventosTotalesUsuario').click(function () {
  const usuario = $("#personaEventosTotales").val();

  console.log('Usuario:', usuario);

  // Verificar si los campos son validos
  if (!validarCamposEventosTotalesUsuario()) {
    return;
  }

  var formData = $(this).serializeArray(); // Recopila los datos del formulario
  var dataObject = {}; // Crea un objeto para los datos del formulario
  console.log(dataObject);

  // Recorre los datos del formulario y llena el objeto con los valores
  formData.forEach(function (item) {
    if (item.value.trim() !== '') {
      dataObject[item.name] = item.value;
    }
  });

  // Realizar una solicitud AJAX para obtener los datos de la incidencia
  $.ajax({
    url: 'ajax/ReportesAuditoria/EventosTotales/getReporteEventosTotalesUsuario.php',
    method: 'GET',
    data: {
      personaEventosTotales: usuario
    },
    dataType: 'json',
    success: function (data) {
      console.log("Datos recibidos:", data);

      if (data.error) {
        toastr.error('Error en la solicitud: ' + data.error);
        return;
      }

      // Obtener la cantidad de registros
      const totalRecords = data.length;
      // Verificar si hay registros
      if (totalRecords === 0) {
        toastr.warning('No se encontraron datos para el usuario seleccionado.', 'Advertencia');
        return;
      }

      try {
        if (data.length > 0) {
          const { jsPDF } = window.jspdf;
          const doc = new jsPDF('landscape');
          const logoUrl = './public/assets/escudo.png';

          // Función para agregar encabezado
          function addHeader(doc, totalRecords) {
            const pageWidth = doc.internal.pageSize.width;
            const marginX = 10;
            const marginY = 5;
            const logoWidth = 25;
            const logoHeight = 25;
            const reportTitle = 'REPORTE DE EVENTOS POR USUARIO';
            const headerText2 = 'Subgerencia de Informática y Sistemas';
            const fechaImpresion = new Date().toLocaleDateString();

            // Agregar logo
            doc.addImage(logoUrl, 'PNG', marginX, marginY, logoWidth, logoHeight);

            // Título principal
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(15);
            const titleWidth = doc.getTextWidth(reportTitle);
            const titleX = (pageWidth - titleWidth) / 2;
            doc.text(reportTitle, titleX, marginY + 10);
            doc.setLineWidth(0.5);
            doc.line(titleX, marginY + 11, titleX + titleWidth, marginY + 11);

            // Subtítulo: cantidad de registros
            const subtitleText = `Cantidad de registros: ${totalRecords}`;
            doc.setFontSize(11);
            const subtitleWidth = doc.getTextWidth(subtitleText);
            const subtitleX = (pageWidth - subtitleWidth) / 2;
            doc.text(subtitleText, subtitleX, marginY + 17);

            // Fecha y texto derecho
            doc.setFontSize(8);
            const headerText2Width = doc.getTextWidth(headerText2);
            const fechaText = `Fecha de impresión: ${fechaImpresion}`;
            const fechaTextWidth = doc.getTextWidth(fechaText);
            doc.text(headerText2, pageWidth - marginX - headerText2Width, marginY + logoHeight / 2);
            doc.text(fechaText, pageWidth - marginX - fechaTextWidth, marginY + logoHeight / 2 + 5);
          }

          // Función para agregar pie de página
          function addFooter(doc, pageNumber, totalPages) {
            doc.setFontSize(8);
            doc.setFont('helvetica', 'italic');
            const footerY = 200;
            doc.setLineWidth(0.5);
            doc.line(10, footerY - 5, doc.internal.pageSize.width - 10, footerY - 5);

            const footerText = 'Sistema de Gestión de Incidencias';
            const pageInfo = `Página ${pageNumber} de ${totalPages}`;
            doc.text(footerText, 10, footerY);
            doc.text(pageInfo, doc.internal.pageSize.width - 10 - doc.getTextWidth(pageInfo), footerY);
          }

          // Función para agregar datos del usuario y fechas
          function addUser(doc) {
            const pageWidth = doc.internal.pageSize.width;
            const labels = {
              usuario: 'Usuario: '
            };

            // Obtener valores
            const usuarioNombre = $('#nombreUsuarioEventosTotales').val() || '-';

            // Dibujar datos de usuario
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(11);

            // Usuario

            const usuarioLabelWidth = doc.getTextWidth(labels.usuario);
            const usuarioValueWidth = doc.getTextWidth(` ${usuarioNombre}`);
            const totalUsuarioWidth = usuarioLabelWidth + usuarioValueWidth;
            const startXUsuario = (pageWidth - totalUsuarioWidth) / 2;
            const titleYUsuario = 29;
            doc.text(labels.usuario, startXUsuario, titleYUsuario);
            doc.setFont('helvetica', 'normal');
            doc.text(` ${usuarioNombre}`, startXUsuario + usuarioLabelWidth, titleYUsuario);
          }

          // Función para agregar tabla de datos
          function addTable(doc) {
            let item = 1;
            doc.autoTable({
              startY: 35,
              margin: { left: 4.5 },
              head: [['N°', 'FECHA Y HORA', 'EVENTO', 'TABLA', 'ROL', 'NOMBRE COMPLETO', 'ÁREA', 'IP', 'NOMBRE DEL EQUIPO']],
              body: data.map(reporte => [
                item++,
                reporte.fechaFormateada,
                reporte.AUD_operacion,
                reporte.AUD_tabla,
                reporte.ROL_nombre,
                reporte.NombreCompleto,
                reporte.ARE_nombre,
                reporte.AUD_ip,
                reporte.AUD_nombreEquipo
              ]),
              styles: {
                fontSize: 7.5,
                cellPadding: 2,
                halign: 'center',
                valign: 'middle'
              },
              headStyles: {
                fillColor: [44, 62, 80],
                textColor: [255, 255, 255],
                fontStyle: 'bold',
                halign: 'center'
              },
              columnStyles: {
                0: { cellWidth: 8 }, // Campo de ítem
                1: { cellWidth: 35 }, // Campo de fecha formateada
                2: { cellWidth: 40 }, // Campo de operación
                3: { cellWidth: 30 }, // Campo de tabla
                4: { cellWidth: 22 }, // Campo de rol
                5: { cellWidth: 35 }, // Campo de nombre completo
                6: { cellWidth: 42 }, // Campo area
                7: { cellWidth: 35 }, // Campo de ip
                8: { cellWidth: 40 } // Campo de nombre del equipo
              }
            });
          }

          // Agregar encabezado, datos de usuario y fechas, tabla y pie de página
          addHeader(doc, totalRecords);
          addUser(doc);
          addTable(doc);

          // Agregar pie de página en todas las páginas
          const totalPages = doc.internal.getNumberOfPages();
          for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            addFooter(doc, i, totalPages);
          }

          // Establecer las propiedades del documento PDF
          doc.setProperties({
            title: 'Reporte de eventos por usuario.pdf'
          });

          // Mostrar mensaje de éxito
          toastr.success('Reporte de eventos por usuario generado.', 'Mensaje');

          // Abrir PDF después de una pequeña pausa
          setTimeout(() => {
            window.open(doc.output('bloburl'), '_blank');
          }, 2000);
        } else {
          toastr.warning('No se ha encontrado eventos para el usuario seleccionado.', 'Advertencia');
        }
      } catch (error) {
        toastr.error('Hubo un error al generar reporte.', 'Mensaje de error');
        console.error('Error al generar el PDF:', error.message);
      }
    },
    error: function (xhr, status, error) {
      toastr.error('Hubo un error al obtener datos de los eventos.', 'Mensaje de error');
      console.error('Error al realizar la solicitud AJAX:', error);
    }
  });
});

// Funcion para validar que el campo usuario tenga un valor
function validarCamposEventosTotalesUsuario() {
  var valido = false;
  var mensajeError = '';

  var faltaUsuario = ($('#personaEventosTotales').val() !== null && $('#personaEventosTotales').val().trim() !== '');

  // Verificar si al menos un campo está lleno
  if (faltaUsuario) {
    valido = true;
  } else {
    mensajeError = 'Debe seleccionar un usuario para generar reporte.';
  }

  if (!valido) {
    toastr.warning(mensajeError.trim(), 'Advertencia');
  }

  return valido;
}

