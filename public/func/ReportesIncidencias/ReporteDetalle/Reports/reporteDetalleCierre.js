$(document).ready(function () {
  toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true,
    "timeOut": "2000"
  };

  // Manejo del clic en el botón de imprimir incidencia
  $('#tablaIncidenciasDetalle').on('click', '#imprimir-cierre', function () {
    // Obtener el número de incidencia desde la fila seleccionada
    const fila = $(this).closest('tr');
    const celdas = fila.find('td');
    const numeroCierre = celdas.eq(1).text().trim();
    // Setear el valor en el input de cierre
    $('#num_cierre').val(numeroCierre);

    // Realizar una solicitud AJAX para obtener los datos de la incidencia
    $.ajax({
      // url: 'ajax/getReporteDetalleCierre.php',
      url: 'ajax/ReportesIncidencias/ReporteDetalle/getReporteDetalleCierre.php',
      method: 'GET',
      data: { numero: numeroCierre },
      dataType: 'json',
      success: function (data) {
        console.log("Datos recibidos:", data);
        const cierre = data.find(cie => cie.CIE_numero === numeroCierre);

        if (cierre) {
          try {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const logoUrl = './public/assets/escudo.png';

            function addHeader(doc) {
              doc.setFontSize(9);
              doc.setFont('helvetica', 'normal');

              const fechaImpresion = new Date().toLocaleDateString();
              const headerText2 = 'Subgerencia de Informática y Sistemas';
              const reportTitle = 'REPORTE DE CIERRE';

              const pageWidth = doc.internal.pageSize.width;
              const marginX = 10;
              const marginY = 5; 

              const logoWidth = 25;
              const logoHeight = 25;

              doc.addImage(logoUrl, 'PNG', marginX, marginY, logoWidth, logoHeight);

              doc.setFont('helvetica', 'bold');
              doc.setFontSize(15);
              const titleWidth = doc.getTextWidth(reportTitle);
              const titleX = (pageWidth - titleWidth) / 2;
              const titleY = 25; 

              doc.text(reportTitle, titleX, titleY);
              doc.setLineWidth(0.5);
              doc.line(titleX, titleY + 1, titleX + titleWidth, titleY + 1);

              doc.setFontSize(8);
              doc.setFont('helvetica', 'normal');
              const fechaText = `Fecha de impresión: ${fechaImpresion}`;
              const headerText2Width = doc.getTextWidth(headerText2);
              const fechaTextWidth = doc.getTextWidth(fechaText);

              // Ajustar las posiciones de los textos del encabezado
              const headerText2X = pageWidth - marginX - headerText2Width;
              const fechaTextX = pageWidth - marginX - fechaTextWidth;

              // Reducir este valor para subir el texto "Subgerencia de Informática y Sistemas"
              const headerText2Y = marginY + logoHeight / 3; // Cambié la división para subirlo
              const fechaTextY = headerText2Y + 5;

              doc.text(headerText2, headerText2X, headerText2Y);
              doc.text(fechaText, fechaTextX, fechaTextY);
            }

            addHeader(doc);

            // Detalle del cierre
            const titleY = 45;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(12);
            doc.text('Detalle del cierre:', 20, titleY);

            doc.setFontSize(10);
            doc.text(`Número de incidencia: ${cierre.INC_numero_formato}`, 120, titleY);

            doc.autoTable({
              startY: 48,
              margin: { left: 20 },
              head: [['Campo', 'Descripción']],
              body: [
                [{ content: 'Cierre:', styles: { fontStyle: 'bold' } }, cierre.CIE_numero],
                [{ content: 'Fecha de cierre:', styles: { fontStyle: 'bold' } }, cierre.fechaCierreFormateada],
                [{ content: 'Prioridad:', styles: { fontStyle: 'bold' } }, cierre.PRI_nombre],
                [{ content: 'Documento:', styles: { fontStyle: 'bold' } }, cierre.CIE_documento],
                [{ content: 'Cód. Patrimonial:', styles: { fontStyle: 'bold' } }, cierre.INC_codigoPatrimonial],
                [{ content: 'Nombre del Bien:', styles: { fontStyle: 'bold' } }, cierre.BIE_nombre],
                [{ content: 'Condición:', styles: { fontStyle: 'bold' } }, cierre.CON_descripcion],
                [{ content: 'Diagnóstico:', styles: { fontStyle: 'bold' } }, cierre.CIE_diagnostico],
                [{ content: 'Solución:', styles: { fontStyle: 'bold' } }, cierre.SOL_descripcion],
                [{ content: 'Recomendaciones:', styles: { fontStyle: 'bold' } }, cierre.CIE_recomendaciones],
                [{ content: 'Estado:', styles: { fontStyle: 'bold' } }, cierre.Estado]

              ],
              styles: {
                fontSize: 10,
                cellPadding: 2,
                valign: "middle",
              },
              headStyles: {
                fillColor: [44, 62, 80],
                textColor: [255, 255, 255],
                fontStyle: 'bold',
              },
              columnStyles: {
                0: { cellWidth: 50 }, // Ancho para la columna Campo
                1: { cellWidth: 120 } // Ancho para la columna Descripcion
              }
            });

            const titleFirma = 200;
            doc.setFont('times', 'normal');
            doc.setFontSize(11);

            const textFirmaSello = 'Firma y Sello';
            const textWidthFirmaSello = doc.getTextWidth(textFirmaSello);
            const maxTextWidth = Math.max(textWidthFirmaSello);
            const lineExtraWidth = 20;
            const lineWidth = maxTextWidth + lineExtraWidth;
            const pageWidth = doc.internal.pageSize.width;
            const centerX = (pageWidth - lineWidth) / 2;

            doc.setLineWidth(0.5);
            doc.line(centerX, titleFirma - 5, centerX + lineWidth, titleFirma - 5);
            doc.text(textFirmaSello, centerX + (lineWidth - textWidthFirmaSello) / 2, titleFirma);

            function addFooter(doc, pageNumber, totalPages) {
              doc.setFontSize(8);
              doc.setFont('helvetica', 'italic');
              const footerY = 285;
              doc.setLineWidth(0.05);
              doc.line(20, footerY - 5, doc.internal.pageSize.width - 20, footerY - 5);

              const footerText = 'Sistema de Gestión de Incidencias';
              const pageInfo = `Página ${pageNumber} de ${totalPages}`;
              const pageWidth = doc.internal.pageSize.width;

              doc.text(footerText, 20, footerY);
              doc.text(pageInfo, pageWidth - 20 - doc.getTextWidth(pageInfo), footerY);
            }

            const totalPages = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
              doc.setPage(i);
              addFooter(doc, i, totalPages);
            }
// Establecer las propiedades del documento
doc.setProperties({
  title: "Reporte detallado de cierre.pdf"
});
            // Mostrar mensaje de exito de pdf generado
            toastr.success('Reporte detallado de cierre generado.', 'Mensaje');
            // Retrasar la apertura del PDF y limpiar el campo de entrada
            setTimeout(() => {
              window.open(doc.output('bloburl'), '_blank');
              $('#numeroIncidencia').val(''); // Limpiar el campo de entrada
            }, 2000);
            // doc.save(`incidencia_${numeroIncidencia}.pdf`);
            // $('#modalBuscarIncidencia').modal('hide');
          } catch (error) {
            console.error('Error al generar el reporte detallado de cierre:', error);
            toastr.error('Hubo un error al generar el reporte detallado de cierre.', 'Mensaje de error');
          }
        } else {
          toastr.warning('Aun no se ha cerrado la incidencia.', 'Advertencia');
        }
      },
      error: function (xhr, status, error) {
        toastr.error('Hubo un error al obtener los datos de la incidencia.', 'Mensaje de error');
        console.error('Error al realizar la solicitud AJAX:', error);
      }
    });
  });
});

