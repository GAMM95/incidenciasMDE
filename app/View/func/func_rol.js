$(document).ready(function () {
  $('tr').click(function () {
    var cod = $(this).find('th[data-codrol]').data('codrol'); // Corrected line
    var nom = $(this).find('th[data-rol]').data('rol');

    $('#txt_codigoRol').val(cod);
    $('#txt_nombreRol').val(nom);
    $(this).addClass('bg-blue-200 font-semibold');
    $('tr').not(this).removeClass('bg-blue-200 font-semibold');
  });


  function nuevoRegistro() {
    const form = document.getElementById('formrol');
    form.reset();
    $('#txt_codigoRol').val(''); // Asegurarse de que el campo de código de categoría también se restablezca
    $('tr').removeClass('bg-blue-200 font-semibold');
  }
  // Asignar el evento 'click' al botón 'Nuevo Registro'
  const btnNuevo = document.getElementById('nuevo-registro');
  btnNuevo.addEventListener('click', nuevoRegistro);

  //GUARDAR DATOS
  // $(document).ready(function () {
  $("#guardar-rol").on("click", function (e) {
    // Obtener los datos del formulario
    e.preventDefault();
    var formData = $("formrol").serialize(); // Obtener los datos del formulario

    $.ajax({
      url: "modulo-rol.php?action=registrar", // Reemplaza "tu_archivo_de_backend.php" con tu ruta de backend
      type: "POST",
      data: formData,
      success: function (response) {
        toastr.success("Rol guardado exitosamente");
        setTimeout(function () {
          location.reload();
        }, 1500);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al guardar el rol");
      }
    });
  });

  // Editar categoría
  $("#editar-rol").on("click", function (e) {
    e.preventDefault();
    var formData = $("#formrol").serialize();

    $.ajax({
      url: "modulo-rol.php?action=editar",
      method: "POST",
      data: formData,
      success: function (response) {
        toastr.success("Rol actualizado exitosamente");
        setTimeout(function () {
          location.reload();
        }, 1500);
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        toastr.error("Error al actualizar el rol");
      }
    });
  });
});