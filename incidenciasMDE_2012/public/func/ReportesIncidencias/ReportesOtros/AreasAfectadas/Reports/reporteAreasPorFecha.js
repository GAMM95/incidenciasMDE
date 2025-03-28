$(document).ready(function () {
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true,
    "timeOut": "2000"
  };
});

// Generación del PDF al hacer clic en el botón Por fecha
$('#reporteAreaMasIncidenciasFecha').click(function () {
  const fechaInicio = $('#fechaInicioAreaMasAfectada').val();
  const fechaFin = $('#fechaFinAreaMasAfectada').val();

  console.log('Fecha Inicio:', fechaInicio);
  console.log('Fecha Fin:', fechaFin);

  // Verificar si los campos son validos
  if (!validarCamposAreasMasAfectadasFecha()) {
    return; // Detiene el envío si los campos fechas no son válidos
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

  // Realizar una solicitud AJAX para obtener los datos del cierre de incidencia
  $.ajax({
    url: 'ajax/ReportesIncidencias/ReportesOtros/AreasAfectadas/getReporteAreaMasIncidenciaFecha.php',
    method: 'GET',
    data: {
      fechaInicioAreaMasAfectada: fechaInicio,
      fechaFinAreaMasAfectada: fechaFin
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
        toastr.warning('No se encontraron datos para el rango de fecha ingresado.', 'Advertencia');
        return;
      }

      try {
        if (data.length > 0) {
          const { jsPDF } = window.jspdf;
          const doc = new jsPDF('portrait');
          const logoUrl = './public/assets/escudo.png';

          // Funcion para agregar el encabezado del PDF
          function addHeader(doc, totalRecords) {
            doc.setFontSize(9);
            doc.setFont('helvetica', 'normal');
            const fechaImpresion = new Date().toLocaleDateString();
            const headerText2 = 'Subgerencia de Informática y Sistemas';
            const reportTitle = 'ÁREAS CON MÁS INCIDENCIAS';

            const pageWidth = doc.internal.pageSize.width;
            const marginX = 10;
            const marginY = 5;
            const logoWidth = 25;
            const logoHeight = 25;

            // Agregar logo
            doc.addImage(logoUrl, 'PNG', marginX, marginY, logoWidth, logoHeight);

            // Titulo principal
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(12);
            const titleWidth = doc.getTextWidth(reportTitle);
            const titleX = (pageWidth - titleWidth) / 2;
            const titleY = 20;
            doc.text(reportTitle, titleX, titleY);
            doc.setLineWidth(0.5);
            doc.line(titleX, titleY + 1, titleX + titleWidth, titleY + 1);

            // Subtítulo: cantidad de registros
            const subtitleText = `Cantidad de registros: ${totalRecords}`;
            doc.setFontSize(11);
            const subtitleWidth = doc.getTextWidth(subtitleText);
            const subtitleX = (pageWidth - subtitleWidth) / 2;
            doc.text(subtitleText, subtitleX, marginY + 25);

            // Fecha de impresion 
            doc.setFontSize(8);
            doc.setFont('helvetica', 'normal');
            const fechaText = `Fecha de impresión: ${fechaImpresion}`;
            const headerText2Width = doc.getTextWidth(headerText2);
            const fechaTextWidth = doc.getTextWidth(fechaText);
            const headerText2X = pageWidth - marginX - headerText2Width;
            const fechaTextX = pageWidth - marginX - fechaTextWidth;
            const headerText2Y = marginY + logoHeight / 2;
            const fechaTextY = headerText2Y + 5;

            doc.text(headerText2, headerText2X, headerText2Y);
            doc.text(fechaText, fechaTextX, fechaTextY);
          }

          // Funcion para editar el pie de página del PDF
          function addFooter(doc, pageNumber, totalPages) {
            doc.setFontSize(8);
            doc.setFont('helvetica', 'italic');
            const footerY = 285;
            doc.setLineWidth(0.5);
            doc.line(10, footerY - 5, doc.internal.pageSize.width - 10, footerY - 5);

            const footerText = 'Sistema de Gestión de Incidencias';
            const pageInfo = `Página ${pageNumber} de ${totalPages}`;
            const pageWidth = doc.internal.pageSize.width;

            doc.text(footerText, 10, footerY);
            doc.text(pageInfo, pageWidth - 10 - doc.getTextWidth(pageInfo), footerY);
          }

          // Funcion para  agregar la tabla de fechas
          function addFechasTable(doc) {
            // Subtitulos de fechas
            const fechaInicioText = 'Fecha inicial:';
            const fechaFinText = 'Fecha final:';

            // Obtener las fechas en formato original
            const fechaInicioOriginal = $('#fechaInicioAreaMasAfectada').val();
            const fechaFinOriginal = $('#fechaFinAreaMasAfectada').val();

            // Función para formatear la fecha a dd/mm/aaaa
            function formatearFecha(fecha) {
              const partes = fecha.split('-'); // Suponiendo que las fechas están en formato aaaa-mm-dd
              return `${partes[2]}/${partes[1]}/${partes[0]}`; // Retorna dd/mm/aaaa
            }

            // Formatear las fechas
            const fechaInicioValue = formatearFecha(fechaInicioOriginal);
            const fechaFinValue = formatearFecha(fechaFinOriginal);

            // Texto completo para la fila de la tabla
            const fechaRango = `${fechaInicioText} ${fechaInicioValue}     -     ${fechaFinText} ${fechaFinValue}`;

            // Crear tabla de fechas con el rango ingresado
            doc.autoTable({
              startY: 40, // Ajustar la altura donde se dibuja la tabla
              margin: { left: 10 },
              head: [['RANGO DE FECHAS INGRESADO']], // Título de la tabla
              body: [[fechaRango]], // Contenido de la tabla con el rango de fechas
              styles: {
                fontSize: 10,
                cellPadding: 3,
                halign: 'center',
                valign: 'middle'
              },
              headStyles: {
                fillColor: [44, 62, 80], // Color de fondo del encabezado
                textColor: [255, 255, 255], // Color del texto del encabezado
                fontStyle: 'bold',
                halign: 'center'
              },
              columnStyles: {
                0: { cellWidth: 190 } // Ajusta el ancho de la columna para abarcar todo el espacio
              }
            });
          }

          // Funcion para agregar la tabla de datos
          function addTable(doc) {
            let item = 1;
            doc.autoTable({
              startY: 60, // Altura de la tabla respecto a la parte superior
              margin: { left: 10 },
              head: [['N°', 'Área afectada', 'Total de incidencias']],
              body: data.map(reporte => [
                item++,
                reporte.areaMasIncidencia,
                reporte.cantidadIncidencias,
              ]),
              styles: {
                fontSize: 10,
                cellPadding: 3,
                halign: 'center',
                valign: 'middle'
              },
              headStyles: {
                fillColor: [119, 146, 170],
                textColor: [255, 255, 255],
                fontStyle: 'bold',
                halign: 'center'
              },
              columnStyles: {
                0: { cellWidth: 30 }, // Ancho para la columna item
                1: { cellWidth: 100 }, // Ancho para la columna area
                2: { cellWidth: 60 }, // Ancho para la columna cantidad
              }
            });
          }

          addHeader(doc, totalRecords);
          addFechasTable(doc);
          addTable(doc);

          const totalPages = doc.internal.getNumberOfPages();
          for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            addFooter(doc, i, totalPages);
          }

          // Establecer las propiedades del documento
          doc.setProperties({
            title: "Reporte de áreas afectadas por fechas.pdf"
          });

          // Mostrar mensaje de exito de pdf generado
          toastr.success('Reporte de las 10 primeras &aacute;reas con m&aacute;s incidencias generado.', 'Mensaje');
          // Retrasar la apertura del PDF y limpiar el campo de entrada
          setTimeout(() => {
            window.open(doc.output('bloburl'), '_blank');
            $('#fechaInicio').val('');
            $('#fechaFin').val('');
          }, 2000);
        } else {
          toastr.warning('No se ha encontrado &aacute;reas con m&aacute;s incidencias para las fechas seleccionadas.', 'Advertencia');
        }
      } catch (error) {
        toastr.error('Hubo un error al generar reporte.', 'Mensaje de error');
        console.error('Error al generar el PDF:', error.message);
      }
    },
    error: function (xhr, status, error) {
      toastr.error('Hubo un error al obtener &aacute;reas con m&aacute;s incidencias.', 'Mensaje de error');
      console.error('Error al realizar la solicitud AJAX:', error);
    }
  });


  function validarCamposAreasMasAfectadasFecha() {
    var valido = false;
    var mensajeError = '';

    var fechaInicioSeleccionada = ($('#fechaInicioAreaMasAfectada').val() !== null && $('#fechaInicioAreaMasAfectada').val().trim() !== '');
    var fechaFinSeleccionada = ($('#fechaFinAreaMasAfectada').val() !== null && $('#fechaFinAreaMasAfectada').val().trim() !== '');

    // Verificar si al menos un campo está lleno
    if (fechaInicioSeleccionada || fechaFinSeleccionada) {
      valido = true;
    } else {
      mensajeError = 'Debe ingresar las fechas para generar reporte.';
    }

    if (!valido) {
      toastr.warning(mensajeError.trim());
    }

    return valido;
  }


  function validarFechasAreasMasAfectadasFecha() {
    // Obtener valores de los campos de fecha
    const fechaInicio = new Date($('#fechaInicioAreaMasAfectada').val());
    const fechaFin = new Date($('#fechaFinAreaMasAfectada').val());

    // Obtener la fecha actual
    const fechaHoy = new Date();

    // Validar la fecha de inicio y fin
    let valido = true;
    let mensajeError = '';

    // Bloquear fechas posteriores a la fecha actual
    if (fechaInicio > fechaHoy) {
      mensajeError = 'La fecha de inicio no puede ser posterior a la fecha actual.';
      valido = false;
    }

    if (fechaFin > fechaHoy) {
      mensajeError = 'La fecha de fin no puede ser posterior a la fecha actual.';
      valido = false;
    }

    // Verificar que la fecha de fin sea posterior a la fecha de inicio
    if (fechaInicio && fechaFin && fechaFin < fechaInicio) {
      mensajeError = 'La fecha de fin debe ser posterior a la fecha de inicio.';
      valido = false;
    }

    // Mostrar mensaje de error con Toastr si la validación falla
    if (!valido) {
      toastr.warning(mensajeError.trim(), 'Advertencia');
    }

    return valido;
  }

  // Agregar eventos para validar fechas cuando cambien
  $('#fechaInicioAreaMasAfectada, #fechaFinAreaMasAfectada').on('change', function () {
    validarFechasAreasMasAfectadasFecha();
  });
});
