$(document).ready(function () {
  $('tr').click(function () {
    var cod = $(this).find('th[data-codrol]').data('codrol'); // Corrected line
    var nom = $(this).find('th[data-rol]').data('rol');


    $('#CodRol').val(cod);
    $('#NombreRol').val(nom);
    $(this).addClass('bg-blue-200 font-semibold');
    $('tr').not(this).removeClass('bg-blue-200 font-semibold');
  });


  function nuevoRegistro() {
    const form = document.getElementById('formrol');
    form.reset();
  }
  // Asignar el evento 'click' al botón 'Nuevo Registro'
  const btnNuevo = document.getElementById('nuevo-registro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  //GUARDAR DATOS
  // $(document).ready(function () {
  $("#guardar-rol").on("click", function () {
    // Obtener los datos del formulario
    var formData = $("formrol").serialize(); // Obtener los datos del formulario

    $.ajax({
      url: "modulo-rol.php?action?=registrar", // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
      type: "POST",
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
        toastr.success("Categoría actualizada exitosamente");
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al actualizar la categoría");
      }
    });
  });
});