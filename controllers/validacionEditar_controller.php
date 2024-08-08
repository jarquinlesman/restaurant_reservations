<?php
require_once 'updateRestaurant_controller.php';
require_once '../routes/restaurant_route.php'; // Incluye la ruta que a su vez incluye el controlador

$restaurantData = null;
$tablesData = [];
$error = null;

// Verifica si se ha enviado un ID para cargar el restaurante
if (isset($_GET['id'])) {
    $restaurantDetails = getRestaurantDetails($_GET['id']); // Obtiene los datos del restaurante
    $restaurantData = $restaurantDetails['restaurant'];
    $tablesData = $restaurantDetails['tables'];
}

// Verifica si se obtuvo información del restaurante
if (!$restaurantData) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'No Encontrado',
                text: 'Restaurante no encontrado.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = '../views/restaurant.php';
            });
        });
    </script>";
    exit;
}

// Si se ha enviado el formulario, procesar la actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar que todos los campos requeridos estén presentes
    if (empty($_POST['name']) || empty($_POST['address']) || empty($_POST['phone']) || empty($_POST['email'])) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos Incompletos',
                    text: 'Por favor complete todos los campos.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    history.back();
                });
            });
        </script>";
        exit;
    }

    // Procesa la actualización
    $updateResult = updateRestaurantData(
        $_POST['id'],
        $_POST['name'],
        $_POST['address'],
        $_POST['phone'],
        $_POST['email'],
        [
            'tables_2' => $_POST['tables_2'],
            'tables_4' => $_POST['tables_4'],
            'tables_6' => $_POST['tables_6'],
            'tables_10' => $_POST['tables_10']
        ],
        $_FILES['image']
    );

    if ($updateResult) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualización Exitosa',
                    text: 'Restaurante actualizado correctamente.',
                    timer: 3000,
                    timerProgressBar: true
                }).then(() => {
                    window.location.href = '../views/restaurant.php'; // Cambia a la ruta que desees
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
                    title: 'Error',
                    text: 'Hubo un problema al actualizar el restaurante.',
                    confirmButtonText: 'Intentar de nuevo'
                }).then(() => {
                    history.back();
                });
            });
        </script>";
        exit;
    }
}

// Lógica de mostrar el formulario de registro
$showRegisterRestaurant = false;

if (isset($_SESSION['showRegisterRestaurant']) && $_SESSION['showRegisterRestaurant'] === true) {
    $showRegisterRestaurant = true; // Cambiar a verdadero si es el super administrador
}

return [
    'restaurantData' => $restaurantData,
    'tablesData' => $tablesData,
    'showRegisterRestaurant' => $showRegisterRestaurant,
    'error' => $error
];
?>