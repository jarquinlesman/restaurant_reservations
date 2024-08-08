<?php
// Incluir el archivo de conexión
require_once '../db/db.php';

function getRestaurantDetails($id) {
    global $conexion;

    // Obtener datos del restaurante
    $stmt = $conexion->prepare("SELECT * FROM restaurant WHERE Id_Rest = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $restaurantResult = $stmt->get_result();
    $restaurantData = $restaurantResult->fetch_assoc();

    // Obtener la cantidad de mesas
    $tables = [];
    $stmt = $conexion->prepare("SELECT Id_TableType, Number_Table FROM tables WHERE Id_Rest = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $tablesResult = $stmt->get_result();
    
    while ($row = $tablesResult->fetch_assoc()) {
        $tables[$row['Id_TableType']] = $row['Number_Table'];
    }

    // Devolver un array con los datos del restaurante y las mesas
    return [
        'restaurant' => $restaurantData,
        'tables' => $tables
    ];
}

function updateRestaurantData($id, $name, $address, $phone, $email, $tables, $image) {
    global $conexion;

    // Actualizar la información del restaurante
    $stmt = $conexion->prepare("UPDATE restaurant SET Name = ?, Location = ?, Phone = ?, Email = ? WHERE Id_Rest = ?");
    $stmt->bind_param('ssssi', $name, $address, $phone, $email, $id);
    $stmt->execute();

    // Actualizar las mesas
    $tableTypes = ['tables_2' => 1, 'tables_4' => 2, 'tables_6' => 3, 'tables_10' => 4];
    foreach ($tableTypes as $key => $typeId) {
        $quantity = isset($tables[$key]) ? (int)$tables[$key] : 0;
        // Verificar si ya existe la mesa para actualizar
        $stmt = $conexion->prepare("UPDATE tables SET Number_Table = ? WHERE Id_Rest = ? AND Id_TableType = ?");
        $stmt->bind_param('iii', $quantity, $id, $typeId);
        $stmt->execute();
    }

    // Manejar la carga de la imagen
    if ($image && $image['tmp_name']) {
        $imageData = file_get_contents($image['tmp_name']);
        // Actualizar la imagen en la base de datos
        $stmt = $conexion->prepare("UPDATE images SET image = ? WHERE Id_Rest = ?");
        $null = null; // Se usa null para el bind_param en el tipo de datos binarios
        $stmt->bind_param('bi', $null, $id);
        $stmt->send_long_data(0, $imageData);
        $stmt->execute();
    }

    // Cerrar la declaración
    $stmt->close();

    return true;
}

function getAdminDetails($idRest) {
    global $conexion;

    $stmt = $conexion->prepare("
        SELECT ra.Id_User, u.Name, u.Phone, u.Email, u.Pass, r.Name AS RestaurantName 
        FROM restaurant_admins AS ra 
        JOIN restaurant AS r ON ra.Id_Rest = r.Id_Rest 
        JOIN users AS u ON ra.Id_User = u.Id_User 
        WHERE r.Id_Rest = ? AND u.Id_Role = 2
    ");
    $stmt->bind_param('i', $idRest);
    $stmt->execute();
    $adminResult = $stmt->get_result();

    if ($adminResult->num_rows > 0) {
        return $adminResult->fetch_assoc();
    } else {
        return null; // Manejar el caso donde no se encontró el administrador
    }
}

function updateAdminData($idAdmin, $name, $phone, $email, $password) {
    global $conexion;

    // Asegúrate de que la columna se llama 'Pass' en tu base de datos
    $stmt = $conexion->prepare("
        UPDATE users 
        SET Name = ?, Phone = ?, Email = ?, Pass = ? 
        WHERE Id_User = ?
    ");
    $stmt->bind_param('ssssi', $name, $phone, $email, $password, $idAdmin);
    return $stmt->execute();
}


?>

