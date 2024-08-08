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
        echo "<script>alert('Por favor complete todos los campos.'); history.back();</script>";
        exit;
    }

    // Llamar al controlador para procesar la actualización
    $result = updateAdminData($idAdmin, $name, $phone, $email, $password);

    // Redirigir basado en el resultado
    if ($result) {
        echo "<script>
            alert('Administrador actualizado correctamente.');
            window.location.href = '../views/restaurant.php';
        </script>";
        exit;
    } else {
        echo "<script>alert('Hubo un problema al actualizar el administrador.'); history.back();</script>";
    }
} else {
    echo "<script>alert('Método no permitido.'); history.back();</script>";
}
?>
