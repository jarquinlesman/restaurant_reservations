<?php
// reservasAdmin_route.php
session_start();
require_once '../controllers/reservasAdmin_controller.php';

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_res = isset($_POST['id_res']) ? $_POST['id_res'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';

    if (!empty($id_res) && !empty($state)) {
        $controller = new reservasAdmin_controller();
        $response = $controller->estado($id_res, $state);
    } else {
        $response['success'] = false;
        $response['Error'] = 'Datos incompletos';
    }
} else {
    $response['success'] = false;
    $response['Error'] = 'Método no permitido';
}

echo json_encode($response);
exit();
?>



