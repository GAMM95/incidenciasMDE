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
    $('#txt_codigoCategoria').val(''); // Asegurarse de que el campo de código de categoría también se restablezca
    $('tr').removeClass('bg-blue-200 font-semibold'); // Eliminar cualquier selección de fila
  }

  const btnNuevo = document.getElementById('nuevo-registro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  // Guardar categoría
  $("#guardar-categoria").on("click", function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del botón
    var formData = $("#formcategoria").serialize();

    $.ajax({
      url: "modulo-categoria.php?action=registrar",
      method: "POST",
      data: formData,
      success: function (response) {
        toastr.success("Categoría guardada exitosamente");
        location.reload(); // Recargar la página para reflejar los cambios
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al guardar la categoría");
      }
    });
  });

  // Editar categoría
  // function editarCategoria() {
  //   const codigo = document.getElementById('txt_codigoCategoria').value;
  //   const nombre = document.getElementById('txt_nombreCategoria').value;
  //   if (codigo && nombre) {
  //     document.getElementById('formcategoria').action = 'modulo-categoria.php?action=editar';
  //     document.getElementById('formcategoria').submit();
  //     toastr.success("Categoría actualizada exitosamente");
  //   } else {
  //     toastr.error("Error al actualizar la categoría");
  //   }
  // }

  $("#editar-categoria").on("click", function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del botón
    var formData = $("#formcategoria").serialize();

    $.ajax({
      url: "modulo-categoria.php?action=editar",
      method: "POST",
      data: formData,
      success: function (response) {
        toastr.success("Categoría actualizada exitosamente");
        location.reload(); // Recargar la página para reflejar los cambios
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al guardar la categoría");
      }
    });
  });

});

