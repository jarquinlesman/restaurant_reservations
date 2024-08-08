<?php
require '../controllers/signup_controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Name']) && isset($_POST['Phone']) && isset($_POST['Email']) && isset($_POST['Pass'])) {
        $name = $_POST['Name'];
        $phone = $_POST['Phone'];
        $email = $_POST['Email'];
        $pass = $_POST['Pass'];

        if (insertClient($name, $phone, $email, $pass)) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  <script>
                      document.addEventListener('DOMContentLoaded', function() {
                          Swal.fire({
                              icon: 'success',
                              title: 'Éxito',
                              text: 'Registro exitoso.',
                              confirmButtonText: 'Aceptar'
                          }).then(() => {
                              window.location.href = '../index.php';
                          });
                      });
                  </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  <script>
                      document.addEventListener('DOMContentLoaded', function() {
                          Swal.fire({
                              icon: 'error',
                              title: '¡Error!',
                              text: 'Error al registrar. Por favor, inténtelo de nuevo.',
                              confirmButtonText: 'Aceptar'
                          }).then(() => {
                              history.back();
                          });
                      });
                  </script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      Swal.fire({
                          icon: 'error',
                          title: '¡Error!',
                          text: 'Por favor complete todos los campos.',
                          confirmButtonText: 'Aceptar'
                      }).then(() => {
                          history.back();
                      });
                  });
              </script>";
    }
}
?>