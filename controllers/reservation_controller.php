<?php
require '../db/db.php';

function isReservationAvailable($id_rest, $date, $start_time, $end_time) {
    global $conexion;

    // Consulta para verificar las reservas existentes en la misma fecha y restaurante
    $query = "SELECT * FROM reservation WHERE Id_Rest = ? AND ReservationDate = ? AND State != 3";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        return "Error en la preparación de la consulta: " . $conexion->error;
    }

    $stmt->bind_param("is", $id_rest, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        // Verifica si hay conflicto de tiempo con reservas existentes
        $existing_start_time = new DateTime($row['StartTime']);
        $existing_end_time = new DateTime($row['EndTime']);
        $new_start_time = new DateTime($start_time);
        $new_end_time = new DateTime($end_time);

        if ($new_start_time < $existing_end_time && $new_end_time > $existing_start_time) {
            return "El tiempo seleccionado no está disponible.";
        }
    }

    return true;
}

function insertReservation($id_user, $id_rest, $date, $start_time, $end_time, $people) {
    global $conexion;
    $state = 1; // Estado de En Espera para la reservación
    $id_table = 0;

    if ($people <= 2) {
        $id_table = 1;
    } elseif ($people <= 4) {
        $id_table = 2;
    } elseif ($people <= 6) {
        $id_table = 3;
    } elseif ($people <= 10) {
        $id_table = 4;
    } else {
        return "Número de personas excede las capacidades previstas.";
    }

    // Valida la disponibilidad de la reserva
    $availability = isReservationAvailable($id_rest, $date, $start_time, $end_time);
    if ($availability !== true) {
        return $availability;
    }

    // Consulta para insertar la reservación
    $query = "INSERT INTO reservation (Id_User, Id_Rest, Id_Table, ReservationDate, StartTime, EndTime, Number_People, State) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        return "Error en la preparación de la consulta: " . $conexion->error;
    }
    
    $stmt->bind_param("iiisssii", $id_user, $id_rest, $id_table, $date, $start_time, $end_time, $people, $state);

    if ($stmt->execute()) {
        return true;
    } else {
        return "Error al ejecutar la consulta: " . $stmt->error;
    }
}
?>