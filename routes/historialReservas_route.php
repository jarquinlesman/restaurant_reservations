<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controllers/historialReservas_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $user_id = $_SESSION['user_id']; // Obtén el user_id de la sesión actual
    
    try {
        $reservaciones = obtenerReservaciones($user_id);
        echo json_encode($reservaciones);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}

?>