<?php
// historialReservas_route.php
session_start();
require_once '../controllers/restauranteAdmin_controller.php';

header('Content-Type: application/json');

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (!empty($user_id)) {
    $reservaciones = obtenerReservacionesAdmin($user_id);
    echo json_encode($reservaciones);
} else {
    echo json_encode(['error' => 'User ID not found in session.']);
}
exit();
?>