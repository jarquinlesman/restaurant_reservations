<?php
require_once '../controllers/updateRestaurant_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar los datos del formulario
    $idAdmin = $_POST['Id_Admin'] ?? null;
    $name = $_POST['Name'] ?? '';
    $phone = $_POST['Phone'] ?? '';
    $email = $_POST['Email'] ?? '';
    $password = $_POST['Pass'] ?? '';

    // Validar los datos
    if (empty($name) || empty($phone) || empty($email) || empty($password) || $idAdmin === null) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Campos Incompletos',
                text: 'Por favor complete todos los campos.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                history.back();
            });
        </script>";
        exit;
    }

    // Llamar al controlador para procesar la actualización
    $result = updateAdminData($idAdmin, $name, $phone, $email, $password);

    // Redirigir basado en el resultado
    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Actualización Exitosa',
                text: 'Administrador actualizado correctamente.',
                timer: 3000,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../views/restaurant.php';
            });
        </script>";
        exit;
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al actualizar el administrador.',
                confirmButtonText: 'Intentar de nuevo'
            }).then(() => {
                history.back();
            });
        </script>";
    }
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Método No Permitido',
            text: 'Método no permitido.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            history.back();
        });
    </script>";
}
?>
