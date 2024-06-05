$(document).ready(function () {
  $('tr').click(function () {
    var cod = $(this).find('th[data-codcategoria]').data('codcategoria');
    var nom = $(this).find('th[data-categoria]').data('categoria');

    $('#txt_codigoCategoria').val(cod);
    $('#txt_nombreCategoria').val(nom);
    $(this).addClass('bg-blue-200 font-semibold');
    $('tr').not(this).removeClass('bg-blue-200 font-semibold');
  });

  function nuevoRegistro() {
    const form = document.getElementById('formcategoria');
    form.reset();
    $('#txt_codigoCategoria').val('');
    $('tr').removeClass('bg-blue-200 font-semibold');
  }

  const btnNuevo = document.getElementById('nuevo-registro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  $("#guardar-categoria").on("click", function (e) {
    e.preventDefault();
    var formData = $("#formcategoria").serialize();

    $.ajax({
      url: "modulo-categoria.php?action=registrar",
      method: "POST",
      data: formData,
      success: function (response) {
        toastr.success("Categoría guardada exitosamente");
        setTimeout(function () {
          location.reload();
        }, 1500);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al guardar la categoría");
      }
    });
  });

  $("#editar-categoria").on("click", function (e) {
    e.preventDefault();
    var formData = $("#formcategoria").serialize();

    $.ajax({
      url: "modulo-categoria.php?action=editar",
      method: "POST",
      data: formData,
      success: function (response) {
        toastr.success("Categoría actualizada exitosamente");
        setTimeout(function () {
          location.reload();
        }, 1500);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al actualizar la categoría");
      }
    });
  });
});
