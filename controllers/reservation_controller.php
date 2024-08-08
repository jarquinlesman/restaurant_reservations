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
            return false; // Conflicto de horario
        }
    }

    return true; // No hay conflictos
}

function insertReservation($id_user, $id_rest, $date, $start_time, $end_time, $people) {
    global $conexion;
    $state = 1; // Estado de En Espera para la reservación

    // Identificar el tipo de mesa basado en la cantidad de personas
    $id_table_type = null;
    if ($people <= 2) {
        $id_table_type = 1;
    } elseif ($people <= 4) {
        $id_table_type = 2;
    } elseif ($people <= 6) {
        $id_table_type = 3;
    } elseif ($people <= 10) {
        $id_table_type = 4;
    } else {
        return "Número de personas excede las capacidades previstas.";
    }

    // Paso 1: Verificar si hay una reservación en la misma fecha y en el rango de tiempo dado
    $availability = isReservationAvailable($id_rest, $date, $start_time, $end_time);
    if ($availability !== true) {
        // Si hay conflicto, paso 2: Validar la disponibilidad de mesas del tipo requerido
        $query = "SELECT Number_Table FROM tables WHERE Id_Rest = ? AND Id_TableType = ?";
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $conexion->error;
        }
        $stmt->bind_param("ii", $id_rest, $id_table_type);
        $stmt->execute();
        $stmt->bind_result($available_tables);
        $stmt->fetch();
        $stmt->close();

        if ($available_tables === null) {
            return "No se encontró el tipo de mesa adecuado para la cantidad de personas.";
        }

        // Contar cuántas reservaciones existen para el tipo de mesa en la fecha y hora especificadas
        $query = "SELECT COUNT(*) as count FROM reservation 
                  WHERE Id_Rest = ? AND Id_Table IN (SELECT Id_Table FROM tables WHERE Id_TableType = ?) 
                  AND ReservationDate = ? AND StartTime < ? AND EndTime > ? AND State != 3";
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            return "Error en la preparación de la consulta: " . $conexion->error;
        }
        $stmt->bind_param("iisss", $id_rest, $id_table_type, $date, $end_time, $start_time);
        $stmt->execute();
        $stmt->bind_result($reserved_tables);
        $stmt->fetch();
        $stmt->close();

        // Validar disponibilidad de mesas
        if ($reserved_tables >= $available_tables) {
            return "No hay disponibilidad para ese tipo de mesa.";
        }
    }

    // Inserción de la reserva
    $query = "INSERT INTO reservation (Id_User, Id_Rest, Id_Table, ReservationDate, StartTime, EndTime, Number_People, State) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        return "Error en la preparación de la consulta: " . $conexion->error;
    }
    $stmt->bind_param("iiisssii", $id_user, $id_rest, $id_table_type, $date, $start_time, $end_time, $people, $state);

    if ($stmt->execute()) {
        return true;
    } else {
        return "Error al ejecutar la consulta: " . $stmt->error;
    }
}
?>