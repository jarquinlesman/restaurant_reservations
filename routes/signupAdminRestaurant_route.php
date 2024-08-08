<?php
require '../controllers/singupAdminRestaurant_controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['Name'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $pass = $_POST['Pass'];
    $idRest = $_POST['Id_Rest'];

    $resultado = registrarAdministrador($name, $phone, $email, $pass, $idRest);

    if ($resultado === true) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      Swal.fire({
                          title: '¿Deseas registrar un nuevo administrador?',
                          icon: 'question',
                          showCancelButton: true,
                          confirmButtonText: 'Sí',
                          cancelButtonText: 'No'
                      }).then((result) => {
                          if (result.isConfirmed) {
                              // Limpia los campos del formulario excepto la info del restaurante
                              window.history.back();
                          } else {
                              // Redirige a la página de restaurantes
                              window.location.href = '../views/restaurant.php';
                          }
                      });
                  });
              </script>";
    } else {
        // Manejar el error y mostrar un mensaje
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  alert('". addslashes($resultado) ."');
                  window.location.href = '../views/signupAdminRestaurant.php';
              </script>";
    }
}
?>