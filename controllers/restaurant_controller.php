<?php
require '../db/db.php';

function getRestaurants() {
    global $conexion;
    $query = "SELECT r.Id_Rest, r.Name, r.Phone, r.Email, r.Location, i.Image 
              FROM restaurant r
              LEFT JOIN Images i ON r.Id_Rest = i.Id_Rest
              WHERE r.State = 1";
    $result = $conexion->query($query);

    if ($result) {
        $restaurants = [];
        while ($row = $result->fetch_assoc()) {
            $row['Image'] = base64_encode($row['Image']); // Convertir imagen a base64
            $restaurants[] = $row;
        }
        return ['restaurants' => $restaurants, 'error' => null];
    } else {
        $error = "Error en la consulta SQL: " . $conexion->error;
        error_log($error);
        return ['restaurants' => [], 'error' => $error]; // Devolver el error
    }
}
?>