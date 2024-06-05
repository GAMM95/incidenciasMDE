$(document).ready(function () {
  $('tr').click(function () {
    var cod = $(this).find('th[data-codarea]').data('codarea');
    var nom = $(this).find('th[data-area]').data('area');

    $('#txt_codigoArea').val(cod);
    $('#txt_nombreArea').val(nom);
    $(this).addClass('bg-blue-200 font-semibold');
    $('tr').not(this).removeClass('bg-blue-200 font-semibold');
  });
});

function nuevoRegistro() {
  const form = document.getElementById('formarea');
  form.reset();
  $('#txt_codigoArea').val('');
  $('tr').removeClass('bg-blue-200 font-semibold');
}

const btnNuevo = document.getElementById('nuevo-registro');
btnNuevo.addEventListener('click', nuevoRegistro);

// GUARDAR DATOS
$("#guardar-area").on("click", function (e) {
  e.preventDefault();
  var formData = $("#formarea").serialize();

  $.ajax({
    url: "modulo-area.php?action=registrar",
    type: "POST",
    data: formData,
    success: function (response) {
      toastr.success("Área guardada exitosamente");
      setTimeout(function () {
        location.reload();
      }, 1500);
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
      toastr.error("Error al guardar el área");
    }
  });
});

// EDITAR DATOS
$("#editar-area").on("click", function (e) {
  e.preventDefault();
  var formData = $("#formarea").serialize();

  $.ajax({
    url: "modulo-area.php?action=editar",
    method: "POST",
    data: formData,
    success: function (response) {
      toastr.success("Área actualizada exitosamente");
      setTimeout(function () {
        location.reload();
      }, 1500);
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
      toastr.error("Error al actualizar el área");
    }
  });
});
