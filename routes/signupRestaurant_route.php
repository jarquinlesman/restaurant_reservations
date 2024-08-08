<?php
require_once '../controllers/signupRestaurant_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar los datos del formulario
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $tables = [
        'tables_2' => $_POST['tables_2'] ?? 0,
        'tables_4' => $_POST['tables_4'] ?? 0,
        'tables_6' => $_POST['tables_6'] ?? 0,
        'tables_10' => $_POST['tables_10'] ?? 0,
    ];

    $image = $_FILES['image'] ?? null;

    // Validar los datos
    if (empty($name) || empty($address) || empty($phone) || empty($email)) {
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
        exit;
    }

    // Verificar si el archivo de imagen se cargó correctamente
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        // Llamar al controlador para procesar los datos
        $result = insertRestaurantData($name, $address, $phone, $email, $tables, $image);

        // Redirigir basado en el resultado
        if ($result) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  <script>
                      document.addEventListener('DOMContentLoaded', function() {
                          Swal.fire({
                              icon: 'success',
                              title: 'Éxito',
                              text: 'Restaurante registrado correctamente. Ahora se debe de registrar un administrador para el restaurante.',
                              confirmButtonText: 'Aceptar'
                          }).then(() => {
                              window.location.href = '../views/signupAdminRestaurant.php';
                          });
                      });
                  </script>";
            exit;
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  <script>
                      document.addEventListener('DOMContentLoaded', function() {
                          Swal.fire({
                              icon: 'error',
                              title: '¡Error!',
                              text: 'Hubo un problema al registrar el restaurante.',
                              confirmButtonText: 'Aceptar'
                          }).then(() => {
                              history.back();
                          });
                      });
                  </script>";
        }
    } else {
        // Error en la carga del archivo
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      Swal.fire({
                          icon: 'error',
                          title: '¡Error!',
                          text: 'Error en la carga del archivo de imagen.',
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
                      title: 'Método no permitido',
                      text: 'Método no permitido.',
                      confirmButtonText: 'Aceptar'
                  }).then(() => {
                      history.back();
                  });
              });
          </script>";
}
?>
