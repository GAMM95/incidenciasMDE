$(document).ready(function () {
  // Selección de fila
  $('tr').click(function () {
    var cod = $(this).find('th[data-codcategoria]').data('codcategoria');
    var nom = $(this).find('th[data-categoria]').data('categoria');

    $('#txt_codigoCategoria').val(cod);
    $('#txt_nombreCategoria').val(nom);
    $(this).addClass('bg-blue-200 font-semibold');
    $('tr').not(this).removeClass('bg-blue-200 font-semibold');
  });

  // Reseteo de formulario
  function nuevoRegistro() {
    const form = document.getElementById('formcategoria');
    form.reset();
  }
  const btnNuevo = document.getElementById('nuevo-registro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  // Guardar categoría
  $("#guardar-categoria").on("click", function () {

    // if($('txt_nombreCategoria').val()==='')
    var formData = $("#formcategoria").serialize();

    $.ajax({
      url: "modulo-categoria.php?action=registrar",
      method: "POST",
      data: formData,
      success: function (response) {
        toastr.success("Categoría guardada exitosamente");
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al guardar la categoría");
      }
    });
  });

  // Editar categoría
  $("#editar-categoria").on("click", function () {
    var formData = $("#formcategoria").serialize();

    $.ajax({
      url: "modulo-categoria.php?action=editar",
      method: "POST",
      data: formData,
      success: function (response) {
        console.log("Response:", response);
        if (response === "success") {
          toastr.success("Categoría actualizada exitosamente");
        } else {
          toastr.error("Error al actualizar la categoría");
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al actualizar la categoría");
      }
    });
  });
});
