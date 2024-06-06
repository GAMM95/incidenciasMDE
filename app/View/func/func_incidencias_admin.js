$(document).ready(function () {
  console.log("FETCHING CATEGORIES");
  $.ajax({
    url: 'ajax/getCategoryData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#categoria');
      select.empty();
      $.each(data, function (index, value) {
        console.log(value); // Añade esta línea para depurar y verificar las claves recibidas
        select.append('<option value="' + value.CAT_codigo + '">' + value.CAT_nombre + '</option>');
      });
      document.getElementById('categoria').value = '<?php echo isset($incidenciaRegistrada) ? $incidenciaRegistrada["CAT_codigo"] : ""; ?>';
    },
    error: function (error) {
      console.error(error);
    }
  });
});


$(document).ready(function () {
  console.log("FETCHING")
  $.ajax({
    url: 'ajax/getAreaData.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      var select = $('#area');
      select.empty();
      $.each(data, function (index, value) {
        select.append('<option value="' + value.ARE_codigo + '">' + value.ARE_nombre + '</option>');
      });
      document.getElementById('area').value = '<?php echo $incidenciaRegistrada ? $incidenciaRegistrada["ARE_codigo"] : "; ?>';
    },
    error: function (error) {
      console.error(error);
    }
  });
});

$(document).ready(function () {
  console.log("FETCHING")
  $.ajax({
    url: '../../../ajax/getLastIncidencia.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      console.log(data);
      var select = $('#numero_incidencia');
      if (select.val() === '') {
        select.empty();
        select.val(data.INC_codigo);
      }
    },
    error: function (error) {
      console.error(error);
    }
  });
});

function limpiarCampos() {
  // Obtener el formulario por su ID
  const form = document.getElementById('formIncidencia');
  // Limpiar los campos del formulario
  form.reset();
}
const btnLimpiar = document.getElementById('limpiarCampos');
btnLimpiar.addEventListener('click', limpiarCampos);

function nuevoRegistro() {
  const form = document.getElementById('formIncidencia');

  // Restablecer el formulario
  form.reset();
}
// Asignar el evento 'click' al botón 'Nuevo Registro'
const btnNuevo = document.getElementById('nuevoRegistro');
btnNuevo.addEventListener('click', nuevoRegistro);

//GUARDAR DATOS
$(document).ready(function () {
  $("#guardar-incidencia").on("click", function () {
    // Obtener los datos del formulario
    var formData = $("form").serialize(); // Obtener los datos del formulario

    $.ajax({
      url: "consultar-incidencia.php", // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
      type: "POST",
      data: formData,
      success: function (response) {
        // Manejar la respuesta del servidor si es necesario
        alert("Datos guardados exitosamente");
        // Puedes limpiar el formulario si lo deseas
        $("form")[0].reset();
      },
      error: function (xhr, status, error) {
        // Manejar los errores si la solicitud falla
        console.error(error);
        alert("Error al guardar los datos. Por favor, inténtalo de nuevo.");
      }
    });
  });
});