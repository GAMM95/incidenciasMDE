$(document).ready(function () {
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true,
    "timeOut": "2000"
  };
});

// Generación del PDF al hacer clic en el botón Por fecha
$('#reporteAreaMasIncidenciasCategoria').click(function () {
  const categoria = $("#categoriaSeleccionada").val();

  console.log('Categoria:', categoria);

  // Verificar si los campos son validos
  if (!validarCamposAreasMasAfectadasCategoria()) {
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
    url: 'ajax/ReportesIncidencias/ReportesOtros/AreasAfectadas/getReporteAreaMasIncidenciaCategoria.php',
    method: 'GET',
    data: {
      categoriaSeleccionada: categoria
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
        toastr.warning('No se encontraron datos para la categor&iacute;a seleccionada.', 'Advertencia');
        return;
      }

      try {
        if (data.length > 0) {
          const { jsPDF } = window.jspdf;
          const doc = new jsPDF('portrait');
          const logoUrl = './public/assets/escudo.png';

          // Funcion para agregar encabezado
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

          // Funcion para agregar el pie de pagina
          function addFooter(doc, pageNumber, totalPages) {
            doc.setFontSize(8);
            doc.setFont('helvetica', 'italic');
            const footerY = 285;
            doc.setLineWidth(0.5);
            doc.line(10, footerY - 5, doc.internal.pageSize.width - 10, footerY - 5);

            const footerText = 'Sistema de Gestión de Incidencias';
            const pageInfo = `Página ${pageNumber} de ${totalPages}`;
            doc.text(footerText, 10, footerY);
            doc.text(pageInfo, doc.internal.pageSize.width - 10 - doc.getTextWidth(pageInfo), footerY);
          }

          // Función para agregar una tabla con la categoría seleccionada
          function addCategoryTable(doc) {
            const categoriaNombre = $('#nombreCategoriaSeleccionada').val() || '-';

            // Crear tabla de categoría seleccionada
            doc.autoTable({
              startY: 40, // Ajustar la altura donde se dibuja la tabla
              margin: { left: 10 },
              head: [['CATEGORÍA SELECCIONADA']],
              body: [[categoriaNombre]],    // Cuerpo con la categoría
              styles: {
                fontSize: 10,
                cellPadding: 3,
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
                0: { cellWidth: 190 } // Ajusta el ancho de la columna
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

          // Agregar encabezado, dato de la categoriaSeleccionada, tabla y pie de página
          addHeader(doc, totalRecords);
          addCategoryTable(doc); 
          addTable(doc);

          // Agregar pie de página en todas las páginas
          const totalPages = doc.internal.getNumberOfPages();
          for (let i = 1; i <= totalPages; i++) {
            doc.setPage(i);
            addFooter(doc, i, totalPages);
          }

          // Establecer las propiedades del documento
          doc.setProperties({
            title: "Reporte de áreas afectadas por categoría.pdf"
          });

          // Mostrar mensaje de exito de pdf generado
          toastr.success('Reporte de las &aacute;reas con m&aacute;s incidencias por caregor&iacute;a generado.', 'Mensaje');

          // Retrasar la apertura del PDF y limpiar el campo de entrada
          setTimeout(() => {
            window.open(doc.output('bloburl'), '_blank');
          }, 2000);
        } else {
          toastr.warning('No se ha encontrado &aacute;reas con m&aacute;s incidencias para la categor&iacute;a seleccionada.', 'Advertencia');
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
});

// Funcion para validar que el campo categoria tenga un valor
function validarCamposAreasMasAfectadasCategoria() {
  var valido = false;
  var mensajeError = '';

  var faltaCategoria = ($('#categoriaSeleccionada').val() !== null && $('#categoriaSeleccionada').val().trim() !== '');

  // Verificar si al menos un campo está lleno
  if (faltaCategoria) {
    valido = true;
  } else {
    mensajeError = 'Debe seleccionar una categor&iacute;a para generar el reporte.';
  }

  if (!valido) {
    toastr.warning(mensajeError.trim());
  }

  return valido;
}