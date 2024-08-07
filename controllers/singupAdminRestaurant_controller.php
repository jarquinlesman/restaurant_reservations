<?php
require '../db/db.php';

function registrarAdministrador($nombreCompleto, $telefono, $correo, $Pass, $idRest) {
    global $conexion;
    $id_role = 2; // Rol del administrador
    $state = 1; // Estado activo

    // Verificar si ya existe un usuario con el mismo correo
    $query = "SELECT * FROM users WHERE Email = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return "Ya hay un usuario registrado con este correo.";
    }

    // Si el correo no existe, proceder a registrar al administrador
    $query = "INSERT INTO users (Name, Phone, Email, Pass, Id_Role, State) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssii", $nombreCompleto, $telefono, $correo, $Pass, $id_role, $state);
    
    if ($stmt->execute()) {
        // Obtener el ID del administrador recién insertado
        $adminId = $conexion->insert_id;

        // Insertar en la tabla restaurant_admins
        $query = "INSERT INTO restaurant_admins (Id_Rest, Id_User) VALUES (?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ii", $idRest, $adminId);


        
        if ($stmt->execute()) {
            return true; // Registro exitoso
        } else {
            return "Error al asociar el administrador con el restaurante: " . $stmt->error;
        }
    } else {
        return "Error en el registro: " . $stmt->error;
    }
}

function obtenerUltimoRestaurante() {
    global $conexion;

    $query = "SELECT Id_Rest, Name FROM restaurant ORDER BY Id_Rest DESC LIMIT 1";
    $result = $conexion->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Manejar el caso en que no haya restaurantes
    }
}
?>