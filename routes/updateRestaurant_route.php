<?php
require_once '../controllers/updateRestaurant_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar los datos del formulario
    $id = $_POST['id'] ?? null; // Obtener el ID del restaurante
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
    if (empty($name) || empty($address) || empty($phone) || empty($email) || $id === null) {
        echo "<script>alert('Por favor complete todos los campos.'); history.back();</script>";
        exit;
    }

    // Llamar al controlador para procesar la actualización
    $result = updateRestaurantData($id, $name, $address, $phone, $email, $tables, $image);

    // Redirigir basado en el resultado
    if ($result) {
        echo "<script>
            alert('Restaurante actualizado correctamente.');
            window.location.href = '../views/restaurant.php'; // Cambia aquí la redirección
        </script>";
        exit;
    } else {
        echo "<script>alert('Hubo un problema al actualizar el restaurante.'); history.back();</script>";
    }
} else {
    echo "<script>alert('Método no permitido.'); history.back();</script>";
}
?>