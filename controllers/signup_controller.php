<?php
require '../db/db.php';

function insertClient($name, $phone, $email, $pass) {
    global $conexion;
    $id_role = 3;
    $state = 1;
    
    //consulta de inserción
    $query = "INSERT INTO users (Name, Phone, Email, Pass, Id_Role, State) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        return false;
    }
    
    $stmt->bind_param("ssssii", $name, $phone, $email, $pass, $id_role, $state);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
