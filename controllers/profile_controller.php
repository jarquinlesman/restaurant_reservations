<?php
require '../db/db.php';

function updateClient($name, $phone, $email, $pass, $id_user) {
    global $conexion;
    
    //consulta de actualizacion
    $query = "UPDATE Users SET Name = ?, Phone = ?, Email = ?, Pass = ? WHERE Id_User = ?;";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        return false;
    }
    
    $stmt->bind_param("ssssi", $name, $phone, $email, $pass, $id_user);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>