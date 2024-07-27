<?php
// Incluir el archivo de conexión
require_once '../db/db.php';

function insertRestaurantData($name, $address, $phone, $email, $tables, $image) {
    global $conexion; // Usar la conexión desde db.php

    // Preparar y ejecutar la consulta para el restaurante
    $stmt = $conexion->prepare("INSERT INTO restaurant (Name, Location, Phone, Email, state) VALUES (?, ?, ?, ?, ?)");
    $state = 1; // Valor predeterminado para el estado
    $stmt->bind_param('ssssi', $name, $address, $phone, $email, $state);
    $stmt->execute();
    $restaurantId = $stmt->insert_id; // Obtener el ID del restaurante insertado

    // Preparar y ejecutar las consultas para las mesas
    $tableTypes = ['tables_2' => 1, 'tables_4' => 2, 'tables_6' => 3, 'tables_10' => 4]; // Mapeo de tipos de mesas
    foreach ($tableTypes as $key => $typeId) {
        $quantity = isset($tables[$key]) ? (int)$tables[$key] : 0;
        $stmt = $conexion->prepare("INSERT INTO Tables (Id_Rest, Id_TableType, Number_Table, State) VALUES (?, ?, ?, ?)");

        // Insertar incluso si la cantidad es 0
        $state = 1; // Valor predeterminado para el estado
        $stmt->bind_param('iiii', $restaurantId, $typeId, $quantity, $state);
        $stmt->execute();
    }

    // Manejar la carga de la imagen
    if ($image && $image['tmp_name']) {
        $imageData = file_get_contents($image['tmp_name']);
        $stmt = $conexion->prepare("INSERT INTO images (image, Id_Rest) VALUES (?, ?)");
        
        // Bind para datos binarios
        $null = null; // Se usa null para el bind_param en el tipo de datos binarios
        $stmt->bind_param('bi', $null, $restaurantId);
        $stmt->send_long_data(0, $imageData); // Enviar datos binarios largos
        $stmt->execute();
    }

    // Cerrar la declaración
    $stmt->close();
    
    return true;
}
?>