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
        echo "<script>alert('Por favor complete todos los campos.'); history.back();</script>";
        exit;
    }

    // Verificar si el archivo de imagen se cargó correctamente
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        // Llamar al controlador para procesar los datos
        $result = insertRestaurantData($name, $address, $phone, $email, $tables, $image);

        // Redirigir basado en el resultado
        if ($result) {
            echo "<script>
                alert('Restaurante registrado correctamente. Ahora se debe de registrar un administrador para el restaurante.');
                window.location.href = '../views/signupAdminRestaurant.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('Hubo un problema al registrar el restaurante.'); history.back();</script>";
        }
    } else {
        // Error en la carga del archivo
        echo "<script>alert('Error en la carga del archivo de imagen.'); history.back();</script>";
    }
} else {
    echo "<script>alert('Método no permitido.'); history.back();</script>";
}
?>